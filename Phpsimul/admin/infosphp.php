<?php

/* PHPsimul : Créez votre jeu de simulation en PHP
Copyright (©) - 2007 - CAPARROS Sébastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr

*/

$page = '';


switch(@$_GET['action'])
{ // debut switch get action

	case 'infos_serveur' :
	
		echo "
			<br>
			<br>
			<center>
			<a href='../admin.php?mod=infosphp'><h1>Retour</h1></a></center><br><br>";
		 echo phpinfo();	
		
	break;
	
	/*******************************************************************\
	|*******************************************************************|
	\*******************************************************************/
	
	case 'infos_fonctions' : // Remerciement a l'auteur de ce bout de code (http://www.sdprod.fr.tc/), les seules modifications qu'a subbit le code pour etre mis sur PHPsimul est au point de vue indentation
		
		// On definie le nom du fichier reference
		define('NOM_FICHIER_REFERENCE', 'infosphp.dat');
		
		// O bloque l'execution du script si il manque le fichier de reference
		if (!file_exists(NOM_FICHIER_REFERENCE) )
		{
			die('
				<script>
					alert("Le fichier '.NOM_FICHIER_REFERENCE.' est introuvable, le script ne peut pas être executé");
					location="../admin.php?mod=infosphp"
				</script>
				');
		}

		extract($_POST);

		echo '
				<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
				<html>
				<head>
					<title>SDprod PHPinfo v2.0</title>
					<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
					<style type="text/css">
						body {
							margin-top: 0;
							margin-bottom: 0;
							margin-left: 10px;
							margin-right: 10px;
							background-color: #FFFFFF;
							color: #000000;
							font-family: Verdana;
							font-size: 16px;
						}
						hr {
							height: 1px;
							width: 100%;
							background-color: #000000;
							border: 0;
						}
						input {
							background-color: #EEEEEE;
							color: #000000;
							border: 1px solid #000000;
						}
						a {
							color: #0000CC;
							text-decoration: none;
						}
						a:hover {
							color: #FF0000;
							text-decoration: none;
						}
						.titre {
							background-color: #CCCCCC;
							font-weight: bold;
							font-size: 12px;
						}
						.contenu {
							background-color: #EEEEEE;
							font-size: 12px;
						}
						.oui {
							color: #009900;
							text-align: center;
						}
						.non {
							color: #FF0000;
							text-align: center;
						}
					</style>
				</head>

				<body>
		     ';

		// Variables générales
		$php_url = "http://www.php.net/manual/fr";
		$info_url = "http://sdprod.net/PHPinfo/info.php";
		$ref_len = 0;
		$fct_len_all = 0;
		$fct_yes = 0;
		$fct_no = 0;

		// Date de modification du fichier de référence
		$time = filemtime(NOM_FICHIER_REFERENCE);

		// Affichage de l'en-tête SDprod
		echo "<center><a href='../admin.php?mod=infosphp'><h1>Retour</h1></a></center>";
		echo "<hr>\n&#8226; <b><a href=\"http://www.SDprod.fr.tc\" target=\"_blank\" title=\"Cliquez ici pour visiter SDproduction\">SDprod PHPinfo v2.0</a></b><br>\n";
		echo "Informations sur les fonctions <b>PHP ".phpversion()."</b> du serveur <b>".$_SERVER['SERVER_NAME']."</b><br>\n";
		echo "<iframe src=\"$info_url?id=$time\" align=\"left\" frameborder=\"0\" height=\"18\" width=\"1000\" marginheight=\"0\" marginwidth=\"0\" scrolling=\"no\"></iframe><br>";
		echo "<hr><br>\n";
		echo "<form method=\"post\" action=\"\">";
		echo "<b>Recherche :</b>\n";
		echo "<input type=\"text\" name=\"search\" value=\"".@$search."\">\n";
		echo "<input type=\"submit\" name=\"go\" value=\"GO\">";
		echo "</form>\n<br><br><br>\n";

		// Ouverture du fichier de référence
		$fp = fopen(NOM_FICHIER_REFERENCE, "r");

		if (@$search == "")
		{
			// Liste des références
			while (($ref = fgets($fp, 4096)) != "")
			{
				$fct = "";
				$s = "";
				
				// Liste des fonctions
				while (($data = fgets($fp, 4096)) != "\n")
				{
					$fct[] = $data;
				}
				
				$fct_len = count($fct);
				if ($fct_len > 1) $s = "s";
				$ref_data = explode(chr(3), $ref);
				
				// Affichage de la réference
				echo "&#8226; <b><a href=\"$php_url/$ref_data[0]\" target=\"_blank\">".trim($ref_data[1])."</a></b> ($fct_len fonction$s)\n<br><br>\n";
				echo "<table width=\"1400\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#000000\">\n";
				echo "<tr class=\"titre\">\n<td width=\"300\">Nom de la fonction</td>\n";
				echo "<td width=\"80\" align=\"center\">Supporté</td>\n";
				echo "<td width=\"920\">Description</td>\n</tr>\n";
				
				// Affichage des fonctions
				for($i=0; $i<$fct_len; $i++)
				{
					$fct_data = explode(chr(3), $fct[$i]);
					
					echo "<tr class=\"contenu\">\n<td><a href=\"$php_url/$fct_data[0]\" target=\"_blank\">$fct_data[1]</a></td>\n";
					if (function_exists($fct_data[1]))
					{
						echo "<td class=\"oui\">OUI</td>\n";
						$fct_yes++;
					}
					else
					{
						echo "<td class=\"non\">NON</td>\n";
						$fct_no++;
					}
					echo "<td>".trim($fct_data[2])."</td>\n</tr>\n";
				}
					
				echo "</table>\n";
				echo "<br><br><br>\n";
				$ref_len++;
				$fct_len_all += $fct_len;
			}
		}
		else
		{
			// Recherche
			while ($fct = fgets($fp, 4096))
			{
				if ((stristr($fct, $search)) && (substr($fct, 0, 3) != "ref"))
				{
					$res[] = $fct;
				}
			}
			
			$s = "";
			$res_len = count($res);
			if ($res_len > 1) $s = "s";
			echo "&#8226; <b><a href=\"\" title=\"Cliquez ici pour retourner sur la page principale\">Résultats de la recherche</a></b> ($res_len fonction$s)\n<br><br>\n";
			
			if ($res_len > 0)
			{
				sort($res);
				
				// Affichage des résultats de la recherche
				echo "<table width=\"1400\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#000000\">\n";
				echo "<tr class=\"titre\">\n<td width=\"300\">Nom de la fonction</td>\n";
				echo "<td width=\"80\" align=\"center\">Supporté</td>\n";
				echo "<td width=\"920\">Description</td>\n</tr>\n";
				
				// Affichage des fonctions
				for ($i=0; $i<$res_len; $i++)
				{
					$fct_data = explode(chr(3), $res[$i]);
					
					echo "<tr class=\"contenu\">\n<td><a href=\"$php_url/$fct_data[0]\" target=\"_blank\">$fct_data[1]</a></td>\n";
					if (function_exists($fct_data[1]))
					{
						echo "<td class=\"oui\">OUI</td>\n";
						$fct_yes++;
					}
					else
					{
						echo "<td class=\"non\">NON</td>\n";
						$fct_no++;
					}
					echo "<td>".trim($fct_data[2])."</td>\n</tr>\n";
				}
			
				echo "</table>\n";
			}
			else
			{
				echo "Aucun résultat\n";
			}
			
			echo "<br><br><br>\n";
		}

		fclose($fp);

		// Affichage des statistiques
		echo "<br>\n<hr>\n&#8226; <b>Statistiques</b><br>\n";
		if ($search == "")
		{
			echo "Nombre total de réferences : $ref_len<br>\n";
			echo "Nombre total de fonctions : $fct_len_all<br>\n";
		}
		echo "Fonctions supportées : $fct_yes<br>\n";
		echo "Fonctions non supportées : $fct_no<br>\n<hr>\n";

					 
	break;
	
	/*******************************************************************\
	|*******************************************************************|
	\*******************************************************************/
	
	default :
	
		$page .= "
					Que désirez vous voir ?
					<br>
					<br>
					<a href='admin/infosphp.php?action=infos_serveur' >Informations sur le serveur</a>
					<br>
					<br>
					<a href='admin/infosphp.php?action=infos_fonctions'>Les fonctions disponibles</a>
				 ";
	break;
	
} // fin switch get action
	
?>