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
	
	case 'logs_joueurs' :
	
		$page .= "
					<img src='admin/tpl/icons/4561.gif'><br><font color='red'>
					Cette partie vous indique la date de dernière connexion des joueurs.<br>
					</font>
					<br>
					<table border='1' cellpadding='0' cellspacing='0' align = 'center' Bgcolor = '#7799FF'>
					<tr>
					<td align = 'center' Bgcolor = 'darkorange' width = '155'><b>Nom</b></td>
					<td align = 'center' Bgcolor = 'darkorange' width = '155'><b>Derniere connexion</b></td>
					</tr>					
				 ";

		// On recupere les dernieres connexion des joueurs classé par connexions
		$joueurs = $sql->query("SELECT nom, onlinetime FROM ".PREFIXE_TABLES.TABLE_USERS." ORDER BY onlinetime DESC");

		while($row = mysql_fetch_array($joueurs) )
		{
			$page .= "
						<tr>
							<td align = 'center' width = '155' Bgcolor = 'yellow'>".$row['nom']."</td>
							<td align = 'center' width = '155' Bgcolor = 'yellow'>".$row['onlinetime']."</td>
						</tr>
					 ";
		}
		
		$page .="</table><br><br><center><img src='admin/tpl/icons/retour.gif.png'> 
				 <a href='?mod=joueurs'>Retour</a></center>
				";
	break;

	/**************************************************************************\
	|**************************************************************************|
	\**************************************************************************/
		
	case 'liste_ips' :
	
		$page = "

					<center><table valign='center' border = '0' Width = '500'><tr><td WIDTH ='105'><br><table valign='center' border = '0' Width = '500'><tr><td align = 'center' >
					<img src='admin/tpl/images/4561.gif'><br><font color='red'>
					Cette partie recense les adresses ip des joueurs se connectant sur votre jeu.<br>
					Pour être en règle vis à vis de la loie française, votre jeu doit être déclaré a la CNIL.
					</font></td></tr></table><br></center><br>

					<table border='1' cellpadding='0' cellspacing='0' align = 'center' width = '100%'>
					<tr Bgcolor = '#7799FF'>

					<th align = 'center' width = '120'><center>Nom</center></th>
					<th align = 'center' width = '120'><center>Mail</center></th>
					<th align = 'center' width = '120'><center>IP</center></td>
					<th align = 'center' width = '120'><center>Last connexion</center></th>

					</tr>
				";

		$ips = $sql->query('SELECT nom, mail, ip, onlinetime FROM '.PREFIXE_TABLES.TABLE_USERS.' ORDER BY ip ');


		// Recuperation des resultats
		while($row = mysql_fetch_array($ips) )
		{

			$page .= "
						<table border='1' cellpadding='0' cellspacing='0' align = 'center' width = '100%'>

						<tr>\n
						<td align = 'center' width = '120' Bgcolor = '#99CC55'><center>".$row['nom']."</center></td>\n
						<td align = 'center' width = '120'><center><a href='mailto:".$row['mail']."'>".$row['mail']."</a></center></td>\n
						<td align = 'center' width = '120'><center><a href='?mod=multicompte&action=voir&ip=".$row['ip']."'>".$row['ip']."</a></center></td>\n
						<td align = 'center' width = '120'><center>".$row['onlinetime']."</center></td>\n
						</tr>\n
						</tr>

						</table>
			         ";
		}
		
	break;
	
	/**************************************************************************\
	|**************************************************************************|
	\**************************************************************************/
	
	case 'piloris' : // Affichage du piloris
		
		// Le piloris a été créer a la base par Nummi pour le jeu, modifier et optimisé pour l'administration par Max485
		
		$page .= "<center><h2><u>Liste des joueurs bannis</u></h2>";

		$joueurs_bannis = $sql->query("SELECT nom, motifbanni, time_bannis FROM ".PREFIXE_TABLES.TABLE_USERS." WHERE banni='1' and (time_bannis='0' or time_bannis>".time().") ") ;

		if(mysql_num_rows($joueurs_bannis) <= 0) // On test si une ligne est renvoyé sinon on marque que personne n'est bannis
		{
			$page .= "<img border='0' src='admin/tpl/images/456.gif'><h4>Personne n'a été bannis</h4>
					  <br>
					  <br>
					  <br>
					  <img src='admin/tpl/icons/retour.gif.png'>
					  <a href='?mod=joueurs'>Retour</a>
					 ";
		}
		elseif(mysql_num_rows($joueurs_bannis) > 0) // Dans le cas ou des joueurs ont été bannis
		{
			$page .= "
						<table border='1' width='450'><tr><th>Pseudo</th><th>Motif</th><th>Fin du blocage</th></tr>
					";

			while ($joueur_banni = mysql_fetch_array ($joueurs_bannis) ) 
			{
				$page.= "
						<tr>
							<td align='center'>
								".$joueur_banni['nom']."
							</td>
							<td align='center'>
								".$joueur_banni['motifbanni']."
							</td align='center'>
							<td align='center'>
								".( ($joueur_banni['time_bannis'] == '0')?'Banni à vie':date('d/m/Y \à H \H i',$joueur_banni['time_bannis']) )."
							</td>
						</tr>
						";
			}
		
			$page .= '</table></center>' ;

		}

	break;
	
	/**************************************************************************\
	|**************************************************************************|
	\**************************************************************************/
	
	case 'supprimer_joueurs_options': // Permet de supprimer des joueurs inactif,  on n'ayant jamais valider leur inscription, large choix d'options sur la page - Codé par Max485
		
		$page .= "
					<h3>Bienvenue dans le Mod de suppression des joueurs inactif &/OU n'ayant jamais validé leur inscription</h3>
					<br>
					<a href='?mod=joueurs&action=supprimer_joueurs_options&choix=voir_non_valide'>Cliquer ici pour voir les joueurs n'ayant pas validé</a>
					<br><br>
					<a href='?mod=joueurs&action=supprimer_joueurs_options&choix=voir_inactif'>Cliquer ici pour voir les joueurs inactifs</a>
					<br><br>
					<a href='?mod=joueurs&action=supprimer_joueurs_options&choix=supprimer_all_non_valide'>Si vous desirez supprimer tous les joueurs non valide, cliquer ici</a>
					<br><br>
					<a href='?mod=joueurs&action=supprimer_joueurs_options&choix=supprimer_all_inactifs'>Si vous desirer supprimer les tous joueurs inactifs, Cliquer ici</a>
					<br><br>
					En cas de demande de suppression de joueurs, il vous sera demander d'indiquer une date, <br>ce qui permetta de ne pas supprimer les joueurs qui vous penser pas perdu ...
					<br>
					<br>
					<hr>
					<br>
				 ";

		switch(@$_GET['choix'])
		{ // debut switch get choix
			
			case 'voir_non_valide' :
			
				$non_valide_all = $sql->query("SELECT id, valide, time FROM ".PREFIXE_TABLES.TABLE_USERS." WHERE valide != '1' ");
				
				if(mysql_num_rows($non_valide_all) <= 0) // Dans le cas ou il n'y a pas de joueur de non valide
				{
					$page .= '
								<img border="0" src="admin/tpl/images/456.gif">
								<br>
								Tous les joueurs on bien validé leur inscriptions
								<br>
								<br>
								<br>
							 ';				
						}
				elseif(mysql_num_rows($non_valide_all) > 0) // Dans le cas ou il y a des joueur de non valide
				{
					$page .= "
								<table border='1' width='400'>
									<tr>
										<th>Nom</th>
										<th>Inscrit le</th>
										<th>Action</th>
									</tr>
							 ";
						 
					while ($non_valide = mysql_fetch_array($valide2) ) 
					{
						$page .= "
									<tr>
										<td align='center'>
											<a href='?mod=joueurs&action=modifier&joueur=".$non_valide['id']."'>
												".$non_valide['nom']."
											</a>
										</td>
										<td>
											".date('d/m/Y \à H \H i \M\i\n s', $non_valide['time'])."
										</td>
										<td>
											<a href='?mod=joueurs&supprimer=".$valide['id']."'>
												<img border='0' width='10' title='Supprimer le joueur' src='admin/tpl/icons/1591.gif'>
											</a>
										</td>
									</tr>
								 ";

					}
					
					$page .= '</table>';
					
				}

			break;
			
			/*########################################*\
			|*########################################*|
			\*########################################*/
			
			case 'voir_inactif' : // Pour voir les joueurs inactif
				
				// On affiche le formulaire permettant de determiner le temps pour definir un joueur vraiment inactif
				$page .= "
							Vous determiné les joueurs inactif ceux ne s'etant pas connecté depuis combien de temps?? (En secondes)
							<br>
							<form action='?mod=joueurs&action=supprimer_joueurs_options&choix=voir_inactif' method='post'>
								<input id='temps' type='text' name='temps' value='".@$_POST['temps']."'>
								<input type='submit' name='submit' value='Continuer'>
							</form>
							<br><a class='url_curseur' onclick='document.getElementById(\"temps\").value=\"86400\";'>24 Heures</a>
							<br><a class='url_curseur' onclick='document.getElementById(\"temps\").value=\"604800\";'>7 Jours</a>
							<br><a class='url_curseur' onclick='document.getElementById(\"temps\").value=\"1209600\";'>2 Semaines</a>
							<br><a class='url_curseur' onclick='document.getElementById(\"temps\").value=\"2592000\";'>1 Mois</a>
							<br><a class='url_curseur' onclick='document.getElementById(\"temps\").value=\"31104000\";'>1 Ans</a>
							<br>
							<hr>
							<br>
						 ";

				if(isset($_POST['temps']) ) // Dans le cas ou le formulaire a deja été envoyé au moins une fois, on affiche les inactifs avec le temps demandé
				{ // debut if isset post temps
				
					$time_post = time() - $_POST['temps'] ; 
					
					// On recupere les inactifs dans la BDD				
					$inactifs = $sql->query("SELECT nom, time, id FROM ".PREFIXE_TABLES.TABLE_USERS." WHERE valide='1' AND time <= '".$time_post."' ");
					
					$page .= "
								<br>
								Vous avez demandé a voir les joueurs etant inactifs depuis : 
					            ".floor($_POST['temps'] / 60)." Min ".($_POST['temps'] % 60)."
								<br>
								Soit depuis le ".date('d/m/Y \à H \H i \m\i\n s',$time_post)."
								<br>
								<br>
							 ";
							 
					if(mysql_num_rows($inactifs) <= 0) // Dans le cas ou il ny a pas de joueur inactif sur le jeu
					{
					$page .= '
								<img border="0" src="admin/tpl/images/456.gif">
								<br>
								Il n\' y a pas de joueurs inactifs
								<br>
								<br>
								<br>
							 ';							
					}
					elseif(mysql_num_rows($inactifs) > 0) // Dans ce cas il y a des joueurs inactif sur le jeu
					{
						$page .= "
									<table border='1' width='500'>
										<tr>
											<th>Pseudo</th>
											<th>Inactif depuis le</th>
											<th>Action</th>
										</tr>
								 ";
					

						while ($inactif = mysql_fetch_array($inactifs) )
						{
							$page .= "
									<tr>
										<td align='center'>".$inactif['nom']."</td>
										<td align='center'>".date('d/m/Y \à H \H i \m\i\n s',$inactif['time'])."</td>
										<td align='center'>
											<a href='?mod=joueurs&supprimer=".$inactif['id']."'>
												<img border='0' width='10' title='Supprimer le joueur' src='admin/tpl/icons/1591.gif'>
											</a>
										</td>
									</tr>
									 ";
						}
						
						$page .= '</table>
								 ';
					}
				
				} // fin if isset post temps
				
			break;
			
			/*########################################*\
			|*########################################*|
			\*########################################*/
						
			case 'supprimer_all_non_valide' :
			
				// On affiche le formulaire permettant de determiner le temps apres lequel les joueurs doivent etre virer
				$page .= "
							Vous determiné les joueurs n'ayant pas validé, qui ne viendront jamais, 
							les joueurs s'etant inscrit il y a ?? (En secondes)							<br>
							<form action='?mod=joueurs&action=supprimer_joueurs_options&choix=supprimer_all_non_valide' method='post'>
								<input id='temps' type='text' name='temps' value='".@$_POST['temps']."'>
								<input type='submit' name='submit' value='Continuer'>
							</form>
							<br><a class='url_curseur' onclick='document.getElementById(\"temps\").value=\"86400\";'>24 Heures</a>
							<br><a class='url_curseur' onclick='document.getElementById(\"temps\").value=\"604800\";'>7 Jours</a>
							<br><a class='url_curseur' onclick='document.getElementById(\"temps\").value=\"1209600\";'>2 Semaines</a>
							<br><a class='url_curseur' onclick='document.getElementById(\"temps\").value=\"2592000\";'>1 Mois</a>
							<br><a class='url_curseur' onclick='document.getElementById(\"temps\").value=\"31104000\";'>1 Ans</a>
							<br>
							<hr>
							<br>
						 ";
						
				// On informe le nombre de joueurs etant dans le cas demandé, apres avoir posté le formulaire
				if(@$_POST['temps'] != '' )
				{
					$time_post = time() - ($_POST['temps']) ;
					
					// On recupere le nombre de joueurs n'ayant pas validé
					$nb_non_valide = $sql->select1("SELECT COUNT(id) FROM ".PREFIXE_TABLES.TABLE_USERS." WHERE valide != '1' AND time <= '".$time_post."' ");

					$page .= "
								Vous avez demandé a supprimer les joueurs n'ayant pas validé leur compte depuis : 
					            ".floor($_POST['temps'] / 60)." Min ".($_POST['temps'] % 60)."<br>
								Soit depuis le ".date('d/m/Y \à H \H i \m\i\n s',$time_post)."
								<br>
								<br>
								Il y a ".$nb_non_valide." joueurs correspondant a ce cas
								<br>
								<br>
								Voulez-vous continuer ?? 
								<br>
								Si vous confirmer, l'effet sera immediat et ne pourra plus être annulé (A part par un backup eventuelle de la BDD)
								<br>
								<br>
								<a href='?mod=joueurs&action=supprimer_joueurs_options&choix=supprimer_all_non_valide&supprimer=".$time_post."&validation=OUI'>OUI</a>
								-
								<a href='?mod=joueurs&action=supprimer_joueurs_options&choix=supprimer_all_non_valide&supprimer=".$time_post."&validation=NON'>NON</a>
							 ";
				}
				elseif(!empty($_GET['supprimer']) ) // Dans le cas ou la confirmation a eu lieu on la traite
				{ // debut elseif !empty get supprimer
					// $GET['supprimer'] contient le temps de suppression
					
					if($_GET['validation'] == 'NON') // Finalement on les supprime pas
					{
					$page .= 'Les joueurs n\'ont pas été supprimé';
					}
					elseif($_GET['validation'] == 'OUI') // La confirmation de suppression a eu lieu on les vire
					{ // debut elseif validation oui
						
						// On recupere les joueur n'ayant pas valider depuis le temps x defini dans $GET['supprimer']
						$all_non_valide = $sql->query("SELECT id, bases, nom FROM ".PREFIXE_TABLES.TABLE_USERS." WHERE valide != '1' AND time <= '".$_GET['supprimer']."' ");
						
						while ($non_valide = mysql_fetch_array($all_non_valide) )
						{
							
							$sql->update("DELETE FROM ".PREFIXE_TABLES.TABLE_USERS." WHERE id='".$non_valide['id']."' ");

							// On recuperes les base du joueurs
							$bases = explode(",", $non_valide['bases']);
							
							foreach($bases AS $base) // On supprime les bases, etant donnée que le joueur n'a jamais validé, dans ce cas il ne doit avoir qu'une seule base, voir pas du tous
							{
								$sql->update('DELETE FROM '.PREFIXE_TABLES.TABLE_BASES.' WHERE id="'.$base.'" ');
							}
	
							$page .= "Vous avez bien supprimé le joueur ".$non_valide['nom'].'<br>';
						}
					
					$page .= '<br><font color="red">Tous les joueurs n\'ayant pas validé apres le '.date('d / m / Y \à H \H\e\u\r\e\s i \M\i\n', $_GET['supprimer']).' ont bien été supprimé</font>';

					} // fin elseif validation oui
				
				} // fin elseif !empty get supprimer

			break;

			/*########################################*\
			|*########################################*|
			\*########################################*/
			
			case 'supprimer_all_inactifs' :

				// On affiche le formulaire permettant de determiner le temps apres lequel les joueurs doivent etre virer
				$page .= "
							Vous determiné les joueurs inactifs, qui ne viendront jamais, 
							les joueurs s'etant inscrit il y a ?? (En secondes)
							<br>
							<form action='?mod=joueurs&action=supprimer_joueurs_options&choix=supprimer_all_inactifs' method='post'>
								<input id='temps' type='text' name='temps' value='".@$_POST['temps']."'>
								<input type='submit' name='submit' value='Continuer'>
							</form>
							<br><a class='url_curseur' onclick='document.getElementById(\"temps\").value=\"86400\";'>24 Heures</a>
							<br><a class='url_curseur' onclick='document.getElementById(\"temps\").value=\"604800\";'>7 Jours</a>
							<br><a class='url_curseur' onclick='document.getElementById(\"temps\").value=\"1209600\";'>2 Semaines</a>
							<br><a class='url_curseur' onclick='document.getElementById(\"temps\").value=\"2592000\";'>1 Mois</a>
							<br><a class='url_curseur' onclick='document.getElementById(\"temps\").value=\"31104000\";'>1 Ans</a>
							<br>
							<hr>
							<br>
						 ";
		
				// On informe le nombre de joueurs etant dans le cas demandé, apres avoir posté le formulaire
				if(@$_POST['temps'] != '' )
				{
					$time_post = time() - ($_POST['temps']) ;
					
					// On recupere le nombre de joueurs inactifs depuis le temps demandé
					$nb_inactifs = $sql->select1("SELECT COUNT(id) FROM ".PREFIXE_TABLES.TABLE_USERS." WHERE valide = '1' AND time <= '".$time_post."' ");

					$page .= "
								Vous avez demandé a supprimer les joueurs inactifs depuis : 
					            ".floor($_POST['temps'] / 60)." Min ".($_POST['temps'] % 60)."<br>
								Soit depuis le ".date('d/m/Y \à H \H i \m\i\n s',$time_post)."
								<br>
								<br>
								Il y a ".$nb_inactifs." joueurs correspondant a ce cas
								<br>
								<br>
								Voulez-vous continuer ?? 
								<br>
								Si vous confirmer, l'effet sera immediat et ne pourra plus être annulé (A part par un backup eventuelle de la BDD)
								<br>
								<br>
								<a href='?mod=joueurs&action=supprimer_joueurs_options&choix=supprimer_all_inactifs&supprimer=".$time_post."&validation=OUI'>OUI</a>
								-
								<a href='?mod=joueurs&action=supprimer_joueurs_options&choix=supprimer_all_inactifs&supprimer=".$time_post."&validation=NON'>NON</a>
							 ";
				}
				elseif(!empty($_GET['supprimer']) ) // Dans le cas ou la confirmation a eu lieu on la traite
				{ // debut elseif !empty get supprimer
					// $GET['supprimer'] contient le temps de suppression
					
					if($_GET['validation'] == 'NON') // Finalement on les supprime pas
					{
					$page .= 'Les joueurs n\'ont pas été supprimé';
					}
					elseif($_GET['validation'] == 'OUI') // La confirmation de suppression a eu lieu on les vire
					{ // debut elseif validation oui
						
						// On recupere les joueur inactifs depuis le temps x defini dans $GET['supprimer']
						$all_inactifs = $sql->query("SELECT id, bases, nom FROM ".PREFIXE_TABLES.TABLE_USERS." WHERE valide = '1' AND time <= '".$_GET['supprimer']."' ");
						
						while ($all_inactif = mysql_fetch_array($all_inactifs) )
						{
							
							$sql->update("DELETE FROM ".PREFIXE_TABLES.TABLE_USERS." WHERE id='".$all_inactif['id']."' ");

							// On recuperes les base du joueurs
							$bases = explode(",", $all_inactif['bases']);
							
							foreach($bases AS $base) // On supprime les bases, etant donnée que le joueur n'a jamais validé, dans ce cas il ne doit avoir qu'une seule base, voir pas du tous
							{
								$sql->update('DELETE FROM '.PREFIXE_TABLES.TABLE_BASES.' WHERE id="'.$base.'" ');
							}
	
	
							// On supprime les notes du joueur
						    $sql->update("DELETE FROM ".PREFIXE_TABLES.TABLE_NOTES." WHERE iduser='".$all_inactif['id']."' ");
							
							// Si le joueurs avait posté une candidature on la supprime
						    $sql->update("DELETE FROM ".PREFIXE_TABLES.TABLE_ALLIANCES_CANDIDATURES." WHERE idjoueur='".$all_inactif['id']."' ");
							
							// Si le joueurs avait des amis, on vire les amis on la demande avait été faite par le joueur et ceut on la demande avait été faite par son ami
						    $sql->update("DELETE FROM ".PREFIXE_TABLES.TABLE_AMIS." WHERE sender='".$all_inactif['id']."' or owner='".$all_inactif['id']."' ");

							$page .= "Vous avez bien supprimé le joueur ".$all_inactif['nom'].'<br>';
						}
					
					$page .= '<br><font color="red">Tous les joueurs n\'ayant pas validé apres le '.date('d / m / Y \à H \H\e\u\r\e\s i \M\i\n', $_GET['supprimer']).' ont bien été supprimé</font>';

					} // fin elseif validation oui
				
				} // fin elseif !empty get supprimer

			break;
			
			/*########################################*\
			|*########################################*|
			\*########################################*/
			
		} // fin switch get choix
		
		$page .= '<br><br><img src="admin/tpl/icons/retour.gif.png"> <a href="?mod=joueurs">Retour</a>';

	break;

	/**************************************************************************\
	|**************************************************************************|
	\**************************************************************************/
		
	case 'modifier' : // pour toute demande de modification de joueurs
	
		// On recupere les infos du joueur selectionné
		$row = $sql->select("SELECT * FROM ".PREFIXE_TABLES.TABLE_USERS." WHERE id='" . $_GET["joueur"] . "' LIMIT 1");

		// On recupere la date de fin de bannissement
		if($row['banni'] == '0') // Dans ce cas le joueur n'est pas banni
		{
			$date_fin_bannis = 'non banni';
		}
		elseif($row['banni'] == '1' && $row['time_bannis'] == '0') // Dans ce cas le joueur est banni, et a vie
		{
			$date_fin_bannis = 'banni a vie';
		}
		elseif($row['banni'] == '1'&& $row['time_bannis'] != '0') // Dans ce cas le joueur est banni, et ce pour uen durée limité
		{
			$date_fin_bannis = 'jusqu\'au '.date('d/m/y à H:i:s', $row['time_bannis']);
		}
		
		// On recupere le nom de l'alliance du joueur, si il n'en possede pas alors on le precise
		$alli = $sql->select1("SELECT nom FROM ".PREFIXE_TABLES.TABLE_ALLIANCES." WHERE id='" . $row['alli'] . "' LIMIT 1");
		if($alli == '') // Le joueur ne possede pas d'alliance
		{
			$alli = 'Aucune alliance';
		}
		
		// On recupere le nom du rang du joueur
		$race = $controlrow['race_'.$row['race']];

		$page .= "
					<form method='post' action='?mod=joueurs&envoyemodif=" . $_GET["joueur"] . "'>
					<table align = 'center' border = '0'>
						<tr>
							<td colspan='2' align='center'>
								<u>Edition Joueur</u>
							</td>
						</tr>
						<tr>
							<td>Nom : </td>
							<td><input type='text' name='nom' value='" . $row["nom"] . "'></td>
						</tr>
						<tr>
							<td>Changer le pass : </td>
							<td><input type='password' name='pass1' value=''></td>
						</tr>
						<tr>
							<td>Reecrire pass : </td>
							<td><input type='password' name='pass2' value=''></td>
						</tr>
						<tr>
							<td>Code de validation (mettez 1 pour valider manuellement) : </td>
							<td><input type='text' name='valide' value='" . $row["valide"] . "'></td></tr>
						<tr>
							<td>Ajouter des points AlloPass (Le joueur en possede actuelement ".$row['allopass'].")</td>
							<td><input type='text' name='allopass_sup' value=''></td>
						</tr>
						<tr>
							<td>Ajouter des crédits : (Credits actuel => " . $row["credits"] . ")</td>
							<td><input type='text' name='credits_sup' value=''></td>
						</tr>
						<tr>
							<td>Banni : </td>
							<td>".select("banni")."</td>
						</tr>
						<tr>
							<td>Banni pour combien de temps (mettre en secondes) (Actuellement ".$date_fin_bannis.") 
							<br> (
							Pour banir a vie mettez 0. Laissez le champ vide pour ne pas changer)</td>
							<td><input type='text' name='temps_banni'></td>
						</tr>
						<tr>
							<td>Multicompte N°1 (Ecrire le/les pseudos) : </td>
							<td><input type='text' name='multi' value='" . $row["multi"] . "'></td>
						</tr>
						<tr>
							<td>Multicompte N°2 (Ecrire le/les pseudos) : </td>
							<td><input type='text' name='multi2' value='" . $row["multi2"] . "'></td>
						</tr>
						<tr>	
							<td>Motif du ban : </td>
							<td><input type='text' name='motifbanni' value='" . $row["motifbanni"] . "'></td>
						</tr>
					</table>
					<br>
					<center><input type='submit' value='Valider'></center>
					</form>
					<br>
					<br>
					<br>
					<u>Informations Joueur</u>
					<br>
					<br>
					<table border='1' cellpadding='0' cellspacing='0' align = 'center' width = '100%'>
						<tr Bgcolor = '#7799FF'>
							<th width = '125'>Mail</th>
							<th width = '125'>Derniere connexion</th>
							<th width = '125'>Points</th>
							<th width = '125'>Race</th>
							<th width = '125'>IP</th>
							<th width = '125'>Alliance</th>
							<th width = '125'>Fondateur</th>
							<th width = '125'>Avatar</th>
						</tr>
						<tr>
							<td align = 'center' width = '125'><a href='mailto:".$row['mail']."'>".$row['mail']."</a></td>
							<td align = 'center' width = '125'>".$row['onlinetime']."</td>
							<td align = 'center' width = '125'>".number_format($row['points'], 0, '.', '.')."</td>
							<td align = 'center' width = '125'>$race</td>
							<td align = 'center' width = '125'><a href='?mod=multicompte&action=voir&ip=".$row['ip']."'>".$row['ip']."</a></td>
							<td align = 'center' width = '125'>$alli</td>
							<td align = 'center' width = '125'>".( ($row['admin_alli'] == '1')?'OUI':'NON')."</td>
							<td align = 'center' width = '125'><a href='".$row['avatar']."'><img width='20px' src='".$row['avatar']."'</a></td>
						</tr>
					</table>
					<br>
					<br>
					<center><img src='admin/tpl/icons/retour.gif.png'> 
					<a href='?mod=joueurs'>Retour</a></center>
				 ";
		
	break;

	/**************************************************************************\
	|**************************************************************************|
	\**************************************************************************/
	
	default : // Page affiché par default, listant tous les joueurs, et affichant les options disponibles
	
		if(!empty($_GET['envoyemodif']) ) // Dans le cas ou on a envoyer une modification pour un joueur
		{ // debut if modifier joueur
			
			// $_GET['envoyemodif'] contient l'id du joueur a modifier
			
			if($_POST['temps_banni'] != '') // Dans le cas ou le joueur a saisi un temps de bannissement
			{
				if($_POST['temps_banni'] != '0') // Si la saisi est differente de 0 alors on ajoute la saisi avec le temps actuelle
				{
					$time_bannis = $_POST['temps_banni'] + time();
				} 
				else // Dans le cas ou ca equivaut a 0, on laisse 0, car cela veut dire que le joueur est bannis a vie
				{ 
					$time_bannis = "0"; 
				}
			}
			else // Si le joueur n'a pas defini de temps de blocage on ne le change pas
			{
				$time_bannis = $sql->select1('SELECT time_bannis FROM '.PREFIXE_TABLES.TABLE_USERS.' WHERE id="'.$_GET['envoyemodif'].'" ');
			}
			
			// Si la fin de bannissement d'une personne est arrivé, on modifie les valeurs des champ de bannissement
			if($_POST['banni'] == '0' || ( $time_bannis < time() && $time_bannis != '0' ) ) 
			{
				$_POST['motifbanni'] = 'Non banni';
				$time_bannis = 0 ;
				$_POST['banni'] = '0' ;
			}

			//Dans le cas ou on a demander a ajouter des points allopass au joueur
			if($_POST['allopass_sup'] != '')
			{
				// on recupere le nombre de points qu'il possede et on les ajoute on nombre de point saisi a ajouter
				$points_allopass = $sql->select1('SELECT allopass FROM '.PREFIXE_TABLES.TABLE_USERS.' WHERE id="'.$_GET['envoyemodif'].'" ') 
								   + $_POST['allopass_sup'] ;
			}

			// Rajout de Credit a un joueur (On prend les anciens credit, plus les credit que l'admin a voulu rajouter au joueur
			$new_credits = $sql->select1('SELECT credits FROM '.PREFIXE_TABLES.TABLE_USERS.' WHERE id="'.$_GET['envoyemodif'].'" ') 
						  + $_POST['credits_sup'] ;
			
			// On insere les infos dans MySQL
			$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_USERS." SET
								nom='" . $_POST['nom'] . "',
						 ".( ($_POST['pass1'] != '' && $_POST['pass1'] == $_POST['pass2'])?" pass='".md5($_POST['pass1'])."', ": '')."
								valide='" . $_POST['valide'] . "',
								banni='" . $_POST['banni'] . "',
								multi='" . $_POST['multi'] . "',
								multi2='" . $_POST['multi2'] . "',
								motifbanni='" . $_POST['motifbanni'] . "',
								time_bannis='".$time_bannis."'
					     ".( ($_POST['allopass_sup'] != '')?", allopass='".$points_allopass."'":'')."
					     ".( ($_POST['credits_sup'] != '')?", credits='".$new_credits."'":'')."
								WHERE id='" . $_GET['envoyemodif'] . "'
						 ");

			$page .= "<img src='admin/tpl/icons/accept.png'> L'enregistrement à été effectué avec succès.<br><br><hr><br>";

		} // fin if modifier joueur
		#################################################################################

		if (!empty($_GET['supprimer']) ) // Si on demande a virer un joueur
		{ // debut if supprimer joueur
		
			// $_GET['supprimer'] contient l'id du joueur a virer
			
			if(empty($_GET['validation']) ) // Dans le cas ou aucune confirmation a été posté, on affiche le formulaire
			{
				$page .= "Voulez vous vraiment supprimer ce joueur ?
							 <br>
							 <br>
							 <a href='?mod=joueurs&supprimer=" . $_GET['supprimer'] . "&validation=OUI'>
							 	OUI
							 </a> 
							 - 
							 <a href='?mod=joueurs&supprimer=" . $_GET['supprimer'] . "&validation=NON'>
							 	NON
							 </a>
							 <br>
							 <hr>
							 <br>
							";
			}
			elseif($_GET['validation'] == 'NON') // Dans le cas ou on veut plus virer le joueur
			{
				$page .= 'Le joueur n\'a pas été supprimée<br><hr><br>';
			}
			elseif($_GET['validation'] == 'OUI') // Dans le cas ou le joueur veut vraiment virer le joueur
			{
				// On supprime le joueur et on detruit son existance dans toutes les tables
				
				// On recuperes les bases du joueur
				$bases = $sql->select1("SELECT bases FROM ".PREFIXE_TABLES.TABLE_USERS." WHERE id='".$_GET["supprimer"]."' ");
				
				// On supprime le joueur de la table des joueurs
				$sql->update("DELETE FROM ".PREFIXE_TABLES.TABLE_USERS." WHERE id='".$_GET["supprimer"]."' ");
				
				// On extrait les basses du joueurs
				$bases_explode = explode(",", $bases);
				
				foreach($bases_explode as $base) // On créer une boucle 
				{	
					// On supprime chaque bases
					$sql->update('DELETE FROM '.PREFIXE_TABLES.TABLE_BASES.' WHERE id="'.$base.'" ');
				}

				// on supprime les notes du joueur
			    $sql->update("DELETE FROM ".PREFIXE_TABLES.TABLE_NOTES." WHERE iduser='".$_GET["supprimer"]."' ");
				
				// Si le joueurs avait posté une candidature on la supprime
			    $sql->update("DELETE FROM ".PREFIXE_TABLES.TABLE_ALLIANCES_CANDIDATURES." WHERE idjoueur='".$_GET["supprimer"]."' ");
				
				// Si le joueurs avait des amis, on vire les amis on la demande avait été faite par le joueur et ceut on la demande avait été faite par son ami
			    $sql->update("DELETE FROM ".PREFIXE_TABLES.TABLE_AMIS." WHERE sender='".$_GET["supprimer"]."' or owner='".$_GET["supprimer"]."' ");

				$page .= 'Le joueur a bien été supprimé<br><br><hr><br>';
    		}
		} // fin if supprimer joueur

		#################################################################################

		//### Affiche la liste des joueurs ###\\
		
		$joueurs = $sql->query("SELECT * FROM ".PREFIXE_TABLES.TABLE_USERS." ORDER BY nom"); // Recupere la liste des joueurs trié par nom
		
		$page .= "
					<a href='?mod=joueurs&action=piloris'>Voir la liste des joueurs bloqués</a>
					<br>
					<br>
					<a href='?mod=joueurs&action=supprimer_joueurs_options'>
						Supprimer les joueurs Inactifs &/OU n'ayant pas validé leurs inscription
					</a>
					<br>
					<br>
					<hr>
					<br>
				 ";
		
		if(mysql_num_rows($joueurs) <= 0) // Dans le cas ou il n'existe pas de joueur dans la base de données
		{
			$page .= '
						<img border="0" src="admin/tpl/images/456.gif">
						<br>
						Il n\' existe pas de joueur dans la base de données
						<br>
						<br>
						<br>
						<img src="admin/tpl/icons/retour.gif.png"> <a href="?mod=default">Retour</a>
					 ';
		}
		elseif(mysql_num_rows($joueurs) > 0) // Il existe un ou plusieurs joueur dans la base de données
		{ // debut elseif afficher liste joueurs
			$page .=  "	
						<u>Cliquez sur un utilisateur pour l'éditer</u>: 
						<br>
						<table>
				      ";
		      
			while ($row = mysql_fetch_array($joueurs) ) 
			{
			   $page .= "
						<tr>
							<td>
								<br><a href='?mod=joueurs&supprimer=".$row['id']."'>
								<img width='10px' src='admin/tpl/icons/delete.gif.png'>
								</a>
								<img src='admin/tpl/icons/gamers.gif.png'> 
								<a href='?mod=joueurs&action=modifier&joueur=" . $row["id"] . "'>
									" . $row["nom"] . "
								</a>
							</td>
						</tr>
						";
			}

			$page .= "</table>
					  <br>
					  <br>
					  <center><img src='admin/tpl/icons/retour.gif.png'> 
					  <a href='?mod=default'>Retour</a></center>
					 ";
		
		} // fin elseif afficher liste joueurs
	break;


} // fin switch get action	
			
?>