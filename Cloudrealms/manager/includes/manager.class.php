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
// File: manager.class.php                                                        /
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

class manager
{

	function load_ui()
	{
	
	}
	
	function console()
	{
		echo "<div style='margin:30px;'>";
		echo "<h1>Welcome to the manager, ".$_SESSION[username]."</h1>";
		echo "<a href='index.php?action=home'>Home</a> | ";
		echo "<a href='index.php?action=game_config'>Game Config</a> | ";
		echo "<a href='index.php?action=add_item'>Add new item</a> | ";
		echo "<a href='index.php?action=add_quest'>Add new quest</a> | ";
		echo "<a href='index.php?action=add_npc'>Add new NPC</a> | ";
		echo "<a href='index.php?action=add_enemy'>Add new Enemy</a> | ";
		echo "<a href='index.php?action=add_enemy_type'>Add new Enemy Type</a> | ";
		echo "<a href='index.php?action=add_obj'>Add new Object</a> | ";
		echo "<a href='index.php?action=map_editor'>Map Editor</a> | ";
		echo "<a href='index.php?action=add_loc'>Add new Location</a> | ";
		echo "<a href='index.php?action=add_class'>Add new Class</a> | ";
		echo "<a href='index.php?action=sounds'>Sounds Manager</a> | ";
		echo "<a href='index.php?action=add_skill'>Add New Skill Set</a> | ";
		echo "<a href='../do/logout.php'>Logout</a><br><br>";
	}
	
	function add_skill()
	{
		echo "<b>Add Skills Set</b>";
		echo "<p>Here you will be able to add new skill sets available to players</p>";
		echo "<form method='post' action='index.php?action=add_skill'><ul>";
		echo "<li>Skill Set Name: <input type='text' name='name'>";
		echo "<li>Skill Set Description: <br><textarea name='desc' style='width:350px;height:90px;'></textarea>";
		echo "<li>Skill Set Abbreviation: <input type='text' maxlength='3' name='abbreviation'>";
		echo "<li><input type='submit' name='add_skill' value='Add New Skill'></ul>";
		if($_POST[add_skill])
		{
			$q = "INSERT INTO skill_sets (name, description, abbreviation) VALUES ('$_POST[name]', '$_POST[desc]', '$_POST[abbreviation]')";
			mysql_query($q) or die (mysql_error());
			echo "Skill Set added successfully!";
			echo '<meta http-equiv="REFRESH" content="1;url=index.php?action=add_skill">';
		}
	}
	
	function sounds_manager()
	{
		echo "<b>Sounds Manager</b>";
		echo "<p>Here you will be able to upload sounds to your game, then add background music to your locations and battle events, and even to your login screen</p>";
		echo "<form>";
		echo "<input id='file_upload' name='file_upload' type='file' />";    
		echo "</form>";
	}
	
	function map_editor($canvas_width, $canvas_height, $tile_width, $tile_height, $fullscreen)
	{
		echo "<table><tr><td valign=top width=340><form method='post' action='$_SERVER[REQUEST_URI]'>";
		echo "Set game canvas width: <input type='text' name='width' value='$canvas_width' /><br>";
		echo "Set game canvas height: <input type='text' name='height' value='$canvas_height' /><br>";
		echo "<input type='submit' name='set_canvas' value='Update Canvas'>";
		echo "</form></td><td valign=top>";
		if($fullscreen==1){
			echo "<li>Fullscreen mode is ON</li>";
		}
		echo "<form method='post' action='$_SERVER[REQUEST_URI]' onSubmit='return dropdown(this.location_selector)'>";
		echo "<select name='location_selector'><option value='none'>Select a location to edit</option>";
		$selectLocations=mysql_query("SELECT * FROM locations");
		while($row=mysql_fetch_array($selectLocations))
		{
			echo "<option value='index.php?action=map_editor&loc=$row[name]'>$row[name]</option>";
		}
		echo "</select> <input type='submit' name='location' value='Go!'></td></tr></table>";
		echo "<div id='map_editor'> </div>";
		echo "<br><br>";
		if($_POST[set_canvas])
		{
			$q = "UPDATE game SET canvas_width = '$_POST[width]', canvas_height = '$_POST[height]' WHERE id = '1'";
			mysql_query($q);
			if (mysql_errno()) {
			  $error = "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$query\n<br>";
			  echo $error;
			} else {
				echo "Map successfully updated!";
				echo '<meta http-equiv="REFRESH" content="1;url='.$_SERVER[REQUEST_URI].'">';
			}
		}
	}
	
