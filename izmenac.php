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
	
if (isset($_POST['izmena'])) {
	
	foreach($_POST as $xx => $yy) {
		$$xx=$yy;
	}
	
	$datum=date('H:i:s d.m.Y.');
	$sql="SELECT izmenio FROM quotes WHERE `ID`='$izm_id'";
	$result = $mysqli->query($sql) or die;
	$row=$result->fetch_assoc();
	$izmenio=$row['izmenio'];
	$izmenio=$izmenio.$user.' - '.$datum.'; ';
	$izm_tekst=mysql_real_escape_string($izm_tekst);
	$izm_autor=mysql_real_escape_string($izm_autor);
	$sql="UPDATE quotes SET `quote`='$izm_tekst', `autor`='$izm_autor', `izmenio`='$izmenio' WHERE `ID`=$izm_id";
	$mysqli->query($sql) or die;

}

?>
<html>
<head profile="http://www.w3.org/2005/20/profile">
<link rel="icon"
	  type="image/png"
	  href="images/favicon.gif">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title id="Timerhead">Lingo 2.0 - Izmena citata</title>
<link type='text/css' rel='stylesheet' href='style.css' />
<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<meta name="robots" content="noindex">
</head>
<body onload="ajax_request()">
<form action="#" method="POST">
<?php include 'topbar.php'; ?>

<div id="kolona_l" class="kolona" style="margin:0 0 10px 20px;float:left">
	<div class="box">
		<h3>Postojeći citati</h3>
		<div class="side_unutra" id="listareci">
<?php

$sql="SELECT * FROM quotes ORDER BY `ID` DESC";
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
	foreach($row as $xx => $yy) {
		$$xx=$yy;
	}
	if ((strlen($quote)-4)>100) {
	$pos=strpos($quote, ' ', 100);
	$quote=substr($quote,0,$pos ).'...';
	}
	if ($autor==NULL) $autor="Nepoznati autor";
	echo '<div id="blacklink" onclick="ajax_request('.$ID.')" ><a href="#"><b>'.$autor.'</b> - "'.$quote.'"</a></div>';
	
}
?>
		</div>
	</div>
</div>

<div id="kolona_d" class="kolona" style="margin:0 20px 10px 0;float:right">
	<div id="opcije" class="box">
		<h3>Opcije</h3>
		<div class="side_unutra">
		<form id="izmena" action="#" method="POST" >
			<input type="submit" id="Izmeni" value="Izmeni" style="width:inherit" />
			<input type="hidden" value="1" name="izmena" />
			<input type="button" id="delete" value="Obriši" style="width:inherit" onclick="ajax_delrequest()" />
		</div>
	</div>
</div>

<div id="kolona_c" class="kolona" style="width:550px;margin:50px auto 20px;z-index:999">
	<div class="box">
		<h3 style="width:524">Izmena citata</h3>
		<div id="centralni_box" class="deklinacija">
			<div style="margin-bottom:10px">
				<div style="overflow:hidden;padding-bottom:0">
					<div style="float:left;margin-top:3px">Tekst:</div>
					<div style="float:right">
						Autor: <input type="text" id="izm_autor" name="izm_autor"/>
					</div>
				</div>
				<textarea rows="3" id="izm_tekst" name="izm_tekst" style="font-family:arial;width:100%"></textarea>
				<input type="hidden" id="izm_id" name="izm_id" />
				</form>
			</div>
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
document.getElementById("listareci").style.height=255;
} 
else
{
document.getElementById("kolona_l").style.height=viewportheight-75;
document.getElementById("kolona_c").style.height=viewportheight-75;
document.getElementById("kolona_d").style.height=viewportheight-75;
document.getElementById("listareci").style.height=viewportheight-135;
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
function ajax_request(posebno)
	{
	$.getJSON('ajax/ajaxizmenac.php', {posebno:posebno}, function(data) {
		$('#izm_id').val(data.ID);
		$('#izm_tekst').val(data.quote);
		$('#izm_autor').val(data.autor);
		});
	}
function ajax_delrequest()
	{
		if(confirm("Da li ste sigurni da zelite da obrisete ovaj citat?")){
			$.getJSON('ajax/ajaxdelc.php', {posebno:$('#izm_id').val()}, function(data) {
				});
				setTimeout("location.href = 'izmenac.php';",100);
		}
	}
</script>
</form>
</body>
</html>