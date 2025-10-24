<?php
include '../connection.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receber dados do formulário
    $id_professor = $_POST['id_professor'];
    $nome_professor = $_POST['nome_professor'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $horarios = $_POST['horarios'];
    $admin = $_POST['admin'];
    $competencias = isset($_POST['competencia']) ? $_POST['competencia'] : array();
    
    // Iniciar transação
    $conn->autocommit(FALSE);
    $erro = false;
    
    try {
        // Atualizar dados do professor
        if(!empty($_POST['senha'])) {
            $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
            $sql = "UPDATE professores SET 
                    nome_professor = '$nome_professor',
                    email = '$email',
                    senha = '$senha',
                    cpf = '$cpf',
                    horarios = '$horarios',
                    admin = $admin
                    WHERE id_professor = $id_professor";
        } else {
            $sql = "UPDATE professores SET 
                    nome_professor = '$nome_professor',
                    email = '$email',
                    cpf = '$cpf',
                    horarios = '$horarios',
                    admin = $admin
                    WHERE id_professor = $id_professor";
        }
        
        if(!$conn->query($sql)) {
            throw new Exception("Erro ao atualizar professor: " . $conn->error);
        }
        
        // Limpar competências atuais do professor
        $sql_delete = "DELETE FROM professor_curso_materia WHERE id_professor = $id_professor";
        if(!$conn->query($sql_delete)) {
            throw new Exception("Erro ao limpar competências: " . $conn->error);
        }
        
        // Inserir novas competências selecionadas
        if(!empty($competencias)) {
            foreach($competencias as $id_curso => $materias) {
                foreach($materias as $id_materia => $tipo_nota) {
                    $id_curso = intval($id_curso);
                    $id_materia = intval($id_materia);
                    $tipo_nota = $conn->real_escape_string($tipo_nota);
                    
                    $sql_insert = "INSERT INTO professor_curso_materia (id_professor, id_curso, id_materia, tipo_nota) 
                                   VALUES ($id_professor, $id_curso, $id_materia, '$tipo_nota')";
                    
                    if(!$conn->query($sql_insert)) {
                        throw new Exception("Erro ao inserir competência: " . $conn->error);
                    }
                }
            }
        }
        
        // Commit das alterações
        $conn->commit();
        
        header("Location: ../pages/professores.php?success=1");
        exit();
        
    } catch (Exception $e) {
        // Rollback em caso de erro
        $conn->rollback();
        echo "Erro: " . $e->getMessage();
    }
    
    $conn->autocommit(TRUE);
    $conn->close();
} else {
    echo "Método não permitido!";
}
?>