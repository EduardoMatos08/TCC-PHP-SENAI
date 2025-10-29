<?php
include '../connection.php';

// Buscar dados do professor para edição
if(isset($_GET['id_professor'])) {
    $id_professor = $_GET['id_professor'];
    
    $sql = "SELECT * FROM professores WHERE id_professor = $id_professor";
    $result = $connection->query($sql);
    
    if($result->num_rows > 0) {
        $professor = $result->fetch_assoc();
    } else {
        die("Professor não encontrado!");
    }
    
    // Buscar matérias e competências atuais do professor
    $sql_competencias = "SELECT pcm.*, m.nome_materia, m.sigla, c.nome_curso 
                         FROM professor_curso_materia pcm
                         INNER JOIN materias m ON pcm.id_materia = m.id_materia
                         INNER JOIN cursos c ON pcm.id_curso = c.id_curso
                         WHERE pcm.id_professor = $id_professor";
    $result_competencias = $connection->query($sql_competencias);
    
    $competencias_selecionadas = array();
    while($row = $result_competencias->fetch_assoc()) {
        $competencias_selecionadas[$row['id_curso']][$row['id_materia']] = $row['tipo_nota'];
    }
    
} else {
    die("ID do professor não especificado!");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EDITAR - Professor</title>
    <link rel="stylesheet" href="../bootstrap-styles/bootstrap.css" />
    <script src="../bootstrap-styles/bootstrap.js"></script>
    <link rel="icon" type="image/x-icon" href="../assets/favicon.png">
</head>

<style>
.mt-4 {
    margin-top: 5.5rem !important;
}

.mb-3 {
    width: 50%;
}

form {
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    padding: 0 20px;
}

.btn-danger {
    align-self: center;
    height: max-content;
    width: 125px;
}

.btn-success {
    width: 125px !important;
}

.td-content {
    text-align: center;
}

.td-table-teacher {
    vertical-align: middle !important;
}

.card {
    position: static !important;
}

#adm-div {
    display: flex;
    align-items: center;
    gap: 10px;
}

#adm-div .form-label {
    margin: 0;
}

.form-check-input {
    margin: 0;
    margin-right: 5px;
}

.form-check {
    display: flex;
    min-height: 1.5rem;
    padding-left: 1.5em;
    margin-bottom: 0.125rem;
    flex-direction: row;
    align-items: center;
}

.d-flex {
    display: flex !important;
    align-items: center;
    gap: 30px;
}

.div-curso-materias {
    transition: height 0.15s ease-in-out;
    background-color: #dee2e6;
    padding: 0;
    height: 0;
    overflow: hidden;
    margin-bottom: 20px;
}

.lista-materias {
    transition: all 0.1s ease-in-out;
    max-height: 200px;
    overflow-y: auto;
}

.form-check-group {
    display: flex;
    gap: 15px;
    align-items: center;
}

#div-curso {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    margin-bottom: 5px;
}

.dropdown-toggle {
    background: none;
    border: none;
    padding: 10px;
    color: #6c757d;
}

.dropdown-toggle::after {
    display: inline-block;
    margin-left: 0.255em;
    vertical-align: 0.255em;
    content: "";
    border-top: 0.3em solid;
    border-right: 0.3em solid transparent;
    border-bottom: 0;
    border-left: 0.3em solid transparent;
}

.form-check-group {
    width: 30%;
}

.form-check {
    width: 100%;
    justify-content: space-between;
    padding: 0 8.5px;
}

.alert-secondary{
    margin: 0;
}

#caractere-especial {
    font-weight: bold;
}

.user-button {
    width: auto;
}

#td-options-buttons {
    display: grid;
    gap: 10px;
    grid-template-columns: 1fr 1fr;
}

</style>

