<?php
$host = "localhost";
$user = "root";
$passwordx = "";
$db_name = "lingo2";
$mysqli = mysqli_connect($host, $user, $passwordx, $db_name) or die;
$mysqli->query("SET NAMES 'utf8'") or die;
date_default_timezone_set('Europe/Belgrade');
?>