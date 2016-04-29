<?php
	session_start();
	$uri=$_SERVER['REQUEST_URI'];
	$pos = strrpos($uri, "/");
	$url = substr($uri, $pos+1);
	if ($_SESSION['loggedin'] != 1 OR $_SESSION['level'] == 0 ) {
		header("Location: login.php?url=$url");
		exit;
	}
	else {
	include 'config.php';
	$level=$_SESSION['level'];
	$user=$_SESSION['user'];
	}
	
if (isset($_POST['koliko'])) {
	$go=1;
	foreach($_POST as $xx => $yy) {
		$$xx=$yy;
	}
	
}
else {
$koliko=20;
$naosnovu=1;
$tipt=11;
$go=0;
$grupe="sve_reci";
}

?>
<html>
<head profile="http://www.w3.org/2005/20/profile">
<link rel="icon"
	  type="image/png"
	  href="images/favicon.gif">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title id="Timerhead">Lingo 2.0 - Test iz poznavanja reči</title>
<link type='text/css' rel='stylesheet' href='style.css' />
<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<style type="text/css">
#centralni_box > div > div {
text-align:center
}
#centralni_box > div > div > input {
margin:0
}
#centralni_box a {
text-decoration:none;
color:#000;
}
.pojed_reci {
line-height:21px;
}
#rezultati > div > div > a {
text-decoration:none;
color:#000;
}
</style>
<meta name="robots" content="noindex">
</head>
<body onload="ajax_request(),ajax_request2(1)">
<form action="#" method="POST">
<?php include 'topbar.php'; 
if (isset($_POST['recnik'])) echo '<input type="hidden" id="checkok" value="2" />';
else echo '<input type="hidden" id="checkok" value="1" />';
echo '<input type="hidden" name="userx" id="userx" value="'.$user.'" />';
?>
<div id="kolona_l" class="kolona" style="margin:0 0 10px 20px;float:left">
	<div class="box">
		<h3><span id="ajaxw2"></span> Rečnik</h3>
		<div class="side_unutra" style="height:26px">
			<select name="recnik" id="recnik" style="width:100%">
<?php
if (isset($_POST['recnik'])) {
$recnikx=explode("-",$_POST['recnik']);
$recnik=$recnikx[1];
$smer=$recnikx[0];
}
else {
$sql='SELECT recnik, smer FROM `test_reci` WHERE `user`="'.$user.'" ORDER BY `test_reci`.`datum` DESC LIMIT 1';
$result = $mysqli->query($sql) or die;
$row=$result->fetch_assoc();
$recnik=$row['recnik'];
$smer=$row['smer'];
}
$sql ='SELECT * FROM jezici ORDER BY `ime`';
$result = $mysqli->query($sql) or die;

while ($row=$result->fetch_assoc()) {
$tabela = $row['tabela'];
$ime= $row['ime'];
$prideva=ucfirst($row['prideva']);
$pridevb=ucfirst($row['pridevb']);
$genitiva=$row['genitiva'];
$genitivb=$row['genitivb'];
$imena=explode(" - ",$ime);
			echo '<option value="a-'.$tabela.'"';
			if (($recnik==$tabela) AND ($smer=='a')) echo ' selected="selected"';
			echo '>'.$imena[0].' -> '.$imena[1].'</option>';
			echo '<option value="b-'.$tabela.'"';
			if (($recnik==$tabela) AND ($smer=='b')) echo 'selected="selected"';
			echo '>'.$imena[1].' -> '.$imena[0].'</option>';

}

?>
			</select>
		</div>
	</div>
	<div class="box">
		<div style="padding:0"><h3><div style="float:left">Statistike</div><div style="float:right"><input type="button" id="stat" value="osveži statistiku" onclick="ajax_request2(2)" /></div></h3></div>
		<div class="side_unutra" id="listareci" style="background: #fff url('images/stat.gif') repeat-y fixed left;padding:0 5px 0 5px">
		</div>
	</div>
</div>

