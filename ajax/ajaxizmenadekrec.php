<?php
include '../config.php';
$pass2html='';
$recnik = isset($_GET["recnik"]) ? $_GET["recnik"] : 0;
$recnik = mysqli_real_escape_string($mysqli,$recnik);
$sql="SELECT * FROM $recnik ORDER BY `naziv` ASC";
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
$id=$row['ID'];
$naziv=$row['naziv'];
	$pass2html.='<div id="blacklink" style="border-right: thin dashed #000" onclick="ajax_request('.$id.')" ><a href="#">'.$naziv.'</a></div>';
}
$pass['pass2html']=$pass2html;
echo json_encode($pass);

?>