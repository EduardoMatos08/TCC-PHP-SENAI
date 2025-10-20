<?php

include "../connection.php";

// Verifica se o id_materia do usuário foi enviado via GET
if (isset($_GET['id_turma'])) {
    $id_turma = intval($_GET['id_turma']);

    // Prepara e executa a exclusão
    $stmt = $connection->prepare("DELETE FROM turmas WHERE id_turma = ?");
    $stmt->bind_param("i", $id_turma);

    if ($stmt->execute()) {
        // Redireciona de volta para a página de administração
        header("Location: ../pages/adm_turmas.php?msg=Turma+deletada+com+sucesso");
        exit();
    } else {
        echo "Erro ao deletar turma.";
    }

    $stmt->close();
} else {
    echo "Id de turma não especificado.";
}

?>