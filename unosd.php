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
	
if (isset($_POST['dizajn1'])) {
	foreach($_POST as $aa => $bb) {
		$$aa=$bb;
	}

$dizajn=$dizajn5.'$#!$';
$dizajn.=$dizajn6.'$#!$';
if ($centriranje1==1) $dizajn.='1$#!$';
	else $dizajn.='2$#!$';
if ($centriranje2==1) $dizajn.='1$#!$';
	else $dizajn.='2$#!$';
for ($i = 1; $i <= $dizajn1; $i++) {
	$dizajn.=${'sirina1x'.$i}.',';
}
$dizajn=substr($dizajn, 0, -1).'$#!$';
for ($i = 1; $i <= $dizajn3; $i++) {
	$dizajn.=${'sirina2x'.$i}.',';
}
$dizajn=substr($dizajn, 0, -1).'$#!$';

$odgovori="";
for ($x = 1; $x <= 2; $x++) {
	$redovix=$x*2;
	$kolonex=$x*2-1;
	for ($i = 1; $i <= ${'dizajn'.$redovix}; $i++) {
	
		for ($ii = 1; $ii <= ${'dizajn'.$kolonex}; $ii++) {
			if (isset(${'hide'.$x.'x'.$i.'x'.$ii})) $dizajn.='$x$,';
			else {
				if (${'inv'.$x.'x'.$i.'x'.$ii}==9) {
				$odgovori.=${'in'.$x.'x'.$i.'x'.$ii}.',';
				$dizajn.='$!$,';
				}
				else {
				$dizajn.=${'inv'.$x.'x'.$i.'x'.$ii}.'$:'.${'in'.$x.'x'.$i.'x'.$ii}.',';
				}
			}
		}
		$dizajn=substr($dizajn, 0, -1);
		$dizajn.='$y$,';
	}
	$dizajn=substr($dizajn, 0, -4);
	$dizajn.='$#$,';
}
$dizajn=substr($dizajn, 0, -4);
$odgovori=substr($odgovori, 0, -1);
$datum=date('d.m.Y.');
$sql="INSERT INTO $recnik (`naziv`,`dizajn`,`odgovori`,`uneo`) VALUES ('$nazivdek','$dizajn','$odgovori','".$user." - ".$datum."')";
$mysqli->query($sql) or die;


}
if (isset($dizajn1)==false) $dizajn1=2;
if (isset($dizajn2)==false) $dizajn2=1;
if (isset($dizajn3)==false) $dizajn3=2;
if (isset($dizajn4)==false) $dizajn4=7;
if (isset($dizajn5)==false) $dizajn5=0;
if (isset($dizajn6)==false) $dizajn6=0;
if (isset($centriranje1)==false) $centriranje1=1;
if (isset($centriranje2)==false) $centriranje2=1;
if (isset($recnik)==false) $recnik=0;

