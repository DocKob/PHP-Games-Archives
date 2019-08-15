<?php


if(adminautoriséok == "1234567890123456789")
{

if(@$_POST['action'] == "Mettre à jour alliance")
{
//----------------------- Vérification des champs ----------------------------\\
if (empty($_POST["nom"]) || empty($_POST["tag"]) ) {
$page .= "<h1>Erreur : Vous êtes obligé de définir un nom et un tag.</h1>";
}
else
{ // debut else nom et tag rempli
//-------------------Récuération et envoi des donnés--------------------------------\\
$nom=$_POST['nom'];
$tag=$_POST['tag'];
if(isset($_POST['logo']))      $logo=$_POST['logo'];
else      $logo="";
if(isset($_POST['id_rangs_default'])  and $_POST['id_rangs_default'] != "Aucun" )      $id_rangs_default=$_POST['id_rangs_default'];
else      $id_rangs_default="";
if(isset($_POST['texte']))      $texte=mysql_real_escape_string($_POST['texte']);
else      $texte="";
if(isset($_POST['texte_int']))  $texte2=mysql_real_escape_string($_POST['texte_int']);
else      $texte2="";
if(isset($_POST['cand']))  $cand=mysql_real_escape_string($_POST['cand']);
else      $cand="";
if(isset($_POST['status']))  $status=mysql_real_escape_string($_POST['status']);
else      $status="Aucun";
//-------------------Envoi des donnés--------------------------------\\

// Ensuite on envoye toutes les données dans la table alliance
$a = mysql_query("SELECT * FROM phpsim_users WHERE id='".$userid."'");
while ($b= mysql_fetch_array($a)){$c = $b['alli'] ;}
$c = mysql_query("SELECT * FROM phpsim_alliance WHERE id='".$c."'");
while ($d= mysql_fetch_array($c)){$e = $d['id'] ;}
mysql_query("UPDATE phpsim_alliance SET nom='".$nom."', tag='".$tag."', logo='".$logo."', texte='".$texte."',texte_int='".$texte2."', candidature='".$cand."', id_rangs_default='".$id_rangs_default."', status='".$status."' WHERE id = '".$e."' ");


//-------------------Texte pour dire que 'alliance a bien été modifié--------------------------------\\
$page .= "<font size='+2'><b>L'alliance a bien été mise à jour.</b></font>";

}
} // fin else nom et tag rempli

//-------------------Repérer le nom de l'alliance de l'utilisateur--------------------------------\\
$a = mysql_query("SELECT * FROM phpsim_users WHERE id='".$userid."'");
$b = mysql_fetch_array($a) ;

// Recuperer les infos de l'alli
$b = mysql_query("SELECT * FROM phpsim_alliance WHERE id='".$b['alli']."'");
$d = mysql_fetch_array($b) ;

// Formulaire pour changer d'infos
$page.="<center><b>Vous pouvez modifier les informations ci-dessous :</b><br><br><br>
<form method='post' action=''><table>
<tr><td>Nom de l'alliance :</td> <td><input type='text'  size='50' name='nom' value='".$d['nom']."'></td></tr>
<tr><td>TAG :</td> <td><input type='text' name='tag'  size='50' value='".$d['tag']."'></td></tr>
<tr><td>Logo de l'alliance :</td> <td> <input type='text' size='50' name='logo' value='".$d['logo']."'></td></tr>
".'<tr><td>Status du moment :</td> <td><input type="text" size="50" name="status" value="'.$d['status'].'">
'."<tr><td>Rang par default :</td> <td><select name='id_rangs_default' STYLE='width:100%'> ";

// On recupere les rangs existants
$rangs1 = mysql_query("SELECT * FROM phpsim_rangs WHERE idalli='".$d['id']."' ORDER BY nom ");

while ($rangs = mysql_fetch_array($rangs1) ) 
{

$page.="<option "; if($rangs["id"] == $d["id_rangs_default"]) { $page .= " SELECTED "; } $page .=" value='".$rangs["id"]."'>".$rangs["nom"]."</option>";
  
}
   
$page.="
<OPTION "; if($d["id_rangs_default"] == "") { $page .= " SELECTED "; } $page .=" value='Aucun'>Aucun</option>
</select></td></tr>
</td></tr>
</table>
<br><br>
<b>Texte externe (Fonctionne avec HTML) :</b><br><TEXTAREA cols='50'
rows='12'  type='text' name='texte' >".$d['texte']."</TEXTAREA>
<br><br>
<b>Texte Interne (Fonctionne avec HTML) :</b><br><TEXTAREA cols='50'
rows='12'  type='text' name='texte_int' >".$d['texte_int']."</TEXTAREA><br>
<br><br>
<b>Candidature :</b><br><TEXTAREA cols='50'
rows='12'  type='text' name='cand' >".$d['candidature']."</TEXTAREA><br>
<br><br>

<input type='submit' name='action' value='Mettre à jour alliance'>
</form>";



}
else
{
@$page .= "Vous n'êtes pas autorisé à accéder à cette page.";
}

?>