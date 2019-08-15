<?


include("config.php");
updatecookie();

include("languages/$lang");
$title=$l_warp_title;
include("header.php");

connectdb();

if(checklogin())
{
  die();
}

$result = $db->Execute("SELECT * FROM $dbtables[ships] WHERE email='$username'");
$playerinfo=$result->fields;

if($playerinfo[turns] < 1)
{
  echo "$l_warp_turn<BR><BR>";
  TEXT_GOTOMAIN();
  include("footer.php");
  die();
}

if($playerinfo[dev_warpedit] < 1)
{
  echo "$l_warp_none<BR><BR>";
  TEXT_GOTOMAIN();
  include("footer.php");
  die();
}

$res = $db->Execute("SELECT allow_warpedit,$dbtables[universe].zone_id FROM $dbtables[zones],$dbtables[universe] WHERE sector_id=$playerinfo[sector] AND $dbtables[universe].zone_id=$dbtables[zones].zone_id");
$zoneinfo = $res->fields;
if($zoneinfo[allow_warpedit] == 'N')
{
  echo "$l_warp_forbid<BR><BR>";
  TEXT_GOTOMAIN();
  include("footer.php");
  die();
}

$target_sector = round($target_sector);
$result = $db->Execute("SELECT * FROM $dbtables[ships] WHERE email='$username'");
$playerinfo = $result->fields;

bigtitle();


$res = $db->Execute("SELECT allow_warpedit,$dbtables[universe].zone_id FROM $dbtables[zones],$dbtables[universe] WHERE sector_id=$target_sector AND $dbtables[universe].zone_id=$dbtables[zones].zone_id");
$zoneinfo = $res->fields;
if($zoneinfo[allow_warpedit] == 'N' && $bothway)
{
  $l_warp_forbidtwo = str_replace("[target_sector]", $target_sector, $l_warp_forbidtwo);
  echo "$l_warp_forbidtwo<BR><BR>";
  TEXT_GOTOMAIN();
  include("footer.php");
  die();
}

$result2 = $db->Execute("SELECT * FROM $dbtables[universe] WHERE sector_id=$target_sector");
$row = $result2->fields;
if(!$row)
{
  echo "$l_warp_nosector<BR><BR>";
  TEXT_GOTOMAIN();
  die();
}

$result3 = $db->Execute("SELECT * FROM $dbtables[links] WHERE link_start=$playerinfo[sector]");
if($result3 > 0)
{
  while(!$result3->EOF)
  {
    $row = $result3->fields;
    if($target_sector == $row[link_dest])
    {
      $flag = 1;
    }
    $result3->MoveNext();
  }
  if($flag != 1)
  {
    $l_warp_unlinked = str_replace("[target_sector]", $target_sector, $l_warp_unlinked);
    echo "$l_warp_unlinked<BR><BR>";
  }
  else
  {
    $delete1 = $db->Execute("DELETE FROM $dbtables[links] WHERE link_start=$playerinfo[sector] AND link_dest=$target_sector");
    $update1 = $db->Execute("UPDATE $dbtables[ships] SET dev_warpedit=dev_warpedit - 1, turns=turns-1, turns_used=turns_used+1 WHERE ship_id=$playerinfo[ship_id]");
    if(!$bothway)
    {
      echo "$l_warp_removed $target_sector.<BR><BR>";
    }
    else
    {
      $delete2 = $db->Execute("DELETE FROM $dbtables[links] WHERE link_start=$target_sector AND link_dest=$playerinfo[sector]");
      echo "$l_warp_removedtwo $target_sector.<BR><BR>";
    }
  }
}

TEXT_GOTOMAIN();

include("footer.php");

?>
