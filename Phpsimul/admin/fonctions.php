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


/*
Fichiers contenant toutes les fonction neccessaire au bon fonctionnement de l'administration
*/

#########################################################################################
/*-------------------------------------------------------------------------------------*\
FONCTION NECESSAIRE A LA SUPPRESSION DE RESSOURCES, RECHERCHES, BATIMENTS, ETC
\*-------------------------------------------------------------------------------------*/
function calculer_suppression($tabsupprimer, $tabids, $id) // Fonction créer par Khi3l
{
	$tabids = explode(',', $tabids);
	// On récupère la position de $id dans $tabids
	$i = 0;
	while ($i <= count($tabids))
	{
		if ($tabids[$i] == $id)
		{
			$position = $i;
			break;
		}
		$i++;
	}
	// Maintenant, on va mettre à jour $tabsupprimer
	$tab = explode(',', $tabsupprimer);
	$tabsupprimer = array();
	$i = 0;
	// On commence par la partie précédant $position
	while ($i < $position)
	{
		$tabsupprimer[$i] = $tab[$i];
		$i++;
	}
	// Puis on traite la partie après $position
	$i = $position + 1;
	while ($i <= count($tab))
	{
		$tabsupprimer[$i - 1] = $tab[$i];
		$i++;
	}
	return implode(',', $tabsupprimer);
}


/*
EXEMPLE :

	case "delete":
		$cquery = mysql_query("SELECT * FROM " . _PREFIX_ . _TABLE_CONFIG_ . "");
		while ($row = mysql_fetch_array($cquery))
		{
			$config[$row['config_name']] = $row['config_value'];
		}
		$tabdepart = $config["recherchesdepart"];
		$tabconfig = $config["recherchesids"];
		$tab = array();
		$query = mysql_query("SELECT * FROM " . _PREFIX_ . _TABLE_MEMBRES_ . "");
		while ($row = mysql_fetch_array($query))
		{
			$tabrech = $row["recherches"];
			$tabrech = calculer_suppression($tabrech, $tabconfig, $id);
			mysql_query("UPDATE " . _PREFIX_ . _TABLE_MEMBRES_ . " SET recherches='" . $tabrech . "' WHERE id='" . $row["id"] . "'");
		}
		$tabdepart = calculer_suppression($tabdepart, $tabconfig, $id);
		$tabconfig = calculer_suppression($tabconfig, $tabconfig, $id);
		mysql_query("UPDATE " . _PREFIX_ . _TABLE_CONFIG_ . " SET recherchesdepart='" . $tabdepart . "', recherchesids='" . $tabconfig . "'");
		mysql_query("DELETE FROM " . _PREFIX_ . _TABLE_RECHERCHES_ . " WHERE id='" . $id . "'");
	break;
*/
	
	
	
	
	
	
	
	
#########################################################################################
/*--------------------------------------------------------------------------------------
FONCTION NECESSAIRE A LA SUPPRESSION DE RESSOURCES, RECHERCHES, BATIMENTS, ETC QUI ONT UN NIVEAU
--------------------------------------------------------------------------------------*/
// Explication par Max485 => Cette fonction permet de supprimer dans les tables batiments, recherches, chantier et defenses, les batiments/recherche necessaire lorsqu'on supprime celle ci
function calculer_suppression_niveau($tabsupprimer, $id) // Créer par khi3l
{
	$tabsupprimer = explode(',', $tabsupprimer);
	// On récupère la position de $id dans $tabids
	$i = 0;
	$j = 0;
	$position = array();
	while ($i <= count($tabsupprimer))
	{
		$tmp = explode('-', $tabsupprimer[$i]);
		$idtmp = $tmp[0];
		if ($idtmp == $id)
		{
			$position[$j] = $i;
			$j++;
		}
		$i++;
	}
	// Maintenant, on va mettre à jour $tabsupprimer
	$tab = $tabsupprimer;
	$tabsupprimer = array();
	$i = 0;
	while ($j <= count($position))
	{
		// On commence par la partie précédant $position[$j]
		while ($i < $position[$j])
		{
			$tabsupprimer[$i] = $tab[$i];
			$i++;
		}
		// Puis on traite la partie après $position[$j]
		$i = $position[$j] + 1;
		while ($i <= count($tab))
		{
			$tabsupprimer[$i - 1] = $tab[$i];
			$i++;
		}
		$j++;
	}
	return implode(',', $tabsupprimer);
}







