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

/*

Mettre a jour $baserow['map'] pour changer contenu_case,contenu_case en id-contenu,id2-contenu2
Mettre a jour $baserow["batiments"] pour changer niveau_bat,niveau_bat2e en id-niveau,id2-niveau2
Mettre a jour $userrow["recherches"] pour changer niveau_bat,niveau_bat2e en id-niveau,id2-niveau2
$controlrow['nombres_cases_sur_cartes']
$contolrow['type_batiments'] == 'liste', carte


*/

// On inclue la classe permettant de gerer les constructions
include("classes/construction.class.php");
$const = new construction;

// DEBUT TEST
	$controlrow['nombres_cases_sur_cartes'] = 90;
	$controlrow['type_batiments'] = 'liste';
	// Etant donnée que les cases son pour le moment sous forme 0,0,0,0,0,0,1,0,0,1,-1,0,0,0,0,-1 le script ne peut pas marcher, on va donc changer les cases pour leur donner la forme numero_case-contenu_case,numero_case2-contenu_case2
	$mmap = eregi_replace('-1', '°1°', $baserow['map']); // On change les -1 des arbres en /1\
	$mmap = eregi_replace('-2', '°2°', $mmap); // On change les -2 des construction en cours, en /2\
	$baserow['map'] = $const->format_niv($mmap); // On transforme les champs en champ normale
	// Voila maintenant le champ map contient numer_case-contenu,numero_case-contenu2 a la place de contenu,contenu2
	
	// On fait de meme pour les batiments stocké dans la BDD
	$baserow['batiments'] = $const->format_niv($baserow['batiments']); // On transforme les champs en champ normale
	// Et aussi pour les recherches
	$userrow['recherches'] = $const->format_niv($userrow['recherches']); // On transforme les champs en champ normale

// FIN TEST


// DEBUT ON RECUPERES LES NIVEAUX DES BATIMENTS DU JOUEUR		
	$niv = $const->niveaux($baserow["batiments"]);
// FIN ON RECUPERES LES NIVEAUX DES BATIMENTS DU JOUEUR		

// DEBUT TRAITEMENT DANS LE CAS OU UN BATIMENT EST EN COURS
	if($baserow['batimentencours'] != '' || $baserow['batimentencours'] != '0') // Dans le cas ou un batiment est en cours
	{ // Debut if traitement batiment en cours
		
		
		
	} // Fin if traitement batiment en cours
	
