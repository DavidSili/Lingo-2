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
<title id="Timerhead">Lingo 2.3 - Admin panel: korisnici</title>
<link type='text/css' rel='stylesheet' href='style.css' />
<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<style type="text/css">
<meta name="robots" content="noindex">
</style>
</head>
<body onload="ajax_request(1,1,'sve korisnike')">
<form action="#" method="POST">
<?php include 'topbar.php'; ?>

<div id="kolona_l" class="kolona" style="margin:0 0 10px 20px;float:left">
	<div class="box">
		<h3>Postojeći članovi</h3>
		<div class="side_unutra" id="listareci" style="overflow-x:hidden">
			<div id="blacklink" onclick="ajax_request(1,1,'sve korisnike')"><a href="#">Svi korisnici</a></div>
			<div id="blacklink" onclick="ajax_request(1,2,'najaktivnije korisnike')"><a href="#">Najaktivniji korisnici</a></div>
			<div id="blacklink" onclick="ajax_request(1,3,'poslednje aktivne korisnike')"><a href="#">Poslednje aktivni korisnici</a></div>
			<div style="width:100%;border-top: thin #333 solid;background:#ccc;border-bottom: thin #333 solid;background:#ccc;padding-left:5px;margin:5px 0"><b>Korisnici:</b></div>
<?php 
$sql="SELECT * FROM users ORDER BY `username` ASC";
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
$id=$row['ID'];
$username=$row['username'];
	echo '<div id="blacklink" onclick="ajax_request(2,'.$id.',\''.$username.'\')" style="padding-left:10px"><a href="#">'.$username.'</a></div>';
}
?>
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
		<h3 style="width:524">Statistike za <span id="spec"></span></h3>
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
document.getElementById("listareci").style.height=265;
document.getElementById("centralni_box").style.height=255;
} 
else
{
document.getElementById("kolona_l").style.height=viewportheight-75;
document.getElementById("kolona_c").style.height=viewportheight-75;
document.getElementById("kolona_d").style.height=viewportheight-75;
document.getElementById("listareci").style.height=viewportheight-135;
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
function ajax_request(prvo,drugo,tekst)
	{
	var tekstx;
	if (prvo==2) tekstx='korisnika: '+tekst;
		else tekstx=tekst;
	document.getElementById("spec").innerHTML=tekstx;
	$.getJSON('ajax/ajaxadminuser.php', {a1:prvo,a2:drugo}, function(data) {
		$('#centralni_box').html(data.pass2html);
		});
	}

</script>
</form>
</body>
</html>