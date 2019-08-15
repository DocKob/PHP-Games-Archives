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
// File: character.class.php                                                      /
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

class Character {
	var $id;
	var $name; // user input
	var $level;
	var $money;
	var $exp;
	var $age; // user input
	var $knowledge; // user input
	var $strength; 
	var $magic;
	var $charm; 
	var $zodiac; // user input
	var $avatar; // user input
	var $martial;
	var $class; // user input
	var $gender; // user input
	var $inventoryID;
	var $userID;
	var $questPanel;
	
	public function process($_name, $_age, $_knowledge, $_strength, $_magic, $_charm, $_zodiac, $_class, $_gender) { 
		$this->name = $_name;
		$this->age = $_age;
		$this->knowledge = $_knowledge;
		$this->strength = $_strength;
		$this->magic = $_magic;
		$this->charm = $_charm;
		$this->zodiac = $_zodiac;
		$this->class = $_class;
		$this->gender = $_gender;
		//Insert character data to database
		$query = "INSERT INTO characters (name, age, knowledge, strength, magic, charm, zodiac, class, gender) VALUES ('".$this->name."', '".$this->age."', '".$this->knowledge."', '".$this->strength."', '".$this->magic."', '".$this->charm."', '".$this->zodiac."', '".$this->class."', '".$this->gender."')";
		mysql_query($query);
		if (mysql_errno()) {
		  $error = "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$query\n<br>";
		  echo $error;
		} 
		// add default data to database
		$query = "UPDATE characters SET level = '1', money = '100', exp = '0', martial = 'Single' WHERE name = '$_name'";
		mysql_query($query);
		if (mysql_errno()) {
		  $error = "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$query\n<br>";
		  echo $error;
		} 
	}
	
	function characterBuilder($step)
	{
		include_once("mmorpg.class.php");
		$mmorpg = new MMORPG();
		if($step=="user_info"){
			echo "<span class='title'>Username:</span>"; ?> <input type='text' id='input' name='username' value='Enter a Username...' onclick="this.value='';" /><?
			echo "<br>
					<span class='title'>Password:</span> <input type='password' id='input' name='password' /><br>
					<span class='title'>Confirm Password:</span> <input type='password' id='input' name='password2' /><br>
					<span class='title'>Email:</span>"; ?> <input type='text' name='email' id='input' value='Enter your Email...' onclick="this.value=''" /><br><?
				echo "<span class='title'>Avatar:</span> <input type='file' id='file' name='avatar' />";
		} else if($step=="character_skills"){
			echo "<p><b>Skill Points Available: </b><input type='textbox' id='char_skills' name='skill_points' value='20' size='3'></p>";
			$skills = $mmorpg->getSkills();
            for($i=0; $i < count($skills[name]); $i++)
            {
                echo "<span class='title2'>".$skills[name][$i].": <input name='".$skills[abbreviation][$i]."'  id='".$skills[abbreviation][$i]."' size='3' value='";
                if($skills[id][$i]==$char_skills[skill][$i]){
                    echo $char_skills[points][$i];
                } else {
                    echo '0';
                }
                echo "'>"; ?> <button onclick="addPoint('<? echo $skills[abbreviation][$i]; ?>');return false">+</button> / <button onclick="subtractPoint('<? echo $skills[abbreviation][$i]; ?>');return false">-</button></span><?
            }
		} else if($step=="character_basics"){
			echo "<span class='title'>Age: (YYYY-MM-DD):</span> <input type='text' id='input' name='age' /><br>
				   <span class='title'>Zodiac:</span>
					<select id='input' name='zodiac'>
						<option>Aries</option>
						<option>Taurus</option>
						<option>Gemini</option>
						<option>Cancer</option>
						<option>Leo</option>
						<option>Virgo</option>
						<option>Libra</option>
						<option>Scorpio</option>
						<option>Sagittarius</option>
						<option>Capricorn</option>
						<option>Aquarius</option>
						<option>Pisces</option>
					</select><br>
					<span class='title'>Class:</span>
					<select id='input' name='class'>";
							$grabClasses = mysql_query("SELECT * FROM classes");
							while($row=mysql_fetch_array($grabClasses))
							{
								if($row[enemy]!=1){
									?><option value='<? echo $row[id]; ?>' onclick="updateClassVariable('<? echo $row[name]; ?>');"><? echo $row[name]; ?></option><?
								}
							}
					echo "</select><br>
					<span class='title'>Gender:</span>
					<select id='input' name='gender'>"; ?>
						<option onmousedown="setGender('male');">Male</option>
						<option onmousedown="setGender('female');">Female</option>
					<? echo "</select><br>
					<span class='title'>Hometown:</span>
					<select id='input' name='hometown'>";
							$grabLocations = mysql_query("SELECT * FROM locations");
							while($row=mysql_fetch_array($grabLocations))
							{
								if($row[hometown]==1){
									echo "<option value='$row[id]'>$row[display_name]</option>";
								}
							}
					echo "</select>";
		} else if($step=="character_look"){
			echo"<div id='male_sprites'>";
			if ($handle = opendir('source/player_sprites/male')) {
				while (false !== ($file = readdir($handle))) {
					?><div class="viewSprite" style="background:url('source/player_sprites/male/<? echo $file; ?>');"></div><?
				}
				closedir($handle);
			}
			echo "</div>";
			echo"<div id='female_sprites'>";
			if ($handle = opendir('source/player_sprites/female')) {
				while (false !== ($file = readdir($handle))) {
					?><div class="viewSprite" style="background:url('source/player_sprites/female/<? echo $file; ?>');"></div><?
				}
				closedir($handle);
			}
			echo "</div>";
		} else if($step=="review_character"){
			echo "<input type='submit' name='build_character' value='Build Character!'>";
		}
	}
	
