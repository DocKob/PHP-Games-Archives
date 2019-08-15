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
// File: messages.php                                                             /
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

include("includes/connect.php");
include("classes/comm.class.php");
include("classes/character.class.php");
include("classes/social.class.php");
$social = new Social();
$do = $_GET['do'];
$char = new Character();
$comm = new Comm();
$user = $_GET[user];
$to = $_GET[to];
$from = $_GET[from];
$message = $_GET[message];
$to_name = $char->getNameFromID($to);
$from_name = $char->getNameFromID($from);
$sender = $char->getNameFromID($user);
?>
<link href="interface/styles/layout.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="interface/styles/socialHub.css" />
<link rel="stylesheet" type="text/css" href="interface/styles/table-styles.css" />
<?
echo $social->displayHubMenu($user);
echo "<h2>Messages</h2>";
echo "<div style='margin:10px;'><a href='messages.php?do=inbox&user=".$user."'>Inbox</a> | <a href='messages.php?do=sentbox&user=".$user."'>Sentbox</a> | <a href='messages.php?do=compose&user=".$user."'>Compose</a></div>";
if($do=='compose'){
/// Compose Message
echo "<div style='color:#000;margin:10px;'>";
echo "<h2>Compose a message</h2>";
echo "<form method='post' action='$_SERVER[REQUEST_URI]'>";
echo "<table><tr>";
echo "<td>To:</td><td> <input type='textbox' name='to' size='30' value='$to_name' ";
		if($to){
			echo "readonly='readonly'";
		}
		echo "></td></tr>";
		if($from){
			echo "<tr><td>From:</td><td> <input type='textbox' name='from' size='30' value='$from_name' readonly='readonly'></td></tr>";
		} else {
			echo  "<tr><td>From:</td><td>".$sender."</td></tr>";
		}
echo "<tr><td>Subject:</td> <td><input type='textbox' name='subject' size='30'></td></tr>";
echo "<tr><td>Message:</td><td><textarea rows='5' cols='30' name='message' style='float:right;'></textarea></td></tr>";
echo "</table><br><input type='submit' name='send_message' value='Send Message'></form></div>";
if($_POST[send_message])
{
	$comm->new_pm($_POST[to], $_POST[from], $_POST[subject], $_POST[message]);
	echo "Message sent!";
}
} else if($do=='inbox'){
/// Inbox
?>
<table id="box-table-a" width="100%">
<thead>  
	<tr>
		<td>View</td>
		<td>Status</td>
		<td>From</td>
		<td>Subject</td>
		<td>Date</td>
	</tr>
</thead> 
<tbody> 
<? 
$received = $comm->get_received_pm($user);
for($i=0; $i < count($received[id]); $i++){ ?>
	<tr>
		<td><a href="messages.php?do=read&message=<? echo $received[id][$i]; ?>&user=<? echo $user; ?>">[ x ]</a></td>
		<td><? echo $received[status][$i]; ?></td>
		<td><? echo $received[from][$i]; ?></td>
		<td><? echo $received[subject][$i]; ?></td>
		<td><? echo $received[date][$i]; ?></td>
	</tr>
	<? } ?>
</tbody>
</table>
<?
} else if($do=='read'){
/// View Message
$pm = $comm->get_pm($message);
if($pm[pmto]==$sender){
	$comm->set_pm_read($message);
}
?>
<table id="box-table-a" width="100%">
<thead>  
	<tr>
		<td>From:</td>
		<td><? echo $pm[pmfrom]; ?></td>
	</tr>
	<tr>
		<td>To:</td>
		<td><? echo $pm[pmto]; ?></td>
	</tr>
	<tr>
		<td>Subject:</td>
		<td><? echo $pm[pmsubject]; ?></td>
	</tr>
</thead>
</table>
<table id="box-table-a">
<tbody>
	<tr>
		<td height="200px" valign="top"><? echo $pm[message]; ?></td>
	</tr>
</tbody>
</table>
<?
} else if($do=='sentbox'){
/// Sentbox
?>
<table id="box-table-a" width="100%">
<thead>  
	<tr>
		<td>View</td>
		<td>Status</td>
		<td>To</td>
		<td>Subject</td>
		<td>Date</td>
	</tr>
</thead> 
<tbody> 
<? 
$sent = $comm->get_sent_pm($user);
for($i=0; $i < count($sent[id]); $i++){ ?>
	<tr>
		<td><a href="messages.php?do=read&message=<? echo $sent[id][$i]; ?>&user=<? echo $user; ?>">[ x ]</a></td>
		<td><? echo $sent[status][$i]; ?></td>
		<td><? echo $sent[to][$i]; ?></td>
		<td><? echo $sent[subject][$i]; ?></td>
		<td><? echo $sent[date][$i]; ?></td>
	</tr>
	<? } ?>
</tbody>
</table>
<?
}
?>

