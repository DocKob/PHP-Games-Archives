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

// On affiche la derniere news

// On selectionne la derniere news et on créer les valeurs du template
$news = $sql->select('SELECT * FROM phpsim_news ORDER BY id DESC LIMIT 1');

$tpl->value('news_date2', date('d', $news['date']) );
$tpl->value('news_date1', date('m', $news['date']) );
$tpl->value('news_date0', date('Y', $news['date']) );
$tpl->value('titre', $news['titre']);
$tpl->value('message', $news['texte']);



// On selectionne les deux derniers screens
$query = $sql->query('SELECT * FROM phpsim_screens ORDER BY id DESC LIMIT 2 ');


$nbscreen = 1;
while ($screens = mysql_fetch_array($query) ) 
{
$tpl->value('numeroscreen'.$nbscreen, $screens['numero']);

$nbscreen++;
}

// On met en place les templates
$tpl->value('description_jeu', stripslashes(nl2br($controlrow['description']) ) ); // La description du jeu
$tpl->value('inscrit_total', $inscrit_total); // Le nombre d'inscrit dans le jeu
$tpl->value('connexion_form', $tpl->construire('login/connexion_form') ); // pour afficher le formulaire de connexion

$page = $tpl->construire('login/default');


?>