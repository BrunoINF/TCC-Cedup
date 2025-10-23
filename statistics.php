<?php
include("Php/connection.php");
include("Php/verify.php");

$id_login = $_SESSION['cpf'];
$sql_usuario = "SELECT * FROM usuario WHERE cpf ='" . $id_login . "'";
$usuario = mysqli_fetch_array(mysqli_query($id, $sql_usuario));
$sql_Perfil = "SELECT * FROM Perfil WHERE cpf_usuario = '$id_login'";
$Perfil = mysqli_fetch_array(mysqli_query($id, $sql_Perfil));
$idPerfil = $Perfil['id_Perfil'];

$datas = [];
$sql_conclusoes = "SELECT DATE_FORMAT(concluido_em, '%Y-%m-%d') as data FROM treino_concluido WHERE id_Perfil =  " . $idPerfil . " ";
$res_conclusoes = mysqli_query($id, $sql_conclusoes);

while ($linha = mysqli_fetch_array($res_conclusoes)) {
    $datas[] = $linha['data'];
}
$sql_treinos_pesonalizados = "
            SELECT COUNT(*) AS NUM_PERS
            FROM treino_concluido
            WHERE id_Perfil = $idPerfil
            AND tipo = 'personalizado'";

$res_num_pers = mysqli_query($id, $sql_treinos_pesonalizados);
$array_num_pers = mysqli_fetch_array($res_num_pers);

$sql_treinos_pronto = "
            SELECT COUNT(*) AS NUM_PERS
            FROM treino_concluido
            WHERE id_Perfil = $idPerfil
            AND tipo = 'pronto'";

$res_num_pront = mysqli_query($id, $sql_treinos_pronto);
$array_num_pront = mysqli_fetch_array($res_num_pront);

$sql_treinos_concluidos = "SELECT * FROM treino_concluido WHERE id_Perfil=" . $idPerfil;
$res_treinos_concluidos = mysqli_query($id, $sql_treinos_concluidos);

$arrayTreinosPersonalizados = [];
$arrayTreinosProntos = [];

while ($linha_id = mysqli_fetch_assoc($res_treinos_concluidos)) {
    if ($linha_id['tipo'] == "personalizado") {
        $arrayTreinosPersonalizados[] = $linha_id['id_treino'];
    } else {
        $arrayTreinosProntos[] = $linha_id['id_treino'];
    }
}

// Puxa o tempo dos treinos concluidos
$sql_usuario = "SELECT * FROM usuario WHERE cpf ='" . $id_login . "'";
$usuario = mysqli_fetch_array(mysqli_query($id, $sql_usuario));
$sql_Perfil = "SELECT * FROM Perfil WHERE cpf_usuario = '$id_login'";
$Perfil = mysqli_fetch_array(mysqli_query($id, $sql_Perfil));
$idPerfil = $Perfil['id_Perfil'];

$datas = [];
$sql_conclusoes = "SELECT DATE_FORMAT(concluido_em, '%Y-%m-%d') as data FROM treino_concluido WHERE id_Perfil =  " . $idPerfil . " ";
$res_conclusoes = mysqli_query($id, $sql_conclusoes);

while ($linha = mysqli_fetch_array($res_conclusoes)) {
    $datas[] = $linha['data'];
}

$sql_treinos_pesonalizados = "
        SELECT COUNT(*) AS NUM_PERS
        FROM treino_concluido
        WHERE id_Perfil = $idPerfil
        AND tipo = 'personalizado'";

$res_num_pers = mysqli_query($id, $sql_treinos_pesonalizados);
$array_num_pers = mysqli_fetch_array($res_num_pers);

$sql_treinos_pronto = "
        SELECT COUNT(*) AS NUM_PERS
        FROM treino_concluido
        WHERE id_Perfil = $idPerfil
        AND tipo = 'pronto'";

$res_num_pront = mysqli_query($id, $sql_treinos_pronto);
$array_num_pront = mysqli_fetch_array($res_num_pront);

$sql_treinos_concluidos = "SELECT * FROM treino_concluido WHERE id_Perfil=" . $idPerfil;
$res_treinos_concluidos = mysqli_query($id, $sql_treinos_concluidos);

$arrayTreinosPersonalizados = [];
$arrayTreinosProntos = [];

while ($linha_id = mysqli_fetch_assoc($res_treinos_concluidos)) {
    if ($linha_id['tipo'] == "personalizado") {
        $arrayTreinosPersonalizados[] = $linha_id['id_treino'];
    } else {
        $arrayTreinosProntos[] = $linha_id['id_treino'];
    }
}

// --- PROCESSAMENTO DO TEMPO ---
$tempo_novo = $_POST['tempo'] ?? '00:00:00';

// Inicializa variáveis para evitar erros
$minutos_totais = 0;
$tempo_exibicao = "00:00:00";

