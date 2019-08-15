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


include("classes/unites.class.php");
$unit = new unites;

if(isset($_GET["c1"])) { $c1 = $_GET["c1"]; }
if(isset($_GET["c2"])) { $c2 = $_GET["c2"]; }
if(isset($_GET["c3"])) { $c3 = $_GET["c3"]; }
if(isset($_POST["c1"])) { $c1 = $_POST["c1"]; }
if(isset($_POST["c2"])) { $c2 = $_POST["c2"]; }
if(isset($_POST["c3"])) { $c3 = $_POST["c3"]; }

if (!empty($c1) && !empty($c2) && !empty($c3)) 
{
    if (isset($_GET["etape"]) && $_GET["etape"] == 2) 
	{

		$base2 = $sql->select("SELECT phpsim_bases.*, phpsim_users.points FROM phpsim_bases, phpsim_users WHERE phpsim_bases.utilisateur=phpsim_users.id AND phpsim_bases.ordre_1='" . $c1 . "' AND phpsim_bases.ordre_2='" . $c2 . "' AND phpsim_bases.ordre_3='" . $c3 . "' LIMIT 1");

		$chiffre = 0;
		$unites = "";

		while(isset($_POST[$chiffre])) 
		{
			$unites .= $_POST[$chiffre].",";
			$chiffre = $chiffre + 1;
		}

		$test = $unites;
		$test = explode(",", $test);
		$chiffre = 0;
		$somme = 0;

		while(isset($test[$chiffre])) 
		{
			$somme = $somme + $test[$chiffre];

			$chiffre = $chiffre + 1;
		}

		if($somme <= 0) 
		{

			die("Vous devez envoyer minimum une unite.");

		}

		$chiffre = 0;
		$ress = "";

		while(isset($_POST["ress".$chiffre])) 
		{
			$ress .= $_POST["ress".$chiffre].",";
			$chiffre = $chiffre + 1;
		}


		$ressources = $unit->modif_ressources($baserow["ressources"], "-", $ress);


		$baseunites = $unit->modif_unites($baserow["unites"], "-", $unites);

		// DEBUT RECUPERATION TEMPS DE TRAJET

			$multiplicateur = 1;

			if($c3 > $baserow["ordre_3"]) 
			{
				$multiplicateur += ($c3 - $baserow["ordre_3"]);
			}
			elseif($c3 < $baserow["ordre_3"]) 
			{
				$multiplicateur += ($baserow["ordre_3"] - $c3);
			}

			if($c2 > $baserow["ordre_2"]) 
			{
				$multiplicateur += (($c2 - $baserow["ordre_2"])*$controlrow["tps_ordre_2"]);
			}
			elseif($c2 < $baserow["ordre_2"]) 
			{
				$multiplicateur += (($baserow["ordre_2"] - $c2)*$controlrow["tps_ordre_2"]);
			}

			if($c1 > $baserow["ordre_1"]) 
			{
				$multiplicateur += (($c1 - $baserow["ordre_1"])*$controlrow["tps_ordre_1"]);
			}
			elseif($c1 < $baserow["ordre_1"]) 
			{
				$multiplicateur += (($baserow["ordre_1"] - $c1)*$controlrow["tps_ordre_1"]);
			}

			$tempstotal = $controlrow["temps_voyage"] * $multiplicateur;
			$tempstotal /= ( ($userrow["vitesse_supplementaire"] / 100) + 1 ); // On rajoute la vitesse 
			
		// FIN RECUPERATION TEMPS DE TRAJET

		if($_POST["mission"] == 2) 
		{
			$tempstotal = round($tempstotal/10);
		}

				$carbu = $unit->calculer_carbu($controlrow["carburant"], $multiplicateur);

				$heure_arrivee = time() + $tempstotal;

				$attdef = $unit->calculer_attaque_et_defense($unites);
				$attdef2 = explode("|", $attdef);
				$attaque = $attdef2[0] * (1 + ($userrow["attaque_supplementaire"] / 100));
				$defense = $attdef2[1] * (1 + ($userrow["defense_supplementaire"] / 100));
				$bouclier = $attdef2[2] * (1 + ($userrow["bouclier_supplementaire"] / 100));

				if($_POST["mission"] == "VIDE") 
				{
					die("Veuillez séléctionner une mission.");
				}

		$ressources = $unit->modif_ressources($ressources, "-", $carbu);

		if(@$_POST["mission"] == 0 && $base2["points"] <= $controlrow["points_mini"]) 
		{

			die("Vous ne pouvez pas attaquer ce joueur car son nombre de points ne dépasse pas ".$controlrow["points_mini"].", il est donc encore sous la protection des joueurs faibles.");

		}

		if(@$_POST["mission"] == 0 && $base2["utilisateur"] == $userrow["id"]) 
		{
			die("Vous ne pouvez pas vous attaquer vous même.");
		}

		$stockage = 0;

		$stk = $sql->query("SELECT stockage, id FROM phpsim_chantier ORDER BY id");

		$st = $unites;

		$st = explode(",", $st);

		while($row = mysql_fetch_array($stk) ) 
		{

			if(isset($st[$row["id"] - 1])) 
			{

				$stockage = $stockage + ($row["stockage"] * $st[$row["id"] - 1]);

			}

		}


		$test2 = $ress;
		$test = explode(",", $test2);
		$chiffre = 0;
		$somme = 0;

		while(isset($test[$chiffre])) 
		{
			$somme = $somme + $test[$chiffre];

			$chiffre = $chiffre + 1;
		}

		if($somme > $stockage) 
		{

			die("Vous ne pouvez pas transporter autant de ressources.");

		}



		$sql->update("INSERT INTO phpsim_unites SET
						user_depart='" . $userrow["id"] . "',
						user_arrivee='" . $base2["utilisateur"] . "',
						base_depart='" . $baserow["id"] . "',
						base_arrivee='" . $base2["id"] . "',
						base_proprietaire='" . $baserow["id"] . "',
						unites='" . $unites . "',
						attaque='" . $attaque . "',
						defense='" . $defense . "',
						heure_arrivee='" . $heure_arrivee . "',
						tps_total='" . $tempstotal . "',
						mission='" . $_POST["mission"] . "',
						ressources='".$ress."',
						stockage='".$stockage."',
						bouclier='".$bouclier."'
					");

		$sql->update("UPDATE phpsim_bases SET unites='" . $baseunites . "', ressources='".$ressources."' WHERE id='" . $baserow["id"] . "'");

		$page = "Envoi effectué.<br><a href='index.php'>Retour</a>";
    } 
	else 
	{

		$multiplicateur = 1;

		if($c3 > $baserow["ordre_3"]) 
		{
			$multiplicateur += ($c3 - $baserow["ordre_3"]);
		}
		elseif($c3 < $baserow["ordre_3"]) 
		{
			$multiplicateur += ($baserow["ordre_3"] - $c3);
		}

		if($c2 > $baserow["ordre_2"]) 
		{
			$multiplicateur += (($c2 - $baserow["ordre_2"])*$controlrow["tps_ordre_2"]);
		}
		elseif($c2 < $baserow["ordre_2"]) 
		{
			$multiplicateur += (($baserow["ordre_2"] - $c2)*$controlrow["tps_ordre_2"]);
		}

		if($c1 > $baserow["ordre_1"]) 
		{
			$multiplicateur += (($c1 - $baserow["ordre_1"])*$controlrow["tps_ordre_1"]);
		}
		elseif($c1 < $baserow["ordre_1"]) 
		{
			$multiplicateur += (($baserow["ordre_1"] - $c1)*$controlrow["tps_ordre_1"]);
		}

		$carbu = $unit->calculer_carbu($controlrow["carburant"], $multiplicateur);

		$page = "<form method='post' action='index.php?mod=unites&c1=".$c1."&c2=".$c2."&c3=".$c3."&etape=2'>Mission : <select name='mission'>
		<option value='VIDE'>-------------</option>
		<option value='0'>Attaquer</option>
		<option value='2'>Espionner</option>
		<option value='3'>Transporter</option>
		</select><br><br>

		<u>Carburant nécéssaire : </u><br>".$unit->afficher_ressources($carbu)."<br><u>Temps de voyage : </u>".$unit->afficher_temps(($controlrow["temps_voyage"] * $multiplicateur / ($userrow["vitesse_supplementaire"] / 100 + 1) ) )."


		<br><br>Envoyer : <br><table border='0'>";

		$query = $sql->query("SELECT * FROM phpsim_chantier");
		$unites = explode(",", $baserow["unites"]);

		while ($row = mysql_fetch_array($query)) 
		{

			if($row["race_".$userrow["race"]] == 1) 
			{

				$qte = $unites[$row["id"] - 1];
				if ($qte == "") 
				{
					$qte = 0;
				}
				$page .= "<tr><td><input type='text' size='5' name='" . ($row["id"] - 1) . "' value='0'></td><td>" . $row["nom"] . " ( " . $qte . " disponibles )</td></tr>";

			} 
			else 
			{

				$page .= "<input type='hidden' name='" . ($row["id"] - 1) . "' value='0'>";

			}

		}

		$page .= "</table><table border='0'>";

		$query = $sql->query("SELECT * FROM phpsim_ressources ORDER BY id");

		while($row = mysql_fetch_array($query))
		{

			$page .= "<tr><td>".$row["nom"]." : </td><td><input type='text' name='ress".($row["id"] - 1)."' value='0'></td></tr>";

		}

		$page .= "</table><br><input type='submit' value='Envoyer'></form>";
	}
} 
else // Si on a pas encore posté de coordonnées
{
	include("coordonnees.php");
}

?>