<?
include("config.php");
updatecookie();
include("languages/$lang");


connectdb();



$title=$l_teamplanet_title;
include("header.php");

if(checklogin())
{
  die();
}


$res = $db->Execute("SELECT * FROM $dbtables[ships] WHERE email='$username'");
$playerinfo = $res->fields;

if ($playerinfo[team]==0)
{
 echo "<BR>$l_teamplanet_notally";
 echo "<BR><BR>";
 TEXT_GOTOMAIN();

 include("footer.php");

 return;
}


$query = "SELECT * FROM $dbtables[planets] WHERE corp=$playerinfo[team]";
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
    $query .= " $sort DESC";
  }
  elseif($sort == "torp")
  {
    $query .= " torps DESC";
  }
  else
  {
    $query .= " sector_id ASC";
  }
}

$res = $db->Execute($query);

bigtitle();


echo "<BR>";
echo "<B><A HREF=planet_report.php>$l_teamplanet_personal</A></B>";
echo "<BR>";
echo "<BR>";


$i = 0;
if($res)
{
  while(!$res->EOF)
  {
    $planet[$i] = $res->fields;
    $i++;

    $res->Movenext();
  }
}

$num_planets = $i;
if($num_planets < 1)
{
  echo "<BR>$l_teamplanet_noplanet";
}
else
{
  echo "$l_pr_clicktosort<BR><BR>";
  echo "<TABLE WIDTH=\"100%\" BORDER=0 CELLSPACING=0 CELLPADDING=2>";
  echo "<TR BGCOLOR=\"$color_header\">";
  echo "<TD><B><A HREF=team_planets.php?sort=sector>$l_sector</A></B></TD>";
  echo "<TD><B><A HREF=team_planets.php?sort=name>$l_name</A></B></TD>";
  echo "<TD><B><A HREF=team_planets.php?sort=ore>$l_ore</A></B></TD>";
  echo "<TD><B><A HREF=team_planets.php?sort=organics>$l_organics</A></B></TD>";
  echo "<TD><B><A HREF=team_planets.php?sort=goods>$l_goods</A></B></TD>";
  echo "<TD><B><A HREF=team_planets.php?sort=energy>$l_energy</A></B></TD>";
  echo "<TD><B><A HREF=team_planets.php?sort=colonists>$l_colonists</A></B></TD>";
  echo "<TD><B><A HREF=team_planets.php?sort=credits>$l_credits</A></B></TD>";
  echo "<TD><B><A HREF=team_planets.php?sort=fighters>$l_fighters</A></B></TD>";
  echo "<TD><B><A HREF=team_planets.php?sort=torp>$l_torps</A></B></TD>";
  echo "<TD><B>$l_base?</B></TD><TD><B>$l_selling?</B></TD>";
  echo "<TD><B>Player</B></TD>";
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
    if($planet[$i][sells] == "Y")
    {
      $total_selling += 1;
    }
    if(empty($planet[$i][name]))
    {
      $planet[$i][name] = "$l_unnamed";
    }
    $owner = $planet[$i][owner];
    $res = $db->Execute("SELECT character_name FROM $dbtables[ships] WHERE ship_id=$owner");
    $player = $res->fields[character_name];

    echo "<TR BGCOLOR=\"$color\">";
    echo "<TD><A HREF=rsmove.php?engage=1&destination=". $planet[$i][sector_id] . ">". $planet[$i][sector_id] ."</A></TD>";
    echo "<TD>" . $planet[$i][name]              . "</TD>";
    echo "<TD>" . NUMBER($planet[$i][ore])       . "</TD>";
    echo "<TD>" . NUMBER($planet[$i][organics])  . "</TD>";
    echo "<TD>" . NUMBER($planet[$i][goods])     . "</TD>";
    echo "<TD>" . NUMBER($planet[$i][energy])    . "</TD>";
    echo "<TD>" . NUMBER($planet[$i][colonists]) . "</TD>";
    echo "<TD>" . NUMBER($planet[$i][credits])   . "</TD>";
    echo "<TD>" . NUMBER($planet[$i][fighters])  . "</TD>";
    echo "<TD>" . NUMBER($planet[$i][torps])     . "</TD>";
    echo "<TD>" . ($planet[$i][base] == 'Y' ? "$l_yes" : "$l_no") . "</TD>";
    echo "<TD>" . ($planet[$i][sells] == 'Y' ? "$l_yes" : "$l_no") . "</TD>";
    echo "<TD>" . $player                        . "</TD>";
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
  echo "<TR BGCOLOR=\"$color\">";
  echo "<TD></TD>";
  echo "<TD>$l_pr_totals</TD>";
  echo "<TD>" . NUMBER($total_ore) . "</TD>";
  echo "<TD>" . NUMBER($total_organics) . "</TD>";
  echo "<TD>" . NUMBER($total_goods) . "</TD>";
  echo "<TD>" . NUMBER($total_energy) . "</TD>";
  echo "<TD>" . NUMBER($total_colonists) . "</TD>";
  echo "<TD>" . NUMBER($total_credits) . "</TD>";
  echo "<TD>" . NUMBER($total_fighters) . "</TD>";
  echo "<TD>" . NUMBER($total_torp) . "</TD>";
  echo "<TD>" . NUMBER($total_base) . "</TD>";
  echo "<TD>" . NUMBER($total_selling) . "</TD>";
  echo "<TD></TD>";
  echo "</TR>";
  echo "</TABLE>";
}

echo "<BR><BR>";

TEXT_GOTOMAIN();

include("footer.php");

?>
