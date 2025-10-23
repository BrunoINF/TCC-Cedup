<h2>Exercícios</h2>
<?php include("modal_cExerc.php"); ?>
<input type="text" id="filtroTabelaExerc" class="search" placeholder="Pesquisar na tabela...">

<?php
$sql_exercise = "SELECT * FROM exercicio";
$res_exercise = mysqli_query($id, $sql_exercise);

$contlinha = mysqli_num_rows($res_exercise);
if ($contlinha > 0) {
  ?>
  <table class="adm-table exercises-table" id="table_exerc">
    <tr>
      <th>Imagem</th>
      <th>Nome</th>
      <th>Grupo Muscular</th>
      <th>Duração</th>
      <th>Obs</th>
      <th>Editar</th>
      <th>Deletar</th>
    </tr>
    <?php
    while ($linha = mysqli_fetch_array($res_exercise)) {

      $imagemBinaria = $linha['imagem'];
      $info = getimagesizefromstring($imagemBinaria);
      if ($info != false) {
        $tipoMime = $info['mime'];
        $base64 = base64_encode($imagemBinaria);
        $src = "data:$tipoMime;base64,$base64";
      } else {
        $src = "../images/default.png";
      }

      ?>
      <tr>
        <td align="center" data-label="Imagem">
          <div class="img-container">
            <img src="<?php echo $src; ?>" class="img_exercise" alt="<?php echo $linha['nome']; ?>">
          </div>
        </td>
        <td align="center"><?php echo $linha['nome']; ?></td>
        <td align="center"><?php echo $linha['grupo_muscular']; ?></td>
        <td align="center"><?php echo $linha['tempo_execucao']; ?></td>
        <td align="center" data-label="Obs">
          <?php echo substr($linha['observacoes'], 0, 50) . (strlen($linha['observacoes']) > 50 ? '...' : ''); ?>
        </td>
        <td>
          <button class="btn-action" onclick="openEdtModal('edtExerc<?php echo $linha['id_exercicio']; ?>')">Editar</button>
        </td>
        <td>
          <button class="btn-remove" onclick="deletExerc(<?php echo $linha['id_exercicio'] ?>)">
            Excluir
          </button>
        </td>
      </tr>


      <dialog class="modalExerc" id="edtExerc<?php echo $linha['id_exercicio']; ?>">
        <div class="modal-content">
          <header>
            <h1>Editar exercício</h1>
          </header>
          <form action="Php/process_edt_exercise.php" class="modal-form" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $linha['id_exercicio']; ?>">
            <label for="n">Digite o nome do exercício</label><br>
            <input type="text" name="name" id="n" placeholder="Nome Exercicio" value="<?php echo $linha['nome']; ?>"
              required><br>

            <fieldset class="muscle-group">
              <legend>Grupo Muscular</legend>
              <label class="radio-label">
                <input type="radio" name="type" id="b" value="Braço">
                <span class="radio-custom"></span>
                <span class="radio-text">Braço</span>
              </label>

              <label class="radio-label">
                <input type="radio" name="type" id="p" value="Peito">
                <span class="radio-custom"></span>
                <span class="radio-text">Peito</span>
              </label>

              <label class="radio-label">
                <input type="radio" name="type" id="o" value="Ombro">
                <span class="radio-custom"></span>
                <span class="radio-text">Ombro</span>
              </label>

              <label class="radio-label">
                <input type="radio" name="type" id="c" value="Costas">
                <span class="radio-custom"></span>
                <span class="radio-text">Costas</span>
              </label>

              <label class="radio-label">
                <input type="radio" name="type" id="pn" value="Perna">
                <span class="radio-custom"></span>
                <span class="radio-text">Perna</span>
              </label>
            </fieldset>

            <label for="o">Digite uma observação na hora de executar o exercicio</label><br>
            <textarea style="resize: none;" name="obs" id="o" class="textarea"
              required><?php echo $linha['observacoes']; ?></textarea>

            <label for="t">Tempo de execução em (s)</label>
            <input type="number" name="temp_exe" id="t" placeholder="Tempo execução" min="1" max="3600"
              value="<?php echo $linha['tempo_execucao']; ?>" required><br>

            <?php
            $imagemBinaria = $linha['imagem'];
            if (!empty($imagemBinaria)) {
              $info = getimagesizefromstring($imagemBinaria);
              if ($info !== false) {
                $tipoMime = $info['mime'];
                $base64 = base64_encode($imagemBinaria);
                $src = "data:$tipoMime;base64,$base64";
              } else {
                $src = "../images/default.png";
              }
            } else {
              $src = "../images/default.png";
            }
            ?>

            <div class="file-upload-container">
              <label for="file-input-<?php echo $linha['id_exercicio']; ?>" class="file-upload-label">Selecionar
                Imagem</label>
              <div class="preview-box" id="preview-box-<?php echo $linha['id_exercicio']; ?>">
                <img class="img" id="image-preview-<?php echo $linha['id_exercicio']; ?>" src="<?php echo $src; ?>"
                  alt="Pré-visualização">
              </div>
              <input type="file" id="file-input-<?php echo $linha['id_exercicio']; ?>" name="img" accept="image/*">
            </div>

            <input type="hidden" name="id_exercicio" value="<?php echo $linha['id_exercicio']; ?>">

            <div class="btns">
              <button type="submit" class="submit">Editar</button>
              <button type="button" class="closeEdtExerc"
                onclick="closeEdtModal('edtExerc<?php echo $linha['id_exercicio']; ?>')">Fechar</button>
            </div>
          </form>
        </div>
      </dialog>

    <?php }
} else {
  echo "<div class='Nada'><span class='nada'>Ainda não tem nada para ver aqui</span></div>";
} ?>
</table>

<script>
  document.getElementById("filtroTabelaExerc").addEventListener("keyup", function () {
    let filtro = this.value.toLowerCase();
    let linhas = document.querySelectorAll("#table_exerc tr");

    linhas.forEach((linha, index) => {
      if (index === 0) return;

      let textoLinha = linha.textContent.toLowerCase();
      linha.style.display = textoLinha.includes(filtro) ? "" : "none";
    });
  });

  function openEdtModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.showModal();

    const fileInput = modal.querySelector('input[type="file"]');
    const imagePreview = modal.querySelector('img[id^="image-preview-"]');

    if (fileInput && imagePreview) {
      fileInput.addEventListener("change", function () {
        const file = this.files[0];
        if (file) {
          const reader = new FileReader();
          reader.addEventListener("load", function () {
            imagePreview.setAttribute("src", this.result);
          });
          reader.readAsDataURL(file);
        }
      });
    }
  }

  function closeEdtModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.close();
  }
</script>