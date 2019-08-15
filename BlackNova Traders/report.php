<?

include("config.php");

updatecookie();


include("languages/$lang");
$title=$l_report_title;

connectdb();
include("header.php");



if(checklogin())
{
  die();
}

$result = $db->Execute("SELECT * FROM $dbtables[ships] WHERE email='$username'");

$playerinfo=$result->fields;

$shiptypes[0]= "tinyship.gif";
$shiptypes[1]= "smallship.gif";
$shiptypes[2]= "mediumship.gif";
$shiptypes[3]= "largeship.gif";
$shiptypes[4]= "hugeship.gif";

$shipavg = $playerinfo['hull'] + $playerinfo['engines'] + $playerinfo['power'] + $playerinfo['computer'] + $playerinfo['sensors'] + $playerinfo['armor'] + $playerinfo['shields'] + $playerinfo['beams'] + $playerinfo['torp_launchers'] + $playerinfo['cloak'];
$shipavg /= 10;
if($shipavg < 8)
   $shiplevel = 0;
elseif($shipavg < 12)
   $shiplevel = 1;
elseif($shipavg < 16)
   $shiplevel = 2;
elseif($shipavg < 20)
   $shiplevel = 3;
else
   $shiplevel = 4;

bigtitle();

echo "<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=\"100%\">";
echo "<TR BGCOLOR=\"$color_header\"><TD><B>$l_player: $playerinfo[character_name]</B></TD><TD ALIGN=CENTER><B>$l_ship: $playerinfo[ship_name]</B></TD><TD ALIGN=RIGHT><B>$l_credits: " . NUMBER($playerinfo[credits]) . "</B></TD></TR>";
echo "</TABLE>";
echo "<BR>";

echo "<TABLE BORDER=0 CELLSPACING=5 CELLPADDING=0 WIDTH=\"100%\">";
echo "<TR><TD>";

echo "<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=\"100%\">";
echo "<TR BGCOLOR=\"$color_header\"><TD><B>$l_ship_levels</B></TD><TD></TD></TR>";
echo "<TR BGCOLOR=\"$color_line1\"><TD>$l_hull</TD><TD>$l_level $playerinfo[hull]</TD></TR>";
echo "<TR BGCOLOR=\"$color_line2\"><TD>$l_engines</TD><TD>$l_level $playerinfo[engines]</TD></TR>";
echo "<TR BGCOLOR=\"$color_line1\"><TD>$l_power</TD><TD>$l_level $playerinfo[power]</TD></TR>";
echo "<TR BGCOLOR=\"$color_line2\"><TD>$l_computer</TD><TD>$l_level $playerinfo[computer]</TD></TR>";
echo "<TR BGCOLOR=\"$color_line1\"><TD>$l_sensors</TD><TD>$l_level $playerinfo[sensors]</TD></TR>";
echo "<TR BGCOLOR=\"$color_line2\"><TD>$l_armor</TD><TD>$l_level $playerinfo[armor]</TD></TR>";
echo "<TR BGCOLOR=\"$color_line1\"><TD>$l_shields</TD><TD>$l_level $playerinfo[shields]</TD></TR>";
echo "<TR BGCOLOR=\"$color_line2\"><TD>$l_beams</TD><TD>$l_level $playerinfo[beams]</TD></TR>";
echo "<TR BGCOLOR=\"$color_line1\"><TD>$l_torp_launch</TD><TD>$l_level $playerinfo[torp_launchers]</TD></TR>";
echo "<TR BGCOLOR=\"$color_line2\"><TD>$l_cloak</TD><TD>$l_level $playerinfo[cloak]</TD></TR>";
echo "<TR BGCOLOR=\"$color_line1\"><TD><i>$l_shipavg</i></TD><TD>$l_level " . NUMBER($shipavg, 2) . "</TD></TR>";

