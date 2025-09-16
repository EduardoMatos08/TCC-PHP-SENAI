<?php

include "connection.php";

$nome = $_POST['nome'];
$email = $_POST['email'];
$horarios = $_POST['horarios'];

if ($nome == null || $email == null || $horarios == null) {
    echo '
        <script>
            alert("Por favor, preencha todos os campos.");
            window.location.href = "./adm_teacher.php";
        </script>
    ';
} else {
    echo '
        <script>
            alert("Professor cadastrado com sucesso!");
            window.location.href = "./adm_teacher.php";
        </script>
    ';

    $sql = "INSERT INTO `professores` (`nome`, `email`, `horarios`) VALUES ('$nome', '$email', '$horarios')";
    $inserir = mysqli_query($connection, $sql);
}

?>