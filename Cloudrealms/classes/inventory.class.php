<?php
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
// File: inventory.class.php                                                      /
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

class Inventory{
	
	function load_inventory($inventory)
	{
		$loadInventory = mysql_query("SELECT * FROM inventory WHERE id = '$inventory'");
		while($row = mysql_fetch_array($loadInventory))
		{
			$slot[0] = $row['slot0'];
			$slot[1] = $row['slot1'];
			$slot[2] = $row['slot2'];
			$slot[3] = $row['slot3'];
			$slot[4] = $row['slot4'];
			$slot[5] = $row['slot5'];
			$slot[6] = $row['slot6'];
			$slot[7] = $row['slot7'];
			$slot[8] = $row['slot8'];
			$slot[9] = $row['slot9'];
			$slot[10] = $row['slot10'];
			$slot[11] = $row['slot11'];
		}
		return $slot;
	}
	
	function drop_item($slot, $char)
	{
		mysql_query("UPDATE inventory SET $slot = '0' WHERE char_name = '$char'") or die(mysql_error());
	}
	
	function get_item_from_slot($slot, $char)
	{
		$getItemID = mysql_query("SELECT * FROM inventory WHERE char_name = '$char'");
		while($row = mysql_fetch_array($getItemID))
		{
			$itemid = $row[$slot];
		}
		return $itemid;
	}
	
	function add_item($itemid, $player)
	{
		include_once("mmorpg.class.php");
		$mmorpg = new MMORPG();
		include_once("comm.class.php");
		$comm = new Comm();
		$char = $mmorpg->getCharacter($player);
		$slot = $this->load_inventory($char[inventory]);
		$num = array();
		for($i=0; $i < count($slot); $i++)
		{
			if($slot[$i]==0)
			{
				$fill[$i] = 1;
				$num[0] = $i;
				$_slot = "slot".$num[0];
				mysql_query("UPDATE inventory SET $_slot = '$itemid' WHERE id = '$char[inventory]'");
				$note = $this->item_name($itemid)." has been added to your inventory";
				$comm->new_notification($note, "info", $player);
				$result = $this->item_name($itemid)." has been added to inventory";
				return $_slot;
			}
		}
		$x=-1;
		foreach($slot as $_slot)
		{
			$x++;
			if($_slot==0)
			{
				$fill[$x] = 1;
			}
		}
		$isInventoryFull = count($fill);
		if($isInventoryFull==0)
		{
			$result = "Inventory is full";
			$comm->new_notification("Inventory is full! try dropping some items to make room", "error", $player);
		}
	}
	
	function item_name($id)
	{
		$getItemName = mysql_query("SELECT * FROM items WHERE id = '$id'");
		while($row=mysql_fetch_array($getItemName))
		{
			$item_name = $row[name];
		}
		return $item_name;
	}
	
	function item_img($id)
	{
		$getItemImg = mysql_query("SELECT * FROM items WHERE id = '$id'");
		while($row=mysql_fetch_array($getItemImg))
		{
			$item_img = $row[img];
		}
		if($id==0)
		{
			$item_img = "source/items/blank.jpg";
		}
		return $item_img;
	}
	
	function item_id($id)
	{
		$getItemID = mysql_query("SELECT * FROM items WHERE id = '$id'");
		while($row=mysql_fetch_array($getItemID))
		{
			$item_id = $row[id];
		}
		return $item_id;
	}
	
	function load_item($id)
	{
		$getItemsData = mysql_query("SELECT * FROM items WHERE id = '$id'");
		while($row = mysql_fetch_array($getItemsData))
		{
			$item[id] = $row['id'];
			$item[name] = $row['name'];
			$item[desc] = $row['description'];
			$item[img] = $row['img'];
			$item[value] = $row['value'];
			$item[mp] = $row['mp'];
			$item[hp] = $row['hp'];
			$item[tp] = $row['tp'];
			$item[exp] = $row['exp'];
		}
		return $item;
	}
	
	function use_item($id, $slot, $slotid) // TO-DO: Improve this stoopid function
	{
		$item = $this->load_item($id);
		$itemx[mp] = $item['mp'];
		$itemx[hp] = $item['hp'];
		$itemx[tp] = $item['tp'];
		$itemx[exp] = $item['exp'];
		$item_increase[0] = "MP";
		$item_increase[1] = "HP";
		$item_increase[2] = "TP";
		$item_increase[3] = "EXP";
		$num=-1;
		foreach($itemx as $_item)
		{
			$num++;
			if($_item)
			{
				$column = strtolower($item_increase[$num]);
				mysql_query("UPDATE characters SET $column = '$_item' WHERE id = '$player'");
				$note = "You use the $item_name, and your $item_increase[$num] is increased by $_item";
				// after and item is used it is removed from players inventory
				mysql_query("UPDATE inventory SET $slot = '0' WHERE id = '$slot_id'");
			}
		}
	}
	
}
?>