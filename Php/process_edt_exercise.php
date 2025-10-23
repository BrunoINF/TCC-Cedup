<?php
include("connection.php");
session_start();

$_SESSION['back'] = "exerc";

$id_exercicio = $_POST['id'];
$nome = $_POST['name'];
$obs =  $_POST['obs'];
$tempo_exec = intval($_POST['temp_exe']); 
$grupos = $_POST['type'] ?? [];
$arquivo = $_FILES['img'] ?? null; 

$grupo_str = is_array($grupos) ? implode(", ", $grupos) : (string)$grupos;

$sql = "UPDATE exercicio 
        SET nome = '$nome',
            grupo_muscular = '$grupo_str',
            observacoes = '$obs',
            tempo_execucao = '00:00:$tempo_exec' 
        WHERE id_exercicio = $id_exercicio";

if ($arquivo && $arquivo['error'] === UPLOAD_ERR_OK) {
    $tmpPath = $arquivo['tmp_name'];
    $imagemDados = mysqli_real_escape_string($id, file_get_contents($tmpPath));
    $sql = "UPDATE exercicio 
            SET nome = '$nome',
                grupo_muscular = '$grupo_str',
                observacoes = '$obs',
                tempo_execucao = '00:00:$tempo_exec',
                imagem  = '$imagemDados'
            WHERE id_exercicio = $id_exercicio";
}

if (mysqli_query($id, $sql)) {
    
    $cpfLogado = $_SESSION['cpf'];

    $resPerfil = mysqli_query($id, "SELECT id_Perfil FROM perfil WHERE cpf_usuario = '$cpfLogado'");
    $perfil = mysqli_fetch_assoc($resPerfil);
    $id_login = $perfil['id_Perfil'];

    $resUsuario = mysqli_query($id, "SELECT email FROM usuario WHERE cpf = '$cpfLogado'");
    $usuarioLogado = mysqli_fetch_assoc($resUsuario);
    $emailADM = $usuarioLogado['email'];

    mysqli_query($id, "INSERT INTO logs (id_perfil, acao, detalhes) 
                       VALUES ('$id_login', 'Edição de Exercício', 'o usuário $emailADM editou o exercício $nome')");

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
    <title>Editado com sucesso</title>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: "Exercicio editado com sucesso!",
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
    exit();
} else {
    $error = mysqli_error($id);
    echo "<script>alert('Erro: $error'); window.location.href='../admPag.php';</script>";
    exit();
}
?>
