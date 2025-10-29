<?php
include "../connection.php";
// Buscar dados do professor para edição
if(isset($_GET['id_curso'])) {
    $id_curso = $_GET['id_curso'];
    
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
  <title>ADM - Matérias</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="../bootstrap-styles/bootstrap.css" />
  <script src="../bootstrap-styles/bootstrap.js"></script>
  <link rel="icon" type="image/x-icon" href="../assets/favicon.png">

  <style>
    td {
      vertical-align: middle;
    }

    #div-curso {
      display: flex;
      align-items: center;
      width: 100%;
      background-color: #e9ecef;
      justify-content: space-between;
      padding: 10px;
      border-bottom: solid #c0c0c0ff;
    }

    h3 {
      font-size: 25px;
      margin: 0;
      height: min-content;
    }

    #dropdownMenuButton1 {
      margin-left: 10px;
      background: none;
      border: none;
      padding: 10px;
    }

    #dropdownMenuButton1:after {
      color: #6c757d;
    }

    .div-curso-materias {
      transition: height 0.15s ease-in-out;
      background-color: #dee2e6;
      padding: 0;
      height: 0;
      overflow: hidden;
      margin-bottom: 20px;
    }

    #div-expansora {
      padding: 20px;
    }

    .lista-materias {
      transition: all 0.1s ease-in-out;
    }

    .mb-3 {
      width: 50%;
    }

    .d-flex {
      display: flex;
      align-items: center;
      gap: 30px;
    }

    .form-check {
      transition: all 0.3s ease-in-out;
      border-radius: 5px;
      display: flex;
      align-items: center;
      opacity: 1;
      max-height: 50px;
      margin-bottom: 5px;
    }

    .form-check.hidden {
      opacity: 0;
      max-height: 0;
      margin: 0;
      padding: 0 !important;
      overflow: hidden;
    }

    .form-check:hover {
      background-color: #adb5bd;
    }

    #action-buttons {
      display: flex;
      gap: 10px;
    }
    #td-options-buttons {
        display: grid;
        gap: 10px;
        grid-template-columns: 1fr 1fr;
    }
  </style>
</head>

