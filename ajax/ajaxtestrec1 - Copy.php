<?php
include '../config.php';
$klk = isset($_GET["koliko"]) ? $_GET["koliko"] : 0;
$naosnovu = isset($_GET["naosnovu"]) ? $_GET["naosnovu"] : 0;
$tipt = isset($_GET["tipt"]) ? $_GET["tipt"] : 0;
$userx = isset($_GET["userx"]) ? $_GET["userx"] : 0;

$passhtml="";
$sql ='SELECT tabela FROM jezici ORDER BY `ime` LIMIT 1';
$result = mysql_query ($sql) or die;
$row = mysql_fetch_assoc ($result);
if (isset($_GET['recnik'])) {
$recnikx=explode("-",$_GET['recnik']);
$recnik=$recnikx[1];
$smer=$recnikx[0];
}
else {
$recnik=$row['tabela'];
$smer='a';
}

switch ($naosnovu) {
	case 1:
		$insnaosnovu=' AND `user` = "'.$userx.'"';
		break;
	case 2:
		$insnaosnovu='';
		break;
}

$sql='SELECT AVG(procenat) AS avg,MIN(procenat) AS min,MAX(procenat) AS max FROM `test_reci` WHERE recnik="'.$recnik.'" AND smer="'.$smer.'"'.$insnaosnovu;
$result=mysql_query($sql) or die;
$row=mysql_fetch_assoc($result);
$avg=round($row['avg'],4);
$min=round($row['min'],4);
$max=round($row['max'],4);
$himin=round(($min+$avg)/2,4);
$lomax=round(($avg+$max)/2,4);
switch ($tipt) {
	case 1:
		$sql ='SELECT SQL_CALC_FOUND_ROWS *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci AND recnik="'.$recnik.'" AND smer="'.$smer.'"'.$insnaosnovu.'
				WHERE (t.ukupno < 4 OR t.ukupno IS NULL)
				ORDER BY RAND()
				LIMIT '.$klk;
		break;
	case 2:
		$sql ='SELECT SQL_CALC_FOUND_ROWS *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$min.' AND t.procenat <'.$himin.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" '.$insnaosnovu.'
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$klk;
		break;
	case 3:
		$sql ='SELECT SQL_CALC_FOUND_ROWS *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$himin.' AND t.procenat <'.$avg.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" '.$insnaosnovu.'
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$klk;
		break;
	case 4:
		$sql ='SELECT SQL_CALC_FOUND_ROWS *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$avg.' AND t.procenat <'.$lomax.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" '.$insnaosnovu.'
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$klk;
		break;
	case 5:
		$sql ='SELECT SQL_CALC_FOUND_ROWS *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$lomax.' AND t.procenat <='.$max.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" '.$insnaosnovu.'
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$klk;
		break;
	case 6:
		$klk1=ceil($klk*0.6);
		$klk2=round(($klk-$klk1)*0.5);
		$klk3=round(($klk-$klk1-$klk2)*0.5);
		$klk4=$klk-$klk1-$klk2-$klk3;
		$sql ='(SELECT *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$min.' AND t.procenat <'.$himin.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" '.$insnaosnovu.'
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$klk1.')
					UNION
				(SELECT *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$himin.' AND t.procenat <'.$avg.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" '.$insnaosnovu.'
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$klk2.')
					UNION
				(SELECT *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$avg.' AND t.procenat <'.$lomax.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" '.$insnaosnovu.'
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$klk3.')
					UNION
				(SELECT *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$lomax.' AND t.procenat <='.$max.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" '.$insnaosnovu.'
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$klk4.')
				ORDER BY RAND()';
		break;
	case 7:
		$klk1=ceil($klk*0.7);
		$klk2=round(($klk-$klk1)*0.66);
		$klk3=$klk-$klk1-$klk2;
		$sql ='(SELECT *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$himin.' AND t.procenat <'.$avg.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" '.$insnaosnovu.'
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$klk1.')
					UNION
				(SELECT *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$avg.' AND t.procenat <'.$lomax.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" '.$insnaosnovu.'
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$klk2.')
					UNION
				(SELECT *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$lomax.' AND t.procenat <='.$max.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" '.$insnaosnovu.'
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$klk3.')
				ORDER BY RAND()';
		break;
	case 8:
		$klk1=ceil($klk*0.8);
		$klk2=$klk-$klk1;
		$sql ='(SELECT *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$avg.' AND t.procenat <'.$lomax.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" '.$insnaosnovu.'
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$klk1.')
					UNION
				(SELECT *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$lomax.' AND t.procenat <='.$max.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" '.$insnaosnovu.'
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$klk2.')
				ORDER BY RAND()';
		break;
	case 9:
		$premesec=date('Y-m-d',strtotime("-1 month"));
		$sql='SELECT *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE t.datum <"'.$premesec.'"'.$insnaosnovu.' AND recnik="'.$recnik.'" AND smer="'.$smer.'" '.$insnaosnovu.'
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$klk;
		break;
	case 10:
		$presedmicu=date('Y-m-d',strtotime("-1 week"));
		$sql='SELECT *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE t.datum <"'.$presedmicu.'"'.$insnaosnovu.' AND recnik="'.$recnik.'" AND smer="'.$smer.'" '.$insnaosnovu.'
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$klk;
		break;
	case 11:
		$sql ='SELECT SQL_CALC_FOUND_ROWS *, ID rid FROM '.$recnik.' ORDER BY RAND() LIMIT '.$klk;
		break;
}
$sql2='SELECT FOUND_ROWS()';
$result = mysql_query ($sql) or die;
$result2 = mysql_query ($sql2) or die;
$row2=mysql_fetch_assoc($result2);
$totrows=$row2['FOUND_ROWS()'];
$rc=1;
while ($row = mysql_fetch_assoc ($result)) {

	$ID=$row['rid'];
	$aa=$row['aa'];
	$bb=$row['bb'];
	$coma=$row['coma'];
	$comb=$row['comb'];
	$syna=$row['syna'];
	$synb=$row['synb'];
	
	if ($smer=='a') {
	$comx=$coma;
	$recx=$aa;
	$recy=$bb;
	$recs=$synb;
	}
	else {
	$comx=$comb;
	$recx=$bb;
	$recy=$aa;
	$recs=$syna;
	}
	$passhtml.='<div class="pojed_reci" style="background:#';
	if ( $rc & 1 ) $passhtml.='ddd';
		else $passhtml.='fff';
	$passhtml.=';"><div><a href="#" title="'.$comx.'" style="cursor:help';
	if ($comx!="") $passhtml.=';border-bottom: 1px #333 dashed';
	$passhtml.='" tabindex="-1">'.$recx.'</a><input type="text" name="recz'.$rc.'" style="float:right" autocomplete="off" ><input type="hidden" name="comx'.$rc.'" value="'.$comx.'"/><input type="hidden" name="recx'.$rc.'" value="'.$recx.'"/><input type="hidden" name="recy'.$rc.'" value="'.$recy.'"/><input type="hidden" name="recs'.$rc.'" value="'.$recs.'"/><input type="hidden" name="reci'.$rc.'" value="'.$ID.'"/></div></div>';
	$rc++;
}
$rc--;
$passhtml.='<input type="hidden" name="recniky" value="'.$recnik.'"/><input type="hidden" name="smery" value="'.$smer.'"/><input type="hidden" name="kolikox" value="'.$klk.'"/><input type="hidden" name="naosnovuy" value="'.$naosnovu.'"/><input type="hidden" name="tipty" value="'.$tipt.'"/><input type="hidden" name="ukupnoreci" value="'.$rc.'"/>';
$pass['passhtml']=$passhtml;
$pass['totrows']='reči u grupi: '.$totrows;
echo json_encode($pass);
?>