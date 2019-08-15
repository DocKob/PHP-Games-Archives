<?php

// Si la constante n'est pas defini on bloque l'execution du fichier
if( (!defined('PHPSIMUL_PAGES') || @PHPSIMUL_PAGES != 'PHPSIMULLL') && empty($_GET['action']) ) 
{
	die('Erreur 404 - Le fichier n\'a pas été trouvé');
}

/* PHPsimul : Créez votre jeu de simulation en PHP
Copyright (©) - 2007 - CAPARROS Sébastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr

*/

@session_start(); // On demarre la session dans le cas ou c'est l'appel direct et qu'il faut ouvrir le chat

switch(@$_GET['action'])
{
	default : // Dans ce cas on affiche le chat avec les derniers messages, et le cadre de saisi pour l'envoye

		$_SESSION['chat'] = $userrow['alli']; // On enregistre la session pour le Chat, ce qui permet d'eviter une requet SQL pour recuperer les infos du joueur a chaque fois

		$messages = afficher_messages($userrow['alli']); // n demande les messages

		$tpl->value("idalliance", $userrow["alli"]);
		$tpl->value('messages', $messages);
		$page = $tpl->construire('chat');

	break;
	
	######################################################################
	
	case 'afficher_messages' : // Dans le cas ou on demande a afficher le chat
	
		// Dans ce cas la, le fichier est appelé en direct, il faut alors executer les action necessaires
		
		define('PHPSIMUL_PAGES', 'PHPSIMULLL');
		include('../systeme/config.php');
		include('../classes/sql.class.php');
		$sql = new sql;
		$sql->connect();
		
		echo afficher_messages($_SESSION['chat']);
		
	break;
	
	######################################################################
	
	case 'envoye_message' :
	
		define('PHPSIMUL_PAGES', 'PHPSIMULLL');
		include('../systeme/config.php');
		include('../classes/sql.class.php');
		$sql = new sql;
		$sql->connect();

		if(@$_GET['message'] != '' && @$_GET['type'] != '' ) // Dans le cas ou un message a été posté
		{

			if($_GET['type'] == '0') // Dans ce cas le message est Global
			{
				$type = '';
			}
			else // Dans l'autre cas le message est alliance
			{
				$type = $_SESSION['chat'];
			}
			
			// On insere le message dans la BDD
			$sql->update('INSERT INTO '.PREFIXE_TABLES.TABLE_CHAT.'
					SET 
						posteur="'.$_SESSION['idjoueur'].'", 
						date="'.time().'", 
						alliance="'. $type.'", 
						message="'. $_GET["message"].'" ');
			
			
		}		
		
		echo afficher_messages($_SESSION['chat']);
		
	break;
	
	######################################################################


}



function afficher_messages($alli_joueur) // Cette fonction permet de recuperer les messages
{
	$messages_query = sql::query('
						 SELECT 
							'.PREFIXE_TABLES.TABLE_CHAT.'.alliance AS chat_alliance,
							'.PREFIXE_TABLES.TABLE_CHAT.'.message AS chat_message,
							'.PREFIXE_TABLES.TABLE_USERS.'.nom AS posteur_nom
						
						 FROM 
							(SELECT * FROM '.PREFIXE_TABLES.TABLE_CHAT.' ORDER BY id DESC LIMIT 10) 
							'.PREFIXE_TABLES.TABLE_CHAT.'
						
						 LEFT JOIN
							'.PREFIXE_TABLES.TABLE_USERS.'
						 ON
							'.PREFIXE_TABLES.TABLE_CHAT.'.posteur = '.PREFIXE_TABLES.TABLE_USERS.'.id
							
						 WHERE 
							alliance="'.$alli_joueur.'"
						  OR 
							alliance=""

						 ORDER BY 
							'.PREFIXE_TABLES.TABLE_CHAT.'.id ASC
							
						');

	if(mysql_affected_rows() <= 0) // Dans le cas ou y'a aucun messages
	{
		$messages = '<tr><td align="center">Aucun messages</td></tr>';
	}
	else // Dans ce cas ya des messages
	{
		$messages = ''; // On incremente la variable

		while($msg = mysql_fetch_array($messages_query) ) 
		{

			if($msg['chat_alliance'] != '') // On regarde si le message posté vient d'une alliance
			{
				// Dans ce cas on affiche le posteur en bleu
				$couleur = 'blue';
				$tag = 'Alliance';
			} 
			else // Le message est global
			{
				// Dans ce cas on affiche le posteur en noir
				$couleur = 'black';
				$tag = 'Global';
			}

			$lien = ( (empty($_GET['action']) ) ? '' : '../' ); // Dans le cas ou le joueur ne poste pas d'action, c'est que il demande a voir le chat, sinon c'est le JS qui fait son effet et dans ce cas le chat est dans modules/ il faut donc changer le lien vers les templates
			$file = fopen($lien.'templates/smileys.html', 'r'); // On ouvre le fichier contenant les smileys
			
			// On demarre les tableaux
			$symbole_smileys = array();
			$image_smileys = array();
			
			while( $ligne = fgets($file, 4096) ) // On traite chaque ligne, donc chaque smileys
			{
				$smiley = explode(' %%% ', $ligne); // On recupere les infos de smileys
			
				$symbole_smileys[] = $smiley[0]; // On recupere le symbole du smiley
				$image_smileys[] = $smiley[2]; // On recupere l'image du smiley
			}
			
			$chat_message = str_replace($symbole_smileys, $image_smileys, htmlentities($msg['chat_message']) ); // On parse chaque smiley pour le remplacer par son image
			//$chat_message = $msg['chat_message'];
			
			$messages .= '
							<tr>
								<th align="left">
									<font color="'.$couleur.'">['.$tag.'] '.$msg['posteur_nom'].' :</font>
								</th>
								<td align="left">
									'.$chat_message.'
								</td>
							</tr>
						 ';

		}
	
	}
	
	return $messages;
	
}


?>