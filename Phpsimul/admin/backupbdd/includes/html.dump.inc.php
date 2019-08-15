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

if (isset($_POST['LastTable']))
{
	@header('Cache-Control: no-cache');
	@header('Pragma: no-cache');
}

if (isset($_POST['zlib']) && intval($_POST['zlib']) == 1 && extension_loaded('zlib'))
{
	define('USE_ZLIB', true);
}
else
{
	define('USE_ZLIB', false);
}

include ('admin/backupbdd/includes/functions.files.inc.php');

if (!isset($_POST['tbls']) || !is_array($_POST['tbls']))
{
	PrintError($LANG['ERROR_NO_TABLE_SELECTED']);
}

if (!isset($_POST['SaveStruct']) && !isset($_POST['SaveData']))
{
	PrintError($LANG['ERROR_NO_SAVE_TYPE_SELECTED']);
}
$iSQL = CheckConnect($_POST['dbhost'], $_POST['dbbase'], $_POST['dbuser'], $_POST['dbpass']);


function	SaveSql($iFd)
{
	global	$iStartTime, $LANG, $aParams;

	$sProgressText = "";
	$sNextPageUrl = "";

	$iSQL = mysql_connect($aParams['dbhost'], $aParams['dbuser'], $aParams['dbpass']);
	$sProgressText =  $aParams['CurrentTable'] . ' : ' . $LANG['DUMPING_SAVING_TABLE'].': '.$aParams['CurrentTable'].' (' . number_format((MicrotimeFloat() - $iStartTime), 2, '.', '') . "s)";
	ProgressUpdate($sProgressText);
	if ($aParams['CurrentSaveStruct'])
	{
		$sOutput = "";
		$result = mysql_query('SHOW CREATE TABLE `'.$aParams['CurrentTable'].'` ;');
		$tmpres = mysql_fetch_array($result);

		if ($aParams['ChkDropTable'])
		{
			$sOutput .= "\r\nDROP TABLE IF EXISTS `".$aParams['CurrentTable']."`;\r\n";
		}
		if ($aParams['ChkIfNotExists'])
		{
			$tmpres[1] = str_replace("CREATE TABLE", "CREATE TABLE IF NOT EXISTS", $tmpres[1]);
		}
		$sOutput .= str_replace("\n", " ", $tmpres[1]) . ";\r\n";
		FileWrite($iFd, $sOutput);
		$sProgressText = $aParams['CurrentTable'] . ' : ' . $LANG['DUMPING_SAVING_STRUCT'].' (' . number_format((MicrotimeFloat() - $iStartTime), 2, '.', '') . 's)';
		ProgressUpdate($sProgressText);
	}

	$sOutput = '';

	$query2 = 'SELECT * FROM `'.$aParams['CurrentTable'].'`';
	$result2 = mysql_query($query2);
	$nbchamps = mysql_num_fields($result2);

	$iRowsSaved = 0;
	$afield_num = array();

	$sFieldContent = "";
	$sSQLField="";

	for ($j = 0; $j < $nbchamps; $j++)
	{
		$type = mysql_field_type($result2, $j);
		if ($type == 'tinyint' || $type == 'smallint' || $type == 'mediumint' ||
				$type == 'int' || $type == 'bigint'  ||$type == 'timestamp')
		{
			$afield_num[$j] = true;
		}
		else
		{
			$afield_num[$j] = false;
		}
		unset($type);
	}

	//$bFastReplace = PhpMinimumVersion("4.0.5");

	$aSearchSlashes = array('\\',"//");
	$aReplaceSlashes = array('\\\\',"\/\/");

	$aSearch = array('\'',"\"",chr(10),chr(13),"\t","\x00","\x1a");
	$aReplace = array('\'\'',"\\\"","\\n","\\r","\\t","\\0","\\Z");

	if ($aParams['SaveData'])
	{
		while ($iRowsSaved < $aParams['LastRow'])
		{
			if ($row = mysql_fetch_row($result2))
			{
				$iRowsSaved++;
			}
			else
			{
				break;
			}
		}
		while ($row = mysql_fetch_row($result2))
		{
			$sOutput = '';
			$sOutput .= 'INSERT INTO `'.$aParams['CurrentTable'].'` VALUES(';
			$c=0;

			while ($c < $nbchamps)
			{
				$sSQLField = '';

				if ($c != 0)
				{
					$sOutput .= ',';
				}

				if (!isset($row[$c]))
				{
					$sSQLField     = 'NULL';
				}
				else if ($row[$c] == '0' || $row[$c] != '')
				{
					if ($afield_num[$c])
					{
					    $sSQLField = $row[$c];
					}
					else
					{
						$sFieldContent = $row[$c];
						//if ($bFastReplace)
						//{
							$sFieldContent = str_replace ($aSearchSlashes,$aReplaceSlashes,$sFieldContent);
							$sFieldContent = str_replace ($aSearch,$aReplace,$sFieldContent);
						//}
						//else
						//{
						//	$sFieldContent = str_replace ('\\','\\\\',$sFieldContent);
						//	$sFieldContent = str_replace("//","\/\/",$sFieldContent);
						//	$sFieldContent = str_replace('\'', '\'\'', $sFieldContent);
						//	$sFieldContent = str_replace ("\"","\\\"",$sFieldContent);
						//	$sFieldContent = str_replace (chr(10),"\\n",$sFieldContent);
						//	$sFieldContent = str_replace (chr(13),"\\r",$sFieldContent);
						//	$sFieldContent = str_replace ("\t","\\t",$sFieldContent);
						//	$sFieldContent = str_replace ( "\x00","\\0",$sFieldContent);
						//	$sFieldContent = str_replace ( "\x1a","\\Z",$sFieldContent);
						//}
						$sSQLField = "'" . $sFieldContent . "'";
					}
				}
				else
				{
					$sSQLField     = "''";
				}
				$sOutput .= $sSQLField;
				$c++;
			}
			$sOutput .= ");\r\n";

			FileWrite($iFd, $sOutput);
			$iRowsSaved++;
			$aParams['CurrentRow']++;

			if ((($iRowsSaved) % 500) == 0)
			{
				ProgressUpdate($aParams['CurrentTable'].' : '.$LANG['DUMPING_SAVING_DATA'].' '.$iRowsSaved.' (' .  number_format((MicrotimeFloat() - $iStartTime), 2, '.', '') . 's)',
								(($aParams['CurrentRow'] * 100 ) / $aParams['TotalNumRows']));
			}

			if ((MicrotimeFloat() - $iStartTime) > MAX_EXECUTION_TIME)
			{
				$aParams['LastRow'] = $iRowsSaved;
				$aParams['LastTable'] = $aParams['CurrentTableIndex'];
				$sNextPageUrl = NextPageForm($aParams, $LANG['RESUME_DUMP']);
				break;
			}
		}
	}

	@mysql_free_result($result2);
	@mysql_close();
	return $sNextPageUrl;
}


