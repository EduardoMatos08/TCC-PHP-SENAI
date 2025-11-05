<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lançadeiro Senai - Calendário Semanal</title>
  <!-- Importação dos Scripts e Estilos - Status: Funcionando -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
  .table-calendar {
    table-layout: fixed;
  }
  .table-calendar td, .table-calendar th {
    vertical-align: top;
    text-align: center;
  }
  .table-calendar th {
    height: 60px;
  }
  .table-calendar td {
    height: 180px;
    position: relative;
  }
  .hoje {
    background-color: #0d6efd;
    color: white;
    border-radius: 50%;
    display: inline-block;
    width: 30px;
    height: 30px;
    line-height: 30px;
    margin-bottom: 5px;
  }
  .semana-atual {
    background-color: #e7f1ff;
  }
  .dia-semana {
    font-weight: bold;
    font-size: 1.1em;
  }
  .controles-calendario {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
    margin-bottom: 20px;
  }
  .controles-calendario select {
    width: auto;
  }
  .numero-dia {
    font-weight: bold;
    font-size: 1.2em;
    margin-bottom: 8px;
  }
  .periodo {
    border: 1px solid #dee2e6;
    margin: 2px 0;
    padding: 4px;
    font-size: 0.85em;
    background-color: #f8f9fa;
    border-radius: 4px;
    min-height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color 0.2s;
  }
  .periodo:hover {
    background-color: #e9ecef;
  }
  .periodo-manha {
    border-left: 3px solid #0d6efd;
  }
  .periodo-tarde {
    border-left: 3px solid #198754;
  }
  .periodo-noite {
    border-left: 3px solid #6f42c1;
  }
  .periodo-label {
    font-weight: 500;
  }
  /* Estilos para dias fora do mês - OPACOS */
  .fora-mes {
    background-color: rgba(248, 249, 250, 0.4) !important;
    color: rgba(108, 117, 125, 0.5) !important;
  }
  .fora-mes .periodo {
    background-color: rgba(248, 249, 250, 0.4) !important;
    color: rgba(108, 117, 125, 0.5) !important;
    border-color: rgba(222, 226, 230, 0.4) !important;
    cursor: default !important;
  }
  .fora-mes .periodo-manha {
    border-left-color: rgba(13, 110, 253, 0.3) !important;
  }
  .fora-mes .periodo-tarde {
    border-left-color: rgba(25, 135, 84, 0.3) !important;
  }
  .fora-mes .periodo-noite {
    border-left-color: rgba(111, 66, 193, 0.3) !important;
  }
  .fora-mes .periodo:hover {
    background-color: rgba(248, 249, 250, 0.4) !important;
  }
  .card-semana {
    transition: transform 0.2s;
  }
  .card-semana:hover {
    transform: translateY(-2px);
  }
  .dia-vazio {
    background-color: #f8f9fa;
  }
</style>

