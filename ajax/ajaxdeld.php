<?php
include '../config.php';
$pass='';
$posebno = isset($_GET["posebno"]) ? $_GET["posebno"] : 0;
$recnik = isset($_GET["recnik"]) ? $_GET["recnik"] : 0;
$sql="DELETE FROM $recnik WHERE `ID`='$posebno'";
mysql_query($sql) or die;
echo json_encode($pass);
?>