<?php

include "connection.php";

// Verifica se o ID do usuário foi enviado via GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Prepara e executa a exclusão
    $stmt = $connection->prepare("DELETE FROM materias WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redireciona de volta para a página de administração
        header("Location: adm_subjects.php?msg=Matéria+deletada+com+sucesso");
        exit();
    } else {
        echo "Erro ao deletar matéria.";
    }

    $stmt->close();
} else {
    echo "ID de matéria não especificado.";
}

?>