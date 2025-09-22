<?php

// Conexão com o banco de dados
include '../connection.php';

// Verifica se o ID do usuário foi enviado via GET
if (isset($_GET['id_professor'])) {
    $id_professor = intval($_GET['id_professor']);

    // Prepara e executa a exclusão
    $stmt = $connection->prepare("DELETE FROM professores WHERE id_professor = ?");
    $stmt->bind_param("i", $id_professor);

    if ($stmt->execute()) {
        // Redireciona de volta para a página de administração
        header("Location: ../pages/adm_professores.php?msg=Usuario+deletado+com+sucesso");
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