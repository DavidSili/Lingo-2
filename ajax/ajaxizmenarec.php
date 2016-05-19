<?php
include '../config.php';
$posebno = isset($_GET["posebno"]) ? $_GET["posebno"] : 0;
$recnik = isset($_GET["recnik"]) ? $_GET["recnik"] : 0;
$posebno=mysqli_real_escape_string($mysqli,$posebno);
$recnik=mysqli_real_escape_string($mysqli,$recnik);

if ($posebno!=0) $sql="SELECT * FROM $recnik WHERE `ID`=$posebno";
else $sql="SELECT * FROM $recnik ORDER BY `ID` DESC LIMIT 1";
	$result = $mysqli->query($sql) or die ;
	$row=$result->fetch_assoc();
	foreach($row as $xx => $yy) {
		$$xx=$yy;
	}
	$grupesend="";
	if (empty($grupa)==NULL) {
		$grupe=explode(',',$grupa);
				
		$sql='SELECT * FROM grupe ORDER BY ID ASC';
		$result = $mysqli->query($sql) or die ;
		while ($row=$result->fetch_assoc()) {
			$grupesend.='<input type="checkbox" name="grupe[]" value="'.$row['ID'].'" ';
			if (in_array($row['ID'],$grupe)) $grupesend.='checked="checked" ';
			$grupesend.='/>'.$row['naziv'].'<br/>';
		}

	}
	else {
		$sql='SELECT * FROM grupe WHERE recnik="'.$recnik.'" ORDER BY ID ASC';
		$result = $mysqli->query($sql) or die ;
		while ($row=$result->fetch_assoc()) {
		$grupesend.='<input type="checkbox" name="grupe[]" value="'.$row['ID'].'" />'.$row['naziv'].'<br/>';
		}
	}

$passhtml['ID']=$ID;
$passhtml['aa']=$aa;
$passhtml['bb']=$bb;
$passhtml['syna']=$syna;
$passhtml['synb']=$synb;
$passhtml['coma']=$coma;
$passhtml['comb']=$comb;
$passhtml['grupe']=$grupesend;
echo json_encode($passhtml);
?>