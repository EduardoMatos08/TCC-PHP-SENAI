<?php
include '../connection.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receber dados do formulário
    $id_materia = $_POST['id_materia'];
    $nome_materia = trim($_POST['nome_materia']);
    $sigla = trim($_POST['sigla']);
    $carga_horaria = trim($_POST['carga_horaria']);
    
    // Validar dados
    $errors = array();
    
    // Verificar se os campos estão em branco
    if(empty($nome_materia) || empty($sigla) || empty($carga_horaria)) {
        $errors[] = "O nome da matéria, sigla e carga horária são obrigatórios!";
    }
    
    // Verificar se há erros
    if(!empty($errors)) {
        session_start();
        $_SESSION['errors'] = $errors;
        $_SESSION['old_data'] = $_POST;
        header("Location: editar_materia.php?id_materia=" . $id_materia);
        exit();
    }
    
    // Iniciar transação
    $connection->autocommit(FALSE);
    
    try {
        // Atualizar dados da matéria - CORREÇÃO: nome da coluna
        $sql = "UPDATE materias SET nome_materia = ?, sigla = ?, carga_horaria = ? WHERE id_materia = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssii", $nome_materia, $sigla, $carga_horaria, $id_materia); // CORREÇÃO: "ssii"
        
        if(!$stmt->execute()) {
            throw new Exception("Erro ao atualizar matéria: " . $stmt->error);
        }
        
        // Commit das alterações
        $connection->commit();
        
        header("Location: ../pages/adm_materias.php?success=1");
        exit();
        
    } catch (Exception $e) {
        // Rollback em caso de erro
        $connection->rollback();
        
        session_start();
        $_SESSION['error'] = "Erro ao atualizar matéria: " . $e->getMessage();
        header("Location: editar_materia.php?id_materia=" . $id_materia); // CORREÇÃO: nome do arquivo
        exit();
    }
    
    $connection->autocommit(TRUE);
    $connection->close();
} else {
    echo "Método não permitido!";
}
?>