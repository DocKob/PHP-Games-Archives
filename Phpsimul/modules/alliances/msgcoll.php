<?php

/*

msgcoll.php - Permet l'envoye de message au membre de l'alliance

Une selection de Rang peut etre fait, dans le cas contraire, le message sera envoyé a tous les membres

Le message porte dans son titre [Alliance] permettant de savoir qu'il vient de l'alliance

Ainsi que [le Rang qui a recu le message]

Codé entierement par Max485

*/




if(@$_POST['postok'] == "postok") // si le formulaire a deja été posté ont éxécute une action
{ // debut if form deja posté

if (empty($_POST["desti"]) ) 
{
					// On affiche le formulaire
                      $données_form = array(
                      				   		  "status" => "Veuillez indiquer un destinataire.",
                      							  "desti" => $_POST['desti'],
                      					        "titre" => $_POST['titre'],
                      							  "message" => $_POST['message'],
                    								  ) ;

             msg_ecrire_form($données_form) ;
}
elseif (empty($_POST["titre"]) ) 
{
					// On affiche le formulaire
                      $données_form = array(
                      				   		  "status" => "Veuillez indiquer un titre.",
                      							  "desti" => $_POST['desti'],
                      					        "titre" => $_POST['titre'],
                      							  "message" => $_POST['message'],
                    								  ) ;

             msg_ecrire_form($données_form) ;
}
elseif (empty($_POST["message"]) ) 
{
					// On affiche le formulaire
                      $données_form = array(
                      				   		  "status" => "Et le message ??",
                      							  "desti" => $_POST['desti'],
                      					        "titre" => $_POST['titre'],
                      							  "message" => $_POST['message'],
                    								  ) ;

             msg_ecrire_form($données_form) ;
} 
else {
    $données_rangs1 = mysql_query("SELECT * FROM phpsim_rangs WHERE id='" . $_POST["desti"] . "'");
    if (mysql_num_rows($données_rangs1) == 0 and $_POST["desti"] != 00) 
    {
					// On affiche le formulaire
                      $données_form = array(
                      				   		  "status" => "Le rang n'existe pas",
                      							  "desti" => $_POST['desti'],
                      					        "titre" => $_POST['titre'],
                      							  "message" => $_POST['message'],
                    								  ) ;

             msg_ecrire_form($données_form) ;   
    }
    else
    {
    $données_rangs = mysql_fetch_array($données_rangs1);
    $time = time();
    
    if($_POST['desti'] == 00) // alors le message doit etre envoyer a tous les membre de l'alli
    { // debut if envoyer a tous    
    
    // On cherche toutes les personne etant dans l'alliance
    $users_in_alli = mysql_query("SELECT * FROM phpsim_users WHERE alli='".$userrow['alli']."' ") ;
    
    // Et on envoye le message a tous ce qui sont dans l'alliance
    while($users_infos = mysql_fetch_array($users_in_alli) )
    {
    mysql_query("INSERT INTO phpsim_messagerie SET 
                 id='', 
                 titre='[Alliance][Tous] ".$_POST["titre"] . "', 
                 message='" . $_POST["message"] . "', 
                 date='" . $time . "', 
                 emetteur='" . $userrow["id"] . "', 
                 destinataire='" . $users_infos["id"] . "'
                ");
    }
// On affiche le formulaire
                      $données_form = array(
                      				   		  "status" => "Le message a bien été envoyé.",
                      							  "desti" => "0",
                      					        "titre" => "(Sans Titre)",
                      							  "message" => "",
                    								  ) ;

             msg_ecrire_form($données_form) ;
    } // fin if envoyer a tous
    else
    { // debut else envoyer le message a rang x
    // On cherche toutes les personne etant dans le rang
    $users_in_rangs = mysql_query("SELECT * FROM phpsim_users WHERE rangs='".$_POST['desti']."' ") ;
    
    // On recupere le nom du rang
    $données_rangs1 = mysql_query("SELECT * FROM phpsim_rangs WHERE id='".$_POST['desti']."' ") ;
    $données_rangs = mysql_fetch_array($données_rangs1) ;
    $nom_rang = $données_rangs['nom'] ;
    
    // Et on envoye le message a tous ce qui sont dans le rang
    while($users_infos = mysql_fetch_array($users_in_rangs) )
    {
    mysql_query("INSERT INTO phpsim_messagerie SET 
                 id='', 
                 titre='[Alliance][".$nom_rang."] ".$_POST["titre"] . "', 
                 message='" . $_POST["message"] . "', 
                 date='" . $time . "', 
                 emetteur='" . $userrow["id"] . "', 
                 destinataire='" . $users_infos["id"] . "'
                ");
    }
// On affiche le formulaire
                      $données_form = array(
                      				   		  "status" => "Le message a bien été envoyé.",
                      							  "desti" => "0",
                      					        "titre" => "(Sans Titre)",
                      							  "message" => "",
                    								  ) ;

             msg_ecrire_form($données_form) ;
             
    } // fin else envoyer le message a rang x
	 
	 }
}






} // fin if form deja posté
#####################################################################################################################
else // si c'est la premiere fois que la page s'affiche
{
$desti="0"; // On definit destinataire = 0 pour affichez Tous par default

// On affiche le forumaire
$données_form = array(
                      "status" => "Nouveau message",
                      "desti" => $desti,
                      "titre" => "(Sans Titre)",
                      "message" => "",
                     ) ;

msg_ecrire_form($données_form) ;


}
#####################################################################################################################
function msg_ecrire_form($données_form_cette_variable_est_un_tableau)
{
extract($données_form_cette_variable_est_un_tableau);

global $page;
global $userrow;

// On recupere et on met en forme les rang existants
$rangs1 = mysql_query("SELECT * FROM phpsim_rangs WHERE idalli='".$userrow['alli']."' ORDER BY nom ") ;
while($rangs = mysql_fetch_array($rangs1) )
{
@$dest .= "<option "; if($desti == $rangs['id']) { $dest.=" SELECTED "; } $dest.="value='".$rangs['id']."'>".$rangs['nom']."</option>";
}
$dest .="<option "; if($desti == 0) { $dest.=" SELECTED "; } $dest.=" value='00'>Tous</option>";
// Tout les rangs existant on été recuperé dans une balise select nommé "destinataire"


$page="
<a href='index.php?mod=alliances/alliance'>Retour a la page d'alliance</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href='index.php?mod=bbcode'>Voir BBCode existant</a>

<h1><font color='FF0000'>".$status."</font></h1>
<form action='' method='post'>
<table border=0>
<tr><td>Destinataire : </td><td><select name='desti' STYLE='width:100%'>".$dest."</select></td></tr>
<tr><td>Titre : </td><td><input type='text' size='52' name='titre' value='".$titre."'></td></tr>
<tr><td>Message : </td></tr></table><textarea name='message' cols='50' rows='10'>".$message."</textarea>
<input type='hidden' name='postok' value='postok'>
<br><input type='submit' value='Envoyer'>
</form>
";
}


?>