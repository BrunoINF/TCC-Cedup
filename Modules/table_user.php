<h2>Usuários</h2>

<input type="text" id="filtroTabelaUser" class="search" placeholder="Pesquisar na tabela...">

<table class="adm-table users-table" id="table_user">
  <tr>
    <th>CPF</th>
    <th>Email</th>
    <th>Senha</th>
    <th>Tipo</th>
    <th>Tornar ADM</th>
    <th>Bannir</th>
  </tr>

  <?php
  $sql_usuarios = "Select * from usuario";
  $res_usuarios = mysqli_query($id, $sql_usuarios);

  while ($linha = mysqli_fetch_array($res_usuarios)) { ?>

    <tr align="center">
      <td align="center"> <?php echo $linha['cpf']; ?> </td>
      <td align="center" data-label="Email"><?php echo $linha['email']; ?></td>
      <td align="center" data-label="Senha"><?php echo substr($linha['senha'], 0, 10) . '...'; ?></td>
      <td align="center"> <?php echo $linha['tipo']; ?></td>
      <?php if ($linha['tipo'] == "Supremo") { ?>
        <td>
          <button class="btn-action" disabled style="opacity: 0.4;">Promover</button>
        </td>
        </td>
        <td>
          <button class="btn-remove" disabled
            style="opacity: 0.4;">Bannir</button>
        </td>
      </tr>
      </tr><?php } elseif ($linha['tipo'] == "ADM") { ?>
      <td>
        <button class="btn-action" disabled style="opacity: 0.4;">Promover</button>
      </td>
      </td>
      <td>
        <button class="btn-remove" onclick="bannirUsuario('<?php echo $linha['cpf']; ?>')">Bannir</button>
      </td>
      </tr>
    <?php } else { ?>
      <td>
        <button class="btn-action"
          onclick="promoveUsuario('<?php echo $linha['cpf']; ?>')">Promover</button>
      </td>
      <td>
        <button class="btn-remove" onclick="bannirUsuario('<?php echo $linha['cpf']; ?>')"">Bannir</button>
      </td>
      </tr>
    <?php }
  } ?>

</table>

<script>
  document.getElementById("filtroTabelaUser").addEventListener("keyup", function () {
    let filtro = this.value.toLowerCase();
    let linhas = document.querySelectorAll("#table_user tr");

    linhas.forEach(linha => {
      let textoLinha = linha.textContent.toLowerCase();
      linha.style.display = textoLinha.includes(filtro) ? "" : "none";
    });
  });
</script>