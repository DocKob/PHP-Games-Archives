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
 Cette classes remplace les anciennes classes :
- batiment
- recherche
- chantier
*/


class construction 
{

	################################################################################
    /****************************************************************************************************\
		FORMATER UN TEMPS DE TYPE time() EN TEMPS DE TYPE H Heures M Minutes S Secondes
	\****************************************************************************************************/
	/**
	 * Génère l'affichage d'un temps à partir d'un TimeStamp
	 *
	 * @param TimeStamp $tps nombre de secondes à formatter en une heure lisible
	 * @param Boolean $verbose à <b>true</b> pour avoir H Min et Sec à la place des deux-points
	 * @param Boolean $full à <b>true</b> pour avoir l'affichage complet (HH:MM:SS)
	 * @param Boolean $jour à <b>true</b> pour avoir le décompte en jour si plus de 24h.
	 * @return String
	 */
	function afficher_temps($tps,$verbose=true,$full=false,$jour=true) 
	{
		$texte='';


		if ($jour) 
		{
			$j = floor($tps/86400);
			$tps=$tps-($j*86400);
			$jours =sprintf('%d J ',$j);
		} 
		else 
		{
			$j=0;
			$jours='';
		}
	
		$h = floor($tps/3600);
		$heures =sprintf('%02d',$h).($verbose?' H ': ':');
		$tps = $tps - ($h*3600);
		$m = floor($tps/60);
		$minutes =sprintf('%02d',$m).($verbose?' Min ': ':');
		$s = $tps - ($m*60);
		$secondes =sprintf('%02d',$s).($verbose?' Sec': '');

		if (!$full) 
		{
			if ($j==0) 
			{
				$jours='';
				
				if ($h==0) 
				{
					$heures='';
					
					if ($m==0) 
					{
						$minutes='';
					}
				}
			}
		}
		
		$temps = $jours.$heures.$minutes.$secondes;
		return $temps;
	}
	################################################################################
    /****************************************************************************************************\
		CALCULER LE TEMPS NECESSAIRE POUR MONTER A UN PROCHAIN NIVEAU
	\****************************************************************************************************/
    function calculer_temps($nivbat, $temps, $temps_evo)
    {
        global $baserow;

        if ($nivbat != 0 || $nivbat != "") 
		{
            $nivencours = 0;
            while ($nivencours < $nivbat) 
			{
                $temps = $temps * (($temps_evo / 100) + 1);
                $nivencours = $nivencours + 1;
            }

            $temps = $temps / (1 + ($baserow["temps_diminution"] / 100));
        }
		
        return $temps;
    }

	################################################################################
    /****************************************************************************************************\
		AFFICHE LES RESSOURCES NECESSAIRE POUR UNE EVOLUTION
			$batressources => les ressources necessaires pour construire le niveau 1
			$batressources_evo => le taux d'evolution de ressources necessaire
	\****************************************************************************************************/
    function afficher_ressources($batressources, $batressources_evo)
    {
        global $batrow;
        global $niv;
        global $voirbat;
       
        if(empty($batrow["id"]) ) 
		{ 
			$batrow["id"] = $voirbat["id"] ; 
		}

        $ressourcespage = " ";

        $ressourcesquery = sql::query('SELECT * FROM '.PREFIXE_TABLES.TABLE_RESSOURCES.' ');

        $batrowressources2 = "0," . $batressources;

        $besoin = explode(",", $batrowressources2);

        while ($row = mysql_fetch_array($ressourcesquery)) 
		{
            $nivencours = 0;
            $ressource = $besoin[$row["id"]];
            if(isset($batrow["id"]) && !isset($niv[$batrow["id"]])) 
			{
                $niv[$batrow["id"]] == "0";
            }
            while ($nivencours < $niv[$batrow["id"]]) 
			{
                $ressource = $ressource * (($batressources_evo / 100) + 1);
                $nivencours = $nivencours + 1;
            }
            $ressource = round($ressource);
            $ressourcespage .= $row["nom"] . " : " . number_format($ressource, 0, '.', '.') . "<br>";
        }

        return $ressourcespage;
    }

	################################################################################
    /****************************************************************************************************\
		CALCULER LES RESSOURCES A AJOUTER LORS DU PASSAGE AU NIVEAU $niveau + 1
			$niveau => Il s'agit du niveau actuelle de notre construction
	\****************************************************************************************************/
    function calculer_ressources($niveau, $ressources, $ressources_evo)
    {
        $ressources2 = explode(",", $ressources);
        $nombre = 0;

        while (isset($ressources2[$nombre])) 
		{
            $ress = $ressources2[$nombre];
            $chiffre = 0;
            while ($chiffre < $niveau) 
			{
                $ress = $ress * (($ressources_evo / 100) + 1);
                $chiffre = $chiffre + 1;
            }
            $ressources2[$nombre] = round($ress);
            $nombre = $nombre + 1;
        }
        $ressourcesaajouter = implode(",", $ressources2);
        
		return $ressourcesaajouter;
    }

