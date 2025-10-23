<?php
include("connection.php");
include("verify.php");

$id_login = $_SESSION['cpf'];
$sql_Perfil = "SELECT * FROM Perfil WHERE cpf_usuario = '$id_login'";
echo $sql_Perfil;
$Perfil = mysqli_fetch_array(mysqli_query($id, $sql_Perfil));
$idPerfil = $Perfil['id_Perfil'];

$mensagem = $_POST['msg'];

$sql = "INSERT INTO pedido_treino (id_Perfil, mensagem) VALUES ('$idPerfil', '$mensagem')";

if (mysqli_query($id, $sql)) {
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
    <title>Deletado com sucesso</title>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: "Pedido feito com sucesso!",
            text: "Mensagem enviada a resposta pode vir a demorar",
            icon: "success",
            denyButtonText: "Cancelar",
            background: "#0C0E11",
            color: "#fff",
            confirmButtonText: "Voltar",
            customClass: {
                confirmButton: 'ConfirmPop',
            }
        }).then(() => {
            window.location.href = '../dashboard.php'
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

        .ConfirmPop {
            background: transparent !important;
            border: 1px solid greenyellow;
            font-weight: 600 !important;
            transition: 0.3s !important;

            &:hover {
                box-shadow: 0px 0px 10px greenyellow;
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
    <title>Deletado com sucesso</title>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: "Pedido feito com sucesso!",
            text: "Falha ao enviar mensagem tentar novamente mais tarde",
            icon: "warning",
            denyButtonText: "Cancelar",
            background: "#0C0E11",
            color: "#fff",
            confirmButtonText: "Voltar",
            customClass: {
                confirmButton: 'ConfirmPop',
            }
        }).then(() => {
            window.location.href = '../dashboard.php'
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

        .ConfirmPop {
            background: transparent !important;
            border: 1px solid greenyellow;
            font-weight: 600 !important;
            transition: 0.3s !important;

            &:hover {
                box-shadow: 0px 0px 10px greenyellow;
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
}
?>