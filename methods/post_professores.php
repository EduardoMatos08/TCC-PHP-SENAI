<?php
// Importa o arquivo de conexão com o banco de dados
include "../connection.php";

// Recebe os dados enviados pelo formulário via POST
$nome_professor = $_POST['nome_professor'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$admin = $_POST['admin'];

// Criptografa a senha corretamente
$senha = $_POST['senha'];
$senha = password_hash($senha, PASSWORD_DEFAULT);

$horarios = $_POST['horarios'];

// Verifica se matérias foram enviadas; se não, define como array vazio
$materias = isset($_POST['materias']) ? $_POST['materias'] : [];

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
    
    // Insere os dados do professor na tabela "professores"
    $sql = "INSERT INTO `professores` (`nome_professor`, `email`, `horarios`, `admin`, `cpf`, `senha`) 
            VALUES ('$nome_professor', '$email', '$horarios', '$admin', '$cpf', '$senha')";
    $inserir = mysqli_query($connection, $sql);

    // Recupera o ID gerado automaticamente para esse professor (chave primária)
    $id_professor = mysqli_insert_id($connection);

    // Se o professor tiver matérias associadas
    if (!empty($materias)) {
        // Percorre cada matéria selecionada e cria uma relação na tabela intermediária
        foreach ($materias as $id_materia) {
            $sqlRelacao = "INSERT INTO professor_materia (id_professor, id_materia) 
                           VALUES ('$id_professor', '$id_materia')";
            mysqli_query($connection, $sqlRelacao);
        }
    }

    // Mostra mensagem de sucesso e redireciona para a página de administração de professores
    echo '
        <script>
            alert("Professor cadastrado com sucesso!");
            window.location.href = "../pages/adm_professores.php";
        </script>
    ';
}
?>
