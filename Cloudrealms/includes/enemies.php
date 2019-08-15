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
// File: enemies.php                                                              /
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
include("../classes/mmorpg.class.php");
include("../classes/inventory.class.php");
include("../classes/character.class.php");
include("../includes/connect.php");
$battle = new Battle();
$mmorpg = new MMORPG();
$inventory = new Inventory();
$char = new Character();
$battleid = $_GET[battleid];
$enemy[0] = $_GET[enemy0];
$enemy[1] = $_GET[enemy1];
$enemy[2] = $_GET[enemy2];
$enemy[3] = $_GET[enemy3];
$enemy[4] = $_GET[enemy4];
$player[0] = $_GET[player0];
$player[1] = $_GET[player1];
$player[2] = $_GET[player2];
$player[3] = $_GET[player3];
$player[4] = $_GET[player4];
$enemy1_hp = $_GET[hp];
$char_id = $_GET[char];
$loc=$_GET[loc];
$r=200;
$z=5;
$b=-5;
$hp = 0;
// Calculate party size
$x=-1;
foreach($player as $_player)
{
	$x++;
	if($_player!=0)
	{
		$_partyz[$x]=1;
	}
}
$partySize = count($_partyz);
// Grab the players target
$getPlayerTarget = mysql_query("SELECT * FROM characters WHERE id = '$player[0]'");
while($row = mysql_fetch_array($getPlayerTarget))
{
	$target = $row[current_target];
}
// RE-GET Enemies
$loadBattle = mysql_query("SELECT * FROM battle_logs WHERE unique_code = '$battleid'");
while($row = mysql_fetch_array($loadBattle))
{
	$enemy[0] = $row[enemy1];
	$enemy[1] = $row[enemy2];
	$enemy[2] = $row[enemy3];
	$enemy[3] = $row[enemy4];
	$enemy[4] = $row[enemy5];
	$enemy1_hp = $row[enemy1_hp];
	$enemy2_hp = $row[enemy2_hp];
	$enemy3_hp = $row[enemy3_hp];
	$enemy4_hp = $row[enemy4_hp];
	$enemy5_hp = $row[enemy5_hp];
	$end = $row[end];
}
// check if battle has ended, if it has redirect back to the players start location
if($end==1)
{
	$mmorpg->redirect("index.php?location=$loc");
}
// Set enemy hp to 0 if enemy does not exist
$hpnum=0;
foreach($enemy as $_enemy)
{
	$hpnum++;
	if($_enemy==0)
	{
		$where = "enemy".$hpnum."_hp";
		mysql_query("UPDATE battle_logs SET $where = '0' WHERE unique_code = '$battleid'");
	}
}
$all_enemy_hp = $battle->enemyHP($enemy[0], $battleid, 1)+$battle->enemyHP($enemy[1], $battleid, 2)+$battle->enemyHP($enemy[2], $battleid, 3)+$battle->enemyHP($enemy[3], $battleid, 4)+$battle->enemyHP($enemy[4], $battleid, 5);
$all_player_hp = $battle->playerHP($player[0])+$battle->playerHP($player[1])+$battle->playerHP($player[2])+$battle->playerHP($player[3])+$battle->playerHP($player[4]);
// Handle deaths
$enemy_hp=0;
$player_id=-1;
foreach($enemy as $_enemy)
{
	$enemy_hp++;
	$player_id++;
	$_the_enemy = "enemy".$enemy_hp;
	if($battle->enemyHP($_enemy, $battleid, $enemy_hp) <= 0)
	{
		$en_name = $battle->enemyName($_enemy);
		if($battle->enemyID($_enemy)!=0)
		{
			$mmorpg->doNote("$en_name has fallen");
		}
		mysql_query("UPDATE battle_logs SET $_the_enemy = '0' WHERE unique_code = '$battleid'");
	}
}
// Handle battle end
if($all_enemy_hp <= 0) // all enemies are dead, then end battle completely
{
	mysql_query("UPDATE battle_logs SET end = '1' WHERE unique_code = '$battleid'"); // ends battle
	mysql_query("UPDATE characters SET current_battle = '0' WHERE current_battle = '$battleid'");
	$battle->randomDropDistribution($player, $enemy, $partySize);
	$battle->expDistribution($player, $enemy);
	foreach($player as $players)
	{
		mysql_query("UPDATE characters SET current_battle = '0', current_target = 'enemy1' WHERE id = '$players'");
		if($partyID)
		{
			mysql_query("UPDATE party SET battleid = '0' WHERE id = '$partyID'");
		}
	}
	$mmorpg->redirect("index.php?location=$loc");
} else if($all_player_hp <= 0){
	$mmorpg->doNote("You have lost this battle");
	mysql_query("UPDATE battle_logs SET end = '1' WHERE unique_code = '$battleid'"); // ends battle
	mysql_query("UPDATE characters SET current_battle = '0' WHERE current_battle = '$battleid'");
	foreach($player as $players)
	{
		mysql_query("UPDATE characters SET current_battle = '0', current_target = 'enemy1' WHERE id = '$players'");
		if($partyID)
		{
			mysql_query("UPDATE party SET battleid = '0' WHERE id = '$partyID'");
		}
	}
	$mmorpg->redirect("index.php?location=$loc");
}
if($battle->playerHP($char_id) <= 0)
{
	$mmorpg->doNote("You have fallen in battle");
	mysql_query("UPDATE battle_logs SET end = '1' WHERE unique_code = '$battleid'"); // ends battle
	mysql_query("UPDATE characters SET current_battle = '0' WHERE id = '$char_id'");
	$mmorpg->redirect("index.php?location=$loc");
}
foreach($enemy as $_enemy){
	$hp++; 
	if($_enemy!=0){
?>
	<div class="node" style="bottom:<? echo $b+=20; ?>%;right:<? echo $r=$r-40; ?>px;z-index:<? echo $z--; ?>;">
		<b><? echo $battle->enemyName($_enemy); ?></b>
		<img src="<? echo $battle->enemyAvatar($_enemy); ?>" class="enemy">
		<div class="usagebox" style="width:120px;height:10px;"><div class="midbar" style="<? if($battle->enemyHP($_enemy, $battleid, $hp) > 0){ ?>width:<? echo $battle->enemyHP($_enemy, $battleid, $hp); ?>%;height:10px;background:#00FF08;<? } else { ?>width:100%;height:10px;background:#ff0000;<? } ?>">
			<small><? if($battle->enemyHP($_enemy, $battleid, $hp) > 0){ ?>HP:<? echo $battle->enemyHP($_enemy, $battleid, $hp); ?>%<? } else { ?>HP:<? echo $battle->enemyHP($_enemy, $battleid, $hp); ?>%<? } ?></small>
		</div></div>
	</div>
<? }} ?>
<script>
function playerAttack()
{
	$.post("do/attack.php?who=player&char=<? echo $char_id; ?>&enemy=<? echo $enemy[0]; ?>&id=<? echo $battleid; ?>&hp=<? echo $enemy1_hp; ?>&w=<? echo $target; ?>");
}
</script>