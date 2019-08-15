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

	case 'modifier':
		
		// On recuperes les infos de la recherche a modifier
	$row = $sql->select('SELECT * FROM '.PREFIXE_TABLES.TABLE_RECHERCHES.' WHERE id="'.$_GET['recherche'].'" ');
		
		$page .= "
						<form method='post' action='?mod=recherches&envoyemodif=" . $_GET["recherche"] . "'>
						<table>
							<tr><td>Nom de la recherche : </td><td><input type='text' name='nom' value='" . $row["nom"] . "'></td></tr>
							<tr><td>Description : </td><td><textarea cols='50' rows='10' name='description'>" . $row["description"] . "</textarea></td></tr>
							<tr><td>Image (dans le dossier images/recherches et nommée x.gif ou x est un nombre, indiquez ce nombre) : </td><td><input type='text' name='image' value='" . $row["image"] . "'></td></tr>
							<tr><td>Temps de construction du premier niveau (en secondes) : </td><td><input type='text' name='tps' value='" . $row["tps"] . "'></td></tr>
							<tr><td>Evolution du temps : </td><td>Chaque niveau ajoute <input type='text' name='tps_evo' value='" . $row["tps_evo"] . "'>% au précédent.</td></tr>
							<tr><td>Ressources nécéssaires (allez voir <a href='?mod=aide&action=selectressources' target='_blank'>ici</a>) : </td><td><input type='text' name='ressources' value='" . $row["ressources"] . "'></td></tr>
							<tr><td>Evolution des ressources nécéssaires :  </td><td>Chaque niveau ajoute <input type='text' name='ressources_evo' value='" . $row["ressources_evo"] . "'>% au précédent.</td></tr>
							<tr><td>Niveau maximum (mettez 0 si il n'y a pas de niveau maximum) : </td><td><input type='text' name='niveau_max' value='" . $row["niveau_max"] . "'></td></tr>
							<tr><td>Points (nombre de points ajoutés pour chaque niveau) : </td><td><input type='text' name='points' value='" . $row["points"] . "'></td></tr>
							<tr><td>Evolution des points : </td><td>Chaque niveau ajoute <input type='text' name='points_evo' value='" . $row["points_evo"] . "'>% au précédent.</td></tr>

							<tr><td>Batiments nécéssaires (allez voir <a href='?mod=aide&action=selectbatiments' target='_blank'>ici</a>) : </td><td><input type='text' name='batiments' value='" . $row["batiments"] . "'></td></tr>
							<tr><td>Recherches nécéssaires (allez voir <a href='?mod=aide&action=selectrecherches' target='_blank'>ici</a>) : </td><td><input type='text' name='recherches' value='" . $row["recherches"] . "'></td></tr>

							<tr><td>Attaque supplémentaire (augmente l'attaque de x % par niveau) : </td><td><input type='text' name='attaque_supplementaire' value='" . $row["attaque_supplementaire"] . "'></td></tr>
							<tr><td>Défense supplémentaire (augmente la défense de x % par niveau) : </td><td><input type='text' name='defense_supplementaire' value='" . $row["defense_supplementaire"] . "'></td></tr>
							<tr><td>Bouclier supplémentaire (augmente le bouclier de x % par niveau) : </td><td><input type='text' name='bouclier_supplementaire' value='" . $row["bouclier_supplementaire"] . "'></td></tr>
							<tr><td>Vitesse supplémentaire (augmente la vitesse de x % par niveau) : </td><td><input type='text' name='vitesse_supplementaire' value='" . $row["vitesse_supplementaire"] . "'></td></tr>
							
							<tr><td>Accessible pour la race 1 : </td><td>".select("race_1")."</td></tr>
							<tr><td>Accessible pour la race 2 : </td><td>".select("race_2")."</td></tr>
							<tr><td>Accessible pour la race 3 : </td><td>".select("race_3")."</td></tr>
							<tr><td>Accessible pour la race 4 : </td><td>".select("race_4")."</td></tr>
							<tr><td>Accessible pour la race 5 : </td><td>".select("race_5")."</td></tr>
						</table>
						<br>
						<br>
						<input type='submit' value='Valider'>
						</form>
						<br>
						<br>
						<center>
						<img src='admin/tpl/icons/retour.gif.png'> 
						<a href='?mod=recherches'>Retour</a></center>
						";

		
	break;

	/******************************************************************\
	|******************************************************************|
	\******************************************************************/

	default :

		if(!empty($_GET['envoyemodif']) ) // Dans le cas ou on veut envoyer la modification d'un batiment
		{ // debut if modifier un recherche
		
			// On extrait le tableau des POST
			extract($_POST);

			$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_RECHERCHES." SET 
											nom='" . addslashes($nom) . "',
											description='" . addslashes($description) . "',
											image='" . $image . "',
											tps='" . $tps . "',
											tps_evo='" . $tps_evo . "',
											ressources='" . $ressources . "',
											ressources_evo='" . $ressources_evo . "',
											niveau_max='" . $niveau_max . "',
											points='" . $points . "',
											points_evo='" . $points_evo . "',
											batiments='" . $batiments . "',

											attaque_supplementaire='".$attaque_supplementaire."',
											defense_supplementaire='".$defense_supplementaire."',
											bouclier_supplementaire='".$bouclier_supplementaire."',
											vitesse_supplementaire='".$vitesse_supplementaire."',

											race_1='" . $race_1 . "',
											race_2='" . $race_2 . "',
											race_3='" . $race_3 . "',
											race_4='" . $race_4 . "',
											race_5='" . $race_5 . "',

											recherches='" . $recherches . "'
										
							     WHERE id='" . $_GET["envoyemodif"] . "'
							 ");

			$page .= "<img src='admin/tpl/icons/accept.png'> Enregistrement effectué avec succès.<br><br>";




		} // fin if modifier un recherche
		#####################################################################

		if(!empty($_GET['remonter']) ) // Dans le cas ou le joueur a demander a remonter la recherche d'une place
		{ // debut if remonter d'un emplacement
		
			// On recupere l'ordre de la recherche possedant l'id envoyer par formulaire
			$ordrebat = $sql->select1("SELECT ordre FROM ".PREFIXE_TABLES.TABLE_RECHERCHES." WHERE id='".$_GET['remonter']."' ");
			
			// On detruit l'ordre de la recherche precedent pour qu'il ne nous gene pas
			$sql->update('UPDATE '.PREFIXE_TABLES.TABLE_RECHERCHES.' SET ordre="xyz" WHERE ordre="'. ($ordrebat - 1) .'" ');
			$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_RECHERCHES." SET ordre='" . ($ordrebat - 1) . "' WHERE id='" . $_GET['remonter'] . "' ");
			$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_RECHERCHES." SET ordre='" . $ordrebat . "' WHERE ordre='xyz' ");
		
		} // fin if remonter d'un emplacement
		
		#####################################################################
		
		if (@$_GET["creer"] == 1) // Dans le cas ou on a demander a créer un batiment
		{ // debut if créer batiment
		
    		$id = $sql->select1("SELECT MAX(id) FROM ".PREFIXE_TABLES.TABLE_RECHERCHES." ") + 1;
			$ordre = $sql->select1("SELECT MAX(ordre) FROM ".PREFIXE_TABLES.TABLE_RECHERCHES." ") + 1;
   		
			// On ajoute la recherche dans la table des batiments
    		$sql->update("INSERT INTO ".PREFIXE_TABLES.TABLE_RECHERCHES." SET id='" . $id . "', 
    																	  						   nom='Nouvelle recherche', 
    																	  						   ordre='" . $ordre . "'
    						 ");
			
			// On rajoute l'existance du batiment pour chaque joueur
			$query = $sql->query('SELECT id, recherches FROM '.PREFIXE_TABLES.TABLE_USERS.' ');
			while ($row = mysql_fetch_array($query) )
			{
				$bat = $row["recherches"] . (($row['recherches'] == '') ? '0' : ',0' );
				$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_USERS." SET recherches='" . $bat . "' WHERE id='" . $row["id"] . "'");
			}
			
			// On modifie dans la table config les batiment par default
			$defbat = $controlrow["recherches_default"] . (($controlrow["recherches_default"] == '') ? '0' : ',0');
			$posbat = $controlrow["recherchesids"] . (($controlrow["recherchesids"] == '') ? $id : ',' . $id);
			$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . $defbat . "' WHERE config_name='recherches_default'");
			$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . $posbat . "' WHERE config_name='recherchesids'");
			
			// On detruit le cache pour l'actualiser
			unlink('cache/controlrow');
			
			$page .= "La recherche a bien été créé. Vous pouvez maintenant l'éditer.</center><br>";
    	
    	} // fin if créer batiment

		#####################################################################

		if (!empty($_GET["supprimer"]) ) // Dans le cas ou on demande a supprimer une recherche
		{ // debut if supprimer batiment
			if(empty($_GET['validation']) ) // Dans le cas ou aucune confirmation a été posté, on affiche le formulaire
			{
				$page .= "Voulez vous vraiment supprimer cette recherche ?
							 <br>
							 <br>
							 <a href='?mod=recherches&supprimer=" . $_GET['supprimer'] . "&validation=OUI'>
							 	OUI
							 </a> 
							 - 
							 <a href='?mod=recherches&supprimer=" . $_GET['supprimer'] . "&validation=NON'>
							 	NON
							 </a>
							";
			}
			elseif($_GET['validation'] == 'NON') // Dans le cas ou le formulaire a été renvoyé, et que le joueur ne veut pas virerle batiment
			{
				$page .= 'La recherche n\'a pas été supprimer<br><br>';
			}
			elseif($_GET['validation'] == 'OUI') // Dans le cas ou le joueur veut vraiment sa recherche
			{
				// On supprime l'existance de la recherche dans la table des joueurs
				
				// On supprime le batiment de la BDD
    			$sql->update("DELETE FROM ".PREFIXE_TABLES.TABLE_RECHERCHES." WHERE id='" . $_GET["supprimer"] . "'");
    		}
		} // fin if supprimer batiment

		#####################################################################

		$recherches = $sql->query("SELECT id, nom FROM ".PREFIXE_TABLES.TABLE_RECHERCHES." ORDER BY ordre");

		while ($recherche = mysql_fetch_array($recherches) ) 
		{
    		$page .= "<table valign='left' border = '0' Width = '500'>
    						<tr>
    							<td WIDTH ='50%'>
    								<img src='admin/tpl/icons/lightning.png'>  
    								<a href='?mod=recherches&action=modifier&recherche=" . $recherche["id"] . "'>
    									" . $recherche["nom"] . "
    								</a>
    							</td>
	
								<td align ='center'>
									<img src='admin/tpl/icons/lightning_go.png'>
									<a href='?mod=recherches&remonter=" . $recherche["id"] . "'>
										Remonter
									</a>
								</td>
								<td align ='center'>
									<img src='admin/tpl/icons/lightning_delete.png'>
									<a href='?mod=recherches&supprimer=" . $recherche["id"] . "'>
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
					<a href='?mod=recherches&creer=1'>
						Ajouter une recherche
					</a>
					<br>
					<br>
					<center><img src='admin/tpl/icons/retour.gif.png'> 
					<a href='?mod=recherche'>Retour</a></center>
				  ";
		
	
	break;

} // fin switch get action


?>