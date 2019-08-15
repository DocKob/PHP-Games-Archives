<?php
//$Id: traderoute.php 63 2006-02-03 02:32:31Z phpfixer $
include("config.php");
updatecookie();

include("languages/$lang");

$title=$l_tdr_title;
include("header.php");

connectdb();

if(checklogin())
{
  die();
}

//-------------------------------------------------------------------------------------------------


bigtitle();

$result = $db->Execute("SELECT * FROM $dbtables[ships] WHERE email='$username'");
$playerinfo = $result->fields;

$result = $db->Execute("SELECT * FROM $dbtables[traderoutes] WHERE owner=$playerinfo[ship_id]");
$num_traderoutes=$result->RecordCount();
$i=0;
while(!$result->EOF)
{
  $traderoutes[$i] = $result->fields;
  $i++;
  $result->MoveNext();
}

$freeholds = NUM_HOLDS($playerinfo[hull]) - $playerinfo[ship_ore] - $playerinfo[ship_organics] - $playerinfo[ship_goods] - $playerinfo[ship_colonists];
$maxholds = NUM_HOLDS($playerinfo[hull]);
$maxenergy = NUM_ENERGY($playerinfo[power]);
if ($playerinfo[ship_colonists] < 0 || $playerinfo[ship_ore] < 0 || $playerinfo[ship_organics] < 0 || $playerinfo[ship_goods] < 0 || $playerinfo[ship_energy] < 0 || $freeholds < 0)
{
    if ($playerinfo[ship_colonists] < 0 || $playerinfo[ship_colonists] > $maxholds)
    {
        adminlog(LOG_ADMIN_ILLEGVALUE, $playerinfo[ship_id], "$playerinfo[ship_name]|$playerinfo[ship_colonists]|colonists|$maxholds");
        $playerinfo[ship_colonists] = 0;
    }
    if ($playerinfo[ship_ore] < 0 || $playerinfo[ship_ore] > $maxholds)
    {
        adminlog(LOG_ADMIN_ILLEGVALUE, $playerinfo[ship_id], "$playerinfo[ship_name]|$playerinfo[ship_ore]|ore|$maxholds");
        $playerinfo[ship_ore] = 0;
    }
    if ($playerinfo[ship_organics] < 0 || $playerinfo[ship_organics] > $maxholds)
    {
        adminlog(LOG_ADMIN_ILLEGVALUE, $playerinfo[ship_id], "$playerinfo[ship_name]|$playerinfo[ship_organics]|organics|$maxholds");
        $playerinfo[ship_organics] = 0;
    }
    if ($playerinfo[ship_goods] < 0 || $playerinfo[ship_goods] > $maxholds)
    {
        adminlog(LOG_ADMIN_ILLEGVALUE, $playerinfo[ship_id], "$playerinfo[ship_name]|$playerinfo[ship_goods]|goods|$maxholds");
        $playerinfo[ship_goods] = 0;
    }
    if ($playerinfo[ship_energy] < 0 || $playerinfo[ship_energy] > $maxenergy)
    {
        adminlog(LOG_ADMIN_ILLEGVALUE, $playerinfo[ship_id], "$playerinfo[ship_name]|$playerinfo[ship_energy]|energy|$maxenergy");
        $playerinfo[ship_energy] = 0;
    }
    if ($freeholds < 0)
    {
        $freeholds = 0;
    }
$update1 = $db->Execute("UPDATE $dbtables[ships] SET ship_ore=$playerinfo[ship_ore], ship_organics=$playerinfo[ship_organics], ship_goods=$playerinfo[ship_goods], ship_energy=$playerinfo[ship_energy], ship_colonists=$playerinfo[ship_colonists] WHERE ship_id=$playerinfo[ship_id]");
}
if(!isset($tr_repeat) || $tr_repeat <= 0)
  $tr_repeat = 1;


if($command == 'new')   //displays new trade route form
  traderoute_new('');
elseif($command == 'create')    //enters new route in db
  traderoute_create();
elseif($command == 'edit')    //displays new trade route form, edit
  traderoute_new($traderoute_id);
elseif($command == 'delete')  //displays delete info
  traderoute_delete();
elseif($command == 'settings')  //global traderoute settings form
  traderoute_settings();
elseif($command == 'setsettings') //enters settings in db
  traderoute_setsettings();
elseif(isset($engage)) //performs trade route
{
    $i = $tr_repeat;
    while($i > 0)
    {

        $result = $db->Execute("SELECT * FROM $dbtables[ships] WHERE email='$username'");
        $playerinfo = $result->fields;
        //echo $i;
        traderoute_engage($i);
        //echo $i;
        $i--;
    }

}


//-----------------------------------------------------------------
if($command != 'delete')
{
  echo "<p>$l_tdr_newtdr<p>";
  echo "<p>$l_tdr_modtdrset<p>";
}
else {
  $l_tdr_confdel = str_replace("[tdr_id]", $traderoute_id, $l_tdr_confdel);
  echo "<p>$l_tdr_confdel<p>";
}

if($num_traderoutes == 0)
  echo "$l_tdr_noactive<p>";
else
{
  echo '<table border=1 cellspacing=1 cellpadding=2 width="100%" align="center">' .
       '<tr bgcolor=' . $color_line2 . '><td align="center" colspan=7><b><font color=white>
       ';

  if($command != 'delete')
    echo $l_tdr_curtdr;
  else
    echo $l_tdr_deltdr;

  echo "</font></b>" .
       "</td></tr>" .
       "<tr align='center' bgcolor=$color_line2>" .
       "<td><font size=2 color=white><b>$l_tdr_src</b></font></td>" .
       "<td><font size=2 color=white><b>$l_tdr_srctype</b></font></td>" .
       "<td><font size=2 color=white><b>$l_tdr_dest</b></font></td>" .
       "<td><font size=2 color=white><b>$l_tdr_desttype</b></font></td>" .
       "<td><font size=2 color=white><b>$l_tdr_move</b></font></td>" .
       "<td><font size=2 color=white><b>$l_tdr_circuit</b></font></td>" .
       "<td><font size=2 color=white><b>$l_tdr_change</b></font></td>" .
       "</tr>";
  $i=0;
  $curcolor=$color_line1;
  while($i < $num_traderoutes)
  {
    echo "<tr bgcolor=$curcolor>";
    if($curcolor == $color_line1)
      $curcolor = $color_line2;
    else
      $curcolor = $color_line1;

    echo "<td><font size=2 color=white>";
    if($traderoutes[$i][source_type] == 'P')
      echo "&nbsp;$l_tdr_portin <a href=rsmove.php?engage=1&destination=" . $traderoutes[$i][source_id] . ">" . $traderoutes[$i][source_id] . "</a></font></td>";
    else
    {
      $result = $db->Execute("SELECT name, sector_id FROM $dbtables[planets] WHERE planet_id=" . $traderoutes[$i][source_id]);
      if($result)
      {
        $planet1 = $result->fields;
        echo "&nbsp;$l_tdr_planet <b>$planet1[name]</b>$l_tdr_within<a href=\"rsmove.php?engage=1&destination=$planet1[sector_id]\">$planet1[sector_id]</a></font></td>";
      }
      else
        echo "&nbsp;$l_tdr_nonexistance</font></td>";
    }

    echo "<td align='center'><font size=2 color=white>";
    if($traderoutes[$i][source_type] == 'P')
    {
      $result = $db->Execute("SELECT * FROM $dbtables[universe] WHERE sector_id=" . $traderoutes[$i][source_id]);
      $port1 = $result->fields;
      echo "&nbsp;" . t_port($port1[port_type]) . "</font></td>";
    }
    else
    {
      if(empty($planet1))
        echo "&nbsp;$l_tdr_na</font></td>";
      else
        echo "&nbsp;$l_tdr_cargo</font></td>";
    }

    echo "<td><font size=2 color=white>";

    if($traderoutes[$i][dest_type] == 'P')
        echo "&nbsp;$l_tdr_portin <a href=\"rsmove.php?engage=1&destination=" . $traderoutes[$i][dest_id] . "\">" . $traderoutes[$i][dest_id] . "</a></font></td>";
    else
    {
      $result = $db->Execute("SELECT name, sector_id FROM $dbtables[planets] WHERE planet_id=" . $traderoutes[$i][dest_id]);
      if($result)
      {
        $planet2 = $result->fields;
        echo "&nbsp;$l_tdr_planet <b>$planet2[name]</b>$l_tdr_within<a href=\"rsmove.php?engage=1&destination=$planet2[sector_id]\">$planet2[sector_id]</a></font></td>";
      }
      else
        echo "&nbsp;$l_tdr_nonexistance</font></td>";
    }

    echo "<td align='center'><font size=2 color=white>";
    if($traderoutes[$i][dest_type] == 'P')
    {
      $result = $db->Execute("SELECT * FROM $dbtables[universe] WHERE sector_id=" . $traderoutes[$i][dest_id]);
      $port2 = $result->fields;
      echo "&nbsp;" . t_port($port2[port_type]) . "</font></td>";
    }
    else
    {
      if(empty($planet2))
        echo "&nbsp;$l_tdr_na</font></td>";
      else
      {
        echo "&nbsp;";
        if($playerinfo[trade_colonists] == 'N' && $playerinfo[trade_fighters] == 'N' && $playerinfo[trade_torps] == 'N')
          echo $l_tdr_none;
        else
        {
          if($playerinfo[trade_colonists] == 'Y')
            echo $l_tdr_colonists;
          if($playerinfo[trade_fighters] == 'Y')
          {
            if($playerinfo[trade_colonists] == 'Y')
              echo ", ";
            echo $l_tdr_fighters;
          }
          if($playerinfo[trade_torps] == 'Y')
            echo "<br>$l_tdr_torps";
        }
        echo "</font></td>";
      }
    }
    echo "<td align='center'><font size=2 color=white>";
    if($traderoutes[$i][move_type] == 'R')
    {
      echo "&nbsp;RS, ";

      if($traderoutes[$i][source_type] == 'P')
        $src=$port1;
      else
        $src = $planet1[sector_id];

      if($traderoutes[$i][dest_type] == 'P')
        $dst=$port2;
      else
        $dst = $planet2[sector_id];

      $dist = traderoute_distance($traderoutes[$i][source_type], $traderoutes[$i][dest_type], $src, $dst, $traderoutes[$i][circuit]);

      $l_tdr_escooped2 = $l_tdr_escooped;
      $l_tdr_escooped2 = str_replace("[tdr_dist_triptime]", $dist[triptime], $l_tdr_escooped2);
      $l_tdr_escooped2 = str_replace("[tdr_dist_scooped]", $dist[scooped], $l_tdr_escooped2);
      echo $l_tdr_escooped2;

      echo "</font></td>";

    }
    else
    {
      echo "&nbsp;$l_tdr_warp";
      if($traderoutes[$i][circuit] == '1')
        echo ", 2 $l_tdr_turns";
      else
        echo ", 4 $l_tdr_turns";
      echo "</font></td>";
    }

    echo "<td align='center'><font size=2 color=white>";
    if($traderoutes[$i][circuit] == '1')
      echo "&nbsp;1 $l_tdr_way</font></td>";
    else
      echo "&nbsp;2 $l_tdr_ways</font></td>";

    echo "<td align='center'><font size=2 color=white>";
    echo "<a href=\"traderoute.php?command=edit&traderoute_id=" . $traderoutes[$i][traderoute_id] . "\">";
    echo "$l_tdr_edit</a><br><a href=\"traderoute.php?command=delete&traderoute_id=" . $traderoutes[$i][traderoute_id] . "\">";
    echo "$l_tdr_del</a></font></td></tr>";

    $i++;
  }

  echo "</table><p>";
}
?>

