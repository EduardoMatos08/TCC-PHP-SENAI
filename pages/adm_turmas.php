<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ADM - Turmas</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="../bootstrap-styles/bootstrap.css" />
  <script src="../bootstrap-styles/bootstrap.js"></script>
  <link rel="icon" type="image/x-icon" href="../assets/favicon.png">

  <style>
    td {
      vertical-align: middle;
    }

    /* troque #div-turma por .div-turma */
      .div-turma {
        display: flex;
        align-items: center;
        width: 100%;
        background-color: #e9ecef;
        justify-content: space-between;
        padding: 10px;
        border-bottom: solid #c0c0c0ff;
      }

    h3 {
      font-size: 25px;
      margin: 0;
      height: min-content;
    }

    .dropdown-toggle {
      margin-left: 10px;
      background: none;
      border: none;
      padding: 10px;
    }

    .dropdown-toggle:after {
      color: #6c757d;
    }

    .div-turma-cursos {
      transition: height 0.15s ease-in-out;
      background-color: #dee2e6;
      padding: 0;
      height: 0;
      overflow: hidden;
      margin-bottom: 20px;
    }

    .div-expansora {
      padding: 20px;
    }

    .lista-cursos {
      transition: all 0.1s ease-in-out;
    }

    .mb-3 {
      width: 50%;
    }

    .d-flex {
      display: flex;
      align-items: center;
      gap: 30px;
    }

    .form-check {
      transition: all 0.3s ease-in-out;
      border-radius: 5px;
      display: flex;
      align-items: center;
      opacity: 1;
      max-height: 50px;
      margin-bottom: 5px;
    }

    .form-check.hidden {
      opacity: 0;
      max-height: 0;
      margin: 0;
      padding: 0 !important;
      overflow: hidden;
    }

    .form-check:hover {
      background-color: #adb5bd;
    }

    #action-buttons {
      display: flex;
    gap: 10px;
    }
  </style>
</head>

