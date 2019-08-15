<?php $forum = $_GET['forum']; ?>
<table width="670" border="0" align="center" cellpadding="0" cellspacing="0" class="txt">
<tr>
    <td><a href="jeu.php?include=forum_nouveau&forum=<? echo($forum); ?>"><img src="images/bout_forum_nouveau.gif" width="70" height="20" border="0"></a></td>
</tr>
</table>
<br>
<?php
$nbr = 10;
if( !isset($_GET['p']) )
{
	$debut = 0;
}
else
{
	$debut = $nbr*$_GET['p'];
}

$sql = "SELECT * FROM is_user WHERE pseudo = '".$pseudo."'";
$resultat_user = mysql_query($sql);
$t_user = mysql_fetch_array($resultat_user);

$sql = "SELECT * FROM is_f_sujet WHERE forum='".$forum."' ORDER BY seconde DESC LIMIT ".$debut.",".$nbr;
$resultat_sujet = mysql_query($sql);
$t_sujet = mysql_fetch_array($resultat_sujet);

if( $t_sujet['alliance'] != 0 && $alliance != $t_sujet['alliance'] && $t_user['sexe'] != 'z' )
{
	echo('<p align="center">Ce forum est r&eacute;serv&eacute; &agrave; une alliance</p>');
}
else
{
echo('
<table width="670"  border="0" cellspacing="0" cellpadding="0" class="txt" align="center">
<tr>
<td width="45" class="table16px">&nbsp;</td>
<td width="10" class="table16px">&nbsp;&nbsp;</td>
<td width="300" class="table16px"><div align="center">Sujet</div></td>
<td width="90" class="table16px"><div align="center">Auteur</div></td>
<td width="70" class="table16px"><div align="center">Affichages</div></td>
<td width="70" class="table16px"><div align="center">R&eacute;ponses</div></td>
<td width="185" class="table16px"><div align="center">Dernier message</div></td>
</tr>
</table>
');

	$resultat_sujet = mysql_query($sql);
	while( $t_sujet = mysql_fetch_array($resultat_sujet) )
	{
		$sql4 = "SELECT COUNT(id) AS nb FROM is_f_post WHERE sujet='".$t_sujet['id']."'";
		$r_post = mysql_query($sql4);
		$t_post = mysql_fetch_array($r_post);
		$sql5 = "SELECT * FROM is_f_post WHERE sujet='".$t_sujet['id']."' ORDER BY date_ecrit DESC";
		$r_postd = mysql_query($sql5);
		$t_postd = mysql_fetch_array($r_postd);
		echo('
		<br>
		<table width="670"  border="0" cellspacing="0" cellpadding="0" class="txt" align="center">
		<tr bgcolor="#333333">
		<td width="45"><a href="jeu.php?include=forum_message&sujet='.$t_sujet['id'].'&forum='.$forum.'"><img src="images/oeil.jpg" width="45" height="45" border="0"></a></td>
		<td width="10" class="table45px">&nbsp;&nbsp;</td>
		<td width="300" class="table45px"><a href="jeu.php?include=forum_message&sujet='.$t_sujet['id'].'&forum='.$forum.'">'.stripslashes($t_sujet['titre']).'</a></td>
		<td width="90" class="table45px"><div class="center">'.$t_sujet['auteur'].'</div></td>
		<td width="70" class="table45px"><div align="center">'.$t_sujet['vu'].'</div></td>
		<td width="70" class="table45px"><div align="center">'.$t_post['nb'].'</div></td>
		<td width="185" class="table45px"><div align="center">'.$t_postd['date_ecrit'].'<br>'.$t_postd['auteur'].'</div></td>
		</tr>
		</table>
		');
	}
}
?>
<br>
<table width="670" border="0" align="center" cellpadding="0" cellspacing="0" class="txt">
<tr>
    <td><a href="jeu.php?include=forum_nouveau&forum=<? echo($forum); ?>"><img src="images/bout_forum_nouveau.gif" width="70" height="20" border="0"></a></td>
<td align="right" class="txt">
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
<?php
$sql = "SELECT COUNT(id) FROM is_f_post WHERE sujet='".$sujet."'";
$resultat_sujet = mysql_query($sql);
$row = mysql_fetch_row($resultat_sujet);
$total = $row[0];

if($total > $nbr)
{
	$pages = ceil($total/$nbr);
	if ($_GET['p'] > 0) {
	$a = $_GET['p'] - 1;
	 echo('<td><a href=jeu.php?include=forum_message&sujet='.$sujet.'&forum='.$forum.'&p='.$a.'><img src="images/bout_forum_precedant.gif" border="0"></a></td> ');
	} else {
	$a = $_GET['p'];
	 echo('<td><a href=jeu.php?include=forum_message&sujet='.$sujet.'&forum='.$forum.'&p='.$a.'><img src="images/bout_forum_precedant.gif" border="0"></a></td> ');
	}
	for($i=0 ; $i < $pages ; $i++)
	{
		if($_GET['p'] == $i) echo(" <td width=40 height=20 class=bout_page_40px>[ <a href=jeu.php?include=forum_message&sujet=".$sujet."&forum=".$forum."&p=".$i.">".$i."</a> ]</td> ");
		else echo(" <td width=30 class=bout_page_30px><a href=jeu.php?include=forum_message&sujet=".$sujet."&forum=".$forum."&p=".$i.">".$i."</a></td> ");
	}
	if ($_GET['p'] < $nbr) {
	$a = $_GET['p'] + 1;
	 echo(' <td><a href=jeu.php?include=forum_message&sujet='.$sujet.'&forum='.$forum.'&p='.$a.'><img src="images/bout_forum_suivant.gif" border="0"></a></td>');
	} else {
	$a = $_GET['p'];
	 echo(' <td><a href=jeu.php?include=forum_message&sujet='.$sujet.'&forum='.$forum.'&p='.$a.'><img src="images/bout_forum_suivant.gif" border="0"></a></td>');
	}
}
mysql_free_result($resultat_user);
unset($t_user);
?>
  </tr>
</table>
</td>
</tr>
</table>
