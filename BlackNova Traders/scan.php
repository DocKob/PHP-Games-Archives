<?

include("config.php");

updatecookie();

include("languages/$lang");
$title=$l_scan_title;
include("header.php");

connectdb();
if(checklogin())
{
  die();
}
$result = $db->Execute ("SELECT * FROM $dbtables[ships] WHERE email='$username'");
$playerinfo=$result->fields;

$result2 = $db->Execute ("SELECT * FROM $dbtables[ships] WHERE ship_id='$ship_id'");
$targetinfo=$result2->fields;

$playerscore = gen_score($playerinfo[ship_id]);
$targetscore = gen_score($targetinfo[ship_id]);

$playerscore = $playerscore * $playerscore;
$targetscore = $targetscore * $targetscore;

bigtitle();

srand((double)microtime()*1000000);

/* check to ensure target is in the same sector as player */
if($targetinfo[sector] != $playerinfo[sector])
{
  echo $l_planet_noscan;
}
else
{
  if($playerinfo[turns] < 1)
  {
    echo $l_scan_turn;
  }
  else
  {
    /* determine per cent chance of success in scanning target ship - based on player's sensors and opponent's cloak */
    $success= SCAN_SUCCESS($playerinfo[sensors], $targetinfo[cloak]);
    if($success < 5)
    {
      $success = 5;
    }
    if($success > 95)
    {
      $success = 95;
    }
    $roll = rand(1, 100);
    if($roll > $success)
    {
      /* if scan fails - inform both player and target. */
      echo $l_planet_noscan;
      playerlog($targetinfo[ship_id], LOG_SHIP_SCAN_FAIL, "$playerinfo[character_name]");
    }
    else
    {
      /* if scan succeeds, show results and inform target. */
      /* scramble results by scan error factor. */

      // Get total bounty on this player, if any
      $btyamount = 0;
      $hasbounty = $db->Execute("SELECT SUM(amount) AS btytotal FROM $dbtables[bounty] WHERE bounty_on = $targetinfo[ship_id]");

      if($hasbounty)
      {
         $resx = $hasbounty->fields;
         if($resx[btytotal] > 0) 
         {
            $btyamount = NUMBER($resx[btytotal]);
            $l_scan_bounty=str_replace("[amount]",$btyamount,$l_scan_bounty);
            echo $l_scan_bounty . "<BR>";
            $btyamount = 0;
            // Check for Federation bounty
            $hasfedbounty = $db->Execute("SELECT SUM(amount) AS btytotal FROM $dbtables[bounty] WHERE bounty_on = $targetinfo[ship_id] AND placed_by = 0");
            if($hasfedbounty)
            {
               $resy = $hasfedbounty->fields;
               if($resy[btytotal] > 0) 
               { 
                  $btyamount = $resy[btytotal];
                  echo $l_scan_fedbounty . "<BR>";
               }
            }
         }
      }
      // Player will get a Federation Bounty on themselves if they attack a player who's score is less than bounty_ratio of
      // themselves. If the target has a Federation Bounty, they can attack without attracting a bounty on themselves.
      if($btyamount == 0 && ((($targetscore / $playerscore) < $bounty_ratio) || $targetinfo[turns_used] < $bounty_minturns))
      {
         echo $l_by_fedbounty . "<BR><BR>";
      }
      else
      {
         echo $l_by_nofedbounty . "<BR><BR>";
      }
      $sc_error= SCAN_ERROR($playerinfo[sensors], $targetinfo[cloak]);
      echo "$l_scan_ron $targetinfo[ship_name], $l_scan_capt  $targetinfo[character_name]<BR><BR>";
      echo "<b>$l_ship_levels:</b><BR><BR>";
      echo "<table  width=\"\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">";
      echo "<tr><td>$l_hull:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
      {
        $sc_hull=round($targetinfo[hull] * $sc_error / 100);
        echo "<td>$sc_hull</td></tr>";
      }
      else {echo"<td>???</td></tr>";}
      echo "<tr><td>$l_engines:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
      {
        $sc_engines=round($targetinfo[engines] * $sc_error / 100);
        echo "<td>$sc_engines</td></tr>";
      }
      else {echo"<td>???</td></tr>";}
      echo "<tr><td>$l_power:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
      {
        $sc_power=round($targetinfo[power] * $sc_error / 100);
        echo "<td>$sc_power</td></tr>";
      }
      else {echo"<td>???</td></tr>";}
      echo "<tr><td>$l_computer:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
      {
        $sc_computer=round($targetinfo[computer] * $sc_error / 100);
        echo "<td>$sc_computer</td></tr>";
      }
      else {echo"<td>???</td></tr>";}
      echo "<tr><td>$l_sensors:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
      {
        $sc_sensors=round($targetinfo[sensors] * $sc_error / 100);
        echo "<td>$sc_sensors</td></tr>";
      }
      else {echo"<td>???</td></tr>";}
      echo "<tr><td>$l_beams:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
      {
        $sc_beams=round($targetinfo[beams] * $sc_error / 100);
        echo "<td>$sc_beams</td></tr>";
      }
      else {echo"<td>???</td></tr>";}
      echo "<tr><td>$l_torpedo Launchers:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
      {
        $sc_torp_launchers=round($targetinfo[torp_launchers] * $sc_error / 100);
        echo "<td>$sc_torp_launchers</td></tr>";
      }
      else {echo"<td>???</td></tr>";}
      echo "<tr><td>$l_armor:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
      {
        $sc_armor=round($targetinfo[armor] * $sc_error / 100);
        echo "<td>$sc_armor</td></tr>";
      }
      else {echo"<td>???</td></tr>";}
      echo "<tr><td>$l_shields:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
      {
        $sc_shields=round($targetinfo[shields] * $sc_error / 100);
        echo "<td>$sc_shields</td></tr>";
      }
      else {echo"<td>???</td></tr>";}
      echo "<tr><td>$l_cloak:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
      {
        $sc_cloak=round($targetinfo[cloak] * $sc_error / 100);
        echo "<td>$sc_cloak</td></tr>";
      }
      else {echo"<td>???</td></tr>";}
      echo "</table><BR>";
      echo "<b>$l_scan_arma</b><BR><BR>";
      echo "<table  width=\"\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">";
      echo "<tr><td>$l_armorpts:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
      {
        $sc_armor_pts=round($targetinfo[armor_pts] * $sc_error / 100);
        echo "<td>$sc_armor_pts</td></tr>";
      }
      else {echo"<td>???</td></tr>";}
      echo "<tr><td>$l_fighters:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
      {
        $sc_ship_fighters=round($targetinfo[ship_fighters] * $sc_error / 100);
        echo "<td>$sc_ship_fighters</td></tr>";
      }
      else {echo"<td>???</td></tr>";}
      echo "<tr><td>$l_torps:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
      {
        $sc_torps=round($targetinfo[torps] * $sc_error / 100);
        echo "<td>$sc_torps</td></tr>";
      }
      else {echo"<td>???</td></tr>";}
      echo "</table><BR>";
      echo "<b>$l_scan_carry</b><BR><BR>";
      echo "<table  width=\"\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">";
      echo "<tr><td>Credits:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
      {
        $sc_credits=round($targetinfo[credits] * $sc_error / 100);
        echo "<td>$sc_credits</td></tr>";
      }
      else {echo"<td>???</td></tr>";}
      echo "<tr><td>$l_colonists:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
      {
        $sc_ship_colonists=round($targetinfo[ship_colonists] * $sc_error / 100);
        echo "<td>$sc_ship_colonists</td></tr>";
      }
      else {echo"<td>???</td></tr>";}
      echo "<tr><td>$l_energy:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
      {
        $sc_ship_energy=round($targetinfo[ship_energy] * $sc_error / 100);
        echo "<td>$sc_ship_energy</td></tr>";
      }
      else {echo"<td>???</td></tr>";}
      echo "<tr><td>$l_ore:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
      {
        $sc_ship_ore=round($targetinfo[ship_ore] * $sc_error / 100);
        echo "<td>$sc_ship_ore</td></tr>";
      }
      else {echo"<td>???</td></tr>";}
      echo "<tr><td>$l_organics:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
      {
        $sc_ship_organics=round($targetinfo[ship_organics] * $sc_error / 100);
        echo "<td>$sc_ship_organics</td></tr>";
      }
      else {echo"<td>???</td></tr>";}
      echo "<tr><td>$l_goods:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
      {
        $sc_ship_goods=round($targetinfo[ship_goods] * $sc_error / 100);
        echo "<td>$sc_ship_goods</td></tr>";
      }
      else {echo"<td>???</td></tr>";}
      echo "</table><BR>";
      echo "<b>$l_devices:</b><BR><BR>";
      echo "<table  width=\"\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">";
      echo "<tr><td>$l_warpedit:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
      {
        $sc_dev_warpedit=round($targetinfo[dev_warpedit] * $sc_error / 100);
        echo "<td>$sc_dev_warpedit</td></tr>";
      }
      else {echo"<td>???</td></tr>";}
      echo "<tr><td>$l_genesis:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
      {
        $sc_dev_genesis=round($targetinfo[dev_genesis] * $sc_error / 100);
        echo "<td>$sc_dev_genesis</td></tr>";
      }
      else {echo"<td>???</td></tr>";}
      echo "<tr><td>$l_deflect:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
      {
        $sc_dev_minedeflector=round($targetinfo[dev_minedeflector] * $sc_error / 100);
        echo "<td>$sc_dev_minedeflector</td></tr>";
      }
      else {echo"<td>???</td></tr>";}
      echo "<tr><td>$l_ewd:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
      {
        $sc_dev_emerwarp=round($targetinfo[dev_emerwarp] * $sc_error / 100);
        echo "<td>$sc_dev_emerwarp</td></tr>";
      }
      else {echo"<td>???</td></tr>";}
      echo "<tr><td>$l_escape_pod:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
        {echo "<td>$targetinfo[dev_escapepod]</td></tr>";} else {echo"<td>???</td></tr>";}
      echo "<tr><td>$l_fuel_scoop:</td>";
      $roll=rand(1,100);
      if ($roll<$success)
        {echo "<td>$targetinfo[dev_fuelscoop]</td></tr>";} else {echo"<td>???</td></tr>";}
      echo "</table><BR>";
      playerlog($targetinfo[ship_id], LOG_SHIP_SCAN, "$playerinfo[character_name]");
    }

    $db->Execute("UPDATE $dbtables[ships] SET turns=turns-1,turns_used=turns_used+1 WHERE ship_id=$playerinfo[ship_id]");
  }
}


echo "<BR><BR>";
TEXT_GOTOMAIN();

include("footer.php");
?>
