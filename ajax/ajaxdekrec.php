<?php
include '../config.php';
$pass2html='';
$recnik = isset($_GET["recnik"]) ? $_GET["recnik"] : 0;
$sql="SELECT * FROM $recnik ORDER BY `naziv` ASC";
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
$naziv=$row['naziv'];
	$pass2html.='<div style="border-right: thin dashed #000">'.$naziv.'</div>';
}
$pass['pass2html']=$pass2html;
echo json_encode($pass);

?>