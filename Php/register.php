<?php  
include('connection.php');
session_start();

$login = $_POST['email'];
$senha = $_POST['password'];
$cpf = $_POST['cpf'];

$peso = $_POST['peso'];
$altura = $_POST['altura'];
$sexo = $_POST['sexo'];

$altura_m = $altura / 100;
$imc = $peso / ($altura_m * $altura_m);

function validar_cpf($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    for ($t = 9; $t < 11; $t++) {
        $soma = 0;
        for ($c = 0; $c < $t; $c++) {
            $soma += $cpf[$c] * (($t + 1) - $c);
        }
        $digito = ((10 * $soma) % 11) % 10;
        if ($cpf[$c] != $digito) {
            return false;
        }
    }
    return true;
}

if (!validar_cpf($cpf)) {
    $_SESSION['login_error'] = "Cpf invalido!";
    header("Location: ../register.php");
    exit();
}

    $sql = "INSERT INTO usuario (email, senha, cpf, tipo)
            VALUES ('".$login."', '".md5($senha)."', '".$cpf."', 'Usuario')";
    $ret = mysqli_query($id, $sql);

if ($ret) {
    $_SESSION['id_login'] = $cpf;
    $_SESSION['tipo'] = "Perfil  ";

    $sql_Perfil = "INSERT INTO Perfil (cpf_usuario, peso, altura, sexo, imc, tempo_Treino)
        VALUES ('".$cpf."', ".$peso.", ".$altura.", '".$sexo."', ".$imc.", '00:00:00')";
        echo $sql_Perfil;
    $res_Perfil = mysqli_query($id, $sql_Perfil);

    header("Location: ../dashboard.php");
    exit();
} else {
    echo "<script language='javascript'>alert('Erro ao cadastrar usuário. Tente novamente mais tarde!');</script>";
}
?>
