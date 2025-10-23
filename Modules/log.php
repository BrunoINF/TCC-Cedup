<?php
$sql_log = "SELECT * FROM LOGS";
$res_log = mysqli_query($id, "$sql_log");
?>

<div class="Logs">
    <div class="log">
        <h2>Logs de ADM</h2>
        <?php if (mysqli_num_rows($res_log) > 0) { ?>
            <?php while ($linhaLog = mysqli_fetch_assoc($res_log)) { ?>
                <div class="solicitacao">
                    <div class="text">
                        <div class="acao">
                            <span class="limite-texto"><?php echo "Ação: " . $linhaLog['acao']; ?></span>
                        </div>
                        <div class="desc">
                            <span><?php echo "Detalhe: " . $linhaLog['detalhes']; ?></span>
                        </div>
                    </div>
                    <div class="delet">
                        <a href="Php/delete_log.php?id_log=<?php echo $linhaLog['id_log']; ?>'"><i class="bi bi-trash"></i></a>
                    </div>
                </div>
            <?php } ?>

        <?php } else { ?>
            <p style="color: gray;">Nenhum log encontrado até o momento.</p>
        <?php } ?>
    </div>
</div>

<style>
    div.solicitacoes {
        padding: 0;
        margin-left: 50px;
        display: flex;
        flex-direction: column;
        max-width: 1000px;
    }

    .solicitacao {
        background: #1a1a1a;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 15px 20px;
        margin: 10px 0;
        display: flex;
        justify-content: space-between;
        border-left: 3px solid lightgray;
        margin-left: 20px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .solicitacao .text {
        width: 70%;
    }

    .solicitacao .delet {
        width: 20%;
        min-height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .solicitacao .delet img {
        width: 50px;
        height: 50px;
    }

    .solicitacao:hover {
        transform: scale(1.007);
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
    }

    .log {
        margin-bottom: 40px;
    }

    .log .Logs {
        background-color: #151A1D;
        width: 1000px;
        line-height: 30px;
        margin-bottom: 10px;
        border-radius: 7px;
        padding: 5px;
    }

    span.limite-texto {
        display: inline-block;
        max-width: 95%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .acao {
        color: lightgray;
        font-weight: 500;
    }

    .desc {
        color: white;
        font-style: oblique;
        font-weight: 700;
    }
</style>