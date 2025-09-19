<?php

include "../connection.php";

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$horarios = $_POST['horarios'];

if ($nome == null || $email == null || $horarios == null || $senha == null || $cpf == null) {
    echo '
        <script>
            alert("Por favor, preencha todos os campos.");
            window.location.href = "../pages/adm_professores.php";
        </script>
    ';
} else {
    echo '
        <script>
            alert("Professor cadastrado com sucesso!");
            window.location.href = "../pages/adm_professores.php";
        </script>
    ';

    $sql = "INSERT INTO `professores` (`nome`, `email`, `horarios`, `cpf`, `senha`) VALUES ('$nome', '$email', '$horarios', '$cpf', '$senha')";
    $inserir = mysqli_query($connection, $sql);
}

?>