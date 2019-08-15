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
{ // debut switch action

	case 'modifier' :
	
		$row = $sql->select("SELECT * FROM ".PREFIXE_TABLES.TABLE_FORUMS." WHERE id='" . $_GET["forum"] . "'");

		$page .= "
					<form method='post' action='?mod=forum&envoyemodif=" . $_GET["forum"] . "'>
					<table>
						<tr><td>Nom du forum : </td><td><input type='text' name='nom' value='" . $row["nom"] . "'></td></tr>
						<tr><td>Description du forum : </td><td><TEXTAREA cols='50' rows='12'  type='text' name='description' >".$row["description"]."</TEXTAREA></td></tr>
					</table>
					<br>
					<br>
					<input type='submit' value='Valider'>
					</form>
					<br>
					<br>
					<center><img src='admin/tpl/icons/retour.gif.png'> 
					<a href='?mod=forum'>Retour</a></center>
					
					";

	break;
	
	/******************************************************************\
	|******************************************************************|
	\******************************************************************/

	default :

		#####################################################################

		if(!empty($_GET['envoyemodif']) )
		{ // debut if enregistrement modif
			
			extract($_POST);
			$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_FORUMS." SET 
									nom='" . addslashes($nom) . "',
									description='" . addslashes($description) . "'
								WHERE id='" . $_GET["envoyemodif"] . "'
						    ");

			$page .= "<img src='admin/tpl/icons/accept.png'> Enregistrement effectué avec succès.
						<br>
						<br>
					  ";

			
		} // fin if enregistrement modif
		
		#####################################################################
		
		if (@$_GET["creer"] == 1) // Dans le cas ou on a demander a créer une unité
		{ // debut if créer forum
		
    		$id = $sql->select1("SELECT MAX(id) FROM ".PREFIXE_TABLES.TABLE_FORUMS." ") + 1;

    		$sql->update("INSERT INTO ".PREFIXE_TABLES.TABLE_FORUMS." SET id='" . $id . "', nom='Nouveau forum'"); 

			$page .= "Le forum a bien été créé. Vous pouvez maintenant l'éditer.</center><br>";
    	
    	} // fin if créer forum

		#####################################################################

		if (!empty($_GET["supprimer"]) ) // Dans le cas ou on demande a supprimer un forum
		{ // debut if supprimer unité
			if(empty($_GET['validation']) ) // Dans le cas ou aucune confirmation a été posté, on affiche le formulaire
			{
				$page .= "Voulez vous vraiment supprimer ce forum ?
							 <br>
							 <br>
							 <a href='?mod=forum&supprimer=" . $_GET['supprimer'] . "&validation=OUI'>
							 	OUI
							 </a> 
							 - 
							 <a href='?mod=forum&supprimer=" . $_GET['supprimer'] . "&validation=NON'>
							 	NON
							 </a>
							";
			}
			elseif($_GET['validation'] == 'NON') // Dans le cas ou le formulaire a été renvoyé, et que le joueur ne veut pas virer le forum
			{
				$page .= 'Le forum n\'a pas été supprimer<br><br>';
			}
			elseif($_GET['validation'] == 'OUI') // Dans le cas ou le joueur veut vraiment virer son forum
			{
				// On supprime le forum de la BDD
    			$sql->update("DELETE FROM ".PREFIXE_TABLES.TABLE_FORUMS." WHERE id='" . $_GET["supprimer"] . "'");
    		
    			$page .= 'Le forum a bien été supprimer du jeu<br><br>';
    		}
		} // fin if supprimer unité


		#####################################################################



		$query = $sql->query("SELECT * FROM ".PREFIXE_TABLES.TABLE_FORUMS." ORDER BY id");

		while ($row = mysql_fetch_array($query) ) 
		{
    		$page .= "
    						<table valign='left' border = '0' Width = '500'>
    						<tr>
    							<td WIDTH ='200'>
    								<a href='?mod=forum&action=modifier&forum=" . $row["id"] . "'>" . $row["nom"] . "</a>
    							</td>
								<td>
									<img src='admin/tpl/icons/1591.gif'>
									<a href='?mod=forum&supprimer=" . $row["id"] . "'>Supprimer</a>
								</td>
							</tr>
							</table>
							<br>
						 ";
		}

		$page .= "
					<img src='admin/tpl/icons/add.png'><a href='?mod=forum&creer=1'>Ajouter un forum</a>
					<br><br><center><img src='admin/tpl/icons/retour.gif.png'> <a href='?mod=default'>Retour</a></center>
				   ";

	break;
	
} // fin switch get action

echo "<br><a href='?mod=modoforum'><font color='red' size='+1'>Modérer le forum</font></a><br><br>";
?>