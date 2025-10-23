<?php
include("Php/connection.php");
include("Php/verify.php");
$return = $_SESSION['back'];

$id_login = $_SESSION['cpf'];
$sql_usuario = "SELECT * FROM usuario WHERE cpf ='" . $id_login . "'";
$usuario = mysqli_fetch_array(mysqli_query($id, $sql_usuario));
$sql_Perfil = "SELECT * FROM Perfil WHERE cpf_usuario = '$id_login'";
$Perfil = mysqli_fetch_array(mysqli_query($id, $sql_Perfil));
$idPerfil = $Perfil['id_Perfil'];

$sql_respondidos = "SELECT * FROM pedido_treino 
                    WHERE id_Perfil = $idPerfil and status ='aprovado' ORDER BY criado_em DESC;";
$res_respondidos = mysqli_query($id, $sql_respondidos);

$sql_pendentes = "SELECT * FROM pedido_treino 
                  WHERE id_Perfil = $idPerfil AND status = 'pendente'";
$res_pendentes = mysqli_query($id, $sql_pendentes);
?>

<!DOCTYPE html>
<html lang="pt-Br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link rel="stylesheet" href="Style/style-user.css">
    <link rel="stylesheet" href="Style/style-assets.css">
    <link rel="stylesheet" href="Style/style-footer.css">
    <link rel="shortcut icon" href="Images/Logo.png" type="image/x-icon">

    <title>Usuario</title>
</head>

<body>
    <section class="body">
        <?php include("Modules/nav.php") ?>
        <div class="interface">
            <header class="header">
                <h1>
                    Painel de Perfil
                </h1>
            </header>

            <div class="btn-perfil-top">
                <button class="btn 
                <?php
                if ($return != "solicitacao") {
                    echo "active";
                } else {

                }
                ?>
                " data-target="perfil">Perfil</button>
                <button class="btn
                <?php
                if ($return == "solicitacao") {
                    echo "active";
                } else {

                }
                ?>
                " data-target="solicitacoes">Solicitações</button>
                <button class="btn" data-target="history">Historico de Progreção</button>
            </div>

            <section class="contents 
            <?php
            if ($return != "solicitacao") {
                echo "active";
            } else {

            }
            ?>
            " id="perfil">
                <?php include("Modules/profile.php"); ?>

            </section>

            <section class="contents
            <?php
            if ($return == "solicitacao") {
                echo "active";
            } else {

            }
            ?>
            " id="solicitacoes">
                <?php include("Modules/requests_training.php"); ?>

            </section>

            <section class="contents" id="history">
                <?php include("Modules/history.php"); ?>
                <?php
                include("Modules/footer.php");
                ?>
            </section>

        </div>
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
    </script>
    <script>
        function deletRequest(id_pedido) {
            Swal.fire({
                title: "Deletar solicitação?",
                text: "Deseja realmente deletar o historico de sua solicitação?",
                icon: "warning",
                showDenyButton: true,
                confirmButtonText: "Deletar",
                denyButtonText: "Cancelar",
                background: "#0C0E11",
                color: 'white',
                customClass: {
                    confirmButton: 'DeletePop',
                    denyButton: 'CancelPop',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "Php/delete_request.php?id_pedido=" + encodeURIComponent(id_pedido);
                }
            });
        }
    </script>
</body>

</html>