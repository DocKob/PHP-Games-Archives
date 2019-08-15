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

echo <<<EOF
{$sHEADER}
<script type="text/javascript">
<!--
	function ConfirmDelete(link)
	{
		if (confirm ("{$LANG['GEST_CONFIRM_DELETE']}"))
		{
			document.location = link;
			return true;
		}
		else
		{
			return false;
		}
	}
-->
</script>
<fieldset>
	<legend>{$LANG['GEST_DUMP']}<br><br></legend>
EOF;

$aDumpFiles = ListFiles('admin/backupbdd/dumps/');
if (count($aDumpFiles) == 0)
{
	echo $LANG['GEST_NO_FILES'];
}
foreach ($aDumpFiles as $sFiles)
{
	if (ereg("^([0-9a-zA-Z_\-\.]+)\.sql(\.gz)?$", $sFiles))
	{
		echo '<a href="admin/backupbdd/download.php?file='.rawurlencode($sFiles).'">'.$sFiles.'</a> ('.FormatSize(filesize('admin/backupbdd/dumps/'.$sFiles)).') - <a href="#" onclick="javascript:ConfirmDelete(\'index.php?mod=backupbdd&act=delete&file='.rawurlencode($sFiles).'\');">Supprimer</a><br />';
	}
}

echo <<<EOF
</fieldset>
{$sFOOTER}
EOF;
?>