	function add_enemy_type()
	{
		echo "<b>Add New Enemy Type</b><ul>";
		echo "<form enctype='multipart/form-data' method='post' action='index.php?action=add_enemy_type'>";
		echo "<li>Name: <input type='text' name='name'></li>";
		echo "<li>Class: <select name='class'>";
		$getEnemyClasses = mysql_query("SELECT * FROM classes WHERE enemy = '1'");
		while($row=mysql_fetch_array($getEnemyClasses))
		{
			echo "<option>$row[name]</option>";
		}
		echo "</select></li>";
		echo "<li>Species: <input type='text' name='species'></li>";
		echo "<li>Description: <input type='text' name='desc'></li>";
		echo "<li>Emblem: <input type='file' name='emblem'></li>";
		echo "<li><input type='submit' name='add_enemy_type' value='Add New Enemy Type'></li>";
		echo "</ul></form>";
		// do code
			if($_POST[add_enemy_type])
			{
				$target = "../source/emblems/"; 
				$target = $target . basename( $_FILES['emblem']['name']);
				$emblem = "source/emblems/". basename( $_FILES['emblem']['name']);
				if(move_uploaded_file($_FILES['emblem']['tmp_name'], $target)) 
					{ 
						// SUCCESSFUL AVATAR UPLOAD!
					} else { 
						//echo "Failed image upload";
				}
				mysql_query("INSERT INTO enemy_types (name, eclass, species, edesc, emblem) VALUES ('$_POST[name]', '$_POST[class]', '$_POST[species]', '$_POST[desc]', '$emblem')") or die(mysql_error());
				echo '<meta http-equiv="REFRESH" content="1;url=index.php?action=add_enemy_type">';
			}
	}
	
