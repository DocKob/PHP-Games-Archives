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

class unites_arrivee 
{

	###############################################################################
	/*******************************************************************************************************\

	\*******************************************************************************************************/
	function ress_esp($ress) 
	{

		$ress2 = explode(",", $ress);
		$nombre = 0;

		while(isset($ress2[$nombre])) 
		{

			if($ress2[$nombre] <= 99) 
			{ 
				$ress2[$nombre] = (round($ress2[$nombre]/10)*10); 
			}
			elseif($ress2[$nombre] <= 999) 
			{ 
				$ress2[$nombre] = (round($ress2[$nombre]/100)*100); 
			}
			elseif($ress2[$nombre] <= 9999) 
			{ 
				$ress2[$nombre] = (round($ress2[$nombre]/1000)*1000); 
			}
			elseif($ress2[$nombre] <= 99999) 
			{ 
				$ress2[$nombre] = (round($ress2[$nombre]/10000)*10000); 
			}
			elseif($ress2[$nombre] <= 999999) 
			{ 
				$ress2[$nombre] = (round($ress2[$nombre]/100000)*100000); 
			}
			elseif($ress2[$nombre] <= 9999999) 
			{ 
				$ress2[$nombre] = (round($ress2[$nombre]/1000000)*1000000); 
			}
			elseif($ress2[$nombre] > 9999999) 
			{ 
				$ress2[$nombre] = (round($ress2[$nombre]/1000000)*1000000); 
			}

			$nombre = $nombre + 1;
		}

		$ress = implode(",", $ress2);

		return $ress;

	}

