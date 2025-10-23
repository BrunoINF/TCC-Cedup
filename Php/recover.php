<?php
include ("connection.php");
session_start();

$email = $_POST['email'];
$sql = "SELECT * FROM usuario WHERE email = '".$_POST['email']."'"; 
    $res = mysqli_query($id, $sql);
    $linha = mysqli_num_rows($res);

if($linha > 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) {

$novasenha = substr(md5(time()), 0, length: 6);
$novasenhacript = md5($novasenha);

$sql = "UPDATE USUARIO SET SENHA = '$novasenhacript' WHERE EMAIL = '$email'";
$res = mysqli_query($id, $sql);

    $_SESSION['nova_senha'] = $novasenha;
    $_SESSION['email'] = $email;
}else{
        $_SESSION['login_error'] = "Email invalido!";
        header("Location: ../login.php");
}
?>

<script type="text/javascript"src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>

<script defer>
emailjs.init({
    publicKey: "r4HC0Lqq0399DoDeU",
});

// Sintaxe corrigida
emailjs.send("service_01v4eum", "template_ffm47f8", {
    subject: "Sua nova senha é: <?php echo $_SESSION['nova_senha']; ?>",
    name: "TransformFit",
    message: "Sua nova senha: <?php echo $_SESSION['nova_senha']; ?>",
    email: "<?php echo $_SESSION['email']; ?>",
})
.then(function(response) {
    alert("Sua senha foi alterada com sucesso verificar sua caixa de entrada no Email!");
    window.location.href = '../login.php?success=1';
}, function(error) {
    alert('Erro ao enviar email: ' + JSON.stringify(error));
    window.location.href = '../login.php';
});
</script>x