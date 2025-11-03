<?php
include '../connection.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receber dados do formulário
    $id_turma = $_POST['id_turma'];
    $cursos = isset($_POST['cursos']) ? $_POST['cursos'] : array();
    
    // Validar dados
    $errors = array();
    
    // Verificar se a turma foi informada
    if(empty($id_turma)) {
        $errors[] = "ID da turma é obrigatório!";
    }
    
    // Verificar se há erros
    if(!empty($errors)) {
        session_start();
        $_SESSION['errors'] = $errors;
        header("Location: ../pages/adm_turmas.php?error=1");
        exit();
    }
    
    // Iniciar transação
    $connection->autocommit(FALSE);
    
    try {
        // REMOVER TODOS os cursos atuais da turma
        $sql_delete = "DELETE FROM turma_curso WHERE id_turma = ?";
        $stmt_delete = $connection->prepare($sql_delete);
        $stmt_delete->bind_param("i", $id_turma);
        
        if(!$stmt_delete->execute()) {
            throw new Exception("Erro ao limpar cursos da turma: " . $stmt_delete->error);
        }
        
        // INSERIR APENAS os novos cursos selecionados (se houver)
        if(!empty($cursos)) {
            // Usar INSERT com múltiplos valores para melhor performance
            $sql_insert = "INSERT INTO turma_curso (id_turma, id_curso) VALUES ";
            $values = array();
            $params = array();
            $types = '';
            
            foreach($cursos as $id_curso) {
                $id_curso = intval($id_curso);
                // Verificar se o curso já não foi adicionado (evitar duplicatas no mesmo formulário)
                if(!in_array($id_curso, $params)) {
                    $values[] = "(?, ?)";
                    $params[] = $id_turma;
                    $params[] = $id_curso;
                    $types .= 'ii';
                }
            }
            
            if(!empty($values)) {
                $sql_insert .= implode(', ', $values);
                $stmt_insert = $connection->prepare($sql_insert);
                $stmt_insert->bind_param($types, ...$params);
                
                if(!$stmt_insert->execute()) {
                    throw new Exception("Erro ao associar cursos: " . $stmt_insert->error);
                }
            }
        }
        
        // Commit das alterações
        $connection->commit();
        
        header("Location: ../pages/adm_turmas.php?success=1");
        exit();
        
    } catch (Exception $e) {
        // Rollback em caso de erro
        $connection->rollback();
        
        session_start();
        $_SESSION['error'] = "Erro ao atualizar cursos da turma: " . $e->getMessage();
        header("Location: ../pages/adm_turmas.php?error=1");
        exit();
    }
    
    $connection->autocommit(TRUE);
    $connection->close();
} else {
    echo "Método não permitido!";
}
?>