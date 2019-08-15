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


if($inscrit_total < $controlrow['inscription_total']) // Dans le cas ou les inscriptions sont possible
{

#############################################################
####### DEBUT Code permettant d'afficher les races du joueur

$race = ''; // On incremente la valeur pour ne pas generer d'erreurs

if(!empty($controlrow["race_1"]) ) 
{ 
$tpl->value('optionvalue', '1');
$tpl->value('optiontexteafficher', $controlrow['race_1']);
$race .= $tpl->construire('login/select_form');
}
if(!empty($controlrow["race_2"]) ) 
{ 
$tpl->value('optionvalue', '2');
$tpl->value('optiontexteafficher', $controlrow['race_2']);
$race .= $tpl->construire('login/select_form');
}
if(!empty($controlrow["race_3"]) ) 
{ 
$tpl->value('optionvalue', '3');
$tpl->value('optiontexteafficher', $controlrow['race_3']);
$race .= $tpl->construire('login/select_form');
}
if(!empty($controlrow["race_4"]) ) 
{ 
$tpl->value('optionvalue', '4');
$tpl->value('optiontexteafficher', $controlrow['race_4']);
$race .= $tpl->construire('login/select_form');
}
if(!empty($controlrow["race_5"]) ) 
{ 
$tpl->value('optionvalue', '5');
$tpl->value('optiontexteafficher', $controlrow['race_5']);
$race .= $tpl->construire('login/select_form');
}
#############################################################


$tpl->value('postnom' , '');
$tpl->value('postavatar' , '');
$tpl->value('postmail' , '');
$tpl->value('postimage' , '');
$tpl->value('erreur' , '');
$tpl->value('selectraces' , $race);
$tpl->value('src_frame', $_SERVER['REQUEST_URI']); 
$page = $tpl->construire('login/inscrire2a');




}
else // Dans le cas ou les inscription sont impossible on redirige sur la fonction qui le dit
{

inscription_max_atteinte() ;

}


?>
