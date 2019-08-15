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

Attention: Le mod n'a pas été refait de A a Z lors de la modification complete de l'admin, certains bug peuvent apparaitre
*/

$page = ''; // On initalise la variable


switch(@$_GET['action'])
{ // debut switch get action

	/**************************************************************************\
	|**************************************************************************|
	\**************************************************************************/
	
	case 'voir' :
	
		$ip = explode("|",$_GET['ip']);

		if(@$ip[1] == "00") // Si le joueur a demander le bannissement on bannis tous les joueurs
		{
			if(empty($_POST['time']) or @$_POST['time'] == '')
			{
				$page .= "
							Combien de temps desirez vous bloquez les joueurs ??
							<br>(Le temps est en seconde, si vous desirez les bloquez a vie, alors mettez 0)
							<br><br><form action='?action=multicompte&action=voir' method='post'>
							<input type='text' name='time' value='Temps' onFocus=\"if (this.value=='Temps') {this.value=''}\" size='50'>
							<br><br>
							Le motif du ban:<br> (Laissez la valeur par default ou vidé, le message sera \"Multicompte avec les joueurs: joueur 1, joueur 2\"
							<br><input type='text' name='motifban' value='Motif du ban' onFocus=\"if (this.value=='Motif du ban') {this.value=''}\"  size='50'>
							<br><br><input type='submit' name='submit_bloqued_j' value='Confirmez le ban'>
						 ";
			}
			elseif(isset($_POST['time']) and $_POST['time'] != '')
			{
				$timeban = ($_POST['time'] == "Temps")?0: time() + $_POST['time']; // Si le joueur n'a pas parametrer le temps, on le met a 0 sinon on met sa valeur

				if($_POST['motifban'] == "Motif du ban" or $_POST['motifban'] == "")
				{
					$joueurs_impliqué = $sql->query("SELECT nom FROM ".PREFIXE_TABLES.TABLE_USERS." WHERE ip='".$ip[0]."' ORDER BY nom ");
					$motifban = "Multicompte avec les joueurs: ";
					while($ji = mysql_fetch_array($joueurs_impliqué) )
					{
						$motifban .= $ji['nom'].", ";
					}
				}
				else 
				{ 
					$motifban = $_POST['motifban']; 
				}

				$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_USERS." SET banni='1', motifbanni='".$motifban."', time_bannis='".$timeban."' WHERE ip='".$ip[0]."' ");

				$page .= "<font size='+1'>Les joueurs ont bien été bannis</font><br><br><br>";
			}

		}
		elseif(isset($ip[0]) ) // Si un appel a cette page est effectué, alors on commence par regarder si le joueur a mis un IP sinon on met l'autre page
		{

			$query = $sql->query("SELECT id, nom, banni, time_bannis FROM ".PREFIXE_TABLES.TABLE_USERS." WHERE ip='".$_GET["ip"]."' ORDER BY nom");

			$page .= "L'utilisateur ayant pour IP: ".$_GET["ip"]." est titulaire des comptes suivants : <br><br>";

			while($row = mysql_fetch_array($query) ) 
			{
				// Permet d'afficher une image devant le joueur si il est actuelement bloqué
				if($row['banni'] == 1 and $row['time_bannis'] >= time() ) 
				{ 
					$display = "<img width='14' border='0' src='design/icons/help.gif.png'> ".$row['nom']."</font>"; 
					$title = "title='Le joueur est actuellement bloqué' "; }
				else 
				{ 
					$display = $row['nom'] ; $title=""; 
				}

				$page .= "<a ".$title." href='?mod=joueurs&action=modifier&joueur=".$row["id"]."'>".$display."</a><br>";
			}

			$page .= "<br><br><a href='?mod=multicompte&action=voir&ip=".$_GET['ip']."|00'><img border='0' src='admin/tpl/images/alerts_push.gif.png'> Bloquez tous les comptes de cette IP</a>";
		} 


	break;
	
	/**************************************************************************\
	|**************************************************************************|
	\**************************************************************************/
	
	default :
		
		// On cherche si des multicompte existe
		$query = $sql->query("
								SELECT COUNT(ip) AS nombre, ip  
								FROM ".PREFIXE_TABLES.TABLE_USERS." 
								GROUP BY ip 
								HAVING nombre > 1  
								AND ip IS NOT NULL  
								AND ip <> ' '
								ORDER BY nombre DESC 
							 ");

							  
		if(mysql_num_rows($query) <= 0) // Dans le cas ou il n'y a pas de multicompte
		{
			$page .= "<img border='0' src='admin/tpl/images/456.gif'><br><br>Aucun multi-compte détécté.";
		}
		else // Dans le cas ou il y a des multicompte detecté
		{
			$page .= "Voici les multicomptes détéctés : <br><br>";
			while($row = mysql_fetch_array($query) ) 
			{
				$page .= "<a href='?mod=multicompte&action=voir&ip=".$row["ip"]."'>".$row["ip"]."</a>   ( ".$row["nombre"]." )<br>";
			}
		}

	break;
	
} // fin switch get action
?>