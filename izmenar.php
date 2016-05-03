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
	
if (isset($_POST['izm_id'])) {
	foreach($_POST as $xx => $yy) {
		$$xx=$yy;
	}
	
$ID=$izm_id;
$datum=date('H:i:s d.m.Y.');
$sql="SELECT izmenio FROM $recnik WHERE `ID`='$ID'";
$result = $mysqli->query($sql) or die;
$row=$result->fetch_assoc();
$izmenio=$row['izmenio'];
$izmenio=$izmenio.$user.' - '.$datum.'; ';

$svegrupe="";
if (isset($grupe)) {
	foreach ($grupe as $grupx) {
		$svegrupe.=$grupx.',';
	}
	$svegrupe=substr($svegrupe, 0, -1);
}

$sql="UPDATE $recnik SET `aa`='$reca', `bb`='$recb', `syna`='$syna', `synb`='$synb', `coma`='$coma', `comb`='$comb', `grupa`='$svegrupe', `izmenio`='$izmenio' WHERE `ID`='$ID'";
$mysqli->query($sql) or die;

}
else {
$recnik="";
}
?>
<html>
<head profile="http://www.w3.org/2005/20/profile">
<link rel="icon"
	  type="image/png"
	  href="images/favicon.gif">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title id="Timerhead">Lingo 2.3 - Izmena reči</title>
<link type='text/css' rel='stylesheet' href='style.css' />
<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<style type="text/css">
h4 {
margin: 5px 0;
}
</style>
<meta name="robots" content="noindex">
</head>
<body onload="ajax_request2();ajax_request(0);">
<form action="#" method="POST">
<?php include 'topbar.php'; ?>

<div id="kolona_l" class="kolona" style="margin:0 0 10px 20px;float:left">
	<div class="box">
		<h3>Rečnik</h3>
		<div class="side_unutra" style="height:26px">
			<select id="recnik" onchange="ajax_request2()" name="recnik" style="width:100%">
<?php
$sql='SELECT recnik FROM `test_reci` WHERE `user`="'.$user.'" ORDER BY `test_reci`.`datum` DESC LIMIT 1';
$result = $mysqli->query($sql) or die;
$row=$result->fetch_assoc();
$recnik=$row['recnik'];

$sql ='SELECT * FROM jezici ORDER BY `ime`';
$result = $mysqli->query($sql) or die;
while ($row=$result->fetch_assoc()) {
$tabela = $row['tabela'];
$ime= $row['ime'];
			echo '<option value="'.$tabela.'" ';
			if ($tabela==$recnik) echo 'selected="selected"';
			echo '>'.$ime.'</option>';

}

?>
			</select>
		</div>
	</div>
	<div class="box">
		<h3>Postojeće reči</h3>
		<div class="side_unutra" id="listareci" >
		</div>
	</div>
</div>

<div id="kolona_d" class="kolona" style="margin:0 20px 10px 0;float:right">
	<div id="opcije" class="box">
		<h3>Opcije</h3>
		<div class="side_unutra">
			<input type="submit" id="Izmeni" value="Izmeni" style="width:inherit" />
			<input type="hidden" value="1" name="izmena" />
			<input type="hidden" id="izm_id" value="" name="izm_id" />
			<input type="button" id="delete" value="Obriši" style="width:inherit" onclick="ajax_delrequest()" />
			<fieldset><legend>Grupe reči</legend><div id="groupfield"></div>
			</fieldset>
		</div>
	</div>
</div>

<div id="kolona_c" class="kolona" style="width:550px;margin:50px auto 20px;z-index:999">
	<div class="box">
		<h3 style="width:524">Izmena reči</h3>
		<div id="centralni_box" class="deklinacija">
			<div class="pojed_reci" >
				<div>
					<input type="text" name="reca" id="aa" title="Srpska reč">
					<input type="text" name="recb" id="bb" style="float:right" title="Strana reč">
				</div>
				<div>
					<input type="text" name="syna" id="syna" title="Sinonim srpske reči" style="background:#ddd">
					<input type="text" name="synb" id="synb" style="float:right;background:#ddd" title="Sinonim strane reči">
				</div>
				<div>
					<input type="text" name="coma" id="coma" title="Komentar srpske reči" style="background:#ccc">
					<input type="text" name="comb" id="comb" style="float:right;background:#ccc" title="Komentar strane reči">
				</div>
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
document.getElementById("listareci").style.height=159;
} 
else
{
document.getElementById("kolona_l").style.height=viewportheight-75;
document.getElementById("kolona_c").style.height=viewportheight-75;
document.getElementById("kolona_d").style.height=viewportheight-75;
document.getElementById("listareci").style.height=viewportheight-241;
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
function ajax_request2()
	{
	$.getJSON('ajax/ajaxizmenarecrec.php', {recnik: $('#recnik').val()}, function(data) {
		$('#listareci').html(data.pass2html);
		});
	}
function ajax_request(posebno)
	{
	$.getJSON('ajax/ajaxizmenarec.php', {recnik: $('#recnik').val(),posebno: posebno}, function(data) {
		$('#izm_id').val(data.ID);
		$('#aa').val(data.aa);
		$('#bb').val(data.bb);
		$('#coma').val(data.coma);
		$('#comb').val(data.comb);
		$('#syna').val(data.syna);
		$('#synb').val(data.synb);
		$('#groupfield').html(data.grupe);
		});
	}
function ajax_delrequest()
	{
		if(confirm("Da li ste sigurni da zelite da obrisete ovu rec?")){
			$.getJSON('ajax/ajaxdelr.php', {recnik: $('#recnik').val(),posebno:$('#izm_id').val()}, function(data) {
				});
				setTimeout("location.href = 'izmenar.php';",10000);
		}
	}
</script>
</form>
</body>
</html>