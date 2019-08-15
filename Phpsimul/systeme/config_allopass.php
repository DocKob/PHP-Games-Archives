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

/*

Si vous comptez vous inscrire à allopass, nos vous serions reconnaissants d'utiliser le lien suivant : 

http://www.allopass.com/index.php4?ADV=11935836

Ca ne vous coutera rien de plus, mais vous nous aiderez à financer le serveur du forum de la communauté. Merci.

Pour configurer votre allopass, créez votre document comme ceci : 

URL de la page d'accès : [url de votre site, avec le nom du dossier ou est situé phpsimul, si il y en a un]/index.php?mod=allopass

URL du document : [url de votre site, avec le nom du dossier ou est situé phpsimul, si il y en a un]/allopass.php

URL d'erreur : [url de votre site, avec le nom du dossier ou est situé phpsimul, si il y en a un]/index.php?mod=allopass&erreur=codeinvalide

Nombre de codes : 1

Validité du code d'accès : 1 fois

*/

@$controlrow["allopass_points_par_achat"] = 1000; //nombre de points allopass que l'utilisateur achète

@$controlrow["allopass_script"] = <<<SCRIPTALLOPASSPHPSIMULFORMATCLASSIQUE

Remplacez ce texte par votre script allopass format classique.

SCRIPTALLOPASSPHPSIMULFORMATCLASSIQUE;


@$controlrow["allopass_identifiant"] = "Remplacez ce texte par l'identifiant de votre document"; //Vous trouverez l'identifiant dans la liste de vos documents, il est sous la forme xxxxxx/xxxxxx/xxxxxxx


@$controlrow["allopass_securite"] = <<<SECURITEALLOPASSPHPSIMUL

Remplacez ce texte par votre code de sécurité allopass fourni sur le site.

SECURITEALLOPASSPHPSIMUL;
















?>