<div class="perfil">
    <div class="img-perfil">
        <img src="Images/user.png   " alt="Imagem do Perfil">
    </div>

    <div class="txt-perfil">
        <fieldset>
            <legend>Informações do Usuario</legend>

            <h3>
                Email:
                <span> &#8192; <?php echo $usuario['email']; ?></span>
            </h3>

            <h3>
                Senha:
                <span> &#8192; ••••••••••••••••</span>
            </h3>

            <h3>
                Cpf
                <span> &#8192; <?php echo $usuario['cpf'] ?></span>
            </h3>
        </fieldset>


        <fieldset>
            <legend>Informações do Perfil</legend>

            <?php
            $alt = $Perfil['altura'];
            $imc = substr($Perfil['imc'], 0, 5);

            if ($Perfil['sexo'] == "m") {
                $sexo = "Masculino";
            } else {
                $sexo = "Feminino";
            }
            ?>
            <h3>
                Altura:
                <span> &#8192; <?php echo $alt; ?>m</span>
            </h3>
            <h3>
                Peso:
                <span> &#8192;<?php echo $Perfil['peso']; ?>kg</span>
            </h3>
            <h3>
                Imc:
                <span> &#8192;<?php echo $imc; ?></span>
            </h3>
            <h3>
                Sexo:
                <span> &#8192;<?php echo $sexo; ?></span>
            </h3>
        </fieldset>
    </div>

    <div class="btns">

        <?php include("Modules/edit_Perfil.php"); ?>

        <?php include("Modules/edit_user.php"); ?>

        <button class="sair" onclick="window.location.href='Php/quit.php'">
            <i class="bi bi-door-open"></i> Sair
        </button>
    </div>

</div>
