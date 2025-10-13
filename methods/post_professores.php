<?php
// Importa o arquivo de conexão com o banco de dados
include "../connection.php";

// Recebe os dados enviados pelo formulário via POST
$nome_professor = $_POST['nome_professor'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$admin = isset($_POST['admin']) ? $_POST['admin'] : 0; // Corrigido
$senha = $_POST['senha'];
$senha = password_hash($senha, PASSWORD_DEFAULT);
$horarios = $_POST['horarios'];

function containsAnyCharacter(string $nome_professor, array $char): bool
{
    foreach ($char as $c) {
        if (strpos($nome_professor, $c) !== false) {
            return true;
        }
    }
    return false;
}

// Example usage
$char = ["'", "/", "&", '"', "=", "+", "#", "$", "@", "?", ".", "<", ">"];

$position = containsAnyCharacter($nome_professor, $char);

echo '<script>var_dump('.$position.')</script>'; // bool(true)

// Verifica se algum campo obrigatório está vazio
if ($nome_professor == null || $email == null || $senha == null || $cpf == null) {
    // Caso falte campo, mostra alerta e redireciona de volta para a página de cadastro
    echo '
        <script>
            alert("Por favor, preencha todos os campos.");
            window.location.href = "../pages/adm_professores.php";
        </script>
    ';
    exit; // Adicionado exit para parar execução
} if ($position !== false) {
    echo '
        <script>
            alert("Não utilize caracteres especiais.");
            window.location.href = "../pages/adm_professores.php";
        </script>
    ';
} else {
    // Escapar o email para evitar SQL injection
    $email_escapado = mysqli_real_escape_string($connection, $email);
    
    $sql = "SELECT COUNT(*) AS total FROM professores WHERE email = '$email_escapado'";
    $resultado = mysqli_query($connection, $sql);
    
    if ($resultado) {
        $linha = mysqli_fetch_assoc($resultado);
        
        if ($linha['total'] > 0) {
            echo '
                <script>
                    alert("Outro usuário já tem esse E-mail.");
                    window.location.href = "../pages/adm_professores.php";
                </script>
            ';
            exit; // Para a execução aqui
        }
    }
    
    // Inicia transação
    mysqli_begin_transaction($connection);

    try {
        // Insere professor
        $sql = "INSERT INTO professores (nome_professor, email, horarios, admin, cpf, senha) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "ssssss", $nome_professor, $email, $horarios, $admin, $cpf, $senha);
        mysqli_stmt_execute($stmt);
        
        $id_professor = mysqli_insert_id($connection);

        // Processa competências
        if (isset($_POST['competencia']) && is_array($_POST['competencia'])) {
            foreach ($_POST['competencia'] as $id_curso => $materias) {
                foreach ($materias as $id_materia => $tipo_nota) {
                    $sql_comp = "INSERT INTO professor_curso_materia (id_professor, id_curso, id_materia, tipo_nota) 
                                VALUES (?, ?, ?, ?)";
                    $stmt = mysqli_prepare($connection, $sql_comp);
                    mysqli_stmt_bind_param($stmt, "iiis", $id_professor, $id_curso, $id_materia, $tipo_nota);
                    mysqli_stmt_execute($stmt);
                }
            }
        }

        mysqli_commit($connection);
        
        // Mostra mensagem de sucesso e redireciona para a página de administração de professores
        echo '
            <script>
                alert("Professor cadastrado com sucesso!");
                window.location.href = "../pages/adm_professores.php";
            </script>
        ';
    } catch (Exception $e) {
        mysqli_rollback($connection);
        echo '
            <script>
                alert("Erro ao cadastrar professor: ' . $e->getMessage() . '");
                window.location.href = "../pages/adm_professores.php";
            </script>
        ';
    }
}
?>