<body>
  <?php include '../components/navbar.php'; ?>

  <h1 style="padding-top: 5.5rem; text-align: center;">CADASTRO DE CURSOS</h1>

  <!-- Formulário de cursos -->
  <form action="../methods/post_cursos.php" method="POST">
    <div class="container mt-4 d-flex flex-column align-items-center">
      <div style="margin-top: 30px;width: 100%;display: flex;flex-direction: column;align-items: flex-start;">
        <div class="mb-3">
          <label for="nome_curso" class="form-label">Nome do Curso</label>
          <input class="form-control" name="nome_curso" required />
        </div>
        <div class="mb-3">
          <label for="sigla_curso" class="form-label">Sigla</label>
          <input class="form-control" name="sigla_curso" required />
        </div>
      </div>
      <button type="submit" class="btn btn-primary mt-3" style="width: 30%;">Enviar</button>
    </div>
  </form>

  <?php
  // Consulta cursos
  $sql2 = "SELECT id_curso, nome_curso, sigla_curso FROM cursos";
  $result2 = $connection->query($sql2);

  if ($result2->num_rows > 0) {
    echo '<div class="container mt-4">';
    echo '<h2 class="mb-4" style="font-size: 1.75rem; font-weight: 500;">Lista de Cursos</h2>';

    while ($row2 = $result2->fetch_assoc()) {
      $idCurso = $row2["id_curso"];
      echo '
        <div id="div-curso">
          <h3>' . htmlspecialchars($row2["nome_curso"]) . ' - ' . htmlspecialchars($row2["sigla_curso"]) . '</h3>
          <div class="d-flex">
          <button onClick="openDropdown(event)" class="dropdown-toggle" type="button" id="dropdownMenuButton1"></button>
          <div id="action-buttons">
            <a href="../methods/edit_cursos_materias.php?id_curso=3" class="btn btn-primary">Editar</a>  
            <a href="../methods/delete_cursos.php?id_curso=' . $idCurso . '" class="btn btn-danger" onclick="return confirm(\'Tem certeza que deseja remover este curso?\')">Remover</a>
          </div>
          </div>
        </div>
      ';

      // Div expansível de matérias
      echo '<div class="div-curso-materias">';

      // Buscar matérias
      // Primeiro busca as matérias relacionadas ao curso
      $sqlMateriasRelacionadas = "SELECT m.id_materia, m.nome_materia, m.sigla, m.carga_horaria 
                                 FROM materias m 
                                 INNER JOIN curso_materias cm ON m.id_materia = cm.id_materia 
                                 WHERE cm.id_curso = $idCurso";
      
      // Depois busca as matérias não relacionadas
      $sqlMateriasNaoRelacionadas = "SELECT m.id_materia, m.nome_materia, m.sigla, m.carga_horaria 
                                    FROM materias m 
                                    WHERE m.id_materia NOT IN (
                                      SELECT id_materia FROM curso_materias WHERE id_curso = $idCurso
                                    )";

      $resultMateriasRelacionadas = $connection->query($sqlMateriasRelacionadas);
      $resultMateriasNaoRelacionadas = $connection->query($sqlMateriasNaoRelacionadas);

      echo '
        <div id="div-expansora" style="padding: 20px;">
          <h5 style="margin-bottom: 15px;">Adicionar matérias ao curso</h5>
          <input type="text" class="form-control mb-3" placeholder="Pesquisar matéria..." oninput="filtrarMaterias(event)" data-curso-id="' . $idCurso . '" />


          <form action="../methods/post_curso_materias.php" method="POST">
            <input type="hidden" name="id_curso" value="' . $idCurso . '">
            <div id="lista-materias-' . $idCurso . '" class="lista-materias">';

      // Exibe matérias relacionadas
      if ($resultMateriasRelacionadas->num_rows > 0) {
        while ($materia = $resultMateriasRelacionadas->fetch_assoc()) {
          echo '
              <div class="form-check justify-content-between align-items-center p-2 border-bottom">
                <label class="form-check-label" for="materia-' . $idCurso . '-' . $materia["id_materia"] . '">'
                  . htmlspecialchars($materia["nome_materia"]) . ' - ' . htmlspecialchars($materia["sigla"]) . ' ('. htmlspecialchars($materia["carga_horaria"]) .' Horas)
                </label>
                <input class="form-check-input" type="checkbox" checked
                  name="materias[]" value="' . $materia["id_materia"] . '"
                  id="materia-' . $idCurso . '-' . $materia["id_materia"] . '">
              </div>';
        }
        
        // Adiciona divisor se houver matérias não relacionadas
        if ($resultMateriasNaoRelacionadas->num_rows > 0) {
          echo '<div class="dropdown-divider my-3"></div>';
        }
      }

      // Exibe matérias não relacionadas
      if ($resultMateriasNaoRelacionadas->num_rows > 0) {
        while ($materia = $resultMateriasNaoRelacionadas->fetch_assoc()) {
          echo '
              <div class="form-check justify-content-between align-items-center p-2 border-bottom">
                <label class="form-check-label" for="materia-' . $idCurso . '-' . $materia["id_materia"] . '">'
                  . htmlspecialchars($materia["nome_materia"]) . ' - ' . htmlspecialchars($materia["sigla"]) . ' ('. htmlspecialchars($materia["carga_horaria"]) .' Horas)
                </label>
                <input class="form-check-input" type="checkbox"
                  name="materias[]" value="' . $materia["id_materia"] . '"
                  id="materia-' . $idCurso . '-' . $materia["id_materia"] . '">
              </div>';
        }
      }

      echo '
            </div>
            <button type="submit" class="btn btn-primary mt-3 w-100">Salvar Matérias</button>
          </form>
        </div>
      </div>';
    }

    echo '</div>';
  } else {
    echo '
      <div class="container mt-4">
        <h3 style="font-size: 1.75rem; font-weight: 500;">Lista de Cursos</h3>
        <div class="alert alert-warning mt-3">Nenhum resultado encontrado.</div>
      </div>';
  }
  ?>

  <h1 style="padding-top: 5.5rem; text-align: center;">CADASTRO DE MATÉRIAS</h1>

  <!-- Formulário de matérias -->
  <form action="../methods/post_materias.php" method="POST">
    <div class="container mt-4 d-flex flex-column align-items-center">
      <div style="margin-top: 30px;width: 100%;display: flex;flex-direction: column;align-items: flex-start;">
        <div class="mb-3">
          <label class="form-label">Nome da Matéria</label>
          <input class="form-control" name="nome_materia" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Sigla</label>
          <input class="form-control" name="sigla" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Carga Horária</label>
          <input name="carga_horaria" type="number" class="form-control" required />
        </div>
      </div>
      <button type="submit" class="btn btn-primary mt-3" style="width: 30%;">Enviar</button>
    </div>
  </form>

  <script>
    // Abre e fecha dropdown
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

    // Filtro de matérias
    // Remove acentos e coloca em minúsculas
    function normalizeString(str) {
      return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
    }

    // Evento oninput -> filtra a lista de matérias correspondente ao curso
    function filtrarMaterias(event) {
      const input = event.target;
      const idCurso = input.dataset.cursoId;
      const filtro = normalizeString(input.value.trim());
      const divLista = document.getElementById(`lista-materias-${idCurso}`);
      const container = input.closest('.div-curso-materias');
      const content = container.querySelector('#div-expansora');
      
      if (!divLista) return;

      const materias = divLista.querySelectorAll('.form-check');
      let anyVisible = false;

      materias.forEach(item => {
        const label = item.querySelector('.form-check-label');
        if (!label) return;
        
        const texto = normalizeString(label.textContent);
        const matches = texto.includes(filtro);
        
        item.style.display = matches ? 'flex' : 'none';
        if (matches) anyVisible = true;
      });

      // Remove mensagem antiga se existir
      const oldMessage = divLista.querySelector('.no-results-msg');
      if (oldMessage) oldMessage.remove();

      // Adiciona mensagem de "nenhum resultado" se necessário
      if (!anyVisible) {
        const message = document.createElement('div');
        message.className = 'no-results-msg alert alert-warning mt-2';
        message.textContent = 'Nenhuma matéria encontrada.';
        divLista.appendChild(message);
      }

      // Recalcula e atualiza a altura do dropdown após a animação
      setTimeout(() => {
        container.style.height = content.offsetHeight + 'px';
      }, 300);
    }

  </script>
