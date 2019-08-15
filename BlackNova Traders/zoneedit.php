<?
include("config.php");
updatecookie();

include("languages/$lang");
$title=$l_ze_title;
include("header.php");

connectdb();

if(checklogin())
  die();

bigtitle();

$res = $db->Execute("SELECT * FROM $dbtables[zones] WHERE zone_id='$zone'");
if($res->EOF)
  zoneedit_die($l_zi_nexist);
$curzone = $res->fields;

if($curzone[corp_zone] == 'N')
{
  $result = $db->Execute("SELECT ship_id FROM $dbtables[ships] WHERE email='$username'");
  $ownerinfo = $result->fields;
}
else
{
  $result = $db->Execute("SELECT creator, id FROM $dbtables[teams] WHERE creator=$curzone[owner]");
  $ownerinfo = $result->fields;
}

if(($curzone[corp_zone] == 'N' && $curzone[owner] != $ownerinfo[ship_id]) || ($curzone[corp_zone] == 'Y' && $curzone[owner] != $ownerinfo[id] && $row[owner] == $ownerinfo[creator]))
  zoneedit_die($l_ze_notowner);

if($command == change)
  zoneedit_change();

if($curzone[allow_beacon] == 'Y')
  $ybeacon = "checked";
elseif($curzone[allow_beacon] == 'N')
  $nbeacon = "checked";
else
  $lbeacon = "checked";

if($curzone[allow_attack] == 'Y')
  $yattack = "checked";
else
  $nattack = "checked";

if($curzone[allow_warpedit] == 'Y')
  $ywarpedit = "checked";
elseif($curzone[allow_warpedit] == 'N')
  $nwarpedit = "checked";
else
  $lwarpedit = "checked";

if($curzone[allow_planet] == 'Y')
  $yplanet = "checked";
elseif($curzone[allow_planet] == 'N')
  $nplanet = "checked";
else
  $lplanet = "checked";

if($curzone[allow_trade] == 'Y')
  $ytrade = "checked";
elseif($curzone[allow_trade] == 'N')
  $ntrade = "checked";
else
  $ltrade = "checked";

if($curzone[allow_defenses] == 'Y')
  $ydefense = "checked";
elseif($curzone[allow_defenses] == 'N')
  $ndefense = "checked";
else
  $ldefense = "checked";

echo "<form action=zoneedit.php?command=change&zone=$zone method=post>" .
     "<table border=0><tr>" .
     "<td align=right><font size=2><b>$l_ze_name : &nbsp;</b></font></td>" .
     "<td><input type=text name=name size=30 maxlength=30 value=\"$curzone[zone_name]\"></td>" .
     "</tr><tr>" .
     "<td align=right><font size=2><b>$l_ze_allow $l_beacons : &nbsp;</b></font></td>" .
     "<td><input type=radio name=beacons value=Y $ybeacon>&nbsp;$l_yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name=beacons value=N $nbeacon>&nbsp;$l_no&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name=beacons value=L $lbeacon>&nbsp;$l_zi_limit</td>" .
     "</tr><tr>" .
     "<td align=right><font size=2><b>$l_ze_attacks : &nbsp;</b></font></td>" .
     "<td><input type=radio name=attacks value=Y $yattack>&nbsp;$l_yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name=attacks value=N $nattack>&nbsp;$l_no</td>" .
     "</tr><tr>" .
     "<td align=right><font size=2><b>$l_ze_allow $l_warpedit : &nbsp;</b></font></td>" .
     "<td><input type=radio name=warpedits value=Y $ywarpedit>&nbsp;$l_yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name=warpedits value=N $nwarpedit>&nbsp;$l_no&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name=warpedits value=L $lwarpedit>&nbsp;$l_zi_limit</td>" .
     "</tr><tr>" .
     "<td align=right><font size=2><b>$l_allow $l_sector_def : &nbsp;</b></font></td>" .
     "<td><input type=radio name=defenses value=Y $ydefense>&nbsp;$l_yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name=defenses value=N $ndefense>&nbsp;$l_no&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name=defenses value=L $ldefense>&nbsp;$l_zi_limit</td>" .
     "</tr><tr>" .
     "<td align=right><font size=2><b>$l_ze_genesis : &nbsp;</b></font></td>" .
     "<td><input type=radio name=planets value=Y $yplanet>&nbsp;$l_yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name=planets value=N $nplanet>&nbsp;$l_no&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name=planets value=L $lplanet>&nbsp;$l_zi_limit</td>" .
     "</tr><tr>" .
     "<td align=right><font size=2><b>$l_allow $l_title_port : &nbsp;</b></font></td>" .
     "<td><input type=radio name=trades value=Y $ytrade>&nbsp;$l_yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name=trades value=N $ntrade>&nbsp;$l_no&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name=trades value=L $ltrade>&nbsp;$l_zi_limit</td>" .
     "</tr><tr>" .
     "<td colspan=2 align=center><br><input type=submit value=$l_submit></td></tr>" .
     "</table>" .
     "</form>";


echo "<a href=zoneinfo.php?zone=$zone>$l_clickme</a> $l_ze_return.<p>";
TEXT_GOTOMAIN();

include("footer.php");

//-----------------------------------------------------------------

function zoneedit_change()
{
  global $zone;
  global $name;
  global $beacons;
  global $attacks;
  global $warpedits;
  global $planets;
  global $trades;
  global $defenses;
  global $l_clickme, $l_ze_saved, $l_ze_return;
  global $db,$dbtables;

  if(!get_magic_quotes_gpc())
    $name = addslashes($name);
  $db->Execute("UPDATE $dbtables[zones] SET zone_name='$name', allow_beacon='$beacons', allow_attack='$attacks', allow_warpedit='$warpedits', allow_planet='$planets', allow_trade='$trades', allow_defenses='$defenses' WHERE zone_id=$zone");
  echo "$l_ze_saved<p>";
  echo "<a href=zoneinfo.php?zone=$zone>$l_clickme</a> $l_ze_return.<p>";
  TEXT_GOTOMAIN();

  include("footer.php");
  die();
}

function zoneedit_die($error_msg)
{
  echo "<p>$error_msg<p>";

  TEXT_GOTOMAIN();
  include("footer.php");
  die();
}

?>
