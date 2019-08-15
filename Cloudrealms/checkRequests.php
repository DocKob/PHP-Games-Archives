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
// File: checkRequests.php                                                        /
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

include('interface/header.php');
include('includes/connect.php');
include('classes/requests.class.php');
$requests = new Requests();
$read=$_GET[read];
$username=$_GET[user];
$reqid=$_GET[reqid];
$action=$_GET[action];
$requests->set_all_to_read($username);
$requests->show_nav($username);
if($read=='inbox'){
	echo "<div id='inbox'></div>";
} else if($read=='sent'){
	echo "<div id='sentbox'></div>";
} else if($action=='respond'){ 
	$getRequestData = mysql_query("SELECT * FROM requests WHERE id = '$reqid'");
	while($row = mysql_fetch_array($getRequestData))
	{
		$to = $row[request_to];
		$from = $row[request_from];
		$type = $row[request_type];
	}
	$getFromID = mysql_query("SELECT * FROM users WHERE username = '$from'");
	while($row = mysql_fetch_array($getFromID))
	{
		$from_id = $row[id];
		$from_char = $row[characterID];
	}
	$getToID = mysql_query("SELECT id FROM users WHERE username = '$to'");
	while($row = mysql_fetch_array($getToID))
	{
		$to_id = $row[id];
	}
	$getPartyData = mysql_query("SELECT * FROM party WHERE leader = '$from_char'");
	while($row = mysql_fetch_array($getPartyData))
	{
		$party_name = $row[party_name];
		$members[0]=$row[member1];
		$members[1]=$row[member2];
		$members[2]=$row[member3];
		$members[3]=$row[member4];
		$partyID = $row[id];
	}
	if($type=='party')
	{
		echo "You have been invited to join the party, $party_name, by $from<br>";
		echo "<br><a href='checkRequests.php?user=$username&action=respond&reqid=$reqid&do=accept'>Accept</a> | <a href='checkRequests.php?user=$username&action=respond&reqid=$reqid&do=decline'>Decline</a>";
		if($_GET['do']=='decline')
		{
			mysql_query("DELETE FROM requests WHERE id = '$reqid'");
			echo "<br><br>You have declined $from's invite to join party";
			mysql_query("INSERT INTO requests (request_to, request_from, request_type, message, status) VALUES ('$from', '$to', 'response', '$to has declined your party invite', 'unread')");
		} else if($_GET['do']=='accept')
		{
			$count=0;
			foreach($members as $member){
				$count++;
				if($member==0){
					mysql_query("UPDATE party SET member$count = '$to_id' WHERE party_name = '$party_name'");
					echo "<br><br>You are now a member of $from's party, $party_name";
					mysql_query("INSERT INTO requests (request_to, request_from, request_type, message, status) VALUES ('$from', '$to', 'response', '$to has accepted your party invite', 'unread')");
					mysql_query("DELETE FROM requests WHERE id = '$reqid'");
					mysql_query("UPDATE characters SET party = '$partyID' WHERE id = '$to_id'");
					exit(0);
				} else {
					echo "<br><br>Party is full";
					exit(0);
				}
			}
		}
	}
}
?>
</div>
<script type="text/javascript">
function close_n(type, id)
{
	var url = "do/closeNotification.php?type="+type+"&id="+id;
	$.post(url);
}
var auto_refresh = setInterval(function ()
{
	$('#inbox').load('viewer/viewInbox.php?user=<? echo $username; ?>').fadeIn("slow");
	$('#sentbox').load('viewer/viewSentbox.php?user=<? echo $username; ?>').fadeIn("slow");
}, 1000); // refresh interval
</script>