<?php

// Inclui o arquivo responsável pela conexão com o banco de dados
include "../connection.php";

// Recebe os valores enviados pelo formulário (via método POST)
$nome_curso = $_POST['nome_curso']; // Nome da matéria
$sigla = $_POST['sigla_curso']; // Sigla da matéria (abreviação)

// Verifica se algum dos campos obrigatórios não foi preenchido
if ($nome_curso == null || $sigla_curso == null) {
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
            alert("Curso cadastrada com sucesso!");
            window.location.href = "../pages/adm_materias.php";
        </script>
    ';

    // Monta a query SQL para inserir os dados na tabela "curso"
    $sql = "INSERT INTO `cursos` (`nome_curso`, `sigla_curso`) 
            VALUES ('$nome_curso', '$sigla_curso')";

    // Executa a query de inserção no banco de dados
    $inserir = mysqli_query($connection, $sql);
}

?>