<?

//-------------------------------------------------------------------------------------------------

TEXT_GOTOMAIN();
include("footer.php");

?>

<?

function traderoute_die($error_msg)
{
  global $l_footer_until_update, $l_footer_players_on_1, $l_footer_players_on_2, $l_footer_one_player_on;
    global $sched_ticks, $color_line1, $color_line2, $color_header, $servertimezone;
  echo "<p>$error_msg<p>";


  TEXT_GOTOMAIN();
  include("footer.php");
  die();
}

function traderoute_check_compatible($type1, $type2, $move, $circuit, $src, $dest)
{
  global $playerinfo;
  global $l_tdr_nowlink1, $l_tdr_nowlink2, $l_tdr_sportissrc, $l_tdr_notownplanet, $l_tdr_planetisdest;
  global $l_tdr_samecom, $l_tdr_sportcom, $color_line1, $color_line2, $color_header, $servertimezone;
  global $db, $dbtables;

  //check warp links compatibility
  if($move == 'warp')
  {
    $query = $db->Execute("SELECT link_id FROM $dbtables[links] WHERE link_start=$src[sector_id] AND link_dest=$dest[sector_id]");
    if($query->EOF)
    {
      $l_tdr_nowlink1 = str_replace("[tdr_src_sector_id]", $src[sector_id], $l_tdr_nowlink1);
      $l_tdr_nowlink1 = str_replace("[tdr_dest_sector_id]", $dest[sector_id], $l_tdr_nowlink1);
      traderoute_die($l_tdr_nowlink1);
    }
    if($circuit == '2')
    {
      $query = $db->Execute("SELECT link_id FROM $dbtables[links] WHERE link_start=$dest[sector_id] AND link_dest=$src[sector_id]");
      if($query->EOF)
      {
        $l_tdr_nowlink2 = str_replace("[tdr_src_sector_id]", $src[sector_id], $l_tdr_nowlink2);
        $l_tdr_nowlink2 = str_replace("[tdr_dest_sector_id]", $dest[sector_id], $l_tdr_nowlink2);
        traderoute_die($l_tdr_nowlink2);
      }
    }
  }

  //check ports compatibility
  if($type1 == 'port')
  {
    if($src[port_type] == 'special')
    {
      if(($type2 != 'planet') && ($type2 != 'corp_planet'))
        traderoute_die($l_tdr_sportissrc);
      if($dest[owner] != $playerinfo[ship_id] && ($dest[corp] == 0 || ($dest[corp] != $playerinfo[team])))
        traderoute_die($l_tdr_notownplanet);
    }
    else
    {
      if($type2 == 'planet')
        traderoute_die($l_tdr_planetisdest);
      if($src[port_type] == $dest[port_type])
        traderoute_die($l_tdr_samecom);
    }
  }
  else
  {
    if($dest['port_type'] == 'special')
      traderoute_die($l_tdr_sportcom);
  }
}


function traderoute_distance($type1, $type2, $start, $dest, $circuit, $sells = 'N')
{
  global $playerinfo, $color_line1, $color_line2, $color_header, $servertimezone;
  global $level_factor;
  global $db, $dbtables;

  $retvalue[triptime] = 0;
  $retvalue[scooped1] = 0;
  $retvalue[scooped2] = 0;
  $retvalue[scooped] = 0;

  if($type1 == 'L')
  {
    $query = $db->Execute("SELECT * FROM $dbtables[universe] WHERE sector_id=$start");
    $start = $query->fields;
  }

  if($type2 == 'L')
  {
    $query = $db->Execute("SELECT * FROM $dbtables[universe] WHERE sector_id=$dest");
    $dest = $query->fields;
  }

  if($start[sector_id] == $dest[sector_id])
  {
    if($circuit == '1')
      $retvalue[triptime] = '1';
    else
      $retvalue[triptime] = '2';
    return $retvalue;
  }

  $deg = pi() / 180;

  $sa1 = $start[angle1] * $deg;
  $sa2 = $start[angle2] * $deg;
  $fa1 = $dest[angle1] * $deg;
  $fa2 = $dest[angle2] * $deg;
  $x = $start[distance] * sin($sa1) * cos($sa2) - $dest[distance] * sin($fa1) * cos($fa2);
  $y = $start[distance] * sin($sa1) * sin($sa2) - $dest[distance] * sin($fa1) * sin($fa2);
  $z = $start[distance] * cos($sa1) - $dest[distance] * cos($fa1);
  $distance = round(sqrt(mypw($x, 2) + mypw($y, 2) + mypw($z, 2)));
  $shipspeed = mypw($level_factor, $playerinfo[engines]);
  $triptime = round($distance / $shipspeed);

  if(!$triptime && $destination != $playerinfo[sector])
    $triptime = 1;

  if($playerinfo[dev_fuelscoop] == "Y")
      $energyscooped = $distance * 100;
  else
    $energyscooped = 0;

  if($playerinfo[dev_fuelscoop] == "Y" && !$energyscooped && $triptime == 1)
    $energyscooped = 100;

  $free_power = NUM_ENERGY($playerinfo[power]) - $playerinfo[ship_energy];

  if($free_power < $energyscooped)
    $energyscooped = $free_power;

  if($energyscooped < 1)
    $energyscooped = 0;

  $retvalue[scooped1] = $energyscooped;

  if($circuit == '2')
  {
    if($sells == 'Y' && $playerinfo[dev_fuelscoop] == 'Y' && $type2 == 'P' && $dest[port_type] != 'energy')
    {
      $energyscooped = $distance * 100;
      $free_power = NUM_ENERGY($playerinfo[power]);
      if($free_power < $energyscooped)
        $energyscooped = $free_power;
      $retvalue[scooped2] = $energyscooped;
    }
    elseif($playerinfo[dev_fuelscoop] == 'Y')
    {
      $energyscooped = $distance * 100;
      $free_power = NUM_ENERGY($playerinfo[power]) - $retvalue[scooped1] - $playerinfo[ship_energy];
      if($free_power < $energyscooped)
        $energyscooped = $free_power;
      $retvalue[scooped2] = $energyscooped;
    }
  }

  if($circuit == '2')
  {
    $triptime*=2;
    $triptime+=2;
  }
  else
    $triptime+=1;

  $retvalue[triptime] = $triptime;
  $retvalue[scooped] = $retvalue[scooped1] + $retvalue[scooped2];

  return $retvalue;
}

