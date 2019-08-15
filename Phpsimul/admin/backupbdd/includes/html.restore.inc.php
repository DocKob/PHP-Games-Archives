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


if (!ereg("^([0-9a-zA-Z_\-\.]+)\.sql(\.gz)?$", rawurldecode($_POST['FileName'])) || !file_exists('admin/backupbdd/dumps/'.rawurldecode($_POST['FileName'])))
{
	PrintError($LANG['ERROR_INVALID_FILENAME']);
}

$iSQL = CheckConnect($_POST['dbhost'], $_POST['dbbase'], $_POST['dbuser'], $_POST['dbpass']);

$aParams = array(
'act' => 'dorestore',
'dbhost' => $_POST['dbhost'],
'dbbase' => $_POST['dbbase'],
'dbuser' => $_POST['dbuser'],
'dbpass' => $_POST['dbpass'],
'FileName' => rawurldecode($_POST['FileName']),
'LastFilePos' => ((isset($_POST['LastFilePos'])) ? intval($_POST['LastFilePos']) : 0),
'InvalidDump' => ((isset($_POST['InvalidDump'])) ? intval($_POST['InvalidDump']) : 0),
);

if (eregi('^(.*)\.gz$', $aParams['FileName']))
{
	$aParams['zlib'] = 1;
	if (!extension_loaded('zlib'))
	{
		PrintError($LANG['ERROR_ZLIB_NOT_AVAILABLE']);
	}
	define ('USE_ZLIB', true);
}
else
{
	define ('USE_ZLIB', false);
}

include ('admin/backupbdd/includes/functions.files.inc.php');

if (!($iFd = FileOpen('admin/backupbdd/dumps/'.$aParams['FileName'], "rb")))
{
	PrintError($LANG['ERROR_INVALID_FILENAME']);
}

if ($aParams['LastFilePos'] > 0 && FileSeek($iFd, $aParams['LastFilePos']) == -1)
{
	PrintError($LANG['ERROR_INVALID_FILENAME']);
}

$aParams['TotalFilePos'] = (isset($_POST['TotalFilePos'])) ? intval($_POST['TotalFilePos']) : 1;
$aParams['CurrentFileLine'] = (isset($_POST['CurrentFileLine'])) ? intval($_POST['CurrentFileLine']) : 0;

$sUpdateBar = ($aParams['TotalFilePos'] == 1 && $aParams['CurrentFileLine'] == 0) ? 0 : ceil(($aParams['CurrentFileLine'] * 100 ) / $aParams['TotalFilePos']);

echo <<<EOF
{$GLOBALS['sHEADER']}
<form action="" method="post" id="frmProgress" name="frmProgress">
	<p><input id="txtProgress" name="txtProgress" value="Restore" readonly /><br /><br /></p>
	</form>

	<div id="divProgressBarTxt">0%</div>
	<table id="tblProgressBar" cellspacing="0" cellpadding="0">
		<tr>
			<td id="tdProgressBarLeft"></td>
			<td id="tdProgressBarRight"></td>
		</tr>
	</table>

	<script type="text/javascript">
	<!--
	function	MyGetById(id)
	{
		itm = null;
		if (document.getElementById)
			itm = document.getElementById(id);
		else if (document.all)
			itm = document.all[id];
		else if (document.layers)
			itm = document.layers[id];
		return itm;
	}

	function	UpdateBar(percent)
	{
		var itm = MyGetById('tdProgressBarLeft');
		var itm2 = MyGetById('tdProgressBarRight');
		var txt = MyGetById('divProgressBarTxt');
		itm.width =  (percent * 4);
		itm2.width =  (400 - itm.width);
		txt.innerHTML = percent + '%';
	}
	UpdateBar({$sUpdateBar});
	-->
	</script>
EOF;


