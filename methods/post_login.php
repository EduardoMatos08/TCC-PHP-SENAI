<?php
include '../connection.php';
session_start();

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM professores WHERE email = '$email' AND senha = '$senha'";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $_SESSION['id_professor'] = $user['id_professor'];
    $_SESSION['nome_professor'] = $user['nome_professor'];
    // Redireciona para a home
    header("Location: ../pages/home.php");
    exit();
} else {
    // Login inválido
    header("Location: ../index.php?erro=1");
    exit();
}
?>