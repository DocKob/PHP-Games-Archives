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

$sFile = rawurldecode($_GET['file']);
$sResult = (ereg("^([0-9a-zA-Z_\-\.]+)\.sql(\.gz)?$", $sFile) && @unlink('admin/backupbdd/dumps/'.$sFile)) ? '<div class="ok">'.$LANG['DELETE_FILE_OK'].'</div>' : '<div class="error">'.$LANG['DELETE_FILE_ERROR'].'</div>';
echo <<<EOF
{$sHEADER}
{$sResult}
{$sFOOTER}
EOF;
?>
