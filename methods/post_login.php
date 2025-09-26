<?php

// Inicia a sessão para permitir o uso de variáveis de sessão
session_start();

// Inclui o arquivo que faz a conexão com o banco de dados
include "../connection.php";

// Recebe os dados enviados pelo formulário (email e senha) via método POST
$email = $_POST['email'];
$senha = $_POST['senha'];

// Verifica se o método usado para acessar a página foi POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Prepara a consulta SQL com placeholders para evitar SQL Injection
    $sql = "SELECT * FROM professores WHERE email = ? AND senha = ?";
    
    // Prepara a query no banco de dados
    $stmt = $connection->prepare($sql);
    
    // Substitui os placeholders (?) pelos valores de $email e $senha
    // O "ss" indica que são duas strings
    $stmt->bind_param("ss", $email, $senha);
    
    // Executa a query no banco
    $stmt->execute();
    
    // Pega o resultado da consulta
    $result = $stmt->get_result();

    // Se encontrou pelo menos 1 usuário com esse email e senha
    if ($result->num_rows > 0) {
        // Converte o resultado em um array associativo
        $user = $result->fetch_assoc();
        
        // Guarda os dados principais do professor na sessão
        $_SESSION['id_professor'] = $user['id_professor'];
        $_SESSION['nome_professor'] = $user['nome_professor'];
        $_SESSION['admin'] = $user['admin']; // guarda se é admin ou não

        // Redireciona o usuário para a página inicial do sistema
        header("Location: ../pages/home.php");
        exit; // encerra o script para evitar execução extra
    } else {
        // Caso email ou senha não existam no banco
        echo "Usuário ou senha inválidos!";
    }
}

?>