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


class batiment 
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
	function afficher_temps($tps,$verbose=true,$full=false,$jour=false) 
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
	
	/*
	function afficher_temps($temps)
	{
		$secondes = $temps % 60;
		$heures = floor($temps / 60);
		$minutes = $heures % 60;
		$heures = floor($heures / 60);

		$temps = "";
		if ($secondes < 10)
		{
			$temps = "0" . $secondes . " Sec";
		}
		else
		{
			$temps = $secondes . " Sec";
		}
		
		if ($minutes < 10)
		{
			$temps = "0" . $minutes . " Min " . $temps;
		}
		else
		{
			$temps = $minutes . " Min " . $temps;
		}
		
		if ($heures < 10)
		{
			$temps = "0" . $heures . " H " . $temps;
		}
		else
		{
			$temps = $heures . " H " . $temps;
		}
		return $temps;
	}
	*/
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
		CALCULE L4ENERGIE A JOUTER DANS LA BASE DE DONNÉES
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
	DEBUT CODE BY MAX485 - AFFICHAGE DU TEMPS RESTANT AVANT DE POUVOIR LANCÉ LA PROCHAINE CONSTRUCTION
	\*************************************************************************************************************************/
	function ressources_manquantes($batrow)
	{
		global $baserow ;
		global $niv;

		$temps_avant_dispo = " ";

		// DEBUT calcul reccessource nesseccaire pour batiment
	        $ressourcesquery = sql::query("SELECT * FROM ".PREFIXE_TABLES.TABLE_RESSOURCES." ");

	        $batrowressources2 = "0," . $batrow["ressources"];

	        $besoin = explode(",", $batrowressources2);

	        $construction_impossible = " "; // on definit construction impossible pour eviter une erreur

	        $temps_avant_dispo .= "Ressources manquantes : ";
	       
	        while ($row = mysql_fetch_array($ressourcesquery))
	        { // debut while traitement une ressource
	            $nivencours = 0;
	            $ressource = $besoin[$row["id"]];
	            if(isset($batrow["id"]) && !isset($niv[$batrow["id"]])) 
				{
	                $niv[$batrow["id"]] == "0";
	            }
	            while ($nivencours < $niv[$batrow["id"]]) 
				{
	                $ressource = $ressource * (($batrow["ressources_evo"] / 100) + 1);
	                $nivencours = $nivencours + 1;
	            }
	            $ressource_necessaire = round($ressource);
		// FIN calcul reccessource nesseccaire pour batiment

	            $ress = explode(",", $baserow["ressources"]); // pour prendre un seule chiffre du resultat des ressources
	            $prod = explode(",", $baserow["productions"]); // idem mais pour la prod

	            $res1 = round($ress[$row["id"] - 1]) ; // quantité ressource que l'on possede

	            $prod1 = round($prod[$row["id"] - 1]); // la prod que l'on fait

	            $res_m = $ressource_necessaire - round($ress[$row["id"] - 1]) ; // ressources manquante
	            
	            $res_m = round($res_m) ;
	           
	            if($res_m < 0)  // si il y a plus de ressource que l'on a besoin alors
				{ 
					$res_m = 0 ; 
				}

	            if($res_m > 0) // si une ressource manquante est superieur a 0 alors 
				{ 
				$construction_impossible .= "1"; // construction impossible on incremente la variable avec "1"
				} 
	                                
	            $temps_avant_dispo .= " ".$row["nom"].": ".$res_m." |" ;


	        } // fin while traitement une ressource
	       

		return array('ressources_manquantes' => $temps_avant_dispo ,
					 'construction_impossible' => $construction_impossible,
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

	
	
	
	
	
}

?> 