echo "</TABLE>";
echo "</TD><TD VALIGN=TOP>";
echo "<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=\"100%\">";
$holds_used = $playerinfo[ship_ore] + $playerinfo[ship_organics] + $playerinfo[ship_goods] + $playerinfo[ship_colonists];
$holds_max = NUM_HOLDS($playerinfo[hull]);
echo "<TR BGCOLOR=\"$color_header\"><TD><B>$l_holds</B></TD><TD ALIGN=RIGHT><B>" . NUMBER($holds_used) . " / " . NUMBER($holds_max) . "</B></TD></TR>";
echo "<TR BGCOLOR=\"$color_line1\"><TD>$l_ore</TD><TD ALIGN=RIGHT>" . NUMBER($playerinfo[ship_ore]) . "</TD></TR>";
echo "<TR BGCOLOR=\"$color_line2\"><TD>$l_organics</TD><TD ALIGN=RIGHT>" . NUMBER($playerinfo[ship_organics]) . "</TD></TR>";
echo "<TR BGCOLOR=\"$color_line1\"><TD>$l_goods</TD><TD ALIGN=RIGHT>" . NUMBER($playerinfo[ship_goods]) . "</TD></TR>";
echo "<TR BGCOLOR=\"$color_line2\"><TD>$l_colonists</TD><TD ALIGN=RIGHT>" . NUMBER($playerinfo[ship_colonists]) . "</TD></TR>";
echo "<TR><TD>&nbsp;</TD></TR>";
$armor_pts_max = NUM_ARMOUR($playerinfo[armor]);
$ship_fighters_max = NUM_FIGHTERS($playerinfo[computer]);
$torps_max = NUM_TORPEDOES($playerinfo[torp_launchers]);
echo "<TR BGCOLOR=\"$color_header\"><TD><B>$l_arm_weap</B></TD><TD></TD></TR>";
echo "<TR BGCOLOR=\"$color_line1\"><TD>$l_armorpts</TD><TD ALIGN=RIGHT>" . NUMBER($playerinfo[armor_pts]) . " / " . NUMBER($armor_pts_max) . "</TD></TR>";
echo "<TR BGCOLOR=\"$color_line2\"><TD>$l_fighters</TD><TD ALIGN=RIGHT>" . NUMBER($playerinfo[ship_fighters]) . " / " . NUMBER($ship_fighters_max) . "</TD></TR>";
echo "<TR BGCOLOR=\"$color_line1\"><TD>$l_torps</TD><TD ALIGN=RIGHT>" . NUMBER($playerinfo[torps]) . " / " . NUMBER($torps_max) . "</TD></TR>";
echo "</TABLE>";
echo "</TD><TD VALIGN=TOP>";
echo "<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=\"100%\">";
$energy_max = NUM_ENERGY($playerinfo[power]);
echo "<TR BGCOLOR=\"$color_header\"><TD><B>$l_energy</B></TD><TD ALIGN=RIGHT><B>" . NUMBER($playerinfo[ship_energy]) . " / " . NUMBER($energy_max) . "</B></TD></TR>";
echo "<TR><TD>&nbsp;</TD></TR>";
echo "<TR BGCOLOR=\"$color_header\"><TD><B>$l_devices</B></TD><TD></B></TD></TR>";
echo "<TR BGCOLOR=\"$color_line1\"><TD>$l_beacons</TD><TD ALIGN=RIGHT>$playerinfo[dev_beacon]</TD></TR>";
echo "<TR BGCOLOR=\"$color_line2\"><TD>$l_warpedit</TD><TD ALIGN=RIGHT>$playerinfo[dev_warpedit]</TD></TR>";
echo "<TR BGCOLOR=\"$color_line1\"><TD>$l_genesis</TD><TD ALIGN=RIGHT>$playerinfo[dev_genesis]</TD></TR>";
echo "<TR BGCOLOR=\"$color_line2\"><TD>$l_deflect</TD><TD ALIGN=RIGHT>$playerinfo[dev_minedeflector]</TD></TR>";
echo "<TR BGCOLOR=\"$color_line1\"><TD>$l_ewd</TD><TD ALIGN=RIGHT>$playerinfo[dev_emerwarp]</TD></TR>";
$escape_pod = ($playerinfo[dev_escapepod] == 'Y') ? $l_yes : $l_no;
$fuel_scoop = ($playerinfo[dev_fuelscoop] == 'Y') ? $l_yes : $l_no;
$lssd = ($playerinfo[dev_lssd] == 'Y') ? $l_yes : $l_no;
echo "<TR BGCOLOR=\"$color_line2\"><TD>$l_escape_pod</TD><TD ALIGN=RIGHT>$escape_pod</TD></TR>";
echo "<TR BGCOLOR=\"$color_line1\"><TD>$l_fuel_scoop</TD><TD ALIGN=RIGHT>$fuel_scoop</TD></TR>";
echo "<TR BGCOLOR=\"$color_line2\"><TD>$l_lssd</TD><TD ALIGN=RIGHT>$lssd</TD></TR>";
echo "</TABLE>";

echo "</TD></TR>";
echo "</TABLE>";

echo "<p align=center>";
echo "<img src=\"images/$shiptypes[$shiplevel]\" border=0></p>";

TEXT_GOTOMAIN();

include("footer.php");

?>

