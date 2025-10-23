<h2>Treinos Prontos</h2>

<?php
include("Php/connection.php");

$sql_training = "SELECT * FROM treino_pronto";
$res_training = mysqli_query($id, $sql_training);
include("modal_ctp.php");
if (mysqli_num_rows($res_training) > 0) {
    while ($linha = mysqli_fetch_array($res_training)) {
        $id_treino = $linha['id_treino'];
        $nome = $linha['nome'];
        $grupo_muscular = $linha['grupo_muscular'];

        $sql_TExerc = "
            SELECT tpe.id_exercicio, e.nome, tpe.series, tpe.carga, tpe.repeticoes 
            FROM treino_pronto_exercicio tpe
            INNER JOIN exercicio e ON e.id_exercicio = tpe.id_exercicio 
            WHERE tpe.id_treino = $id_treino";
        $res_TExerc = mysqli_query($id, $sql_TExerc);

        $sql_NotIn = "
            SELECT id_exercicio, nome 
            FROM exercicio 
            WHERE id_exercicio NOT IN (
                SELECT id_exercicio 
                FROM treino_pronto_exercicio 
                WHERE id_treino = $id_treino
            )";
        $res_NotIn = mysqli_query($id, $sql_NotIn);

        
        ?>

        <div class="treino">
            <h1>
                <?php echo $nome; ?>
                <p><?php echo $grupo_muscular; ?></p>
            </h1>
            <div>
                <button class="btn-action" onclick="openModal('edtTpro<?php echo $id_treino; ?>')">Editar</button>
                <button class="btn-remove"
                    onclick="deletTrainingP(<?php echo $id_treino ?>)">Deletar</button>
            </div>
        </div>

        <dialog id="edtTpro<?php echo $id_treino; ?>" class="edtTpro">
            <div class="modal-content">
                <header>
                    <h1>Editar treino Pronto</h1>
                </header>
                <form action="Php/process_edt_trainingP.php" method="post" enctype="multipart/form-data">

                    <input type="hidden" name="id" value="<?php echo $id_treino; ?>">

                    <span>Digite o novo nome</span>
                    <input type="text" name="name" placeholder="Nome do Treino" value="<?php echo $nome; ?>" required>

                    <fieldset>
                        <legend>Grupo Muscular</legend>
                        <label><input type="checkbox" name="type[]" value="Braço">Braço</label>
                        <label><input type="checkbox" name="type[]" value="Peito">Peito</label>
                        <label><input type="checkbox" name="type[]" value="Ombro">Ombro</label>
                        <label><input type="checkbox" name="type[]" value="Costas">Costas</label>
                        <label><input type="checkbox" name="type[]" value="Perna">Perna</label>
                    </fieldset>

                    <div class="exerc">
                        <h2>Exercícios do treino</h2>
                        <?php while ($rowTprr = mysqli_fetch_assoc($res_TExerc)) { ?>
                            <div class="exercRow">
                                <div class="row-top">
                                    <span class="exercName"><?php echo $rowTprr['nome']; ?></span>
                                    <label class="labelExerc">
                                        Remover <input type="checkbox" name="delete_exerc[]"
                                            value="<?php echo $rowTprr['id_exercicio']; ?>">
                                    </label>
                                </div>

                                <div class="row-inputs">
                                    <label>Séries:
                                        <input type="number" name="series<?php echo $rowTprr['id_exercicio']; ?>"
                                            value="<?php echo $rowTprr['series']; ?>" min="1" required>
                                    </label>
                                    <label>Repetições:
                                        <input type="number" name="repeticoes<?php echo $rowTprr['id_exercicio']; ?>"
                                            value="<?php echo $rowTprr['repeticoes']; ?>" min="1" required>
                                    </label>
                                    <label>Carga:
                                        <input type="number" name="carga<?php echo $rowTprr['id_exercicio']; ?>"
                                            value="<?php echo $rowTprr['carga']; ?>" min="1" required>
                                    </label>
                                </div>
                                <input type="hidden" name="id_exerc[]" value="<?php echo $rowTprr['id_exercicio']; ?>">
                            </div>
                        <?php } ?>
                    </div>

                    <div class="exerc">
                        <h2>Adicionar exercícios</h2>
                        <input type="text" id="searchExercTpro" placeholder="Pesquisar exercício..." class="searchBarTpro">
                        <?php while ($rowNot = mysqli_fetch_assoc($res_NotIn)) { ?>
                            <div class="exercItem">
                                <div class="row-top">
                                    <label>
                                        <input type="checkbox" class="chk-add" name="new_exerc[]"
                                            value="<?php echo $rowNot['id_exercicio']; ?>">
                                        <?php echo "<span class='nomeExerc'>" . $rowNot['nome'] . "</span>"; ?>
                                    </label>
                                </div>
                                <div class="row-inputs hidden">
                                    <label>Séries:
                                        <input type="number" name="series_new[<?php echo $rowNot['id_exercicio']; ?>]" min="1">
                                    </label>
                                    <label>Repetições:
                                        <input type="number" name="repeticoes_new[<?php echo $rowNot['id_exercicio']; ?>]" min="1">
                                    </label>
                                    <label>Carga:
                                        <input type="number" name="carga_new[<?php echo $rowNot['id_exercicio']; ?>]" min="1">
                                    </label>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="btns">
                        <button type="submit" class="submit">Editar Treino</button>
                        <button type="button" onclick="closeModal('edtTpro<?php echo $id_treino; ?>')"
                            class="closeModal">Fechar</button>
                    </div>
                </form>
            </div>
        </dialog>

        <?php
    }
}
?>

<style>
    .treino {
        background: #1d1c1c;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: .3s;
    }

    .treino:hover {
        transform: scale(1.007);
    }

    .treino h1 {
        font-size: 1.3em;
    }

    .treino h1 p {
        font-size: .7em;
        color: lightgray;
    }

    /* Modal */

    .exerc {
        display: flex;
        flex-direction: column;
        gap: 12px;
        padding: 10px;
        background: #0e0e0e71;
        border-radius: 8px;
        border: 1px solid #222;
        max-height: 250px;
        overflow-y: auto;
    }

    .exercRow {
        display: flex;
        flex-direction: column;
    }

    .exercRow:hover {
        background-color: #111;
    }

    .row-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .exercName {
        font-weight: 600;
        color: white;
    }

    .labelExerc {
        color: lightgray;
        font-size: 0.9em;
    }

    .hidden {
        display: none;
    }

    .row-inputs {
        margin-top: 10px;
        margin-left: 28px;
        border-left: 2px solid #444;
        padding-left: 10px;
    }

    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: translate(-50%, -50%) scale(0.8) rotate(-5deg);
        }

        50% {
            transform: translate(-50%, -50%) scale(1.05) rotate(2deg);
        }

        100% {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1) rotate(0deg);
        }
    }

    dialog.edtTpro {
        background: rgba(14, 17, 19, 0.85);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.6);
        padding: 0;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border: none;
        opacity: 0;
        width: 500px;
        max-width: 90vw;
        max-height: 90vh;
        color: white;
        overflow-x: hidden;
        z-index: 1000;
    }

    dialog.edtTpro[open] {
        opacity: 1;
        animation: fadeIn 0.4s ease forwards;
    }

    dialog.edtTpro:not([open]) {
        display: none;
    }

    dialog.edtTpro::backdrop {
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(2px);
    }

    /* Modal Content */
    .modal-content {
        padding: 20px;
    }

    .modal-content header {
        padding: 0;
        min-height: 0;
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
    }

    .modal-content h1 {
        font-size: 1.5em;
        margin: 0;
        padding: 0 0;
        font-weight: 500;
        color: white;
    }

    /* Form Elements */
    .edtTpro form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .edtTpro input[type="text"],
    .edtTpro input[type="number"] {
        padding: 9px 12px;
        border: 1px solid #222;
        background-color: #1d1b1b54;
        color: lightgray;
        width: 100%;
        font-size: 0.8em;
        border-radius: 7px;
        outline: none;
        transition: 0.3s;
        box-sizing: border-box;
    }

    .edtTpro input[type="text"]:focus,
    .edtTpro input[type="number"]:focus {
        color: white;
        border: 1px solid #FD5805;
        box-shadow: 0 0 8px #FD5805;
    }

    /* Fieldset */
    .edtTpro fieldset {
        border: 1px solid #444;
        border-radius: 8px;
        margin: 0;
        display: flex;
        justify-content: space-around;
        gap: 10px;
    }

    .edtTpro legend {
        color: white;
        font-size: 1em;
        padding: 0 10px;
        font-weight: 500;
    }

    .edtTpro fieldset label {
        display: flex;
        align-items: center;
        color: white;
        font-size: 0.9em;
        cursor: pointer;
    }

    /* File Upload */
    .file-upload-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        width: 100%;
    }

    .file-upload-label {
        padding: 12px 24px;
        background-color: #080808;
        color: white;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s;
        text-align: center;
        font-size: 1em;
        width: 100%;
        box-sizing: border-box;
    }

    .file-upload-label:hover {
        box-shadow: 0 0 10px 3px #333;
        background-color: #111;
    }

    #file-input {
        display: none;
    }

    .preview-box {
        width: 100%;
        max-width: 300px;
        height: 150px;
        border-radius: 4px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #111;
        border: 2px solid #333;
    }

    #image-preview {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    /* Buttons */
    .btns {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-top: 10px;
    }

    .btns button {
        flex: 1;
        padding: 12px 20px;
        font-size: 1em;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        font-weight: 500;
    }

    .submit {
        background: #FD5805;
        color: white;
    }

    .submit:hover {
        background: #ff6a1f;
        box-shadow: 0 0 12px #FD5805;
        transform: translateY(-1px);
    }

    .closeModal {
        background: #8B0000;
        color: white;
    }

    .closeModal:hover {
        background: #a30000;
        box-shadow: 0 0 10px 3px darkred;
        transform: translateY(-1px);
    }
