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
{ // debut switch action

	case 'modifier' :
		
		// On recupere le SQL de l'unité pour l'afficher
		$row = $sql->select('SELECT * FROM '.PREFIXE_TABLES.TABLE_CHANTIER.' WHERE id="'.$_GET['unite'].'" ');
	
		
		$page .= "
					<form method='post' action='?mod=chantier&envoyemodif=" . $_GET["unite"] . "'>
					<table>
						<tr><td>Nom de l'unité : </td><td><input type='text' name='nom' value='" . $row["nom"] . "'></td></tr>
						<tr><td>Description : </td><td><textarea cols='50' rows='10' name='description'>" . $row["description"] . "</textarea></td></tr>
						<tr><td>Image (dans le dossier images/chantier et nommée x.gif ou x est un nombre, indiquez ce nombre) : </td><td><input type='text' name='image' value='" . $row["image"] . "'></td></tr>
						<tr><td>Temps de construction par unité (en secondes) : </td><td><input type='text' name='tps' value='" . $row["tps"] . "'></td></tr>
						<tr><td>Ressources nécéssaires (allez voir <a href='?mod=aide&action=selectressources' target='_blank'>ici</a>) : </td><td><input type='text' name='ressources' value='" . $row["ressources"] . "'></td></tr>
						<tr><td>Nombre maximum : </td><td><input type='text' name='niveau_max' value='" . $row["niveau_max"] . "'></td></tr>
						<tr><td>Points (nombre de points ajoutés pour chaque unité) : </td><td><input type='text' name='points' value='" . $row["points"] . "'></td></tr>
						
						<tr><td>Points d'attaque : </td><td><input type='text' name='attaque' value='" . $row["attaque"] . "'></td></tr>
						<tr><td>Points de défense : </td><td><input type='text' name='defense' value='" . $row["defense"] . "'></td></tr>
						<tr><td>Points de bouclier : </td><td><input type='text' name='bouclier' value='" . $row["bouclier"] . "'></td></tr>

						<tr><td>Batiments nécéssaires (allez voir <a href='?mod=aide&action=selectbatiments' target='_blank'>ici</a>) : </td><td><input type='text' name='batiments' value='" . $row["batiments"] . "'></td></tr>
						<tr><td>Recherches nécéssaires (allez voir <a href='?mod=aide&action=selectrecherches' target='_blank'>ici</a>) : </td><td><input type='text' name='recherches' value='" . $row["recherches"] . "'></td></tr>

						<tr><td>Accessible pour la race 1 : </td><td>".select("race_1")."</td></tr>
						<tr><td>Accessible pour la race 2 : </td><td>".select("race_2")."</td></tr>
						<tr><td>Accessible pour la race 3 : </td><td>".select("race_3")."</td></tr>
						<tr><td>Accessible pour la race 4 : </td><td>".select("race_4")."</td></tr>
						<tr><td>Accessible pour la race 5 : </td><td>".select("race_5")."</td></tr>

						<tr><td>Capacité de stockage : </td><td><input type='text' name='stockage' value='" . $row["stockage"] . "'></td></tr>
					</table>
					<br>
					<br>
					<input type='submit' value='Valider'></form>
					<br>
					<br>
					<center><img src='admin/tpl/icons/retour.gif.png'> <a href='?mod=chantier'>Retour</a></center>
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
			$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CHANTIER." SET 
														nom='" . addslashes($nom) . "',
														description='" . addslashes($description) . "',
														image='" . $image . "',
														tps='" . $tps . "',
														ressources='" . $ressources . "',
														niveau_max='" . $niveau_max . "',
														points='" . $points . "',
														
														attaque='" . $attaque . "',
														defense='" . $defense . "',
														bouclier='" . $bouclier . "',

														batiments='" . $batiments . "',
														recherches='" . $recherches . "'

														race_1='" . $race_1 . "',
														race_2='" . $race_2 . "',
														race_3='" . $race_3 . "',
														race_4='" . $race_4 . "',
														race_5='" . $race_5 . "',

														stockage='" . $stockage . "',

														WHERE id='" . $_GET["envoyemodif"] . "'
							 ");

			$page .= "<img src='admin/tpl/icons/accept.png'> Enregistrement effectué avec succès.<br><br>";
			
		} // fin if enregistrement modif
		
		#####################################################################
		
		if(!empty($_GET['remonter']) ) // Dans le cas ou le joueur a demander a remonter l'unité d'une place
		{ // debut if remonter d'un emplacement
		
			// On recupere l'ordre de l'unité possedant l'id envoyer par formulaire
			$ordrebat = $sql->select1("SELECT ordre FROM ".PREFIXE_TABLES.TABLE_CHANTIER." WHERE id='".$_GET['remonter']."' ");
			
			// On detruit l'ordre de l'unité precedent pour qu'il ne nous gene pas
			$sql->update('UPDATE '.PREFIXE_TABLES.TABLE_CHANTIER.' SET ordre="xyz" WHERE ordre="'. ($ordrebat - 1) .'" ');
			$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CHANTIER." SET ordre='" . ($ordrebat - 1) . "' WHERE id='" . $_GET['remonter'] . "' ");
			$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CHANTIER." SET ordre='" . $ordrebat . "' WHERE ordre='xyz' ");
		
		} // fin if remonter d'un emplacement
		
		#####################################################################
		
		if (@$_GET["creer"] == 1) // Dans le cas ou on a demander a créer une unité
		{ // debut if créer unité
		
    		$id = $sql->select1("SELECT MAX(id) FROM ".PREFIXE_TABLES.TABLE_CHANTIER." ") + 1;
			$ordre = $sql->select1("SELECT MAX(ordre) FROM ".PREFIXE_TABLES.TABLE_CHANTIER." ") + 1;
   		
			// On ajoute l'unité dans la table du chantier
    		$sql->update("INSERT INTO ".PREFIXE_TABLES.TABLE_CHANTIER." SET id='" . $id . "', 
    																	  						  nom='Nouvelle unité', 
    																	  						  ordre='" . $ordre . "'
    						 ");
			
			// On rajoute l'existance de l'unité pour chaque joueur
			$query = $sql->query('SELECT id, unites FROM '.PREFIXE_TABLES.TABLE_BASES.' ');
			while ($row = mysql_fetch_array($query) )
			{
				$bat = $row["unites"] . (($row['unites'] == '') ? '0' : ',0' );
				$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_BASES." SET unites='" . $bat . "' WHERE id='" . $row["id"] . "'");
			}
			
			// On modifie dans la table config les chantier par default
			$defbat = $controlrow["unites_default"] . (($controlrow["unites_default"] == '') ? '0' : ',0');
			$posbat = $controlrow["chantierids"] . (($controlrow["chantierids"] == '') ? $id : ',' . $id);
			$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . $defbat . "' WHERE config_name='unites_default'");
			$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . $posbat . "' WHERE config_name='unitesids'");
			
			// On detruit le cache pour l'actualiser
			unlink('cache/controlrow');
			
			$page .= "L'unité a bien été créé. Vous pouvez maintenant l'éditer.</center><br>";
    	
    	} // fin if créer unité

		#####################################################################

		if (!empty($_GET["supprimer"]) ) // Dans le cas ou on demande a supprimer une unité
		{ // debut if supprimer unité
			if(empty($_GET['validation']) ) // Dans le cas ou aucune confirmation a été posté, on affiche le formulaire
			{
				$page .= "Voulez vous vraiment supprimer cette unité ?
							 <br>
							 <br>
							 <a href='?mod=chantier&supprimer=" . $_GET['supprimer'] . "&validation=OUI'>
							 	OUI
							 </a> 
							 - 
							 <a href='?mod=chantier&supprimer=" . $_GET['supprimer'] . "&validation=NON'>
							 	NON
							 </a>
							";
			}
			elseif($_GET['validation'] == 'NON') // Dans le cas ou le formulaire a été renvoyé, et que le joueur ne veut pas virer l'unité
			{
				$page .= 'L\'unité n\'a pas été supprimer<br><br>';
			}
			elseif($_GET['validation'] == 'OUI') // Dans le cas ou le joueur veut vraiment virer son unité
			{
				// On supprime l'existance de l'unité dans la table des joueurs
				
				// On supprime l'unité de la BDD
    			$sql->update("DELETE FROM ".PREFIXE_TABLES.TABLE_CHANTIER." WHERE id='" . $_GET["supprimer"] . "'");
    		
    			$page .= 'L\'unité a bien été supprimer du jeu<br><br>';
    		}
		} // fin if supprimer unité


		#####################################################################

		$unites = $sql->query("SELECT id, nom FROM ".PREFIXE_TABLES.TABLE_CHANTIER." ORDER BY ordre");

		while ($unite = mysql_fetch_array($unites) ) 
		{
    		$page .= "<table valign='left' border = '0' Width = '500'>
    						<tr>
    							<td WIDTH ='50%'>
    								<img src='admin/tpl/icons/batiment_edit.gif.png'>  
    								<a href='?mod=chantier&action=modifier&unite=" . $unite["id"] . "'>
    									" . $unite["nom"] . "
    								</a>
    							</td>
	
								<td align ='center'>
									<img src='admin/tpl/icons/14522.gif'>
									<a href='?mod=chantier&remonter=" . $unite["id"] . "'>
										Remonter
									</a>
								</td>
								<td align ='center'>
									<img src='admin/tpl/icons/building_delete.png'>
									<a href='?mod=chantier&supprimer=" . $unite["id"] . "'>
										Supprimer
									</a>
								</td>
							</tr>
						</table>
						<br>
				  	  ";
		}


		$page .= "
					<img src='admin/tpl/icons/multi_group_add.gif.png'>
					<a href='?mod=chantier&creer=1'>
						Ajouter une unités
					</a>
					<br>
					<br>
					<center><img src='admin/tpl/icons/retour.gif.png'> 
					<a href='?mod=chantier'>Retour</a></center>

				  ";
		
	break;
	
} // fin switch get action







?>