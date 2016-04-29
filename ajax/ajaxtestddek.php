<?php
include '../config.php';
$pass2html='';
$recnik = isset($_GET["recnik"]) ? $_GET["recnik"] : 0;
$smerpo = isset($_GET["smerpo"]) ? $_GET["smerpo"] : 0;
$selpo = isset($_GET["selpo"]) ? $_GET["selpo"] : 0;
switch ($selpo) {
	case 1 :
	$ordby='rid';
		break;
	case 2 :
	$ordby='naziv';
		break;
	case 3 :
	$ordby='t.procenat';
		break;
	case 4 :
	$ordby='t.ukupno';
		break;
	case 5 :
	$ordby='t.datum';
		break;
}
if ($smerpo==1) $smerpox='ASC';

$sql="SELECT * FROM (SELECT ID rid, naziv FROM $recnik) r LEFT JOIN test_dek t ON t.iddek = r.rid AND t.recnik = '$recnik' ORDER BY $ordby $smerpox";
$result = $mysqli->query($sql) or die;

while($row=$result->fetch_assoc()) {
$naziv=$row['naziv'];
$rid=$row['rid'];
$procenat=round($row['procenat'],2)*100;
$ukupno=$row['ukupno'];
	$pass2html.='<div id="blacklink" style="border-right: thin dashed #000" onclick="ajax_request('.$rid.')"><div style="float:left;width:33px;padding-right:3px;text-align:right;';
	if ($ukupno<10) $pass2html.='font-style:italic;color:#888;';
	$pass2html.='border-right: 1px solid black;margin-right:3px">'.$procenat.'%</div><a href="#">'.$naziv.'</a></div>';
}
$pass['pass2html']=$pass2html;
echo json_encode($pass);

?>