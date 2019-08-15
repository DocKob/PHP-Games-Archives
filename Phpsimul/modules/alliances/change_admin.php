<?php

/*

Cette page est appélé en post par la page admin_membres.php

Elle permet de changer l'admin de l'alli

Créer par Max485

*/

if(isset($_POST['new_admin']) ) // on change l'admin de l'alli
{
$new_admin=$_POST['new_admin'];

mysql_query("UPDATE phpsim_users SET admin_alli='1' WHERE id = '".$new_admin."' ");
mysql_query("UPDATE phpsim_users SET admin_alli='0' WHERE id = '".$userrow['id']."' ");

@$page .= "<font size='+1'><center><b>Vous avez bien défini un nouvel Admin
<br>Vous n'êtes desormais plus l'administrateur de l'alliance</b></center></font><br><br>";

include("alliance.php");
}



?>