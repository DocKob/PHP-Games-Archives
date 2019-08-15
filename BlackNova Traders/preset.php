<?


include("config.php");
updatecookie();

include("languages/$lang");
$title = "$l_pre_title";

include("header.php");

connectdb();

if(checklogin())
{
  die();
}

$result = $db->Execute("SELECT * FROM $dbtables[ships] WHERE email='$username'");
$playerinfo = $result->fields;

bigtitle();

if(!isset($change))
{
  echo "<FORM ACTION=preset.php METHOD=POST>";
  echo "Preset 1: <INPUT TYPE=TEXT NAME=preset1 SIZE=6 MAXLENGTH=6 VALUE=$playerinfo[preset1]><BR>";
  echo "Preset 2: <INPUT TYPE=TEXT NAME=preset2 SIZE=6 MAXLENGTH=6 VALUE=$playerinfo[preset2]><BR>";
  echo "Preset 3: <INPUT TYPE=TEXT NAME=preset3 SIZE=6 MAXLENGTH=6 VALUE=$playerinfo[preset3]><BR>";
  echo "<INPUT TYPE=HIDDEN NAME=change VALUE=1>";
  echo "<BR><INPUT TYPE=SUBMIT VALUE=$l_pre_save><BR><BR>";
  echo "</FORM>";
}
else
{
  $preset1 = round(abs($preset1));
  $preset2 = round(abs($preset2));
  $preset3 = round(abs($preset3));
  if($preset1 > $sector_max)
  {
    $l_pre_exceed = str_replace("[preset]", "1", $l_pre_exceed);
    $l_pre_exceed = str_replace("[sector_max]", $sector_max, $l_pre_exceed);
    echo $l_pre_exceed;
  }
  elseif($preset2 > $sector_max)
  {
    $l_pre_exceed = str_replace("[preset]", "2", $l_pre_exceed);
    $l_pre_exceed = str_replace("[sector_max]", $sector_max, $l_pre_exceed);
    echo $l_pre_exceed;
  }
  elseif($preset3 > $sector_max)
  {
    $l_pre_exceed = str_replace("[preset]", "3", $l_pre_exceed);
    $l_pre_exceed = str_replace("[sector_max]", $sector_max, $l_pre_exceed);
    echo $l_pre_exceed;
  }
  else
  {
    $update = $db->Execute("UPDATE $dbtables[ships] SET preset1=$preset1,preset2=$preset2,preset3=$preset3 WHERE ship_id=$playerinfo[ship_id]");
    $l_pre_set = str_replace("[preset1]", "<a href=rsmove.php?engage=1&destination=$preset1>$preset1</a>", $l_pre_set);
    $l_pre_set = str_replace("[preset2]", "<a href=rsmove.php?engage=1&destination=$preset2>$preset2</a>", $l_pre_set);
    $l_pre_set = str_replace("[preset3]", "<a href=rsmove.php?engage=1&destination=$preset3>$preset3</a>", $l_pre_set);
    echo $l_pre_set;
  }
}

TEXT_GOTOMAIN();

include("footer.php");

?> 


