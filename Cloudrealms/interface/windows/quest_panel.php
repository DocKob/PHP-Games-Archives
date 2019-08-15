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
// File: quest_panel.php                                                          /
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

$grabQuestPanel = mysql_query("SELECT * FROM quest_panel WHERE charID = '$charID'") or die (mysql_error());
while($row = mysql_fetch_array($grabQuestPanel))
{
	$activeQuest = $row[activeQuest];
	$quest2 = $row[quest2];
	$quest3 = $row[quest3];
	$quest4 = $row[quest4];
}
$forActiveQuest = mysql_query("SELECT * FROM quests WHERE id = '$activeQuest'") or die (mysql_error());
while($row = mysql_fetch_array($forActiveQuest))
{
	$active_name = $row[quest_name];
	$active_desc = $row[desc];
}
$forQuest2 = mysql_query("SELECT * FROM quests WHERE id = '$quest2'") or die (mysql_error());
while($row = mysql_fetch_array($forQuest2))
{
	$quest2_name = $row[quest_name];
	$quest2_desc = $row[desc];
}
$forQuest3 = mysql_query("SELECT * FROM quests WHERE id = '$quest3'") or die (mysql_error());
while($row = mysql_fetch_array($forQuest3))
{
	$quest3_name = $row[quest_name];
	$quest3_desc = $row[desc];
}
$forQuest4 = mysql_query("SELECT * FROM quests WHERE id = '$quest4'") or die (mysql_error());
while($row = mysql_fetch_array($forQuest4))
{
	$quest4_name = $row[quest_name];
	$quest4_desc = $row[desc];
}
?>
<!-- quest panel window -->
<div id="quest_panel" class="containerPlus draggable resizable {buttons:'m,c', skin:'default', width:'350', height:'200',title:'Quest Panel', closed:'true' }" style="top:430px;left:72%;color:#000;"><br>
<ul>
	<li>
		Active Quest: 
		<? 
			if($activeQuest=='0'){ 
				echo "None"; 
			} else { 
				echo "<a href='getQuestData.php?quest=$active_name'>".$active_name."</a>"; 
			} 
		?>
	</li><hr>
	<li>
		Quest Slot 2: 
		<? if($quest2=='0'){ 
				echo "None"; 
			} else { 
				echo "<a href='getQuestData.php?quest=$quest2_name'>".$quest2_name."</a>"; 
				if($activeQuest=='0'){ 
					echo " - <a href='index.php?action=make_quest_active&quest_id=$quest2&the_quest=quest2'>Make Active</a>"; 
				}
			} 
		?>
	</li><hr>
	<li>
		Quest Slot 3: 
		<? if($quest3=='0'){ 
				echo "None"; 
			} else { 
				echo "<a href='getQuestData.php?quest=$quest3_name'>".$quest3_name."</a>"; 
				if($activeQuest=='0'){ 
					echo " - <a href='index.php?action=make_quest_active&quest_id=$quest3&the_quest=quest3'>Make Active</a>"; 
				}
			} 
		?>
	</li><hr>
	<li>
		Quest Slot 4: 
		<? if($quest4=='0'){ 
				echo "None"; 
			} else { 
				echo "<a href='getQuestData.php?quest=$quest4_name'>".$quest4_name."</a>";  
				if($activeQuest=='0'){ 
					echo " - <a href='index.php?action=make_quest_active&quest_id=$quest4&the_quest=quest4'>Make Active</a>"; 
				}
			} 
		?>
	</li><hr>
</ul>
</div>
<!-- /quest panel window -->