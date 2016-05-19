<?php
session_start();
$uri=$_SERVER['REQUEST_URI'];
$pos = strrpos($uri, "/");
$url = substr($uri, $pos+1);
include 'config.php';
if ($_SESSION['loggedin'] != 1 OR $_SESSION['level'] == 0 ) {
	header("Location: login.php?url=$url");
	exit;
}
else {
$level=$_SESSION['level'];
$user=$_SESSION['user'];
}
$datumx=date('Y-m-d');

if (isset($_POST['recnik'])) $recnik=mysqli_real_escape_string($mysqli,$_POST['recnik']);
else $recnik="";

?>
<html>
<head profile="http://www.w3.org/2005/20/profile">
<link rel="icon"
	  type="image/png"
	  href="images/favicon.gif">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title id="Timerhead">Lingo 2.3 - Test deklinacija</title>
<link type='text/css' rel='stylesheet' href='style.css' />
<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<style type="text/css">
h4 {
	margin:5px 0;
}
</style>
<meta name="robots" content="noindex">
</head>
<body onload="ajax_request2()">
<form id="glavni" action="#" method="POST">
<?php include 'topbar.php'; ?>

<div id="kolona_l" class="kolona" style="margin:0 0 10px 20px;float:left">
	<div class="box">
		<h3>Rečnik</h3>
		<div class="side_unutra" style="height:26px">
			<select name="recnik" id="recnik" style="width:100%" onchange="ajax_request2()">
<?php
$sql ='SELECT * FROM recnici ORDER BY `naziv`';
$result = $mysqli->query($sql) or die;

while ($row=$result->fetch_assoc()) {
$tabela = $row['tabela'];
$naziv= $row['naziv'];
if ($recnik=="") $recnik=$tabela;
			echo '<option value="'.$tabela.'"';
			if ($tabela==$recnik) echo 'selected="selected"';
			echo ' >'.$naziv.'</option>';
}

if (isset($_POST['recnik'])) {
	
	$smerpo=mysqli_real_escape_string($mysqli,$_POST['smerpo']);
	$selpo=mysqli_real_escape_string($mysqli,$_POST['selpo']);

}
else {

	$smerpo=1;
	$selpo=1;

}

?>
			</select>
		</div>
	</div>
	<div class="box">
		<h3>Postojeće deklinacije</h3>
		<div id="prelist" style="border-bottom: 1px solid black;padding:0 0 2px 8px;width:292px;font-size:12pt;;margin:2px 0 0 0;">
			Sortiraj
			<select name="smerpo" id="smerpo" onchange="ajax_request2()">
				<option value="1" <?php if ($smerpo==1) echo 'selected="selected"'; ?>>rastuće</option>
				<option value="2" <?php if ($smerpo==2) echo 'selected="selected"'; ?>>opadajuće</option>
			</select>
			po
			<select name="selpo" id="selpo" onchange="ajax_request2()">
				<option value="1" <?php if ($selpo==1) echo 'selected="selected"'; ?>>rednom broju</option>
				<option value="2" <?php if ($selpo==2) echo 'selected="selected"'; ?>>nazivu</option>
				<option value="3" <?php if ($selpo==3) echo 'selected="selected"'; ?>>procentu uspeha</option>
				<option value="4" <?php if ($selpo==4) echo 'selected="selected"'; ?>>broju pokušaja</option>
				<option value="5" <?php if ($selpo==5) echo 'selected="selected"'; ?>>datumu</option>
			</select>
		</div>
		<div class="side_unutra" id="listareci" style="padding-top:0">
		</div>
	</div>
</div>

<div id="kolona_d" class="kolona" style="margin:0 20px 10px 0;float:right">
	<div class="box">
		<h3>Opcije</h3>
		<div class="side_unutra">
			<input type="submit" id="Unesi" value="Proveri test" style="width:inherit" <?php
			if (isset($_POST['recnik'])) echo 'disabled="disabled"';
			?>/>
		</div>
	</div>
</div>

<div id="kolona_c" class="kolona" style="width:550px;margin:50px auto 20px;z-index:999">
	<div class="box">
		<h3 style="width: 524px;">Deklinacija</h3>
		<div id="centralni_box" style="width:510px;overflow-y:auto;overflow-x:hidden">

