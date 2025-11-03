<?php
include '../connection.php';

// Iniciar sessão para mensagens de erro
session_start();

// Buscar dados do curso para edição
if(isset($_GET['id_curso'])) {
    $id_curso = $_GET['id_curso'];
    
    $sql = "SELECT * FROM cursos WHERE id_curso = $id_curso";
    $result = $connection->query($sql);
    
    if($result->num_rows > 0) {
        $curso = $result->fetch_assoc();
    } else {
        die("Curso não encontrado!");
    }
    
} else {
    die("ID do curso não especificado!");
}

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
    <link rel="stylesheet" href="../bootstrap-styles/bootstrap.css" />
    <script src="../bootstrap-styles/bootstrap.js"></script>
    <title>Editar Curso</title>
    <style>
        html {
            height: 100%;
        }

        body {
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            height: auto;
        }
        form {
            height: auto;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        .btn {
            transition: all 0.2s ease-in;
            background-color: #007bff;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        .btn:hover {
            background-color: #0056b3;
            color: #fff;
        }
        .btn-voltar {
            transition: all 0.2s ease-in;
            background-color: #6c757d;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 10px;
            padding: 12px 24px;
            color: white;
            border-radius: 4px;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
        }
        .btn-voltar:hover {
            background-color: #545b62;
            color: #fff;
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
        <h1>Editar Curso</h1>
        
        <?php if(!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if(!empty($errors)): ?>
            <?php foreach($errors as $err): ?>
                <div class="error"><?php echo $err; ?></div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <form action="../methods/update_materias_cursos.php" method="POST">
            <input type="hidden" name="id_curso" value="<?php echo $curso['id_curso']; ?>">
            
            <div class="form-group">
                <label for="nome_curso">Nome do Curso:</label>
                <input class="form-control" type="text" id="nome_curso" name="nome_curso" 
                       value="<?php echo htmlspecialchars($old_data ? $old_data['nome_curso'] : $curso['nome_curso']); ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="sigla_curso">Sigla do Curso:</label>
                <input class="form-control" type="text" id="sigla_curso" name="sigla_curso" 
                       value="<?php echo htmlspecialchars($old_data ? $old_data['sigla_curso'] : $curso['sigla_curso']); ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <a href="./adm_materias.php" class="btn-voltar">Voltar</a>
                <button type="submit" class="btn">Atualizar Curso</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
$connection->close();
?>