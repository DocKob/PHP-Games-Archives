<?php
// Document créé par           nummi           pour PHPsimul 
// Modifié par Max485
//-------------------Formulaire pour créer alliance--------------------------------\\

/*

Infos:

*/

if(isset($_POST['nom']) ) // si on a cliquez sur envoye le form alors on arrive ici
{ // debut if isset post nom

// On met les variable avant, sinon elle ont boguer mon elseif
@$traitement_nom = mysql_query("SELECT nom FROM phpsim_alliance WHERE nom='" . mysql_real_escape_string($_POST["nom"]) . "' LIMIT 1");
@$traitement_tag = mysql_query("SELECT tag FROM phpsim_alliance WHERE tag='" . mysql_real_escape_string($_POST["tag"]) . "' LIMIT 1");

// On commence par verifie que la personne a bien mis un tag et un nom
if (empty($_POST["nom"]) or empty($_POST["tag"]) ) 
{
$infos = array(
               "nom" => $_POST["nom"],
               "tag" => $_POST["tag"],
               "logo" => $_POST["logo"],
               "error" => "Merci de bien vouloir indiquer un nom ainsi qu'un tag.<br><br>",
              ) ;
formulaire_creer_alli($infos) ; // on affiche le forulaire
}

// On teste si le nom est pas deja pris
elseif (mysql_num_rows($traitement_nom) > 0) 
{
$infos = array(
               "nom" => $_POST["nom"],
               "tag" => $_POST["tag"],
               "logo" => $_POST["logo"],
               "error" => "Ce nom d'alliance est déjà utilisé. Veuillez en choisir un autre.<br><br>",
              ) ;
formulaire_creer_alli($infos) ; // on affiche le forulaire
}

// On teste si le tag n'existe pas deja
elseif (mysql_num_rows($traitement_tag) > 0) 
{
$infos = array(
               "nom" => $_POST["nom"],
               "tag" => $_POST["tag"],
               "logo" => $_POST["logo"],
               "error" => "Ce Tag est déjà utilisé. Veuillez en choisir un autre.<br><br>",
              ) ;
formulaire_creer_alli($infos) ; // on affiche le forulaire
}
else // pour créer l'alliance que si les données du haut sont correct
{
//-------------------Récupération des infos pour créer l'alliance--------------------------------\\
// On met la fonction mysql_real_escape_string() pour evité les injections sql
$nom = mysql_real_escape_string($_POST['nom']);
$tag = mysql_real_escape_string($_POST['tag']);
if(isset($_POST['logo']) ) {$logo = mysql_real_escape_string($_POST['logo']); } 
else { $logo = ""; }

//-------------------Envoi des infos--------------------------------\\
$idrow = mysql_query("SELECT MAX(id) AS idmax FROM phpsim_alliance");
$idrow = mysql_fetch_array($idrow);
$id = $idrow["idmax"] + 1; // permet de saisir comme id un chiffre juste au dessus de l'id actuel

$idrow = mysql_query("SELECT MAX(id) AS idmax FROM phpsim_forums");
$idrow = mysql_fetch_array($idrow);
$id2 = $idrow["idmax"] + 1; // permet de saisir comme id un chiffre juste au dessus de l'id actuel

mysql_query("INSERT INTO phpsim_alliance (id, nom, tag, adresse_forum, logo) VALUES ( '".$id."','".$nom."', '".$tag."', '".$id2."','".$logo."' )");
mysql_query("INSERT INTO phpsim_forums SET id='".$id2."', nom='Alliance ".$nom."', description='Forum de l\'alliance ".$nom."', alliance='".$id."'");
mysql_query("UPDATE phpsim_users SET admin_alli='1', alli = '".$id."' WHERE id = '".$userid."' ");


//-------------------Texte pour dire que alliance a bien été  créé --------------------------------\\
$page = "<b><font size='+2'>Votre alliance a bien été créée.</font></b>";

include("alliance.php");

}

} // fin if isset post nom 

###################################################################################################################

// affichage de la page par default (si form pas encore envoyé)
else
{
// si on a pas encore voulu envoyé le formulaire on definit un tableau par default
if(empty($infos) )
{
$infos = array(
               "nom" => "",
               "tag" => "",
               "logo" => "",
               "error" => "",
              ) ;
}

formulaire_creer_alli($infos) ; // on affiche le forulaire
}


















###################################################################################################################

function formulaire_creer_alli($données_du_tableau)
{

global $page ; // on passe la variable en global, 
               // Infos: Faut le faire dans chaque fonction qui inclut une variable $page
$page = " 
<font size='+2'>Créer une alliance : </font>
<br><br>
".@$données_du_tableau['error']."
<table>
<form method='post' action=''>
<tr><td>Nom de l'alliance : </td><td><input type='text' name='nom' value='".@$données_du_tableau['nom']."'></td></tr>
<tr><td>Tag : </td><td><input type='text' name='tag' value='".@$données_du_tableau['tag']."'></td></tr>
<tr><td>Logo de l'alliance : </td><td><input size='50' type='text' name='logo' value='".@$données_du_tableau['logo']."'><i> &nbsp;(Entrez une url)</i></td></tr> 
</table>
".'
<br><input type="submit" name="action" value="Créer l\'alliance"></form><br>
';
}

?>