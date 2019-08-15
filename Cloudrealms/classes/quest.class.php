<?php
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
// File: quest.class.php                                                          /
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

class Quest {
	var $id;
	var $quest_name;
	var $info;
	var $npc1;
	var $npc2;
	var $npc3;
	var $npc4;
	var $npc5;
	var $loc1;
	var $loc2;
	var $loc3;
	var $loc4;
	var $loc5;
	var $condition1;
	var $condition2;
	var $condition3;
	var $condition4;
	var $condition5;
	var $scene1;
	var $scene2;
	var $scene3;
	var $scene4;
	var $scene5;
	var $reward1;
	var $reward2;
	var $reward3;
	var $reward4;
	var $reward5;
	var $exp;
	var $level_required;
	var $quest_type;
	var $party;
	var $complex1;
	var $complex2;
	var $complex3;
	var $complex4;
	var $completion_time;
	var $end_condition;
	
	public function newQuest($_quest_name, $_info, $_npc1, $_npc2, $_npc3, $_npc4, $_npc5, $_loc1, $_loc2, $_loc3, $_loc4, $_loc5, $_condition1, $_condition2, $_condition3, $_condition4, $_condition5, $_scene1, $_scene2, $_scene3, $_scene4, $_scene5, $_reward1, $_reward2, $_reward3, $_reward4, $_reward5, $_exp, $_level_required, $_quest_type, $_party, $_complex1, $_complex2, $_complex3, $_complex4, $_completion_time, $_end_condition) 
	{
		$this->quest_name = $_quest_name;
		$this->info = $_info;
		$this->npc1 = $_npc1;
		$this->npc2 = $_npc2;
		$this->npc3 = $_npc3;
		$this->npc4 = $_npc4;
		$this->npc5 = $_npc5;
		$this->loc1 = $_loc1;
		$this->loc2 = $_loc2;
		$this->loc3 = $_loc3;
		$this->loc4 = $_loc4;
		$this->loc5 = $_loc5;
		$this->condition1 = $_condition1;
		$this->condition2 = $_condition2;
		$this->condition3 = $_condition3;
		$this->condition4 = $_condition4;
		$this->condition5 = $_condition5;
		$this->scene1 = $_scene1;
		$this->scene2 = $_scene2;
		$this->scene3 = $_scene3;
		$this->scene4 = $_scene4;
		$this->scene5 = $_scene5;
		$this->reward1 = $_reward1;
		$this->reward2 = $_reward2;
		$this->reward3 = $_reward3;
		$this->reward4 = $_reward4;
		$this->reward5 = $_reward5;
		$this->exp = $_exp;
		$this->level_required = $_level_required;
		$this->quest_type = $_quest_type;
		$this->party = $_party;
		$this->complex1 = $_complex1;
		$this->complex2 = $_complex2;
		$this->complex3 = $_complex3;
		$this->complex4 = $_complex4;
		$this->completion_time = $_completion_time;
		$this->end_condition = $_end_condition;
		// Insert new quest into database
		$query = "INSERT INTO quests (quest_name, info, npc1, npc2, npc3, npc4, npc5, loc1, loc2, loc3, loc4, loc5, condition1, condition2, condition3, condition4, condition5, scene1, scene2, scene3, scene4, scene5, reward1, reward2, reward3, reward4, reward5, exp, level_required, quest_type, party, complex1, complex2, complex3, complex4, completion_time, end_condition) VALUES ('$_quest_name', '$_info', '$_npc1','$_npc2','$_npc3','$_npc4','$_npc5','$_loc1','$_loc2','$_loc3','$_loc4','$_loc5','$_condition1','$_condition2','$_condition3','$_condition4','$_condition5','$_scene1','$_scene2','$_scene3','$_scene4','$_scene5','$_reward1','$_reward2','$_reward3','$_reward4','$_reward5','$_exp','$_level_required','$_quest_type', '$_party', '$_complex1','$_complex2','$_complex3','$_complex4','$_completion_time', '$_end_condition')";
		mysql_query($query);
		if (mysql_errno()) {
		  $error = "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$query\n<br>";
		  echo $error;
		} else {
			echo "Quest added successfully!";
			echo '<meta http-equiv="REFRESH" content="1;url=index.php?action=add_quest">';
		}
	}
	
	public function grabQuestData($questid)
	{
		// first retrieve the quest
		$getQuest = mysql_query("SELECT * FROM quests WHERE id = '$questid'") or die (mysql_error());
		while($row = mysql_fetch_array($getQuest))
		{
			$quest_name = $row[quest_name];
			$quest_info = $row[info];
			$npc1 = $row[npc1];
			$npc2 = $row[npc2];
			$npc3 = $row[npc3];
			$npc4 = $row[npc4];
			$npc5 = $row[npc5];
			$loc1 = $row[loc1];
			$loc2 = $row[loc2];
			$loc3 = $row[loc3];
			$loc4 = $row[loc4];
			$loc5 = $row[loc5];
			$condition1 = $row[condition1];
			$condition2 = $row[condition2];
			$condition3 = $row[condition3];
			$condition4 = $row[condition4];
			$condition5 = $row[condition5];
			$scene1 = $row[scene1];
			$scene2 = $row[scene2];
			$scene3 = $row[scene3];
			$scene4 = $row[scene4];
			$scene5 = $row[scene5];
			$reward1 = $row[reward1];
			$reward2 = $row[reward2];
			$reward3 = $row[reward3];
			$reward4 = $row[reward4];
			$reward5 = $row[reward5];
			$exp = $row[exp];
			$level_required = $row[level_required];
			$quest_type = $row[quest_type];
			$complex1 = $row[complex1];
			$complex2 = $row[complex2];
			$complex3 = $row[complex3];
			$complex4 = $row[complex4];
			$completion_time = $row[completion_time];
		}
	}
	