	################################################################################
    /****************************************************************************************************\
		CALCULE L'ENERGIE A AJOUTER LORS DU PASSAGE AU NIVEAU $niv + 1
			$niv => Il s'agit du niveau actuelle a laquelle se trouve la construction
	\****************************************************************************************************/
    function calculer_energie($niv, $ene, $ene_evo)
    {
        $nombre = 0;
        while ($nombre < $niv ) 
		{
            $ene = $ene * (($ene_evo / 100) + 1);
            $nombre = $nombre + 1;
        }
		
        $ajout = round($ene);
		
        return $ajout;
    }
	
	################################################################################
    /****************************************************************************************************\
		CALCULE L'ENERGIE A JOUTER DANS LA BASE DE DONNÉES
			$niv => Il s'agit du niveau actuelle de la construction
	\****************************************************************************************************/
    function calculer_ajout_energie($niv, $ene, $ene_evo)
    {
        $nombre = 0;
        while ($nombre < ($niv + 1)) 
		{
            $ene = $ene * (($ene_evo / 100) + 1);
            $nombre = $nombre + 1;
        }
        $eneprecedente = $ene / (($ene_evo / 100) + 1);
        $ajout = round($ene - $eneprecedente);
        return $ajout;
    }	
	
	################################################################################
    /****************************************************************************************************\
		MODIFIER LES RESSOURCES DU JOUEUR LORS DU LANCEMENT D'UNE OPERATION
	\****************************************************************************************************/
    function modif_ressources($ressourcesdepart, $operateur, $ressourcesaajouter)
    {
        $ressourcesaajouter2 = explode(",", $ressourcesaajouter);
        $ressourcesdepart2 = explode(",", $ressourcesdepart);
        $chiffre = 0;

        while (isset($ressourcesaajouter2[$chiffre])) 
		{
            if ($operateur == "+") 
			{
                $ressourcesdepart2[$chiffre] = $ressourcesdepart2[$chiffre] + $ressourcesaajouter2[$chiffre];
            } 
			elseif ($operateur == "-") 
			{
                $ressourcesdepart2[$chiffre] = $ressourcesdepart2[$chiffre] - $ressourcesaajouter2[$chiffre];
                if ($ressourcesdepart2[$chiffre] < 0) 
				{
                    die("Vous n'avez pas assez de ressources. <a href='index.php?mod=batiments'>Retour</a>");
                }
            }

            $chiffre = $chiffre + 1;
        }
        $ressourcesfinales = implode(",", $ressourcesdepart2);

        return $ressourcesfinales;
    }
	
	################################################################################
    /****************************************************************************************************\
	CALCULE LES RESSOURCES A AJOUTER LORS DU PASSAGE A UN NIVEAU SUPERIEURS D'UN BATIMENT
	\****************************************************************************************************/
    function calculer_ajout_ressources($niveau, $ressources, $ressources_evo)
    {
        $ressources2 = explode(",", $ressources);
        $nombre = 0;

        while (isset($ressources2[$nombre])) 
		{
            $ress = $ressources2[$nombre];
            $chiffre = 0;
            while ($chiffre < $niveau) 
			{
                $ress = $ress * (($ressources_evo / 100) + 1);
                $chiffre = $chiffre + 1;
            }

		   if($niveau > 0) 
		   {
				$ressprecedente = $ress / (($ressources_evo / 100) + 1);
				$ressources2[$nombre] = round($ress - $ressprecedente);
		   } 
		   else 
		   {
		      $ressources2[$nombre] = $ress;
		   }

		   $nombre = $nombre + 1;
        }
		
        $ressourcesaajouter = implode(",", $ressources2);
		
        return $ressourcesaajouter;
    }

