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
// File: talkToNPC.php                                                            /
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
$getNPCz2 = mysql_query("SELECT * FROM npc WHERE id = '$npc'") or die (mysql_error());
while($row = mysql_fetch_array($getNPCz2))
{
	$npc_id = $row[id];
	$npc_name = $row[name];
	$npc_avatar = $row[avatar];
	$npc_bust = $row[bust];
	$npc_age = $row[age];
	$npc_greeting1 = $row[greeting1];
	$npc_greeting2 = $row[greeting2];
	$npc_greeting3 = $row[greeting3];
}
?>
<font color="#000">
<img src='<? echo $npc_bust; ?>' width='240px' height='240px' style="float:left;"><br>
<div id="ticker" style="float:left;margin:20px;">
	<div>
		<p><? echo $npc_greeting1; ?></p><br>
		<? if(!$npc_greeting2==''){ ?>
		<button class="next">Continue</button>
		<? } else {} ?>
	</div>
	<div>
		<p><? echo $npc_greeting2; ?></p><br>
		<? if(!$npc_greeting3==''){ ?>
		<button class="next">Continue</button>
		<? } else {} ?>
	</div>
	<div>
		<p><? echo $npc_greeting3; ?></p><br>
	</div>
</div>