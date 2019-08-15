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
// File: post_handler.php                                                         /
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

if($_POST['dropItem']){ // drop an item from the inventory
	$slot = $_POST['item_to_drop'];
	$drop = "UPDATE inventory SET $slot = '0' WHERE char_name = '$name'";
	mysql_query($drop) or die ("MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$drop\n<br>");
	$message_on = true;
	$message = "Item successfully dropped!";
	$message_type = "success";
	$return_arr = array();
	echo json_encode($return_arr);
} else if($_GET[action]=='make_quest_active'){ // set a quest to active quest
	$make_quest_active = "UPDATE quest_panel SET activeQuest = '$_GET[quest_id]', $_GET[the_quest] = '0' WHERE charID = '$charID'";
	mysql_query($make_quest_active) or die ("MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$drop\n<br>");
	$message_on = true;
	$message = "You have a new active quest";
	$message_type = "success";
} else if($_GET[action]=='setup_home') { 
	$query="UPDATE homes SET bgcolor = '$_GET[bgcolor]', setup = '1' WHERE charID = '$charID'";
	mysql_query($query) or die (mysql_error());
	$message_on = true;
	$message = "Your home has been setup";
	$message_type = "success";
} else if($_POST['start_party']){
	mysql_query("INSERT INTO party (leader, party_name) VALUES ('$char_id', '$_POST[party_name]')");
	$grabNewPartyID = mysql_query("SELECT * FROM party WHERE leader = '$char_id'");
	while($row=mysql_fetch_array($grabNewPartyID)){
		$new_party=$row[id];
	}
	mysql_query("UPDATE characters SET party = '$new_party' WHERE id = '$char_id'");
	$message_on = true;
	$message = "You have started a party";
	$message_type = "success";
} else if($_GET[action]=='disband_party') { 
	$query="UPDATE characters SET party = '0' WHERE id = '$char_id'";
	mysql_query($query) or die (mysql_error());
	$getPartyData=mysql_query("SELECT * FROM party WHERE leader = '$char_id'");
	while($row=mysql_fetch_array($getPartyData))
	{
		$member1 = $row[member1];
	}
	if($member1==0)
	{
		mysql_query("DELETE FROM party WHERE leader = '$char_id'");
	} else {
		mysql_query("UPDATE party SET leader = '$member1', member1 = '0' WHERE leader = '$char_id'");
	}
	$message_on = true;
	$message = "You have disbanded party";
	$message_type = "success";
} else if($_GET[action]=='send_requests'){
	$type=$_GET[type];
	$to=$_GET[to];
	$from=$_GET[from];
	if($_GET[message]=='party'){
		$message="New request to join party!";
	}
	mysql_query("INSERT INTO requests (request_to, request_from, request_type, message, status) VALUES ('$to', '$from', '$type', '$message', 'unread')");
	$message_on=true;
	$message="Request sent";
	$message_type="success";
} else if($_GET[action]=='read_requests'){
	mysql_query("UPDATE requests SET status = 'read' WHERE request_to = '$username'");
}

?>