function traderoute_new($traderoute_id)
{
  global $playerinfo, $color_line1, $color_line2, $color_header;
  global $num_traderoutes, $servertimezone;
  global $max_traderoutes_player;
  global $l_tdr_editerr, $l_tdr_maxtdr, $l_tdr_createnew, $l_tdr_editinga, $l_tdr_traderoute, $l_tdr_unnamed;
  global $l_tdr_cursector, $l_tdr_selspoint, $l_tdr_port, $l_tdr_planet, $l_tdr_none, $l_tdr_insector, $l_tdr_selendpoint;
  global $l_tdr_selmovetype, $l_tdr_realspace, $l_tdr_warp, $l_tdr_selcircuit, $l_tdr_oneway, $l_tdr_bothways, $l_tdr_create;
  global $l_tdr_modify, $l_tdr_returnmenu, $l_tdr_none;
  global $l_footer_until_update, $l_footer_players_on_1, $l_footer_players_on_2, $l_footer_one_player_on, $sched_ticks;
  global $db, $dbtables;

  if(!empty($traderoute_id))
  {
    $result = $db->Execute("SELECT * FROM $dbtables[traderoutes] WHERE traderoute_id=$traderoute_id");
    if(!result || $result->EOF)
      traderoute_die($l_tdr_editerr);
    $editroute = $result->fields;
    if($editroute[owner] != $playerinfo[ship_id])
      traderoute_die($l_tdr_notowner);
  }

  if($num_traderoutes >= $max_traderoutes_player && empty($editroute))
    traderoute_die("<p>$l_tdr_maxtdr<p>");

  echo "<p><font size=3 color=blue><b>";
  if(empty($editroute))
    echo $l_tdr_createnew;
  else
    echo "$l_tdr_editinga ";
  echo "$l_tdr_traderoute</b></font><p>";

//---------------------------------------------------
//---- Get Planet info Corp and Personal (BEGIN) ----

  $result = $db->Execute("SELECT * FROM $dbtables[planets] WHERE owner=$playerinfo[ship_id] ORDER BY sector_id");

  $num_planets = $result->RecordCount();
  $i=0;
  while (!$result->EOF)
  {
    $planets[$i] = $result->fields;
    if($planets[$i][name] == "")
      $planets[$i][name] = $l_tdr_unnamed;
    $i++;
    $result->MoveNext();
  }

  $result = $db->Execute("SELECT * FROM $dbtables[planets] WHERE corp=$playerinfo[team] AND corp!=0 AND owner<>$playerinfo[ship_id] ORDER BY sector_id");
  $num_corp_planets = $result->RecordCount();
  $i=0;
  while (!$result->EOF)
  {
    $planets_corp[$i] = $result->fields;
    if($planets_corp[$i][name] == "")
      $planets_corp[$i][name] = $l_tdr_unnamed;
    $i++;
    $result->MoveNext();
  }
//---- Get Planet info Corp and Personal (END) ------
//---------------------------------------------------
  // Display Current Sector
  echo "$l_tdr_cursector $playerinfo[sector]<br>";

  // Start of form for starting location
  echo "
    <form action=traderoute.php?command=create method=post>
    <table border=0><tr>
    <td align=right><font size=2><b>$l_tdr_selspoint <br>&nbsp;</b></font></td>
    <tr>
    <td align=right><font size=2>$l_tdr_port : </font></td>
    <td><input type=radio name=\"ptype1\" value=\"port\"
    ";

  if(empty($editroute) || (!empty($editroute) && $editroute[source_type] == 'P'))
    echo " checked";

    echo "
      ></td>
      <td>&nbsp;&nbsp;<input type=text name=port_id1 size=20 align='center'
      ";

  if(!empty($editroute) && $editroute[source_type] == 'P')
    echo " value=\"$editroute[source_id]\"";

  echo "
    ></td>
    </tr><tr>
    ";

//-------------------- Personal Planet
  echo "
    <td align=right><font size=2>Personal $l_tdr_planet : </font></td>
    <td><input type=radio name=\"ptype1\" value=\"planet\"
    ";
  if(!empty($editroute) && $editroute[source_type] == 'L')
    echo " checked";

    echo '
    ></td>
    <td>&nbsp;&nbsp;<select name=planet_id1>
    ';

  if($num_planets == 0)
    echo "<option value=none>$l_tdr_none</option>";
  else
  {
    $i=0;
    while($i < $num_planets)
    {
      echo "<option ";
      if($planets[$i][planet_id] == $editroute[source_id])
        echo "selected ";
      echo "value=" . $planets[$i][planet_id] . ">" . $planets[$i][name] . " $l_tdr_insector " . $planets[$i][sector_id] . "</option>";
      $i++;
    }
  }
//----------------------- Corp Planet
    echo "
    </tr><tr>
    <td align=right><font size=2>Corporate $l_tdr_planet : </font></td>
    <td><input type=radio name=\"ptype1\" value=\"corp_planet\"
    ";

  if(!empty($editroute) && $editroute[source_type] == 'C')
    echo " checked";

    echo '
    ></td>
    <td>&nbsp;&nbsp;<select name=corp_planet_id1>
    ';

  if($num_corp_planets == 0)
    echo "<option value=none>$l_tdr_none</option>";
  else
  {
    $i=0;
    while($i < $num_corp_planets)
    {
      echo "<option ";
      if($planets_corp[$i][planet_id] == $editroute[source_id])
        echo "selected ";
      echo "value=" . $planets_corp[$i][planet_id] . ">" . $planets_corp[$i][name] . " $l_tdr_insector " . $planets_corp[$i][sector_id] . "</option>";
      $i++;
    }
  }
  echo "
    </select>
    </tr>";
//----------------------- End Start point selection
//----------------------- Begin Ending point selection
  echo "
    <tr><td>&nbsp;
    </tr><tr>
    <td align=right><font size=2><b>$l_tdr_selendpoint : <br>&nbsp;</b></font></td>
    <tr>
    <td align=right><font size=2>$l_tdr_port : </font></td>
    <td><input type=radio name=\"ptype2\" value=\"port\"
    ";

  if(empty($editroute) || (!empty($editroute) && $editroute[dest_type] == 'P'))
    echo " checked";

    echo '
    ></td>
    <td>&nbsp;&nbsp;<input type=text name=port_id2 size=20 align="center"
    ';

  if(!empty($editroute) && $editroute[dest_type] == 'P')
    echo " value=\"$editroute[dest_id]\"";

    echo "
    ></td>
    </tr>";
//-------------------- Personal Planet
    echo "
    <tr>
    <td align=right><font size=2>Personal $l_tdr_planet : </font></td>
    <td><input type=radio name=\"ptype2\" value=\"planet\"
    ";

  if(!empty($editroute) && $editroute[dest_type] == 'L')
    echo " checked";

  echo '
    ></td>
    <td>&nbsp;&nbsp;<select name=planet_id2>
    ';

  if($num_planets == 0)
    echo "<option value=none>$l_tdr_none</option>";
  else
  {
    $i=0;
    while($i < $num_planets)
    {
      echo "<option ";
      if($planets[$i][planet_id] == $editroute[dest_id])
        echo "selected ";
      echo "value=" . $planets[$i][planet_id] . ">" . $planets[$i][name] . " $l_tdr_insector " . $planets[$i][sector_id] . "</option>";
      $i++;
    }
  }
//----------------------- Corp Planet
  echo "
    </tr><tr>
    <td align=right><font size=2>Corporate $l_tdr_planet : </font></td>
    <td><input type=radio name=\"ptype2\" value=\"corp_planet\"
    ";

  if(!empty($editroute) && $editroute[dest_type] == 'C')
    echo " checked";

    echo '
    ></td>
    <td>&nbsp;&nbsp;<select name=corp_planet_id2>
    ';

  if($num_corp_planets == 0)
    echo "<option value=none>$l_tdr_none</option>";
  else
  {
    $i=0;
    while($i < $num_corp_planets)
    {
      echo "<option ";
      if($planets_corp[$i][planet_id] == $editroute[dest_id])
        echo "selected ";
      echo "value=" . $planets_corp[$i][planet_id] . ">" . $planets_corp[$i][name] . " $l_tdr_insector " . $planets_corp[$i][sector_id] . "</option>";
      $i++;
    }
  }
  echo "
    </select>
    </tr>";
//----------------------- End finishing point selection

  echo "
    </select>
    </tr><tr>
    <td>&nbsp;
    </tr><tr>
    <td align=right><font size=2><b>$l_tdr_selmovetype : </b></font></td>
    <td colspan=2 valign=top><font size=2><input type=radio name=\"move_type\" value=\"realspace\"
    ";

  if(empty($editroute) || (!empty($editroute) && $editroute[move_type] == 'R'))
    echo " checked";

  echo "
    >&nbsp;$l_tdr_realspace&nbsp;&nbsp<font size=2><input type=radio name=\"move_type\" value=\"warp\"
    ";

  if(!empty($editroute) && $editroute[move_type] == 'W')
    echo " checked";

  echo "
    >&nbsp;$l_tdr_warp</font></td>
    </tr><tr>
    <td align=right><font size=2><b>$l_tdr_selcircuit : </b></font></td>
    <td colspan=2 valign=top><font size=2><input type=radio name=\"circuit_type\" value=\"1\"
    ";

  if(empty($editroute) || (!empty($editroute) && $editroute[circuit] == '1'))
    echo " checked";

  echo "
    >&nbsp;$l_tdr_oneway&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name=\"circuit_type\" value=\"2\"
    ";

  if(!empty($editroute) && $editroute[circuit] == '2')
    echo " checked";

  echo "
    >&nbsp;$l_tdr_bothways</font></td>
    </tr><tr>
    <td>&nbsp;
    </tr><tr>
    <td><td><td align='center'>
    ";

  if(empty($editroute))
    echo "<input type=submit value=\"$l_tdr_create\">";
  else
  {
    echo "<input type=hidden name=editing value=$editroute[traderoute_id]>";
    echo "<input type=submit value=\"$l_tdr_modify\">";
  }

  echo "
    </table>
    $l_tdr_returnmenu<br>
    </form>
    ";


  TEXT_GOTOMAIN();
  include("footer.php");
  die();
}

function traderoute_create()
{
  global $playerinfo, $color_line1, $color_line2, $color_header;
  global $num_traderoutes, $servertimezone;
  global $max_traderoutes_player;
  global $ptype1;
  global $ptype2;
  global $port_id1;
  global $port_id2;
  global $planet_id1;
  global $planet_id2;
  global $corp_planet_id1;
  global $corp_planet_id2;
  global $move_type;
  global $circuit_type;
  global $editing;
  global $l_tdr_maxtdr, $l_tdr_errnotvalidport, $l_tdr_errnoport, $l_tdr_errnosrc, $l_tdr_errnotownnotsell;
  global $l_tdr_errnotvaliddestport, $l_tdr_errnoport2, $l_tdr_errnodestplanet, $l_tdr_errnotownnotsell2;
  global $l_tdr_newtdrcreated, $l_tdr_tdrmodified, $l_tdr_returnmenu;
  global $db, $dbtables;

    if($num_traderoutes >= $max_traderoutes_player && empty($editing))
    {//dont let them exceed max traderoutes
        traderoute_die($l_tdr_maxtdr);
    }
  //dbase sanity check for source
  if($ptype1 == 'port')
  {
    $query = $db->Execute("SELECT * FROM $dbtables[universe] WHERE sector_id=$port_id1");
    if(!$query || $db->EOF)
    {
      $l_tdr_errnotvalidport = str_replace("[tdr_port_id]", $port_id1, $l_tdr_errnotvalidport);
      traderoute_die($l_tdr_errnotvalidport);
    }
    //OK we definitely have a port here
    $source=$query->fields;
    if($source['port_type'] == 'none')
    {
      $l_tdr_errnoport = str_replace("[tdr_port_id]", $port_id1, $l_tdr_errnoport);
      traderoute_die($l_tdr_errnoport);
    }
  }
  else
  {
    $query = $db->Execute("SELECT * FROM $dbtables[planets] WHERE planet_id=$planet_id1");
    $source=$query->fields;
    if(!$query || $query->EOF)
    {
      traderoute_die($l_tdr_errnosrc);
    }

    //hum, that thing was tricky
    if($source['owner'] != $playerinfo['ship_id'])
    {
      if(($playerinfo['team'] == 0 || $playerinfo['team'] != $source['corp']) && $source['sells'] == 'N')
      {
        $l_tdr_errnotownnotsell = str_replace("[tdr_source_name]", $source[name], $l_tdr_errnotownnotsell);
        $l_tdr_errnotownnotsell = str_replace("[tdr_source_sector_id]", $source[sector_id], $l_tdr_errnotownnotsell);
        traderoute_die($l_tdr_errnotownnotsell);
      }
    }
  }
//OK we have $source, *probably* now lets see if we have ever been there
//Attempting to fix the map the universe via traderoute bug -- rjordan01

$pl1query = $db->Execute("SELECT * FROM $dbtables[movement_log] WHERE sector_id=$source[sector_id] AND ship_id = $playerinfo[ship_id]");
$num_res1 = $pl1query->numRows();
if($num_res1 == 0)
{
    traderoute_die("You cannot create a traderoute from a sector you have not visited!");
}
//note: shouldnt we, more realistically, require a ship to be *IN* the source sector to create the traderoute?

  //dbase sanity check for dest
  if($ptype2 == 'port')
  {
    $query = $db->Execute("SELECT * FROM $dbtables[universe] WHERE sector_id=$port_id2");
    if(!$query || $query->EOF)
    {
      $l_tdr_errnotvaliddestport = str_replace("[tdr_port_id]", $port_id2, $l_tdr_errnotvaliddestport);
      traderoute_die($l_tdr_errnotvaliddestport);
    }

    $destination=$query->fields;

    if($destination['port_type'] == 'none')
    {
      $l_tdr_errnoport2 = str_replace("[tdr_port_id]", $port_id2, $l_tdr_errnoport2);
      traderoute_die($l_tdr_errnoport2);
    }
  }
  else
  {
    $query = $db->Execute("SELECT * FROM $dbtables[planets] WHERE planet_id=$planet_id2");
    $destination=$query->fields;
        if(!$query || $query->EOF)
        {
            traderoute_die($l_tdr_errnodestplanet);
        }

    if($destination['owner'] != $playerinfo['ship_id'] && $destination['sells'] == 'N')
    {
      $l_tdr_errnotownnotsell2 = str_replace("[tdr_dest_name]", $destination['name'], $l_tdr_errnotownnotsell2);
      $l_tdr_errnotownnotsell2 = str_replace("[tdr_dest_sector_id]", $destination['sector_id'], $l_tdr_errnotownnotsell2);
      traderoute_die($l_tdr_errnotownnotsell2);
    }
  }
//OK now we have $destination lets see if we've been there.
$pl2query = $db->Execute("SELECT * FROM $dbtables[movement_log] WHERE sector_id=$destination[sector_id] AND ship_id = $playerinfo[ship_id]");
$num_res2 = $pl2query->numRows();
if($num_res2 == 0)
{
    traderoute_die("You cannot create a traderoute into a sector you have not visited!");
}
//check destination- we cannot trade INTO a special port
if($destination['port_type'] == 'special')
{

    traderoute_die("You cannot create a traderoute into a special port!");
}
  //check traderoute for src => dest
  traderoute_check_compatible($ptype1, $ptype2, $move_type, $circuit_type, $source , $destination);

  if($ptype1 == 'port')
    $src_id = $port_id1;
  elseif($ptype1 == 'planet')
    $src_id = $planet_id1;
  elseif($ptype1 == 'corp_planet')
    $src_id = $corp_planet_id1;


  if($ptype2 == 'port')
    $dest_id = $port_id2;
  elseif($ptype2 == 'planet')
    $dest_id = $planet_id2;
  elseif($ptype2 == 'corp_planet')
    $dest_id = $corp_planet_id2;


  if($ptype1 == 'port')
    $src_type = 'P';
  elseif($ptype1 == 'planet')
    $src_type = 'L';
  elseif($ptype1 == 'corp_planet')
    $src_type = 'C';


  if($ptype2 == 'port')
    $dest_type = 'P';
  elseif($ptype2 == 'planet')
    $dest_type = 'L';
  elseif($ptype2 == 'corp_planet')
    $dest_type = 'C';

  if($move_type == 'realspace')
    $mtype = 'R';
  else
    $mtype = 'W';

  if(empty($editing))
  {
    $query = $db->Execute("INSERT INTO $dbtables[traderoutes] VALUES(NULL, $src_id, $dest_id, '$src_type', '$dest_type', '$mtype', $playerinfo[ship_id], '$circuit_type')");
    echo "<p>$l_tdr_newtdrcreated";
  }
  else
  {
    $query = $db->Execute("UPDATE $dbtables[traderoutes] SET source_id=$src_id, dest_id=$dest_id, source_type='$src_type', dest_type='$dest_type', move_type='$mtype', owner=$playerinfo[ship_id], circuit='$circuit_type' WHERE traderoute_id=$editing");
    echo "<p>$l_tdr_tdrmodified";
  }

  echo " $l_tdr_returnmenu";
  traderoute_die("");

}

