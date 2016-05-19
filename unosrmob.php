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
if (isset($_POST['reca'])) {
	foreach($_POST as $aa => $bb) {
		$$aa=mysqli_real_escape_string($mysqli,$bb);
	}

	if (($reca!="") AND ($recb!="")) {
	
		$sql="INSERT INTO $recnik (`aa`,`bb`,`coma`,`comb`,`syna`,`synb`,`uneo`) VALUES ('".$reca."','".$recb."','".$coma."','".$comb."','".$syna."','".$synb."','".$user." - ".$datum."')";
		$mysqli->query($sql) or die;
	
	}

}
else $recnik="";

?>
<html>
<head profile="http://www.w3.org/2005/20/profile">
<link rel="icon"
	  type="image/png"
	  href="images/favicon.gif">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title id="Timerhead">Lingo 2.3 - Unos reči za mobilni</title>
<link type='text/css' rel='stylesheet' href='style.css' />
<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<style type="text/css">
input {
	width:100%;
}
</style>
<meta name="robots" content="noindex">
</head>
<body>
<form action="#" method="POST">
	<select name="recnik" style="width:100%">
<?php
		$sql ='SELECT * FROM jezici ORDER BY `ime`';
		$result = $mysqli->query($sql) or die;
		while ($row=$result->fetch_assoc()) {
		$tabela = $row['tabela'];
		$ime= $row['ime'];
		echo '<option value="'.$tabela.'"';
		if ($tabela==$recnik) echo ' selected';
		echo '>'.$ime.'</option>';
		}
?>
	</select><br/>
	Srpska reč: <input type="text" name="reca" /><br/>
	Strana reč: <input type="text" name="recb" /><br/>
	Sinonim srpske reči: <input type="text" name="syna" /><br/>
	Sinonim strane reči: <input type="text" name="synb" /><br/>
	Komentar srpske reči: <input type="text" name="coma" /><br/>
	Komentar strane reči: <input type="text" name="comb" /><br/>
	<input type="submit" value="unesi" style="margin-top:5px" />
</form>
</body>
</html>