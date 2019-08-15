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
// File: manageItem.php                                                           /
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
include('classes/inventory.class.php');
$inventory = new Inventory();
include('classes/mmorpg.class.php');
$mmorpg = new MMORPG();
$item = $_GET[item];
$player = $_GET[u];
$action = $_GET[action];
$slot = $_GET[slot];
$slot_id = $_GET[slotid];
$loc = $_GET[loc];
$getItemsData = mysql_query("SELECT * FROM items WHERE id = '$item'");
$x=0;
while($row = mysql_fetch_array($getItemsData))
{
	$item_id = $row['id'];
	$item_name = $row['name'];
	$item_desc = $row['description'];
	$item_img = $row['img'];
	$item_value = $row['value'];
	$itemz[0] = $row['mp'];
	$itemz[1] = $row['hp'];
	$itemz[2] = $row['tp'];
	$itemz[3] = $row['exp'];
	$itemz[4] = $row['spell'];
}
$item_increase[0] = "MP";
$item_increase[1] = "HP";
$item_increase[2] = "TP";
$item_increase[3] = "EXP";
$num=-1;
if($action=='use')
{
	foreach($itemz as $_item)
	{
		$num++;
		if($_item)
		{
			$column = strtolower($item_increase[$num]);
			// get players current column
			$getIt = mysql_query("SELECT * FROM characters WHERE id = '$player'");
			while($row = mysql_fetch_array($getIt))
			{
				$got = $row[$column];
			}
			$increaseBy = $got + $_item;
			mysql_query("UPDATE characters SET $column = '$increaseBy' WHERE id = '$player'");
			echo "<p>You use the $item_name, and your $item_increase[$num] is increased by $_item</p>";
			// after and item is used it is removed from players inventory
			$xchar = $mmorpg->getCharacter($player);
			mysql_query("UPDATE inventory SET $slot = '0' WHERE char_name = '$xchar[name]'");
			echo "<br>Close to continue...";
		}
	}
} else if($action=='learn'){
	include_once("classes/spell.class.php");
	$spell = new Spell();
	echo "Trying to learn...<br><br>";
	$result = $spell->learn($player, $itemz[4], $slot);
	echo "<div style='margin:7px;border:1px #000 solid;padding:7px;background:#FFFC9C;'>".$result."</div>";
} else {
?>
<font color="#000">
<div style="float:left;margin:5px;">
<img src="<? echo $item_img; ?>">
</div> 
<div style="float:left;margin:5px;">
<strong>Item:</strong> <? echo $item_name; ?></br>
<strong>Description:</strong> <? echo $item_desc; ?></br>
<strong>Value:</strong> <? echo $item_value; ?></br>
<?
	$set=0;
	for($num=0;$num < count($itemz);$num++)
	{
		if($itemz[$num])
		{
			if($itemz[$num]!=$itemz[4])
			{
				echo "<strong>Increases:</strong> ".$item_increase[$num]." by ".$itemz[$num]."</br>";
				$set=1;
			}
			if($itemz[$num]==$itemz[4])
			{
				echo "<strong>Notice:</strong>This is a scroll that you can try to learn<br>";
				$set=2;
			}
		}
	}
?>
<strong>Actions:</strong> <? if($set==0){ echo " None"; } else { ?>
<hr>
<ul>
<?
if($set==1)
{
	echo "<li><a href='$_SERVER[REQUEST_URI]&action=use'>Use Item</a>";
}
if($set==2)
{
	echo "<li><a href='$_SERVER[REQUEST_URI]&action=learn'>Attempt to learn spell</a>";
}
}
?>
</ul>
</div>
<?
}
$connect->CloseDB();
?>
