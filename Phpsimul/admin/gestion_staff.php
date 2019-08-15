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

// On commence a créer la page
$page = '
			<center>
			<h1><u>Membres du Staff</u></h1>
		  ';
		  
switch(@$_GET['action'])
{ // debut switch get action

	case 'modifier' : // Dans le cas ou on souhaite modifier un membre
	case 'creer': // Si on souhaite créer un membre
		
		if($_GET['action'] == 'modifier') // Dans ce cas on a demander a modifier un membre existant
		{
			// On recupere le SQL du joueur
			$joueur = $sql->select('SELECT * FROM '.PREFIXE_TABLES.TABLE_STAFF.' WHERE id="'.$_GET['joueur'].'" ');
			
			$id = $joueur['id']; // Permet de faire savoir l'id du joueur a modifier au script 
			
			$titre = 'Modifier les paramètre d\'un membre'; // Defini le titre a afficher sur la page
			
			if($joueur['fondateur'] == '1' && $userrow['fondateur'] != '1') // Si il s'agit d'un simple administrateur qui veut modifier un compte d'un fondateur, alors on le bloque
			{
				die('<script>document.location="?mod=aide&error=modification_fondateur_interdite&redirection=gestion_staff"</script>'); // On redirige sur une erreur
			}
		}
		else // Dans le cas d'une creation
		{
			$id = '0'; // indique au script qu'il faut créer le joueur
			
			$joueur = $_POST; // Permet de remettre les données posté si il s'agit d'une creation
			
			$titre = 'Ajouter un membre'; // Defini le titre afficher sur la page
		}
		
		$page .= '
					<br>
					<h4><u>'.$titre.'</u></h4>

			     '.( (@$_GET['error'] == 1)?'
					<script>alert("Merci de specifier des mots de passe identiques")</script>
				 ':'')
				 .( (@$_GET['error'] == 2)?'
					<script>alert("Si vous n\'entrez pas de mot de passe pour le joueur, ca ira pas !")</script>
				 ':'')
				 .( (@$_GET['error'] == 3)?'
					<script>alert("Il est obligatoire d\'indiquer un nom")</script>
				 ':'').'
				 
					<form method="post" action="?mod=gestion_staff&envoyemodif='.$id.'">
					<table>
					<tr>
						<td>Nom InGame : </td><td><input type="text" name="idjoueur" maxlength="50" value="'.@$joueur['idjoueur'].'">
							  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Pour vous, a titre indicatif, ce champ n\'a aucune influence)
						</td>
					</tr>
					<tr>
						<td><br></td><td><br></td>
					</tr>
					<tr>
						<td>Nom : </td><td><input type="text" name="nom" maxlength="30" value="'.@$joueur['nom'].'">
					<tr>
						<td>Mot de Passe : </td><td><input type="password" name="pass1" maxlength="30"></td>
					</tr>
					<tr>
						<td>Confirmation : </td><td><input type="password" name="pass2" maxlength="30"></td>
					</tr>
					<tr>
						<td>Moderateur : </td><td>
						<select name="moderateur">
								<option value="1" '.( (@$joueur['moderateur'] == '1')?' selected':'').'>OUI</option>
								<option value="0" '.( (@$joueur['moderateur'] == '0')?' selected':'').'>NON</option>
						</select>
						</td>
					</tr>
				 '.( ($userrow['fondateur'] == '1')?'
					<tr>
						<td>Administrateur : </td><td>
						<select name="administrateur">
								<option value="1" '.( (@$joueur['administrateur'] == '1')?' selected':'').'>OUI</option>
								<option value="0" '.( (@$joueur['administrateur'] == '0')?' selected':'').'>NON</option>
						</select>
						</td>
					</tr>
					<tr>
						<td>Fondateur : </td><td>
						<select name="fondateur">
								<option value="1" '.( (@$joueur['fondateur'] == '1')?' selected ':'').'>OUI</option>
								<option value="0" '.( (@$joueur['fondateur'] == '0')?' selected ':'').'>NON</option>
						</select>
						</td>
					</tr>
				 ':'').'
					</table>
					<br>
					<input type="submit" value="Valider">
					</form>
					<br>
					<br>
		';
			
	
	break;
	
	/****************************************************************************************************\
	|****************************************************************************************************|
	\****************************************************************************************************/
	
	default :

			/*** DEBUT PARTIE MODIFICATION / CREATION D'UN MEMBRE ***/
				if(@$_GET['envoyemodif'] == '0') //  Dans ce cas l'admin a decider de créer un nouveau membre
				{ // debut if get envoyemodif pour créer membre

					extract($_POST); // On extrait la tableau post pour ecrire plus vite les variables

					if($pass1 != $pass2) // Si les passe ne correspondent pas
					{
						die('<script>document.location.href="?mod=gestion_staff&action=creer&error=1"</script>');
					}
					if($pass1 == '') // Si les mots de passe sont vide
					{
						die('<script>document.location.href="?mod=gestion_staff&action=creer&error=2"</script>');
					}
					if($nom == '') // Si aucun nom n'ont été specifier
					{
						die('<script>document.location.href="?mod=gestion_staff&action=creer&error=3"</script>');
					}
					
					// Dans le cas ou les pass sont correct et qu'un nom a été specifier, on enregistres les données dans la table SQL
					// Si celui qui tient a ajouter un nouveau membre, n'est que administrateur, alors il n'a le droit d'ajouter que des moderateurs
					$sql->update('INSERT INTO '.PREFIXE_TABLES.TABLE_STAFF.' SET
										idjoueur="'.$idjoueur.'",
										nom="'.$nom.'",
										pass="'.md5($pass1).'",
										moderateur="'.$moderateur.'",
										administrateur="'.( ($userrow['fondateur'] == 1)?$administrateur:'0').'",
										fondateur="'.( ($userrow['fondateur'] == 1)?$fondateur:'0').'"
								   ');
								   
					$page .= '<br><hr>Le joueur '.$nom.' a bien été créer<br><hr><br>';

				} // fin  if get envoyemodif pour créer membre
				##################################################
				elseif(!empty($_GET['envoyemodif']) ) // Dans le cas ou l'admin veut modifier un membre
				{ // debut if get envoye modif pour modifier membre

					// $_GET['envoyemodif'] contient l'id du membre a modifier
					
					extract($_POST); // On extrait la tableau post pour ecrire plus vite les variables

					$sql->update('UPDATE '.PREFIXE_TABLES.TABLE_STAFF.' SET 
										idjoueur="'.$idjoueur.'",
										nom="'.$nom.'",
								 '.( ($pass1 != '' && $pass1 == $pass2)?' 
										pass="'.md5($pass1).'", 
								 ':'').'
								 '.( ($userrow['fondateur'] == 1)?'
										administrateur="'.$administrateur.'",
										fondateur="'.$fondateur.'",
								 ':'').'
										moderateur="'.$moderateur.'"
									WHERE id="'.$_GET['envoyemodif'].'"
								 ');

					$page .= '<br><hr>Le joueur '.$nom.' a bien été modifié<br><hr><br>';
								 
				} // fin if get envoye modif pour modifier membre
		/*** FIN PARTIE MODIFICATION / CREATION D'UN MEMBRE ***/
		
		/*** DEBUT PARTIE SUPPRIMER UN MEMBRE DU STAFF ***/
			if (!empty($_GET["supprimer"]) ) // Dans le cas ou on demande a supprimer un membre
			{ // debut if supprimer membre
				
				// On regarde si le compte a supprimer est un compte fondateur
				$j_fondateur = $sql->select1('SELECT fondateur FROM '.PREFIXE_TABLES.TABLE_STAFF.' WHERE id="'.$_GET['supprimer'].'" ');
				if($userrow['fondateur'] != '1' && $j_fondateur == '1') // Si on rentre dans ce if, alors c'est qu'il s'agit d'un simple admin qui veut supprimer un compte fondateur
				{
					die('<script>document.location="?mod=aide&error=modification_fondateur_interdite&redirection=gestion_staff"</script>'); // On redirige sur une erreur
				}
				
				if(empty($_GET['validation']) ) // Dans le cas ou aucune confirmation a été posté, on affiche le formulaire
				{
					$page .= "<br><hr>Voulez vous vraiment supprimer ce membre ?
								 <br>
								 <br>
								 <a href='?mod=gestion_staff&supprimer=" . $_GET['supprimer'] . "&validation=OUI'>
								 	OUI
								 </a> 
								 - 
								 <a href='?mod=gestion_staff&supprimer=" . $_GET['supprimer'] . "&validation=NON'>
								 	NON
								 </a>
								 <br><hr><br>
								";
				}
				elseif($_GET['validation'] == 'NON') // Dans le cas ou le formulaire a été renvoyé, et que l'admin ne peut pas virer le membre
				{
					$page .= '<br><hr>Le membre n\'a pas été supprimer<br><hr><br>';
				}
				elseif($_GET['validation'] == 'OUI') // Dans le cas ou le joueur veut vraiment virer le membre
				{
					// On supprime l'existance de du membre dans la table des joueurs
					
					// On supprime le membre de la BDD
	    			$sql->update("DELETE FROM ".PREFIXE_TABLES.TABLE_STAFF." WHERE id='" . $_GET["supprimer"] . "'");
	    		
	    			$page .= '<br><hr>Le membre a bien été supprimé<br><hr><br>';
	    		}
			} // fin if supprimer membre
		/*** FIN PARTIE SUPPRIMER UN MEMBRE DU STAFF ***/


		// On recuperes les infos des membres existants, il existe forcement au moins un membre dans cette table sinon on ne peut pas acceder ici
		$table_staff = $sql->query('SELECT id,idjoueur,nom,fondateur,administrateur,moderateur,ip,time FROM '.PREFIXE_TABLES.TABLE_STAFF.' ORDER BY nom');
		
		$page .= '
					<br><br>
					<table border="1"> 
					<tr>
					<th align="center">Nom InGame</th>
					<th align="center">Pseudo</th>
					<th align="center">Moderateur</th>
					<th align="center">Administrateur</th>
					<th align="center">Fondateur</th>
					<th align="center">Dernière IP</th>
					<th align="center">Dernière connexion</th>
					<th align="center">Action</th>
					</tr>
				 ';

		while($rep = mysql_fetch_array($table_staff) )
		{ // debut while fetch array de $table_staff

			$page.='
				 	 <tr>
				  	 <td align="center">'.$rep['idjoueur'].'</td>
					 <td align="center">'.$rep['nom'].'</td>
					 <td align="center">'.( ($rep['moderateur'] == 1)?'OUI':'NON').'</td>
					 <td align="center">'.( ($rep['administrateur'] == 1)?'OUI':'NON').'</td>
					 <td align="center">'.( ($rep['fondateur'] == 1)?'OUI':'NON').'</td>
					 <td align="center">'.$rep['ip'].'</td>
					 <td align="center">'.date('d/m/Y H \H i : s',$rep['time']).'</td>
					 <td align="center">
						 <a href="?mod=gestion_staff&action=modifier&joueur='.$rep['id'].'">
							<img border="0" width="15" title="Modifier les paramètres du joueur" src="admin/tpl/icons/cog.png">
						 </a>
						 <a href="?mod=gestion_staff&supprimer='.$rep['id'].'">
							<img width="15" border="0" title="Supprimer ce compte" src="admin/tpl/icons/delete.gif.png">
						 </a>
					</td></tr>
				   ';
		} // fin while fetch array de $table_staff


		$page .= '
		</table>
		<br>
		<br>
		<a href="?mod=gestion_staff&action=creer"><img border="0" src="admin/tpl/icons/add.png"> Ajouter un membre</a>
		';




	break;
	
} // fin switch get action


$page .= '
			<br><br>
			<img src="admin/tpl/icons/retour.gif.png"> 
			<a href="?mod=gestion_staff">Retour</a>
		 ';


/********************************************************\
Mod Codé entieremment pour PHPSimul par Max485
Permet de rendre independant le jeu et l'administration,
pour plus de securité et pour que le modo n'agit pas
sur l'univers dans lequel il joue
\*********************************************************/


?>

