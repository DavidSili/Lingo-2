<?php
include '../config.php';
$pass='';
$posebno = isset($_GET["posebno"]) ? $_GET["posebno"] : 0;
$sql="DELETE FROM quotes WHERE `ID`='$posebno'";
mysql_query($sql) or die;
echo json_encode($pass);

?>