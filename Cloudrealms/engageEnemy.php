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
// File: engageEnemy.php                                                          /
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
$enemy = $_GET[enemy];
$loc = $_GET[loc];
$getEnemy = mysql_query("SELECT * FROM enemy WHERE id = '$enemy'") or die (mysql_error());
while($row = mysql_fetch_array($getEnemy))
{
	$enemy_id = $row[id];
	$enemy_name = $row[name];
	$enemy_avatar = $row[avatar];
	$enemy_bust = $row[bust];
	$enemy_greeting1 = $row[greeting1];
	$enemy_greeting2 = $row[greeting2];
	$enemy_level = $row[level];
	$enemy_atk = $row[attack];
	$enemy_def = $row[defense];
}
?>
<font color="#000">
<img src='<? echo $enemy_bust; ?>' width='240px' height='240px' style="float:left;"><br>
<div id="ticker" style="float:left;margin:20px;">
	<div>
		<p><? echo $enemy_greeting1; ?></p><br>
		<button class="next">Continue</button>
	</div>
	<? if($enemy_greeting2!=''){ ?>
	<div>
		<p><? echo $enemy_greeting2; ?></p><br>
		<button class="next">Continue</button>
	</div>
	<? } ?>
	<div>
		<p>Name: <? echo $enemy_name; ?></p><br>
		<p>Attack Power: <? echo $enemy_atk; ?></p><br>
		<p>Defense: <? echo $enemy_def; ?></p><br>
		<p>Level: <? echo $enemy_level; ?></p><br>
		<br>
		<p>Your Actions: <a href="index.php?mode=battle&enemy=<? echo $enemy_id; ?>&loc=<? echo $loc; ?>" target="_parent">Engage In Battle</a></p>
	</div>
</div>