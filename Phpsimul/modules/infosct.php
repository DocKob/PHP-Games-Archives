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

lang("infosct");

// Si le joueur a acceder sans mettre de id alors on redirige
if(empty($_GET['bat']) && empty($_GET['rech']) ) 
{ 
	die('<script>document.location.href="index.php"</script>'); 
}

if(isset($_GET['bat']) ) // Si il s'agit d'un batiment
{

	// $page = $cache->chercher('bat'.$_GET['bat'].'_'.$userrow['id'],"infosct",1);

	$page = 1;
	if($page == 1) 
	{

		include("classes/batiments.class.php");
		$bat = new batiment;

		$batiment = $sql->select('SELECT * FROM phpsim_batiments WHERE id="'.$_GET['bat'].'" ');

		// Si il n'exsite pas de batiments avec cette id alors on redirige
		if(empty($batiment) ) 
		{ 
			die('<script>document.location.href="index.php"</script>'); 
		}

		// on affiche la description du batiment pour commencer
		$page='
				<b><u>'.$batiment['nom'].'</b></u><br><br>
				<table border="1">
				<tr><th colspan="2"><u>'.$lang["desc"].'</u></th>
				<tr>
				<td><img src="templates/'.$userrow['template'].'/images/batiments/'.$batiment['image'].'.gif"></td>
				<td>'.nl2br($batiment['description']).'</td></tr>
				</table>
			  ';

		// On chercche le niveau actuelle du joueur pour le batiment demandé
		$nivbatj = explode(",",$baserow['batiments']) ;
		$niv = $nivbatj[$batiment['id']  - 1];
		$nivj = $nivbatj[$batiment['id'] - 1];
		$niv = ($niv == 0)?'1':$niv;

		// On cherche le nombres de ressources existante dans le jeu
		$nb_ress = $sql->select1("SELECT COUNT(id) FROM phpsim_ressources ");
		$ress_nom = '';
		$nbress = 1 ;
		while($nbress <= $nb_ress) 
		{ 
			$ress_nom .= '<td align="center"><u>'.$sql->select1('SELECT nom FROM phpsim_ressources WHERE id="'.$nbress.'" ').'</u></td>'; 
			$nbress++;
		}

		$teststk = 0;
		$test = 0;
		$prod = '';
		$prods = '';

		while($niv < ($nivj+10) )
		{
			$productions = "";
			$prod3 = $bat->calculer_ressources(($niv-1), $batiment["production"], $batiment["production_evo"]);
			$prod2 = explode(",",$prod3);
			foreach($prod2 as $prod1) 
			{ 
				$productions .= '<td align="center">'.$prod1.'</td>';
				$test = $test + $prod1;
			}

			if($controlrow["energie_activee"] == 1)
			{
				$energie = ($bat->calculer_energie(($niv-1), $batiment['consommation'], $batiment['consommation_evo'])*-1);
				$energie2 = $bat->calculer_energie(($niv-1), $batiment['production_energie'], $batiment['production_energie_evo']);
				$energie3 = '<td align="center">'.($energie+$energie2).'</td>';
				$enetest = ($energie+$energie2);

				if(is_numeric($enetest)) 
				{
					$test = $test + $enetest;
				}

			}

			$stockage = "";
			$stk3 = $bat->calculer_ressources(($niv-1), $batiment["stockage"], $batiment["stockage_evo"]);
			$stk2 = explode(",",$stk3);
			foreach($stk2 as $stk1) 
			{ 
				$stockage .= '<td align="center">'.$stk1.'</td>';
				$teststk = $teststk + $stk1;
			}

			$prod .= '<tr><td align="center">'.$niv.'</td>'.$productions.$energie3.'</tr>'."\n";

			$prods .= '<tr><td align="center">'.$niv.'</td>'.$stockage.'</tr>'."\n";
			$niv++;
		}

		if($energie3 == 0 || $energie3 == '') 
		{

			$enecolonne = '';

		}

		if($test != 0) 
		{

			// On affiche la production en partant
			$prod = '<br><br><table border="1">
			<tr><th colspan="'.($nb_ress+2).'"><u>'.$lang["pdbati"].'</u></th>
			<tr><td align="center"><u>'.$lang["niv"].'</u></td>'.$ress_nom.'<td align="center"><u>'.$controlrow['energie_nom'].'</u></td></tr>'."\n".$prod.'</table>';

		} 
		else 
		{

			$prod = '';

		}

		if($teststk != 0) 
		{

			$prods = '
						<br><br><table border="1">
						<tr><th colspan="'.($nb_ress+1).'"><u>'.$lang["capacites"].'</u></th>
						<tr><td align="center"><u>'.$lang["niv"].'</u></td>'.$ress_nom.'</tr>'."\n".$prods.'</table>
					 ';

		} 
		else 
		{

			$prods = '';

		}


		$page .=  $prod.$prods;



		$cache->save($page, 'bat'.$_GET['bat'].'_'.$userrow['id'],"infosct",1); 
	}



}
##################################################################################
elseif(isset($_GET['rech']) ) // Si il s'agit d'une recherche
{



}


?>