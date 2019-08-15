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
// File: battle.class.php                                                         /
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

class Battle
{	

	function getPlayerSpells($id)
	{
		$getSpells = mysql_query("SELECT * FROM spells WHERE user = '$id'");
		$num=0;
		while($row = mysql_fetch_array($getSpells))
		{
			$spell[$num++] = $row[scroll];
		}
		return $spell;
	}
	
	function loadScroll($id)
	{
		$getScrollData = mysql_query("SELECT * FROM scrolls WHERE id = '$id'");
		$scroll = mysql_fetch_array($getScrollData);
		return $scroll;
	}
	
	function loadTarget($id)
	{
		$getTarget = mysql_query("SELECT * FROM characters WHERE id = '$id'");
		$target = mysql_fetch_array($getTarget);
		return $target;
	}
	
	function loadEnemyTarget($enemy, $battleid)
	{
		$getTarget = mysql_query("SELECT * FROM battle_logs WHERE unique_code = '$battleid'");
		while($row = mysql_fetch_array($getTarget))
		{
			$enemyid = $row[$enemy];
		}
		$getEnemy = mysql_query("SELECT * FROM enemy WHERE id = '$enemyid'");
		$target = mysql_fetch_array($getEnemy);
		return $target;
	}
	
	function loadMonsterTarget($monster, $battleid)
	{
		$getTarget = mysql_query("SELECT * FROM battle_logs WHERE unique_code = '$battleid'");
		while($row = mysql_fetch_array($getTarget))
		{
			$monsterid = $row[$monster];
		}
		$getMonster = mysql_query("SELECT * FROM monsters WHERE id = '$monsterid'");
		$target = mysql_fetch_array($getMonster);
		return $target;
	}
	
	function getEnemyHP($enemy, $battleid)
	{
		$enemy_hp = $enemy."_hp";
		$getEnemyHP = mysql_query("SELECT * FROM battle_logs WHERE unique_code = '$battleid'");
		while($row=mysql_fetch_array($getEnemyHP))
		{
			$enemyHP = $row[$enemy_hp];
		}
		return $enemyHP;
	}
	
	function castSpell($caster, $target, $enemy, $spell, $battleid)
	{
		include_once("mmorpg.class.php");
		$mmorpg = new MMORPG();
		$caster_name = $this->playerName($caster);
		$target_hp = $this->getEnemyHP($target, $battleid);
		$spell = $this->loadScroll($spell);
		if($enemy==1)
		{
			$enemy_target = $this->loadEnemyTarget($target, $battleid);
			$enemyhp = $target."_hp";
			if($spell[dmg]==0) // must be an affect spell
			{
				if($spell[affect]!=0) // make sure it is an affect spell
				{
					if($enemy_target[$spell[affect]]==0)
					{
						$this->log($battleid, "$caster_name cast $spell[name] on $enemy_target[name] but it has no effect");
					} else {
						if($spell[affect]=='hp')
						{
							$affect = $enemy_target[hp] + $spell[plus];
							mysql_query("UPDATE battle_logs SET $enemyhp = '$affect' WHERE unique_codes = '$battleid");
						} else {
							$this->log($battleid, "$caster_name cast $spell[name] on $enemy_target[name] but it has no effect");
						}
					}
				} else {
					$this->log($battleid, "$caster_name cast $spell[name] on $enemy_target[name] but it has no affect");
				}
			} else if($spell[dmg] >= 0){
				$damage = $target_hp - $spell[dmg];
				mysql_query("UPDATE battle_logs SET $enemyhp = '$damage' WHERE unique_code = '$battleid'");
				$this->log($battleid, "$caster_name cast $spell[name] on $enemy_target[name] and deals $spell[dmg] damage");
			}
		} if($enemy==0) {
			$target_char = $mmorpg->getCharacterByName($target);
			$player_target = $this->loadTarget($target_char[id]);
			$newMP = $this->playerMP($caster) - $spell[mp_cost];
			$this->log($battleid, $newMP);
			if($spell[dmg]==0)
			{
				if($spell[affect]!='0')
				{
					$affect = $player_target[$spell[affect]] + $spell[plus];
					mysql_query("UPDATE characters SET $spell[affect] = '$affect' WHERE id = '$player_target[id]'");
					$this->log($battleid, "$caster_name cast $spell[name] on $player_target[name] and increases their $spell[affect] by $spell[plus]");
				}
			} else if($spell[dmg] >= 0){
				if($caster_name==$player_target[name]){
					$player_target[name] = "themself";
				}
				$this->log($battleid, "$caster_name attempted to cast $spell[name] on $player_target[name] but failed");
			}
			// mysql_query("UPDATE characters SET mp = '$newMP' WHERE name = '$caster_name'");
			// if(mysql_error())
			// {
				// $this->log($battleid, mysql_error());
			// }
		}
	}
	
