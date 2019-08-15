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
// File: inventory.php                                                            /
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

include("classes/inventory.class.php");
$inventory = new Inventory();
?>
<!-- inventory window -->
<div id="inventory" class="containerPlus draggable resizable {buttons:'m,c', skin:'default', width:'350', height:'420',title:'Inventory', closed:'true' }" style="top:220px; left:72%;color:#000;"><br>
<?
if($inventoryID == "0"){
	echo "You have not yet set up your inventory";
} else {
	$slot = $inventory->load_inventory($inventoryID);
	for($n=0;$n < count($slot);$n++)
	{
		if($slot[$n]==0)
		{
			$empty = 1;
		}
	} 
	echo "<center>This is what's in your inventory<br><br>";
	echo "<div id='success_drop' style='margin:3px;'></div><br>";
	echo "<form id='dropItem'>Drop Item: <select name='slot'>";
	for($x=0;$x < count($slot);$x++)
	{
		$_slot = "slot".$x;
		if($slot[$x]!=0)
		{
			echo "<option value='$_slot'>".$_slot.": ".$inventory->item_name($slot[$x])."</option>";
		}
	}
	echo "</select><input type='submit' name='dropItem' value='Go!'></form><br><br>";
	echo "<div id='show_inventory'></div>";
	}
?>
	</center>
</div>
<!-- /inventory window -->
<script type="text/javascript">
// DROP ITEM
$(function(){
	$("#dropItem").submit(function(){		
		$.post("do/dropItem.php?user=<? echo $userID; ?>", $("#dropItem").serialize(),
		function(data){
				$("#success_drop").html(data.success); 
		}, "json");
		return false;
	});
});
var auto_refresh = setInterval(function ()
{
	$('#show_inventory').load('includes/show_inventory.php?char=<? echo $char_id; ?>&loc=<? echo $location; ?>&inv=<? echo $inventoryID; ?>').fadeIn("slow");
}, 2000); // refresh interval
</script>