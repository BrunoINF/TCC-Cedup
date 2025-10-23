<?php
include ("Php/connection.php");

$id_login = $_SESSION['cpf'];
$perfil = mysqli_fetch_array(mysqli_query($id, "SELECT * FROM perfil WHERE CPF_USUARIO = '$id_login'"));
?>

<button onclick="openModal('modalperfil')" class="dados"><i class="bi bi-pen"></i> Editar Dados</button>

<dialog id="modalperfil">
    <div class="modal-content">
        <header>
            <h1>Alterar dados corporais</h1>
        </header>
        <form action="Php/process_edt_perfil.php" method="post">
            <div class="form-group">
                <p>Peso (kg)</p>
                <input type="number" name="peso" placeholder="70.0kg" value="<?php echo $perfil['peso'] ?>">
            </div>

            <div class="form-group">
                <p>Altura (cm)</p>
                <input type="number" name="altura" placeholder="180cm" value="<?php echo $perfil['altura'] ?>">
            </div>

            <div class="btns">
                <button type="submit" class="open">Alterar perfil</button>
                <button type="button" onclick="closeModal('modalperfil')" class="close">Fechar</button>
            </div>
        </form>
    </div>
</dialog>