<table width="670" border="0" cellspacing="0" cellpadding="0" class="txt" align="center">
  <tr>
    <td width="90" class="table16px">&nbsp;</td>
    <td width="250" class="table16px">Nom</td>
    <td width="100" class="table16px">Renomm&eacute;e</td>
	<td width="120" class="table16px">Score</td>
	<td width="100" class="table16px"><div align="center">Dirigeant</div></td>
  </tr>
<?php

$alliance = "SELECT id , nom , roi , image FROM is_alliance";
$resultat_alliance = mysql_query($alliance);

while( $t_alliance = mysql_fetch_array($resultat_alliance) )
{
	$i++;
	$user = "SELECT * FROM is_user WHERE alliance = '".$t_alliance['id']."'";
	$resultat_user = mysql_query($user);
	$t_user = mysql_fetch_array($resultat_user);
	$renomme2 = -1;
	if ($t_user['renomme'] >= 1) {
		$renomme1 += $t_user['renomme'];
	} else {
		$renomme2 += $t_user['renomme'];	
	}
	$renomme = $renomme1-$renomme2;
	$score += $t_user['score'];
	$user2 = "SELECT COUNT(id) AS nb FROM is_user WHERE alliance = '".$t_alliance['id']."'";
	$resultat_user2 = mysql_query($user2);
	$t_user2 = mysql_fetch_array($resultat_user2);
	echo('
	<tr>
	<td>'.$i.'</td>
	<td width="250">
	<a href="jeu.php?include=confrerie_informations&id='.$t_alliance['id'].'">'.$t_alliance['nom'].'</a>
	</td>
	<td width="120">
	'.$renomme/$t_user2['nb'].'
	</td>
	<td width="120">
	'.$score/$t_user2['nb'].'
	</td>
	<td width="100"><div align="center">
	<a href="jeu.php?include=informations?joueur='.$t_alliance['roi'].'">'.$t_alliance['roi'].'</a>
	</div></td>
	</tr>
	');
}
mysql_free_result($resultat_user);
unset($t_user);
?>
</table>