<?php

// Si la constante n'est pas defini on bloque l'execution du fichier
if(!defined('PHPSIMUL_PAGES') || @PHPSIMUL_PAGES != 'PHPSIMULLL') 
{
die('Erreur 404 - Le fichier n\'a pas �t� trouv�');
}

/* PHPsimul : Cr�ez votre jeu de simulation en PHP
Copyright (�) - 2007 - CAPARROS S�bastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr

Ce mod a �t� cr�er par Max485, il permet de recevoir les messages envoyer dans le mod contact sur le jeu

*/

$page ='';

switch(@$_GET['action'])
{ // debut switch action
	
	// On place un switch pour une eventuelle modification du mod, mais pour le moment celui di est inutile
	
	#################################################################
	
	default :
			
		if(isset($_GET['supprimer']) ) // Si get supprimer vaut quelque chose, alors l'admin a cliquer sur delete, dans ce cas on execute la suppression
		{ // debut if get supprimer
		
			// $_GET['supprimer'] contient l'id du message a virer

			$sql->update('DELETE FROM '.PREFIXE_TABLES.TABLE_CONTACT.' WHERE Id="'.$_GET['supprimer'].'" ');

		} // fin if get supprimer
		
		/*************************************************************************************************************************************/
		
		$message_post� = $sql->query('SELECT * FROM '.PREFIXE_TABLES.TABLE_CONTACT.' ORDER BY time ');

		$page .= '<DIV align="left"> '; // Permet d'eviter que le texte soit centr�

		while($msg_post� = mysql_fetch_array($message_post�))
		{ // debut while recuper� les messages

			extract($msg_post�); // On extrait les reponse pour avoir a ecrire que des variable au lieu de tableau

			// On bloque toute execution HTML qui aurait pu etre post� dans le message, et on affiche le message tel qu'il a �t� post� (= retour a la ligne)
			$Pseudo = nl2br(htmlspecialchars(stripslashes($Pseudo) ) ) ;
			$Mail = nl2br(htmlspecialchars(stripslashes($Mail) ) );
			$Message = nl2br(htmlspecialchars(stripslashes($Message) ) ); // On vire les slash qu'il pourrait y avoir 

			$page .= '
					       <h5><font color="00FFFF">'.$Pseudo.' (<a href="mailto:'.$Mail.'"><font color="00FFFF">'.$Mail.'</font></a>) � post� le '.date('d / m / Y \� H \H\e\u\r\e\s i \M\i\n', $time).' :</font></h5>
					       <b><font color="FF1493">'.$Message.'</font></b>
					       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="?mod=contact&supprimer='.$Id.'">
					       <img border="0" src="admin/tpl/icons/deleteop5.gif" width="15" height="15"></a>
					       <br>
					       <br>
					       <hr>
					 ';
					     
		} // fin while recuper� les messages
		
		// Dans le cas ou aucun messages n'ont �t� post�
		if(empty($Pseudo) ) $page .='<center><img src="admin/tpl/images/456.gif"><br><br><h3><font color="00FFFF">Aucun message n\'est present dans la Base De Donn�es</font></h3>';

$page .= '<br></DIV>'; // fin du div permettant de tout caler a gauche

	break;
	
} // fin switch get action


