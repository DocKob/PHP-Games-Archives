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


class unites 

{
	###############################################################################
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
		
		if($jours == 0)
		{
			$jours = '';
		}
		
		$temps = $jours.$heures.$minutes.$secondes;
		return $temps;
	}

	###############################################################################
    /****************************************************************************************************\

	\****************************************************************************************************/
    function modif_ressources($ressourcesdepart, $operateur, $ressourcesaajouter)
    {
        $ressourcesaajouter2 = explode(",", $ressourcesaajouter);
        $ressourcesdepart2 = explode(",", $ressourcesdepart);
        $chiffre = 0;

        while ($ressourcesaajouter2[$chiffre] != "") 
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
                    die("Vous n'avez pas assez de ressources. <a href='index.php?mod=map'>Retour</a>");
                }
            }

            $chiffre = $chiffre + 1;
        }
        $ressourcesfinales = implode(",", $ressourcesdepart2);

        return $ressourcesfinales;
    }

	###############################################################################
    /****************************************************************************************************\

	\****************************************************************************************************/
    function modif_unites($ressourcesdepart, $operateur, $ressourcesaajouter)
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
                    die("Vous n'en possédez pas autant. <a href='index.php?mod=chantier'>Retour</a>");
                }
            }

            $chiffre = $chiffre + 1;
        }
        $ressourcesfinales = implode(",", $ressourcesdepart2);

        return $ressourcesfinales;
    }
	
	###############################################################################
    /****************************************************************************************************\

	\****************************************************************************************************/
    function calculer_attaque_et_defense($unitesliste)
    {
        $query = sql::query("SELECT * FROM phpsim_chantier ORDER BY id");
        $unites2 = explode(",", $unitesliste);
        $defense = 0;
        $attaque = 0;
		$bouclier = 0;
        while ($row = mysql_fetch_array($query) ) 
		{
            $defense = $defense + ($unites2[$row["id"] - 1] * $row["defense"]);
            $attaque = $attaque + ($unites2[$row["id"] - 1] * $row["attaque"]);
			$bouclier = $bouclier + ($unites2[$row["id"] - 1] * $row["bouclier"]);
        }

        $return = $attaque . "|" . $defense . "|" . $bouclier ;
        return $return;
    }
	
	###############################################################################
    /****************************************************************************************************\

	\****************************************************************************************************/
    function afficher_ressources($batressources)
    {
        global $batrow;
        global $niv;

        $ressourcespage = " ";

        $ressourcesquery = sql::query("SELECT * FROM phpsim_ressources");

        $batrowressources2 = "0," . $batressources;

        $besoin = explode(",", $batrowressources2);

        while ($row = mysql_fetch_array($ressourcesquery)) 
		{
            $nivencours = 0;
            $ressource = $besoin[$row["id"]];
            $ressource = round($ressource);
            $ressourcespage .= $row["nom"] . " : " . $ressource . "<br>";
        }

        return $ressourcespage;
    }

	###############################################################################
    /****************************************************************************************************\

	\****************************************************************************************************/
    function calculer_carbu($ress, $taux)
    {

        $besoin = explode(",", $ress);

		$chiffre = 0;

        while (isset($besoin[$chiffre])) 
		{

			$besoin[$chiffre] = $besoin[$chiffre] * $taux;

			$chiffre = $chiffre + 1;
		}

		$ress2 = implode(",", $besoin);

        return $ress2;
    }

}

?>