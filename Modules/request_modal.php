<?php
$id_login = $_SESSION['cpf'];

$sql_perfil = "SELECT * FROM perfil WHERE cpf_usuario = '$id_login'";
$perfil = mysqli_fetch_array(mysqli_query($id, $sql_perfil));
$idperfil = $perfil['id_Perfil'];

$verif = mysqli_query($id, "SELECT COUNT(*) AS total FROM pedido_treino WHERE id_perfil = $idperfil AND status = 'pendente'");
$row = mysqli_fetch_assoc($verif);

$tem_pendente = $row['total'] > 0;

?>

<link rel="stylesheet" href="../Style/style-assets.css">

<button onclick="openModal('modal')" class="btn-modal <?php if ($tem_pendente)
    echo 'pulse'; ?>">
    Solicitar Treino
    <?php if ($tem_pendente) { ?>
        <span class="badge">!</span>
    <?php } ?>
</button>

<dialog id="modal">
    <div class="modal-content">
        <header>
            <?php if ($tem_pendente) { ?>
                <span class="warning">Você já tem um pedido pendente. Espere a resposta</span>
            <?php } ?>
            <h1>Solicitar treino personalizado</h1>
            <p>Descreva o que você precisa:</p>
        </header>
        <form action="Php/request.php" method="post" id="requestForm">
            <textarea style="resize: none;" name="msg" required></textarea>
            <div class="btns">
                <button type="submit" class="open <?php if ($tem_pendente)
                    echo "off"; ?>" <?php if ($tem_pendente)
                          echo "disabled"; ?>>Enviar</button>
                <button type="button" onclick="closeModal('modal')" class="close">Fechar</button>
            </div>
        </form>
    </div>
</dialog>

<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.showModal();

        setTimeout(() => {
            modal.classList.add('open');
        }, 10);
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);

        modal.classList.remove('open');

        setTimeout(() => {
            modal.close();
        }, 300);
    }

    // Adiciona animação ao enviar o formulário
    document.getElementById('requestForm').addEventListener('submit', function (e) {
        const submitBtn = this.querySelector('.open');
        if (!submitBtn.classList.contains('off')) {
            submitBtn.classList.add('sending');
            submitBtn.textContent = 'Enviando...';

            // Simula o envio (remova isso quando integrar com backend)
            setTimeout(() => {
                submitBtn.classList.remove('sending');
                submitBtn.textContent = 'Enviado!';
                setTimeout(() => {
                    closeModal('modal');
                }, 1000);
            }, 1500);
        }
    });
</script>