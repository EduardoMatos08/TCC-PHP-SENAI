<?php
include '../connection.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receber dados do formulário
    $id_turma = $_POST['id_turma'];
    $nome_turma = trim($_POST['nome_turma']);
    $cursos = isset($_POST['cursos']) ? $_POST['cursos'] : array();
    
    // Validar dados
    $errors = array();
    
    // Verificar se o nome da turma está em branco
    if(empty($nome_turma)) {
        $errors[] = "O nome da turma é obrigatório!";
    }
    
    // Verificar se há erros
    if(!empty($errors)) {
        session_start();
        $_SESSION['errors'] = $errors;
        $_SESSION['old_data'] = $_POST;
        header("Location: editar_turma.php?id_turma=" . $id_turma);
        exit();
    }
    
    // Iniciar transação
    $connection->autocommit(FALSE);
    
    try {
        // Atualizar dados da turma
        $sql = "UPDATE turmas SET nome_turma = ? WHERE id_turma = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("si", $nome_turma, $id_turma);
        
        if(!$stmt->execute()) {
            throw new Exception("Erro ao atualizar turma: " . $stmt->error);
        }
        
        // Limpar cursos atuais da turma
        $sql_delete = "DELETE FROM turma_curso WHERE id_turma = ?";
        $stmt_delete = $connection->prepare($sql_delete);
        $stmt_delete->bind_param("i", $id_turma);
        
        if(!$stmt_delete->execute()) {
            throw new Exception("Erro ao limpar cursos da turma: " . $stmt_delete->error);
        }
        
        // Inserir novos cursos selecionados (mesmo que vazio)
        if(!empty($cursos)) {
            $sql_insert = "INSERT INTO turma_curso (id_turma, id_curso) VALUES (?, ?)";
            $stmt_insert = $connection->prepare($sql_insert);
            
            foreach($cursos as $id_curso) {
                $id_curso = intval($id_curso);
                $stmt_insert->bind_param("ii", $id_turma, $id_curso);
                
                if(!$stmt_insert->execute()) {
                    throw new Exception("Erro ao associar curso: " . $stmt_insert->error);
                }
            }
        }
        
        // Se não houver cursos selecionados, a tabela turma_curso ficará vazia para esta turma
        // Isso é permitido pelo seu banco de dados
        
        // Commit das alterações
        $connection->commit();
        
        header("Location: ../pages/adm_turmas.php?success=1");
        exit();
        
    } catch (Exception $e) {
        // Rollback em caso de erro
        $connection->rollback();
        
        session_start();
        $_SESSION['error'] = "Erro ao atualizar turma: " . $e->getMessage();
        header("Location: editar_turma.php?id_turma=" . $id_turma);
        exit();
    }
    
    $connection->autocommit(TRUE);
    $connection->close();
} else {
    echo "Método não permitido!";
}
?>