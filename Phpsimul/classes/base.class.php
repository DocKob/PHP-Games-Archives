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



class base 
{
	#############################################################################################################
    /****************************************************************************************************\
			PERMET DE CHANGER LA BASE SUR LAQUELLE ON SE TROUVE
	\****************************************************************************************************/
	function select_base() 
    {
        global $userrow;

        if (!empty($_POST["idbase"]) ) 
        {
            $verifquery = sql::query("SELECT id FROM ".PREFIXE_TABLES.TABLE_BASES." 
										WHERE id='" . $_POST["idbase"] . "' 
										AND utilisateur='" . $userrow["id"] . "' 
									 ");
            
			if (mysql_num_rows($verifquery) == 1) 
            {
                sql::update("UPDATE ".PREFIXE_TABLES.TABLE_USERS." SET baseactuelle='" . $_POST["idbase"] . "' WHERE id='" . $userrow["id"] . "' ");
                die('<script>document.location="?mod=accueil";</script>');
            }
        }
    }
	
	#############################################################################################################
    /****************************************************************************************************\
		ON MET A JOUR LES RESSOURCES DE LA BASE
	\****************************************************************************************************/ 
	function maj()
    {
        global $userrow;
        global $controlrow;

        $baserow = sql::select("SELECT * FROM ".PREFIXE_TABLES.TABLE_BASES." WHERE id='" . $userrow["baseactuelle"] . "' 
                                AND utilisateur='" . $userrow["id"] . "' LIMIT 1");

        $temps_ecoule = time() - $baserow["derniere_mise_a_jour"];
        
        $productions = explode(",", $baserow["productions"]);
                
        $ressources = explode(",", $baserow["ressources"]);
        
        $stock = explode(",", $baserow["stockage"]);
        
        $chiffre = 0;

		// DEBUT Recuperation du facteur de production

			if ($controlrow["energie_activee"] == 1) // Dans le cas ou l'energie est activé
			{

				if ($baserow['energie'] > $baserow['energie_max']) // On regarde si on utilise plus d'energie que se que l'on possede
				{
					$facteur = ($baserow['energie_max'] / $baserow['energie']);
						
					if ($facteur > 1) // Si le facteur est plus grand que 1
					{
						$facteur = 1;
					}
				}
				else
				{
					$facteur = 1;
				}
			} 
			else // Si l'energie est desactivé
			{
				$facteur = 1;
			} 

			if($userrow['allopass_facteur_production'] == '1' && $userrow['allopass_facteur_production_temps'] > time() ) // Dans le cas ou le joueur a acheter un allopass, et que le temps n'est pas ecoulé augmentant sont facteur de production
			{
				// On multiplie le facteur par le facteur de production
				$facteur *= ( $allopass['facteur_production']['pourcent_facteur_en_plus'] / 100 + 1);
			}
			
		// FIN Recuperation du facteur de production

		while (isset($productions[$chiffre]))
		{
	         if($ressources[$chiffre] <= $stock[$chiffre])
			{
			   $ajouter = ($productions[$chiffre] / 3600) * $temps_ecoule;
			   $ajouter = $ajouter * $facteur;
			   $prod_ressource[$chiffre] = $ressources[$chiffre] + $ajouter;
	  
				if($prod_ressource[$chiffre] <= $stock[$chiffre])
				{
					$ressources[$chiffre] = $ressources[$chiffre] + $ajouter;
				}

			}
			else
			{
				$ressources[$chiffre] = $stock[$chiffre]+0.1;
			}

			$chiffre++;
		}

        $derniere_mise_a_jour = time();
        $baserow["ressources"] = implode(",", $ressources);

	
        sql::update("UPDATE ".PREFIXE_TABLES.TABLE_BASES." SET ressources='" . $baserow["ressources"] . 
                    "', derniere_mise_a_jour='" . $derniere_mise_a_jour . "' WHERE id='" . $baserow["id"] . "'");

        return $baserow;
    }
	
	#############################################################################################################
    /****************************************************************************************************\
		MET EN FORME LES COORDONNÉE DE LA BASE
	\****************************************************************************************************/   
	function coordonnees($id)
    {
        global $controlrow;

        if ($controlrow["coordonnees_activees"] == 1) 
		{
            $row = sql::select("SELECT ordre_1,ordre_2,ordre_3 FROM ".PREFIXE_TABLES.TABLE_BASES." WHERE id='" . $id . "' LIMIT 1");
			$coordonnees = '['.( ($controlrow['ordre_1_active'] == 1)? $row['ordre_1'] . ':' : '' ). $row['ordre_2'] . ':' . $row['ordre_3'] . ']';
		} 
		else 
		{
            $coordonnees = '';
        }
		
        return $coordonnees;
    }
	
	#############################################################################################################
    /****************************************************************************************************\
		FONCTION PERMETTANT D'AFFICHER LES RESSOURCES DE LA BASE SUR LA PAGE
	\****************************************************************************************************/
    function afficher_ressources()
    {
        global $userrow;
        global $baserow;
        global $controlrow;
		
		$chiffre = 0;
        $facteur = 1;

        if ($controlrow["energie_activee"] == 1) 
		{
            if ($baserow["energie"] > $baserow["energie_max"]) 
			{
                if ($baserow["energie_max"] > 0) 
				{
                    $facteur = ($baserow["energie_max"] / $baserow["energie"]);
                    if ($facteur > 1) 
					{
                        $facteur = 1;
                    }
                } 
				else 
				{
                    $facteur = 1;
                }
            }
        } 
		else 
		{
            $facteur = 1;
        } 

        $baseressources = $baserow["ressources"];
        $basestk = $baserow["stockage"];
		
		$prod = "0,".$baserow["productions"];
		$prod = explode(",", $prod);
		
        $ressourcesquery = sql::query("SELECT * FROM ".PREFIXE_TABLES.TABLE_RESSOURCES." ");
        
        $baseressources2 = explode(",", '0,'.$baseressources);

        $basestk2 = explode(",", '0,'.$basestk);
        
        $ressources ='';

		templates::getboucle("ressources"); 
		
		templates::value('theme', $userrow['template']);
		
        while ($row = mysql_fetch_array($ressourcesquery) ) 
        {

			if($basestk2[$row['id']] > $baseressources2[$row["id"]]) // Dans le cas ou les silo ne sont pas plein
			{
                $ress_qté = number_format(round($baseressources2[$row["id"]]), 0, '.', '.');
            } 
            else // si le silo est plein
            {
				$ress_qté = "<font color='red'>" . number_format(round($baseressources2[$row["id"]]), 0, '.', '.') .  "</font>";
            }	
			
			templates::value('ressourcenom', $row['nom']);
			templates::value('ressourceimage', $row['image']);
			templates::value('ressourcequantité', $ress_qté);
			
			// POUR PERMETTRE A LA FONCTION JS DE METTRE LES RESSOURCES A JOUR EN TANT RÉEL
	            templates::value('idressource', $row['id']);
				templates::value('nombre_ressources_actuel', $baseressources2[$row['id']] );
				templates::value('prod_par_heure', $prod[$row['id']]);
				templates::value('stockage_max', $basestk2[$row['id']]);

             templates::boucle();
			
        }

        if ($controlrow["energie_activee"] == 1) 
		{
            $ene1 = $baserow["energie_max"] - $baserow["energie"];

            if ($ene1 < 0) 
			{
                $ene1 = "<font color='red'>" . $ene1 . "</font>";
            }

            templates::value('ressourceimage', 'energie');
            templates::value('ressourcenom', $controlrow['energie_nom']);
            templates::value('ressourcequantité', $ene1 . ' / ' . $baserow['energie_max']);

            templates::boucle();
        }
		
		$ressources = templates::finboucle();

        return $ressources;
    }
    
    
	#############################################################################################################
    /****************************************************************************************************\
		PERMET D'AJOUTER LES BASES DANS LE <SELECT> AFFICHANT LES BASES SUR LA PAGE
	\****************************************************************************************************/    
	function afficher_bases() // Permet d'afficher les ressources
    {
        global $userrow;
        global $baserow;
        global $controlrow;

        $userbases = $userrow["bases"];
        $bases = explode(",", $userbases);
        $nbre = 0;
        $autresbases = " ";
        $selectbases='';

        while (isset($bases[$nbre])) 
		{
            if ($bases[$nbre] != $userrow["baseactuelle"]) 
			{
                $autresbases .= " OR id='" . $bases[$nbre] . "'";
            }
            $nbre = $nbre + 1;
        }

        $query = sql::query("SELECT id,nom FROM ".PREFIXE_TABLES.TABLE_BASES." WHERE utilisateur='" . $userrow["id"] . "' AND id='" . $userrow["baseactuelle"] . "'" . $autresbases);
	  
        while ($row = mysql_fetch_array($query)) 
        { // debut while traitement base
            if ($row["id"] == $userrow["baseactuelle"]) 
			{
            templates::value('sel','selected');
            } 
			else
			{
				templates::value('sel','');
            }

            if ($controlrow["coordonnees_activees"] == 1) 
			{
                $coordonnees = $this->coordonnees($row["id"]);
            } 
			else 
			{
                $coordonnees = " ";
            }

            templates::value('optionvalue',$row['id']);
            templates::value('optiontexteafficher',$row['nom'].' '.$coordonnees);
            $selectbases.= templates::construire('select_def')."n";
            
        } // fin while traitement base

		  return $selectbases;
    }

	#############################################################################################################

} // FIN Classe base.class.php

?>