	function add_enemy()
	{
		echo "<b>Add New Enemy</b><ul>";
		echo "<form enctype='multipart/form-data' method='post' action='index.php?action=add_enemy'>";
		echo "<li>Enemy Name: <input type='text' name='enemy_name'></li>";
		echo "<li>Enemy Bust: <input type='file' name='enemy_bust'></li>";
		echo "<li>Enemy Avatar: <input type='file' name='enemy_avatar'></li>";
		echo "<li>Enemy Combat Avatar: <input type='file' name='combat_avatar'></li>";
		echo "<li>Enemy Attack: <input type='text' name='enemy_attack'></li>";
		echo "<li>Enemy Defense: <input type='text' name='enemy_defense'></li>";
		$getEnemyTypes = mysql_query("SELECT * FROM enemy_types") or die (mysql_error());
		echo "<li>Enemy Types: <select name='enemy_type'>";
		while($row = mysql_fetch_array($getEnemyTypes))
		{
			echo "<option value='$row[id]'>$row[name]</option>";
		}
		echo "</select></li>";
		echo "<li>Enemy Greeting 1: <br><textarea name='enemy_greeting1'></textarea></li>";
		echo "<li>Enemy Greeting 2: <br><textarea name='enemy_greeting2'></textarea></li>";
		// LOCATIONS
		$grabLocation = mysql_query("SELECT * FROM locations") or die (mysql_error());
		echo "<li>Location: <select name='location'><option vale='0'>none</option>";
		while($row = mysql_fetch_array($grabLocation))
		{
			echo "<option value='$row[id]'>$row[name]</option>";
		}
		echo "</select>";
		echo "<li><input type='submit' name='add_enemy' value='Add New Enemy'></li>";
		echo "</ul></form>";
		// do code
			if($_POST[add_enemy])
			{
				$target = "../source/avatars/enemy/"; 
				$target = $target . basename( $_FILES['enemy_avatar']['name']);
				$enemy_avatar = "source/avatars/enemy/". basename( $_FILES['enemy_avatar']['name']);
				if(move_uploaded_file($_FILES['enemy_avatar']['tmp_name'], $target)) 
					{ 
						// SUCCESSFUL AVATAR UPLOAD!
					} else { 
						//echo "Failed image upload";
				}
				$target = "../source/busts/"; 
				$target = $target . basename( $_FILES['enemy_bust']['name']);
				$enemy_bust = "source/busts/". basename( $_FILES['enemy_bust']['name']);
				if(move_uploaded_file($_FILES['enemy_bust']['tmp_name'], $target)) 
					{ 
						// SUCCESSFUL AVATAR UPLOAD!
					} else { 
						//echo "Failed image upload";
				}
				$target = "../source/avatars/combat/"; 
				$target = $target . basename( $_FILES['combat_avatar']['name']);
				$combat_avatar = "source/avatars/combat/". basename( $_FILES['combat_avatar']['name']);
				if(move_uploaded_file($_FILES['combat_avatar']['tmp_name'], $target)) 
					{ 
						// SUCCESSFUL AVATAR UPLOAD!
					} else { 
						//echo "Failed image upload";
				}
				mysql_query("INSERT INTO enemy (name, bust, avatar, combat_avatar, attack, defense, type, greeting1, greeting2, location) VALUES ('$_POST[enemy_name]', '$enemy_bust', '$enemy_avatar', '$combat_avatar', '$_POST[enemy_attack]', '$_POST[enemy_defense]', '$_POST[enemy_type]', '$_POST[enemy_greeting1]', '$_POST[enemy_greeting2]', '$_POST[location]')") or die(mysql_error());
				echo '<meta http-equiv="REFRESH" content="1;url=index.php?action=add_enemy">';
			}
		}
	
	
	function add_class()
	{
		echo "<b>Add a new Class</b><ul>";
		echo "<form method='post' action='index.php?action=add_class'>";
		echo "<li>Class Name: <input type='text' name='class_name'></li> ";
		echo "<li>Class Description: <br><textarea name='class_desc' style='width:350px;height:90px;'></textarea></li>";
		echo "<li>Is this an enemy class only? <input type='checkbox' name='enemy' value='1'></li><br>";
		echo "<li><input type='submit' name='add_class' value='Add New Class'></li>";
		echo "</ul></form>";
		if($_POST[add_class])
		{
			$q = "INSERT INTO classes (name, class_desc, enemy) VALUES ('$_POST[class_name]', '$_POST[class_desc]', '$_POST[enemy]')";
			mysql_query($q) or die (mysql_error());
			echo "Class added successfully!";
			echo '<meta http-equiv="REFRESH" content="1;url=index.php?action=add_class">';
		}
	}
	