<div id="kolona_d" class="kolona" style="margin:0 20px 10px 0;float:right">
	<div class="box">
		<h3>Opcije</h3>
		<div class="side_unutra">
			Počni test sa
			<select name="koliko" id="koliko" style="width:43px">
				<option<?php if($koliko=='5') echo ' selected="selected"'; ?>>5</option>
				<option<?php if($koliko=='10') echo ' selected="selected"'; ?>>10</option>
				<option<?php if($koliko=='15') echo ' selected="selected"'; ?>>15</option>
				<option<?php if($koliko=='20') echo ' selected="selected"'; ?>>20</option>
				<option<?php if($koliko=='30') echo ' selected="selected"'; ?>>30</option>
				<option<?php if($koliko=='40') echo ' selected="selected"'; ?>>40</option>
				<option<?php if($koliko=='50') echo ' selected="selected"'; ?>>50</option>
				<option<?php if($koliko=='100') echo ' selected="selected"'; ?>>100</option>
			</select>
			pitanja
		<input type="button" id="Osveži" value="Osveži" onclick="ajax_request()"/><span id="ajaxw1"></span><br/>
		Na osnovu: <select name="naosnovu" id="naosnovu">
			<option value="1"<?php if ($naosnovu=='1') echo ' selected="selected"'; ?>>ličnog</option>
			<option value="2"<?php if ($naosnovu=='2') echo ' selected="selected"'; ?>>opšteg</option>
		</select> uspeha<br/>
		Tip testa:<select name="tipt" id="tipt">
			<option value="1"<?php if ($tipt=='1') echo ' selected="selected"'; ?> style="background:#e5eeff">Nove</option>
			<option value="2"<?php if ($tipt=='2') echo ' selected="selected"'; ?> style="background:#eebbbb">Najslabije poznate</option>
			<option value="3"<?php if ($tipt=='3') echo ' selected="selected"'; ?> style="background:#ffd6d6">Slabije poznate</option>
			<option value="4"<?php if ($tipt=='4') echo ' selected="selected"'; ?> style="background:#d6ffd6">Bolje poznate</option>
			<option value="5"<?php if ($tipt=='5') echo ' selected="selected"'; ?> style="background:#bbeebb">Najbolje poznate</option>
			<option value="6"<?php if ($tipt=='6') echo ' selected="selected"'; ?> style="background:#eed3d3">Najslabije poznate mix</option>
			<option value="7"<?php if ($tipt=='7') echo ' selected="selected"'; ?> style="background:#ffe3e3">Slabije poznate mix</option>
			<option value="8"<?php if ($tipt=='8') echo ' selected="selected"'; ?> style="background:#e3ffe3">Bolje poznate mix</option>
			<option value="9"<?php if ($tipt=='9') echo ' selected="selected"'; ?> style="background:#bbccff">Pre više od mesec dana</option>
			<option value="10"<?php if ($tipt=='10') echo ' selected="selected"'; ?> style="background:#d6dfff">Pre više od nedelju dana</option>
			<option value="11"<?php if ($tipt=='11') echo ' selected="selected"'; ?>>Sve</option>
		</select>
		<br/>Grupe:<select name="grupe" id="grupe">
			<option value="sve_reci" <?php if ($grupe=="sve_reci") echo ' selected="selected"'; ?>>sve reči</option>
<?php
$sql='SELECT * FROM grupe ORDER BY ID ASC';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	echo '<option value="'.$row['ID'].'" ';
	if ($row['ID']==$grupe) echo ' selected="selected" ';
	echo '>'.$row['naziv'].'</option>';
}
?>			
		</select>
		<input type="submit" id="proveri" value="Proveri" />
		</div>
	</div>
	<div class="box">
		<h3>Rezultati</h3>
		<div class="side_unutra" id="rezultati">
		
<?php
$datum=date('Y-m-d');
if ($go==1) {
$countt=0;
	$datumx=$datum;
	for ($i = 1; $i <= $ukupnoreci; $i++) { 
	if (empty(${'recz'.$i})) ${'recz'.$i}=" ";
		echo '<div><div class="sideelement"><a href="#" title="'.${'comx'.$i}.'" style="cursor:help" tabindex="-1">'.${'recx'.$i}.'</a></div><div class="sideelement" style="background:#';
		if (empty(${'recs'.$i})==false) $syn=explode(', ',${'recs'.$i});
		else $syn=array();
		if ((${'recz'.$i}==${'recy'.$i}) or (in_array(${'recz'.$i},$syn))) {
		echo 'dfd';
		$countt++;
		$ok=1;
		}
		else {
		echo 'fdd';
		$ok=0;
		}
		$sql="SELECT COUNT(*) AS cnt FROM `test_reci` WHERE `user`='$user' AND `recnik`='$recnik' AND `smer`='$smer' AND `idreci`='".${'reci'.$i}."'";
		$result = $mysqli->query($sql) or die;
		$row=$result->fetch_assoc();
		$numr=$row['cnt'];
		
		echo '">'.${'recz'.$i}.'</div><div class="sideelement"><a href="#" title="'.${'recs'.$i}.'" style="cursor:help" tabindex="-1">'.${'recy'.$i}.'</a></div></div>';
		
		if ($numr==1) {
			$sql="SELECT *, ID as idsel FROM `test_reci` WHERE `user`='$user' AND `recnik`='$recnik' AND `smer`='$smer' AND `idreci`='".${'reci'.$i}."'";
			$result = $mysqli->query($sql) or die;
			$row=$result->fetch_assoc();
			foreach($row as $xx => $yy) {
				$$xx=$yy;
			}
			$nukupno=$ukupno+1;
			if ($ukupno>7) {
				$nprocenat=($procenat*7+$ok)/8;
			}
			else {
				$nprocenat=($procenat*$ukupno+$ok)/$nukupno;
			}
			$sql='UPDATE `test_reci` SET `ukupno`="'.$nukupno.'",`procenat`="'.$nprocenat.'",`datum`="'.$datumx.'" WHERE `ID`="'.$idsel.'"';
		}
		else {
			$sql='INSERT INTO `test_reci` (`user`,`recnik`,`smer`,`idreci`,`ukupno`,`procenat`,`datum`) VALUES ("'.$user.'","'.$recnik.'","'.$smer.'","'.${'reci'.$i}.'",1,'.$ok.',"'.$datumx.'") ';
		}
			$mysqli->query($sql) or die;

	}
	$sql='INSERT INTO `test_rezultati` (`user`,`recnik`,`smer`,`vrsta`,`ukupno`,`tacnih`,`datum`) VALUES ("'.$user.'","'.$recnik.'","'.$smer.'","reci",'.$ukupnoreci.','.$countt.',"'.$datumx.'") ';
	$mysqli->query($sql) or die;
	$procentt=($countt/$ukupnoreci)*1000;
	$procentt=round($procentt)/10;
	echo '<div style="height:2px"></div>';
	echo '<div style="padding:2px;background:#fff;text-align:center;font-weight:bold">Tačnih '.$countt.' od '.$ukupnoreci.' ('.$procentt.'%)</div>';

echo '<input type="button" id="itsok" onclick="its_ok()" value="ok" style="width:100%" />';
}
?>		
		</div>
	</div>
