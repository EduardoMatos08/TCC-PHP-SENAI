<?php

// Inclui o arquivo responsável pela conexão com o banco de dados
include "../connection.php";

// Recebe os valores enviados pelo formulário (via método POST)
$nome_turma = $_POST['nome_turma']; // Nome da matéria

// Verifica se algum dos campos obrigatórios não foi preenchido
if ($nome_turma == null) {
    // Caso haja campo vazio → mostra alerta e redireciona para a página de administração
    echo '
        <script>
            alert("Por favor, preencha todos os campos.");
            window.location.href = "../pages/adm_turmas.php";
        </script>
    ';
} else {
    // Caso todos os campos estejam preenchidos corretamente
    // Mostra mensagem de sucesso e redireciona para a mesma página
    echo '
        <script>
            alert("Turma cadastrada com sucesso!");
            window.location.href = "../pages/adm_turmas.php";
        </script>
    ';

    // Monta a query SQL para inserir os dados na tabela "materias"
    $sql = "INSERT INTO `turmas` (`nome_turma`) 
            VALUES ('$nome_turma')";

    // Executa a query de inserção no banco de dados
    $inserir = mysqli_query($connection, $sql);
}

?>
