<?php
include("Php/connection.php");
include("Php/verify.php");

$return = $_SESSION['back'];

$id_login = $_SESSION['cpf'];
$sql_Perfil = "SELECT * FROM Perfil WHERE cpf_usuario = '$id_login'";
$Perfil = mysqli_fetch_array(mysqli_query($id, $sql_Perfil));
$idPerfil = $Perfil['id_Perfil'];
?>

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Fim -->
    <!-- BootStrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Fim -->
    <link rel="stylesheet" href="Style/style-dashboard.css">
    <link rel="stylesheet" href="Style/style-assets.css">
    <link rel="stylesheet" href="Style/style-footer.css">
    <link rel="shortcut icon" href="Images/Logo.png" type="image/x-icon">
    <title>Dashboard</title>
</head>

<body>

    <section class="body">
        <?php include("Modules/nav.php") ?>
        <div class="interface">
            <header class="header">
                <h1>
                    Painel TransformFit
                </h1>
                <?php
                include('Modules/request_modal.php')
                    ?>
            </header>

            <section class="trainings">
                <div class="buttons">
                    <button class="btn 
                    <?php
                    if ($return != "tpro") {
                        echo "active";
                    } else {

                    }
                    ?>
                    " data-target="TreinoPersonalizado">Treino Personalizado</button>
                    <button class="btn
                    <?php
                    if ($return == "tpro") {
                        echo "active";
                    } else {

                    }
                    ?>
                    " data-target="TreinoPronto">Treino Pronto</button>
                </div>


                <div class="contents
                <?php
                if ($return == "tpro") {
                    echo "active";
                } else {

                }
                ?>
                " id="TreinoPronto">
                    <?php
                    $sql_treinoP = "Select * from treino_pronto";
                    $treinosP = mysqli_query($id, $sql_treinoP);
                    ?>
                    <h1>Treinos Prontos</h1>
                    <?php
                    while ($linhaP = mysqli_fetch_array($treinosP)) {
                        ?>
                        <a href="trainingP.php?id_treino=<?php echo $linhaP['id_treino']; ?>">
                            <article class="trainingP">
                                <div class="txt-trainingP">
                                    <span><?php echo $linhaP['nome']; ?>
                                        <p <p style="font-size: 0.8em; color: lightgray;">
                                            <?php echo $linhaP['grupo_muscular'] ?>
                                        </p>
                                    </span>
                                </div>
                                <div class="time-training">
                                    <span class="time-training"><?php
                                    list($horas, $minutos, $segundos) = explode(':', $linhaP['duracao']);
                                    $minutos_totais = ($horas * 60) + $minutos + round($segundos / 60);
                                    echo $minutos_totais; ?>
                                        min</span>
                                </div>
                            </article>
                        </a>
                    <?php } ?>
                </div>

                <div class="contents 
                <?php
                if ($return != "tpro") {
                    echo "active";
                } else {

                }
                ?>
                " id="TreinoPersonalizado">
                    <h1>Treinos Personalizado</h1>
                    <?php include("Modules/modal_ct.php"); ?>
                    <div class="buscar">
                        <?php include("Modules/search_bar.php"); ?>
                    </div>
                </div>


            </section>
        </div>
        <?php
        include("Modules/footer.php");
        ?>


    </section>



    <script>
        const btns = document.querySelectorAll('.btn');
        const contents = document.querySelectorAll('.contents');

        const paginaAtual = window.location.pathname;

        btns.forEach(btn => {
            btn.addEventListener('click', () => {
                btns.forEach(b => b.classList.remove('active'));
                contents.forEach(c => c.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById(btn.dataset.target).classList.add('active');
            });
        });

        if (paginaAtual === '/Site/trainingP.php') {
            btns.forEach(b => b.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));
        }
    </script>
</body>

</html>