// FIN TRAITEMENT DANS LE CAS OU UN BATIMENT EST EN COURS
	
		
switch(@$_GET['action'])
{ // debut switch get action

	###############################################################

	case 'construire': // Si on a demander a construire un batiment
		
		if(!empty($_GET['batiment']) ) // On traite la demande de construction qui si un batiment a bien été posté
		{ // debut if traiter demande de construction
			
			// On recupere les contenus de chaque cases
			$case = $const->niveaux($baserow['map']);
			
			// On recuperes les infos sur le batiment a construire, oen verifiant si il est bien disponible pour la race du joueur
			$batrow = $sql->select('SELECT * FROM phpsim_batiments WHERE race_'.$userrow["race"].'="1" and id="'.$_GET['batiment'].'" LIMIT 1 ');
			
			if(empty($batrow) ) // Dans ce cas c'est que le batiment n'existe ps ou qu'il n'est pas acessible pur le joueur
			{
				die('
					  <script>
						alert("'.$lang->recup('batiment_non_existant').'");
						document.location="?mod=batiments&miseenforme=1"
					  </script>
					');
			} 
			// Dans le cas ou le batiment est bien present alors on le traite (Inutile de faire un else puisque le fi de dessus bloque le script)
			
			// On verifie que le niveau maximum n'est pas été atteint
			if( $niv[$batrow["id"]] >= $batrow["niveau_max"] && $batrow["niveau_max"] != 0 ) 
			{
				die('
					  <script>
						alert("'.$lang->recup('niveau_max_atteint').'");
						document.location="?mod=batiments&miseenforme=1"
					  </script>
					');
			}
		
			// On verifie qu'il reste de la place sur la planete
			if($baserow["cases_max"] <= $baserow["cases"]) 
			{
				die('
					  <script>
						alert("'.$lang->recup('planete_pleine').'");
						document.location="?mod=batiments&miseenforme=1"
					  </script>
					');
			}
			
			// On teste si le joueur possede les ressources necessaires
			$ress_manquantes2 = $const->ressources_manquantes($batrow); // Renvoye un tableau
			$ress_manquantes = $ress_manquantes2['construction_impossible']; // Recupere un chiffre, Si 1 alors il manque des ressources, si 0 alors il ne manuqe pas de ressources
			if($ress_manquantes == '1') // On recupere simplement la variable qui permet de definir si une construction est possible ou pas
			{
				die('
					  <script>
						alert("'.$lang->recup('ressources_manquantes').'");
						document.location="?mod=batiments&miseenforme=1"
					  </script>
					');
			}
			

			// On verifie que les batiment et les recherches necessaire a la construction sont bien disponible
			$acces_bat = $const->batiments_necessaire($batrow);
			$acces_rech = $const->recherches_necessaire($batrow);
			if($acces_bat == 0 || $acces_rech == 0) // Dans le cas ou la construction est impossible
			{
				die('
					  <script>
						alert("'.$lang->recup('necesssaire_non_debloquer_pour_construire_batiment').'");
						document.location="?mod=batiments&miseenforme=1"
					  </script>
					');
			}	

			// Dans le cas ou le joueur a posté une case, on verifie qu'elle n'est pas deja occupé par un autre batiment
			if(!empty($_GET['case']) )
			{
				if(empty($case[$_GET['case']]) ) // Dans le cas ou la case n'a pas été defini dans SQL, cela veut dire qu'il ny a rien dessus
				{
					// On incremente pour ne pas provoqué d'erreur
					$case[$_GET['case']] = '0';
				}
				
				if($case[$_GET['case']] != '0' && $case[$_GET['case']] != '°1°' && $case[$_GET['case']] != '°2°')
				{ // Dans ce cas la case contient un batiment
					// On verifie que le batiment que cette case contient est bien le batiment qu'on veut construire, si ce n'est pas le cas on bloque
					if($case[$_GET['case']] != $batrow['id'])
					{
						die('
							  <script>
								alert("'.$lang->recup('impossible_de_construire_un_batiment_different_sur_case').'");
								document.location="?mod=batiments&miseenforme=0";
							  </script>
							');
					}
					else // Dans le cas ou le batiment a deja été construit
					{
						$cases_sql = 'no_modif'; // On defini qu'il ne faut pas modifier les cases dans SQL
						$maj_case = $_GET['case'];
					}
				}
				elseif($case[$_GET['case']] == '0') // Dans le cas ou la case contient 0 c'est qu'il ny a rien de construit, on peut alors construire dessus
				{
					// $_GET['case'] contient le numero de la case sur laquelle on souhaite construire
				
					$case[$_GET['case']] = '°2°'; // On change la valeur de la case en definissant qu'elle est en construction
					
					$cases = array();
					
					foreach($case AS $casee) // On traite chaque case, 
					{
						$cases[] = $casee[0].'-'.$casee[1]; // On remet ici le numero de la case et son contenu dans la meme clé du tableau
					}

					$cases_sql = implode(",", $cases); // On remet sous forme id-contenu,id2-contenu2
					$maj_case = $_GET['case'];
				}
			}
			else // Dans le cas ou $_GET['case'] est vide, alors le joueur n'a pas choisi de case, on va lui en attribuer une au hasard, et prenant soin de ne pas en attribuer une qui n'est pas disponible
			{ // On arrive ici dans le cas ou le type carte a été desactivé
				// On commence par regarder si le batiment n'est construit sur aucune cases
				$nb = 1; // On incremente la variable
				while($nb <= count($case) ) // On passe dans le while tant que l'on a pas passer chaque case
				{
					if($case[$nb] == $batrow['id']) // Dans le cas ou le contenu de la case est le batiment qu'on a demander a construire
					{
						$case_du_batiment = $nb; // On recupere le numero de la case ayant le batiment
						break; // On arrete le while quand on a trouver la case
					}
					$nb++; // On incremente la variable
				}
				
				if(!empty($case_du_batiment) ) // Dans le cas ou le batiment a été trouvé sur une case
				{
					// Alors on recupere les cases pour les mettre dans SQL
					$cases_sql = 'no_modif'; // Alors on defini qu'il ne faut pas modifier le SQL des cases
					$maj_case = $case_du_batiment; 
				}
				else // Dans le cas ou la case n'a pas été trouvé, c'est que le batiment n'a jamais été construit
				{
					// On arttribue une case au hasard pour le batiment, en prenant soin de ne pas attribuer une case deja prise
					$recommencer = 0; // On defini la variable par default
					while($recommencer == 0)
					{
						$nouvelle_case = round(1, $controlrow['nombres_cases_sur_cartes']); // On choisi une case entre 1 et le nombre maximum de case defini sur l'admin
					
						if(empty($case[$nouvelle_case]) || $case[$nouvelle_case] == '0') // Dans le cas ou la case n'existe pas dans le SQL, ou dans le cas ou elle contient 0 ce qui veut dire qu'elle est libre
						{
							$case[$nouvelle_case] = '°2°'; // On change la valeur de la case en definissant qu'elle est en construction

							$cases = array();

							foreach($case AS $casee) // On traite chaque case, 
							{
								$cases[] = $casee[0].'-'.$casee[1]; // On remet ici le numero de la case et son contenu dans la meme clé du tableau
							}

							$cases_sql = implode(",", $cases); // On remet sous forme id-contenu,id2-contenu2
							$maj_case = $nouvelle_case;
							break; // Quand on a enfin notre case, on peut stopper la boucle
						}
						else // Dans le cas ou la case contient deja quelque chose
						{
							$recommencer = 1; // On definie qu'il faut recommencer la boucle
						}
					}
				
				}
			}
					

				
			// Dans le cas ou la page n'a pas été bloqué quand on arrive ici, c'est que la construction est possible
			
			// On recupere le nombres de ressources necesssaire pour créer le niveau
			$aajouter = $const->calculer_ressources($niv[$batrow['id']], $row["ressources"], $row["ressources_evo"]);
			
			// On recuperes les ressources restante apres avoir soustrait les ressources a utiliser
			$baseressources = $const->modif_ressources($baserow["ressources"], "-", $aajouter);

			// On calcule le temps necessaire a la construction
			$temps = $const->calculer_temps($niv[$batrow['id']], $batrow["tps"], $batrow["tps_evo"]);

			// On recupere le temps actuelle
			$timestamp = time();
			
			// On ecrit le champ batiment en cours en inserant id_ressources depensé_temps de construction_temps actuelle_emplacement du batiment sur les cases, si celle si est posté
			$batimentencours = $batrow['id'] . "_" 
							 . $aajouter . "_" 
							 . $temps . "_" 
							 . $timestamp . '_'
							 . $maj_case ;
			
			// On envoye les infos du batiment en cours, ainsi que les nouvelles case dans le SQL		
			$sql->update("UPDATE phpsim_bases SET 
								batimentencours='" . $batimentencours . "', 
								ressources='" . $baseressources . "'
								".( ($cases_sql == 'no_modif')?'': ",  map='".$cases_sql."' ")."
						   WHERE id='" . $baserow["id"] . "'
						  ");
						  
			echo "<script>document.location='?mod=batiments'); </script>";

			
			
			
		} // fin if traiter demande de construction
		else // Dans le cas ou le joueur n'a pas saisi de batiment
		{
			// On le redirige sur la page batiment
			die('<script>document.location="?mod=batiments&miseenforme=1"</script>');
		}
		
		
		
		
	break;
	
	###############################################################

	case 'liste': // On affiche la liste des batiments 
		
		// On recupere tous les batiments de la race du joueur en les triant par ordre
		$batiments = $sql->query("SELECT * FROM phpsim_batiments WHERE race_".$userrow["race"]."='1' ORDER BY ordre");

		if(mysql_num_rows($batiments) <= 0) // Dans le cas ou il n'y a pas de batiment dans la base de données
		{
			// on stoppe le script en affichant un message d'erreur
			$tpl->error($lang->recup('aucun_batiments_dans_base_de_donnees') ); //=> Il n'y a aucun batiment dans la base de données
		}
		else // Dans le cas ou il y a des batiments alors on les affiches
		{ // debut else il y a des batiments dans la BDD
			
			$nombrelignes = 0; // Incremente la variable

			$tpl->getboucle("batiments"); // Commence une boucle

			while ($batrow = mysql_fetch_array($batiments) ) 
			{ // debut while $batrow
				
				if(empty($niv[$batrow['id']]) ) // Dans le cas ou on a jamais construit le batiment, alors on defini que le niveau est egal a 0
				{
					$niv[$batrow['id']] = 0;
				}
				
				// On affiche le batiment que dans le cas
				// Si on se trouve avec batiment par carte, la variable $_GET['case'] contient la case sur laquelle in a cliquer, on affiche dans ce cas que les batiments qui n'ont encore pas été construit
				// Ou alors si on se trouve par affiche d'une liste normale, on affiche tous les batiments
				if( ( ($niv[$batrow['id']] == 0 || empty($niv[$batrow['id']]) ) && !empty($_GET['case']) )
					|| empty($_GET['case']) 
				  )
				{ // debut if afficher ou pas batiment
				
				
					if ($niv[$batrow["id"]] == '0') // Si le niveau du batiment est vide
					{
						$niveau = ' '; // Alors on affiche du vide a la place du niveau
					} 
					else // Sinon on affiche le niveau du joueur
					{
						$niveau = "( ".$lang->recup('niveau').' '. $niv[$batrow["id"]] . " )";
					}

					$rm = $const->ressources_manquantes($batrow); // On execute la fonction permettant de cacluler les ressources manquantes
					$temps_avant_dispo = $rm['ressources_manquantes'] ; // On recupere les ressources manquantes
					$construction_impossible= $rm['construction_impossible'] ; // Et une variable permet de savoir si il est possible ou pas de conestuire
					$ressourcespage = $const->afficher_ressources($batrow["ressources"], $batrow["ressources_evo"]); // On affiche les ressources dans un format formaté
					$temps = $const->calculer_temps($niv[$batrow["id"]], $batrow["tps"], $batrow["tps_evo"]); // On calcule l'evolution de temps par niveau
					$temps = $const->afficher_temps($temps); // On affiche le temps formaté
					
					$batimentencours = explode("_", $baserow["batimentencours"]); // On recupere la construction en cours

					$lien = "&nbsp;";

					if ($baserow["batimentencours"] == '') // Dans le cas ou il n'y a aucun batiment en construction, on affiche les liens pour construire
					{
						$niveauaconstruire = $niv[$batrow["id"]] + 1; // On recupere le niveau a construire

						
						if ($niv[$batrow["id"]] >= $batrow["niveau_max"] && $batrow["niveau_max"] != 0) 
						{ // Dans le cas ou le niveau maximum est atteint, on precise qu'on ne peut pas construire
							$lien = "<font color='red'>".$lang->recup('niveau_max_atteint')."</font>"; //=> Le niveau maximal à été atteint.
						}
						elseif($construction_impossible == 1 ) // Si construction impossible contient un 1 alors on n'a pas les ressources suffisantes
						{  // Dans le cas ou on a pas assez de ressources on le precise
						  $lien ="<font color='red'>".$lang->recup('ressources_manquantes')."</font>";
						}               
						elseif ($niv[$batrow["id"]] < $batrow["niveau_max"] || $batrow["niveau_max"] == 0) 
						{ // Dans le cas ou on peut construire
							$lien = '<a href=\'javascript:clic("batiments&action=construire&batiment=' . $batrow["id"] . ( (!empty($_GET['case']) )?'&case='.$_GET['case'].'':'').'" , "1");\'>
									 <font color=\'green\'>'.$lang->recup('construction_niveau').' ' . $niveauaconstruire . '</font></a>
									';
						} 
		
					} 
					elseif ($batimentencours[0] == $batrow["id"]) // Dans le cas ou le batiment en construction, et que c'est le batiment qu'on traite, alors on lui donne le compteur, avec le temps de construction restante
					{
						// On affiche le compte a rebours dynamique en JS avec le temps restant avant la fin
						$lien = "<div id='construction'>".$const->afficher_temps($batimentencours[2])."</div><script>construire('".$batimentencours[2]."'); </script>";
					}

					if ($baserow["cases"] >= $baserow["cases_max"]) // Dans le cas ou le nombre de case maximum est depassé
					{
						// On ne permet pas la construction 
						$lien = "<font color='red'>".$lang->recup('planete_pleine')."</font>";
					}
					
					// On regarde si les batiments necessaire sont bien dispo, si c'est le cas renvoye 1 sinon 0
					$acces_bat = $const->batiments_necessaire($batrow);
					
					// On regarde si les recherches necessaire sont bien dispo
					$acces_rech = $const->recherches_necessaire($batrow);
					
					if($acces_bat == 1 && $acces_rech == 1) // Dans le cas ou les batimens et recherches necessaire sont bien dispo
					{
						$accesb = 1; // On permet la construction
					}
					else // Dans le cas ou il manques des batiment ou recherches
					{
						$accesb = 0; // On ne permet pas la construction
					}
		
					if($accesb == 1) // Dans le cas ou le batiment est acessible, on l'affiche
					{
							    $tpl->value("id", $batrow["id"]);
							    $tpl->value("theme", $userrow["template"]);
							    $tpl->value("image", $batrow["image"]);
							    $tpl->value("nom", stripslashes(nl2br($batrow["nom"])));
							    $tpl->value("niveau", $niveau);
							    $tpl->value("description", stripslashes(nl2br($batrow["description"])));
							    $tpl->value('lang_ressources_manquantes', $lang->recup('ressources_manquantes').' : ');
								$tpl->value('lang_ressources', $lang->recup('ressources').' : ');
								$tpl->value('lang_temps', $lang->recup('temps').' : ');
								$tpl->value("ressources", $ressourcespage);
							    $tpl->value("temps", $temps);
							    $tpl->value("lien", $lien);
							    $tpl->value("temps_avant_dispo", $temps_avant_dispo);
							    
							    $tpl->boucle();
							    $nombrelignes++;

					}
					elseif($accesb == 0 && $controlrow['voir_batiments_inaccessibles'] == 1) // Dans le cas ou la batiment n'est pas accessible, mais qu'il est demander de voir les batiments acessible sur l'admin, on l'affiche, si c'est pas demander de l'afficher dans l'admin, alors il ne s'affichera pas
					{

							    $tpl->value("id", $batrow["id"]);
							    $tpl->value("theme", $userrow["template"]);
							    $tpl->value("image", $batrow["image"]);
							    $tpl->value("nom", stripslashes(nl2br($batrow["nom"])));
							    $tpl->value("niveau", $niveau);
							    $tpl->value("description", stripslashes(nl2br($batrow["description"]) ) );
							    $tpl->value('ressources', $lang->recup('necesssaire_non_debloquer_pour_construire_batiment') );
							    $tpl->value('lang_ressources_manquantes', '');
								$tpl->value('lang_ressources', '');
								$tpl->value('lang_temps', '');							   
							    $tpl->value("temps", '');
							    $tpl->value("lien", '');
							    $tpl->value("temps_avant_dispo", '');
							    
							    $tpl->boucle();
								
							    $nombrelignes++;

					}

				} // fin if afficher ou pas batiment
				
			} // fin while $batrow

			$page .= $tpl->finboucle();
		
			// Dans le cas ou on la carte est defini pour le jeu, et qu'aucun batiment ne peut encore etre ajouté (Dans le cas ou on se trauve sur liste tous les batiments sont affichés)
			if($nombrelignes == 0)
			{
				// On affiche un message d'alerte precisant qu'il ny a aucun batiment a ajouter, puis on redirige sur la carte
				die('
						<script>
							alert("'.$lang->recup('aucun_batiments_ne_peuvent_etre_ajouter').'");
							document.location.href="?mod=batiments&miseenforme=1";
						</script>
					 ');
			}
			
		} // fin else il y a des batiments dans la BDD
		
	
		
	
	break;
	
	###############################################################

	case 'voir': // Dans le cas ou on demande a voir juste un batiment, dans ce cas ou est sur la carte

		$batimentencours = explode(",", $baserow["batimentencours"]); // On recuperes les infos du batiment en cours

		if($_GET['batiment'] == 'encours') // Si c'est le batiment en cours de construction qu'on a demander a voir
		{	// Alors on recupere dans le SQL l'id du batiment en cours
			$voirbat = sql::select("SELECT * FROM phpsim_batiments WHERE id='" . $batimentencours[0] . "'");
		}
		else // Si c'est un batiment deja construit
		{
			// Dans ce cas on recupere le SQL du batiment a voir
			$voirbat = sql::select("SELECT * FROM phpsim_batiments WHERE id='" . $_GET['batiment'] . "'");
		}		
		
		// Dans le cas d'un hack, alors aucun SQL est retourné, on affiche un message d'erreur
		if(empty($voirbat) )
		{
			// On affiche le message d'erreur dans une alert JavaScript
			// Puis on redirige sur les batiments
			die('
				  <script>
					alert("'.$lang->recup('batiment_non_existant').'");
					document.location.href="?mod=batiments&miseenforme=1";
				  </script>
				 ');
		}
		
		if(empty($niv[$voirbat['id']]) ) // Dans le cas ou le batiment n'a jamais été construit, alors il n'a pas de niveau,
		{
			// On initialise la variable pour ne pas provoquer de bugs
			$niv[$voirbat['id']] = 0;
		}
		
		// On demande la fonction permettant de calculé le nombres de ressources manquantes
		$rm = $const->ressources_manquantes($voirbat);
		$temps_avant_dispo = $rm['ressources_manquantes'] ; // On recupere les ressources manquantes
		$construction_impossible= $rm['construction_impossible'] ; // On recupere la variable permettant de determiner si la construction est possible ou pas

		$ressourcespage = $const->afficher_ressources($voirbat["ressources"], $voirbat["ressources_evo"]); //  Calcule et formate les ressources necessaire pour créer le batiment
		$temps = $const->calculer_temps($niv[$voirbat["id"]], $voirbat["tps"], $voirbat["tps_evo"]); // Calcule le temps necessaire pour créer le niveau suivant
		$temps = $const->afficher_temps($temps); // On affiche le temps sous forme formaté
		$lien = "&nbsp;"; // On incremente la variable

		if ($baserow["batimentencours"] == '') // Dans le cas ou il n'y a pas de batiments en construction, on affiche le lien corepondant
		{
			
			$niveauaconstruire = $niv[$voirbat["id"]] + 1;

			if ($niv[$voirbat["id"]] >= $voirbat["niveau_max"] && $voirbat["niveau_max"] != 0) 
			{ // Dans le cas ou le niveau maximum a été atteint
				$lien = "<font color='red'>".$lang->recup('niveau_max_atteint')."</font>";
			}
			elseif(ereg("[1]",$construction_impossible) ) 
			{ // Si construction impossible contient un 1 alors on n'a pas les ressources suffisantes 
			  $lien ="<font color='red'>".$lang->recup('ressources_manquantes')."</font>";
			}
			elseif ($niv[$voirbat["id"]] < $voirbat["niveau_max"] || $voirbat["niveau_max"] == 0) 
			{ // Dans le cas ou on peut construire on affiche le lien
				$lien = "<a href='index.php?mod=batiments&construire=" . $voirbat["id"] . "'>
						 <font color='green'>".$lang->recup('construction_niveau')." " . $niveauaconstruire . "</font></a>
						";
			} 
		
		} 
		elseif ($batimentencours[0] == $voirbat["id"]) // Dans le cas ou le batiment a construire est le batiment que l'on traite
		{
				// On affiche le compte a rebours dynamique en JS
			   $lien = "<div id='construction'></div><script>construire('".$batimentencours[2]."'); </script>";

		}


		// On affiche le batiment sur la page
		$tpl->value("id", $batrow["id"]);
		$tpl->value("nom", stripslashes(nl2br($voirbat["nom"])));
		$tpl->value("niveau", $niv[$voirbat["id"]]);
		$tpl->value("theme", $userrow["template"]);
		$tpl->value("image", $voirbat["image"]);
		$tpl->value("description", stripslashes(nl2br($voirbat["description"])));
		$tpl->value("temps_avant_dispo", @$voirbat["temps_avant_dispo"]);
		$tpl->value("ressources", "<u>Ressources</u> : <br>".$ressourcespage);
		$tpl->value("temps", "<u>Temps</u> : ".$temps);
		$tpl->value("lien", $lien);
		$tpl->value("temps_avant_dispo", $temps_avant_dispo);

		$page = $tpl->construire("voirbatiment"); // On construit la page

		
	break;
	
	###############################################################
	
	case 'infos': // Si on demande des infos sur le batiment
		
		
		
	break;
	
	###############################################################
	
	default : // Par default on affiche la carte, pour afficher directement la liste par le menu, il faut rajouter &action=liste
	
		if($controlrow['type_batiments'] == 'liste') // Dans ce cas on redirige sur la liste
		{
			die('<script>location="?mod=batiments&action=liste&miseenforme=1"</script>');
		}	
		
		// On affiche la carte 
		
		$casenb = 1; // On initialise la variable
		$casenbmax = $controlrow['nombres_cases_sur_cartes']; // On recupere le nombres de cases que possede le template de carte dans le jeu
		// DEBUT ON RECUPERE LE CONTENU DES CASES SOUS UN TABLEAU NOMMÉ $cases CONTENANT id_case => contenu_case
		$case = $const->niveaux($baserow["map"]);
		// FIN ON RECUPERE LE CONTENU DES CASES SOUS UN TABLEAU NOMMÉ $cases CONTENANT id_case => contenu_case

		/*
		Voici les informations sur le contenu des cases :
			0  => La case est vide
			°1° => La case contient un arbre
			°2° => Une construction est en cours sur la case
			1 et + => Un batiment est créer sur la case, ce chiffre represente l'id du batiment créer
		*/
		
		$basebatimentencours = $baserow["batimentencours"]; // On recupere la batiment en construction
		
		while($casenb <= $casenbmax) // On effectue l'action pour chaque case
		{ // debut while remplir case
			if(empty($case[$casenb]) ) // Dans le cas ou le champ n'existe pas dans SQL cela veut dire que ya rien de créer sur la case
			{
				$case[$casenb] = '0';
			}
			
			if($case[$casenb] == '0' && empty($baserow["batimentencours"]) ) 
			{ // Dans le cas ou il n'y a rien sur la case et qu'aucun batiment n'est en construction
				// On permet de cliquer sur la case pour pouvoir constuire un nouveau batiment
				$tpl->value($casenb, "<a href='javascript:clic(\"batiments&action=liste&case=".$casenb."\", \"1\");'>
									  <img src='templates/".$userrow["template"]."/images/carte/".$baserow["ordre_3"]."/fond.gif' 
										   border='0' width='64' height='64'></a>
								      ");
			}
			elseif($case[$casenb] == '0'  && !empty($baserow["batimentencours"]) ) 
			{ // Dans le cas ou la case est vide mais qu'un batiment est en cours de creation
				// On ne permet pas de cliquer sur la case
				$tpl->value($casenb, "<img src='templates/".$userrow["template"]."/images/carte/".$baserow["ordre_3"]."/fond.gif' 
										   border='0' width='64' height='64'>
								     ");
			}
			elseif($case[$casenb] == '°1°') 
			{ // Dans le cas ou la case vaut -1 c'est qu'il y a un arbre dessus
				// On affiche l'arbre se trouvant sur la case
				$tpl->value($casenb, "<img src='templates/".$userrow["template"]."/images/carte/".$baserow["ordre_3"]."/arbre.gif' 
									  border='0' width='64' height='64'>
									 ");
			}
			elseif($case[$casenb] == '°2°') 
			{ // Dans ce cas, c'est que une construction est en train de se faire sur la case
				// On permet de cliquer dessus pour voir la construction
				$tpl->value($casenb, "<a href='javascript:clic(\"batiments&action=voir&batiment=encours\", \"1\");'>
									  <img src='templates/".$userrow["template"]."/images/carte/".$baserow["ordre_3"]."/construction.gif' border='0' width='64' height='64'></a>");
			}
			elseif($case[$casenb] > 0) 
			{ // Dans ce cas, il y a un batiment de construit sur la case, on recupere ses informations pour les afficher
				
				// On recuperes les infos du batiment sur la case
				$bati = $sql->select("SELECT id,image,nom FROM ".PREFIXE_TABLES.TABLE_BATIMENTS." WHERE id='".$case[$casenb]."' LIMIT 1");

				$tpl->value($casenb, "<a href='javascript:clic(\"batiments&action=voir&batiment=".$bati['id']."\", \"1\");'>
									  <img src='templates/".$userrow["template"]."/images/batiments/".$bati["image"].".gif' 
									  border='0' width='64' height='64' 
									  onmouseover='montre(\"".$bati["nom"]."\");' onmouseout='cache();'>
									  </a>
									 ");

				$tpl->value("ordre_3", $baserow["ordre_3"]);
			}

			$page = $tpl->construire("carte"); // On construit la carte pour chaque cases
			
			$casenb++;
			
		} // fin while remplir case
		
		// $page contient la carte formater
		
	break;
	
} // fin switch get action






?>