if ($aParams['InvalidDump'] == 1)
{
	echo <<<EOF
	<div id="divIncompatible">{$LANG['RESTORE_ADVERT']}</div>
	<script type="text/javascript">
	<!--
	MyGetById('divProgressBarTxt').style.display = "none";
	MyGetById('tblProgressBar').style.display = "none";
	//-->
	</script>
EOF;
}

flush();

$nNbQuery = 0;
$nNumberLines = 0;
$sNextPageUrl = '';
$nNbErrors = 0;

while (!FileEOF($iFd))
{
	if ($nNbErrors > 5)
	{
		echo '<strong>Too many errors</strong>';
		break;
	}
	$sBuf = FileGets($iFd, 100000);
	$nNumberLines++;
	$aParams['CurrentFileLine']++;
	$sQuery = trim($sBuf);

	if (!empty($sQuery) && ($sQuery{0} != '#') && ($sQuery{0} != '-'))
	{
		$nNbQuery++;
		if (mysql_query($sQuery) == false)
		{
			echo 'Query Error Line <strong>'.$aParams['CurrentFileLine'].'</strong><br />';
			echo 'Error :'.mysql_error().'<br /><pre>'.$sQuery.'</pre>';
			$nNbErrors++;
		}
	}
	if (!empty($sQuery) && $aParams['CurrentFileLine'] == 3 && $sQuery{0} == '-' && $aParams['TotalFilePos'] == 1 && ereg("-- Rows: ([0-9]+)", $sQuery, $aRegs))
	{
		$aParams['TotalFilePos'] = $aRegs[1];
	}

	if ($aParams['InvalidDump'] == 0 && $aParams['TotalFilePos'] == 1 && $aParams['CurrentFileLine'] == 3)
	{
		echo <<<EOF
		<div id="divIncompatible">{$LANG['RESTORE_ADVERT']}</div>
		<script type="text/javascript">
		<!--
		MyGetById('divProgressBarTxt').style.display = "none";
		MyGetById('tblProgressBar').style.display = "none";
		//-->
		</script>
EOF;
		$aParams['InvalidDump'] = 1;
	}



	$aParams['LastFilePos'] = FileTell($iFd);
	if (($nNbQuery > 0) && ((($nNbQuery) % 500) == 0))
	{
		ProgressUpdate($LANG['QUERIES_EXECUTED'].': ' . $aParams['CurrentFileLine'] .  ' (' .  number_format((MicrotimeFloat() - $iStartTime), 2, '.', '') . 's)',
						ceil(($aParams['CurrentFileLine'] * 100 ) / $aParams['TotalFilePos']));
	}

	if ((MicrotimeFloat() - $iStartTime) > MAX_EXECUTION_TIME)
	{
		$sNextPageUrl = NextPageForm($aParams, $LANG['RESUME_RESTORE']);
		break;
	}
}
@mysql_close();
FileClose($iFd);

if (trim($sNextPageUrl)!="")
{
	ProgressUpdate($LANG['PLEASE_WAIT']);
	echo <<<EOF
	<div id="divAdvertise" class="wait">
	<h3>{$LANG['RESTORE_WAIT_RESUME']}</h3>
	<h4>{$LANG['RESTORE_WAIT_RESUME2']}:</h4>
	{$sNextPageUrl}
	<script type="text/javascript">
	<!--
	function GoNow()   { document.frmNextPage.submit(); }
	setTimeout('GoNow()', 5000);
	//-->
	</script>
	</div>
EOF;
}
else
{
	ProgressUpdate($LANG['RESTORE_COMPLETE'].' - '.$LANG['QUERIES_EXECUTED'].': '.$aParams['CurrentFileLine'].  ' (' .  number_format((MicrotimeFloat() - $iStartTime), 2, '.', '') . 's)', 100);
	echo <<<EOF
	<div id="divAdvertise" class="done">
	<h3>{$LANG['RESTORE_COMPLETE']}</h3>
	</div>
EOF;
}

echo $GLOBALS['sFOOTER'];

?>