	function getBattleMusic($location)
	{
		$getBattleAudio = mysql_query("SELECT * FROM locations WHERE name = '$location'");
		while($row=mysql_fetch_array($getBattleAudio))
		{
			$audio[ogg] = $row[battle_ogg];
			$audio[mp3] = $row[battle_mp3];
		}
		return $audio;
	}
	
	function targetName($target, $battleid)
	{
		$getTargetData = mysql_query("SELECT * FROM battle_logs WHERE unique_code = '$battleid'");
		while($row = mysql_fetch_array($getTargetData))
		{
			$_target = $row[$target];
		}
		return $this->enemyName($_target);
	}
	function enemyName($id)
	{
		$getEnemy = mysql_query("SELECT * FROM enemy WHERE id = '$id'");
		while($row=mysql_fetch_array($getEnemy))
		{
			$enemyName[$id] = $row[name];
		}
		return $enemyName[$id];
	}
	
	function enemyEXP($id)
	{
		$getEnemy = mysql_query("SELECT * FROM enemy WHERE id = '$id'");
		while($row=mysql_fetch_array($getEnemy))
		{
			$enemyEXP[$id] = $row[exp];
		}
		return $enemyEXP[$id];
	}
	
	function enemyID($id)
	{
		$getEnemy = mysql_query("SELECT * FROM enemy WHERE id = '$id'");
		while($row=mysql_fetch_array($getEnemy))
		{
			$enemyID[$id] = $row[id];
		}
		return $enemyID[$id];
	}
	
	function enemyAttack($id)
	{
		$getEnemy = mysql_query("SELECT * FROM enemy WHERE id = '$id'");
		while($row=mysql_fetch_array($getEnemy))
		{
			$enemyAttack[$id] = $row[attack];
		}
		return $enemyAttack[$id];
	}
	
	function enemyDefense($id)
	{
		$getEnemy = mysql_query("SELECT * FROM enemy WHERE id = '$id'");
		while($row=mysql_fetch_array($getEnemy))
		{
			$enemyDefense[$id] = $row[defense];
		}
		return $enemyDefense[$id];
	}
	
	function enemyAvatar($id)
	{
		$getEnemy = mysql_query("SELECT * FROM enemy WHERE id = '$id'");
		while($row=mysql_fetch_array($getEnemy))
		{
			$enemyAvatar[$id] = $row[combat_avatar];
		}
		return $enemyAvatar[$id];
	}
	
	function enemyHP($id, $battleid, $enemy_hp)
	{
		$enemy_hp = "enemy".$enemy_hp."_hp";
		$getEnemy = mysql_query("SELECT $enemy_hp FROM battle_logs WHERE unique_code = '$battleid'");
		while($row=mysql_fetch_array($getEnemy))
		{
			$enemyHP[$id] = $row[$enemy_hp];
		}
		return $enemyHP[$id];
	}
	
	function playerName($id)
	{
		$getPlayer = mysql_query("SELECT * FROM characters WHERE id = '$id'");
		while($row=mysql_fetch_array($getPlayer))
		{
			$playerName[$id] = $row[name];
		}
		return $playerName[$id];
	}
	
	function playerAttack($id)
	{
		$getPlayer = mysql_query("SELECT * FROM characters WHERE id = '$id'");
		while($row=mysql_fetch_array($getPlayer))
		{
			$playerAttack[$id] = $row[attack];
		}
		return $playerAttack[$id];
	}
	
