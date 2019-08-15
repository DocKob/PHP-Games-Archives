<?
///////////////////////////////////////////////////////////////////////////////////
// cloudRealms Web MMORPG Game Engine                                             /
// Description: cloudRealms is a web based game engine that allows game           /
// developers to easily design and deploy 2D web based social MMORPG games.       /
///////////////////////////////////////////////////////////////////////////////////
// Distributor: Verdis Technologies                                               /
// Website: www.verdisx.com                                                       / 
///////////////////////////////////////////////////////////////////////////////////
// Author: Ronald A. Richardson                                                   /
// Website: www.ronaldarichardson.com                                             /
// Email: theprestig3@gmail.com                                                   /
///////////////////////////////////////////////////////////////////////////////////
// File: portalChecker.php                                                        /
// Modified: 6/13/2011                                                            /
///////////////////////////////////////////////////////////////////////////////////
// This file is part of cloudRealms.                                              /
//                                                                                /
// cloudRealms is free software: you can redistribute it and/or modify            /
// it under the terms of the GNU Affero General Public License as published by    /
// the Free Software Foundation, either version 3 of the License, or              /
// (at your option) any later version.                                            /
//                                                                                /
// cloudRealms is distributed in the hope that it will be useful,                 /
// but WITHOUT ANY WARRANTY; without even the implied warranty of                 /
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                  /
// GNU Affero General Public License for more details.                            /
//                                                                                /
// You should have received a copy of the GNU Affero General Public License       /
// along with cloudRealms.  If not, see <http://www.gnu.org/licenses/>.           /
///////////////////////////////////////////////////////////////////////////////////

include("connect.php");
include("../classes/mmorpg.class.php");
$char = $_GET[char];
$location = $_GET[loc];
$mmorpg = new MMORPG();
$checkPlayerCoordinates = mysql_query("SELECT * FROM characters WHERE id = '$char'");
while($row = mysql_fetch_array($checkPlayerCoordinates)) // Get players location and current coordinates from the database
{
	$playerCoordinates[row] = $row[row];
	$playerCoordinates[col] = $row[col];
	$playerCoordinates[location] = $row[location];
}
$playerLocation = $mmorpg->getLocationFromID($playerCoordinates[location]); // Grab all player location data
// Get all portals from location
$x=-1;
$getPortals = mysql_query("SELECT * FROM tiles WHERE location = '$playerLocation[name]' AND portal != ''") or die(mysql_error());
while($row = mysql_fetch_array($getPortals))
{
	$x++;
	$portals[id][$x] = $row[id];
	$portals[col][$x] = $row[col];
	$portals[row][$x] = $row[row];
	$portals[to][$x] = $row[portal];
	$portals[from][$x] = $row[location];
}
$numberOfPortalsInLocation = count($portals[id]);
/////////////////////// HANDLE GAME CANVAS BOUNDRIES /////////////////////////////
?>
<script>
if(playerCol<=0){
	// teleport the player west
	if(confirm("Do you wish to enter <? echo $mmorpg->locationDisplayName($playerLocation[west]); ?>?")){
		window.location = "index.php?location=<? echo $playerLocation[west]; ?>";
	}
}else if(playerRow<=0){
	// teleport the player north
	if(confirm("Do you wish to enter <? echo $mmorpg->locationDisplayName($playerLocation[north]); ?>?")){
		window.location = "index.php?location=<? echo $playerLocation[north]; ?>";
	}
}else if(playerRow>=<? echo $canvas_height; ?>){
	// teleport the player south
	if(confirm("Do you wish to enter <? echo $mmorpg->locationDisplayName($playerLocation[south]); ?>?")){
		window.location = "index.php?location=<? echo $playerLocation[south]; ?>";
	}
}else if(playerCol>=<? echo $canvas_width-2; ?>){
	// teleport the player east
	if(confirm("Do you wish to enter <? echo $mmorpg->locationDisplayName($playerLocation[east]); ?>?")){
		window.location = "index.php?location=<? echo $playerLocation[east]; ?>";
	}
}
</script>
<?
////////////////////// IF PLAYER GOES TO NEW LOCATION MOVE CHARACTER /////////////
if($playerLocation[name]!=$location)
{
	$loc = $mmorpg->getLocationFromName($location);
	mysql_query("UPDATE characters SET location = '$loc[id]' WHERE id = '$char'");
	$mmorpg->redirect("index.php?location=$location");
}
?>
<script>
/////////////////////// TELEPORT PLAYER IF ON PORTAL TILE ////////////////////////
numberOfPortalsInLocation = <? echo $numberOfPortalsInLocation; ?>;
for(i=0;i < numberOfPortalsInLocation;i++)
{
	<? for($x=0; $x < $numberOfPortalsInLocation; $x++){ ?>
	if(playerCol==<? echo $portals[col][$x]; ?>&&playerRow==<? echo $portals[row][$x]; ?>)
	{
		if(confirm("Do you wish to enter <? echo $mmorpg->locationDisplayName($portals[to][$x]); ?>?")){
			newCol = playerCol + 1;
			newRow = playerRow + 1;
			$.post("do/updatePlayerCoordinates.php?col="+newCol+"&row="+playerRow+"&char=<? echo $char; ?>&location=<? echo $portals[to][$x]; ?>");
			window.location = "index.php?location=<? echo $portals[to][$x]; ?>";
		} else {
			$().dialog("open");
		}
		
	}
	<? } ?>
}
</script>