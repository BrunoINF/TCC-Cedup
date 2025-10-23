<?php
$hoje = new DateTime();

$inicioSemana = clone $hoje;
$inicioSemana->modify('monday this week');
$fimSemana = clone $inicioSemana;
$fimSemana->modify('sunday this week');

$sqlDate = "
    SELECT concluido_em 
    FROM treino_concluido 
    WHERE concluido_em BETWEEN '".$inicioSemana->format('Y-m-d 00:00:00')."' 
                          AND '".$fimSemana->format('Y-m-d 23:59:59')."'
";
$resDate = mysqli_query($id, $sqlDate);

$diasTreinados = [];
while ($row = mysqli_fetch_assoc($resDate)) {
    $dataTreino = new DateTime($row['concluido_em']);
    $diasTreinados[] = $dataTreino->format('Y-m-d');
}

$diasSemana = ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"];
?>

  <div class="week-calendar">
    <?php
    for ($i = 0; $i < 7; $i++) {
        $dia = clone $inicioSemana;
        $dia->modify("+$i days");

        $isHoje = $dia->format('Y-m-d') === $hoje->format('Y-m-d');
        $isTreino = in_array($dia->format('Y-m-d'), $diasTreinados);

        echo "<div class='day";
        if ($isHoje) echo " active";
        if ($isTreino) echo " concluido";
        echo "' data-label='".$diasSemana[$dia->format('w')]."'>";

        echo "<div class='label'>".$diasSemana[$dia->format('w')]."</div>";

        if ($isHoje) {
            echo "<div class='date'>".$dia->format('d')."</div>";
        }

        echo "</div>";
    }
    ?>
  </div>