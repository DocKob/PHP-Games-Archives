<?php

// Si la constante n'est pas defini on bloque l'execution du fichier
if(!defined('PHPSIMUL_PAGES') || @PHPSIMUL_PAGES != 'PHPSIMULLL') 
{
die('Erreur 404 - Le fichier n\'a pas été trouvé');
}

/* 

PHPsimul : Créez votre jeu de simulation en PHP
Copyright (©) - 2007 - CAPARROS Sébastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr

*/

lang("optionbase");


if(@$_GET['action'] == 'abandon_colonie')
{ // debut if virer colo
// On regarde si il ne s'agit pas de la base mere du joueur, si il s'agit de celle la, on bloque
$base_mere = explode(',', $userrow['bases']);

if($base_mere[0] == $userrow['baseactuelle'])
{
// Il s'agit de la base mere, on affiche un message d'erreur

$error = $lang["pasdel1"]." ".$controlrow['nom_bases']." ".$lang["pasdel2"]."<br>";

}
else
{ // Debut de else base non mere

// On supprime la base

$bases_totale1 = explode(",", $userrow['bases']);
$bases_du_joueur = '';
$numero = 0 ;
foreach($bases_totale1 as $bases_totale)
{
if($bases_totale != $userrow['baseactuelle'])  {  $bases_du_joueur .= $bases_totale."," ;  }
$numero++;
}


$bases_du_joueur = str_replace(',,', ',', $bases_du_joueur); // On vire les double virgules qui apparaissent apres ca

if($bases_du_joueur{strlen($bases_du_joueur)-1} == ',')  { $base_du_joueur = $bases_du_joueur{strlen($bases_du_joueur)-1} = ' '; }



$sql->query("UPDATE phpsim_users SET bases='".$bases_du_joueur."' WHERE id='".$userrow['id']."' ");
$sql->query("DELETE FROM phpsim_bases WHERE id='".$userrow['baseactuelle']."' ");

// On defini que le joueur se trouve sur ca base de depart et on renvoye vers le mod accueil

$base_principale = explode(",", $userrow['bases']);
$sql->query("UPDATE phpsim_users SET baseactuelle=".$base_principale[0]." WHERE id='".$userrow['id']."' ");

die('<script>document.location="?mod=accueil"</script>');

} // Fin de else base non mere


} // fin if virer colo

#####################################################################################################################

$coordonnees = base::coordonnees($baserow["id"], $controlrow["coordonnees_activees"], $controlrow["ordre_1_active"]);

if (!empty($_POST["nom"]) ) 
{
    $_POST["nom"] = str_replace("<", "&lt;", $_POST["nom"]);
    $baserow["nom"] = str_replace(">", "&gt;", $_POST["nom"]);
    mysql_query("UPDATE phpsim_bases SET nom='" . htmlspecialchars(addslashes($baserow["nom"]) ) . "' WHERE id='" . $baserow["id"] . "'");
}

$tpl->value('controlrow_nom_bases', $controlrow["nom_bases"]);
$tpl->value('base_joueur', $baserow["nom"]);
$tpl->value('coordonnees', $coordonnees);

// On regarde si un message doit s'afficher dans quel cas on l'affiche sinon on supprime erreur du code source
if(!empty($error) && $error != '') { $tpl->value('error', $error); }
else { $tpl->value('error', ''); }


$page = $tpl->construire('optionsbase');

?>