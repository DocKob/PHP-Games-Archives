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

######################################################################################################
### Enregistrement des données lorsque celle ci ont été envoyé ###

if(@$_POST['formok'] == 'formok')
{ // debut if traitement formulaire
	
	// Enregistrement des nouveaux parametre dans SQL
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('mail') . "' WHERE config_name='mail'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('nom') . "' WHERE config_name='nom'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('url') . "' WHERE config_name='url'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('description') . "' WHERE config_name='description'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('description_breve') . "' WHERE config_name='description_breve'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('reglement') . "' WHERE config_name='reglement'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('ouvert') . "' WHERE config_name='ouvert'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('verifmail') . "' WHERE config_name='verifmail'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('log_menu') . "' WHERE config_name='log_menu'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('maxnews') . "' WHERE config_name='maxnews'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('maxscreens') . "' WHERE config_name='maxscreens'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('cacher_erreurs') . "' WHERE config_name='cacher_erreurs'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('screensparligne') . "' WHERE config_name='screensparligne'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('screenswidth') . "' WHERE config_name='screenswidth'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('screensheight') . "' WHERE config_name='screensheight'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('agemin') . "' WHERE config_name='agemin'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('logo') . "' WHERE config_name='logo'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('logo_log') . "' WHERE config_name='logo_log'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('rss') . "' WHERE config_name='rss'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('rss_log') . "' WHERE config_name='rss_log'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('icone') . "' WHERE config_name='icone'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('menu_width') . "' WHERE config_name='menu_width'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('coordonnees_activees') . "' WHERE config_name='coordonnees_activees'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('ordre_1_active') . "' WHERE config_name='ordre_1_active'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('ordre_1_max') . "' WHERE config_name='ordre_1_max'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('ordre_2_max') . "' WHERE config_name='ordre_2_max'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('ordre_3_max') . "' WHERE config_name='ordre_3_max'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('nom_bases') . "' WHERE config_name='nom_bases'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('nom_cases') . "' WHERE config_name='nom_cases'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('cases_default') . "' WHERE config_name='cases_default'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('cases_minimum_pour_colonisation') . "' WHERE config_name='cases_minimum_pour_colonisation'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('cases_maximum_pour_colonisation') . "' WHERE config_name='cases_maximum_pour_colonisation'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('ressourcesdepart') . "' WHERE config_name='ressourcesdepart'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('productiondepart') . "' WHERE config_name='productiondepart'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('stockagedepart') . "' WHERE config_name='stockagedepart'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('energie_nom') . "' WHERE config_name='energie_nom'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('energie_activee') . "' WHERE config_name='energie_activee'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('energie_default') . "' WHERE config_name='energie_default'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('login_template') . "' WHERE config_name='login_template'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('unites_nom') . "' WHERE config_name='unites_nom'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('chantier_necessaire') . "' WHERE config_name='chantier_necessaire'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('recherches_necessaire') . "' WHERE config_name='recherches_necessaire'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('ressources_coloniser') . "' WHERE config_name='ressources_coloniser'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('inscription_total') . "' WHERE config_name='inscription_total'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('vprofil_voirplanetes') . "' WHERE config_name='vprofil_voirplanetes'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('vprofil_voirbatiments') . "' WHERE config_name='vprofil_voirbatiments'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('vprofil_recherches') . "' WHERE config_name='vprofil_recherches'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('vprofil_flottes') . "' WHERE config_name='vprofil_flottes'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('vprofil_status') . "' WHERE config_name='vprofil_status'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('voir_batiments_inaccessibles') . "' WHERE config_name='voir_batiments_inaccessibles'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('upload_avatars_actif') . "' WHERE config_name='upload_avatars_actif'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('temps_voyage') . "' WHERE config_name='temps_voyage'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('tps_ordre_1') . "' WHERE config_name='tps_ordre_1'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('tps_ordre_2') . "' WHERE config_name='tps_ordre_2'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('carburant') . "' WHERE config_name='carburant'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('att_conquerir') . "' WHERE config_name='att_conquerir'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('points_mini') . "' WHERE config_name='points_mini'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('bases_max') . "' WHERE config_name='bases_max'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('tps_echanges') . "' WHERE config_name='tps_echanges'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('banque') . "' WHERE config_name='banque'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('valeurs') . "' WHERE config_name='valeurs'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('compression') . "' WHERE config_name='compression'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('base_de_depart_choisi_automatiquement') . "' WHERE config_name='base_de_depart_choisi_automatiquement'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('inscription_total') . "' WHERE config_name='inscription_total'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('race_1') . "' WHERE config_name='race_1'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('race_2') . "' WHERE config_name='race_2'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('race_3') . "' WHERE config_name='race_3'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('race_4') . "' WHERE config_name='race_4'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('race_5') . "' WHERE config_name='race_5'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('race_1_theme') . "' WHERE config_name='race_1_theme'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('race_2_theme') . "' WHERE config_name='race_2_theme'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('race_3_theme') . "' WHERE config_name='race_3_theme'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('race_4_theme') . "' WHERE config_name='race_4_theme'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('race_5_theme') . "' WHERE config_name='race_5_theme'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('race_1_infos') . "' WHERE config_name='race_1_infos'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('race_2_infos') . "' WHERE config_name='race_2_infos'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('race_3_infos') . "' WHERE config_name='race_3_infos'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('race_4_infos') . "' WHERE config_name='race_4_infos'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('race_5_infos') . "' WHERE config_name='race_5_infos'") ;

	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('message_bienvenue_actif') . "' WHERE config_name='message_bienvenue_actif'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('titre_message_bienvenue') . "' WHERE config_name='titre_message_bienvenue'") ;
	$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . chrp('message_bienvenue') . "' WHERE config_name='message_bienvenue'") ;

	// On supprime le cache pour lui permettre de se regenerer
	unlink('cache/controlrow');
	
	##################################################
	## Creation du fichier index.html a la racine pour passez dans une frame et ne pas afficher les liens en haut de pages
		
		// On ouvre le fichier contenant la source du fichier index a créer
		include('admin/TPL_creation_document_index.php'); // La variable neccessaire dedans est $doc_index
		
		// On remplace les sigles par les configurations du jeu		
		$pageframe = str_replace('{{nom}}', $controlrow['nom'], $doc_index);
		$pageframe = str_replace('{{url}}', $controlrow['url'], $pageframe);
		$pageframe = str_replace('{{description}}', $controlrow['description_breve'], $pageframe);
		$pagefinale = str_replace('{{template}}', $controlrow['login_template'], $pageframe);

		// On ecrit ou ré-écrit le fichier index.html se trouvant a la racine du jeu
		$f = fopen('index.html', 'w+');
		fputs($f, $pagefinale);
		fclose($f);

	## Fin d'ecriture de la page index.html
	##################################################
		
	$page .= "<h3><img src='admin/tpl/icons/accept.png'> Enregistrement effectué avec succès.</h3><br><br></center>";

	//On recharge la page pour actualiser les valeurs modifier
	die('<script>location="?mod=configurationprincipale|'.$mod[1].'&modif=ok"</script>');
	
} // fin if traitement formulaire



