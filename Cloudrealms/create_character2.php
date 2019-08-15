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
// File: create_character2.php                                                    /
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

include('interface/header.php');
include('classes/character.class.php');
include('includes/connect.php');
echo '<div style="margin:30px;color:#000;">';
$user = $_GET[user];
$char_name = $_POST[name];
// Checks if the character is in use
if (!get_magic_quotes_gpc()) {
	$_POST['username'] = addslashes($_POST['username']);
}
$namecheck = $_POST['name'];
$check = mysql_query("SELECT name FROM characters WHERE name = '$namecheck'") 
or die(mysql_error());
$check2 = mysql_num_rows($check);
// If the name exists it gives an error
 if ($check2 != 0) {
	die("<div class='status error'><p><img src='".$basedir."interface/img/icons/icon_error.png' /><span>Error!</span> Sorry, the character name ".$_POST['name']." is already in use</p></div><a href='#' onClick='history.go(-1)'>try again</a>");
}

$character = new Character();
$character->process($_POST['name'],$_POST['age'],$_POST['knowledge'],$_POST['strength'],$_POST['magic'],$_POST['charm'],$_POST['zodiac'],$_POST['class'],$_POST['gender']);
// this code snippet will insert user id to the newly created character, and the character id to the user
$grabUserID = mysql_query("SELECT id FROM users WHERE username = '$user'") or die (mysql_error());
while($row = mysql_fetch_array($grabUserID))
{
	$userid = $row[id];
}
$grabCharacterID = mysql_query("SELECT id FROM characters WHERE name = '$char_name'") or die (mysql_error());
while($row = mysql_fetch_array($grabCharacterID))
{
	$charid = $row[id];
}
mysql_query("INSERT INTO quest_panel (charID) VALUES ('$charid')"); // this line ass the charid to the characters quest panel
$grabQuestID = mysql_query("SELECT id FROM quest_panel WHERE charID = '$charid'") or die (mysql_error());
while($row = mysql_fetch_array($grabQuestID))
{
	$questid = $row[id];
}
mysql_query("UPDATE characters SET userID = '$userid' WHERE name = '$char_name'"); // this line adds the userid to character
mysql_query("UPDATE users SET characterID = '$charid' WHERE username = '$user'"); // this line adds the charid to the user
mysql_query("UPDATE characters SET questPanel = '$questid' WHERE name = '$char_name'"); // this line adds the quest panel id to the character
mysql_query("UPDATE characters SET hp = '100', mp = '100', current_battle = '0' WHERE name = '$char_name'"); // sets the character hp, and mp, this will be improved in a function in the near future
// now it is stime to create the characters home
mysql_query("INSERT INTO homes (charID, setup) VALUES ('$charid', '0')");
$grabHomeID = mysql_query("SELECT id FROM homes WHERE charID = '$charid'");
while($row = mysql_fetch_array($grabHomeID))
{
	$homeid = $row[id];
}
mysql_query("UPDATE characters SET home = '$homeid' WHERE name = '$char_name'");
?>  
<h2>Create your character (part 2)</h2><br />
<form name="create_character2" method="post" action="do/create_character.php?char_name=<? echo $char_name; ?>">
<div class="contentcontainer sml left" style="width:420px;" id="tabs">
	<div class="headings">
		<h2 class="left">Avatar Builder v1.0</h2>
		<ul class="smltabs">
			<li><a href="#tabs-1">Style 1</a></li>
			<li><a href="#tabs-2">Style 2</a></li>
		</ul>
	</div>
		<div class="contentbox" id="tabs-1">
			<? if($_POST[gender] == "Male"){ ?>
			<table><tr>
			<td><img src="source/avatars/male_style1_seq1.png" width="150px" height="150px"><br><input type="radio" name="avatar" value="source/avatars/male_style1_seq1.png"></td>
			</tr></table>
			<? } else { ?>
			<table><tr>
			<td><img src="source/avatars/female_style1_seq1.png" width="150px" height="150px"><br><input type="radio" name="avatar" value="source/avatars/female_style1_seq1.png"></td>
			</tr></table>
			<? } ?>
		</div>
		<div class="contentbox" id="tabs-2">
			<? if($_POST[gender] == "Male"){ ?>
			male styles
			<? } else { ?>
			female styles
			<? } ?>
		</div>
	</div>
<div style="clear:both;"></div>
<input type="submit" value="Create Character!" class="btn" name="create_character2" />
</form>
</div>