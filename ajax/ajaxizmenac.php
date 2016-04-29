<?php
include '../config.php';
$pass='';
$posebno = isset($_GET["posebno"]) ? $_GET["posebno"] : 0;
$sql="SELECT * FROM quotes WHERE `ID`='$posebno'";
if(isset($posebno)==false OR $posebno=="") $sql='SELECT * FROM quotes ORDER BY `ID` DESC LIMIT 1';
$result=mysql_query($sql) or die;
$row=mysql_fetch_assoc($result);
$pass['ID']=$row['ID'];
$pass['quote']=$row['quote'];
$pass['autor']=$row['autor'];
echo json_encode($pass);

?>