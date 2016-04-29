<?php
include '../config.php';
$vrsta = isset($_GET["vrsta"]) ? $_GET["vrsta"] : 0;
$recnik = isset($_GET["recnik"]) ? $_GET["recnik"] : 0;

if ($vrsta!=0) $sql="SELECT * FROM $recnik WHERE `ID`=$vrsta";
else $sql="SELECT * FROM $recnik ORDER BY `ID` DESC LIMIT 1";
	$result = $mysqli->query($sql) or die;
	$row=$result->fetch_assoc();
	foreach($row as $aa => $bb) {
		$$aa=$bb;
	}

$a=explode('$#!$',$dizajn);
$dizajn5=$a[0];
$dizajn6=$a[1];
$centriranje1=$a[2];
$centriranje2=$a[3];
$sirina1=explode(',',$a[4]);
$sirina2=explode(',',$a[5]);
$b=explode('$#$,',$a[6]);
$odg=explode(',',$odgovori);	
$odgc=0;
$ecount=1;
$ycount1=0;
$ycount2=0;
foreach ($b as $inb) {
	$c=explode('$y$,',$inb);
	foreach ($c as $inc) {
		${'ycount'.$ecount}++;
		$d=explode(',',$inc);
		$cellcount=1;
		foreach ($d as $ind) {
			if ($ind=='$!$') {
				${'in'.$ecount.'x'.${'ycount'.$ecount}.'x'.$cellcount}=$odg[$odgc];
				${'inv'.$ecount.'x'.${'ycount'.$ecount}.'x'.$cellcount}=9;
				${'hide'.$ecount.'x'.${'ycount'.$ecount}.'x'.$cellcount}=0;
				$odgc++;
			}
			elseif ($ind=='$x$') {
				${'in'.$ecount.'x'.${'ycount'.$ecount}.'x'.$cellcount}="";
				${'inv'.$ecount.'x'.${'ycount'.$ecount}.'x'.$cellcount}=1;
				${'hide'.$ecount.'x'.${'ycount'.$ecount}.'x'.$cellcount}=1;
			}
			else {
				${'in'.$ecount.'x'.${'ycount'.$ecount}.'x'.$cellcount}=substr($ind,3);
				${'inv'.$ecount.'x'.${'ycount'.$ecount}.'x'.$cellcount}=substr($ind,0,1);
				${'hide'.$ecount.'x'.${'ycount'.$ecount}.'x'.$cellcount}=0;
			}
			$cellcount++;
		}
	}
	$ecount++;
}
$dizajn2=$ycount1;
$dizajn4=$ycount2;
$dizajn1=count($sirina1);
$dizajn3=count($sirina2);

$rowwidth1=$dizajn1*197;
$rowwidth2=$dizajn3*197;
if ($dizajn5!=0 and $dizajn5<$dizajn1) $rowwidth1=$rowwidth1+7;
if ($dizajn6!=0 and $dizajn6<$dizajn3) $rowwidth2=$rowwidth2+7;

$passhtml="";
$passhtml.='<h4>'.$naziv.'</h4>';

