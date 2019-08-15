<?php

$b = mysql_query("SELECT * FROM phpsim_users WHERE id='".$userid."'"); //   $b = id alliance dans phpsim_users
while ($d= mysql_fetch_array($b)){$f = $d['alli'] ; $g = $d['admin_alli'];}
$a = mysql_query("SELECT *  FROM phpsim_alliance WHERE id='".$f."'"); //inofs sur alliance
		if ( $f != 0 ) {
			while ($e = mysql_fetch_array($a)){
			 if ( $g == 1 ){
				$page= "<center><a href='index.php?mod=alliances/admin_alli'> Administrer l'alliance</a>";
				}
			 $page.="<center><table border='1'><tr><th align ='center' valign='middle'><i>Numéro de création : </i></th><td>
			 ".$e['id']."
			 </td></tr><tr><th align ='center' valign='middle'><b>Nom : </b></th><td>
			 ".$e['nom']."
			 <br><b><tr><th align ='center' valign='middle'>TAG : </b></th><td>
			 ".$e['tag']."
			 <br><b><tr><th align ='center' valign='middle'>Forum : </b></th><td><a>
			 ".$e['adresse_forum']."
			 </a></tr></th><tr><td colspan='2'>
			 ".$e['texte']."
			 </td></tr></table></center>";
			}
		}
			elseif ($f == 0){  
			$page.="
			<h3>Attention ! Les alliances ne seront diponibles que dans 2 semaines environ. Merci de pas créer d'alliance !</h3><br>
			<b>Vous pouvez :</b> <br><br>
			 1 - créer une alliance <a href='index.php?mod=alliances/create'>ici<br><br><br></a> 
			 2 - ou rejoindre une alliance ici : en cours <br>";} //créer ou  rejoindre alliance

?>