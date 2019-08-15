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


##########################################################################################################
/*************************************************************************************\
					FONCTION QUI PERMET D'AFFICHER LE MENU
\*************************************************************************************/
function menu()
{
    global $tpl;
    global $userrow;
    global $cache;
    
    $menu = $cache->chercher("menu");

	if ($menu == 1) 
	{
		 
	    $menuquery = sql::query("SELECT nom,module,separateur,miseenforme FROM phpsim_menu ORDER BY id");

	    $tpl->getboucle("menu");

	    while ($menurow = mysql_fetch_array($menuquery)) 
	    { // debut while $menurow
	        if ($menurow["separateur"] == 1) // Dans le cas ou il s'agit d'un separateur
	        {
	        		$tpl->boucletotal .= $tpl->construire('menu_separateur');
	        } 
	        else // Dans le cas ou il s'agit d'un lien
	        {
					$tpl->value('lien', 'index.php?mod='.$menurow['module']);
					$tpl->value('nom', $menurow['nom']); 
	        		        $tpl->boucle();
	        }
	    } // fin while $menurow
	   
	       $menu = $tpl->finboucle();

	       $cache->save($menu, 'menu');

	}

    return $menu;
}
##########################################################################################################
/*************************************************************************************\
			FONCTION QUI PERMET DE VERIFIER LA CONNEXION DU JOUEUR
\*************************************************************************************/
function tout_verifier($userrow, $controlrow, $mod, $sql)
{
    if(empty($userrow['nom']) ) // On tombe dans ce cas lorsque le joueur vient de se faire supprimer son compte par un admin
    									  // Pour eviter les bug il faut alors deconnecter le joueur
    {
			unset($_SESSION['idjoueur']);
			header('location: index.html');
    }
    
    if ($userrow['valide'] != 1) 
	{
        die("Merci de valider votre compte.");
    }

    if ($userrow["banni"] == 1) 
	{
    	if($userrow["time_bannis"] == 0 )
    	{
			die("Vous ne pouvez pas jouer car vous avez été banni pour la raison suivante : " . $userrow["motifbanni"] . "
			     <br>Vous avez été banni a vie");
    	}
    	elseif($userrow["time_bannis"] > time() )
    	{
		  // On detruit le cookie et la session de la connexion pour eviter des bugs
		  setcookie("PHPsimul");
		  unset($_SESSION['idjoueur98765432100']);
			die("Vous ne pouvez pas jouer car vous avez été banni pour la raison suivante : " . $userrow["motifbanni"] . "
			     <br>Vous pourrez jouer a partir du ".date("d/m/Y à H:i:s", $userrow["time_bannis"]));
        }
    }

    if ($userrow["bases"] == "" || $userrow["bases"] == 0) 
	{
		@$mod = explode('|', $_GET['mod']);
		include("systeme/choixbasedepart.php");
        if ($mod[0] == "choixbasedepart2") 
		{
            choixbasedepart2($mod[1], $mod[2], $mod[3]);
        } 
		else 
		{
            choixbasedepart();
        }
        exit();
    }

    if ($controlrow["ouvert"] != 1 && $userrow["administrateur"] == 0) 
	{
        die("Vous ne pouvez pas jouer car le jeu est en cours de maintenance.");
    }
   
}
##########################################################################################################
/*************************************************************************************\
	     FONCTION PERMETTANT DE CALCULER LE TEMPS D'EXECUTION DE LA PAGE
\*************************************************************************************/
function DiffTime($microtime1, $microtime2) // Merci à Marneus Calgar de phpcs pour cette fonction !!!
{
	list($micro1, $time1) = explode(' ', $microtime1);
	list($micro2, $time2) = explode(' ', $microtime2);
	$time = $time2 - $time1;
	if ($micro1 > $micro2)
	{
		$time--;
		$micro = 1 + $micro2 - $micro1;
	}
	else
	{
		$micro = $micro2 - $micro1;
	}
	$micro += $time;
	return $micro;
}


##########################################################################################################
/*************************************************************************************\
	             FONCTION PERMETTANT DE METTRE UN MESSAGE EN FORMAT BBCODE
\*************************************************************************************/
Function bbcode_msg($texte) // Merci a Max485 pour cette fonction
{

   //on supprime les slashs qui se seraient ajoutés automatiquement
   $texte = stripslashes($texte) ;
   //on désactive le HTML
   $texte = htmlspecialchars($texte) ;
   //on génére des retours chariots automatiques !!!
   $texte = nl2br($texte) ; 

	//on crée le bbcode qui sera appliqué à notre texte !
	$bbcode=array(
		//mise en gras
		"!\[b\](.+)\[/b\]!isU",
		//soulignement
		"!\[u\](.+)\[/u\]!isU",
		//mise en italique
		"!\[i\](.+)\[/i\]!isU",
		//mise en couleur
		"!\[color=(.+)\](.+)\[/color\]!isU",
		//liste à puces 1
		"!\[ul\](.+)\[/ul\]!U",
		//liste à puces 2
		"!\[li\](.+)\[/li\]!U",
		// Lien nommé
		"!\[url=(.+?)\](.+?)\[\/url\]!i",
		//afficher les images
		"!\[img\](.+)\[/img\]!i",
		// Lien
		"!\[url\](.+?)\[\/url\]!i",
		// Email nommé
		"!\[email=(.+?)\](.+?)\[\/email\]!i",
		// Email
		"!\[email\](.+?)\[\/email\]!i",
		// Size H1
		"!\[size=1\](.+)\[/size\]!i",
		// Size H2
		"!\[size=2\](.+)\[/size\]!i",
		// Size H3
		"!\[size=3\](.+)\[/size\]!i",
		// Size H4
		"!\[size=4\](.+)\[/size\]!i",
		// Size H5
		"!\[size=5\](.+)\[/size\]!i",
		// Size Tres petit
		"!\[size=tres petit\](.+)\[/size\]!i",
		// Size Petit
		"!\[size=petit\](.+)\[/size\]!i",
		// Size Normal
		"!\[size=normal\](.+)\[/size\]!i",
		// Size Moyen
		"!\[size=moyen\](.+)\[/size\]!i",
		// Size Grand
		"!\[size=grand\](.+)\[/size\]!i",
		// Size 18
		"!\[size=18\](.+)\[/size\]!i",
		// Quote
		"!\[quote\](.+)\[/quote\]!i",
		//Quote nommé
		"!\[quote=(.+)\](.+)\[/quote\]!i",
		// Code
		"!\[code\](.+)\[/code\]!i",



	);

	$html = array(
		//mise en gras
		"<b>$1</b>",
		//soulignement
		"<u>$1</u>",
		//mise en italique
		"<i>$1</i>",   
		//mise en couleur
		"<span style=\"color:$1\">$2</span>",
		//liste à puce 1
		"<ul>$1</ul>",
		//liste à puce 2
		"<li>$1</li>",
		// Lien nommé
		"<a href=\"$1\">$2</a>",
		//afficher les images
		"<img src=\"$1\">",
		// Lien
		"<a href=\"$1\">$1</a>",
		// Email nommé
		"<a href=\"mailto:$1\">$2</a>",
		// Email
		"<a href=\"mailto:$1\">$1</a>",
		//Size H1
		"<h1>$1</h1>",
		//Size H2
		"<h2>$1</h2>",
		//Size H3
		"<h3>$1</h3>",
		//Size H4
		"<h4>$1</h4>",
		//Size H5
		"<h5>$1</h5>",
		//Size Tres Petit
		"<h1>$1</h1>",
		//Size Petit
		"<h3>$1</h3>",
		//Size Normal
		"<h4>$1</h4>",
		//Size Moyen
		"<h6>$1</h6>",
		//Size Grand
		"<h7>$1</h7>",
		// Size 18
		"<h6>$1</h6>",
		// Quote
		"<br><u><b>Citation :</b></u><table cellpadding=\"2\" cellspacing=\"1\" border=\"0\" width=\"100%\" align=\"left\" bgcolor=\"red\"><tr><td bgcolor=\"#FFFFFF\"><font color=\"#000000\"><b>$1</b><br></font></td></tr></table><br><br>",
		// Quote nommé
		"<br><u><b>$1 :</b></u><table cellpadding=\"2\" cellspacing=\"1\" border=\"0\" width=\"100%\" align=\"left\" bgcolor=\"red\"><tr><td bgcolor=\"#FFFFFF\"><font color=\"#000000\"><b>$2</b><br></font></td></tr></table><br><br>",
		// Code
		"<br><u><b>Code :</b></u><table cellpadding=\"2\" cellspacing=\"1\" border=\"0\" width=\"100%\" align=\"left\" bgcolor=\"red\"><tr><td bgcolor=\"#FFFFFF\"><font color=\"#000000\"><b>$1</b><br></font></td></tr></table><br><br>",

	);
   
   $texte = preg_replace($bbcode,$html,$texte);

	return $texte ;

}
##########################################################################################################
/*************************************************************************************\
			FONCTION PERMETTANT DE DEMARRER UN FICHIER LANG
\*************************************************************************************/
function lang($nom, $fichier = '.') 
{
	global $lang;

	if(include($fichier.'/lang/'.$nom.'.php') ) // On verifie si l'inclusion fonctionne bien
	{
		// Dans le cas ou ca fonctionne
		return 1;
	}
	else // Dans le cas ou ca fonctionne pas
	{
		return 0;
	}
}







##########################################################################################################








?>
