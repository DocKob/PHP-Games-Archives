<?
include("config.php");
updatecookie();

include("languages/$lang");
$title=$l_pr_title;

include("header.php");

connectdb();

if(checklogin())
{
  die();
}

// Get data about planets
$res = $db->Execute("SELECT * FROM $dbtables[ships] WHERE email='$username'");
$playerinfo = $res->fields;


// determine what type of report is displayed and display it's title
if($PRepType==1 || !isset($PRepType)) // display the commodities on the planets
{
  $title = "$title: Status";
  bigtitle();
  standard_report();
}
elseif($PRepType==2)                  // display the production values of your planets and allow changing
{
  $title = "$title: Production";
  bigtitle();
  planet_production_change();
}
elseif($PRepType==0)                  // For typing in manually to get a report menu
{
  $title = "$title: Menu";
  bigtitle();
  planet_report_menu();
}
else                                  // display the menu if no valid options are passed in
{
  $title = "$title: Status";
  bigtitle();
  planet_report();
}


// ---- Begin functions ------ //
function planet_report_menu()
{
  global $playerinfo;
  global $l_pr_teamlink;

  echo "<B><A HREF=planet_report.php?PRepType=1 NAME=Planet Status>Planet Status</A></B><BR>" .
       "Displays the number of each Commodity on the planet (Ore, Organics, Goods, Energy, Colonists, Credits, Fighters, and Torpedoes)<BR>" .
       "<BR>" .
       "<B><A HREF=planet_report.php?PRepType=2 NAME=Planet Status>Change Production</A></B> &nbsp;&nbsp; <B>Base Required</B> on Planet<BR>" .
       "This Report allows you to change the rate of production of commondits on planets that have a base<BR>" .
       "-- You must travel to the planet to build a base set the planet to coporate or change the name (celebrations and such)<BR>";

  if ($playerinfo[team]>0)
  {
    echo "<BR>" .
         "<B><A HREF=team_planets.php>$l_pr_teamlink</A></B><BR> " . 
         "Commondity Report (like Planet Status) for planets marked Corporate by you and/or your fellow alliance member<BR>" .
         "<BR>";
  }
}