function traderoute_delete()
{
  global $playerinfo, $color_line1, $color_line2, $color_header;
  global $confirm, $servertimezone;
  global $num_traderoutes;
  global $traderoute_id;
  global $traderoutes;
  global $l_tdr_returnmenu, $l_tdr_tdrdoesntexist, $l_tdr_notowntdr, $l_tdr_tdrdeleted;
  global $db, $dbtables;

  $query = $db->Execute("SELECT * FROM $dbtables[traderoutes] WHERE traderoute_id=$traderoute_id");
  if(!$query || $query->EOF)
    traderoute_die($l_tdr_tdrdoesntexist);

  $delroute = $query->fields;

  if($delroute[owner] != $playerinfo[ship_id])
    traderoute_die($l_tdr_notowntdr);

  if(empty($confirm))
  {
    $num_traderoutes = 1;
    $traderoutes[0] = $delroute;
    // here it continues to the main file area to print the route
  }
  else
  {
    $query = $db->Execute("DELETE FROM $dbtables[traderoutes] WHERE traderoute_id=$traderoute_id");
    echo "$l_tdr_tdrdeleted $l_tdr_returnmenu";
    traderoute_die("");
  }
}

function traderoute_settings()
{
  global $playerinfo, $color_line1, $color_line2, $color_header, $servertimezone;
  global $l_tdr_globalset, $l_tdr_tdrsportsrc, $l_tdr_colonists, $l_tdr_fighters, $l_tdr_torps, $l_tdr_trade;
  global $l_tdr_tdrescooped, $l_tdr_keep, $l_tdr_save, $l_tdr_returnmenu;
  global $db, $dbtables;

  echo "<p><font size=3 color=blue><b>$l_tdr_globalset</b></font><p>";

  echo "<font color=white size=2><b>$l_tdr_tdrsportsrc :</b></font><p>".
    "<form action=traderoute.php?command=setsettings method=post>".
    "<table border=0><tr>".
    "<td><font size=2 color=white> - $l_tdr_colonists :</font></td>".
    "<td><input type=checkbox name=colonists";

  if($playerinfo[trade_colonists] == 'Y')
    echo " checked";

  echo "></tr><tr>".
    "<td><font size=2 color=white> - $l_tdr_fighters :</font></td>".
    "<td><input type=checkbox name=fighters";

  if($playerinfo[trade_fighters] == 'Y')
    echo " checked";

  echo "></tr><tr>".
    "<td><font size=2 color=white> - $l_tdr_torps :</font></td>".
    "<td><input type=checkbox name=torps";

  if($playerinfo[trade_torps] == 'Y')
    echo " checked";

  echo "></tr>".
    "</table>".
    "<p>".
    "<font color=white size=2><b>$l_tdr_tdrescooped :</b></font><p>".
    "<table border=0><tr>".
    "<td><font size=2 color=white>&nbsp;&nbsp;&nbsp;$l_tdr_trade</font></td>".
    "<td><input type=radio name=energy value=\"Y\"";

  if($playerinfo[trade_energy] == 'Y')
    echo " checked";

  echo "></td></tr><tr>".
    "<td><font size=2 color=white>&nbsp;&nbsp;&nbsp;$l_tdr_keep</font></td>".
    "<td><input type=radio name=energy value=\"N\"";

  if($playerinfo[trade_energy] == 'N')
    echo " checked";

  echo "></td></tr><tr><td>&nbsp;</td></tr><tr><td>".
    "<td><input type=submit value=\"$l_tdr_save\"></td>".
    "</tr></table>".
    "</form>";

  echo $l_tdr_returnmenu;
  traderoute_die("");

}

function traderoute_setsettings()
{
  global $playerinfo, $color_line1, $color_line2, $color_header;
  global $colonists, $servertimezone;
  global $fighters;
  global $torps;
  global $energy;
  global $l_tdr_returnmenu, $l_tdr_globalsetsaved;
  global $db, $dbtables;

  empty($colonists) ? $colonists = 'N' : $colonists = 'Y';
  empty($fighters) ? $fighters = 'N' : $fighters = 'Y';
  empty($torps) ? $torps = 'N' : $torps = 'Y';

  $db->Execute("UPDATE $dbtables[ships] SET trade_colonists='$colonists', trade_fighters='$fighters', trade_torps='$torps', trade_energy='$energy' WHERE ship_id=$playerinfo[ship_id]");

  echo "$l_tdr_globalsetsaved $l_tdr_returnmenu";
  traderoute_die("");
}

