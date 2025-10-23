<button class="add" id="abrirCtExerc">
    Adicionar exercícios
</button>

<div id="ctExerc" class="modalCtExerc">
    <div class="modal-content">
        <header>
            <h1>Criar exercício</h1>
        </header>
        <form action="Php/process_create_exercise.php" class="modal-form" method="POST" enctype="multipart/form-data">
            <label for="n">Digite o nome do novo exercício</label><br>
            <input type="text" name="name" id="n" placeholder="Nome Exercicio" required><br>

            <fieldset class="muscle-group">
                <legend>Grupo Muscular</legend>
                <div class="radio-container">
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
                </div>
            </fieldset>

            <label for="o">Digite uma observação na hora de executar o exercicio</label><br>

            <textarea style="resize: none;" name="obs" id="o" class="textarea" required></textarea>

            <label for="t">Tempo de execução em (s)</label>
            <input type="number" name="temp_exe" id="t" placeholder="Tempo execução" max="60" min="1" required><br>

            <div class="file-upload-container">
                <label for="file-input" class="file-upload-label">Selecionar Imagem</label>
                <div class="preview-box" id="preview-box">
                    <span id="preview-text"></span>
                    <img id="image-preview" src="#" alt="Pré-visualização">
                </div>
                <input type="file" id="file-input" name="img" accept="image/*">
            </div>

            <div class="btns">
                <button type="submit" class="submit">Criar exercicio</button>
                <button type="button" class="closeCtExerc">Fechar</button>
            </div>
        </form>
    </div>
</div>

<script>
    const modalExerc = document.getElementById("ctExerc");
    const btnExerc = document.getElementById("abrirCtExerc");
    const closeExerc = document.querySelector(".closeCtExerc");
    const fileInput = document.getElementById("file-input");
    const imagePreview = document.getElementById("image-preview");
    const previewText = document.getElementById("preview-text");

    btnExerc.onclick = () => {
        modalExerc.style.display = "flex";
        modalExerc.classList.add("modal-open");
    };

    closeExerc.onclick = () => {
        modalExerc.style.display = "none";
        modalExerc.classList.remove("modal-open");
    };

    window.onclick = (event) => {
        if (event.target === modalExerc) {
            modalExerc.style.display = "none";
            modalExerc.classList.remove("modal-open");
        }
    };

    fileInput.addEventListener("change", function () {
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();

            previewText.style.display = "none";
            imagePreview.style.display = "block";

            reader.addEventListener("load", function () {
                imagePreview.setAttribute("src", this.result);
            });

            reader.readAsDataURL(file);
        } else {
            previewText.style.display = "block";
            imagePreview.style.display = "none";
            imagePreview.setAttribute("src", "");
        }
    });
</script>