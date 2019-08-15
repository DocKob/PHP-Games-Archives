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


class commerce 
{

#########################################################################################
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

        $ressourcesquery = sql::query("SELECT * FROM ".PREFIXE_TABLES.TABLE_RESSOURCES." ");

        $batrowressources2 = "0," . $batressources;

        $besoin = explode(",", $batrowressources2);

        while ($row = mysql_fetch_array($ressourcesquery)) 
		{
            $nivencours = 0;
            $ressource = $besoin[$row["id"]];
            if(isset($batrow["id"]) && !isset($niv[$batrow["id"]])) {
                $niv[$batrow["id"]] == "0";
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
#########################################################################################
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
            } elseif ($operateur == "-") 
			{
                $ressourcesdepart2[$chiffre] = $ressourcesdepart2[$chiffre] - $ressourcesaajouter2[$chiffre];
                if ($ressourcesdepart2[$chiffre] < 0) 
				{
                    die("Vous n'avez pas assez de ressources. <a href='index.php?mod=commerce&page=vendre'>Retour</a>");
                }
            }

            $chiffre = $chiffre + 1;
        }
        $ressourcesfinales = implode(",", $ressourcesdepart2);

        return $ressourcesfinales;
    }
#########################################################################################	
    function modif_ressources2($ressourcesdepart, $operateur, $ressourcesaajouter)
    {
        $ressourcesaajouter2 = explode(",", $ressourcesaajouter);
        $ressourcesdepart2 = explode(",", $ressourcesdepart);
        $chiffre = 0;

        while (isset($ressourcesaajouter2[$chiffre])) 
		{
            if ($operateur == "+") 
			{
                $ressourcesdepart2[$chiffre] = $ressourcesdepart2[$chiffre] + $ressourcesaajouter2[$chiffre];
            } elseif ($operateur == "-") 
			{
                $ressourcesdepart2[$chiffre] = $ressourcesdepart2[$chiffre] - $ressourcesaajouter2[$chiffre];
                if ($ressourcesdepart2[$chiffre] < 0) 
				{
                    die("La banque ne possède pas assez de ressources. Il vous faudra attendre que d'autres joueurs en vendent. <a href='index.php?mod=commerce&page=acheter'>Retour</a>");
                }
            }

            $chiffre = $chiffre + 1;
        }
        $ressourcesfinales = implode(",", $ressourcesdepart2);

        return $ressourcesfinales;
    }
	
}

?>