	################################################################################
    /*************************************************************************************************************************\
		AFFICHAGE DU TEMPS RESTANT AVANT DE POUVOIR LANCÉ LA PROCHAINE CONSTRUCTION
	\*************************************************************************************************************************/
	function ressources_manquantes($batrow)
	{
		global $baserow ;
		global $niv;

		$temps_avant_dispo = ' ';
	    $construction_impossible = '0'; // On incremente la variable avec 0 pour defini que la construction est possible

		$ressourcesquery = sql::query("SELECT * FROM ".PREFIXE_TABLES.TABLE_RESSOURCES." ");
		$batrowressources2 = "0," . $batrow["ressources"];
		$besoin = explode(",", $batrowressources2);
		
		$ress = explode(",", $baserow["ressources"]); // On recupere chaque ressource disponible dans la BDD  dans un tableau

		while ($row = mysql_fetch_array($ressourcesquery) ) // On traite chaque ressource une a une
		{ // debut while traitement une ressource
			$nivencours = 0;
			$ressource = $besoin[$row["id"]];
			if(isset($batrow["id"]) && !isset($niv[$batrow["id"]])) 
			{
				$niv[$batrow["id"]] = "0";
			}
			while ($nivencours < $niv[$batrow["id"]]) 
			{
				$ressource = $ressource * (($batrow["ressources_evo"] / 100) + 1);
				$nivencours = $nivencours + 1;
			}
			$ressource_necessaire = round($ressource);

			$res1 = round($ress[$row["id"] - 1]) ; // Recupere la quantité que l'on possede poru lea ressource 

			$res_m = $ressource_necessaire - round($ress[$row["id"] - 1]) ; // Calcule le nombre de ressource manquante
			
			$res_m = round($res_m) ; // Met en format simple
		   
			if($res_m < 0)  // Dans le cas ou les ressources obtenu sont dans le moins alors, on en a assez
			{ 
				$res_m = 0 ; 
			}
			elseif($res_m > 0) // Dans le cas ou elle sont dans le plus, on en manque
			{ 
				$construction_impossible = "1"; // construction impossible on passe la variable avec "1"
			} 
								
			$temps_avant_dispo .= " ".$row["nom"].": ".$res_m." |" ; // On rajoute la ressource pour l'afficher


		} // fin while traitement une ressource
	       
		// On renvoye un tableau
		return array('ressources_manquantes' => $temps_avant_dispo , // Affiche le nombre de ressources manquante
					 'construction_impossible' => $construction_impossible, // Renvoye 1 dans le cas ou il manque des ressource et que l'on peut pas construire, sinon renvoye 0
					);
	}


	################################################################################
    /*************************************************************************************************************************\
		APRES SUNE CONSTRUCTION D'UNITES, AJOUTE LES NOUVELLES A CELLE DEJA LA
	\*************************************************************************************************************************/
    function fin_unites($unitesactuelles, $ajouter)
    {
        $unites2 = explode(",", $unitesactuelles);

        $unites3 = explode(",", $ajouter);

        $chiffre = 0;

        while (isset($unites3[$chiffre])) 
		{
		
            $unites2[$unites3[$chiffre] - 1] = $unites2[$unites3[$chiffre] - 1] + 1;

            $chiffre = $chiffre + 1;
        }

        $unites = implode(",", $unites2);

        return $unites;
    }

	
	################################################################################
    /*************************************************************************************************************************\
		CALCULER LE TEMPS DE CONSTRUCTION D'UNE UNITES
	\*************************************************************************************************************************/
    function calculer_temps_chantier($temps)
    {
        global $baserow;
		
		// On prend le temps defini pour construire l'unites $temps et on lui enleve le temps de diminution
        $temps = $temps / (1 + ($baserow["temps_diminution"] / 100));

        return $temps;
    }
	
	################################################################################
    /*************************************************************************************************************************\
		RECUPERES LES NIVEAUX DANS UN TABLEAU $niv CONTENANT $niv[id_const] = niveau_const
	\*************************************************************************************************************************/
    
	function niveaux($emplacement)
	{
		$niveaux2 = explode(",", $emplacement);
		$niv = array();

		foreach($niveaux2 AS $niveaux)
		{
		$niveau = explode('-', $niveaux);
		//echo $niveaux.'<br>'.$niveau[0].'<br>'.$niveau[1].'<br><br>'; // Verification de bugs
		$niv[$niveau[0]] = $niveau[1];
		}
		
		return $niv; // Retour le tableau contenant les niveau
	}	
	
	################################################################################
    /*************************************************************************************************************************\
		PERMET DE FORMATER LES CHAMPS SQL DE LA FORME 0,0,0,0,0,0 en id-contenu,id2-contenu2 POUR UN FONCTIONNEMENT AVEC LES OUVEAUX MODS
	\*************************************************************************************************************************/
    function format_niv($emplacement)
	{
		$ccc = explode(',', $emplacement);
		$c = array();
		$nb = 1;
		
		while($nb <= count($ccc) )
		{
			$c[$nb] = $nb.'-'.$ccc[$nb - 1]; // On met chaque champ de forme id-contenu
			$nb++;
		}
		
		return implode(',', $c);
	}
	
