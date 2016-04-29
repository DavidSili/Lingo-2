<?php
	session_start();
	$uri=$_SERVER['REQUEST_URI'];
	$pos = strrpos($uri, "/");
	$url = substr($uri, $pos+1);
	if ($_SESSION['loggedin'] != 1 OR $_SESSION['level'] <4 ) {
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
<title id="Timerhead">Lingo 2.0 - Unos deklinacija</title>
<link type='text/css' rel='stylesheet' href='style.css' />
<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<style type="text/css">
<meta name="robots" content="noindex">
</style>
</head>
<body onload="ajax_request();ajax_request2();">
<form action="#" method="POST">
<?php include 'topbar.php'; ?>

<div id="kolona_l" class="kolona" style="margin:0 0 10px 20px;float:left">
	<div class="box">
		<h3>Rečnik</h3>
		<div class="side_unutra" style="height:26px">
			<select id="recniksend" onchange="ajax_request2()" name="recnik" style="width:100%">
<?php
$sql ='SELECT * FROM recnici ORDER BY `naziv`';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
$tabela = $row['tabela'];
$naziv = $row['naziv'];
if ($recnik=="") $recnik=$tabela;
			echo '<option value="'.$tabela.'"';
			if ($tabela==$recnik) echo 'selected="selected"';
			echo '>'.$naziv.'</option>';

}

?>
			</select>
		</div>
	</div>
	<div class="box">
		<h3>Postojeće deklinacije</h3>
		<div class="side_unutra" id="listareci" >
		</div>
	</div>
</div>

<div id="kolona_d" class="kolona" style="margin:0 20px 10px 0;float:right">
	<div id="opcije" class="box">
		<h3>Opcije</h3>
		<div class="side_unutra">
		</div>
	</div>
</div>

<div id="kolona_c" class="kolona" style="width:550px;margin:50px auto 20px;z-index:999">
	<div class="box">
		<h3 style="width:524">Unos deklinacija</h3>
		<div id="centralni_box" class="deklinacija">
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
	$("#opcije div input").css("width","inherit");
	$(".deklinacija div input").css("width","inherit");

}
function ajax_request()
	{
	$.getJSON('ajax/ajaxdek.php', {a1: $('#dizajn1').val(),a2: $('#dizajn2').val(),a3: $('#dizajn3').val(),a4: $('#dizajn4').val(),a5: $('#dizajn5').val(),a6: $('#dizajn6').val(),a7: $('#centriranje1').val(),a8: $('#centriranje2').val(),debug: $('#debug').val()}, function(data) {
		$('#centralni_box').html(data.passhtml);
		});
	}
function ajax_request2()
	{
	$.getJSON('ajax/ajaxdekrec.php', {recnik: $('#recniksend').val()}, function(data) {
		$('#listareci').html(data.pass2html);
		});
	}

</script>
</form>
</body>
</html>