function standard_report()
{
  global $db;
  global $res;
  global $playerinfo;
  global $dbtables;
  global $username;
  global $sort;
  global $query;
  global $color_header, $color, $color_line1, $color_line2;
  global $l_pr_teamlink, $l_pr_clicktosort;
  global $l_sector, $l_name, $l_unnamed, $l_ore, $l_organics, $l_goods, $l_energy, $l_colonists, $l_credits, $l_fighters, $l_torps, $l_base, $l_selling, $l_pr_totals, $l_yes, $l_no;

  echo "Planetary report descriptions and <B><A HREF=planet_report.php?PRepType=0>menu</A></B><BR>" .
       "<BR>" .
       "<B><A HREF=planet_report.php?PRepType=2>Change Production</A></B> &nbsp;&nbsp; <B>Base Required</B> on Planet<BR>";

  if ($playerinfo[team]>0)
  {
    echo "<BR>" .
         "<B><A HREF=team_planets.php>$l_pr_teamlink</A></B><BR> " . 
         "<BR>";
  }


  $query = "SELECT * FROM $dbtables[planets] WHERE owner=$playerinfo[ship_id]";

  if(!empty($sort))
  {
    $query .= " ORDER BY";
    if($sort == "name")
    {
      $query .= " $sort ASC";
    }
    elseif($sort == "organics" || $sort == "ore" || $sort == "goods" || $sort == "energy" ||
      $sort == "colonists" || $sort == "credits" || $sort == "fighters")
    {
      $query .= " $sort DESC, sector_id ASC";
    }
    elseif($sort == "torp")
    {
      $query .= " torps DESC, sector_id ASC";
    }
    else
    {
      $query .= " sector_id ASC";
    }

  }
  else
  {
     $query .= " ORDER BY sector_id ASC";
  }

  $res = $db->Execute($query);

  $i = 0;
  if($res)
  {
    while(!$res->EOF)
    {
      $planet[$i] = $res->fields;
      $i++;
      $res->MoveNext();
    }
  }

  $num_planets = $i;
  if($num_planets < 1)
  {
    echo "<BR>$l_pr_noplanet";
  }
  else
  {

    echo "<BR>";
    echo "<FORM ACTION=planet_report_ce.php METHOD=POST>";

    // ------ next block of echo's creates the header of the table
    echo "$l_pr_clicktosort<BR><BR>";
    echo "<B>WARNING:</B> \"Build\" and \"Take Credits\" will cause your ship to move. <BR><BR>";
    echo "<TABLE WIDTH=\"100%\" BORDER=0 CELLSPACING=0 CELLPADDING=2>";
    echo "<TR BGCOLOR=\"$color_header\" VALIGN=BOTTOM>";
    echo "<TD><B><A HREF=planet_report.php?PRepType=1&sort=sector_id>$l_sector</A></B></TD>";
    echo "<TD><B><A HREF=planet_report.php?PRepType=1&sort=name>$l_name</A></B></TD>";
    echo "<TD><B><A HREF=planet_report.php?PRepType=1&sort=ore>$l_ore</A></B></TD>";
    echo "<TD><B><A HREF=planet_report.php?PRepType=1&sort=organics>$l_organics</A></B></TD>";
    echo "<TD><B><A HREF=planet_report.php?PRepType=1&sort=goods>$l_goods</A></B></TD>";
    echo "<TD><B><A HREF=planet_report.php?PRepType=1&sort=energy>$l_energy</A></B></TD>";
    echo "<TD ALIGN=CENTER><B><A HREF=planet_report.php?PRepType=1&sort=colonists>$l_colonists</A></B></TD>";
    echo "<TD ALIGN=CENTER><B><A HREF=planet_report.php?PRepType=1&sort=credits>$l_credits</A></B></TD>";
    echo "<TD ALIGN=CENTER><B>Take<BR>Credits</B></TD>";
    echo "<TD ALIGN=CENTER><B><A HREF=planet_report.php?PRepType=1&sort=fighters>$l_fighters</A></B></TD>";
    echo "<TD ALIGN=CENTER><B><A HREF=planet_report.php?PRepType=1&sort=torp>$l_torps</A></B></TD>";
    echo "<TD ALIGN=RIGHT><B>$l_base?</B></TD>";
    if($playerinfo[team] > 0)
      echo "<TD ALIGN=RIGHT><B>Corp?</B></TD>";
    echo "<TD ALIGN=RIGHT><B>$l_selling?</B></TD>";

    // ------ next block of echo's fils the table and calculates the totals of all the commoditites as well as counting the bases and selling planets
    echo "</TR>";
    $total_organics = 0;
    $total_ore = 0;
    $total_goods = 0;
    $total_energy = 0;
    $total_colonists = 0;
    $total_credits = 0;
    $total_fighters = 0;
    $total_torp = 0;
    $total_base = 0;
    $total_corp = 0;
    $total_selling = 0;
    $color = $color_line1;
    for($i=0; $i<$num_planets; $i++)
    {
      $total_organics += $planet[$i][organics];
      $total_ore += $planet[$i][ore];
      $total_goods += $planet[$i][goods];
      $total_energy += $planet[$i][energy];
      $total_colonists += $planet[$i][colonists];
      $total_credits += $planet[$i][credits];
      $total_fighters += $planet[$i][fighters];
      $total_torp += $planet[$i][torps];
      if($planet[$i][base] == "Y")
      {
        $total_base += 1;
      }
      if($planet[$i][corp] > 0)
      {
        $total_corp += 1;
      }
      if($planet[$i][sells] == "Y")
      {
        $total_selling += 1;
      }
      if(empty($planet[$i][name]))
      {
        $planet[$i][name] = $l_unnamed;
      }
      echo "<TR BGCOLOR=\"$color\">";
      echo "<TD><A HREF=rsmove.php?engage=1&destination=". $planet[$i][sector_id] . ">". $planet[$i][sector_id] ."</A></TD>";
      echo "<TD>" . $planet[$i][name] . "</TD>";
      echo "<TD>" . NUMBER($planet[$i][ore]) . "</TD>";
      echo "<TD>" . NUMBER($planet[$i][organics]) . "</TD>";
      echo "<TD>" . NUMBER($planet[$i][goods]) . "</TD>";
      echo "<TD>" . NUMBER($planet[$i][energy]) . "</TD>";
      echo "<TD ALIGN=RIGHT>" . NUMBER($planet[$i][colonists]) . "</TD>";
      echo "<TD ALIGN=RIGHT>" . NUMBER($planet[$i][credits]) . "</TD>";
      echo "<TD ALIGN=CENTER>" . "<INPUT TYPE=CHECKBOX NAME=TPCreds[] VALUE=\"" . $planet[$i]["planet_id"] . "\">" . "</TD>";
      echo "<TD ALIGN=RIGHT>"  . NUMBER($planet[$i][fighters]) . "</TD>";
      echo "<TD ALIGN=RIGHT>"  . NUMBER($planet[$i][torps]) . "</TD>";
      echo "<TD ALIGN=CENTER>" . base_build_check($planet, $i) . "</TD>";
      if($playerinfo[team] > 0)
        echo "<TD ALIGN=CENTER>" . ($planet[$i][corp] > 0  ? "$l_yes" : "$l_no") . "</TD>";
      echo "<TD ALIGN=CENTER>" . ($planet[$i][sells] == 'Y' ? "$l_yes" : "$l_no") . "</TD>";
      echo "</TR>";

      if($color == $color_line1)
      {
        $color = $color_line2;
      }
      else
      {
        $color = $color_line1;
      }
    }

    // the next block displays the totals
    echo "<TR BGCOLOR=$color>";
    echo "<TD COLSPAN=2 ALIGN=CENTER>$l_pr_totals</TD>";
    echo "<TD>" . NUMBER($total_ore) . "</TD>";
    echo "<TD>" . NUMBER($total_organics) . "</TD>";
    echo "<TD>" . NUMBER($total_goods) . "</TD>";
    echo "<TD>" . NUMBER($total_energy) . "</TD>";
    echo "<TD ALIGN=RIGHT>" . NUMBER($total_colonists) . "</TD>";
    echo "<TD ALIGN=RIGHT>" . NUMBER($total_credits) . "</TD>";
    echo "<TD></TD>";
    echo "<TD ALIGN=RIGHT>"  . NUMBER($total_fighters) . "</TD>";
    echo "<TD ALIGN=RIGHT>"  . NUMBER($total_torp) . "</TD>";
    echo "<TD ALIGN=CENTER>" . NUMBER($total_base) . "</TD>";
    if($playerinfo[team] > 0)
      echo "<TD ALIGN=CENTER>" . NUMBER($total_corp) . "</TD>";
    echo "<TD ALIGN=CENTER>" . NUMBER($total_selling) . "</TD>";
    echo "</TR>";
    echo "</TABLE>";

    echo "<BR>";
    echo "<INPUT TYPE=SUBMIT VALUE=\"Collect Credits\">  <INPUT TYPE=RESET VALUE=RESET>";
    echo "</FORM>";
  }
}



