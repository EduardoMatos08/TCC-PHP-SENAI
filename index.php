<!-- Página de login :) -->

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <!-- Importação dos Scripts e Estilos - Status: Funcionando -->
  <link rel="stylesheet" href="./bootstrap-styles/bootstrap.css" />
  <script src="./bootstrap-styles/bootstrap.js"></script>
  <link rel="icon" type="image/x-icon" href="../assets/favicon.png">
</head>

<style>

  body {
    background-color: #000;
  }

  .background-page {
    background-image: url(./assets/background-senai.jpg);
    background-size: cover;
  }

  .row {
    flex-direction: row-reverse !important;
  }

</style>

<body>
  <!-- Corpo do Site -->

  <div class="background-page container-fluid vh-100 d-flex justify-content-center align-items-center">
    <div class="row shadow-lg rounded-4 overflow-hidden w-75" style="max-width: 900px;">

      <!-- Lado esquerdo -->
      <div class="background-left col-md-6 bg-purple text-white d-flex flex-column justify-content-center align-items-center p-5">

      </div>

      <!-- Lado direito -->
      <div class="col-md-6 bg-white p-5">

        <h3 class="mb-4 text-left">Login</h3>

        <form action="./methods/post_login.php" method="POST">

          <div class="mb-3">
            <input type="text" name="email" class="form-control" placeholder="E-mail" required>
          </div>

          <div class="mb-3">
            <input type="password" name="senha" class="form-control" placeholder="Senha" required>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <input class="form-check-input" type="checkbox" name="remember" id="remember">
              <label for="remember">Lembrar-se</label>
            </div>

            <a href="#" class="small">Esqueceu a senha?</a>
          </div>

          <button type="submit" class="btn btn-primary w-100">Login</button>

        </form>
      </div>
    </div>
  </div>

</body>

</html>