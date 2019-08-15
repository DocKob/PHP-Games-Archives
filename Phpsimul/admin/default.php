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


#######################################################
## Supprime la liste des acces si cela a �t� demand� ##

if(@$_GET['action'] == 'supprimer_liste' && $userrow['fondateur'] == 1) // On permet la supression de la liste que si le joueur est le fondateur et si il l'a demand�
{
	unlink('admin/acces.txt') ; // Supprime le fichier

	// Cr�er un fichier du meme nom mais vide pour eviter des bugs
	$fp = fopen("admin/acces.txt", "a"); 
	fclose($fp); // Ferme le fichier

	$listeacces = "Vous venez de supprimez la liste"; // Ca c'est ce que contient le fichier, la ca contient juste qu'il a �t� supprim�
}



/* DEBUT ANCIEN CODE PERMETTANT DE LISTER LES ACCES *\
####################################
## On listes les personnes qui se sont connect� au panneau ##

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
Apr�s de longs tests, voici la nouvelle arme dont dispose la mod�ration sur les differentes version de PHPSimul.
<br>
Cette console a �t� con�ue pour pouvoir r�pondre d'avantage aux besoins des administrateurs et mod�rateurs;
<br>
ceux qui chaque jour contribuent � l'�volution de votre jeu. 
<br/>
<br/>
Bonne mod�ration � tous.
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
Historique des acc�s au panneau (<a class='effacer_liste' href='?mod=default&action=supprimer_liste'><font color='000000'>
Pour effacer la liste, cliquez ici</font></a>) : <br><br>".file_get_contents('admin/acces.txt')."</center>";



?>