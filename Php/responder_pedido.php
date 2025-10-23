<?php
include("connection.php");
session_start();

$cpfLogado = $_SESSION['cpf'];

$resPerfil = mysqli_query($id, "SELECT id_Perfil FROM perfil WHERE cpf_usuario = '$cpfLogado'");
$perfil = mysqli_fetch_assoc($resPerfil);
$id_login = $perfil['id_Perfil'];

$resUsuario = mysqli_query($id, "SELECT email FROM usuario WHERE cpf = '$cpfLogado'");
$usuarioLogado = mysqli_fetch_assoc($resUsuario);
$emailADM = $usuarioLogado['email'];

$resposta = $_POST['res'];
$id_pedido = $_POST['id_pedido'];

$PerfilAdm = mysqli_fetch_assoc(mysqli_query($id, "SELECT id_perfil FROM perfil WHERE cpf_usuario =" . $cpfLogado));

$resPerfil = mysqli_fetch_assoc(mysqli_query($id, "SELECT id_perfil FROM pedido_treino WHERE id_pedido=" . $id_pedido));

$resCpf = mysqli_fetch_assoc(mysqli_query($id, "SELECT cpf_usuario FROM perfil WHERE id_perfil=" . $resPerfil['id_perfil']));

$info = mysqli_fetch_assoc(mysqli_query($id, "SELECT * FROM usuario WHERE cpf= '" . $resCpf['cpf_usuario'] . "'"));

$emailPedido = $info['email'];

$sql = "UPDATE pedido_treino SET Resposta_ADM = '" . $resposta . "', status='aprovado' WHERE id_pedido=" . $id_pedido;

if (mysqli_query($id, $sql)) {
    $sql_log = "INSERT INTO logs (id_perfil, acao, detalhes)
                    VALUES (" . $PerfilAdm['id_perfil'] . ", 'Resposta a pedido', 'O administrador $emailADM respondeu o pedido do usuário $emailPedido')";
    mysqli_query($id, $sql_log);
    header("Location: ../admPag.php");
    exit();
} else {
    $error = mysqli_error($id);
    echo "<script>alert('Erro: $error'); window.location.href='../admPag.php';</script>";
    exit();
}
?>