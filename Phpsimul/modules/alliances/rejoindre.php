<?php
// Document cr�� par           nummi           pour PHPsimul 
// Modifi� par Max485

@$alli_a_rejoindre = $mod[1] ; // le tableau mod contient les truc apres le | que l'on peut trouv� dans l'url 
                              // il est cr�er dans l'index du jeu

if( (empty($userrow['alli']) or $userrow['alli'] == 0) and (empty($userrow['alli']) or $userrow['candidature'] == 0) )
{ // debut if le joueur peut posez candidature

########################################################################################################################

if(empty($alli_a_rejoindre) ) // si le joueur n'est pas passez par le classement, on lui propose d'indiquez le nom de l'alli a rejoindre
{
if(empty($_POST['nom_alli_rej']) )
{
@$page.="
<font size='+2'><b>Rejoindre une alliance : </b></font><br>
<form method='post' action=''>
Inscrivez le <b>Tag</b> de l'alliance � rejoindre : <input type='text' name='nom_alli_rej'>
<br>
<input type='submit' value='Rejoindre l\'alliance'>
</form>
";
}
elseif(!empty($_POST['nom_alli_rej']) )
{
// On teste si l'alliance existe bel et bien
$donn�es_alli_a_rejoindre = mysql_query("SELECT * FROM phpsim_alliance WHERE tag='".$_POST['nom_alli_rej']."' ");
 if(mysql_num_rows($donn�es_alli_a_rejoindre) == 0)
 {
  @$page.="
  <font size='+2'><b>Rejoindre une alliance:</b></font><br><br>
  L'alliance selectionn�e n'existe pas. Merci d'indiquer un nom correct<br>
  <form method='post' action=''>
  Inscrivez le <b>Tag</b> de l'alliance a rejoindre : <input type='text' name='nom_alli_rej' value='".$_POST['nom_alli_rej']."'>
  <br>
  <input type='submit' value='Rejoindre l'alliance'>
  </form>
  ";
 }
 else
 {
  @$page.="
  <font size='+2'><b>Rejoindre une alliance : </b></font><br><br>
  L'alliance a bien �t� trouv�e<br><br>
  <a href='index.php?mod=alliances/rejoindre|".$_POST['nom_alli_rej']."'>Continuer l'inscription</a>
  ";
 }
}

}
else // si le joueur est pass� par le classement, alors le nom de l'alliance a rejoindre est pas vide
{ // debut else pass� par classement

// On recupere les donn�es de l'alli a rejoindre
$donn�es_alli_a_rejoindre = mysql_query("SELECT * FROM phpsim_alliance WHERE tag='".$alli_a_rejoindre."' ");
$donn�es_alli = mysql_fetch_array($donn�es_alli_a_rejoindre) ;

$total_de_membres1 = mysql_query("SELECT COUNT(id) As totmembres FROM phpsim_users WHERE alli = '".$donn�es_alli['id']."'");
$total_de_membres = mysql_fetch_array($total_de_membres1) ;

$points1 = mysql_query("SELECT SUM(points) As points FROM phpsim_users WHERE alli = '".$donn�es_alli['id']."'");
$points =  mysql_fetch_array($points1) ;

// On affiche la page permettant de confirm�
@$page.="
<font size='+2'><b>Rejoindre une alliance : </b></font><br><br>
Voici les infos de l'alliance que vous avez demand� de rejoindre : <br><br>
<table>
<tr>	
<td>Nom</td>	      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>	
<td>Tag</td>	      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>Points</td>      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>Nombre de membres</td> 
</tr>

<tr>	
<td>".$donn�es_alli['nom']."</td>	<td></td>
	<td>".$donn�es_alli['tag']."</td>	<td></td>
	<td>".$points['points']."</td>	<td></td>
	<td>".$total_de_membres['totmembres']."</td> <td></td>
	</tr>
</table>

<form method='post' action='index.php?mod=alliances/rejoindre2'> 
<br>Vous pouvez �crire un petit commentaire/motivation, et nous vous le conseillons : <br><br>
<textarea name='commentaire' rows='10' cols='50'>".$donn�es_alli['candidature']."</textarea>
<input type='hidden' name='tag_alli_rej' value='".$donn�es_alli['tag']."'>
<br><INPUT type='submit' name='rejoindre_alli' value='Confirmez'>
</form>
";

} // fin else pass� par classement





} // fin if le joueur peut posez candidature
else // si le joueur a deja une alliance alors on leprevient qu'il peut ajouter ca candidature
{
@$page.= "
Vous ne pouvez pas poser de candidature, vous �tes deja dans une alliance
<br><a href='javascript:history.back();'>Retour</a>
";

}




?>