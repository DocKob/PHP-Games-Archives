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

function  ListFiles($sDir, $bRemoveExt = false)
{

  $aGlob = array();
  
  if ($fd = @opendir($sDir))
  {
    @$sPattern = '^'.$sPattern.'$';
    while($sFile = readdir($fd))
    {
      if (!is_dir($sDir.'/'.$sFile) && ($sFile != '.') && ($sFile != '..'))
      {
        if ($bRemoveExt)
          $aGlob[] = substr($sFile, 0, strpos($sFile, '.'));
        else
          $aGlob[] = $sFile;
      }
    }
  }
  sort($aGlob);
  return $aGlob;
}

function	PrintArray($a)
{
	echo '<pre>';
	print_r($a);
	echo '</pre>';
}

function	PrintError($txt)
{
	global	$sHEADER, $sFOOTER, $LANG;

	echo <<<EOF
	{$sHEADER}
	<br /><br />
	<div class="error"><br />{$txt}<br /><br /></div>
	<br />
	<br /><br />
	{$sFOOTER}
EOF;
	exit;
}

function MicrotimeFloat()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function CheckConfig()
{
	global	$CONFIG;

	if (!file_exists('admin/backupbdd/lang/'.$CONFIG['lang'].'.inc.php') )
		return ('Configuration Error: Invalid Language.');
	return (false);
}


function	CheckConnect($sDBhost = '', $sDBbase = '', $sDBuser = '', $sDBpass = '')
{
	global	$LANG;

	if (!($iSQL = @mysql_connect($sDBhost, $sDBuser, $sDBpass)))
	{
		PrintError($LANG['ERROR_CONNEXION_FAILED']);
	}
	if (!mysql_select_db($sDBbase, $iSQL))
	{
		@mysql_close($iSQL);
		PrintError($LANG['ERROR_DB_NOT_EXISTS']);
	}
	return ($iSQL);
}


function	GetTotalNumRows($aTables, $sDBhost = '', $sDBbase = '', $sDBuser = '', $sDBpass = '')
{
	$iSQL = mysql_connect($sDBhost, $sDBuser, $sDBpass);
	if (!$iSQL)
	{
		PrintError($LANG['ERROR_CONNEXION_FAILED']);
		return -1;
	}
	if (!mysql_select_db($sDBbase, $iSQL))
	{
		PrintError($LANG['ERROR_DB_NOT_EXISTS']);
		@mysql_close($iSQL);
		return -1;
	}
	$Total = 0;
	foreach ($aTables as $sTable)
	{
		$req = mysql_query("SELECT COUNT(*) as Num FROM ".$sTable);
		$data = mysql_fetch_assoc($req);
		$Total += intval($data['Num']);
	}
	return ($Total);
}

//function	PhpMinimumVersion ($sVersionCheck )
//{
//	$aMinVersion = explode(".", $sVersionCheck);
//	$aCurVersion = explode(".", phpversion());
//
//	if (($aCurVersion[0] < $aMinVersion[0])
//		|| (($aCurVersion[0] == $aMinVersion[0]) && ($aCurVersion[1] < $aMinVersion[1]))
//		|| (($aCurVersion[0] == $aMinVersion[0]) && ($aCurVersion[1] == $aMinVersion[1]) && ($aCurVersion[2][0] < $aMinVersion[2][0])))
//		{
//	  	return (false);
//	  }
//	else
//		{
//	  	return (true);
//	  }
//}

function	PrintJS($iTableCount)
{
	return <<<EOF
		<script type="text/javascript">
		<!--
		function checkall()
		{
			var i = 0;

			while (i < {$iTableCount})
			{
				a = 'tbls[' + i + ']';
				document.dbtables.elements[a].checked = true;
				i++;
			}

		}

		function decheckall()
		{
			var i = 0;

			while (i < {$iTableCount})
			{
				a = 'tbls[' + i + ']';
				document.dbtables.elements[a].checked = false;
				i++;
			}

		}
		-->
		</script>
EOF;
}

function	NextPageForm($aParams, $sButtonTxt)
{
	global	$LANG;
/*
	unset($aParams['dbhost']);
	unset($aParams['dbbase']);
	unset($aParams['dbuser']);
	unset($aParams['dbpass']);
*/
	$sForm = '<form id="frmNextPage" name="frmNextPage" method="post" action="">';
	foreach ($aParams as $key => $value)
	{
		if (!is_array($value))
		{
			$sForm .= '<input type="hidden" name="'.$key.'" value="'.htmlentities($value).'" \>'."\n";
		}
		else
		{
			foreach($value as $k => $v)
			{
				$sForm .= '<input type="hidden" name="'.$key.'['.$k.']" value="'.htmlentities($v).'" />'."\n";
			}
		}
	}
	$sForm .= '<input type="submit" value=" '.$sButtonTxt.' " \>'."\n";
	$sForm .= '</form>'."\n";
	return  ($sForm);
}

function	ProgressUpdate($sText, $iPercent = '')
{
	$sText = htmlentities(str_replace('"', '\'', $sText));
	if ($iPercent != '')
	{
		$iPercent = ceil($iPercent);
		$sProgressBarUpdate = 'UpdateBar('.$iPercent.');';
	}
	else
	{
		$sProgressBarUpdate = '';
	}

	echo <<<EOF
<script type="text/javascript">
<!--
MyGetById('txtProgress').value = "{$sText}";
{$sProgressBarUpdate}
//-->
</script>

EOF;
	flush();
}

function	FormatSize($iSize)
{
	if ($iSize >= 1073741824)
		$sFormat = round($iSize / 1073741824 * 100) / 100 . " Go";
	elseif ($iSize >= 1048576)
		$sFormat = round($iSize / 1048576 * 100) / 100 . " Mo";
	elseif ($iSize >= 1024)
		$sFormat = round($iSize / 1024 * 100) / 100 . " Ko";
	else
		$sFormat = $iSize . " octets";
	if ($iSize == 0)
		$sFormat="-";
	return $sFormat;
}
?>
