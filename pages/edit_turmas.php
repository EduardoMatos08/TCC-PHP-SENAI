<?php
include '../connection.php';

// Iniciar sessão para mensagens de erro
session_start();

// Buscar dados da turma para edição
if(isset($_GET['id_turma'])) {
    $id_turma = $_GET['id_turma'];
    
    $sql = "SELECT * FROM turmas WHERE id_turma = $id_turma";
    $result = $connection->query($sql);
    
    if($result->num_rows > 0) {
        $turma = $result->fetch_assoc();
    } else {
        die("Turma não encontrada!");
    }
    
    // Buscar cursos associados à turma
    $sql_cursos = "SELECT tc.id_curso, c.nome_curso 
                   FROM turma_curso tc
                   INNER JOIN cursos c ON tc.id_curso = c.id_curso
                   WHERE tc.id_turma = $id_turma";
    $result_cursos = $connection->query($sql_cursos);
    
    $cursos_selecionados = array();
    while($row = $result_cursos->fetch_assoc()) {
        $cursos_selecionados[] = $row['id_curso'];
    }
    
} else {
    die("ID da turma não especificado!");
}

// Buscar todos os cursos disponíveis
$sql_todos_cursos = "SELECT * FROM cursos";
$result_todos_cursos = $connection->query($sql_todos_cursos);

// Verificar se há dados antigos (em caso de erro)
$old_data = isset($_SESSION['old_data']) ? $_SESSION['old_data'] : null;
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : array();
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';

// Limpar sessão
unset($_SESSION['old_data']);
unset($_SESSION['errors']);
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Turma</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"], select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .checkbox-group {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 4px;
            max-height: 200px;
            overflow-y: auto;
        }
        .checkbox-item {
            margin-bottom: 8px;
            padding: 5px;
            background: #f9f9f9;
            border-radius: 3px;
        }
        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .btn-voltar {
            background-color: #6c757d;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
            padding: 10px 20px;
            color: white;
            border-radius: 4px;
        }
        .btn-voltar:hover {
            background-color: #545b62;
        }
        .error {
            color: #dc3545;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .success {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Turma</h1>
        
        <?php if(!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if(!empty($errors)): ?>
            <?php foreach($errors as $err): ?>
                <div class="error"><?php echo $err; ?></div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <form action="../methods/update_turmas.php" method="POST">
            <input type="hidden" name="id_turma" value="<?php echo $turma['id_turma']; ?>">
            
            <div class="form-group">
                <label for="nome_turma">Nome da Turma:</label>
                <input type="text" id="nome_turma" name="nome_turma" 
                       value="<?php echo htmlspecialchars($old_data ? $old_data['nome_turma'] : $turma['nome_turma']); ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label>Cursos Associados:</label>
                <div class="checkbox-group">
                    <?php 
                    // Reset pointer do resultado
                    $result_todos_cursos->data_seek(0);
                    while($curso = $result_todos_cursos->fetch_assoc()): 
                        $checked = '';
                        if($old_data) {
                            // Usar dados do formulário em caso de erro
                            $checked = isset($old_data['cursos']) && in_array($curso['id_curso'], $old_data['cursos']) ? 'checked' : '';
                        } else {
                            // Usar dados do banco
                            $checked = in_array($curso['id_curso'], $cursos_selecionados) ? 'checked' : '';
                        }
                    ?>
                        <div class="checkbox-item">
                            <label>
                                <input type="checkbox" name="cursos[]" 
                                       value="<?php echo $curso['id_curso']; ?>"
                                       <?php echo $checked; ?>>
                                <?php echo htmlspecialchars($curso['nome_curso'] . ' (' . $curso['sigla_curso'] . ')'); ?>
                            </label>
                        </div>
                    <?php endwhile; ?>
                </div>
                <small style="color: #666;">Deixe em branco para remover todos os cursos associados</small>
            </div>
            
            <div class="form-group">
                <a href="./adm_turmas.php" class="btn-voltar">← Voltar</a>
                <button type="submit" class="btn">Atualizar Turma</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
$connection->close();
?>