function traderoute_engage($j)
{
  global $playerinfo, $color_line1, $color_line2, $color_header;
  global $engage, $servertimezone;
    global $color_line2;
    global $color_line1;
  global $traderoutes;
  global $fighter_price;
  global $torpedo_price;
  global $colonist_price;
  global $colonist_limit;
  global $inventory_factor;
  global $ore_price;
  global $ore_delta;
  global $ore_limit;
  global $organics_price;
  global $organics_delta;
  global $organics_limit;
  global $goods_price;
  global $goods_delta;
  global $goods_limit;
  global $energy_price;
  global $energy_delta;
  global $energy_limit;
  global $l_tdr_turnsused, $l_tdr_turnsleft, $l_tdr_credits, $l_tdr_profit, $l_tdr_cost, $l_tdr_totalprofit, $l_tdr_totalcost;
  global $l_tdr_planetisovercrowded, $l_tdr_engageagain, $l_tdr_onlyonewaytdr, $l_tdr_engagenonexist, $l_tdr_notowntdr;
  global $l_tdr_invalidspoint, $l_tdr_inittdr, $l_tdr_invalidsrc, $l_tdr_inittdrsector, $l_tdr_organics, $l_tdr_energy, $l_tdr_loaded;
  global $l_tdr_nothingtoload, $l_tdr_scooped, $l_tdr_dumped, $l_tdr_portisempty, $l_tdr_portisfull, $l_tdr_ore, $l_tdr_sold;
  global $l_tdr_goods, $l_tdr_notyourplanet, $l_tdr_invalidssector, $l_tdr_invaliddport, $l_tdr_invaliddplanet;
  global $l_tdr_invaliddsector, $l_tdr_nowlink1, $l_tdr_nowlink2, $l_tdr_moreturnsneeded, $l_tdr_tdrhostdef;
  global $l_tdr_globalsetbuynothing, $l_tdr_nosrcporttrade, $l_tdr_tradesrcportoutsider, $l_tdr_tdrres, $l_tdr_torps;
  global $l_tdr_nodestporttrade, $l_tdr_tradedestportoutsider, $l_tdr_portin, $l_tdr_planet, $l_tdr_bought, $l_tdr_colonists;
  global $l_tdr_fighters, $l_tdr_nothingtotrade;
  global $db, $dbtables;

  //10 pages of sanity checks! yeah!

  foreach($traderoutes as $testroute)
  {
    if($testroute['traderoute_id'] == $engage)
      $traderoute = $testroute;
    //var_dump($traderoute);
  }

  if(!isset($traderoute))
    traderoute_die($l_tdr_engagenonexist);

  if($traderoute['owner'] != $playerinfo['ship_id'])
    traderoute_die($l_tdr_notowntdr);



// ********************************
// *****  Source Check ************
// ********************************
  if($traderoute['source_type'] == 'P')
  {
    //retrieve port info here, we'll need it later anyway
    $result = $db->Execute("SELECT * FROM $dbtables[universe] WHERE sector_id=$traderoute[source_id]");
    if(!$result || $result->EOF)
      traderoute_die($l_tdr_invalidspoint);

    $source = $result->fields;

    if($traderoute['source_id'] != $playerinfo['sector'])
    {
      $l_tdr_inittdr = str_replace("[tdr_source_id]", $traderoute['source_id'], $l_tdr_inittdr);
      traderoute_die($l_tdr_inittdr);
    }
  }
  elseif($traderoute['source_type'] == 'L' || $traderoute['source_type'] == 'C')  // get data from planet table
  {
    $result = $db->Execute("SELECT * FROM $dbtables[planets] WHERE planet_id=$traderoute[source_id]");
    if(!$result || $result->EOF)
      traderoute_die($l_tdr_invalidsrc);

    $source = $result->fields;

    if($source['sector_id'] != $playerinfo['sector'])
    {
      $l_tdr_inittdrsector = str_replace("[tdr_source_sector_id]", $source['sector_id'], $l_tdr_inittdrsector);
      traderoute_die($l_tdr_inittdrsector);
    }

    if($traderoute['source_type'] == 'L')
    {
      if($source[owner] != $playerinfo[ship_id])
      {
        $l_tdr_notyourplanet = str_replace("[tdr_source_name]", $source[name], $l_tdr_notyourplanet);
        $l_tdr_notyourplanet = str_replace("[tdr_source_sector_id]", $source[sector_id], $l_tdr_notyourplanet);
        traderoute_die($l_tdr_notyourplanet);
      }
    }
    elseif($traderoute[source_type] == 'C')   // check to make sure player and planet are in the same corp.
    {
      if($source[corp] != $playerinfo[team])
      {
        $l_tdr_notyourplanet = str_replace("[tdr_source_name]", $source[name], $l_tdr_notyourplanet);
        $l_tdr_notyourplanet = str_replace("[tdr_source_sector_id]", $source[sector_id], $l_tdr_notyourplanet);
        $not_corp_planet = "$source[name] in $source[sector_id] not a Copporate Planet";
        traderoute_die($not_corp_planet);
      }
    }

    //store starting port info, we'll need it later
    $result = $db->Execute("SELECT * FROM $dbtables[universe] WHERE sector_id=$source[sector_id]");
    if(!$result || $result->EOF)
      traderoute_die($l_tdr_invalidssector);

    $sourceport = $result->fields;
  }

// ********************************
// ***** Destination Check ********
// ********************************
  if($traderoute[dest_type] == 'P')
  {
    $result = $db->Execute("SELECT * FROM $dbtables[universe] WHERE sector_id=$traderoute[dest_id]");
    if(!$result || $result->EOF)
      traderoute_die($l_tdr_invaliddport);

    $dest = $result->fields;
  }
  elseif(($traderoute[dest_type] == 'L') || ($traderoute[dest_type] == 'C'))  // get data from planet table
  {
    $result = $db->Execute("SELECT * FROM $dbtables[planets] WHERE planet_id=$traderoute[dest_id]");
    if(!$result || $result->EOF)
      traderoute_die($l_tdr_invaliddplanet);

    $dest = $result->fields;

    $result = $db->Execute("SELECT * FROM $dbtables[universe] WHERE sector_id=$dest[sector_id]");
    if(!$result || $result->EOF)
      traderoute_die($l_tdr_invaliddsector);

    $destport = $result->fields;
  }

  if(!isset($sourceport))
    $sourceport=$source;
  if(!isset($destport))
    $destport=$dest;

// ***************************************************
// ***** Warp or RealSpace and generate distance *****
// ***************************************************
  if($traderoute[move_type] == 'W')
  {
    $query = $db->Execute("SELECT link_id FROM $dbtables[links] WHERE link_start=$source[sector_id] AND link_dest=$dest[sector_id]");
    if($query->EOF)
    {
      $l_tdr_nowlink1 = str_replace("[tdr_src_sector_id]", $source[sector_id], $l_tdr_nowlink1);
      $l_tdr_nowlink1 = str_replace("[tdr_dest_sector_id]", $dest[sector_id], $l_tdr_nowlink1);
      traderoute_die($l_tdr_nowlink1);
    }
    if($traderoute[circuit] == '2')
    {
      $query = $db->Execute("SELECT link_id FROM $dbtables[links] WHERE link_start=$dest[sector_id] AND link_dest=$source[sector_id]");
      if($query->EOF)
      {
        $l_tdr_nowlink2 = str_replace("[tdr_src_sector_id]", $source[sector_id], $l_tdr_nowlink2);
        $l_tdr_nowlink2 = str_replace("[tdr_dest_sector_id]", $dest[sector_id], $l_tdr_nowlink2);
        traderoute_die($l_tdr_nowlink2);
      }
      $dist[triptime] = 4;
    }
    else
      $dist[triptime] = 2;

    $dist[scooped] = 0;
  }
  else
    $dist = traderoute_distance('P', 'P', $sourceport, $destport, $traderoute[circuit]);


// ********************************************
// ***** Check if player has enough turns *****
// ********************************************
  if($playerinfo[turns] < $dist[triptime])
  {
    $l_tdr_moreturnsneeded = str_replace("[tdr_dist_triptime]", $dist[triptime], $l_tdr_moreturnsneeded);
    $l_tdr_moreturnsneeded = str_replace("[tdr_playerinfo_turns]", $playerinfo[turns], $l_tdr_moreturnsneeded);
    traderoute_die($l_tdr_moreturnsneeded);
  }


// ********************************
// ***** Sector Defense Check *****
// ********************************
  $hostile = 0;

  $result99 = $db->Execute("SELECT * FROM $dbtables[sector_defence] WHERE sector_id = $source[sector_id] AND ship_id <> $playerinfo[ship_id]");
  if(!$result99->EOF)
  {
     $fighters_owner = $result99->fields;
     $nsresult = $db->Execute("SELECT * from $dbtables[ships] where ship_id=$fighters_owner[ship_id]");
     $nsfighters = $nsresult->fields;
     if ($nsfighters[team] != $playerinfo[team] || $playerinfo[team]==0)
            $hostile = 1;
  }

  $result98 = $db->Execute("SELECT * FROM $dbtables[sector_defence] WHERE sector_id = $dest[sector_id] AND ship_id <> $playerinfo[ship_id]");
  if(!$result98->EOF)
  {
     $fighters_owner = $result98->fields;
     $nsresult = $db->Execute("SELECT * from $dbtables[ships] where ship_id=$fighters_owner[ship_id]");
     $nsfighters = $nsresult->fields;
     if ($nsfighters[team] != $playerinfo[team] || $playerinfo[team]==0)
            $hostile = 1;
  }

  if($hostile > 0 && $playerinfo[hull] > $mine_hullsize)
     traderoute_die($l_tdr_tdrhostdef);

// ***************************************
// ***** Special Port Nothing to do ******
// ***************************************
  if($traderoute[source_type] == 'P' && $source[port_type] == 'special' && $playerinfo[trade_colonists] == 'N' && $playerinfo[trade_fighters] == 'N' && $playerinfo[trade_torps] == 'N')
    traderoute_die($l_tdr_globalsetbuynothing);


// *********************************************
// ***** Check if zone allows trading  SRC *****
// *********************************************
  if($traderoute[source_type] == 'P')
  {
    $res = $db->Execute("SELECT * FROM $dbtables[zones],$dbtables[universe] WHERE $dbtables[universe].sector_id=$traderoute[source_id] AND $dbtables[zones].zone_id=$dbtables[universe].zone_id");
    $zoneinfo = $res->fields;
    if($zoneinfo[allow_trade] == 'N')
      traderoute_die($l_tdr_nosrcporttrade);
    elseif($zoneinfo[allow_trade] == 'L')
    {
      if($zoneinfo[corp_zone] == 'N')
      {
        $res = $db->Execute("SELECT team FROM $dbtables[ships] WHERE ship_id=$zoneinfo[owner]");
        $ownerinfo = $res->fields;

        if($playerinfo[ship_id] != $zoneinfo[owner] && $playerinfo[team] == 0 || $playerinfo[team] != $ownerinfo[team])
          traderoute_die($l_tdr_tradesrcportoutsider);
      }
      else
      {
        if($playerinfo[team] != $zoneinfo[owner])
          traderoute_die($l_tdr_tradesrcportoutsider);
      }
    }
  }

// **********************************************
// ***** Check if zone allows trading  DEST *****
// **********************************************
  if($traderoute[dest_type] == 'P')
  {
    $res = $db->Execute("SELECT * FROM $dbtables[zones],$dbtables[universe] WHERE $dbtables[universe].sector_id=$traderoute[dest_id] AND $dbtables[zones].zone_id=$dbtables[universe].zone_id");
    $zoneinfo = $res->fields;
    if($zoneinfo[allow_trade] == 'N')
      traderoute_die($l_tdr_nodestporttrade);
    elseif($zoneinfo[allow_trade] == 'L')
    {
      if($zoneinfo[corp_zone] == 'N')
      {
        $res = $db->Execute("SELECT team FROM $dbtables[ships] WHERE ship_id=$zoneinfo[owner]");
        $ownerinfo = $res->fields;

        if($playerinfo[ship_id] != $zoneinfo[owner] && $playerinfo[team] == 0 || $playerinfo[team] != $ownerinfo[team])
          traderoute_die($l_tdr_tradedestportoutsider);
      }
      else
      {
        if($playerinfo[team] != $zoneinfo[owner])
          traderoute_die($l_tdr_tradedestportoutsider);
      }
    }
  }

//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//---------  We're done with checks! All that's left is to make it happen --------
//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------


traderoute_results_table_top();
// ------------ Determine if Source is Planet or Port
    if($traderoute['source_type'] == 'P')
    {
        echo "$l_tdr_portin $source[sector_id]";
    }
    elseif(($traderoute['source_type'] == 'L') || ($traderoute['source_type'] == 'C'))
    {
        echo "$l_tdr_planet $source[name] in $sourceport[sector_id]";
    }
  traderoute_results_source();

// ------------ Determine if Destination is Planet or Port
    if($traderoute['dest_type'] == 'P')
    {
        echo "$l_tdr_portin $dest[sector_id]";
    }
    elseif(($traderoute['dest_type'] == 'L') || ($traderoute['dest_type'] == 'C'))
    {
        echo "$l_tdr_planet $dest[name] in $destport[sector_id]";
    }
   traderoute_results_destination();

  $sourcecost=0;

//-------- Source is Port ------------
  if($traderoute[source_type] == 'P')
  {
    //-------- Special Port Section (begin) ------
    if($source[port_type] == 'special')
    {
      $total_credits = $playerinfo[credits];

      if($playerinfo[trade_colonists] == 'Y')
      {
      $free_holds = NUM_HOLDS($playerinfo[hull]) - $playerinfo[ship_ore] - $playerinfo[ship_organics] - $playerinfo[ship_goods] - $playerinfo[ship_colonists];
        $colonists_buy = $free_holds;

        if($playerinfo[credits] < $colonist_price * $colonists_buy)
          $colonists_buy = $playerinfo[credits] / $colonist_price;

        if($colonists_buy != 0)
          echo "$l_tdr_bought " . NUMBER($colonists_buy) . " $l_tdr_colonists<br>";

        $sourcecost-=$colonists_buy * $colonist_price;
        $total_credits-=$colonists_buy * $colonist_price;
      }
      else
        $colonists_buy = 0;

      if($playerinfo[trade_fighters] == 'Y')
      {
        $free_fighters = NUM_FIGHTERS($playerinfo[computer]) - $playerinfo[ship_fighters];
        $fighters_buy = $free_fighters;

        if($total_credits < $fighters_buy * $fighter_price)
          $fighters_buy = $total_credits / $fighter_price;

        if($fighters_buy != 0)
          echo "$l_tdr_bought " . NUMBER($fighters_buy) . " $l_tdr_fighters<br>";

        $sourcecost-=$fighters_buy * $fighter_price;
        $total_credits-=$fighters_buy * $fighter_price;
      }
      else
        $fighters_buy = 0;

      if($playerinfo[trade_torps] == 'Y')
      {
        $free_torps = NUM_FIGHTERS($playerinfo[torp_launchers]) - $playerinfo[torps];
        $torps_buy = $free_torps;

        if($total_credits < $torps_buy * $torpedo_price)
          $torps_buy = $total_credits / $torpedo_price;

        if($torps_buy != 0)
          echo "$l_tdr_bought " . NUMBER($torps_buy) . " $l_tdr_torps<br>";

        $sourcecost-=$torps_buy * $torpedo_price;
      }
      else
        $torps_buy = 0;

      if($torps_buy == 0 && $colonists_buy == 0 && $fighters_buy == 0)
        echo "$l_tdr_nothingtotrade<br>";

      if($traderoute[circuit] == '1')
        $db->Execute("UPDATE $dbtables[ships] SET ship_colonists=ship_colonists+$colonists_buy, ship_fighters=ship_fighters+$fighters_buy,torps=torps+$torps_buy, ship_energy=ship_energy+$dist[scooped1] WHERE ship_id=$playerinfo[ship_id]");
    }
//-------- Special Port Section (end) ------
//-------- Normal Port Section (begin) ------
    else
    {
      //sells commodities
      // added below initializations, for traderoute bug - rjordan01

            $ore_buy = 0;
            $goods_buy = 0;
            $organics_buy = 0;
            $energy_buy = 0;

            if($source[port_type] != 'ore')
      {
        $ore_price1 = $ore_price + $ore_delta * $source[port_ore] / $ore_limit * $inventory_factor;
        if($source[port_ore] - $playerinfo[ship_ore] < 0)
        {
          $ore_buy = $source[port_ore];
          $portfull = 1;
        }
        else
          $ore_buy = $playerinfo[ship_ore];
        $sourcecost += $ore_buy * $ore_price1;
        if($ore_buy != 0)
        {
          if($portfull == 1)
            echo "$l_tdr_sold " . NUMBER($ore_buy) . " $l_tdr_ore ($l_tdr_portisfull)<br>";
          else
            echo "$l_tdr_sold " . NUMBER($ore_buy) . " $l_tdr_ore<br>";
        }
        $playerinfo[ship_ore] -= $ore_buy;
      }

      $portfull = 0;
      if($source[port_type] != 'goods')
      {
        $goods_price1 = $goods_price + $goods_delta * $source[port_goods] / $goods_limit * $inventory_factor;
        if($source[port_goods] - $playerinfo[ship_goods] < 0)
        {
          $goods_buy = $source[port_goods];
          $portfull = 1;
        }
        else
          $goods_buy = $playerinfo[ship_goods];
        $sourcecost += $goods_buy * $goods_price1;
        if($goods_buy != 0)
        {
            if($portfull == 1)
            {
                echo "$l_tdr_sold " . NUMBER($goods_buy) . " $l_tdr_goods ($l_tdr_portisfull)<br>";

            }
            else
            {
                echo "$l_tdr_sold " . NUMBER($goods_buy) . " $l_tdr_goods<br>";
            }
        }
        $playerinfo[ship_goods] -= $goods_buy;
      }

      $portfull = 0;
      if($source[port_type] != 'organics')
      {
        $organics_price1 = $organics_price + $organics_delta * $source[port_organics] / $organics_limit * $inventory_factor;
        if($source[port_organics] - $playerinfo[ship_organics] < 0)
        {
          $organics_buy = $source[port_organics];
          $portfull = 1;
        }
        else
          $organics_buy = $playerinfo[ship_organics];
        $sourcecost += $organics_buy * $organics_price1;
        if($organics_buy != 0)
        {
            if($portfull == 1)
            {
                echo "$l_tdr_sold " . NUMBER($organics_buy) . " $l_tdr_organics ($l_tdr_portisfull)<br>";
            }
            else
            {
                echo "$l_tdr_sold " . NUMBER($organics_buy) . " $l_tdr_organics<br>";
            }
        }
        $playerinfo[ship_organics] -= $organics_buy;
      }

      $portfull = 0;
      if($source[port_type] != 'energy' && $playerinfo[trade_energy] == 'Y')
      {
        $energy_price1 = $energy_price + $energy_delta * $source[port_energy] / $energy_limit * $inventory_factor;
        if($source[port_energy] - $playerinfo[ship_energy] < 0)
        {
          $energy_buy = $source[port_energy];
          $portfull = 1;
        }
        else
        {
            $energy_buy = $playerinfo[ship_energy];
        }
        $sourcecost += $energy_buy * $energy_price1;
        if($energy_buy != 0)
        {
            if($portfull == 1)
            {
                echo "$l_tdr_sold " . NUMBER($energy_buy) . " $l_tdr_energy ($l_tdr_portisfull)<br>";
            }
            else
            {
                echo "$l_tdr_sold " . NUMBER($energy_buy) . " $l_tdr_energy<br>";
            }
        }
        $playerinfo[ship_energy] -= $energy_buy;
      }

      $free_holds = NUM_HOLDS($playerinfo[hull]) - $playerinfo[ship_ore] - $playerinfo[ship_organics] - $playerinfo[ship_goods] - $playerinfo[ship_colonists];

      //time to buy
      if($source[port_type] == 'ore')
      {
        $ore_price1 = $ore_price - $ore_delta * $source[port_ore] / $ore_limit * $inventory_factor;
        $ore_buy = $free_holds;
        if($playerinfo[credits] + $sourcecost < $ore_buy * $ore_price1)
          $ore_buy = ($playerinfo[credits] + $sourcecost) / $ore_price1;
        if($source[port_ore] < $ore_buy)
        {
          $ore_buy = $source[port_ore];
            if($source[port_ore] == 0)
            {
                echo "$l_tdr_bought " . NUMBER($ore_buy) . " $l_tdr_ore ($l_tdr_portisempty)<br>";
            }
        }
        if($ore_buy != 0)
        {
            echo "$l_tdr_bought " . NUMBER($ore_buy) . " $l_tdr_ore<br>";
        }
        $playerinfo['ship_ore'] += $ore_buy;
        $sourcecost -= $ore_buy * $ore_price1;
        $db->Execute("UPDATE $dbtables[universe] SET port_ore=port_ore-$ore_buy, port_energy=port_energy-$energy_buy, port_goods=port_goods-$goods_buy, port_organics=port_organics-$organics_buy WHERE sector_id=$source[sector_id]");
      }

      if($source[port_type] == 'goods')
      {
        $goods_price1 = $goods_price - $goods_delta * $source[port_goods] / $goods_limit * $inventory_factor;
        $goods_buy = $free_holds;
        if($playerinfo[credits] + $sourcecost < $goods_buy * $goods_price1)
          $goods_buy = ($playerinfo[credits] + $sourcecost) / $goods_price1;
        if($source[port_goods] < $goods_buy)
        {
          $goods_buy = $source[port_goods];
          if($source[port_goods] == 0)
            echo "$l_tdr_bought " . NUMBER($goods_buy) . " $l_tdr_goods ($l_tdr_portisempty)<br>";
        }
        if($goods_buy != 0)
          echo "$l_tdr_bought " . NUMBER($goods_buy) . " $l_tdr_goods<br>";
        $playerinfo[ship_goods] += $goods_buy;
        $sourcecost -= $goods_buy * $goods_price1;
        $db->Execute("UPDATE $dbtables[universe] SET port_ore=port_ore-$ore_buy, port_energy=port_energy-$energy_buy, port_goods=port_goods-$goods_buy, port_organics=port_organics-$organics_buy WHERE sector_id=$source[sector_id]");
      }

      if($source[port_type] == 'organics')
      {
        $organics_price1 = $organics_price - $organics_delta * $source[port_organics] / $organics_limit * $inventory_factor;
        $organics_buy = $free_holds;
        if($playerinfo[credits] + $sourcecost < $organics_buy * $organics_price1)
          $organics_buy = ($playerinfo[credits] + $sourcecost) / $organics_price1;
        if($source[port_organics] < $organics_buy)
        {
          $organics_buy = $source[port_organics];
          if($source[port_organics] == 0)
            echo "$l_tdr_bought " . NUMBER($organics_buy) . " $l_tdr_organics ($l_tdr_portisempty)<br>";
        }
        if($organics_buy != 0)
          echo "$l_tdr_bought " . NUMBER($organics_buy) . " $l_tdr_organics<br>";
        $playerinfo[ship_organics] += $organics_buy;
        $sourcecost -= $organics_buy * $organics_price1;
        $db->Execute("UPDATE $dbtables[universe] SET port_ore=port_ore-$ore_buy, port_energy=port_energy-$energy_buy, port_goods=port_goods-$goods_buy, port_organics=port_organics-$organics_buy WHERE sector_id=$source[sector_id]");
      }

      if($source[port_type] == 'energy')
      {
        $energy_price1 = $energy_price - $energy_delta * $source[port_energy] / $energy_limit * $inventory_factor;
        $energy_buy = NUM_ENERGY($playerinfo[power]) - $playerinfo[ship_energy] - $dist[scooped1];
        if($playerinfo[credits] + $sourcecost < $energy_buy * $energy_price1)
          $energy_buy = ($playerinfo[credits] + $sourcecost) / $energy_price1;
        if($source[port_energy] < $energy_buy)
        {
          $energy_buy = $source[port_energy];
          if($source[port_energy] == 0)
            echo "$l_tdr_bought " . NUMBER($energy_buy) . " $l_tdr_energy ($l_tdr_portisempty)<br>";
        }
        if($energy_buy != 0)
          echo "$l_tdr_bought " . NUMBER($energy_buy) . " $l_tdr_energy<br>";
        $playerinfo[ship_energy] += $energy_buy;
        $sourcecost -= $energy_buy * $energy_price1;
        $db->Execute("UPDATE $dbtables[universe] SET port_ore=port_ore-$ore_buy, port_energy=port_energy-$energy_buy, port_goods=port_goods-$goods_buy, port_organics=port_organics-$organics_buy WHERE sector_id=$source[sector_id]");
      }
      if($dist[scooped1] > 0)
      {
        $playerinfo[ship_energy]+= $dist[scooped1];
        if($playerinfo[ship_energy] > NUM_ENERGY($playerinfo[power]))
          $playerinfo[ship_energy] = NUM_ENERGY($playerinfo[power]);
      }
      if($ore_buy == 0 && $goods_buy == 0 && $energy_buy == 0 && $organics_buy == 0)
        echo "$l_tdr_nothingtotrade<br>";

      if($traderoute[circuit] == '1')
        $db->Execute("UPDATE $dbtables[ships] SET ship_ore=$playerinfo[ship_ore], ship_goods=$playerinfo[ship_goods], ship_organics=$playerinfo[ship_organics], ship_energy=$playerinfo[ship_energy] WHERE ship_id=$playerinfo[ship_id]");
    }
  }
//------------- Source is port (end) ---------
//------------- Source is planet (begin) -----
  elseif(($traderoute[source_type] == 'L') || ($traderoute[source_type] == 'C'))
  {
    $free_holds = NUM_HOLDS($playerinfo[hull]) - $playerinfo[ship_ore] - $playerinfo[ship_organics] - $playerinfo[ship_goods] - $playerinfo[ship_colonists];

    if($traderoute[dest_type] == 'P')
    {
      //pick stuff up to sell at port
      if(($playerinfo[ship_id] == $source[owner]) || ($playerinfo[team] == $source[corp]))
      {
        if($source[goods] > 0 && $free_holds > 0 && $dest[port_type] != 'goods')
        {
          if($source[goods] > $free_holds)
            $goods_buy = $free_holds;
          else
            $goods_buy = $source[goods];
          $free_holds -= $goods_buy;
          $playerinfo[ship_goods] += $goods_buy;
          echo "$l_tdr_loaded " . NUMBER($goods_buy) . " $l_tdr_goods<br>";
        }
        else
          $goods_buy = 0;

        if($source[ore] > 0 && $free_holds > 0 && $dest[port_type] != 'ore')
        {
          if($source[ore] > $free_holds)
            $ore_buy = $free_holds;
          else
            $ore_buy = $source[ore];
          $free_holds -= $ore_buy;
          $playerinfo[ship_ore] += $ore_buy;
          echo "$l_tdr_loaded " . NUMBER($ore_buy) . " $l_tdr_ore<br>";
        }
        else
          $ore_buy = 0;

        if($source[organics] > 0 && $free_holds > 0 && $dest[port_type] != 'organics')
        {
          if($source[organics] > $free_holds)
            $organics_buy = $free_holds;
          else
            $organics_buy = $source[organics];
          $free_holds -= $organics_buy;
          $playerinfo[ship_organics] += $organics_buy;
          echo "$l_tdr_loaded " . NUMBER($organics_buy) . " $l_tdr_organics<br>";
        }
        else
          $organics_buy = 0;

        if($ore_buy == 0 && $goods_buy == 0 && $organics_buy == 0)
          echo "$l_tdr_nothingtoload<br>";

        if($traderoute[circuit] == '1')
          $db->Execute("UPDATE $dbtables[ships] SET ship_ore=$playerinfo[ship_ore], ship_goods=$playerinfo[ship_goods], ship_organics=$playerinfo[ship_organics] WHERE ship_id=$playerinfo[ship_id]");

      }
      else  //buy from planet - not implemented yet
      {
      }

      $db->Execute("UPDATE $dbtables[planets] SET ore=ore-$ore_buy, goods=goods-$goods_buy, organics=organics-$organics_buy WHERE planet_id=$source[planet_id]");
    }
// ---------- destination is a planet, so load cols and weapons
    elseif(($traderoute[dest_type] == 'L') || ($traderoute[dest_type] == 'C'))
    {
      if($source[colonists] > 0 && $free_holds > 0 && $playerinfo[trade_colonists] == 'Y')
      {
        if($source[colonists] > $free_holds)
          $colonists_buy = $free_holds;
        else
          $colonists_buy = $source[colonists];
        $free_holds -= $colonists_buy;
        $playerinfo[ship_colonists] += $colonists_buy;
        echo "$l_tdr_loaded " . NUMBER($colonists_buy) . " $l_tdr_colonists<br>";
      }
      else
        $colonists_buy = 0;

      $free_torps = NUM_TORPEDOES($playerinfo[torp_launchers]) - $playerinfo[torps];
      if($source[torps] > 0 && $free_torps > 0 && $playerinfo[trade_torps] == 'Y')
      {
        if($source[torps] > $free_torps)
          $torps_buy = $free_torps;
        else
          $torps_buy = $source[torps];
        $free_torps -= $torps_buy;
        $playerinfo[torps] += $torps_buy;
        echo "$l_tdr_loaded " . NUMBER($torps_buy) . " $l_tdr_torps<br>";
      }
      else
        $torps_buy = 0;

      $free_fighters = NUM_FIGHTERS($playerinfo[computer]) - $playerinfo[ship_fighters];
      if($source[fighters] > 0 && $free_fighters > 0 && $playerinfo[trade_fighters] == 'Y')
      {
        if($source[fighters] > $free_fighters)
          $fighters_buy = $free_fighters;
        else
          $fighters_buy = $source[fighters];
        $free_fighters -= $fighters_buy;
        $playerinfo[ship_fighters] += $fighters_buy;
        echo "$l_tdr_loaded " . NUMBER($fighters_buy) . " $l_tdr_fighters<br>";
      }
      else
        $fighters_buy = 0;

      if($fighters_buy == 0 && $torps_buy == 0 && $colonists_buy == 0)
        echo "$l_tdr_nothingtoload<br>";

      if($traderoute[circuit] == '1')
        $db->Execute("UPDATE $dbtables[ships] SET torps=$playerinfo[torps], ship_fighters=$playerinfo[ship_fighters], ship_colonists=$playerinfo[ship_colonists] WHERE ship_id=$playerinfo[ship_id]");

      $db->Execute("UPDATE $dbtables[planets] SET colonists=colonists-$colonists_buy, torps=torps-$torps_buy, fighters=fighters-$fighters_buy WHERE planet_id=$source[planet_id]");
    }
  }

  if($dist[scooped1] != 0)
    echo "$l_tdr_scooped " . NUMBER($dist[scooped1]) . " $l_tdr_energy<br>";

  traderoute_results_close_cell();

  if($traderoute['circuit'] == '2')
  {
    $playerinfo['credits'] += $sourcecost;
    $destcost = 0;
    if($traderoute[dest_type] == 'P')
    {
            //added the below for traderoute bug - rjordan01
            $ore_buy = 0;
            $goods_buy = 0;
            $organics_buy = 0;
            $energy_buy = 0;

      //sells commodities
      $portfull = 0;
      if($dest[port_type] != 'ore')
      {
        $ore_price1 = $ore_price + $ore_delta * $dest[port_ore] / $ore_limit * $inventory_factor;
        if($dest[port_ore] - $playerinfo[ship_ore] < 0)
        {
          $ore_buy = $dest[port_ore];
          $portfull = 1;
        }
        else
          $ore_buy = $playerinfo[ship_ore];
        $destcost += $ore_buy * $ore_price1;
        if($ore_buy != 0)
        {
          if($portfull == 1)
            echo "$l_tdr_sold " . NUMBER($ore_buy) . " $l_tdr_ore ($l_tdr_portisfull)<br>";
          else
            echo "$l_tdr_sold " . NUMBER($ore_buy) . " $l_tdr_ore<br>";
        }
        $playerinfo[ship_ore] -= $ore_buy;
      }

      $portfull = 0;
      if($dest[port_type] != 'goods')
      {
        $goods_price1 = $goods_price + $goods_delta * $dest[port_goods] / $goods_limit * $inventory_factor;
        if($dest[port_goods] - $playerinfo[ship_goods] < 0)
        {
          $goods_buy = $dest[port_goods];
          $portfull = 1;
        }
        else
          $goods_buy = $playerinfo[ship_goods];
        $destcost += $goods_buy * $goods_price1;
        if($goods_buy != 0)
        {
          if($portfull == 1)
            echo "$l_tdr_sold " . NUMBER($goods_buy) . " $l_tdr_goods ($l_tdr_portisfull)<br>";
          else
            echo "$l_tdr_sold " . NUMBER($goods_buy) . " $l_tdr_goods<br>";
        }
        $playerinfo[ship_goods] -= $goods_buy;
      }

      $portfull = 0;
      if($dest[port_type] != 'organics')
      {
        $organics_price1 = $organics_price + $organics_delta * $dest[port_organics] / $organics_limit * $inventory_factor;
        if($dest[port_organics] - $playerinfo[ship_organics] < 0)
        {
          $organics_buy = $dest[port_organics];
          $portfull = 1;
        }
        else
          $organics_buy = $playerinfo[ship_organics];
        $destcost += $organics_buy * $organics_price1;
        if($organics_buy != 0)
        {
          if($portfull == 1)
            echo "$l_tdr_sold " . NUMBER($organics_buy) . " $l_tdr_organics ($l_tdr_portisfull)<br>";
          else
            echo "$l_tdr_sold " . NUMBER($organics_buy) . " $l_tdr_organics<br>";
        }
        $playerinfo[ship_organics] -= $organics_buy;
      }

      $portfull = 0;
      if($dest[port_type] != 'energy' && $playerinfo[trade_energy] == 'Y')
      {
        $energy_price1 = $energy_price + $energy_delta * $dest[port_energy] / $energy_limit * $inventory_factor;
        if($dest[port_energy] - $playerinfo[ship_energy] < 0)
        {
          $energy_buy = $dest[port_energy];
          $portfull = 1;
        }
        else
          $energy_buy = $playerinfo[ship_energy];
        $destcost += $energy_buy * $energy_price1;
        if($energy_buy != 0)
        {
          if($portfull == 1)
            echo "$l_tdr_sold " . NUMBER($energy_buy) . " $l_tdr_energy ($l_tdr_portisfull)<br>";
          else
            echo "$l_tdr_sold " . NUMBER($energy_buy) . " $l_tdr_energy<br>";
        }
        $playerinfo[ship_energy] -= $energy_buy;
      }
      else
        $energy_buy = 0;

      $free_holds = NUM_HOLDS($playerinfo[hull]) - $playerinfo[ship_ore] - $playerinfo[ship_organics] - $playerinfo[ship_goods] - $playerinfo[ship_colonists];

      //time to buy
      if($dest[port_type] == 'ore')
      {
        $ore_price1 = $ore_price - $ore_delta * $dest[port_ore] / $ore_limit * $inventory_factor;
        if($traderoute[source_type] == 'L')
          $ore_buy = 0;
        else
        {
          $ore_buy = $free_holds;
          if($playerinfo[credits] + $destcost < $ore_buy * $ore_price1)
          $ore_buy = ($playerinfo[credits] + $destcost) / $ore_price1;
          if($dest[port_ore] < $ore_buy)
          {
            $ore_buy = $dest[port_ore];
            if($dest[port_ore] == 0)
              echo "$l_tdr_bought " . NUMBER($ore_buy) . " $l_tdr_ore ($l_tdr_portisempty)<br>";
          }
          if($ore_buy != 0)
            echo "$l_tdr_bought " . NUMBER($ore_buy) . " $l_tdr_ore<br>";
          $playerinfo[ship_ore] += $ore_buy;
          $destcost -= $ore_buy * $ore_price1;
        }
        $db->Execute("UPDATE $dbtables[universe] SET port_ore=port_ore-$ore_buy, port_energy=port_energy-$energy_buy, port_goods=port_goods-$goods_buy, port_organics=port_organics-$organics_buy WHERE sector_id=$dest[sector_id]");
      }

      if($dest[port_type] == 'goods')
      {
        $goods_price1 = $goods_price - $goods_delta * $dest[port_goods] / $goods_limit * $inventory_factor;
        if($traderoute[source_type] == 'L')
          $goods_buy = 0;
        else
        {
          $goods_buy = $free_holds;
          if($playerinfo[credits] + $destcost < $goods_buy * $goods_price1)
            $goods_buy = ($playerinfo[credits] + $destcost) / $goods_price1;
          if($dest[port_goods] < $goods_buy)
          {
            $goods_buy = $dest[port_goods];
            if($dest[port_goods] == 0)
              echo "$l_tdr_bought " . NUMBER($goods_buy) . " $l_tdr_goods ($l_tdr_portisempty)<br>";
          }
          if($goods_buy != 0)
            echo "$l_tdr_bought " . NUMBER($goods_buy) . " $l_tdr_goods<br>";
          $playerinfo[ship_goods] += $goods_buy;
          $destcost -= $goods_buy * $goods_price1;
        }
        $db->Execute("UPDATE $dbtables[universe] SET port_ore=port_ore-$ore_buy, port_energy=port_energy-$energy_buy, port_goods=port_goods-$goods_buy, port_organics=port_organics-$organics_buy WHERE sector_id=$dest[sector_id]");
      }

      if($dest[port_type] == 'organics')
      {
        $organics_price1 = $organics_price - $organics_delta * $dest[port_organics] / $organics_limit * $inventory_factor;
        if($traderoute[source_type] == 'L')
          $organics_buy = 0;
        else
        {
          $organics_buy = $free_holds;
          if($playerinfo[credits] + $destcost < $organics_buy * $organics_price1)
            $organics_buy = ($playerinfo[credits] + $destcost) / $organics_price1;
          if($dest[port_organics] < $organics_buy)
          {
            $organics_buy = $dest[port_organics];
            if($dest[port_organics] == 0)
              echo "$l_tdr_bought " . NUMBER($organics_buy) . " $l_tdr_organics ($l_tdr_portisempty)<br>";
          }
          if($organics_buy != 0)
            echo "$l_tdr_bought " . NUMBER($organics_buy) . " $l_tdr_organics<br>";
          $playerinfo[ship_organics] += $organics_buy;
          $destcost -= $organics_buy * $organics_price1;
        }
        $db->Execute("UPDATE $dbtables[universe] SET port_ore=port_ore-$ore_buy, port_energy=port_energy-$energy_buy, port_goods=port_goods-$goods_buy, port_organics=port_organics-$organics_buy WHERE sector_id=$dest[sector_id]");
      }

      if($dest[port_type] == 'energy')
      {
        $energy_price1 = $energy_price - $energy_delta * $dest[port_energy] / $energy_limit * $inventory_factor;
        if($traderoute[source_type] == 'L')
          $energy_buy = 0;
        else
        {
          $energy_buy = NUM_ENERGY($playerinfo[power]) - $playerinfo[ship_energy] - $dist[scooped1];
          if($playerinfo[credits] + $destcost < $energy_buy * $energy_price1)
            $energy_buy = ($playerinfo[credits] + $destcost) / $energy_price1;
          if($dest[port_energy] < $energy_buy)
          {
            $energy_buy = $dest[port_energy];
            if($dest[port_energy] == 0)
              echo "$l_tdr_bought " . NUMBER($energy_buy) . " $l_tdr_energy ($l_tdr_portisempty)<br>";
          }
          if($energy_buy != 0)
            echo "$l_tdr_bought " . NUMBER($energy_buy) . " $l_tdr_energy<br>";
          $playerinfo[ship_energy] += $energy_buy;
          $destcost -= $energy_buy * $energy_price1;
        }

        if($ore_buy == 0 && $goods_buy == 0 && $energy_buy == 0 && $organics_buy == 0)
          echo "$l_tdr_nothingtotrade<br>";

        $db->Execute("UPDATE $dbtables[universe] SET port_ore=port_ore-$ore_buy, port_energy=port_energy-$energy_buy, port_goods=port_goods-$goods_buy, port_organics=port_organics-$organics_buy WHERE sector_id=$dest[sector_id]");
      }
      if($dist[scooped2] > 0)
      {
        $playerinfo[ship_energy]+= $dist[scooped2];
        if($playerinfo[ship_energy] > NUM_ENERGY($playerinfo[power]))
          $playerinfo[ship_energy] = NUM_ENERGY($playerinfo[power]);
      }
      $db->Execute("UPDATE $dbtables[ships] SET ship_ore=$playerinfo[ship_ore], ship_goods=$playerinfo[ship_goods], ship_organics=$playerinfo[ship_organics], ship_energy=$playerinfo[ship_energy] WHERE ship_id=$playerinfo[ship_id]");
    }
    else //dest is planet
    {
      if($traderoute[source_type] == 'L' || $traderoute[source_type] == 'C')
      {
        $colonists_buy=0;
        $fighters_buy=0;
        $torps_buy=0;
      }

      if($playerinfo[trade_colonists] == 'Y')
      {
        $colonists_buy += $playerinfo[ship_colonists];
        $col_dump = $playerinfo[ship_colonists];
        if($dest[colonists] + $colonists_buy >= $colonist_limit)
        {
          $exceeding = $dest[colonists] + $colonists_buy - $colonist_limit;
          $col_dump = $exceeding;
          $setcol = 1;
          $colonists_buy-=$exceeding;
          if($colonists_buy < 0)
            $colonists_buy = 0;
        }
      }
      else
        $col_dump = 0;

      if($colonists_buy != 0)
      {
        if($setcol ==1)
          echo "$l_tdr_dumped " . NUMBER($colonists_buy) . " $l_tdr_colonists ($l_tdr_planetisovercrowded)<br>";
        else
          echo "$l_tdr_dumped " . NUMBER($colonists_buy) . " $l_tdr_colonists<br>";
      }

      if($playerinfo[trade_fighters] == 'Y')
      {
        $fighters_buy += $playerinfo[ship_fighters];
        $fight_dump = $playerinfo[ship_fighters];
      }
      else
        $fight_dump = 0;

      if($fighters_buy != 0)
        echo "$l_tdr_dumped " . NUMBER($fighters_buy) . " $l_tdr_fighters<br>";

      if($playerinfo[trade_torps] == 'Y')
      {
        $torps_buy += $playerinfo[torps];
        $torps_dump = $playerinfo[torps];
      }
      else
        $torps_dump = 0;

      if($torps_buy != 0)
        echo "$l_tdr_dumped " . NUMBER($torps_buy) . " $l_tdr_torps<br>";

      if($torps_buy == 0 && $fighters_buy == 0 && $colonists_buy == 0 && $organics_buy == 0)
        echo "$l_tdr_nothingtodump<br>";

      if($traderoute[source_type] == 'L' || $traderoute[source_type] == 'C')
      {
        if($playerinfo[trade_colonists] == 'Y')
        {
          if($setcol != 1)
            $col_dump = 0;
        }
        else
          $col_dump = $playerinfo[ship_colonists];

        if($playerinfo[trade_fighters] == 'Y')
          $fight_dump = 0;
        else
          $fight_dump = $playerinfo[ship_fighters];

        if($playerinfo[trade_torps] == 'Y')
          $torps_dump = 0;
        else
          $torps_dump = $playerinfo[torps];
      }

      $db->Execute("UPDATE $dbtables[planets] SET colonists=colonists+$colonists_buy, fighters=fighters+$fighters_buy, torps=torps+$torps_buy WHERE planet_id=$traderoute[dest_id]");

      if($traderoute[source_type] == 'L' || $traderoute[source_type] == 'C')
      {
        $db->Execute("UPDATE $dbtables[ships] SET ship_colonists=$col_dump, ship_fighters=$fight_dump, torps=$torps_dump, ship_energy=ship_energy+$dist[scooped] WHERE ship_id=$playerinfo[ship_id]");
      }
      else
      {
        if($setcol == 1)
          $db->Execute("UPDATE $dbtables[ships] SET ship_colonists=$col_dump, ship_fighters=ship_fighters-$fight_dump, torps=torps-$torps_dump, ship_energy=ship_energy+$dist[scooped] WHERE ship_id=$playerinfo[ship_id]");
        else
          $db->Execute("UPDATE $dbtables[ships] SET ship_colonists=ship_colonists-$col_dump, ship_fighters=ship_fighters-$fight_dump, torps=torps-$torps_dump, ship_energy=ship_energy+$dist[scooped] WHERE ship_id=$playerinfo[ship_id]");
      }
    }
    if($dist[scooped2] != 0)
    {
      echo "$l_tdr_scooped " . NUMBER($dist[scooped1]) . " $l_tdr_energy<br>";
    }

  }
  else
  {
    echo $l_tdr_onlyonewaytdr;
    $destcost = 0;
  }
  traderoute_results_show_cost();

  if($sourcecost > 0)
    echo "$l_tdr_profit : " . NUMBER(abs($sourcecost));
  else
    echo "$l_tdr_cost : " . NUMBER(abs($sourcecost));
    traderoute_results_close_cost();

  if($destcost > 0)
    echo "$l_tdr_profit : " . NUMBER(abs($destcost));
  else
    echo "$l_tdr_cost : " . NUMBER(abs($destcost));
traderoute_results_close_table();


  $total_profit = $sourcecost + $destcost;

    traderoute_results_display_totals($total_profit);
    if($traderoute['circuit'] == '1')
    {
        $newsec = $destport[sector_id];
    }
    else
    {
        $newsec = $sourceport[sector_id];
    }
  $db->Execute("UPDATE $dbtables[ships] SET turns=turns-$dist[triptime], credits=credits+$total_profit, turns_used=turns_used+$dist[triptime], sector=$newsec WHERE ship_id=$playerinfo[ship_id]");
  $playerinfo[credits]+=$total_profit - $sourcecost;
  $playerinfo[turns]-=$dist[triptime];

$tdr_display_creds =   NUMBER($playerinfo['credits']);
  traderoute_results_display_summary($tdr_display_creds);
//echo $j." -- ";
// ===============
  if($traderoute['circuit'] == 2)
  {
    $l_tdr_engageagain = str_replace("[tdr_engage]", $engage, $l_tdr_engageagain);
    if($j == 1)
    {
       echo "$l_tdr_engageagain";
        traderoute_results_show_repeat();
    }
  }
// ===============
  if($j == 1)
     traderoute_die("");
}

