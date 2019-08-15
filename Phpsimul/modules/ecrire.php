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


if(@$_POST['postok'] == "postok") // si le formulaire a deja été posté ont éxécute une action
{ // debut if form deja posté

if (empty($_POST["destinataire"])) {
					$tpl->value("status", "Veillez indiquez un destinataire");
					$tpl->value("destinataire", $_POST['destinataire']);
					$tpl->value("titre", $_POST['titre']);
					$tpl->value("message", $_POST['message']);

					$page = $tpl->construire("message_ecrire");
} 
elseif (empty($_POST["titre"])) {
					$tpl->value("status", "Veillez indiquez un titre");
					$tpl->value("destinataire", $_POST['destinataire']);
					$tpl->value("titre", $_POST['titre']);
					$tpl->value("message", $_POST['message']);

					$page = $tpl->construire("message_ecrire");
}
elseif (empty($_POST["message"])) {
					$tpl->value("status", "Et le message ??");
					$tpl->value("destinataire", $_POST['destinataire']);
					$tpl->value("titre", $_POST['titre']);
					$tpl->value("message", $_POST['message']);

					$page = $tpl->construire("message_ecrire");
} 
else {
    $query = mysql_query("SELECT id FROM phpsim_users WHERE nom='" . $_POST["destinataire"] . "'");
    if (mysql_num_rows($query) == 0) {
					$tpl->value("status", "Le joueur n'existe pas");
					$tpl->value("destinataire", $_POST['destinataire']);
					$tpl->value("titre", $_POST['titre']);
					$tpl->value("message", $_POST['message']);

					$page = $tpl->construire("message_ecrire");    
    }
    else
    {
    $row = mysql_fetch_array($query);
    $time = time();
    mysql_query("INSERT INTO phpsim_messagerie SET id='', titre='" . addslashes($_POST["titre"]) . "', 
                 message='" . addslashes($_POST["message"]) . "', date='" . $time . "', 
                 emetteur='" . $userrow["id"] . "', destinataire='" . $row["id"] . "'");
					
					$tpl->value("status", "Le message a bien été envoyé");
					$tpl->value("destinataire", "");
					$tpl->value("titre", "(Sans Titre)");
					$tpl->value("message", "");

					$page = $tpl->construire("message_ecrire");}
    }






} // fin if form deja posté
#####################################################################################################################
else // si c'est la premiere fois que la page s'affiche
{
// si le joueurs est arrivé par ici en cliquant sur un nom de joueur dans le but de lui envoyer un message, 
// on met le nom du joueur ici, sinon on affiche du vide
if(isset($_GET["destinataire"])) { $destinataire = $_GET["destinataire"]; } 
else { $destinataire = ""; }

$tpl->value("status", "Nouveau Message");
$tpl->value("destinataire", $destinataire);
$tpl->value("titre", "(Sans Titre)");
$tpl->value("message", "");

$page = $tpl->construire("message_ecrire");


}




?>