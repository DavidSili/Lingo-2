<?php
include '../config.php';
$pass2html='';
$recnik = isset($_GET["recnik"]) ? $_GET["recnik"] : 0;
$recnik = $mysqli->real_escape_string($recnik);
$sql="SELECT * FROM $recnik ORDER BY `naziv` ASC";
$result=mysqli_query($mysqli,$sql) or die;
while($row=$result->fetch_assoc()) {
$naziv=$row['naziv'];
$ID=$row['ID'];
	$pass2html.='<div id="blacklink" style="border-right: thin dashed #000" onclick="ajax_request('.$ID.')"><a href="#">'.$naziv.'</a></div>';
}
$pass['pass2html']=$pass2html;
echo json_encode($pass);

?>