	public function acceptQuest($quest, $char)
	{
		$getQuest = mysql_query("SELECT * FROM quests WHERE id = '$quest'") or die (mysql_error());
		while($row = mysql_fetch_array($getQuest))
		{
			$quest_name = $row[quest_name];
			$level_required = $row[level_required];
			$quest_type = $row[quest_type];
			$party_quest = $row[party];
		}
		$grabCharacterData = mysql_query("SELECT * FROM characters WHERE id = '$char'");
		while($row = mysql_fetch_array($grabCharacterData))
		{
			include_once('character.class.php');
			$character = new Character();
			$name = $row['name'];
			$level = $row['level'];
			$money = $row['money'];
			$exp = $row['exp'];
			$age = $character->calculateCharacterAge($row['age']);
			$knowledge = $row['knowledge'];
			$strength = $row['strength'];
			$charm = $row['charm'];
			$zodiac = $row['zodiac'];
			$avatar = $row['avatar'];
			$martial = $row['martial'];
			$classid = $row['class'];
			$getClass = mysql_query("SELECT * FROM classes WHERE id = '$classid'");
			while($rowx = mysql_fetch_array($getClass))
			{
				$class = $rowx[name];
			}
			$gender = $row['gender'];
			$inventoryID = $row['inventoryID'];
			$party = $row['party'];
		}
		$grabQuestPanel = mysql_query("SELECT * FROM quest_panel WHERE charID = '$char'") or die (mysql_error());
		while($row = mysql_fetch_array($grabQuestPanel))
		{
			$activeQuest = $row[activeQuest];
			$quest2 = $row[quest2];
			$quest3 = $row[quest3];
			$quest4 = $row[quest4];
		}
		$_quest[0]=$quest2;
		$_quest[1]=$quest3;
		$_quest[2]=$quest4;
		$_quest[3]=$activeQuest;
		// quest logic for accept quest
		if(!$level >= $level_required) // is the player elgible for quest?
		{
			echo "You must be level $level_required or higher to take this quest<br>";
		}
		if($party==0)
		{
			if($party_quest!='No')
			{
				echo "You must be in a party to take on this quest<br>";
			}
		}
		if($quest_type!='Any') // is this quest for anyone?
		{
			if($class!=$quest_type) // is this quest for the player?
			{
				echo "Your must be a $quest_type to take this quest<br>";
			}
		} else {
			foreach($_quest as $anyquest)
			{
				if($anyquest==$quest) // already has quest
				{
					echo "This quest is already activated in your quest panel<br>";
					exit;
				}
			}
			if($activeQuest==0) // able to accept quest
			{
				$q = "UPDATE quest_panel SET activeQuest = '$quest' WHERE charID = '$char'";
				mysql_query($q);
				echo 'The quest, '.$quest_name.' has been added to your quest panel!<br>';
			} else {
				echo "You already have an active quest, below you can add the quest to your panel if you have a open quest slot.<br><br>";
				$x=1;
				$d=0;
				echo "<form method='post' action='questFromNPC.php?method=takeQuest&id=$quest&char=$char'>Open Quest Slots: <select name='questSlot'>";
				while($x < 4)
				{
					$x++;
					if($_quest[$d++]==0)
					{
						echo "<option value='quest$x'>Quest Slot $x</option>";
					}
				}
				echo "</select><input type='submit' value='Select Slot' name='selectSlot' /></form>";
			}
			if($_POST[selectSlot])
			{
				$q = "UPDATE quest_panel SET $_POST[questSlot] = '$quest' WHERE charID = '$char'";
				mysql_query($q);
				echo "<br>The quest, $quest_name has been added to an open quest slot<br>";
			}
		}
	}
	
