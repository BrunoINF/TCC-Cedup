<?php
include('connection.php');
include("verify.php");

$_SESSION['back'] = "TreinoPro";

$cpfLogado = $_SESSION['cpf'];

$resPerfil = mysqli_query($id, "SELECT id_Perfil FROM perfil WHERE cpf_usuario = '$cpfLogado'");
$perfil = mysqli_fetch_assoc($resPerfil);
$id_login = $perfil['id_Perfil'];

$resUsuario = mysqli_query($id, "SELECT email FROM usuario WHERE cpf = '$cpfLogado'");
$usuarioLogado = mysqli_fetch_assoc($resUsuario);
$emailADM = $usuarioLogado['email'];

$PerfilAdm = mysqli_fetch_assoc(mysqli_query($id, "SELECT id_perfil FROM perfil WHERE cpf_usuario =" . $cpfLogado));

$id_treino = $_GET['id_treino'];

$sqlNome = "SELECT nome FROM treino_pronto WHERE id_treino = $id_treino";
$nome = mysqli_fetch_assoc(mysqli_query($id, $sqlNome));

if($nome){
$sql = "Delete from treino_pronto where id_treino =" . $id_treino;
$res = mysqli_query($id, $sql);
}

if ($res) {
    mysqli_query($id, "INSERT INTO logs (id_perfil, acao, detalhes) 
                   VALUES (" . $PerfilAdm['id_perfil'] . ", 'Deletar de Treino Pronto', 'O administrador $emailADM deletou o treino pronto ".$nome['nome']."')");

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
        <!-- Fim -->
        <link rel="shortcut icon" href="../Images/Logo.png" type="image/x-icon">
        <title>Deletado com sucesso</title>
    </head>

    <body>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                title: "Treino deletado com sucesso!",
                icon: "success",
                denyButtonText: "Cancelar",
                background: "#0C0E11",
                color: "#fff",
                confirmButtonText: "Voltar",
                customClass: {
                    confirmButton: 'DeletePop',
                }
            }).then(() => {
                window.location.href = '../admPag.php'
            });
        </script>

        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: "Poppins", sans-serif;
            }

            body {
                background-color: #0B0E0F;
            }

            .CancelPop {
                background: transparent !important;
                border: 1px solid gray;
                font-weight: 600 !important;
                transition: 0.3s !important;

                &:hover {
                    box-shadow: 0px 0px 10px gray;
                }
            }

            .DeletePop {
                background: transparent !important;
                border: 1px solid red;
                font-weight: 600 !important;
                transition: 0.3s !important;

                &:hover {
                    box-shadow: 0px 0px 10px red;
                }
            }
        </style>
    </body>

    </html>

    <?php

} else {
    echo "<script language='javascript'>
        alert('Erro ao deletar treino!')
        window.location.href='training.php'; </script>";
}
?>