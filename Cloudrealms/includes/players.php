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
// File: players.php                                                              /
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

include("../classes/battle.class.php");
include("../includes/connect.php");
$battle = new Battle();
$battleid = $_GET[battleid];
$player[0] = $_GET[player0];
$player[1] = $_GET[player1];
$player[2] = $_GET[player2];
$player[3] = $_GET[player3];
$player[4] = $_GET[player4];
$l=0;
$z1=5;
foreach($player as $_player){ 
	$b1+=20;
	if($_player){
?>
	<div class="node" style="bottom:<? echo $b1; ?>%;left:<? echo $l=$l+40; ?>px;z-index:<? echo $z1--; ?>;">
		<b><? echo $battle->playerName($_player); ?></b>
		<img src="<? echo $battle->playerAvatar($_player); ?>">
		<div class="usagebox" style="width:120px;height:10px;overflow:hidden;"><div class="midbar" style="<? if($battle->playerHP($_player) > 0){ ?>width:<? echo $battle->playerHP($_player); ?>%;height:10px;background:#00FF08;<? } else { ?>width:100%;height:10px;background:#ff0000;<? } ?>"><small><? if($battle->playerHP($_player) > 0){ ?>HP:<? echo $battle->playerHP($_player); ?>%<? } else { ?>HP:<? echo $battle->playerHP($_player); ?>%<? } ?></small></div></div>
		<div class="usagebox" style="width:120px;height:10px;overflow:hidden;"><div class="midbar" style="width:<? echo $battle->playerMP($_player); ?>%;height:10px;background:#00C8FF;"><small>MP:<? echo $battle->playerMP($_player); ?>%</small></div></div>
		<div class="usagebox" style="width:120px;height:10px;overflow:hidden;"><div class="midbar" style="width:<? echo $battle->playerTP($_player); ?>%;height:10px;background:#F200FF;"><small>TP:<? echo $battle->playerTP($_player); ?>%</small></div></div>
	</div>
<? 
}}
?>