######################################################################################################




// On traite ici la partie de la configuration du jeu, elle est tous le temps chargé dans $controlrow, donc pas besoin de la recharger
// En revanche pour un fonctionnement avec la fonction select(), on doit changer le $controlrow en $row
$row = $controlrow;

// On affiche l'entete
$page .= 
			( (@$_GET['modif'] == 'ok')?'<h3><img src="admin/tpl/icons/accept.png"> Enregistrement effectué avec succès.</h3><br><br></center>':'')."
			Modification des paramètres principaux de votre jeu :
			<table width='100%' border='1'>
			<tr>
				<td width='20%' align='center'><a href='?mod=configurationprincipale|generale'>Generale</a></td>
				<td width='20%' align='center'><a href='?mod=configurationprincipale|bases'>Bases</a></td>
				<td width='20%' align='center'><a href='?mod=configurationprincipale|races'>Races</a></td>
				<td width='20%' align='center'><a href='?mod=configurationprincipale|attaques'>Attaques</a></td>
				<td width='20%' align='center'><a href='?mod=configurationprincipale|vprofils'>Mod Voir Profils</a></td>
			</tr>
			<tr>
				<td width='20%' align='center'><a href='?mod=configurationprincipale|msgbienvenue'>Message De Bienvenue</a></td>

				<!--
				<td width='20%' align='center'><a href='?mod=configurationprincipale|'></a></td>
				<td width='20%' align='center'><a href='?mod=configurationprincipale|'></a></td>
				<td width='20%' align='center'><a href='?mod=configurationprincipale|'></a></td>
				-->
			</tr>
			</table>

			<form action='?mod=configurationprincipale|".@$mod[1]."' method='post'>
			<br><br>
			<table>

		  ";