</style>

<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);

        if (modal.tagName === 'DIALOG') {
            modal.showModal();

            const fileInput = modal.querySelector('input[type="file"]');
            const imagePreview = modal.querySelector('img[id^="image-preview-"]');

            if (fileInput && imagePreview) {
                fileInput.replaceWith(fileInput.cloneNode(true));
                const newFileInput = modal.querySelector('input[type="file"]');

                newFileInput.addEventListener("change", function () {
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
        } else {
            const overlay = document.getElementById('modalOverlay') || createOverlay();
            modal.classList.add('modal-open');
            overlay.classList.add('active');
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);

        if (modal.tagName === 'DIALOG') {
            modal.close();
        } else {
            const overlay = document.getElementById('modalOverlay');
            modal.classList.remove('modal-open');
            if (overlay) overlay.classList.remove('active');
        }
    }

    function createOverlay() {
        const overlay = document.createElement('div');
        overlay.id = 'modalOverlay';
        overlay.className = 'modal-overlay';
        overlay.onclick = function () {
            document.querySelectorAll('.modal-open').forEach(modal => {
                modal.classList.remove('modal-open');
            });
            overlay.classList.remove('active');
        };
        document.body.appendChild(overlay);
        return overlay;
    }

    document.querySelectorAll('.chk-add').forEach(chk => {
        chk.addEventListener('change', () => {
            const inputs = chk.closest('.exercItem').querySelector('.row-inputs');
            if (chk.checked) {
                inputs.classList.remove('hidden');
            } else {
                inputs.classList.add('hidden');
            }
        });
    });

    const searchInput = document.getElementById("searchExercTpro");
    searchInput.addEventListener("keyup", function () {
        const termo = this.value.toLowerCase();
        const itens = document.querySelectorAll(".exercItem");
        itens.forEach(item => {
            const nome = item.querySelector(".nomeExerc").textContent.toLowerCase();
            if (nome.includes(termo)) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
    });
</script>