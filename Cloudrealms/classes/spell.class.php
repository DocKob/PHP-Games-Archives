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
// File: spell.class.php                                                          /
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

class Spell{
	
	function load_scroll($id)
	{
		$getScrollData = mysql_query("SELECT * FROM scrolls WHERE id = '$id'");
		while($row = mysql_fetch_array($getScrollData))
		{
			$scroll[id] = $row[id];
			$scroll[name] = $row[name];
			$scroll[desc] = $row[desc];
			$scroll[img] = $row[img];
			$scroll[dmg] = $row[dmg];
			$scroll[type] = $row[type];
			$scroll[affect] = $row[affect];
			$scroll[plus] = $row[plus];
			$scroll[class1] = $row[class1];
			$scroll[class2] = $row[class2];
			$scroll[class3] = $row[class3];
			$scroll[level] = $row[level];
		}
		return $scroll;
	}
	
	function check_if_user_knowsscroll($user, $scroll)
	{
		$checkIfUserHasLearnedScrollAlready = mysql_query("SELECT * FROM spells WHERE user = '$user' AND scroll = '$scroll'");
		while($row = mysql_fetch_array($checkIfUserHasLearnedScrollAlready))
		{
			$ifScroll = $row[scroll];
		}
		return $ifScroll;
	}
			
	function learn($user, $scroll, $slot=NULL)
	{
		include_once("mmorpg.class.php");
		$mmorpg = new MMORPG();
		include_once("comm.class.php");
		$comm = new Comm();
		include_once("inventory.class.php");
		$inventory = new Inventory();
		$knowsscroll = $this->check_if_user_knowsscroll($user, $scroll);
		$char = $mmorpg->getCharacter($user);
		$scroll = $this->load_scroll($scroll);
		if($knowsscroll!=$scroll[id])
		{
			if($char[level] >= $scroll[level])
			{
				if($user['class']==$scroll[class1]||$scroll[class2]||$scroll[class2])
				{
					$result = mysql_query("INSERT INTO spells (scroll, user) VALUES ('$scroll[id]', '$char[id]')") or die(mysql_error());
					$inventory->drop_item($slot, $char[name]);
					$result = "You have successfully learned the spell $scroll[name]";
					$comm->new_notification($result, "success", $char[id]);
				} else {
					$result = "You have failed to learn $scroll[name] because you don't meet class requirements";
					$comm->new_notification($result, "error", $char[id]);
				}
			} else {
				$result = "You must be level $scroll[level] or higher to learn $scroll[name]";
				$comm->new_notification($result, "error", $char[id]);
			}
		} else {
			$result = "You already know $scroll[name]";
			$comm->new_notification($result, "error", $char[id]);
		}
		return $result;
	}
}
?>