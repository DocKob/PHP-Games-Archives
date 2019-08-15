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

// On bloque l'execution de la page pour les modo, elle est seulement autorisé pour les administrateurs et fondateurs
if($userrow['administrateur'] != '1' && $userrow['fondateur'] != '1')
{
	die('<script>document.location="?mod=aide&error=interdit_au_modo"</script>'); // On redirige sur la page gerant les erreurs afficher en alerte JS
}

$page = ''; // On initalise la variable

switch(@$_GET['action'])
{
	
	/******************************************************************\
	|******************************************************************|
	\******************************************************************/


	case 'modifier' :
		
		// On recupere le SQL de lien du menu pour l'afficher
		$row = $sql->select('SELECT * FROM '.PREFIXE_TABLES.TABLE_MENU.' WHERE id="'.$_GET['menu'].'" ');
	
		$page .= "
					<form method='post' action='?mod=menu&envoyemodif=" . $_GET["menu"] . "'>
					Nom du lien : <input type='text' name='nom' value='" . $row["nom"] . "'><br>
					Nom du module appelé : <input type='text' name='module' value='" . $row["module"] . "'><br>
					Séparateur - si oui, une barre noire apparaître à la place d'un lien ? ".select("separateur")."<br>Utiliser le système de chargement de la page (si non, le lien sera un lien normal) ? ".select("miseenforme")."<br>
					<br><br><input type='submit' value='Valider'></form>
					<br>
					<br>
					<center><img src='admin/tpl/icons/retour.gif.png'> <a href='?mod=menu'>Retour</a></center>
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
			$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_MENU." SET 
										nom='" . addslashes($nom) . "', 
										module='" . $module . "', 
										separateur='" . $separateur . "', 
										miseenforme='" . $miseenforme . "' 
							  WHERE id='" . $_GET["envoyemodif"] . "'
							 ");

			$page .= "<img src='admin/tpl/icons/accept.png'>  Enregistrement effectué avec succès.<br><br>";


		} // fin if enregistrement modif
		
		#####################################################################
		
		if(!empty($_GET['remonter']) ) // Dans le cas ou le joueur a demander a remonter l'unité d'une place
		{ // debut if remonter d'un emplacement
		
			// On recupere l'ordre de l'unité possedant l'id envoyer par formulaire
			$ordrebat = $sql->select1("SELECT id FROM ".PREFIXE_TABLES.TABLE_MENU." WHERE id='".$_GET['remonter']."' ");
			
			// On detruit l'ordre de l'unité precedent pour qu'il ne nous gene pas
			$sql->update('UPDATE '.PREFIXE_TABLES.TABLE_MENU.' SET id="xyz" WHERE id="'. ($ordrebat - 1) .'" ');
			$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_MENU." SET id='" . ($ordrebat - 1) . "' WHERE id='" . $_GET['remonter'] . "' ");
			$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_MENU." SET id='" . $ordrebat . "' WHERE id='xyz' ");
		
		} // fin if remonter d'un emplacement
		
		#####################################################################
		
		if (@$_GET["creer"] == 1) // Dans le cas ou on a demander a créer une unité
		{ // debut if créer lien menu
   		
   		//On insere le lien dans SQL
   		$id = $sql->select1("SELECT MAX(id) FROM ".PREFIXE_TABLES.TABLE_MENU." ") + 1;
    		$sql->update("INSERT INTO ".PREFIXE_TABLES.TABLE_MENU." SET id='" . $id . "', nom='Nouveau lien'");
    		
    		// On supprime les caches du menu
    		
    		
    	} // fin if créer lien menu

		#####################################################################

		if (!empty($_GET["supprimer"]) ) // Dans le cas ou on demande a supprimer un lien du menu
		{ // debut if supprimer lien menu
			if(empty($_GET['validation']) ) // Dans le cas ou aucune confirmation a été posté, on affiche le formulaire
			{
				$page .= "Voulez vous vraiment supprimer ce lien ?
							 <br>
							 <br>
							 <a href='?mod=menu&supprimer=" . $_GET['supprimer'] . "&validation=OUI'>
							 	OUI
							 </a> 
							 - 
							 <a href='?mod=menu&supprimer=" . $_GET['supprimer'] . "&validation=NON'>
							 	NON
							 </a>
							";
			}
			elseif($_GET['validation'] == 'NON') // Dans le cas ou le formulaire a été renvoyé, et que le joueur ne veut pas virer l'unité
			{
				$page .= 'Le lien du menu n\'a pas été supprimer<br><br>';
			}
			elseif($_GET['validation'] == 'OUI') // Dans le cas ou le joueur veut vraiment virer son unité
			{
				// On supprime tous cache du menu pouvant exister 
				

				// On supprime le lien du menu de la BDD
    			$sql->update("DELETE FROM ".PREFIXE_TABLES.TABLE_MENU." WHERE id='" . $_GET["supprimer"] . "'");
    		
    			$page .= 'Le lien du menu a bien été supprimer du jeu<br><br>';
    		}
		} // fin if supprimer lien menu


		#####################################################################


		$query = $sql->query("SELECT * FROM ".PREFIXE_TABLES.TABLE_MENU." ORDER BY id");

		while ($row = mysql_fetch_array($query)
		) 
		{
    	$page .= "
    				<table valign='left' border = '0' Width = '500'>
    					<tr>
    						<td WIDTH ='105'>
    							<img src='admin/tpl/icons/application_form.png'> 
    							<a href='?mod=menu&action=modifier&menu=" . $row["id"] . "'>" . $row["nom"] . "</a>
    						</td>
							<td align ='center'>
								<img src='admin/tpl/icons/application_get.png'>
								<a href='?mod=menu&remonter=" . $row["id"] . "'>Remonter</a>
							</td>
							<td align ='center'>
								<img src='admin/tpl/icons/application_form_delete.png'>
								<a href='?mod=menu&supprimer=" . $row["id"] . "'>Supprimer</a>
							</td>
						</tr>
					</table>
					<br>
					";
		}
		$page .= "<img src='admin/tpl/icons/application_form_add.png'><a href='?mod=menu&creer=1'>Ajouter un lien</a>
		          <br><br><center><img src='admin/tpl/icons/retour.gif.png'> <a href='?mod)default'>Retour</a></center>
		         ";



	break;
	
} // fin switch get action







?>