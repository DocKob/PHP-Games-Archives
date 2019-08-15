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
// File: location_handler.php                                                     /
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

$location=$_GET[location];
if($location=='home')
{
	$grabUserHomeDetails = mysql_query("SELECT * FROM homes WHERE charID = '$char_id'");
	while($row = mysql_fetch_array($grabUserHomeDetails))
	{
		$is_Setup = $row[setup];
		$bg = $row[background];
		$bgcolor = $row[bgcolor];
	}
	if($is_Setup==0)
	{
		$mmorpg->iframe("setupHome.php?action=0&char=$char_id");
		$bgcolor = '000';
	}
}
if($location=='')
{
	$location='vanlord';
}
$grabLocationData = mysql_query("SELECT * FROM locations WHERE name = '$location'") or die (mysql_error());
while($row = mysql_fetch_array($grabLocationData))
{
	$loc_id = $row[id];
	$loc_name = $row[name];
	$loc_display_name = $row[display_name];
	$loc_north = $row[north];
	$loc_south = $row[south];
	$loc_east = $row[east];
	$loc_west = $row[west];
	$loc_tile_color = $row[default_tile_color];
	$loc_bg = $row[background];
	$loc_ogg = $row[ogg];
	$loc_mp3 = $row[mp3];
}
?>
<style>
body 
{
  background: url('<? echo $loc_bg; ?>') #<? echo $loc_tile_color; ?> repeat;
  color: <? echo $fontcolor; ?>;
} 
.jcarousel-skin-tango .jcarousel-container 
{
	background: #<? echo $loc_bg; ?>;
}
</style>
<audio preload="auto" autoplay="autoplay" loop="loop">
	<source src="<? echo $loc_ogg; ?>" />
	<source src="<? echo $loc_mp3; ?>" />
</audio>