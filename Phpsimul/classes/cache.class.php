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



class cache 
{ 

	##########################################################################################################
	/****************************************************************************************************\
			ON LIT UN FICHIER DU CACHE
	\****************************************************************************************************/
	function lire($fichier) 
	{

		$contenu = file_get_contents($fichier);
		return $contenu;

	}
		

	##########################################################################################################
	/****************************************************************************************************\
	ON VERIFIE SI LE FICHIER EXISTE DANS QUEL CAS OU LE LIT, SINON ON RENVOYE TRUE
	\****************************************************************************************************/
	function chercher($nompage, $dossier2 = "", $joueur_or_tpl='0', $interval = 3600) 
	{
		global $userrow ;

		$dir = 'cache/'.(($dossier2 != "")?$dossier2.'/':'');

		$file = $dir.$nompage.(($joueur_or_tpl == 0)?"_".$userrow['template']:'');

		$echo = 1;

		if (file_exists($file) && (time() - filemtime($file)) < $interval) 
		{

			$echo = '<!-- DEPUIS LE CACHE : '.$nompage.' -->';
			$echo .= $this->lire($file);
			$echo .= '<!-- FIN CONTENU CACHE -->';
		}

		return $echo;

		// SI LE CACHE NECESSITE UNE MISE A JOUR LA FONCTION RETOURNE TRUE, SINON ELLE RETOURNE LE CONTENU DU CACHE
	}

	##########################################################################################################
	/****************************************************************************************************\
			ON SAUVEGARDE DANS LE CACHE UN $contenu 
	\****************************************************************************************************/
	function save($contenu, $nompage, $dossier2 = "./", $joueur_or_tpl='0') 
	{
		// PERMET D'ENREGISTRER DANS LE CACHE

		global $userrow ;

		$dir = 'cache/'.(($dossier2 != "")?$dossier2.'/':'');

		$file = $dir.$nompage.(($joueur_or_tpl == 0)?"_".$userrow['template']:''); // Si =0 alors il s'agit d'un template Si =1 alors il s'agit d'un truc de joueur

		$f = fopen($file, 'w+');
		fputs($f, $contenu);
		fclose($f);

	}

	##########################################################################################################
	/****************************************************************************************************\
					POUR SUPPRIMER UN FICHIER DU CACHE
	\****************************************************************************************************/
	function delete($nompage, $dossier2 = "", $joueur_or_tpl='0') // Pour supprimer le cache
	{
		global $userrow ;

		$dir = 'cache/'.(($dossier2 != "")?$dossier2.'/':'');

		$file = $dir.$nompage.(($joueur_or_tpl == 0)?"_".$userrow['template']:''); // Si =0 alors il s'agit d'un template Si =1 alors il s'agit d'un truc de joueur

		unlink($file);
	}



	##########################################################################################################
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

			$f = fopen($lien_cache, 'w+'); // On ouvre le fichier en mode ecriture + effacement de l'ancien texte
			fputs($f, $ser2); // On enregistre dans le fichier
			fclose($f); // On ferme le fichier
		}
		
		return $controlrow; // On retourne le $controlrow comprenant les config du jeu
	}







}
	
?>