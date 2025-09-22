<?php

// Inclui o arquivo responsável pela conexão com o banco de dados
include "../connection.php";

// Recebe os valores enviados pelo formulário (via método POST)
$nome_materia = $_POST['nome_materia']; // Nome da matéria
$sigla = $_POST['sigla']; // Sigla da matéria (abreviação)
$carga_horaria = $_POST['carga_horaria']; // Carga horária da matéria

// Verifica se algum dos campos obrigatórios não foi preenchido
if ($nome_materia == null || $sigla == null || $carga_horaria == null) {
    // Caso haja campo vazio → mostra alerta e redireciona para a página de administração
    echo '
        <script>
            alert("Por favor, preencha todos os campos.");
            window.location.href = "../pages/adm_materias.php";
        </script>
    ';
} else {
    // Caso todos os campos estejam preenchidos corretamente
    // Mostra mensagem de sucesso e redireciona para a mesma página
    echo '
        <script>
            alert("Matéria cadastrada com sucesso!");
            window.location.href = "../pages/adm_materias.php";
        </script>
    ';

    // Monta a query SQL para inserir os dados na tabela "materias"
    $sql = "INSERT INTO `materias` (`nome_materia`, `sigla`, `carga_horaria`) 
            VALUES ('$nome_materia', '$sigla', '$carga_horaria')";

    // Executa a query de inserção no banco de dados
    $inserir = mysqli_query($connection, $sql);
}

?>
