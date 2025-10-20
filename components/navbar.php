<?php
session_start();
include '../connection.php';

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

echo '
    <!-- Navbar -->
    <nav style="z-index: 5; margin: 0; border-bottom: solid #0000004d 2px; position: fixed; width: 100vw;" class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
        <a class="navbar-brand" href="#">Lançadeiro Senai</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="width: -webkit-fill-available; justify-content: space-between; margin: 0;">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="./home.php">Horários</a>
            </li>
';


// Exibe aba admin apenas se for admin
if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
    echo '
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Administrador
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="./adm_professores.php">Professores</a></li>
            <li><a class="dropdown-item" href="./adm_materias.php">Disciplinas</a></li>
            <li><a class="dropdown-item" href="./adm_turmas.php">Turmas</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <a class="dropdown-item" href="#">Horários</a>
            </li>
            </ul>
        </li>
        </ul>
        </div>';
    
}

// Botão login/logout
echo '<ul class="d-flex" style="margin: 0;">';
if (isset($_SESSION['id_professor'])) {
    echo '<p style="margin: 0; font-weight: 600; font-size: 1.5rem;">Bem Vindo, <spam style="color: #0d6efd;">' . $_SESSION['nome_professor'] . '</spam>!</p>';
    echo '<a style="margin-right: 32px;" href="../methods/logout.php" class="btn btn-outline-danger">Logout</a>';
} else {
    echo '<a style="margin-right: 32px;" href="../index.php" class="btn btn-outline-success">Login</a>';
}
echo '</ul>';

echo '
    </div>
    </nav>
';

?>