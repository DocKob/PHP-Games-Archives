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
// File: requests.class.php                                                       /
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

class Requests{

	function show_nav($user)
	{
		echo '<div style="color:#000;overflow-y:scroll;height:100%;">';
		echo '<a href="checkRequests.php?read=inbox&user='.$user.'">Inbox</a> | ';
		echo '<a href="checkRequests.php?read=sent&user='.$user.'">Sent Box</a><br><br>';
	}
	
	function set_all_to_read($user)
	{
		mysql_query("UPDATE requests SET status = 'read' WHERE request_to = '$user'");
	}
	
	function inbox($user)
	{
		$i=0;
		$getRequests=mysql_query("SELECT * FROM requests WHERE request_to = '$user'");
		while($row = mysql_fetch_array($getRequests))
		{ 
			$message[$i++]=$row[message];
			if(count($message)=='0'){ 
				echo "Inbox is empty";
			} else {
				echo '<div class="status info" style="width:90%;color:#000;float:left;">';
				?><form name="request<? echo $i; ?>" class="formx" onsubmit='close_n("<? echo $row[request_type]; ?>", "<? echo $row[id]; ?>");return false'><p class="closestatus"><input type="submit" value="x"></p></form><?
				echo '<p><img src="interface/img/icons/icon_info.png" alt="Request inbox" /><span>'.$row[request_type].'</span> From: <a href="">'.$row[request_from].'</a> - '.$row[message].' - Status: '.$row[status].'';
				if($row[request_type]=='response'){ } 
				else 
				{
					echo '- <a href="checkRequests.php?user='.$user.'&action=respond&reqid='.$row[id].'">Respond</a></p>';
				}
				echo '</div>';
			}
		}
	}
	
	function sentbox($user)
	{
		$i=0;
		$getSentRequests=mysql_query("SELECT * FROM requests WHERE request_from = '$user'");
		while($row = mysql_fetch_array($getSentRequests))
		{
			$message[$i++]=$row[message];
			if(count($message)==0)
			{ 
				echo "Sent Box is empty"; 
			} else {
				if($row[status]=='read')
				{
					echo '<div class="status info" style="width:90%;color:#000;float:left;">';
					?><form name="request<? echo $i; ?>" class="formx" onsubmit='close_n("<? echo $row[request_type]; ?>", "<? echo $row[id]; ?>");return false'><p class="closestatus"><input type="submit" value="x"></p></form><?
					echo '<p><img src="interface/img/icons/icon_info.png" alt="Request inbox" /><span>'.$row[request_type].' request</span> To: <a href="">'.$row[request_to].'</a> - '.$row[message].' - '.$row[status].'</p>';
					echo '</div>';
				}
			}
		}
	}
	
}
	
?>