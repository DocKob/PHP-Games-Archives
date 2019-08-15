<?php
$sujet = $_GET['sujet'];
$forum = $_GET['forum'];

$nbr = 10;
if( !isset($_GET['p']) )
{
	$debut = 0;
}
else
{
	$debut = $nbr*$_GET['p'];
}

$sql = "SELECT sexe FROM is_user WHERE pseudo = '".$pseudo."'";
$resultat_user = mysql_query($sql);
$t_user = mysql_fetch_array($resultat_user);

$sql = "SELECT * , is_f_post.id as post_id FROM is_f_post LEFT JOIN is_user ON is_f_post.auteur = is_user.pseudo WHERE is_f_post.sujet = '".$sujet."' ORDER BY is_f_post.seconde ASC LIMIT ".$debut.",".$nbr;
$resultat_post = mysql_query($sql);

$sql2 = "SELECT * FROM is_f_sujet WHERE id='".$sujet."'";
$resultat_sujet2 = mysql_query($sql2);
$t_sujet2 = mysql_fetch_array($resultat_sujet2);

?>
<table width="690" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><a href="jeu.php?include=forum_nouveau&sujet=<?= $sujet ?>&forum=<?= $forum ?>"><img src="images/bout_forum_repondre.gif" width="70" height="20" border="0"></a> <a href="jeu.php?include=forum_nouveau&forum=<?= $forum ?>"><img src="images/bout_forum_nouveau.gif" width="70" height="20" border="0"></a></td>
<?php
if ($t_sujet2['auteur'] == $pseudo || $t_user['sexe'] == 'z' ) {
	echo('
	<td align="right">
	<a href="action/sujet_suppr.php?sujet='.$sujet.'&forum='.$forum.'"><img src="images/bout_forum_effacer.gif" width="70" height="20" border="0"></a>
	</td>
	');		
}	
?>
  </tr>
</table>
<?php
if( $t_sujet['alliance'] != 0 && $alliance != $t_sujet['alliance'] && $t_user['sexe'] != 'z' )
{
	echo('<p align="center">Ce forum est r&eacute;serv&eacute; &agrave; une alliance</p>');
}
else
{
	echo('
		<br>
		<table width="690" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" class="txt" align="center">
	');
	
	while( $t_post = mysql_fetch_array($resultat_post) )
	{
		echo('
			<tr>
			<td width="90" valign="top" align="center" bgcolor="#333333"><br>
			<font color="'.$sexes[ $t_post['sexe'] ].'">'.$t_post['auteur'].'</font><br>
		');
		if (isset($t_post['portrait']) >= 1)
		{		
			echo('
				<br><img src="'.$t_post['portrait'].'" width="90" height="90"><br>
			');
		} else {
			echo('<br><div align="center">No Avatar</div>');
		}
		echo('
			<br>
			'.$renomme[ $t_post['renomme'] ].'
			<br><br>
			<td width="600" bgcolor="#333333" valign="top">
		');
		if ($t_post['auteur'] == $pseudo || $t_user['sexe'] == 'z')
		{
		echo('
			<table align="right" border="0" cellpadding="0" cellspacing="0">
			  <tr>
			<td width="30" class="bout_page_30px"><a href="action/post_edit.php?post='.$t_post['post_id'].'&sujet='.$sujet.'&forum='.$forum.'">/</a> </td>
			<td>&nbsp;</td>
			<td width="30" class="bout_page_30px"><a href="action/post_suppr.php?post='.$t_post['post_id'].'&sujet='.$sujet.'&forum='.$forum.'">X</a></td>
			<td>&nbsp;</td>
			  </tr>
			</table>
		');
		}
		echo('
			<br>
			&nbsp;'.nl2br(stripslashes(isaCode($t_post['texte']))).'<br>
			&nbsp;____________________________<br>
			'.$t_post['signature'].'
			<br>
			</td>
			</tr>
			<tr>
			<td colspan="2" class="table16px">
			<p align="right">Message &eacute;crit le '.$t_post['date_ecrit'].'</p>
			</td>
			</tr>
		');
	}
	echo('
		</table>
	');
}
?>
<br>
<table width="690" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><a href="jeu.php?include=forum_nouveau&sujet=<?= $sujet ?>&forum=<?= $forum ?>"><img src="images/bout_forum_repondre.gif" width="70" height="20" border="0"></a> <a href="jeu.php?include=forum_nouveau&forum=<?= $forum ?>"><img src="images/bout_forum_nouveau.gif" width="70" height="20" border="0"></a></td>
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