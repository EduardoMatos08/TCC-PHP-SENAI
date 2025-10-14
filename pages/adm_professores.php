<!DOCTYPE html>
<html lang="pt-br">



<head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ADM - Professores</title>
    <!-- Importação dos Scripts e Estilos - Status: Funcionando -->
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
    .modal {
  display: none; /* Escondido por padrão */
  position: fixed; /* Fica por cima de tudo */
  z-index: 1; /* Fica no topo */
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.7); /* Fundo escuro semitransparente */
}

.modal-conteudo {
  background-color: #fefefe;
  margin: 15% auto; /* Centraliza verticalmente e horizontalmente */
  padding: 20px;
  border: 1px solid #888;
  width: 80%; /* Largura do modal */
  position: relative;
  text-align: center;
}

.fechar {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}

.fechar:hover,
.fechar:focus {
  color: black;
  text-decoration: none;
}

</style>

<body>
    <!-- Corpo do Site -->
    
    <?php include '../components/navbar.php'; ?>
    
    <!-- Formulário de Cadastro -->
    <form action="../methods/post_professores.php" method="POST">
        <div class="container mt-4">

            <h1 style="margin-bottom: 20px; text-align: center;">CADASTRO DE PROFESSORES</h1>

            <div class="mb-3">
                <label id="nome" for="exampleInputEmail1" class="label-adictional-style form-label">Nome</label>
                <input class="form-control" name="nome_professor" aria-describedby="emailHelp" />
                <p id="caractere-especial">Não utilize caracteres especiais.</p>
            </div>

            <div class="mb-3">
                <label id="cpf" for="exampleInputPassword1" class="label-adictional-style form-label">CPF</label>
                <input name="cpf" id="cpf" type="text" class="form-control" maxlength="11" oninput="mascara(this)" />
            </div>

            <div class="mb-3">
                <label id="email" for="exampleInputPassword1" class="label-adictional-style form-label">E-mail</label>
                <input name="email" type="email" class="form-control" />
            </div>

            <div class="mb-3">
                <label id="senha" for="exampleInputPassword1" class="label-adictional-style form-label">Senha</label>
                <div class="input-group">
                    <input style="position: static !important;" name="senha" type="password" class="form-control"
                        id="senhaInput" />
                    <button type="button" class="btn btn-outline-secondary" id="toggleSenha" tabindex="-1">
                        Mostrar
                    </button>
                </div>
            </div>

            <div id="adm-div" class="mb-3">
                <label id="admin" for="exampleInputPassword1" class="label-adictional-style form-label">Administrador: </label>
                <input onclick="toggleValue()" class="form-check-input" type="checkbox" name="admin" id="adminSim" value="0"></input>
            </div>
            <!-- Botão que abre o modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#materiasModal">
                Selecionar matérias
            </button>
        </div>


        <div id="meuModal" class="modal">
  <div class="modal-conteudo">
    <span class="fechar" onclick="fecharModal()">&times;</span>
    <img id="imagemNoModal" src="caminho/para/sua-imagem.png" alt="Descrição da imagem">
  </div>
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
                echo '
                    <div class="form-check d-flex justify-content-between align-items-center p-2 border-bottom">
                        <label class="form-check-label">
                            ' . htmlspecialchars($materia["nome_materia"]) . ' - ' . htmlspecialchars($materia["sigla"]) . 
                            ' (' . htmlspecialchars($materia["carga_horaria"]) . ' Horas)
                        </label>
                        <div class="form-check-group">
                            <div class="form-check">
                                <label class="form-check-label">N1</label>
                                <input type="radio" name="competencia[' . $curso["id_curso"] . '][' . $materia["id_materia"] . ']" value="n1" class="form-check-input">
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">N2</label>
                                <input type="radio" name="competencia[' . $curso["id_curso"] . '][' . $materia["id_materia"] . ']" value="n2" class="form-check-input">
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">N3</label>
                                <input type="radio" name="competencia[' . $curso["id_curso"] . '][' . $materia["id_materia"] . ']" value="n3" class="form-check-input">
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
                        <input name="horarios" id="horariosSelecionados" type="hidden">

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
                                <!-- Dias úteis: Segunda a Sexta -->
                                <!-- Período: Manhã -->
                                <tr>
                                    <td style="text-align: center;" class="td-center"><strong>Manhã</strong></td>
                                    <td id="segunda-manha" class="td-content" class="td-center"><input type="button"
                                            class="btn toggle-btn btn-danger" data-day="segunda" data-period="manha"
                                            aria-pressed="false"></input></td>
                                    <td id="terca-manha" class="td-content" class="td-center"><input type="button"
                                            class="btn toggle-btn btn-danger" data-day="terca" data-period="manha"
                                            aria-pressed="false"></input></td>
                                    <td id="quarta-manha" class="td-content" class="td-center"><input type="button"
                                            class="btn toggle-btn btn-danger" data-day="quarta" data-period="manha"
                                            aria-pressed="false"></input></td>
                                    <td id="quinta-manha" class="td-content" class="td-center"><input type="button"
                                            class="btn toggle-btn btn-danger" data-day="quinta" data-period="manha"
                                            aria-pressed="false"></input></td>
                                    <td id="sexta-manha" class="td-content" class="td-center"><input type="button"
                                            class="btn toggle-btn btn-danger" data-day="sexta" data-period="manha"
                                            aria-pressed="false"></input></td>
                                    <td id="sabado-manha" class="td-content" class="td-center"><input type="button"
                                            class="btn toggle-btn btn-danger" data-day="sabado" data-period="manha"
                                            aria-pressed="false"></input></td>
                                </tr>

                                <!-- Período: Tarde -->
                                <tr>
                                    <td style="text-align: center;" class="td-center"><strong>Tarde</strong></td>
                                    <td id="segunda-tarde" class="td-content" class="td-center"><input type="button"
                                            class="btn toggle-btn btn-danger" data-day="segunda" data-period="tarde"
                                            aria-pressed="false"></input></td>
                                    <td id="terca-tarde" class="td-content" class="td-center"><input type="button"
                                            class="btn toggle-btn btn-danger" data-day="terca" data-period="tarde"
                                            aria-pressed="false"></input></td>
                                    <td id="quarta-tarde" class="td-content" class="td-center"><input type="button"
                                            class="btn toggle-btn btn-danger" data-day="quarta" data-period="tarde"
                                            aria-pressed="false"></input></td>
                                    <td id="quinta-tarde" class="td-content" class="td-center"><input type="button"
                                            class="btn toggle-btn btn-danger" data-day="quinta" data-period="tarde"
                                            aria-pressed="false"></input></td>
                                    <td id="sexta-tarde" class="td-content" class="td-center"><input type="button"
                                            class="btn toggle-btn btn-danger" data-day="sexta" data-period="tarde"
                                            aria-pressed="false"></input></td>
                                    <td id="sabado-tarde" class="td-content" class="td-center"><input type="button"
                                            class="btn toggle-btn btn-danger" data-day="sabado" data-period="tarde"
                                            aria-pressed="false"></input></td>
                                </tr>

                                <!-- Período: Noite -->
                                <tr>
                                    <td style="text-align: center;" class="td-center"><strong>Noite</strong></td>
                                    <td id="segunda-noite" class="td-content" class="td-center"><input type="button"
                                            class="btn toggle-btn btn-danger" data-day="segunda" data-period="noite"
                                            aria-pressed="false"></input></td>
                                    <td id="terca-noite" class="td-content" class="td-center"><input type="button"
                                            class="btn toggle-btn btn-danger" data-day="terca" data-period="noite"
                                            aria-pressed="false"></input></td>
                                    <td id="quarta-noite" class="td-content" class="td-center"><input type="button"
                                            class="btn toggle-btn btn-danger" data-day="quarta" data-period="noite"
                                            aria-pressed="false"></input></td>
                                    <td id="quinta-noite" class="td-content" class="td-center"><input type="button"
                                            class="btn toggle-btn btn-danger" data-day="quinta" data-period="noite"
                                            aria-pressed="false"></input></td>
                                    <td id="sexta-noite" class="td-content" class="td-center"><input type="button"
                                            class="btn toggle-btn btn-danger" data-day="sexta" data-period="noite"
                                            aria-pressed="false"></input></td>
                                    <td id="sabado-noite" class="td-content" class="td-center"><input type="button"
                                            class="btn toggle-btn btn-danger" data-day="sabado" data-period="noite"
                                            aria-pressed="false"></input></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <small class="text-muted">Clique em cada botão para alternar entre vermelho (horário indisponível) e
                        verde
                        (horário disponível).</small>

                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top: 30px; width: 30%;">Enviar</button>

    </form>