$sUpdateBar = (!isset($_POST['CurrentRow'])) ? 0 : ceil((intval($_POST['CurrentRow']) * 100 ) / intval($_POST['TotalNumRows']));
echo <<<EOF
{$sHEADER}

<form action="" method="post" id="frmProgress" name="frmProgress">
<p><input id="txtProgress" name="txtProgress"  value="Dumping" readonly /><br /><br /></p>
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
flush();

$aParams = array(
'tbls' => array_merge($_POST['tbls']),
'act' => 'dodump',
'dbhost' => $_POST['dbhost'],
'dbbase' => $_POST['dbbase'],
'dbuser' => $_POST['dbuser'],
'dbpass' => $_POST['dbpass'],
'LastRow' => intval($_POST['LastRow']),
'LastTable' => intval($_POST['LastTable']),
'zlib' => (isset($_POST['zlib']) ? intval($_POST['zlib']) : 0),
);


$aParams['TotalNumRows'] = (!isset($_POST['TotalNumRows'])) ? GetTotalNumRows($aParams['tbls'], $_POST['dbhost'], $_POST['dbbase'], $_POST['dbuser'], $_POST['dbpass']) : $_POST['TotalNumRows'];
$aParams['CurrentRow'] = (!isset($_POST['CurrentRow'])) ? 0 : $_POST['CurrentRow'];
$aParams['SaveStruct'] = (isset($_POST['SaveStruct']) && $_POST['SaveStruct'] == 1) ? 1 : 0;
$aParams['SaveData'] = (isset($_POST['SaveData']) && $_POST['SaveData'] == 1) ? 1 : 0;
$aParams['ChkDropTable'] = (isset($_POST['ChkDropTable']) && $_POST['ChkDropTable'] == 1);
$aParams['ChkIfNotExists'] = (isset($_POST['ChkIfNotExists']) && $_POST['ChkIfNotExists'] == 1);

