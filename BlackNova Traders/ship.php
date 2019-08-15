<?
include("config.php");
updatecookie();

include("languages/$lang");

$title=$l_ship_title;
include("header.php");

connectdb();

if(checklogin())
{
  die();
}


$res = $db->Execute("SELECT sector FROM $dbtables[ships] WHERE email='$username'");
$playerinfo = $res->fields;
$res2 = $db->Execute("SELECT ship_name, character_name, sector FROM $dbtables[ships] WHERE ship_id=$ship_id");
$othership = $res2->fields;

bigtitle();

if($othership[sector] != $playerinfo[sector])
{
  echo "$l_ship_the <font color=white>", $othership[ship_name],"</font> $l_ship_nolonger ", $playerinfo[sector], "<BR>";
}
else
{
	echo "$l_ship_youc <font color=white>", $othership[ship_name], "</font>, $l_ship_owned <font color=white>", $othership[character_name],"</font>.<br><br>";
	echo "$l_ship_perform<BR><BR>";
	echo "<a href=scan.php?ship_id=$ship_id>$l_planet_scn_link</a><br>";
	echo "<a href=attack.php?ship_id=$ship_id>$l_planet_att_link</a><br>";
	echo "<a href=mailto.php?to=$ship_id>$l_send_msg</a><br>";
}

echo "<BR>";
TEXT_GOTOMAIN();

include("footer.php");

?>