</body>

<script>

function mostrarModal() {
  const modal = document.getElementById("meuModal");
  modal.style.display = "block";
}

function fecharModal() {
  const modal = document.getElementById("meuModal");
  modal.style.display = "none";
}

// Fechar o modal clicando fora dele
window.onclick = function(event) {
  const modal = document.getElementById("meuModal");
  if (event.target == modal) {
    modal.style.display = "none";
  }
}


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
    
    console.log(checkboxAdmin);
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

    if (isNaN(v[v.length - 1])) { // impede entrar outro caractere que não seja número
        i.value = v.substring(0, v.length - 1);
        return;
    }

    i.setAttribute("maxlength", "14");
    if (v.length == 3 || v.length == 7) i.value += ".";
    if (v.length == 11) i.value += "-";

}

function openModal(name_professor, email, cpf, materias_competencias) {
    // Formata as competências em uma lista
    let competenciasHtml = '';
    if (materias_competencias && materias_competencias !== 'null') {
        const items = materias_competencias.split(',');
        const cursos = {};
        
        // Agrupa por curso
        items.forEach(item => {
            const [curso, resto] = item.split('###');
            if (!curso || !resto) return;
            
            if (!cursos[curso]) {
                cursos[curso] = [];
            }
            cursos[curso].push(resto);
        });

        // Gera o HTML
        const competenciaColors = {
            'N1': '#dc3545',  // Vermelho (Bootstrap danger)
            'N2': '#ffc107',  // Amarelo (Bootstrap warning)
            'N3': '#198754'   // Verde (Bootstrap success)
        };

        competenciasHtml = '<ul style="list-style-type: none; padding-left: 0;">';
        for (const [curso, materias] of Object.entries(cursos)) {
            competenciasHtml += `<li><strong>Curso: ${curso}</strong><ul style="list-style-type: none;">`;
            materias.forEach(materia => {
                // Extrai o tipo de nota (N1, N2 ou N3) do final da string
                const competencia = materia.split(':').pop().trim();
                const materiaInfo = materia.split(':')[0];
                competenciasHtml += `<li>• ${materiaInfo}: <strong style="color: ${competenciaColors[competencia]}">${competencia}</strong></li>`;
            });
            competenciasHtml += '</ul></li>';
        }
        competenciasHtml += '</ul>';
    } else {
        competenciasHtml = 'Nenhuma competência atribuída';
    }

    const modalContent = `
      <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div style="display: flex; justify-content: center;" class="modal-dialog">
          <div style="align-self: center; width: 70vw; padding: 2%;" class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="infoModalLabel">Informações do Professor</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p><strong>Nome:</strong> ${name_professor}</p>
              <p><strong>Email:</strong> ${email}</p>
              <p><strong>CPF:</strong> ${cpf}</p>
              <p style="text-align: center;"><strong>COMPETÊNCIAS</strong></p>
              ${competenciasHtml}
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div>
    `;

    // Adiciona o modal ao corpo do documento
    document.body.insertAdjacentHTML('beforeend', modalContent);

    // Inicializa e mostra o modal usando Bootstrap
    const infoModal = new bootstrap.Modal(document.getElementById('infoModal'), { backdrop: 'static', keyboard: false });
    infoModal.show();

    // Remove o modal do DOM quando for fechado
    document.getElementById('infoModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('infoModal').remove();
    });

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

