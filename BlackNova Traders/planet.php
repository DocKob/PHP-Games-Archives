<?
include("config.php");
include("combat.php");

updatecookie();

include("languages/$lang");
$title=$l_planet_title;
include("header.php");

connectdb();

if(checklogin())
{
  die();
}
//-------------------------------------------------------------------------------------------------

$result = $db->Execute("SELECT * FROM $dbtables[ships] WHERE email='$username'");
$playerinfo=$result->fields;

$result2 = $db->Execute("SELECT * FROM $dbtables[universe] WHERE sector_id=$playerinfo[sector]");
$sectorinfo=$result2->fields;

$planet_id = stripnum($planet_id);

$result3 = $db->Execute("SELECT * FROM $dbtables[planets] WHERE planet_id=$planet_id");
if($result3)
  $planetinfo=$result3->fields;

bigtitle();

srand((double)microtime()*1000000);

if(!empty($planetinfo))
/* if there is a planet in the sector show appropriate menu */
{
  if($playerinfo[sector] != $planetinfo[sector_id])
  {
    if($playerinfo[on_planet] == 'Y')
      $db->Execute("UPDATE $dbtables[ships] SET on_planet='N' WHERE ship_id=$playerinfo[ship_id]");
    echo "$l_planet_none <p>";
    TEXT_GOTOMAIN();
    include("footer.php");
    die();
  }
  if(($planetinfo[owner] == 0  || $planetinfo[defeated] == 'Y') && $command != "capture")
  {
    if($planetinfo[owner] == 0) echo "$l_planet_unowned.<BR><BR>";
    $capture_link="<a href=planet.php?planet_id=$planet_id&command=capture>$l_planet_capture1</a>";
    $l_planet_capture2=str_replace("[capture]",$capture_link,$l_planet_capture2);
    echo "$l_planet_capture2.<BR><BR>";
    echo "<BR>";
    TEXT_GOTOMAIN();
    include("footer.php");
    die();
  }
  if($planetinfo[owner] != 0)
  {
    $result3 = $db->Execute("SELECT * FROM $dbtables[ships] WHERE ship_id=$planetinfo[owner]");
    $ownerinfo = $result3->fields;
  }
  if(empty($command))
  {
    /* ...if there is no planet command already */
    if(empty($planetinfo[name]))
    {
        $l_planet_unnamed=str_replace("[name]",$ownerinfo[character_name],$l_planet_unnamed);
      echo "$l_planet_unnamed<BR><BR>";
    }
    else
    {
     $l_planet_named=str_replace("[name]",$ownerinfo[character_name],$l_planet_named);
     $l_planet_named=str_replace("[planetname]",$planetinfo[name],$l_planet_named);
      echo "$l_planet_named<BR><BR>";
    }
    if($playerinfo['ship_id'] == $planetinfo['owner']) 
    { 
       if($destroy==1 && $allow_genesis_destroy) 
       { 
          echo "<font color=red>$l_planet_confirm</font><br><A HREF=planet.php?planet_id=$planet_id&destroy=2>yes</A><br>"; 
          echo "<A HREF=planet.php?planet_id=$planet_id>no!</A><BR><br>"; 
       } 
       elseif($destroy==2 && $allow_genesis_destroy) 
       { 
          if($playerinfo[dev_genesis] > 0) 
          { 
             $update = $db->Execute("delete from $dbtables[planets] where planet_id=$planet_id"); 
             $update2=$db->Execute("UPDATE $dbtables[ships] SET turns_used=turns_used+1, turns=turns-1,dev_genesis=dev_genesis-1 WHERE ship_id=$playerinfo[ship_id]"); 
             $update3=$db->Execute("UPDATE $dbtables[ships] SET on_planet='N' WHERE planet_id=$planet_id"); 
             calc_ownership($playerinfo[sector]);
             echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=main.php\">"; 
          } 
          else 
          { 
             echo "$l_gns_nogenesis<br>"; 
          } 
       } 
       elseif($allow_genesis_destroy) 
       { 
          echo "<A onclick=\"javascript: alert ('alert:$l_planet_warning');\" HREF=planet.php?planet_id=$planet_id&destroy=1>$l_planet_destroyplanet</a><br>"; 
       } 
    } 

    if($planetinfo[owner] == $playerinfo[ship_id] || ($planetinfo[corp] == $playerinfo[team] && $playerinfo[team] > 0))
    {
      /* owner menu */
      echo "$l_turns_have: $playerinfo[turns]<p>";
      
     $l_planet_name_link = "<a href=planet.php?planet_id=$planet_id&command=name>" . $l_planet_name_link . "</a>";
     $l_planet_name =str_replace("[name]",$l_planet_name_link,$l_planet_name2);
     
     echo "$l_planet_name<BR>";
     
     $l_planet_leave_link = "<a href=planet.php?planet_id=$planet_id&command=leave>" . $l_planet_leave_link . "</a>";
     $l_planet_leave=str_replace("[leave]",$l_planet_leave_link,$l_planet_leave);


     $l_planet_land_link = "<a href=planet.php?planet_id=$planet_id&command=land>" . $l_planet_land_link . "</a>";
     $l_planet_land=str_replace("[land]",$l_planet_land_link,$l_planet_land);

      if($playerinfo[on_planet] == 'Y' && $playerinfo[planet_id] == $planet_id)
      {
        echo "$l_planet_onsurface<BR>";
        echo "$l_planet_leave<BR>";
        echo "$l_planet_logout<BR>";
      }
      else
      {
        echo "$l_planet_orbit<BR>";
        echo "$l_planet_land<BR>";
      }

      $l_planet_transfer_link="<a href=planet.php?planet_id=$planet_id&command=transfer>" . $l_planet_transfer_link . "</a>";
      $l_planet_transfer=str_replace("[transfer]",$l_planet_transfer_link,$l_planet_transfer);
      echo "$l_planet_transfer<BR>";
      if($planetinfo[sells] == "Y")
      {
        echo $l_planet_selling;
      }
      else
      {
        echo $l_planet_not_selling;
      }
      $l_planet_tsell_link="<a href=planet.php?planet_id=$planet_id&command=sell>" . $l_planet_tsell_link ."</a>";
      $l_planet_tsell=str_replace("[selling]",$l_planet_tsell_link,$l_planet_tsell);
      echo "$l_planet_tsell<BR>";
      if($planetinfo[base] == "N")
      {
         $l_planet_bbase_link = "<a href=planet.php?planet_id=$planet_id&command=base>" . $l_planet_bbase_link . "</a>";
         $l_planet_bbase=str_replace("[build]",$l_planet_bbase_link,$l_planet_bbase);
        echo "$l_planet_bbase<BR>";
      }
      else
      {
        echo "$l_planet_hasbase<BR>";
      }

      $l_planet_readlog_link="<a href=log.php>" . $l_planet_readlog_link ."</a>";
      $l_planet_readlog=str_replace("[View]",$l_planet_readlog_link,$l_planet_readlog);
      echo "<BR>$l_planet_readlog<BR>";

      if ($playerinfo[ship_id] == $planetinfo[owner])
      {
        if ($playerinfo[team] <> 0)
        {
	   if ($planetinfo[corp] == 0)
           {
           $l_planet_mcorp_linkC = "<a href=corp.php?planet_id=$planet_id&action=planetcorp>" . $l_planet_mcorp_linkC . "</a>";
           $l_planet_mcorp=str_replace("[planet]",$l_planet_mcorp_linkC,$l_planet_mcorp);
	 	echo "$l_planet_mcorp<BR>";
	   }
	   else
	   {
        $l_planet_mcorp_linkP = "<a href=corp.php?planet_id=$planet_id&action=planetpersonal>" . $l_planet_mcorp_linkP . "</a>";
        $l_planet_mcorp=str_replace("[planet]",$l_planet_mcorp_linkP,$l_planet_mcorp);
		echo "$l_planet_mcorp<BR>";
	   }
         }
      }
      /* change production rates */
      echo "<FORM ACTION=planet.php?planet_id=$planet_id METHOD=POST>";
      echo "<INPUT TYPE=HIDDEN NAME=command VALUE=productions><BR>";
      echo "<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=2>";
      echo "<TR BGCOLOR=\"$color_header\"><TD></TD><TD><B>$l_ore</B></TD><TD><B>$l_organics</B></TD><TD><B>$l_goods</B></TD><TD><B>$l_energy</B></TD><TD><B>$l_colonists</B></TD><TD><B>$l_credits</B></TD><TD><B>$l_fighters</B></TD><TD><B>$l_torps</TD></TR>";
      echo "<TR BGCOLOR=\"$color_line1\">";
      echo "<TD>$l_current_qty</TD>";
      echo "<TD>" . NUMBER($planetinfo[ore]) . "</TD>";
      echo "<TD>" . NUMBER($planetinfo[organics]) . "</TD>";
      echo "<TD>" . NUMBER($planetinfo[goods]) . "</TD>";
      echo "<TD>" . NUMBER($planetinfo[energy]) . "</TD>";
      echo "<TD>" . NUMBER($planetinfo[colonists]) . "</TD>";
      echo "<TD>" . NUMBER($planetinfo[credits]) . "</TD>";
      echo "<TD>" . NUMBER($planetinfo[fighters]) . "</TD>";
      echo "<TD>" . NUMBER($planetinfo[torps]) . "</TD>";
      echo "</TR>";
      echo "<TR BGCOLOR=\"$color_line2\"><TD>$l_planet_perc</TD>";
      echo "<TD><INPUT TYPE=TEXT NAME=pore VALUE=\"$planetinfo[prod_ore]\" SIZE=6 MAXLENGTH=6></TD>";
      echo "<TD><INPUT TYPE=TEXT NAME=porganics VALUE=\"$planetinfo[prod_organics]\" SIZE=6 MAXLENGTH=6></TD>";
      echo "<TD><INPUT TYPE=TEXT NAME=pgoods VALUE=\"" .round($planetinfo[prod_goods])."\" SIZE=6 MAXLENGTH=6></TD>";
      echo "<TD><INPUT TYPE=TEXT NAME=penergy VALUE=\"$planetinfo[prod_energy]\" SIZE=6 MAXLENGTH=6></TD>";
      echo "<TD>n/a</TD><TD>*</TD>";
      echo "<TD><INPUT TYPE=TEXT NAME=pfighters VALUE=\"$planetinfo[prod_fighters]\" SIZE=6 MAXLENGTH=6></TD>";
      echo "<TD><INPUT TYPE=TEXT NAME=ptorp VALUE=\"$planetinfo[prod_torp]\" SIZE=6 MAXLENGTH=6></TD>";
      echo "</TABLE>$l_planet_interest<BR><BR>";
      echo "<INPUT TYPE=SUBMIT VALUE=$l_planet_update>";
      echo "</FORM>";
    }
    else
    {
      /* visitor menu */
      if($planetinfo[sells] == "Y")
      {
       $l_planet_buy_link="<a href=planet.php?planet_id=$planet_id&command=buy>" . $l_planet_buy_link ."</a>";
       $l_planet_buy=str_replace("[buy]",$l_planet_buy_link,$l_planet_buy);
        echo "$l_planet_buy<BR>";
      }
      else
      {
        echo "$l_planet_not_selling.<BR>";
      }
       $l_planet_att_link="<a href=planet.php?planet_id=$planet_id&command=attac>" . $l_planet_att_link ."</a>";
       $l_planet_att=str_replace("[attack]",$l_planet_att_link,$l_planet_att);
       $l_planet_scn_link="<a href=planet.php?planet_id=$planet_id&command=scan>" . $l_planet_scn_link ."</a>";
       $l_planet_scn=str_replace("[scan]",$l_planet_scn_link,$l_planet_scn);
      echo "$l_planet_att<BR>";
      echo "$l_planet_scn<BR>";
      if ($sofa_on) echo "<a href=planet.php?planet_id=$planet_id&command=bom>$l_sofa</a><BR>";
    }
  }
  elseif($planetinfo[owner] == $playerinfo[ship_id] || ($planetinfo[corp] == $playerinfo[team] && $playerinfo[team] > 0))
  {
    /* player owns planet and there is a command */
    if($command == "sell")
    {
      if($planetinfo[sells] == "Y")
      {
        /* set planet to not sell */
        echo "$l_planet_nownosell<BR>";
        $result4 = $db->Execute("UPDATE $dbtables[planets] SET sells='N' WHERE planet_id=$planet_id");
      }
      else
      {
        echo "$l_planet_nowsell<BR>";
        $result4b = $db->Execute ("UPDATE $dbtables[planets] SET sells='Y' WHERE planet_id=$planet_id");
      }
    }
    elseif($command == "name")
    {
      /* name menu */
      echo "<form action=\"planet.php?planet_id=$planet_id&command=cname\" method=\"post\">";
      echo "$l_planet_iname:  ";
      echo "<input type=\"text\" name=\"new_name\" size=\"20\" maxlength=\"20\" value=\"$planetinfo[name]\"><BR><BR>";
      echo "<input type=\"submit\" value=\"$l_submit\"><input type=\"reset\" value=\"$l_reset\"><BR><BR>";
      echo "</form>";
    }
    elseif($command == "cname")
    {
      /* name2 menu */
      $new_name = trim(strip_tags($new_name));
      $result5 = $db->Execute("UPDATE $dbtables[planets] SET name='$new_name' WHERE planet_id=$planet_id");
      $new_name = stripslashes($new_name);
      echo "$l_planet_cname $new_name.";
    }
    elseif($command == "land")
    {
      /* land menu */
      echo "$l_planet_landed<BR><BR>";
      $update = $db->Execute("UPDATE $dbtables[ships] SET on_planet='Y', planet_id=$planet_id WHERE ship_id=$playerinfo[ship_id]");
    }
    elseif($command == "leave")
    {
      /* leave menu */
      echo "$l_planet_left<BR><BR>";
      $update = $db->Execute("UPDATE $dbtables[ships] SET on_planet='N' WHERE ship_id=$playerinfo[ship_id]");
    }
    elseif($command == "transfer")
    {
      /* transfer menu */
      $free_holds = NUM_HOLDS($playerinfo[hull]) - $playerinfo[ship_ore] - $playerinfo[ship_organics] - $playerinfo[ship_goods] - $playerinfo[ship_colonists];
      $free_power = NUM_ENERGY($playerinfo[power]) - $playerinfo[ship_energy];
      $l_planet_cinfo=str_replace("[cargo]",NUMBER($free_holds),$l_planet_cinfo);
      $l_planet_cinfo=str_replace("[energy]",NUMBER($free_power),$l_planet_cinfo);
      echo "$l_planet_cinfo<BR><BR>";
      echo "<FORM ACTION=planet2.php?planet_id=$planet_id METHOD=POST>";
      echo "<TABLE WIDTH=\"100%\" BORDER=0 CELLSPACING=0 CELLPADDING=0>";
      echo"<TR BGCOLOR=\"$color_header\"><TD><B>$l_commodity</B></TD><TD><B>$l_planet</B></TD><TD><B>$l_ship</B></TD><TD><B>$l_planet_transfer_link</B></TD><TD><B>$l_planet_toplanet</B></TD><TD><B>$l_all?</B></TD></TR>";
      echo"<TR BGCOLOR=\"$color_line1\"><TD>$l_ore</TD><TD>" . NUMBER($planetinfo[ore]) . "</TD><TD>" . NUMBER($playerinfo[ship_ore]) . "</TD><TD><INPUT TYPE=TEXT NAME=transfer_ore SIZE=10 MAXLENGTH=20></TD><TD><INPUT TYPE=CHECKBOX NAME=tpore VALUE=-1></TD><TD><INPUT TYPE=CHECKBOX NAME=allore VALUE=-1></TD></TR>";
      echo"<TR BGCOLOR=\"$color_line2\"><TD>$l_organics</TD><TD>" . NUMBER($planetinfo[organics]) . "</TD><TD>" . NUMBER($playerinfo[ship_organics]) . "</TD><TD><INPUT TYPE=TEXT NAME=transfer_organics SIZE=10 MAXLENGTH=20></TD><TD><INPUT TYPE=CHECKBOX NAME=tporganics VALUE=-1></TD><TD><INPUT TYPE=CHECKBOX NAME=allorganics VALUE=-1></TD></TR>";
      echo"<TR BGCOLOR=\"$color_line1\"><TD>$l_goods</TD><TD>" . NUMBER($planetinfo[goods]) . "</TD><TD>" . NUMBER($playerinfo[ship_goods]) . "</TD><TD><INPUT TYPE=TEXT NAME=transfer_goods SIZE=10 MAXLENGTH=20></TD><TD><INPUT TYPE=CHECKBOX NAME=tpgoods VALUE=-1></TD><TD><INPUT TYPE=CHECKBOX NAME=allgoods VALUE=-1></TD></TR>";
      echo"<TR BGCOLOR=\"$color_line2\"><TD>$l_energy</TD><TD>" . NUMBER($planetinfo[energy]) . "</TD><TD>" . NUMBER($playerinfo[ship_energy]) . "</TD><TD><INPUT TYPE=TEXT NAME=transfer_energy SIZE=10 MAXLENGTH=20></TD><TD><INPUT TYPE=CHECKBOX NAME=tpenergy VALUE=-1></TD><TD><INPUT TYPE=CHECKBOX NAME=allenergy VALUE=-1></TD></TR>";
      echo"<TR BGCOLOR=\"$color_line1\"><TD>$l_colonists</TD><TD>" . NUMBER($planetinfo[colonists]) . "</TD><TD>" . NUMBER($playerinfo[ship_colonists]) . "</TD><TD><INPUT TYPE=TEXT NAME=transfer_colonists SIZE=10 MAXLENGTH=20></TD><TD><INPUT TYPE=CHECKBOX NAME=tpcolonists VALUE=-1></TD><TD><INPUT TYPE=CHECKBOX NAME=allcolonists VALUE=-1></TD></TR>";
      echo"<TR BGCOLOR=\"$color_line2\"><TD>$l_fighters</TD><TD>" . NUMBER($planetinfo[fighters]) . "</TD><TD>" . NUMBER($playerinfo[ship_fighters]) . "</TD><TD><INPUT TYPE=TEXT NAME=transfer_fighters SIZE=10 MAXLENGTH=20></TD><TD><INPUT TYPE=CHECKBOX NAME=tpfighters VALUE=-1></TD><TD><INPUT TYPE=CHECKBOX NAME=allfighters VALUE=-1></TD></TR>";
      echo"<TR BGCOLOR=\"$color_line1\"><TD>$l_torps</TD><TD>" . NUMBER($planetinfo[torps]) . "</TD><TD>" . NUMBER($playerinfo[torps]) . "</TD><TD><INPUT TYPE=TEXT NAME=transfer_torps SIZE=10 MAXLENGTH=20></TD><TD><INPUT TYPE=CHECKBOX NAME=tptorps VALUE=-1></TD><TD><INPUT TYPE=CHECKBOX NAME=alltorps VALUE=-1></TD></TR>";
      echo"<TR BGCOLOR=\"$color_line2\"><TD>$l_credits</TD><TD>" . NUMBER($planetinfo[credits]) . "</TD><TD>" . NUMBER($playerinfo[credits]) . "</TD><TD><INPUT TYPE=TEXT NAME=transfer_credits SIZE=10 MAXLENGTH=20></TD><TD><INPUT TYPE=CHECKBOX NAME=tpcredits VALUE=-1></TD><TD><INPUT TYPE=CHECKBOX NAME=allcredits VALUE=-1></TD></TR>";
      echo "</TABLE><BR>";
      echo "<INPUT TYPE=SUBMIT VALUE=$l_planet_transfer_link>&nbsp;<INPUT TYPE=RESET VALUE=Reset>";
      echo "</FORM>";
    }
    elseif($command == "base")
    {
      /* build a base */
      if($planetinfo[ore] >= $base_ore && $planetinfo[organics] >= $base_organics && $planetinfo[goods] >= $base_goods && $planetinfo[credits] >= $base_credits)
      {
      // ** Create The Base
        $update1 = $db->Execute("UPDATE $dbtables[planets] SET base='Y', ore=$planetinfo[ore]-$base_ore, organics=$planetinfo[organics]-$base_organics, goods=$planetinfo[goods]-$base_goods, credits=$planetinfo[credits]-$base_credits WHERE planet_id=$planet_id");
      // ** Update User Turns
        $update1b = $db->Execute("UPDATE $dbtables[ships] SET turns=turns-1, turns_used=turns_used+1 where ship_id=$playerinfo[ship_id]");
      // ** Refresh Plant Info
        $result3 = $db->Execute("SELECT * FROM $dbtables[planets] WHERE planet_id=$planet_id");
        $planetinfo=$result3->fields;
      // ** Notify User Of Base Results
        echo "$l_planet_bbuild<BR><BR>";
      // ** Calc Ownership and Notify User Of Results
        $ownership = calc_ownership($playerinfo[sector]);
        if(!empty($ownership))
        {
        echo "$ownership<p>";
        }
      }
      else
      {
        echo "$l_planet_baseinfo<BR><BR>";
      }
    }
    elseif($command == "productions")
    {
      /* change production percentages */
      $porganics = stripnum($porganics);
      $pore = stripnum($pore);
      $pgoods = stripnum($pgoods);
      $penergy = stripnum($penergy);
      $pfighters = stripnum($pfighters);
      $ptorp = stripnum($ptorp);
      if($porganics < 0.0 || $pore < 0.0 || $pgoods < 0.0 || $penergy < 0.0 || $pfighters < 0.0 || $ptorp < 0.0)
      {
        echo "$l_planet_p_under<BR><BR>";
      }
      elseif(($porganics + $pore + $pgoods + $penergy + $pfighters + $ptorp) > 100.0)
      {
        echo "$l_planet_p_over<BR><BR>";
      }
      else
      {
        $db->Execute("UPDATE $dbtables[planets] SET prod_ore=$pore,prod_organics=$porganics,prod_goods=$pgoods,prod_energy=$penergy,prod_fighters=$pfighters,prod_torp=$ptorp WHERE planet_id=$planet_id");
        echo "$l_planet_p_changed<BR><BR>";
      }
    }
    else
    {
      echo "$l_command_no<BR>";
    }
  }
  else
  {
    /* player doesn't own planet and there is a command */
    if($command == "buy")
    {
      if($planetinfo[sells] == "Y")
      {
        $ore_price = ($ore_price + $ore_delta / 4);
        $organics_price = ($organics_price + $organics_delta / 4);
        $goods_price = ($goods_price + $goods_delta / 4);
        $energy_price = ($energy_price + $energy_delta / 4);
        echo "<form action=planet3.php?planet_id=$planet_id method=post>";
        echo "<table>";
        echo "<tr><td>$l_commodity</td><td>$l_avail</td><td>$l_price</td><td>$l_buy</td><td>$l_cargo</td></tr>";
        echo "<tr><td>$l_ore</td><td>$planetinfo[ore]</td><td>$ore_price</td><td><input type=text name=trade_ore size=10 maxlength=20 value=0></td><td>$playerinfo[ship_ore]</td></tr>";
        echo "<tr><td>$l_organics</td><td>$planetinfo[organics]</td><td>$organics_price</td><td><input type=text name=trade_organics size=10 maxlength=20 value=0></td><td>$playerinfo[ship_organics]</td></tr>";
        echo "<tr><td>$l_goods</td><td>$planetinfo[goods]</td><td>$goods_price</td><td><input type=text name=trade_goods size=10 maxlength=20 value=0></td><td>$playerinfo[ship_goods]</td></tr>";
        echo "<tr><td>$l_energy</td><td>$planetinfo[energy]</td><td>$energy_price</td><td><input type=text name=trade_energy size=10 maxlength=20 value=0></td><td>$playerinfo[ship_energy]</td></tr>";
        echo "</table>";
        echo "<input type=submit value=$l_submit><input type=reset value=$l_reset><BR></form>";
      }
      else
      {
        echo "$l_planet_not_selling<BR>";
      }
    }
    elseif($command == "attac")
    {
//check to see if sure...
    if($planetinfo[sells] == "Y")
      {
               $l_planet_buy_link="<a href=planet.php?planet_id=$planet_id&command=buy>" . $l_planet_buy_link ."</a>";
		       $l_planet_buy=str_replace("[buy]",$l_planet_buy_link,$l_planet_buy);
        echo "$l_planet_buy<BR>";
      }
      else
      {
        echo "$l_planet_not_selling<BR>";
      }
       $l_planet_att_link="<a href=planet.php?planet_id=$planet_id&command=attack>" . $l_planet_att_link ."</a>";
       $l_planet_att=str_replace("[attack]",$l_planet_att_link,$l_planet_att);
       $l_planet_scn_link="<a href=planet.php?planet_id=$planet_id&command=scan>" . $l_planet_scn_link ."</a>";
       $l_planet_scn=str_replace("[scan]",$l_planet_scn_link,$l_planet_scn);
      echo "$l_planet_att <b>$l_planet_att_sure</b><BR>";
      echo "$l_planet_scn<BR>";
	if($sofa_on) echo "<a href=planet.php?planet_id=$planet_id&command=bom>$l_sofa</a><BR>";
    }
    elseif($command == "attack")
    {
    	planetcombat();
    }

    elseif($command == "bom")
    {
//check to see if sure...
    if($planetinfo[sells] == "Y" && $sofa_on)
      {
               $l_planet_buy_link="<a href=planet.php?planet_id=$planet_id&command=buy>" . $l_planet_buy_link ."</a>";
		       $l_planet_buy=str_replace("[buy]",$l_planet_buy_link,$l_planet_buy);
        echo "$l_planet_buy<BR>";
      }
      else
      {
        echo "$l_planet_not_selling<BR>";
      }
       $l_planet_att_link="<a href=planet.php?planet_id=$planet_id&command=attac>" . $l_planet_att_link ."</a>";
       $l_planet_att=str_replace("[attack]",$l_planet_att_link,$l_planet_att);
       $l_planet_scn_link="<a href=planet.php?planet_id=$planet_id&command=scan>" . $l_planet_scn_link ."</a>";
       $l_planet_scn=str_replace("[scan]",$l_planet_scn_link,$l_planet_scn);
      echo "$l_planet_att<BR>";
      echo "$l_planet_scn<BR>";
	echo "<a href=planet.php?planet_id=$planet_id&command=bomb>$l_sofa</a><b>$l_planet_att_sure</b><BR>";

    }
    elseif($command == "bomb" && $sofa_on)
    {
    	planetbombing();
    }

    elseif($command == "scan")
    {
      /* scan menu */
      if($playerinfo[turns] < 1)
      {
        echo "$l_plant_scn_turn<BR><BR>";
	    TEXT_GOTOMAIN();
        include("footer.php");
        die();
      }
      /* determine per cent chance of success in scanning target ship - based on player's sensors and opponent's cloak */
      $success = (10 - $ownerinfo[cloak] / 2 + $playerinfo[sensors]) * 5;
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
        echo "$l_planet_noscan<BR><BR>";
        TEXT_GOTOMAIN();
        playerlog($ownerinfo[ship_id], LOG_PLANET_SCAN_FAIL, "$planetinfo[name]|$playerinfo[sector]|$playerinfo[character_name]");
        include("footer.php");
        die();
      }
      else
      {
        playerlog($ownerinfo[ship_id], LOG_PLANET_SCAN, "$planetinfo[name]|$playerinfo[sector]|$playerinfo[character_name]");
        /* scramble results by scan error factor. */
        $sc_error= SCAN_ERROR($playerinfo[sensors], $targetinfo[cloak]);
        if(empty($planetinfo[name]))
           $planetinfo[name] = $l_unnamed;
        $l_planet_scn_report=str_replace("[name]",$planetinfo[name],$l_planet_scn_report);
        $l_planet_scn_report=str_replace("[owner]",$ownerinfo[character_name],$l_planet_scn_report);
        echo "$l_planet_scn_report<BR><BR>";
        echo "<table>";
        echo "<tr><td>$l_commodities:</td><td></td>";
        echo "<tr><td>$l_organics:</td>";
        $roll = rand(1, 100);
        if($roll < $success)
        {
          $sc_planet_organics=NUMBER(round($planetinfo[organics] * $sc_error / 100));
          echo "<td>$sc_planet_organics</td></tr>";
        }
        else
        {
          echo "<td>???</td></tr>";
        }
        echo "<tr><td>$l_ore:</td>";
        $roll = rand(1, 100);
        if($roll < $success)
        {
          $sc_planet_ore=NUMBER(round($planetinfo[ore] * $sc_error / 100));
          echo "<td>$sc_planet_ore</td></tr>";
        }
        else
        {
          echo "<td>???</td></tr>";
        }
        echo "<tr><td>$l_goods:</td>";
        $roll = rand(1, 100);
        if($roll < $success)
        {
          $sc_planet_goods=NUMBER(round($planetinfo[goods] * $sc_error / 100));
          echo "<td>$sc_planet_goods</td></tr>";
        }
        else
        {
          echo "<td>???</td></tr>";
        }
        echo "<tr><td>$l_energy:</td>";
        $roll = rand(1, 100);
        if($roll < $success)
        {
          $sc_planet_energy=NUMBER(round($planetinfo[energy] * $sc_error / 100));
          echo "<td>$sc_planet_energy</td></tr>";
        }
        else
        {
          echo "<td>???</td></tr>";
        }
        echo "<tr><td>$l_colonists:</td>";
        $roll = rand(1, 100);
        if($roll < $success)
        {
          $sc_planet_colonists=NUMBER(round($planetinfo[colonists] * $sc_error / 100));
          echo "<td>$sc_planet_colonists</td></tr>";
        }
        else
        {
          echo "<td>???</td></tr>";
        }
        echo "<tr><td>$l_credits:</td>";
        $roll = rand(1, 100);
        if($roll < $success)
        {
          $sc_planet_credits=NUMBER(round($planetinfo[credits] * $sc_error / 100));
          echo "<td>$sc_planet_credits</td></tr>";
        }
        else
        {
          echo "<td>???</td></tr>";
        }
        echo "<tr><td>$l_defense:</td><td></td>";
        echo "<tr><td>$l_base:</td>";
        $roll = rand(1, 100);
        if($roll < $success)
        {
          echo "<td>$planetinfo[base]</td></tr>";
        }
        else
        {
          echo "<td>???</td></tr>";
        }
        echo "<tr><td>$l_base $l_torps:</td>";
        $roll = rand(1, 100);
        if($roll < $success)
        {
          $sc_base_torp=NUMBER(round($planetinfo[torps] * $sc_error / 100));
          echo "<td>$sc_base_torp</td></tr>";
        }
        else
        {
          echo "<td>???</td></tr>";
        }
        echo "<tr><td>$l_fighters:</td>";
        $roll = rand(1, 100);
        if($roll < $success)
        {
          $sc_planet_fighters=NUMBER(round($planetinfo[fighters] * $sc_error / 100));
          echo "<td>$sc_planet_fighters</td></tr>";
        }
        else
        {
          echo "<td>???</td></tr>";
        }
        echo "<tr><td>$l_beams:</td>";
        $roll = rand(1, 100);
        if($roll < $success)
        {
          $sc_beams=NUMBER(round($ownerinfo[beams] * $sc_error / 100));
          echo "<td>$sc_beams</td></tr>";
        }
        else
        {
          echo "<td>???</td></tr>";
        }
        echo "<tr><td>$l_torp_launch:</td>";
        $roll = rand(1, 100);
        if($roll < $success)
        {
          $sc_torp_launchers=NUMBER(round($ownerinfo[torp_launchers] * $sc_error / 100));
          echo "<td>$sc_torp_launchers</td></tr>";
        }
        else
        {
          echo "<td>???</td></tr>";
        }
        echo "<tr><td>$l_shields</td>";
        $roll=rand(1, 100);
        if($roll < $success)
        {
          $sc_shields=NUMBER(round($ownerinfo[shields] * $sc_error / 100));
          echo "<td>$sc_shields</td></tr>";
        }
        else
        {
          echo "<td>???</td></tr>";
        }
        echo "</table><BR>";
//         $roll=rand(1, 100);
//         if($ownerinfo[sector] == $playerinfo[sector] && $ownerinfo[on_planet] == 'Y' && $roll < $success)
//         {
//           echo "<B>$ownerinfo[character_name] $l_planet_ison</B><BR>";
//         }
        
       $res = $db->Execute("SELECT * FROM $dbtables[ships] WHERE on_planet = 'Y' and planet_id = $planet_id"); 

       while(!$res->EOF)       
       { 
         $row = $res->fields;       
         $success = SCAN_SUCCESS($playerinfo[sensors], $row[cloak]);
         if($success < 5)
         {
           $success = 5;
         }
         if($success > 95)
         {
           $success = 95;
         }
         $roll = rand(1, 100);

         if($roll < $success)
         {
           echo "<B>$row[character_name] $l_planet_ison</B><BR>";
         }  
         $res->MoveNext();
       }
        //
        
      }
      $update = $db->Execute("UPDATE $dbtables[ships] SET turns=turns-1, turns_used=turns_used+1 WHERE ship_id=$playerinfo[ship_id]");
    }
    elseif($command == "capture" &&  $planetinfo[owner] == 0)
    {
      echo "$l_planet_captured<BR>";
      $update = $db->Execute("UPDATE $dbtables[planets] SET corp=null, owner=$playerinfo[ship_id], base='N', defeated='N' WHERE planet_id=$planet_id");
      $ownership = calc_ownership($playerinfo[sector]);

        if(!empty($ownership))

          echo "$ownership<p>";
      if($planetinfo[owner] != 0)
      {
        gen_score($planetinfo[owner]);
      }
      
      if($planetinfo[owner] != 0)
      {
        $res = $db->Execute("SELECT character_name FROM $dbtables[ships] WHERE ship_id=$planetinfo[owner]");
        $query = $res->fields;
        $planetowner=$query[character_name];
      }
      else
        $planetowner="$l_planet_noone";

      playerlog($playerinfo[player_id], LOG_PLANET_CAPTURED, "$planetinfo[colonists]|$planetinfo[credits]|$planetowner");
      
    }
    elseif($command == "capture" &&  ($planetinfo[owner] == 0 || $planetinfo[defeated] == 'Y'))
    {
      echo "$l_planet_notdef<BR>";
      $db->Execute("UPDATE $dbtables[planets] SET defeated='N' WHERE planet_id=$planetinfo[planet_id]");
    }
    else
    {
      echo "$l_command_no<BR>";
    }
  }
}
else
{
  echo "$l_planet_none<p>";
}
if($command != "")
{
  echo "<BR><a href=planet.php?planet_id=$planet_id>$l_clickme</a> $l_toplanetmenu<BR><BR>";
}
if($allow_ibank)
{
  echo "$l_ifyouneedplan <A HREF=\"igb.php?planet_id=$planet_id\">$l_igb_term</A>.<BR><BR>";
}
echo "<A HREF =\"bounty.php\">$l_by_placebounty</A><p>";

//-------------------------------------------------------------------------------------------------
TEXT_GOTOMAIN();

include("footer.php");


?>