?>
<html>
<head profile="http://www.w3.org/2005/20/profile">
<link rel="icon"
	  type="image/png"
	  href="images/favicon.gif">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title id="Timerhead">Lingo 2.3 - Unos deklinacija</title>
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
			<b>Dizajn deklinacije:</b> <br/>
			prvi deo: <select id="dizajn1" name="dizajn1" style="margin-left:10px;width:41px">
				<option <?php if ($dizajn1==1) echo 'selected'; ?>>1</option>
				<option <?php if ($dizajn1==2) echo 'selected'; ?>>2</option>
				<option <?php if ($dizajn1==3) echo 'selected'; ?>>3</option>
				<option <?php if ($dizajn1==4) echo 'selected'; ?>>4</option>
				<option <?php if ($dizajn1==5) echo 'selected'; ?>>5</option>
				<option <?php if ($dizajn1==6) echo 'selected'; ?>>6</option>
				<option <?php if ($dizajn1==7) echo 'selected'; ?>>7</option>
				<option <?php if ($dizajn1==8) echo 'selected'; ?>>8</option>
			</select>
			x
			<select id="dizajn2" name="dizajn2" style="width:41px">
				<option <?php if ($dizajn2==0) echo 'selected'; ?>>0</option>
				<option <?php if ($dizajn2==1) echo 'selected'; ?>>1</option>
				<option <?php if ($dizajn2==2) echo 'selected'; ?>>2</option>
				<option <?php if ($dizajn2==3) echo 'selected'; ?>>3</option>
			</select>
			,
			<select id="centriranje1" name="centriranje1">
				<option <?php if ($centriranje1==1) echo 'selected'; ?> value="1">centar</option>
				<option <?php if ($centriranje1==2) echo 'selected'; ?> value="2">na levo</option>
			</select><br/>
			Razdvojiti između: <select id="dizajn5" name="dizajn5">
				<option value="0" <?php if ($dizajn5==0) echo 'selected'; ?>></option>
				<option value="1" <?php if ($dizajn5==1) echo 'selected'; ?>>1. i 2.</option>
				<option value="2" <?php if ($dizajn5==2) echo 'selected'; ?>>2. i 3.</option>
				<option value="3" <?php if ($dizajn5==3) echo 'selected'; ?>>3. i 4.</option>
				<option value="4" <?php if ($dizajn5==4) echo 'selected'; ?>>4. i 5.</option>
				<option value="5" <?php if ($dizajn5==5) echo 'selected'; ?>>5. i 6.</option>
				<option value="6" <?php if ($dizajn5==6) echo 'selected'; ?>>6. i 7.</option>
				<option value="7" <?php if ($dizajn5==7) echo 'selected'; ?>>7. i 8.</option>
			</select> kolone<br/><br/>
			drugi deo: <select id="dizajn3" name="dizajn3" style="width:41px">
				<option <?php if ($dizajn3==1) echo 'selected'; ?>>1</option>
				<option <?php if ($dizajn3==2) echo 'selected'; ?>>2</option>
				<option <?php if ($dizajn3==3) echo 'selected'; ?>>3</option>
				<option <?php if ($dizajn3==4) echo 'selected'; ?>>4</option>
				<option <?php if ($dizajn3==5) echo 'selected'; ?>>5</option>
				<option <?php if ($dizajn3==6) echo 'selected'; ?>>6</option>
				<option <?php if ($dizajn3==7) echo 'selected'; ?>>7</option>
				<option <?php if ($dizajn3==8) echo 'selected'; ?>>8</option>
			</select>
			x
			<select id="dizajn4" name="dizajn4" style="width:41px">
				<option <?php if ($dizajn4==1) echo 'selected'; ?>>1</option>
				<option <?php if ($dizajn4==2) echo 'selected'; ?>>2</option>
				<option <?php if ($dizajn4==3) echo 'selected'; ?>>3</option>
				<option <?php if ($dizajn4==4) echo 'selected'; ?>>4</option>
				<option <?php if ($dizajn4==5) echo 'selected'; ?>>5</option>
				<option <?php if ($dizajn4==6) echo 'selected'; ?>>6</option>
				<option <?php if ($dizajn4==7) echo 'selected'; ?>>7</option>
				<option <?php if ($dizajn4==8) echo 'selected'; ?>>8</option>
				<option <?php if ($dizajn4==9) echo 'selected'; ?>>9</option>
				<option <?php if ($dizajn4==10) echo 'selected'; ?>>10</option>
				<option <?php if ($dizajn4==11) echo 'selected'; ?>>11</option>
				<option <?php if ($dizajn4==12) echo 'selected'; ?>>12</option>
			</select>
			,
			<select id="centriranje2" name="centriranje2"	>
				<option <?php if ($centriranje2==1) echo 'selected'; ?> value="1">centar</option>
				<option <?php if ($centriranje2==2) echo 'selected'; ?> value="2">na levo</option>
			</select><br/>
			Razdvojiti između: <select id="dizajn6" name="dizajn6">
				<option value="0" <?php if ($dizajn6==0) echo 'selected'; ?>></option>
				<option value="1" <?php if ($dizajn6==1) echo 'selected'; ?>>1. i 2.</option>
				<option value="2" <?php if ($dizajn6==2) echo 'selected'; ?>>2. i 3.</option>
				<option value="3" <?php if ($dizajn6==3) echo 'selected'; ?>>3. i 4.</option>
				<option value="4" <?php if ($dizajn6==4) echo 'selected'; ?>>4. i 5.</option>
				<option value="5" <?php if ($dizajn6==5) echo 'selected'; ?>>5. i 6.</option>
				<option value="6" <?php if ($dizajn6==6) echo 'selected'; ?>>6. i 7.</option>
				<option value="7" <?php if ($dizajn6==7) echo 'selected'; ?>>7. i 8.</option>
			</select> kolone<br/>

			<input type="button" value="promeni" style="width:75px;margin-bottom:20px;width:inherit" onclick="ajax_request()" /><br/>
			<b>Naziv:</b> <input type="text" name="nazivdek" style="width:inherit"/>
		<input type="submit" id="Unesi" value="Unesi" style="width:inherit"/>
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