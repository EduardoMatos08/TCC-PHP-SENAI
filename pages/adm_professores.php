<!DOCTYPE html>
<html lang="pt-br">



<head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
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






        <!-- Seleção de matérias -->
        <!-- Modal -->
        <div class="modal fade" id="materiasModal" tabindex="-1" aria-labelledby="materiasModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" style="max-width: 500px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="materiasModalLabel">Selecione as matérias</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body" style="max-height: 300px; overflow-y: auto;">
                        <ul class="list-unstyled mb-0">
                            <?php
          include "../connection.php";
          $sqlMaterias = "SELECT id_materia, nome_materia FROM materias";
          $resultMaterias = $connection->query($sqlMaterias);

          if ($resultMaterias->num_rows > 0) {
            while ($row = $resultMaterias->fetch_assoc()) {
              echo '<li>';
              echo '<div class="form-check">';
              echo '<input class="form-check-input" type="checkbox" name="materias[]" id="materia_' . $row['id_materia'] . '" value="' . $row['id_materia'] . '">';
              echo '<label class="form-check-label" for="materia_' . $row['id_materia'] . '">' . htmlspecialchars($row['nome_materia']) . '</label>';
              echo '</div>';
              echo '</li>';
            }
          } else {
            echo "<li><span class='text-muted'>Nenhuma matéria cadastrada</span></li>";
          }
          ?>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Salvar</button>
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

function openModal(name_professor, email, cpf) {
    // Cria o conteúdo do modal
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
    const infoModal = new bootstrap.Modal(document.getElementById('infoModal'));
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
            GROUP_CONCAT(m.nome_materia SEPARATOR ', ') AS materias
        FROM professores p
        LEFT JOIN professor_materia pm ON p.id_professor = pm.id_professor
        LEFT JOIN materias m ON pm.id_materia = m.id_materia
        GROUP BY p.id_professor";

$result = $connection->query($sql);

if (!$result) {
    die("Erro na query: " . $connection->error);
}

include '../components/adm_verification.php';

if ($result->num_rows > 0) {
    echo '<div class="container mt-4">';
    echo '<h2>Lista de Professores</h2>';
    echo '<table class="table table-striped table-hover table-bordered">';
    echo '<thead><tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>CPF</th>
            <th>Matérias</th>
            <th>Administrador</th>
            <th style="width: 0 !important"></th>
          </tr></thead><tbody>';
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['id_professor']}</td>";
        echo "<td>{$row['nome_professor']}</td>";
        echo "<td>{$row['email']}</td>";
        echo "<td>{$row['cpf']}</td>";
        echo "<td>{$row['materias']}</td>";
        if ($row['admin'] == 1) {
            echo "<td>Sim</td>";
        } else {
            echo "<td>Não</td>";
        };
        
        echo '<td><a href="../methods/delete_professores?id_professor=' . $row["id_professor"] . '" class="btn btn-danger" onclick="return confirm(\'Tem certeza que deseja remover este usuário?\')">Remover</a></td>';
        echo "</tr>";
    }
    echo '</tbody></table></div>';
} else {
    echo '<div class="container mt-4"><div class="alert alert-warning">Nenhum professor cadastrado.</div></div>';
}
?>