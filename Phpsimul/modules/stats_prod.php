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

// On inclue la classe pour les templates
	include('classes/templates2.class.php');
	$tpl2 = new Tpl;

$tpl2->fichier('templates/'.$userrow['template'].'/stats_prod.html'); // On recupere le fichier du template
	
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


// On definit une valeur par default de temps_prod si elle est vide, ou si le joueur a pas envoyé un temps correct
if(empty($_POST['temps_prod']) || strlen($_POST['temps_prod']) > 3) 
{
	$temps_prod = 168 ; 
}
else 
{
	$temps_prod = $_POST['temps_prod']; 
}

// GESTION DE L'AFFICHAGE EN JOURS OU EN HEURES DES PRODUCTIONS POUR UN  TEMPS SAISI
	if($temps_prod >= 24) // Dans le cas ou on a plus de 1 jour
	{
		if( is_int( ($temps_prod / 24) ) ) // Dans le cas ou on a un jour complet
		{
			$temps_prod_afficher = ($temps_prod / 24).' Jours' ;
		}
		else // Dans le cas ou on a un temps partitiel
		{
			$temps_prod_afficher = $temps_prod.' H' ;
		}
	}
	else // Dans le cas ou on a pas 24 heures, alors on a forecement un affichage en Heures
	{
		$temps_prod_afficher = $temps_prod.' H' ;
	}


// On recupere les ressources existantes, comme cela tous ce fait a partir de la, on a donc une base clair
$ressources_existantes = $sql->query('SELECT * FROM '.PREFIXE_TABLES.TABLE_RESSOURCES.' ORDER BY id ');

$base_ressources = explode(",", $baserow["ressources"]); // On recupere le tableau des ressources actuellement dispo dans la base
$base_stockage = explode(",", $baserow["stockage"]); // On recupere le tableau des capacité de stockage de la base
$base_productions = explode(",", $baserow["productions"]); // On recupere le tableau des productions de la base
$prod_depart = explode(",",$controlrow['productiondepart']) ;



// On concoit les variable pour ne pas generer des erreurs
$nom_ressources = array();
$afficher_prod_depart = array();
$afficher_prod_mines = array();
$augmentation_par_recherches = array();
$prod_total = array();
$prod_total_enX = array();
$stockage = array();

$barre_rempli_width = array();
$barre_pourcent = array();
$barre_vide_width = array();

$nb = 0; // On incremente la variable qui va nous permettent de recuperer les infos concerant la ressource traité dans les bases du joueur


while($ressource = mysql_fetch_array($ressources_existantes) ) // On traite chaque ressource
{
	$nom_ressources[] =$ressource['nom']; // Le nom de la ressource
	$afficher_prod_depart[] = number_format(round($prod_depart[$nb]), 0, '.', '.'); // La production de depart
	$afficher_prod_mines[] = number_format(round($base_productions[$nb] * $facteur), 0, '.', '.'); // Affochage de la prod des mines
	$augmentation_par_recherches[] = ''; // La production en plus grace au recherches
	$prod_total[] = number_format(round( ($prod_depart[$nb] + $base_productions[$nb]) ), 0, '.', '.'); // Affichage de la prod totale
	$prod_total_enX[] = number_format(round( ($prod_depart[$nb] + ($base_productions[$nb] * $facteur * $temps_prod) ) ), 0, '.', '.'); // Affichage de la prod pour un temps donnée
	$stockage[] = number_format(round($base_stockage[$nb]), 0, '.', '.'); // Affichage des capacité de stockage
	
	$pourcent_rempli = round( $base_ressources[$nb] / $base_stockage[$nb] * 100 ) ; // Recupere en % le remplissage du silo pour la ressource
	$pourcent_rempli =  ( ($pourcent_rempli >= 100) ? 100 : $pourcent_rempli ); // Dans le cas ou on depasse la quantité du silo, on met au max du silo
	$barre_rempli_width[] = $pourcent_rempli; // On recupere le pourcentage plein pour le tableau html
	$barre_pourcent_affichage[] = number_format($pourcent_rempli, 0, '.', '.');; // On recupere un jolie nombre formaté pour l'afficher
	$barre_vide_width[] = 100 - $pourcent_rempli; // On recuperer le pourcentage de vide pour le tableau html

	$nb++;
}

// On affiche les boucles
$tpl2->assigntag('nom_ressources', 1,
		array(
				'nom_ressources' => $nom_ressources
			 )
			    ); // Affichage du nom des ressources
$tpl2->assigntag('afficher_prod_depart', 1,
		array(
				'afficher_prod_depart' => $afficher_prod_depart
			 )
			    ); // Affichage de la prod de depart
$tpl2->assigntag('afficher_prod_mines', 1,
		array(
				'afficher_prod_mines' => $afficher_prod_mines
			 )
			    ); // La production grace au mines
$tpl2->assigntag('augmentation_par_recherches', 1,
		array(
				'augmentation_par_recherches' => $augmentation_par_recherches
			 )
			    ); // Affichage de l'augmentation par les recherches				
$tpl2->assigntag('prod_total', 1,
		array(
				'prod_total' => $prod_total
			 )
			    ); // La prod total (Mines + prod Depart)
$tpl2->assigntag('prod_total_enX', 1,
		array(
				'prod_total_enX' => $prod_total_enX
			 )
			    ); // La prod total (Mines + prod Depart) pendant un temps donnée
$tpl2->assigntag('stockage', 1,
		array(
				'stockage' => $stockage
			 )
			    ); // Le stokage sur la planete
				
// Les barres depoucentage de remplissage des stockages
$tpl2->assigntag('afficher_stock_barre', 1,
		array(
				'nom_ressources' => $nom_ressources,
				'barre_rempli_width' => $barre_rempli_width,
				'barre_pourcent_affichage' => $barre_pourcent_affichage,
				'barre_vide_width' => $barre_vide_width,
			 )
			    );

// On affiche le template generale
$tpl2->assign(
		array(
				'facteur_production' => $facteur, // Le facteur de production
				'temps_prod' => $temps_prod, // Le temps pour lequel on veut voir la prod
				'temps_prod_afficher' => $temps_prod_afficher, // Le temps pour lequel on veut les prod, mais cette fois formaté
				'nom->energie' => $controlrow['energie_nom'], // On affiche le nom del'energie
				'prod_depart->energie' => $controlrow['energie_default'], // On affiche l'energie de base
				'conso_energie' => $baserow['energie'], // On affiche l'energie consommé par le joueur
				'total_prod->energie' => $baserow['energie_max'], // L'energie produite par le joueur
				'colspan_total' => ($nb + 3), // Le nombre de colonne totale dans la table
				'calculette' => file_get_contents('templates/'.$userrow['template'].'/calculette.html') // Une petite calculette JS créer a l'orgine en PHP par Tereur, qui peut s'averer tres pratique, d'ailleurs on le remercie enormement
			 )
			 );


$page = $tpl2->recuptpl(); // On recupere le template apres avoir subit les consequences

$page = str_replace('{user_template}', $userrow['template'], $page); // On change les valeurs des template par le template du joueur


?>