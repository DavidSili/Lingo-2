<?php
include '../config.php';
$pass='';
$posebno = isset($_GET["posebno"]) ? $_GET["posebno"] : 0;
$posebno = mysqli_real_escape_string($mysqli,$posebno);
$sql="DELETE FROM quotes WHERE `ID`='$posebno'";
mysqli_query($mysqli,$sql) or die;
echo json_encode($pass);

?>