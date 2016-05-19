<?php
include '../config.php';
$sent = isset($_GET["sent"]) ? $_GET["sent"] : 0;
$info = isset($_GET["info"]) ? $_GET["info"] : 0;
$sent = $mysqli->real_escape_string($sent);
$info = $mysqli->real_escape_string($info);
$sent=explode('y',$sent);
$info=explode(',',$info);
$recnik=$info[0];
$smer=$info[1];
$userx=$info[2];

foreach($sent as $x=>$y) {
	$sent[$x]=explode('x',$y);
}

$datum=date('Y-m-d');

foreach($sent as $a=>$b) {
	$IDp=$b[0];
	$ukupno=$b[1];
	$procenat=$b[2];
	$ok=$b[3];
	$nukupno=$ukupno+1;
	if ($ukupno>7) {
		$nprocenat=($procenat*7+$ok)/8;
	}
	else {
		$nprocenat=($procenat*$ukupno+$ok)/$nukupno;
	}
	if ($ukupno==0) {
	$sql='INSERT INTO `test_reci_m` (`user`,`recnik`,`smer`,`idreci`,`ukupno`,`procenat`,`datum`) VALUES ("'.$userx.'","'.$recnik.'","'.$smer.'","'.$IDp.'",1,'.$ok.',"'.$datum.'") ';
	}
	else {
	$sql='UPDATE `test_reci_m` SET `ukupno`="'.$nukupno.'",`procenat`="'.$nprocenat.'",`datum`="'.$datum.'" WHERE `user`="'.$userx.'" AND `recnik`="'.$recnik.'" AND `smer`="'.$smer.'" AND `idreci`="'.$IDp.'"';
	}
	$mysqli->query($sql) or die;

}

$pass['passhtml']=$sent;
echo json_encode($pass);
?>