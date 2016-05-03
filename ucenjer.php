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
	
?>
<html>
<head profile="http://www.w3.org/2005/20/profile">
<link rel="icon"
	  type="image/png"
	  href="images/favicon.gif">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title id="Timerhead">Lingo 2.3 - Učenje reči</title>
<link type='text/css' rel='stylesheet' href='style.css' />
<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<style type="text/css">
#centralni_box > div > div > div{
	width:250px;
	background:#ccc;
	padding:
}
</style>
<meta name="robots" content="noindex">
</head>
<body onload="ajax_request()">
<?php include 'topbar.php'; ?>

<div id="kolona_l" class="kolona" style="margin:0 0 10px 20px;float:left">
	<div class="box">
		<h3>Rečnik</h3>
		<div class="side_unutra" style="height:26px">
			<form action="#" method="POST">
			<select name="recnik" id="recnik" style="width:100%" onchange="ajax_request()">
<?php
$sql='SELECT recnik FROM `test_reci` WHERE `user`="'.$user.'" ORDER BY `test_reci`.`datum` DESC LIMIT 1';
$result = $mysqli->query($sql) or die;
$row=$result->fetch_assoc();
$favrecnik=$row['recnik'];

$sql ='SELECT * FROM jezici ORDER BY `ime`';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
$tabela = $row['tabela'];
$ime= $row['ime'];
$prideva=ucfirst($row['prideva']);
$pridevb=ucfirst($row['pridevb']);
$genitiva=$row['genitiva'];
$genitivb=$row['genitivb'];
if (empty($recnik)) $recnik=$tabela;
			echo '<option value="'.$tabela.'" ';
			if ($tabela==$favrecnik) echo 'selected="selected" ';
			echo '>'.$ime.'</option>';

}

?>
			</select>
		</div>
	</div>
</div>

<div id="kolona_d" class="kolona" style="margin:0 20px 10px 0;float:right">
	<div class="box">
		<h3>Opcije</h3>
		<div class="side_unutra">
			Pokaži
			<select id="grupe">
				<option value="sve_reci">sve reči</option>
			</select>
			koje
			<select name="srckoje" id="srckoje" onchange="ajax_request()">
				<option value="1">počinju sa</option>
				<option value="2">sadrže</option>
			</select>:
			<input type="text" name="search" id="search" style="width:inherit"/>
			od:
			<select name="srcsta" id="srcsta" onchange="ajax_request()">
				<option value="0" selected>Svih vrsta reči</option>
				<option value="1">Osnovnih reči</option>
				<option value="2">Osnovnih reči i sinonima</option>
				<option value="3">Sinonima</option>
				<option value="4">Komentara</option>
			</select><br/>
			i sortiraj 
			<select name="sortsmer" id="sortsmer" onchange="ajax_request()">
				<option value="ASC" selected>rastuće</option>
				<option value="DESC">opadajuće</option>
			</select> po:
			<select name="sortpo" id="sortpo" onchange="ajax_request()">
				<option value="aa" selected><?php echo $prideva; ?> reč</option>
				<option value="bb">Strana reč</option>
				<option value="syna">Sinonim <?php echo $genitiva; ?> reči</option>
				<option value="synb">Sinonim <?php echo $genitivb; ?> reči</option>
				<option value="coma">Komentar <?php echo $genitiva; ?> reči</option>
				<option value="comb">Komentar <?php echo $genitivb; ?> reči</option>
			</select>
			
			<input type="button" id="Unesi" value="Prikaži" style="width:inherit" onclick="ajax_request()"/>
		</div>
	</div>
</div>

<div id="kolona_c" class="kolona" style="width:550px;margin:50px auto 20px;z-index:999">
	<div class="box">
		<h3 style="width:524">Učenje reči</h3>
		<div id="centralni_box" style="width:510px;overflow-y:auto;overflow-x:hidden">
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
document.getElementById("centralni_box").style.height=255;
} 
else
{
document.getElementById("kolona_l").style.height=viewportheight-75;
document.getElementById("kolona_c").style.height=viewportheight-75;
document.getElementById("kolona_d").style.height=viewportheight-75;
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
	$("#centralni_box > div > div").css("width","195px");
	$(".side_unutra").css("width","210px");
}
function ajax_request()
	{
	$.getJSON('ajax/ajaxucenjer.php', {recnik: $('#recnik').val(),grupe: $('#grupe').val(),srcsta: $('#srcsta').val(),srckoje: $('#srckoje').val(),search: $('#search').val(),sortsmer: $('#sortsmer').val(),sortpo: $('#sortpo').val()}, function(data) {
		$('#centralni_box').html(data.passhtml);
		$('#grupe').html(data.grupex);
		});
	}
</script>
</body>
</html>