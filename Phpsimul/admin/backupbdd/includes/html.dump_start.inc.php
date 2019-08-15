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

$aTables = mysql_list_tables ($_POST['dbbase'], $iSQL);
$iTablesCount = mysql_num_rows ($aTables);
$sJScript = PrintJS($iTablesCount);

echo <<<EOF
{$sHEADER}
{$sJScript}

<form action="" method="post" name="dbtables">
<div id="divTablesBlock">
	<input type="hidden" name="act" value="dodump">
	<input type="hidden" name="dbhost" value="{$_POST['dbhost']}">
	<input type="hidden" name="dbbase" value="{$_POST['dbbase']}">
	<input type="hidden" name="dbuser" value="{$_POST['dbuser']}">
	<input type="hidden" name="dbpass" value="{$_POST['dbpass']}">
	<input type="hidden" name="LastTable" value="-1">
	<input type="hidden" name="LastRow" value="-1">
	<fieldset>
		<legend>{$LANG['SELECT_MAKE_SELECTION']}</legend><br>
		<br><input type="checkbox" name="selc" alt="Select All" class="noborder" onclick="if (document.dbtables.selc.checked==true){checkall();}else{decheckall();}" />
		<label for="selc" class="bolder">{$LANG['SELECT_TABLE_NAME']}</label>
		<br><br>
EOF;

$i = 0;
while ($i < $iTablesCount)
{
	$sTmp = mysql_tablename ($aTables, $i);
	echo <<<EOF
		<input type="checkbox" id="tbls[{$i}]" name="tbls[{$i}]" value="{$sTmp}" class="noborder" />
		<label for="tbls[{$i}]">{$sTmp}</label>
		<br />
EOF;
	$i++;
}

$sDefaultFileName = 'dump_'.$_POST['dbbase'].'_'.date("Ymd");


if (extension_loaded('zlib'))
{
	$sZlib = '<input type="checkbox" name="zlib" value="1" id="zlib" class="noborder" />';
}
else
{
	$sZlib = '<input type="checkbox" name="zlib" disabled="disabled" value="0" id="zlib" class="noborder" />';
}

echo <<<EOF
	</fieldset>
</div>
<div id="divOptionsBlock">
	<fieldset>
		<legend>{$LANG['OPTIONS_LEGEND']}</legend><br>
		<input type="checkbox" name="SaveStruct" checked="checked" value="1" id="SaveStruct" class="noborder" />
		<label for="SaveStruct">{$LANG['SELECT_STRUCT']}</label>
		<br />
		<input type="checkbox" name="SaveData" checked="checked" value="1" id="SaveData" class="noborder" />
		<label for="SaveData">{$LANG['SELECT_DATA']}</label>
		<br />
		<br />
		<input type="checkbox" name="ChkDropTable" checked="checked" value="1" id="ChkDropTable" class="noborder" />
		<label for="ChkDropTable">{$LANG['SELECT_ADD_DROPTABLE']}</label>
		<br />
		<input type="checkbox" name="ChkIfNotExists" checked="checked" value="1" id="ChkIfNotExists" class="noborder" />
		<label for="ChkIfNotExists">{$LANG['SELECT_ADD_IFEXISTS']}</label>
		<br />
		{$sZlib}
		<label for="zlib">{$LANG['SELECT_GZIP']}</label>
		<br /><br />
		<div class="title">{$LANG['SELECT_FILENAME']}</div>
		<input type="text" name="FileName" size="40" value="{$sDefaultFileName}" id="FileName" />
		<br />
		<br />
		<input type="submit" value=" {$LANG['SELECT_SUBMIT']} " />
	</fieldset>
</div>
<div class="cleaner"></div>
</form>
{$sFOOTER}
EOF;


@mysql_close($iSQL);


?>