	function playerDefense($id)
	{
		$getPlayer = mysql_query("SELECT * FROM characters WHERE id = '$id'");
		while($row=mysql_fetch_array($getPlayer))
		{
			$playerDefense[$id] = $row[defense];
		}
		return $playerDefense[$id];
	}
	
	function playerAvatar($id)
	{
		$getPlayer = mysql_query("SELECT * FROM characters WHERE id = '$id'");
		while($row=mysql_fetch_array($getPlayer))
		{
			$playerAvatar[$id] = $row[combat_avatar];
		}
		return $playerAvatar[$id];
	}
	
	function playerHP($id)
	{
		$getPlayer = mysql_query("SELECT * FROM characters WHERE id = '$id'");
		while($row=mysql_fetch_array($getPlayer))
		{
			$playerHP[$id] = $row[hp];
		}
		return $playerHP[$id];
	}
	
	function playerMP($id)
	{
		$getPlayer = mysql_query("SELECT * FROM characters WHERE id = '$id'");
		while($row=mysql_fetch_array($getPlayer))
		{
			$playerMP[$id] = $row[mp];
		}
		return $playerMP[$id];
	}
	
	function playerTP($id)
	{
		$getPlayer = mysql_query("SELECT * FROM characters WHERE id = '$id'");
		while($row=mysql_fetch_array($getPlayer))
		{
			$playerTP[$id] = $row[tp];
		}
		return $playerTP[$id];
	}
	
	function playerLevel($id)
	{
		$getPlayer = mysql_query("SELECT * FROM characters WHERE id = '$id'");
		while($row=mysql_fetch_array($getPlayer))
		{
			$playerLevel[$id] = $row[level];
		}
		return $playerLevel[$id];
	}
	
	function log($battleid, $message)
	{
		mysql_query("INSERT INTO logs (unique_code, message) VALUES ('$battleid', '$message')");
	}
	
	public function attack($who, $attacker, $victim, $battleid, $enemy)
	// set who to either enemy or player, attacker is the id of the attacker, victim is the id of the victim, the battleid is the unique code for the battle, only define enemy hp if attacking enemy, enemy is to be set to which enemy column such as enemy1, enemy2
	{
		if($who!='player') // When the enemy attacks
		{
			$getAttacker = mysql_query("SELECT * FROM enemy WHERE id = '$attacker'");
			while($row=mysql_fetch_array($getAttacker))
			{
				$atk_name = $row[name];
				$atk_power = $row[attack];
			}
			$getVictim = mysql_query("SELECT * FROM characters WHERE id = '$victim'");
			while($row=mysql_fetch_array($getVictim))
			{
				$vic_name = $row[name];
				$vic_hp = $row[hp];
			}
			if($victim==0)
			{
				mysql_query("INSERT INTO logs (unique_code, message) VALUES ('$battleid', '$atk_name missed')");
			} else {
				$victim_hp = $vic_hp - $atk_power;
				mysql_query("UPDATE characters SET hp = '$victim_hp' WHERE id = '$victim'");
				mysql_query("INSERT INTO logs (unique_code, message) VALUES ('$battleid', '$atk_name attacked $vic_name for $atk_power damage points')");
			}
		} else { // If player attacks
			// grab both player and enemy data
			$getPlayer = mysql_query("SELECT * FROM characters WHERE id = '$attacker'");
			while($row=mysql_fetch_array($getPlayer))
			{
				$player_name = $row[name];
				$player_attack = $row[attack];
			}
			$getEnemy = mysql_query("SELECT * FROM enemy WHERE id = '$victim'");
			while($row=mysql_fetch_array($getEnemy))
			{
				$enemy_name = $row[name];
			}
			// next grab enemy data from the battle log
			$enemy = $enemy."_hp";
			$getEnemyHP = mysql_query("SELECT * FROM battle_logs WHERE unique_code = '$battleid'");
			while($row=mysql_fetch_array($getEnemyHP))
			{
				$enemy_hp = $row[$enemy];
			}
			$victim_hp = $enemy_hp - $player_attack;
			mysql_query("UPDATE battle_logs SET $enemy = '$victim_hp' WHERE unique_code = '$battleid'");
			mysql_query("INSERT INTO logs (unique_code, message) VALUES ('$battleid', '$player_name attacked $enemy_name for $player_attack damage points')");
		}
		// Next increase players tp whether enemy attacks or the player attacks tp will still be increased
		$tpIncreaseAmmount = rand(5, 30);
		if($who!='player'){
			$this->increaseTP($tpIncreaseAmmount, $victim);
		} else {
			$this->increaseTP($tpIncreaseAmmount, $attacker);
		}
	}
	
