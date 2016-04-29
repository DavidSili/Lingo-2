<?php
include '../config.php';
$pass='';
$recnik = isset($_GET["recnik"]) ? $_GET["recnik"] : 0;
$posebno = isset($_GET["posebno"]) ? $_GET["posebno"] : 0;
$sql="DELETE FROM $recnik WHERE `ID`='$posebno'";
$mysqli->query($sql) or die;
echo json_encode($pass);

?>