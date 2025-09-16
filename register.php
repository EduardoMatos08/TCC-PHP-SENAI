<?php

    include "connection.php";

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    //$horarios = $_POST['horarios'];

    $sql = "INSERT INTO `professores` (`nome`, `email`, `horarios`) VALUES ('$nome', '$email')";

    $inserir = mysqli_query($connection, $sql);

?>