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
	$user=$_SESSION['user'];
	}
$datum=date('d.m.Y.');
if (isset($_POST['kolikododaj'])) {
	foreach($_POST as $aa => $bb) {
		$$aa=mysqli_real_escape_string($mysqli,$bb);
	}

	for ($i = 1; $i <= $reci; $i++) {
		
		if ((${'reca'.$i}!="") AND (${'recb'.$i}!="")) {
			
			$svegrupe="";
			foreach ($grupe as $grupx) {
				$svegrupe.=$grupx.',';
			}
			$svegrupe=substr($svegrupe, 0, -1);
			$sql="INSERT INTO $recnik (`aa`,`bb`,`coma`,`comb`,`syna`,`synb`,`grupa`,`uneo`) VALUES ('".${'reca'.$i}."','".${'recb'.$i}."','".${'coma'.$i}."','".${'comb'.$i}."','".${'syna'.$i}."','".${'synb'.$i}."','".$svegrupe."','".$user." - ".$datum."')";
			$mysqli->query($sql) or die;
		
		}
		
	}

}
else $recnik=0;
?>
<html>
<head profile="http://www.w3.org/2005/20/profile">
<link rel="icon"
	  type="image/png"
	  href="images/favicon.gif">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title id="Timerhead">Lingo 2.3 - Unos reči</title>
<link type='text/css' rel='stylesheet' href='style.css' />
<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<meta name="robots" content="noindex">
</head>
<body onload="ajax_request()">
<?php include 'topbar.php'; ?>

<div id="kolona_l" class="kolona" style="margin:0 0 10px 20px;float:left">
	<div class="box">
		<h3>Rečnik</h3>
		<div class="side_unutra" style="height:26px">
			<form action="#" method="POST">
			<select id="recnik" name="recnik" style="width:100%" onchange="ajax_request()">
<?php
$sql='SELECT recnik FROM `test_reci` WHERE `user`="'.$user.'" ORDER BY `test_reci`.`datum` DESC LIMIT 1';
$result = $mysqli->query($sql) or die;
$row=$result->fetch_assoc();
$favrecnik=$row['recnik'];

$sql='SELECT * FROM jezici ORDER BY `ime`';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
$tabela = $row['tabela'];
$ime= $row['ime'];
$prideva=ucfirst($row['prideva']);
$pridevb=ucfirst($row['pridevb']);
$genitiva=$row['genitiva'];
$genitivb=$row['genitivb'];
if ($recnik=="0") $recnik=$favrecnik;
			echo '<option value="'.$tabela.'"';
			if ($recnik==$tabela) echo ' selected';
			echo '>'.$ime.'</option>';

}

?>
			</select>
		</div>
	</div>
	<div class="box">
		<h3>Postojeće reči</h3>
		<div class="side_unutra" id="listareci">
		</div>
	</div>
</div>

<div id="kolona_d" class="kolona" style="margin:0 20px 10px 0;float:right">
	<div class="box">
		<h3>Opcije</h3>
		<div class="side_unutra">
			Unesi i počni sa:
			<input type="hidden" name="reci" value="<?php if (isset($_POST['kolikododaj'])) echo $kolikododaj; else echo '6';?>" />
			<select name="kolikododaj" style="width:43px">
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
				<option selected>6</option>
				<option>7</option>
				<option>8</option>
				<option>9</option>
				<option>10</option>
				<option>15</option>
				<option>20</option>
				<option>50</option>
			</select>
			polja
		<input type="submit" id="Unesi" value="Unesi"/>
		</div>
		<div>
			<fieldset><legend>Grupe reči</legend>
<?php
$sql='SELECT * FROM grupe WHERE recnik="'.$recnik.'" ORDER BY ID ASC';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	echo '<input type="checkbox" name="grupe[]" value="'.$row['ID'].'" />'.$row['naziv'].'<br/>';
}
?>
			</fieldset>
		</div>
	</div>
</div>

<div id="kolona_c" class="kolona" style="width:550px;margin:50px auto 20px;z-index:999">
	<div class="box">
		<h3 style="width:524">Unos reči</h3>
		<div id="centralni_box" style="width:510px;overflow-y:auto;overflow-x:hidden">
<?php
if (isset($_POST['kolikododaj'])) $klkd=$kolikododaj;
else $klkd='6';
for ($i = 1; $i <= $klkd; $i++) {
	echo '<div class="pojed_reci" style="background:#';
	if ( $i & 1 ) echo 'ddd';
		else echo 'fff';
	echo ';"><div><input type="text" name="reca'.$i.'" title="srpska reč"><input type="text" name="recb'.$i.'" style="float:right" title="Strana reč"></div><div><input type="text" name="syna'.$i.'" title="Sinonim srpske reči"><input type="text" name="synb'.$i.'" style="float:right" title="Sinonim strane reči"></div><div><input type="text" name="coma'.$i.'" title="Komentar srpske reči"><input type="text" name="comb'.$i.'" style="float:right" title="Komentar strane reči"></div>';
	echo '</div>';
}

?>		
		</form>
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
document.getElementById("listareci").style.height=viewportheight-241;
document.getElementById("centralni_box").style.height=viewportheight-145;
}

if (viewportwidth < 1280)
{
	document.getElementById("kolona_l").style.width=250;
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
	$(".side_unutra").css("width","210px");
	$("#listareci").css("width","240px");
	$("#listareci div").css("width","230px");
	$("#listareci div div").css("width","230px");
	$("#listareci div div div").css("width","111px");
}
function ajax_request()
	{
	$.getJSON('ajax/ajaxunosrec.php', {recnik: $('#recnik').val()}, function(data) {
		$('#listareci').html(data.pass2html);
		});
	}
</script>
</body>
</html>