<?php
session_start();
$error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
unset($_SESSION['login_error']);
?>

<!DOCTYPE html>
<html lang="pt-Br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Fim -->
    <!-- BootStrap -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Fim -->
    <link rel="stylesheet" href="Style/style-login.css">
    <link rel="stylesheet" href="Style/style-loading.css">
    <link rel="stylesheet" href="Style/style-assets.css">
    <script src="Js/script-login-regiser.js"></script>
  <link rel="shortcut icon" href="Images/Logo.png" type="image/x-icon">
    <title>Registro</title>
</head>

<body>
<section class="form">
    <div class="interface">

          <form method="POST" action="Php/register.php" id="form">
        <div class="form">
          <h1>Transform<span>Fit</span></h1>
            <h1>Criar conta</h1>
            <div class="text">
            <h2>
                Adicione seu CPF:
                <input type="text" name="cpf" placeholder="000.000.000-00" required class="inpt" maxlength="14" oninput="formatCPF(this)">
            </h2>
            <h2>
                Adicione seu Email:
                <input type="email" name="email" placeholder="exemplo@email.com" required class="inpt">
            </h2>
            <h2>
                Adicione seu Peso(Kg) e altura(cm):<br>
                <div class="between">
                <input type="number" name="peso" placeholder="Peso"  required class="inpt alt">
                <input type="text" name="altura" placeholder="Altura" required class="inpt alt" maxlength="4" oninput="formatAltura(this)">
                </div>
            </h2>
            <h2>
                Informe seu sexo:
                <select id="sexo" name="sexo" class="custom-select">
                    <option value="" disabled selected>Selecione...</option>
                    <option value="masculino" class="oo">Masculino</option>
                    <option value="feminino">Feminino</option>
                    <option value="outro">Outro</option>
                </select>
            </h2>
            <h2>
                Adicione sua senha:
                <div class="senha">
                <input type="password" name="password" placeholder="•••••" required id="password" class="inpt">
                <button id="eye" type="button" class="eye"><i class="bi bi-eye"></i></button>
                </div>
            </h2>
                <?php if(isset($error)){ ?>
        <center><label for="eye"><?php echo ($error); ?></label></center>
                <?php } ?>
            </div>

            <br>

            <button type="submit" class="btn">Entrar</button>

            <p onClick="navegar('register.php')" class="Aacont">Ja tem conta?<span> Faça Login</span></p>
        </div>
    </form>


    </div>
</section>
<!-- Loader -->
<div id="loader" class="loader-overlay">
  <div class="spinner"></div>
</div>

<script src="Js/script-loading.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script src="Js/script-formata.js"></script>
<script>
  const btn = document.getElementById('eye');
  const password = document.getElementById('password');
  
  btn.addEventListener('mousedown', function () {
    password.type = 'text';
        this.style.opacity = "1";
  });
  btn.addEventListener('mouseup', function () {
    password.type = 'password';
    this.style.opacity = ".6";
  });
  btn.addEventListener('mouseleave', function () {
    password.type = 'password';
    this.style.opacity = ".6";
  });

   gsap.fromTo("div",{
    opacity: 0,
        y: 200, 
        duration: 0.6,
  },{
    opacity: 1,
        y: 0, 
        duration: 0.6,
  });

    function navegar(destino) {
      gsap.to(".form", 
      {
        opacity: 0, 
        y: -100, 
        duration: 0.6, 
        onComplete: () => {
          window.location.href = "login.php"; 
        }
      });
    }
</script>
</body>
</html>