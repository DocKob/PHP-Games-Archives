<html>
<head>
<title> Isalow : The Final Fight </title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
<!--
var secondes = <? echo($TIMEAFFICHAGE); ?>

function affichertemps() {
	secondes--;
	
	if(secondes < 0) secondes = 3599;
	
	var mins = Math.round(secondes/60);
	var secs = secondes%60;	
	
	document.getElementById('heure').innerHTML = '<font class="heure">'+mins+' : '+secs+'</font>';
}
function boucle(){
	setTimeout("boucle()", 1000);
	affichertemps();
}
-->
</script>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="boucle();">
<table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="txt">
<tr>
<td colspan="10">
<img src="images/header.jpg" width="770" height="60" alt=""></td>
</tr>
<tr width="770" height="24">
<td align="center" style="background-image: url(images/menu.jpg)">
  <a href="jeu.php?include=accueil">Accueil</a> ::
  <a href="jeu.php?include=forum_index">Communication</a> ::
  <a href="jeu.php?include=messages" style="color:<?= $URLMESSAGE ?>">Messagerie</a> ::
  <a href="jeu.php?include=carte">Domaine</a> ::
  <a href="#">Attaque</a> ::
  <a href="jeu.php?include=commerce">Commerce</a> ::
  <a href="jeu.php?include=economie">Production</a> ::
<?php
if( $alliance != 0 )
{
	$sql = "SELECT * FROM is_user WHERE pseudo = '$pseudo'";
	$resultat_user = mysql_query($sql);
	$t_user = mysql_fetch_array($resultat_user);
	echo ('<a href="jeu.php?include=confrerie&id='.$t_user['alliance'].'">Alliance</a> ::');
}
else
{
	echo ('<a href="jeu.php?include=confrerie">Alliance</a> ::');
}
?>
  <a href="jeu.php?include=classement">Classement</a> ::
  <a href="jeu.php?include=preferences">Pr&eacute;f&eacute;rences</a>
</td>
</tr>
<tr style="background-image: url(images/background.jpg)">
<td colspan=10>
<div id="heure" style="position:absolute;"></div>
<br>
<br>
<!-- beginning contenu -->