	public function processAvatar($_avatar, $name2){
		$this->avatar = $_avatar;
		// add avatar to database
		$query = "UPDATE characters SET avatar = '$_avatar' WHERE name = '$name2'";
		mysql_query($query);
		if (mysql_errno()) {
		  $error = "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$query\n<br>";
		  echo $error;
		} 
	}
	
	public function calculateCharacterAge($birthday){
		list($year,$month,$day) = explode("-",$birthday);
		$year_diff  = date("Y") - $year;
		$month_diff = date("m") - $month;
		$day_diff   = date("d") - $day;
		if ($day_diff < 0 || $month_diff < 0)
		  $year_diff--;
		return $year_diff;
	}
	
	public function setupInventory($char){
		if($inventoryID==0){
			echo "<center>Setting up inventory now...<br>";
			echo "<img src='interface/img/ajax-loader.gif'><br>";
			$q = "INSERT INTO inventory (char_name, slot1, slot2, slot3, slot4, slot5, slot6, slot7, slot8, slot9, slot10, slot11) VALUES ('$char', '1', '2', '3', '0', '0', '0', '0', '0', '0', '0', '0')";
			mysql_query($q);
			if (mysql_errno()) {
			  $error = "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$query\n<br>";
			  echo $error;
			} 
			$getInventoryID = mysql_query("SELECT id FROM inventory WHERE char_name = '$char'");
			while($row = mysql_fetch_array($getInventoryID))
			{
				$newInventoryID = $row[id];
			}
			$update = "UPDATE characters SET inventoryID = '$newInventoryID' WHERE name = '$char'";
			mysql_query($update);
			echo "Inventory successfully setup, you can now attain items!<br><br>";
			echo "<a href='index.php' target='_parent'>click here to continue</a>";
		} else {
			echo "Your inventory is already setup";
		}
	}
	
	function gainEXP($gain, $player)
	{
		include_once("mmorpg.class.php");
		$mmo = new MMORPG();
		include_once("comm.class.php");
		$comm = new Comm();
		$char = $mmo->getCharacter($player);
		$new_exp = $char[exp]+$gain;
		mysql_query("UPDATE characters SET exp = '$new_exp' WHERE id = '$char[id]'") or die(mysql_error());
		$note = "You gain $gain EXP points";
		$comm->new_notification($note, "success", $player);
		return $new_exp;
	}
	
