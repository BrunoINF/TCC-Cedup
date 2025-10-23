<!-- BootStrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
<!-- Fim -->

<script>

    function expandir() {
        document.querySelector('.menu-lateral').classList.toggle('expandir');
    }

</script>
<!-- NavBar -->
<nav class="menu-lateral">
    <div class="btn-expandir" onclick="expandir()">
        <i class="bi bi-list"></i>
    </div>
    <ul>
        <li class="item-menu dashboard">
            <a href="dashboard.php">
                <span class="icon"><i class="bi bi-columns-gap"></i></span>
                <span class="txt-link">Treinos</span>
            </a>
        </li>

        <li class="item-menu statistics">
            <a href="statistics.php">
                <span class="icon"><i class="bi bi-clipboard-data"></i></span>
                <span class="txt-link">Estatisticas</span>
            </a>
        </li>

        <?php
        if (!isset($_SESSION['tipo'])) {

        } else {
            $tipo = $_SESSION['tipo'];
            if ($tipo == "ADM" || $tipo == "Supremo") {
                ?>
                <li class="item-menu admPag">
                    <a href="admPag.php">
                        <span class="icon"><i class="bi bi-gear"></i></span>
                        <span class="txt-link">ADM-Pag</span>
                    </a>
                </li>

                <?php
            }
        }

        ?>

        <li class="item-menu user">
            <a href="user.php">
                <span class="icon"><i class="bi bi-person"></i></span>
                <span class="txt-link">Perfil</span>
            </a>
        </li>
    </ul>
</nav>
<!-- Fim -->

<!-- Estilo -->
<style>
    /* Navbar */
    nav.menu-lateral {
        width: 90px;
        height: 100%;
        background-color: black;
        padding: 40px 0 40px 0;
        box-shadow: 3px 0 15px #FD5805;
        position: fixed;
        top: 0;
        left: 0;
        transition: .5s;
        overflow: hidden;
        z-index: 999;
    }

    nav.menu-lateral.expandir {
        width: 300px;

        & i {
            position: relative !important;
            left: 10px;
            transform: transformX(0%) !important;
        }
    }

    .btn-expandir {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .btn-expandir > i {

        color: white;
        font-size: 45px;
        transition: 0.5s ease-in-out;

        &:hover {
            color: lightgray;
        }
    }


    ul {
        height: 100%;
        list-style: none;

    }

    ul li.item-menu {
        transition: .5s;
    }

    ul li.item-menu:hover {
        background: #FD5805;
    }

    ul li.item-menu a {
        color: white;
        text-decoration: none;
        padding: 20px;
        display: flex;
        line-height: 32px;
        position: relative;
        white-space: nowrap;
    }

    ul li.item-menu a .txt-link {
        margin-left: 100px;
        transition: .5s;
        opacity: 0;
        font-size: 0em;
        color: white;
    }

    nav.menu-lateral.expandir a .txt-link {
        margin-left: 40px;
        font-size: 20px;
        opacity: 1;
    }

    ul li.item-menu a .icon > i {
        font-size: 30px;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
    }

    /* Fim */

@media screen and (max-width: 900px) {
    nav.menu-lateral {
        width: 50px;
    }

    nav.menu-lateral.expandir {
        width: 200px;
    }

    .btn-expandir>i {
        font-size: 35px;
    }

    ul {
        display: flex;
        flex-direction: column;
        list-style: none;
        padding: 0;
        margin: 0;
    }
}

</style>
<!-- Fim -->