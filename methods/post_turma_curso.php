<?php
include "../connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $id_turma = $_POST["id_turma"];
  $cursos = $_POST["cursos"] ?? [];

  // Remove associações antigas (se quiser sobrescrever)
  $connection->query("DELETE FROM turma_curso WHERE id_turma = $id_curso");

  // Adiciona novas associações
  foreach ($cursos as $id_curso) {
    $connection->query("INSERT INTO turma_curso (id_turma, id_curso) VALUES ($id_turma, $id_curso)");
  }

  header("Location: ../pages/adm_turmas.php?status=ok");
  exit();
}
?>