</body>

</html>

<?php
include "../connection.php";
include '../components/adm_verification.php';

// Lista de matérias
$sql = "SELECT id_materia, nome_materia, sigla, carga_horaria FROM materias";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
  echo '
    <div class="container mt-4">
      <h2 class="mb-4" style="font-size: 1.75rem; font-weight: 500;">Lista de Matérias</h2>
      <table class="table table-striped table-hover table-bordered">
        <thead class="table-light">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Nome</th>
            <th scope="col">Sigla</th>
            <th scope="col">Carga Horária</th>
            <th style="width: 1%;"></th>
          </tr>
        </thead>
        <tbody>
  ';

  while ($row = $result->fetch_assoc()) {
    echo '
      <tr>
        <td>' . $row["id_materia"] . '</td>
        <td>' . htmlspecialchars($row["nome_materia"]) . '</td>
        <td>' . htmlspecialchars($row["sigla"]) . '</td>
        <td>' . htmlspecialchars($row["carga_horaria"]) . ' Horas</td>
        <td id="td-options-buttons">
          <a href="../methods/put_materias.php?id_materia=' . $row["id_materia"] . '" class="user-button btn btn-primary">Editar</a>
          <a href="../methods/delete_materias.php?id_materia=' . $row["id_materia"] . '" class="user-button btn btn-danger" onclick="return confirm(\'Tem certeza que deseja remover este usuário?\')">Remover</a>
        </td>
      </tr>
    ';
  }

  echo '
        </tbody>
      </table>
    </div>';
} else {
  echo '
    <div class="container mt-4">
      <h3 style="font-size: 1.75rem; font-weight: 500;">Lista de Matérias</h3>
      <div class="alert alert-warning mt-3">Nenhum resultado encontrado.</div>
    </div>';
}
?>