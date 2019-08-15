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


if (@$_POST["nom"] != '' && @$_POST['pass'] != '' ) // Dans le cas ou le joueur a posté un nom et un pass
{
    $pass_md5 = md5($_POST['pass']); // On crypte le pass en md5
	
    $query = $sql->query("SELECT id FROM phpsim_users WHERE nom='" . $_POST['nom'] . "' AND pass='" . $pass_md5 . "' LIMIT 1");
	
    if (mysql_num_rows($query) != 1) // Dans le cas ou ce n'est pas des identifiants valide
	{
        die("Pseudo ou mot de passe invalide, veuillez vous relogguer avec vos bons identifiants.");
    }
    $row = mysql_fetch_array($query); // Dans le as ou les identifiants sont valide, on recupere les infos du joueur
	
	$_SESSION['idjoueur'] = $row['id']; // On recupere l'id du joueur dans une session
	
	die('<script>location="../index.php"</script>'); // on redirige sur l'index du jeu
	
}


$tpl->value('inscrit_total', $inscrit_total); // Le nombre d'inscrit dans le jeu
$page = $tpl->construire('login/connexion_form');

?>