<?php

// Si la constante n'est pas defini on bloque l'execution du fichier
if(!defined('PHPSIMUL_PAGES') || @PHPSIMUL_PAGES != 'PHPSIMULLL') 
{
die('Erreur 404 - Le fichier n\'a pas �t� trouv�');
}

/* PHPsimul : Cr�ez votre jeu de simulation en PHP
Copyright (�) - 2007 - CAPARROS S�bastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr

*/

include("systeme/config_allopass.php");

if($_GET["erreur"] == "codeinvalide")
{

	$page =  "Le code allopass que vous avez entr� est invalide.<br><br><a href='index.php?mod=allopass'>Retour</a>";

} 
else 
{


	$page = "

	Bienvenue sur la page allopass de phpsimul. 

	<br>

	Vous pourrez, via cette page, 
	acheter des codes allopass et ainsi profiter d'avantages. 

	<br>PHPSimul vous remercie de votre soutient !<br>
	En cas de probl�me avec le module allopass, vous pouvez me contacter � l'adresse suivante: 
	<a href='mailto: ".$controlrow["mail"]."'>".$controlrow["mail"]."</a>

	<br><br><center>

	".$controlrow["allopass_script"]."

	</center>
	";



	//fin r�elle pages
 
}

?>