<?php
    
    include '../connection.php';

    $sql2 = "SELECT 
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

    $result2 = $connection->query($sql2);
    $data2 = array();

    while ($row2 = $result2->fetch_assoc()) {
        $data2[] = $row2;
    }

    $json2 = json_encode($data2);
    
    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 0 || $_SESSION['admin'] == null) {
        echo '
            <script>
                window.location.href = "../index.php?erro=2";
            </script>
        ';
    }

?>