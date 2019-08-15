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


define('XT_SECU', 1);

if (isset($_POST['LastTable']))
{
	@header('Cache-Control: no-cache');
	@header('Pragma: no-cache');
}

include ('backupbdd/includes/config.inc.php');
include ('backupbdd/includes/functions.inc.php');

define('MAX_EXECUTION_TIME', $CONFIG['timeout']);

$iStartTime = MicrotimeFloat();
if ($sError = CheckConfig())
{
	echo $sError;
	exit;
}

if (isset($_POST['selectlang']))
{
	$sCurrentLang = $_POST['selectlang'];
}
else if (isset($_COOKIE[$CONFIG['cookiename']]))
{
	$sCurrentLang = $_COOKIE[$CONFIG['cookiename']];
}
else
{
	$sCurrentLang = $CONFIG['lang'];
}

if (!ereg("^([0-9a-zA-Z]+)$", $sCurrentLang) || !file_exists('backupbdd/lang/'.$sCurrentLang.'.inc.php'))
{
	echo 'Invalid Language File.';
	exit;
}

@SetCookie($CONFIG['cookiename'], $sCurrentLang);
include ('backupbdd/lang/'.$sCurrentLang.'.inc.php');
include ('backupbdd/includes/html.header.inc.php');
include ('backupbdd/includes/html.footer.inc.php');


$aPages = array(
'dump' => 'backupbdd/includes/html.dump_start.inc.php',
'dodump' => 'backupbdd/includes/html.dump.inc.php',
'restore' => 'backupbdd/includes/html.restore_start.inc.php',
'dorestore' => 'backupbdd/includes/html.restore.inc.php',
'delete' => 'backupbdd/includes/html.delete.inc.php',
'gest' => 'backupbdd/includes/html.gest.inc.php'
);


if (!isset($_REQUEST['act']) || !array_key_exists($_REQUEST['act'], $aPages))
{
	include('backupbdd/includes/html.start.inc.php');
}
else
{
	include($aPages[$_REQUEST['act']]);
}
?>
