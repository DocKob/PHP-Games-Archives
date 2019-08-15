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


$page = $cache->chercher('classement_alliances');

if($page == 1)
{

$tpl->value('select_joueurs', ''); 
$tpl->value('select_allis', 'selected'); 
$tpl->value('type', '_allis'); 
$page = $tpl->construire('classement_entete');

$classement = ''; // On increment la variable pour ne pas provoquer un affichage d'erreur
$nombre = 1 ;

$requete = $sql->query('
							SELECT 
								phpsim_alliance.*,
								( 
								 SUM('.PREFIXE_TABLES.TABLE_USERS.'.points) 
								 / 
								 COUNT('.PREFIXE_TABLES.TABLE_USERS.'.alli)
								) AS total
								
							FROM 
								'.PREFIXE_TABLES.TABLE_ALLIANCES.'
							
							LEFT JOIN
								'.PREFIXE_TABLES.TABLE_USERS.'
							ON
								'.PREFIXE_TABLES.TABLE_ALLIANCES.'.id = '.PREFIXE_TABLES.TABLE_USERS.'.alli
								
							GROUP BY 
								'.PREFIXE_TABLES.TABLE_ALLIANCES.'.id
							
							ORDER BY 
								total 
							DESC
							
					   ');

while ($d = mysql_fetch_array ($requete) ) 
{

$tpl->value('nombreclassement', $nombre);
$tpl->value('tagalli', $d['tag']);
$tpl->value('nomalli', $d['nom']);
$tpl->value('points', number_format($d['total'], 0, '.', '.'));


$classement .= $tpl->construire('classement_alli_users');


$nombre = $nombre + 1 ;
}

$tpl->value('affichage_users', $classement);
$page .= $tpl->construire('classement_alli_entete');

$cache->save($page, 'classement_alliances');
}


?>