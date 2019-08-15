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

// On recupere les news, jusqu'au nombre max defini dans l'admin
$query = $sql->query('SELECT * FROM phpsim_news ORDER BY id DESC LIMIT '.$controlrow["maxnews"]);

$affnews = ''; // On demarre la variable pour ne pas procoquer une erreur
while ($news = mysql_fetch_array($query) ) 
{

$date = explode("-", $news['date']);

$tpl->value('news_date2', date('d', $news['date']) );
$tpl->value('news_date1', date('m', $news['date']) );
$tpl->value('news_date0', date('Y', $news['date']) );
$tpl->value('titre', $news['titre']);
$tpl->value('message', $news['texte']);


$affnews .= $tpl->construire('login/news_affnews');
  
}

$tpl->value('affichage_news', $affnews);
$page = $tpl->construire('login/news');

?>