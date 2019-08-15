<?php

// Si la constante n'est pas defini on bloque l'execution du fichier
if(!defined('PHPSIMUL_PAGES') || @PHPSIMUL_PAGES != 'PHPSIMULLL') 
{
die('Erreur 404 - Le fichier n\'a pas été trouvé');
}

/* PHPsimul : Créez votre jeu de simulation en PHP
Copyright (©) - 2007 - CAPARROS Sébastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr

*/

lang("coordonnees");

@$page.="
<script>
function afficher(o1, o2, o3)
{
document.form.c1.options[o1 - 1].selected='selected'; 
document.form.c2.options[o2 - 1].selected='selected'; 
document.form.c3.options[o3 - 1].selected='selected'; 
}
</script>

";

$ordre_1 = $baserow["ordre_1"];
$ordre_2 = $baserow["ordre_2"];
$ordre_3 = $baserow["ordre_3"];

$page .= "<form name='form' action='index.php?mod=unites' method='post'>".$lang["coord"]." <select name='c1'>";

$o1 = 1;
$o2 = 1;
$o3 = 1;

while($o1 <= $controlrow["ordre_1_max"])
{

$select1 = "";

if($o1 == $ordre_1) {
$select1 = "selected";
}

$page .= "<option value='".$o1."' ".$select1.">".$o1."</option>";
$o1 = $o1 + 1;

}

$page .= "</select>&nbsp;&nbsp;&nbsp;<select name='c2'>";

while($o2 <= $controlrow["ordre_2_max"])
{

$select2 = "";

if($o2 == $ordre_2) {
$select2 = "selected";
}

$page .= "<option value='".$o2."' ".$select2.">".$o2."</option>";
$o2 = $o2 + 1;

}

$page .= "</select>&nbsp;&nbsp;&nbsp;<select name='c3'>";

while($o3 <= $controlrow["ordre_3_max"])
{

$select3 = "";

if($o3 == $ordre_3) {
$select3 = "selected";
}

$page .= "<option value='".$o3."' ".$select3.">".$o3."</option>";
$o3 = $o3 + 1;

}

$page .= "
</select><br><br><input type='submit' value='Continuer'>
</form><br><br><table border='0' width='60%'><tr><td width='30%'><b>Vous : </b><br><br>";

$val = $userrow["bases"];
$val = explode(",", $val);
$nombre = 0;

while(isset($val[$nombre])) {

$row = $sql->select("SELECT * FROM phpsim_bases WHERE id='".$val[$nombre]."'");

$page .= "<a href='javascript:afficher(".$row["ordre_1"].", ".$row["ordre_2"].", ".$row["ordre_3"]."); '>".$row["nom"]."</a><br>";

$nombre = $nombre + 1;
}

$page .= "</td><td valign='top'><b>".$lang["amis"]." </b><br><br>";

$amis = $sql->query("SELECT phpsim_users.nom, phpsim_bases.ordre_1, phpsim_bases.ordre_2, phpsim_bases.ordre_3 
FROM phpsim_listeamis, phpsim_users, phpsim_bases 
WHERE 
(phpsim_listeamis.owner=phpsim_users.id AND phpsim_listeamis.sender='".$userrow["id"]."'
AND phpsim_users.baseactuelle=phpsim_bases.id)
OR (phpsim_listeamis.owner='".$userrow["id"]."' AND phpsim_listeamis.sender=phpsim_users.id
AND phpsim_users.baseactuelle=phpsim_bases.id)
ORDER BY phpsim_users.nom
") OR die(mysql_error());


while($row = mysql_fetch_array($amis)) {

$page .= "<a href='javascript:afficher(".$row["ordre_1"].", ".$row["ordre_2"].", ".$row["ordre_3"]."); '>".$row["nom"]."</a><br>";

}

$page .= "</td></tr></table>";

?>