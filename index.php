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
<title id="Timerhead">Lingo 2.3</title>
<link type='text/css' rel='stylesheet' href='style.css' />
<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<style type="text/css">
#novost p {
margin: 2px 0;
text-indent:20px;
}
</style>
<meta name="robots" content="noindex">
</head>
<body>
<?php include 'topbar.php'; ?>

<div id="introbox">
	<h3>Dobrodošli!</h3>
	<div id="quote">
<?php
$sql="SELECT * FROM quotes ORDER BY RAND() LIMIT 0,1";
$result = $mysqli->query($sql) or die;
$row=$result->fetch_assoc();
$quote=$row['quote'];
$autor=$row['autor'];
if ($autor=="") $autor='Nepoznati autor';
echo '<div><b><i>"'.$quote.'"</b></i></div><div style="float:right"> - '.$autor.'</div><div style="clear:both"></div>';

?>
	</div>
	<div id="newsbox">
<?php
$sql="SELECT * FROM novosti ORDER BY `ID` DESC LIMIT 0,5";
$result = $mysqli->query($sql) or die;
$row=$result->fetch_assoc();
$naslov=$row['naslov'];
$tekst=$row['tekst'];
$datum=date('j.n.Y. G:i:s',strtotime($row['datum']));
echo '<div id="novost" style="margin-bottom:10px;padding-bottom:5px;border-bottom: 1px dashed #000"><p><b>'.$naslov.'</b></p><p>'.$tekst.'</p><div style="text-align:right">'.$datum.'</div></div>';
echo '</div>';

if ($level>2) {
echo '<div style="margin-top:30px;text-align:center">';
echo '<a href="unosrmob.php" title="unos reči preko mobilnog"><img src="images/cell.gif" /></a><a href="mtrprep.php" title="test reči preko mobilnog"><img src="images/cell2.gif" /></a>';
echo '</div>';
}

?>
</div>
<script type="text/javascript">
var quote=$('#quote').height();
document.getElementById("newsbox").style.height=410-quote;
</script>
</body>
</html>