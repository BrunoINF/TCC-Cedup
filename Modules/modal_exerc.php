<?php
$modal_id = uniqid('modal_exerc_');
$abrir_id = 'abrirModalBtn_' . $modal_id;
$fechar_id = 'fecharModalBtn_' . $modal_id;
$exercicios = mysqli_query($id, "SELECT id_exercicio, nome FROM exercicio");
?>

<button id="<?= $abrir_id; ?>" class="btnAbrirModalExerc" type="button">Selecionar Exercícios</button>

<div id="<?= $modal_id; ?>" class="modal_exerc">
    <div class="modal_exerc-conteudo">
        <span class="fechar_exerc" id="<?= $fechar_id; ?>">×</span>
        <h2>Selecione os Exercícios</h2>
        <div class="lista-exercicios" id="listaExerc_<?= $modal_id; ?>">
            <?php while ($ex = mysqli_fetch_assoc($exercicios)) { ?>
                <div class="exercicio-item" style="margin-bottom: 15px;">
                    <label>
                        <input type="checkbox" name="exercicios[]" class="check exercicio-check"
                            value="<?= $ex['id_exercicio']; ?>" onchange="toggleCamposExtras(this)">
                        <span style="margin-left: 10px;" class="nome-exercicio"><?= $ex['nome']; ?></span>
                    </label>
                    <div class="campos-extras">
                        <input type="number" name="series[<?= $ex['id_exercicio']; ?>]" min="1" class="textExerc" placeholder="Número de séries">
                        <input type="number" name="repeticoes[<?= $ex['id_exercicio']; ?>]" min="1" class="textExerc" placeholder="Número de repetições">
                        <input type="number" name="carga[<?= $ex['id_exercicio']; ?>]" step="0.1" class="textExerc" placeholder="Carga (kg)">
                    </div>
                </div>
            <?php } ?>
        </div>
        <button type="button" class="btn_modal_exerc" onclick="confirmarExercicios_modal_exerc()">Confirmar</button>
    </div>
</div>

<script>
    (function () {
        const modalExerc = document.getElementById('<?= $modal_id; ?>');
        const abrirBtn = document.getElementById('<?= $abrir_id; ?>');
        const fecharBtn = document.getElementById('<?= $fechar_id; ?>');
        modalExerc.style.display = 'none';
        abrirBtn.addEventListener('click', () => {
            modalExerc.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
        fecharBtn.addEventListener('click', () => {
            modalExerc.style.display = 'none';
            document.body.style.overflowY = 'auto';
        });

        const searchInput = document.getElementById("searchExerc_<?= $modal_id; ?>");
        const listaExerc = document.getElementById("listaExerc_<?= $modal_id; ?>");
        searchInput.addEventListener("keyup", function () {
            const termo = this.value.toLowerCase();
            const itens = listaExerc.getElementsByClassName("exercicio-item");
            Array.from(itens).forEach(item => {
                const nome = item.querySelector(".nome-exercicio").textContent.toLowerCase();
                if (nome.includes(termo)) {
                    item.style.display = "block";
                } else {
                    item.style.display = "none";
                }
            });
        });
    })();
    function toggleCamposExtras(checkbox) {
        const camposExtras = checkbox.closest('div').querySelector('.campos-extras');
        if (checkbox.checked) {
            camposExtras.style.display = 'block';
        } else {
            camposExtras.style.display = 'none';
            const inputs = camposExtras.querySelectorAll('input');
            inputs.forEach(input => input.value = '');
        }
    }
    function confirmarExercicios_modal_exerc() {
        alert('Exercícios confirmados!');
        document.querySelector(".modal_exerc").style.display = 'none';
        document.body.style.overflow = 'auto';
    }
</script>

<style>
    .btnAbrirModalExerc {
        padding: 6px 12px;
        border: 2px solid #1d1b1b;
        background-color: transparent;
        color: white;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 1em;
        width: 100%;
        margin-top: 10px;
    }
    .btnAbrirModalExerc:hover {
        box-shadow: 0 0 10px 3px #222;
    }
    .textExerc {
        border: 1px solid #000000;
        background-color: #1d1b1b;
        color: white;
        width: 97.5%;
        padding: 5px;
        margin: 5px;
        border-radius: 3px;
        outline: none;
    }
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type="checkbox"] {
        appearance: none;
        -webkit-appearance: none;
        background-color: #1d1b1b;
        border: 2px solid #000000;
        padding: 7px;
        border-radius: 4px;
        display: inline-block;
        position: relative;
        cursor: pointer;
        transition: all 0.2s ease;
        order: 1;
        vertical-align: middle;
        margin-left: 5px;
    }
    input[type="checkbox"]:checked {
        background-color: #FFA500;
        border-color: rgba(200, 100, 0, 1);
    }
    input[type="checkbox"]:checked::after {
        content: "✔";
        color: white;
        font-size: 12px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .modal_exerc {
        position: fixed;
        z-index: 5;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .modal_exerc-conteudo {
        background: #0c0c0ce0;
        padding: 20px;
        border-radius: 8px;
        max-height: 80vh;
        width: 80%;
        max-width: 500px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        position: fixed;
        color: white;
    }
    .fechar_exerc {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 28px;
        cursor: pointer;
    }
    .lista-exercicios {
        max-height: 400px;
        overflow-y: auto;
        overflow-x: hidden;
        padding-right: 5px;
    }
    .lista-exercicios label {
        display: flex;
        align-items: center;
        padding: 5px;
        transition: all 0.3s;
    }
    .lista-exercicios label:hover {
        background-color: #0c0c0c;
        border-radius: 4px;
    }
    .campos-extras {
        display: none;
        margin-top: 10px;
        margin-left: 28px;
        border-left: 2px solid #444;
        padding-left: 10px;
    }
    .btn_modal_exerc {
        padding: 8px 16px;
        background-color: #0E1113;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 15px;
        width: 100%;
        font-size: 1em;
    }
    .btn_modal_exerc:hover {
        background-color: #444;
    }
    .search-bar {
        width: 100%;
        padding: 8px;
        margin: 12px 0;
        border: 1px solid #444;
        border-radius: 4px;
        background-color: #1d1b1b;
        color: white;
        font-size: 1em;
    }
    .search-bar:focus {
        outline: none;
        border-color: #FFA500;
    }
</style>
