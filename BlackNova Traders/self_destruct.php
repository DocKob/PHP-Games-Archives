<?
include("config.php");
updatecookie();

include("languages/$lang");

$title=$l_die_title;
include("header.php");

connectdb();

if(checklogin())
{
  die();
}

bigtitle();

$result = $db->Execute("SELECT ship_id,character_name FROM $dbtables[ships] WHERE email='$username'");
$playerinfo = $result->fields;

if(!isset($sure))
{
  echo "<FONT COLOR=RED><B>$l_die_rusure</B></FONT><BR><BR>";
  echo "<A HREF=$interface>$l_die_nonono</A> $l_die_what<BR><BR>";
  echo "<A HREF=self_destruct.php?sure=1>$l_yes!</A> $l_die_goodbye<BR><BR>";
}
elseif($sure == 1)
{
  echo "<FONT COLOR=RED><B>$l_die_check</B></FONT><BR><BR>";
  echo "<A HREF=$interface>$l_die_nonono</A> $l_die_what<BR><BR>";
  echo "<A HREF=self_destruct.php?sure=2>$l_yes!</A> $l_die_goodbye<BR><BR>";
}
elseif($sure == 2)
{
  echo "$l_die_count<BR>";
  echo "$l_die_vapor<BR><BR>";
  echo "$l_die_please.<BR>";
  db_kill_player($playerinfo['ship_id']);
  cancel_bounty($playerinfo['ship_id']);
  adminlog(LOG_ADMIN_HARAKIRI, "$playerinfo[character_name]|$ip");
  playerlog($playerinfo[ship_id], LOG_HARAKIRI, "$ip");
}
else
{
  echo "$l_die_exploit<BR><BR>";
}

if($sure != 2)
{
  TEXT_GOTOMAIN();
}

include("footer.php");

?>
