<?php

// Inclui o arquivo de conexão com o banco de dados
include "../connection.php";

// Recebe os dados enviados pelo formulário via método POST
$nome_professor = $_POST['nome_professor'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
// A senha é criptografada antes de salvar
$senha = md5($_POST['senha']);
$horarios = $_POST['horarios'];

// Verifica se algum dos campos obrigatórios está vazio/nulo
if ($nome_professor == null || $email == null || $horarios == null || $senha == null || $cpf == null) {
    // Caso algum campo esteja vazio, mostra um alerta e redireciona de volta para a página de cadastro
    echo '
        <script>
            alert("Por favor, preencha todos os campos.");
            window.location.href = "../pages/adm_professores.php";
        </script>
    ';
} else {
    // Se todos os campos foram preenchidos corretamente, mostra mensagem de sucesso e redireciona
    echo '
        <script>
            alert("Professor cadastrado com sucesso!");
            window.location.href = "../pages/adm_professores.php";
        </script>
    ';

    // Monta a query SQL para inserir os dados do professor no banco
    $sql = "INSERT INTO `professores` (`nome_professor`, `email`, `horarios`, `cpf`, `senha`) 
            VALUES ('$nome_professor', '$email', '$horarios', '$cpf', '$senha')";

    // Executa a query de inserção
    $inserir = mysqli_query($connection, $sql);
}

?>
