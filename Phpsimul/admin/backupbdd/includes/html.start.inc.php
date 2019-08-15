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

$sLangDropDown = '';

$aFiles = ListFiles('admin/backupbdd/lang/', true);
foreach($aFiles as $sLang)
{
	//$sLang = str_replace(array('admin/backupbdd/lang/', '.inc.php'), '', $sLang);
	if (ereg("^([0-9a-zA-Z]+)$", $sLang))
	{
		if ($sCurrentLang == $sLang)
		{
			$sLangDropDown .= '<option value="'.$sLang.'" selected="selected">'.$sLang.'</option>';
		}
		else
		{
			$sLangDropDown .= '<option value="'.$sLang.'">'.$sLang.'</option>';
		}
	}
}

echo <<<EOF
{$sHEADER}
<form action="" method="post" id="frmConnex" name="frmConnex">
<fieldset>
<legend>{$LANG['TITLE_DATABASE_CONNEXION']}<br></legend>
<input type="hidden" name="dbhost" id="dbhost" size="30" value="{$CONFIG['dbhost']}" />
<input type="hidden" name="dbbase" id="dbbase" size="30" value="{$CONFIG['dbbase']}" />
<input type="hidden" name="dbuser" id="dbuser" size="30" value="{$CONFIG['dbuser']}" />
<input type="hidden" name="dbpass" id="dbpass" size="30" value="{$CONFIG['dbpass']}" />
<br>
<label for="radioconnect">{$LANG['LOGON_ACTSAVE']}</label>
<input type="radio" name="act" value="dump" checked="checked" id="radioconnect" class="noborder" />
<br />
<label for="radiorestore">{$LANG['LOGON_ACTRESTORE']}</label>&nbsp;&nbsp;
<input type="radio" name="act" value="restore" id="radiorestore" class="noborder" />
<br />
<label for="radiogest">{$LANG['LOGON_ACTGEST']}</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="act" value="gest" id="radiogest" class="noborder" />
<br /><br />
<input type="submit" value=" {$LANG['LOGON_CONNECT']} " id="tdBtnConnex" />
</fieldset>
</form>
{$sFOOTER}
EOF;
?>
