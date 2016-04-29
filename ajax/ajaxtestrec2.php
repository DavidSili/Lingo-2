<?php
include '../config.php';
$klk = isset($_GET["koliko"]) ? $_GET["koliko"] : 0;
$tipt = isset($_GET["tipt"]) ? $_GET["tipt"] : 0;
$userx = isset($_GET["userx"]) ? $_GET["userx"] : 0;
$poziv = isset($_GET["poziv"]) ? $_GET["poziv"] : 0;

$passhtml="";
$datum=date('Y-m-d');
$sql ='SELECT tabela FROM jezici ORDER BY `ime` LIMIT 1';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
if (isset($_GET['recnik'])) {
$recnikx=explode("-",$_GET['recnik']);
$recnik=$recnikx[1];
$smer=$recnikx[0];
}
else {
$recnik=$row['tabela'];
$smer='a';
}

if ($poziv==1) {
$sql='SELECT datum FROM test_statistike WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND vrsta="rec"';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$datumy=$row['datum'];
if ($datumy!=$datum) $poziv=2;
}
if ($poziv==2) {
$store='';

// broj naučenih reči u jednom smeru
$sql='SELECT COUNT(*) cnt FROM test_reci WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND procenat>=0.8 AND ukupno>7';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat0a=$row['cnt'];
$store.=$stat0a.'$!$';

// broj naučenih reči u oba smera
$sql='SELECT COUNT(*) cnt FROM ( SELECT idreci, SUM(IF(procenat>0.8 AND ukupno>7,1,0)) AS rez FROM test_reci WHERE user="'.$userx.'" AND recnik="'.$recnik.'" GROUP BY idreci ) AS d WHERE rez=2';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat0b=$row['cnt'];
$store.=$stat0b.'$!$';

// broj svih naučenih reči

$sql='SELECT tabela FROM jezici';
$stat0c=0;
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
while($row=$result->fetch_assoc()) {
$tabela=$row['tabela'];
$sql='SELECT COUNT(*) cnt FROM ( SELECT idreci, SUM(IF((procenat>0.8 AND ukupno>7),1,0)) AS rez FROM test_reci WHERE user="'.$userx.'" AND recnik="'.$tabela.'" GROUP BY idreci ) AS d WHERE rez=2';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat0c=$stat0c+$row['cnt'];
}
$store.=$stat0c.'$!$';

// uzimanje informacija o ukupnom broju reči za sledeće tri statistike

$sql2='SELECT COUNT(ID) cnt FROM `'.$recnik.'`';
$result2 = $mysqli->query($sql2) or die(mysqli_error($mysqli));
$row2=$result2->fetch_assoc();

//    procenat broja naučenih reči u jednom smeru i u oba smera

$statx1=$row2['cnt'];
if ($statx1==0) {
$stat0d=0;	
$stat0e=0;
}
else {
$stat0d=$stat0a/$statx1;
$stat0e=$stat0b/$statx1;
}


// procenat broja svih naučenih reči

$sql='SELECT tabela FROM jezici';
$statx2=0;
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
while($row=$result->fetch_assoc()) {
$tabela=$row['tabela'];
$sql2='SELECT COUNT(ID) cnt FROM `'.$tabela.'`';
$result2 = $mysqli->query($sql2) or die(mysqli_error($mysqli));
$row2=$result2->fetch_assoc();
$statx2=$statx2+$row2['cnt'];
}
$stat0f=$stat0c/$statx2;
$proc1=round($stat0d,4)*100;
$width1=round($stat0d*168);
$proc2=round($stat0e,4)*100;
$width2=round($stat0e*168);
$proc3=round($stat0f,4)*100;
$width3=round($stat0f*168);

$store.=$statx1.'$!$'.$statx2.'$!!$Procenat broja naučenih reči u ovom smeru$!$'.$proc1.'%$!$25%$!$50%$!$75%$!$100%$!$'.$width1.'$#$Procenat broja naučenih celih reči$!$'.$proc2.'%$!$25%$!$50%$!$75%$!$100%$!$'.$width2.'$#$Procenat broja naučenih reči iz svih unešenih jezika$!$'.$proc3.'%$!$25%$!$50%$!$75%$!$100%$!$'.$width3.'$#$';

// Testovi sa procentom tačnosti većim od 50% u toku ovog dana
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND
		(tacnih / ukupno) >= 0.5 AND ukupno>9 AND vrsta="rec" AND datum="'.$datum.'"';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat001=$row['cnt'];
if ($stat001<=30) $graph=round($stat001/30*42);
elseif ($stat001<=100) $graph=round(($stat001-30)/70*42+42);
elseif ($stat001<=300) $graph=round(($stat001-100)/200*42+84);
elseif ($stat001<100) $graph=round(($stat001-300)/700*42+126);
else $graph=168;
$store.='Testovi sa procentom tačnosti većim od 50% u toku ovog dana$!$'.$stat001.'$!$30$!$100$!$300$!$1k$!$'.$graph.'$#$';

// Testovi sa procentom tačnosti većim od 75% u toku ovog dana
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND
		(tacnih / ukupno) >= 0.75 AND ukupno>9 AND vrsta="rec" AND datum="'.$datum.'"';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat002=$row['cnt'];
if ($stat002<=30) $graph=round($stat002/30*42);
elseif ($stat002<=100) $graph=round(($stat002-30)/70*42+42);
elseif ($stat002<=300) $graph=round(($stat002-100)/200*42+84);
elseif ($stat002<1000) $graph=round(($stat002-300)/700*42+126);
else $graph=168;
$store.='Testovi sa procentom tačnosti većim od 75% u toku ovog dana$!$'.$stat002.'$!$30$!$100$!$300$!$1k$!$'.$graph.'$#$';

// Testovi sa svim tačnim odgovorima u toku ovog dana
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND
		tacnih = ukupno AND ukupno>9 AND vrsta="rec" AND datum="'.$datum.'"';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat003=$row['cnt'];
if ($stat003<=10) $graph=round($stat003/10*42);
elseif ($stat003<=30) $graph=round(($stat003-10)/20*42+42);
elseif ($stat003<=100) $graph=round(($stat003-30)/70*42+84);
elseif ($stat003<300) $graph=round(($stat003-100)/200*42+126);
else $graph=168;
$store.='Testovi sa svim tačnim odgovorima u toku ovog dana$!$'.$stat003.'$!$10$!$30$!$100$!$300$!$'.$graph.'$#$';

// Svi tacni odgovori u toku ovog dana
$sql='SELECT SUM(tacnih) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND vrsta="rec" AND datum="'.$datum.'"';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat004=$row['cnt'];
if ($stat004==NULL) $stat004=0;
if ($stat004<=300) $graph=round($stat004/300*42);
elseif ($stat004<=1000) $graph=round(($stat004-300)/700*42+42);
elseif ($stat004<=3000) $graph=round(($stat004-1000)/2000*42+84);
elseif ($stat004<10000) $graph=round(($stat004-3000)/7000*42+126);
else $graph=168;
$store.='Svi tačni odgovori u toku ovog dana$!$'.$stat004.'$!$300$!$1k$!$3k$!$10k$!$'.$graph.'$#$';


// test sa brojem tačnih > 50%
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND vrsta="rec" AND
		(tacnih / ukupno) >= 0.5 AND ukupno>9';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat1=$row['cnt'];
if ($stat1<=300) $graph=round($stat1/300*42);
elseif ($stat1<=1000) $graph=round(($stat1-300)/700*42+42);
elseif ($stat1<=3000) $graph=round(($stat1-1000)/2000*42+84);
elseif ($stat1<10000) $graph=round(($stat1-3000)/7000*42+126);
else $graph=168;
$store.='Testova sa brojem tačnih > 50%$!$'.$stat1.'$!$300$!$1k$!$3k$!$10k$!$'.$graph.'$#$';

// test sa brojem tačnih > 75%
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND vrsta="rec" AND
		(tacnih / ukupno) >= 0.75 AND ukupno>9';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat2=$row['cnt'];
if ($stat2<=100) $graph=round($stat2/100*42);
elseif ($stat2<=300) $graph=round(($stat2-100)/200*42+42);
elseif ($stat2<=1000) $graph=round(($stat2-300)/700*42+84);
elseif ($stat2<3000) $graph=round(($stat2-1000)/2000*42+126);
else $graph=168;
$store.='Testova sa brojem tačnih > 75%$!$'.$stat2.'$!$100$!$300$!$1k$!$3k$!$'.$graph.'$#$';

// test sa svim tačnim rečima
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND vrsta="rec" AND
		tacnih = ukupno AND ukupno>9';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat3=$row['cnt'];
if ($stat3<=30) $graph=round($stat3/30*42);
elseif ($stat3<=100) $graph=round(($stat3-30)/70*42+42);
elseif ($stat3<=300) $graph=round(($stat3-100)/200*42+84);
elseif ($stat3<1000) $graph=round(($stat3-300)/700*42+126);
else $graph=168;
$store.='Testova sa svim tačnim rečima$!$'.$stat3.'$!$30$!$100$!$300$!$1k$!$'.$graph.'$#$';

// Svi tačni odgovori
$sql='SELECT SUM(tacnih) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND vrsta="rec"';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat4=$row['cnt'];
if ($stat4==NULL) $stat4=0;
if ($stat4<=3000) $graph=round($stat4/3000*42);
elseif ($stat4<=10000) $graph=round(($stat4-3000)/7000*42+42);
elseif ($stat4<=30000) $graph=round(($stat4-10000)/20000*42+84);
elseif ($stat4<100000) $graph=round(($stat4-30000)/70000*42+126);
else $graph=168;
$store.='Svi tačni odgovori$!$'.$stat4.'$!$3k$!$10k$!$30k$!$100k$!$'.$graph.'$#$';

// Reči sa procentom tačnosti većim od 80% i preko 7 puta da su se pojavile
$sql='SELECT COUNT(*) cnt FROM test_reci WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND
		procenat >= 0.8 AND ukupno > 7';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat5=$row['cnt'];
if ($stat5<=30) $graph=round($stat5/30*42);
elseif ($stat5<=100) $graph=round(($stat5-30)/70*42+42);
elseif ($stat5<=300) $graph=round(($stat5-100)/200*42+84);
elseif ($stat5<1000) $graph=round(($stat5-300)/700*42+126);
else $graph=168;
$store.='Reči sa procentom tačnosti većim od 80%$!$'.$stat5.'$!$30$!$100$!$300$!$1k$!$'.$graph.'$#$';

// Reči sa procentom tačnosti većim od 95% i preko 7 puta da su se pojavile
$sql='SELECT COUNT(*) cnt FROM test_reci WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND
		procenat >= 0.95 AND ukupno > 7';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat6=$row['cnt'];
if ($stat6<=10) $graph=round($stat6/10*42);
elseif ($stat6<=30) $graph=round(($stat6-10)/20*42+42);
elseif ($stat6<=100) $graph=round(($stat6-30)/70*42+84);
elseif ($stat6<300) $graph=round(($stat6-100)/200*42+126);
else $graph=168;
$store.='Reči sa procentom tačnosti većim od 95%$!$'.$stat6.'$!$10$!$30$!$100$!$300$!$'.$graph.'$#$';

// Testovi sa procentom tačnosti većim od 50% u toku jednog dana
$stat7=0;
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND
		(tacnih / ukupno) >= 0.5 AND ukupno>9 AND vrsta="rec" GROUP BY DATE(datum)';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
while($row=$result->fetch_assoc()) {
$aaa=$row['cnt'];
if ($aaa>$stat7) $stat7=$aaa;
}
if ($stat7<=30) $graph=round($stat7/30*42);
elseif ($stat7<=100) $graph=round(($stat7-30)/70*42+42);
elseif ($stat7<=300) $graph=round(($stat7-100)/200*42+84);
elseif ($stat7<1000) $graph=round(($stat7-300)/700*42+126);
else $graph=168;
$store.='Testovi sa procentom tačnosti većim od 50% u toku jednog dana$!$'.$stat7.'$!$30$!$100$!$300$!$1k$!$'.$graph.'$#$';

// Testovi sa procentom tačnosti većim od 75% u toku jednog dana
$stat8=0;
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND
		(tacnih / ukupno) >= 0.75 AND ukupno>9 AND vrsta="rec" GROUP BY DATE(datum)';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
while($row=$result->fetch_assoc()) {
$aaa=$row['cnt'];
if ($aaa>$stat8) $stat8=$aaa;
}
if ($stat7<=30) $graph=round($stat7/30*42);
elseif ($stat7<=100) $graph=round(($stat7-30)/70*42+42);
elseif ($stat7<=300) $graph=round(($stat7-100)/200*42+84);
elseif ($stat7<1000) $graph=round(($stat7-300)/700*42+126);
else $graph=168;
$store.='Testovi sa procentom tačnosti većim od 75% u toku jednog dana$!$'.$stat8.'$!$30$!$100$!$300$!$1k$!$'.$graph.'$#$';

// Testovi sa svim tačnim odgovorima u toku jednog dana
$stat9=0;
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND
		tacnih = ukupno AND ukupno>9 AND vrsta="rec" GROUP BY DATE(datum)';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
while($row=$result->fetch_assoc()) {
$aaa=$row['cnt'];
if ($aaa>$stat9) $stat9=$aaa;
}
if ($stat9<=10) $graph=round($stat9/10*42);
elseif ($stat9<=30) $graph=round(($stat9-10)/20*42+42);
elseif ($stat9<=100) $graph=round(($stat9-30)/70*42+84);
elseif ($stat9<300) $graph=round(($stat9-100)/200*42+126);
else $graph=168;
$store.='Testovi sa svim tačnim odgovorima u toku jednog dana$!$'.$stat9.'$!$10$!$30$!$100$!$300$!$'.$graph.'$#$';

// Svi tacni odgovori u toku jednog dana
$stat10=0;
$sql='SELECT SUM(tacnih) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND vrsta="rec" GROUP BY DATE(datum)';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
while($row=$result->fetch_assoc()) {
$aaa=$row['cnt'];
if ($aaa>$stat10) $stat10=$aaa;
}
if ($stat10<=300) $graph=round($stat10/300*42);
elseif ($stat10<=1000) $graph=round(($stat10-300)/700*42+42);
elseif ($stat10<=3000) $graph=round(($stat10-1000)/2000*42+84);
elseif ($stat10<10000) $graph=round(($stat10-3000)/7000*42+126);
else $graph=168;$store.='Svi tačni odgovori u toku jednog dana$!$'.$stat10.'$!$300$!$1k$!$3k$!$10k$!$'.$graph.'$#$';

// Testovi sa procentom tačnosti većim od 50% u toku jedne sedmice
$stat11=0;
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND
		(tacnih / ukupno) >= 0.5 AND ukupno>9 AND vrsta="rec" GROUP BY YEAR(datum), WEEK(datum,0)';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
while($row=$result->fetch_assoc()) {
$aaa=$row['cnt'];
if ($aaa>$stat11) $stat11=$aaa;
}
if ($stat11<=100) $graph=round($stat11/30*42);
elseif ($stat11<=300) $graph=round(($stat11-100)/200*42+42);
elseif ($stat11<=1000) $graph=round(($stat11-300)/700*42+84);
elseif ($stat11<3000) $graph=round(($stat11-1000)/2000*42+126);
else $graph=168;
$store.='Testovi sa procentom tačnosti većim od 50% u toku jedne sedmice$!$'.$stat11.'$!$30$!$100$!$300$!$1k$!$'.$graph.'$#$';

// Testovi sa procentom tačnosti većim od 75% u toku jedne sedmice
$stat12=0;
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND
		(tacnih / ukupno) >= 0.75 AND ukupno>9 AND vrsta="rec" GROUP BY YEAR(datum), WEEK(datum,0)';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
while($row=$result->fetch_assoc()) {
$aaa=$row['cnt'];
if ($aaa>$stat12) $stat12=$aaa;
}
if ($stat12<=30) $graph=round($stat12/30*42);
elseif ($stat12<=100) $graph=round(($stat12-30)/70*42+42);
elseif ($stat12<=300) $graph=round(($stat12-100)/200*42+84);
elseif ($stat12<1000) $graph=round(($stat12-300)/700*42+126);
else $graph=168;
$store.='Testovi sa procentom tačnosti većim od 75% u toku jedne sedmice$!$'.$stat12.'$!$30$!$100$!$300$!$1k$!$'.$graph.'$#$';

// Testovi sa svim tačnim odgovorima u toku jedne sedmice
$stat13=0;
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND
		tacnih = ukupno AND ukupno>9 AND vrsta="rec" GROUP BY YEAR(datum), WEEK(datum,0)';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
while($row=$result->fetch_assoc()) {
$aaa=$row['cnt'];
if ($aaa>$stat13) $stat13=$aaa;
}
if ($stat13<=10) $graph=round($stat13/10*42);
elseif ($stat13<=30) $graph=round(($stat13-10)/20*42+42);
elseif ($stat13<=100) $graph=round(($stat13-30)/70*42+84);
elseif ($stat13<300) $graph=round(($stat13-100)/200*42+126);
else $graph=168;
$store.='Testovi sa svim tačnim odgovorima u toku jedne sedmice$!$'.$stat13.'$!$10$!$30$!$100$!$300$!$'.$graph.'$#$';

// Svi tacni odgovori u toku jedne sedmice
$stat14=0;
$sql='SELECT SUM(tacnih) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND vrsta="rec" GROUP BY YEAR(datum), WEEK(datum,0)';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
while($row=$result->fetch_assoc()) {
$aaa=$row['cnt'];
if ($aaa>$stat14) $stat14=$aaa;
}
if ($stat14<=1000) $graph=round($stat14/1000*42);
elseif ($stat14<=3000) $graph=round(($stat14-1000)/2000*42+42);
elseif ($stat14<=10000) $graph=round(($stat14-3000)/7000*42+84);
elseif ($stat14<30000) $graph=round(($stat14-10000)/20000*42+126);
else $graph=168;
$store.='Svi tačni odgovori u toku jedne sedmice$!$'.$stat14.'$!$1k$!$3k$!$10k$!$30k$!$'.$graph.'$#$';

// Testovi sa procentom tačnosti većim od 50% u toku jednog meseca
$stat15=0;
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND
		(tacnih / ukupno) >= 0.5 AND ukupno>9 AND vrsta="rec" GROUP BY YEAR(datum), MONTH(datum)';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
while($row=$result->fetch_assoc()) {
$aaa=$row['cnt'];
if ($aaa>$stat15) $stat15=$aaa;
}
if ($stat15<=300) $graph=round($stat15/300*42);
elseif ($stat15<=1000) $graph=round(($stat15-300)/700*42+42);
elseif ($stat15<=3000) $graph=round(($stat15-1000)/2000*42+84);
elseif ($stat15<10000) $graph=round(($stat15-3000)/7000*42+126);
else $graph=168;
$store.='Testovi sa procentom tačnosti većim od 50% u toku jednog meseca$!$'.$stat15.'$!$300$!$1k$!$3k$!$10k$!$'.$graph.'$#$';

// Testovi sa procentom tačnosti većim od 75% u toku jednog meseca
$stat16=0;
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND
		(tacnih / ukupno) >= 0.75 AND ukupno>9 AND vrsta="rec" GROUP BY YEAR(datum), MONTH(datum)';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
while($row=$result->fetch_assoc()) {
$aaa=$row['cnt'];
if ($aaa>$stat16) $stat16=$aaa;
}
if ($stat16<=300) $graph=round($stat16/3000*42);
elseif ($stat16<=1000) $graph=round(($stat16-300)/700*42+42);
elseif ($stat16<=3000) $graph=round(($stat16-1000)/2000*42+84);
elseif ($stat16<10000) $graph=round(($stat16-3000)/7000*42+126);
else $graph=168;
$store.='Testovi sa procentom tačnosti većim od 75% u toku jednog meseca$!$'.$stat16.'$!$300$!$1k$!$3k$!$10k$!$'.$graph.'$#$';

// Testovi sa svim tačnim odgovorima u toku jednog meseca
$stat17=0;
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND
		tacnih = ukupno AND ukupno>9 AND vrsta="rec" GROUP BY YEAR(datum), MONTH(datum)';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
while($row=$result->fetch_assoc()) {
$aaa=$row['cnt'];
if ($aaa>$stat17) $stat17=$aaa;
}
if ($stat17<=100) $graph=round($stat17/100*42);
elseif ($stat17<=300) $graph=round(($stat17-100)/200*42+42);
elseif ($stat17<=1000) $graph=round(($stat17-300)/700*42+84);
elseif ($stat17<3000) $graph=round(($stat17-1000)/2000*42+126);
else $graph=168;
$store.='Testovi sa svim tačnim odgovorima u toku jednog meseca$!$'.$stat17.'$!$100$!$300$!$1k$!$3k$!$'.$graph.'$#$';

// Svi tacni odgovori u toku jednog meseca
$stat18=0;
$sql='SELECT SUM(tacnih) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND vrsta="rec" GROUP BY YEAR(datum), MONTH(datum)';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
while($row=$result->fetch_assoc()) {
$aaa=$row['cnt'];
if ($aaa>$stat18) $stat18=$aaa;
}
if ($stat18<=3000) $graph=round($stat18/3000*42);
elseif ($stat18<=10000) $graph=round(($stat18-3000)/7000*42+42);
elseif ($stat18<=30000) $graph=round(($stat18-10000)/20000*42+84);
elseif ($stat18<100000) $graph=round(($stat18-30000)/70000*42+126);
else $graph=168;
$store.='Svi tačni odgovori u toku jednog meseca$!$'.$stat18.'$!$3k$!$10k$!$30k$!$100k$!$'.$graph.'$#$';

// Svi testovi u toku jednog dana
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND vrsta="rec" GROUP BY DATE(datum)';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat19=$row['cnt'];
if ($stat19==NULL) $stat19=0;
if ($stat19<=100) $graph=round($stat19/100*42);
elseif ($stat19<=300) $graph=round(($stat19-100)/200*42+42);
elseif ($stat19<=1000) $graph=round(($stat19-300)/700*42+84);
elseif ($stat19<3000) $graph=round(($stat19-1000)/2000*42+126);
else $graph=168;
$store.='Svi testovi u toku jednog dana$!$'.$stat19.'$!$100$!$300$!$1k$!$3k$!$'.$graph.'$#$';

// Svi testovi u toku jedne sedmice
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND vrsta="rec" GROUP BY YEAR(datum), WEEK(datum,0)';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat20=$row['cnt'];
if ($stat20==NULL) $stat20=0;
if ($stat20<=300) $graph=round($stat20/300*42);
elseif ($stat20<=1000) $graph=round(($stat20-300)/700*42+42);
elseif ($stat20<=3000) $graph=round(($stat20-1000)/2000*42+84);
elseif ($stat20<10000) $graph=round(($stat20-3000)/7000*42+126);
else $graph=168;
$store.='Svi testovi u toku jedne sedmice$!$'.$stat20.'$!$300$!$1k$!$3k$!$10k$!$'.$graph.'$#$';

// Svi testovi u toku jednog meseca
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND vrsta="rec" GROUP BY YEAR(datum), MONTH(datum)';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat21=$row['cnt'];
if ($stat21==NULL) $stat21=0;
if ($stat21<=1000) $graph=round($stat21/1000*42);
elseif ($stat21<=3000) $graph=round(($stat21-1000)/2000*42+42);
elseif ($stat21<=10000) $graph=round(($stat21-3000)/7000*42+84);
elseif ($stat21<30000) $graph=round(($stat21-10000)/20000*42+126);
else $graph=168;
$store.='Svi testovi u toku jednog meseca$!$'.$stat21.'$!$1k$!$3k$!$10k$!$30k$!$'.$graph.'$#$';

// Svi testovi u toku jednog dana za ovaj jezik
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND vrsta="rec" GROUP BY DATE(datum)';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat22=$row['cnt'];
if ($stat22==NULL) $stat22=0;
if ($stat22<=300) $graph=round($stat22/300*42);
elseif ($stat22<=1000) $graph=round(($stat22-300)/700*42+42);
elseif ($stat22<=3000) $graph=round(($stat22-1000)/2000*42+84);
elseif ($stat22<10000) $graph=round(($stat22-3000)/7000*42+126);
else $graph=168;
$store.='Svi testovi u toku jednog dana za ovaj jezik$!$'.$stat22.'$!$300$!$1k$!$3k$!$10k$!$'.$graph.'$#$';

// Svi testovi u toku jedne sedmice za ovaj jezik
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND vrsta="rec" GROUP BY YEAR(datum), WEEK(datum,0)';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat23=$row['cnt'];
if ($stat23==NULL) $stat23=0;
if ($stat23<=1000) $graph=round($stat23/1000*42);
elseif ($stat23<=3000) $graph=round(($stat23-1000)/2000*42+42);
elseif ($stat23<=10000) $graph=round(($stat23-3000)/7000*42+84);
elseif ($stat23<30000) $graph=round(($stat23-10000)/20000*42+126);
else $graph=168;
$store.='Svi testovi u toku jedne sedmice za ovaj jezik$!$'.$stat23.'$!$1k$!$3k$!$10k$!$30k$!$'.$graph.'$#$';

// Svi testovi u toku jednog meseca za ovaj jezik
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND vrsta="rec" GROUP BY YEAR(datum), MONTH(datum)';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat24=$row['cnt'];
if ($stat24==NULL) $stat24=0;
if ($stat24<=3000) $graph=round($stat24/3000*42);
elseif ($stat24<=10000) $graph=round(($stat24-3000)/7000*42+42);
elseif ($stat24<=30000) $graph=round(($stat24-10000)/20000*42+84);
elseif ($stat24<100000) $graph=round(($stat24-30000)/70000*42+126);
else $graph=168;
$store.='Svi testovi u toku jednog meseca za ovaj jezik$!$'.$stat24.'$!$3k$!$10k$!$30k$!$100k$!$'.$graph.'$#$';

// Sve tačne reči za ovaj jezik
$sql='SELECT SUM(tacnih) cnt FROM test_rezultati WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND vrsta="rec"';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat25=$row['cnt'];
if ($stat25==NULL) $stat25=0;
if ($stat25<=10000) $graph=round($stat25/10000*42);
elseif ($stat25<=30000) $graph=round(($stat25-10000)/20000*42+42);
elseif ($stat25<=100000) $graph=round(($stat25-30000)/70000*42+84);
elseif ($stat25<300000) $graph=round(($stat25-100000)/200000*42+126);
else $graph=168;
$store.='Sve tačne reči za ovaj jezik$!$'.$stat25.'$!$10k$!$30k$!$100k$!$300k$!$'.$graph.'$#$';

// Svi testovi u toku jednog dana za ovog korisnika
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE user="'.$userx.'" AND vrsta="rec" GROUP BY DATE(datum)';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat26=$row['cnt'];
if ($stat26==NULL) $stat26=0;
if ($stat26<=300) $graph=round($stat26/300*42);
elseif ($stat26<=1000) $graph=round(($stat26-300)/700*42+42);
elseif ($stat26<=3000) $graph=round(($stat26-1000)/2000*42+84);
elseif ($stat26<10000) $graph=round(($stat26-3000)/7000*42+126);
else $graph=168;
$store.='Svi testovi u toku jednog dana koje ste vi obavili$!$'.$stat26.'$!$300$!$1k$!$3k$!$10k$!$'.$graph.'$#$';

// Svi testovi u toku jedne sedmice ovog korisnika
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE user="'.$userx.'" AND vrsta="rec" GROUP BY YEAR(datum), WEEK(datum,0)';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat27=$row['cnt'];
if ($stat27==NULL) $stat27=0;
if ($stat27<=1000) $graph=round($stat27/1000*42);
elseif ($stat27<=3000) $graph=round(($stat27-1000)/2000*42+42);
elseif ($stat27<=10000) $graph=round(($stat27-3000)/7000*42+84);
elseif ($stat27<30000) $graph=round(($stat27-10000)/20000*42+126);
else $graph=168;
$store.='Svi testovi u toku jedne sedmice koje ste vi obavili$!$'.$stat27.'$!$1k$!$3k$!$10k$!$30k$!$'.$graph.'$#$';

// Svi testovi u toku jednog meseca ovog korisnika
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE user="'.$userx.'" AND vrsta="rec" GROUP BY YEAR(datum), MONTH(datum)';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat28=$row['cnt'];
if ($stat28==NULL) $stat28=0;
if ($stat28<=3000) $graph=round($stat28/3000*42);
elseif ($stat28<=10000) $graph=round(($stat28-3000)/7000*42+42);
elseif ($stat28<=30000) $graph=round(($stat28-10000)/20000*42+84);
elseif ($stat28<100000) $graph=round(($stat28-30000)/70000*42+126);
else $graph=168;
$store.='Svi testovi u toku jednog meseca koje ste vi obavili$!$'.$stat28.'$!$3k$!$10k$!$30k$!$100k$!$'.$graph.'$#$';

// Sve tačne reči ovog korisnika
$sql='SELECT SUM(tacnih) cnt FROM test_rezultati WHERE user="'.$userx.'" AND vrsta="rec"';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat29=$row['cnt'];
if ($stat29==NULL) $stat29=0;
if ($stat29<=30000) $graph=round($stat29/30000*42);
elseif ($stat29<=100000) $graph=round(($stat29-30000)/70000*42+42);
elseif ($stat29<=300000) $graph=round(($stat29-100000)/200000*42+84);
elseif ($stat29<1000000) $graph=round(($stat29-300000)/700000*42+126);
else $graph=168;
$store.='Sve tačne reči koje ste vi pogodili$!$'.$stat29.'$!$30k$!$100k$!$300k$!$1M$!$'.$graph.'$#$';

// Svi testovi u toku jednog dana za sve korisnike
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE vrsta="rec" GROUP BY DATE(datum)';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat30=$row['cnt'];
if ($stat30<=3000) $graph=round($stat30/3000*42);
elseif ($stat30<=10000) $graph=round(($stat30-3000)/7000*42+42);
elseif ($stat30<=30000) $graph=round(($stat30-10000)/20000*42+84);
elseif ($stat30<100000) $graph=round(($stat30-30000)/70000*42+126);
else $graph=168;
$store.='Svi testovi u toku jednog dana za sve korisnike$!$'.$stat30.'$!$3k$!$10k$!$30k$!$100k$!$'.$graph.'$#$';

// Svi testovi u toku jedne sedmice za sve korisnike
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE vrsta="rec" GROUP BY YEAR(datum), WEEK(datum,0)';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat31=$row['cnt'];
if ($stat31<=10000) $graph=round($stat31/10000*42);
elseif ($stat31<=30000) $graph=round(($stat31-10000)/20000*42+42);
elseif ($stat31<=100000) $graph=round(($stat31-30000)/70000*42+84);
elseif ($stat31<300000) $graph=round(($stat31-100000)/200000*42+126);
else $graph=168;
$store.='Svi testovi u toku jedne sedmice za sve korisnike$!$'.$stat31.'$!$10k$!$30k$!$100k$!$300k$!$'.$graph.'$#$';

// Svi testovi u toku jednog meseca za sve korisnike
$sql='SELECT COUNT(*) cnt FROM test_rezultati WHERE vrsta="rec" GROUP BY YEAR(datum), MONTH(datum)';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat32=$row['cnt'];
if ($stat32<=30000) $graph=round($stat32/30000*42);
elseif ($stat32<=100000) $graph=round(($stat32-30000)/70000*42+42);
elseif ($stat32<=300000) $graph=round(($stat32-100000)/200000*42+84);
elseif ($stat32<1000000) $graph=round(($stat32-300000)/700000*42+126);
else $graph=168;
$store.='Svi testovi u toku jednog meseca za sve korisnike$!$'.$stat32.'$!$30k$!$100k$!$300k$!$1M$!$'.$graph.'$#$';

// Sve tačne reči za sve korisnike
$sql='SELECT SUM(tacnih) cnt FROM test_rezultati WHERE vrsta="rec"';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$stat33=$row['cnt'];
if ($stat33<=300000) $graph=round($stat33/300000*42);
elseif ($stat33<=1000000) $graph=round(($stat33-300000)/700000*42+42);
elseif ($stat33<=3000000) $graph=round(($stat33-1000000)/2000000*42+84);
elseif ($stat33<10000000) $graph=round(($stat33-3000000)/7000000*42+126);
else $graph=168;
$store.='Sve tačne reči za sve korisnike$!$'.$stat33.'$!$300k$!$1M$!$3M$!$10M$!$'.$graph;

$sql='SELECT stat, ID, COUNT(*) cnt FROM test_statistike WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND vrsta="rec"';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$idsel=$row['ID'];
if ($row['cnt']==1) {
	$laststat=$row['stat'];
	$sql='UPDATE test_statistike SET stat="'.$store.'", datum="'.$datum.'", laststat="'.$laststat.'" WHERE ID="'.$idsel.'"';
	$mysqli->query($sql) or die(mysqli_error($mysqli));
}
else {
	$sql='INSERT INTO test_statistike (user, vrsta, recnik, smer, stat, datum) VALUES ("'.$userx.'","rec","'.$recnik.'","'.$smer.'","'.$store.'","'.$datum.'")';
	$mysqli->query($sql) or die(mysqli_error($mysqli));
}

}

