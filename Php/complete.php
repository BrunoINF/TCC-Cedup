<?php
include('connection.php');
include("verify.php");

$id_login = $_SESSION['cpf'];
$tempo = intval($_POST['tempo']);

$id_user = mysqli_fetch_array(mysqli_query($id, "SELECT * FROM Perfil WHERE cpf_usuario =" . $id_login));

$id_treino = $_GET['treino'];
$tipo = $_GET['tipo'];
$sql = "INSERT INTO treino_concluido (id_treino, id_Perfil, tipo) VALUES (" . $id_treino . ", " . $id_user['id_Perfil'] . ", '" . $tipo . "');";
if (mysqli_query($id, $sql)) {
    $_SESSION['complete'] = "C";
    header("Location: ../complete.php");
} else {
    echo "<script>
                alert('" . mysqli_error($id) . "');
                window.location.href = '../dashboard.php';
            </script>";

}
?>