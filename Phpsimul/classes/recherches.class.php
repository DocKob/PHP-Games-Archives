<?php

// Si la constante n'est pas defini on bloque l'execution du fichier
if(!defined('passageobligerparindex') || @passageobligerparindex != 'mrestpassezarindex') 
{
include('../systeme/error404.php');
die();
}

/* PHPsimul : Créez votre jeu de simulation en PHP
Copyright (©) - 2007 - CAPARROS Sébastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr

*/



class recherche {
#################################################################################################
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

	/*
	function afficher_temps($temps)
    {
        $heures = round($temps / 3600);
        $minutes = round(($temps - (3600 * $heures)) / 60);
        $secondes = round($temps - (3600 * $heures) - (60 * $minutes));

        if ($secondes < 0) {
            $minutes = $minutes -1;
            $secondes = 60 + $secondes;
        }

        $temps = "";

        if ($heures != 0 && $heures != "") {
            $temps .= $heures . ' H ';
        }

        if ($minutes != 0 && $minutes != "") {
            $temps .= $minutes . ' Min ';
        }

        $temps .= $secondes .' Sec ';
        return $temps;
    }
	*/
#################################################################################################
    function calculer_temps($nivbat, $temps, $temps_evo)
    {
        global $baserow;

        if ($nivbat != 0 || $nivbat != "") {
            $nivencours = 0;
            while ($nivencours < $nivbat) {
                $temps = $temps * (($temps_evo / 100) + 1);
                $nivencours = $nivencours + 1;
            }

            $temps = $temps / (1 + ($baserow["temps_diminution"] / 100));
        }
        return $temps;
    }
#################################################################################################
    function afficher_ressources($batressources, $batressources_evo)
    {
    global $niv;
    global $batrow;

        $ressourcespage = " ";

        $ressourcesquery = sql::query("SELECT * FROM phpsim_ressources");

        $batrowressources2 = "0," . $batressources;

        $besoin = explode(",", $batrowressources2);

        while ($row = mysql_fetch_array($ressourcesquery)) {
            $nivencours = 0;
            $ressource = $besoin[$row["id"]];

            if(!isset($niv[$batrow["id"]])) {
			$niv[$batrow["id"]] = 0;
			}

            while ($nivencours < $niv[$batrow["id"]]) {
                $ressource = $ressource * (($batressources_evo / 100) + 1);
                $nivencours = $nivencours + 1;
            }
            $ressource = round($ressource);
            $ressourcespage .= $row["nom"] . " : " . number_format($ressource, 0, '.', '.') . "<br>";
        }

        return $ressourcespage;
    }
#################################################################################################
    function calculer_ressources($niveau, $ressources, $ressources_evo) // Le niveau est l'actuel mais pas le suivant
    {
        $ressources2 = explode(",", $ressources);
        $nombre = 0;

        while (isset($ressources2[$nombre])) {
            $ress = $ressources2[$nombre];
            $chiffre = 0;
            while ($chiffre < $niveau) {
                $ress = $ress * (($ressources_evo / 100) + 1);
                $chiffre = $chiffre + 1;
            }
            $ressources2[$nombre] = round($ress);
            $nombre = $nombre + 1;
        }
        $ressourcesaajouter = implode(",", $ressources2);
        return $ressourcesaajouter;
    }
#################################################################################################
    function modif_ressources($ressourcesdepart, $operateur, $ressourcesaajouter)
    {
        $ressourcesaajouter2 = explode(",", $ressourcesaajouter);
        $ressourcesdepart2 = explode(",", $ressourcesdepart);
        $chiffre = 0;

        while (isset($ressourcesaajouter2[$chiffre])) {
            if ($operateur == "+") {
                $ressourcesdepart2[$chiffre] = $ressourcesdepart2[$chiffre] + $ressourcesaajouter2[$chiffre];
            } elseif ($operateur == "-") {
                $ressourcesdepart2[$chiffre] = $ressourcesdepart2[$chiffre] - $ressourcesaajouter2[$chiffre];
                if ($ressourcesdepart2[$chiffre] < 0) {
                    die("Vous n'avez pas assez de ressources. <a href='javascript:history.back();'>Retour</a>");
                }
            }

            $chiffre = $chiffre + 1;
        }
        $ressourcesfinales = implode(",", $ressourcesdepart2);

        return $ressourcesfinales;
    }
    
    
// DEBUT CODE BY MAX485 - Affichage du temps restant avant de pouvoir lancé la prochaine construction

################################################################################
function ressources_manquantes($voirbat)
{
global $baserow ;



        $temps_avant_dispo = " ";

// DEBUT calcul reccessource nesseccaire pour batiment
        $ressourcesquery = sql::query("SELECT * FROM phpsim_ressources");

        @$batrowressources2 = "0," . $voirbat["ressources"];

        $besoin = explode(",", $batrowressources2);

        $construction_impossible = " "; // on definit construction impossible pour eviter une erreur

        $temps_avant_dispo .= "Ressources manquantes : ";
        
        while ($row = mysql_fetch_array($ressourcesquery)) 
        { // debut while traitement une ressource
            $nivencours = 0;
            @$ressource = $besoin[$row["id"]];
            if(isset($batrow["id"]) && !isset($niv[$batrow["id"]])) {
                $niv[$batrow["id"]] == "0";
            }
            while (@$nivencours < @$niv[$batrow["id"]]) {
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
           
            if($res_m < 0) { $res_m = 0 ; } // si il y a plus de ressource que l'on a besoin alors

            if($res_m > 0) { $construction_impossible .= "1"; } // si une ressource manquante est superieur a 0 alors 
                                // construction impossible on incremente la variable avec "1"

            $temps_avant_dispo .= " ".$row["nom"].": ".$res_m." |" ;


        } // fin while traitement une ressource
        
// FIN CODE BY MAX485 - Affichage du temps restant avant de pouvoir lancé la prochaine construction

return array('ressources_manquantes' => $temps_avant_dispo ,
             'construction_impossible' => $construction_impossible,
            );
}

#################################################################################################
}

?>