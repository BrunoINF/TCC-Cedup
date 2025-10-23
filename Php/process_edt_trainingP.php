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
            title: "Treino editado com sucesso!",
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
include("connection.php");
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

$id_login = $_SESSION['cpf'];
$sql_usuario = "SELECT * FROM usuario WHERE cpf = '$id_login'";
$usuario = mysqli_fetch_array(mysqli_query($id, $sql_usuario));

$sql_Perfil = "SELECT * FROM Perfil WHERE cpf_usuario = '$id_login'";
$Perfil = mysqli_fetch_array(mysqli_query($id, $sql_Perfil));
$idPerfil = $Perfil['id_Perfil'];

$duracaoTotalSegundos = 0;

$id_treino = $_POST["id"];
$nome = mysqli_real_escape_string($id, $_POST['name'] ?? '');
$tipo = $_POST['type'] ?? [];
$arquivo = $_FILES['image'] ?? null;

$tipo_str = is_array($tipo) ? implode(", ", $tipo) : $tipo;

$imagemUpdate = "";
if ($arquivo && !empty($arquivo['tmp_name'])) {
    $tmpPath = $arquivo['tmp_name'];
    $imagemDados = addslashes(file_get_contents($tmpPath));
    $imagemUpdate = ", imagem = '$imagemDados'";
}

$sql_treino = "UPDATE treino_pronto 
               SET nome = '$nome',
                   grupo_muscular = '$tipo_str'
                   $imagemUpdate
               WHERE id_treino = $id_treino";

if (!mysqli_query($id, $sql_treino)) {
    die("Erro ao atualizar treino: " . mysqli_error($id));
}

if (!empty($_POST['delete_exerc'])) {
    foreach ($_POST['delete_exerc'] as $idExercicio) {
        $idExercicio = (int) $idExercicio;
        $sqlDel = "DELETE FROM treino_pronto_exercicio 
                   WHERE id_treino = $id_treino 
                     AND id_exercicio = $idExercicio";
        mysqli_query($id, $sqlDel);
    }
}

// Atualizar exercícios existentes
$idExercicios = $_POST['id_exerc'] ?? [];
foreach ($idExercicios as $idExercicio) {
    $idExercicio = (int) $idExercicio;

    $series = (int) ($_POST['series' . $idExercicio] ?? 0);
    $reps = (int) ($_POST['repeticoes' . $idExercicio] ?? 0);
    $carga = (float) ($_POST['carga' . $idExercicio] ?? 0);

    $sql = "UPDATE treino_pronto_exercicio
            SET series = $series, repeticoes = $reps, carga = $carga
            WHERE id_treino = $id_treino AND id_exercicio = $idExercicio";
    mysqli_query($id, $sql);

    $sqlTempo = "SELECT TIME_TO_SEC(tempo_execucao) as tempo_segundos 
                 FROM exercicio 
                 WHERE id_exercicio = $idExercicio";
    $resTempo = mysqli_query($id, $sqlTempo);
    if ($resTempo && mysqli_num_rows($resTempo) > 0) {
        $tempoExercicio = (int) mysqli_fetch_assoc($resTempo)['tempo_segundos'];
        $duracaoTotalSegundos += $tempoExercicio * $series * $reps;
    }
}

// Inserir novos exercícios
if (!empty($_POST['new_exerc'])) {
    foreach ($_POST['new_exerc'] as $idExercicio) {
        $idExercicio = (int) $idExercicio;
        $series = (int) ($_POST['series_new'][$idExercicio] ?? 0);
        $reps = (int) ($_POST['repeticoes_new'][$idExercicio] ?? 0);
        $carga = (float) ($_POST['carga_new'][$idExercicio] ?? 0);

        $sqlInsertEx = "INSERT INTO treino_pronto_exercicio 
                        (id_exercicio, id_treino, series, repeticoes, carga)
                        VALUES ($idExercicio, $id_treino, $series, $reps, $carga)";
        mysqli_query($id, $sqlInsertEx);

        $sqlTempo = "SELECT TIME_TO_SEC(tempo_execucao) as tempo_segundos 
                     FROM exercicio 
                     WHERE id_exercicio = $idExercicio";
        $resTempo = mysqli_query($id, $sqlTempo);
        if ($resTempo && mysqli_num_rows($resTempo) > 0) {
            $tempoExercicio = (int) mysqli_fetch_assoc($resTempo)['tempo_segundos'];
            $duracaoTotalSegundos += $tempoExercicio * $series * $reps;
        }
    }
}

// Atualizar duração total do treino
$duracaoFormatada = gmdate("H:i:s", $duracaoTotalSegundos);
$sqlUpdateDuracao = "UPDATE treino_pronto 
                     SET duracao = '$duracaoFormatada' 
                     WHERE id_treino = $id_treino";
mysqli_query($id, $sqlUpdateDuracao);

$sqlLog = "INSERT INTO logs (id_perfil, acao, detalhes) 
                   VALUES (" . $PerfilAdm['id_perfil'] . ", 'Edição de Treino Publico', 'O usuário $emailADM editou o treino pronto " . $_POST['name'] . "')";

mysqli_query($id, $sqlLog);

exit;
?>