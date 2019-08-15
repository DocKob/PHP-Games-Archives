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

$iSQL = CheckConnect($_POST['dbhost'], $_POST['dbbase'], $_POST['dbuser'], $_POST['dbpass']);

echo <<<EOF
{$sHEADER}
<form action="" method="post" name="frmRestore" id="frmRestore">
<input type="hidden" name="act" value="dorestore">
<input type="hidden" name="dbhost" value="{$_POST['dbhost']}">
<input type="hidden" name="dbbase" value="{$_POST['dbbase']}">
<input type="hidden" name="dbuser" value="{$_POST['dbuser']}">
<input type="hidden" name="dbpass" value="{$_POST['dbpass']}">
<input type="hidden" name="LastFilePos" value="0">
<fieldset>
	<legend>{$LANG['RESTORE_CHOOSE_DUMP']}</legend>
	<select name="FileName">
EOF;

$aDumpFiles = ListFiles('admin/backupbdd/dumps/');
foreach ($aDumpFiles as $sFiles)
{
	$sFiles = str_replace('admin/backupbdd/dumps/', '', $sFiles);
	if (ereg("^([0-9a-zA-Z_\-]+)\.sql(\.gz)?$", $sFiles))
	{
		echo '<option value="'.rawurlencode($sFiles).'">'.$sFiles.'</option>';
	}
}

echo <<<EOF
	</select>
	<br /><br />
	<input type="submit" value=" {$LANG['RESTORE_BUTTON']} " />
</fieldset>
</form>
{$sFOOTER}
EOF;

?>