function traderoute_results_table_top()
{
global $color_line2,$l_tdr_tdrres;
  echo "<table border='1' cellspacing='1' cellpadding='2' width='65%' align='center'>\n".
    "<tr bgcolor='".$color_line2."'>\n<td align='center' colspan='7'><b>\n<font color='white'>".$l_tdr_tdrres."</font></b>\n</td></tr>".
    "\n<tr align='center' bgcolor='".$color_line2."'>".
    "<td width='50%'><font size='2' color='#fff'><b>\n";

}
function traderoute_results_source()
{
   echo "</b></font></td>\n<td width='50%'><font size='2' color='white'><b>\n";
}
function traderoute_results_destination()
{
    global $color_line1;
    echo "</b></font></td></tr><tr bgcolor='".$color_line1."'>\n<td align='center'><font size='2' color='white'>\n";
}
function traderoute_results_close_cell()
{
   echo "</font></td><td align='center'><font size='2' color='white'>";
}
function traderoute_results_show_cost()
{
    global $color_line2;
    echo "</font></td></tr><tr bgcolor='".$color_line2."'><td align='center'><font size='2' color='white'>\n\n";
}
function traderoute_results_close_cost()
{
    echo "</font></td><td align='center'><font size='2' color='white'>\n\n";
}
function traderoute_results_close_table()
{
    echo "</font></td></tr>\n</table>\n<p><center><font size=3 color=white><b>\n";
}

