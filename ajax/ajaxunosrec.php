<?php
include '../config.php';
$pass2html="";
$recnik = isset($_GET["recnik"]) ? $_GET["recnik"] : 0;
$sql="SELECT * FROM $recnik ORDER BY `bb` ASC";
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {

foreach($row as $xx => $yy) {
	$$xx=$yy;
}

$pass2html.='<div style="border-bottom: thin solid #000"><div><div title="'.$coma.'" style="border-right: thin dashed #000">'.$aa.'</div><div title="'.$comb.'">'.$bb.'</div></div>';
if ($syna!="" OR $synb!="") $pass2html.='<div><div style="border-right: thin dashed #000;min-height:14px;border-top: thin dashed #aaa;color:#aaa">'.$syna.'</div><div style="border-top: thin dashed #aaa;color:#aaa">'.$synb.'</div></div>';
$pass2html.='<div style="clear:both"></div></div>';
}
$pass['pass2html']=$pass2html;
echo json_encode($pass);

?>