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

switch(@$_GET['action'])
{ // debut switch get action

	/************************************************************\
	|************************************************************|
	\************************************************************/
	
	case 'backup' :

	if (isset($_POST['LastTable']))
		{
			@header('Cache-Control: no-cache');
			@header('Pragma: no-cache');
		}

		include ('admin/backupbdd/includes/config.inc.php');
		include ('admin/backupbdd/includes/functions.inc.php');

		define('MAX_EXECUTION_TIME', $CONFIG['timeout']);

		$iStartTime = MicrotimeFloat();
		if ($sError = CheckConfig())
		{
			echo $sError;
			exit;
		}

		if (isset($_POST['selectlang']) )
		{
			$sCurrentLang = $_POST['selectlang'];
		}
		else if (isset($_COOKIE[$CONFIG['cookiename']]))
		{
			$sCurrentLang = $_COOKIE[$CONFIG['cookiename']];
		}
		else
		{
			$sCurrentLang = $CONFIG['lang'];
		}

		if (!ereg("^([0-9a-zA-Z]+)$", $sCurrentLang) || !file_exists('admin/backupbdd/lang/'.$sCurrentLang.'.inc.php'))
		{
			echo 'Invalid Language File.';
			exit;
		}

		@SetCookie($CONFIG['cookiename'], $sCurrentLang);
		include ('admin/backupbdd/lang/'.$sCurrentLang.'.inc.php');
		include ('admin/backupbdd/includes/html.header.inc.php');
		include ('admin/backupbdd/includes/html.footer.inc.php');


		$aPages = array(
						'dump' => 'admin/backupbdd/includes/html.dump_start.inc.php',
						'dodump' => 'admin/backupbdd/includes/html.dump.inc.php',
						'restore' => 'admin/backupbdd/includes/html.restore_start.inc.php',
						'dorestore' => 'admin/backupbdd/includes/html.restore.inc.php',
						'delete' => 'admin/backupbdd/includes/html.delete.inc.php',
						'gest' => 'admin/backupbdd/includes/html.gest.inc.php'
						);


		if (!isset($_REQUEST['act']) || !array_key_exists($_REQUEST['act'], $aPages) )
		{
			include('admin/backupbdd/includes/html.start.inc.php');
		}
		else
		{
			include($aPages[$_REQUEST['act']]);
		}
	break;
	
	/************************************************************\
	|************************************************************|
	\************************************************************/
	
	case 'liste' :

		#####################################################################################################################
		// On passe les POST & GET dans des variables
		@$table = $_GET['table'];
		@$requete = $_POST['req'];
		$page = "";

		#####################################################################################################################
		// Si on a envoyer une requete post req n'est pas vide alors on detruit get table
		if(isset($requete) )
		{
			unset($table);
		}
		elseif(isset($table) ) // Si on a envoyer une table alors get table contient une table on crée une requete select
		{ // debut else table posté
			$requete = 'select * from '.quote_smart($table, FALSE).' ';
		} // fin else table posté
		else // si aucun n'est rempli ont affiche la valeur par default
		{
			$requete = 'SELECT * FROM phpsim_menu'; // Requete par default
		}

		#####################################################################################################################
		// On effectue ensuite la requete
		if(isset($requete) )
		{ // debut if requete envoyer

			$pub_requete = $requete ; // On transforme la variable requete en pub_requete
			                          // Car le code des affichage requete n'est pas de moi
			                          // et il etait plus simple de le modifier au minimuù

			// la regex : coupe les "points-virgule suivis (ou pas) d'espace(s) puis d'un ordre SQL", multiligne & insensible à la casse
			// les 2 options sont pour inclure les délimiteurs dans l'output et éliminer les sous-chaines vides

				$tmp_requete = ';'.$pub_requete;

				$pat[0] = "/^\s+/";
				$pat[1] = "/\s{2,}/";
				$pat[2] = "/\s+\$/";
				$pat[3] = "/;\$/";
				$rep[0] = "";
				$rep[1] = " ";
				$rep[2] = "";
				$rep[3] = "";
				$tmp_requete = preg_replace($pat, $rep, $tmp_requete);

			// les 2 options sont pour inclure les délimiteurs dans l'output et éliminer les sous-chaines vides
				$requetes = preg_split('#;\s*(select|explain|alter|delete|drop|insert|replace|update|load|show|check|analyze|repair|optimize)#mi',$tmp_requete,-1,PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY);
				for ($i = 0; $i < count($requetes); $i += 2) {
					array_splice($requetes, $i, 2, array($requetes[$i].$requetes[1+$i--]));
				}
		} // fin if requete envoyer


		foreach($requetes as $requete) 
		{ // debut foreach $requete

			// suppression des caractères inutiles
			$requete = trim($requete);
			// exécution de la requete
			$ress = mysql_query($requete);
			// affichage de la requete en haut de la page
			$page .= '<table border="1" width="100%" cellspacing="1"><tr class="style" Bgcolor = "#99CC55"><td style="text-align: left;">'.$requete.'</td></tr>';

			$premiere_ligne = TRUE;
			$class_css = 'f';
			// requete de type modification (DELETE, INSERT, REPLACE, UPDATE...)
			if (strpos(strtolower($requete),'alter') !== FALSE) 
			{
				$page .= '<tr><td class="f">Table modifiée.</td></tr>';
			} 
			elseif (strpos(strtolower($requete),'delete') !== FALSE) 
			{
				$page .= '<tr><td class="f"><b>'.mysql_affected_rows().'</b> lignes <b>supprimées</b>.</td></tr>';
			} 
			elseif (strpos(strtolower($requete),'insert') !== FALSE) 
			{
				$page .= '<tr><td class="f"><b>'.mysql_affected_rows().'</b> lignes <b>insérées</b>.</td></tr>';
			} 
			elseif (strpos(strtolower($requete),'replace') !== FALSE) 
			{
				$page .= '<tr><td class="f"><b>'.mysql_affected_rows().'</b> lignes <b>remplacées</b>.</td></tr>';
			} 
			elseif (strpos(strtolower($requete),'update') !== FALSE) 
			{
				$page .= '<tr><td class="f"><b>'.mysql_affected_rows().'</b> lignes <b>mises à jour</b>.</td></tr>';
			} 
			elseif (strpos(strtolower($requete),'drop') !== FALSE) 
			{
				$page .= '<tr><td class="f"><b>Drop</b> effectué.</td></tr>';
			} 
			elseif (strpos(strtolower($requete),'load') !== FALSE) 
			{
				$page .= '<tr><td class="f"><b>'.mysql_affected_rows().'</b> lignes <b>affectées</b>.</td></tr>';
			} 
			else 
			{
				// à faire uniquement si requete de type affichage (SELECT, SHOW, DESCRIBE, EXPLAIN...)
				$page .= '<tr class="style"><td style="text-align: left; width: "100%" Bgcolor = "#FF9999">Affichage des enregistrements : <b>'.mysql_affected_rows().'</b> au total.</td></tr></table>';
				$page .= '<table border="1" cellpadding="0" cellspacing="1" align="center">';
				while ($row = mysql_fetch_assoc($ress) ) 
				{
					// la ligne d'entete, avec le nom des champs
					if ($premiere_ligne) 
					{
						$titre = array_keys($row);
						$page .= '<tr>';
						foreach ($titre as $cell)
						$page .= '<td class="c">'.$cell.'</td>'; // pas nécessaire de protéger les noms des champs (impossible d'avoir des caractères HTML dans cette partie là)
						$page .= "</tr>\n";
					}
					$premiere_ligne = FALSE;

					// les résultats
					$page .= '<tr>';
					foreach ($row as $cell)
					{
						$page .= '<td style="text-align:left;" class="'.$class_css.'" >';
						if (!isset($cell) || $cell == '' ) $page .= '&nbsp;'.'</td>'; // pour les champs vides. empty() n'est pas à utiliser ici surtout pour les valeurs zéro
						else $page .= htmlentities($cell,ENT_QUOTES).'</td>'; // htmlentities() ou htmlspecialchars() ? convertir tous les caractères, ou juste les balises HTML ?
					}
					$page .= "</tr>\n";
					// alternance des styles
					if ($class_css == 'f') $class_css = 'k'; else $class_css = 'f';
				}

				// libération des ressources
				mysql_free_result($ress);
			}
			
			$page .= '</table>';

		} // fin foreach $requete

		#####################################################################################################################
		// On liste les tables

		$liste_tables = mysql_list_tables(BDD_NOM);

		if ($liste_tables !== FALSE) 
		{ // debut Code executé si tables presentes
			$page .= '
						<style type="text/css">
						div ul .listetable:hover {text-decoration: none; color: lime; text-decoration: underline overline;}
						</style>
						<div style="width: 260px; float: left; text-align: left;" >Liste des tables présentes dans la base :
						<ul style="list-style-type: square; text-align: left; margin-left: -0px;">
					 ';
				
			// Boucle permettant de listez les tables
			while ($row = mysql_fetch_row($liste_tables)) 
			{ 
				$page .= '<li><a href="?mod=sql&action=liste&table='.$row[0].'" class="listetable">'.$row[0].'</a></li>'; 
			}

			$page .= '</ul></div><div style="margin-left: 260px;"> ';
		} // fin Code executé si tables presentes
		else // Si aucune tables on affiche rien
		{
			$page .="<div>";
		}

		#####################################################################################################################
		// Le formulaire pour les requetes
		$page .='
					<form action="?mod=sql&action=liste" method="post">
					<textarea rows="14" cols="30" style="width: 100%;" name="req">'.$requete.'</textarea>
					<input type="submit" name="envoi" style="width: 100%;" value="Exécuter">
					</form>
					</div>
				';
		#####################################################################################################################

	break;
	
} // fin switch get action





?>