<body>
    <?php include '../components/navbar.php'; ?>
    
    <!-- Formulário de Edição -->
    <form action="../methods/update_professor.php" method="POST">
        <div class="container mt-4">
            <h1 style="margin-bottom: 20px; text-align: center;">EDITAR PROFESSOR</h1>

            <input type="hidden" name="id_professor" value="<?php echo $professor['id_professor']; ?>">

            <div class="mb-3">
                <label id="nome" for="exampleInputEmail1" class="label-adictional-style form-label">Nome</label>
                <input class="form-control" name="nome_professor" value="<?php echo $professor['nome_professor']; ?>" aria-describedby="emailHelp" />
                <p id="caractere-especial">Não utilize caracteres especiais.</p>
            </div>

            <div class="mb-3">
                <label id="cpf" for="exampleInputPassword1" class="label-adictional-style form-label">CPF</label>
                <input name="cpf" id="cpf" type="text" class="form-control" value="<?php echo $professor['cpf']; ?>" maxlength="14" oninput="mascara(this)" />
            </div>

            <div class="mb-3">
                <label id="email" for="exampleInputPassword1" class="label-adictional-style form-label">E-mail</label>
                <input name="email" type="email" class="form-control" value="<?php echo $professor['email']; ?>" />
            </div>

            <div class="mb-3">
                <label id="senha" for="exampleInputPassword1" class="label-adictional-style form-label">Senha</label>
                <div class="input-group">
                    <input style="position: static !important;" name="senha" type="password" class="form-control"
                        id="senhaInput" placeholder="Deixe em branco para manter a atual" />
                    <button type="button" class="btn btn-outline-secondary" id="toggleSenha" tabindex="-1">
                        Mostrar
                    </button>
                </div>
            </div>

            <div id="adm-div" class="mb-3">
                <label id="admin" for="exampleInputPassword1" class="label-adictional-style form-label">Administrador: </label>
                <input onclick="toggleValue()" class="form-check-input" type="checkbox" name="admin" id="adminSim" value="<?php echo $professor['admin']; ?>" <?php echo $professor['admin'] == 1 ? 'checked' : ''; ?>></input>
            </div>

            <!-- Botão que abre o modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#materiasModal">
                Selecionar matérias
            </button>
        </div>

        <!-- Seleção de matérias -->
        <!-- Modal -->
        <div class="modal fade" id="materiasModal" tabindex="-1" aria-labelledby="materiasModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="materiasModalLabel">Selecionar Cursos e Matérias</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                    <?php
$sqlCursos = "SELECT id_curso, nome_curso, sigla_curso FROM cursos";
$resultCursos = $connection->query($sqlCursos);

if ($resultCursos->num_rows > 0) {
    while ($curso = $resultCursos->fetch_assoc()) {
        echo '
        <div id="div-curso">
            <h3>' . htmlspecialchars($curso["nome_curso"]) . ' - ' . htmlspecialchars($curso["sigla_curso"]) . '</h3>
            <button onClick="openDropdown(event)" class="dropdown-toggle" type="button"></button>
        </div>
        <div class="div-curso-materias">
            <div id="div-expansora" style="padding: 20px;">
                <div class="lista-materias">';

        // Buscar apenas matérias relacionadas ao curso atual
        $sqlMaterias = "
            SELECT m.id_materia, m.nome_materia, m.sigla, m.carga_horaria
            FROM materias m
            INNER JOIN curso_materias cm ON m.id_materia = cm.id_materia
            WHERE cm.id_curso = " . (int)$curso['id_curso'];

        $resultMaterias = $connection->query($sqlMaterias);

        if ($resultMaterias && $resultMaterias->num_rows > 0) {
            while ($materia = $resultMaterias->fetch_assoc()) {
                $competencia_atual = isset($competencias_selecionadas[$curso['id_curso']][$materia['id_materia']]) ? $competencias_selecionadas[$curso['id_curso']][$materia['id_materia']] : '';
                
                echo '
                    <div class="form-check d-flex justify-content-between align-items-center p-2 border-bottom">
                        <label class="form-check-label">
                            ' . htmlspecialchars($materia["nome_materia"]) . ' - ' . htmlspecialchars($materia["sigla"]) . 
                            ' (' . htmlspecialchars($materia["carga_horaria"]) . ' Horas)
                        </label>
                        <div class="form-check-group">
                            <div class="form-check">
                                <label class="form-check-label">N1</label>
                                <input type="radio" name="competencia[' . $curso["id_curso"] . '][' . $materia["id_materia"] . ']" value="n1" class="form-check-input" ' . ($competencia_atual == 'n1' ? 'checked' : '') . '>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">N2</label>
                                <input type="radio" name="competencia[' . $curso["id_curso"] . '][' . $materia["id_materia"] . ']" value="n2" class="form-check-input" ' . ($competencia_atual == 'n2' ? 'checked' : '') . '>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">N3</label>
                                <input type="radio" name="competencia[' . $curso["id_curso"] . '][' . $materia["id_materia"] . ']" value="n3" class="form-check-input" ' . ($competencia_atual == 'n3' ? 'checked' : '') . '>
                            </div>
                        </div>
                    </div>';
            }
        } else {
            echo '<div class="alert alert-secondary">Nenhuma matéria vinculada a este curso.</div>';
        }

        echo '
                </div>
            </div>
        </div>';
    }
} else {
    echo '<div class="alert alert-warning">Nenhum curso cadastrado.</div>';
}
?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Selecionar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabela de Horários -->
        <div class="container">
            <div style="margin-top: 30px;" class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="m-0" style="font-size: 1.75rem; font-weight: 500;">Horários Disponíveis</h3>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <input name="horarios" id="horariosSelecionados" type="hidden" value="<?php echo $professor['horarios']; ?>">

                        <table class="table table-bordered table-fixed align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Período</th>
                                    <th class="text-center">Segunda</th>
                                    <th class="text-center">Terça</th>
                                    <th class="text-center">Quarta</th>
                                    <th class="text-center">Quinta</th>
                                    <th class="text-center">Sexta</th>
                                    <th class="text-center">Sábado</th>
                                </tr>
                            </thead>
                            <tbody name="horarios">
                                <?php
                                // Decodificar horários atuais
                                $horarios_atuais = explode(',', $professor['horarios']);
                                $dias = ['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado'];
                                $periodos = ['manha', 'tarde', 'noite'];
                                
                                foreach($periodos as $periodo): ?>
                                <tr>
                                    <td style="text-align: center;" class="td-center"><strong><?php echo ucfirst($periodo); ?></strong></td>
                                    <?php foreach($dias as $dia): 
                                        $horario_id = $dia . '-' . $periodo;
                                        $esta_selecionado = in_array($horario_id, $horarios_atuais);
                                        $classe_btn = $esta_selecionado ? 'btn-success' : 'btn-danger';
                                    ?>
                                    <td id="<?php echo $horario_id; ?>" class="td-content">
                                        <input type="button" class="btn toggle-btn <?php echo $classe_btn; ?>" 
                                               data-day="<?php echo $dia; ?>" data-period="<?php echo $periodo; ?>"
                                               aria-pressed="<?php echo $esta_selecionado ? 'true' : 'false'; ?>">
                                    </td>
                                    <?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <small class="text-muted">Clique em cada botão para alternar entre vermelho (horário indisponível) e verde (horário disponível).</small>
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary" style="margin-top: 30px; width: 30%;">Atualizar Professor</button>
        <a href="../pages/professores.php" class="btn btn-secondary" style="margin-top: 10px; width: 30%;">Cancelar</a>
    </form>

