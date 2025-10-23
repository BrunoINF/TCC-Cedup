<?php
$id_login = $_SESSION['cpf'];
$sql_Perfil = "SELECT * FROM Perfil WHERE cpf_usuario = '$id_login'";
$Perfil = mysqli_fetch_array(mysqli_query($id, $sql_Perfil));
$idPerfil = $Perfil['id_Perfil'];


$sql_treino = "Select * from treino_personalizado WHERE id_Perfil   = '$idPerfil ' ORDER BY data_criacao DESC";
$treinos = mysqli_query($id, $sql_treino);
?>


<h1>
    Treinos Agendados
</h1>


<?php
$contlinha = mysqli_num_rows($treinos);
if ($contlinha > 1) {
    while ($linha = mysqli_fetch_array($treinos)) {
        $imagemBinaria = $linha['imagem'];
        $info = getimagesizefromstring($imagemBinaria);
        if ($info !== false) {
            $tipoMime = $info['mime'];
            $base64 = base64_encode($imagemBinaria);
            $src = "data:$tipoMime;base64,$base64";
        } else {
            $src = "Images/default.png";
        }

        ?>
        <a href="training.php?id_treino=<?php echo $linha['id_treino']; ?>">
            <article class="training">
                <div class="txt-training">
                    <img src="<?= $src ?>" alt="img Treino">
                    <span><?php echo $linha['nome']; ?>
                        <p><?php echo $linha['data_criacao']; ?></p>
                    </span>
                </div>

                <div class="time-training">
                    <span>45 min</span>
                </div>
            </article>
        </a>
    <?php }
} else {
    echo "<div class='Nada'><span class='nada'>Ainda não tem nada para ver aqui</span></div>";
} ?>