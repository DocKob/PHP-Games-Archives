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
// File: trader.class.php                                                         /
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

class Trader{

	function tradeid()
	{
		include_once("mmorpg.class.php");
		$mmorpg = new MMORPG();
		$trade_id = $mmorpg->rand_uniqid(rand());
		return $trade_id;
	}
	
	function add_to_queue($trade, $id, $slot)
	{
		$checkSlot = mysql_query("SELECT * FROM trading_queue WHERE slot = '$slot'");
		while($row = mysql_fetch_array($checkSlot))
		{
			$slotQueued = $row[tradeid];
		}
		if($slotQueued!=$trade)
		{
			$result = mysql_query("INSERT INTO trading_queue (tradeid, itemid, slot) VALUES ('$trade', '$id', '$slot')") or die(mysql_error());
		}
		return $result;
	}
	
	function drop_from_queue($slot, $trade)
	{
		mysql_query("DELETE FROM trading_queue WHERE slot = '$slot' AND tradeid = '$trade'");
	}
	
	function trade($tradeid, $taker, $giver)
	{
		include_once("inventory.class.php");
		$inventory = new Inventory();
		include_once("character.class.php");
		$character = new Character();
		include_once("comm.class.php");
		$comm = new Comm();
		$slot = $this->load_trade_queue($tradeid);
		for($i=0; $i < count($slot); $i++)
		{
			$char = $character->getNameFromID($giver);
			$itemid = $inventory->get_item_from_slot($slot[$i], $char);
			$inventory->drop_item($slot[$i], $char);
			$inventory->add_item($itemid, $taker);
			$this->drop_from_queue($slot[$i], $tradeid);
		}
		$result = "Trade completed";
		$comm->new_notification($result, "success", $giver);
		$comm->new_notification($result, "success", $taker);
		return $result;
	}
	
	function load_trade_queue($tradeid)
	{
		$loadQueue = mysql_query("SELECT * FROM trading_queue WHERE tradeid = '$tradeid'");
		$num=0;
		while($row = mysql_fetch_array($loadQueue))
		{
			$queue[$num++] = $row[slot];
		}
		return $queue;
	}
}
?>