</body>

<script>
// Seleciona todos os botões toggle
const toggles = document.querySelectorAll(".toggle-btn");
const hiddenInput = document.getElementById("horariosSelecionados");

// Adiciona evento de clique para alternar classes
toggles.forEach(btn => {
    btn.addEventListener("click", () => {
        const isActive = btn.classList.contains("btn-success");

        if (isActive) {
            btn.classList.remove("btn-success");
            btn.classList.add("btn-danger");
            btn.setAttribute("aria-pressed", "false");
        } else {
            btn.classList.remove("btn-danger");
            btn.classList.add("btn-success");
            btn.setAttribute("aria-pressed", "true");
        }
    });
});

function toggleValue() {
    checkboxAdmin = document.getElementById("adminSim");
    if (checkboxAdmin.value == "0") {
        checkboxAdmin.value = "1";
    } else {
        checkboxAdmin.value = "0";
    }
}

// Antes de enviar o formulário, coleta os horários ativos
document.querySelector("form").addEventListener("submit", (e) => {
    const selecionados = [];

    toggles.forEach(btn => {
        // Verifica se o botão está ativo (verde)
        if (btn.classList.contains("btn-success")) {
            const dia = btn.getAttribute("data-day");
            const periodo = btn.getAttribute("data-period");
            selecionados.push(`${dia}-${periodo}`);
        }
    });
    
    // Define o valor do input hidden com os horários selecionados
    hiddenInput.value = selecionados.join(",");
});

// Verifica do cpf é válido
function mascara(i) {
    var v = i.value;

    if (isNaN(v[v.length - 1])) {
        i.value = v.substring(0, v.length - 1);
        return;
    }

    i.setAttribute("maxlength", "14");
    if (v.length == 3 || v.length == 7) i.value += ".";
    if (v.length == 11) i.value += "-";
}

// Botão de mostrar/ocultar senha
document.addEventListener('DOMContentLoaded', function() {
    const senhaInput = document.getElementById('senhaInput');
    const toggleSenha = document.getElementById('toggleSenha');
    toggleSenha.addEventListener('click', function() {
        if (senhaInput.type === 'password') {
            senhaInput.type = 'text';
            toggleSenha.textContent = 'Ocultar';
        } else {
            senhaInput.type = 'password';
            toggleSenha.textContent = 'Mostrar';
        }
    });
});

// Função para controlar o dropdown
function openDropdown(event) {
    const button = event.currentTarget;
    const container = button.closest('#div-curso').nextElementSibling;
    const content = container.querySelector('#div-expansora');
    
    if (container.style.height === '0px' || container.style.height === '') {
        container.style.height = content.offsetHeight + 'px';
    } else {
        container.style.height = '0px';
    }
}
</script>

</html>