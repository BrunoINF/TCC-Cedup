<?php
include("Php/connection.php");
include("Php/verify.php");

if (!isset($_SESSION['complete'])) {
    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="pt-Br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- BootStrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="Style/style-training.css">
    <link rel="stylesheet" href="Style/style-assets.css">
    <link rel="stylesheet" href="Style/style-footer.css">
  <link rel="shortcut icon" href="Images/Logo.png" type="image/x-icon">
    <title>Treino Concluído</title>
</head>

<body>
    <section class="completed">
        <header>
            <div class="btn-header">
                <i class="bi bi-caret-left" onclick="window.location.href='dashboard.php'"></i>
            </div>
            <div class="inf-header">
                <h1>TransformFit</h1>
            </div>
        </header>

        <section class="body">
            <div class="success">
                <div class="head">
                    <i class="bi bi-stars"></i>
                    <h1>Treino Concluido</h1>
                    <i class="bi bi-stars"></i>
                </div>

                <div class="calendar">
                    <?php include("Modules/weekView.php"); ?>
                </div>

                <div class="info">
                    <div>
                        <h3>Peso total</h3>
                        <p>148kg <i class="bi bi-handbag"></i><br>20min <i class="bi bi-clock"></i></p>
                    </div>
                    <div>
                        <h3>Motivação do dia</h3>
                        <p id="motivacao"></p>
                    </div>
                </div>

                <button class="btn-back" onclick="window.location.href='dashboard.php'">Voltar para o treino</button>
            </div>
        </section>

    </section>
    <script src="Js/script-motivation.js"></script>
</body>

</html>