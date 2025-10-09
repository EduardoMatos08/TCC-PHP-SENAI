<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ADM - Matérias</title>
  <!-- Importação dos Scripts e Estilos - Status: Funcionando -->
  <link rel="stylesheet" href="../bootstrap-styles/bootstrap.css" />
  <script src="../bootstrap-styles/bootstrap.js"></script>
  <link rel="icon" type="image/x-icon" href="../assets/favicon.png">
</head>

<style>

  td {
    vertical-align: middle;
  }

</style>

<body>
  <!-- Corpo do Site -->
  
  <?php include '../components/navbar.php'; ?>

  <h1 style="padding-top: 5.5rem; text-align: center;">CADASTRO DE CURSOS</h1>

  <form action="../methods/post_cursos.php" method="POST">
    <div style="display: flex; flex-direction: column; align-items: center; margin-top: 0 !important;" class="container mt-4">

      <div style="margin-top: 30px;width: 100%;display: flex;flex-direction: column;align-items: flex-start;">
        <div class="mb-3">
          <label id="nome-materia" for="exampleInputEmail1" class="label-adictional-style form-label">Nome do Curso</label>
          <input class="form-control" name="nome_curso" aria-describedby="emailHelp" />
        </div>

        <div class="mb-3">
          <label id="nome-materia" for="exampleInputEmail1" class="label-adictional-style form-label">Sigla</label>
          <input class="form-control" name="sigla_curso" aria-describedby="emailHelp" />
        </div>
      </div>

      <button type="submit" class="btn btn-primary" style="margin-top: 30px; width: 30%;">Enviar</button>
    </div>
  </form>

  <?php

  include "../connection.php";

  // Query para buscar os dados
  $sql2 = "SELECT id_curso, nome_curso, sigla_curso FROM cursos";
  $result2 = $connection->query($sql2);

  // Exibe os resultados em lista
  // Verifica se há resultados
  if ($result2->num_rows > 0) {
    echo '<div style="margin: 30px auto !important;" class="container mt-4">';
    echo '<h2 style="margin-top: 30px; font-size: 1.75rem; font-weight: 500;" class="mb-4">Lista de Cursos</h2>';
    echo '<table class="table table-striped table-hover table-bordered">';
    echo '  <thead class="table-light">';
    echo '    <tr>';
    echo '      <th scope="col">ID</th>';
    echo '      <th scope="col">Nome</th>';
    echo '      <th scope="col">Sigla</th>';
    echo '      <th scope="col">Carga Horária</th>';
    echo '      <th style="width: 1%;"></th>';
    echo '    </tr>';
    echo '  </thead>';
    echo '  <tbody>';

    // Output de cada linha
    while ($row2 = $result2->fetch_assoc()) {
      echo '<tr>';
      echo '<td>' . $row2["id_curso"] . '</td>';
      echo '<td>' . $row2["nome_curso"] . '</td>';
      echo '<td>' . $row2["sigla_curso"] . '</td>';
      echo '<td><a href="../methods/delete_cursos.php?id_curso=' . $row["id_curso"] . '" class="btn btn-danger" onclick="return confirm(\'Tem certeza que deseja remover esta matéria?\')">Remover</a></td>';
      echo '</tr>';
    }

    // Fecha a tabela e o container
    echo '  </tbody>';
    echo '</table>';
    echo '</div>';
  } else {
    // Mensagem se não houver resultados
    echo '<div style="margin: 30px auto !important;" class="container mt-4">';
    echo '<h3
        id="nome" 
        class="label-adictional-style form-label" 
        style="margin-top: 30px; font-size: 1.75rem; font-weight: 500;">
        Lista de Cursos
      </h3>';
    echo '<div style="margin: 30px 0;" class="alert alert-warning">Nenhum resultado encontrado.</div>';
    echo '</div>';
  }

  ?>

  <h1 style="padding-top: 5.5rem; text-align: center;">CADASTRO DE MATÉRIAS</h1>

  <form action="../methods/post_materias.php" method="POST">
    <div style="display: flex; flex-direction: column; align-items: center; margin-top: 0 !important;" class="container mt-4">

      <div style="margin-top: 30px;width: 100%;display: flex;flex-direction: column;align-items: flex-start;">
        <div class="mb-3">
          <label id="nome-materia" for="exampleInputEmail1" class="label-adictional-style form-label">Nome da Matéria</label>
          <input class="form-control" name="nome_materia" aria-describedby="emailHelp" />
        </div>

        <div class="mb-3">
          <label id="nome-materia" for="exampleInputEmail1" class="label-adictional-style form-label">Sigla</label>
          <input class="form-control" name="sigla" aria-describedby="emailHelp" />
        </div>

        <div class="mb-3">
          <label id="carga-horaria" for="exampleInputPassword1" class="label-adictional-style form-label">Carga Horária</label>
          <input name="carga_horaria" type="number" class="form-control" />
        </div>
      </div>

      <button type="submit" class="btn btn-primary" style="margin-top: 30px; width: 30%;">Enviar</button>
    </div>
  </form>

</body>

<style>
  .mb-3 {
    width: 50%;
  }
  .d-flex {
            display: flex !important;
            align-items: center;
            gap: 30px;
        }
</style>

</html>

<?php

include "../connection.php";

// Query para buscar os dados
$sql = "SELECT id_materia, nome_materia, sigla, carga_horaria FROM materias";
$result = $connection->query($sql);

include '../components/adm_verification.php';

// Exibe os resultados em lista
// Verifica se há resultados
if ($result->num_rows > 0) {
  echo '<div style="margin: 30px auto !important;" class="container mt-4">';
  echo '<h2 style="margin-top: 30px; font-size: 1.75rem; font-weight: 500;" class="mb-4">Lista de Matérias</h2>';
  echo '<table class="table table-striped table-hover table-bordered">';
  echo '  <thead class="table-light">';
  echo '    <tr>';
  echo '      <th scope="col">ID</th>';
  echo '      <th scope="col">Nome</th>';
  echo '      <th scope="col">Sigla</th>';
  echo '      <th scope="col">Carga Horária</th>';
  echo '      <th style="width: 1%;"></th>';
  echo '    </tr>';
  echo '  </thead>';
  echo '  <tbody>';

  // Output de cada linha
  while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row["id_materia"] . '</td>';
    echo '<td>' . $row["nome_materia"] . '</td>';
    echo '<td>' . $row["sigla"] . '</td>';
    echo '<td>' . $row["carga_horaria"] . ' Horas</td>';
    echo '<td><a href="../methods/delete_materias.php?id_materia=' . $row["id_materia"] . '" class="btn btn-danger" onclick="return confirm(\'Tem certeza que deseja remover esta matéria?\')">Remover</a></td>';
    echo '</tr>';
  }

  // Fecha a tabela e o container
  echo '  </tbody>';
  echo '</table>';
  echo '</div>';
} else {
  // Mensagem se não houver resultados
  echo '<div style="margin: 30px auto !important;" class="container mt-4">';
  echo '<h3
      id="nome" 
      class="label-adictional-style form-label" 
      style="margin-top: 30px; font-size: 1.75rem; font-weight: 500;">
      Lista de Matérias
    </h3>';
  echo '<div style="margin: 30px 0;" class="alert alert-warning">Nenhum resultado encontrado.</div>';
  echo '</div>';
}

?>