if (isset($_POST['FileName']))
{
	if ($aParams['LastTable'] == -1)
	{
		$_POST['FileName'] = preg_replace("([^0-9a-zA-Z_]+)", '', $_POST['FileName']);
		$aParams['FileName'] = ($aParams['zlib']) ? $_POST['FileName'].'.sql.gz' : $_POST['FileName'].'.sql';
	}
	else
	{
		$aParams['FileName'] = $_POST['FileName'];
	}
}

if (USE_ZLIB)
{
	$sMode = ($aParams['LastTable'] >= 0) ? "ab9" : "wb9";
}
else
{
	$sMode = ($aParams['LastTable'] >= 0) ? "a" : "w";
}

if (!$iFd = FileOpen('admin/backupbdd/dumps/'.$aParams['FileName'], $sMode))
{
	PrintError($LANG['ERROR_OPENING_FILE']);
}

if ($aParams['LastTable'] < 0)
{
	$sOutput = "-- Dump of ".$_POST['dbbase']." (".date("F j, Y, g:i a").")\r\n";
	$sOutput .= "-- Created by Xt-Dump ".$XTDUMP_VERSION." http://www.dreaxteam.net \r\n";
	if ($aParams['TotalNumRows'] > 0)
	{
		$sOutput .= '-- Rows: '.$aParams['TotalNumRows']."\r\n";
	}
	FileWrite($iFd, $sOutput);

	$iFirstTable = 0;
}
else
{
	$sOutput = " -- Resume Part \r\n";
	FileWrite($iFd, $sOutput);

	$iFirstTable = $aParams['LastTable'];
}

$sNextUrl = '';

for ($i = $iFirstTable; $i < count($aParams['tbls']); $i++)
{
	if (($aParams['LastTable'] >= 0) && ($i == $aParams['LastTable']))
	{
		$aParams['CurrentSaveStruct'] = false;
	}
	else
	{
		$aParams['CurrentSaveStruct'] = $aParams['SaveStruct'];
	}

	$aParams['CurrentTable'] = $aParams['tbls'][$i];
	$aParams['CurrentTableIndex'] = $i;
	$sNextUrl = SaveSql($iFd);
	if (trim($sNextUrl) != "")
	{
		break;
	}
	else
	{
		$aParams['LastRow'] = -1;
	}
}

FileClose($iFd);

if (trim($sNextUrl)!="")
{
	ProgressUpdate($LANG['PLEASE_WAIT']);
	echo <<<EOF
	<div id="divAdvertise" class="wait">
	<h3>{$LANG['DUMPING_WAIT_RESUME']}</h3>
	<h4>{$LANG['DUMPING_WAIT_RESUME2']}:</h4>
	{$sNextUrl}
	<script type="text/javascript">
	<!--
		function GoNow ()   { document.frmNextPage.submit(); }
		setTimeout('GoNow()', 5000);
	//-->
	</script>
	</div>
EOF;

}
else
{
	$sFileNameFull = 'admin/backupbdd/download.php?file='.rawurlencode($aParams['FileName']);
	ProgressUpdate($LANG['DUMPING_COMPLETE'], 100);
	echo <<<EOF
	<div id="divAdvertise" class="done">
	<h3>{$LANG['DUMPING_COMPLETE']}</h3>
	<h4>{$LANG['DUMPING_GET_FILE']}:</h4>
	<a href="{$sFileNameFull}">{$aParams['FileName']}</a>
	</div>
EOF;
}
echo $GLOBALS['sFOOTER'];

?>
