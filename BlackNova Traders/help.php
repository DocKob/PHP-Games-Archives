<?


include("config.php");
updatecookie();

$title = "Help";
include("header.php");

connectdb();

if(checklogin())
{
  die();
}

bigtitle();

echo "Greetings and welcome to BlackNova Traders!";
echo "<BR><BR>";
echo "This is a game of inter-galactic exploration. Players explore the universe, trading for commodities and ";
echo "increasing their wealth and power. Battles can be fought over space sectors and planets.";
echo "<BR><BR>";
echo "<A HREF=#mainmenu>Main Menu commands</A><BR>";
echo "<A HREF=#techlevels>Tech levels</A><BR>";
echo "<A HREF=#devices>Devices</A><BR>";
echo "<A HREF=#zones>Zones</A><BR>";
echo "<A NAME=mainmenu></A><H2>Main Menu commands:</H2>";
echo "<B>Ship report:</B><BR>";
echo "Display a detailed report on your ship's systems, cargo and weaponry. You can display this report by ";
echo "clicking on your ship's name at the top of the main page.";
echo "<BR><BR>";
echo "<B>Warp links:</B><BR>";
echo "Move from one sector to another through warp links, by clicking on the sector numbers.";
echo "<BR><BR>";
echo "<B>Long-range scan:</B><BR>";
echo "Scan a neighboring sector with your long range scanners without actually moving there.";
if($allow_fullscan)
{
  echo " A full scan will give you an outlook on all the neighboring sectors in one wide sweep of your ";
  echo "sensors.";
}
echo "<BR><BR>";
echo "<B>Ships:</B><BR>";
echo "Scan or attack a ship (if it shows up on your sensors) by clicking on the appropriate link on the right ";
echo "of the ship's name. The attacked ship may evade your offensive maneuver depending on its tech levels.";
echo "<BR><BR>";
echo "<B>Trading ports:</B><BR>";
echo "Access the port trading menu by clicking on a port's type when you enter a sector where one is present.";
echo "<BR><BR>";
echo "<B>Planets:</B><BR>";
echo "Access the planet menu by clicking on a planet's name when you enter a sector where one is present.";
echo "<BR><BR>";
if($allow_navcomp)
{
  echo "<B>Navigation computer:</B><BR>";
  echo "Use your computer to find a route to a specific sector. The navigation computer's power depends on ";
  echo "your computer tech level.";
  echo "<BR><BR>";
}
echo "<B>RealSpace:</B><BR>";
echo "Use your ship's engines to get to a specific sector. Upgrade your engines' tech level to use RealSpace ";
echo "moves effectively. By clicking on the 'Presets' link you can memorize up to 3 sector numbers for quick ";
echo "movement or you can target any sector using the 'Other' link."; 
echo "<BR><BR>";
echo "<B>Trade routes:</B><BR>";
echo "Use trade routes to quickly trade commodities between ports. Trade routes take advantage of RealSpace ";
echo "movements to go back and forth between two ports and trade the maximum amount of commodities at each ";
echo "end. Ensure the remote sector contains a trading port before using a trade route. The trade route ";
echo "presets are shared with the RealSpace ones. As with RealSpace moves, any sector can be targeted using ";
echo "the 'Other' link";
echo "<BR><BR>";
echo "<H3>Menu bar (bottom part of the main page):</H3>";
echo "<B>Devices:</B><BR>";
echo "Use the different devices that your ship carries (Genesis Torpedoes, beacons, Warp Editors, etc.). For ";
echo "more details on each individual device, scroll down to the 'Devices' section.";
echo "<BR><BR>";
echo "<B>Planets:</B><BR>";
echo "Display a list of all your planets, with current totals on commodities, weaponry and credits.";
echo "<BR><BR>";
echo "<B>Log:</B><BR>";
echo "Display the log of events that have happened to your ship.";
echo "<BR><BR>";
echo "<B>Send Message:</B><BR>";
echo "Send an e-mail to another player.";
echo "<BR><BR>";
echo "<B>Rankings:</B><BR>";
echo "Display the list of the top players, ranked by their current scores.";
echo "<BR><BR>";
echo "<B>Last Users:</B><BR>";
echo "Display the list of users who recently logged on to the game.";
echo "<BR><BR>";
echo "<B>Options:</B><BR>";
echo "Change user-specific options (currently, only the password can be changed).";
echo "<BR><BR>";
echo "<B>Feedback:</B><BR>";
echo "Send an e-mail to the game admin.";
echo "<BR><BR>";
echo "<B>Self-Destruct:</B><BR>";
echo "Destroy your ship and remove yourself from the game.";
echo "<BR><BR>";
echo "<B>Help:</B><BR>";
echo "Display the help page (what you're reading right now).";
echo "<BR><BR>";
echo "<B>Logout:</B><BR>";
echo "Remove any game cookies from your system, ending your current session.";
echo "<BR><BR>";
echo "<A NAME=techlevels></A><H2>Tech levels:</H2>";
echo "You can upgrade your ship components at any special port. Each component upgrade improves your ship's ";
echo "attributes and capabilities.";
echo "<BR><BR>";
echo "<B>Hull:</B><BR>";
echo "Determines the number of holds available on your ship (for transporting commodities and ";
echo "colonists).";
echo "<BR><BR>";
echo "<B>Engines:</B><BR>";
echo "Determines the size of your engines. Larger engines can move through RealSpace at a faster pace.";
echo "<BR><BR>";
echo "<B>Power:</B><BR>";
echo "Determines the number of energy your ship can carry.";
echo "<BR><BR>";
echo "<B>Computer:</B><BR>";
echo "Determines the number of fighters your ship can control.";
echo "<BR><BR>";
echo "<B>Sensors:</B><BR>";
echo "Determines the precision of your sensors when scanning a ship or planet. Scan success is dependent upon ";
echo "the target's cloak level.";
echo "<BR><BR>";
echo "<B>Armour:</B><BR>";
echo "Determines the number of armor points your ship can use.";
echo "<BR><BR>";
echo "<B>Shields:</B><BR>";
echo "Determines the efficiency of your ship's shield system during combat.";
echo "<BR><BR>";
echo "<B>Beams:</B><BR>";
echo "Determines the efficiency of your ship's beam weapons during combat.";
echo "<BR><BR>";
echo "<B>Torpedo launchers:</B><BR>";
echo "Determines the number of torpedoes your ship can use.";
echo "<BR><BR>";
echo "<B>Cloak:</B><BR>";
echo "Determines the efficiency of your ship's cloaking system. See 'Sensors' for more details.";
echo "<BR><BR>";
echo "<A NAME=devices></A><H2>Devices:</H2>";
echo "<B>Space Beacons:</B><BR>";
echo "Post a warning or message which will be displayed to anyone entering this sector. Only 1 beacon can be ";
echo "active in each sector, so a new beacon removes the existing one (if any).";
echo "<BR><BR>";
echo "<B>Warp Editors:</B><BR>";
echo "Create or destroy warp links to another sector.";
echo "<BR><BR>";
echo "<B>Genesis Torpedoes:</B><BR>";
echo "Create a planet in the current sector (if one does not yet exist).";
echo "<BR><BR>";
echo "<B>Mine Deflector:</B><BR>";
echo "Protect the player against mines dropped in space. Each deflector takes out 1 mine.";
echo "<BR><BR>";
echo "<B>Emergency Warp Device:</B><BR>";
echo "Transport your ship to a random sector, if manually engaged. Otherwise, an Emergency Warp Device can ";
echo "protect your ship when attacked by transporting you out of the reach of the attacker.";
echo "<BR><BR>";
echo "<B>Escape Pod (maximum of 1):</B><BR>";
echo "Keep yourself alive when your ship is destroyed, enabling you to keep your credits and planets.";
echo "<BR><BR>";
echo "<B>Fuel Scoop (maximum of 1):</B><BR>";
echo "Accumulate energy units when using RealSpace movement.";
echo "<BR><BR>";
echo "<A NAME=zones></A><H2>Zones:</H2>";
echo "The galaxy is divided into different areas with different rules being enforced in each zone. To display ";
echo "the restrictions attached to your current sector, just click on the zone name (top right corner of the ";
echo "main page). Your ship can be towed out of a zone to a random sector when your hull size exceeds the ";
echo "maximum allowed level for that specific zone. Attacking other players and using some devices can also ";
echo "be disallowed in some zones.";
echo "<BR><BR>";

TEXT_GOTOMAIN();
include("footer.php");

?> 
