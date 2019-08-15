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
// File: party.class.php                                                          /
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

class Party{

	function party_invite($to, $from)
	{
		include_once("comm.class.php");
		$comm = new Comm();
		$comm->new_request($to, $from, "party", "$from has invited you to join his party", "unread");
	}
	
	function start_party($leader, $party_name)
	{
		include_once("comm.class.php");
		$comm = new Comm();
		mysql_query("INSERT INTO party (leader, party_name) VALUES ('$leader', '$party_name')");
		$grabNewPartyID = mysql_query("SELECT * FROM party WHERE leader = '$leader'");
		while($row=mysql_fetch_array($grabNewPartyID))
		{
			$new_party=$row[id];
		}
		mysql_query("UPDATE characters SET party = '$new_party' WHERE id = '$leader'");
		$comm->new_notification("You have started a party", "success", $leader);
	}
	
	function request_to_join_party($char, $party)
	{
	
	}
	
	function drop_member($member)
	{
	
	}
	
	function add_member($member)
	{
	
	}
	
	function disband_party($member)
	{
	
	}
}
?>