function traderoute_results_display_totals($total_profit)
{
    global $l_tdr_totalprofit,$l_tdr_totalcost;
    if($total_profit > 0)
    {
        echo "$l_tdr_totalprofit : <font color='#00ff00'><b>" . NUMBER(abs($total_profit)) . "</font></b><br>\n";
    }
    else
    {
        echo "$l_tdr_totalcost : <font color='red'><b>" . NUMBER(abs($total_profit)) . "</font></b><br>\n";
    }
}
function traderoute_results_display_summary($tdr_display_creds)
{
  global  $l_tdr_turnsused , $dist, $l_tdr_turnsleft, $playerinfo,$l_tdr_credits;
  echo "\n<font size='3' color='white'><b>$l_tdr_turnsused : <font color='red'>$dist[triptime]</font></b><br>";
  echo "\n<font size='3' color='white'><b>$l_tdr_turnsleft : <font color='#00ff00'>$playerinfo[turns]</font></b><br><p>";

  echo "\n<font size='3' color='white'><b>$l_tdr_credits : <font color='#00ff00'> $tdr_display_creds\n</font></b><br><font size='2'>\n";

}
function traderoute_results_show_repeat()
{
    global $engage;
    echo "<FORM ACTION='traderoute.php?engage=".$engage."' METHOD='post'>" .
            "<BR>Enter times to repeat <INPUT TYPE='TEXT' NAME='tr_repeat' VALUE='1' SIZE='5'> <INPUT TYPE='SUBMIT' VALUE='SUBMIT'>";
    echo "<p>";
}
?>
