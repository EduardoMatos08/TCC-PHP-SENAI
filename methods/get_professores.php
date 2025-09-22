<?php
// Inclui o arquivo de conexão com o banco de dados
include 'connection.php';

// Define o cabeçalho da resposta como JSON
header('Content-Type: application/json');

// Pega o parâmetro "id" da URL (GET) e garante que seja um número inteiro
$id_professor = isset($_GET['id_professor']) ? intval($_GET['id_professor']) : 0;

// Verifica se o ID é válido (maior que 0)
if ($id_professor > 0) {
    // Prepara a query para buscar nome, email e horários do professor pelo ID
    $stmt = $connection->prepare('SELECT nome_professor, email, cpf, horarios FROM professores WHERE id_professor = ? LIMIT 1');
    // Substitui o "?" da query pelo valor do ID (como inteiro)
    $stmt->bind_param('i', $id_professor);
    // Executa a query
    $stmt->execute();
    // Obtém o resultado da consulta
    $result = $stmt->get_result();

    // Se encontrou um professor com o ID informado
    if ($row = $result->fetch_assoc()) {
        // Retorna os dados do professor em formato JSON
        echo json_encode([
            'nome_professor' => $row['nome_professor'],
            'email' => $row['email'],
            'cpf' => $row['cpf'],
            'horarios' => $row['horarios']
        ]);
    } else {
        // Caso não encontre o professor no banco de dados
        echo json_encode(['error' => 'Professor não encontrado']);
    }

    // Fecha a declaração preparada
    $stmt->close();
} else {
    // Caso o ID não seja válido
    echo json_encode(['error' => 'ID inválido']);
}

// Fecha a conexão com o banco de dados
$connection->close();
