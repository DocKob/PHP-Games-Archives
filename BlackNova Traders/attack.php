<?php
//$Id: attack.php 48 2006-01-19 03:15:53Z phpfixer $

include("config.php");
updatecookie();
include("languages/$lang");


connectdb();



$title=$l_att_title;
include("header.php");

if(checklogin())
{
  die();//shouldnt we redirect to login page or show the login notice here?
}
//-------------------------------------------------------------------------------------------------
 $db->Execute("LOCK TABLES $dbtables[ships] WRITE, $dbtables[universe] WRITE, $dbtables[bounty] WRITE $dbtables[zones] READ, $dbtables[planets] WRITE, $dbtables[news] WRITE, $dbtables[logs] WRITE");
$result = $db->Execute ("SELECT * FROM $dbtables[ships] WHERE email='$username'");
$playerinfo=$result->fields;

$ship_id = stripnum($ship_id);

$result2 = $db->Execute ("SELECT * FROM $dbtables[ships] WHERE ship_id='$ship_id'");
$targetinfo=$result2->fields;

bigtitle();

srand((double)microtime()*1000000);
$playerscore = gen_score($playerinfo['ship_id']);
//echo $playerscore;
$targetscore = gen_score($targetinfo['ship_id']);
//echo $targetscore;
$playerscore = $playerscore * $playerscore;
$targetscore = $targetscore * $targetscore;
/* check to ensure target is in the same sector as player */
if($targetinfo['sector'] != $playerinfo['sector'] || $targetinfo['on_planet'] == "Y")
{
  echo "$l_att_notarg<BR><BR>";
}
elseif($playerinfo['turns'] < 1)
{
  echo "$l_att_noturn<BR><BR>";
}
else
{
  /* determine percent chance of success in detecting target ship - based on player's sensors and opponent's cloak */
  $success = (10 - $targetinfo['cloak'] + $playerinfo['sensors']) * 5;
  if($success < 5)
  {
    $success = 5;
  }
  if($success > 95)
  {
    $success = 95;
  }
  $flee = (10 - $targetinfo['engines'] + $playerinfo['engines']) * 5;
  $roll = rand(1, 100);
  $roll2 = rand(1, 100);

  $res = $db->Execute("SELECT allow_attack,$dbtables[universe].zone_id FROM $dbtables[zones],$dbtables[universe] WHERE sector_id='$targetinfo[sector]' AND $dbtables[zones].zone_id=$dbtables[universe].zone_id");
  $zoneinfo = $res->fields;
  if($zoneinfo['allow_attack'] == 'N')
  {
    echo "$l_att_noatt<BR><BR>";
  }
  elseif($flee < $roll2)
  {
    echo "$l_att_flee<BR><BR>";
    $db->Execute("UPDATE $dbtables[ships] SET turns=turns-1,turns_used=turns_used+1 WHERE ship_id=$playerinfo[ship_id]");
    playerlog($targetinfo['ship_id'], LOG_ATTACK_OUTMAN, "$playerinfo[character_name]");
  }
  elseif($roll > $success)
  {
    /* if scan fails - inform both player and target. */
    echo "$l_planet_noscan<BR><BR>";
    $db->Execute("UPDATE $dbtables[ships] SET turns=turns-1,turns_used=turns_used+1 WHERE ship_id=$playerinfo[ship_id]");
    playerlog($targetinfo['ship_id'], LOG_ATTACK_OUTSCAN, "$playerinfo[character_name]");
  }
  else
  {
    /* if scan succeeds, show results and inform target. */
    $shipavg = $targetship['hull'] + $targetship['engines'] + $targetship['power'] + $targetship['computer'] + $targetship['sensors'] + $targetship['armor'] + $targetship['shields'] + $targetship['beams'] + $targetship['torp_launchers'] + $targetship['cloak'];
    $shipavg /= 10;
    if($shipavg > $ewd_maxhullsize)
    {
       $chance = ($shipavg - $ewd_maxhullsize) * 10;
    }
    else
    {
       $chance = 0;
    }
    $random_value = rand(1,100);
    if($targetinfo['dev_emerwarp'] > 0 && $random_value > $chance)
    {
      /* need to change warp destination to random sector in universe */
      $rating_change=round($targetinfo['rating']*.1);
      $dest_sector=rand(1,$sector_max);
      $db->Execute("UPDATE $dbtables[ships] SET turns=turns-1,turns_used=turns_used+1,rating=rating-$rating_change WHERE ship_id=$playerinfo[ship_id]");
      $l_att_ewdlog=str_replace("[name]",$playerinfo['character_name'],$l_att_ewdlog);
      $l_att_ewdlog=str_replace("[sector]",$playerinfo['sector'],$l_att_ewdlog);
      playerlog($targetinfo['ship_id'], LOG_ATTACK_EWD, "$playerinfo[character_name]");
      $result_warp = $db->Execute ("UPDATE $dbtables[ships] SET sector=$dest_sector, dev_emerwarp=dev_emerwarp-1,cleared_defences=' ' WHERE ship_id=$targetinfo[ship_id]");
      log_move($targetinfo['ship_id'],$dest_sector);
      echo "$l_att_ewd<BR><BR>";
    }
    else
    {
      if(($targetscore / $playerscore < $bounty_ratio || $targetinfo['turns_used'] < $bounty_minturns) && ( preg_match("/(\@xenobe)$/",$targetinfo['email']) !== false )) // bounty-free Xenobe attacking allowed.
      {
          //changed xen check to a regexp cause a player could put @xen or whatever in his email address
          // so (\@xenobe) is an exact match and the $ symbol means "this is the *end* of the string
          //so our custom @xenobe names will match, nothing else will
         // Check to see if there is Federation bounty on the player. If there is, people can attack regardless.
         $btyamount = 0;
         $hasbounty = $db->Execute("SELECT SUM(amount) AS btytotal FROM $dbtables[bounty] WHERE bounty_on = $targetinfo[ship_id] AND placed_by = 0");
         if($hasbounty)
         {
            $resx = $hasbounty->fields;
            $btyamount = $resx['btytotal'];
         }
         if($btyamount <= 0)
         {
            $bounty = ROUND($playerscore * $bounty_maxvalue);
            $insert = $db->Execute("INSERT INTO $dbtables[bounty] (bounty_on,placed_by,amount) values ($playerinfo[ship_id], 0 ,$bounty)");
            playerlog($playerinfo['ship_id'],LOG_BOUNTY_FEDBOUNTY,"$bounty");
            echo $l_by_fedbounty2 . "<BR><BR>";
         }
      }
      if($targetinfo['dev_emerwarp'] > 0)
      {
        playerlog($targetinfo['ship_id'], LOG_ATTACK_EWDFAIL, $playerinfo['character_name']);
      }
        $targetenergy = $targetinfo['ship_energy'];
        $playerenergy = $playerinfo['ship_energy'];
        //I added these two so we can have a value for debugging and reporting totals
        //if we use the variables in calcs below, change the display of stats too
      $targetbeams = NUM_BEAMS($targetinfo['beams']);
      if($targetbeams>$targetinfo['ship_energy'])
      {
        $targetbeams=$targetinfo['ship_energy'];
      }
      $targetinfo['ship_energy']=$targetinfo['ship_energy']-$targetbeams;
    //why dont we set targetinfo[ship_energy] to a variable instead?
      $playerbeams = NUM_BEAMS($playerinfo['beams']);
      if($playerbeams>$playerinfo['ship_energy'])
      {
        $playerbeams=$playerinfo['ship_energy'];
      }
      $playerinfo['ship_energy']=$playerinfo['ship_energy']-$playerbeams;
      $playershields = NUM_SHIELDS($playerinfo['shields']);
      if($playershields>$playerinfo['ship_energy'])
      {
        $playershields=$playerinfo['ship_energy'];
      }
      $playerinfo['ship_energy']=$playerinfo['ship_energy']-$playershields;
      $targetshields = NUM_SHIELDS($targetinfo['shields']);
      if($targetshields>$targetinfo['ship_energy'])
      {
        $targetshields=$targetinfo['ship_energy'];
      }
      $targetinfo['ship_energy']=$targetinfo['ship_energy']-$targetshields;

      $playertorpnum = round(mypw($level_factor,$playerinfo['torp_launchers']))*10;
      if($playertorpnum > $playerinfo['torps'])
      {
        $playertorpnum = $playerinfo['torps'];
      }
      $targettorpnum = round(mypw($level_factor,$targetinfo['torp_launchers']))*10;
      if($targettorpnum > $targetinfo['torps'])
      {
        $targettorpnum = $targetinfo['torps'];
      }
      $playertorpdmg = $torp_dmg_rate*$playertorpnum;
      $targettorpdmg = $torp_dmg_rate*$targettorpnum;
      $playerarmor = $playerinfo['armor_pts'];
      $targetarmor = $targetinfo['armor_pts'];
      $playerfighters = $playerinfo['ship_fighters'];
      $targetfighters = $targetinfo['ship_fighters'];
      $targetdestroyed = 0;
      $playerdestroyed = 0;
      echo "$l_att_att $targetinfo[character_name] $l_abord $targetinfo[ship_name]:<BR><BR>";
    echo "<table width='100%'><tr><th width='12%'>Player</th><th width='12%'>Beams(lvl)</th><th width='12%'>Shields(lvl)</th>
          <th width='12%'>Energy(Start)</th><th width='12%'>Torps(lvl)</th><th width='12%'>TorpDmg</th><th width='12%'>Fighters(lvl)</th><th width='12%'>Armor(lvl)</th></tr>";
    echo "<tr><td width='12%'>You</td><td width='12%'>$playerbeams($playerinfo[beams])</td><td width='12%'>$playershields($playerinfo[shields])</td><td width='12%'>$playerinfo[ship_energy]($playerenergy)</td>
          <td width='12%'>$playertorpnum($playerinfo[torp_launchers])</td><td width='12%'>$playertorpdmg</td><td width='12%'>$playerfighters</td><td width='12%'>$playerarmor($playerinfo[armor])</td></tr>";
    echo "<tr><td width='12%'>Target</td><td width='12%'>$targetbeams($targetinfo[beams])</td><td width='12%'>$targetshields($targetinfo[shields])</td><td width='12%'>$targetinfo[ship_energy]($targetenergy)</td>
          <td width='12%'>$targettorpnum($targetinfo[torp_launchers])</td><td width='12%'>$targettorpdmg</td><td width='12%'>$targetfighters</td><td width='12%'>$targetarmor($targetinfo[armor])</td></tr>";
    echo "</table><p>Does Target have Pod?: $targetinfo[dev_escapepod]<p>Does Attacker have Pod?: $playerinfo[dev_escapepod]<br>";
    echo "$l_att_beams<BR>";
      if($targetfighters > 0 && $playerbeams > 0)
      {
        if($playerbeams > round($targetfighters / 2))
        {
          $temp = round($targetfighters/2);
          $lost = $targetfighters-$temp;
          //maybe we should report on how many beams fired , etc for comparision/bugtracking
          echo "$targetinfo[character_name] $l_att_lost $lost $l_fighters<BR>";
          $targetfighters = $temp;
          $playerbeams = $playerbeams-$lost;
        }
        else
        {
          $targetfighters = $targetfighters-$playerbeams;
          echo "$targetinfo[character_name] $l_att_lost $playerbeams $l_fighters<BR>";
          $playerbeams = 0;
        }
      }
      if($playerfighters > 0 && $targetbeams > 0)
      {
        if($targetbeams > round($playerfighters / 2))
        {
          $temp=round($playerfighters/2);
          $lost=$playerfighters-$temp;
          echo "$l_att_ylost $lost $l_fighters<BR>";
          $playerfighters=$temp;
          $targetbeams=$targetbeams-$lost;
        }
        else
        {
          $playerfighters=$playerfighters-$targetbeams;
          echo "$l_att_ylost $targetbeams $l_fighters<BR>";
          $targetbeams=0;
        }
      }
      if($playerbeams > 0)
      {
        if($playerbeams > $targetshields)
        {
          $playerbeams=$playerbeams-$targetshields;
          $targetshields=0;
          echo "$targetinfo[character_name]". $l_att_sdown ."<BR>";
        }
        else
        {
          echo "$targetinfo[character_name]" . $l_att_shits ." $playerbeams $l_att_dmg.<BR>";
          $targetshields=$targetshields-$playerbeams;
          $playerbeams=0;
        }
      }
      if($targetbeams > 0)
      {
        if($targetbeams > $playershields)
        {
          $targetbeams=$targetbeams-$playershields;
          $playershields=0;
          echo "$l_att_ydown<BR>";
        }
        else
        {
          echo "$l_att_yhits $targetbeams $l_att_dmg.<BR>";
          $playershields=$playershields-$targetbeams;
          $targetbeams=0;
        }
      }
      if($playerbeams > 0)
      {
        if($playerbeams > $targetarmor)
        {
          $targetarmor=0;
          echo "$targetinfo[character_name] " .$l_att_sarm ."<BR>";
        }
        else
        {
          $targetarmor=$targetarmor-$playerbeams;
          echo "$targetinfo[character_name]". $l_att_ashit ." $playerbeams $l_att_dmg.<BR>";
        }
      }
      if($targetbeams > 0)
      {
        if($targetbeams > $playerarmor)
        {
          $playerarmor=0;
          echo "$l_att_yarm<BR>";
        }
        else
        {
          $playerarmor=$playerarmor-$targetbeams;
          echo "$l_att_ayhit $targetbeams $l_att_dmg.<BR>";
        }
      }
      echo "<BR>$l_att_torps<BR>";
      if($targetfighters > 0 && $playertorpdmg > 0)
      {
        if($playertorpdmg > round($targetfighters / 2))
        {
          $temp=round($targetfighters/2);
          $lost=$targetfighters-$temp;
          echo "$targetinfo[character_name] $l_att_lost $lost $l_fighters<BR>";
          $targetfighters=$temp;
          $playertorpdmg=$playertorpdmg-$lost;
        }
        else
        {
          $targetfighters=$targetfighters-$playertorpdmg;
          echo "$targetinfo[character_name] $l_att_lost $playertorpdmg $l_fighters<BR>";
          $playertorpdmg=0;
        }
      }
      if($playerfighters > 0 && $targettorpdmg > 0)
      {
        if($targettorpdmg > round($playerfighters / 2))
        {
          $temp=round($playerfighters/2);
          $lost=$playerfighters-$temp;
          echo "$l_att_ylost $lost $l_fighters<BR>";
          echo "$temp - $playerfighters - $targettorpdmg";
          $playerfighters=$temp;
          $targettorpdmg=$targettorpdmg-$lost;
        }
        else
        {
          $playerfighters=$playerfighters-$targettorpdmg;
          echo "$l_att_ylost $targettorpdmg $l_fighters<BR>";
          $targettorpdmg=0;
        }
      }
      if($playertorpdmg > 0)
      {
        if($playertorpdmg > $targetarmor)
        {
          $targetarmor=0;
          echo "$targetinfo[character_name]" . $l_att_sarm ."<BR>";
        }
        else
        {
          $targetarmor=$targetarmor-$playertorpdmg;
          echo "$targetinfo[character_name]" . $l_att_ashit . " $playertorpdmg $l_att_dmg.<BR>";
        }
      }
      if($targettorpdmg > 0)
      {
        if($targettorpdmg > $playerarmor)
        {
          $playerarmor=0;
          echo "$l_att_yarm<BR>";
        }
        else
        {
          $playerarmor=$playerarmor-$targettorpdmg;
          echo "$l_att_ayhit $targettorpdmg $l_att_dmg.<BR>";
        }
      }
      echo "<BR>$l_att_fighters<BR>";
      if($playerfighters > 0 && $targetfighters > 0)
      {
        if($playerfighters > $targetfighters)
        {
          echo "$targetinfo[character_name] $l_att_lostf<BR>";
          $temptargfighters=0;
        }
        else
        {
          echo "$targetinfo[character_name] $l_att_lost $playerfighters $l_fighters.<BR>";
          $temptargfighters=$targetfighters-$playerfighters;
        }
        if($targetfighters > $playerfighters)
        {
          echo "$l_att_ylostf<BR>";
          $tempplayfighters=0;
        }
        else
        {
          echo "$l_att_ylost $targetfighters $l_fighters.<BR>";
          $tempplayfighters=$playerfighters-$targetfighters;
        }
        $playerfighters=$tempplayfighters;
        $targetfighters=$temptargfighters;
      }
      if($playerfighters > 0)
      {
        if($playerfighters > $targetarmor)
        {
          $targetarmor=0;
          echo "$targetinfo[character_name]". $l_att_sarm . "<BR>";
        }
        else
        {
          $targetarmor=$targetarmor-$playerfighters;
          echo "$targetinfo[character_name]" . $l_att_ashit ." $playerfighters $l_att_dmg.<BR>";
        }
      }
      if($targetfighters > 0)
      {
        if($targetfighters > $playerarmor)
        {
          $playerarmor=0;
          echo "$l_att_yarm<BR>";
        }
        else
        {
          $playerarmor=$playerarmor-$targetfighters;
          echo "$l_att_ayhit $targetfighters $l_att_dmg.<BR>";
        }
      }
      if($targetarmor < 1)
      {
        echo "<BR>$targetinfo[character_name]". $l_att_sdest ."<BR>";
        if($targetinfo['dev_escapepod'] == "Y")
        {
          $rating=round($targetinfo['rating']/2);
          echo "$l_att_espod<BR><BR>";
          $db->Execute("UPDATE $dbtables[ships] SET hull=0,engines=0,power=0,sensors=0,computer=0,beams=0,torp_launchers=0,torps=0,armor=0,armor_pts=100,cloak=0,shields=0,sector=0,ship_organics=0,ship_ore=0,ship_goods=0,ship_energy=$start_energy,ship_colonists=0,ship_fighters=100,dev_warpedit=0,dev_genesis=0,dev_beacon=0,dev_emerwarp=0,dev_escapepod='N',dev_fuelscoop='N',dev_minedeflector=0,on_planet='N',rating='$rating',cleared_defences=' ',dev_lssd='N' WHERE ship_id=$targetinfo[ship_id]");
          playerlog($targetinfo['ship_id'], LOG_ATTACK_LOSE, "$playerinfo[character_name]|Y");
          collect_bounty($playerinfo['ship_id'],$targetinfo['ship_id']);
        }
        else
        {
          playerlog($targetinfo['ship_id'], LOG_ATTACK_LOSE, "$playerinfo[character_name]|N");
          db_kill_player($targetinfo['ship_id']);
          collect_bounty($playerinfo['ship_id'],$targetinfo['ship_id']);
        }

        if($playerarmor > 0)
        {
          $rating_change=round($targetinfo['rating']*$rating_combat_factor);
            //Updating to always get a positive rating increase for xenobe and the credits they are carrying - rjordan
            $salv_credits = 0;

            if ( preg_match("/(\@xenobe)$/",$targetinfo['email']) !== false )                       //*** He's a Xenobe ***
            {
             $db->Execute("UPDATE $dbtables[xenobe] SET active= N WHERE xenobe_id=$targetinfo[email]");

             if ($rating_change > 0)
             {
            $rating_change = 0 - $rating_change;
          playerlog($targetinfo['ship_id'], LOG_ATTACK_LOSE, "$playerinfo[character_name]|N");
          collect_bounty($playerinfo['ship_id'],$targetinfo['ship_id']);
          db_kill_player($targetinfo['ship_id']);

             }
             $salv_credits = $targetinfo['credits'];
            }

          $free_ore = round($targetinfo['ship_ore']/2);
          $free_organics = round($targetinfo['ship_organics']/2);
          $free_goods = round($targetinfo['ship_goods']/2);
          $free_holds = NUM_HOLDS($playerinfo['hull']) - $playerinfo['ship_ore'] - $playerinfo['ship_organics'] - $playerinfo['ship_goods'] - $playerinfo['ship_colonists'];
          if($free_holds > $free_goods)
          {
            $salv_goods=$free_goods;
            $free_holds=$free_holds-$free_goods;
          }
          elseif($free_holds > 0)
          {
            $salv_goods=$free_holds;
            $free_holds=0;
          }
          else
          {
            $salv_goods=0;
          }
          if($free_holds > $free_ore)
          {
            $salv_ore=$free_ore;
            $free_holds=$free_holds-$free_ore;
          }
          elseif($free_holds > 0)
          {
            $salv_ore=$free_holds;
            $free_holds=0;
          }
          else
          {
            $salv_ore=0;
          }
          if($free_holds > $free_organics)
          {
            $salv_organics=$free_organics;
            $free_holds=$free_holds-$free_organics;
          }
          elseif($free_holds > 0)
          {
            $salv_organics=$free_holds;
            $free_holds=0;
          }
          else
          {
            $salv_organics=0;
          }
          $ship_value=$upgrade_cost*(round(mypw($upgrade_factor, $targetinfo['hull']))+round(mypw($upgrade_factor, $targetinfo['engines']))+round(mypw($upgrade_factor, $targetinfo['power']))+round(mypw($upgrade_factor, $targetinfo['computer']))+round(mypw($upgrade_factor, $targetinfo['sensors']))+round(mypw($upgrade_factor, $targetinfo['beams']))+round(mypw($upgrade_factor, $targetinfo['torp_launchers']))+round(mypw($upgrade_factor, $targetinfo['shields']))+round(mypw($upgrade_factor, $targetinfo['armor']))+round(mypw($upgrade_factor, $targetinfo['cloak'])));
          $ship_salvage_rate=rand(10,20);
          $ship_salvage=$ship_value*$ship_salvage_rate/100+$salv_credits;  //added credits for xenobe - 0 if normal player - GunSlinger

          $l_att_ysalv=str_replace("[salv_ore]",$salv_ore,$l_att_ysalv);
          $l_att_ysalv=str_replace("[salv_organics]",$salv_organics,$l_att_ysalv);
          $l_att_ysalv=str_replace("[salv_goods]",$salv_goods,$l_att_ysalv);
          $l_att_ysalv=str_replace("[ship_salvage_rate]",$ship_salvage_rate,$l_att_ysalv);
          $l_att_ysalv=str_replace("[ship_salvage]",$ship_salvage,$l_att_ysalv);
          $l_att_ysalv=str_replace("[rating_change]",NUMBER(abs($rating_change)),$l_att_ysalv);

          echo $l_att_ysalv;
          $update3 = $db->Execute ("UPDATE $dbtables[ships] SET ship_ore=ship_ore+$salv_ore, ship_organics=ship_organics+$salv_organics, ship_goods=ship_goods+$salv_goods, credits=credits+$ship_salvage WHERE ship_id=$playerinfo[ship_id]");
          $armor_lost=$playerinfo['armor_pts']-$playerarmor;
          $fighters_lost=$playerinfo['ship_fighters']-$playerfighters;
          $energy=$playerinfo['ship_energy'];
          $update3b = $db->Execute ("UPDATE $dbtables[ships] SET ship_energy=$energy,ship_fighters=ship_fighters-$fighters_lost, armor_pts=armor_pts-$armor_lost, torps=torps-$playertorpnum, turns=turns-1, turns_used=turns_used+1, rating=rating-$rating_change WHERE ship_id=$playerinfo[ship_id]");
          echo "$l_att_ylost $armor_lost $l_armorpts, $fighters_lost $l_fighters, $l_att_andused $playertorpnum $l_torps.<BR><BR>";
        }
      }
      else
      {
       $l_att_stilship=str_replace("[name]",$targetinfo['character_name'],$l_att_stilship);
        echo "$l_att_stilship<BR>";
        $rating_change=round($targetinfo['rating']*.1);
        $armor_lost=$targetinfo['armor_pts']-$targetarmor;
        $fighters_lost=$targetinfo['ship_fighters']-$targetfighters;
        $energy=$targetinfo['ship_energy'];
        playerlog($targetinfo['ship_id'], LOG_ATTACKED_WIN, "$playerinfo[character_name]|$armor_lost|$fighters_lost");
        $update4 = $db->Execute ("UPDATE $dbtables[ships] SET ship_energy=$energy,ship_fighters=ship_fighters-$fighters_lost, armor_pts=armor_pts-$armor_lost, torps=torps-$targettorpnum WHERE ship_id=$targetinfo[ship_id]");
        $armor_lost=$playerinfo['armor_pts']-$playerarmor;
        $fighters_lost=$playerinfo['ship_fighters']-$playerfighters;
        $energy=$playerinfo['ship_energy'];
        $update4b = $db->Execute ("UPDATE $dbtables[ships] SET ship_energy=$energy,ship_fighters=ship_fighters-$fighters_lost, armor_pts=armor_pts-$armor_lost, torps=torps-$playertorpnum, turns=turns-1, turns_used=turns_used+1, rating=rating-$rating_change WHERE ship_id=$playerinfo[ship_id]");
        echo "$l_att_ylost $armor_lost $l_armorpts, $fighters_lost $l_fighters, $l_att_andused $playertorpnum $l_torps.<BR><BR>";
      }
      if($playerarmor < 1)
      {
        echo "$l_att_yshiplost<BR><BR>";
        if($playerinfo['dev_escapepod'] == "Y")
        {
          $rating=round($playerinfo['rating']/2);
          echo "$l_att_loosepod<BR><BR>";
          $db->Execute("UPDATE $dbtables[ships] SET hull=0,engines=0,power=0,sensors=0,computer=0,beams=0,torp_launchers=0,torps=0,armor=0,armor_pts=100,cloak=0,shields=0,sector=0,ship_organics=0,ship_ore=0,ship_goods=0,ship_energy=$start_energy,ship_colonists=0,ship_fighters=100,dev_warpedit=0,dev_genesis=0,dev_beacon=0,dev_emerwarp=0,dev_escapepod='N',dev_fuelscoop='N',dev_minedeflector=0,on_planet='N',rating='$rating',dev_lssd='N' WHERE ship_id=$playerinfo[ship_id]");
          collect_bounty($targetinfo[ship_id],$playerinfo[ship_id]);
        }
        else
        {
          echo "Didnt have pod?! $playerinfo[dev_escapepod]<br>";
          db_kill_player($playerinfo['ship_id']);
          collect_bounty($targetinfo[ship_id],$playerinfo[ship_id]);
        }
        if($targetarmor > 0)
        {
          $free_ore = round($playerinfo[ship_ore]/2);
          $free_organics = round($playerinfo[ship_organics]/2);
          $free_goods = round($playerinfo[ship_goods]/2);
          $free_holds = NUM_HOLDS($targetinfo[hull]) - $targetinfo[ship_ore] - $targetinfo[ship_organics] - $targetinfo[ship_goods] - $targetinfo[ship_colonists];
          if($free_holds > $free_goods)
          {
            $salv_goods=$free_goods;
            $free_holds=$free_holds-$free_goods;
          }
          elseif($free_holds > 0)
          {
            $salv_goods=$free_holds;
            $free_holds=0;
          }
          else
          {
            $salv_goods=0;
          }
          if($free_holds > $free_ore)
          {
            $salv_ore=$free_ore;
            $free_holds=$free_holds-$free_ore;
          }
          elseif($free_holds > 0)
          {
            $salv_ore=$free_holds;
            $free_holds=0;
          }
          else
          {
            $salv_ore=0;
          }
          if($free_holds > $free_organics)
          {
            $salv_organics=$free_organics;
            $free_holds=$free_holds-$free_organics;
          }
          elseif($free_holds > 0)
          {
            $salv_organics=$free_holds;
            $free_holds=0;
          }
          else
          {
            $salv_organics=0;
          }
          $ship_value=$upgrade_cost*(round(mypw($upgrade_factor, $playerinfo[hull]))+round(mypw($upgrade_factor, $playerinfo[engines]))+round(mypw($upgrade_factor, $playerinfo[power]))+round(mypw($upgrade_factor, $playerinfo[computer]))+round(mypw($upgrade_factor, $playerinfo[sensors]))+round(mypw($upgrade_factor, $playerinfo[beams]))+round(mypw($upgrade_factor, $playerinfo[torp_launchers]))+round(mypw($upgrade_factor, $playerinfo[shields]))+round(mypw($upgrade_factor, $playerinfo[armor]))+round(mypw($upgrade_factor, $playerinfo[cloak])));
          $ship_salvage_rate=rand(10,20);
          $ship_salvage=$ship_value*$ship_salvage_rate/100+$salv_credits;  //added credits for xenobe - 0 if normal player - GunSlinger

          $l_att_salv=str_replace("[salv_ore]",$salv_ore,$l_att_salv);
          $l_att_salv=str_replace("[salv_organics]",$salv_organics,$l_att_salv);
          $l_att_salv=str_replace("[salv_goods]",$salv_goods,$l_att_salv);
          $l_att_salv=str_replace("[ship_salvage_rate]",$ship_salvage_rate,$l_att_salv);
          $l_att_salv=str_replace("[ship_salvage]",$ship_salvage,$l_att_salv);
          $l_att_salv=str_replace("[name]",$targetinfo[character_name],$l_att_salv);

          echo "$l_att_salv<BR>";
          $update6 = $db->Execute ("UPDATE $dbtables[ships] SET credits=credits+$ship_salvage, ship_ore=ship_ore+$salv_ore, ship_organics=ship_organics+$salv_organics, ship_goods=ship_goods+$salv_goods WHERE ship_id=$targetinfo[ship_id]");
          $armor_lost=$targetinfo[armor_pts]-$targetarmor;
          $fighters_lost=$targetinfo[ship_fighters]-$targetfighters;
          $energy=$targetinfo[ship_energy];
          $update6b = $db->Execute ("UPDATE $dbtables[ships] SET ship_energy=$energy,ship_fighters=ship_fighters-$fighters_lost, armor_pts=armor_pts-$armor_lost, torps=torps-$targettorpnum WHERE ship_id=$targetinfo[ship_id]");
        }
      }
    }
  }
}
$db->Execute("UNLOCK TABLES");
//-------------------------------------------------------------------------------------------------

TEXT_GOTOMAIN();

include("footer.php");

?>
