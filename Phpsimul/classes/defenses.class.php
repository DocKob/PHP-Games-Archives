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



class defenses {
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

    function afficher_ressources($batressources, $batressources_evo)
    {
        global $batrow;
        global $niv;

        $ressourcespage = " ";

        $ressourcesquery = sql::query("SELECT * FROM phpsim_ressources");

        $batrowressources2 = "0," . $batressources;

        $besoin = explode(",", $batrowressources2);

        while ($row = mysql_fetch_array($ressourcesquery)) {
            $nivencours = 0;
            $ressource = $besoin[$row["id"]];
            $ressourcespage .= $row["nom"] . " : " . $ressource . "<br>";
        }

        return $ressourcespage;
    }

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
                    die("Vous n'avez pas assez de ressources. <a href='index.php?mod=chantier'>Retour</a>");
                }
            }

            $chiffre = $chiffre + 1;
        }
        $ressourcesfinales = implode(",", $ressourcesdepart2);

        return $ressourcesfinales;
    }

    function fin_defenses($unitesactuelles, $ajouter)
    {
        $unites2 = explode(",", $unitesactuelles);

        $unites3 = explode(",", $ajouter);

        $chiffre = 0;

        while (isset($unites3[$chiffre])) {
            $unites2[$unites3[$chiffre] - 1] = $unites2[$unites3[$chiffre] - 1] + 1;

            $chiffre = $chiffre + 1;
        }

        $unites = implode(",", $unites2);

        return $unites;
    }

    function calculer_temps($temps)
    {
        global $baserow;

        $temps = $temps / (1 + ($baserow["temps_diminution"] / 100));

        return $temps;
    }
}

?>