#########################################################################################
/*-------------------------------------------------------------------------------------------*\
PERMET D'INSERER OUI OU NON A LA PLACE DE 0 OU 1 DANS UNE PAGE OU LA REQUETE SQL SE NOMME $row
\*-------------------------------------------------------------------------------------------*/
function select($nom) // Créer par Camaris
{

	global $row;

	if($row[$nom] == 1)
	{
		$oui = "selected";
		$non = " ";
	}
	else
	{
		$oui = " ";
		$non = 'selected';
	}

	$txt = "
			<select name='".$nom."'>
				<option value='1' ".$oui.">Oui</option>
				<option value='0' ".$non.">Non</option>
			</select>
		   ";

	return $txt;

}






#########################################################################################
/*--------------------------------------------------------------------------------------------------*\
LORS DES MODIFICATIONS DANS LA CONFIGURATION PRINCIPALE, SEULEMENT CERTAISN CHAMPS SONT RENVOYÉ, DE 
CE FAITE, IL FAUT METTRE AU AUTRE CHAMPS LEUR VALEUR NORMALE, CELA CE FAIT GRACE A CETTE FONCTION
\*--------------------------------------------------------------------------------------------------*/
function chrp($nom_champ) // Créer par Max485
{
	global $controlrow;

	if (isset($_POST[$nom_champ]) ) // Si le champ a été posté alors on le modifie
	{
		$value = addslashes($_POST[$nom_champ]);
	}  
	else // Si le champ n'a pas été posté on  met la valeur deja contenue
	{
		$value = addslashes($controlrow[$nom_champ]);
	} 
	
	return $value;
}





#########################################################################################
/*--------------------------------------------------------------------------------------------------*\
SUPPRESSION DES EVENTUELLES GUILLEMETS AJOUTÉS
\*--------------------------------------------------------------------------------------------------*/
function quote_smart($value,$addquote = TRUE) 
{
	// Stripslashes
	if (get_magic_quotes_gpc() )
	{
		$value = stripslashes($value);
	}

	// Protection si ce n'est pas un entier ou pas une chaine à protéger
	if (!is_numeric($value) && $addquote)
	{
		$value = "'" . mysql_real_escape_string($value) . "'";
	}

	return $value;
}


#########################################################################################
/*--------------------------------------------------------------------------------------------------*\
 PROTECTION DES VARIABLES POUR MYSQL (GESTION DES GUILLEMETS) - PROVIENT DU MANUEL PHP
\*--------------------------------------------------------------------------------------------------*/

function unquote_smart($value)
{
	// Stripslashes
	if (get_magic_quotes_gpc() )
	{
		return stripslashes($value);
	}
}


#########################################################################################


#########################################################################################
/****************************************************************************************************\
PERMET DE METTRE EN CACHE LE TABLEAU $controlrow CE QUI EVITE UNE REQUETE SQL EN PLUS
\****************************************************************************************************/
function cache_config($lien_cache)
{
	$ser = @file_get_contents($lien_cache); // On recupere le cache dans le cas ou il existe
	$controlrow = unserialize($ser); // On unseralize le fichier

	if (@empty($controlrow['nom']) ) // Dans le cas ou le fichier n'existe pas, alors $controlrow['nom'] n'existe pas non plus, on passe ici pour créerle fichier
	{
		// On recupere la config
		$config = sql::query('SELECT config_name, config_value FROM '.PREFIXE_TABLES.TABLE_CONFIG.' ');
		while ($row = mysql_fetch_array($config) ) // On passe dans chaque ligne
		{
			$controlrow[$row['config_name']] = $row['config_value']; // On passe chaque ligne dans $controlrow
		}
		$controlrow2 = $controlrow; // Permet d'eviter des bugs
		$ser2 = serialize($controlrow2); // On serialize pour pouvoir mettre dans un fichier

		$f = fopen('cache/controlrow', 'w+'); // On ouvre le fichier en mode ecriture + effacement de l'ancien texte
		fputs($f, $ser2); // On enregistre dans le fichier
		fclose($f); // On ferme le fichier
	}
	
	return $controlrow; // On retourne le $controlrow comprenant les config du jeu
}
#########################################################################################

?>