// Adicione esta função para controlar o dropdown
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

<?php
include "../connection.php";

$sql = "SELECT 
            p.id_professor, 
            p.nome_professor, 
            p.email,
            p.admin,
            p.cpf,
            COALESCE(GROUP_CONCAT(
                DISTINCT CONCAT(
                    c.nome_curso, '###',
                    m.nome_materia, ' - ',
                    m.sigla, ': ',
                    UPPER(pcm.tipo_nota)
                ) ORDER BY c.nome_curso
            ), '') as materias_competencias
        FROM professores p
        LEFT JOIN professor_curso_materia pcm ON p.id_professor = pcm.id_professor
        LEFT JOIN materias m ON pcm.id_materia = m.id_materia
        LEFT JOIN cursos c ON pcm.id_curso = c.id_curso
        GROUP BY p.id_professor, p.nome_professor, p.email, p.admin, p.cpf";

$result = $connection->query($sql);

if (!$result) {
    die("Erro na query: " . $connection->error);
}

include '../components/adm_verification.php';

function mascararCPF($cpf) {
    // Remove caracteres não numéricos
    $cpf = preg_replace('/\D/', '', $cpf);

    // Se o CPF for válido (11 dígitos), mascara os primeiros 9
    if (strlen($cpf) === 11) {
        return "***.***.***-" . substr($cpf, -2);
    } else {
        return "CPF inválido";
    }
}

if ($result->num_rows > 0) {
    echo '<div class="container mt-4">';
    echo '<h2>Lista de Professores</h2>';
    echo '<table class="table table-striped table-hover table-bordered">';
    echo '<thead><tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>CPF</th>
            <th>Administrador</th>
            <th style="width: 0 !important"></th>
          </tr></thead><tbody>';
    while ($row = $result->fetch_assoc()) {
        // Aplica a máscara de CPF
        $cpf_mascarado = mascararCPF($row['cpf']);

        echo "<tr>";
        echo "<td>{$row['id_professor']}</td>";
        echo "<td><a onclick='openModal(\"{$row['nome_professor']}\", \"{$row['email']}\", \"{$cpf_mascarado}\", \"{$row['materias_competencias']}\")' class='btn btn-link'>{$row['nome_professor']}</a></td>";
        echo "<td>{$row['email']}</td>";
        echo "<td>{$cpf_mascarado}</td>";
        // echo "<td>{$row['materias_competencias']}</td>"; // Removida coluna de matérias
        if ($row['admin'] == 1) {
            echo "<td>Sim</td>";
        } else {
            echo "<td>Não</td>";
        }
        
        echo '<td><a href="../methods/delete_professores.php?id_professor=' . $row["id_professor"] . '" class="btn btn-danger" onclick="return confirm(\'Tem certeza que deseja remover este usuário?\')">Remover</a></td>';
        echo "</tr>";
    }
    echo '</tbody></table></div>';
} else {
    echo '<div class="container mt-4"><div class="alert alert-warning">Nenhum professor cadastrado.</div></div>';
}
?>