if ($tempo_novo !== '00:00:00' && isset($_POST['tempo'])) {
    // Busca o tempo atual do usuário
    $sql_tempo_atual = "SELECT tempo_treino FROM perfil WHERE cpf_usuario = '$id_login'";
    $res_tempo_atual = mysqli_query($id, $sql_tempo_atual);

    if ($res_tempo_atual && mysqli_num_rows($res_tempo_atual) > 0) {
        $tempo_atual = mysqli_fetch_assoc($res_tempo_atual)['tempo_treino'];

        // Converte ambos os tempos para segundos
        list($h_atual, $m_atual, $s_atual) = explode(':', $tempo_atual);
        list($h_novo, $m_novo, $s_novo) = explode(':', $tempo_novo);

        $segundos_atual = ($h_atual * 3600) + ($m_atual * 60) + $s_atual;
        $segundos_novo = ($h_novo * 3600) + ($m_novo * 60) + $s_novo;

        // Soma os tempos
        $segundos_total = $segundos_atual + $segundos_novo;

        // Converte de volta para formato HH:MM:SS
        $horas_total = floor($segundos_total / 3600);
        $minutos_total = floor(($segundos_total % 3600) / 60);
        $segundos_total = $segundos_total % 60;

        $tempo_total = sprintf("%02d:%02d:%02d", $horas_total, $minutos_total, $segundos_total);

        $sql = "UPDATE perfil SET tempo_treino = '$tempo_total' WHERE cpf_usuario = '$id_login'";
        $res = mysqli_query($id, $sql);

        if ($res) {
            echo "<!-- Tempo atualizado com sucesso: $tempo_total -->";
            // Usa o tempo atualizado para exibição
            $tempo_exibicao = $tempo_total;
        } else {
            // Se falhar a atualização, usa o tempo atual
            $tempo_exibicao = $tempo_atual;
        }
    }
}

// SEMPRE busca o tempo atual do banco para exibição (mesmo se não houve POST)
$sql_tempo_exibicao = "SELECT tempo_treino FROM perfil WHERE cpf_usuario = '$id_login'";
$res_tempo_exibicao = mysqli_query($id, $sql_tempo_exibicao);

if ($res_tempo_exibicao && mysqli_num_rows($res_tempo_exibicao) > 0) {
    $tempo_exibicao_db = mysqli_fetch_assoc($res_tempo_exibicao)['tempo_treino'];

    // Converte para minutos para exibição
    list($horas, $minutos, $segundos) = explode(':', $tempo_exibicao_db);
    $minutos_totais = ($horas * 60) + $minutos + round($segundos / 60);
    $tempo_exibicao = $tempo_exibicao_db;
} else {
    $minutos_totais = 0;
    $tempo_exibicao = "00:00:00";
}

$sql_historico = "SELECT * FROM treino_concluido WHERE id_perfil = $idPerfil ORDER BY concluido_em DESC";
$res_historico = mysqli_query($id, $sql_historico);


// Calendario (Não apagar)
$sql_historico = "SELECT * FROM treino_concluido WHERE id_perfil = $idPerfil ORDER BY concluido_em DESC";
$res_historico = mysqli_query($id, $sql_historico);
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
    <link rel="stylesheet" href="Style/style-statistics.css">
    <link rel="stylesheet" href="Style/style-assets.css">
    <link rel="stylesheet" href="Style/style-footer.css">
  <link rel="shortcut icon" href="Images/Logo.png" type="image/x-icon">
    <title>Estatísticas</title>
</head>

