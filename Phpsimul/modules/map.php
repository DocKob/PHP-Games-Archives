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


if ($controlrow["ordre_1_active"] == 1) // Dans le cas ou les coordonées de type Galaxie sont actives
{ // Debut if ordre1 actif

    if (empty($_POST["ordre_1"])) 
    {
        $ordre_1 = $baserow["ordre_1"];
    } 
    else 
    {
        $ordre_1 = $_POST["ordre_1"];
    }

	 if (empty($_POST["ordre_2"])) 
	 {
    	$ordre_2 = $baserow["ordre_2"];
	 } 
	 else 
	 {
    $ordre_2 = $_POST["ordre_2"];
	 }


	 if (!empty($_GET["ordre_1"])) 
	 {
    $ordre_1 = $_GET["ordre_1"];
    }

	if (!empty($_GET["ordre_2"])) 
	{
    $ordre_2 = $_GET["ordre_2"];
	}

	if (!empty($mod[1]) ) 
	{
    $ordre_1 = $mod[1];
	}

	if (!empty($mod[2]) )
	{
    $ordre_2 = $mod[2];
	}


    if ($ordre_1 > $controlrow["ordre_1_max"]) 
    {
        $ordre_1 = $controlrow["ordre_1_max"];
    }
    
    
} // Fin if ordre1 actif
else // Dans le cas ou les coordonnées ordre1 sont inactives
{ // Debut else coordonnées ordre1 inactives

    $ordre_1 = 1; // Dans le cas ou ordre1 est inactif, alors il est toujours de 1
    
} // FIN else coordonnées ordre1 inactives


if ($ordre_2 > $controlrow["ordre_2_max"]) // Si le joueur a indiqué un ordre2 trop elevé alors on le met a la valeur max
{
    $ordre_2 = $controlrow["ordre_2_max"];
} 



// On commence a créer le template a cette endroit, du au faite que ces valeurs sont utile a plusieurs moment du script
$tpl->value('ordre_2', $ordre_2);
$tpl->value('ordre_1', $ordre_1);


if ($controlrow["ordre_1_active"] == 1) // Si les coordonnées ordre1 sont active, alors on affiche le boutton pour les changer
{ // debut if ordre1 active

$tpl->value('ordre_1-1', $ordre_1-1);
$tpl->value('ordre_1+1', $ordre_1+1);
$ordre1_button = $tpl->construire('map_affichage_ordre1_si_actif');
}
else // Dans le cas ou les coordonnées sont inactif, on créer la variable et on la met a 0
{
$ordre1_button = '';
}


$numero_ordre_3 = 1; // Nombre incrementé a chaque fin de while
$affj = ''; // on créer la variable pour ne pas generer une erreur

while ($numero_ordre_3 <= $controlrow["ordre_3_max"]) // On continue la boucle tant qu'on est pas arrivé au max de ordre3 
{ // debut while traitement joueurs
    
$ordrequery = $sql->query("SELECT nom,
											utilisateur,
											image,
											ordre_1,
											ordre_2,
											ordre_3 
									FROM phpsim_bases 
									WHERE ordre_1='" . $ordre_1 . "' 
											AND ordre_2='" . $ordre_2 . "' 
											AND ordre_3='" . $numero_ordre_3 . "'
								   ");
								   
if (mysql_num_rows($ordrequery) == 1) // On verifie si une ligne a été retourné, dans ce cas, un joueur est present a cette emplacement
{ // debut if joueur present

$ordre = mysql_fetch_array($ordrequery);

// On recupere les infos sur le proprietaire de la planete
$occupantrow = $sql->select("SELECT id,
												nom,
												avatar,
												time 
									  FROM phpsim_users 
									  WHERE id='" . $ordre["utilisateur"] . "'
									 ");
									 
// On regarde si le joueur est inactif, dans quel cas on lui place le status inactif
if($occupantrow['time'] <= time() - (7 * 24 * 60 * 60) ) // Si le joueur est inactif depuis 7jours
{
$status_i = $tpl->construire('map_status_inactif_7j'); 
}
if($occupantrow['time'] <= time()  - (30 * 24 * 60 * 60) ) //Si le joueur est inactif depuis 30jours
{ 
$status_i = $tpl->construire('map_status_inactif_30j'); 
}
if(empty($status_i) ) // Dans le cas ou la variable na pas été defjni on la genere pour eviter une erreur
{
$status_i = '';
}

// On créer le template du joueur
$tpl->value('numero', $numero_ordre_3);
$tpl->value('imagebasedujoueur', $ordre["image"]);
$tpl->value('ordre1joueur', $ordre['ordre_1']);
$tpl->value('ordre2joueur', $ordre['ordre_2']);
$tpl->value('ordre3joueur', $ordre['ordre_3']);
$tpl->value('nomjoueur', $ordre['nom']);
$tpl->value('id_occupant', $occupantrow["id"]);
$tpl->value('avatar_occupant', $occupantrow["avatar"]);
$tpl->value('nom_occupant', $occupantrow["nom"]);
$tpl->value('status_inactif', $status_i);

$affj .= $tpl->construire('map_users');
   
} // fin if joueur present

else // Dans le cas ou la planete na pas de proprietaire

{ // debut else planete vide

$tpl->value("numero", $numero_ordre_3);
$affj .= $tpl->construire('map_users_place_vide');

} // fin else planete vide

    $numero_ordre_3++; // on increment de 1 la valeur

} // fin while traitement joueurs


// On créer le template de la page
$tpl->value('affichage_boutton_changement_galaxie_si_actif', $ordre1_button);
$tpl->value('ordre_2-1', ($ordre_2-1) );
$tpl->value('ordre_2+1', ($ordre_2+1) );
$tpl->value('affichage_joueurs', $affj);


$page = $tpl->construire('map');

?>