	function add_quest()
	{
		echo "<b>Add a new Quest</b><ul>";
		echo "<form enctype='multipart/form-data' method='post' action='index.php?action=add_quest'>";
		echo "<li>Quest Name: <input type='text' name='quest_name'></li>";
		echo "<li>Quest Description: <br><textarea name='info' style='width:350px;height:90px;'></textarea></li>";
		// NPC's
		$i=0;
		while($i < 5)
		{
			$i++;
			$grabNPC = mysql_query("SELECT * FROM npc") or die (mysql_error());
			echo "<li>NPC $i: <select name='npc$i'><option vale='0'>none</option>";
			while($row = mysql_fetch_array($grabNPC))
			{
				echo "<option value='$row[id]'>$row[name]</option>";
			}
			echo "</select>";
		}
		// LOCATIONS
		$l=0;
		while($l < 5)
		{
			$l++;
			$grabLocation = mysql_query("SELECT * FROM locations") or die (mysql_error());
			echo "<li>Location $l: <select name='loc$l'><option vale='0'>none</option>";
			while($row = mysql_fetch_array($grabLocation))
			{
				echo "<option value='$row[id]'>$row[name]</option>";
			}
			echo "</select>";
		}
		// CONDITIONS
		$c=0;
		while($c < 5)
		{
			$c++;
			echo "<li>Condition $c: <br><textarea name='condition$c' style='width:350px;height:90px;'></textarea></li>";
		}
		// SCENES
		$s=0;
		while($s < 5)
		{
			$s++;
			echo "<li>Cut Scene Animation $s: <input type='file' name='scene$s' /></li>";
		}
		// REWARDS
		$r=0;
		while($r < 5)
		{
			$r++;
			$grabItem = mysql_query("SELECT * FROM items") or die (mysql_error());
			echo "<li>Reward $r: <select name='item$r'><option vale='0'>none</option>";
			while($row = mysql_fetch_array($grabItem))
			{
				echo "<option value='$row[id]'>$row[name]</option>";
			}
			echo "</select>";
		}
		// EXP GAIN
		echo "<li>EXP Gain: <input type='text' name='exp' /></li>";
		// LEVEL REQUIRED
		$z=0;
		echo "<li>Level Required: <select name='level'>";
		while($z < 150)
		{
			$z++;
			echo "<option>$z</option>";
		}
		echo "</select></li>";
		// QUEST TYPE
		echo "<li>Quest Type: 
		<select name='qtype'>
			<option>Any</option>";
			$grabClass = mysql_query("SELECT * FROM classes");
			while($n = mysql_fetch_array($grabClass))
			{
				echo "<option>$n[name]</option>";
			}
		echo "</select></li>";
		echo "<li>Is this a party only quest? <select name='party'><option>Yes</option><option>No</option></select></li>";
		// COMPLEX CONDITIONS
		$c=0;
		while($c < 5)
		{
			$c++;
			echo "<li>Complex Condition $c: <br><textarea name='complex$c' style='width:350px;height:90px;'></textarea></li>";
		}
		// COMPLETION TIME
		$z=0;
		echo "<li>Completion Time: <select name='qtime'>";
		while($z < 48)
		{
			$z++;
			echo "<option value='$z'>$z Hours</option>";
		}
		echo "</select></li>";
		// END
		echo "<li>Ending Condition: <select name='end_condition'><option>completion1</option><option>completion2</option><option>completion3</option><option>completion4</option><option>completion5</option></select>";
		echo "<li><input type='submit' name='add_quest' value='Add New Quest'></li>";
		echo "</ul></form>";
		// do code
		if($_POST[add_quest]){
			$x=0;
			while($x < 5)
			{
				$x++;
				$target = "../source/scenes/"; 
				$target = $target . basename( $_FILES['scene'.$x.'']['name']);
				$game_logo = "source/scenes/". basename( $_FILES['scene'.$x.'']['name']);
				if(move_uploaded_file($_FILES['scene'.$x.'']['tmp_name'], $target)) 
				{ 
					// SUCCESSFUL LOGO UPLOAD!
				} else {}
			}
			include_once('../classes/quest.class.php');
			$quest = new Quest();
			$quest->newQuest($_POST[quest_name], $_POST[info], $_POST[npc1], $_POST[npc2], $_POST[npc3], $_POST[npc4], $_POST[npc5], $_POST[loc1], $_POST[loc2], $_POST[loc3], $_POST[loc4], $_POST[loc5], $_POST[condition1], $_POST[condition2], $_POST[condition3], $_POST[condition4], $_POST[condition5], $_POST[scene1], $_POST[scene2], $_POST[scene3], $_POST[scene4], $_POST[scene5], $_POST[reward1], $_POST[reward2], $_POST[reward3], $_POST[reward4], $_POST[reward5], $_POST[exp], $_POST[level], $_POST[qtype], $_POST[party], $_POST[complex1], $_POST[complex2], $_POST[complex3], $_POST[complex4], $_POST[qtime], $_POST[end_condition]);
		}
	}
	
