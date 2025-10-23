<?php
$id_login = $_SESSION['cpf'];
$sql_Perfil = "SELECT * FROM Perfil WHERE cpf_usuario = '$id_login'";
$Perfil = mysqli_fetch_array(mysqli_query($id, $sql_Perfil));
$idPerfil = $Perfil['id_Perfil'];

$pesquisa = isset($_GET['searchBar']) ? $_GET['searchBar'] : '';
?>

<div class="search">
    <form method="get" id="searchForm">
        <input type="search" name="searchBar" id="searchBar" 
        placeholder="Pesquise pelo Treino..."
            onkeyup="loading_training(this.value)" value="<?php echo $pesquisa; ?>">
        <br><br>
    </form>
</div>
<div id="result-container">
    <div id="searchResults"></div>
    <?php
    if (!empty($pesquisa)) {
        $sqltreino = "SELECT * FROM treino_personalizado 
                     WHERE id_Perfil = '$idPerfil' 
                     AND nome LIKE '%$pesquisa%' 
                     ORDER BY data_criacao DESC";
    } else {
        $sqltreino = "SELECT * FROM treino_personalizado 
                     WHERE id_Perfil = '$idPerfil' 
                     ORDER BY data_criacao DESC";
    }

    $treinos = mysqli_query($id, $sqltreino);
    $contlinha = mysqli_num_rows($treinos);

    if ($contlinha > 0) {
        while ($linha = mysqli_fetch_array($treinos)) {
            $imagemBinaria = $linha['imagem'];
if (!empty($imagemBinaria)) {
    $info = getimagesizefromstring($imagemBinaria);
    if ($info !== false) {
        $tipoMime = $info['mime'];
        $base64 = base64_encode($imagemBinaria);
        $src = "data:$tipoMime;base64,$base64";
    } else {
        $src = "Images/default.png";
    }
} else {
    $src = "Images/default.png";
}

            ?>
            <a href="training.php?id_treino=<?php echo $linha['id_treino']; ?>" class="training-link">
                <article class="training">
                    <div class="txt-training">
                        <img src="<?= $src ?>" alt="img Treino">
                        <span class="nome"><?php echo $linha['nome']; ?>
                            <p><?php echo date('d/m/Y H:i', strtotime($linha['data_criacao'])); ?></p>
                        </span>
                    </div>
                    <div class="time-training">
                        <span>
                            <?php
                            list($horas, $minutos, $segundos) = explode(':', $linha['duracao']);
                            $minutos_totais = ($horas * 60) + $minutos + round($segundos / 60);
                            echo $minutos_totais . " min";
                            ?>
                        </span>
                    </div>
                </article>
            </a>
            <?php
        }
    } else {
        if (!empty($pesquisa)) {
            echo "<div class='Nada'><span class='nada'>Nenhum treino encontrado para: '" . $pesquisa . "'</span></div>";
        } else {
            echo "<div class='Nada'><span class='nada'>Ainda não tem nada para ver aqui</span></div>";
        }
    }
    ?>
</div>

<script src="../Js/search.js"></script>