<body>
  <!-- Corpo do Site -->
  <!-- Navbar -->
  <?php include '../components/navbar.php' ?>
  
  <?php
  date_default_timezone_set('America/Sao_Paulo');
  
  // Obter mês e ano da URL ou usar o atual
  $mes = isset($_GET['mes']) ? intval($_GET['mes']) : date('m');
  $ano = isset($_GET['ano']) ? intval($_GET['ano']) : date('Y');
  
  // Validar valores
  if ($mes < 1) {
    $mes = 12;
    $ano--;
  }
  if ($mes > 12) {
    $mes = 1;
    $ano++;
  }
  if ($ano < 2000) $ano = 2000;
  if ($ano > 2100) $ano = 2100;
  
  // Dados do mês
  $primeiro_dia = mktime(0, 0, 0, $mes, 1, $ano);
  $nome_mes = strftime('%B', $primeiro_dia);
  $dias_no_mes = date('t', $primeiro_dia);
  
  // Dias da semana
  $dias_semana = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
  
  // Calcular o primeiro dia da semana (domingo da primeira semana)
  $primeiro_dia_semana = date('w', $primeiro_dia);
  $data_inicio_semana = date('j', strtotime("-$primeiro_dia_semana days", $primeiro_dia));
  $mes_inicio_semana = date('n', strtotime("-$primeiro_dia_semana days", $primeiro_dia));
  $ano_inicio_semana = date('Y', strtotime("-$primeiro_dia_semana days", $primeiro_dia));
  
  // Calcular número de semanas
  $ultimo_dia = mktime(0, 0, 0, $mes, $dias_no_mes, $ano);
  $ultimo_dia_semana = date('w', $ultimo_dia);
  $semanas_no_mes = ceil(($dias_no_mes + $primeiro_dia_semana) / 7);
  
  // Data atual para comparação
  $dia_hoje = date('j');
  $mes_hoje = date('m');
  $ano_hoje = date('Y');
  ?>

  <div style="margin-top: 0 !important;" class="container mt-5">
    <!-- Controles de navegação -->
    <div class="controles-calendario">
      <a href="?mes=<?= $mes-1 ?>&ano=<?= $ano ?>" class="btn btn-primary">Mês Anterior</a>
      
      <div class="d-flex align-items-center">
        <select class="form-select me-2" id="select-mes" onchange="atualizarCalendario()">
          <?php for($m = 1; $m <= 12; $m++): ?>
            <option value="<?= $m ?>" <?= $m == $mes ? 'selected' : '' ?>>
              <?= strftime('%B', mktime(0, 0, 0, $m, 1, $ano)) ?>
            </option>
          <?php endfor; ?>
        </select>
        
        <select class="form-select" id="select-ano" onchange="atualizarCalendario()">
          <?php for($a = $ano-5; $a <= $ano+5; $a++): ?>
            <option value="<?= $a ?>" <?= $a == $ano ? 'selected' : '' ?>>
              <?= $a ?>
            </option>
          <?php endfor; ?>
        </select>
      </div>
      
      <a href="?mes=<?= $mes+1 ?>&ano=<?= $ano ?>" class="btn btn-primary">Próximo Mês</a>
    </div>
    
    <h2 class="text-center mb-4"><?= ucfirst($nome_mes) . " de $ano" ?></h2>
    
    <!-- Calendário semanal -->
    <?php 
    // Gerar as semanas
    for($semana = 0; $semana < $semanas_no_mes; $semana++): 
      $data_semana = strtotime("+$semana weeks", strtotime("$ano_inicio_semana-$mes_inicio_semana-$data_inicio_semana"));
      
      // Calcular intervalo de datas da semana
      $data_inicio = date('Y-m-d', $data_semana);
      $data_fim = date('Y-m-d', strtotime('+6 days', $data_semana));
      
      // Verificar se é a semana atual
      $semana_atual = false;
      $data_hoje = date('Y-m-d');
      if ($data_hoje >= $data_inicio && $data_hoje <= $data_fim) {
        $semana_atual = true;
      }
    ?>
      
      <div class="card mb-4 card-semana <?= $semana_atual ? 'border-primary' : '' ?>">
        <div class="card-header <?= $semana_atual ? 'bg-primary text-white' : 'bg-light' ?>">
          <h5 class="mb-0">Semana <?= $semana + 1 ?> - 
            <?= date('d/m', $data_semana) ?> a 
            <?= date('d/m', strtotime('+6 days', $data_semana)) ?>
          </h5>
        </div>
        <div class="card-body p-0 <?= $semana_atual ? 'semana-atual' : '' ?>">
          <table class="table table-bordered table-calendar mb-0">
            <thead class="table-light">
              <tr>
                <?php foreach ($dias_semana as $dia): ?>
                  <th class="dia-semana"><?= $dia ?></th>
                <?php endforeach; ?>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
                // Gerar os 7 dias da semana
                for($i = 0; $i < 7; $i++):
                  $data_dia = strtotime("+$i days", $data_semana);
                  $dia_numero = date('j', $data_dia);
                  $dia_mes = date('n', $data_dia);
                  $dia_ano = date('Y', $data_dia);
                  
                  // Verificar se o dia pertence ao mês atual
                  $fora_do_mes = $dia_mes != $mes;
                  $classe_dia = $fora_do_mes ? 'fora-mes' : '';
                  
                  // Verificar se é hoje
                  $e_hoje = ($dia_numero == $dia_hoje && $dia_mes == $mes_hoje && $dia_ano == $ano_hoje);
                ?>
                  <td class="<?= $classe_dia ?>">
                    <div class="numero-dia">
                      <?php if ($e_hoje && !$fora_do_mes): ?>
                        <span class="hoje"><?= $dia_numero ?></span>
                      <?php else: ?>
                        <?= $dia_numero ?>
                      <?php endif; ?>
                    </div>
                    
                    <!-- Período Manhã -->
                    <div class="periodo periodo-manha <?= $fora_do_mes ? 'fora-mes' : '' ?>" 
                         <?= !$fora_do_mes ? "onclick=\"abrirModal('$dia_numero/$mes/$ano', 'Manhã')\"" : "" ?>>
                      <span class="periodo-label">Manhã</span>
                    </div>
                    
                    <!-- Período Tarde -->
                    <div class="periodo periodo-tarde <?= $fora_do_mes ? 'fora-mes' : '' ?>" 
                         <?= !$fora_do_mes ? "onclick=\"abrirModal('$dia_numero/$mes/$ano', 'Tarde')\"" : "" ?>>
                      <span class="periodo-label">Tarde</span>
                    </div>
                    
                    <!-- Período Noite -->
                    <div class="periodo periodo-noite <?= $fora_do_mes ? 'fora-mes' : '' ?>" 
                         <?= !$fora_do_mes ? "onclick=\"abrirModal('$dia_numero/$mes/$ano', 'Noite')\"" : "" ?>>
                      <span class="periodo-label">Noite</span>
                    </div>
                  </td>
                <?php endfor; ?>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    <?php endfor; ?>
  </div>

  <!-- Modal para adicionar/editar informações do período -->
  <div class="modal fade" id="periodoModal" tabindex="-1" aria-labelledby="periodoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="periodoModalLabel">Adicionar Informações</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p id="modalInfo"></p>
          <div class="mb-3">
            <label for="periodoDescricao" class="form-label">Descrição:</label>
            <textarea class="form-control" id="periodoDescricao" rows="3" placeholder="Adicione informações sobre este período..."></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" onclick="salvarPeriodo()">Salvar</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    let periodoSelecionado = null;
    
    function atualizarCalendario() {
      const mes = document.getElementById('select-mes').value;
      const ano = document.getElementById('select-ano').value;
      window.location.href = `?mes=${mes}&ano=${ano}`;
    }
    
    function abrirModal(data, periodo) {
      periodoSelecionado = { data, periodo };
      document.getElementById('modalInfo').textContent = `${periodo} - ${data}`;
      document.getElementById('periodoDescricao').value = '';
      
      // Carregar dados salvos (se existirem)
      const dadosSalvos = localStorage.getItem(`periodo_${data}_${periodo}`);
      if (dadosSalvos) {
        document.getElementById('periodoDescricao').value = dadosSalvos;
      }
      
      const modal = new bootstrap.Modal(document.getElementById('periodoModal'));
      modal.show();
    }
    
    function salvarPeriodo() {
      if (periodoSelecionado) {
        const descricao = document.getElementById('periodoDescricao').value;
        localStorage.setItem(`periodo_${periodoSelecionado.data}_${periodoSelecionado.periodo}`, descricao);
        
        const modal = bootstrap.Modal.getInstance(document.getElementById('periodoModal'));
        modal.hide();
        
        alert('Informações salvas com sucesso!');
      }
    }
  </script>
</body>

</html>
