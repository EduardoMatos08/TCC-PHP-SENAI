<?php

// Conexão com o banco de dados
include 'connection.php';

// Verifica se o ID do usuário foi enviado via GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Prepara e executa a exclusão
    $stmt = $connection->prepare("DELETE FROM professores WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redireciona de volta para a página de administração
        header("Location: adm_teacher.php?msg=Usuario+deletado+com+sucesso");
        exit();
    } else {
        echo "Erro ao deletar usuário.";
    }

    $stmt->close();
} else {
    echo "ID de usuário não especificado.";
}

$connection->close();

?>