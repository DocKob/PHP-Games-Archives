<?php
//$Id: genesis.php 47 2006-01-19 02:55:27Z phpfixer $
include("config.php");
updatecookie();

include("languages/$lang");
$title=$l_gns_title;
include("header.php");

connectdb();

if(checklogin())
{
  die();
}
//adding db lock to prevent more than 5 planets in a sector - rjordan
$db->Execute("LOCK TABLES $dbtables[ships] WRITE, $dbtables[planets] WRITE, $dbtables[universe] READ, $dbtables[zones] READ");

//-------------------------------------------------------------------------------------------------
$result = $db->Execute("SELECT * FROM $dbtables[ships] WHERE email='$username'");
$playerinfo = $result->fields;

$result2 = $db->Execute("SELECT * FROM $dbtables[universe] WHERE sector_id='$playerinfo[sector]'");
$sectorinfo = $result2->fields;

$result3 = $db->Execute("SELECT planet_id FROM $dbtables[planets] WHERE sector_id='$playerinfo[sector]'");
$num_planets = $result3->RecordCount();

// Generate Planetname
$planetname = substr($playerinfo[character_name],0,1) . substr($playerinfo[ship_name],0,1) . "-" . $playerinfo[sector] . "-" . ($num_planets + 1);

bigtitle();

if($playerinfo[turns] < 1)
{
  echo "$l_gns_turn";
}
elseif($playerinfo[on_planet]=='Y')
{
  echo $l_gns_onplanet;
}
elseif($num_planets >= $max_planets_sector)
{
  echo $l_gns_full;
}

/* -------------------------------------------------------------- *
 * I'm (SharpBlue) lazy. With many planets by sector that code    *
 * becomes pretty hard to manage, and besides... Isn't it a       *
 * little too powerful?                                           *
 * -------------------------------------------------------------- *
elseif($sectorinfo[planet] == "Y")
{
  echo "There is already a planet in this sector.";
  if($playerinfo[ship_id]==$sectorinfo[planet_owner])
  {
    if($destroy==1 && $allow_genesis_destroy)
    {
    // not multilingualed cause its not working right now anyway
      echo "<BR>Are you sure???<BR><A HREF=genesis.php?destroy=2>YES, Let them die!</A><BR>";
      echo "<A HREF=device.php>No! That would be Evil!</A><BR>";
    }
    elseif($destroy==2 && $allow_genesis_destroy)
    {
      if($playerinfo[dev_genesis] > 0)
      {
        $deltarating=$sectorinfo[planet_colonists];
        $update = $db->Execute("UPDATE $dbtables[universe] SET planet_name=NULL, planet_organics=0, planet_energy=0, planet_ore=0, planet_goods=0, planet_colonists=0, planet_credits=0, planet_fighters=0, planet_owner=null, planet_corp=null, base='N',base_sells='N', base_torp=0, planet_defeated='N', planet='N' WHERE sector_id=$playerinfo[sector]");
        $update2=$db->Execute("UPDATE $dbtables[ships] SET turns_used=turns_used+1, turns=turns-1, dev_genesis=dev_genesis-1, rating=rating-$deltarating WHERE ship_id=$playerinfo[ship_id]");
        echo "<BR>Errr, there was one with $deltarating colonists here....<BR>";
      }
      else
      {
        echo "$l_gns_nogenesis";
      }
    }
    elseif($allow_genesis_destroy)
    {
      echo "<BR>Do you want to destroy <A HREF=genesis.php?destroy=1>";
      if($sectorinfo[planet_name]=="")
      {
        echo "Unnamed</A>?";
      }
      else
      {
        echo $sectorinfo[planet_name] . "</A>?";
      }
    }
  }
}
* --------------------------------------------------------------- *
* If anyone who's coded this thing is willing to update it to     *
* support multiple planets, go ahead. I suggest removing this     *
* code completely from here and putting it in the planet menu     *
* instead. Easier to manage, makes more sense too.                *
* End of comments section.                                        *
* -------------------------------------------------------------- */

elseif($playerinfo[dev_genesis] < 1)
{
  echo "$l_gns_nogenesis";
}
else
{
  $res = $db->Execute("SELECT allow_planet, corp_zone, owner FROM $dbtables[zones] WHERE zone_id='$sectorinfo[zone_id]'");
  $zoneinfo = $res->fields;
  if($zoneinfo[allow_planet] == 'N')
  {
    echo "$l_gns_forbid";
  }
  elseif($zoneinfo[allow_planet] == 'L')
  {
    if($zoneinfo[corp_zone] == 'N')
    {
      if($playerinfo[team] == 0 && $zoneinfo[owner] <> $playerinfo[ship_id])
      {
        echo $l_gns_bforbid;
      }
      else
      {
        $res = $db->Execute("SELECT team FROM $dbtables[ships] WHERE ship_id=$zoneinfo[owner]");
        $ownerinfo = $res->fields;
        if($ownerinfo[team] != $playerinfo[team])
        {
          echo $l_gns_bforbid;
        }
        else
        {
          $query1 = "INSERT INTO $dbtables[planets] VALUES(NULL, $playerinfo[sector], '$planetname', 0, 0, 0, 0, 0, 0, 0, 0, $playerinfo[ship_id], 0, 'N', 'N', $default_prod_organics, $default_prod_ore, $default_prod_goods, $default_prod_energy, $default_prod_fighters, $default_prod_torp, 'N')";
          $update1 = $db->Execute($query1);
          $query2 = "UPDATE $dbtables[ships] SET turns_used=turns_used+1, turns=turns-1, dev_genesis=dev_genesis-1 WHERE ship_id=$playerinfo[ship_id]";
          $update2 = $db->Execute($query2);
          echo $l_gns_pcreate;
        }
      }
    }
    elseif($playerinfo[team] != $zoneinfo[owner])
    {
      echo $l_gns_bforbid;
    }
    else
    {
      $query1 = "INSERT INTO $dbtables[planets] VALUES(NULL, $playerinfo[sector], '$planetname', 0, 0, 0, 0, 0, 0, 0, 0, $playerinfo[ship_id], 0, 'N', 'N', $default_prod_organics, $default_prod_ore, $default_prod_goods, $default_prod_energy, $default_prod_fighters, $default_prod_torp, 'N')";
      $update1 = $db->Execute($query1);
      $query2 = "UPDATE $dbtables[ships] SET turns_used=turns_used+1, turns=turns-1, dev_genesis=dev_genesis-1 WHERE ship_id=$playerinfo[ship_id]";
      $update2 = $db->Execute($query2);
      echo $l_gns_pcreate;
    }
  }
  else
  {
    $query1 = "INSERT INTO $dbtables[planets] VALUES(NULL, $playerinfo[sector], '$planetname', 0, 0, 0, 0, 0, 0, 0, 0, $playerinfo[ship_id], 0, 'N', 'N', $default_prod_organics, $default_prod_ore, $default_prod_goods, $default_prod_energy, $default_prod_fighters, $default_prod_torp, 'N')";
    $update1 = $db->Execute($query1);
    $query2 = "UPDATE $dbtables[ships] SET turns_used=turns_used+1, turns=turns-1, dev_genesis=dev_genesis-1 WHERE ship_id=$playerinfo[ship_id]";
    $update2 = $db->Execute($query2);
    echo $l_gns_pcreate;
  }
}

//-------------------------------------------------------------------------------------------------
$db->Execute("UNLOCK TABLES");

echo "<BR><BR>";
TEXT_GOTOMAIN();

include("footer.php");

?>