	###############################################################################
	/*******************************************************************************************************\
		
	\*******************************************************************************************************/
	function modif_ressources($ressourcesdepart, $operateur, $ressourcesaajouter) // fonctionne aussi pour les unités
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
			}

			$chiffre = $chiffre + 1;
		}
		
		$ressourcesfinales = implode(",", $ressourcesdepart2);

		return $ressourcesfinales;
	}

	###############################################################################
	/*******************************************************************************************************\

	\*******************************************************************************************************/
	function calculer_attaque_et_defense($unitesliste, $defensesliste)
	{
		$query = sql::query("SELECT * FROM ".PREFIXE_TABLES.TABLE_CHANTIER." ORDER BY id");
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

		$query = sql::query("SELECT * FROM ".PREFIXE_TABLES.TABLE_DEFENSES." ORDER BY id");
		$defenses2 = explode(",", $defensesliste);
		while ($row = mysql_fetch_array($query)) 
		{
			$defense = $defense + ($defenses2[$row["id"] - 1] * $row["defense"]);
			$attaque = $attaque + ($defenses2[$row["id"] - 1] * $row["attaque"]);
			$bouclier = $bouclier + ($defenses2[$row["id"] - 1] * $row["bouclier"]);
		}

        $return = $attaque . "|" . $defense . "|" . $bouclier;
		return $return;
	}

	###############################################################################
	/*******************************************************************************************************\

	\*******************************************************************************************************/
	// DEBUT FONCTIONS PRINCIPALES
	function mission0($row) // attaque
	{ // debut fonction mission attaque
		
		global $controlrow, $userrow;

		
		
		
		
		
		
		
		
		
		
		
		
		
		/*
		
		
		// Les vaisseaux sont arrivés, on récupère les infos
		$defenseur_vaisseaux = explode(',', $rowB['vaisseaux']);
		$attaquant_vaisseaux = explode(',', $vaisseaux);
		$attaquant_nom = $attaquant['pseudo'];
		$defenseur_nom = $defenseur['pseudo'];
		
		// Et c'est parti pour le long code du combat
		$this->rapport = '';
		$attaquant_flotte = array();
		$defenseur_flotte = array();

		$attaquant_arme = 0;
		$attaquant_bouclier = 0;
		$attaquant_coque = 0;
		$this->rapport .= sptintf($lang->recuplng('combat_rapport_attaquant'), $attaquant_nom) . '<br />';

		// On récupère les informations sur les vaisseaux de l'attaquant
		$result = $sql->query("SELECT * FROM " . _PREFIX_ . _TABLE_VAISSEAUX_ . " WHERE id IN '" . $attaquant_vaisseaux . "' ORDER BY arme DESC, bouclier DESC, coque DESC");
		while ($rowAtt = mysql_fetch_array($result))
		{
			$attaquant_arme += $rowAtt['arme'];
			$attaquant_bouclier += $rowAtt['bouclier'];
			$attaquant_coque += $rowAtt['coque'];
			$this->rapport .= $rowAtt['nom'] . $lang->recuplng('attaque') . $rowAtt['arme'] . $lang->recuplng('bouclier') . $rowAtt['bouclier'] . $lang->recuplng('coque') . $rowAtt['coque'] . '<br />';
			$attaquant_flotte[] = array('arme' => $rowAtt['arme'], 'bouclier' => $rowAtt['bouclier'], 'coque' => $rowAtt['coque'], 'etat' => 'intact', 'nom' => $rowAtt['nom'], 'id' => $rowAtt['id'], 'stockage' => $rowAtt['stockage']);
		}
		$this->rapport .= $lang->recuplng('combattotal') . $attaquant_arme . $lang->recuplng('bouclier') . $attaquant_bouclier . $lang->recuplng('coque') . $attaquant_coque . '<br /><br />';

		$defenseur_arme = 0;
		$defenseur_bouclier = 0;
		$defenseur_coque = 0;

		$this->rapport .= sptintf($lang->recuplng('combat_rapport_defenseur'), $defenseur_nom) . '<br />';

		// On récupère les infos sur les vaisseaux du défenseur
		$result = $sql->query("SELECT * FROM " . _PREFIX_ . _TABLE_VAISSEAUX_ . " WHERE id IN '" . $defenseur_vaisseaux . "' ORDER BY arme DESC, bouclier DESC, coque DESC");
		while ($rowDef = mysql_fetch_array($result))
		{
			$defenseur_arme += $rowDef['arme'];
			$defenseur_bouclier += $rowDef['bouclier'];
			$defenseur_coque += $rowDef['coque'];
			$this->rapport .= $rowDef['nom'] . $lang->recuplng('attaque') . $rowDef['arme'] . $lang->recuplng('bouclier') . $rowDef['bouclier'] . $lang->recuplng('coque') . $rowDef['coque'] . '<br />';
			$defenseur_flotte[] = array('arme' => $rowDef['arme'], 'bouclier' => $rowDef['bouclier'], 'coque' => $rowDef['coque'], 'etat' => 'intact', 'nom' => $rowDef['nom'], 'id' => $rowDef['id'], 'stockage' => $rowDef['stockage'], 'ressources' => $rowDef['ressources']);
		}
		$this->rapport .= $lang->recuplng('combattotal') . $defenseur_arme . $lang->recuplng('bouclier') . $defenseur_bouclier . $lang->recuplng('coque') . $defenseur_coque . '<br /><br />';

		// On passe au combat proprement dit
		$combat = array();
		$combat['nb_attaquants'] = count($attaquant_flotte);
		$combat['nb_defenseurs'] = count($defenseur_flotte);
		// On aura aussi besoin de ces infos plus tard, il faut les stocker ailleurs
		$nb_attaquants = $combat['nb_attaquants'];
		$nb_defenseurs = $combat['nb_defenseurs'];
		$passes = 0;
		while ($combat['nb_attaquants'] > 0 AND $combat['nb_defenseurs'] > 0)
		{
			$passes++;
			$att_flotte = $attaquant_flotte;
			$def_flotte = $defenseur_flotte;
			$survivant = $combat['nb_defenseurs'];
			$cible = $defenseur_flotte;
			$compteur1 = 0;
			while (count($att_flotte) > 0 AND $survivant > 0) // tant qu'il y a un opposant disponible
			{
				if ($att_flotte[0]['etat'] != "Detruit")
				{
					// Génération d'une variable aléatoire déterminant les chances de toucher
					$chance = rand(0, 100);
					if ($chance > 75)
					{
						$compteur1++;
					}
					else
					{
						$cible_precise = count($cible) - $survivant;
						$priorite = 0;

						while ($def_flotte[$priorite]['etat'] == "Detruit") // gère les cibles détruites
						{
							array_shift($def_flotte) ; // supprime le plus fort
						}

						$puissance_feu = $att_flotte[0]['arme'];
						if ($puissance_feu > $def_flotte[$priorite]['bouclier']) // si arme sup à bouclier
						{
							$cible[$cible_precise]['coque'] -= ($puissance_feu - $def_flotte[$priorite]['bouclier']);
							if ($cible[$cible_precise]['coque'] <= 0)
							{
								$cible[$cible_precise]['etat'] = "Detruit";
								$survivant--;
								array_shift($def_flotte); // supprime le plus fort
							}
						}
						array_shift($att_flotte);
					}
				}
				else
				{
				array_shift($att_flotte);
				}
			}		
			$combat['nb_defenseurs'] = $survivant;
			$att_flotte = $attaquant_flotte;
			$def_flotte = $defenseur_flotte;
			$survivant = $combat['nb_attaquants'];
			$cible = $attaquant_flotte;
			$compteur2 = 0;
			while (count($att_flotte) > 0 AND $survivant > 0) // tant qu'il y a un opposant disponible
			{
				if ($att_flotte[0]['etat'] != "Detruit")
				{
					// Génération d'une variable aléatoire déterminant les chances de toucher
					$chance = rand(0, 100);
					if ($chance > 75)
					{
					$compteur2++;
					}
					else
					{
						$cible_precise = count($cible) - $survivant;
						$priorite = 0;

						while ($def_flotte[$priorite]['etat'] == "Detruit") // gère les cibles détruites
						{
							array_shift($def_flotte) ; // supprime le plus fort
						}

						$puissance_feu = $att_flotte[0]['arme'];
						if ($puissance_feu > $flotteB[$priorite]['bouclier']) // si arme sup à bouclier
						{
						$cible[$cible_precise]['coque'] -= ($puissance_feu - $flotteB[$priorite]['bouclier']);
						if ($cible[$cible_precise]['coque'] <= 0)
						{
						$cible[$cible_precise]['etat'] = "Detruit";
						$survivant--;
						array_shift($def_flotte); // supprime le plus fort
						}
						}
						array_shift($att_flotte);
					}
				}
				else
				{
					array_shift($att_flotte);
				}
			}		
			
			$combat['nb_attaquants'] = $survivant;
		}
		$this->rapport .= spintf($lang->recuplng('combat_vaisseaux_ratent_cible'), $compteur1, $compteur2) . '<br />';
		$this->rapport .= spintf($lang->recuplng('combat_nb_survivants_apres_passes'), $passes, $combat['nb_attaquants'], $combat['nb_defenseurs']) . '<br />';

		// On gère la défaite du défenseur
		if ($combat['nb_defenseurs'] == 0)
		{
		$victoireatt = 1;
		// On récupère 60% des ressources des vaisseaux détruits
		$ressources_defenseur = array();
		$i = 0;
		while ($i <= $nb_defenseurs)
		{
		// On récupère les ressources pour chaque vaisseau $i
		$tabrestmp = explode(',', $defenseur_flotte[$i]['ressources']);
		$j = 0;
		while ($j <= count($tabrestmp))
		{
		// Pour chaque ressource, on calcule 60% de sa valeur et on la stocke dans un tableau
		if ($j == 0)
		{
		$ressources_defenseur[$j] = 0 + ceil(($tabrestmp[$j] * 0.6));
		}
		else
		{
		$ressources_defenseur[$j] += ceil(($tabrestmp[$j] * 0.6));
		}
		$j++;
		}
		$i++;
		}
		// On a les ressources totales, on décime tous les vaisseaux du défenseur
		$vaisseaux_defenseur = array();
		$sql->update("UPDATE TABLE " . _PREFIX_ . _TABLE_PLANETES_ . " SET vaisseaux='' WHERE id='" . $planetearrivee . "'");

		// On met à jour les vaisseaux de l'attaquant
		$tabvaisseaux_attaquant = array();
		$fret_attaquant = 0;
		$i = 0;
		$compteur = 0; // Compte le nombre de vaisseaux détruits
		while ($i <= $nb_attaquants)
		{
		if ($attaquant_flotte[$i]['etat'] != 'Detruit')
		{
		$tabvaisseaux_attaquant[] = $attaquant_flotte[$i]['id'];
		$fret_attaquant += $attaquant_flotte[$i]['stockage'];
		}
		else
		{
		$compteur++;
		}
		$i++;
		}

		// On gère le fret en fonction du stockage des vaisseaux restants, de $ressources_defenseur et des ressources de la planète du défenseur
		$ressB = array();
		$i = 0;
		while ($i <= count($ressources_defenseur))
		{
		if ($ressources_defenseur <= $fret_attaquant)
		{
		$ressB[$i] = $ressources_defenseur;
		}
		else
		{
		$ressB[$i] = $fret_attaquant;
		}
		$i++;
		}
		$ressdef = explode(',', $rowB['ressources']);
		$i = 0;
		while ($i <= count($ressdef))
		{
		if (ceil(0.6 * $ressdef[$i]) <= ($fret_attaquant - $ressB[$i]))
		{
		$ressB[$i] += ceil(0.6 * $ressdef[$i]);
		}
		$i++;
		}
		// On prépare le tableau des ressources pour afficher dans le rapport
		$tab = array();
		$i = 0;
		$rowress = $sql->query("SELECT nom FROM " . _PREFIX_ . _TABLE_RESSOURCES_ . "");
		while ($i <= count($ressB))
		{
		$tab[$i] = array('nom' => $rowress[$i], 'valeur' => $ressB[$i]);
		$i++;
		}
		// On prépare le rapport
		$ress = '';
		$i = 0;
		while ($i <= count($tab))
		{
		$ress .= $tab[$i]['nom'] . ' : ' . $tab[$i]['valeur'] . '<br />';
		$i++;
		}
		$ressources_finales = implode(',', $ressB);
		// On met à jour les vaisseaux et les ressources à déplacer de la mission
		$sql->update("UPDATE TABLE " . _PREFIX_ . _TABLE_MISSIONS_ . " SET etat='2', ressourcesadeplacer='" . $ressources_finales . "', vaisseaux='" . implode(',', $tabvaisseaux_attaquant) . "' WHERE id='" . $row['id'] . "'");

		// Mise à jour du rapport
		$this->rapport .= $lang->recuplng('combat_defaite_defenseur') . '<br />';
		$this->rapport .= sprintf($lang->recuplng('combat_attaquant_perd'), $compteur) . '<br />';
		$this->rapport .= sprintf($lang->recuplng('combat_defenseur_perd'), $nb_defenseurs) . '<br />';
		$this->rapport .= sprintf($lang->recuplng('combat_attaquant_gagne'), $ress) . '<br />';
		}
		// On gère la défaite de l'attaquant
		if ($combat['nb_attaquants'] == 0)
		{
		$victoireatt = 0;
		// On récupère 60% des ressources des vaisseaux détruits
		$ressources_attaquant = array();
		$i = 0;
		while ($i <= $nb_attaquants)
		{
		// On récupère les ressources pour chaque vaisseau $i
		$tabrestmp = explode(',', $attaquant_flotte[$i]['ressources']);
		$j = 0;
		while ($j <= count($tabrestmp))
		{
		// Pour chaque ressource, on calcule 60% de sa valeur et on la stocke dans un tableau
		if ($j == 0)
		{
		$ressources_attaquant[$j] = 0 + ceil(($tabrestmp[$j] * 0.6));
		}
		else
		{
		$ressources_attaquant[$j] += ceil(($tabrestmp[$j] * 0.6));
		}
		$j++;
		}
		$i++;
		}
		$ressources_attaquant = implode(',', $ressources_attaquant);
		// On met à jour des ressources sur la planète du défenseur
		$ressourcesB = modif_ressources($rowB['ressources'], '+', $ressources_attaquant);
		// On prépare le tableau des ressources pour afficher dans le rapport
		$tab = array();
		$i = 0;
		$rowress = $sql->query("SELECT nom FROM " . _PREFIX_ . _TABLE_RESSOURCES_ . "");
		$tabtmp = explode(',', $ressourcesB);
		while ($i <= count($tabtmp))
		{
		$tab[$i] = array('nom' => $rowress[$i], 'valeur' => $tabtmp[$i]);
		$i++;
		}
		// On prépare le rapport
		$ress = '';
		$i = 0;
		while ($i <= count($tab))
		{
		$ress .= $tab[$i]['nom'] . ' : ' . $tab[$i]['valeur'] . '<br />';
		$i++;
		}
		$sql->update("UPDATE TABLE " . _PREFIX_ . _TABLE_PLANETES_ . " SET ressources='" . $ressourcesB . "' WHERE id='" . $planetearrivee . "'");
		// On met à jour les vaisseaux du défenseur
		$tabvaisseaux_defenseur = array();
		$i = 0;
		$compteur = 0; // Compte le nombre de vaisseaux détruits
		while ($i <= $nb_defenseur)
		{
		if ($defenseur_flotte[$i]['etat'] != 'Detruit')
		{
		$tabvaisseaux_defenseur[] = $defenseur_flotte[$i]['id'];
		}
		else
		{
		$compteur++;
		}
		$i++;
		}
		$tabvaisseaux_defenseur = implode(',', $tabvaisseaux_defenseur);
		$sql->update("UPDATE TABLE " . _PREFIX_ . _TABLE_PLANETES_ . " SET vaisseaux='" . $tabvaisseaux_defenseur . "', ressources='" . $ressourcesB . "' WHERE id='" . $planetearrivee . "'");
		// Mise à jour du rapport
		$this->rapport .= $lang->recuplng('combat_defaite_attaquant') . '<br />';
		$this->rapport .= sprintf($lang->recuplng('combat_attaquant_perd'), $nb_attaquants) . '<br />';
		$this->rapport .= sprintf($lang->recuplng('combat_defenseur_perd'), $compteur) . '<br />';
		$this->rapport .= sprintf($lang->recuplng('combat_defenseur_ressources_athmosphere'), $ress) . '<br />';
		}
		// Envoi du rapport à l'attaquant et au défenseur
		$query = $sql->query("INSERT INTO " . _PREFIX_ . _TABLE_MESSAGERIE_ . " VALUES ('', 'Systeme', '', '', '" . mysql_real_escape_string(htmlspecialchars($lang->recuplng('missioncombatrapport'))) . "', '" . mysql_real_escape_string(htmlspecialchars($this->rapport)) . "', '" . time() . "', '" . mysql_real_escape_string(htmlspecialchars($attaquant['pseudo'])) . "')" );
		$query = $sql->query("INSERT INTO " . _PREFIX_ . _TABLE_MESSAGERIE_ . " VALUES ('', 'Systeme', '', '', '" . mysql_real_escape_string(htmlspecialchars($lang->recuplng('missioncombatrapport'))) . "', '" . mysql_real_escape_string(htmlspecialchars($this->rapport)) . "', '" . time() . "', '" . mysql_real_escape_string(htmlspecialchars($defenseur['pseudo'])) . "')" );
		// Si l'attaquant a gagné, on ne supprime pas la mission
		if ($victoireatt != 1)
		{
		// On supprime la mission pour le joueur ayant la planète A
		$i = 0;
		$tab = array();
		while ($i <= count($missionsatt))
		{
		if ($missionsatt[$i] != $id)
		{
		$tab[] = $missionsatt[$i];
		}
		$i++;
		}
		$query = $sql->update("UPDATE TABLE " . _PREFIX_ . _TABLE_MEMBRES_ . " SET missionsencours='" . $missionsatt['missionsencours'] . "' WHERE id='" . $attaquant['id'] . "'");
		// On supprime la mission pour le joueur ayant la planète B
		$i = 0;
		$tab = array();
		while ($i <= count($missionsdef))
		{
		if ($missionsdef[$i] != $id)
		{
		$tab[] = $missionsdef[$i];
		}
		$i++;
		}
		$query = $sql->update("UPDATE TABLE " . _PREFIX_ . _TABLE_MEMBRES_ . " SET missionsencours='" . $missionsdef['missionsencours'] . "' WHERE id='" . $defenseur['id'] . "'");
		$query = $sql->query("DELETE * FROM " . _PREFIX_ . _TABLE_MISSIONS_ . " WHERE id='" . $row['id'] . "'");
		}
		
		*/				
					
					
					
					
					
					
					
					
		
		$ressourcesquery = sql::query("SELECT * FROM ".PREFIXE_TABLES.TABLE_RESSOURCES." ");

		$nbresstotal = mysql_num_rows($ressourcesquery);

		$ressourcesgagnees = "";

		$base = sql::select("SELECT * FROM ".PREFIXE_TABLES.TABLE_BASES." WHERE id='" . $row["base_arrivee"] . "'");

		$advuser = sql::select("SELECT * FROM ".PREFIXE_TABLES.TABLE_USERS." WHERE id='".$base["utilisateur"]."'");

		$adversaire = $this->calculer_attaque_et_defense($base["unites"], $base["defenses"]);

		$adversaire2 = explode("|", $adversaire);
		$advattaque = $adversaire2[0] * (1 + ($advuser["attaque_supplementaire"] / 100));
		$advdefense = $adversaire2[1] * (1 + ($advuser["defense_supplementaire"] / 100));
		$advbouclier = $adversaire2[2] * (1 + ($advuser["bouclier_supplementaire"] / 100));

		if ($advdefense != 0 && $advbouclier != 0 && $advattaque != 0 && $advdefense != "" && $advbouclier != "" && $advattaque != "") 
		{
			$coeff1 = $row["attaque"] / ($advdefense+$advbouclier);
			$coeff2 = $row["defense"] / $advattaque;
			$coeff3 = $row["bouclier"] / $advattaque;
		} 
		else 
		{
			$coeff1 = 2;	
			$coeff2 = 2;
			$coeff3 = 2;
		}

        $coefftotal = $coeff1 + $coeff2+ $coeff3;

		if ($coefftotal > 2.5) // Gagne
		{ 
			$gagne = 1;
			$unitmax = explode(",", $base["ressources"]);

			$nombre = 0;
			$total = 0;
			while ($nombre < $nbresstotal) 
			{
				if($unitmax[$nombre] >= 0 && $unitmax[$nombre] != '') 
				{
					$ressg[$nombre] = rand(1, $unitmax[$nombre]);
				} 
				else 
				{
					$ressg[$nombre] = 0;
				}

				$total = $total + $ressg[$nombre];

				$nombre = $nombre + 1;
			}

			$coeffm = 1;

			if($total > $row["stockage"])
			{
				$coeffm = ($row["stockage"]/$total);
			}

			$nombre = 0;

			while(isset($ressg[$nombre])) 
			{
				$ressg[$nombre] = $ressg[$nombre] * $coeffm;

				$nombre = $nombre + 1;
			}


			$ressourcesgagnees = implode(",", $ressg);
			$base["ressources"] = implode(",", $unitmax);

			if(!empty($ressourcesgagnees)) 
			{
				$ressfinales = $this->modif_ressources($base["ressources"], "-", $ressourcesgagnees);            
			}

		} 
		elseif ($coefftotal < 1.5) // Perd
		{
			$gagne = 0;
		} 
		else // En cas d'egalité
		{ 
			$gagne = 2;
		}

		$id = $row["id"];
		$user_depart = $row["user_arrivee"];
		$user_arrivee = $row["user_depart"];
		$base_depart = $row["base_arrivee"];
		$base_arrivee = $row["base_depart"];
		$base_proprietaire = $row["base_proprietaire"];
		$tps_total = $row["tps_total"];
		$heure_arrivee = time() + $tps_total - (time() - $row["heure_arrivee"]);
		$mission = 1;
		$ressources = $this->modif_ressources($ressourcesgagnees, "+", $row["ressources"]);

		if($gagne == 1) 
		{

			$unitmax2 = explode(",", $base["unites"]);
			$nombre = 0;
			while ($unitmax2[$nombre] != "") 
			{
				if($unitmax2[$nombre] != 0 && $unitmax2[$nombre] != '') 
				{
					$ressg2[$nombre] = round(rand(1, ($unitmax2[$nombre]/2)));
				} 
				else 
				{

					$ressg2[$nombre] = 0;

				}
				
				$unitmax2[$nombre] = $unitmax2[$nombre] - $ressg2[$nombre];

				if($unitmax2[$nombre] < 0) 
				{
					$unitmax2[$nombre] = 0;
				}

				$nombre = $nombre + 1;
			}
			
			$unitesaprendre = implode(",", $ressg2);
			$base["unites"] = implode(",", $unitmax2);

			if($controlrow["att_conquerir"] == 1) 
			{
				$prendre = explode(",", $unitesaprendre);
				$nombre = 0;
				while ($prendre[$nombre] != "") 
				{
					$prendre[$nombre] = round($prendre[$nombre]/2);
					$nombre = $nombre + 1;
				}
				$prendre = implode(",", $prendre);
				$row["unites"] = $this->modif_ressources($row["unites"], "+", $prendre);
			}


		} 
		elseif($gagne == 0) 
		{

			$unitmax2 = explode(",", $row["unites"]);
			$nombre = 0;
			while ($unitmax2[$nombre] != "") 
			{

				if($unitmax2[$nombre] != 0 && $unitmax2[$nombre] != '') 
				{

					$ressg2[$nombre] = round(rand(1, ($unitmax2[$nombre]/2)));

				} 
				else 
				{

					$ressg2[$nombre] = 0;

				}

				$unitmax2[$nombre] = $unitmax2[$nombre] - $ressg2[$nombre];
				$nombre = $nombre + 1;
			}
			
			$unitesperdues = implode(",", $ressg2);
			$row["unites"] = implode(",", $unitmax2);

		}

		sql::update("UPDATE ".PREFIXE_TABLES.TABLE_UNITES." SET
		user_depart='" . $user_depart . "',
		user_arrivee='" . $user_arrivee . "',
		base_depart='" . $base_depart . "',
		base_arrivee='" . $base_arrivee . "',
		base_proprietaire='" . $base_proprietaire . "',
		heure_arrivee='" . $heure_arrivee . "',
		tps_total='" . $tps_total . "',
		ressources='" . $ressources . "',
		mission='" . $mission . "',
		unites='".$row["unites"]."'  
		WHERE id='" . $id . "'");

		sql::update("UPDATE ".PREFIXE_TABLES.TABLE_BASES." SET ressources='" . $ressfinales . "', unites='".$base["unites"]."' WHERE id='" . $base["id"] . "'");


		// affichage rapport
		$user1 = sql::select("SELECT nom FROM ".PREFIXE_TABLES.TABLE_USERS." WHERE id='" . $row["user_depart"] . "'");
		$user2 = sql::select("SELECT nom FROM ".PREFIXE_TABLES.TABLE_USERS." WHERE id='" . $row["user_arrivee"] . "'");
		$attaquant = $user1["nom"];
		$defenseur = $user2["nom"];

		$txtrapport = "Rapport de combat entre <b>" . $attaquant . "</b> et <b>" . $defenseur . "</b>.<br>
		<table border=1><tr><td></td><td><b>" . $attaquant . "</b></td><td><b>" . $defenseur . "</b></td></tr>

		<tr><td>Attaque : </td><td><b>" . $row["attaque"] . "</b></td><td><b>" . $advattaque . "</b></td></tr>

		<tr><td>Défense : </td><td><b>" . $row["defense"] . "</b></td><td><b>" . $advdefense . "</b></td></tr>

		<tr><td>Bouclier : </td><td><b>" . $row["bouclier"] . "</b></td><td><b>" . $advbouclier . "</b></td></tr>

		</table><br><br>";

		if ($gagne == 1) // Gagne
		{
			$txtrapport .= "<b>" . $attaquant . "</b> a gagné la bataille. <br>Il remporte : <br>";
			$ress = sql::query("SELECT * FROM ".PREFIXE_TABLES.TABLE_RESSOURCES." ORDER BY id");
			$ress2 = explode(",", $ressourcesgagnees);
			while ($row2 = mysql_fetch_array($ress)) 
			{
				$txtrapport .= $row2["nom"] . " : " . $ress2[$row2["id"] - 1] . "<br>";
			}
		} 
		elseif ($gagne == 0) // Perd
		{ 
			$txtrapport .= "<b>" . $defenseur . "</b> a gagné la bataille.";
		} 
		else // Nul
		{
			$txtrapport .= "Personne ne gagne la bataille.";
		}


		if($gagne == 1) 
		{

			$txt2 = "<br><br>Vous avez perdu : <br>";

			$ress = sql::query("SELECT * FROM ".PREFIXE_TABLES.TABLE_CHANTIER." ORDER BY id");
			$ress2 = explode(",", $unitesaprendre);
			while ($row2 = mysql_fetch_array($ress)) 
			{
				$txt1 .= $row2["nom"] . " : " . $ress2[$row2["id"] - 1] . "<br>";
			}

			if($controlrow["att_conquerir"] == 1) 
			{

				$txt1 = "<br><br>Vous avez remporté : <br>";

				$ress = sql::query("SELECT * FROM ".PREFIXE_TABLES.TABLE_CHANTIER." WHERE race_".$userrow["race"]."='1' ORDER BY id");
				$ress2 = explode(",", $prendre);
				while ($row2 = mysql_fetch_array($ress)) 
				{

					if($ress2[$row2["id"] - 1] == "") 
					{
						$ress2[$row2["id"] - 1] = 0;
					}
					if($ress2[$row2["id"] - 1] != 0) 
					{

						$txt1 .= $row2["nom"] . " : " . $ress2[$row2["id"] - 1] . "<br>";

					}

				}

			}

		} 
		elseif($gagne == 0)
		{

			$txt1 = "<br><br>Vous avez perdu : <br>";

			$ress = sql::query("SELECT * FROM ".PREFIXE_TABLES.TABLE_CHANTIER." WHERE race_".$userrow["race"]."='1' ORDER BY id");
			$ress2 = explode(",", $unitesperdues);
			while ($row2 = mysql_fetch_array($ress)) 
			{

				if($ress2[$row2["id"] - 1] == "") 
				{
					$ress2[$row2["id"] - 1] = 0;
				}

				if($ress2[$row2["id"] - 1] != 0) 
				{

					$txt1 .= $row2["nom"] . " : " . $ress2[$row2["id"] - 1] . "<br>";

				}
			}

		}

		sql::update("INSERT INTO ".PREFIXE_TABLES.TABLE_MESSAGERIE." SET
						destinataire='" . $row["user_depart"] . "',
						titre='RAPPORT DE COMBAT',
						message='" . addslashes($txtrapport.$txt1) . "',
						systeme='1',
						date='" . time() . "'
					");
		
		sql::update("INSERT INTO ".PREFIXE_TABLES.TABLE_MESSAGERIE." SET
						destinataire='" . $row["user_arrivee"] . "',
						titre='RAPPORT DE COMBAT',
						message='" . addslashes($txtrapport.$txt2) . "',
						systeme='1',
						date='" . time() . "'
					");
		// FIN RAPPORT
	} // fin fonction mission attaque

	###############################################################################
	/*******************************************************************************************************\

	\*******************************************************************************************************/
	function mission1($row) // retour
	{ 
		$base = sql::select("SELECT * FROM ".PREFIXE_TABLES.TABLE_BASES." WHERE id='" . $row["base_arrivee"] . "'");
		$newunites = $this->modif_ressources($base["unites"], "+", $row["unites"]);
		$newressources = $this->modif_ressources($base["ressources"], "+", $row["ressources"]);
		sql::update("UPDATE ".PREFIXE_TABLES.TABLE_BASES." SET unites='" . $newunites . "', ressources='" . $newressources . "' WHERE id='" . $base["id"] . "'");
		sql::update("DELETE FROM ".PREFIXE_TABLES.TABLE_UNITES." WHERE id='" . $row["id"] . "'");
	}

	###############################################################################
	/*******************************************************************************************************\

	\*******************************************************************************************************/
	function mission3($row) // transport
	{ // debut fonction mission transport

		$ress = sql::select("SELECT ressources FROM ".PREFIXE_TABLES.TABLE_BASES." WHERE id='".$row["base_arrivee"]."'");

		$newress = $this->modif_ressources($ress["ressources"], "+", $row["ressources"]);

		$ress = sql::update("UPDATE ".PREFIXE_TABLES.TABLE_BASES." SET ressources='".$newress."' WHERE id='".$row["base_arrivee"]."'");

		$id = $row["id"];
		$user_depart = $row["user_arrivee"];
		$user_arrivee = $row["user_depart"];
		$base_depart = $row["base_arrivee"];
		$base_arrivee = $row["base_depart"];
		$base_proprietaire = $row["base_proprietaire"];
		$tps_total = $row["tps_total"];
		$heure_arrivee = time() + $tps_total - (time() - $row["heure_arrivee"]);
		$mission = 1;
		$ressources = "";

		sql::update("UPDATE ".PREFIXE_TABLES.TABLE_UNITES." SET
						user_depart='" . $user_depart . "',
						user_arrivee='" . $user_arrivee . "',
						base_depart='" . $base_depart . "',
						base_arrivee='" . $base_arrivee . "',
						base_proprietaire='" . $base_proprietaire . "',
						heure_arrivee='" . $heure_arrivee . "',
						tps_total='" . $tps_total . "',
						ressources='" . $ressources . "',
						mission='" . $mission . "' WHERE id='" . $id . "'
					");
	}

	###############################################################################
	/*******************************************************************************************************\

	\*******************************************************************************************************/
	function mission2($row) // Espionnage
	{

		global $controlrow;

		$base = sql::select("SELECT nom, ressources, unites FROM ".PREFIXE_TABLES.TABLE_BASES." WHERE id='".$row["base_arrivee"]."' LIMIT 1");

		$base["ressources"] = $this->ress_esp($base["ressources"]);

		$puissance = $this->calculer_attaque_et_defense($base["unites"], $base["defenses"]);

		$pui = explode("|", $puissance);
		$ress2 = "";
		$ress = sql::query("SELECT * FROM ".PREFIXE_TABLES.TABLE_RESSOURCES." ORDER BY id");
		$ress3 = explode(",", $base["ressources"]);
		while ($row2 = mysql_fetch_array($ress)) 
		{
			$ress2 .= $row2["nom"] . " : " . number_format($ress3[$row2["id"] - 1], 0, ".",".") . "<br>";
		}


		$txt = "Rapport d\'espionnage de la ".$controlrow["nom_bases"]." <b>".$base["nom"]."</b>.<br><br>
		Ses ressources approximatives sont : <br>".$ress2."<br><br>
		La puissance approximative de l\'adversaire est : 
		<br><br>Attaque : ".$pui[0]."<br>Défense : ".$pui[1]."<br>Bouclier : ".$pui[2];



		$id = $row["id"];
		$user_depart = $row["user_arrivee"];
		$user_arrivee = $row["user_depart"];
		$base_depart = $row["base_arrivee"];
		$base_arrivee = $row["base_depart"];
		$base_proprietaire = $row["base_proprietaire"];
		$tps_total = $row["tps_total"];
		$heure_arrivee = time() + $tps_total - (time() - $row["heure_arrivee"]);
		$mission = 1;

		sql::update("UPDATE ".PREFIXE_TABLES.TABLE_UNITES." SET
						user_depart='" . $user_depart . "',
						user_arrivee='" . $user_arrivee . "',
						base_depart='" . $base_depart . "',
						base_arrivee='" . $base_arrivee . "',
						base_proprietaire='" . $base_proprietaire . "',
						heure_arrivee='" . $heure_arrivee . "',
						tps_total='" . $tps_total . "',
						mission='" . $mission . "' WHERE id='" . $id . "'
					");

		sql::update("INSERT INTO ".PREFIXE_TABLES.TABLE_MESSAGERIE." SET
						destinataire='" . $row["user_depart"] . "',
						titre='ESPIONNAGE',
						message='" . $txt . "',
						systeme='1',
						date='" . time() . "'
					");


	}

}

?>