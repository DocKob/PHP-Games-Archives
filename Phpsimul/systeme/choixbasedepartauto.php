<?php

// Si la constante n'est pas defini on bloque l'execution du fichier
if(!defined('PHPSIMUL_PAGES') || @PHPSIMUL_PAGES != 'PHPSIMULLL') 
{
	die('Erreur 404 - Le fichier n\'a pas été trouvé');
}

/* 

PHPsimul : Créez votre jeu de simulation en PHP
Copyright (©) - 2007 - CAPARROS Sébastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr

*/



##########################################################################################################
function choixbasedepartauto() // Permet de definir une base ainsi qu'une image pour la base automatiquement
{
    global $userrow;
    global $controlrow;
    global $page;
    global $theme ;
    global $sql;
    global $compteurs;

    if ($controlrow["coordonnees_activees"] == 1) // si le systeme de coordonnées est activé
    { // debut if controlrow coordonnées_actives = 1
        if ($controlrow["ordre_1_active"] == 1) // si la galaxie nommé ordre_1 est activé
        {
                $ordre_1 = rand(1, $controlrow["ordre_1_max"]);

            if ($ordre_1 > $controlrow["ordre_1_max"]) // on test si le rand() a pas pris une valeur au dessus de la max
            {                                          // si c'est le ca alors on met la max et pas plus haut
                $ordre_1 = $controlrow["ordre_1_max"];
            }
        } 
        else // si la galaxie ordre_1 n'est pas activé, on le defini comme =1
        {
            $ordre_1 = 1;
        }

            $ordre_2 = rand(1, $controlrow["ordre_2_max"]); // On choisi une valeur au pif pour le systeme (ordre_2)

        if ($ordre_2 > $controlrow["ordre_2_max"]) // si la valeur retenu est plus grosse que la valeur autorisé alors on met a la valeur autorisé
        {
            $ordre_2 = $controlrow["ordre_2_max"];
        }

        ###################################################################################
        
        $numero_ordre_3 = 1;
		  $ordre_3 = rand(1, $controlrow["ordre_3_max"]) ;
        while ($numero_ordre_3 <= $controlrow["ordre_3_max"]) 
        {
            $ordrequery = mysql_query("SELECT * FROM phpsim_bases WHERE ordre_1='" . $ordre_1 . "' AND ordre_2='" . $ordre_2 . "' AND ordre_3='" . $ordre_3 . "'");
            if (mysql_num_rows($ordrequery) == 1) {
					$ordre_3 = rand(1, $controlrow["ordre_3_max"]) ;
            } 
            else 
            {
              $ordre_3 = $ordre_3 ;
              break;
            }
            $numero_ordre_3++;
        }
        
		$count = 0 ;
		$dir = opendir("../templates/" . $userrow["template"] . "/images/bases") ;
		while($file = readdir($dir) )
		{
			if(!is_dir($file) ) 
			{ 
				if(!eregi('index', $file) ) // On incremente la valeur qui si ce n'est pas un fichier index 
				{ 
					$count ++;
				} 
			} 
		}

		$image = rand(1, $count); // Defini une image aleatoire en prenant pas plus que le nombre d'images dans le template

	    $idmaxquery = mysql_query("SELECT MAX(id) AS idmax FROM phpsim_bases");
	    $idmaxrow = mysql_fetch_array($idmaxquery);
	    $idmax = $idmaxrow["idmax"] + 1;

		mysql_query("UPDATE phpsim_users SET bases='" . $idmax . "', baseactuelle='" . $idmax . "' WHERE id='" . $userrow["id"] . "'");

		$map2 = explode(",", "0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0");
		$map2[rand(1, 81)] = "-1";
		$map2[rand(1, 81)] = "-1";
		$map2[rand(1, 81)] = "-1";
		$map = implode(",", $map2);

		mysql_query("
					INSERT INTO phpsim_bases SET 
					id='" . $idmax . "',
					utilisateur='" . $userrow["id"] . "',
					ordre_1='" . $ordre_1 . "',
					ordre_2='" . $ordre_2 . "',
					ordre_3='" . $ordre_3 . "',
					ressources='" . $controlrow["ressourcesdepart"] . "',
					derniere_mise_a_jour='" . time() . "',
					cases='0',
					cases_max = '" . $controlrow["cases_default"] . "',
					productions='" . $controlrow["productiondepart"] . "',
					stockage='" . $controlrow["stockagedepart"] . "',
					energie_max='" . $controlrow["energie_default"] . "',
					energie='0',
					batiments='" . $compteurs->nbbatiments() . "',
					unites='" . $compteurs->nbunites() . "',
					defenses='" . $compteurs->nbdefenses() . "',	
					image='" . $image . "',
					map='".$map."'
					");


    } // fin if controlrow coordonnées_actives = 1
    
	#####################################################################
    else // si les cooronnées sont inactive
    {
        $idmaxquery = mysql_query("SELECT MAX(id) AS idmax FROM phpsim_bases");
        $idmaxrow = mysql_fetch_array($idmaxquery);
        $idmax = $idmaxrow["idmax"] + 1;

        mysql_query("UPDATE phpsim_users SET bases='" . $idmax . "', baseactuelle='" . $idmax . "' WHERE id='" . $userrow["id"] . "'");


		$count = 0 ;
		$dir = opendir("../templates/" . $userrow["template"] . "/images/bases") ;
		while($file = readdir($dir) )
		{
			if(!is_dir($file) ) 
			{
				if(!eregi('index', $file) )  // On incremente la valeur qui si ce n'est pas un fichier index 
				{ 
					$count ++; 
				} 
			}
		}

		$image = rand(1, $count); // Defini une image aleatoire en prenant pas plus que le nombre d'images dans le template

		$map2 = explode(",", "0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0");
		$map2[rand(1, 81)] = "-1";
		$map2[rand(1, 81)] = "-1";
		$map2[rand(1, 81)] = "-1";
		$map = implode(",", $map2);

		mysql_query("INSERT INTO phpsim_bases SET 
		                    id='" . $idmax . "', 
		                    utilisateur='" . $userrow["id"] . "', 
		                    ressources='" . $controlrow["ressourcesdepart"] . "',
		                    derniere_mise_a_jour='" . time() . "',
		                    cases='0', 
		                    cases_max = '" . $controlrow["cases_default"] . "', 
		                    productions='" . $controlrow["productiondepart"] . "', 
		                    stockage='" . $controlrow["stockagedepart"] . "', 
		                    energie_max='" . $controlrow["energie_default"] . "', 
		                    energie='0', 
		                    batiments='" . $compteurs->nbbatiments() . "',
								  unites='" . $compteurs->nbunites() . "',
								  defenses='" . $compteurs->nbdefenses() . "',					
		                    image='" . $image . "',
		                    map='".$map."'");
    }

}
#########################################################################################################################


?>