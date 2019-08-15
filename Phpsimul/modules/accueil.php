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

// Ici ancien emplacement fonction js pour les flottes, voir si ca fonctionne dans acceuil.html sinon a remetre ici

lang("accueil");

$tpl->value('messages', ' ');

$unites_req = $sql->query('SELECT * FROM phpsim_unites WHERE 
							user_arrivee="' . $userrow['id'] . '" 
							OR 
							user_depart="' . $userrow['id'] . '" 
						ORDER BY heure_arrivee
							 ');

if (mysql_num_rows($unites_req) > 0) 
{ // debut if unites en cours

    include("classes/unites.class.php"); // on ouvre le fichier de classe
    $unit = new unites; // On met en place la classe
    
    $nb='1'; // Permet de change le nim de chaque unites pour faire fonctionner la fonction js des temps defillants
    
    while ($row = mysql_fetch_array($unites_req) ) 
    {
    
        // Calcule du temps restant
        $temps = ($row["heure_arrivee"] - time() );
        $tpl->value('nbvolunites', $nb);
        $tpl->value('temps', $temps);
        $tpl->value('temps_aff', $unit->afficher_temps($temps) );
        $tpl->value('temps_arrivé', date("d/m \à H:i:s", $row["heure_arrivee"]) );
        $nb++;

		  // On recupere la destination de depart de la flotte en cours de traitement
        $depart = $sql->select('SELECT * FROM phpsim_bases 
        																WHERE id="' . $row['base_depart'] . '"
        								 ');
        								 
        $tpl->value('base_depart_nom', $depart['nom']);
        $tpl->value('depart_ordre_1', $depart["ordre_1"]);
        $tpl->value('depart_ordre_2', $depart["ordre_2"]);
        $tpl->value('aff_coord_base_depart', base::coordonnees($depart['id']));


        // on recupere la destination d'arrivé de la flotte
        $arrivee = $sql->select('SELECT * FROM phpsim_bases WHERE id="' . $row['base_arrivee'] . '"');
        
        $tpl->value('base_arriver_nom', $arrivee['nom']);
        $tpl->value('arriver_ordre_1', $arrivee['ordre_1']);
        $tpl->value('arriver_ordre_2', $arrivee['ordre_2']);
        $tpl->value('aff_coord_base_arriver', base::coordonnees($arrivee['id']));

        
        if ($row['mission'] == 0) { // attaque
                $couleur = 'red';
            $mission = $lang["attaquer"];
        } elseif ($row['mission'] == 1) { // retour
                $couleur = 'green';
            $mission = $lang["retour"];
        } elseif ($row['mission'] == 2) { // coloniser
                $couleur = 'orange';
            $mission = $lang["espionner"];
        } elseif ($row['mission'] == 4) { // espionner
                $couleur = 'blue';
            $mission = $lang["coloniser"];

        } elseif ($row['mission'] == 3) { // transporter
                $couleur = 'green';
            $mission = $lang["transporter"];
        }


        $tpl->value('couleur_mission', $couleur);
        
        $tpl->value('mission', $mission);
        
        $unites .= $tpl->construire('unites');
    }
    
    $tpl->value('nom_des_bases', $controlrow['nom_bases'] );
    $tpl->value('unites', $unites );
    $tpl->value('nbanz', ($nb - 1) );
    $unitespage = $tpl->construire('unites_head');
    
} // fin if unites en cours
else // Si aucune flotte n'est en cours
{
$unitespage = '';
}


$tpl->value('unites', $unitespage);

if ($controlrow["coordonnees_activees"]) {
    $coordonnees = base::coordonnees($baserow["id"]);
    $caseslibres = $baserow["cases_max"] - $baserow["cases"];
    $coord = $coordonnees ;
}

$mail = $sql->select("SELECT COUNT(id) AS nombre FROM phpsim_messagerie WHERE statut='1' AND destinataire='" . $userrow["id"] . "'");

if ($mail["nombre"] > 0) {
    if ($mail["nombre"] == 1) {
        $tpl->value("messages", "<a href='index.php?mod=messagerie'>".$lang["vousavez"] . $mail["nombre"] . $lang["nouveaumessage"]."</a>");
    } else {
        $tpl->value("messages", "<a href='index.php?mod=messagerie'>".$lang["vousavez"] . $mail["nombre"] . $lang["nouveaumessage"]."</a>");
    }
}

// cherche l'ordre_1 et l'ordre_2
$ordre = $sql->select("SELECT ordre_1,ordre_2 FROM phpsim_bases WHERE id='".$baserow["id"]."' ");

$total = $sql->select1("SELECT Count(id) FROM phpsim_users ");

$tpl->value("classement", number_format($compteurs->classement($userrow['id']), 0, '.', '.') );

$tpl->value("nb_inscrit", number_format($total, 0, '.', '.') );

$tpl->value("imagebase", $baserow["image"]);

$tpl->value("base_nom", $baserow["nom"] );

$tpl->value("controlrow_nom_base", $controlrow["nom_bases"] );

$tpl->value("coordonnees", $coord);

$tpl->value("ordre_1", $ordre['ordre_1']);

$tpl->value("ordre_2", $ordre['ordre_2']);

$tpl->value("nom_cases", $controlrow["nom_cases"]);
$tpl->value('cases_utiliser', $baserow["cases"]);
$tpl->value('cases_max', $baserow["cases_max"]);
$tpl->value('caseslibre', $caseslibres);

##########################################################################
### Barre d'affichage pour les bases
$lon = ( ceil ( ( ($baserow['cases'] / $baserow['cases_max'] ) * 100 ) ) ) * 2 ;
$min = 200 - $lon ;

$tpl->value('lon', $lon);
$tpl->value('min', $min);
##########################################################################
# Les barres ont été créer par Nummi, et ameliorer par Zorbox memebre du form PHPSimul
# Le code a ensuite été optmisé pour finir par Max485


$points = number_format(round($userrow["points"]), 0, '.', '.');
$pointsbat = number_format(round($userrow["points_bat"]), 0, '.', '.');
$pointsrech = number_format(round($userrow["points_rech"]), 0, '.', '.');
$pointsunitdef = number_format(round($userrow["points_unit"]), 0, '.', '.');


$tpl->value("points", $points);
$tpl->value("pointsbat", $pointsbat);
$tpl->value("pointsrech", $pointsrech);
$tpl->value("pointsunitdef", $pointsunitdef);




@$page .= $tpl->construire('accueil');




?>