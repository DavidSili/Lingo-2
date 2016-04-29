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
<meta name="robots" content="noindex">
<style type="text/css">
	#centralni_box input {
		margin-bottom: 10px;
		width:195px;
	}
	.primer {
		color:#aaa;
		margin-left:30px;
	}
</style>
</head>
<body>
<form action="#" method="POST">
<?php include 'topbar.php'; ?>

<div id="kolona_l" class="kolona" style="margin:0 0 10px 20px;float:left">
	<div class="box">
		<h3>Postojeći rečnici za:</h3>
		<div class="side_unutra" id="listareci" style="font-size:11pt">
			<?php
			$sql ='SELECT ime, tabela FROM jezici ORDER BY `ime`';
			$result = $mysqli->query($sql) or die;
			while ($row=$result->fetch_assoc()) {
				$tabela = $row['tabela'];
				$ime = $row['ime'];
				echo $ime.' (<span style="font-style:italic;color:#aaa">'.$tabela.'</span>)<br>';
			}
			?>
		</div>
	</div>
</div>

<div id="kolona_d" class="kolona" style="margin:0 20px 10px 0;float:right">
	<div id="opcije" class="box">
		<h3>Opcije</h3>
		<div class="side_unutra">
			<input type="submit" value="Kreiraj rečnik" style="width:100%;margin-bottom:20px" />
			<input type="reset" value="Resetuj" style="width:100%" />
		</div>
	</div>
</div>

<div id="kolona_c" class="kolona" style="width:550px;margin:50px auto 20px;z-index:999;font-size: 11pt;">
	<div class="box">
		<h3 style="width: 524px;">Unos deklinacija</h3>
		<div id="centralni_box" class="deklinacija">
			Naziv rečnika:<span style="margin-left:125px;font-style: bold;" class="primer">Primer:</span><br>
			<input type="text" name="nrecnika" /><span class="primer">Srpski - Engleski</span><br>
			Naziv tabele za reči:<br>
			rec_<input type="text" name="tabreci" style="width:167px !important;"/><span class="primer">rec_srbeng</span><br>
			Naziv tabele za deklinacije:<br>
			dek_<input type="text" name="tabdek" style="width:164px !important;" /><span class="primer">dek_eng</span><br>
			Naziv fajla za prvi jezik*:<br>
			<input type="text" name="slikaa" /><span class="primer">srb.gif</span><br>
			Naziv fajla za drugi jezik*:<br>
			<input type="text" name="slikab" /><span class="primer">eng.gif</span><br>
			Naziv prvog jezika u pridevu jednine:<br>
			<input type="text" name="prideva" /><span class="primer">srpska</span><br>
			Naziv drugog jezika u pridevu jednine:<br>
			<input type="text" name="pridevb" /><span class="primer">engleska</span><br>
			Naziv prvog jezika u genitivu jednine:<br>
			<input type="text" name="genitiva" /><span class="primer">srpske</span><br>
			Naziv drugog jezika u genitivu jednine:<br>
			<input type="text" name="genitivb" /><span class="primer">engleske</span>
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
document.getElementById("listareci").style.height=325;
document.getElementById("centralni_box").style.height=255;
} 
else
{
document.getElementById("kolona_l").style.height=viewportheight-75;
document.getElementById("kolona_c").style.height=viewportheight-75;
document.getElementById("kolona_d").style.height=viewportheight-75;
document.getElementById("listareci").style.height=viewportheight-137;
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
</script>
</form>
</body>
</html>