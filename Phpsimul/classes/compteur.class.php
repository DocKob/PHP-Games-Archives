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


class compteur 
{

	########################################################################################################
    /****************************************************************************************************\
		ON RECUPERE LE NOMBRE DE CONNECTÉ SUR LE JEU
	\****************************************************************************************************/
	function nbconnect()
	{

		$temps_actuel = time() ; 

		$heure_max = $temps_actuel - TEMPS_PENDANT_LEQUEL_ON_EST_ACTIF ;

		$nbconnect = sql::select1('SELECT COUNT(id) FROM '.PREFIXE_TABLES.TABLE_USERS.' WHERE time >= "'.$heure_max.'" '); 

		if ($nbconnect <= 1)  // Si il ny a qu'une personne de connecté
		{
			$compteur = @templates::construire('nbconnect1'); 
		} 
		else // Si il a plusieurs personnes de connecté
		{
			templates::value('nombrepersonneconnect',$nbconnect);
			$compteur =  templates::construire('nbconnectx');
		}

		return $compteur;
	}

	########################################################################################################
    /****************************************************************************************************\
		RECUPERE LE CLASSEMENT GENERALE D'UN JOUEUR
	\****************************************************************************************************/
	function classement($quel_joueur)
	{
		global $userrow ;

		return sql::select1("SELECT (COUNT(id)+1) FROM ".PREFIXE_TABLES.TABLE_USERS." WHERE points > '".$userrow["points"]."' ORDER BY points ");
	}

	########################################################################################################
    /****************************************************************************************************\
		ON RECUPERE LE NOMBRE DE BASE QUE POSSEDE LE JOUEUR DONT L'ID EST $quel_joueur
	\****************************************************************************************************/
	function nombre_bases($quel_joueur)
	{
		$joueur_base = sql::select1("SELECT bases FROM ".PREFIXE_TABLES.TABLE_USERS." WHERE id='".$quel_joueur."' ");

		$bases_totale = explode(",", $joueur_base);
		
		$nombre = COUNT($bases_totale);

		return $nombre ;
	}

	########################################################################################################
    /****************************************************************************************************\
		ON RECUPERE LE NOMBRE DE BATIMENTS EXISTANT DANS LA TABLES DES BATIMENTS
		ET ON LE MET SOUS FORME DE CHAMP SQL TEL QUE 0,0,0,0,0,0,0
	\****************************************************************************************************/
	function nbbatiments()
	{
		$nbbatiments = sql::select1('SELECT COUNT(id) FROM '.PREFIXE_TABLES.TABLE_BATIMENTS.' ');
		$batiments = '';
		$chiffre = 1;
		while($chiffre <= $nbbatiments)
		{
			$batiments .= '0,';
			$chiffre++;
		}
		if($batiments{strlen($batiments)-1} == ',')  // On vire la virgule en trop a la fin
		{ 
			$batiments{strlen($batiments)-1} = ' '; 
		} 

		return $batiments;
	}

	########################################################################################################
    /****************************************************************************************************\
		ON RECUPERE LE NOMBRE D'UNITÉES EXISTANT DANS LA TABLES DES UNITÉS
		ET ON LE MET SOUS FORME DE CHAMP SQL TEL QUE 0,0,0,0,0,0,0
	\****************************************************************************************************/
	function nbunites()
	{
		$nbunites = sql::select1('SELECT COUNT(id) FROM '.PREFIXE_TABLES.TABLE_CHANTIER.' ');
		$unites = '';
		$chiffre = 1;
		while($chiffre <= $nbunites)
		{
			$unites.= '0,';
			$chiffre++;
		}
		if($unites{strlen($unites)-1} == ',')  // On vire la virgule en trop a la fin
		{ 
			$unites{strlen($unites)-1} = ' '; 
		} 

		return $unites ;
	}

	########################################################################################################
    /****************************************************************************************************\
		ON RECUPERE LE NOMBRE DE DEFENSES EXISTANT DANS LA TABLES DES DEFENSES
		ET ON LE MET SOUS FORME DE CHAMP SQL TEL QUE 0,0,0,0,0,0,0
	\****************************************************************************************************/
	function nbdefenses()
	{

		$nbdefenses = sql::select1('SELECT COUNT(id) FROM '.PREFIXE_TABLES.TABLE_DEFENSES.' ');
		$defenses = '';
		$chiffre = 1;
		while($chiffre <= $nbdefenses)
		{
			$defenses.= '0,';
			$chiffre++;
		}
		if($defenses{strlen($defenses)-1} == ',')  // On vire la virgule en trop a la fin
		{ 
			$defenses{strlen($defenses)-1} = ' '; 
		} 

		return $defenses;
	}
	
	########################################################################################################
    /****************************************************************************************************\
		ON RECUPERE LE NOMBRE DE RECHERCHES EXISTANT DANS LA TABLES DES RECHERCHES
		ET ON LE MET SOUS FORME DE CHAMP SQL TEL QUE 0,0,0,0,0,0,0
	\****************************************************************************************************/
	function nbrecherches()
	{
		$nbrecherches = sql::select1('SELECT COUNT(id) FROM '.PREFIXE_TABLES.TABLE_RECHERCHES.' ');
		$recherches = '';
		$chiffre = 1;
		while($chiffre <= $nbrecherches)
		{
			$recherches.= '0,';
			$chiffre++;
		}
		if($recherches{strlen($recherches)-1} == ',')// On vire la virgule en trop a la fin
		{ 
			$recherches{strlen($recherches)-1} = ' '; 
		} 

		return $recherches;
	}

	

} // FIN CLASSE compteur.class.php




?>