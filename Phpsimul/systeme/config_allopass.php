<?php

// Si la constante n'est pas defini on bloque l'execution du fichier
if(!defined('PHPSIMUL_PAGES') || @PHPSIMUL_PAGES != 'PHPSIMULLL') 
{
	die('Erreur 404 - Le fichier n\'a pas �t� trouv�');
}

/* PHPsimul : Cr�ez votre jeu de simulation en PHP
Copyright (�) - 2007 - CAPARROS S�bastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr

*/

/*

Si vous comptez vous inscrire � allopass, nos vous serions reconnaissants d'utiliser le lien suivant : 

http://www.allopass.com/index.php4?ADV=11935836

Ca ne vous coutera rien de plus, mais vous nous aiderez � financer le serveur du forum de la communaut�. Merci.

Pour configurer votre allopass, cr�ez votre document comme ceci : 

URL de la page d'acc�s : [url de votre site, avec le nom du dossier ou est situ� phpsimul, si il y en a un]/index.php?mod=allopass

URL du document : [url de votre site, avec le nom du dossier ou est situ� phpsimul, si il y en a un]/allopass.php

URL d'erreur : [url de votre site, avec le nom du dossier ou est situ� phpsimul, si il y en a un]/index.php?mod=allopass&erreur=codeinvalide

Nombre de codes : 1

Validit� du code d'acc�s : 1 fois

*/

@$controlrow["allopass_points_par_achat"] = 1000; //nombre de points allopass que l'utilisateur ach�te

@$controlrow["allopass_script"] = <<<SCRIPTALLOPASSPHPSIMULFORMATCLASSIQUE

Remplacez ce texte par votre script allopass format classique.

SCRIPTALLOPASSPHPSIMULFORMATCLASSIQUE;


@$controlrow["allopass_identifiant"] = "Remplacez ce texte par l'identifiant de votre document"; //Vous trouverez l'identifiant dans la liste de vos documents, il est sous la forme xxxxxx/xxxxxx/xxxxxxx


@$controlrow["allopass_securite"] = <<<SECURITEALLOPASSPHPSIMUL

Remplacez ce texte par votre code de s�curit� allopass fourni sur le site.

SECURITEALLOPASSPHPSIMUL;
















?>