function planet_production_change()
{
  global $db;
  global $res;
  global $playerinfo;
  global $dbtables;
  global $username;
  global $sort;
  global $query;
  global $color_header, $color, $color_line1, $color_line2;
  global $l_pr_teamlink, $l_pr_clicktosort;
  global $l_sector, $l_name, $l_unnamed, $l_ore, $l_organics, $l_goods, $l_energy, $l_colonists, $l_credits, $l_fighters, $l_torps, $l_base, $l_selling, $l_pr_totals, $l_yes, $l_no;


  $query = "SELECT * FROM $dbtables[planets] WHERE owner=$playerinfo[ship_id] AND base='Y'";

  echo "Planetary report <B><A HREF=planet_report.php?PRepType=0>menu</A></B><BR>" .
       "<BR>" .
       "<B><A HREF=planet_report.php?PRepType=1>Planet Status</A></B><BR>";

  if ($playerinfo[team]>0)
  {
    echo "<BR>" .
         "<B><A HREF=team_planets.php>$l_pr_teamlink</A></B><BR> " . 
         "<BR>";
  }

  if(!empty($sort))
  {
    $query .= " ORDER BY";
    if($sort == "name")
    {
      $query .= " $sort ASC";
    }
    elseif($sort == "organics" || $sort == "ore" || $sort == "goods" || $sort == "energy" || $sort == "fighters")
    {
      $query .= " prod_$sort DESC, sector_id ASC";
    }
    elseif($sort == "colonists" || $sort == "credits")
    {
      $query .= " $sort DESC, sector_id ASC";
    }
    elseif($sort == "torp")
    {
      $query .= " prod_torp DESC, sector_id ASC";
    }
    else
    {
      $query .= " sector_id ASC";
    }

  }
  else
  {
     $query .= " ORDER BY sector_id ASC";
  }

  $res = $db->Execute($query);

  $i = 0;
  if($res)
  {
    while(!$res->EOF)
    {
      $planet[$i] = $res->fields;
      $i++;
      $res->MoveNext();
    }
  }

  $num_planets = $i;
  if($num_planets < 1)
  {
    echo "<BR>$l_pr_noplanet";
  }
  else
  {
    echo "<FORM ACTION=planet_report_ce.php METHOD=POST>";

// ------ next block of echo's creates the header of the table
    echo "$l_pr_clicktosort<BR><BR>";
    echo "<TABLE WIDTH=\"100%\" BORDER=0 CELLSPACING=0 CELLPADDING=2>";
    echo "<TR BGCOLOR=\"$color_header\" VALIGN=BOTTOM>";
    echo "<TD ALIGN=LEFT>  <B><A HREF=planet_report.php?PRepType=2&sort=sector_id>$l_sector</A></B></TD>";
    echo "<TD ALIGN=LEFT>  <B><A HREF=planet_report.php?PRepType=2&sort=name>$l_name</A></B></TD>";
    echo "<TD ALIGN=CENTER><B><A HREF=planet_report.php?PRepType=2&sort=ore>$l_ore</A></B></TD>";
    echo "<TD ALIGN=CENTER><B><A HREF=planet_report.php?PRepType=2&sort=organics>$l_organics</A></B></TD>";
    echo "<TD ALIGN=CENTER><B><A HREF=planet_report.php?PRepType=2&sort=goods>$l_goods</A></B></TD>";
    echo "<TD ALIGN=CENTER><B><A HREF=planet_report.php?PRepType=2&sort=energy>$l_energy</A></B></TD>";
    echo "<TD ALIGN=RIGHT> <B><A HREF=planet_report.php?PRepType=2&sort=colonists>$l_colonists</A></B></TD>";
    echo "<TD ALIGN=RIGHT> <B><A HREF=planet_report.php?PRepType=2&sort=credits>$l_credits</A></B></TD>";
    echo "<TD ALIGN=CENTER><B><A HREF=planet_report.php?PRepType=2&sort=fighters>$l_fighters</A></B></TD>";
    echo "<TD ALIGN=CENTER><B><A HREF=planet_report.php?PRepType=2&sort=torp>$l_torps</A></B></TD>";
//    echo "<TD ALIGN=CENTER><B>$l_base?</B></TD>";
    if($playerinfo[team] > 0)
      echo "<TD ALIGN=CENTER><B>Corp?</B></TD>";
    echo "<TD ALIGN=CENTER><B>$l_selling?</B></TD>";
    echo "</TR>";

    $total_colonists = 0;
    $total_credits = 0;
    $total_corp = 0;
    
    $temp_var = 0;

    $color = $color_line1;

    for($i=0; $i<$num_planets; $i++)
    {
      $total_colonists += $planet[$i][colonists];
      $total_credits += $planet[$i][credits];
      if(empty($planet[$i][name]))
      {
        $planet[$i][name] = $l_unnamed;
      }
      echo "<TR BGCOLOR=\"$color\">";
      echo "<TD><A HREF=rsmove.php?engage=1&destination=". $planet[$i][sector_id] . ">". $planet[$i][sector_id] ."</A></TD>";
                                             echo "<TD>" . $planet[$i][name] . "</TD>";
      echo "<TD ALIGN=CENTER>" . "<input size=6 type=text name=\"prod_ore["      . $planet[$i]["planet_id"] . "]\" value=\"" . $planet[$i]["prod_ore"]      . "\">" . "</TD>";
      echo "<TD ALIGN=CENTER>" . "<input size=6 type=text name=\"prod_organics[" . $planet[$i]["planet_id"] . "]\" value=\"" . $planet[$i]["prod_organics"] . "\">" . "</TD>";
      echo "<TD ALIGN=CENTER>" . "<input size=6 type=text name=\"prod_goods["    . $planet[$i]["planet_id"] . "]\" value=\"" . $planet[$i]["prod_goods"]    . "\">" . "</TD>";
      echo "<TD ALIGN=CENTER>" . "<input size=6 type=text name=\"prod_energy["   . $planet[$i]["planet_id"] . "]\" value=\"" . $planet[$i]["prod_energy"]   . "\">" . "</TD>";
      echo "<TD ALIGN=RIGHT>"  . NUMBER($planet[$i][colonists])              . "</TD>";
      echo "<TD ALIGN=RIGHT>"  . NUMBER($planet[$i][credits])        . "</TD>";
      echo "<TD ALIGN=CENTER>" . "<input size=6 type=text name=\"prod_fighters[" . $planet[$i]["planet_id"] . "]\" value=\"" . $planet[$i]["prod_fighters"] . "\">" . "</TD>";
      echo "<TD ALIGN=CENTER>" . "<input size=6 type=text name=\"prod_torp["     . $planet[$i]["planet_id"] . "]\" value=\"" . $planet[$i]["prod_torp"]     . "\">" . "</TD>";
      if($playerinfo[team] > 0)
        echo "<TD ALIGN=CENTER>" . corp_planet_checkboxes($planet, $i) . "</TD>";
      echo "<TD ALIGN=CENTER>" . selling_checkboxes($planet, $i)     . "</TD>";
      echo "</TR>";

      if($color == $color_line1)
      {
        $color = $color_line2;
      }
      else
      {
        $color = $color_line1;
      }
    }
    echo "<TR BGCOLOR=$color>";
    echo "<TD COLSPAN=2 ALIGN=CENTER>$l_pr_totals</TD>";
    echo "<TD>" . "" . "</TD>";
    echo "<TD>" . "" . "</TD>";
    echo "<TD>" . "" . "</TD>";
    echo "<TD>" . "" . "</TD>";
    echo "<TD ALIGN=RIGHT>" . NUMBER($total_colonists) . "</TD>";
    echo "<TD ALIGN=RIGHT>" . NUMBER($total_credits)   . "</TD>";
    echo "<TD>" . "" . "</TD>";
    echo "<TD>" . "" . "</TD>";
    if($playerinfo[team] > 0)
      echo "<TD></TD>";
    echo "<TD></TD>";
    echo "</TR>";
    echo "</TABLE>";

    echo "<BR>";
    echo "<INPUT TYPE=HIDDEN NAME=ship_id VALUE=$playerinfo[ship_id]>";
    echo "<INPUT TYPE=HIDDEN NAME=team_id   VALUE=$playerinfo[team]>";
    echo "<INPUT TYPE=SUBMIT VALUE=SUBMIT>  <INPUT TYPE=RESET VALUE=RESET>";
    echo "</FORM>";
  }
}

