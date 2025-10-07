<!-- Página de login :) -->

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="./bootstrap-styles/bootstrap.css" />
  <script src="./bootstrap-styles/bootstrap.js"></script>
  <link rel="icon" type="image/x-icon" href="../assets/favicon.png">
  <style>
    body {
      background-color: #000;
    }

    .background-page {
      background-image: url(./assets/background-senai.jpg);
      background-size: cover;
      background-position: center;
    }

    .row {
      flex-direction: row-reverse !important;
    }

    .bg-purple {
      background-color: #6f42c1;
    }

    #div-container {
      display: flex !important;
      flex-direction: column !important;
      align-items: center !important;
    }

    .alert-warning {
      width: 50% !important;
    }

    .mt-4 {
      display: flex;
    flex-direction: column;
    align-items: center;
    }
  </style>
</head>
<body>

  <div id="div-container" class="background-page container-fluid vh-100 d-flex justify-content-center align-items-center">
  <script>
    const currentUrl = new URL(window.location.href);
    const erro1 = currentUrl.origin + currentUrl.pathname + '?erro=1';
    const erro2 = currentUrl.origin + currentUrl.pathname + '?erro=2';
    if (currentUrl.searchParams.get('erro') === '2') {
      document.getElementById("div-container").innerHTML = '<div class="container mt-4"><div class="alert alert-warning">Entre   como ADM para acessar a página.</div></div>';
    } if (currentUrl.searchParams.get('erro') === '1') {
      document.getElementById("div-container").innerHTML = '<div class="container mt-4"><div class="alert alert-warning">Usuário ou Senha incorretos.</div></div>';
    }
  </script>
  
    <div class="row shadow-lg rounded-4 overflow-hidden w-75" style="max-width: 900px;">

      <!-- Lado esquerdo -->
      <div class="background-left col-md-6 bg-purple text-white d-flex flex-column justify-content-center align-items-center p-5">
        <h2>Bem-vindo(a)!</h2>
        <p>Acesse sua conta para continuar</p>
      </div>

      <!-- Lado direito -->
      <div class="col-md-6 bg-white p-5">
        <h3 class="mb-4 text-left">Login</h3>

        <form action="./methods/post_login.php" method="POST">
          <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="E-mail" required>
          </div>

          <div class="mb-3">
            <input type="password" name="senha" class="form-control" placeholder="Senha" required>
          </div>

          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
      </div>
    </div>
  </div>

</body>
  
</html>