<?php
if (isset($_POST['recnik'])) {

	foreach($_POST as $xx => $yy) {
		$$xx=mysqli_real_escape_string($mysqli,$yy);
	}

	$sql="SELECT * FROM $recnik WHERE `ID`='$posebnox'";
	$result = $mysqli->query($sql) or die;
	$row=$result->fetch_assoc();
		foreach($row as $xx => $yy) {
			$$xx=$yy;
		}
		echo '<h4>'.$naziv.'</h4>';
		echo '<div class="ucenjed">';

	$a=explode('$#!$',$dizajn);
	$sep1=$a[0];
	$sep2=$a[1];
	$cent1=$a[2];
	$cent2=$a[3];
	$sirina1=explode(',',$a[4]);
	$sirina2=explode(',',$a[5]);
	$b=explode('$#$,',$a[6]);
	$odg=explode(',',$odgovori);
	$ukupnoo=count($odg);
	$ecount=1;
	$ocount=0;
	$tcount=0;
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
		echo '<div style="overflow:hidden;margin-bottom:5px">';
		$c=explode('$y$,',$inb);
		foreach ($c as $inc) {
			echo '<div style="overflow:hidden;width:'.${'usirina'.$ecount}.'px';
			if (${'cent'.$ecount}==1) echo ';margin:0 auto';
			echo '">';
			$d=explode(',',$inc);
			$cellcount=1;
			foreach ($d as $ind) {
				$cellcountx=$cellcount-1;
				if ($cellcount==(${'sep'.$ecount}+1) AND $cellcount!=1) echo '<div style="width:1px;height:30px;background:#333;float:left;padding:0;"></div>';
				echo '<div style="float:left;width:';
				echo ${'sirina'.$ecount}[$cellcountx]*30;
				echo 'px';
				if ($ind=='$x$') echo ';border:none;background:#fff';
				elseif ($ind=='$!$' AND ${'odgovor'.$ocount}==$odg[$ocount]) {
				echo ';background:#dfd';
				$tcount++;
				}
				elseif ($ind=='$!$' AND ${'odgovor'.$ocount}!=$odg[$ocount]) {
				echo ';background:#fdd';
				}
				echo '">';
				if ($ind=='$!$') {
					echo '<input disabled="disabled" type="text" style="width:100%" title="'.$odg[$ocount].'" value="'.${'odgovor'.$ocount}.'"/>';
					$ocount++;
				}
				elseif ($ind=='$x$') echo "";
				else {
					$da=substr($ind,0,1);
					$db=substr($ind,3);
					
					switch ($da) {
						case 1:
							echo '<div class="uelem">'.$db.'</div>';
							break;
						case 2:
							echo '<div class="uelem"><b>'.$db.'</b></div>';
							break;
						case 3:
							echo '<div class="uelem"><i>'.$db.'</i></div>';
							break;
						case 4:
							echo '<div class="uelem"><b><i>'.$db.'</i></b></div>';
							break;
						case 5:
							echo '<div class="uelem" style="text-align:right">'.$db.'</div>';
							break;
						case 6:
							echo '<div class="uelem" style="text-align:right"><b>'.$db.'</b></div>';
							break;
						case 7:
							echo '<div class="uelem" style="text-align:right"><i>'.$db.'</i></div>';
							break;
						case 8:
							echo '<div class="uelem" style="text-align:right"><b><i>'.$db.'</i></b></div>';
							break;
					}
				}
				echo "</div>";
				$cellcount++;
			}
			echo "</div>";
		}
		
		echo '</div>';
	$ecount++;
	}

	echo '<br/><div style="text-align:center"><input type="button" id="again" onclick="ajax_request('.$posebnox.')" value="Ponovi isti test" /></div></div><input id="posebno" type="hidden" name="posebnox" value="'.$posebnox.'"/><input type="hidden" id="check" value="2" /></br>';
	
		$sql='SELECT *, COUNT(*) as cnt,ID as idsel FROM test_dek WHERE user="'.$user.'" AND recnik="'.$recnik.'" AND iddek="'.$posebnox.'"';
		$result = $mysqli->query($sql) or die;
		$row=$result->fetch_assoc();
		$ukupno=$row['ukupno'];
		$procenat=$row['procenat'];
		$idsel=$row['idsel'];
	
		$tpr=$tcount/$ukupnoo;
		
	if ($row['cnt']==1) {
	
		$nukupno=$ukupno+1;
		
		if ($ukupno>7) {
		$nprocenat=($procenat*7+$tpr)/8;
		}
		else {
		$nprocenat=($procenat*$ukupno+$tpr)/$nukupno;
		}
		
		$sql='UPDATE test_dek SET ukupno="'.$nukupno.'", procenat="'.$nprocenat.'", datum="'.$datumx.'" WHERE ID="'.$idsel.'"';
	}
	else {
		$sql='INSERT INTO test_dek (user, recnik, iddek, ukupno, procenat, datum) VALUES ("'.$user.'","'.$recnik.'","'.$posebnox.'","1","'.$tpr.'","'.$datumx.'") ';
	}
	$mysqli->query($sql) or die;
		
	$sql='INSERT INTO test_rezultati (user, recnik, smer, vrsta, ukupno, tacnih, datum) VALUES ("'.$user.'","'.$recnik.'","x","dek","'.$ukupnoo.'","'.$tcount.'","'.$datumx.'")';
	$mysqli->query($sql) or die;

}
?>
		</div>
	</div>