<body>
    <section class="body">
        <?php include("Modules/nav.php") ?>
        <div class="interface">
            <header class="header">
                <h1>
                    Painel de Estatísticas
                </h1>
            </header>

            <section class="statistic">
                <div class="statsiticsCalendar">
                    <div class="calendar">
                        <div class="headerCalendar">
                            <div id="prev" class="btnCalendar">
                                <i class="bi bi-caret-left"></i>
                            </div>
                            <div id="month-year"></div>
                            <div id="next" class="btnCalendar">
                                <i class="bi bi-caret-right"></i>
                            </div>
                        </div>
                        <div class="weekdays">
                            <div>Dom</div>
                            <div>Seg</div>
                            <div>Ter</div>
                            <div>Qua</div>
                            <div>Qui</div>
                            <div>Sex</div>
                            <div>Sab</div>
                        </div>
                        <div class="days" id="days"></div>
                    </div>
                </div>

                <div class="statsiticsText">
                    <div class="buttons">
                        <button type="button" class="btn active" data-target="calendario">Calendário</button>
                        <button type="button" class="btn" data-target="historico">Histórico</button>
                    </div>

                    <section class="contents active" id="calendario">
                        <fieldset>
                            <legend>
                                Estatísticas
                            </legend>

                            <h3>
                                Treinos personalizados concluídos:
                                <span> &#8192;
                                    <?php
                                    if ($array_num_pers['NUM_PERS'] > 0) {
                                        echo '<span class="result">' . $array_num_pers['NUM_PERS'] . "</span>";
                                    } else {
                                        echo "Ainda não concluiu";
                                    }

                                    ?>
                                </span>
                            </h3>

                            <h3>
                                Treinos prontos concluidos:
                                <span> &#8192;
                                    <?php
                                    if ($array_num_pront['NUM_PERS'] > 0) {
                                        echo '<span class="result">' . $array_num_pront['NUM_PERS'] . "</span>";
                                    } else {
                                        echo "Ainda não concluiu";
                                    } ?></span>

                            </h3>

                            <h3>
                                Total de tempo treinado: <?php echo '<span class="result">' . $tempo_exibicao; ?></span>
                            </h3>

                            <div class="img">
                                <img src="Images/winner.png" alt="Estatísticas">
                            </div>
                        </fieldset>
                    </section>

                    <section class="contents" id="historico">
                        <div class="just">
                            <h1 class="his">Histórico de treinos concluídos</h1>
                        </div>
                        <?php 
                        $countLine = mysqli_num_rows($res_historico);
                        if($countLine > 0){
                        while ($row_historico = mysqli_fetch_array($res_historico)) { ?>
                            <div class="historico">
                                <?php $sql_nome = "SELECT nome FROM treino_" . $row_historico['tipo'] . " WHERE id_treino =" . $row_historico['id_treino'];
                                $res_nome = mysqli_query($id, $sql_nome);

                                if ($res_nome && mysqli_num_rows($res_nome) > 0) {
                                    $nome = mysqli_fetch_assoc($res_nome);
                                    echo "<span>" . $nome['nome'] . "</span>";
                                } else {
                                    echo "<span class='treino-nao-encontrado'>O treino não existe</span>";
                                }
                                ?>

                                <?php echo "<span>" . $row_historico['concluido_em'] . "</span>"; ?>
                            </div>
                        <?php }
                        ;}else{
                            echo '<span style="color: lightgray;">Nenhum treino concluído</span>';
                        }
                         ?>
                    </section>
                </div>
        </div>
        <?php
        include("Modules/footer.php");
        ?>
    </section>

    <script>

        const btns = document.querySelectorAll('.btn');
        const contents = document.querySelectorAll('.contents');

        btns.forEach(btn => {
            btn.addEventListener('click', () => {
                btns.forEach(b => b.classList.remove('active'));
                contents.forEach(c => c.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById(btn.dataset.target).classList.add('active');
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const monthYear = document.getElementById('month-year');
            const daysContainer = document.getElementById('days');
            const prevButton = document.getElementById('prev');
            const nextButton = document.getElementById('next');

            const months = [
                'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
                'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
            ];

            const treinosCompletos = <?php echo json_encode($datas); ?>;

            let currentDate = new Date();
            let today = new Date();

            function renderCalendar(date) {
                const year = date.getFullYear();
                const month = date.getMonth();

                monthYear.textContent = `${months[month]} ${year}`;
                daysContainer.innerHTML = '';

                const firstDay = new Date(year, month, 1).getDay();
                const lastDay = new Date(year, month + 1, 0).getDate();

                // Dias do mês anterior
                const prevMonthLastDay = new Date(year, month, 0).getDate();
                for (let i = firstDay; i > 0; i--) {
                    const dayDiv = document.createElement('div');
                    dayDiv.textContent = prevMonthLastDay - i + 1;
                    dayDiv.classList.add('fade');
                    daysContainer.appendChild(dayDiv);
                }

                // Dias do mês atual
                for (let i = 1; i <= lastDay; i++) {
                    const dayDiv = document.createElement('div');
                    dayDiv.textContent = i;

                    const dataFormatada = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;

                    // Dias treinados
                    if (treinosCompletos.includes(dataFormatada)) {
                        // Verifica se a data do treino é anterior ou igual ao dia atual para marcar
                        const dataDia = new Date(dataFormatada + 'T00:00:00');
                        if (dataDia <= today) {
                            dayDiv.classList.add('completed');
                        }
                    }

                    // Dia atual
                    if (i === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                        dayDiv.classList.add('today');
                    }

                    daysContainer.appendChild(dayDiv);
                }

                // Dias do próximo mês
                const nextMonthStartDay = 7 - new Date(year, month + 1, 0).getDay() - 1;
                for (let i = 1; i <= nextMonthStartDay; i++) {
                    const dayDiv = document.createElement('div');
                    dayDiv.textContent = i;
                    dayDiv.classList.add('fade');
                    daysContainer.appendChild(dayDiv);
                }
            }

            prevButton.addEventListener('click', function () {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar(currentDate);
            });

            nextButton.addEventListener('click', function () {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar(currentDate);
            });

            renderCalendar(currentDate);
        });
    </script>
</body>

</html>