	################################################################################
    /*************************************************************************************************************************\
		PERMET DE DEFINIR SI LES BATIMENTS NECESSAIRE A UNE CONSTRUCTION SONT BIEN DISPO
	\*************************************************************************************************************************/
    function batiments_necessaire($batrow)
	{
		global $niv; // On recupere le niveau des batiments
		
		$accesb = 1;
		
		// DEBUT ON TESTE SI LE BATIMENT EST ACCESSIBLE OU SI IL REQUIERE UN AUTRE BATIMENT
		if($batrow["batiments"] != '0' && $batrow["batiments"] != '' ) // On teste que si le batiment necessite un autre batiment
		{ // debut if test si batiment requis est dispo lorsque la construction necessite un batiment
			
			$niv_necessaire2 = explode(",", $batrow["batiments"]); // On recupere les batiments necessaire pour la construction, il sont stocké sous la forme id_bat-niveau-bat,id_bat2-niv_bat2

			// On connait le niveau de chaque batiments, du au faite, qu'on le recupere plus haut sous le tableau $niv
			// $niv[id_du_constituant] = 'niveau_du_constituant';
								
			foreach($niv_necessaire2 AS $niv_necessaire) // On teste pour chaque batiment necessaire si elle est dispo ou pas
			{ // A ce niveau $niv_necessaire contient un tableau donc chaque valeur est egal a id_necessaire-niveau_necessaire
					
					$niv_n = explode('-', $niv_necessaire); // On separe l'id et le niveau du batiment necesssaire
					
					if( @$niv[$niv_n[0]] >= $niv_n[1]) 
					{ // On teste si le niveau du batiment necessaire $niv[id] ou id est representé par l'id du batiment necessaire, est egal au niveau du batiment necessaire ou superieur
						// Dans ce cas ou peut acceder a la construction on effectue donc aucune action
					}
					else // Si le niveau necessaire n'est pas atteint, alors on ne peut pas acceder a la construction
					{
						$accesb = 0;
						break; // Dans le cas ou un niveau n'est pas requis ca ne sert a rien d'aller plus loin, on sait que on ne peut pas construire
					}
			}
		} // fin if test si batiment requis est dispo lorsque la construction necessite un batiment
		// FIN ON TESTE SI LE BATIMENT EST ACCESSIBLE OU SI IL REQUIERE UN AUTRE BATIMENT

		return $accesb; // Renvoye 1 si les batiments necessaire sont bien dispo sinon renvoye 0
	}
		
	################################################################################
    /*************************************************************************************************************************\
		PERMET DE DEFINIR SI LES RECHERCHES NECESSAIRE A UNE CONSTRUCTION SONT BIEN DISPO
	\*************************************************************************************************************************/
	function recherches_necessaire($batrow)
	{
		global $userrow; // On recupere les info du joueur
		
		$accesb = 1; // Par default on a acces au batiment
		
		// DEBUT ON TESTE SI LE BATIMENT EST ACCESSIBLE OU SI IL REQUIERE UNE RECHERCHE
		if($batrow["recherches"] != '0' && $batrow["recherches"] != '' ) // On teste que si le batiment necessite un autre batiment
		{ // debut if test si recherche requis est dispo lorsque la construction necessite une recherche

			$niv_necessaire2 = explode(",", $batrow["recherches"]); // Recupere les recherches necessaire pour créer la batiment

			// On recupere le niveau de chaque recherches sous la forme $niv[id_de_la_recherche] = 'niveau_de_la_recherche';
				// DEBUT ON RECUPERES LES NIVEAUX DES RECHERCHES DU JOUEUR		
					$niv_rech = $this->niveaux($userrow['recherches']);
				// FIN ON RECUPERES LES NIVEAUX DES RECHERCHES DU JOUEUR		
					
								
			foreach($niv_necessaire2 AS $niv_necessaire) // On teste pour chaque batiment necessaire si elle est dispo ou pas
			{ // A ce niveau $niv_necessaire contient un tableau donc chaque valeur est egal a id_necessaire-niveau_necessaire
					
					$niv_n = explode('-', $niv_necessaire); // On separe l'id et le niveau du batiment necesssaire
					
					if(@$niv_rech[$niv_n[0]] >= $niv_n[1]) 
					{ // On teste si le niveau du batiment necessaire $niv[id] ou id est representé par l'id du batiment necessaire, est egal au niveau du batiment necessaire ou superieur
						// Dans ce cas ou peut acceder a la constituante on effectue donc aucune action
					}
					else // Si le niveau necessaire n'est pas atteint, alors on affiche pas la constituante
					{
						$accesb = 0;
						break; // Dans le cas ou un niveau n'est pas requis ca ne sert a rien d'aller plus loin, on sait que on ne peut pas construire
					}
			}
		} // fin if test si recherche requis est dispo lorsque la construction necessite une recherche
		// FIN ON TESTE SI LE BATIMENT EST ACCESSIBLE OU SI IL REQUIERE UNE RECHERCHE

		return $accesb; // Renvoye 1 si les recherches necessaire sont bien dispo sinon renvoye 0
	}














	
}

?> 