$sql='SELECT stat, laststat FROM test_statistike WHERE user="'.$userx.'" AND recnik="'.$recnik.'" AND smer="'.$smer.'" AND vrsta="rec"';
$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
$row=$result->fetch_assoc();
$statx1=explode('$!!$',$row['stat']);
$statx1a=$statx1[0];
$statx1aa=explode('$!$',$statx1a);
$statx1b=$statx1[1];
$statx=explode('$#$',$statx1b);

$staty=explode('$!!$',$row['laststat']);
$statya=explode('$!$',$staty[0]);
$statyb=explode('$#$',$staty[1]);

for ($i = 0; $i <= 39; $i++) {
    ${'statxx'.$i}=explode('$!$',$statx[$i]);
	${'statyy'.$i}=explode('$!$',$statyb[$i]);
}

for ($i = 0; $i <= 2; $i++) {
	if ($statya[$i]>$statx1aa[$i]) {
	$razl[$i]=$statya[$i]-$statx1aa[$i];
	$por1[$i]='(&#x25BC '.$razl[$i].')';
	}
	elseif ($statya[$i]<$statx1aa[$i]) {
	$razl[$i]=$statx1aa[$i]-$statya[$i];
	$por1[$i]='(&#x25B2 '.$razl[$i].')';
	}
	else $por1[$i]='';
}

