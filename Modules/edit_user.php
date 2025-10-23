<?php
include ("Php/connection.php");
$id_login = $_SESSION['cpf'];
$user = mysqli_fetch_array(mysqli_query($id, "SELECT * FROM USUARIO WHERE CPF = '$id_login'"));
?>

<button onclick="openModal('modalUser')" class="alterar"><i class="bi bi-person-lock"></i> Alterar Senha</button>

<dialog id="modalUser">
    <div class="modal-content">
        <header>
            <h1>Alterar senha e Email</h1>
        </header>
        <form action="Php/process_edt_user.php" method="post">
            <div class="form-group">
                <p>Email</p>
                <input type="email" name="email" placeholder="exemplo@email.com" value="<?php echo $user['email']?>">
            </div>
            <div class="form-group senha">
                <p>Senha</p>
                <input type="password" name="password" placeholder="•••••" required id="password">
                <button id="eye" type="button" class="eye"><i class="bi bi-eye"></i></button>
            </div>
            <div class="btns">
                <button type="submit" class="open">Alterar perfil</button>
                <button type="button" onclick="closeModal('modalUser')" class="close">Fechar</button>
            </div>
        </form>
    </div>
</dialog>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
const btn = document.getElementById('eye');
const password = document.getElementById('password');

btn.addEventListener('mousedown', () => { password.type = 'text'; btn.style.opacity = "1"; });
btn.addEventListener('mouseup', () => { password.type = 'password'; btn.style.opacity = ".6"; });
btn.addEventListener('mouseleave', () => { password.type = 'password'; btn.style.opacity = ".6"; });

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.showModal();

    gsap.fromTo(modal, 
        {opacity:0, scale:0.8, y:-50}, 
        {opacity:1, scale:1, y:0, duration:0.5, ease:"back.out(1.7)"}
    );
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);

    gsap.to(modal, 
        {opacity:0, scale:0.8, y:-50, duration:0.4, ease:"back.in(1.7)", onComplete: ()=>{modal.close();}}
    );
}
</script>
