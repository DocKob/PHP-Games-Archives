<?php
//$Id: admin.php 39 2006-01-18 05:19:56Z phpfixer $

include("config.php");
include("languages/$lang");
updatecookie();

$title="Administration";
include("header.php");

connectdb();
bigtitle();

function CHECKED($yesno)
{
  return(($yesno == "Y") ? "CHECKED" : "");
}

function YESNO($onoff)
{
  return(($onoff == "ON") ? "Y" : "N");
}

$module = $menu;

if($swordfish != $adminpass)
{
  echo "<FORM ACTION=admin.php METHOD=POST>";
  echo "Password: <INPUT TYPE=PASSWORD NAME=swordfish SIZE=20 MAXLENGTH=20>&nbsp;&nbsp;";
  echo "<INPUT TYPE=SUBMIT VALUE=Submit><INPUT TYPE=RESET VALUE=Reset>";
  echo "</FORM>";
}
else
{
  if(empty($module))
  {
    echo "Welcome to the BlackNova Traders administration module<BR><BR>";
    echo "Select a function from the list below:<BR>";
    echo "<FORM ACTION=admin.php METHOD=POST>";
    echo "<SELECT NAME=menu>";
    echo "<OPTION VALUE=useredit SELECTED>User editor</OPTION>";
    echo "<OPTION VALUE=univedit>Universe editor</OPTION>";
    echo "<OPTION VALUE=sectedit>Sector editor</OPTION>";
    echo "<OPTION VALUE=planedit>Planet editor</OPTION>";
    echo "<OPTION VALUE=linkedit>Link editor</OPTION>";
    echo "<OPTION VALUE=zoneedit>Zone editor</OPTION>";
    echo "<OPTION VALUE=ipedit>IP bans editor</OPTION>";
    echo "<OPTION VALUE=logview>Log Viewer</OPTION>";
    echo "</SELECT>";
    echo "<INPUT TYPE=HIDDEN NAME=swordfish VALUE=$swordfish>";
    echo "&nbsp;<INPUT TYPE=SUBMIT VALUE=Submit>";
    echo "</FORM>";
  }
  else
  {
    $button_main = true;

    if($module == "useredit")
    {
      echo "<B>User editor</B>";
      echo "<BR>";
      echo "<FORM ACTION=admin.php METHOD=POST>";
      if(empty($user))
      {
        echo "<SELECT SIZE=20 NAME=user>";
        $res = $db->Execute("SELECT ship_id,character_name FROM $dbtables[ships] ORDER BY character_name");
        while(!$res->EOF)
        {
          $row=$res->fields;
          echo "<OPTION VALUE=$row[ship_id]>$row[character_name]</OPTION>";
          $res->MoveNext();
        }
        echo "</SELECT>";
        echo "&nbsp;<INPUT TYPE=SUBMIT VALUE=Edit>";
      }
      else
      {
        if(empty($operation))
        {
          $res = $db->Execute("SELECT * FROM $dbtables[ships] WHERE ship_id=$user");
          $row = $res->fields;
          echo "<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=5>";
          echo "<TR><TD>Player name</TD><TD><INPUT TYPE=TEXT NAME=character_name VALUE=\"$row[character_name]\"></TD></TR>";
          echo "<TR><TD>Password</TD><TD><INPUT TYPE=TEXT NAME=password2 VALUE=\"$row[password]\"></TD></TR>";
          echo "<TR><TD>E-mail</TD><TD><INPUT TYPE=TEXT NAME=email VALUE=\"$row[email]\"></TD></TR>";
          echo "<TR><TD>ID</TD><TD>$user</TD></TR>";
          echo "<TR><TD>Ship</TD><TD><INPUT TYPE=TEXT NAME=ship_name VALUE=\"$row[ship_name]\"></TD></TR>";
          echo "<TR><TD>Destroyed?</TD><TD><INPUT TYPE=CHECKBOX NAME=ship_destroyed VALUE=ON " . CHECKED($row[ship_destroyed]) . "></TD></TR>";
          echo "<TR><TD>Levels</TD>";
          echo "<TD><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=5>";
          echo "<TR><TD>Hull</TD><TD><INPUT TYPE=TEXT SIZE=5 NAME=hull VALUE=\"$row[hull]\"></TD>";
          echo "<TD>Engines</TD><TD><INPUT TYPE=TEXT SIZE=5 NAME=engines VALUE=\"$row[engines]\"></TD>";
          echo "<TD>Power</TD><TD><INPUT TYPE=TEXT SIZE=5 NAME=power VALUE=\"$row[power]\"></TD>";
          echo "<TD>Computer</TD><TD><INPUT TYPE=TEXT SIZE=5 NAME=computer VALUE=\"$row[computer]\"></TD></TR>";
          echo "<TR><TD>Sensors</TD><TD><INPUT TYPE=TEXT SIZE=5 NAME=sensors VALUE=\"$row[sensors]\"></TD>";
          echo "<TD>Armour</TD><TD><INPUT TYPE=TEXT SIZE=5 NAME=armor VALUE=\"$row[armor]\"></TD>";
          echo "<TD>Shields</TD><TD><INPUT TYPE=TEXT SIZE=5 NAME=shields VALUE=\"$row[shields]\"></TD>";
          echo "<TD>Beams</TD><TD><INPUT TYPE=TEXT SIZE=5 NAME=beams VALUE=\"$row[beams]\"></TD></TR>";
          echo "<TR><TD>Torpedoes</TD><TD><INPUT TYPE=TEXT SIZE=5 NAME=torp_launchers VALUE=\"$row[torp_launchers]\"></TD>";
          echo "<TD>Cloak</TD><TD><INPUT TYPE=TEXT SIZE=5 NAME=cloak VALUE=\"$row[cloak]\"></TD></TR>";
          echo "</TABLE></TD></TR>";
          echo "<TR><TD>Holds</TD>";
          echo "<TD><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=5>";
          echo "<TR><TD>Ore</TD><TD><INPUT TYPE=TEXT SIZE=8 NAME=ship_ore VALUE=\"$row[ship_ore]\"></TD>";
          echo "<TD>Organics</TD><TD><INPUT TYPE=TEXT SIZE=8 NAME=ship_organics VALUE=\"$row[ship_organics]\"></TD>";
          echo "<TD>Goods</TD><TD><INPUT TYPE=TEXT SIZE=8 NAME=ship_goods VALUE=\"$row[ship_goods]\"></TD></TR>";
          echo "<TR><TD>Energy</TD><TD><INPUT TYPE=TEXT SIZE=8 NAME=ship_energy VALUE=\"$row[ship_energy]\"></TD>";
          echo "<TD>Colonists</TD><TD><INPUT TYPE=TEXT SIZE=8 NAME=ship_colonists VALUE=\"$row[ship_colonists]\"></TD></TR>";
          echo "</TABLE></TD></TR>";
          echo "<TR><TD>Combat</TD>";
          echo "<TD><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=5>";
          echo "<TR><TD>Fighters</TD><TD><INPUT TYPE=TEXT SIZE=8 NAME=ship_fighters VALUE=\"$row[ship_fighters]\"></TD>";
          echo "<TD>Torpedoes</TD><TD><INPUT TYPE=TEXT SIZE=8 NAME=torps VALUE=\"$row[torps]\"></TD></TR>";
          echo "<TR><TD>Armour Pts</TD><TD><INPUT TYPE=TEXT SIZE=8 NAME=armor_pts VALUE=\"$row[armor_pts]\"></TD></TR>";
          echo "</TABLE></TD></TR>";
          echo "<TR><TD>Devices</TD>";
          echo "<TD><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=5>";
          echo "<TR><TD>Beacons</TD><TD><INPUT TYPE=TEXT SIZE=5 NAME=dev_beacon VALUE=\"$row[dev_beacon]\"></TD>";
          echo "<TD>Warp Editors</TD><TD><INPUT TYPE=TEXT SIZE=5 NAME=dev_warpedit VALUE=\"$row[dev_warpedit]\"></TD>";
          echo "<TD>Genesis Torpedoes</TD><TD><INPUT TYPE=TEXT SIZE=5 NAME=dev_genesis VALUE=\"$row[dev_genesis]\"></TD></TR>";
          echo "<TR><TD>Mine Deflectors</TD><TD><INPUT TYPE=TEXT SIZE=5 NAME=dev_minedeflector VALUE=\"$row[dev_minedeflector]\"></TD>";
          echo "<TD>Emergency Warp</TD><TD><INPUT TYPE=TEXT SIZE=5 NAME=dev_emerwarp VALUE=\"$row[dev_emerwarp]\"></TD></TR>";
          echo "<TR><TD>Escape Pod</TD><TD><INPUT TYPE=CHECKBOX NAME=dev_escapepod VALUE=ON " . CHECKED($row[dev_escapepod]) . "></TD>";
          echo "<TD>FuelScoop</TD><TD><INPUT TYPE=CHECKBOX NAME=dev_fuelscoop VALUE=ON " . CHECKED($row[dev_fuelscoop]) . "></TD></TR>";
          echo "</TABLE></TD></TR>";
          echo "<TR><TD>Credits</TD><TD><INPUT TYPE=TEXT NAME=credits VALUE=\"$row[credits]\"></TD></TR>";
          echo "<TR><TD>Turns</TD><TD><INPUT TYPE=TEXT NAME=turns VALUE=\"$row[turns]\"></TD></TR>";
          echo "<TR><TD>Current sector</TD><TD><INPUT TYPE=TEXT NAME=sector VALUE=\"$row[sector]\"></TD></TR>";
          echo "</TABLE>";
          echo "<BR>";
          echo "<INPUT TYPE=HIDDEN NAME=user VALUE=$user>";
          echo "<INPUT TYPE=HIDDEN NAME=operation VALUE=save>";
          echo "<INPUT TYPE=SUBMIT VALUE=Save>";
        }
        elseif($operation == "save")
        {
          // update database
          $_ship_destroyed = empty($ship_destroyed) ? "N" : "Y";
          $_dev_escapepod = empty($dev_escapepod) ? "N" : "Y";
          $_dev_fuelscoop = empty($dev_fuelscoop) ? "N" : "Y";
          $db->Execute("UPDATE $dbtables[ships] SET character_name='$character_name',password='$password2',email='$email',ship_name='$ship_name',ship_destroyed='$_ship_destroyed',hull='$hull',engines='$engines',power='$power',computer='$computer',sensors='$sensors',armor='$armor',shields='$shields',beams='$beams',torp_launchers='$torp_launchers',cloak='$cloak',credits='$credits',turns='$turns',dev_warpedit='$dev_warpedit',dev_genesis='$dev_genesis',dev_beacon='$dev_beacon',dev_emerwarp='$dev_emerwarp',dev_escapepod='$_dev_escapepod',dev_fuelscoop='$_dev_fuelscoop',dev_minedeflector='$dev_minedeflector',sector='$sector',ship_ore='$ship_ore',ship_organics='$ship_organics',ship_goods='$ship_goods',ship_energy='$ship_energy',ship_colonists='$ship_colonists',ship_fighters='$ship_fighters',torps='$torps',armor_pts='$armor_pts' WHERE ship_id=$user");
          echo "Changes saved<BR><BR>";
          echo "<INPUT TYPE=SUBMIT VALUE=\"Return to User editor\">";
          $button_main = false;
        }
        else
        {
          echo "Invalid operation";
        }
      }
      echo "<INPUT TYPE=HIDDEN NAME=menu VALUE=useredit>";
      echo "<INPUT TYPE=HIDDEN NAME=swordfish VALUE=$swordfish>";
      echo "</FORM>";
    }
    elseif($module == "univedit")
    {
      echo "<B>Universe editor</B>";

        $title="Expand/Contract the Universe";
        echo "<BR>Expand or Contract the Universe <BR>";


        if (empty($action))
        {
        echo "<FORM ACTION=admin.php METHOD=POST>";
        echo "Universe Size: <INPUT TYPE=TEXT NAME=radius VALUE=\"$universe_size\">";
        echo "<INPUT TYPE=HIDDEN NAME=swordfish VALUE=$swordfish>";
        echo "<INPUT TYPE=HIDDEN NAME=menu VALUE=univedit>";
        echo "<INPUT TYPE=HIDDEN NAME=action VALUE=doexpand> ";
        echo "<INPUT TYPE=SUBMIT VALUE=\"Play God\">";
        echo "</FORM>";
        }
        elseif ($action == "doexpand")
        {
        echo "<BR><FONT SIZE='+2'>Be sure to update your config.php file with the new universe_size value</FONT><BR>";
        srand((double)microtime()*1000000);
        $result = $db->Execute("SELECT sector_id FROM $dbtables[universe] ORDER BY sector_id ASC");
        while (!$result->EOF)
        {
                $row=$result->fields;
                $distance=rand(1,$radius);
                $db->Execute("UPDATE $dbtables[universe] SET distance=$distance WHERE sector_id=$row[sector_id]");
                echo "Updated sector $row[sector_id] set to $distance<BR>";
                $result->MoveNext();
        }

    }
        }
    elseif($module == "sectedit")
    {
      echo "<H2>Sector editor</H2>";
      echo "<FORM ACTION=admin.php METHOD=POST>";
      if(empty($sector))
      {
        echo "<H5>Note: Cannot Edit Sector 0</H5>";
        echo "<SELECT SIZE=20 NAME=sector>";
        $res = $db->Execute("SELECT sector_id FROM $dbtables[universe] ORDER BY sector_id");
        while(!$res->EOF)
        {
          $row=$res->fields;
          echo "<OPTION VALUE=$row[sector_id]> $row[sector_id] </OPTION>";
          $res->MoveNext();
        }
        echo "</SELECT>";
        echo "&nbsp;<INPUT TYPE=SUBMIT VALUE=Edit>";
      }
      else
      {
        if(empty($operation))
        {
          $res = $db->Execute("SELECT * FROM $dbtables[universe] WHERE sector_id=$sector");
          $row = $res->fields;

          echo "<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=2>";
          echo "<TR><TD><tt>          Sector ID  </tt></TD><TD><FONT COLOR=#66FF00>$sector</FONT></TD>";
          echo "<TD ALIGN=Right><tt>  Sector Name</tt></TD><TD><INPUT TYPE=TEXT SIZE=15 NAME=sector_name VALUE=\"$row[sector_name]\"></TD>";
          echo "<TD ALIGN=Right><tt>  Zone ID    </tt></TD><TD>";
                                      echo "<SELECT SIZE=1 NAME=zone_id>";
                                      $ressubb = $db->Execute("SELECT zone_id,zone_name FROM $dbtables[zones] ORDER BY zone_name");
                                      while(!$ressubb->EOF)
                                      {
                                        $rowsubb=$ressubb->fields;
                                        if ($rowsubb[zone_id] == $row[zone_id])
                                        {
                                        echo "<OPTION SELECTED=$rowsubb[zone_id] VALUE=$rowsubb[zone_id]>$rowsubb[zone_name]</OPTION>";
                                        } else {
                                        echo "<OPTION VALUE=$rowsubb[zone_id]>$rowsubb[zone_name]</OPTION>";
                                        }
                                        $ressubb->MoveNext();
                                      }
                                      echo "</SELECT></TD></TR>";
          echo "<TR><TD><tt>          Beacon     </tt></TD><TD COLSPAN=5><INPUT TYPE=TEXT SIZE=70 NAME=beacon VALUE=\"$row[beacon]\"></TD></TR>";
          echo "<TR><TD><tt>          Distance   </tt></TD><TD><INPUT TYPE=TEXT SIZE=9 NAME=distance VALUE=\"$row[distance]\"></TD>";
          echo "<TD ALIGN=Right><tt>  Angle1     </tt></TD><TD><INPUT TYPE=TEXT SIZE=9 NAME=angle1 VALUE=\"$row[angle1]\"></TD>";
          echo "<TD ALIGN=Right><tt>  Angle2     </tt></TD><TD><INPUT TYPE=TEXT SIZE=9 NAME=angle2 VALUE=\"$row[angle2]\"></TD></TR>";
          echo "<TR><TD COLSPAN=6>    <HR>       </TD></TR>";
          echo "</TABLE>";

          echo "<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=2>";
          echo "<TR><TD><tt>          Port Type  </tt></TD><TD>";
                                      echo "<SELECT SIZE=1 NAME=port_type>";
                                      $oportnon = $oportorg = $oportore = $oportgoo = $oportene = "VALUE";
                                      if ($row[port_type] == "none") $oportnon = "SELECTED=none VALUE";
                                      if ($row[port_type] == "organics") $oportorg = "SELECTED=organics VALUE";
                                      if ($row[port_type] == "ore") $oportore = "SELECTED=ore VALUE";
                                      if ($row[port_type] == "goods") $oportgoo = "SELECTED=goods VALUE";
                                      if ($row[port_type] == "energy") $oportene = "SELECTED=energy VALUE";
                                      echo "<OPTION $oportnon=none>none</OPTION>";
                                      echo "<OPTION $oportorg=organics>organics</OPTION>";
                                      echo "<OPTION $oportore=ore>ore</OPTION>";
                                      echo "<OPTION $oportgoo=goods>goods</OPTION>";
                                      echo "<OPTION $oportene=energy>energy</OPTION>";
                                      echo "</SELECT></TD>";
          echo "<TD ALIGN=Right><tt>  Organics   </tt></TD><TD><INPUT TYPE=TEXT SIZE=9 NAME=port_organics VALUE=\"$row[port_organics]\"></TD>";
          echo "<TD ALIGN=Right><tt>  Ore        </tt></TD><TD><INPUT TYPE=TEXT SIZE=9 NAME=port_ore VALUE=\"$row[port_ore]\"></TD>";
          echo "<TD ALIGN=Right><tt>  Goods      </tt></TD><TD><INPUT TYPE=TEXT SIZE=9 NAME=port_goods VALUE=\"$row[port_goods]\"></TD>";
          echo "<TD ALIGN=Right><tt>  Energy     </tt></TD><TD><INPUT TYPE=TEXT SIZE=9 NAME=port_energy VALUE=\"$row[port_energy]\"></TD></TR>";
          echo "<TR><TD COLSPAN=10>   <HR>       </TD></TR>";
          echo "</TABLE>";

          echo "<BR>";
          echo "<INPUT TYPE=HIDDEN NAME=sector VALUE=$sector>";
          echo "<INPUT TYPE=HIDDEN NAME=operation VALUE=save>";
          echo "<INPUT TYPE=SUBMIT SIZE=1 VALUE=Save>";
        }
        elseif($operation == "save")
        {
          // update database
          $secupdate = $db->Execute("UPDATE $dbtables[universe] SET sector_name='$sector_name',zone_id='$zone_id',beacon='$beacon',port_type='$port_type',port_organics='$port_organics',port_ore='$port_ore',port_goods='$port_goods',port_energy='$port_energy',distance='$distance',angle1='$angle1',angle2='$angle2' WHERE sector_id=$sector");
          if(!$secupdate) {
            echo "Changes to Sector record have FAILED Due to the following Error:<BR><BR>";
            echo $db->ErrorMsg() . "<br>";
          } else {
            echo "Changes to Sector record have been saved.<BR><BR>";
          }
          echo "<INPUT TYPE=SUBMIT VALUE=\"Return to Sector editor\">";
          $button_main = false;
        }
        else
        {
          echo "Invalid operation";
        }
      }
      echo "<INPUT TYPE=HIDDEN NAME=menu VALUE=sectedit>";
      echo "<INPUT TYPE=HIDDEN NAME=swordfish VALUE=$swordfish>";
      echo "</FORM>";
    }
    elseif($module == "planedit")
    {
      echo "<H2>Planet editor</H2>";
      echo "<FORM ACTION=admin.php METHOD=POST>";
      if(empty($planet))
      {
        echo "<SELECT SIZE=15 NAME=planet>";
        $res = $db->Execute("SELECT planet_id, name, sector_id FROM $dbtables[planets] ORDER BY sector_id");
        while(!$res->EOF)
        {
          $row=$res->fields;
          if($row[name] == "")

            $row[name] = "Unnamed";

          echo "<OPTION VALUE=$row[planet_id]> $row[name] in sector $row[sector_id] </OPTION>";
          $res->MoveNext();
        }
        echo "</SELECT>";
        echo "&nbsp;<INPUT TYPE=SUBMIT VALUE=Edit>";
      }
      else
      {
        if(empty($operation))
        {
          $res = $db->Execute("SELECT * FROM $dbtables[planets] WHERE planet_id=$planet");
          $row = $res->fields;

          echo "<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=2>";
          echo "<TR><TD><tt>          Planet ID  </tt></TD><TD><FONT COLOR=#66FF00>$planet</FONT></TD>";
          echo "<TD ALIGN=Right><tt>  Sector ID  </tt><INPUT TYPE=TEXT SIZE=5 NAME=sector_id VALUE=\"$row[sector_id]\"></TD>";
          echo "<TD ALIGN=Right><tt>  Defeated   </tt><INPUT TYPE=CHECKBOX NAME=defeated VALUE=ON " . CHECKED($row[defeated]) . "></TD></TR>";
          echo "<TR><TD><tt>          Planet Name</tt></TD><TD><INPUT TYPE=TEXT SIZE=15 NAME=name VALUE=\"$row[name]\"></TD>";
          echo "<TD ALIGN=Right><tt>  Base       </tt><INPUT TYPE=CHECKBOX NAME=base VALUE=ON " . CHECKED($row[base]) . "></TD>";
          echo "<TD ALIGN=Right><tt>  Sells      </tt><INPUT TYPE=CHECKBOX NAME=sells VALUE=ON " . CHECKED($row[sells]) . "></TD></TR>";
          echo "<TR><TD COLSPAN=4>    <HR>       </TD></TR>";
          echo "</TABLE>";

          echo "<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=2>";
          echo "<TR><TD><tt>          Planet Owner</tt></TD><TD>";
                                      echo "<SELECT SIZE=1 NAME=owner>";
                                      $ressuba = $db->Execute("SELECT ship_id,character_name FROM $dbtables[ships] ORDER BY character_name");
                                      echo "<OPTION VALUE=0>No One</OPTION>";
                                      while(!$ressuba->EOF)
                                      {
                                      $rowsuba=$ressuba->fields;
                                      if ($rowsuba[ship_id] == $row[owner])
                                        {
                                        echo "<OPTION SELECTED=$rowsuba[ship_id] VALUE=$rowsuba[ship_id]>$rowsuba[character_name]</OPTION>";
                                        } else {
                                        echo "<OPTION VALUE=$rowsuba[ship_id]>$rowsuba[character_name]</OPTION>";
                                        }
                                        $ressuba->MoveNext();
                                      }
                                      echo "</SELECT></TD>";
          echo "<TD ALIGN=Right><tt>  Organics   </tt></TD><TD><INPUT TYPE=TEXT SIZE=9 NAME=organics VALUE=\"$row[organics]\"></TD>";
          echo "<TD ALIGN=Right><tt>  Ore        </tt></TD><TD><INPUT TYPE=TEXT SIZE=9 NAME=ore VALUE=\"$row[ore]\"></TD>";
          echo "<TD ALIGN=Right><tt>  Goods      </tt></TD><TD><INPUT TYPE=TEXT SIZE=9 NAME=goods VALUE=\"$row[goods]\"></TD>";
          echo "<TD ALIGN=Right><tt>  Energy     </tt></TD><TD><INPUT TYPE=TEXT SIZE=9 NAME=energy VALUE=\"$row[energy]\"></TD></TR>";
          echo "<TR><TD><tt>          Planet Corp</tt></TD><TD><INPUT TYPE=TEXT SIZE=5 NAME=corp VALUE=\"$row[corp]\"></TD>";
          echo "<TD ALIGN=Right><tt>  Colonists  </tt></TD><TD><INPUT TYPE=TEXT SIZE=9 NAME=colonists VALUE=\"$row[colonists]\"></TD>";
          echo "<TD ALIGN=Right><tt>  Credits    </tt></TD><TD><INPUT TYPE=TEXT SIZE=9 NAME=credits VALUE=\"$row[credits]\"></TD>";
          echo "<TD ALIGN=Right><tt>  Fighters   </tt></TD><TD><INPUT TYPE=TEXT SIZE=9 NAME=fighters VALUE=\"$row[fighters]\"></TD>";
          echo "<TD ALIGN=Right><tt>  Torpedoes  </tt></TD><TD><INPUT TYPE=TEXT SIZE=9 NAME=torps VALUE=\"$row[torps]\"></TD></TR>";
          echo "<TR><TD COLSPAN=2><tt>Planet Production</tt></TD>";
          echo "<TD ALIGN=Right><tt>  Organics   </tt></TD><TD><INPUT TYPE=TEXT SIZE=9 NAME=prod_organics VALUE=\"$row[prod_organics]\"></TD>";
          echo "<TD ALIGN=Right><tt>  Ore        </tt></TD><TD><INPUT TYPE=TEXT SIZE=9 NAME=prod_ore VALUE=\"$row[prod_ore]\"></TD>";
          echo "<TD ALIGN=Right><tt>  Goods      </tt></TD><TD><INPUT TYPE=TEXT SIZE=9 NAME=prod_goods VALUE=\"$row[prod_goods]\"></TD>";
          echo "<TD ALIGN=Right><tt>  Energy     </tt></TD><TD><INPUT TYPE=TEXT SIZE=9 NAME=prod_energy VALUE=\"$row[prod_energy]\"></TD></TR>";
          echo "<TR><TD COLSPAN=6><tt>Planet Production</tt></TD>";
          echo "<TD ALIGN=Right><tt>  Fighters   </tt></TD><TD><INPUT TYPE=TEXT SIZE=9 NAME=prod_fighters VALUE=\"$row[prod_fighters]\"></TD>";
          echo "<TD ALIGN=Right><tt>  Torpedoes  </tt></TD><TD><INPUT TYPE=TEXT SIZE=9 NAME=prod_torp VALUE=\"$row[prod_torp]\"></TD></TR>";
          echo "<TR><TD COLSPAN=10>   <HR>       </TD></TR>";
          echo "</TABLE>";

          echo "<BR>";
          echo "<INPUT TYPE=HIDDEN NAME=planet VALUE=$planet>";
          echo "<INPUT TYPE=HIDDEN NAME=operation VALUE=save>";
          echo "<INPUT TYPE=SUBMIT SIZE=1 VALUE=Save>";
        }
        elseif($operation == "save")
        {
          // update database
          $_defeated = empty($defeated) ? "N" : "Y";
          $_base = empty($base) ? "N" : "Y";
          $sells = empty($sells) ? "N" : "Y";
          $planupdate = $db->Execute("UPDATE $dbtables[planets] SET sector_id='$sector_id',defeated='$_defeated',name='$name',base='$_base',sells='$_sells',owner='$owner',organics='$organics',ore='$ore',goods='$goods',energy='$energy',corp='$corp',colonists='$colonists',credits='$credits',fighters='$fighters',torps='$torps',prod_organics='$prod_organics',prod_ore='$prod_ore',prod_goods='$prod_goods',prod_energy='$prod_energy',prod_fighters='$prod_fighters',prod_torp='$prod_torp' WHERE planet_id=$planet");
          if(!$planupdate) {
            echo "Changes to Planet record have FAILED Due to the following Error:<BR><BR>";
            echo $db->ErrorMsg() . "<br>";
          } else {
            echo "Changes to Planet record have been saved.<BR><BR>";
          }
          echo "<INPUT TYPE=SUBMIT VALUE=\"Return to Planet editor\">";
          $button_main = false;
        }
        else
        {
          echo "Invalid operation";
        }
      }
      echo "<INPUT TYPE=HIDDEN NAME=menu VALUE=planedit>";
      echo "<INPUT TYPE=HIDDEN NAME=swordfish VALUE=$swordfish>";
      echo "</FORM>";
    }
    elseif($module == "linkedit")
    {
      echo "<B>Link editor</B>";
    }
    elseif($module == "zoneedit")
    {
      echo "<B>Zone editor</B>";
      echo "<BR>";
      echo "<FORM ACTION=admin.php METHOD=POST>";
      if(empty($zone))
      {
        echo "<SELECT SIZE=20 NAME=zone>";
        $res = $db->Execute("SELECT zone_id,zone_name FROM $dbtables[zones] ORDER BY zone_name");
        while(!$res->EOF)
        {
          $row=$res->fields;
          echo "<OPTION VALUE=$row[zone_id]>$row[zone_name]</OPTION>";
          $res->MoveNext();
        }
        echo "</SELECT>";
        echo "<INPUT TYPE=HIDDEN NAME=operation VALUE=editzone>";
        echo "&nbsp;<INPUT TYPE=SUBMIT VALUE=Edit>";

      }
      else
      {
        if($operation == "editzone")
        {
          $res = $db->Execute("SELECT * FROM $dbtables[zones] WHERE zone_id=$zone");
          $row = $res->fields;
          echo "<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=5>";
          echo "<TR><TD>Zone ID</TD><TD>$row[zone_id]</TD></TR>";
          echo "<TR><TD>Zone Name</TD><TD><INPUT TYPE=TEXT NAME=zone_name VALUE=\"$row[zone_name]\"></TD></TR>";
          echo "<TR><TD>Allow Beacon</TD><TD><INPUT TYPE=CHECKBOX NAME=zone_beacon VALUE=ON " . CHECKED($row[allow_beacon]) . "></TD>";
          echo "<TR><TD>Allow Attack</TD><TD><INPUT TYPE=CHECKBOX NAME=zone_attack VALUE=ON " . CHECKED($row[allow_attack]) . "></TD>";
          echo "<TR><TD>Allow WarpEdit</TD><TD><INPUT TYPE=CHECKBOX NAME=zone_warpedit VALUE=ON " . CHECKED($row[allow_warpedit]) . "></TD>";
          echo "<TR><TD>Allow Planet</TD><TD><INPUT TYPE=CHECKBOX NAME=zone_planet VALUE=ON " . CHECKED($row[allow_planet]) . "></TD>";
          echo "</TABLE>";
          echo "<TR><TD>Max Hull</TD><TD><INPUT TYPE=TEXT NAME=zone_hull VALUE=\"$row[max_hull]\"></TD></TR>";
          echo "<BR>";
          echo "<INPUT TYPE=HIDDEN NAME=zone VALUE=$zone>";
          echo "<INPUT TYPE=HIDDEN NAME=operation VALUE=savezone>";
          echo "<INPUT TYPE=SUBMIT VALUE=Save>";
        }
        elseif($operation == "savezone")
        {
          // update database
          $_zone_beacon = empty($zone_beacon) ? "N" : "Y";
          $_zone_attack = empty($zone_attack) ? "N" : "Y";
          $_zone_warpedit = empty($zone_warpedit) ? "N" : "Y";
          $_zone_planet = empty($zone_planet) ? "N" : "Y";
          $db->Execute("UPDATE $dbtables[zones] SET zone_name='$zone_name',allow_beacon='$_zone_beacon' ,allow_attack='$_zone_attack' ,allow_warpedit='$_zone_warpedit' ,allow_planet='$_zone_planet', max_hull='$zone_hull' WHERE zone_id=$zone");
          echo "Changes saved<BR><BR>";
          echo "<INPUT TYPE=SUBMIT VALUE=\"Return to Zone Editor \">";
          $button_main = false;
        }
        else
        {
          echo "Invalid operation";
        }
      }
      echo "<INPUT TYPE=HIDDEN NAME=menu VALUE=zoneedit>";
      echo "<INPUT TYPE=HIDDEN NAME=swordfish VALUE=$swordfish>";
      echo "</FORM>";
    }
    elseif($module == "ipedit")
    {
      echo "<B>IP Bans editor</B><p>";
      if(empty($command))
      {
        echo "<FORM ACTION=admin.php METHOD=POST>";
        echo "<INPUT TYPE=HIDDEN NAME=swordfish VALUE=$swordfish>";
        echo "<INPUT TYPE=HIDDEN NAME=command VALUE=showips>";
        echo "<INPUT TYPE=HIDDEN NAME=menu VALUE=ipedit>";
        echo "<INPUT TYPE=SUBMIT VALUE=\"Show player's ips\">";
        echo "</form>";

        $res = $db->Execute("SELECT ban_mask FROM $dbtables[ip_bans]");
        while(!$res->EOF)
        {
          $bans[]=$res->fields[ban_mask];
          $res->MoveNext();
        }

        if(empty($bans))
          echo "<b>No IP bans are currently active.</b>";
        else
        {
          echo "<table border=1 cellspacing=1 cellpadding=2 width=100% align=center>" .
               "<tr bgcolor=$color_line2><td align=center colspan=7><b><font color=white>" .
               "Active IP Bans" .
               "</font></b>" .
               "</td></tr>" .
               "<tr align=center bgcolor=$color_line2>" .
               "<td><font size=2 color=white><b>Ban Mask</b></font></td>" .
               "<td><font size=2 color=white><b>Affected Players</b></font></td>" .
               "<td><font size=2 color=white><b>E-mail</b></font></td>" .
               "<td><font size=2 color=white><b>Operations</b></font></td>" .
               "</tr>";

          $curcolor=$color_line1;

          foreach($bans as $ban)
          {
            echo "<tr bgcolor=$curcolor>";
            if($curcolor == $color_line1)
              $curcolor = $color_line2;
            else
              $curcolor = $color_line1;

            $printban = str_replace("%", "*", $ban);
            echo "<td align=center><font size=2 color=white>$printban</td>" .
                 "<td align=center><font size=2 color=white>";

            $res = $db->Execute("SELECT character_name, ship_id, email FROM $dbtables[ships] WHERE ip_address LIKE '$ban'");
            unset($players);
            while(!$res->EOF)
            {
              $players[] = $res->fields;
              $res->MoveNext();
            }

            if(empty($players))
            {
              echo "None";
            }
            else
            {
              foreach($players as $player)
              {
                echo "<b>$player[character_name]</b><br>";
              }
            }

            echo "<td align=center><font size=2 color=white>";

            if(empty($players))
            {
              echo "N/A";
            }
            else
            {
              foreach($players as $player)
              {
                echo "$player[email]<br>";
              }
            }

            echo "<td align=center nowrap valign=center><font size=2 color=white>" .
                 "<form action=admin.php method=POST>" .
                 "<INPUT TYPE=HIDDEN NAME=swordfish VALUE=$swordfish>" .
                 "<INPUT TYPE=HIDDEN NAME=command VALUE=unbanip>" .
                 "<INPUT TYPE=HIDDEN NAME=menu VALUE=ipedit>" .
                 "<INPUT TYPE=HIDDEN NAME=ban VALUE=$ban>" .
                 "<INPUT TYPE=SUBMIT VALUE=Remove>" .
                 "</form>";

          }

          echo "</table><p>";
        }
      }
      elseif($command== 'showips')
      {
        $res = $db->Execute("SELECT DISTINCT ip_address FROM $dbtables[ships]");
        while(!$res->EOF)
        {
          $ips[]=$res->fields[ip_address];
          $res->MoveNext();
        }
        echo "<table border=1 cellspacing=1 cellpadding=2 width=100% align=center>" .
             "<tr bgcolor=$color_line2><td align=center colspan=7><b><font color=white>" .
             "Players sorted by IP address" .
             "</font></b>" .
             "</td></tr>" .
             "<tr align=center bgcolor=$color_line2>" .
             "<td><font size=2 color=white><b>IP address</b></font></td>" .
             "<td><font size=2 color=white><b>Players</b></font></td>" .
             "<td><font size=2 color=white><b>E-mail</b></font></td>" .
             "<td><font size=2 color=white><b>Operations</b></font></td>" .
             "</tr>";

        $curcolor=$color_line1;

        foreach($ips as $ip)
        {
          echo "<tr bgcolor=$curcolor>";
          if($curcolor == $color_line1)
            $curcolor = $color_line2;
          else
            $curcolor = $color_line1;

          echo "<td align=center><font size=2 color=white>$ip</td>" .
               "<td align=center><font size=2 color=white>";

          $res = $db->Execute("SELECT character_name, ship_id, email FROM $dbtables[ships] WHERE ip_address='$ip'");
          unset($players);
          while(!$res->EOF)
          {
            $players[] = $res->fields;
            $res->MoveNext();
          }

          foreach($players as $player)
          {
            echo "<b>$player[character_name]</b><br>";
          }

          echo "<td align=center><font size=2 color=white>";

          foreach($players as $player)
          {
            echo "$player[email]<br>";
          }

          echo "<td align=center nowrap valign=center><font size=2 color=white>" .
               "<form action=admin.php method=POST>" .
               "<INPUT TYPE=HIDDEN NAME=swordfish VALUE=$swordfish>" .
               "<INPUT TYPE=HIDDEN NAME=command VALUE=banip>" .
               "<INPUT TYPE=HIDDEN NAME=menu VALUE=ipedit>" .
               "<INPUT TYPE=HIDDEN NAME=ip VALUE=$ip>" .
               "<INPUT TYPE=SUBMIT VALUE=Ban>" .
               "</form>" .
               "<form action=admin.php method=POST>" .
               "<INPUT TYPE=HIDDEN NAME=swordfish VALUE=$swordfish>" .
               "<INPUT TYPE=HIDDEN NAME=command VALUE=unbanip>" .
               "<INPUT TYPE=HIDDEN NAME=menu VALUE=ipedit>" .
               "<INPUT TYPE=HIDDEN NAME=ip VALUE=$ip>" .
               "<INPUT TYPE=SUBMIT VALUE=Unban>" .
               "</form>";

        }

        echo "</table><p>" .
             "<form action=admin.php method=POST>" .
             "<INPUT TYPE=HIDDEN NAME=swordfish VALUE=$swordfish>" .
             "<INPUT TYPE=HIDDEN NAME=menu VALUE=ipedit>" .
             "<INPUT TYPE=SUBMIT VALUE=\"Return to IP bans menu\">" .
             "</form>";
      }
      elseif($command == 'banip')
      {
        $ip = $HTTP_POST_VARS[ip];
        echo "<b>Banning ip : $ip<p>";
        echo "<font size=2 color=white>Please select ban type :<p>";

        $ipparts = explode(".", $ip);

        echo "<table border=0>" .
             "<tr><td align=right>" .
             "<form action=admin.php method=POST>" .
             "<INPUT TYPE=HIDDEN NAME=swordfish VALUE=$swordfish>" .
             "<INPUT TYPE=HIDDEN NAME=menu VALUE=ipedit>" .
             "<INPUT TYPE=HIDDEN NAME=command VALUE=banip2>" .
             "<INPUT TYPE=HIDDEN NAME=ip VALUE=$ip>" .
             "<input type=radio name=class value=I checked>" .
             "<td><font size=2 color=white>IP only : $ip</td>" .
             "<tr><td>" .
             "<input type=radio name=class value=A>" .
             "<td><font size=2 color=white>Class A : $ipparts[0].$ipparts[1].$ipparts[2].*</td>" .
             "<tr><td>" .
             "<input type=radio name=class value=B>" .
             "<td><font size=2 color=white>Class B : $ipparts[0].$ipparts[1].*</td>" .
             "<tr><td><td><br><input type=submit value=Ban>" .
             "</table>" .
             "</form>";

        echo "<form action=admin.php method=POST>" .
             "<INPUT TYPE=HIDDEN NAME=swordfish VALUE=$swordfish>" .
             "<INPUT TYPE=HIDDEN NAME=menu VALUE=ipedit>" .
             "<INPUT TYPE=SUBMIT VALUE=\"Return to IP bans menu\">" .
             "</form>";
      }
      elseif($command == 'banip2')
      {
        $ip = $HTTP_POST_VARS[ip];
        $ipparts = explode(".", $ip);

        if($class == 'A')
          $banmask = "$ipparts[0].$ipparts[1].$ipparts[2].%";
        elseif($class == 'B')
          $banmask = "$ipparts[0].$ipparts[1].%";
        else
          $banmask = $ip;

        $printban = str_replace("%", "*", $banmask);
        echo "<font size=2 color=white><b>Successfully banned $printban</b>.<p>";

        $db->Execute("INSERT INTO $dbtables[ip_bans] VALUES(NULL, '$banmask')");
        $res = $db->Execute("SELECT DISTINCT character_name FROM $dbtables[ships], $dbtables[ip_bans] WHERE ip_address LIKE ban_mask");
        echo "Affected players :<p>";
        while (!$res->EOF)
        {
          echo " - " . $res->fields[character_name] . "<br>";
          $res->MoveNext();
        }

        echo "<form action=admin.php method=POST>" .
             "<INPUT TYPE=HIDDEN NAME=swordfish VALUE=$swordfish>" .
             "<INPUT TYPE=HIDDEN NAME=menu VALUE=ipedit>" .
             "<INPUT TYPE=SUBMIT VALUE=\"Return to IP bans menu\">" .
             "</form>";
      }
      elseif($command == 'unbanip')
      {
        $ip = $HTTP_POST_VARS[ip];

        if(!empty($ban))
          $res = $db->Execute("SELECT * FROM $dbtables[ip_bans] WHERE ban_mask='$ban'");
        else
          $res = $db->Execute("SELECT * FROM $dbtables[ip_bans] WHERE '$ip' LIKE ban_mask");

        $nbbans = $res->RecordCount();
        while(!$res->EOF)
        {
          $res->fields[print_mask] = str_replace("%", "*", $res->fields[ban_mask]);
          $bans[]=$res->fields;
          $res->MoveNext();
        }

        if(!empty($ban))
          $db->Execute("DELETE FROM $dbtables[ip_bans] WHERE ban_mask='$ban'");
        else
          $db->Execute("DELETE FROM $dbtables[ip_bans] WHERE '$ip' LIKE ban_mask");

        $query_string = "ip_address LIKE '" . $bans[0][ban_mask] ."'";
        for( $i = 1; $i < $nbbans ; $i++)
          $query_string = $query_string . " OR ip_address LIKE '" . $bans[$i][ban_mask] . "'";

        $res = $db->Execute("SELECT DISTINCT character_name FROM $dbtables[ships] WHERE $query_string");
        $nbplayers = $res->RecordCount();
        while(!$res->EOF)
        {
          $players[]=$res->fields[character_name];
          $res->MoveNext();
        }

        echo "<font size=2 color=white><b>Successfully removed $nbbans bans</b> :<p>";

        foreach($bans as $ban)
        {
          echo " - $ban[print_mask]<br>";
        }

        echo "<p><b>Affected players :</b><p>";
        if(empty($players))
          echo " - None<br>";
        else
        {
          foreach($players as $player)
          {
            echo " - $player<br>";
          }
        }

        echo "<form action=admin.php method=POST>" .
             "<INPUT TYPE=HIDDEN NAME=swordfish VALUE=$swordfish>" .
             "<INPUT TYPE=HIDDEN NAME=menu VALUE=ipedit>" .
             "<INPUT TYPE=SUBMIT VALUE=\"Return to IP bans menu\">" .
             "</form>";
      }

    }
    elseif($module == "logview")
    {
      echo "<form action=log.php method=POST>" .
           "<INPUT TYPE=HIDDEN NAME=swordfish VALUE=$swordfish>" .
           "<INPUT TYPE=HIDDEN NAME=player VALUE=0>" .
           "<INPUT TYPE=SUBMIT VALUE=\"View admin log\">" .
           "</form>" .
           "<form action=log.php method=POST>" .
           "<INPUT TYPE=HIDDEN NAME=swordfish VALUE=$swordfish>" .
           "<SELECT name=player>";

      $res = $db->execute("SELECT ship_id, character_name FROM $dbtables[ships] ORDER BY character_name ASC");
      while(!$res->EOF)
      {
        $players[] = $res->fields;
        $res->MoveNext();
      }

      foreach($players as $player)
        echo "<OPTION value=$player[ship_id]>$player[character_name]</OPTION>";

      echo "</SELECT>&nbsp;&nbsp;" .
           "<INPUT TYPE=SUBMIT VALUE=\"View player log\">" .
           "</form><HR size=1 width=80%>";
    }
    else
    {
      echo "Unknown function";
    }

    if($button_main)
    {
      echo "<p>";
      echo "<FORM ACTION=admin.php METHOD=POST>";
      echo "<INPUT TYPE=HIDDEN NAME=swordfish VALUE=$swordfish>";
      echo "<INPUT TYPE=SUBMIT VALUE=\"Return to main menu\">";
      echo "</FORM>";
    }
  }
}

include("footer.php");

?>
