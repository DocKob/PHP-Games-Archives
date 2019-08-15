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

switch(@$_GET['action'])
{ // debut switch action

	####################################################################################
	//*** Modifier le titre de la PopUP permettant d'ecouter les musiques ***\\
	
	case 'modif_config' :
		
		if($_POST['modif_config'] != '' ) // On agit que si du texte a bien été saisi
		{
			// On enregistre les modification dans SQL
			$sql->update("UPDATE phpsim_config SET config_value='".addslashes($_POST['titre_lecteur_musique'])."' WHERE config_name='titre_lecteur_musique' ") ;
	
			// On supprime le cache de la config pour l'actualiser
			unlink('cache/controlrow');
	
			// On modifie le controlrow pour ne pas afficher un titre erroné du a la modification
			$controlrow['titre_lecteur_musique'] = $_POST['titre_lecteur_musique']; 

			// On affiche un commentaire pour specifier au joueur que la modif a bien eu lieu
			$error = '<hr><font color="red" size="+2">Le nouveau titre de la Pop-UP de musique 
						 est '.$_POST['titre_lecteur_musique'].'</font><br><hr><br>';
		}
	break;
	####################################################################################
	//*** Ajout d'une nouvelle chanson ***\\
	case 'ajout_chanson' :
	
		$error = ''; // On incremente la variable pour ne pas procoqué d'erreur
		
		// On verifie que tous les champs ont bien été rempli
		if($_POST['titre'] == '') 
		{
			$error .= 'Vous n\'avez pas precisez le titre<br>';
		}
		if($_POST['auteur'] == '')
		{
			$error .= 'La chanson possède forcement un auteur<br>';
		}
		if($userrow['administrateur'] == '1' || $userrow['fondateur'] == '1') // Si il s'agit d'un fondateur ou d'un administrateur
		{
			if($_POST['nom_fichier'] == '')
			{
				$error .= 'Vous devez indiquer le nom du fichier<br>';
			}
			if($_POST['extension'] == '')
			{
				$error .= 'Vous devez indiquer l\'extension du fichier de la chanson<br>';
			}
		}	
		elseif($userrow['moderateur'] == '1') // Dans le cas d'un moderateur
		{
			if(empty($_FILES['chanson']['name']) ) // Si le modo n'a pas mis le fichier a posté
			{
				$error .= "Merci de selectionner un fichier<br>";
			}
			if(!eregi('mp3',substr($_FILES['chanson']['name'],-3) ) ) 
			{
				$error .= "Seule les chansons au format MP3 son autorisé<br>";
			}
		}
		
		if($error != '') // Dans le cas ou il y a des erreurs, on met en forme
		{
			$error = '<hr><font color="red" size="+1">'.$error.'</font><hr><br>';
		}
		elseif($error == '') // Dans le cas ou il n'y a pas d'erreurs
		{
			if($userrow['administrateur'] == '1' && $userrow['fondateur'] == '1') // Dans le cas ou c'est un admin ou un fondateur
			{
				// On envoye la nouvelle chanson dans SQL
				$sql->update("INSERT INTO ".PREFIXE_TABLES.TABLE_MUSIQUE." SET 
	             					titre='".addslashes($_POST['titre'])."',
	             					extension='".addslashes($_POST['extension'])."',
	             					nom='".addslashes($_POST['nom_fichier'])."',
	             					artiste='".addslashes($_POST['auteur'])."'
	            		 	 ");
				
				unset($_POST); // Dans le cas ou la chanson a bien été envoyé on vide les données posté pour ne pas les reafficher
	        	
				// On informe le joueur que son ajout a fonctionner
				$error = '<hr><font color="red" size="+2">La chanson a bien été envoyé</font><br><hr><br>';
				
			}
			elseif($userrow['moderateur'] == '1') // Dans le cas ou il s'agit d'un  moderateur
			{
				// On copie le fichier  dans le bon dossier
				$copy = copy($_FILES['chanson']['tmp_name'],'musique/'.addslashes($_FILES['chanson']['name']) );
			
				if($copy) // Dans le cas ou le fichier a bien été envoyé
				{
					// On recupere le nom du fichier
					eregi('(.*).(.*)',$_FILES['chanson']['tmp_name'],$nom);

					// On insere dans SQL
					$sql->update("INSERT INTO phpsim_musique SET 
				             titre='".addslashes($_POST['titre'])."',
				             extension='".addslashes(substr($_FILES['chanson']["name"],-3)  )."',
				             nom='".addslashes($nom[0])."',
				             artiste='".addslashes($_POST['auteur'])."'
								 ");
					
					unset($_POST); // Dans le cas ou la chanson a bien été envoyé on vide les données posté pour ne pas les reafficher
					
		        	// On informe le joueur que son ajout a fonctionner
					$error = '<hr><font color="red" size="+2">La chanson a bien été envoyé</font><br><hr><br>';
				}
				else // Dans le cas ou le fichier a mal été envoyé
				{
					$error = '<hr><font color="red" size="+2">Probleme lors de l\'envoye de la chanson sur le FTP</font><br><hr><br>';
				}
			}
		}
	
	break;
	####################################################################################
	//*** Ajout d'une nouvelle chanson ***\\
	case 'supprimer_chanson' :
		
		if(empty($_GET['validation']) ) // Dans le cas ou aucune confirmation a été posté, on affiche le formulaire
			{
				$error = "<hr><font color='red' size='+2'>
							 Voulez vous vraiment supprimer cette chanson ?
							 <br>
							 <br>
							 <a href='?mod=musique&action=supprimer_chanson&chanson=" . $_GET['chanson'] . "&validation=OUI'>
							 	OUI
							 </a> 
							 - 
							 <a href='?mod=musique&action=supprimer_chanson&chanson=" . $_GET['chanson'] . "&validation=NON'>
							 	NON
							 </a>
							 </font><br><hr><br>
							";
			}
			elseif($_GET['validation'] == 'NON') // Dans ce cas on ne vire pas la chanson
			{
			$error = '<hr><font color="red" size="+2">La chanson n\'a pas été supprimée</font><br><hr><br>';
			}
			elseif($_GET['validation'] == 'OUI') // Dans ce cas ou vire la chanson
			{
				// On supprime l'existance de la recherche dans la table des joueurs
				
				// On supprime le batiment de la BDD
    			$sql->update("DELETE FROM ".PREFIXE_TABLES.TABLE_MUSIQUE." WHERE id='" . $_GET['chanson'] . "' ");
    		
			$error = '<hr><font color="red" size="+2">La chanson a bien été supprimée</font><br><hr><br>';
    		}

	break;
	
} // fin switch action

####################################################################################

// On recuperes les chansons existante
$musiques = $sql->query("SELECT * FROM ".PREFIXE_TABLES.TABLE_MUSIQUE." ") ;

$page = ' 
			<center><h2>Information</h2>
			<br>
			<i>Pour pouvoir ajouter une chanson à la liste de lecture, vous devez :
			<br>
			- Mettre votre chanson sur votre FTP puis indiquez le nom de la chanson et artiste dans le formulaire ci-dessous. 
			<br>
			- Vérifier bien l\'extension. 
			<br>
			- Attention votre musique doit etre placée dans le dossier musique... 
			<br>
			<br>
			'.@$error.'
			<h2>Ajouter Chanson :</h2> 
			<form action="?mod=musique&action=ajout_chanson" method="post" enctype="multipart/form-data">
			<table>
				<tr>
					<td>Titre de la chanson : </td>
					<td><INPUT type="text" name="titre" value="'.@$_POST['titre'].'" size="50"></td>
				</tr> 
				<tr>
					<td>Auteur de la chansons : </td>
					<td><INPUT type="text" name="auteur" value="'.@$_POST['auteur'].'" size="50"></td>
				</tr>	
'.( ($userrow['administrateur'] == '1' || $userrow['fondateur'] == '1')?'			
				<tr>
					<td>Nom du fichier : </td>
					<td><INPUT type="text" name="nom_fichier" value="'.@$_POST['nom_fichier'].'" size="50"></td>
				</tr>
				<tr>
					<td>Extension du fichier (&quot;.mp3&quot; par exemple...) : </td>
					<td><INPUT type="text" name="extension" value="'.@$_POST['extension'].'" size="50"></td>
				</tr> 
':'
				<tr>
					<td>Le fichier (MP3 uniquement) :</td>
					<td><input type="file" name="chanson" size="36"></td>
				</tr>	
' ).'				
			</table>
			<INPUT type="submit" value="Ajouter"></form>
			<br>
			<br>
			<br>
			
			<h2>Configuration du Mod:</h2>
			<form action="?mod=musique&action=modif_config" method="post">
			<table>
				<tr>
					<td>Titre de la Pop-UP qui s\'ouvre:</td>
					<td><INPUT type="text" size="25" name="titre_lecteur_musique" value="'.@$controlrow['titre_lecteur_musique'].'"></td>
				</tr>
			</table>
			<INPUT type="submit" name="modif_config" value="Modifié les paramètres">
			</form>
			<br>
			<br>
			<br>
'.( (mysql_num_rows($musiques) <= 0)?'
			<br>
			<font color="red" size="+2">Vous n\'avez encore jamais mis de chansons</font>
':'			
			<h2>Chanson Actuellement disponible :</h2> 
			<br>
			<table border="1" width="500" >
				<tr>
					<th>N°</th>
					<th>Titre</th>
					<th>Artiste</th>
					<th></th>
				</tr>
		  ');

$nombre = 1 ;

if(mysql_num_rows($musiques) > 0) // Dans le cas ou il y a des chansons
{
	while ($musique = mysql_fetch_array ($musiques) ) 
	{
		$page .= " 
						<tr>
							<td align='center'>".$nombre."</td>
							<td align='center'>".$musique['titre']."</td>
							<td align='center'>".$musique['artiste']."</td>
							<td align='center'>
								<a href='?mod=musique&action=supprimer_chanson&chanson=".$musique['id']."'>
									<img border='0' src='admin/tpl/icons/delete.gif.png'>
								</a>
							</td>
						</tr>
					";
		$nombre++;
	}

	$page .= "</table>";

}

?>