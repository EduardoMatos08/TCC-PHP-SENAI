<?php
include "../connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $id_curso = $_POST["id_curso"];
  $materias = $_POST["materias"] ?? [];

  // Remove associações antigas (se quiser sobrescrever)
  $connection->query("DELETE FROM curso_materias WHERE id_curso = $id_curso");

  // Adiciona novas associações
  foreach ($materias as $id_materia) {
    $connection->query("INSERT INTO curso_materias (id_curso, id_materia) VALUES ($id_curso, $id_materia)");
  }

  header("Location: ../pages/adm_materias.php?status=ok");
  exit();
}
?>
