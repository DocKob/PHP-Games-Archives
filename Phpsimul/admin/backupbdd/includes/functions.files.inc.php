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

if (!defined('USE_ZLIB'))
{
	define('USE_ZLIB', false);
}

function	FileOpen($sFileName, $sMode)
{
	if (USE_ZLIB)
	{
		return (gzopen($sFileName, $sMode));
	}
	else
	{
		return (fopen($sFileName, $sMode));
	}
}

function	FileWrite($iFd, $sData)
{
  if (USE_ZLIB)
  {
		gzwrite($iFd, $sData);
  }
  else
  {
		fwrite($iFd, $sData);
  }
}

function	FileClose($iFd)
{
	if (USE_ZLIB)
	{
		gzclose ($iFd);
	}
	else
	{
		fclose ($iFd);
	}
}

function	FileTell($iFd)
{
	if (USE_ZLIB)
	{
		return  gztell($iFd);
	}
	else
	{
		return  ftell($iFd);
	}
}

function	FileGets($iFd, $iLength = 4096)
{
	if (USE_ZLIB)
	{
		return  gzgets ($iFd, $iLength);
	}
	else
	{
		return  fgets($iFd, $iLength);
	}
}

function	FileEOF($iFd)
{
	if (USE_ZLIB)
	{
		return  gzeof ($iFd);
	}
	else
	{
		return  feof ($iFd);
	}
}

function	FileSeek($iFd, $iOffset)
{
	if (USE_ZLIB)
	{
		return  gzseek ($iFd,$iOffset);
	}
	else
	{
		return  fseek ($iFd,$iOffset);
	}
}

function	FileRewind($iFd)
{
	if (USE_ZLIB)
	{
		return  gzrewind ($iFd);
	}
	else
	{
		return  rewind ($iFd);
	}
}

function	FileEndPos($iFd)
{
	$pc = FileTell($iFd);
	echo $pc.'-';
	FileSeek($iFd, 0);

	$pc2 = FileTell($iFd);
	echo $pc2.'-';
	FileSeek($iFd, $pc);
	return ($pc2);
}

function	FileCount($iFd)
{

	$pc = FileTell($iFd);
	if(!FileRewind($iFd))
	{
		FileSeek($iFd, $pc);
		return false;
	}

	$i = 0;
	while(!FileEOF($iFd))
	{
		FileGets($iFd, 1024*1024*10);
		$i++;
	}

	FileSeek($iFd, $pc);
	return ($i);
}
?>
