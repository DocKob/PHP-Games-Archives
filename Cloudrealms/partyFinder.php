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
// File: partyFinder.php                                                          /
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

include('includes/connect.php');
include('classes/battle.class.php');
$access = new Battle();
echo "<h1>Party Finder</h1>";
echo "<table bordercolor=#C4C4C4 border=1 cellspacing=0 cellpadding=3 width=100%><tr><td>Party Name</td><td>Leader</td><td>Level Range</td><td>Actions</td></tr>";
$findParties = mysql_query("SELECT * FROM party");
while($row=mysql_fetch_array($findParties))
{
	$range_max=$access->playerLevel($row[leader])+2;
	echo "<tr><td>$row[party_name]</td><td>".$access->playerName($row[leader])."</td><td>".$access->playerLevel($row[leader])." - $range_max</td><td><a href=''>Message Leader</a> or <a href=''>Request to join party</a></tr>";
}
echo "</table>";
?>