	function game_config($name, $expansion, $description, $logo, $domain, $canvas_width, $canvas_height, $tile_width, $tile_height, $fullscreen, $mp3_theme, $ogg_theme, $avatar_height)
	{
		echo "<b>Game Configuration</b><ul>";
		echo "<form enctype='multipart/form-data' method='post' action='index.php?action=game_config'>";
		echo "<li>Game Name: <input type='text' name='game_name' value='$name'></li>";
		echo "<li>Game Expansion: <input type='text' name='game_expansion' value='$expansion'></li>";
		echo "<li>Game Description: <br><textarea name='game_description'>$description</textarea></li>";
		echo "<li><img src='../$logo'></li>";
		echo "<li>Change Game Logo: <input type='file' name='game_logo'></li>";
		echo "<li>Game Domain: <input type='text' name='game_domain' value='$domain'></li>";
		echo "<li>Avatar Height: <input type='text' name='avatar_height' value='$avatar_height'></li>";
		echo "<li>Game Canvas Width: <input type='text' name='canvas_width' value='$canvas_width'></li>";
		echo "<li>Game Canvas Height: <input type='text' name='canvas_height' value='$canvas_height'></li>";
		echo "<li>Tiles Width: <input type='text' name='tile_width' value='$tile_width'></li>";
		echo "<li>Tiles Height: <input type='text' name='tile_height' value='$tile_height'></li>";
		echo "Select Game Theme MP3: <select name='mp3Theme'>";
		echo "<option value='$mp3_theme'>- Select Audio -";
		$dirPath = dir('../source/sounds');
		$mp3Array = array();
		while (($file = $dirPath->read()) !== false)
		{
		  if ((substr($file, -3)=="mp3"))
		  {
			 $mp3Array[ ] = trim($file);
		  }
		}
		$dirPath->close();
		sort($mp3Array);
		$c = count($mp3Array);
		for($i=0; $i<$c; $i++)
		{
			echo "<option value=\"source/sounds/" . $mp3Array[$i] . "\">" . $mp3Array[$i] . "\n";
		}
		echo "</select><br>";
		echo "Select Game Theme OGG: <select name='oggTheme'>";
		echo "<option value='$ogg_theme'>- Select Audio -";
		$dirPath = dir('../source/sounds');
		$oggArray = array();
		while (($file = $dirPath->read()) !== false)
		{
		  if ((substr($file, -3)=="ogg"))
		  {
			 $oggArray[ ] = trim($file);
		  }
		}
		$dirPath->close();
		sort($oggArray);
		$c = count($mp3Array);
		for($i=0; $i<$c; $i++)
		{
			echo "<option value=\"source/sounds/" . $oggArray[$i] . "\">" . $oggArray[$i] . "\n";
		}
		echo "</select><br>";
		echo "<li>Full Screen: <input type='checkbox' name='fullscreen' value='1'>";
		if($fullscreen==1)
		{
			echo " Full screen mode is ON";
		} else {
			echo " Full screen mode is OFF</li>";
		}
		echo "<li><input type='submit' name='game_config' value='Update Game!'></li>";
		echo "</ul></form>";
		// do code
		if($_POST[game_config]){
			if(!$_FILES[game_logo]=="")
			{
				// image upload process
				$target = "../interface/img/"; 
				$target = $target . basename( $_FILES['game_logo']['name']);
				$game_logo = "interface/img/". basename( $_FILES['game_logo']['name']);
				if(move_uploaded_file($_FILES['game_logo']['tmp_name'], $target)) 
					{ 
						// SUCCESSFUL LOGO UPLOAD!
					} else { 
						$game_logo = $logo;
				}
			} else {
				$game_logo = $logo;
			}
			// add item data to database now
			$step1 = mysql_query("SELECT * FROM game");
			while($row = mysql_fetch_array($step1))
			{
				$step2 = $row['id'];
			}
			if($step2=='')
			{
				$q = "INSERT INTO game (name, expansion, description, logo, domain, canvas_width, canvas_height, tile_width, tile_height, fullscreen, mp3_theme, ogg_theme, avatar_height) VALUES ('$_POST[game_name]', '$_POST[game_expansion]', '$_POST[game_description]', '$game_logo', '$_POST[game_domain]', '$_POST[canvas_width]', '$_POST[canvas_height]', '$_POST[tile_width]', '$_POST[tile_height]', '$_POST[fullscreen]', '$_POST[mp3Theme]', '$_POST[oggTheme]', '$_POST[avatar_height]')";
				mysql_query($q);
				if (mysql_errno()) {
				  $error = "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$query\n<br>";
				  echo $error;
				} else {
					echo "Game successfully updated!";
					echo '<meta http-equiv="REFRESH" content="1;url=index.php?action=game_config">';
				}
			} else {
				$q = "UPDATE game SET name = '$_POST[game_name]', expansion = '$_POST[game_expansion]', description = '$_POST[game_description]', logo = '$game_logo', domain = '$_POST[game_domain]', canvas_width = '$_POST[canvas_width]', canvas_height = '$_POST[canvas_height]' , tile_width = '$_POST[tile_width]', tile_height = '$_POST[tile_height]', fullscreen = '$_POST[fullscreen]', mp3_theme = '$_POST[mp3Theme]', ogg_theme = '$_POST[oggTheme]', avatar_height = '$_POST[avatar_height]' WHERE id = '1'";
				mysql_query($q);
				if (mysql_errno()) {
				  $error = "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$query\n<br>";
				  echo $error;
				} else {
					echo "Game successfully updated!";
					echo '<meta http-equiv="REFRESH" content="1;url=index.php?action=game_config">';
				}
			}
		}
	}
	
