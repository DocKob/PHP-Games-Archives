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

$CONFIG = array (
// The default language
'lang' => 'french',
// Default database settings (can be empty)
'dbhost' => BDD_HOST,
'dbbase' => BDD_NOM,
'dbuser' => BDD_USER,
'dbpass' => BDD_PASS,
// Timeout limit before redirect
'timeout' => (ini_get('max_execution_time') - 2),
'cookiename' => 'XtDumpLang',
);

$XTDUMP_VERSION = '1 RC2';

?>
