<?php
include '../connection.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receber dados do formulário
    $id_curso = $_POST['id_curso'];
    $nome_curso = trim($_POST['nome_curso']);
    $sigla_curso = trim($_POST['sigla_curso']);
    
    // Validar dados
    $errors = array();
    
    // Verificar se o nome do curso está em branco
    if(empty($nome_curso) || empty($sigla_curso)) {
        $errors[] = "O nome do curso e a sigla são obrigatórios!";
    }
    
    // Verificar se há erros
    if(!empty($errors)) {
        session_start();
        $_SESSION['errors'] = $errors;
        $_SESSION['old_data'] = $_POST;
        header("Location: editar_curso.php?id_curso=" . $id_curso);
        exit();
    }
    
    // Iniciar transação
    $connection->autocommit(FALSE);
    
    try {
        // Atualizar dados do curso
        $sql = "UPDATE cursos SET nome_curso = ?, sigla_curso = ? WHERE id_curso = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssi", $nome_curso, $sigla_curso, $id_curso);
        
        if(!$stmt->execute()) {
            throw new Exception("Erro ao atualizar curso: " . $stmt->error);
        }
        
        // Commit das alterações
        $connection->commit();
        
        header("Location: ../pages/adm_materias.php?success=1");
        exit();
        
    } catch (Exception $e) {
        // Rollback em caso de erro
        $connection->rollback();
        
        session_start();
        $_SESSION['error'] = "Erro ao atualizar curso: " . $e->getMessage();
        header("Location: editar_curso.php?id_curso=" . $id_curso);
        exit();
    }
    
    $connection->autocommit(TRUE);
    $connection->close();
} else {
    echo "Método não permitido!";
}
?>