	function add_item()
	{
		echo "<b>Add New Item</b><ul>";
		echo "<form enctype='multipart/form-data' method='post' action='index.php?action=add_item'>";
		echo "<li>Item Name: <input type='text' name='item_name'></li>";
		echo "<li>Item Description: <br><textarea name='item_description'></textarea></li>";
		echo "<li>Item Value: <input type='text' name='item_value'></li>";
		echo "<li>HP: <input type='text' name='item_hp'></li>";
		echo "<li>TP: <input type='text' name='item_tp'></li>";
		echo "<li>MP: <input type='text' name='item_mp'></li>";
		echo "<li>EXP: <input type='text' name='item_exp'></li>";
		echo "<li>Item Category: <select name='item_cat'><option>food</option><option>outfits</option></select></li>";
		echo "<li>Item Image: <input type='file' name='item_img'></li>";
		echo "<li><input type='submit' name='add_item' value='Add New Item'></li>";
		echo "</ul></form>";
		// do code
		if($_POST[add_item]){
			// item image upload process
			$target = "../source/items/".$_POST[item_cat]."/"; 
			$target = $target . basename( $_FILES['item_img']['name']);
			$item_img = "source/items/".$_POST[item_cat]."/". basename( $_FILES['item_img']['name']);
			if(move_uploaded_file($_FILES['item_img']['tmp_name'], $target)) 
				{ 
					// SUCCESSFUL AVATAR UPLOAD!
				} else { 
					echo "Failed image upload";
			}
			// add item data to database now
			mysql_query("INSERT INTO items (name, description, img, value, mp, hp, tp, exp) VALUES ('".$_POST[item_name]."', '".$_POST[item_description]."', '".$item_img."', '".$_POST[item_value]."', '".$_POST[item_mp]."', '".$_POST[item_hp]."', '".$_POST[item_tp]."', '".$_POST[item_exp]."')");
			echo "Item added successfully!";
			echo '<meta http-equiv="REFRESH" content="1;url=index.php?action=add_item">';
		}
	}
	
