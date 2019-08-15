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
{ // debut switch get action
	
	/******************************************************************\
	|******************************************************************|
	\******************************************************************/

	case 'supprimer_carte' : // Dans le cas ou l'affichage des batiments sous forme de carte ne plait pas au joueur, ceci sert a la remplacé
	
	if(@$_GET["confirm"] == '1') // Dans le cas ou le joueur a confirmer qu'il desirait bien supprimer la carte
	{
		unlink("modules/systeme/batiments2.php");
		$page .= 'Carte désactivée avec succès
					 <br>
					 <br>
					 <a href="?mod=batiments">Retour</a>
				   ';
	}
	elseif(@$_GET['confirm'] == '0') // Dans le cas ou le joueur renonce a la suppression
	{
		$page .= 'Vous avez renoncé a supprimer l\'affichage sous forme de carte
					 <br>
					 <br>
					 <a href="?mod=batiments">Retour</a>
				   ';
	}
	else // Dans le cas ou le formulair en'a pas encore été posté
	{
		$page .= "Etes vous sur de vouloir désactiver la carte ? 
					 Ceci sera irréversible, elle sera remplacée par une liste de batiments...
					 <br>
					 <br>
					 <br>
					 <br>
					 <br>
					 <a href='?mod=batiments&action=supprimer_carte&confirm=1'>OUI</a>
					 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					 <a href='?mod=batiments&action=supprimer_carte&confirm=0'>NON</a>";
	}
	
	break;
	
	/******************************************************************\
	|******************************************************************|
	\******************************************************************/

	case 'modifier':
	
	// On recupere le SQL du batiment pour l'afficher
	$row = $sql->select('SELECT * FROM '.PREFIXE_TABLES.TABLE_BATIMENTS.' WHERE id="'.$_GET['batiment'].'" ');
	
	$page .= "
					<form method='post' action='?mod=batiments&envoyemodif=" . $_GET["batiment"] . "'>
					<table>
						<tr>
							<td>Nom du batiment : </td>
							<td><input type='text' name='nom' value='" . $row["nom"] . "'></td>
						</tr>
						<tr>
							<td>Description : </td>
							<td><textarea cols='50' rows='10' name='description'>" . $row["description"] . "</textarea></td>
						</tr>
						<tr>
							<td>Image (dans le dossier images/batiments et nommée x.gif ou x est un nombre, indiquez ce nombre) : </td>
							<td><input type='text' name='image' value='" . $row["image"] . "'></td>
						</tr>

						<tr>
							<td><br><br>Temps de construction du premier niveau (en secondes) : </td>
							<td><br><br><input type='text' name='tps' value='" . $row["tps"] . "'></td>
						</tr>
						<tr>
							<td>Evolution du temps :  </td>
							<td>Chaque niveau ajoute <input type='text' name='tps_evo' value='" . $row["tps_evo"] . "'>% au précédent.</td>
						</tr>

						<tr>
							<td><br><br>Ressources nécéssaires (allez voir <a href='?mod=aide&action=selectressources' target='_blank'>ici</a>) : </td>
							<td><br><br><input type='text' name='ressources' value='" . $row["ressources"] . "'></td>
						</tr>
						<tr>
							<td>Evolution des ressources nécéssaires :  </td>
							<td>Chaque niveau ajoute <input type='text' name='ressources_evo' value='" . $row["ressources_evo"] . "'>% au précédent.</td>
						</tr>

						<tr>
							<td><br><br>Niveau maximum (mettez 0 si il n'y a pas de niveau maximum) : </td>
							<td><br><br><input type='text' name='niveau_max' value='" . $row["niveau_max"] . "'></td>
						</tr>

						<tr>
							<td><br><br>Production de ressources (allez voir <a href='?mod=aide&action=selectressources' target='_blank'>ici</a>. Si vous souhaitez que votre batiments consomme des ressources chaque heure, il vous suffit d'entrer une production négative de ces ressources.) : </td>
							<td><br><br><input type='text' name='production' value='" . $row["production"] . "'></td>
						</tr>
						<tr>
							<td>Evolution de la production : </td>
							<td>Chaque niveau ajoute <input type='text' name='production_evo' value='" . $row["production_evo"] . "'>% au précédent.</td></tr>
						<tr>
							<td>Diminution du temps de construction de l'ensemble des batiments : </td>
							<td>Diminuer de <input type='text' name='temps_diminution' value='" . $row["temps_diminution"] . "'>% par niveau.</td>
						</tr>

						<tr>
							<td>Consommation d'énergie : </td>
							<td><input type='text' name='consommation' value='" . $row["consommation"] . "'></td>
						</tr>
						<tr>
							<td>Evolution de la consommation : </td>
							<td>Chaque niveau ajoute <input type='text' name='consommation_evo' value='" . $row["consommation_evo"] . "'>% au précédent.</td>
						</tr>

						<tr>
							<td>Production d'énergie : </td>
							<td><input type='text' name='production_energie' value='" . $row["production_energie"] . "'></td>
						</tr>
						<tr>
							<td>Evolution de la production d'énergie : </td>
							<td>Chaque niveau ajoute <input type='text' name='production_energie_evo' value='" . $row["production_energie_evo"] . "'>% au précédent.</td>
						</tr>
	
						<tr>
							<td><br><br>Stockage supplémentaire de ressources (allez voir <a href='?mod=aide&action=selectressources' target='_blank'>ici</a>) : </td>
							<td><br><br><input type='text' name='stockage' value='" . $row["stockage"] . "'></td>
						</tr>
						<tr>
							<td>Evolution du stockage : </td>
							<td>Chaque niveau ajoute <input type='text' name='stockage_evo' value='" . $row["stockage_evo"] . "'>% au précédent.</td>
						</tr>
	
						<tr>
							<td><br><br>Batiments nécéssaires (allez voir <a href='?mod=aide&action=selectbatiments' target='_blank'>ici</a>) : </td>
							<td><br><br><input type='text' name='batiments' value='" . $row["batiments"] . "'></td>
						</tr>
						<tr>
							<td>Recherches nécéssaires (allez voir <a href='?mod=aide&action=selectrecherches' target='_blank'>ici</a>) : </td>
							<td><input type='text' name='recherches' value='" . $row["recherches"] . "'></td>
						</tr>
	
						<tr>
							<td><br><br>Points (Nombre de points ajoutés pour chaque niveau) : </td>
							<td><br><br><input type='text' name='points' value='" . $row["points"] . "'></td>
						</tr>
						<tr>
							<td>Evolution des points : </td>
							<td>Chaque niveau ajoute <input type='text' name='points_evo' value='" . $row["points_evo"] . "'>% au précédent.</td>
						</tr>

						<tr>
							<td>Case+ (Nombre de cases disponible en plus par niveau) : </td>
							<td><input type='text' name='cases_en_plus' value='" . $row["cases_en_plus"] . "'></td>
						</tr>


						<tr>
							<td><br><br>Accessible pour la race 1 : </td>
							<td><br><br>".select("race_1")."</td>
						</tr>
						<tr>
							<td>Accessible pour la race 2 : </td>
							<td>".select("race_2")."</td></tr>
						<tr>
							<td>Accessible pour la race 3 : </td>
							<td>".select("race_3")."</td></tr>
						<tr>
							<td>Accessible pour la race 4 : </td>
							<td>".select("race_4")."</td></tr>
						<tr>
							<td>Accessible pour la race 5 : </td>
							<td>".select("race_5")."</td>
						</tr>

					</table>
					<br>
					<br>
					<input type='submit' value='Valider'></form>
					<br>
					<br>
					<center><img src='admin/tpl/icons/retour.gif.png'> <a href='?mod=batiments'>Retour</a></center>
				";


	break;

	/******************************************************************\
	|******************************************************************|
	\******************************************************************/

	default :

		if(!empty($_GET['envoyemodif']) ) // Dans le cas ou on veut envoyer la modification d'un batiment
		{ // debut if modifier un batiment
		
			// On extrait le tableau des POST
			extract($_POST);
			
			$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_BATIMENTS." SET 
								nom='" . addslashes($nom) . "',
								description='" . addslashes($description) . "',
								image='" . $image . "',
								tps='" . $tps . "',
								tps_evo='" . $tps_evo . "',
								ressources='" . $ressources . "',
								ressources_evo='" . $ressources_evo . "',
								niveau_max='" . $niveau_max . "',
								production='" . $production . "',
								production_evo='" . $production_evo . "',
								temps_diminution='" . $temps_diminution . "',

								points='" . $points . "',
								points_evo='" . $points_evo . "',
								cases_en_plus='" . $cases_en_plus . "',

								consommation='" . $consommation . "',
								consommation_evo='" . $consommation_evo . "',
								production_energie='" . $production_energie . "',
								production_energie_evo='" . $production_energie_evo . "',

								stockage='" . $stockage . "',
								stockage_evo='" . $stockage_evo . "',

								race_1='" . $race_1 . "',
								race_2='" . $race_2 . "',
								race_3='" . $race_3 . "',
								race_4='" . $race_4 . "',
								race_5='" . $race_5 . "',

								batiments='" . $batiments . "',
								recherches='" . $recherches . "'

								WHERE id='" . $_GET["envoyemodif"] . "' 
						 ");

			$page = "<img src='admin/tpl/icons/accept.png'>Enregistrement effectué avec succès.<br><br>";
		
		} // fin if modifier un batiment
		#####################################################################

		if(!empty($_GET['remonter']) ) // Dans le cas ou le joueur a demander a remonter le batiment d'une place
		{ // debut if remonter d'un emplacement
		
			// On recupere l'ordre du batiment possedant l'id envoyer par formulaire
			$ordrebat = $sql->select1("SELECT ordre FROM ".PREFIXE_TABLES.TABLE_BATIMENTS." WHERE id='".$_GET['remonter']."' ");
			
			// On detruit l'ordre du batiment precedent pour qu'il ne nous gene pas
			$sql->update('UPDATE '.PREFIXE_TABLES.TABLE_BATIMENTS.' SET ordre="xyz" WHERE ordre="'. ($ordrebat - 1) .'" ');
			$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_BATIMENTS." SET ordre='" . ($ordrebat - 1) . "' WHERE id='" . $_GET['remonter'] . "' ");
			$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_BATIMENTS." SET ordre='" . $ordrebat . "' WHERE ordre='xyz' ");
		
		} // fin if remonter d'un emplacement
		
		#####################################################################
		
		if (@$_GET["creer"] == 1) // Dans le cas ou on a demander a créer un batiment
		{ // debut if créer batiment
		
    		$id = $sql->select1("SELECT MAX(id) FROM ".PREFIXE_TABLES.TABLE_BATIMENTS." ") + 1;
			$ordre = $sql->select1("SELECT MAX(ordre) FROM ".PREFIXE_TABLES.TABLE_BATIMENTS." ") + 1;
   		
			// On ajoute le batiment dans la table des batiments
    		$sql->update("INSERT INTO ".PREFIXE_TABLES.TABLE_BATIMENTS." SET id='" . $id . "', 
    																	  						  nom='Nouveau batiment', 
    																	  						  ordre='" . $ordre . "'
    						 ");
			
			// On rajoute l'existance du batiment pour chaque joueur
			$query = $sql->query('SELECT id, batiments FROM '.PREFIXE_TABLES.TABLE_BASES.' ');
			while ($row = mysql_fetch_array($query) )
			{
				$bat = $row["batiments"] . (($row['batiments'] == '') ? '0' : ',0' );
				$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_BASES." SET batiments='" . $bat . "' WHERE id='" . $row["id"] . "'");
			}
			
			// On modifie dans la table config les batiment par default
			$defbat = $controlrow["batiments_default"] . (($controlrow["batiments_default"] == '') ? '0' : ',0');
			$posbat = $controlrow["batimentsids"] . (($controlrow["batimentsids"] == '') ? $id : ',' . $id);
			$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . $defbat . "' WHERE config_name='batiments_default'");
			$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . $posbat . "' WHERE config_name='batimentsids'");
			
			// On detruit le cache pour l'actualiser
			unlink('cache/controlrow');
			
			$page .= "Le batiment a bien été créé. Vous pouvez maintenant l'éditer.</center><br>";
    	
    	} // fin if créer batiment

		#####################################################################

		if (!empty($_GET["supprimer"]) ) // Dans le cas ou on demande a supprimer un batiment
		{ // debut if supprimer batiment
			if(empty($_GET['validation']) ) // Dans le cas ou aucune confirmation a été posté, on affiche le formulaire
			{
				$page .= "Voulez vous vraiment supprimer ce batiment ?
							 <br>
							 <br>
							 <a href='?mod=batiments&supprimer=" . $_GET['supprimer'] . "&validation=OUI'>
							 	OUI
							 </a> 
							 - 
							 <a href='?mod=batiments&supprimer=" . $_GET['supprimer'] . "&validation=NON'>
							 	NON
							 </a>
							";
			}
			elseif($_GET['validation'] == 'NON') // Dans le cas ou le formulaire a été renvoyé, et que le joueur ne veut pas virerle batiment
			{
				$page .= 'Le batiment n\'a pas été supprimer<br><br>';
			}
			elseif($_GET['validation'] == 'OUI') // Dans le cas ou le joueur veut vraiment virer son batiment
			{
				// On supprime l'existance du batiment dans la table des joueurs
				
				// On supprime le batiment de la BDD
    			$sql->update("DELETE FROM ".PREFIXE_TABLES.TABLE_BATIMENTS." WHERE id='" . $_GET["supprimer"] . "'");
    		}
		} // fin if supprimer batiment

		#####################################################################

		$batiments = $sql->query("SELECT id, nom FROM ".PREFIXE_TABLES.TABLE_BATIMENTS." ORDER BY ordre");

		while ($batiment = mysql_fetch_array($batiments) ) 
		{
    		$page .= "<table valign='left' border = '0' Width = '500'>
    						<tr>
    							<td WIDTH ='50%'>
    								<img src='admin/tpl/icons/batiment_edit.gif.png'>  
    								<a href='?mod=batiments&action=modifier&batiment=" . $batiment["id"] . "'>
    									" . $batiment["nom"] . "
    								</a>
    							</td>
	
								<td align ='center'>
									<img src='admin/tpl/icons/14522.gif'>
									<a href='?mod=batiments&remonter=" . $batiment["id"] . "'>
										Remonter
									</a>
								</td>
								<td align ='center'>
									<img src='admin/tpl/icons/building_delete.png'>
									<a href='?mod=batiments&supprimer=" . $batiment["id"] . "'>
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
					<a href='?mod=batiments&creer=1'>
						Ajouter un batiment
					</a>
					<br>
					<br>
					<center><img src='admin/tpl/icons/retour.gif.png'> 
					<a href='?mod=batiments'>Retour</a></center>
					<br>
					<br>
					<br>
					<br>
					<br>
					<img src='admin/tpl/icons/building_error.png'>
					<a href='?mod=batiments&action=supprimer_carte'>
						<font color='red'>Désactiver la carte (elle sera remplacée par une liste).</font>
					</a>
				  ";
		
	
	break;

} // fin switch get action



?>
