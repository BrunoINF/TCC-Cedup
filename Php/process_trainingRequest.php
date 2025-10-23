<?php
include("connection.php");
include("verify.php");

$idPerfil = $_POST["id"];
$idPedido = $_POST["id_pedido"];

$duracaoTotalSegundos = 0;

$nome = $_POST['nome'];
$tipo = $_POST['type'];
$tipo_str = is_array($tipo) ? implode(", ", $tipo) : $tipo;

$sql_treino = "INSERT INTO treino_personalizado (nome, grupo_muscular, id_Perfil) 
               VALUES ('$nome', '$tipo_str', $idPerfil)";

if (mysqli_query($id, $sql_treino)) {
    $id_treino = mysqli_insert_id($id);
} else {
    echo "<script>alert('Erro ao criar treino: " . mysqli_error($id) . "');</script>";
    exit;
}

if (isset($_POST['exercicios']) && is_array($_POST['exercicios'])) {
    $exerciciosSelecionados = $_POST['exercicios'];
    
    foreach ($exerciciosSelecionados as $idExercicio) {
        $idExercicio = (int) $idExercicio;
        
        $series = isset($_POST['series'][$idExercicio]) ? (int) $_POST['series'][$idExercicio] : 0;
        $repeticoes = isset($_POST['repeticoes'][$idExercicio]) ? (int) $_POST['repeticoes'][$idExercicio] : 0;
        $carga = isset($_POST['carga'][$idExercicio]) ? (float) $_POST['carga'][$idExercicio] : 0;

        $sqlTempo = "SELECT TIME_TO_SEC(tempo_execucao) as tempo_segundos FROM exercicio WHERE id_exercicio = $idExercicio";
        $resTempo = mysqli_query($id, $sqlTempo);
        
        if ($resTempo && mysqli_num_rows($resTempo) > 0) {
            $tempoExercicio = mysqli_fetch_assoc($resTempo)['tempo_segundos'];
            $duracaoTotalSegundos += $tempoExercicio * $series * $repeticoes;
        }

        $sqlEx = "INSERT INTO treino_personalizado_exercicio (id_exercicio, id_treino, series, repeticoes, carga)
                  VALUES ($idExercicio, $id_treino, $series, $repeticoes, $carga)";
        
        if (!mysqli_query($id, $sqlEx)) {
            echo "<script>alert('Erro ao inserir exercício: " . mysqli_error($id) . "');</script>";
        }
    }
}

$duracaoFormatada = gmdate("H:i:s", $duracaoTotalSegundos);
$sqlUpdate = "UPDATE treino_personalizado 
              SET duracao = '$duracaoFormatada' WHERE ID_treino = " . $id_treino;
              
$resUpdate = mysqli_query($id, $sqlUpdate);

$cpfLogado = $_SESSION['cpf'];
$resPerfilAdm = mysqli_query($id, "SELECT id_Perfil FROM perfil WHERE cpf_usuario = '$cpfLogado'");
$perfilAdm = mysqli_fetch_assoc($resPerfilAdm);

$resUsuarioAdm = mysqli_query($id, "SELECT email FROM usuario WHERE cpf = '$cpfLogado'");
$usuarioAdm = mysqli_fetch_assoc($resUsuarioAdm);
$emailADM = $usuarioAdm['email'];

$resPerfilPedido = mysqli_fetch_assoc(mysqli_query($id, "SELECT id_perfil FROM pedido_treino WHERE id_pedido = $idPedido"));
$resCpfPedido = mysqli_fetch_assoc(mysqli_query($id, "SELECT cpf_usuario FROM perfil WHERE id_perfil = " . $resPerfilPedido['id_perfil']));
$infoPedido = mysqli_fetch_assoc(mysqli_query($id, "SELECT email FROM usuario WHERE cpf = '" . $resCpfPedido['cpf_usuario'] . "'"));
$emailPedido = $infoPedido['email'];

$sql_log = "INSERT INTO logs (id_perfil, acao, detalhes)
            VALUES (" . $perfilAdm['id_Perfil'] . ", 'Criação de treino', 
            'O administrador $emailADM criou um treino personalizado para o usuário $emailPedido com o nome $nome')";
mysqli_query($id, $sql_log);

$sqlAprove = mysqli_query($id, "UPDATE pedido_treino SET status='aprovado' WHERE id_pedido=" . $idPedido);

header("Location: ../admPag.php");
exit;
?>
