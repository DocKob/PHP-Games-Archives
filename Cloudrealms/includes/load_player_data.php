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
// File: load_player_data.php                                                     /
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

if($_GET[user])
{
	$_SESSION[username] = $_GET[user];
	$_SESSION[userid] = $_GET[userid];
}
$grabUserData = mysql_query("SELECT * FROM users WHERE username = '$_SESSION[username]'");
while($row = mysql_fetch_array($grabUserData))
{
	$useravatar = $row['avatar'];
	$email = $row['email'];
	$username = $row['username'];
	$status = $row['status'];
	$charID = $row['characterID'];
	$userID = $row['id'];
}
$grabCharacterData = mysql_query("SELECT * FROM characters WHERE userID = '$_SESSION[userid]'");
while($row = mysql_fetch_array($grabCharacterData))
{
	include('classes/character.class.php');
	$character = new Character();
	$char_id = $row['id'];
	$name = $row['name'];
	$level = $row['level'];
	$money = $row['money'];
	$exp = $row['exp'];
	$maxexp = $row['max_exp'];
	$maxhp = $row['max_hp'];
	$maxmp = $row['max_mp'];
	$hp = $row['hp'];
	$mp = $row['mp'];
	$tp = $row['tp'];
	$age = $character->calculateCharacterAge($row['age']);
	$zodiac = $row['zodiac'];
	$skill_points = $row['skill_points'];
	$attack = $row['attack'];
	$defense = $row['defense'];
	$avatar = $row['avatar'];
	$martial = $row['martial'];
	$class = $row['class'];
	$grabClass = mysql_query("SELECT name FROM classes WHERE id = '$class'");
	while($n = mysql_fetch_array($grabClass))
	{
		$class = $n['name'];
	}
	$gender = $row['gender'];
	$playerRow = $row['row'];
	$playerCol = $row['col'];
	$inventoryID = $row['inventoryID'];
	$partyID = $row['party'];
	$currentBattle = $row['current_battle'];
	$target = $row['current_target'];
}
$grabQuestPanel = mysql_query("SELECT * FROM quest_panel WHERE charID = '$charID'") or die (mysql_error());
while($row = mysql_fetch_array($grabQuestPanel))
{
	$activeQuest = $row[activeQuest];
	$quest2 = $row[quest2];
	$quest3 = $row[quest3];
	$quest4 = $row[quest4];
}
?>