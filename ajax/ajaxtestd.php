<?php
$recnik = isset($_GET["recnik"]) ? $_GET["recnik"] : 0;
$posebno = isset($_GET["posebno"]) ? $_GET["posebno"] : 0;

include '../config.php';

$sql="SELECT * FROM $recnik WHERE `ID`='$posebno'";
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$passhtml='';
$count=0;
while($row=$result->fetch_assoc()) {
	foreach($row as $xx => $yy) {
		$$xx=$yy;
	}
	$passhtml.='<h4>'.$naziv.'</h4>';
	$passhtml.='<div class="ucenjed">';

$a=explode('$#!$',$dizajn);
$sep1=$a[0];
$sep2=$a[1];
$cent1=$a[2];
$cent2=$a[3];
$sirina1=explode(',',$a[4]);
$sirina2=explode(',',$a[5]);
$b=explode('$#$,',$a[6]);
$odg=explode(',',$odgovori);
$ecount=1;
$ocount=0;
$usirina1=0;
foreach($sirina1 as $sirx) {
	$usirina1=$usirina1+($sirx*30)+10;
}
$usirina2=0;
foreach($sirina2 as $sirx) {
	$usirina2=$usirina2+($sirx*30)+10;
}
$cellcountall1=count($sirina1);
$cellcountall2=count($sirina2);
if ($sep1!=0 and $sep1!='' and $sep1!=$cellcountall1) $usirina1=$usirina1+3;
if ($sep2!=0 and $sep2!='' and $sep2!=$cellcountall2) $usirina2=$usirina2+3;

	foreach ($b as $inb) {
		$passhtml.='<div style="overflow:hidden;margin-bottom:5px">';
		$c=explode('$y$,',$inb);
		foreach ($c as $inc) {
			$passhtml.='<div style="overflow:hidden;width:'.${'usirina'.$ecount}.'px';
			if (${'cent'.$ecount}==1) $passhtml.=';margin:0 auto';
			$passhtml.='">';
			$d=explode(',',$inc);
			$cellcount=1;
			foreach ($d as $ind) {
				$cellcountx=$cellcount-1;
				if ($cellcount==(${'sep'.$ecount}+1) AND $cellcount!=1) $passhtml.='<div style="width:1px;height:30px;background:#333;float:left;padding:0;"></div>';
				$passhtml.='<div style="float:left;width:';
				$passhtml.=${'sirina'.$ecount}[$cellcountx]*30;
				$passhtml.='px';
				if ($ind=='$x$') $passhtml.=';border-color:#fff;background:#fff';
				$passhtml.='">';
				if ($ind=='$!$') {
					$passhtml.='<input type="text" name="odgovor'.$ocount.'" style="width:100%" autocomplete="off"/>';
					$ocount++;
				}
				elseif ($ind=='$x$') $passhtml.="";
				else {
					$da=substr($ind,0,1);
					$db=substr($ind,3);
					
					switch ($da) {
						case 1:
							$passhtml.='<div class="uelem">'.$db.'</div>';
							break;
						case 2:
							$passhtml.='<div class="uelem"><b>'.$db.'</b></div>';
							break;
						case 3:
							$passhtml.='<div class="uelem"><i>'.$db.'</i></div>';
							break;
						case 4:
							$passhtml.='<div class="uelem"><b><i>'.$db.'</i></b></div>';
							break;
						case 5:
							$passhtml.='<div class="uelem" style="text-align:right">'.$db.'</div>';
							break;
						case 6:
							$passhtml.='<div class="uelem" style="text-align:right"><b>'.$db.'</b></div>';
							break;
						case 7:
							$passhtml.='<div class="uelem" style="text-align:right"><i>'.$db.'</i></div>';
							break;
						case 8:
							$passhtml.='<div class="uelem" style="text-align:right"><b><i>'.$db.'</i></b></div>';
							break;
					}
				}
				$passhtml.="</div>";
				$cellcount++;
			}
			$passhtml.="</div>";
		}
		$passhtml.="</div>";
	$ecount++;
	}

	$passhtml.='</div><input id="posebno" type="hidden" name="posebnox" value="'.$posebno.'"/><input type="hidden" id="check" value="1" /></br>';
	$count++;
}
	
$pass['passhtml']=$passhtml;
echo json_encode($pass);
?>