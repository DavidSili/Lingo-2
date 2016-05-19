<?php
include '../config.php';
$pass='';
$posebno = isset($_GET["posebno"]) ? $_GET["posebno"] : 0;
$recnik = isset($_GET["recnik"]) ? $_GET["recnik"] : 0;
$posebno = mysqli_real_escape_string($mysqli,$posebno);
$recnik = mysqli_real_escape_string($mysqli,$recnik);
$sql="DELETE FROM $recnik WHERE `ID`='$posebno'";
mysqli_query($mysqli,$sql) or die;
echo json_encode($pass);
?>