<div class="solicitacoes">
  <div class="respondidos">
    <h1>Solicitações respondidas</h1>

    <?php if (mysqli_num_rows($res_respondidos) > 0) { ?>
      <?php while ($linha = mysqli_fetch_assoc($res_respondidos)) { ?>
        <div class="solicitacao">
          <div class="text">
            <div class="my">
              <span class="limite-texto"><?php echo "Eu: " . $linha['mensagem']; ?></span>
            </div>
            <div class="adm">
              <span><?php echo "Resposta: " . $linha['Resposta_ADM']; ?></span>
            </div>
          </div>
          <div class="delet">
            <button class="btnDelet" onclick="deletRequest(<?php echo $linha['id_pedido']; ?>)" href="Php/delete_request.php?id_pedido=<?php echo $linha['id_pedido']; ?>'"><i class="bi bi-trash"></i></button>
          </div>
        </div>
      <?php } ?>

    <?php } else { ?>
      <p style="color: gray;">Nenhuma solicitação respondida até o momento.</p>
    <?php } ?>
  </div>

  <div class="pendentes">
    <h1>Solicitações pendentes</h1>

    <?php if (mysqli_num_rows($res_pendentes) > 0) { ?>
      <?php while ($linha = mysqli_fetch_assoc($res_pendentes)) { ?>
        <div class="solicitacao">
          <div class="my">
            <span class="limite-texto"><?php echo htmlspecialchars($linha['mensagem']); ?></span>
          </div>
        </div>
      <?php } ?>
    <?php } else { ?>
      <p style="color: gray;">Nenhuma solicitação pendente no momento.</p>
    <?php } ?>
  </div>
</div>
