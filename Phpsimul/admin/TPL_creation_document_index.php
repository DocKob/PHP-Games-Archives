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

/*
Lors de modification sur la configuration principale du jeu, 
il se peut que des parametre contenant le html de index.html a la racine change.

La variable suivante contient le modele de ce qui doit etre generé dans l'index.html
*/

// On bloque l'execution de la page pour les modo, elle est seulement autorisé pour les administrateurs et fondateurs
if($userrow['administrateur'] != '1' && $userrow['fondateur'] != '1')
{
	die('<script>document.location="?mod=aide&error=interdit_au_modo"</script>'); // On redirige sur la page gerant les erreurs afficher en alerte JS
}

$doc_index ='

<html>

<head>
	<title>
		{{nom}}
	</title>
	
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="{{url}}rss.php">

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="Description" content="{{description}}">
	
	<link REL="SHORTCUT ICON" HREF="{{url}}templates/{{template}}/images/icon.ico">

</head>

<!-- 
	PHPSimul
	
	Moteur de Jeux PHP
	
	Créer principalement par Camaris, Max485, Stevenson, Khi3l
	
	http://forum.epic-arena.fr
	
-->
							
<frameset rows="*,0,0" frameborder="no" border="0" framespacing="0">
	<frame src="index.php" frameborder="0" scrolling="auto" noresize>
</frameset>
	
</html>

';