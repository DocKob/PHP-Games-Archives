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
// File: battle_log.php                                                           /
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

include("../includes/connect.php");
$battleid = $_GET[battleid];
?>
<? if($initial){ ?><p><? echo $initial; ?></p><? } ?>
<?
$color1 = "#C524FF";
$color2 = "#5BFF24";
$row_count = 0; 
$getLog = mysql_query("SELECT * FROM logs WHERE unique_code = '$battleid' ORDER BY id DESC LIMIT 10");
while($row = mysql_fetch_array($getLog))
{
	$row_color = ($row_count++ % 2) ? $color1 : $color2; 
	if($row[message])
	{
		echo "<p style='background:$row_color;'>$row[message]</p>";
	}
} 
?>
