<?php

/*

Page principal affiché lorsque l'on demande le mod alli

*/


//-------------------Reconnaissance utilisateur--------------------------------\\
$b = mysql_query("SELECT * FROM phpsim_users WHERE id='".$userid."'"); //   $b = id alliance dans phpsim_users
while ($d= mysql_fetch_array($b))
{$f = $d['alli'] ; 
$g = $d['admin_alli']; 
$o = $d ['candidature'] ; 
$ra = $d ['rangs'] ;
}

// Reconnait si le rang du joueur est admin + recupere les données du rang du joueur
$rangs2 = mysql_query("SELECT * FROM phpsim_rangs WHERE id='".$ra."' ") ;
$rangs = mysql_fetch_array($rangs2) ;
$rangs_admin = $rangs['admin'] ;

//-------------------Candidature ?--------------------------------\\
$q = mysql_query("SELECT * FROM phpsim_alliance WHERE id='".$o."'");
while ($r= mysql_fetch_array($q)){$s = $r['nom'] ;}
if ( $o != 0 ) {
$page=" Vous avez posé votre candidature pour l'alliance : <b> ".$s." </b>
<br> Votre candidature est en cours d'examination.<br><br>
<form method='post' action='index.php?mod=alliances/enleve'>
<input value='Retirer sa candidature' type='submit'>
</form>";
}
//-------------------Alliance utilisateur : --------------------------------\\
$a = mysql_query("SELECT *  FROM phpsim_alliance WHERE id='".$f."'"); //infos sur alliance
$u = mysql_query("SELECT COUNT(id) As total FROM phpsim_users WHERE alli = '".$f."'");
$point = mysql_query("SELECT SUM(points) As total2 FROM phpsim_users WHERE alli = '".$f."'");
//-------------------si alli différent de  0 on affiche : --------------------------------\\
		if ( $f != 0 and $o == 0 ) {
			
			while ($e = mysql_fetch_array($a))
			{
			// si il ny a aucun logo alors on affiche rien
			if(empty($e['logo']) ) { } else { @$page .= " <center><img src='".$e['logo']."'>"; }
			
			@$page .= "<center><table border='1' width='400'>";
			while ($v = mysql_fetch_array($u)){
			 // Administrateur de l'alliance on affiche
			 if ( ($g == 1 and $o == 0) or ($rangs_admin == 1 and $o == 0) )
			 {
				$page.= "<tr><th>Administration</th><td><center><a href='index.php?mod=alliances/admin_alli'>Aller à l'administration</a></center>";
			 
			 // On regarde si une candidature a été recu, si oui on le note, et permet a l'admin d'allez sur la page candidature
			 $candidature1 = mysql_query("SELECT * FROM phpsim_allicand WHERE idalli='".$e['id']."' ") ;
			 $candidature = mysql_num_rows($candidature1) ;
			 if($candidature > 0)
			 { $page.="<center><a href='index.php?mod=alliances/admin_alli|cand'>Candidature reçue</a></center>"; }
			 }
				//------------------- Texte Alliance --------------------------------\\
				while ($point2 = mysql_fetch_array($point)){
				
				if(empty($rangs['nom']) ) { $rangs['nom'] = "Aucun"; } // si le rang est pas defini alors on met aucun rang
				if(empty($e['status']) ) { $e['status'] = "Aucun"; } // si le status est pas defini alors on met aucun status

			 $page.="
			 <tr><th align ='center' valign='middle'><i>Points de l'alliance</i></th><td>
			 <center>".$point2['total2']."
			 </td></tr><tr><th align ='center' valign='middle'><i>Statut de l'alliance</i></th><td>
			 <center>".htmlspecialchars($e['status'])."
			 </td></tr><tr><th align ='center' valign='middle'><b>Nom : </b></th><td>
			 <center>".$e['nom']."
			 <br><b><tr><th align ='center' valign='middle'>TAG : </b></th><td>
			 <center>".$e['tag']."
			 <br><b><tr><th align ='center' valign='middle'>Forum : </b></th><td><center><a href='index.php?mod=forum&do=voirforum:".$e["adresse_forum"]."'>Accès au forum</a>
			 <br><b><tr><th align ='center' valign='middle'>Rang : </b></th><td><center>
			 ".$rangs['nom']."</center>
			 <b><tr><th align ='center' valign='middle'>Membres : </th><td align ='center' valign='middle'><center><b>".$v['total']."</b> (<a href='index.php?mod=alliances/members'>Liste des membres</a>) </b>
			 <br><a href='index.php?mod=alliances/msgcoll'>Envoyer un message collectif.</a></td>
			 </tr></th>";
			 
			 if(!empty($e['texte']) ) // si il y a un texte dans l'alliance alors on l'affiche sinon on affiche rien
			 {
			 $page .= "<tr><td colspan='2'><br>
			 <center><b>Texte Externe</b></center>
			 </tr></th><tr><td colspan='2'>
			 ".nl2br($e['texte'])."
			 </tr></th>";
			 }
			 if(!empty($e['texte_int']) ) // si un texte interne a été defini alors on affiche sinon rien
			 $page .= "
			 <tr><td colspan='2'>
			 <center><b><br>Texte Interne</b></center>
			 </tr></th><tr><td colspan='2'>
			 ".nl2br($e['texte_int'])."
			 </td></tr>";
			 }
			$page.="</table>
			<br><br>
			<form name='quittez_alli' method='post' action='index.php?mod=alliances/leave'>
			<a href='javascript:document.quittez_alli.submit();'>Cliquez ici si vous desirez quitter l'alliance.</a>
			</form>";
		}
		}
		}
		
			//-------------------Sinon si alli = 0 on affiche : --------------------------------\\
			elseif ($f == 0 and $o == 0)
			{  
			$conf= mysql_query("SELECT * FROM phpsim_config ");
				while ($conf2= mysql_fetch_array($conf))
				{
					if ( $userrow['points'] >= $conf2['pointalli']  ) 
				   {
						@$page.="
						<b>Vous pouvez : </b> <br><br>
						 1 - <a href='index.php?mod=alliances/create'>Créer une alliance<br><br><br></a> 
						 2 - <a href='index.php?mod=alliances/rejoindre'>Rejoindre une alliance</a> <br>";
				   }
			      elseif ( $userrow['points']< $conf2['pointalli']  ) 
			      {
			       @$page.="
			               <br><br>Vous ne pouvez pas créer d'alliance, vous devez avoir au minimum ".$conf2['pointalli']." points.
			               <br><br><br>
			               Votre seule solution : <a href='index.php?mod=alliances/rejoindre'>Rejoindre une alliance</a> <br>";
				   }
				}
			} 



?>