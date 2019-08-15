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

$page = ''; // On initalise la variable

switch(@$_GET['action'])
{
	
	
	/******************************************************************\
	|******************************************************************|
	\******************************************************************/

	default:
		
		if(@$_GET['creer'] == 1) // L'admin a voulu envoyer un screen
		{
			extract($_POST);

			$sql->update("INSERT INTO ".PREFIXE_TABLES.TABLE_SCREENS." SET id='', numero='" . $screen . "'");

			$page .= "<img src='design/icons/accept.png'> Screen ajouté avec succès.<br><br><br>";
		}
		
		###############################################################################
		
		if(!empty($_GET['supprimer']) ) // si l'admin a voulu supprimer un screen
		{
			
			// $_GET['supprimer'] equivaut a l'id du sreens a virer
		
			$sql->update("DELETE FROM ".PREFIXE_TABLES.TABLE_SCREENS." WHERE id='" . $_GET["supprimer"] . "' ");

			$page .= "<img src='design/icons/accept.png'> L'image à été supprimée avec succès.<br><br><br>";
		}
		
		###############################################################################
		
		// On recuperes les screens presents dans la base de données
		$screens = $sql->query("SELECT * FROM ".PREFIXE_TABLES.TABLE_SCREENS." ");
		
		while ($screen = mysql_fetch_array($screens) ) 
		{
    		$page .= "<img src='templates/default/images/screens/" . $screen["numero"] . ".gif' width='160' height='120' border='1'>
    					 <br>
    					 <a href='?mod=screens&supprimer=" . $screen["id"] . "'>Supprimer</a>
    					 <br>
    					 <br>
    					";
		}

		$page .= "Ajouter un screen 
					 <br>
					 (uploadez le tout d'abord dans le dossier templates/nomdutemplate/images/screens en x.gif 
					 ou x est un nombre, indiquez ce nombre) : 
					 <br>
					 <form method='post' action='?mod=screens&creer=1'>
					 images/screens/<input type='text' name='screen'>.gif
					 <br>
					 <input type='submit' value='Valider'></form></center>
					 <br>
					 <br>
					 <center>
					 <img src='admin/tpl/icons/retour.gif.png'> 
					 <a href='?mod=default'>Retour</a></center>
					";
		
	break;
	
	/******************************************************************\
	|******************************************************************|
	\******************************************************************/


}

?>