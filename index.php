<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ADM - Professores</title>
  <!-- Importação dos Scripts e Estilos - Status: Funcionando -->
  <link rel="stylesheet" href="./bootstrap-styles/bootstrap.css" />
  <script src="./bootstrap-styles/bootstrap.js"></script>
</head>

<body>
  <!-- Corpo do Site -->
  <!-- Navbar -->
  <nav style="border-bottom: solid #0000004d 2px; position: fixed; width: 100vw;" class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="./index.php">Lançadeiro Senai</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin: 0;">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Horários</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Administrador
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="./pages/adm_professores.php">Professores</a></li>
              <li><a class="dropdown-item" href="./pages/adm_materias.php">Disciplinas</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a class="dropdown-item" href="#">Horários</a>
              </li>
            </ul>
          </li>
        </ul>
        <ul class="d-flex" style="margin: 0;">
          <button style="margin-right: 32px;" class="btn btn-outline-success">Login</button>
        </ul>
      </div>
    </div>
  </nav>
</body>

</html>