<?php
include '../config.php';
$pass='';
$posebno = isset($_GET["posebno"]) ? $_GET["posebno"] : 0;
$posebno = mysqli_real_escape_string($mysqli,$posebno);
$sql="SELECT * FROM quotes WHERE `ID`='$posebno'";
if(isset($posebno)==false OR $posebno=="") $sql='SELECT * FROM quotes ORDER BY `ID` DESC LIMIT 1';
$result=mysqli_query($mysqli,$sql) or die;
$row=$result->fetch_assoc();
$pass['ID']=$row['ID'];
$pass['quote']=$row['quote'];
$pass['autor']=$row['autor'];
echo json_encode($pass);

?>