	function add_npc()
	{
	echo "<b>Add New NPC</b><ul>";
	echo "<form enctype='multipart/form-data' method='post' action='index.php?action=add_npc'>";
	echo "<li>NPC Name: <input type='text' name='npc_name'></li>";
	echo "<li>NPC Bust: <input type='file' name='npc_bust'></li>";
	echo "<li>NPC Avatar: <input type='file' name='npc_avatar'></li>";
	echo "<li>NPC Age: <input type='text' name='npc_age'></li>";
	echo "<li>NPC Greeting 1: <br><textarea name='npc_greeting1'></textarea></li>";
	echo "<li>NPC Greeting 2: <br><textarea name='npc_greeting2'></textarea></li>";
	echo "<li>NPC Greeting 3: <br><textarea name='npc_greeting3'></textarea></li>";
	// LOCATIONS
	$grabLocation = mysql_query("SELECT * FROM locations") or die (mysql_error());
	echo "<li>Location: <select name='location'><option vale='0'>none</option>";
	while($row = mysql_fetch_array($grabLocation))
	{
		echo "<option value='$row[id]'>$row[name]</option>";
	}
	echo "</select>";
	echo "<li><input type='submit' name='add_npc' value='Add New NPC'></li>";
	echo "</ul></form>";
	// do code
		if($_POST[add_npc])
		{
			$target = "../source/avatars/npc/"; 
			$target = $target . basename( $_FILES['npc_avatar']['name']);
			$npc_avatar = "source/avatars/npc/". basename( $_FILES['npc_avatar']['name']);
			if(move_uploaded_file($_FILES['npc_avatar']['tmp_name'], $target)) 
				{ 
					// SUCCESSFUL AVATAR UPLOAD!
				} else { 
					echo "Failed image upload";
			}
			$target = "../source/busts/"; 
			$target = $target . basename( $_FILES['npc_bust']['name']);
			$npc_bust = "source/busts/". basename( $_FILES['npc_bust']['name']);
			if(move_uploaded_file($_FILES['npc_bust']['tmp_name'], $target)) 
				{ 
					// SUCCESSFUL AVATAR UPLOAD!
				} else { 
					echo "Failed image upload";
			}
			include_once('../classes/npc.class.php');
			$npc = new NPC();
			$npc->newNPC($_POST[npc_name],$npc_bust,$npc_avatar,$_POST[npc_age],$_POST[npc_greeting1], $_POST[npc_greeting2], $_POST[npc_greeting3], $_POST[location]);
			echo '<meta http-equiv="REFRESH" content="1;url=index.php?action=add_npc">';
		}
	}
	
	function add_obj()
	{
	echo "<b>Add New Object</b><ul>";
	echo "<form enctype='multipart/form-data' method='post' action='index.php?action=add_obj'>";
	echo "<li>Object Name: <input type='text' name='obj_name'></li>";
	echo "<li>Object Image: <input type='file' name='obj_img'></li>";
	// LOCATIONS
	$grabLocation = mysql_query("SELECT * FROM locations") or die (mysql_error());
	echo "<li>Object Location: <select name='location'><option vale='0'>none</option>";
	while($row = mysql_fetch_array($grabLocation))
	{
		echo "<option value='$row[id]'>$row[name]</option>";
	}
	echo "</select>";
	echo "<li><input type='submit' name='add_obj' value='Add New Object'></li>";
	echo "</ul></form>";
	// do code
		if($_POST[add_obj])
		{
			$target = "../source/objects/"; 
			$target = $target . basename( $_FILES['obj_img']['name']);
			$obj_img = "source/objects/". basename( $_FILES['obj_img']['name']);
			if(move_uploaded_file($_FILES['obj_img']['tmp_name'], $target)) 
				{ 
					// SUCCESSFUL AVATAR UPLOAD!
				} else { 
					echo "Failed image upload";
			}
			mysql_query("INSERT INTO objects (name, image, location) VALUES ('$_POST[obj_name]', '$obj_img', '$_POST[location]')");
			if (mysql_errno()) {
			  $error = "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$query\n<br>";
			  echo $error;
			} else {
				echo "Object added successfully!";
				echo '<meta http-equiv="REFRESH" content="1;url=index.php?action=add_obj">';
			}
		}
	}
	
