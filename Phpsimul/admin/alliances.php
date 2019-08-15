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
{ // debut switch get action

	/**************************************************************************\
	|**************************************************************************|
	\**************************************************************************/
	
	case 'liste' :
		
		#################################################################################
		if (!empty($_GET['supprimer']) ) // Si on demande a virer une alliance
		{ // debut if supprimer alliance
		
			// $_GET['supprimer'] contient l'id de l'alliance a virer
			
			if(empty($_GET['validation']) ) // Dans le cas ou aucune confirmation a été posté, on affiche le formulaire
			{
				$page .= "Voulez vous vraiment supprimer cette alliance ?
							 <br>
							 <br>
							 <a href='?mod=alliances&action=liste&supprimer=" . $_GET['supprimer'] . "&validation=OUI'>
							 	OUI
							 </a> 
							 - 
							 <a href='?mod=alliances&action=liste&supprimer=" . $_GET['supprimer'] . "&validation=NON'>
							 	NON
							 </a>
							 <br>
							 <hr>
							 <br>
							";
			}
			elseif($_GET['validation'] == 'NON') // Dans le cas ou on veut plus virer l'alliance
			{
				$page .= 'L\'alliance n\'a pas été supprimée<br><hr><br>';
			}
			elseif($_GET['validation'] == 'OUI') // Dans le cas ou le joueur veut vraiment virer l'alliance
			{
				// On supprime l'alliance et on detruit son existance dans toutes les tables
				$sql->update("DELETE FROM ".PREFIXE_TABLES.TABLE_ALLIANCES." WHERE id='".$_GET['supprimer']."' "); // On detruit l'alliance
				$sql->update("DELETE FROM ".PREFIXE_TABLES.TABLE_RANGS." WHERE idalli='".$_GET['supprimer']."' "); // On detruit les rangs associé a l'alliance
				$sql->update("DELETE FROM ".PREFIXE_TABLES.TABLE_ALLIANCES_CANDIDATURES." WHERE idalli='".$_GET['supprimer']."' "); // On detruit les candidatures associé a l'alliance
				$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_USERS." SET alli='0' , admin_alli='0', rangs='0' WHERE alli='".$_GET['supprimer']."' "); // On remet l'alliance des joueurs a 0 pour ceut qui avait cette alliance
				$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_USERS." SET candidature='0' WHERE candidature='".$_GET['supprimer']."' "); // On supprime toutes les demande de candidature pour cette alliance
    		
				$page .= 'L\'alliance a bien été supprimée<br><hr><br>';
    		}
		} // fin if supprimer alliance
		#################################################################################
		
		//### On affiche la liste des alliances ###\\
		
		// On recupere la liste des alliances
		$alliances = $sql->query("SELECT * FROM ".PREFIXE_TABLES.TABLE_ALLIANCES." ORDER BY id "); // On recupere la liste des alliances

		if(mysql_num_rows($alliances) <= 0) //  Dans ce cas aucunes alliance existe dans la base de données
		{
			$page .= '
						<img border="0" src="admin/tpl/images/456.gif">
						<br>
						Il n\' existe pas d\'alliance dans la base de données
						<br>
						<br>
						<br>
						<img border="0" src="admin/tpl/icons/add.png"> <a href="?mod=alliances&action=creer_alliance">Créer une alliance</a>
						<br>
						<br>
						<br>
						<img src="admin/tpl/icons/retour.gif.png"> <a href="?mod=alliances">Retour</a>
					 ';
		}
		elseif(mysql_num_rows($alliances) > 0) //  Dans le cas u il existe une ou plusieurs alliances
		{ // debut elseif il existe des alliances
			$page .= "
						<center>
						<img src='admin/tpl/icons/retour.gif.png'> 
						<a href='?mod=alliances'>Retour</a>
						<br>
						<br>
						Cliquez sur un nom d'alliance pour modifiez ses options<br><br>
						<table border='1' width='400'>
							<tr>
								<td></td>
								<th>N°</th>
								<th>Nom de l'alliance</th>
								<th>Tag</th>
								<th>Points</th>
							</tr>
					";

			$nombre = 1 ; // On initalise la variable 

			while ($alliance = mysql_fetch_array ($alliances) ) 
			{ // debut while afficher liste alliances
				$points = $sql->select1("SELECT SUM(points) FROM  ".PREFIXE_TABLES.TABLE_USERS." WHERE alli='".$alliance['id']."' ") ; // On recupere les points de l'alliance en aditionnant les points de chaque joueurs
	
				$page .= " 
							<tr>
								<td align='center'>
									<a href='?mod=alliances&action=liste&supprimer=".$alliance['id']."'>
										<img border='0' width='10px' src='admin/tpl/icons/delete.gif.png'>
									</a>
								</td>
								<td align='center'>
									".$nombre."
								</td>
								<td align='center'>
									<a href='?mod=alliances&action=modifier_alliance&alliance=".$alliance['id']."'>
										".$alliance['nom']."
									</a>
								</td>
								<td align='center'>
									".$alliance['tag']."
								</td>
								<td align='center'>
									".$points."
								</td>
							</tr>
						";
						
						$nombre++;
			} // fin while afficher liste alliances

			$page .= "
						</table>
						<br>
						<br>
						<br>
						<img border='0' src='admin/tpl/icons/add.png'> 
						<a href='?mod=alliances&action=creer_alliance'>Créer une alliance</a>
						<br>
						<br>
						<center><img src='admin/tpl/icons/retour.gif.png'> 
						<a href='?mod=alliances'>Retour</a></center>
					";
		
		} // fin elseif il existe des alliances
	break;
	
	/**************************************************************************\
	|**************************************************************************|
	\**************************************************************************/

	case 'modifier_alliance' : // Dans le cas ou on veut modifieer une alliance existante
	case 'creer_alliance' : // Si on desire créer une alliance
		
		################################################################
		if(@$_GET['envoyemodif'] == '0') // Dans le cas ou on vient de créer une alliance
		{ // debut if créer alliance
			$error = ''; // On initalise la variable
			
			// On verifie que le tag et le nom de l'alliance ont bien été rempli, et qu'il n'existe pas deja
			if($_POST['nom'] == '') // Si aucun nom n'a été indiquer
			{
				$error .= 'Merci d\'indiquer un nom a l\'alliance<br>';
			}
			else // Dans le cas ou on a specifier un nom, on regarde qu'il  n'existe pas deja
			{
				$existe_nom = $sql->select1('SELECT COUNT(nom) FROM '.PREFIXE_TABLES.TABLE_ALLIANCES.' WHERE nom="'.$_POST['nom'].'" ');
				
				if($existe_nom >= 1) // Dans le cas ou le nom existe deja 
				{
					$error .= 'Le nom specifie existe deja, vous ne pouvez pas créer une alliance portant ce nom<br>';
				}
			}
			
			if($_POST['tag'] == '') // si aucun tag n'a été indiquer
			{
				$error .= 'Merci d\'indiquer un tag pour l\'alliance<br>';
			}
			else // Dans le cas ou un tag a été indiquer on regarde si il n'existe pas deja
			{
				$existe_tag = $sql->select1('SELECT COUNT(tag) FROM '.PREFIXE_TABLES.TABLE_ALLIANCES.' WHERE tag="'.$_POST['tag'].'" ');
				
				if($existe_tag >= 1) // Dans le cas ou le tag existe deja 
				{
					$error .= 'Le tag specifie existe déja, vous ne pouvez pas créer une alliance portant ce tag<br>';
				}
			}
			
			if($error == '') // Dans le cas ou aucune erreurs n'ont été trouvé, ont ajoute l'alliance dans la BDD
			{
				$sql->update('INSERT INTO '.PREFIXE_TABLES.TABLE_ALLIANCES.' SET
									nom="'.$_POST['nom'].'",
									tag="'.$_POST['tag'].'",
									adresse_forum="'.( ($_POST['forum'] != '')?$_POST['forum']:'').'", 
									logo="'.( ($_POST['logo'] != '')?$_POST['logo']:'').'", 
									texte_externe="'.( ($_POST['texte_externe'] != '')?$_POST['texte_externe']:'').'",
									texte_interne="'.( ($_POST['texte_interne'] != '')?$_POST['texte_interne']:'').'",
									candidature="'.( ($_POST['candidature'] != '')?$_POST['candidature']:'').'", 
									status="'.( ($_POST['status'] != '')?$_POST['status']:'').'", 
									id_rangs_default=""    
							 ');									
			
				$page .= 'L\'alliance a bien été créer, vous pouvez modifier ces informations<br><hr><br>';
			
			}
			else // Dans le cas ou des erreurs ont été trouvé, on reaffiche la page en affichant les texte d'erreurs 
			{
				// On formates les erreurs et on les affiches dans la page
				$page .= $error.'<br><hr><br>';
				
			}
			
		} // fin if créer alliance
		################################################################
		elseif(!empty($_GET['envoyemodif']) ) // Dans ce cas on modifie une alliance existante
		{ // debut elseif modification alliance
			
			// On verifie que les champs principaux et obligatoire ont été rempli, sinon on ne les modifie pas
			if($_POST['nom'] == '')
			{
				// L'admin a detruit le nom de l'alliance
				$nom = '0'; // Precise au script de ne pas modifier le nom
			}
			else // On verifie que le nom n'existe pas deja dans SQL pour une autre alliance
			{
				$existe_nom = $sql->select1('SELECT COUNT(nom) FROM '.PREFIXE_TABLES.TABLE_ALLIANCES.' WHERE nom="'.$_POST['nom'].'" and id != "'.$_GET['envoyemodif'].'" ');
				if($existe_nom >= 1) // Dans ce cas il existe une alliance portant ce nom
				{
					$nom = '0'; // On empeche la modification du nom
				}
			}
			if($_POST['tag'] == '')
			{
				// Si l'admin a voulu virer le tag de l'alliance
				$tag = '0'; // Precise au script de ne pas toucher au tag dans SQL
			}
			else // On regarde si le tag n'existe pas deja
			{
				$existe_tag = $sql->select1('SELECT COUNT(tag) FROM '.PREFIXE_TABLES.TABLE_ALLIANCES.' WHERE tag="'.$_POST['tag'].'" and id != "'.$_GET['envoyemodif'].'" ');
				if($existe_tag >= 1) // Dans ce cas il existe une alliance portant cetag
				{
					$tag = '0'; // On empeche la modification du tag
				}
			}
			//------------------- Envoi des donnés dans MySQL--------------------------------\\
			$sql->update("UPDATE '.PREFIXE_TABLES.TABLE_ALLIANCES.' SET 
									".( (@$nom != '0')?"nom='".addslashes($_POST['nom'])."', ":'')."
									".( ($tag != '0')?"tag='".addslashes($_POST['tag'])."', ":'')."
									adresse_forum='".$_POST['forum']."', 
									logo='".$_POST['logo']."', 
									texte_externe='".addslashes($_POST['texte_externe'])."',
									texte_interne='".addslashes($_POST['texte_interne'])."',
									candidature='".addslashes($_POST['candidature'])."', 
									status='".addslashes($_POST['status'])."', 
									id_rangs_default='".$_POST['rangs']."'    
								WHERE id = '".$_GET['envoyemodif']."' 
						 ");

			//------------------- Texte pour dire que 'alliance a bien été modifié- -------------------------------\\
			$page .= "L'alliance a bien été mise à jour
					  <br>
					  <hr>
					  <br>
					  ";

						
		} // fin if modification alliance
		###########################################################################
		
		//### on affiche les champ modifiable de l'alliance ###\\

		if($_GET['action'] == 'modifier_alliance') // Si on a demander a modifier une alliance
		{
			// On recupere les infos de l'alliance a modifier
			$row = $sql->select1("SELECT * FROM ".PREFIXE_TABLES.TABLE_ALLIANCES." WHERE id='".$_GET['alliance']."' ");
			$id = $row['id']; // On recupere l'id de l'alliance pour le champ form
		}
		else // Dans le second cas, on a demander a créer une alliance
		{
			$id = '0'; // Pour permettre au script de savoir qu'il doit créer l'alliance on lui indique que l'id est egal a 0 
			
			// Dans le cas d'une modification, on incremente les $row par des $_POST ce qui permet de ne pas tous ré-ecrire au reaffichage du formulaire en cas d'erreurs
			
		}
		#######################################################################
		
		//### On affiche les infos modifiable de l'alliance ###\\
		
		$page .= "
					<center>
					<b>Vous pouvez modifier les informations ci-dessous :</b>
					<br>
					<br>
					<br>
					<form method='post' 
						action='?mod=alliances
						&action=".( ($_GET['action'] == 'modifier_alliance')?'modifier_alliance':'creer_alliance')."
						&envoyemodif=".$id."'
					>
					<table>
						<tr>
							<td>Nom de l'alliance :</td> 
							<td><input type='text'  size='50' name='nom' value='".$row['nom']."'></td>
						</tr>
						<tr>
							<td>TAG :</td> 
							<td><input type='text' name='tag'  size='50' value='".$row['tag']."'></td>
						</tr>
						<tr>
							<td>Forum :</td> 
							<td> <input type='text' name='forum' size='50'  value='".$row['adresse_forum']."'></td>
						</tr>
						<tr>
							<td>Logo de l'alliance :</td> 
							<td> <input type='text' size='50' name='logo' value='".$row['logo']."'></td>
						</tr>
						<tr>
							<td>Status du moment :</td> 
							<td><input type='text' size='50' name='status' value='".$row['status']."'></td>
						</tr>
						<tr>
							<td>Rang par default :</td> 
							<td>
								<select name='rangs' STYLE='width:100%'> 
				 ";

		// On recupere les rangs existants de l'alliance dans le cas d'une modification
		if($_GET['action'] == 'modifier_alliance')
		{
			$rangs1 = $sql->query("SELECT * FROM ".PREFIXE_TABLES.TABLE_RANGS." WHERE idalli='".$row['id']."' ORDER BY nom ");

			while ($rangs = mysql_fetch_array($rangs1) ) 
			{
				$page .= "<option ".( ($rangs["id"] == $row["id_rangs_default"])?'SELECTED':'' )." value='".$rangs["id"]."'>".$rangs["nom"]."</option>";
			}
		
			$page .= "<OPTION ".( ($row["id_rangs_default"] == "")?'SELECTED':'')." value='Aucun'>Aucun</option>";
		}
		else // Dans le cas d'une creation on affiche le rang aucun et on le selectionne par defaul
		{
			$page .= "<OPTION SELECTED value='Aucun'>Aucun</option>";
		}
			
		$page .= "
								</select>
							</td>
						</tr>
					</table>
					<br>
					<br>
					<b>Texte externe. (Fonctionne avec HTML) :</b>
					<br>
					<TEXTAREA cols='50' rows='12'  type='text' name='texte_externe' >".$row['texte_externe']."</TEXTAREA>
					<br>
					<br>
					<b>Texte Interne. (Fonctionne avec HTML) :</b>
					<br>
					<TEXTAREA cols='50' rows='12'  type='text' name='texte_interne' >".$row['texte_interne']."</TEXTAREA>
					<br>
					<br>
					<br>
					<b>Candidature. :</b>
					<br>
					<TEXTAREA cols='50' rows='12'  type='text' name='candidature' >".$row['candidature']."</TEXTAREA>
					<br>
					<br>
					<br>
					<input type='submit' value='Mettre à jour alliance'>
					</form>
				 ";
		
	break;
	
	/**************************************************************************\
	|**************************************************************************|
	\**************************************************************************/
	
	default :
	
		//### Dans le cas ou le joueur a demandé a changer le ombre de points necessaire pour créer une alli ###\\
		if(@$_POST['points'] != '' )
		{
			$sql->update('UPDATE '.PREFIXE_TABLES.TABLE_CONFIG.' SET 
					 							 config_value="'.$_POST['points'].'"
					 		        WHERE config_name="pointalli"
					       ');
		
			// On supprime le fichier du cache
			unlink('cache/controlrow');
	
			// On modifie la variable pour ne pas erroné l'affichage de la page
			$controlrow['pointalli'] = $_POST['points'];
		}

		//### On affiche la page par default ###\\

		$page .= "
					<table valign='middle' align='center' >
						<tr>
							<td valign='middle' align='center'>
								<form method='post' action='?mod=alliances'> 
									Nombre de points necessaires pour creer une alliance :  
							</td>
							<td valign='middle' align='center'>
									<INPUT name='points' value='".$controlrow['pointalli']."' size='5'> 
									<Input type='submit' value='Enregistrer'>
								</form>
							</td>
						</tr>
					</table>
					<br>
					<a href='?mod=alliances&action=liste'>Affichez la liste des alliances</a>

					<br>
					<br>
					<br>
					<br>
					<center>
					<img src='admin/tpl/icons/retour.gif.png'> <a href='?mod=default'>Retour</a></center>
				   ";

	break;

	//**************************************************************************\\


} // fin switch get action


?>