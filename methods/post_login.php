<?php

session_start();
include "../connection.php";

$email = $_POST['email'];
$senha = $_POST['senha'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sql = "SELECT * FROM professores WHERE email = ? AND senha = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['id_professor'] = $user['id_professor'];
        $_SESSION['nome_professor'] = $user['nome_professor'];
        $_SESSION['admin'] = $user['admin']; // guarda se é admin ou não

        header("Location: ../pages/home.php");
        exit;
    } else {
        echo "Usuário ou senha inválidos!";
    }
}


?>