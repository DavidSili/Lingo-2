<?php
include '../config.php';
$dizajn1 = isset($_GET["a1"]) ? $_GET["a1"] : 0;
$dizajn2 = isset($_GET["a2"]) ? $_GET["a2"] : 0;
$dizajn3 = isset($_GET["a3"]) ? $_GET["a3"] : 0;
$dizajn4 = isset($_GET["a4"]) ? $_GET["a4"] : 0;
$dizajn5 = isset($_GET["a5"]) ? $_GET["a5"] : 0;
$dizajn6 = isset($_GET["a6"]) ? $_GET["a6"] : 0;
$centriranje1 = isset($_GET["a7"]) ? $_GET["a7"] : 0;
$centriranje2 = isset($_GET["a8"]) ? $_GET["a8"] : 0;
$dizajn1 = mysqli_real_escape_string($mysqli,$dizajn1);
$dizajn2 = mysqli_real_escape_string($mysqli,$dizajn2);
$dizajn3 = mysqli_real_escape_string($mysqli,$dizajn3);
$dizajn4 = mysqli_real_escape_string($mysqli,$dizajn4);
$dizajn5 = mysqli_real_escape_string($mysqli,$dizajn5);
$dizajn6 = mysqli_real_escape_string($mysqli,$dizajn6);
$centriranje1 = mysqli_real_escape_string($mysqli,$centriranje1);
$centriranje2 = mysqli_real_escape_string($mysqli,$centriranje2);


$rowwidth1=$dizajn1*197;
$rowwidth2=$dizajn3*197;
if ($dizajn5!=0 and $dizajn5<$dizajn1) $rowwidth1=$rowwidth1+7;
if ($dizajn6!=0 and $dizajn6<$dizajn3) $rowwidth2=$rowwidth2+7;

$passhtml="";
for ($x = 1; $x <= 2; $x++) {
	$sepx=$x+4;
	$passhtml.='<div style="width:'.${'rowwidth'.$x}.'px';
	if (${'centriranje'.$x}==1) $passhtml.=';margin: 0 auto';
	$passhtml.='">';
	$kolonex=$x*2-1;
	for ($i = 1; $i <= ${'dizajn'.$kolonex}; $i++) {
	if ((${'dizajn'.$sepx}+1)==$i and ${'dizajn'.$sepx}!=0) $passhtml.='<div style="float:left;width:2px;height:32px;margin-right:5px;background:#000"></div>';
	$passhtml.='<div id="element"><span style="font-size:12">Širina kolone:</span><select name="sirina'.$x.'x'.$i.'"><option value="1">Najuže</option><option value="2">Usko</option><option value="3" selected>Srednje</option><option value="4">Široko</option></select></div>';
	}
	$passhtml.='</div>';
	$redovix=$x*2;
	for ($i = 1; $i <= ${'dizajn'.$redovix}; $i++) {
		$passhtml.='<div style="width:'.${'rowwidth'.$x}.'px';
		if (${'centriranje'.$x}==1) $passhtml.=';margin: 0 auto';
		$passhtml.='">';

			for ($ii = 1; $ii <= ${'dizajn'.$kolonex}; $ii++) {
				if ((${'dizajn'.$sepx}+1)==$ii and ${'dizajn'.$sepx}!=0) $passhtml.='<div style="float:left;width:2px;height:55px;margin-right:5px;background:#000"></div>';
				$passhtml.='<div id="element"><input name="in'.$x.'x'.$i.'x'.$ii.'" type="text" style="width:inherit"><select name="inv'.$x.'x'.$i.'x'.$ii.'"><option value="1" selected>tekst</option><option value="2">bold tekst</option><option value="3">italik tekst</option><option value="4">b + i tekst</option><option value="5">desni tekst</option><option value="6">desni bold tekst</option><option value="7">desni italik tekst</option><option value="8">desni b + i tekst</option><option value="9">odgovor</option></select><span style="font-size:12">Sakrij:</span><input type="checkbox" name="hide'.$x.'x'.$i.'x'.$ii.'" value="1" style="width:auto" /></div>';
			}
		
		$passhtml.='</div>';
	}
	if ($x==1) $passhtml.='<div style="height:10px"></div>';
}
$pass['passhtml']=$passhtml;
echo json_encode($pass);
?>