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
// File: notifications.php                                                        /
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

include("connect.php");
include("../classes/comm.class.php");
$comm = new Comm();
include("../classes/mmorpg.class.php");
$mmorpg = new MMORPG();
$user = $_GET[user];
$x=-1;
$char = $mmorpg->getCharacter($user);
$user = $mmorpg->getUser($user);
$grabNotifications = mysql_query("SELECT * FROM notifications WHERE user = '$user[id]'");
while($row = mysql_fetch_array($grabNotifications))
{
	$x++;
	$notification_id[$x] = $row[id];
	$message[$x] = $row[message];
	$message_type[$x] = $row[message_type];
	$status[$x] = $row[status];
	$notification[$x] = $row[id];
}
$y=-1;
echo "<div style='top:10px;right:5px;float:right;position:absolute;z-index:99999;width:300px;color:#000;'>";
if($message_type[0]!='')
{
	foreach($message_type as $notification)
	{
		$y++;
		if($status[$y]!="read")
		{	
			echo "<div id='notification$y' class='status $notification'>";
			?><form name='notification<? echo $y; ?>' class='formx' onsubmit='close_n("notification", "<? echo $notification_id[$y]; ?>");return false'><p class='closestatus'><input type='submit' value='x' style="cursor:pointer;"></p></form><?
			echo "<p><img src='interface/img/icons/icon_$notification.png' alt='$notification' /><span>$notification!</span> $message[$y]</p>";
			echo "</div>";
		}
	}
}
if($char[inventory]==0)
{
	echo "<div id='inv_notification' class='status error'>";
	?><form name='inv_notification' class='formx'><p class='closestatus'><input type='button' value='x' onclick='document.getElementById("inv_notification").style.display="none";' style="cursor:pointer;"></p></form><?
	?><p><img src='interface/img/icons/icon_error.png' alt='Your inventory has not yet been setup' /><span>Warning!</span>  Your inventory has not been setup, <a href='#' onclick="cwindow('setup_inventory.php?char=<? echo $char; ?>');">click here</a> to set it up</p><?
	echo "</div>";
}
$requests = $comm->retrieve_unread_requests($user[name]);
$numberOfRequests=count($requests);
$r = 8;
for($i=0;$i < $numberOfRequests;$i++)
{
	$r++;
	echo "<div id='request$i' class='status info'>";
	?><form name='request<? echo $i; ?>' class='formx' onsubmit='close_n("request", "<? echo $requests[$i][id]; ?>");return false'><p class='closestatus'><input type='submit' value='x' style="cursor:pointer;"></p></form><?
	echo "<p><img src='interface/img/icons/icon_info.png' alt='Notification!' /><span>notice!</span>";
	if($requests[$i][type]=='response')
	{
		echo " ".$requests[$i][message];
	} else {
		?>You have (<? echo $numberOfRequests; ?>) new requests! <a href='#' onclick="cwindow('checkRequests.php?read=inbox&user=<? echo $user[name]; ?>');">Check Your Requests</a><?
	}
	echo "</p>";
	echo "</div>";
}
echo "</div>";
?>
<script type="text/javascript">
function close_n(type, id)
{
	var url = "do/closeNotification.php?type="+type+"&id="+id;
	$.post(url);
}
</script>
