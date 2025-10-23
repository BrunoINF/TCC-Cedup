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
    <link rel="stylesheet" href="Style/style-assets.css">
    <script src="Js/script-login-regiser.js"></script>
  <link rel="shortcut icon" href="Images/Logo.png" type="image/x-icon">
    <title>Login</title>
</head>

<body>
<section class="form">
    <div class="interface">

    <form method="POST" action="Php/recover.php">
        <div class="form">
            <h1 align="center">Transform<span>Fit</span></h1>
            <h1>Recuperar a senha</h1>
            <div class="text">
            <h2>
                Digite seu email:
                <input type="email" name="email" placeholder="exemplo@email.com" required class="inpt">
            </h2>

    <?php if(isset($error)){ ?>
        <center><label for="eye"><?php echo ($error); ?></label></center>
    <?php } ?>
            </div><br>

            <p onClick="navegar('login.php')" class="Aacont">Lembrou a<span> senha?</span></p>
<br>
            
            <button type="submit" class="btn">Recuperar a senha</button>
        </div>
    </form>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script>
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
        y: 100, 
        duration: 0.6, 
        onComplete: () => {
          window.location.href = destino; 
        }
      });
    }
</script>
</body>
</html>
