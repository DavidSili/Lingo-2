<?php
include '../config.php';
$htmlpass='';
$sql="SELECT * FROM quotes ORDER BY `ID` DESC";
$result=mysql_query($sql)) or die;
while($row=mysql_fetch_assoc($result)) {
	foreach($row as $xx => $yy) {
		$$xx=$yy;
	}
	if ((strlen($quote)-4)>100) {
	$pos=strpos($quote, ' ', 100);
	$quote=substr($quote,0,$pos ).'...';
	}
	if ($autor==NULL) $autor="Nepoznati autor";
	$htmlpass.='<div id="blacklink" onclick="ajax_request('.$ID.')" ><a href="#"><b>'.$autor.'</b> - "'.$quote.'"</a></div>';
	
}
$pass['htmlpass']=$htmlpass;
echo json_encode($pass);

?>