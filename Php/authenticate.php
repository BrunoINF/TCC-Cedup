<?php
include("connection.php");
session_start();

if(empty($_POST['email']) OR empty($_POST['password'])) {
    $_SESSION['login_error'] = "Email e senha devem ser preenchidos.";
    header("Location: ../login.php");
    exit();
} else {
    $password = md5($_POST['password']);
    $sql = "SELECT * FROM usuario WHERE email = '".$_POST['email']."'
                    AND senha = '".$password."'"; 
    $res = mysqli_query($id, $sql);
    $linha = mysqli_num_rows($res);

    if($linha > 0) {
        $user = mysqli_fetch_array($res);
        $_SESSION['cpf'] = $user['cpf'];
        $_SESSION['tipo'] = $user['tipo'];
        $_SESSION['back'] = null;
        header("Location: ../dashboard.php");
        exit();
    } else {
        $_SESSION['login_error'] = "Usuário ou senha incorretos!";
        header("Location: ../login.php");
        exit();
    }
}
?>