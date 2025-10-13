<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lançadeiro Senai</title>
  <!-- Importação dos Scripts e Estilos - Status: Funcionando -->
  <link rel="stylesheet" href="../bootstrap-styles/bootstrap.css" />
  <script src="../bootstrap-styles/bootstrap.js"></script>
  <link rel="icon" type="image/x-icon" href="../assets/favicon.png">
</head>

<style>
  .navbar-text {
    font-weight: 500;
    font-size: 18px;
  }
  .d-flex {
            display: flex !important;
            align-items: center;
            gap: 30px;
        }
.mt-5 {
    margin-top: 0 !important;
    padding: 7% 0;
}

</style>


<body>
  <!-- Corpo do Site -->
  <!-- Navbar -->
  <?php include '../components/navbar.php'; ?>
  <?php
date_default_timezone_set('America/Sao_Paulo');

// Dados do mês atual
$mes = date('m');
$ano = date('Y');
$dia_hoje = date('j');
$primeiro_dia = mktime(0, 0, 0, $mes, 1, $ano);
$nome_mes = strftime('%B', $primeiro_dia); // Nome do mês por extenso
$dia_semana = date('w', $primeiro_dia); // 0 (domingo) até 6 (sábado)
$dias_no_mes = date('t', $primeiro_dia); // número de dias no mês

// Dias da semana
$dias_semana = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-calendar td, .table-calendar th {
            width: 14.28%;
            height: 100px;
            vertical-align: top;
            text-align: center;
        }
        .hoje {
            background-color: #0d6efd;
            color: white;
            border-radius: 50%;
            display: inline-block;
            width: 35px;
            height: 35px;
            line-height: 35px;
        }
    </style>

<div style="margin-top: 0 !important;" class="container mt-5">
    <h2 class="text-center mb-4"><?= ucfirst($nome_mes) . " de $ano" ?></h2>
    <table class="table table-bordered table-calendar bg-white shadow-sm">
        <thead class="table-primary">
        <tr>
            <?php foreach ($dias_semana as $dia): ?>
                <th><?= $dia ?></th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php
            // Preenche os dias em branco antes do início do mês
            for ($i = 0; $i < $dia_semana; $i++) {
                echo "<td></td>";
            }

            // Preenche os dias do mês
            for ($dia = 1; $dia <= $dias_no_mes; $dia++) {
                $coluna_atual = ($dia_semana + $dia - 1) % 7;

                // Marca o dia de hoje
                if ($dia == $dia_hoje) {
                    echo "<td><span class='hoje'>$dia</span></td>";
                } else {
                    echo "<td>$dia</td>";
                }

                // Fecha a linha no final da semana
                if ($coluna_atual == 6 && $dia != $dias_no_mes) {
                    echo "</tr><tr>";
                }
            }

            // Completa a última linha com células em branco
            $resto = ($dia_semana + $dias_no_mes) % 7;
            if ($resto != 0) {
                for ($i = 0; $i < 7 - $resto; $i++) {
                    echo "<td></td>";
                }
            }
            ?>
        </tr>
        </tbody>
    </table>
</div>

</body>

</html>

