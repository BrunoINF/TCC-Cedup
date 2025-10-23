<?php
include('connection.php');
include('verify.php');

$_SESSION['back'] = null;

$id_usuario = $_GET['cpf'];
$id_login = $_SESSION['cpf'];

$query_email = "SELECT email FROM usuario WHERE cpf = '$id_usuario'";
$result_email = mysqli_query($id, $query_email);

$PerfilAdm = mysqli_fetch_assoc(mysqli_query($id, "SELECT id_Perfil FROM perfil WHERE cpf_usuario= '$id_login'"));

if (mysqli_num_rows($result_email) > 0) {
    $emailAdm = mysqli_fetch_assoc($result_email);

    $sql_update = "UPDATE usuario SET tipo = 'ADM' WHERE cpf = '$id_usuario'";
    $res = mysqli_query($id, $sql_update);

    if ($res) {

        $query_admin = "SELECT email FROM usuario WHERE cpf = '$id_login'";
        $result_admin = mysqli_query($id, $query_admin);
        $admin = mysqli_fetch_assoc($result_admin);

        $sql_log = "INSERT INTO logs (acao, detalhes, id_Perfil) 
                    VALUES ('Promoção', 'O usuário {$admin['email']} promoveu o usuário {$emailAdm['email']} a ADM', '" . $PerfilAdm['id_Perfil'] . "')";
        mysqli_query($id, $sql_log);

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
            <title>Promovido com sucesso</title>
        </head>

        <body>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    title: "Usaurio promovido a ADM com sucesso!",
                    icon: "success",
                    denyButtonText: "Cancelar",
                    background: "#0C0E11",
                    color: "#fff",
                    confirmButtonText: "Voltar",
                    customClass: {
                        confirmButton: 'ConfirmPop',
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

                .ConfirmPop {
                    background: transparent !important;
                    border: 1px solid greenyellow;
                    font-weight: 600 !important;
                    transition: 0.3s !important;

                    &:hover {
                        box-shadow: 0px 0px 10px greenyellow;
                    }
                }
            </style>
        </body>

        </html>

        <?php
    } else {
        echo "<script>
            alert('Erro ao promover usuário!');
            window.location.href = '../admPag.php';
        </script>";
    }
}
?>