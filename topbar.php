<nav id="topbar">
    <ul>
		<li><a href="#">Zdravo, <?php echo $user; ?>!<img src="images/settings.png" style="margin:3px 0 -3px 10px" height="16" width="16" /></a>
			<ul class="sub2">
				<li><a href="#">Profil</a></li>
				<li><a href="#">Podešavanja</a></li>
			</ul>
		</li>
	</ul>
    <div id="sp" style="float:left"></div>
	<ul style="float:right">
		<div id="sp" style="float:left"></div>
		<li><a href="index.php">Početna</a>
		</li>
		<div id="sp" style="float:left"></div>
		<li><a href="testr.php">Test</a>
			<ul>
				<li><a href="testr.php">Reči</a></li>
				<li><a href="testd.php">Deklinacije</a></li>
			</ul>
		</li>
		<div id="sp" style="float:left"></div>
		<li><a href="ucenjer.php">Učenje</a>
			<ul>
				<li><a href="ucenjer.php">Reči</a></li>
				<li><a href="ucenjed.php">Deklinacija</a></li>
			</ul>
		</li>
		<div id="sp" style="float:left"></div>
<?php
$sql='SELECT level FROM users WHERE username="'.$user.'"';
$result = $mysqli->query($sql) or die;
$row=$result->fetch_assoc();
$level=$row['level'];
if ($level>2) {
?>
		<li><a href="unosr.php">Unos</a>
			<ul>
				<li><a href="unosr.php">Reči</a></li>
				<li><a href="unosd.php">Deklinacija</a></li>
				<li><a href="unosc.php">Citata</a></li>
				<li><a href="unosg.php">Grupa</a></li>
			</ul>
		</li>
		<div id="sp" style="float:left"></div>
		<li><a href="izmenar.php">Izmena</a>
			<ul>
				<li><a href="izmenar.php">Reči</a></li>
				<li><a href="izmenad.php">Deklinacija</a></li>
				<li><a href="izmenac.php">Citata</a></li>
			</ul>
		</li>
		<div id="sp" style="float:left"></div>
<?php
}
if ($level>3) {
?>
		<li><a href="adminusers.php">Admin panel</a>
			<ul>
				<li><a href="adminusers.php">Korisnici</a></li>
				<li><a href="recnici.php">Rečnici</a></li>
			</ul>
		</li>
		<div id="sp" style="float:left"></div>
<?php
}
?>
		<li><a href="logout.php">Odjava</a></li>
	</ul>
</nav>