	public function defend($who, $defender, $aggresor, $initial_attack, $battleid, $enemy_hp, $enemy)
	{
		if($who!='player') // When the enemy defends
		{
			$getDefender = mysql_query("SELECT * FROM enemy WHERE id = '$defender'");
			while($row=mysql_fetch_array($getDefender))
			{
				$def_name = $row[name];
				$def_power = $row[defense];
				$def_hp = $row[hp];
			}
			$getAggresor = mysql_query("SELECT * FROM characters WHERE id = '$aggresor'");
			while($row=mysql_fetch_array($getAggresor))
			{
				$agr_name = $row[name];
				$agr_hp = $row[hp];
				$agr_atk = $row[attack];
			}
			if($aggresor==0)
			{
				mysql_query("INSERT INTO logs (unique_code, message) VALUES ('$battleid', '$atk_name does nothing')");
			} else {
				$dmg = $agr_atk - $def_power;
				$def_hp = $def_hp - $dmg;
				mysql_query("UPDATE battle_logs SET $enemy = '$def_hp' WHERE id = '$defender'");
				mysql_query("INSERT INTO logs (unique_code, message) VALUES ('$battleid', '$def_name defended against $agr_name attack')");
			}
		} else { // If player attacks
			$getAttacker = mysql_query("SELECT * FROM characters WHERE id = '$attacker'");
			while($row=mysql_fetch_array($getAttacker))
			{
				$atk_name = $row[name];
				$atk_power = $row[attack];
			}
			$getVictim = mysql_query("SELECT * FROM enemy WHERE id = '$victim'");
			while($row=mysql_fetch_array($getVictim))
			{
				$vic_name = $row[name];
			}
			$victim_hp = $enemy_hp - $atk_power;
			$enemy = $enemy."_hp";
			mysql_query("UPDATE battle_logs SET $enemy = '$victim_hp' WHERE unique_code = '$battleid'");
			mysql_query("INSERT INTO logs (unique_code, message) VALUES ('$battleid', '$atk_name attacked $vic_name for $atk_power damage points')");
		}
	}
	
	public function retreat($id, $battleid, $mmorpg, $leader=NULL, $partyID=NULL)
	{
		$name = $this->playerName($id);
		$player_hp = $this->playerHP($id);
		$luck = rand(2, 4);
		if($player_hp > 0)
		{
			if($luck==3)
			{
				if($leader!=NULL)
				{
					mysql_query("UPDATE party SET battleid = '0' WHERE id = '$partyID'");
					$getParty = mysql_query("SELECT * FROM party WHERE id = '$partyID'");
					while($row=mysql_fetch_array($getParty))
					{
						$player[0] = $row[leader];
						$player[1] = $row[member1];
						$player[2] = $row[member2];
						$player[3] = $row[member3];
						$player[4] = $row[member4];
						$party_name = $row[party_name];
						$party_battle = $row[battleid];
					}
					foreach($player as $_player)
					{
						if($_player)
						{
							mysql_query("UPDATE characters SET current_battle = '0' WHERE id = '$_player'");
						}
					}
				}
				mysql_query("INSERT INTO logs (unique_code, message) VALUES ('$battleid', '$name has retreated from the battle')");
				mysql_query("UPDATE characters SET current_battle = '0' WHERE id = '$id'");
				mysql_query("UPDATE battle_logs SET end = '1' WHERE unique_code = '$battleid'");
				echo "<script>location.href = 'index.php';</script>";
			} else {
				mysql_query("INSERT INTO logs (unique_code, message) VALUES ('$battleid', '$name failed to retreat')");
				$retreat = false;
			}
		} else 
		{
			mysql_query("INSERT INTO logs (unique_code, message) VALUES ('$battleid', '$name has fallen, and has retreated from the battle')");
			mysql_query("UPDATE characters SET current_battle = '0' WHERE id = '$id'");
			echo "<script>location.href = 'index.php';</script>";
		}
		return $retreat;
	}
	