for ($i = 0; $i <= 39; $i++) {
	if ($i < 3) {
		$statzzx[$i]=substr(${'statxx'.$i}[1],0,-1);
		$statzzy[$i]=substr(${'statyy'.$i}[1],0,-1);
		if ($statzzy[$i]>$statzzx[$i]) {
			$razl[$i]=$statzzy[$i]-$statzzx[$i];
			$por2[$i]='<span style="color:#633;">&#x25BC '.$razl[$i].'%</span>';
		}
		elseif ($statzzy[$i]<$statzzx[$i]) {
			$razl[$i]=$statzzx[$i]-$statzzy[$i];
			$por2[$i]='<span style="color:#363;">&#x25B2 '.$razl[$i].'%</span>';
		}
		else $por2[$i]='';
	}
	elseif ($i < 7) {
		if (${'statyy'.$i}[1]<${'statxx'.$i}[1]) {
			$razl[$i]=${'statxx'.$i}[1]-${'statyy'.$i}[1];
			$por2[$i]='<span style="color:#363;">&#x25B2 '.$razl[$i].'</span>';
		}
		else $por2[$i]='';
	}
	else {
		if (${'statyy'.$i}[1]>${'statxx'.$i}[1]) {
			$razl[$i]=${'statyy'.$i}[1]-${'statxx'.$i}[1];
			$por2[$i]='<span style="color:#633;">&#x25BC '.$razl[$i].'</span>';
		}
		elseif (${'statyy'.$i}[1]<${'statxx'.$i}[1]) {
			$razl[$i]=${'statxx'.$i}[1]-${'statyy'.$i}[1];
			$por2[$i]='<span style="color:#363;">&#x25B2 '.$razl[$i].'</span>';
		}
		else $por2[$i]='';
	}
}

