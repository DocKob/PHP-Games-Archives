<?
                    if (preg_match("/sector_fighters.php/i", $PHP_SELF)) {
                        echo "You can not access this file directly!";
                        die();
                    }
                    include("languages/$lang");

                    echo $l_sf_attacking;
                    $targetfighters = $total_sector_fighters;
     	            $playerbeams = NUM_BEAMS($playerinfo[beams]);
                    if($calledfrom == 'rsmove.php')
                    {
                       $playerinfo[ship_enery] += $energyscooped;
                    }
                    if($playerbeams>$playerinfo[ship_energy])
                    {
                       $playerbeams=$playerinfo[ship_energy];
                    }
                    $playerinfo[ship_energy]=$playerinfo[ship_energy]-$playerbeams;
                    $playershields = NUM_SHIELDS($playerinfo[shields]);
                    if($playershields>$playerinfo[ship_energy])
                    {  
                       $playershields=$playerinfo[ship_energy];
                    }
//                    $playerinfo[ship_energy]=$playerinfo[ship_energy]-$playershields;
                    $playertorpnum = round(mypw($level_factor,$playerinfo[torp_launchers]))*2;
                    if($playertorpnum > $playerinfo[torps])
                    { 
                       $playertorpnum = $playerinfo[torps];
                    }
                    $playertorpdmg = $torp_dmg_rate*$playertorpnum;
                    $playerarmor = $playerinfo[armor_pts];
                    $playerfighters = $playerinfo[ship_fighters];
                    if($targetfighters > 0 && $playerbeams > 0)
                    {
                       if($playerbeams > round($targetfighters / 2))
                       {
                          $temp = round($targetfighters/2);
                          $lost = $targetfighters-$temp;
                          $l_sf_destfight = str_replace("[lost]", $lost, $l_sf_destfight);
                          echo $l_sf_destfight;
                          $targetfighters = $temp;
                          $playerbeams = $playerbeams-$lost;
                       }
                       else
                       {
                          $targetfighters = $targetfighters-$playerbeams;
                          $l_sf_destfightb = str_replace("[lost]", $playerbeams, $l_sf_destfightb);
                          echo $l_sf_destfightb;
                          
                          $playerbeams = 0;
                       }   
                   }
                   echo "<BR>$l_sf_torphit<BR>";
                   if($targetfighters > 0 && $playertorpdmg > 0)
                   {
                      if($playertorpdmg > round($targetfighters / 2))
                      {
                         $temp=round($targetfighters/2);
                         $lost=$targetfighters-$temp;
                         $l_sf_destfightt = str_replace("[lost]", $lost, $l_sf_destfightt);
                         echo $l_sf_destfightt;
                         $targetfighters=$temp;
                         $playertorpdmg=$playertorpdmg-$lost;
                      }
                      else
                      {
                         $targetfighters=$targetfighters-$playertorpdmg;
                         $l_sf_destfightt = str_replace("[lost]", $playertorpdmg, $l_sf_destfightt);
                         echo $l_sf_destfightt;
                         $playertorpdmg=0;
                      }
                  }
                  echo "<BR>$l_sf_fighthit<BR>";
                  if($playerfighters > 0 && $targetfighters > 0)
                  {
                     if($playerfighters > $targetfighters)
                     {
                        echo $l_sf_destfightall;
                        $temptargfighters=0;
                     }
                     else
                     {
                        $l_sf_destfightt2 = str_replace("[lost]", $playerfighters, $l_sf_destfightt2);
                        echo $l_sf_destfightt2;
                        $temptargfighters=$targetfighters-$playerfighters;
                     }
                     if($targetfighters > $playerfighters)
                     {
                        echo $l_sf_lostfight;
                        $tempplayfighters=0;
                     }
                     else
                     {
                        $l_sf_lostfight2 = str_replace("[lost]", $targetfighters, $l_sf_lostfight2);
                        echo $l_sf_lostfight2;
                        $tempplayfighters=$playerfighters-$targetfighters;
                     }     
                     $playerfighters=$tempplayfighters;
                     $targetfighters=$temptargfighters;
                 }
                 if($targetfighters > 0)
                 {
                    if($targetfighters > $playerarmor)
                    {
                       $playerarmor=0;
                       echo $l_sf_armorbreach;
                    }
                    else
                    {
                       $playerarmor=$playerarmor-$targetfighters;
                       $l_sf_armorbreach2 = str_replace("[lost]", $targetfighters, $l_sf_armorbreach2);
                       echo $l_sf_armorbreach2;
                    } 
                 }
                 $fighterslost = $total_sector_fighters - $targetfighters;
                 destroy_fighters($sector,$fighterslost);

                 $l_sf_sendlog = str_replace("[player]", $playerinfo[character_name], $l_sf_sendlog);
                 $l_sf_sendlog = str_replace("[lost]", $fighterslost, $l_sf_sendlog);
                 $l_sf_sendlog = str_replace("[sector]", $sector, $l_sf_sendlog);
                 
                 message_defence_owner($sector,$l_sf_sendlog);
                 playerlog($playerinfo[ship_id], LOG_DEFS_DESTROYED_F, "$fighterslost|$sector");
                 $armor_lost=$playerinfo[armor_pts]-$playerarmor;
                 $fighters_lost=$playerinfo[ship_fighters]-$playerfighters;
                 $energy=$playerinfo[ship_energy];
                 $update4b = $db->Execute ("UPDATE $dbtables[ships] SET ship_energy=$energy,ship_fighters=ship_fighters-$fighters_lost, armor_pts=armor_pts-$armor_lost, torps=torps-$playertorpnum WHERE ship_id=$playerinfo[ship_id]");
                 $l_sf_lreport = str_replace("[armor]", $armor_lost, $l_sf_lreport);
                 $l_sf_lreport = str_replace("[fighters]", $fighters_lost, $l_sf_lreport);
                 $l_sf_lreport = str_replace("[torps]", $playertorpnum, $l_sf_lreport);
                 echo $l_sf_lreport;
                 if($playerarmor < 1)
                 {
                    echo $l_sf_shipdestroyed;
                    playerlog($playerinfo[ship_id], LOG_DEFS_KABOOM, "$sector|$playerinfo[dev_escapepod]");
                    $l_sf_sendlog2 = str_replace("[player]", $playerinfo[character_name], $l_sf_sendlog2);
                    $l_sf_sendlog2 = str_replace("[sector]", $sector, $l_sf_sendlog2);
                    message_defence_owner($sector,$l_sf_sendlog2);
                    if($playerinfo[dev_escapepod] == "Y")
                    {
                       $rating=round($playerinfo[rating]/2);
                       echo $l_sf_escape;
                       $db->Execute("UPDATE $dbtables[ships] SET hull=0,engines=0,power=0,sensors=0,computer=0,beams=0,torp_launchers=0,torps=0,armor=0,armor_pts=100,cloak=0,shields=0,sector=0,ship_organics=0,ship_ore=0,ship_goods=0,ship_energy=$start_energy,ship_colonists=0,ship_fighters=100,dev_warpedit=0,dev_genesis=0,dev_beacon=0,dev_emerwarp=0,dev_escapepod='N',dev_fuelscoop='N',dev_minedeflector=0,on_planet='N',rating='$rating',cleared_defences=' ',dev_lssd='N' WHERE ship_id=$playerinfo[ship_id]");
                       cancel_bounty($playerinfo[ship_id]);
                       $ok=0;
                       TEXT_GOTOMAIN();
                       die();

                    }
                    else
                    { 
                       cancel_bounty($playerinfo[ship_id]);
                       db_kill_player($playerinfo['ship_id']);
                       $ok=0;
                       TEXT_GOTOMAIN();
                       die();
                    }         
                 }
                 if($targetfighters > 0)
                    $ok=0;
                 else
                    $ok=2;
?>
