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
// File: npcz.php                                                                 /
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

?>
<!-- npc in area window -->
<div id="npcz" class="containerPlus draggable resizable {buttons:'m,c', skin:'default', width:'350', height:'200',title:'NPC in Area', closed:'true' }" style="top:10px;left:72%;color:#000;"><br>
<ul>
<?php
$count_npcz=0;
$getNPCz = mysql_query("SELECT * FROM npc WHERE location = '$loc_id'") or die (mysql_error());
while($row = mysql_fetch_array($getNPCz))
{
	$count_npcz++;
}
$getNPCz2 = mysql_query("SELECT * FROM npc WHERE location = '$loc_id'") or die (mysql_error());
echo "There is ".$count_npcz." NPC('s) in the area<br><br>";
$count=1;
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
?>
<li><? echo $npc_name; ?> - <a href="#" onclick="cwindow('questFromNPC.php?npc=<? echo $npc_id; ?>&loc=<? echo $loc_id; ?>&char=<? echo $char_id; ?>');">Quest</a> - <a href="#" onclick="cwindow('talkToNPC.php?npc=<? echo $npc_id; ?>');">Talk</a> - *Trade</li><hr>
<?
}
?>
</ul>
</div>
<!-- /npc in area window -->