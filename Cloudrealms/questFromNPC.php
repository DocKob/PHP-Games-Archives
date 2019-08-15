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
// File: questFromNPC.php                                                         /
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

include('includes/connect.php');
include('interface/header.php');
$npc = $_GET[npc];
$char = $_GET[char];
$method = $_GET[method];
?>
<script language="JavaScript">
function toggle(id) 
{
	var state = document.getElementById(id).style.display;
	if (state == 'block') {
		document.getElementById(id).style.display = 'none';
	} else {
		document.getElementById(id).style.display = 'block';
	}
}
</script>
<font color="#000">
<?
// START QUEST METHOD CONTROLS
include('classes/quest.class.php');
$quest = new Quest();
// loaded quest methods

function quest_panel($npc, $char)
{
	$count=0;
	$getNPCz2 = mysql_query("SELECT * FROM npc WHERE id = '$npc'") or die (mysql_error());
	while($row = mysql_fetch_array($getNPCz2))
	{
		$npc_id = $row[id];
		$npc_name = $row[name];
		$npc_height = $row[height];
		$npc_weight = $row[weight];
		$npc_avatar = $row[avatar];
		$npc_bust = $row[bust];
		$npc_age = $row[age];
		$npc_greeting = $row[greeting];
	}
	echo "<img src='$npc_bust' width='240px' height='240px' style='float:left;'><br>";
	echo "<div style='float:left;margin:20px;width:400px;'>";
	echo '<h1>Quest offered by '.$npc_name.'</h1><br>';
	$getQuests = mysql_query("SELECT * FROM quests WHERE npc1 = '$npc'") or die (mysql_error());
	while($row = mysql_fetch_array($getQuests))
	{
		$count++;
		$quest_id = $row[id];
		?>
		<? echo $row[quest_name]; ?> - <a href="javascript:toggle('quest-<? echo $count; ?>');">Info</a> - <a href="questFromNPC.php?npc=<? echo $npc; ?>&method=takeQuest&id=<? echo $quest_id; ?>&char=<? echo $char; ?>">Take Quest</a>
		<div id="quest-<? echo $count; ?>" style="display:none;width:430px;"><br><div class="status info">
		<p class="closestatus"><a href="javascript:toggle('quest-<? echo $count; ?>');" title="Close">x</a></p>
		<p><b>Description:</b><br><? echo $row[info]; ?><br><b>Locations:</b><br><? echo $row[loc1] ?><br><b>Rewards:</b><br><? echo $row[reward]; ?></p>
		</div></div><hr>
		<?
	}
	echo '</div>';
}
function takeQuest($npc, $quest, $quest_id, $char_id)
{
	echo $quest->acceptQuest($quest_id, $char_id);
}
// 	Handle methods below
if($method=='')
{
	echo quest_panel($npc, $char);
} else if($method=='takeQuest')
{
	echo takeQuest($npc, $quest, $_GET[id], $char);
}
?>