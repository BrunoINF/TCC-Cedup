<h2>Pedidos de Treino</h2>
<?php
$sql_pedidos = "SELECT * FROM pedido_treino WHERE status = 'pendente' ORDER BY criado_em DESC";
$res_pedidos = mysqli_query($id, $sql_pedidos);
$contlinha = mysqli_num_rows($res_pedidos);
if ($contlinha > 0) {
    while ($linha = mysqli_fetch_assoc($res_pedidos)) {
        $sql_pedinte = "SELECT * FROM perfil WHERE id_perfil =" . $linha['id_Perfil'];
        $res_pedintes = mysqli_fetch_array(mysqli_query($id, $sql_pedinte));

        $sql_pedinte = "SELECT * FROM USUARIO WHERE CPF ='" . $res_pedintes['cpf_usuario']."'";
        $res_pedinte = mysqli_fetch_array(mysqli_query($id, $sql_pedinte));
        ?>
        <div class="pedido">
            <?php
            echo '<span id="mensagemPedido">' . $res_pedinte['email'] . ': <p id="msg"> ' . $linha['mensagem'] . '</p></span>';
            ?>

            <form action='Php/responder_pedido.php' method='post'>
                <input type='hidden' name='id_pedido' value='<?php echo $linha['id_pedido']; ?>'>
                <textarea id="resposta" name="res" style="resize: none;" required></textarea>
                <div class="buttons_pedido">
                    <button onclick="gerarSugestao()" class="btn-sugerir" type="button">Gerar resposta</button>
                    <button type="button" class="btn-treino" onclick="addTreino()" id="btnAddTreino">Adicionar Treino</button>
                    <button class='btn-action' type='submit'>Responder</button>
                    <button class='btn-remove' type='button'
                        onclick="window.location.href='Php/delete_request.php?id_pedido=<?php echo $linha['id_pedido']; ?>'">Excluir</button>
                </div>
            </form>
        </div>

        <div id="modalSolicitacao" class="modalSolicitacaoTreino">
            <header>
                <h2>Adicionar treino Treino</h2>
            </header>
            <form method="POST" action="Php/process_trainingRequest.php">
                <input type='hidden' name='id_pedido' value='<?php echo $linha['id_pedido']; ?>'>
                <input type="hidden" name="id" value="<?php echo $linha['id_Perfil']; ?>">
                <label for="nomeTreino">Nome do treino:</label>
                <input type="text" id="nomeTreino" name="nome" required><br>

                <fieldset>
                    <legend>Grupo Muscular</legend>
                    <label class="lab">
                        <input type="checkbox" name="type[]" id="b" value="Braço">
                        <label for="b" class="lab">Braço</label></label>

                    <label class="lab">
                        <input type="checkbox" name="type[]" id="p" value="Peito">
                        <label for="p" class="lab">Peito</label></label>

                    <label class="lab">
                        <input type="checkbox" name="type[]" id="o" value="Ombro">
                        <label for="o" class="lab">Ombro</label></label>

                    <label class="lab">
                        <input type="checkbox" name="type[]" id="c" value="Costas">
                        <label for="c" class="lab">Costas</label></label>

                    <label class="lab">
                        <input type="checkbox" name="type[]" id="pn" value="Perna">
                        <label for="pn" class="lab">Perna</label></label>
                </fieldset>

                <?php include("modal_exerc.php"); ?>

                <div class="btns">
                    <button type="submit" class="btn-submit">Salvar</button>
                    <button type="button" class="closeSolicitao">Fechar</button>
                </div>
            </form>
        </div>
    <?php }
} else {
    echo "<p style='color: gray;'>Nenhum pedido encontrado até o momento.</p>";
}
?>

<script src="Js/script-sugestao.js"></script>
<script>
    const modal = document.getElementById("modalSolicitacao");
    const btn = document.getElementById("btnAddTreino");
    const span = document.querySelector(".closeSolicitao");

    btn.onclick = () => {
        modal.style.display = "flex";
    };

    span.onclick = () => {
        modal.style.display = "none";
    };

    window.onclick = (event) => {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };
</script>