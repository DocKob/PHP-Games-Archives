<script language="JavaScript">
<!--
var continent = '<?php echo($_GET['continent']); ?>';

function af(type,ligne,colone) {
	if( type != "vide" )
	{
		document.write('<a href="jeu.php?include=carteregion&amp;pays='+type+'"><img border="0" width="40" height="40" src="images/carte/base.jpg" alt="Occupe"></a>');
	}
	else
	{
		document.write('<a href="#bottom" onClick="Rempli('+ligne+','+colone+')"><img border="0" width="40" height="40" src="images/carte/vide.jpg" alt="Vide"></a>');
	}
}
function Rempli(ligne,colone)
{
	document.conquerir.ligne.value = ligne;
	document.conquerir.colone.value = colone;
	
	document.getElementById('affichage').innerHTML = '<input name="nom" type="text" id="nom" maxlength="15" value="Nom"><a href="#" onClick="EnvoiFormulaire();">[Conquerir]</a>';
}

function EnvoiFormulaire()
{
	document.conquerir.method = "POST";
	document.conquerir.action = "action/conquerir.php";
	document.conquerir.submit();
}

-->
</script>
<table width="500" border="0" cellspacing="0" cellpadding="0" align="center" class="txt">
<tr>
<td>
<div id="cartepays" style="position:absolute; width:500; height:500; z-index:1;">
<?php
$continent = $_GET['continent'];

$sql = "SELECT * FROM is_pays WHERE continent = '".$continent."'";
$resultat_pays = mysql_query($sql);
$t_pays = mysql_fetch_array($resultat_pays);

$abc = array("1","2","3","4","5","6","7","8","9","10","11","12");

echo('<table align="center" border="0" cellpadding="0" cellspacing="0">');
for($i=0 ; $i < 12 ; $i++) {
	$ligne = explode(";",$t_pays[$abc[$i]]);
	echo("<tr>");
	for($a=0 ; $a < 12 ; $a++) {
		echo('<td><script>af("'.$ligne[$a].'","'.$i.'","'.$a.'");</script></td>');
	}
	echo("</tr>");
}
echo("</table>");
?>
</div>
<img src="images/spacer.gif" width="1" height="500"></td>
</tr>
<tr>
<td>
<form name="conquerir" method="post" action="action/conquerir.php">
<input type="hidden" name="ligne">
<input type="hidden" name="colone">
<input type="hidden" name="continent" value="<? echo($continent); ?>">
<div class="txt" id="affichage" align="center"></div>
</form>
</td>
</tr>
<tr>
<td class="table16px"><div align="center">Co&ucirc;ts pour conqu&eacute;rir une nouvelle r&eacute;gion 
</div></td>
</tr>
<tr>
<td>
<div align="center">
<?php
$sql = "SELECT id FROM is_region WHERE pseudo='$pseudo'";
$resultat_region = mysql_query($sql);
$nombre = mysql_num_rows($resultat_region);

$cout_soldats = $nombre*750;
$cout_clones = $nombre*2000;
$cout_nourriture = $cout_soldats*30 + $cout_clones*20;
echo("Cl&ocirc;nes: $cout_clones | Soldats: $cout_soldats | Nourriture: $cout_nourriture");
?>
</div></td>
</tr>
</table>