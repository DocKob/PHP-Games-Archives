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


#######################################################
## Supprime la liste des acces si cela a été demandé ##

if(@$_GET['action'] == 'supprimer_liste' && $userrow['fondateur'] == 1) // On permet la supression de la liste que si le joueur est le fondateur et si il l'a demandé
{
	unlink('admin/acces.txt') ; // Supprime le fichier

	// Créer un fichier du meme nom mais vide pour eviter des bugs
	$fp = fopen("admin/acces.txt", "a"); 
	fclose($fp); // Ferme le fichier

	$listeacces = "Vous venez de supprimez la liste"; // Ca c'est ce que contient le fichier, la ca contient juste qu'il a été supprimé
}



/* DEBUT ANCIEN CODE PERMETTANT DE LISTER LES ACCES *\
####################################
## On listes les personnes qui se sont connecté au panneau ##

 $file = fopen ("admin/acces.txt","r");
    $templatepage = "";
    while (!feof ($file))
       @$listeacces .= fgets ($file, 
1024);
    fclose($file);
####################################
* FIN ANCIEN CODE PERMETTANT DE LISTER LES ACCES */


$page =  "

<br>
Bienvenue dans le panneau d'administration de PHPSimul
<br/>
<br/>
Après de longs tests, voici la nouvelle arme dont dispose la modération sur les differentes version de PHPSimul.
<br>
Cette console a été conçue pour pouvoir répondre d'avantage aux besoins des administrateurs et modérateurs;
<br>
ceux qui chaque jour contribuent à l'évolution de votre jeu. 
<br/>
<br/>
Bonne modération à tous.
<br/>
<br/>
<i>Le Staff PHPSimul</i><br/></div>
<br>
<br>
<br>
<center>
<style>
	.effacer_liste 
	{ 
		text-decoration: none; 
	} 
</style>
Historique des accès au panneau (<a class='effacer_liste' href='?mod=default&action=supprimer_liste'><font color='000000'>
Pour effacer la liste, cliquez ici</font></a>) : <br><br>".file_get_contents('admin/acces.txt')."</center>";



?>