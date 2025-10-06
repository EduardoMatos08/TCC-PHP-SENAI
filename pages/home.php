<!DOCTYPE html>
<html lang="pt-br">

<style>
  .navbar-text {
    font-weight: 500;
    font-size: 18px;
  }
</style>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lançadeiro Senai</title>
  <!-- Importação dos Scripts e Estilos - Status: Funcionando -->
  <link rel="stylesheet" href="../bootstrap-styles/bootstrap.css" />
  <script src="../bootstrap-styles/bootstrap.js"></script>
  <link rel="icon" type="image/x-icon" href="../assets/favicon.png">
</head>

<body>
  <!-- Corpo do Site -->
  <!-- Navbar -->
  <?php include '../components/navbar.php'; ?>
</body>

</html>

<?php if (!empty($_SESSION['admin']) && $_SESSION['admin'] == 1): ?>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
      Administrador
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
      <li><a class="dropdown-item" href="./adm_professores.php">Professores</a></li>
      <li><a class="dropdown-item" href="./adm_materias.php">Disciplinas</a></li>
      <li>
        <hr class="dropdown-divider">
      </li>
      <li><a class="dropdown-item" href="#">Horários</a></li>
    </ul>
  </li>
<?php endif; ?>