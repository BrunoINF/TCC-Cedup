<?php
session_start();

if(!isset($_SESSION['cpf'])){
    session_destroy();
    header("Location: login.php");
}

?>