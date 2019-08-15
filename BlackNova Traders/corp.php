<?


include("config.php");

updatecookie();

include("languages/$lang");
$title=$l_corpm_title;;
include("header.php");

connectdb();
if (checklogin())
{
	die();
}

//------------------------------------
$result = $db->Execute("SELECT * FROM $dbtables[ships] WHERE email='$username'");
$playerinfo=$result->fields;

$planet_id = stripnum($planet_id);

$result2 = $db->Execute("SELECT * FROM $dbtables[planets] WHERE planet_id=$planet_id");
if($result2)

  $planetinfo=$result2->fields;

if ($planetinfo[owner] == $playerinfo[ship_id] || ($planetinfo[corp] == $playerinfo[team] && $playerinfo[team] > 0))

{

bigtitle();

	if ($action == "planetcorp")
	{
		echo ("$l_corpm_tocorp<BR>");
		$result = $db->Execute("UPDATE $dbtables[planets] SET corp='$playerinfo[team]', owner=$playerinfo[ship_id] WHERE planet_id=$planet_id");
    $ownership = calc_ownership($playerinfo[sector]);

      if(!empty($ownership))

        echo "<p>$ownership<p>";


	}
	if ($action == "planetpersonal")
	{
		echo ("$l_corpm_topersonal<BR>");
		$result = $db->Execute("UPDATE $dbtables[planets] SET corp='0', owner=$playerinfo[ship_id] WHERE planet_id=$planet_id");
    $ownership = calc_ownership($playerinfo[sector]);
                // Kick other players off the planet
                $result = $db->Execute("UPDATE $dbtables[ships] SET on_planet='N' WHERE on_planet='Y' AND planet_id = $planet_id AND ship_id <> $playerinfo[ship_id]");
      if(!empty($ownership))

        echo "<p>$ownership<p>";

	}
TEXT_GOTOMAIN();
}
else
{
echo ("<BR>$l_corpm_exploit<BR>");
TEXT_GOTOMAIN();
}


include("footer.php");

?>
