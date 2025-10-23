<?php
include("php/connection.php");
include("php/verify.php");
$_SESSION['back'] = null;
$id_login = $_SESSION['cpf'];
$id_treino = $_GET['id_treino'];

$sql_training = "SELECT * FROM treino_personalizado WHERE id_treino = '" . $id_treino . "'";
$res_training = mysqli_fetch_array(mysqli_query($id, $sql_training));

$sqlTraining = "
    SELECT e.id_exercicio, e.nome, e.grupo_muscular, e.imagem, e.observacoes, e.tempo_execucao,
           tpe.series, tpe.repeticoes, tpe.carga
    FROM treino_personalizado_exercicio tpe
    INNER JOIN exercicio e ON e.id_exercicio = tpe.id_exercicio
    WHERE tpe.id_treino = '" . $id_treino . "'
";

$resTraining = mysqli_query($id, $sqlTraining);

include("Modules/edtTper.php");
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
    <!-- Fim -->
    <!-- BootStrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Fim -->
    <title>Treino</title>
    <link rel="stylesheet" href="Style/style-training.css">
    <link rel="stylesheet" href="Style/style-assets.css">
    <link rel="shortcut icon" href="Images/Logo.png" type="image/x-icon">
</head>

<body>
    <section class="test">
        <header>
            <div class="btn-header">
                <i class="bi bi-caret-left" onclick="window.location.href='dashboard.php'"></i>
            </div>
            <div class="inf-header">
                <div class="top-header">
                    <h1><?php echo $res_training['nome']; ?></h1>
                    <div class="buttons">
                        <button onclick="openModal('edtTper')">Editar Treino</button>
                        <button onclick="deletar()">Deletar Treino</button>
                    </div>
                </div>

                <div class="botton-header">
                    <h2>
                        <?php echo $res_training['data_criacao']; ?> | <label
                            for="#nome"><?php echo $res_training['grupo_muscular'] ?></label>
                    </h2>
                    <span><?php
                    list($horas, $minutos, $segundos) = explode(':', $res_training['duracao']);
                    $minutos_totais = ($horas * 60) + $minutos + round($segundos / 60);
                    echo $minutos_totais; ?>
                        min</span>
                </div>
            </div>
        </header>

        <div class="progresso-container" id="progress">
            <div class="progresso-info">
                <span>Progresso do Treino:</span>
                <span id="progresso-texto">0/0</span>
            </div>
            <div class="progresso-barra">
                <div class="progresso-preenchimento" id="progresso-barra"></div>
            </div>
            <div class="progresso-status" id="progresso-status">Iniciando treino...</div>
        </div>

        <section class="body">
            <h2>Exercícios</h2>

            <?php
            while ($row = mysqli_fetch_array($resTraining)) {
                $src = "Images/default.png";
                $imagemBinaria = $row['imagem'];
                $info = getimagesizefromstring($imagemBinaria);
                if ($info !== false) {
                    $tipoMime = $info['mime'];
                    $base64 = base64_encode($imagemBinaria);
                    $src = "data:$tipoMime;base64,$base64";
                } else {
                    $src = "../images/default.png";
                }
                ?>
                <div class="exercise">
                    <div class="exercise-header">
                        <div class="exercise-info">
                            <img src="<?php echo $src; ?>" alt="Imagem do exercício">
                            <div class="exercise-text">
                                <h2><?php echo $row['nome']; ?></h2>
                                <p><?php echo $row['observacoes']; ?></p>
                            </div>
                        </div>
                        <span class="duration"><?php echo $row['tempo_execucao']; ?> min</span>
                    </div>

                    <table class="exercise-table">
                        <tr class="table-header">
                            <th>Série</th>
                            <th>Reps</th>
                            <th>Carga (kg)</th>
                            <th>Concluído</th>
                        </tr>

                        <?php for ($i = 1; $i <= $row['series']; $i++) { ?>
                            <tr class="table-row">
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['repeticoes']; ?></td>
                                <td><input type="number" name="carga" id="carga" value="<?php echo $row['carga']; ?>"></td>
                                <td>
                                    <input type="checkbox" class="serie-check">
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
                <?php
            }
            ?>
        </section>

        <footer>
            <button onclick="window.location.href='dashboard.php'">Voltar</button>

            <button
                onclick="window.location.href='Php/complete.php?treino=<?php echo $res_training['id_treino'] ?>&tipo=Personalizado'">Concluir
                treino</button>
        </footer>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const todosCheckboxes = document.querySelectorAll('.serie-check');
            const concluirBtn = document.querySelector('button[onclick*="complete.php"]');
            const progressoTexto = document.getElementById('progresso-texto');
            const progressoBarra = document.getElementById('progresso-barra');
            const progressoStatus = document.getElementById('progresso-status');

            const totalSeries = todosCheckboxes.length;
            atualizarProgresso();

            // Adiciona todas as checkboxes
            todosCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', atualizarProgresso);
            });

            function atualizarProgresso() {
                const seriesConcluidas = document.querySelectorAll('.serie-check:checked').length;
                const porcentagem = totalSeries > 0 ? (seriesConcluidas / totalSeries) * 100 : 0;

                progressoBarra.style.width = porcentagem + '%';
                progressoTexto.textContent = `${seriesConcluidas}/${totalSeries}`;

                if (seriesConcluidas === 0) {
                    progressoStatus.textContent = 'Inicie o treino marcando as séries';
                    progressoStatus.className = 'progresso-status';
                } else if (seriesConcluidas < totalSeries) {
                    progressoStatus.textContent = `Continue! ${totalSeries - seriesConcluidas} séries restantes`;
                    progressoStatus.className = 'progresso-status';
                } else {
                    progressoStatus.textContent = 'Parabéns! Você completou todas as séries!';
                    progressoStatus.className = 'progresso-status progresso-completo';
                }

                if (concluirBtn) {
                    const todosMarcados = seriesConcluidas === totalSeries;
                    concluirBtn.disabled = !todosMarcados;

                    if (todosMarcados) {
                        concluirBtn.style.opacity = '1';
                        concluirBtn.style.cursor = 'pointer';
                    } else {
                        concluirBtn.style.opacity = '0.6';
                        concluirBtn.style.cursor = 'not-allowed';
                    }
                }
            }
        });
    </script>

    <script>
        let navBar = document.querySelector('#progress');

        document.addEventListener("scroll", () => {
            let scrollTop = window.scrollY

            if (scrollTop > 300) {
                navBar.classList.add('rolar');
            }
            else {
                navBar.classList.remove('rolar');
            }

        })
    </script>

    <!-- Contador de tempo -->
    <script>
        let tempoFormatado = "00:00:00";
        let tempoInicio = null;
        let contadorInterval = null;

        function iniciarContadorTempo() {
            tempoInicio = Date.now();

            contadorInterval = setInterval(() => {
                const tempoDecorrido = Date.now() - tempoInicio;
                const segundos = Math.floor(tempoDecorrido / 1000);
                const minutos = Math.floor(segundos / 60);
                const horas = Math.floor(minutos / 60);

                tempoFormatado =
                    `${horas.toString().padStart(2, '0')}:${(minutos % 60).toString().padStart(2, '0')}:${(segundos % 60).toString().padStart(2, '0')}`;

                console.log(`Tempo na página: ${tempoFormatado}`);
            }, 1000);
        }

        function pararContadorTempo() {
            if (contadorInterval) {
                clearInterval(contadorInterval);
                contadorInterval = null;
            }
        }

        function salvarTempo() {
            if (tempoFormatado !== "00:00:00") {
                const formData = new FormData();
                formData.append('tempo', tempoFormatado);

                fetch('statistics.php', {
                    method: 'POST',
                    body: formData
                }).then(response => {
                    console.log('Tempo salvo com sucesso:', tempoFormatado);
                }).catch(error => {
                    console.error('Erro ao salvar tempo:', error);
                });
            }
        }

        // Iniciar quando a página carregar
        document.addEventListener('DOMContentLoaded', iniciarContadorTempo);

        // Salvar tempo quando concluir o treino
        document.querySelector('button[onclick*="complete.php"]').addEventListener('click', function () {
            pararContadorTempo();
            salvarTempo();
        });

        // Salvar tempo quando sair da página
        window.addEventListener('beforeunload', function () {
            pararContadorTempo();
            salvarTempo();
        });
    </script>

    <!-- Popup -->

    <script>
        function deletar() {
            Swal.fire({
                title: "Deletar treino?",
                text: "Deseja realmente deletar seu treino?",
                icon: "warning",
                showDenyButton: true,
                confirmButtonText: "Deletar",
                denyButtonText: "Cancelar",
                background: "#0C0E11",
                color: 'white',
                customClass: {
                    confirmButton: 'DeletePop',
                    denyButton: 'CancelPop',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                        window.location.href = 'Php/delete_training.php?id_treino=<?php echo $id_treino ?>'
                }
            });
        }
    </script>

</body>

</html>