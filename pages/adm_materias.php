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
      border-radius: 10px;
      margin-bottom: 5px;
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
      transition: all 0.2s ease-in;
      background-color: #dee2e6;
      padding: 0;
      height: 0;
      overflow: hidden;
      border-radius: 10px;
      margin-bottom: 20px;
    }

    .mb-3 {
      width: 50%;
    }

    .d-flex {
      display: flex !important;
      align-items: center;
      gap: 30px;
    }

    .form-check {
      transition: all 0.1s ease-in;
      border-radius: 5px;
    }

    .form-check:hover {
      background-color: #adb5bd;
    }
  </style>
</head>

<body>
  <?php include '../components/navbar.php'; ?>
  <?php include "../connection.php"; ?>

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
            <a href="../methods/delete_cursos.php?id_curso=' . $idCurso . '" class="btn btn-danger" onclick="return confirm(\'Tem certeza que deseja remover este curso?\')">Remover</a>
            <button onClick="openDropdown(event)" class="dropdown-toggle" type="button" id="dropdownMenuButton1"></button>
          </div>
        </div>
      ';

      // Div expansível de matérias
      echo '<div class="div-curso-materias">';

      // Buscar matérias
      $sqlMaterias = "SELECT id_materia, nome_materia, sigla FROM materias";
      $resultMaterias = $connection->query($sqlMaterias);

      echo '
        <div style="padding: 20px;">
          <h5 style="margin-bottom: 15px;">Adicionar matérias ao curso</h5>
          <input type="text" class="form-control mb-3" placeholder="Pesquisar matéria..." oninput="filtrarMaterias(event)" data-curso-id="' . $idCurso . '" />


          <form action="../methods/post_curso_materias.php" method="POST">
            <input type="hidden" name="id_curso" value="' . $idCurso . '">
            <div id="lista-materias-' . $idCurso . '" style="max-height: 200px; overflow-y: auto;">';

      if ($resultMaterias->num_rows > 0) {
        while ($materia = $resultMaterias->fetch_assoc()) {
          echo '
              <div class="form-check d-flex justify-content-between align-items-center p-2 border-bottom">
                <label class="form-check-label" for="materia-' . $idCurso . '-' . $materia["id_materia"] . '">'
                  . htmlspecialchars($materia["nome_materia"]) . ' (' . htmlspecialchars($materia["sigla"]) . ')
                </label>
                <input class="form-check-input" type="checkbox"
                  name="materias[]" value="' . $materia["id_materia"] . '"
                  id="materia-' . $idCurso . '-' . $materia["id_materia"] . '">
              </div>';
        }
      } else {
        echo '<div class="alert alert-warning">Nenhuma matéria cadastrada.</div>';
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
      const aberto = container.style.height === 'auto';
      container.style.height = aberto ? '0' : 'auto';
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
      const divLista = document.getElementById('lista-materias-' + idCurso);
      if (!divLista) return;

      const itens = divLista.getElementsByClassName('form-check');
      let anyVisible = false;

      for (let i = 0; i < itens.length; i++) {
        const label = itens[i].querySelector('.form-check-label');
        const texto = normalizeString(label ? label.innerText : itens[i].innerText);

        if (filtro === '' || texto.indexOf(filtro) !== -1) {
          itens[i].style.display = ''; // mostra
          anyVisible = true;
        } else {
          itens[i].style.display = 'none'; // esconde
        }
      }

      // Mensagem "Nenhuma matéria encontrada."
      const parent = divLista.parentElement;
      let noResults = parent.querySelector('.no-results-msg');

      if (!anyVisible) {
        if (!noResults) {
          noResults = document.createElement('div');
          noResults.className = 'no-results-msg mt-2 alert alert-warning';
          noResults.textContent = 'Nenhuma matéria encontrada.';
          parent.appendChild(noResults);
        }
      } else if (noResults) {
        noResults.remove();
      }
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
        <td><a href="../methods/delete_materias.php?id_materia=' . $row["id_materia"] . '" class="btn btn-danger" onclick="return confirm(\'Tem certeza que deseja remover esta matéria?\')">Remover</a></td>
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
