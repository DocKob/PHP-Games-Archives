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


#################################################


Créer par Max485

Permet de voir un avatar en grand

#################################################

Lien a mettre sur les autres page pour acceder ici:

<a href='?mod=avatars|".$user['id']."'>L'image de l'avatars</a>

*/

$tpl->value('lienimage', $sql->select1("SELECT avatar FROM phpsim_users WHERE id='".$mod[1]."' ") );

$page = $tpl->construire('avatars');
