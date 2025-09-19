<?php

include "connection.php";

$nome = $_POST['nome'];
$sigla = $_POST['sigla'];
$carga_horaria = $_POST['carga_horaria'];

if ($nome == null || $sigla == null || $carga_horaria == null) {
    echo '
        <script>
            alert("Por favor, preencha todos os campos.");
            window.location.href = "./adm_subjects.php";
        </script>
    ';
} else {
    echo '
        <script>
            alert("Matéria cadastrada com sucesso!");
            window.location.href = "./adm_subjects.php";
        </script>
    ';

    $sql = "INSERT INTO `materias` (`nome`, `sigla`, `carga_horaria`) VALUES ('$nome', '$sigla', '$carga_horaria')";
    $inserir = mysqli_query($connection, $sql);
}

?>