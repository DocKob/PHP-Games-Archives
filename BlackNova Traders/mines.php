<?
include("config.php");

updatecookie();

include("languages/$lang");
$title=$l_mines_title;
include("header.php");

connectdb();

if(checklogin())
{
  die();
}

//-------------------------------------------------------------------------------------------------


$res = $db->Execute("SELECT * FROM $dbtables[ships] WHERE email='$username'");
$playerinfo = $res->fields;
$res = $db->Execute("SELECT * from $dbtables[universe] WHERE sector_id=$playerinfo[sector]");
$sectorinfo = $res->fields;
$result3 = $db->Execute ("SELECT * FROM $dbtables[sector_defence] WHERE sector_id=$playerinfo[sector] ");
//Put the defence information into the array "defenceinfo"
$i = 0;
$total_sector_fighters = 0;
$total_sector_miness = 0;
$owns_all = true;
$fighter_id = 0;
$mine_id = 0;
$set_attack = 'CHECKED';
$set_toll = '';
if($result3 > 0)
{
   while(!$result3->EOF)
   {
      $defences[$i] = $result3->fields;;
      if($defences[$i]['defence_type'] == 'F')
         $total_sector_fighters += $defences[$i]['quantity'];
      else
         $total_sector_mines += $defences[$i]['quantity'];

      if($defences[$i][ship_id] != $playerinfo[ship_id])
      {
         $owns_all = false;
      }
      else
      {
         if($defences[$i]['defence_type'] == 'F')
         {
            $fighter_id = $defences[$i]['defence_id'];
            if($defences[$i]['fm_setting'] == 'attack')
            {
               $set_attack = 'CHECKED';
               $set_toll = '';
            }
            else
            {
               $set_attack = '';
               $set_toll = 'CHECKED';
            }

         }
         else
            $mine_id = $defences[$i]['defence_id'];

      }
      $i++;
      $result3->MoveNext();
   }
}
$num_defences = $i;
bigtitle();
if ($playerinfo[turns]<1)
{
	echo "$l_mines_noturn<BR><BR>";
	TEXT_GOTOMAIN();
	include("footer.php");
	die();
}
$res = $db->Execute("SELECT allow_defenses,$dbtables[universe].zone_id,owner FROM $dbtables[zones],$dbtables[universe] WHERE sector_id=$playerinfo[sector] AND $dbtables[zones].zone_id=$dbtables[universe].zone_id");
$zoneinfo = $res->fields;
if($zoneinfo[allow_defenses] == 'N')
{
 echo "$l_mines_nopermit<BR><BR>";
}
else
{
   if($num_defences > 0)
   {
      if(!$owns_all)
      {
         $defence_owner = $defences[0]['ship_id'];
         $result2 = $db->Execute("SELECT * from $dbtables[ships] where ship_id=$defence_owner");
         $fighters_owner = $result2->fields;

         if($fighters_owner[team] != $playerinfo[team] || $playerinfo['team'] == 0)
         {
            echo "$l_mines_nodeploy<BR>";
            TEXT_GOTOMAIN();
            die();

         }
      }
   }
   if($zoneinfo[allow_defenses] == 'L')
   {
         $zone_owner = $zoneinfo['owner'];
         $result2 = $db->Execute("SELECT * from $dbtables[ships] where ship_id=$zone_owner");
         $zoneowner_info = $result2->fields;

         if($zone_owner <> $playerinfo[ship_id])
         {
            if($zoneowner_info['team'] != $playerinfo['team'] || $playerinfo['team'] == 0)
            {
               echo "$l_mines_nopermit<BR><BR>";
               TEXT_GOTOMAIN();
               die();

            }
         }
   }


   if(!isset($nummines) or !isset($numfighters) or !isset($mode))
   {
     $availmines = NUMBER($playerinfo[torps]);
     $availfighters = NUMBER($playerinfo[ship_fighters]);
     echo "<FORM ACTION=mines.php METHOD=POST>";
     $l_mines_info1=str_replace("[sector]",$playerinfo[sector], $l_mines_info1);
     $l_mines_info1=str_replace("[mines]",NUMBER($sectorinfo[mines]), $l_mines_info1);
     $l_mines_info1=str_replace("[fighters]",NUMBER($sectorinfo[fighters]), $l_mines_info1);
     echo "$l_mines_info1<BR><BR>";
     $l_mines_info2=str_replace("[mines]",$availmines, $l_mines_info2);
     $l_mines_info2=str_replace("[fighters]",$availfighters, $l_mines_info2);
     echo "You have $availmines mines and $availfighters fighters available to deploy.<BR>";
     echo "$l_mines_deploy <INPUT TYPE=TEXT NAME=nummines SIZE=10 MAXLENGTH=10 VALUE=$playerinfo[torps]> $l_mines.<BR>";
     echo "$l_mines_deploy <INPUT TYPE=TEXT NAME=numfighters SIZE=10 MAXLENGTH=10 VALUE=$playerinfo[ship_fighters]> $l_fighters.<BR>";
     echo "Fighter mode <INPUT TYPE=RADIO NAME=mode $set_attack VALUE=attack>$l_mines_att</INPUT>";
     echo "<INPUT TYPE=RADIO NAME=mode $set_toll VALUE=toll>$l_mines_toll</INPUT><BR>";
     echo "<INPUT TYPE=SUBMIT VALUE=$l_submit><INPUT TYPE=RESET VALUE=$l_reset><BR><BR>";
     echo "<input type=hidden name=op value=$op>";
     echo "</FORM>";
  }
  else
  {
     $nummines = stripnum($nummines);
     $numfighters = stripnum($numfighters);
     if (empty($nummines)) $nummines = 0;
     if (empty($numfighters)) $numfighters = 0;
     if ($nummines < 0) $nummines = 0;
     if ($numfighters < 0) $numfighters =0;
     if ($nummines > $playerinfo[torps])
     {
        echo "$l_mines_notorps<BR>";
        $nummines = 0;
     }
     else
     {
      $l_mines_dmines=str_replace("[mines]",$nummines, $l_mines_dmines);
        echo "$l_mines_dmines<BR>";
     }
     if ($numfighters > $playerinfo[ship_fighters])
     {
        echo "$l_mines_nofighters.<BR>";
        $numfighters = 0;
     }
     else
     {
     $l_mines_dfighter=str_replace("[fighters]",$numfighters, $l_mines_dfighter);
     $l_mines_dfighter=str_replace("[mode]",$mode, $l_mines_dfighter);
        echo "$l_mines_dfighter<BR>";
     }

     $stamp = date("Y-m-d H-i-s");
     if($numfighters > 0)
     {
        if($fighter_id != 0)
        {
           $update = $db->Execute("UPDATE $dbtables[sector_defence] set quantity=quantity + $numfighters,fm_setting = '$mode' where defence_id = $fighter_id");
        }
        else
        {

           $update = $db->Execute("INSERT INTO $dbtables[sector_defence] (ship_id,sector_id,defence_type,quantity,fm_setting) values ($playerinfo[ship_id],$playerinfo[sector],'F',$numfighters,'$mode')");
           echo $db->ErrorMsg();
        }
     }
     if($nummines > 0)
     {
        if($mine_id != 0)
        {
           $update = $db->Execute("UPDATE $dbtables[sector_defence] set quantity=quantity + $nummines,fm_setting = '$mode' where defence_id = $mine_id");
        }
        else
        {
           $update = $db->Execute("INSERT INTO $dbtables[sector_defence] (ship_id,sector_id,defence_type,quantity,fm_setting) values ($playerinfo[ship_id],$playerinfo[sector],'M',$nummines,'$mode')");

        }
     }

     $update = $db->Execute("UPDATE $dbtables[ships] SET last_login='$stamp',turns=turns-1,turns_used=turns_used+1,ship_fighters=ship_fighters-$numfighters,torps=torps-$nummines WHERE ship_id=$playerinfo[ship_id]");

  }
}

//-------------------------------------------------------------------------------------------------

TEXT_GOTOMAIN();

include("footer.php");

?>
