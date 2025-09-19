<?php
include 'connection.php';
header('Content-Type: application/json');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id > 0) {
    $stmt = $connection->prepare('SELECT nome, email, horarios FROM professores WHERE id = ? LIMIT 1');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        echo json_encode([
            'nome' => $row['nome'],
            'email' => $row['email'],
            'horarios' => $row['horarios']
        ]);
    } else {
        echo json_encode(['error' => 'Professor não encontrado']);
    }
    $stmt->close();
} else {
    echo json_encode(['error' => 'ID inválido']);
}
$connection->close();