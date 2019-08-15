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


####################################################################################
## Si on demande une modif de l'avatar

if (@!empty($_POST["avatar"]) || @!empty($_FILES['imgperso']['name']) ) // Si un des champ de l'avatar est rempli
{

	if(@isset($_FILES['imgperso']['name']) ) // Si un fichier est envoyé
	{

		if($controlrow['upload_avatars_actif'] == 1 && eregi('jpg|jpeg|png|gif',substr($_FILES['imgperso']["name"],-3) ) && $_FILES['imgperso']['size'] <= 50000) // test si le format est correct
		{ 
	         // On compte le nombre de fichiers dans le dossier pour donnée le nom d'un chiffre au fichiers
	         $count = 0 ;
				$dir = opendir("avatars_perso") ;
				while($file = readdir($dir) )
				{
				if(!is_dir($file) ) { if(!eregi('index', $file) || !eregi('thumbs', $file)) { $count ++; } } // On incremente la valeur qui si ce n'est pas un fichier index 
				}
	         $ext = substr($_FILES['imgperso']["name"],-3) ;
	         $copy = copy($_FILES['imgperso']['tmp_name'],"avatars_perso/".$count.'.'.$ext );
			
				$filevalide = "1" ;	
		}
		else // si le format est incorrect alors on change pas l'image
		{
		$filevalide = "0" ;
		}
	}
	else // Si aucun fichier n'est envoyé alors on passe ici
	{
	$filevalide ="0" ;
	}

		
if(@$filevalide == "1") // Si le fichier est valide on met le lien du fichiers dans la base des joueur
{
$sql->update('UPDATE phpsim_users SET avatar="' . $controlrow['url'] . 'avatars_perso/' . $count .'.'. $ext . '" WHERE id="'.$userrow['id'].'" ');
die('<script>document.location="index.php?mod=profil"</script>');
}
elseif(@$_POST['avatar'] != "") // Si avatars n'est pas vide
{
$sql->update("UPDATE phpsim_users SET avatar='" . $_POST['avatar'] . "' WHERE id='".$userrow['id']."' ");
die('<script>document.location="index.php?mod=profil"</script>');
}
else // Aucun avatars envoyé
{
die('<script>document.location="index.php?mod=profil&ch=av"</script>');
}

}
####################################################################################
## Si on demande une modif du profil

if ($_POST["pass1"] != "") 
{
    $verifpass = md5($_POST["pass1"]);
    if ($verifpass != $userrow["pass"]) {
        $page = "<h2>Le mot de passe entré est incorrect.</h2>";
        include('profil.php');
    } else {

        if($_POST["delete"] == "SUPPRIMER ".$userrow["nom"]) {
            die("<font color='red'>VOULEZ VOUS VRAIMENT SUPPRIMER VOTRE COMPTE ?<br><br><a href='index.php?mod=systeme/delete'>OUI</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='index.php'>NON</a></font>");
        }

        $nombre = 0;
        $requete = "UPDATE phpsim_users SET ";
        if (!empty($_POST["nom"])) {
            $requete .= "nom='" . $_POST["nom"] . "'";
            $nombre = $nombre + 1;
        }
        if (!empty($_POST["template"])) {
            if ($nombre > 0) {
            $requete .= ", template='" . $_POST["template"] . "'";
            } else {
            $requete .= "template='" . $_POST["template"] . "'";
            }
            $nombre = $nombre + 1;
        }

        if (!empty($_POST["messagerie_type"])) {
            if ($nombre > 0) {
            $requete .= ", messagerie_type='" . $_POST["messagerie_type"] . "'";
            } else {
            $requete .= "messagerie_type='" . $_POST["messagerie_type"] . "'";
            }
            $nombre = $nombre + 1;
        }


            if ($nombre > 0) {
            $requete .= ", signature='" . addslashes($_POST["signature"]) . "'";
            } else {
            $requete .= "signature='" . addslashes($_POST["signature"]) . "'";
            }
            $nombre = $nombre + 1;

        if (!empty($_POST["pass2"]) && !empty($_POST["pass3"]) && $_POST["pass2"] == $_POST["pass3"]) {
            $pass = md5($_POST["pass2"]);
            if ($nombre > 0) {
                $requete .= ", pass='" . $pass . "'";
            } else {
                $requete .= "pass='" . $pass . "'";
            }
            $nombre = $nombre + 1;
        }

        if (!empty($_POST["mail"])) {
            $test = 0;
            $test1 = explode("@", $_POST["mail"]);
            $test2 = explode(".", $test1[1]);
            if (@$test2[1] == "") {
                @$page .= "<h2>Le mail entré est incorrect.</h2>";
                include('profil.php');
                $test = 1;
            }

            if ($test == 0) {
                if ($nombre > 0) {
                    $requete .= ", mail='" . $_POST["mail"] . "'";
                } else {
                    $requete .= "mail='" . $_POST["mail"] . "'";
                }
                $nombre = $nombre + 1;
            }
        }

        if ($nombre > 0 && $test == 0) {
        $requete .= " WHERE nom='".$userrow["nom"]."' ";
            mysql_query($requete);
            die('<script>document.location.href="index.php?mod=profil"</script>');

        }
    }
} 
elseif ($_POST["pass1"] == "") 
{
    $page = "<h2>Merci d'entrer votre mot de passe si vous souhaitez modifier vos informations.</h2>";
    include("profil.php");
}

?>