function corp_planet_checkboxes($planet, $i)
{
 if($planet[$i][corp] <= 0)
    return("<INPUT TYPE=CHECKBOX NAME=corp[] VALUE=\"" . $planet[$i]["planet_id"] . "\">");
  elseif($planet[$i][corp] > 0)
    return("<INPUT TYPE=CHECKBOX NAME=corp[] VALUE=\"" . $planet[$i]["planet_id"] . "\" CHECKED>");
}

function selling_checkboxes($planet, $i)
{
  if($planet[$i][sells] != 'Y')
    return("<INPUT TYPE=CHECKBOX NAME=sells[] VALUE=\"" . $planet[$i]["planet_id"] . "\">");
  elseif($planet[$i][sells] == 'Y')
    return("<INPUT TYPE=CHECKBOX NAME=sells[] VALUE=\"" . $planet[$i]["planet_id"] . "\" CHECKED>");
}

function base_build_check($planet, $i)
{
  global $l_yes, $l_no;
  global $base_ore, $base_organics, $base_goods, $base_credits;

   if($planet[$i][base] == 'Y')
    return("$l_yes");
  elseif($planet[$i][ore] >= $base_ore && $planet[$i][organics] >= $base_organics && $planet[$i][goods] >= $base_goods && $planet[$i][credits] >= $base_credits)
    return("<A HREF=planet_report_ce.php?buildp=" . $planet[$i]["planet_id"] . "&builds=" . $planet[$i]["sector_id"] . ">Build</A>");
  else
    return("$l_no");
}

echo "<BR><BR>";

TEXT_GOTOMAIN();

include("footer.php");

?>
