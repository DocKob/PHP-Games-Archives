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


######################
if(@$_GET["ch"] == "av" ) // si get ch est plein alors on affiche pour changer l'avatar
{

$tpl->value('useravatar', $userrow['avatar']);


if($controlrow['upload_avatars_actif'] == 1) // Si l'upload d'avatar est actif
{
$tpl->value('upload_img', $tpl->construire('profils_form_avatar_upactif') );
}
else // Dans le cas ou l'upload n'est pas actif
{
$tpl->value('upload_img', '');
}

$page = $tpl->construire('profil_form_avatar');
}






######################
elseif(@$_GET['ch'] == 'ca') // si le gars a demandé les conditions d'uploads
{

$page = $tpl->construire('profil_conditions_upavatar');

}



######################
else // si il est vide on affiche la modifcation du profil complet
{

$tpl->value('userid', $userrow['id']);
$tpl->value('useravatars', $userrow['avatar']);
$tpl->value('usernom', $userrow["nom"]);
$tpl->value('usermail', $userrow["mail"]);

$select_theme = '';

$dir = opendir('templates/'); // On ouvre le repertoire

// On affiche les teplate existants en selectionnant celui que nous avons
while ($f = readdir($dir) ) // Lit le repertoire des templates pour savoir lequel existe
{
    if (is_dir('templates/' . $f) && $f != "." && $f != "..") 
    {
        $tpl->value('optionvalue', $f);
        $tpl->value('optiontexteafficher', $f);
        if($userrow['template'] == $f) // Dans le cas ou le template est celui du joueur on le selectionne
        {
        $tpl->value('sel', 'selected');
        }
        else // Si ce n'est pas le template du joueur le champ pour le selected est vide
        {
        $tpl->value('sel', '');
        }
        
		  $select_theme .= $tpl->construire('select_def'); // On construit la ligne de option avec le fichier template prevu pour ca
    }
}

closedir($dir);


$tpl->value('select_theme', $select_theme);

if($userrow["messagerie_type"] == "1") 
{ 
$tpl->value('selected_type1', ' selected ');
$tpl->value('selected_type2', '');
}
elseif($userrow["messagerie_type"] == "2") 
{ 
$tpl->value('selected_type1', '');
$tpl->value('selected_type2', ' selected ');
}

$tpl->value('signature', $userrow["signature"]);


$page = $tpl->construire('profil_form');

}


?>