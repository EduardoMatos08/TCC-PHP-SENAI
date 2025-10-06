<?php
session_start();
include "../connection.php";

// Captura os dados do formulário
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if (empty($email) || empty($senha)) {
    echo '<script>alert("Preencha todos os campos."); window.location.href = "../index.php";</script>';
    exit;
}

// Consulta segura com prepared statement
$sql = "SELECT id_professor, nome_professor, senha FROM professores WHERE email = ? LIMIT 1";
$stmt = $connection->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows === 1) {
    $usuario = $result->fetch_assoc();

    // Verifica a senha
    if (password_verify($senha, $usuario['senha'])) {
        // Login bem-sucedido
        session_regenerate_id(true);
        $_SESSION['id_professor'] = $usuario['id_professor'];
        $_SESSION['nome_professor'] = $usuario['nome_professor'];
        $_SESSION['logado'] = true;

        echo '<script>window.location.href = "../pages/adm_professores.php";</script>';
        exit;
    }
}

// Falha no login
echo '<script>alert("Usuário ou senha inválidos."); window.location.href = "../index.php";</script>';
exit;
?>