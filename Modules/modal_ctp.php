<button onclick="openModal('CTModal')" class="add">Criar Treino</button>

<div id="CTModal" class="modal">
    <div class="modal-content">
        <header>
            <h1>Criar treino Pronto</h1>
        </header>
        <form action="Php/process_create_trainingP.php" method="post">
            <input type="text" name="name" placeholder="Nome do Treino" required>

            <fieldset>
                <legend>Grupo Muscular</legend>
                <label>
                    <input type="checkbox" name="type[]" id="b" value="Braço">
                    <h2 for="b" class="lab">Braço</h2>
                </label>

                <label>
                    <input type="checkbox" name="type[]" id="p" value="Peito">
                    <span class="lab">Peito</span>
                </label>

                <label>
                    <input type="checkbox" name="type[]" id="o" value="Ombro">
                    <span class="lab">Ombro</span>
                </label>

                <label>
                    <input type="checkbox" name="type[]" id="c" value="Costas">
                    <span class="lab">Costas</span>
                </label>

                <label>
                    <input type="checkbox" name="type[]" id="pn" value="Perna">
                    <span class="lab">Perna</span>
                </label>
            </fieldset>

            <?php include("Modules/modal_exerc.php"); ?>

            <div class="btns">
                <button type="submit" class="submit">Criar Treino</button>
                <button type="button" onclick="closeModal('CTModal')" class="closeModal">Fechar</button>
            </div>
        </form>
    </div>
</div>