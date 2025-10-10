<?php

include "../connection.php";

// Verifica se o id_materia do usuário foi enviado via GET
if (isset($_GET['id_curso'])) {
    $id_curso = intval($_GET['id_curso']);

    // Prepara e executa a exclusão
    $stmt = $connection->prepare("DELETE FROM cursos WHERE id_curso = ?");
    $stmt->bind_param("i", $id_curso);

    if ($stmt->execute()) {
        // Redireciona de volta para a página de administração
        header("Location: ../pages/adm_materias.php?msg=Curso+deletado+com+sucesso");
        exit();
    } else {
        echo "Erro ao deletar curso.";
    }

    $stmt->close();
} else {
    echo "Id do curso não especificado.";
}

?>