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
?>
<html>
<head profile="http://www.w3.org/2005/20/profile">
<link rel="icon"
	  type="image/png"
	  href="images/favicon.gif">
<title id="Timerhead">Lingo 2.3 - Priprema za test reči na mobilnom</title>
<link type='text/css' rel='stylesheet' href='style.css' />
<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<style type="text/css">
body {
	width:345px;
	height:400px;
	font-size:18px;
	line-height:48px;
}
input {
	font-size:18px;
	height:42px;
}
select {
	font-size:18px;
	height:42px;
}
</style>
<meta name="robots" content="noindex">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="HandheldFriendly" content="true"></head>
<body>
<form action="mtr.php" method="GET">
	<div style="overflow:hidden">Rečnik: <select name="recnik" style="width:250px;float:right">
<?php
$sql ='SELECT * FROM jezici ORDER BY `ime` DESC';
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
			if (isset($_POST['recnik'])) {
			if (($recnik==$tabela) AND ($smer=='a')) echo ' selected="selected"';
			}
			echo '>'.$imena[0].' -> '.$imena[1].'</option>';
			echo '<option value="b-'.$tabela.'"';
			if (isset($_POST['recnik'])) {
			if (($recnik==$tabela) AND ($smer=='b')) echo 'selected="selected"';
			}
			echo '>'.$imena[1].' -> '.$imena[0].'</option>';

}
?>
			</select></div><div style="overflow:hidden">
	Broj reči: <select name="koliko" id="koliko" style="width:250px;float:right">
				<option>5</option>
				<option selected="selected">10</option>
				<option>15</option>
				<option>20</option>
				<option>30</option>
				<option>40</option>
				<option>50</option>
				<option>100</option>
			</select></div><div style="overflow:hidden">
	Broj opcija: <select name="opcija" id="opcija" style="width:250px;float:right">
				<option>5</option>
				<option>6</option>
				<option>7</option>
				<option>8</option>
				<option>9</option>
				<option selected="selected">10</option>
			</select></div><div style="overflow:hidden">
	Tip testa: <select name="tipt" id="tipt" style="width:250px;float:right">
			<option value="1">Nove</option>
			<option value="2">Najslabije poznate</option>
			<option value="3">Slabije poznate</option>
			<option value="4">Bolje poznate</option>
			<option value="5">Najbolje poznate</option>
			<option value="6">Najslabije poznate mix</option>
			<option value="7">Slabije poznate mix</option>
			<option value="8">Bolje poznate mix</option>
			<option value="9">Pre više od mesec dana</option>
			<option value="10">Pre više od nedelju dana</option>
			<option value="11">Sve</option>
		</select></div><div style="overflow:hidden;text-align:center">
	<input type="submit" value="Test" style="margin-top:5px;width:250px" /></div>
</form>
</body>
</html>