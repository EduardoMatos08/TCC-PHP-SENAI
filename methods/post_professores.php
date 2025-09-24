<?php
include "../connection.php";

$nome_professor = $_POST['nome_professor'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$senha = md5($_POST['senha']);
$horarios = $_POST['horarios'];
$materias = isset($_POST['materias']) ? $_POST['materias'] : [];

if ($nome_professor == null || $email == null || $horarios == null || $senha == null || $cpf == null) {
    echo '
        <script>
            alert("Por favor, preencha todos os campos.");
            window.location.href = "../pages/adm_professores.php";
        </script>
    ';
} else {
    $sql = "INSERT INTO `professores` (`nome_professor`, `email`, `horarios`, `cpf`, `senha`) 
            VALUES ('$nome_professor', '$email', '$horarios', '$cpf', '$senha')";
    $inserir = mysqli_query($connection, $sql);

    $id_professor = mysqli_insert_id($connection);

    if (!empty($materias)) {
        foreach ($materias as $id_materia) {
            $sqlRelacao = "INSERT INTO professor_materia (id_professor, id_materia) 
                           VALUES ('$id_professor', '$id_materia')";
            mysqli_query($connection, $sqlRelacao);
        }
    }

    echo '
        <script>
            alert("Professor cadastrado com sucesso!");
            window.location.href = "../pages/adm_professores.php";
        </script>
    ';
}
?>
