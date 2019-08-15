<?php
$sql = "SELECT email,age,sexe,profil,signature FROM is_user WHERE pseudo = '".$pseudo."'";
$resultat_user = mysql_query($sql);
$t_user = mysql_fetch_array($resultat_user);
?>
<form action="action/preferences.php" method="post" enctype="multipart/form-data" name="preferences">

<table width="670" border="0" align="center" cellpadding="0" cellspacing="0" class="txt">
  <tr>
    <td colspan="2" class="table16px"><div align="center">Vos pr&eacute;f&eacute;rences </div></td>
  </tr>
  <tr>
    <td width="170">Password (Nouveau) </td>
    <td width="500"><input name="password1" type="password" id="password1" style="width:500"></td>
  </tr>
  <tr>
    <td>Password (Confirmation) </td>
    <td><input name="password2" type="password" id="password2" style="width:500"></td>
  </tr>
  <tr>
    <td>Email</td>
    <td><input name="email" type="text" id="email" style="width:500" value="<?= $t_user['email'] ?>"></td>
  </tr>
  <tr>
    <td>Portrait*</td>
    <td>	<input name="portrait" type="file" id="portrait" style="width:500"></td>
  </tr>
  <tr>
    <td>Age</td>
    <td><input type="text" name="age" style="width:500" value="<?= $t_user['age'] ?>"></td>
  </tr>
  <tr>
    <td>Sexe</td>
    <td><select name="sexe" id="sexe" style="width:500">
<?php
if( $t_user['sexe'] == "z" )
{
	echo('<option value="z" selected>Admin</option><option value="m">Homme</option><option value="f">Femme</option>');
}
else if( $t_user['sexe'] == "m" )
{
	echo('<option value="m" selected>Homme</option><option value="f">Femme</option>');
}
else if( $t_user['sexe'] == "f" )
{
	echo('<option value="m">Homme</option><option value="f" selected>Femme</option>');
}

?>
	  
    </select></td>
  </tr>
  <tr>
    <td valign="top">Profil</td>
    <td><textarea name="profil" id="profil" style="width:500; height:100"><?= $t_user['profil'] ?></textarea></td>
  </tr>
  <tr>
    <td>Signature</td>
    <td><input name="signature" type="text" id="signature" style="width:500" value="<?= $t_user['signature'] ?>"></td>
  </tr>
  <tr>
    <td>Password actuel** </td>
    <td><input name="password" type="password" id="password" style="width:500"></td>
  </tr>
  <tr>
    <td colspan="2"><input type="submit" name="Submit" value="Mettre &agrave; jour" style="width:670"></td>
  </tr>
</table>
</form>
<table width="670" border="0" align="center" cellpadding="0" cellspacing="0" class="txt">
  <tr>
    <td><p>* l'image doit &ecirc;tre en format jpg , gif ou png et ne doit pas exc&eacute;der 8ko avec un format de 90*90px. <br>
    ** Le password actuelle est obligatoire pour mettre &agrave; jour vos pr&eacute;f&eacute;rences.</p>    </td>
  </tr>
</table>
<p>&nbsp;</p>
<?
mysql_free_result($resultat_user);
unset($t_user);
?>
