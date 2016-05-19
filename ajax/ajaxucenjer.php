<?php
include '../config.php';

$recnik = isset($_GET["recnik"]) ? $_GET["recnik"] : 0;
$grupe = isset($_GET["grupe"]) ? $_GET["grupe"] : 0;
$srckoje = isset($_GET["srckoje"]) ? $_GET["srckoje"] : 0;
$srcsta = isset($_GET["srcsta"]) ? $_GET["srcsta"] : 0;
$search = isset($_GET["search"]) ? $_GET["search"] : 0;
$sortpo = isset($_GET["sortpo"]) ? $_GET["sortpo"] : 0;
$sortsmer = isset($_GET["sortsmer"]) ? $_GET["sortsmer"] : 0;

$recnik = $mysqli->real_escape_string($recnik);
$grupe = $mysqli->real_escape_string($grupe);
$srckoje = $mysqli->real_escape_string($srckoje);
$srcsta = $mysqli->real_escape_string($srcsta);
$search = $mysqli->real_escape_string($search);
$sortpo = $mysqli->real_escape_string($sortpo);
$sortsmer = $mysqli->real_escape_string($sortsmer);

$grupex='<option value="sve_reci">sve reči</option>';

$sql='SELECT * FROM grupe WHERE recnik="'.$recnik.'" ORDER BY ID ASC';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	$grupex.='<option value="'.$row['ID'].'" >'.$row['naziv'].'</option>';
}
if ($grupe=='sve_reci') {
	$kojegrupe='';
	$kojegrupeb='';
}
else {
	$kojegrupe=" AND `grupa` LIKE '%$grupe%' ";
	$kojegrupeb="WHERE `grupa` LIKE '%$grupe%' ";
}

if ($search!="") {
	if ($srckoje==1) $search.="%";
		else $search="%".$search."%";
}
switch ($srcsta) {
	case 0:
	$mix="`aa` LIKE '$search' OR `bb` LIKE '$search' OR `syna` LIKE '$search' OR `synb` LIKE '$search' OR `coma` LIKE '$search' OR `comb` LIKE '$search'";
		break;
	case 1:
	$mix="`aa` LIKE '$search' OR `bb` LIKE '$search'";
		break;
	case 2:
	$mix="`aa` LIKE '$search' OR `bb` LIKE '$search' OR `syna` LIKE '$search' OR `synb` LIKE '$search'";
		break;
	case 3:
	$mix="`syna` LIKE '$search' OR `synb` LIKE '$search'";
		break;
	case 4:
	$mix="`coma` LIKE '$search' OR `comb` LIKE '$search'";
		break;
}
		
if ($search!="") {
	$sql="SELECT * FROM $recnik WHERE ".$mix.$kojegrupe." ORDER BY `".$sortpo."` ".$sortsmer;
	
}
else {
	$sql="SELECT * FROM $recnik $kojegrupeb ORDER BY `".$sortpo."` ".$sortsmer;
}
$result = $mysqli->query($sql) or die;
$passhtml='<table width=100%>';
$count=0;
while ($row=$result->fetch_assoc()) {
$passhtml.='<tr><td style="padding-bottom:10px"><table border=1 width=100%><colgroup><col style="width:50%"><col style="width:50%"></colgroup>';	
	foreach($row as $xx => $yy) {
		$$xx=$yy;
	}
	if ( $count & 1 ) $bgn='ddd';
		else $bgn='fff';
	$passhtml.='<tr style="background:#'.$bgn.'"><th>'.$aa.'</th><th>'.$bb.'</th></tr>';
	if ($syna!="" or $synb!="") $passhtml.='<tr style="background:#'.$bgn.'"><td>'.$syna.'</td><td>'.$synb.'</td></tr>';
	if ($coma!="" or $comb!="") $passhtml.='<tr style="background:#'.$bgn.';margin-bottom:10px"><td><i>'.$coma.'</i></td><td><i>'.$comb.'</i></td></tr>';
	$count++;
$passhtml.="</td></tr></table>";
}
$passhtml.="</table>";	
$pass['passhtml']=$passhtml;
$pass['grupex']=$grupex;
echo json_encode($pass);
?>