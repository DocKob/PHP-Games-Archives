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
// File: battle_handler.php                                                       /
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

if($hp > 0)
{
	if($mode=='battle')
	{
		$getBattleData = mysql_query("SELECT * FROM battle_logs WHERE unique_code = '$battleid'") or die(mysql_error());
		while($row = mysql_fetch_array($getBattleData))
		{
			$end = $row[end];
		}
		if($end==1)
		{
			$mmorpg->redirect("index.php?location=$loc");
		}
	}
	if($mode!='battle')
	{
		if($currentBattle!='0')
		{
			$mmorpg->doNote("You are still engaged in a battle!");
			$getBattleData = mysql_query("SELECT * FROM battle_logs WHERE unique_code = '$currentBattle'") or die(mysql_error());
			while($row = mysql_fetch_array($getBattleData))
			{
				$end = $row[end];
				$enemy_check1 = $row[enemy1];
				$enemy_check2 = $row[enemy2];
				$enemy_check3 = $row[enemy3];
				$enemy_check4 = $row[enemy4];
				$enemy_check5 = $row[enemy5];
			}
			$enemy_check =  $enemy_check1+$enemy_check2+$enemy_check3+$enemy_check4+$enemy_check5;
			if($end==0)
			{
				$mmorpg->redirect("index.php?mode=battle&battleid=$currentBattle&count=load");
			} else {
				mysql_query("UPDATE characters SET current_battle = '0' WHERE id = '$char_id'");
				$mmorpg->redirect("index.php?location=$loc");
			}
			if($enemy_check==0)
			{
				mysql_query("UPDATE battle_logs SET end = '1'");
			}
			if($currentBattle!=0 && $end==1)
			{
				mysql_query("UPDATE characters SET current_battle = '0' WHERE id = $char_id");
			}
		}
		if($partyID!=0)
		{
			$getParty = mysql_query("SELECT * FROM party WHERE id = '$partyID'");
			while($row=mysql_fetch_array($getParty))
			{
				$party_battle = $row[battleid];
			}
			if($party_battle)
			{
				mysql_query("UPDATE characters SET current_battle = '$party_battle' WHERE id ='$char_id'");
				$mmorpg->doNote("Your party is engaged in battle!");
				$mmorpg->redirect("index.php?mode=battle&battleid=$party_battle&count=load");
			}
		}
	}
} else {
	$mmorpg->doNote("Your character is dead");
	mysql_query("UPDATE characters SET current_battle = '0' WHERE id = '$char_id'");
}
?>

