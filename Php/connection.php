<?php

$dbname = "TransformFit";

if (!($id = mysqli_connect("localhost","root"))){
    echo"Não foi possivel estabelecer uma conexão com o gerenciador MySQL";
    exit;
}
if (!($con = mysqli_select_db($id,$dbname))){
    echo"Não foi possivel estabelecer uma conexão com o banco de dado";
    exit;
}
?>