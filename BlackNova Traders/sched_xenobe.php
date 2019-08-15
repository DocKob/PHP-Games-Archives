<?

  if (preg_match("/sched_xenobe.php/i", $PHP_SELF)) {
      echo "You can not access this file directly!";
      die();
  }

  // *********************************
  // ***** Xenobe TURN UPDATES *****
  // *********************************
  echo "<BR><B>Xenobe TURNS</B><BR><BR>";

  // *********************************
  // ******* INCLUDE FUNCTIONS *******
  // *********************************
  include_once("xenobe_funcs.php");
  include_once("languages/$lang");
  global $targetlink;
  global $xenobeisdead;

  // *********************************
  // **** MAKE Xenobe SELECTION ****
  // *********************************
  $xencount = $xencount0 = $xencount0a = $xencount1 = $xencount1a = $xencount2 = $xencount2a = $xencount3 = $xencount3a = $xencount3h = 0;
  $res = $db->Execute("SELECT * FROM $dbtables[ships] JOIN $dbtables[xenobe] WHERE email=xenobe_id and active='Y' and ship_destroyed='N' ORDER BY sector");
  while(!$res->EOF)
  {
    $xenobeisdead = 0;
    $playerinfo = $res->fields;
    // *********************************
    // ****** REGENERATE/BUY STATS *****
    // *********************************
    xenoberegen();
    // *********************************
    // ****** RUN THROUGH ORDERS *******
    // *********************************
    $xencount++;
    if (rand(1,5) > 1)                                 // ****** 20% CHANCE OF NOT MOVING AT ALL ******
    {
      // *********************************
      // ****** ORDERS = 0 SENTINEL ******
      // *********************************
      if ($playerinfo[orders] == 0)
      {
        $xencount0++;
        // ****** FIND A TARGET ******
        // ****** IN MY SECTOR, NOT MYSELF, NOT ON A PLANET ******
        $reso0 = $db->Execute("SELECT * FROM $dbtables[ships] WHERE sector=$playerinfo[sector] and email NOT LIKE '%@xenobe' and planet_id=0 and ship_id > 1");
        if (!$reso0->EOF)
        {
          $rowo0 = $reso0->fields;
          if ($playerinfo[aggression] == 0)            // ****** O = 0 & AGRESSION = 0 PEACEFUL ******
          {
            // This Guy Does Nothing But Sit As A Target Himself
          }
          elseif ($playerinfo[aggression] == 1)        // ****** O = 0 & AGRESSION = 1 ATTACK SOMETIMES ******
          {
            // Xenobe's only compare number of fighters when determining if they have an attack advantage
            if ($playerinfo[ship_fighters] > $rowo0[ship_fighters])
            {
              $xencount0a++;
              playerlog($playerinfo[ship_id], LOG_Xenobe_ATTACK, "$rowo0[character_name]");
              xenobetoship($rowo0[ship_id]);
              if ($xenobeisdead>0) {
                $res->MoveNext();
                continue;
              }
            }
          }
          elseif ($playerinfo[aggression] == 2)        // ****** O = 0 & AGRESSION = 2 ATTACK ALLWAYS ******
          {
            $xencount0a++;
            playerlog($playerinfo[ship_id], LOG_Xenobe_ATTACK, "$rowo0[character_name]");
            xenobetoship($rowo0[ship_id]);
            if ($xenobeisdead>0) {
              $res->MoveNext();
              continue;
            }
          }
        }
      }
      // *********************************
      // ******** ORDERS = 1 ROAM ********
      // *********************************
      elseif ($playerinfo[orders] == 1)
      {
        $xencount1++;
        // ****** ROAM TO A NEW SECTOR BEFORE DOING ANYTHING ELSE ******
        $targetlink = $playerinfo[sector];
        xenobemove();
        if ($xenobeisdead>0) {
          $res->MoveNext();
          continue;
        }
        // ****** FIND A TARGET ******
        // ****** IN MY SECTOR, NOT MYSELF ******
        $reso1 = $db->Execute("SELECT * FROM $dbtables[ships] WHERE sector=$targetlink and email NOT LIKE '%@xenobe' and ship_id > 1");
        if (!$reso1->EOF)
        {
          $rowo1= $reso1->fields;
          if ($playerinfo[aggression] == 0)            // ****** O = 1 & AGRESSION = 0 PEACEFUL ******
          {


            // This Guy Does Nothing But Roam Around As A Target Himself
          }
          elseif ($playerinfo[aggression] == 1)        // ****** O = 1 & AGRESSION = 1 ATTACK SOMETIMES ******
          {
            // Xenobe's only compare number of fighters when determining if they have an attack advantage
            if ($playerinfo[ship_fighters] > $rowo1[ship_fighters] && $rowo1[planet_id] == 0)
            {
              $xencount1a++;
              playerlog($playerinfo[ship_id], LOG_Xenobe_ATTACK, "$rowo1[character_name]");
              xenobetoship($rowo1[ship_id]);
              if ($xenobeisdead>0) {
                $res->MoveNext();
                continue;
              }
            }
          }
          elseif ($playerinfo[aggression] == 2)        // ****** O = 1 & AGRESSION = 2 ATTACK ALLWAYS ******
          {
            $xencount1a++;
            playerlog($playerinfo[ship_id], LOG_Xenobe_ATTACK, "$rowo1[character_name]");
            if (!$rowo1[planet_id] == 0) {              // *** IS ON PLANET ***
              xenobetoplanet($rowo1[planet_id]);
            } else {
              xenobetoship($rowo1[ship_id]);
            }
            if ($xenobeisdead>0) {
              $res->MoveNext();
              continue;
            }
          }
        }
      }
      // *********************************
      // *** ORDERS = 2 ROAM AND TRADE ***
      // *********************************
      elseif ($playerinfo[orders] == 2)
      {
        $xencount2++;
        // ****** ROAM TO A NEW SECTOR BEFORE DOING ANYTHING ELSE ******
        $targetlink = $playerinfo[sector];
        xenobemove();
        if ($xenobeisdead>0) {
          $res->MoveNext();
          continue;
        }
        // ****** NOW TRADE BEFORE WE DO ANY AGGRESSION CHECKS ******
        xenobetrade();
        // ****** FIND A TARGET ******
        // ****** IN MY SECTOR, NOT MYSELF ******
        $reso2 = $db->Execute("SELECT * FROM $dbtables[ships] WHERE sector=$targetlink and email NOT LIKE '%@xenobe' and ship_id > 1");
        if (!$reso2->EOF)
        {
          $rowo2=$reso2->fields;
          if ($playerinfo[aggression] == 0)            // ****** O = 2 & AGRESSION = 0 PEACEFUL ******
          {
            // This Guy Does Nothing But Roam And Trade
          }
          elseif ($playerinfo[aggression] == 1)        // ****** O = 2 & AGRESSION = 1 ATTACK SOMETIMES ******
          {
            // Xenobe's only compare number of fighters when determining if they have an attack advantage
            if ($playerinfo[ship_fighters] > $rowo2[ship_fighters] && $rowo2[planet_id] == 0)
            {
              $xencount2a++;
              playerlog($playerinfo[ship_id], LOG_Xenobe_ATTACK, "$rowo2[character_name]");
              xenobetoship($rowo2[ship_id]);
              if ($xenobeisdead>0) {
                $res->MoveNext();
                continue;
              }
            }
          }
          elseif ($playerinfo[aggression] == 2)        // ****** O = 2 & AGRESSION = 2 ATTACK ALLWAYS ******
          {
            $xencount2a++;
            playerlog($playerinfo[ship_id], LOG_Xenobe_ATTACK, "$rowo2[character_name]");
            if (!$rowo2[planet_id] == 0) {              // *** IS ON PLANET ***
              xenobetoplanet($rowo2[planet_id]);
            } else {
              xenobetoship($rowo2[ship_id]);
            }
            if ($xenobeisdead>0) {
              $res->MoveNext();
              continue;
            }
          }
        }
      }
      // *********************************
      // *** ORDERS = 3 ROAM AND HUNT  ***
      // *********************************
      elseif ($playerinfo[orders] == 3)
      {
        $xencount3++;
        // ****** LET SEE IF WE GO HUNTING THIS ROUND BEFORE WE DO ANYTHING ELSE ******
        $hunt=rand(0,3);                               // *** 25% CHANCE OF HUNTING ***
        // Uncomment below for Debugging
        //$hunt=0;
        if ($hunt==0)
        {
        $xencount3h++;
        xenobehunter();
        if ($xenobeisdead>0) {
          $res->MoveNext();
          continue;
        }
        } else
        {
          // ****** ROAM TO A NEW SECTOR BEFORE DOING ANYTHING ELSE ******
          xenobemove();
          if ($xenobeisdead>0) {
            $res->MoveNext();
            continue;
          }
          // ****** FIND A TARGET ******
          // ****** IN MY SECTOR, NOT MYSELF ******
          $reso3 = $db->Execute("SELECT * FROM $dbtables[ships] WHERE sector=$playerinfo[sector] and email NOT LIKE '%@xenobe' and ship_id > 1");
          if (!$reso3->EOF)
          {
            $rowo3=$reso3->fields;
            if ($playerinfo[aggression] == 0)            // ****** O = 3 & AGRESSION = 0 PEACEFUL ******
            {
              // This Guy Does Nothing But Roam Around As A Target Himself
            }
            elseif ($playerinfo[aggression] == 1)        // ****** O = 3 & AGRESSION = 1 ATTACK SOMETIMES ******
            {
              // Xenobe's only compare number of fighters when determining if they have an attack advantage
              if ($playerinfo[ship_fighters] > $rowo3[ship_fighters] && $rowo3[planet_id] == 0)
              {
                $xencount3a++;
                playerlog($playerinfo[ship_id], LOG_Xenobe_ATTACK, "$rowo3[character_name]");
                xenobetoship($rowo3[ship_id]);
                if ($xenobeisdead>0) {
                  $res->MoveNext();
                  continue;
                }
              }
            }
            elseif ($playerinfo[aggression] == 2)        // ****** O = 3 & AGRESSION = 2 ATTACK ALLWAYS ******
            {
              $xencount3a++;
              playerlog($playerinfo[ship_id], LOG_Xenobe_ATTACK, "$rowo3[character_name]");
              if (!$rowo3[planet_id] == 0) {              // *** IS ON PLANET ***
                xenobetoplanet($rowo3[planet_id]);
              } else {
                xenobetoship($rowo3[ship_id]);
              }
              if ($xenobeisdead>0) {
                $res->MoveNext();
                continue;
              }
            }
          }
        }
      }
    }
    $res->MoveNext();
	continue;
  }