	public function questConditionWindow($npc_bust, $npc_name, $condition)
	{
		echo "<script>$(document).ready(function () {
				$.fancybox({
					'width': '60%',
					'height': '42%',
					'autoScale': true,
					'transitionIn': 'fade',
					'transitionOut': 'fade',
					'type': 'iframe',
					'href': 'questCondition.php?npc_bust=$npc_bust&npc_name=$npc_name&condition=$condition'
				});
			});</script>";
	}
	
	public function questNote($message)
	{
		echo "<script>jQuery(document).ready(function() { $.fancybox('<font color=#000>".$message."',
				{
					'autoDimensions'	: false,
					'width'         	: 650,
					'height'        	: 'auto',
					'transitionIn'		: 'none',
					'transitionOut'		: 'none'
				}
			);
		});
		</script>";
	}
	
	public function doCondition($quest, $char, $location) // this method determines which sequences have been completed and which are not
	{
		$getQuest = mysql_query("SELECT * FROM quests WHERE id = '$quest'") or die (mysql_error());
		while($row = mysql_fetch_array($getQuest))
		{
			$quest_name = $row[quest_name];
			$quest_info = $row[info];
			$npc[0] = $row[npc1];
			$npc[1] = $row[npc2];
			$npc[2] = $row[npc3];
			$npc[3] = $row[npc4];
			$npc[4] = $row[npc5];
			$loc[0] = $row[loc1];
			$loc[1] = $row[loc2];
			$loc[2] = $row[loc3];
			$loc[3] = $row[loc4];
			$loc[4] = $row[loc5];
			$condition[0] = $row[condition1];
			$condition[1] = $row[condition2];
			$condition[2] = $row[condition3];
			$condition[3] = $row[condition4];
			$condition[4] = $row[condition5];
			$scene[0] = $row[scene1];
			$scene[1] = $row[scene2];
			$scene[2] = $row[scene3];
			$scene[3] = $row[scene4];
			$scene[4] = $row[scene5];
			$reward[0] = $row[reward1];
			$reward[1] = $row[reward2];
			$reward[2] = $row[reward3];
			$reward[3] = $row[reward4];
			$reward[4] = $row[reward5];
			$exp = $row[exp];
			$level_required = $row[level_required];
			$quest_type = $row[quest_type];
			$complex[0] = $row[complex1];
			$complex[1] = $row[complex2];
			$complex[2] = $row[complex3];
			$complex[3] = $row[complex4];
			$completion_time = $row[completion_time];
			$end_condition = $row[end_condition];
		}
		// checks to see if the the level of completion of a quest
			$questPanelCompletion = mysql_query("SELECT * FROM quest_panel WHERE charID = '$char'") or die (mysql_error());
			while($row = mysql_fetch_array($questPanelCompletion))
			{	
				$completion[0] = $row['completion1'];
				$completion[1] = $row['completion2'];
				$completion[2] = $row['completion3'];
				$completion[3] = $row['completion4'];
				$completion[4] = $row['completion5'];
			}
			$i=0;
		// quest logic
		$i=-1;
		$x=0;
		while($i < 5)
		{
			$i++;
			$x++;
			$grabLocation = mysql_query("SELECT * FROM locations WHERE id = '$loc[$i]'"); // get location of sequence first
			while($row = mysql_fetch_array($grabLocation))
			{
				$_loc = $row[name];
			}
			if($location==$_loc)
			{
				if($completion[$i]==0) // check to see if sequence has been completed
				{
					$getNPC = mysql_query("SELECT * FROM npc WHERE id = '$npc[$i]'");
					while($row = mysql_fetch_array($getNPC))
					{
						$_npc[name] = $row[name];
						$_npc[bust] = $row[bust];
						$_npc[avatar] = $row[avatar];
					}	
					$this->questConditionWindow($_npc[bust], $_npc[name], $condition[$i]);
					if(!$scene[$i]=='')
					{
						// do cut scene code
					}
					$completed = "completion".$x;
					mysql_query("UPDATE quest_panel SET $completed = '1' WHERE charID = '$char'");
					if($end_condition==$completed)
					{
						// Character gains rewards
						$this->rewardPlayer($quest, $char);
						// add to completed quests
						mysql_query("INSERT INTO completed_quests (quest_id, char_id) VALUES ('$quest', '$char')");
						// then set activequest to 0
						mysql_query("UPDATE quest_panel SET activeQuest = '0', completion1 = '0', completion2 = '0', completion3 = '0', completion4 = '0' WHERE charID = '$char'");
						//$this->endQuest();
					}
					exit(0);
				}
			}
		}
	}
	
	public function questHandler($activeQuest, $char, $location)
	{
		if(!$activeQuest==0) // determines if there is an active quest or not
		{
			$this->doCondition($activeQuest, $char, $location);
		} else {
			//$this->questNote("You have no active quest currently, go talk to an NPC to join a quest!");
		}
	}

	function rewardPlayer($questid, $player)
	{
		include_once("inventory.class.php");
		$inventory = new Inventory();
		include_once("character.class.php");
		$char = new Character();
		$getRewards = mysql_query("SELECT * FROM quests WHERE id = '$questid'");
		while($row=mysql_fetch_array($getRewards))
		{
			$rewards[0] = $row[reward1];
			$rewards[1] = $row[reward2];
			$rewards[2] = $row[reward3];
			$rewards[3] = $row[reward4];
			$rewards[4] = $row[reward5];
			$exp = $row[exp];
		}
		foreach($rewards as $reward)
		{
			if($reward!=0)
			{
				$inventory->add_item($reward, $player);
			}
		}
		$char->gainEXP($exp, $player);
	}
		
}
?>