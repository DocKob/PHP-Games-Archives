<?php
/*

Page qui s'ouvre quand on veut administrez une alliance

*/

// Reconnait si le rang du joueur est admin
$rang_admin2 = mysql_query("SELECT * FROM phpsim_rangs WHERE id='".$userrow['rangs']."' ") ;
$rang_admin1 = mysql_fetch_array($rang_admin2) ;
$rang_admin = $rang_admin1['admin'] ;

if($userrow['admin_alli'] == 1 or $rang_admin == 1)
{

$page = "
<center><h3>Administration</h3>
<table border='1'><td><center>
<b>Choisisez quelle partie vous desirez administrer : </b><br>
<a href='index.php?mod=alliances/admin_alli|gen'>Gestion Alliance</a> | 
<a href='index.php?mod=alliances/admin_alli|rangs'>Gestion Rangs</a> |
<a href='index.php?mod=alliances/admin_alli|membres'>Gestion Membres</a> | 
<a href='index.php?mod=alliances/admin_alli|cand'>Candidatures</a>
</center></td></table><br>
</center>
";

if(empty($mod[1]) ) { $pagev = "admin_gen.php"; }
else { $pagev = "admin_".$mod[1].".php" ; }

define("adminautoriséok","1234567890123456789") ;

include($pagev) ;

}
else
{
@$page .= "Vous n'êtes pas admin, alors qu'est ce que vous faites lá ??";
}
?>