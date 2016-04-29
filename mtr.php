<?php
	session_start();
	$uri=$_SERVER['REQUEST_URI'];
	$pos = strrpos($uri, "/");
	$url = substr($uri, $pos+1);
	if ($_SESSION['loggedin'] != 1 OR $_SESSION['level'] <3 ) {
		header("Location: login.php?url=$url");
		exit;
	}
	else {
	include 'config.php';
	$level=$_SESSION['level'];
	$userx=$_SESSION['user'];
	}
	
$recnik = isset($_GET["recnik"]) ? $_GET["recnik"] : 0;
$koliko = isset($_GET["koliko"]) ? $_GET["koliko"] : 0;
$opcija = isset($_GET["opcija"]) ? $_GET["opcija"] : 0;
$tipt = isset($_GET["tipt"]) ? $_GET["tipt"] : 0;

$recnikx=explode("-",$recnik);
$recnik=$recnikx[1];
$smer=$recnikx[0];

?>
<html>
<head profile="http://www.w3.org/2005/20/profile">
<link rel="icon"
	  type="image/png"
	  href="images/favicon.gif">
<title id="Timerhead">Lingo 2.0 - Test reči na mobilnom</title>
<link type='text/css' rel='stylesheet' href='style.css' />
<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<style type="text/css">
body {
	width:345px;
	height:400px;
	font-size:18px;
	line-height:48px;
}
input {
	font-size:18px;
	height:42px;
	width:100%;
	margin-bottom:3px;
}
p {
	margin:0 0 3px 0;
}
</style>
<meta name="robots" content="noindex">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="HandheldFriendly" content="true"></head>
<body>
<form action="#" method="POST">
<input type="hidden" id="precnik" name="precnik" value="<?php echo $recnik; ?>" />
<input type="hidden" id="psmer" name="psmer" value="<?php echo $smer; ?>" />
<input type="hidden" id="pkoliko" name="pkoliko" value="<?php echo $koliko; ?>" />
<input type="hidden" id="popcija" name="popcija" value="<?php echo $opcija; ?>" />
<input type="hidden" id="ptipt" name="ptipt" value="<?php echo $tipt; ?>" />
<input type="hidden" id="tpitanje" name="tpitanje" value="1" />
<input type="hidden" id="uktac" name="uktac" value="0" />
<input type="hidden" id="sent" name="sent" />
<input type="hidden" id="userx" name="userx" value="<?php echo $userx; ?>" />

<?php

$sql='SELECT AVG(procenat) AS avg,MIN(procenat) AS min,MAX(procenat) AS max FROM `test_reci_m` WHERE recnik="'.$recnik.'" AND smer="'.$smer.'" AND `user` = "'.$user.'"';
$result = $mysqli->query($sql) or die;
$row=$result->fetch_assoc();
$avg=round($row['avg'],4);
$min=round($row['min'],4);
$max=round($row['max'],4);
$himin=round(($min+$avg)/2,4);
$lomax=round(($avg+$max)/2,4);

