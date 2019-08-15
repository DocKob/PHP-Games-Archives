<?
include("config.php");
updatecookie();

include("languages/$lang");

$title=$l_planet2_title;
include("header.php");

connectdb();
if(checklogin())
{
  die();
}

//-------------------------------------------------------------------------------------------------

$result = $db->Execute("SELECT * FROM $dbtables[ships] WHERE email='$username'");
$playerinfo = $result->fields;

$result2 = $db->Execute("SELECT * FROM $dbtables[planets] WHERE planet_id=$planet_id");
if($result2)
  $planetinfo=$result2->fields;

bigtitle();

if($planetinfo[sector_id] <> $playerinfo[sector])
{
   echo "$l_planet2_sector<BR><BR>";
   TEXT_GOTOMAIN();
   die();
}

if($playerinfo[turns] < 1)
{
  echo "$l_planet2_noturn<BR><BR>";
}
else
{
  $free_holds = NUM_HOLDS($playerinfo[hull]) - $playerinfo[ship_ore] - $playerinfo[ship_organics] - $playerinfo[ship_goods] - $playerinfo[ship_colonists];
  $free_power = NUM_ENERGY($playerinfo[power]) - $playerinfo[ship_energy];
  $fighter_max = NUM_FIGHTERS($playerinfo[computer]) - $playerinfo[ship_fighters];
  $torpedo_max = NUM_TORPEDOES($playerinfo[torp_launchers]) - $playerinfo[torps];

  // first setup the tp flags
  if($tpore != -1)
  {
    $tpore = 1;
  }
  if($tporganics != -1)
  {
    $tporganics  = 1;
  }
  if($tpgoods != -1)
  {
    $tpgoods = 1;
  }
  if($tpenergy != -1)
  {
    $tpenergy = 1;
  }
  if($tpcolonists != -1)
  {
    $tpcolonists = 1;
  }
  if($tpcredits != -1)
  {
    $tpcredits = 1;
  }
  if($tptorps != -1)
  {
    $tptorps = 1;
  }
  if($tpfighters != -1)
  {
    $tpfighters = 1;
  }

  // now multiply all the transfer amounts by 1 to eliminate any trailing spaces
  $transfer_ore = $transfer_ore * 1;
  $transfer_organics = $transfer_organics * 1;
  $transfer_goods = $transfer_goods * 1;
  $transfer_energy = $transfer_energy * 1;
  $transfer_colonists = $transfer_colonists * 1;
  $transfer_credits = $transfer_credits * 1;
  $transfer_torps = $transfer_torps * 1;
  $transfer_fighters = $transfer_fighters * 1;



  if($allore==-1)
  {

     if ($tpore == -1)
     {
        $transfer_ore = $playerinfo['ship_ore'];
     }
     else
     {
        $transfer_ore = $planetinfo['ore'];
     }
  }
  if($allorganics==-1)
  {
     if ($tporganics==-1)
     {
        $transfer_organics = $playerinfo['ship_organics'];
     }
     else
     {
        $transfer_organics = $planetinfo['organics'];
     }

  }

  if($allgoods==-1)
  {
     if ($tpgoods==-1)
     {
        $transfer_goods = $playerinfo['ship_goods'];
     }
     else
     {
        $transfer_goods = $planetinfo['goods'];
     }

  }

  if($allenergy==-1)
  {
     if ($tpenergy==-1)
     {
        $transfer_energy = $playerinfo['ship_energy'];
     }
     else
     {
        $transfer_energy = $planetinfo['energy'];
     }

  }
  if($allcolonists==-1)
  {
     if ($tpcolonists==-1)
     {
        $transfer_colonists = $playerinfo['ship_colonists'];
     }
     else
     {
        $transfer_colonists = $planetinfo['colonists'];
     }

  }
  if($allcredits==-1)
  {
     if ($tpcredits==-1)
     {
        $transfer_credits = $playerinfo['credits'];
     }
     else
     {
        $transfer_credits = $planetinfo['credits'];
     }

  }
  if($alltorps==-1)
  {
     if ($tptorps==-1)
     {
        $transfer_torps = $playerinfo['torps'];
     }
     else
     {
        $transfer_torps = $planetinfo['torps'];
     }
  }
  if($allfighters==-1)
  {
     if ($tpfighters==-1)
     {
        $transfer_fighters = $playerinfo['ship_fighters'];
     }
     else
     {
        $transfer_fighters = $planetinfo['fighters'];
     }

  }


  // ok now get rid of all negative amounts so that all operations are expressed in terms of positive units
  if($transfer_ore < 0)
  {
    $transfer_ore = -1 * $transfer_ore;
    $tpore = -1 * $tpore;
  }

  if($transfer_organics < 0)
  {
    $transfer_organics = -1 * $transfer_organics;
    $tporganics = -1 * $tporganics;
  }

  if($transfer_goods < 0)
  {
    $transfer_goods = -1 * $transfer_goods;
    $tpgoods = -1 * $tpgoods;
  }

  if($transfer_energy < 0)
  {
    $transfer_energy = -1 * $transfer_energy;
    $tpenergy = -1 * $tpenergy;
  }

  if($transfer_colonists < 0)
  {
    $transfer_colonists = -1 * $transfer_colonistst;
    $tpcolonists = -1 * $tpcolonists;
  }

  if($transfer_credits < 0)
  {
    $transfer_credits = -1 * $transfer_credits;
    $tpcredits = -1 * $tpcredits;
  }

  if($transfer_torps < 0)
  {
    $transfer_torps = -1 * $transfer_torps;
    $tptorps = -1 * $tptorps;
  }

  if($transfer_fighters < 0)
  {
    $transfer_fighters = -1 * $transfer_fighters;
    $tpfighters = -1 * $tpfighters;
  }

  // now make sure that the source for each commodity transfer has sufficient numbers to fill the transfer
  if(($tpore == -1) && ($transfer_ore > $playerinfo['ship_ore']))
  {
    $transfer_ore = $playerinfo['ship_ore'];
    echo "$l_planet2_noten $l_ore. $l_planet2_settr $transfer_ore $l_units $l_ore.<BR>\n";
  }
  elseif(($tpore == 1) && ($transfer_ore > $planetinfo['ore']))
  {
    $transfer_ore = $planetinfo['ore'];
    echo "$l_planet2_losup $transfer_ore $l_units $l_ore.<BR>\n";
  }

  if(($tporganics == -1) && ($transfer_organics > $playerinfo['ship_organics']))
  {
    $transfer_organics = $playerinfo['ship_organics'];
    echo "$l_planet2_noten $l_organics. $l_planet2_settr $transfer_organics $l_units.<BR>\n";
  }
  elseif(($tporganics == 1) && ($transfer_organics > $planetinfo['organics']))
  {
    $transfer_organics = $planetinfo['organics'];
    echo "$l_planet2_losup $transfer_organics $l_units $l_organics.<BR>\n";
  }

  if(($tpgoods == -1) && ($transfer_goods > $playerinfo['ship_goods']))
  {
    $transfer_goods = $playerinfo['ship_goods'];
    echo "$l_planet2_noten $l_goods. $l_planet2_settr $transfer_goods $l_units.<BR>\n";
  }
  elseif(($tpgoods == 1) && ($transfer_goods > $planetinfo['goods']))
  {
    $transfer_goods = $planetinfo['goods'];
    echo "$l_planet2_losup $transfer_goods $l_units $l_goods.<BR>\n";
  }

  if(($tpenergy == -1) && ($transfer_energy > $playerinfo['ship_energy']))
  {
    $transfer_energy = $playerinfo['ship_energy'];
    echo "$l_planet2_noten $l_energy. $l_planet2_settr $transfer_energy $l_units.<BR>\n";
  }
  elseif(($tpenergy == 1) && ($transfer_energy > $planetinfo['energy']))
  {
    $transfer_energy = $planetinfo['energy'];
    echo "$l_planet2_losup $transfer_energy $l_units $l_energy.<BR>\n";
  }

  if(($tpcolonists == -1) && ($transfer_colonists > $playerinfo['ship_colonists']))
  {
    $transfer_colonists = $playerinfo['ship_colonists'];
    echo "$l_planet2_noten $l_colonists. $l_planet2_settr $transfer_colonists $l_colonists.<BR>\n";
  }
  elseif(($tpcolonists == 1) && ($transfer_colonists > $planetinfo['colonists']))
  {
    $transfer_colonists = $planetinfo['colonists'];
    echo "$l_planet2_losup $transfer_colonists $l_colonists.<BR>\n";
  }

  if(($tpcredits == -1) && ($transfer_credits > $playerinfo['credits']))
  {
    $transfer_credits = $playerinfo['credits'];
    echo "$l_planet2_noten $l_credits. $l_planet2_settr $transfer_credits $l_credits.<BR>\n";
  }
  elseif(($tpcredits == 1) && ($transfer_credits > $planetinfo['credits']))
  {
    $transfer_credits = $planetinfo['credits'];
    echo "$l_planet2_losup $transfer_credits $l_credits.<BR>\n";
  }

  if(($tpcredits == -1) && $planetinfo[base] == 'N' && ($transfer_credits + $planetinfo['credits'] > $max_credits_without_base))
  {
     $transfer_credits = MAX($max_credits_without_base - $planetinfo['credits'],0);
     echo "$l_planet2_baseexceeded $l_planet2_settr $transfer_credits $l_credits.<BR>\n";
  }

  if(($tptorps == -1) && ($transfer_torps > $playerinfo['torps']))
  {
    $transfer_torps = $playerinfo['torps'];
    echo "$l_planet2_noten $l_torps. $l_planet2_settr $transfer_torps $l_torps.<BR>\n";
  }
  elseif(($tptorps == 1) && ($transfer_torps > $planetinfo['torps']))
  {
    $transfer_torps = $planetinfo['torps'];
    echo "$l_planet2_losup $transfer_torps $l_torps.<BR>\n";
  }

  if(($tpfighters == -1) && ($transfer_fighters > $playerinfo['ship_fighters']))
  {
    $transfer_fighters = $playerinfo['ship_fighters'];
    echo "$l_planet2_noten $l_fighters. $l_planet2_settr $transfer_fighters $l_fighters.<BR>\n";
  }
  elseif(($tpfighters == 1) && ($transfer_fighters > $planetinfo['fighters']))
  {
    $transfer_fighters = $planetinfo['fighters'];
    echo "$l_planet2_losup $transfer_fighters $l_fighters.<BR>\n";
  }

  // Now that we have the amounts adjusted to suit available resources, go ahead and multiply them by their tpflag.
  $transfer_ore = $transfer_ore * $tpore;
  $transfer_organics = $transfer_organics * $tporganics;
  $transfer_goods = $transfer_goods * $tpgoods;
  $transfer_energy = $transfer_energy * $tpenergy;
  $transfer_colonists = $transfer_colonists * $tpcolonists;
  $transfer_credits = $transfer_credits * $tpcredits;
  $transfer_torps = $transfer_torps * $tptorps;
  $transfer_fighters = $transfer_fighters * $tpfighters;

  $total_holds_needed = $transfer_ore + $transfer_organics + $transfer_goods + $transfer_colonists;

  if($playerinfo[ship_id] != $planetinfo[owner] && $transfer_credits != 0 && $corp_planet_transfers != 1)
  {
    echo "$l_planet2_nocorptransfer<p>";
    echo "<A HREF=planet.php?planet_id=$planet_id>$l_clickme</A> $l_toplanetmenu<BR><BR>";
  }
  elseif($total_holds_needed > $free_holds)
  {
    echo "$l_planet2_noten $l_holds $l_planet2_fortr<BR><BR>";
    echo "<A HREF=planet.php?planet_id=$planet_id>$l_clickme</A> $l_toplanetmenu<BR><BR>";
  }
  else
  {
    if(!empty($planetinfo))
    {
      if($planetinfo[owner] == $playerinfo[ship_id] || ($planetinfo[corp] == $playerinfo[team] && $playerinfo[team] <> 0))
      {
        if($transfer_ore < 0 && $playerinfo[ship_ore] < abs($transfer_ore))
        {
          echo "$l_planet2_noten $l_ore $l_planet2_fortr<BR>";
          $transfer_ore = 0;
        }
        elseif($transfer_ore > 0 && $planetinfo[ore] < abs($transfer_ore))
        {
          echo "$l_planet2_noten $l_ore $l_planet2_fortr<BR>";
          $transfer_ore = 0;
        }
        if($transfer_organics < 0 && $playerinfo[ship_organics] < abs($transfer_organics))
        {
          echo "$l_planet2_noten $l_organics $l_planet2_fortr<BR>";
          $transfer_organics = 0;
        }
        elseif($transfer_organics > 0 && $planetinfo[organics] < abs($transfer_organics))
        {
          echo "$l_planet2_noten $l_organics $l_planet2_fortr<BR>";
          $transfer_organics = 0;
        }
        if($transfer_goods < 0 && $playerinfo[ship_goods] < abs($transfer_goods))
        {
          echo "$l_planet2_noten $l_goods $l_planet2_fortr<BR>";
          $transfer_goods = 0;
        }
        elseif($transfer_goods > 0 && $planetinfo[goods] < abs($transfer_goods))
        {
          echo "$l_planet2_noten $l_goods $l_planet2_fortr<BR>";
          $transfer_goods = 0;
        }
        if($transfer_energy < 0 && $playerinfo[ship_energy] < abs($transfer_energy))
        {
          echo "$l_planet2_noten $l_energy $l_planet2_fortr<BR>";
          $transfer_energy = 0;
        }
        elseif($transfer_energy > 0 && $planetinfo[energy] < abs($transfer_energy))
        {
          echo "$l_planet2_noten $l_energy $l_planet2_fortr<BR>";
          $transfer_energy = 0;
        }
        elseif($transfer_energy > 0 && abs($transfer_energy) > $free_power)
        {
          echo "$l_planet2_noten $l_planet2_power $l_planet2_fortr<BR>";
          $transfer_energy = 0;
        }
        if($transfer_colonists < 0 && $playerinfo[ship_colonists] < abs($transfer_colonists))
        {
          echo "$l_planet2_noten $l_colonists $l_planet2_fortr<BR>";
          $transfer_colonists = 0;
        }
        elseif($transfer_colonists > 0 && $planetinfo[colonists] < abs($transfer_colonists))
        {
          echo "$l_planet2_noten $l_colonists $l_planet2_fortr<BR>";
          $transfer_colonists = 0;
        }
        if($transfer_fighters < 0 && $playerinfo[ship_fighters] < abs($transfer_fighters))
        {
          echo "$l_planet2_noten $l_fighters $l_planet2_fortr<BR>";
          $transfer_fighters = 0;
        }
        elseif($transfer_fighters > 0 && $planetinfo[fighters] < abs($transfer_fighters))
        {
          echo "$l_planet2_noten $l_fighters $l_planet2_fortr<BR>";
          $transfer_fighters = 0;
        }
        elseif($transfer_fighters > 0 && abs($transfer_fighters) > $fighter_max)
        {
          echo "$l_planet2_noten $l_planet2_comp $l_planet2_fortr<BR>";
          $transfer_fighters = 0;
        }
        if($transfer_torps < 0 && $playerinfo[torps] < abs($transfer_torps))
        {
          echo "$l_planet2_noten $l_torpedoes $l_planet2_fortr<BR>";
          $transfer_torps = 0;
        }
        elseif($transfer_torps > 0 && $planetinfo[torps] < abs($transfer_torps))
        {
          echo "$l_planet2_noten $l_torpedoes $l_planet2_fortr<BR>";
          $transfer_torps = 0;
        }
        elseif($transfer_torps > 0 && abs($transfer_torps) > $torpedo_max)
        {
          echo "$l_planet2_noten $l_planet2_laun $l_planet2_fortr<BR>";
          $transfer_torps = 0;
        }
        if($transfer_credits < 0 && $playerinfo[credits] < abs($transfer_credits))
        {
          echo "$l_planet2_noten $l_credits $l_planet2_fortr<BR>";
          $transfer_credits = 0;
        }
        elseif($transfer_credits > 0 && $planetinfo[credits] < abs($transfer_credits))
        {
          echo "$l_planet2_noten $l_credits $l_planet2_fortr<BR>";
          $transfer_credits = 0;
        }
        $update1 = $db->Execute("UPDATE $dbtables[ships] SET ship_ore=ship_ore+$transfer_ore, ship_organics=ship_organics+$transfer_organics, ship_goods=ship_goods+$transfer_goods, ship_energy=ship_energy+$transfer_energy, ship_colonists=ship_colonists+$transfer_colonists, torps=torps+$transfer_torps, ship_fighters=ship_fighters+$transfer_fighters, credits=credits+$transfer_credits, turns=turns-1, turns_used=turns_used+1 WHERE ship_id=$playerinfo[ship_id]");
        $update2 = $db->Execute("UPDATE $dbtables[planets] SET ore=ore-$transfer_ore, organics=organics-$transfer_organics, goods=goods-$transfer_goods, energy=energy-$transfer_energy, colonists=colonists-$transfer_colonists, torps=torps-$transfer_torps, fighters=fighters-$transfer_fighters, credits=credits-$transfer_credits WHERE planet_id=$planet_id");
        echo "$l_planet2_compl<BR><a href=planet.php?planet_id=$planet_id>$l_clickme</a> $l_toplanetmenu<BR><BR>";
      }
      else
      {
        echo "$l_planet2_notowner<BR><BR>";
      }
    }
    else
    {
      echo "$l_planet_none<BR><BR>";
    }
  }
}


//-------------------------------------------------------------------------------------------------

TEXT_GOTOMAIN();

include("footer.php");

?>
