<?php
include('connection.php');
include('verify.php');
$id_log = $_GET['id_log'];

$_SESSION['back'] = "log";
       
$sql = "Delete from logs where id_log ='" . $id_log;
$res = mysqli_query($id, $sql);

if($res){
    header("Location: ../admPag.php");
}
?>