$passhtml.='<div style="height:15px;width:280px;border-bottom: 1px solid black;margin-bottom:3px"><div style="width:80px;margin-right:16px;float:left;">Naučenih reči:</div><div style="float:left;width:42px;text-align:center"><a href="#" class="graylink" title="u ovom smeru '.$por1[0].'od ukupno '.$statx1aa[3].'">'.$statx1aa[0].'</a></div><div style="float:left;width:42px;text-align:center"><a href="#" class="graylink" title="u oba smera '.$por1[1].' od ukupno '.$statx1aa[3].'">'.$statx1aa[1].'</a></div><div style="float:left;width:42px;text-align:center"><a href="#" class="graylink" title="svih jezika od ukupno '.$por1[2].' '.$statx1aa[4].'">'.$statx1aa[2].'</a></div></div>';

for ($i = 0; $i <= 39; $i++) {
	$passhtml.='<div style="width:280px;height:15px';
	if ($i==2 OR $i==6 OR $i==10 OR $i==12 OR $i==16 OR $i==20 OR $i==24 OR $i==27 OR $i==31 OR $i==35 OR $i==39) $passhtml.=';border-bottom: 1px solid black';
	$passhtml.='"><div style="float:left;width:50px;text-align:right;margin-right:5px"><a class="graylink" href="#" title="'.${'statxx'.$i}[0].'"';
	if ((($i==3 AND $statxx3[1]==$statxx13[1]) OR ($i==4 AND $statxx4[1]==$statxx14[1]) OR ($i==5 AND $statxx5[1]==$statxx15[1]) OR ($i==6 AND $statxx6[1]==$statxx16[1]) OR ($i==13 AND $statxx13[1]==$statxx17[1]) OR ($i==14 AND $statxx14[1]==$statxx18[1]) OR ($i==15 AND $statxx15[1]==$statxx19[1]) OR ($i==16 AND $statxx16[1]==$statxx20[1]) OR ($i==17 AND $statxx17[1]==$statxx21[1]) OR ($i==18 AND $statxx18[1]==$statxx22[1]) OR ($i==19 AND $statxx19[1]==$statxx23[1]) OR ($i==20 AND $statxx20[1]==$statxx24[1]) OR ($i==25 AND $statxx25[1]==$statxx26[1]) OR ($i==26 AND $statxx26[1]==$statxx27[1]) OR ($i==28 AND $statxx28[1]==$statxx29[1]) OR ($i==29 AND $statxx29[1]==$statxx30[1]) OR ($i==32 AND $statxx32[1]==$statxx33[1]) OR ($i==33 AND $statxx33[1]==$statxx34[1]) OR ($i==36 AND $statxx36[1]==$statxx37[1]) OR ($i==37 AND $statxx37[1]==$statxx38[1])) AND ${'statxx'.$i}[1]!=0) $passhtml.=' style="font-weight:bold"';
	$passhtml.='>'.${'statxx'.$i}[1].'</a></div> <div style="float:left;width:168px;height:15px"><div style="width:168px;height:7px;font-size:7;padding:0;background:#fff"><div style="padding:0;margin-left:20px;width:42px;text-align:center;float:left">'.${'statxx'.$i}[2].'</div><div style="padding:0;width:42px;text-align:center;float:left">'.${'statxx'.$i}[3].'</div><div style="padding:0;width:42px;text-align:center;float:left">'.${'statxx'.$i}[4].'</div><div style="padding:0;width:22px;text-align:right;float:left">'.${'statxx'.$i}[5].'</div></div><div style="width:168px;height:4px;background:#ccc;padding:0"><div style="width:'.${'statxx'.$i}[6].'px;height:4px;padding:0;background:#';
	if (${'statxx'.$i}[6]<43) $passhtml.='333';
	elseif (${'statxx'.$i}[6]<85) $passhtml.='363';
	elseif (${'statxx'.$i}[6]<127) $passhtml.='393';
	elseif (${'statxx'.$i}[6]<168) $passhtml.='3c3';
	else $passhtml.='3f3';
	$passhtml.='"></div></div></div><div style="float:left;height:15px;width:53px">'.$por2[$i].'</div></div>';
}


$pass['passhtml2']=$passhtml;
echo json_encode($pass);
?>