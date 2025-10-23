<?php
include("verify.php");
include("connection.php");

$id_treino = $_GET['id_treino'];
$id_login  = $_SESSION['cpf'];

$sqlPerfil = "SELECT id_Perfil FROM perfil WHERE cpf_usuario = '$id_login'";
$resPerfil = mysqli_query($id, $sqlPerfil);
$rowPerfil = mysqli_fetch_assoc($resPerfil);
$id_perfil = $rowPerfil['id_Perfil'];

$sqlTreino = "SELECT grupo_muscular, nome, duracao 
              FROM treino_pronto 
              WHERE id_treino = $id_treino";
$resTreino = mysqli_query($id, $sqlTreino);
$treino    = mysqli_fetch_assoc($resTreino);

$sqlInsertTreino = "INSERT INTO treino_personalizado (grupo_muscular, nome, id_Perfil, duracao) 
                    VALUES ('{$treino['grupo_muscular']}', '{$treino['nome']}', $id_perfil, '{$treino['duracao']}')";
mysqli_query($id, $sqlInsertTreino);

$novo_treino_id = mysqli_insert_id($id);

$sqlEx = "SELECT id_exercicio, series, repeticoes, carga 
          FROM treino_pronto_exercicio 
          WHERE id_treino = $id_treino";
$resEx = mysqli_query($id, $sqlEx);

while ($ex = mysqli_fetch_assoc($resEx)) {
    $sqlInsertEx = "INSERT INTO treino_personalizado_exercicio (id_exercicio, id_treino, series, repeticoes, carga)
                    VALUES ({$ex['id_exercicio']}, $novo_treino_id, {$ex['series']}, {$ex['repeticoes']}, {$ex['carga']})";
    mysqli_query($id, $sqlInsertEx);
}

header("Location: ../dashboard.php");

?>