	function add_loc()
	{
		echo "<b>Add New Location</b><ul>";
		echo "<form enctype='multipart/form-data' method='post' action='index.php?action=add_loc'>";
		echo "<li>Location Name: <input type='text' name='loc_name'></li>";
		echo "<li>Location Display Name: <input type='text' name='display_name'></li>";
		echo "Select Location Theme MP3: <select name='mp3Theme'>";
		echo "<option value='$mp3_theme'>- Select Audio -";
		$dirPath = dir('../source/sounds');
		$mp3Array = array();
		while (($file = $dirPath->read()) !== false)
		{
		  if ((substr($file, -3)=="mp3"))
		  {
			 $mp3Array[ ] = trim($file);
		  }
		}
		$dirPath->close();
		sort($mp3Array);
		$c = count($mp3Array);
		for($i=0; $i<$c; $i++)
		{
			echo "<option value=\"source/sounds/" . $mp3Array[$i] . "\">" . $mp3Array[$i] . "\n";
		}
		echo "</select><br>";
		echo "Select Location Theme OGG: <select name='oggTheme'>";
		echo "<option value='$ogg_theme'>- Select Audio -";
		$dirPath = dir('../source/sounds');
		$oggArray = array();
		while (($file = $dirPath->read()) !== false)
		{
		  if ((substr($file, -3)=="ogg"))
		  {
			 $oggArray[ ] = trim($file);
		  }
		}
		$dirPath->close();
		sort($oggArray);
		$c = count($mp3Array);
		for($i=0; $i<$c; $i++)
		{
			echo "<option value=\"source/sounds/" . $oggArray[$i] . "\">" . $oggArray[$i] . "\n";
		}
		echo "</select><br>";
		echo "Select Location Battle Theme MP3: <select name='mp3BattleTheme'>";
		echo "<option value=''>- Select Audio -";
		$dirPath = dir('../source/sounds');
		$mp3Array = array();
		while (($file = $dirPath->read()) !== false)
		{
		  if ((substr($file, -3)=="mp3"))
		  {
			 $mp3Array[ ] = trim($file);
		  }
		}
		$dirPath->close();
		sort($mp3Array);
		$c = count($mp3Array);
		for($i=0; $i<$c; $i++)
		{
			echo "<option value=\"source/sounds/" . $mp3Array[$i] . "\">" . $mp3Array[$i] . "\n";
		}
		echo "</select><br>";
		echo "Select Location Battle Theme OGG: <select name='oggBattleTheme'>";
		echo "<option value=''>- Select Audio -";
		$dirPath = dir('../source/sounds');
		$oggArray = array();
		while (($file = $dirPath->read()) !== false)
		{
		  if ((substr($file, -3)=="ogg"))
		  {
			 $oggArray[ ] = trim($file);
		  }
		}
		$dirPath->close();
		sort($oggArray);
		$c = count($mp3Array);
		for($i=0; $i<$c; $i++)
		{
			echo "<option value=\"source/sounds/" . $oggArray[$i] . "\">" . $oggArray[$i] . "\n";
		}
		echo "</select><br>";
		echo '<li>Default Tile Color: <input type="text" maxlength="6" size="6" id="colorpickerField1" name="tile_color" value="66CD00" /></li>';
		echo "<li>Locations Background: (upload) <input type='file' name='bg' /> or select from backgrounds ";
		?>
		<table><td><td>
		<?
		if ($handle = opendir('../source/backgrounds')) {
			echo "<select name='from_source' onChange='previewPic(this)'>";
			while (false !== ($file = readdir($handle))) {
				echo "<option value='source/backgrounds/$file'>$file</option>";
				$first_file=$file;
			}
			echo "</select>";
			closedir($handle);
		} ?>
		</td><td>
		<img name="previewpic" src="../source/backgrounds/<? echo $first_file; ?>" border=1 width=512 height=205>
		</tr></tr></table>
		<?
		echo "<li><input type='submit' name='add_loc' value='Add New Location'></li>";
		echo "</ul></form>";
		// do code
		if($_POST[add_loc]){
			$target = "../source/backgrounds/"; 
			$target = $target . basename( $_FILES['bg']['name']);
			if(move_uploaded_file($_FILES['bg']['tmp_name'], $target)) 
			{ 
				//SUCCESSFUL
			} else { 
				//FAIL			
			}
			if($_POST[bg]==""){
				$bg=$_POST[from_source];
			} else {
				$bg="source/backgrounds/".$_FILES[bg][name];
			}
			mysql_query("INSERT INTO locations (name, display_name, default_tile_color, background, mp3, ogg, battle_mp3, battle_ogg) VALUES ('$_POST[loc_name]', '$_POST[display_name]', '$_POST[tile_color]', '$bg', '$_POST[mp3Theme]', '$_POST[oggTheme]', '$_POST[mp3BattleTheme]', '$_POST[oggBattleTheme]')");
			if (mysql_errno()) {
			  $error = "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$query\n<br>";
			  echo $error;
			} else {
				echo "Location added successfully!";
				echo '<meta http-equiv="REFRESH" content="1;url=index.php?action=add_loc">';
			}
		}
	}
}
?>