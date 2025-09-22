<?php

include "../connection.php";

// Verifica se o id_materia do usuário foi enviado via GET
if (isset($_GET['id_materia'])) {
    $id_materia = intval($_GET['id_materia']);

    // Prepara e executa a exclusão
    $stmt = $connection->prepare("DELETE FROM materias WHERE id_materia = ?");
    $stmt->bind_param("i", $id_materia);

    if ($stmt->execute()) {
        // Redireciona de volta para a página de administração
        header("Location: ../pages/adm_materias.php?msg=Matéria+deletada+com+sucesso");
        exit();
    } else {
        echo "Erro ao deletar matéria.";
    }

    $stmt->close();
} else {
    echo "id de matéria não especificado.";
}

?>