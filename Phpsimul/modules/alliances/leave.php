<?php

$a = mysql_query("SELECT admin_alli FROM phpsim_users WHERE id='".$userid."'"); //   $b = id alliance dans phpsim_users
while ($b= mysql_fetch_array($a)){$c = $b['admin_alli']; }
if ( $c != 1)
   {
    if(empty($_POST['action_conf']) )
    {
    @$page.='<form action="" method="post">
             <center><b><font size="+2">Souhaitez vous vraiment quitter l\'alliance ?
             <br>Ceci prend effet immédiatement et ne peut pas être changé.</font></b>
             <br><br><input type="submit" name="action_conf" value="Confirmé, je ne veut plus être dans l\'alliance.">
             </center></form>
            ';
    }
    else
    {
	mysql_query("UPDATE phpsim_users SET alli='0' , admin_alli='0' where id='".$userid."' ");
	@$page.="<b><font size='+2'>Vous venez de quitter l'alliance, vous n'en faites malheureusement plus partie</font></b><br><br>";
	
	include("alliance.php") ;
	 }
	
	
	}
		elseif ( $c == 1){
			@$page.="<center><b>Vous êtes administrateur, il vous est impossible de changer d'alliance
			        <br>Si vous desirez partir sans détruire l'alliance, alors offrez l'admistration a un autre membre.<br>Si ce que vous voulez, c'est detruire l'alliance, alors vous pouvez continuer<br><br></b><form method='post' action='index.php?mod=alliances/delete_alli'>".'<INPUT type="submit" name="action_leave_alli" value="Detruire l\'alliance"></form></center>';
			
			
			}
			
			?>