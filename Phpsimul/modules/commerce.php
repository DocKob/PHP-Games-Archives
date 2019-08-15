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

lang("commerce");

include("classes/commerce.class.php");
$com = new commerce;

#########################################################################################

if(@$_GET["page"] == "acheter") {

	$page = "<center>".$lang["cbacheter"]."<br><br>
	<form action='index.php?mod=commerce&page=acheter2' method='post'><table border='0'>";
	
	$query = $sql->query("SELECT * FROM phpsim_ressources ORDER BY id");
	
	$val = explode(",", $controlrow["valeurs"]);
	$ress = explode(",", $controlrow["banque"]);
	
			$page .= "
			
		<script>
		function verif(champ, valeur, max)
		{
		
		contenu = parseFloat(document.getElementById(champ).value);
		
		if(contenu == '') {
			contenu = 0;
		}
		
		if(contenu > max) {
			contenu = max;
		}
		
		test = contenu/valeur;
		
		test = Math.round(test);
		
		credits = test;
		contenu = test*valeur;
		
		document.getElementById(champ).value = contenu;
			
		document.getElementById(champ + 'c').innerHTML = credits;
		
		}
		</script>";
	
	while($row = mysql_fetch_array($query)) {

		$valeur = $val[$row["id"] - 1];
		$ressource = $ress[$row["id"] - 1];
		
		$page .= "<tr><td>".$row["nom"]." : </td><td>";
		
		$page .= "<input type='text' name='ress".($row["id"] - 1)."' id='ress".($row["id"] - 1).
		         "' value='0' onchange=\"verif('ress".($row["id"] - 1)."', '".$valeur."', '".$ressource."'); \">
		         &nbsp;&nbsp;(<span id='ress".($row["id"] - 1)."c'>0</span> crédits)</td></tr>";

	}
	
	$page .= "</table><br><input type='submit' value='Valider'></form></center>";

	

#########################################################################################
	
} elseif(@$_GET["page"] == "acheter2") {


	$chiffre = 0;
	$ress = "";
	$credits = 0;
	$valeurs = explode(",", $controlrow["valeurs"]);

	while(isset($_POST["ress".$chiffre])) {
		$ress .= $_POST["ress".$chiffre].",";
		$credits = $credits + round($_POST["ress".$chiffre]/$valeurs[$chiffre]);
		$chiffre = $chiffre + 1;
	}

	$baseressources = $com->modif_ressources($baserow["ressources"], "+", $ress);
	$banqueressources = $com->modif_ressources2($controlrow["banque"], "-", $ress);
	$usercredits = $userrow["credits"] - $credits;
	$dernier_echange = time() + $controlrow["tps_echanges"];
	
	if($usercredits < 0) {
	$page = $lang["pasassezcredits"]." <br><a href='index.php?mod=commerce&page=acheter2'>".$lang["retour"]."</a>";
	} else {
	
	$sql->update("UPDATE phpsim_bases SET ressources='".$baseressources."' WHERE id='".$baserow["id"]."'");
	$sql->update("UPDATE phpsim_users SET credits='".$usercredits."', dernier_achat='".$dernier_echange."' WHERE id='".$userrow["id"]."'");
	$sql->update("UPDATE phpsim_config SET config_value='".$banqueressources."' WHERE config_name='banque'");
	
	$date = $dernier_echange + $controlrow["tps_echanges"];
	
	$date = date("d/m/Y à H:i:s", $date);
	
	$page=$lang["achatbieneffectue"]." ".$date."<br><br><a href='index.php?mod=commerce'>".$lang["retour"]."</a>";

	}
	
#########################################################################################

} elseif(@$_GET["page"] == "vendre") {

	$page = "<center>".$lang["cbvendre"]."<br><br>
	<form action='index.php?mod=commerce&page=vendre2' method='post'><table border='0'>";
	
	$query = $sql->query("SELECT * FROM phpsim_ressources ORDER BY id");
	
	$val = explode(",", $controlrow["valeurs"]);
	$ress = explode(",", $baserow["ressources"]);
	
			$page .= "<script>
		
		function verif(champ, valeur, max)
		{
		
		contenu = parseFloat(document.getElementById(champ).value);
		
		if(contenu == '') {
			contenu = 0;
		}
		
		if(contenu > max) {
			contenu = max;
		}
		
		test = contenu/valeur;
		
		test = Math.round(test);
		
		credits = test;
		contenu = test*valeur;
		
		document.getElementById(champ).value = contenu;
			
		document.getElementById(champ + 'c').innerHTML = credits;
		
		}
		</script>";
	
	while($row = mysql_fetch_array($query)) {

		$valeur = $val[$row["id"] - 1];
		$ressource = $ress[$row["id"] - 1];
		
		$page .= "<tr><td>".$row["nom"]." : </td><td>";
		
		$page .= "<input type='text' name='ress".($row["id"] - 1)."' id='ress".($row["id"] - 1)."' value='0' onchange=\"verif('ress".($row["id"] - 1)."', '".$valeur."', '".$ressource."'); \">&nbsp;&nbsp;(<span id='ress".($row["id"] - 1)."c'>0</span> ".$lang["credits"].")</td></tr>";

	}
	
	$page .= "</table><br><input type='submit' value='Valider'></form></center>";

#########################################################################################
	
} elseif(@$_GET["page"] == "vendre2") {
	
	$chiffre = 0;
	$ress = "";
	$credits = 0;
	$valeurs = explode(",", $controlrow["valeurs"]);

	while(isset($_POST["ress".$chiffre])) {
		$ress .= $_POST["ress".$chiffre].",";
		$credits = $credits + round($_POST["ress".$chiffre]/$valeurs[$chiffre]);
		$chiffre = $chiffre + 1;
	}

	$baseressources = $com->modif_ressources($baserow["ressources"], "-", $ress);
	$banqueressources = $com->modif_ressources($controlrow["banque"], "+", $ress);
	$usercredits = $userrow["credits"] + $credits;
	$dernier_echange = time() + $controlrow["tps_echanges"];
	
	$sql->update("UPDATE phpsim_bases SET ressources='".$baseressources."' WHERE id='".$baserow["id"]."'");
	$sql->update("UPDATE phpsim_users SET credits='".$usercredits."', derniere_vente='".$dernier_echange."' WHERE id='".$userrow["id"]."'");
	$sql->update("UPDATE phpsim_config SET config_value='".$banqueressources."' WHERE config_name='banque'");
	
	$date = $dernier_echange + $controlrow["tps_echanges"];
	
	$date = date("d/m/Y à H:i:s", $date);
	
	$page=$lang["ventebieneffectuee"]." ".$date."<br><br><a href='index.php?mod=commerce'>".$lang["retour"]."</a>";

#########################################################################################
} 
else // Page d'acceuil lorsque rien a été demandé
{

	$page = "<center>".$lang["commerceaccueil"];

	$page .= "<br><br>".$lang["vouspossedez"]." ".$userrow["credits"]." ".$lang["credits"].". <br><br><br>".$lang["quefaire"]."<br><br>";
	
	if($userrow["derniere_vente"] < time()) {	
		$page .= "<a href='index.php?mod=commerce&page=vendre'>".$lang["vendreress"]."</a><br>";
	} else {
		$date = date("d/m/Y à H:i:s", $userrow["derniere_vente"]);
		$page .= $lang["pasassezattendupourvendre"]." ".$date.".<br>";
	}
	
	if($userrow["dernier_achat"] < time()) {	
		$page .= "<a href='index.php?mod=commerce&page=acheter'>".$lang["acheterress"]."</a>";
	} else {
		$date = date("d/m/Y à H:i:s", $userrow["dernier_achat"]);
		$page .= $lang["pasassezattendupouracheter"]." ".$date.".";
	}
	
	$page .= "<br><br></center>";

}

#########################################################################################

?>