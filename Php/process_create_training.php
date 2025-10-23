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
    <title>Treino criado com sucesso</title>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: "Treino criado com sucesso!",
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
    </style>
</body>

</html>

<?php
include("connection.php");
include("verify.php");

$id_login = $_SESSION['cpf'];
$sql_usuario = "SELECT * FROM usuario WHERE cpf =" . $id_login;
$usuario = mysqli_fetch_array(mysqli_query($id, $sql_usuario));
$sql_Perfil = "SELECT * FROM Perfil WHERE cpf_usuario = '$id_login'";
$Perfil = mysqli_fetch_array(mysqli_query($id, $sql_Perfil));
$idPerfil = $Perfil['id_Perfil'];

$duracaoTotalSegundos = 0;
$exercicios = mysqli_query($id, "SELECT id_exercicio, nome FROM exercicio");

$nome = $_POST['name'];
$tipo = $_POST['type'];
$arquivo = $_FILES['image'];
$tmpPath = $arquivo['tmp_name'];
$imagemDados = addslashes(file_get_contents($tmpPath));
$tipo_str = is_array($tipo) ? implode(", ", $tipo) : $tipo;

$sql_treino = "INSERT INTO treino_personalizado (nome, grupo_muscular, Imagem, id_Perfil) 
               VALUES ('$nome', '$tipo_str', '$imagemDados', $idPerfil)";


if (mysqli_query($id, $sql_treino)) {
    $id_treino = mysqli_insert_id($id);
} else {
    echo "<script>alert('Erro ao criar treino: " . mysqli_error($id) . "');</script>";
}

$exerciciosSelecionados = $_POST['exercicios'];
foreach ($exerciciosSelecionados as $idExercicio) {
    $series = null;
    $repeticoes = null;
    $carga = null;

    $series = $_POST['series'][$idExercicio];
    $repeticoes = $_POST['repeticoes'][$idExercicio];
    $carga = $_POST['carga'][$idExercicio];

    $sqlTempo = "SELECT TIME_TO_SEC(tempo_execucao) as tempo_segundos FROM exercicio WHERE id_exercicio = $idExercicio";
    $resTempo = mysqli_query($id, $sqlTempo);
    $tempoExercicio = mysqli_fetch_assoc($resTempo)['tempo_segundos'];

    $duracaoTotalSegundos += $tempoExercicio * $series * $repeticoes;


    $sqlEx = "INSERT INTO  treino_personalizado_exercicio (id_exercicio, id_treino, series, repeticoes, carga)
            VALUES ($idExercicio, $id_treino, $series, $repeticoes, $carga)";

    if (mysqli_query($id, $sqlEx)) {

    } else {
        echo "<script>alert('Erro ao inserir exercício: " . mysqli_error($id) . "');</script>";
    }
}

$duracaoFormatada = gmdate("H:i:s", $duracaoTotalSegundos);
$duracaoTotalSegundos = round($duracaoTotalSegundos / 60) * 60;
$sqlUpdate = "UPDATE treino_personalizado 
              SET duracao = '$duracaoFormatada' 
              WHERE id_treino = $id_treino";
$res = mysqli_query($id, $sqlUpdate);
?>