// **************************
// *** Xenobe Auto Generator ***
// **************************
// ***************************************************************************************
// *** Spawns new Xenobe each update to keep the amount of Xenobe in the universe at $xenobe_max. ***
// ***************************************************************************************
	
$needed_xenobe = $xenobe_max - $xencount;
if ($needed_xenobe >= 0)
{
    echo "creating $needed_xenobe Xenobe.<br>";
    
    //the created xenobe will be set to the average player hull + or - 7
    $stamp = date("Y-m-d H-i-s", time() - 604800); // one week ago
    
        $res = $db->Execute("SELECT round(AVG(hull)) AS hull, round(AVG(power)) AS power, round(AVG(computer)) AS computer, ".
                        "COUNT(*) AS count FROM $dbtables[ships] WHERE ship_destroyed='N' AND email LIKE '%@xenobe' ");
    $row = $res->fields;
    $playeraverage = round(($row[hull] + $row[power]  + $row[computer])/3);
    echo "$row[count] Xenobes used for an average of $playeraverage<br>\n"; 

    while ($needed_xenobe > 0)
    {
        $xenlevel = $playeraverage + rand(-2,4);
	 	if ($xenlevel <= 0) { $xenlevel = rand(1,$xenstartsize); }
	 	if ($xenlevel > 52) { $xenlevel = 52; echo "<br>Lowering Xenobe average too big !<br>"; } // New code to limit xenobe size, stops undeafetable xenobe being created - GunSlinger
		$xen_cloak = round($xenlevel/2);  // Making cloak half the size of the xenobe level so users see more of them.  I know this affects other calcs, but not against players - rjordan
		$fpf = $xenlevel * 1000000;
		echo "creating level $xenlevel Xenobe.<br>"; 	 
	 			 	 
// Create Xenobe Name

        $Sylable1 = array("Xenobe-");
        $Sylable2 = array("Ak","Al","Ar","B","Br","D","F","Fr","G","Gr","H","J","N","Ol","Om","P","Qu","R","S","T","Z");
        $Sylable3 = array("a","ar","aka","aza","e","el","i","in","int","ili","ish","ido","ir","o","oi","or","os","ov","otre","u","un");
        $Sylable4 = array("ag","al","ak","ba","dar","g","ga","k","ka","kar","kil","l","n","ns","ol","r","s","st","ta","ti","x");
        $Sylable5 = array("an","yen","avi","aka","ens","elf","si","pin","rint","eli","ash","ids","sir","os","soi","por","ost","rov","more","urn","onk");

// New code for shipnames orig code from gcfl.net
// Use the 1st $ShipNames below for the 1st update after universe creation by commenting out the 2nd $ShipNames line
// Then after update uncomment the 2nd one and comment out the 1st $ShipNames line. - GunSlinger

//        $ShipNames = array("Scout"); 	

        $ShipNames = array("Steamrunner", "Battle Cruiser", "Death Glider", "Starship", "Deathstar", "Excelsior", "Armageddon", "Copernicus", "Crazy Horse", "Daedalus", "Endeavour", "Equinox", "Fearless", "Nebula", "Intrepid", "Warship", "Odyssey", "Pegasus", "Prometheus", "Brave Star", "Pueblo", "Renegade", "Spaceship", "Stargazer", "Amazon Queen", "Destructor", "Andromeda", "Devastator",  "Event Horizon", "Storm Force", "Reaper", "Mort", "Repulsifier", "Erradicator", "Annihilator", "Tattoo", "Anthrax", "Scylla", "Alacrity", "Red Alert", "Dog Star", "Invincible", "Predator", "Bird of Prey", "Slip Stream", "Devils Horn", "Crusader", "Explorer", "Shadow", "Ulysses", "Punisher", "Iron Maiden", "Thors Hammer", "Thors Chariot", "Solar Storm", "Raptor", "Speed Demon", "Cubix", "Talisman", "Sonic Boom", "Vampyrrhic", "Zed Bed", "Evolution", "Sensai", "Nostradamus", "Harvester", "Sol Slip", "Comet", "Aurora", "Oddysee", "Hive", "Adversary", "Zeppellin", "Zephyr");

        $sy1roll = (0);
        $sy2roll = rand(0,20);
        $sy3roll = rand(0,20);
        $sy4roll = rand(0,20);
        $sy5roll = rand(0,20);
        $character = $Sylable1[$sy1roll] . $Sylable2[$sy2roll] . $Sylable3[$sy3roll] . $Sylable4[$sy4roll] . $Sylable5[$sy5roll];
        $ADODB_FETCH_MODE = ADODB_FETCH_NUM;
        $resultnm = $db->Execute ("select character_name from $dbtables[ships] where character_name='$character'");
        $namecheck = $resultnm->fields;
        $ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
        $nametry = 1;
// If Name Exists Try Again - Up To Nine Times
        while (($namecheck[0]) and ($nametry <= 9)) {
          $sy1roll = (0);
          $sy2roll = rand(0,20);
          $sy3roll = rand(0,20);
          $sy4roll = rand(0,20);
          $sy5roll = rand(0,20);
          $character = $Sylable1[$sy1roll] . $Sylable2[$sy2roll] . $Sylable3[$sy3roll] . $Sylable4[$sy4roll] . $Sylable5[$sy5roll];
          $ADODB_FETCH_MODE = ADODB_FETCH_NUM;
          $resultnm = $db->Execute ("select character_name from $dbtables[ships] where character_name='$character'");
          $namecheck = $resultnm->fields;
          $ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
          $nametry++;
        }
// Create Ship Name
        $shipname = $ShipNames[rand(0,count($ShipNames)-1)] . " " . $xenobe_name;       
// Select Random Sector
        $sector = rand($fed_sectors,$sector_max);
// Select Orders
				$orders = rand(1,2); // orig rand(1,2);   0 = Sentinel, 1 = Explorer, 2 = Trader, 3 = Hunter - so if you dont want hunters set it to (1,2) - if you want sentinels then go (0,2)
// Select Aggression
				$aggression = rand(1,100);
				if ($aggression <= $xen_aggression)
				{
				 $aggression = rand(1,2);  //I do this to create more peacefull than aggressive.  This creates 33% aggressive.  I will make configurable later - Jordo // originally 1 GunSlinger
				}
				else
				{
				 $aggression = 0;
				}
				if ($aggression == 1)
				{
				 $orders = rand(1,2); // orig rand(1,2);   0 = Sentinel, 1 = Explorer, 2 = Trader, 3 = Hunter - so if you dont want hunters set it to (1,2) - if you want sentinels then go (0,2)
				}
// update database
        $_active = empty($active) ? "N" : "Y";
        $errflag=0;
        if ( $character=='' || $shipname=='' ) { echo "Ship name, and character name may not be blank.<BR>"; $errflag=1;}
// Change Spaces to Underscores in shipname
// Create emailname from character
        $emailname = str_replace(" ","_",$character) . "@xenobe";
        $ADODB_FETCH_MODE = ADODB_FETCH_NUM;
        $result = $db->Execute ("select email, character_name, ship_name from $dbtables[ships] where email='$emailname' OR character_name='$character' OR ship_name='$shipname'");
        if ($result>0)
        {
          while (!$result->EOF)
          {
            $row= $result->fields;
            if ($row[0]==$emailname) { echo "ERROR: E-mail address $emailname, is already in use.  "; $errflag=1;}
            if ($row[1]==$character) { echo "ERROR: Character name $character, is already in use.<BR>"; $errflag=1;}
            if ($row[2]==$shipname) { echo "ERROR: Ship name $shipname, is already in use.<BR>"; $errflag=1;}
            $result->MoveNext();
          }
        }
        $ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
        if ($errflag==0)
        {
          $makepass="";
$syllables="er,in,tia,wol,fe,pre,vet,jo,nes,al,len,son,cha,ir,ler,bo,ok,tio,nar,sim,ple,bla,ten,toe,cho,co,lat,spe,ak,er,po,co,lor,pen,cil,li,ght,wh,at,the,he,ck,is,mam,bo,no,fi,ve,any,way,pol,iti,cs,ra,dio,sou,rce,sea,rch,pa,per,com,bo,sp,eak,st,fi,rst,gr,oup,boy,ea,gle,tr,ail,bi,ble,brb,pri,dee,kay,en,be,se";
          $syllable_array=explode(",", $syllables);
          srand((double)microtime()*1000000);
          for ($count=1;$count<=4;$count++) {
            if (rand()%10 == 1) {
              $makepass .= sprintf("%0.0f",(rand()%50)+1);
            } else {
              $makepass .= sprintf("%s",$syllable_array[rand()%62]);
            }
          }
          if ($xenlevel=='') $xenlevel=0;
          $maxenergy = NUM_ENERGY($xenlevel);
          $maxarmour = NUM_ARMOUR($xenlevel);
          $maxfighters = NUM_FIGHTERS($xenlevel);
          $maxtorps = NUM_TORPEDOES($xenlevel);
          $stamp=date("Y-m-d H:i:s");

            // *****************************************************************************
            // *** ADD XENOBE RECORD TO ships TABLE ... MODIFY IF ships SCHEMA CHANGES ***
            // *****************************************************************************

          	$result2 = $db->Execute("INSERT INTO $dbtables[ships] VALUES(NULL,'$shipname','N','$character','$makepass','$emailname',$xenlevel,$xenlevel,$xenlevel,$xenlevel,$xenlevel,$xenlevel,$xenlevel,$maxtorps,$xenlevel,$xenlevel,$maxarmour,$xen_cloak,$xen_start_credits,$sector,0,0,0,$maxenergy,0,$maxfighters,$start_turns,NULL,'N',0,0,0,0,'N','N',$fpf,0, '$stamp',0,0,0,0,'N','127.0.0.1',0,0,0,0,'Y','N','N','Y',' ','$default_lang','Y','N')");
            
            if(!$result2) {
                echo $db->ErrorMsg() . "<br>";
            } else {
                echo "Xenobe has been created.<BR><BR>";
                echo "Password has been set.<BR><BR>";
                echo "Ship Records have been updated.<BR><BR>";
            }
            $result3 = $db->Execute("INSERT INTO $dbtables[xenobe] (xenobe_id,active,aggression,orders) ".
                                    "VALUES('$emailname','Y','$aggression','$orders')");
            if(!$result3) {
                echo $db->ErrorMsg() . "<br>";
            } else {
                echo "Xenobe Records have been updated.<BR><BR>";
            }
            //Xenobe has a 5% chance of getting a planet - rjordan01
            $getsplanet = rand(1,100);
            if($getsplanet<=$xen_planets)
            {
                echo "The Xenobe has been selected to get a planet<BR><BR>";
                $result4 = $db->Execute("SELECT ship_id FROM $dbtables[ships] WHERE character_name = '$character'");
                $xenshipid = $result4->fields;
                
                $resep = $db->Execute("SELECT planet_id FROM $dbtables[planets] WHERE owner = 0 and credits > 0 order by credits desc limit 1");
                $ep = $resep->fields;
                if ($ep[planet_id])
                {
                    $result7 = $db->Execute("UPDATE $dbtables[planets] SET organics='$fpf', ore='$fpf', goods='$fpf', energy='$fpf', colonists='$fpf', credits='$fpf', fighters='$fpf', torps='$fpf', owner='$xenshipid[ship_id]', corp='0', base='Y', sells='N', prod_organics='15.00',prod_ore='5.00',prod_goods='5.00',prod_energy='10.00',prod_fighters='20.00',prod_torp='10.00',N,WHERE planet_id=$ep[planet_id]");
                    if(!$result7) 
                    {
                        echo $db->ErrorMsg() . "<br>";
                    }
                    else 
                    {
                        echo "Xenobe captured an abanded planet. $ep[planet_id]<BR><BR>";
                    }
                }
                else
                {						
                    //checking sector 
                    $fps_query = $db->Execute("select * from $dbtables[universe] WHERE sector_id = '$sector' and zone_id = '1'");
                    $fpsector = $fps_query->fields; 
                    if ($fpsector[sector_id] != $sector)
                    {
                        echo "Not allowed to create a planet in sector $sector.<BR>";
                    }
                    else
                    {
                        
                        echo "sector is $sector<BR>";
                        $maxp = $db->Execute("select * from $dbtables[planets] where sector_id = '$sector'");
                        $num_res = $maxp->numRows(); 
                        if ($num_res >= $max_planets_sector)
                        {
                            echo "There are too many planets in sector $sector. <BR>";
                        }
                        else
                        {								
                            //Create the planet
                            $num_res += 1;
                            $pname = "Xenobe Dominion-$sector-$num_res";
                            echo "The planet name is $pname<BR>";
                            $result5 = $db->Execute("INSERT INTO $dbtables[planets] VALUES(NULL,'$sector','$pname','$fpf','$fpf','$fpf','$fpf','$fpf','$fpf','$fpf','$fpf','$xenshipid[ship_id]','0','Y','N','15.00','5.00','5.00','10.00','20.00','10.00','N')");
                            if(!$result5) 
                            {
                                echo $db->ErrorMsg() . "<br>";
                            }
                            else 
                            {
                                echo "Xenobe Planet has been created.<BR><BR>";
                            }
                        }
                    }
                }
            }
        }
        $needed_xenobe--;
    }
}	

$res->_close();

$xennonmove = $xencount - ($xencount0 + $xencount1 + $xencount2 + $xencount3);
echo "Counted $xencount Xenobe players that are ACTIVE with working ships.<BR>";
echo "$xennonmove Xenobe players did not do anything this round. <BR>";
echo "$xencount0 Xenobe players had SENTINEL orders of which $xencount0a launched attacks. <BR>";
echo "$xencount1 Xenobe players had ROAM orders of which $xencount1a launched attacks. <BR>";
echo "$xencount2 Xenobe players had ROAM AND TRADE orders of which $xencount2a launched attacks. <BR>";
echo "$xencount3 Xenobe players had ROAM AND HUNT orders of which $xencount3a launched attacks and $xencount3h went hunting. <BR>";
echo "XENOBE TURNS COMPLETE. <BR>";
echo "<BR>";

  // *********************************
  // ***** END OF Xenobe TURNS *****
  // *********************************

?>
