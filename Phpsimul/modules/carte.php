<?php

/*

Permet d'afficher une jolie carte pour la galaxie
Code trouvé par Guerrier
Optimisé par Max485 et Guerrier

*/

// TEST - Affiche toutes les erreurs
error_reporting(E_ALL);

// Configuration du script
$image_planete_vide = 'lune.png'; // Le nom de l'image pour les planetes vide
$image_soleil = 'soleil.png'; // Le nom de l'image pour le soleil
$extension_images_bases = 'png'; // Le type d'extension des images pour les planetes coloniser
$repertoire_image_du_script = ''; // Le dossier dans lequel sont contenu les images pour le soleil et les planetes vides

$page = ''; // On incremente la variable pour ne pas provoquer d'erreur

if (isset($_GET['ordre_1']) and isset($_GET['ordre_2']) ) // Dans le cas ou le joueur a demander a changer de coordonnées
{
	$ordre_1 = $_GET['ordre_1'];
	$ordre_2 = $_GET['ordre_2'];
}
else // Le joueur n'a pas demander de coordonnées special
{
	// On prend les coordonnées du joueur
	$ordre_1 = $baserow['ordre_1'];
	$ordre_2 = $baserow['ordre_2'];
} 


// DEBUT Affichage de la zone de changement de galaxie et systeme

	$options_ordre_1 = ''; // On incremente pour ne pas provoqué d\'erreurs
	// On traites les options du select ordre_1
	for($ordre_1_select=1; $ordre_1_select <= $controlrow['ordre_1_max']; $ordre_1_select++) // On incremente chaque fois jusqu'a qu'on arrive au maximum des coordonnées max configurer dans l'admin
	{
		$options_ordre_1 .='<option onclick="document.location=\'?mod=carte&ordre_1='.$ordre_1_select.'&ordre_2='.$ordre_2.'\';"
						            value="'.$ordre_1_select.'" '.( ($ordre_1_select == $ordre_1)? 'selected' : '' ).' >'.$ordre_1_select.'</option>'."\n";
	}

	$options_ordre_2 = ''; // On incremente pour ne pas provoqué d\'erreurs
	// On traite les options du select ordre_2
	for($ordre_2_select=1; $ordre_2_select <= $controlrow['ordre_2_max']; $ordre_2_select++)
	{
		$options_ordre_2 .='<option onclick="document.location=\'?mod=carte&ordre_1='.$ordre_1.'&ordre_2='.$ordre_2_select.'\';"
						 value="'.$ordre_2_select.'" '.( ($ordre_2_select == $ordre_2)? 'selected' : '' ).' >'.$ordre_2_select.'</option>'."\n";
	}

// FIN de l'Affichage de la barre de changement de galaxie et systeme 


// On va chercher les autres joueurs presents sur cette galaxie et ce systeme
$requete = $sql->query("SELECT utilisateur, ordre_3, image, nom FROM phpsim_bases WHERE ordre_1 ='".$ordre_1."' and ordre_2 ='".$ordre_2."' ORDER BY ordre_3 DESC");

// On defini les tableau
$bases_avatar = array() ;
$bases_coord = array();
$bases_nom = array() ;
$bases_img = array() ;
$bases_occupant = array() ;
$bases_alliance = array() ;
$bases_race = array() ;

while ($data = mysql_fetch_array($requete) ) // Pour chaque planetes se trouvant dans le ordre_1 + ordre_2 selectionné
{
	if (empty($bases_coord[$data['ordre_3']]) ) // On verifie que la place n'a pas encore été traité
	{
		$bases_coord[$data['ordre_3']] = $data['ordre_3']; // Tableau contenant le numero ordre_3 des planetes
		$bases_nom[$data['ordre_3']] = $data['nom']; // Contient le nom de la planete
		$bases_img[$data['ordre_3']] = $data['image']; // Contient l'image de la planete
		
		// On recuperes les infos du joueur
		$occupant = $sql->select('SELECT nom, alli, race, avatar FROM phpsim_users WHERE id="'.$data['utilisateur'].'"');
		$bases_avatar[$data['ordre_3']] = '<img width="75" height="75"src=" '.$occupant['avatar'].' "> '; // L'avatar du joueur
		$bases_occupant[$data['ordre_3']] = $occupant['nom']; // Le nom du joueur
		$bases_alliance[$data['ordre_3']] = ( ($occupant['alli'] == 0)? 'Aucune' : $sql->select1('SELECT nom FROM phpsim_alliance WHERE id="'.$occupant['alli'].'" ') ); // L'alliance du joueur
		$bases_race[$data['ordre_3']] = $controlrow['race_'.$occupant['race']];// La race du joueur
		//$bases_[$data['ordre_3']] = $data['']; // Contient
	}
}