<body>
  <?php include '../components/navbar.php'; ?>
  <?php include "../connection.php"; ?>

  <h1 style="padding-top: 5.5rem; text-align: center;">CADASTRO DE TURMAS</h1>

  <!-- Formulário de turmas -->
  <form action="../methods/post_turmas.php" method="POST">
    <div class="container mt-4 d-flex flex-column align-items-center">
      <div style="margin-top: 30px;width: 100%;display: flex;flex-direction: column;align-items: flex-start;">
        <div class="mb-3">
          <label for="nome_turma" class="form-label">Nome da Turma</label>
          <input class="form-control" name="nome_turma"/>
        </div>
      </div>
      <button type="submit" class="btn btn-primary mt-3" style="width: 30%;">Criar Turma</button>
    </div>
  </form>

  <?php
  // Consulta turmas
  $sql_turmas = "SELECT id_turma, nome_turma FROM turmas";
  $result_turmas = $connection->query($sql_turmas);

  if ($result_turmas->num_rows > 0) {
    echo '<div class="container mt-4">';
    echo '<h2 class="mb-4" style="font-size: 1.75rem; font-weight: 500;">Lista de Turmas</h2>';
    // Iniciar o container para as turmas
    echo '<div id="turmas-container">';
    while ($turma = $result_turmas->fetch_assoc()) {
      $idTurma = $turma["id_turma"];
      
      echo '
        <div class="div-turma">
          <h3>' . htmlspecialchars($turma["nome_turma"]) . '</h3>
          <div class="d-flex">
            <button onclick="openDropdown(event)" class="dropdown-toggle" type="button"></button>
            <div id="action-buttons">
              <a href="../methods/put_turma.php?id_turma=' . $idTurma . '" class="btn btn-primary">Editar</a>
              <a href="../methods/delete_turma.php?id_turma=' . $idTurma . '" class="btn btn-danger" onclick="return confirm(\'Tem certeza que deseja remover esta turma?\')">Remover</a>
            </div>
            </div>
        </div>
      ';

      // Div expansível de cursos
      echo '<div class="div-turma-cursos">';

      // Buscar cursos relacionados à turma
      $sql_cursos_relacionados = "SELECT c.id_curso, c.nome_curso 
                                 FROM cursos c 
                                 INNER JOIN turma_curso tc ON c.id_curso = tc.id_curso 
                                 WHERE tc.id_turma = $idTurma";

      // Buscar cursos não relacionados à turma
      $sql_cursos_nao_relacionados = "SELECT c.id_curso, c.nome_curso 
                                     FROM cursos c 
                                     WHERE c.id_curso NOT IN (
                                       SELECT id_curso FROM turma_curso WHERE id_turma = $idTurma
                                     )";

      $result_cursos_relacionados = $connection->query($sql_cursos_relacionados);
      $result_cursos_nao_relacionados = $connection->query($sql_cursos_nao_relacionados);

      echo '
        <div class="div-expansora">
          <h5 style="margin-bottom: 15px;">Adicionar cursos à turma</h5>
          <input type="text" class="form-control mb-3" placeholder="Pesquisar curso..." oninput="filtrarCursos(event)" data-turma-id="' . $idTurma . '" />

          <form action="../methods/post_turma_curso.php" method="POST">
            <input type="hidden" name="id_turma" value="' . $idTurma . '">
            <div id="lista-cursos-' . $idTurma . '" class="lista-cursos">';

      // Exibe cursos já vinculados
      if ($result_cursos_relacionados->num_rows > 0) {
        while ($curso = $result_cursos_relacionados->fetch_assoc()) {
          echo '
              <div class="form-check justify-content-between align-items-center p-2 border-bottom">
                <label class="form-check-label" for="curso-' . $idTurma . '-' . $curso["id_curso"] . '">
                  ' . htmlspecialchars($curso["nome_curso"]) . '
                </label>
                <input class="form-check-input" type="checkbox" checked
                  name="cursos[]" value="' . $curso["id_curso"] . '"
                  id="curso-' . $idTurma . '-' . $curso["id_curso"] . '">
              </div>';
        }
        
        // Adiciona divisor se houver cursos não vinculados
        if ($result_cursos_nao_relacionados->num_rows > 0) {
          echo '<div class="dropdown-divider my-3"></div>';
        }
      }

      // Exibe cursos não vinculados
      if ($result_cursos_nao_relacionados->num_rows > 0) {
        while ($curso = $result_cursos_nao_relacionados->fetch_assoc()) {
          echo '
              <div class="form-check justify-content-between align-items-center p-2 border-bottom">
                <label class="form-check-label" for="curso-' . $idTurma . '-' . $curso["id_curso"] . '">
                  ' . htmlspecialchars($curso["nome_curso"]) . '
                </label>
                <input class="form-check-input" type="checkbox"
                  name="cursos[]" value="' . $curso["id_curso"] . '"
                  id="curso-' . $idTurma . '-' . $curso["id_curso"] . '">
              </div>';
        }
      } else if ($result_cursos_relacionados->num_rows == 0) {
        echo '<div class="alert alert-info">Nenhum curso disponível para vincular.</div>';
      }

      echo '
            </div>';
      
      // Só mostra o botão se houver cursos
      if ($result_cursos_relacionados->num_rows > 0 || $result_cursos_nao_relacionados->num_rows > 0) {
        echo '<button type="submit" class="btn btn-primary mt-3 w-100" href="../methods/post_turma_curso.php?id_turma=' . $idTurma . '">Salvar Cursos da Turma</button>';
      }
      
      echo '
          </form>
        </div>
      </div>';
    }

    echo '</div>';
  } else {
    echo '
      <div class="container mt-4">
        <h3 style="font-size: 1.75rem; font-weight: 500;">Lista de Turmas</h3>
        <div class="alert alert-warning mt-3">Nenhuma turma cadastrada.</div>
      </div>';
  }
  ?>

  <script>
    // Abre e fecha dropdown
    function openDropdown(event) {
      const button = event.currentTarget;
      const container = button.closest('.div-turma').nextElementSibling;
      const content = container.querySelector('.div-expansora');
      
      if (container.style.height === '0px' || container.style.height === '') {
        container.style.height = content.offsetHeight + 'px';
      } else {
        container.style.height = '0px';
      }
    }

    // Remove acentos e coloca em minúsculas
    function normalizeString(str) {
      return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
    }

    // Filtro de cursos
    function filtrarCursos(event) {
      const input = event.target;
      const idTurma = input.dataset.turmaId;
      const filtro = normalizeString(input.value.trim());
      const divLista = document.getElementById(`lista-cursos-${idTurma}`);
      const container = input.closest('.div-turma-cursos');
      const content = container.querySelector('.div-expansora');
      
      if (!divLista) return;

      const cursos = divLista.querySelectorAll('.form-check');
      let anyVisible = false;

      cursos.forEach(item => {
        const label = item.querySelector('.form-check-label');
        if (!label) return;
        
        const texto = normalizeString(label.textContent);
        const matches = texto.includes(filtro);
        
        item.style.display = matches ? 'flex' : 'none';
        if (matches) anyVisible = true;
      });

      // Remove mensagem antiga se existir
      const oldMessage = divLista.querySelector('.no-results-msg');
      if (oldMessage) oldMessage.remove();

      // Adiciona mensagem de "nenhum resultado" se necessário
      if (!anyVisible) {
        const message = document.createElement('div');
        message.className = 'no-results-msg alert alert-warning mt-2';
        message.textContent = 'Nenhum curso encontrado.';
        divLista.appendChild(message);
      }

      // Recalcula e atualiza a altura do dropdown
      setTimeout(() => {
        container.style.height = content.offsetHeight + 'px';
      }, 300);
    }
  </script>
</body>
</html>