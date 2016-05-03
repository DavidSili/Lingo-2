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
<title id="Timerhead">Lingo 2.3 - Učenje deklinacija</title>
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
<body onload="ajax_request(), ajax_request2()">
<?php include 'topbar.php'; ?>

<div id="kolona_l" class="kolona" style="margin:0 0 10px 20px;float:left">
	<div class="box">
		<h3>Rečnik</h3>
		<div class="side_unutra" style="height:26px">
			<form action="#" method="POST">
			<select name="recnik" id="recnik" style="width:100%" onchange="ajax_request()">
<?php
$recnik="";
$sql ='SELECT * FROM recnici ORDER BY `naziv`';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
$tabela = $row['tabela'];
$naziv= $row['naziv'];
if ($recnik=="") $recnik=$tabela;
			echo '<option value="'.$tabela.'">'.$naziv.'</option>';

}

?>
			</select>
		</div>
	</div>
	<div class="box">
		<h3>Postojeće deklinacije</h3>
		<div class="side_unutra" id="listareci">
	</div>
	</div>
</div>

<div id="kolona_d" class="kolona" style="margin:0 20px 10px 0;float:right">
	<div class="box">
		<h3>Opcije</h3>
		<div class="side_unutra">
			Pokaži sve deklinacije koje
			<select name="srckoje" id="srckoje" onchange="ajax_request()">
				<option value="1">počinju sa</option>
				<option value="2">sadrže</option>
			</select>:
			<input type="text" name="search" id="search" style="width:inherit"/></br>
			i sortiraj 
			<select name="sortsmer" id="sortsmer" onchange="ajax_request()">
				<option value="ASC" selected>rastuće</option>
				<option value="DESC">opadajuće</option>
			</select>
			<input type="button" id="Unesi" value="Prikaži" style="width:inherit" onclick="ajax_request()"/>
		</div>
	</div>
</div>

<div id="kolona_c" class="kolona" style="width:550px;margin:50px auto 20px;z-index:999">
	<div class="box">
		<h3 style="width:524">Deklinacije</h3>
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
	$("#centralni_box > div > div").css("width","195px");
	$(".side_unutra").css("width","210px");
	$("#listareci").css("width","240px");
	$("#listareci div").css("width","230px");
	$("#listareci div div").css("width","230px");
	$("#listareci div div div").css("width","111px");
}
function ajax_request(posebno)
	{
	$.getJSON('ajax/ajaxucenjed.php', {posebno:posebno,recnik: $('#recnik').val(),srckoje: $('#srckoje').val(),search: $('#search').val(),sortsmer: $('#sortsmer').val()}, function(data) {
		$('#centralni_box').html(data.passhtml);
		});
	}
function ajax_request2()
	{
	
	$.getJSON('ajax/ajaxucenjeddek.php', {recnik: $('#recnik').val()}, function(data) {
		$('#listareci').html(data.pass2html);
		});
	}
</script>
</body>
</html>