switch(@$mod[1])
{ // debut switch mod1


	/******************************************************************\
	|******************************************************************|
	\******************************************************************/

	case 'bases':
		
		$page .= "
						<tr><td>La base de départ est choisi automatiquement ? </td><td>".select("base_de_depart_choisi_automatiquement")."</td></tr>
						<tr><td>Activer le système de coordonnées ? </td><td>".select("coordonnees_activees")."</td></tr>
						<tr><td>Activer le troisième chiffre des coordonnées ? </td><td>".select("ordre_1_active")."</td></tr>
						<tr><td>Nombre maximum pour le premier chiffre des coordonnées : </td><td><input type='text' name='ordre_1_max' value='" . stripslashes($row["ordre_1_max"]) . "'></td></tr>
						<tr><td>Nombre maximum pour le deuxième chiffre des coordonnées : </td><td><input type='text' name='ordre_2_max' value='" . stripslashes($row["ordre_2_max"]) . "'></td></tr>
						<tr><td>Nombre maximum pour le troisième chiffre des coordonnées : </td><td><input type='text' name='ordre_3_max' value='" . stripslashes($row["ordre_3_max"]) . "'></td></tr>

						<tr><td><br><br>Terme utilisé pour désigner les bases (planètes) : </td><td><br><br><input type='text' name='nom_bases' value='" . stripslashes($row["nom_bases"]) . "'></td></tr>
						<tr><td>Terme utilisé pour désigner les cases : </td><td><input type='text' name='nom_cases' value='" . stripslashes($row["nom_cases"]) . "'></td></tr>

						<tr><td><br><br>Nombre de cases par défaut (pour la première base uniquement) : </td><td><br><br><input type='text' name='cases_default' value='" . stripslashes($row["cases_default"]) . "'></td></tr>
						<tr><td>Nombre maximum de bases : </td><td><input type='text' name='bases_max' value='" . stripslashes($row["bases_max"]) . "'></td></tr>
						<tr><td>Lors de la colonisation :</td><td></td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Nombre minimum de cases : </td><td><input type='text' name='cases_minimum_pour_colonisation' value='" . stripslashes($row["cases_minimum_pour_colonisation"]) . "'></td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Nombre maximum de cases : </td><td><input type='text' name='cases_maximum_pour_colonisation' value='" . stripslashes($row["cases_maximum_pour_colonisation"]) . "'></td></tr>

						</table>
						<br><br>
						Les éléments suivants requièrent que vous passiez par la <a href='index.php?mod=selectressources' target='_blank'>page de séléction de ressources</a>.<br>
						<table>
						<tr><td>Ressources possédées sur chaque base au départ : </td><td><input type='text' name='ressourcesdepart' value='" . stripslashes($row["ressourcesdepart"]) . "'></td></tr>
						<tr><td>Production sur chaque base au départ : </td><td><input type='text' name='productiondepart' value='" . stripslashes($row["productiondepart"]) . "'></td></tr>
						<tr><td>Stockage maximal de ressources sur chaque base au départ : </td><td><input type='text' name='stockagedepart' value='" . stripslashes($row["stockagedepart"]) . "'></td></tr>
						</table>
						<br>
						Les éléments suivants requièrent que vous passiez par la <a href='?mod=aide&action=selectbatiments' target='_blank'>page de séléction de batiments</a>.<br>
						<table>

						<tr><td>Batiments nécéssaires pour accéder aux recherches : </td><td><input type='text' name='recherches_necessaire' value='" . stripslashes($row["recherches_necessaire"]) . "'></td></tr>
						<tr><td>Batiments nécéssaires pour accéder au chantier : </td><td><input type='text' name='chantier_necessaire' value='" . stripslashes($row["chantier_necessaire"]) . "'></td></tr>
						<tr><td>Batiments nécéssaires pour accéder au defenses : </td><td><input type='text' name='defenses_necessaire' value='" . stripslashes($row["defenses_necessaire"]) . "'></td></tr>
						

						<tr><td><br><br>Activer l'énergie ? </td><td><br><br>".select("energie_activee")."</td></tr>
						<tr><td>Nom de l'énergie (si l'énergie est activée) : </td><td><input type='text' name='energie_nom' value='" . stripslashes($row["energie_nom"]) . "'></td></tr>
						<tr><td>Production d'énergie au départ (si l'énergie est activée) : </td><td><input type='text' name='energie_default' value='" . stripslashes($row["energie_default"]) . "'></td></tr>
					";

	break;
	
	/******************************************************************\
	|******************************************************************|
	\******************************************************************/

	case 'vprofils':

		$page .= "
						Quel sont les options qui doivent etre diponible sur la page permettant de voir le profils des autres joueurs ??
						<br><br>
						<tr><td>Voir les planètes ?</td><td>" . select("vprofil_voirplanetes") . "</td></tr>
						<tr><td>Voir les batiments sur chacunes des bases?</td><td>" . select("vprofil_voirbatiments") . "</td></tr>
						<tr><td>Voir les recherches ?</td><td>" . select("vprofil_recherches") . "</td></tr>
						<tr><td>Voir la flotte ?</td><td>" . select("vprofil_flottes") . "</td></tr>
						<tr><td>Voir le status ?</td><td>" . select("vprofil_status") . "</td></tr>
					";
	break;
	
	/******************************************************************\
	|******************************************************************|
	\******************************************************************/

	case 'races':
		
		$page .= "
						<tr><td>Nom de la race N° 1 : </td><td><input type='text' name='race_1' value='" . $row["race_1"] . "'></td></tr>
						<tr><td>Nom de la race N° 2 (vide pour ne pas utiliser la race) : </td><td><input type='text' name='race_2' value='" . stripslashes($row["race_2"]) . "'></td></tr>
						<tr><td>Nom de la race N° 3 (vide pour ne pas utiliser la race) : </td><td><input type='text' name='race_3' value='" . stripslashes($row["race_3"]). "'></td></tr>
						<tr><td>Nom de la race N° 4 (vide pour ne pas utiliser la race) : </td><td><input type='text' name='race_4' value='" . stripslashes($row["race_4"]) . "'></td></tr>
						<tr><td>Nom de la race N° 5 (vide pour ne pas utiliser la race) : </td><td><input type='text' name='race_5' value='" . stripslashes($row["race_5"]) . "'></td></tr>

						<tr><td><br><br>Nom du thème de la race N° 1 : </td><td><br><br><input type='text' name='race_1_theme' value='" . ($row["race_1_theme"]) . "'></td></tr>
						<tr><td>Nom du thème de la race N° 2 : </td><td><input type='text' name='race_2_theme' value='" . stripslashes($row["race_2_theme"]) . "'></td></tr>
						<tr><td>Nom du thème de la race N° 3 : </td><td><input type='text' name='race_3_theme' value='" . stripslashes($row["race_3_theme"]) . "'></td></tr>
						<tr><td>Nom du thème de la race N° 4 : </td><td><input type='text' name='race_4_theme' value='" . stripslashes($row["race_4_theme"]) . "'></td></tr>
						<tr><td>Nom du thème de la race N° 5 : </td><td><input type='text' name='race_5_theme' value='" . stripslashes($row["race_5_theme"]) . "'></td></tr>

						<tr><td><br><br>Description de la race N° 1 : </td><td><br><br><textarea cols='40' rows='5' name='race_1_infos'>" . ( $row["race_1_infos"]) . "</textarea></td></tr>
						<tr><td>Description de la race N° 2 : </td><td><textarea cols='40' rows='5' name='race_2_infos'>" .stripslashes( $row["race_2_infos"]) . "</textarea></td></tr>
						<tr><td>Description de la race N° 3 : </td><td><textarea cols='40' rows='5' name='race_3_infos'>" . stripslashes($row["race_3_infos"]) . "</textarea></td></tr>
						<tr><td>Description de la race N° 4 : </td><td><textarea cols='40' rows='5' name='race_4_infos'>" . stripslashes($row["race_4_infos"]) . "</textarea></td></tr>
						<tr><td>Description de la race N° 5 : </td><td><textarea cols='40' rows='5' name='race_5_infos'>" . stripslashes($row["race_5_infos"]) . "</textarea></td></tr>
					";

	break;
	
	/******************************************************************\
	|******************************************************************|
	\******************************************************************/

	case 'attaques':

		 $page .= "
						<tr><td>Temps de voyage entre deux bases : </td><td><input type='text' name='temps_voyage' value='" . stripslashes($row["temps_voyage"]) . "'></td></tr>
						<tr><td>Nombre de fois ce temps pour changer de galaxie : </td><td><input type='text' name='tps_ordre_1' value='" . stripslashes($row["tps_ordre_1"]) . "'></td></tr>
						<tr><td>Nombre de fois ce temps pour changer de système : </td><td><input type='text' name='tps_ordre_2' value='" . stripslashes($row["tps_ordre_2"]) . "'></td></tr>

						<tr><td><br><br>Ressources nécéssaires à la colonisation : </td><td><br><br><input type='text' name='ressources_coloniser' value='" . stripslashes($row["ressources_coloniser"]) . "'></td></tr>
						<tr><td>Carburant nécéssaire pour voyager entre deux bases : </td><td><input type='text' name='carburant' value='" . stripslashes($row["carburant"]) . "'></td></tr>


						<tr><td><br><br>Les attaquants peuvent remporter des unités adverses ? </td><td><br><br>".select("att_conquerir")."</td></tr>

						<tr><td><br><br>Terme utilisé pour désigner les unités (Unités, Flottes, ...) : </td><td><br><br><input type='text' name='unites_nom' value='" . stripslashes($row["unites_nom"]) . "'></td></tr>

						<tr><td><br><br>Points minimum pour être attaqué : </td><td><br><br><input type='text' name='points_mini' value='" . stripslashes($row["points_mini"]) . "'></td></tr>

					";


	break;
	
	/******************************************************************\
	|******************************************************************|
	\******************************************************************/

	case 'msgbienvenue':

		 $page .= "
						<tr><td align='center' colspan='2'>Vous pouvez choisir d'envoyer un message InGame a l'inscription d'un joueur</td></tr>
						<tr><td><br><br></td><td><br><br></td></tr>
						<tr><td>Activer le système d'envoi de message ?</td><td>" . select("message_bienvenue_actif") . "</td></tr>
						<tr><td><br><br></td><td><br><br></td></tr>
						<tr><td align='center' colspan='2'>Titre donné au message :</td></tr>
						<tr><td align='center' colspan='2'><input size='60' type='text' name='titre_message_bienvenue' value='" . stripslashes($row["titre_message_bienvenue"]) . "'></td></tr>
						<tr><td><br><br></td><td><br><br></td></tr>
						<tr><td align='center' colspan='2'>Sujet du message :</td></tr>
						<tr><td align='center' colspan='2'><textarea rows='10' cols='50' name='message_bienvenue'>" . stripslashes($row["message_bienvenue"]) . "</textarea></td></tr>
					";
	break;
	
	/******************************************************************\
	|******************************************************************|
	\******************************************************************/

	default :

		 $page .= "
						<tr><td>Votre mail : </td><td><input type='text' name='mail' value='" . stripslashes($row["mail"]) . "' size='66'></td></tr>
						<tr><td>Nom du jeu : </td><td><input type='text' name='nom' value='" . stripslashes($row["nom"]) . "' size='66'></td></tr>
						<tr><td>URL du jeu (n'oubliez pas de placer le ''/'' final, ne mettez pas le nom de la page) : </td><td><input type='text' name='url' value='" . stripslashes($row["url"]) . "'  size='66'></td></tr>
						<tr><td>Description : </td><td><textarea cols='50' rows='10' name='description'>" . stripslashes($row["description"]) . "</textarea></td></tr>
						<tr><td>Breves description pour les moteurs de recherches : </td><td><input type='text' name='description_breve' value='" . stripslashes($row["description_breve"]) . "' size='66'></td></tr>
						<tr><td>Règlement : </td><td><textarea cols='50' rows='10' name='reglement'>" . stripslashes($row["reglement"]) . "</textarea></td></tr>
						<tr><td>Cacher les erreurs : </td><td>" . select("cacher_erreurs") . "</td></tr>

						<tr><td>Jeu ouvert (pour les maintenances) ? </td><td>".select("ouvert")."</td></tr>
						<tr><td>Activer le mail d'inscription ? </td><td>".select("verifmail")."</td></tr>
						<tr><td>Afficher le menu sur la page d'accueil ? </td><td>".select("log_menu")."</td></tr>
						<tr><td>Taille du menu (en pourcentage de la largeur de la page) ? </td><td><input type='text' name='menu_width' value='" . stripslashes($row["menu_width"]) . "'></td></tr>

						<tr><td>Nombre de joueurs inscrits au maximum ? </td><td><input type='text' name='inscription_total' value='" . stripslashes($row["inscription_total"]) . "'></td></tr>

						<tr><td><br><br>Afficher le logo dans le jeu ? </td><td><br><br>".select("logo")."</td></tr>
						<tr><td>Afficher le logo dans la page de login ? </td><td>".select("logo_log")."</td></tr>
						<tr><td>Afficher les rss dans le jeu ? </td><td>".select("rss")."</td></tr>
						<tr><td>Afficher les rss sur la page de login ? </td><td>".select("rss_log")."</td></tr>
						<tr><td>Activer l'icone ? </td><td>".select("icone")."</td></tr>

						<tr><td><br><br>Nombre maximum de news affichées : </td><td><br><br><input type='text' name='maxnews' value='" . stripslashes($row["maxnews"]) . "'></td></tr>
						<tr><td>Nombre maximum de screens affichés : </td><td><input type='text' name='maxscreens' value='" . stripslashes($row["maxscreens"]) . "'></td></tr>
						<tr><td>Nombre de screens affichés par ligne : </td><td><input type='text' name='screensparligne' value='" . stripslashes($row["screensparligne"]) . "'></td></tr>
						<tr><td>Taille des screens : </td><td><input type='text' name='screenswidth' value='" . stripslashes($row["screenswidth"]) . "'> x <input type='text' name='screensheight' value='" . stripslashes($row["screensheight"]) . "'></td></tr>
						
						<tr><td><br><br>Activer la compression nyquist (accélère la transmission, mais prend plus de ressources serveur. Chez certains hébergeurs, cette fonction est bloquée) ? </td><td><br><br>".select("compression")."</td></tr>


						<tr><td><br><br>Age minimum pour accéder au jeu : </td><td><br><br><input type='text' name='agemin' value='" . stripslashes($row["agemin"]) . "'></td></tr>


						<tr><td><br><br>Nom du thème (template) utilisé par défaut : </td><td><br><br><input type='text' name='login_template' value='" . stripslashes($row["login_template"]) . "'></td></tr>

						<tr><td><br><br>Afficher les batiments/recherches inconstructibles : </td><td><br><br> ".select("voir_batiments_inaccessibles")." </td></tr>
						<tr><td>Permettre l'envoye d'avatars : </td><td> ".select("upload_avatars_actif")." </td></tr>

						<tr><td><br><br>Temps d'attente en secondes entre chaque échange : </td><td><br><br><input type='text' name='tps_echanges' value='" . stripslashes($row["tps_echanges"]) . "'></td></tr>
						<tr><td>Ressources disponibles à la banque (<a href='?mod=aide&action=selectressources' target='_blank'>Cliquez ici</a>) : </td><td><input type='text' name='banque' value='" . stripslashes($row["banque"]) . "'></td></tr>
						<tr><td>Valeurs des ressources pour les échanges (<a href='?mod=aide&action=selectressources' target='_blank'>Cliquez ici et entrez le nombre de ressources nécéssaire pour faire un crédit</a>) : </td><td><input type='text' name='valeurs' value='" . stripslashes($row["valeurs"]) . "'></td></tr>

					";
	
	break;
	
	/******************************************************************\
	|******************************************************************|
	\******************************************************************/


} // fin switch mod1

$page .=  "</table>
			  <br>
			  <input type='hidden' name='formok' value='formok'>
			  <input type='submit' value='Valider'></form>
			  <br><br><center><img src='design/icons/retour.gif.png'> <a href='?mod=default'>Retour</a></center>
			 ";




?>