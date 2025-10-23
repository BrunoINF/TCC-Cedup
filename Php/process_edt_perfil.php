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
    <title>Edição de usuario</title>

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

        .DeletePop {
            background: transparent !important;
            border: 1px solid greenyellow;
            font-weight: 600 !important;
            transition: 0.3s !important;

            &:hover {
                box-shadow: 0px 0px 10px greenyellow;
            }
        }
    </style>
</head>

<?php
include("connection.php");
include("verify.php");
$id_login = $_SESSION['cpf'];
$sql_Perfil = "SELECT * FROM Perfil WHERE cpf_usuario = '$id_login'";
$Perfil = mysqli_fetch_array(mysqli_query($id, $sql_Perfil));
$idPerfil = $Perfil['id_Perfil'];

$peso = $_POST['peso'];
$altura = $_POST['altura'];
$imc = round($peso / ($altura / 100 * $altura / 100), 2);

$sql = "UPDATE Perfil 
        SET peso = '$peso',
            altura = '$altura',
            imc = '$imc'
        WHERE cpf_usuario = $id_login";

if (mysqli_query($id, $sql)) {
    $sql_history = "INSERT INTO historico (id_perfil, peso, altura, imc) 
                   VALUES ('$idPerfil', '$peso', '$altura', '$imc')";
    $res_history = mysqli_query($id, $sql_history);
    ?>

    <body>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                title: "Perfil editado com sucesso!",
                icon: "success",
                denyButtonText: "Cancelar",
                background: "#0C0E11",
                color: "#fff",
                confirmButtonText: "Voltar",
                customClass: {
                    confirmButton: 'DeletePop',
                }
            }).then(() => {
                window.location.href = '../user.php'
            });
        </script>
    </body>

    <?php
    exit();
} else {
    $error = mysqli_error($id);
    ?>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                title: "Erro ao editar perfil!",
                icon: "warning",
                denyButtonText: "Cancelar",
                background: "#0C0E11",
                color: "#fff",
                confirmButtonText: "Voltar",
                customClass: {
                    confirmButton: 'DeletePop',
                }
            }).then(() => {
                window.location.href = '../user.php'
            });
        </script>
    </body>

    <?php
    exit();
}
?>