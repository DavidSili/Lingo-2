<?php
include '../config.php';
$pass2html='';
$a1 = isset($_GET["a1"]) ? $_GET["a1"] : 0;
$a2 = isset($_GET["a2"]) ? $_GET["a2"] : 0;
$a1 = $mysqli->real_escape_string($a1);
$a2 = $mysqli->real_escape_string($a2);
if ($a1==2) {
	$result = $mysqli->query('SELECT username FROM users WHERE ID="'.$a2.'"') or die;
	$row=$result->fetch_assoc();
	$username=$row['username'];

	$result = $mysqli->query('SELECT datum FROM test_reci WHERE user="'.$username.'" ORDER BY datum DESC LIMIT 1') or die;
	$row=$result->fetch_assoc();
	if ($row['datum']==NULL) $datum="";
		else $datum=date('j.n.Y.',strtotime($row['datum']));
	$pass2html.='<div>Poslednji test iz reči: '.$datum.'</div>';

	$result = $mysqli->query('SELECT datum FROM test_dek WHERE user="'.$username.'" ORDER BY datum DESC LIMIT 1') or die;
	$row=$result->fetch_assoc();
	if ($row['datum']==NULL) $datum="";
		else $datum=date('j.n.Y.',strtotime($row['datum']));
	$pass2html.='<div>Poslednji test iz deklinacija: '.$datum.'</div>';

	$pass2html.='<div>Broj urađenih testova po rečnicima:</div><table border="1" style="margin:0 0 10px 20px"><tr><th style="width:100px">Rečnik</th><th style="width:100px">Broj testova</th></tr>';
	$result = $mysqli->query('SELECT recnik, COUNT(ID) cnt FROM `test_rezultati` WHERE vrsta="rec" AND user="'.$username.'" GROUP BY recnik') or die;
	while ($row=$result->fetch_assoc()) {
		$pass2html.='<tr><td style="text-align:center">'.$row['recnik'].'</td><td style="text-align:center">'.$row['cnt'].'</td></tr>';
	}
	$pass2html.='</table>';
	
	$pass2html.='<div>Broj urađenih testova po deklinacijama:</div><table border="1" style="margin:0 0 10px 20px"><tr><th style="width:100px">Rečnik</th><th style="width:100px">Broj testova</th></tr>';
	$result = $mysqli->query('SELECT recnik, COUNT(ID) cnt FROM `test_rezultati` WHERE vrsta="dek" AND user="'.$username.'" GROUP BY recnik') or die;
	while ($row=$result->fetch_assoc()) {
		$pass2html.='<tr><td style="text-align:center">'.$row['recnik'].'</td><td style="text-align:center">'.$row['cnt'].'</td></tr>';
	}
	$pass2html.='</table>';
	
}
else {
$date=date('Y-m-d');
$date2=date('Y-m-d', strtotime("-1 month"));
$date3=date('Y-m-d', strtotime("-1 week"));
switch ($a2)
	{
	case "1":
		$result = $mysqli->query('SELECT datum FROM test_reci ORDER BY datum DESC LIMIT 1');
		$row=$result->fetch_assoc();
		if ($row['datum']==NULL) $datum="";
			else $datum=date('j.n.Y.',strtotime($row['datum']));
		$pass2html.='<div>Poslednji test iz reči: '.$datum.'</div>';

		$result = $mysqli->query('SELECT datum FROM test_dek ORDER BY datum DESC LIMIT 1');
		$row=$result->fetch_assoc();
		if ($row['datum']==NULL) $datum="";
			else $datum=date('j.n.Y.',strtotime($row['datum']));
		$pass2html.='<div>Poslednji test iz deklinacija: '.$datum.'</div>';

		$result = $mysqli->query('SELECT recnik, COUNT(ID) cnt FROM `test_rezultati` WHERE vrsta="rec" GROUP BY recnik');
		$pass2html.='<div>Broj urađenih testova po rečnicima:</div><table border="1" style="margin:0 0 10px 20px"><tr><th style="width:100px">Rečnik</th><th style="width:100px">Broj testova</th></tr>';
		while ($row=$result->fetch_assoc()) {
			$pass2html.='<tr><td style="text-align:center">'.$row['recnik'].'</td><td style="text-align:center">'.$row['cnt'].'</td></tr>';
		}
		$pass2html.='</table>';
		
		$result = $mysqli->query('SELECT recnik, COUNT(ID) cnt FROM `test_rezultati` WHERE vrsta="dek" GROUP BY recnik');
		$pass2html.='<div>Broj urađenih testova po deklinacijama:</div><table border="1" style="margin:0 0 10px 20px"><tr><th style="width:100px">Rečnik</th><th style="width:100px">Broj testova</th></tr>';
		while ($row=$result->fetch_assoc()) {
			$pass2html.='<tr><td style="text-align:center">'.$row['recnik'].'</td><td style="text-align:center">'.$row['cnt'].'</td></tr>';
		}
		$pass2html.='</table>';
		break;
	case "2":
		$result = $mysqli->query('SELECT user, count(ID) cnt FROM `test_rezultati` WHERE datum>"'.$date.'" AND vrsta="rec" GROUP BY user LIMIT 5');
		$pass2html.='<div><div style="float:left; width:240px; margin-right:15px"><div style="margin-bottom:10px">Testovi za reči:</div><table border="1" style="margin:0 0 10px 10px"><tr><th style="width:100px">Korisnik</th><th style="width:100px">Broj testova</th></tr>';
		while ($row=$result->fetch_assoc()) {
			$pass2html.='<tr><td style="text-align:center">'.$row['user'].'</td><td style="text-align:center">'.$row['cnt'].'</td></tr>';
		}
		$pass2html.='</table></div>';
		$result = $mysqli->query('SELECT user, count(ID) cnt FROM `test_rezultati` WHERE datum>"'.$date.'" AND vrsta="dek" GROUP BY user LIMIT 5');
		$pass2html.='<div style="float:left; width:240px; margin-right:15px"><div style="margin-bottom:10px">Testovi za deklinacije:</div><table border="1" style="margin:0 0 10px 10px"><tr><th style="width:100px">Korisnik</th><th style="width:100px">Broj testova</th></tr>';
		while ($row=$result->fetch_assoc()) {
			$pass2html.='<tr><td style="text-align:center">'.$row['user'].'</td><td style="text-align:center">'.$row['cnt'].'</td></tr>';
		}
		$pass2html.='</table></div></div>';
		$result = $mysqli->query('SELECT user, count(ID) cnt FROM `test_rezultati` WHERE datum>"'.$date2.'" AND vrsta="rec" GROUP BY user LIMIT 5');
		$pass2html.='<div><div style="float:left; width:240px; margin-right:15px"><div style="margin-bottom:10px">Testovi za reči poslednjih mesec dana:</div><table border="1" style="margin:0 0 10px 10px"><tr><th style="width:100px">Korisnik</th><th style="width:100px">Broj testova</th></tr>';
		while ($row=$result->fetch_assoc()) {
			$pass2html.='<tr><td style="text-align:center">'.$row['user'].'</td><td style="text-align:center">'.$row['cnt'].'</td></tr>';
		}
		$pass2html.='</table></div>';
		$result = $mysqli->query('SELECT user, count(ID) cnt FROM `test_rezultati` WHERE datum>"'.$date2.'" AND vrsta="dek" GROUP BY user LIMIT 5');
		$pass2html.='<div style="float:left; width:240px; margin-right:15px"><div style="margin-bottom:10px">Testovi za deklinacije poslednjih mesec dana:</div><table border="1" style="margin:0 0 10px 10px"><tr><th style="width:100px">Korisnik</th><th style="width:100px">Broj testova</th></tr>';
		while ($row=$result->fetch_assoc()) {
			$pass2html.='<tr><td style="text-align:center">'.$row['user'].'</td><td style="text-align:center">'.$row['cnt'].'</td></tr>';
		}
		$pass2html.='</table></div></div>';
		$result = $mysqli->query('SELECT user, count(ID) cnt FROM `test_rezultati` WHERE datum>"'.$date3.'" AND vrsta="rec" GROUP BY user LIMIT 5');
		$pass2html.='<div><div style="float:left; width:240px; margin-right:15px"><div style="margin-bottom:10px">Testovi za reči poslednjih nedelju dana:</div><table border="1" style="margin:0 0 10px 10px"><tr><th style="width:100px">Korisnik</th><th style="width:100px">Broj testova</th></tr>';
		while ($row=$result->fetch_assoc()) {
			$pass2html.='<tr><td style="text-align:center">'.$row['user'].'</td><td style="text-align:center">'.$row['cnt'].'</td></tr>';
		}
		$pass2html.='</table></div>';
		$result = $mysqli->query('SELECT user, count(ID) cnt FROM `test_rezultati` WHERE datum>"'.$date3.'" AND vrsta="dek" GROUP BY user LIMIT 5');
		$pass2html.='<div style="float:left; width:240px; margin-right:15px"><div style="margin-bottom:10px">Testovi za deklinacije poslednih sedmicu dana:</div><table border="1" style="margin:0 0 10px 10px"><tr><th style="width:100px">Korisnik</th><th style="width:100px">Broj testova</th></tr>';
		while ($row=$result->fetch_assoc()) {
			$pass2html.='<tr><td style="text-align:center">'.$row['user'].'</td><td style="text-align:center">'.$row['cnt'].'</td></tr>';
		}
		$pass2html.='</table></div></div>';
		break;
	case "3":
		$result = $mysqli->query('SELECT user, MAX(datum) dat FROM `test_rezultati` WHERE vrsta="rec" GROUP BY user ORDER BY `dat` DESC');
		$pass2html.='<div style="float:left; width:240px; margin-right:15px"><div style="margin-bottom:10px">Poslednji korisnici koji su radili test iz reči:</div><table border="1" style="margin:0 0 10px 10px"><tr><th style="width:100px">Korisnik</th><th style="width:100px">Datum</th></tr>';
		while ($row=$result->fetch_assoc()) {
			$pass2html.='<tr><td style="text-align:center">'.$row['user'].'</td><td style="text-align:center">'.date('j.n.Y.',strtotime($row['dat'])).'</td></tr>';
		}
		$pass2html.='</table></div>';
		$result = $mysqli->query('SELECT user, MAX(datum) dat FROM `test_rezultati` WHERE vrsta="dek" GROUP BY user ORDER BY `dat` DESC');
		$pass2html.='<div style="float:left; width:240px; margin-right:15px"><div style="margin-bottom:10px">Poslednji korisnici koji su radili test iz deklinacija:</div><table border="1" style="margin:0 0 10px 10px"><tr><th style="width:100px">Korisnik</th><th style="width:100px">Datum</th></tr>';
		while ($row=$result->fetch_assoc()) {
			$pass2html.='<tr><td style="text-align:center">'.$row['user'].'</td><td style="text-align:center">'.date('j.n.Y.',strtotime($row['dat'])).'</td></tr>';
		}
		$pass2html.='</table></div>';
		break;
	}
}
$pass['pass2html']=$pass2html;
echo json_encode($pass);

?>