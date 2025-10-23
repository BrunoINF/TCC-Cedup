<?php
include("Php/connection.php");
include("Php/verify.php");

$return = $_SESSION['back'];

$id_login = $_SESSION['cpf'];
$sql_Perfil = "SELECT * FROM Perfil WHERE cpf_usuario = '$id_login'";
$Perfil = mysqli_fetch_array(mysqli_query($id, $sql_Perfil));
$idPerfil = $Perfil['id_Perfil'];

$tipo = $_SESSION['tipo'];
if ($tipo == "ADM" || $tipo == "Supremo") {
  ?>

  <!DOCTYPE html>
  <html lang="pt-br">

  <head>
    <meta charset="UTF-8">
    <title>Painel ADM - TransformFit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Fim -->
    <!-- BootStrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Fim -->
    <link rel="stylesheet" href="Style/style-adm.css">
    <link rel="stylesheet" href="Style/style-assets.css">
    <link rel="stylesheet" href="Style/style-footer.css">
    <link rel="shortcut icon" href="Images/Logo.png" type="image/x-icon">
  </head>

  <body>
    <section class="body">

      <?php include("Modules/nav.php") ?>
      <div class="interface">
        <header class="header">
          <h1>Painel Administrativo <?php echo $return; ?></h1>
        </header>

        <div class="buttons">
          <button class="btn 
            <?php
            if (
              $return != "log" && $return != "exerc" &&
              $return != "pedido" && $return != "TreinoPro" || $return == "usuario"
            ) {
              echo "active";
            } else {

            }
            ?>
          " data-target="usuarios">Usuários</button>
          <button class="btn
            <?php
            if ($return == "exerc") {
              echo "active";
            } else {

            }
            ?>
          " data-target="exercicios">Exercícios</button>
          <button class="btn
            <?php
            if ($return == "pedido") {
              echo "active";
            } else {

            }
            ?>
          " data-target="pedidos">Pedidos</button>
          <button class="btn
            <?php
            if ($return == "TreinoPro") {
              echo "active";
            } else {

            }
            ?>
         " data-target="TreinoPro">Treinos Publicos</button>
          <?php
          $tipo = $_SESSION['tipo'];
          if ($tipo == "Supremo") { ?>
            <button class="btn
            <?php
            if ($return == "log") {
              echo "active";
            } else {

            }
            ?>
         " data-target="log">Log</button>
          <?php } ?>
        </div>

        <div class="adm-content">
          <div class="contents 
            <?php
            if (
              $return != "log" && $return != "exerc" &&
              $return != "pedido" && $return != "TreinoPro" || $return == "usuario"
            ) {
              echo "active";
            } else {

            }
            ?>
          " id="usuarios">
            <?php include("Modules/table_user.php"); ?>
          </div>

          <div class="contents
            <?php
            if ($return == "exerc") {
              echo "active";
            } else {

            }
            ?>
          " id="exercicios">
            <?php include("Modules/table_exerc.php"); ?>
          </div>

          <div class="contents
            <?php
            if ($return == "pedido") {
              echo "active";
            } else {

            }
            ?>
          " id="pedidos">
            <?php include("Modules/table_pedi.php"); ?>
          </div>

          <div class="contents
            <?php
            if ($return == "TreinoPro") {
              echo "active";
            } else {

            }
            ?>
          " id="TreinoPro">
            <?php include("Modules/public_training.php"); ?>
          </div>

          <div class="contents
            <?php
            if ($return == "log") {
              echo "active";
            } else {

            }
            ?>
          " id="log">
            <?php include("Modules/log.php"); ?>
          </div>

        </div>
      </div>
      <?php
      include("Modules/footer.php");
      ?>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      const btns = document.querySelectorAll('.btn');
      const contents = document.querySelectorAll('.contents');

      btns.forEach(btn => {
        btn.addEventListener('click', () => {
          btns.forEach(b => b.classList.remove('active'));
          contents.forEach(c => c.classList.remove('active'));
          btn.classList.add('active');
          document.getElementById(btn.dataset.target).classList.add('active');
        });
      });

      document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.adm-table th').forEach((th, index) => {
          document.querySelectorAll('.adm-table td:nth-child(' + (index + 1) + ')').forEach(td => {

            if (td.textContent.trim() !== '' && !td.hasAttribute('colspan')) {
              td.setAttribute('data-label', th.textContent);
            }
          });
        });
      });
    </script>

    <script src="Js/script-adm.js"></script>
  </body>

  </html>
  <?php
} else {
  echo "<script language='javascript'>
        alert('Então temos um betinha querendo burlar o sistema pare ou pague as consequencias com sua vida.')
        window.location.href='dashboard.php'; </script>";
}
?>