	function enemyDrops($id)
	{
		$getEnemy = mysql_query("SELECT * FROM enemy WHERE id = '$id'");
		while($row=mysql_fetch_array($getEnemy))
		{
			$enemyDrop[0] = $row[drop1];
			$enemyDrop[1] = $row[drop2];
			$enemyDrop[2] = $row[drop3];
			$enemyDrop[3] = $row[drop4];
		}
		return $enemyDrop;
	}
	
	function randomDropDistribution($player, $enemy, $partySize)
	{
		include_once("inventory.class.php");
		$inventory = new Inventory();
		include_once("mmorpg.class.php");
		$mmorpg = new MMORPG();
		$enemy1_drops = $this->enemyDrops($enemy[0]);
		$enemy2_drops = $this->enemyDrops($enemy[1]);
		$enemy3_drops = $this->enemyDrops($enemy[2]);
		$enemy4_drops = $this->enemyDrops($enemy[3]);
		for($x=0;$x < count($enemy1_drops);$x++)
		{
			$drops[$x] = $enemy1_drops[$x];
		}
		for($y=4;$y < count($enemy2_drops);$y++)
		{
			$drops[$y] = $enemy2_drops[$y];
		}
		for($z=8;$z < count($enemy3_drops);$z++)
		{
			$drops[$z] = $enemy3_drops[$z];
		}
		for($i=12;$i < count($enemy4_drops);$i++)
		{
			$drops[$i] = $enemy3_drops[$i];
		}
		for($n=0; $n < count($drops);$n++)
		{
			if($drops[$n]!=0)
			{
				$drop[$n]=$drops[$n];
			}
		}
		$split = count($drop)/$partySize;
		$split = round($split);
		foreach($player as $_player)
		{
			if($_player!=0)
			{
				$playerz = $_player;
			}
		}
		for($w=0; $w < count($playerz); $w++)
		{
			if($drop[$w]!='')
			{
				$inventory->add_item($drop[$w], $playerz[$w]);
			}
		}
	}

	function expDistribution($player, $enemy)
	{
		include_once("character.class.php");
		$char = new Character();
		$num=-1;
		$numm=-1;
		foreach($player as $_player) // get an array of active players
		{
			$num++;
			if($_player!=0)
			{
				$players[$num] = $_player;
			}
		}
		foreach($enemy as $_enemy) // make array of all active enemies exp points
		{
			$numm++;
			if($_enemy!=0)
			{
				$enemies[$numm] = $this->enemyEXP($_enemy);
			}
		}
		$totalEXP = array_sum($enemies);
		$splitEXP = round($totalEXP/count($players));
		foreach($players as $_playerx)
		{
			if($splitEXP > 0)
			{
				$char->gainEXP($splitEXP, $_playerx);
			}
		}
	}
	
	function increaseTP($ammount, $player)
	{
		$getCurrentTP = mysql_query("SELECT * FROM characters where id = '$player'");
		while($row = mysql_fetch_array($getCurrentTP))
		{
			$currentTP = $row[tp];
		}
		$newTP = $ammount + $currentTP;
		mysql_query("UPDATE characters SET tp = '$newTP' WHERE id = '$player'");
	}
	
	function handleDeath($hp)
	{
		if($hp <= 0){
			$this->battle_redirect("index.php");
		}
	}
		
	function battle_redirect($url, $time=NULL)
	{
	  echo '<script>location.href = "'.$url.'";</script>';
	}
}
?>