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
// File: show_inventory.php                                                       /
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

include("../classes/inventory.class.php");
include("../includes/connect.php");
$char_id = $_GET[char];
$location = $_GET[loc];
$inventoryID = $_GET[inv];
$inventory = new Inventory();
$slot = $inventory->load_inventory($inventoryID);
$win=10;
for($y=0;$y < count($slot);$y++)
{
	$win++;
	$_slot = "slot".$y;
	?>
		<span class="inventory"><? if($slot[$x]==0){ ?><a href="#" onclick="cwindow('manageItem.php?item=<? echo $inventory->item_id($slot[$y]); ?>&u=<? echo $char_id; ?>&slot=<? echo $_slot; ?>&slotid=<? echo $inventory->item_id($slot[$y]); ?>&loc=<? echo $location; ?>');"><? } ?><img src="<? echo $inventory->item_img($slot[$y]); ?>" class="gameItem" width="48" height="48" style="margin-right:3px;padding:5px;border:3px #8C8C8C solid;" /><? if($slot[$x]==0){ ?></a><? } ?></span>
	<?
}
?>