// On defini les variable avant la boucle pour ne pas les actualiser inutilement
$fin_ligne_1 = round( $controlrow['ordre_3_max'] / 3 ) ;
$fin_ligne_2 = round( $controlrow['ordre_3_max'] / 3 + $fin_ligne_1 ) ;
$fin_ligne_3 = round( $controlrow['ordre_3_max'] / 3 + ($fin_ligne_1*2) ) ;
$centre_carte = round( ($controlrow['ordre_3_max'] + 1) / 2 ) ; // On recupere le centre de la carte sans oublier d'ajouter le soleil
$position_planetes = 1; // Permet de definir la position de la planete, cette variable ne s'actualise pas lorsque on est sur le soleil

for($pos=1; $pos <= $controlrow['ordre_3_max'] + 1; $pos++) // On defini le nombre de planetes affiché suivant le nombre defini dans l'administration, on rajoute 1 ce qui permet d'afficher le soleil
{ // debut for traitement position

	//***** DEBUT Gestion des fins de lignes *****\\
		if ($pos == $fin_ligne_1 or $pos == $fin_ligne_2 ) // Dans le cas ou on se trouve en fin de ligne
		{
			// On créer le code permettant de changer de ligne
			$finligne = '</tr><tr align="center" valign="middle" height="300">'."\n"; 
		}
		elseif ($pos == $fin_ligne_3) // Dans le cas ou on est a la fin du tableau
		{
			// On referme simplement le tableau
			$finligne = '</tr>'; 
		}
		else // Si l'on est au debut ou milieu de ligne
		{
		    // On defini la variable avec rien dedans ce qui permet de ne pas changer de ligne
		    $finligne = '';
		}
	//***** FIN Gestion des fins de lignes *****\\

	if ($pos == $centre_carte) // Lorsqu' on arrive au centre de la carte on affiche le soleil
	{ 
		$page .='<th align="center" valign="middle" width="300" height="300">
					<a class="lien_curseur" onmouseover="montre('.$pos.');" onmouseout="docache('.$pos.');">
						<img src="templates/'.$userrow['template'].'/images/'.$repertoire_image_du_script.$image_soleil.'" height="300" width="300">
					</a>
				
				<div id="infobulle-'.$pos.'" class="infobulle">
					Soleil
				</div>
				
				</th>'.$finligne."\n";
	}   
	else // Dans le cas ou on est pas au centre de la carte, il ne s'agit pas d'un soleil, alors on affiche
	{
		if(!empty($bases_coord[$position_planetes])) // On regarde si la position est rempli
		{
			// On affiche la planete occupé avec les infos sur son occupant
			$page .='
				<th align="center" valign="middle" width="300" height="300">
					<a onmouseover="montre('.$pos.');" onmouseout="cache('.$pos.');">
						<img width="100" height="100"
							 src="templates/'.$userrow["template"].'/images/bases/'.$bases_img[$position_planetes].'.'.$extension_images_bases.'">
					</a>
					
					<div id="infobulle-'.$pos.'" class="infobulle">
						'.$bases_avatar[$position_planetes].'
						<br>
						Planète : '.$bases_nom[$position_planetes].' ['.$ordre_1.':'.$ordre_2.':'.$position_planetes.']
						<br>
						Occupant => '.$bases_occupant[$position_planetes].'
						<br>
						Alliance => '.$bases_alliance[$position_planetes].'
						<br>
						Race => '.$bases_race[$position_planetes].'
						<br>
						<br>
						<a href="?mod=ecrire&destinataire='.$bases_occupant[$position_planetes].'">Ecrire un message</a>
						<br>
						<a href="?mod=unites&c1=' . $ordre_1 . '&c2=' . $ordre_2 . '&c3=' .$position_planetes. '">Envoyer une flotte</a>
					</div>
				</th>
			'.$finligne."\n";
			
			$position_planetes++;
		}         
		
		else // Dans le cas ou il n'y a personne sur la position
		{		
			$page .='
				<th align="center" valign="middle" width="300" height="300">
					<a onmouseover="montre('.$pos.');" onmouseout="cache('.$pos.');"> 		   
						<img height="100" width="100"
							 src="templates/'.$userrow['template'].'/images/'.$repertoire_image_du_script.$image_planete_vide.'">
					</a>
					
					<div id="infobulle-'.$pos.'" class="infobulle">
						Planète ['.$ordre_1.':'.$ordre_2.':'.$position_planetes.']
						<br>
						La position est vide
						<br>
						<br>
						<a href="?mod=coloniser&o1='.$ordre_1.'&o2='.$ordre_2.'&o3='.$position_planetes.'">Coloniser</a>
					</div>			
				</th>	
			'.$finligne."\n";
			
			$position_planetes++;
		}
	}
} // fin for traitement position

$page .='</table>'; // on ferme le tableau









	
	
$tpl->value('options_ordre_1', $options_ordre_1);
$tpl->value('options_ordre_2', $options_ordre_2);

$page = $tpl->construire('carte_galactique').$page;

?>