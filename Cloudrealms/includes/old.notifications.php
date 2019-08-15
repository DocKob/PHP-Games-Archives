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
// File: old.notifications.php                                                    /
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

include("../includes/connect.php");
include("../classes/mmorpg.class.php");
include("../classes/character.class.php");
$message_on = $_GET[message_on];
$message = $_GET[message];
$message_type = $_GET[message_type];
$username=$_GET[user];
$userID=$_GET[userid];
$grabUserData = mysql_query("SELECT * FROM users WHERE username = '$username'");
while($row = mysql_fetch_array($grabUserData))
{
	$useravatar = $row['avatar'];
	$email = $row['email'];
	$username = $row['username'];
	$status = $row['status'];
	$charID = $row['characterID'];
	$userID = $row['id'];
}
$grabCharacterData = mysql_query("SELECT * FROM characters WHERE userID = '$userID'");
while($row = mysql_fetch_array($grabCharacterData))
{
	include_once('../classes/character.class.php');
	$character = new Character();
	$char_id = $row['id'];
	$name = $row['name'];
	$level = $row['level'];
	$money = $row['money'];
	$exp = $row['exp'];
	$hp = $row['hp'];
	$mp = $row['mp'];
	$tp = $row['tp'];
	$age = $character->calculateCharacterAge($row['age']);
	$knowledge = $row['knowledge'];
	$strength = $row['strength'];
	$charm = $row['charm'];
	$zodiac = $row['zodiac'];
	$avatar = $row['avatar'];
	$martial = $row['martial'];
	$class = $row['class'];
	$grabClass = mysql_query("SELECT name FROM classes WHERE id = '$class'");
	while($n = mysql_fetch_array($grabClass))
	{
		$class = $n['name'];
	}
	$gender = $row['gender'];
	$inventoryID = $row['inventoryID'];
	$partyID = $row['party'];
	$currentBattle = $row['current_battle'];
	$target = $row['current_target'];
}
if($message_on==true){ 
?>
<div id="notification1" class="status <? echo $message_type; ?>" style="width:300px;margin-top:20px;margin-right:100px;color:#000;float:right;z-index:10;position:absolute;right:8px;">
	<p class="closestatus"><a href="#" onclick="document.getElementById('notification1').style.display='none';" title="Close">x</a></p>
	<p><img src="interface/img/icons/icon_<? echo $message_type; ?>.png" alt="<? echo $message_type; ?>" /><span><? echo $message_type; ?>!</span> <? echo $message; ?></p>
</div>
<? 
} else 
{ 
	//do nothing
} 
if($inventoryID==0){
$message_on=true;
?>
<div id="notification2" class="status error" style="width:300px;margin-top:20px;margin-right:100px;color:#000;float:right;z-index:10;position:absolute;right:8px;">
	<p class="closestatus"><a href="#" onclick="document.getElementById('notification2').style.display='none';"  title="Close">x</a></p>
	<p><img src="interface/img/icons/icon_error.png" alt="Your inventory has not yet been setup" /><span>Warning!</span> Your inventory has not been setup, <a href="setup_inventory.php?char=<? echo $name; ?>" id="inventory-setup">click here</a> to set it up</p>
</div>
<?
}
$i=0;
$getUnreadRequests=mysql_query("SELECT * FROM requests WHERE request_to = '$username' AND status = 'unread'");
while($row = mysql_fetch_array($getUnreadRequests))
{
	$requests[$i++]=$row[status];
	$request_type=$row[request_type];
	$request_message=$row[message];
}
$numberOfRequests=count($requests);
if($numberOfRequests > 0){
?>
<div id="notification3" class="status info" style="width:300px;margin-top:20px;margin-right:100px;color:#000;float:right;z-index:10;position:absolute;right:8px;">
	<p class="closestatus"><a href="index.php?location=<? echo $location; ?>&action=read_requests" title="Close">x</a></p>
	<p><img src="interface/img/icons/icon_info.png" alt="Notification" /><span>Notice!</span><? if($request_type=='response'){ echo " ".$request_message; } else { ?> You have (<? echo $numberOfRequests; ?>) new requests! <a href="checkRequests.php?read=inbox&user=<? echo $username; ?>" id="request-5">Check Your Request</a><? } ?></p>
</div>
<? } ?>