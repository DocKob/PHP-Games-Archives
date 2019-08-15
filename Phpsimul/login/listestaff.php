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

$page .= 'Voici les membres du Staff:
		<table border="1" width="1">
			<tr>
				<td>	
					Nom
				</td>
				<td>
					Fonction
				</td>
				<td>
					Action
				</td>
			</tr>
		 ';
		 
		


?>