for ($x = 1; $x <= 2; $x++) {
	$sepx=$x+4;
	$passhtml.='<div style="width:'.${'rowwidth'.$x}.'px';
	if (${'centriranje'.$x}==1) $passhtml.=';margin: 0 auto';
	$passhtml.='">';
	$kolonex=$x*2-1;
	for ($i = 1; $i <= ${'dizajn'.$kolonex}; $i++) {
		$xi=$i-1;
		if ((${'dizajn'.$sepx}+1)==$i and ${'dizajn'.$sepx}!=0) $passhtml.='<div style="float:left;width:2px;height:32px;margin-right:5px;background:#000"></div>';
		$passhtml.='<div id="element"><span style="font-size:12">Širina kolone:</span><select name="sirina'.$x.'x'.$i.'"><option value="1"';
		if (${'sirina'.$x}[$xi]==1) $passhtml.=' selected';
		$passhtml.='>Najuže</option><option value="2"';
		if (${'sirina'.$x}[$xi]==2) $passhtml.=' selected';
		$passhtml.='>Usko</option><option value="3"';
		if (${'sirina'.$x}[$xi]==3) $passhtml.=' selected';
		$passhtml.='>Srednje</option><option value="4"';
		if (${'sirina'.$x}[$xi]==4) $passhtml.=' selected';
		$passhtml.='>Široko</option></select></div>';
	}
	$passhtml.='</div>';
	$redovix=$x*2;
	for ($i = 1; $i <= ${'dizajn'.$redovix}; $i++) {
		$passhtml.='<div style="width:'.${'rowwidth'.$x}.'px';
		if (${'centriranje'.$x}==1) $passhtml.=';margin: 0 auto';
		$passhtml.='">';

			for ($ii = 1; $ii <= ${'dizajn'.$kolonex}; $ii++) {
				if ((${'dizajn'.$sepx}+1)==$ii and ${'dizajn'.$sepx}!=0) $passhtml.='<div style="float:left;width:2px;height:55px;margin-right:5px;background:#000"></div>';
				$passhtml.='<div id="element"><input name="in'.$x.'x'.$i.'x'.$ii.'" value="'.${'in'.$x.'x'.$i.'x'.$ii}.'" type="text" style="width:inherit"><select name="inv'.$x.'x'.$i.'x'.$ii.'"><option value="1"';
				if (${'inv'.$x.'x'.$i.'x'.$ii}==1) $passhtml.=' selected';
				$passhtml.='>tekst</option><option value="2"';
				if (${'inv'.$x.'x'.$i.'x'.$ii}==2) $passhtml.=' selected';
				$passhtml.='>bold tekst</option><option value="3"';
				if (${'inv'.$x.'x'.$i.'x'.$ii}==3) $passhtml.=' selected';
				$passhtml.='>italik tekst</option><option value="4"';
				if (${'inv'.$x.'x'.$i.'x'.$ii}==4) $passhtml.=' selected';
				$passhtml.='>b + i tekst</option><option value="5"';
				if (${'inv'.$x.'x'.$i.'x'.$ii}==5) $passhtml.=' selected';
				$passhtml.='>desni tekst</option><option value="6"';
				if (${'inv'.$x.'x'.$i.'x'.$ii}==6) $passhtml.=' selected';
				$passhtml.='>desni bold tekst</option><option value="7"';
				if (${'inv'.$x.'x'.$i.'x'.$ii}==7) $passhtml.=' selected';
				$passhtml.='>desni italik tekst</option><option value="8"';
				if (${'inv'.$x.'x'.$i.'x'.$ii}==8) $passhtml.=' selected';
				$passhtml.='>desni b + i tekst</option><option value="9"';
				if (${'inv'.$x.'x'.$i.'x'.$ii}==9) $passhtml.=' selected';
				$passhtml.='>odgovor</option></select><span style="font-size:12">Sakrij:</span><input type="checkbox" name="hide'.$x.'x'.$i.'x'.$ii.'" value="1" ';
				if (${'hide'.$x.'x'.$i.'x'.$ii}==1) $passhtml.=' checked="checked"';
				$passhtml.='style="width:auto" /></div>';
			}
		
		$passhtml.='</div>';
	}
	if ($x==1) $passhtml.='<div style="height:10px"></div>';
}
$pass['passhtml']=$passhtml;
$pass['ID']=$ID;
$pass['dizajn1']=$dizajn1;
$pass['dizajn2']=$dizajn2;
$pass['dizajn3']=$dizajn3;
$pass['dizajn4']=$dizajn4;
$pass['dizajn5']=$dizajn5;
$pass['dizajn6']=$dizajn6;
$pass['centriranje1']=$centriranje1;
$pass['centriranje2']=$centriranje2;
$pass['nazivdek']=$naziv;
echo json_encode($pass);
?>