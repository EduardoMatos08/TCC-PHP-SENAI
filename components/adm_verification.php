<?php
    
    include '../connection';

    $sql = "SELECT 
            p.id_professor, 
            p.nome_professor, 
            p.email,
            p.admin,
            p.cpf, 
            GROUP_CONCAT(m.nome_materia SEPARATOR ',') AS materias
        FROM professores p
        LEFT JOIN professor_materia pm ON p.id_professor = pm.id_professor
        LEFT JOIN materias m ON pm.id_materia = m.id_materia
        GROUP BY p.id_professor
    ";

    $result = $connection->query($sql);
    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $json = json_encode($data);
    
    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 0 || $_SESSION['admin'] == null) {
        echo '
            <script>
                window.location.href = "../index.php?erro=2";
            </script>
        ';
    }

?>