switch ($tipt) {
	case 1:
		$sql ='SELECT SQL_CALC_FOUND_ROWS *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND `user` = "'.$user.'"
				WHERE (t.ukupno < 4 OR t.ukupno IS NULL)
				ORDER BY RAND()
				LIMIT '.$koliko;
		break;
	case 2:
		$sql ='SELECT SQL_CALC_FOUND_ROWS *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$min.' AND t.procenat <'.$himin.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND `user` = "'.$user.'"
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$koliko;
		break;
	case 3:
		$sql ='SELECT SQL_CALC_FOUND_ROWS *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$himin.' AND t.procenat <'.$avg.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND `user` = "'.$user.'"
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$koliko;
		break;
	case 4:
		$sql ='SELECT SQL_CALC_FOUND_ROWS *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$avg.' AND t.procenat <'.$lomax.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND `user` = "'.$user.'"
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$koliko;
		break;
	case 5:
		$sql ='SELECT SQL_CALC_FOUND_ROWS *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$lomax.' AND t.procenat <='.$max.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND `user` = "'.$user.'"
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$koliko;
		break;
	case 6:
		$klk1=ceil($koliko*0.6);
		$klk2=round(($koliko-$klk1)*0.5);
		$klk3=round(($koliko-$klk1-$klk2)*0.5);
		$klk4=$koliko-$klk1-$klk2-$klk3;
		$sql ='(SELECT *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$min.' AND t.procenat <'.$himin.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND `user` = "'.$user.'"
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$klk1.')
					UNION
				(SELECT *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$himin.' AND t.procenat <'.$avg.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND `user` = "'.$user.'"
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$klk2.')
					UNION
				(SELECT *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$avg.' AND t.procenat <'.$lomax.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND `user` = "'.$user.'"
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$klk3.')
					UNION
				(SELECT *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$lomax.' AND t.procenat <='.$max.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND `user` = "'.$user.'"
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$klk4.')
				ORDER BY RAND()';
		break;
	case 7:
		$klk1=ceil($koliko*0.7);
		$klk2=round(($koliko-$klk1)*0.66);
		$klk3=$koliko-$klk1-$klk2;
		$sql ='(SELECT *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$himin.' AND t.procenat <'.$avg.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND `user` = "'.$user.'"
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$klk1.')
					UNION
				(SELECT *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$avg.' AND t.procenat <'.$lomax.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND `user` = "'.$user.'"
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$klk2.')
					UNION
				(SELECT *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$lomax.' AND t.procenat <='.$max.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND `user` = "'.$user.'"
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$klk3.')
				ORDER BY RAND()';
		break;
	case 8:
		$klk1=ceil($koliko*0.8);
		$klk2=$koliko-$klk1;
		$sql ='(SELECT *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$avg.' AND t.procenat <'.$lomax.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND `user` = "'.$user.'"
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$klk1.')
					UNION
				(SELECT *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE (t.procenat >='.$lomax.' AND t.procenat <='.$max.') AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND `user` = "'.$user.'"
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
				WHERE t.datum <"'.$premesec.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND `user` = "'.$user.'"
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$koliko;
		break;
	case 10:
		$presedmicu=date('Y-m-d',strtotime("-1 week"));
		$sql='SELECT *, r.ID rid
				FROM '.$recnik.' AS r
				 LEFT JOIN test_reci AS t ON r.ID = t.idreci
				WHERE t.datum <"'.$presedmicu.'"'.$insnaosnovu.' AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND `user` = "'.$user.'"
				GROUP BY r.ID
				ORDER BY RAND()
				LIMIT '.$koliko;
		break;
	case 11:
		$sql ='SELECT SQL_CALC_FOUND_ROWS *, ID rid FROM '.$recnik.' ORDER BY RAND() LIMIT '.$koliko;
		break;
}
$result = $mysqli->query($sql) or die;
$totrows = mysqli_num_rows ($result);
echo '<input type="hidden" id="ukpitanja" value="'.$totrows.'"/>';

$rc=1;
$ostalih=$opcija-1;

while ($row=$result->fetch_assoc()) {
 	$ID=$row['rid'];
	$aa=$row['aa'];
	$bb=$row['bb'];
	$coma=$row['coma'];
	$comb=$row['comb'];
	$syna=$row['syna'];
	$synb=$row['synb'];
	$ukupno=$row['ukupno'];
	$procenat=$row['procenat'];
	
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
    
	echo '<div id="wrap_'.$rc.'"';
	if ($rc=='1') echo ' style="display:inline"';
	else echo ' style="display:none"';
	echo '><center><p><b>'.$recx.'</b>';
	if ($comx!="") echo '<br/><i>('.$comx.')</i>';
	echo '</p></center>';
	$dugmici=array();
	$rcb=1;
	
	$sql3='SELECT ID, aa, bb FROM `'.$recnik.'` WHERE `ID` <> "'.$ID.'" ORDER BY RAND() LIMIT '.$ostalih;
	$result3 = $mysqli->query($sql3) or die;
	while ($row3=$result3->fetch_assoc()) {
	$IDx=$row3['ID'];
	$aax=$row3['aa'];
	$bbx=$row3['bb'];
	if ($smer=='a') $recyx=$bbx;
	else $recyx=$aax;
		$dugmici[$rcb]=array($IDx,$recyx);
		$rcb++;
	}
	$dugmici[$opcija]=array($ID,$recy);
	shuffle($dugmici);

	for ($c = 0; $c <= $ostalih; $c++) {
		echo '<input type="button" id="dugme_'.$rc.'_'.$dugmici[$c][0].'" value="'.$dugmici[$c][1].'" onclick="odgovor('.$rc.','.$dugmici[$c][0].')"/>';
	}
	
	echo '<input type="hidden" id="did_'.$rc.'" value="0"/>';
	echo '<input type="hidden" id="id_'.$rc.'" name="id_'.$rc.'" value="'.$ID.'"/>';
	echo '<input type="hidden" id="ukupno_'.$rc.'" name="ukupno_'.$rc.'" value="'.$ukupno.'"/>';
	echo '<input type="hidden" id="procenat_'.$rc.'" name="procenat_'.$rc.'" value="'.$procenat.'"/>';
	echo '<input type="hidden" id="tacno_'.$rc.'" name="tacno_'.$rc.'" value="'.$recy.'"/>';
	echo '<input type="hidden" id="alt_'.$rc.'" name="alt_'.$rc.'" value="'.$recs.'"/>';
	echo '<input type="hidden" id="uspeo_'.$rc.'" name="uspeo_'.$rc.'" value="0"/></div>';
	$rc++;
}
	echo '<div id="wrap_zadnje"></div>';
?>

</form>
<script type="text/javascript">
function odgovor(pitanje,odgovor)
{
	var recnik = document.getElementById('precnik').value;
	var smer = document.getElementById('psmer').value;
	var ukpitanja = document.getElementById('ukpitanja').value;
	var uktac = document.getElementById('uktac');
	var uktacv = uktac.value;
	var sent = document.getElementById('sent');
	var sentv = sent.value;
	var ukupno = document.getElementById('ukupno_'+pitanje).value;
	var procenat = document.getElementById('procenat_'+pitanje).value;
	var tid = document.getElementById('id_'+pitanje).value;
	var alt = document.getElementById('alt_'+pitanje).value;
	var ovaj = document.getElementById('dugme_'+pitanje+'_'+odgovor);
	var tacni = document.getElementById('dugme_'+pitanje+'_'+tid);
	var ova = ovaj.value;
	var did = document.getElementById('did_'+pitanje);
	var sledece = pitanje + 1;
	if (ukupno=="") ukupno='0';
	if (procenat=="") procenat='0';
	if (did.value == 0) {
		if (tid == odgovor) {
		ovaj.style.border='2px solid #5a5';
		uktac.value=+uktacv + +1;
		sent.value=sentv+tid+'x'+ukupno+'x'+procenat+'x1y';
		}
		else if (alt.indexOf(ova) !==-1) {
		ovaj.style.border='2px solid #5a5';
		tacni.style.border='2px solid #35a';
		uktac.value=+uktacv + +1;
		sent.value=sentv+tid+'x'+ukupno+'x'+procenat+'x1y';
		}
		else {
		ovaj.style.border='2px solid #a55';
		tacni.style.border='2px solid #35a';
		sent.value=sentv+tid+'x'+ukupno+'x'+procenat+'x0y';
		}
		did.value='1';
	}
	else {
		if (ukpitanja == pitanje) {
			$("#wrap_"+pitanje).hide();
			$("#wrap_zadnje").show();
			uktacv = document.getElementById('uktac').value;
			var precnik = document.getElementById('precnik').value;
			var psmer = document.getElementById('psmer').value;
			var pkoliko = document.getElementById('pkoliko').value;
			var popcija = document.getElementById('popcija').value;
			var ptipt = document.getElementById('ptipt').value;
			var sentx = document.getElementById('sent').value;
			var userx = document.getElementById('userx').value;
			sentx = sentx.substring(0, sentx.length - 1);			
			$.getJSON('ajax/ajaxmtr.php', {sent: sentx, info: recnik+','+smer+','+userx}, function(data) {
				document.getElementById('wrap_zadnje').innerHTML='<div>Tačnih ' + uktacv + ' od ukupno ' + ukpitanja + '</div><div><a href="mtr.php?recnik=' + psmer + '-' + precnik + '&koliko=' + pkoliko + '&opcija=' + popcija + '&tipt=' + ptipt + '">Ponovo?</a></div><div><a href="mtrprep.php">Promena parametara testa</a></div>';
			});
		}
		else {
			$("#wrap_"+pitanje).hide();
			$("#wrap_"+sledece).show();
		}
	}
}
</script>
</body>
</html>