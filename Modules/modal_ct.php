<button onclick="openModal('CTModal')" class="add">Criar Treino</button>

<dialog id="CTModal">
    <div class="modal-content">
        <header>
            <h1>Criar treino Personalizado</h1>
        </header>
        <form action="Php/process_create_training.php" method="POST" enctype="multipart/form-data">
            <input type="text" placeholder="Nome do Treino" name="name" required>

            <fieldset>
                <legend>Grupo Muscular</legend>
                <label>
                    <input type="checkbox" name="type[]" id="b" value="Braço">
                    <label for="b" class="lab">Braço</label></label>

                <label>
                    <input type="checkbox" name="type[]" id="p" value="Peito">
                    <label for="p" class="lab">Peito</label></label>

                <label>
                    <input type="checkbox" name="type[]" id="o" value="Ombro">
                    <label for="o" class="lab">Ombro</label></label>

                <label>
                    <input type="checkbox" name="type[]" id="c" value="Costas">
                    <label for="c" class="lab">Costas</label></label>

                <label>
                    <input type="checkbox" name="type[]" id="pn" value="Perna">
                    <label for="pn" class="lab">Perna</label></label>
            </fieldset>

            <div class="file-upload-container">
                <label for="file-input" class="file-upload-label">Selecionar Imagem</label>
                <div class="preview-box" id="preview-box">
                    <img id="image-preview" src="#" alt="Pré-visualização">
                </div>
                <input type="file" id="file-input" name="image" accept="image/*" required>
            </div>

            <?php include("Modules/modal_exerc.php"); ?>

            <div class="btns">
                <button type="submit" class="submit">Criar Treino</button>
                <button type="button" onclick="closeModal('CTModal')" class="closeModal">Fechar</button>
            </div>
        </form>
    </div>
</dialog>

<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.showModal();
    }
    
    function closeModal(modalId) {
        document.getElementById(modalId).close();
    }

    const fileInput = document.getElementById('file-input');
    const imagePreview = document.getElementById('image-preview');
    const previewBox = document.getElementById('preview-box');

    fileInput.addEventListener('change', function (e) {
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (event) {
                imagePreview.src = event.target.result;

                if (file.name.toLowerCase().endsWith('.png')) {
                    previewBox.classList.add('transparent-bg');
                } else {
                    previewBox.classList.remove('transparent-bg');
                }

                imagePreview.style.display = 'block';
            }

            reader.readAsDataURL(file);
        } else {
            previewBox.style.display = 'none';
        }
    });
</script>