</div>

<div id="kolona_c" class="kolona" style="width:550px;margin:50px auto 20px;z-index:999">
	<div class="box">
		<h3 style="width:524px"><div style="height:23px"><div style="float:left">Test reči</div><div style="float:right;color:#ccc" id="totbox"></div></div></h3>
		<div id="centralni_box" style="width:510px;overflow-y:auto;overflow-x:hidden">
		</div>
	</div>
</div>
<!-- <div id="debugbox"></div> -->

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
document.getElementById("rezultati").style.height=113;
document.getElementById("centralni_box").style.height=285;
} 
else
{
document.getElementById("kolona_l").style.height=viewportheight-75;
document.getElementById("kolona_c").style.height=viewportheight-75;
document.getElementById("kolona_d").style.height=viewportheight-75;
document.getElementById("listareci").style.height=viewportheight-241;
document.getElementById("rezultati").style.height=viewportheight-315;
document.getElementById("centralni_box").style.height=viewportheight-145;
}

 console.log(viewportwidth);

 if (viewportwidth < 1280)
{
	document.getElementById("kolona_l").style.width=250;
	document.getElementById("kolona_l").style.margin='0 0 10px 5px';
	document.getElementById("kolona_c").style.width=450;
	document.getElementById("kolona_d").style.width=250;
	document.getElementById("kolona_d").style.margin='0 5px 10px 0';
	if (viewportheight >399) {
		document.getElementById("rezultati").style.height=viewportheight-358;
	}
	else {
		document.getElementById("rezultati").style.height=90;
	}
	$(".box h3").css("width","224px");
	$("#kolona_c h3").css("width","424px");
	$(".box div input").css("width","195px");
	$("#recnik").css("width","210px");
	$(".pojed_reci").css("width","400px");
	$("#centralni_box").css("width","410px");
	$(".side_unutra").css("width","210px");
	$("#listareci").css("width","240px");
	$("#listareci div").css("width","230px");
	$("#listareci div div").css("width","230px");
	$("#listareci div div div").css("width","111px");
	$("#rezultati").css("width","210px");
	$("#stat").css("width","109px");
	$("#rezultati > div").css("width","209px");
	$("#rezultati > div > div").css("width","67px");
}
function ajax_request()
{
document.getElementById('ajaxw1').innerHTML="<img src=\"images/ajax_loading.gif\" />";
	if (document.getElementById('checkok').value == "1") {
		$.getJSON('ajax/ajaxtestrec1.php', {koliko: $('#koliko').val(),naosnovu: $('#naosnovu').val(),tipt: $('#tipt').val(),recnik: $('#recnik').val(),grupe: $('#grupe').val(),userx: $('#userx').val()}, function(data) {
			$('#centralni_box').html(data.passhtml);
			$('#totbox').html(data.totrows);
//			$('#debugbox').html(data.debug);
		});
	}
document.getElementById('ajaxw1').innerHTML="";
}
function ajax_request2(pozivx)
{
document.getElementById('ajaxw2').innerHTML="<img src=\"images/ajax_loading.gif\" />";	
	$.getJSON('ajax/ajaxtestrec2.php', {koliko: $('#koliko').val(),tipt: $('#tipt').val(),recnik: $('#recnik').val(),userx: $('#userx').val(),poziv:pozivx}, function(data) {
		$('#listareci').html(data.passhtml2);
	});
document.getElementById('ajaxw2').innerHTML="";
}
function its_ok()
{
	document.getElementById('checkok').value="1";
	ajax_request();
	document.getElementById('rezultati').innerHTML="";
}
</script>
</form>
</body>
</html>