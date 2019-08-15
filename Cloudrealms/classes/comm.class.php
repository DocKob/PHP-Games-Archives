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
// File: comm.class.php                                                           /
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

class Comm {

	function new_pm($to, $from, $subject, $message)
	{
		$q = mysql_query("INSERT INTO pm (pmto, pmfrom, pmsubject, message, status) VALUES ('$to', '$from', '$subject', '$message', 'unread')") or die(mysql_error());
		$this->new_notification("You have a new message in your Inbox", "info", $to);
		return $q;
	}
	
	function get_pm($id)
	{
		$q = mysql_query("SELECT * FROM pm WHERE id = '$id'");
		$pm = mysql_fetch_array($q);
		return $pm;
	}
	
	function set_pm_read($id)
	{
		mysql_query("UPDATE pm SET status = 'read' WHERE id = '$id'");
	}
	
	function get_received_pm($id)
	{
		include_once("character.class.php");
		$char = new Character();
		$n = $char->getNameFromId($id);
		$x=-1;
		$retreiveAllUsersReceivedPMs = mysql_query("SELECT * FROM pm WHERE pmto = '$n'")or die(mysql_error());
		while($row = mysql_fetch_array($retreiveAllUsersReceivedPMs))
		{
			$x++;
			$pm[id][$x] = $row[id];
			$pm[to][$x] = $row[pmto];
			$pm[from][$x] = $row[pmfrom];
			$pm[subject][$x] = $row[pmsubject];
			$pm[message][$x] = $row[message];
			$pm[status][$x] = $row[status];
			$pm[date][$x] = $row[date];
		}
		return $pm;
	}
	
	function get_sent_pm($id)
	{
		include_once("character.class.php");
		$char = new Character();
		$n = $char->getNameFromId($id);
		$x=-1;
		$retreiveAllUsersSentPMs = mysql_query("SELECT * FROM pm WHERE pmfrom = '$n'");
		while($row = mysql_fetch_array($retreiveAllUsersSentPMs))
		{
			$x++;
			$pm[id][$x] = $row[id];
			$pm[to][$x] = $row[pmto];
			$pm[from][$x] = $row[pmfrom];
			$pm[subject][$x] = $row[pmsubject];
			$pm[message][$x] = $row[message];
			$pm[status][$x] = $row[status];
			$pm[date][$x] = $row[date];
		}
		return $pm;
	}

	function new_notification($message, $message_type, $user)
	{
		mysql_query("INSERT INTO notifications (message, message_type, status, user) VALUES ('$message', '$message_type', 'unread', '$user')");
	}
	
	function read_notification($id)
	{
		mysql_query("UPDATE notifications SET status = 'read' WHERE id = '$id'");
	}
	
	function read_request($id)
	{
		mysql_query("UPDATE requests SET status = 'read' WHERE id = '$id'");
	}
	
	function del_response($id)
	{
		mysql_query("DELETE FROM requests WHERE id = $id");
	}
	
	function new_request($to, $from, $type, $message, $status)
	{
		mysql_query("INSERT INTO requests (request_to, request_from, request_type, message, status) VALUES ('$to', '$from', '$type', '$message', '$status')");
	}
	
	function retrieve_unread_requests($username)
	{
		$x=-1;
		$getUnreadRequests=mysql_query("SELECT * FROM requests WHERE request_to = '$username' AND status = 'unread'");
		while($row = mysql_fetch_array($getUnreadRequests))
		{
			$x++;
			$requests[$x][id] = $row[id];
			$requests[$x][status] = $row[status];
			$requests[$x][type] = $row[request_type];
			$requests[$x][message] = $row[message];
		}
		return $requests;
	}
	
}
?>