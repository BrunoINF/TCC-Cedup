<!-- Gráfico -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<!-- Fim -->

<?php
$id_login = $_SESSION["cpf"];
$sql_Perfil = "SELECT * FROM Perfil WHERE cpf_usuario = '$id_login'";
$Perfil = mysqli_fetch_array(mysqli_query($id, $sql_Perfil));
$idPerfil = $Perfil['id_Perfil'];

$sql_history = "SELECT DATE_FORMAT(data_registro, '%d/%m/%Y') as data_formatada, peso, altura, imc 
                FROM historico 
                WHERE id_perfil = $idPerfil 
                ORDER BY data_registro DESC";
$res_history = mysqli_query($id, $sql_history);

$chartData = [];
$chartData[] = ['Data', 'IMC'];
$tableData = [];

$imc = mysqli_fetch_assoc(mysqli_query($id, "SELECT IMC FROM PERFIL"));

$imc_val = isset($imc['IMC']) ? (float) $imc['IMC'] : null;

$contlinha = mysqli_num_rows($res_history);
if ($contlinha > 0) {
    while ($linhaH = mysqli_fetch_array($res_history)) {
        $chartData[] = [
            $linhaH['data_formatada'],
            (float) $linhaH['imc']
        ];
        $tableData[] = $linhaH;
    }
}
?>




<div class="history">
    <article>
        <div id="curve_chart"></div>
        <table class="IMC-table">
            <tr>
                <th>Valor de IMC</th>
                <th>Classificação</th>
            </tr>
            <tr id="baixo">
                <td>Menor que 18.5</td>
                <td>Abaixo do Peso</td>
            </tr>
            <tr id="normal">
                <td>Entre 18.5 e 24.99</td>
                <td>Peso Normal</td>
            </tr>
            <tr id="sobrepeso">
                <td>Entre 25 e 29.99</td>
                <td>Acima do Peso</td>
            </tr>
            <tr id="obesidade">
                <td>Maior que 30</td>
                <td>Obesidade</td>
            </tr>
        </table>
    </article>

    <?php if ($contlinha > 0) { ?>
        <table class="data-table">
            <tr>
                <th>Data</th>
                <th>Peso (kg)</th>
                <th>Altura (cm)</th>
                <th>IMC</th>
            </tr>
            <?php foreach ($tableData as $linhaHt) { ?>
                <tr>
                    <td><?php echo $linhaHt['data_formatada']; ?></td>
                    <td><?php echo $linhaHt['peso']; ?></td>
                    <td><?php echo $linhaHt['altura']; ?></td>
                    <td><?php echo $linhaHt['imc']; ?></td>
                </tr>
            <?php }
            ; ?>
        </table>
    <?php } else { ?>
        <span>Ainda não possui nada por aqui</span>
    <?php }
    ; ?>
</div>

</div>

<script>
    let IMC = <?php echo $imc_val === null ? 'null' : $imc_val; ?>;

    if (IMC < 18.5) {
        document.getElementById("baixo").style.backgroundColor = "#09555fff"; // vermelho claro
    } else if (IMC >= 18.5 && IMC <= 24.99) {
        document.getElementById("normal").style.backgroundColor = "#2c610dff"; // verde claro
    } else if (IMC >= 25 && IMC <= 29.99) {
        document.getElementById("sobrepeso").style.backgroundColor = "#b69f1fff"; // amarelo claro
    } else if (IMC >= 30) {
        document.getElementById("obesidade").style.backgroundColor = "#a00808ff"; // vermelho mais forte
    }
</script>

<script>
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(initChart);

    var chartData = <?php echo json_encode($chartData); ?>;
    var chart, data, options;

    function initChart() {
        if (!chartData || chartData.length <= 1) {
            document.getElementById('curve_chart').innerHTML = '<p class="no-data">Não há dados suficientes para exibir o gráfico</p>';
            return;
        }

        data = google.visualization.arrayToDataTable(chartData);

        options = {
            title: 'Histórico de IMC',
            titleTextStyle: { color: '#fff', fontSize: 20 },
            curveType: 'function',
            legend: { position: 'bottom', textStyle: { color: '#fff' } },
            backgroundColor: '#0E1113',
            hAxis: { textStyle: { color: 'lightgray' }, title: 'Data', titleTextStyle: { color: 'lightgray' } },
            vAxis: { textStyle: { color: 'lightgray' }, title: 'IMC', titleTextStyle: { color: 'lightgray' } },
            colors: ['#FD5800']
        };

        chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        chart.draw(data, options);
    }

    window.addEventListener("resize", initChart);

    document.addEventListener("DOMContentLoaded", () => {
        const btnHistorico = document.querySelector('button[data-target="history"]');
        if (btnHistorico) {
            btnHistorico.addEventListener("click", function () {
                setTimeout(initChart, 10);
            });
        }
    });
</script>

<script type="text/javascript">
    const botao = document.querySelectorAll('.btn-history');
    const conteiner = document.querySelectorAll('.content-section');

    botao.forEach(btn => {
        btn.addEventListener('click', () => {
            botao.forEach(b => b.classList.remove('ativo'));
            conteiner.forEach(c => c.classList.remove('ativo'));
            btn.classList.add('ativo');
            const targetId = btn.getAttribute('data-target');
            document.getElementById(targetId).classList.add('ativo');

            if (targetId === 'graphic-content') {
                window.setTimeout(drawChart, 100);
            }
        });
    });

    window.addEventListener('resize', drawChart);
    drawChart();
</script>

