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

$page ='';

switch(@$_GET['action'])
{ // debut switch get action


	case 'creer' : // Dans le cas ou une demande pour créer une nouvelle news a été demandé
	case 'modifier': // Dans ce cas c'est une demande de modification d'une news existante
	
		if($_GET['action'] == 'modifier') // Dans le cas d'une modification
		{
			// On recupere les infos de la news a modifier
			$news = $sql->select('SELECT * FROM '.PREFIXE_TABLES.TABLE_NEWS.' WHERE id="'.$_GET['news'].'" '); 
			
			// On defini que l'id a envoyer dans la zone action du formulaire est l'id de la news
			$id = $news['id'];
			
		}
		#############################################################
		else // Dans le cas ou il s'agit d'une creation
		{
			// On defini l'id de la news a 0 ce qui permet de faire savoir au scrilt que c'est une creation
			$id = '0';
		}
		#############################################################
	   $page .= "
	   				<form method='post' action='?mod=news&envoyemodif=".$id."'>
						<table>
							<tr>
								<td align='center'>
									Titre : 
								</td>
							</tr>
							<tr>
								<td align='center'>
									<input type='text' size='67' name='titre' value='".@$news['titre']."'>
								</td>
							</tr>
							<tr>
								<td valign='top' align='center'>
									<br>
									Texte : 
								</td>
							</tr>
							<tr>
								<td align='center'>
									<textarea cols='50' rows='10' name='texte'>".@$news['texte']."</textarea>
								</td>
							</tr>
		".( ($_GET['action'] == 'creer')?"
							<tr>	
								<td align='center'>
									<br>
									Envoyer par mail ?
								</td>
							</tr>
							<tr>
								<td align='center'>
									<select name='mail'>
										<option value='1'>Oui</option>
										<option value='0' selected>Non</option>
									</select>
								</td>
							</tr>
		":'')."
							<tr>
								<td align='center'>
									<br>
									Afficher dans les flux rss ?
								</td>
							</tr>
							<tr>
								<td align='center'>
									<select name='rss'>
										<option value='1' ".( (@$news['rss'] == '1')?'selected':'').">Oui</option>
										<option value='0' ".( (@$news['rss'] == '0')?'selected':'').">Non</option>
									</select>
								</td>
							</tr>
							<tr>
								<td align='center'>
									<br>
									<input type='submit' value='Valider'>
								</td>
							</tr>
						</table>
						</form>
						<br>
						<br>
						<center><img src='admin/tpl/icons/retour.gif.png'> 
						<a href='?mod=news'>Retour</a></center>
				   ";

	break;
	
	/************************************************\
	|************************************************|
	\************************************************/
	
	case 'voir' :
	
		if (!empty($_GET['news']) ) // Dans le cas ou une news a bien été selectionné
		{
			$news = $sql->select("SELECT * FROM ".PREFIXE_TABLES.TABLE_NEWS." WHERE id='" . $_GET['news'] . "' ");

			$date = date('\L\e d / m / Y', $news['date']); // On recupere la date et on la formate
	
			$page .= "<center>
						 <b><u>" . $news["titre"] . "</b></u>
						 <br>
						 " . $date . "
						 <br>
						 <br>
						 " . $news["texte"] . "
						 <br>
						 <br>
      				 <img src='admin/tpl/icons/retour.gif.png'> 
      				 <a href='?mod=news'>Retour</a>
      				 </center>
					   ";
		}
		else // Si aucune note n'a été selectionné
		{
			$page .= 'Erreur : Vous n\'avez pas selectionné de news
						 <br>
						 Merci de recommencer
						 <br>
						 <br>
						 <a href="?mod=news">Retour</a>
						';
		}

	break;
	
	/************************************************\
	|************************************************|
	\************************************************/

	default :
	
		if(@$_GET['envoyemodif'] == '0') // Dans ce cas il s'agit d'une nouvelle nexws a créer
		{ // debut if créer news
		
			extract($_POST); // On extrait les données
			
			// On enregistre les données dans SQL
		   $sql->update("INSERT INTO ".PREFIXE_TABLES.TABLE_NEWS." SET 
		    										id='', 
		   									   titre='" . $_POST['titre'] . "', 
		   									   texte='" . $_POST['texte'] . "', 
		   									   date='" . time(). "', 
		   									   rss='" . $_POST['rss'] . "'
		   					");


			if (@$_POST['mail'] == 1) // Dans le cas ou on a demandé a l'envoyer par mail
			{
        		$mails = $sql->query("SELECT mail FROM phpsim_users WHERE id != '0' "); // On recupere le mail des joueurs
        		while ($mail = mysql_fetch_array($mails) ) 
        		{
          		mail($mail['mail'], $_POST['titre'], $_POST['texte']);
        		}
        		$page .= "Mail envoyé avec succès.<br>";
			}
			
    		$page .= "<img src='admin/tpl/images/Table_ch.gif'> News ajoutée avec succès.<br><hr><br>";
		
		} // fin if créer news
		######################################################
		elseif(!empty($_GET['envoyemodif']) ) // Dans ce cas il s'agit d'une news deja existante qui est a modifier
		{
			// $_GET['envoyemodif'] contient l'id de la news a modifier
			
			// On enregistre les modifications dans SQL
		   $sql->update("UPDATE ".PREFIXE_TABLES.TABLE_NEWS." SET 
		   									   titre='" . $_POST['titre'] . "', 
		   									   texte='" . $_POST['texte'] . "', 
		   									   date='" . time(). "', 
		   									   rss='" . $_POST['rss'] . "'
		   						WHERE id='".$_GET['envoyemodif']."'
		   					");	
		
			$page .= '<img src="admin/tpl/images/Table_ch.gif"> La news a été modifiée avec succèes<br><hr><br>';	
		}
	
		###########################################################################
		
		if(!empty($_GET['supprimer']) ) // Dans le cas ou on veut supprimer une news
		{ // debut if suppr news
		
			// $_GET['supprimer'] contient l'id de la news a supprimer
			
			if(empty($_GET['validation']) ) // Dans le cas ou aucune confirmation a été posté, on affiche le formulaire
			{
				$page .= "Voulez vous vraiment supprimer cette news ?
							 <br>
							 <br>
							 <a href='?mod=news&supprimer=" . $_GET['supprimer'] . "&validation=OUI'>
							 	OUI
							 </a> 
							 - 
							 <a href='?mod=news&supprimer=" . $_GET['supprimer'] . "&validation=NON'>
							 	NON
							 </a>
							 <br>
							 <hr>
							 <br>
							";
			}
			elseif($_GET['validation'] == 'NON') // Si on ne desire finalement pas virer la nes
			{
				$page .= 'La news n\'a pas été supprimer<br><hr><br>';
			}
			elseif($_GET['validation'] == 'OUI') // Si la news doit vraiment etre supprimer
			{
				// On supprime la news de la BDD
    			$sql->update("DELETE FROM ".PREFIXE_TABLES.TABLE_NEWS." WHERE id='" . $_GET["supprimer"] . "'");
    		
    			$page .= 'La news a bien été supprimée du jeu<br><hr><br>';
    		}
		
		} // fin if suppr news
	
		###########################################################################

		/********** Affichage des news exisante **********/
	
		// Recuperation des news existantes
		$news = mysql_query("SELECT * FROM ".PREFIXE_TABLES.TABLE_NEWS." ORDER BY date DESC ");
		
		if(mysql_num_rows($news) <= 0) // Dans le cas ou aucune news n'existe dans la base
		{
			$page .= '<img src="admin/tpl/icons/4561.gif">
						 <br>
						 Il n\'existe actuellement aucune news, créer en une :
						 <table>
						';
		}
		else // Dans le cas ou il existe des news
		{ // debut else afficher les news existante
		
			$page .= "Voici les news actuelles : <br><br><table border = '0' Width = '500'>";
	
			while ($row = mysql_fetch_array($news) ) 
			{
    			$page .= "
    						<tr>
    							<td WIDTH ='200'>
    								<img src='admin/tpl/icons/new.gif.png'> 
    								<a href='?mod=news&action=voir&news=".$row["id"]."'>
    									" . $row["titre"] . "
    								</a>
    							</td>
								<td>
									<img src='admin/tpl/icons/application_form_edit.png'>
									<a href='?mod=news&action=modifier&news=".$row["id"]."'>
										Modifier
									</a>
								</td>
								<td align ='center'>
									<img src='admin/tpl/icons/note_delete.png'>
									<a href='?mod=news&supprimer=" . $row["id"] . "'>
										Supprimer
									</a>
								</td>
							";
			}	
			
		} // fin else afficher les news existante
		
		$page .= "</table>
					 <br>
					 <img src='admin/tpl/icons/note_add.png'>
					 <a href='?mod=news&action=creer'> 
					 	Rédiger une nouvelle news.
					 </a>
					 <br>
					 <br>
					 <center><img src='admin/tpl/icons/retour.gif.png'> <a href='?mod=default'>Retour</a></center>
					";

	break;
	
} // fin swtich get action
	
?>