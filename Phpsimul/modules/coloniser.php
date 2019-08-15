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

lang("coloniser");

include("classes/batiments.class.php");
$bat = new batiment;

$test = $userrow["bases"];
$liste = explode(",", $test);
$nb = count($liste);

if($nb >= $controlrow["bases_max"]) 
{
die($lang["maxatteint"]."<br><a href='index.php?mod=map'>".$lang["retour"]."</a>");
}

$query = $sql->query("SELECT * FROM phpsim_bases WHERE ordre_1='".$_GET["o1"]."' AND ordre_2='".$_GET["o2"]."' AND ordre_3='".$_GET["o3"]."'");

if(mysql_num_rows($query) > 0) 
{
die($lang["placeoccupee"]);
}

$tpl->value('ressources', $bat->afficher_ressources($controlrow["ressources_coloniser"], 0) );
$tpl->value('ordre1', $_GET["o1"]);
$tpl->value('ordre2', $_GET["o2"]);
$tpl->value('ordre3', $_GET["o3"]);

$page = $tpl->construire('sysflottes/coloniser');

if(@$_GET["ok"] == 1) 
{

$ress = $bat->modif_ressources($baserow["ressources"], "-", $controlrow["ressources_coloniser"]);

$sql->update("UPDATE phpsim_bases SET ressources='".$ress."' WHERE id='".$baserow["id"]."'");

$count = 0 ;
$dir = opendir("templates/" . $userrow["template"] . "/images/bases") ;
while($file = readdir($dir) )
{
if(!is_dir($file) ) { if(!eregi('index', $file) ) { $count ++; } } // On incremente la valeur qui si ce n'est pas un fichier index 
}

	 $image = rand(1, $count); // Defini une image aleatoire en prenant pas plus que le nombre d'images dans le template
    $idmaxrow = $sql->select("SELECT MAX(id) AS idmax FROM phpsim_bases");
    $idmax = $idmaxrow["idmax"] + 1;

$map2 = explode(",", "0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0");
$map2[rand(1, 81)] = "-1";
$map2[rand(1, 81)] = "-1";
$map2[rand(1, 81)] = "-1";
$map = implode(",", $map2);

$cases_max = rand($controlrow["cases_minimum_pour_colonisation"],$controlrow["cases_maximum_pour_colonisation"]);



$sql->update("INSERT INTO phpsim_bases SET 
id='" . $idmax . "',
utilisateur='" . $userrow["id"] . "',
ordre_1='" . $_GET["o1"] . "',
ordre_2='" . $_GET["o2"] . "',
ordre_3='" . $_GET["o3"] . "',
ressources='" . $controlrow["ressourcesdepart"] . "',
derniere_mise_a_jour='" . time() . "',
cases='0',
cases_max = '" . $cases_max . "',
productions='" . $controlrow["productiondepart"] . "',
stockage='" . $controlrow["stockagedepart"] . "',
energie_max='" . $controlrow["energie_default"] . "',
energie='0',
batiments='" . $compteurs->nbbatiments() . "',
unites='" . $compteurs->nbunites() . "',
defenses='" . $compteurs->nbdefenses() . "',
image='" . $image . "',
map='".$map."'




");


$userrow["bases"] = eregi_replace(" ","",$userrow["bases"]);

$sql->update("UPDATE phpsim_users SET bases='".($userrow["bases"].",".$idmax)."', baseactuelle='".$idmax."' WHERE id='".$userrow["id"]."'");

die('<script>document.location.href="?mod=accueil"</script>');

}

?>