	function levelsHandler($exp, $currentLevel, $max, $max_hp, $max_mp, $char)
	{
		include_once("comm.class.php");
		$comm = new Comm();
		if($currentLevel==1)
		{
			$max=100;
		}
		if($exp >= $max)
		{
			$levelsGained = $exp / $max;
			if($levelsGained >= 1)
			{
				$remainderEXP = $exp % $max;
				$levelsGained = floor($exp / $max);
				$levelUP = $currentLevel + $levelsGained;
				$maxexpUP = $max + 40;
				$maxmpUP = $max_mp + 4;
				$maxhpUP = $max_hp + 2;
				$query = mysql_query("UPDATE characters SET level = '$levelUP', max_exp = '$maxexpUP', max_mp = '$maxmpUP', max_hp = '$maxhpUP', hp = '$maxhpUP', exp = '$remainderEXP' WHERE id = '$char'") or die(mysql_error());
				$comm->new_notification("You have achieved level $levelUP", "success", $char);
			}
		}
		return $levelUP;
	}
	
	function getIDFromName($name)
	{
		$getID = mysql_query("SELECT * FROM characters WHERE name = '$name'");
		while($row = mysql_fetch_array($getID))
		{
			$charID = $row[id];
		}
		return $charID;
	}
	
	function getNameFromID($id)
	{
		$getName = mysql_query("SELECT * FROM characters WHERE id = '$id'");
		while($row = mysql_fetch_array($getName))
		{
			$charName = $row[name];
		}
		return $charName;
	}
	
	function getUserName($id)
	{
		$getUserName2 = mysql_query("SELECT * FROM characters WHERE id = '$id'");
		while($row = mysql_fetch_array($getUserName2))
		{
			$userID = $row[userID];
		}
		$getUserName = mysql_query("SELECT * FROM users WHERE id = '$userID'");
		while($row = mysql_fetch_array($getUserName))
		{
			$userName = $row[username];
		}
		return $userName;
	}
	
	function getFriends($id)
	{
		$x=0;
		$bFriends = mysql_query("SELECT * FROM friendships WHERE friend_a = '$id'");
		while($row = mysql_fetch_array($bFriends))
		{
			$_bFriends[$x++] = $row[friend_b];
		}
		$y=0;
		$aFriends = mysql_query("SELECT * FROM friendships WHERE friend_b = '$id'");
		while($row = mysql_fetch_array($aFriends))
		{
			$_aFriends[$y++] = $row[friend_a];
		}
		$friends = array_merge((array)$_bFriends, (array)$_aFriends);
		return $friends;
	}
	
	function getRelationship($id)
	{
		$getRelationship = mysql_query("SELECT * FROM relationships WHERE partner_a = '$id'");
		while($row = mysql_fetch_array($getRelationship))
		{
			$relationship[0] = $row[partner_a];
			$relationship[1] = $row[partner_b];
		}
		if($relationship[0]==0)
		{
			$getRelationship = mysql_query("SELECT * FROM relationships WHERE partner_b = '$id'");
			while($row = mysql_fetch_array($getRelationship))
			{
				$relationship[0] = $row[partner_b];
				$relationship[1] = $row[partner_a];
			}
		}
		return $relationship;
	}
	
	function getPlayerAvatar($id)
	{
		$get = mysql_query("SELECT * FROM characters WHERE id = '$id'");
		while($row=mysql_fetch_array($get))
		{
			$avatar = $row[avatar];
		}
		return $avatar;
	}
	
	function getPlayerName($id)
	{
		$get = mysql_query("SELECT * FROM characters WHERE id = '$id'");
		while($row=mysql_fetch_array($get))
		{
			$name = $row[name];
		}
		return $name;
	}
	
	function isInParty($id)
	{
		$findOut = mysql_query("SELECT * FROM characters WHERE id = '$id'");
		while($row = mysql_fetch_array($findOut))
		{
			$party = $row[party];
		}
		if($party==0)
		{
			$inParty = false;
		} else {
			$inParty = true;
		}
		return $inParty;
	}
}
?>