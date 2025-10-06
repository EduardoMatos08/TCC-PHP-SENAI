<?php
session_start();
include "../connection.php";

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';

if (empty($email) || empty($senha)) {
    echo '<script>alert("Preencha todos os campos."); window.location.href = "../index.php?erro=1";</script>';
    exit;
}

$sql = "SELECT id_professor, nome_professor, senha, admin FROM professores WHERE email = ? LIMIT 1";
$stmt = $connection->prepare($sql);
if ($stmt) {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $usuario = $result->fetch_assoc();
        if (password_verify($senha, $usuario['senha'])) {
            session_regenerate_id(true);
            $_SESSION['id_professor'] = $usuario['id_professor'];
            $_SESSION['nome_professor'] = $usuario['nome_professor'];
            $_SESSION['admin'] = $usuario['admin'];
            $_SESSION['logado'] = true;
            echo '<script>window.location.href = "../pages/home.php";</script>';
            exit;
        }
    }
}
// Falha no login
echo '<script>window.location.href = "../index.php?erro=1";</script>';
exit;
?>