</div>

<script type="text/javascript">
 var viewportwidth;
 var viewportheight;
 if (typeof window.innerWidth != 'undefined')
 {
      viewportwidth = window.innerWidth,
      viewportheight = window.innerHeight
 }
 else if (typeof document.documentElement != 'undefined'
     && typeof document.documentElement.clientWidth !=
     'undefined' && document.documentElement.clientWidth != 0)
 {
       viewportwidth = document.documentElement.clientWidth,
       viewportheight = document.documentElement.clientHeight
 }
 else
 {
       viewportwidth = document.getElementsByTagName('body')[0].clientWidth,
       viewportheight = document.getElementsByTagName('body')[0].clientHeight
 }

if (viewportheight < 400)
{
document.getElementById("kolona_l").style.height=325;
document.getElementById("kolona_c").style.height=325;
document.getElementById("kolona_d").style.height=325;
document.getElementById("listareci").style.height=159;
document.getElementById("centralni_box").style.height=255;
} 
else
{
document.getElementById("kolona_l").style.height=viewportheight-75;
document.getElementById("kolona_c").style.height=viewportheight-75;
document.getElementById("kolona_d").style.height=viewportheight-75;
document.getElementById("listareci").style.height=viewportheight-265;
document.getElementById("centralni_box").style.height=viewportheight-145;
}

console.log(viewportwidth);

if (viewportwidth < 1280)
{
	if (viewportheight>=400) {
		document.getElementById("listareci").style.height=viewportheight-289;
	}
	document.getElementById("kolona_l").style.width=250;
	document.getElementById("prelist").style.width=242;
	document.getElementById("kolona_l").style.margin='0 0 10px 5px';
	document.getElementById("kolona_c").style.width=450;
	document.getElementById("kolona_d").style.width=250;
	document.getElementById("kolona_d").style.margin='0 5px 10px 0';
	$(".box h3").css("width","224px");
	$("#kolona_c h3").css("width","424px");
	$(".box div input").css("width","195px");
	$("#recnik").css("width","210px");
	$(".pojed_reci").css("width","400px");
	$("#centralni_box").css("width","410px");
	$("#centralni_box > div > div").css("width","195px");
	$(".side_unutra").css("width","210px");
	$("#listareci").css("width","240px");
	$("#listareci div").css("width","230px");
	$("#listareci div div").css("width","230px");
	$("#listareci div div div").css("width","111px");
}
function ajax_request(posebno)
	{
	$.getJSON('ajax/ajaxtestd.php', {posebno:posebno,recnik: $('#recnik').val()}, function(data) {
		$('#centralni_box').html(data.passhtml);
		});
	document.getElementById("Unesi").disabled='';
	}
function ajax_request2()
	{
	
	$.getJSON('ajax/ajaxtestddek.php', {recnik: $('#recnik').val(),smerpo: $('#smerpo').val(),selpo: $('#selpo').val()}, function(data) {
		$('#listareci').html(data.pass2html);
		});
	}
</script>
</form>
</body>
</html>