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
// File: tradeQueue.php                                                           /
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
include("../classes/inventory.class.php");
$inventory = new Inventory();
$tradeid = $_GET[id];
$color1 = "#E8E8E8";
$color2 = "#ADADAD";
$row_count = 0; 
$getQueue = mysql_query("SELECT DISTINCT * FROM trading_queue WHERE tradeid = '$tradeid' ORDER BY id DESC LIMIT 12");
while($row = mysql_fetch_array($getQueue))
{
	$row_color = ($row_count++ % 2) ? $color1 : $color2; 
	if($row[itemid])
	{
		$item = $inventory->item_name($row[itemid]);
		?><p style='background:<? echo $row_color; ?>;'><? echo $item; ?> from <? echo $row[slot]; ?> <input type='submit' value='remove' style='float:right;margin:0px;padding:0px;' onclick="drop_from_queue('<? echo $row[slot]; ?>');"></p><?
	}
} 
?>
<script>
function drop_from_queue(slot)
{
	$.post("do/dropItemFromQueue.php?trade=<? echo $_COOKIE[tradeid]; ?>&slot="+slot+"");
}
</script>