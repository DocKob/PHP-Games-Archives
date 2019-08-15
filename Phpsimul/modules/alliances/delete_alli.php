<?php
// Document créé par           nummi           pour PHPsimul 

if($_POST['action_leave_alli'] == "Detruire l'alliance")
{

$d = mysql_query("SELECT * FROM phpsim_alliance WHERE id='".$userrow['alli']."'");
$e= mysql_fetch_array($d) ;
$f = $e['id'];

mysql_query("DELETE FROM phpsim_alliance WHERE id='".$f."' ");
mysql_query("DELETE FROM phpsim_rangs WHERE idalli='".$f."' ");
mysql_query("DELETE FROM phpsim_allicand WHERE idalli='".$f."' ");
mysql_query("UPDATE phpsim_users SET alli='0' , admin_alli='0', rangs='0' WHERE alli='".$f."' ");

$page="<b>Vous avez supprimé totalement votre alliance.<b>";

include("alliance.php");


}
else
{
$page.= "L'accès direct à cette page n'est pas autorisé.";
}

?>