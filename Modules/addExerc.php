<?php
$addExercicios = mysqli_query($id, "SELECT id_exercicio, nome FROM exercicio");
?>

<button type="button" id="btnAddExercicios">
  Adicionar Exercícios
</button>

<div id="addExercicios" class="modalExerc">
  <div class="modalExerc-content">
    <span class="close" id="closeExerc">&times;</span>
    <h2>Adicionar Exercícios</h2>
    <div class="lista-addExercicios">
      <?php while ($ex = mysqli_fetch_assoc($addExercicios)){ ?>
        <div style="margin-bottom:12px;">
          <label style="display:flex; align-items:center; cursor:pointer;">
            <input type="checkbox" name="addExercicios[]" class="check exercicio-check" value="<?= $ex['id_exercicio']; ?>"
              onchange="toggleCamposExtras(this)">
            <span style="margin-left:10px;"><?= htmlspecialchars($ex['nome']); ?></span>
          </label>

          <div class="campos-extras" style="display:none; margin-top:6px; margin-left:24px;">
            <input type="number" name="series[<?= $ex['id_exercicio']; ?>]" min="1" class="text"
              placeholder="Número de séries">
            <input type="number" name="repeticoes[<?= $ex['id_exercicio']; ?>]" min="1" class="text"
              placeholder="Número de repetições">
            <input type="number" name="carga[<?= $ex['id_exercicio']; ?>]" step="0.1" class="text"
              placeholder="Carga (kg)">
          </div>
        </div>
      <?php }; ?>
    </div>
    <button type="button" class="btn_modalExerc_exerc" onclick="confirmarModalExerc()">Confirmar</button>
  </div>
</div>

<script>
  const modalExerc = document.getElementById('addExercicios');
  const abrirBtnExerc = document.getElementById('btnAddExercicios');
  const fecharBtnExerc = document.getElementById('closeExerc');

  abrirBtnExerc.addEventListener('click', () => {
    modalExerc.style.display = 'flex';
  });

  fecharBtnExerc.addEventListener('click', () => {
    modalExerc.style.display = 'none';
  });

  function toggleCamposExtras(checkbox) {
    const camposExtras = checkbox.closest('div').querySelector('.campos-extras');
    camposExtras.style.display = checkbox.checked ? 'block' : 'none';
  }

  function confirmarModalExerc() {
    modalExerc.style.display = 'none';
  }

  window.addEventListener('click', (e) => {
    if (e.target === modalExerc) {
      modalExerc.style.display = 'none';
    }
  });
</script>

<style>
  .modalExerc {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    justify-content: center;
    align-items: center;
  }

  .modalExerc-content {
    background: #1c1c1c;
    color: white;
    padding: 20px;
    border-radius: 12px;
    width: 400px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    animation: fadeIn 0.3s ease;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: scale(0);
    }
    to {
      opacity: 1;
      transform: scale(1);
    }
  }

  .close {
    float: right;
    font-size: 24px;
    cursor: pointer;
  }

  .lista-addExercicios input.text {
    margin-bottom: 4px;
    width: 100%;
  }
</style>
