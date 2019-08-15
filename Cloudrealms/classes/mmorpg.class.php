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
// File: mmorpg.class.php                                                         /
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

class MMORPG {
	var $id;
	
	public function doNote($message)
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
	
	public function iframe($href)
	{
		echo "<script>$(document).ready(function () {
				$.fancybox({
					'width': '60%',
					'height': '42%',
					'autoScale': true,
					'transitionIn': 'fade',
					'transitionOut': 'fade',
					'type': 'iframe',
					'href': '$href'
				});
			});
			</script>";
	}
	
	public function rand_uniqid($in, $to_num = false, $pad_up = false, $passKey = null)
	{
		$index = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		if ($passKey !== null) {
		
			for ($n = 0; $n<strlen($index); $n++) {
				$i[] = substr( $index,$n ,1);
			}

			$passhash = hash('sha256',$passKey);
			$passhash = (strlen($passhash) < strlen($index))
				? hash('sha512',$passKey)
				: $passhash;

			for ($n=0; $n < strlen($index); $n++) {
				$p[] =  substr($passhash, $n ,1);
			}

			array_multisort($p,  SORT_DESC, $i);
			$index = implode($i);
		}

		$base  = strlen($index);

		if ($to_num) {
			// Digital number  <<--  alphabet letter code
			$in  = strrev($in);
			$out = 0;
			$len = strlen($in) - 1;
			for ($t = 0; $t <= $len; $t++) {
				$bcpow = bcpow($base, $len - $t);
				$out   = $out + strpos($index, substr($in, $t, 1)) * $bcpow;
			}

			if (is_numeric($pad_up)) {
				$pad_up--;
				if ($pad_up > 0) {
					$out -= pow($base, $pad_up);
				}
			}
			$out = sprintf('%F', $out);
			$out = substr($out, 0, strpos($out, '.'));
		} else {
			// Digital number  -->>  alphabet letter code
			if (is_numeric($pad_up)) {
				$pad_up--;
				if ($pad_up > 0) {
					$in += pow($base, $pad_up);
				}
			}

			$out = "";
			for ($t = floor(log($in, $base)); $t >= 0; $t--) {
				$bcp = bcpow($base, $t);
				$a   = floor($in / $bcp) % $base;
				$out = $out . substr($index, $a, 1);
				$in  = $in - ($a * $bcp);
			}
			$out = strrev($out); // reverse
		}

		return $out;
	}
	
	public function battleid()
	{
		$battle_id = $this->rand_uniqid(rand());
		return $battle_id;
	}
	
	public function redirect($url, $time=NULL)
	{
	  echo '<script>location.href = "'.$url.'";</script>';
	}
	
	public function getCharacter($id)
	{
		include_once('character.class.php');
		$char = new Character();
		$grabCharacterData = mysql_query("SELECT * FROM characters WHERE userID = '$id'");
		$character = mysql_fetch_array($grabCharacterData);
		$grabClass = mysql_query("SELECT name FROM classes WHERE id = '$character[class]'");
		$character[age] = $char->calculateCharacterAge($character[age]);	
		while($n = mysql_fetch_array($grabClass))
		{
			$character['class'] = $n['name'];
		}
		$character[inventory] = $character[inventoryID];
		return $character;
	}
	
	public function getCharacterByName($name)
	{
		$grabCharacterData = mysql_query("SELECT * FROM characters WHERE name = '$name'");
		while($row = mysql_fetch_array($grabCharacterData))
		{
			include_once('character.class.php');
			$char = new Character();
			$character[id] = $row['id'];
			$character[name] = $row['name'];
			$character[level] = $row['level'];
			$character[money] = $row['money'];
			$character[skill_points] = $row['skill_points'];
			$character[exp] = $row['exp'];
			$character[max_exp] = $row['max_exp'];
			$character[hp] = $row['hp'];
			$character[mp] = $row['mp'];
			$character[tp] = $row['tp'];
			$character[age] = $char->calculateCharacterAge($row['age']);
			$character[knowledge] = $row['knowledge'];
			$character[strength] = $row['strength'];
			$character[charm] = $row['charm'];
			$character[zodiac] = $row['zodiac'];
			$charater[avatar] = $row['avatar'];
			$character[martial] = $row['martial'];
			$character['class'] = $row['class'];
			$grabClass = mysql_query("SELECT name FROM classes WHERE id = '$class'");
			while($n = mysql_fetch_array($grabClass))
			{
				$character['class'] = $n['name'];
			}
			$character[gender] = $row['gender'];
			$character[inventory] = $row['inventoryID'];
			$character[party] = $row['party'];
			$character[current_battle] = $row['current_battle'];
			$character[curren_target] = $row['current_target'];
			$character[row] = $row[row];
			$character[col] = $row[col];
		}
		return $character;
	}
	
	public function getUser($id)
	{
		$grabUserData = mysql_query("SELECT * FROM users WHERE id = '$id'");
		while($row = mysql_fetch_array($grabUserData))
		{
			$user[avatar] = $row['avatar'];
			$user[email] = $row['email'];
			$user[name] = $row['username'];
			$user[status] = $row['status'];
			$user[char] = $row['characterID'];
			$user[id] = $row['id'];
		}
		return $user;
	}
	
	public function getUserFromName($username)
	{
		$grabUserData = mysql_query("SELECT * FROM users WHERE username = '$username'");
		while($row = mysql_fetch_array($grabUserData))
		{
			$user[avatar] = $row['avatar'];
			$user[email] = $row['email'];
			$user[name] = $row['username'];
			$user[status] = $row['status'];
			$user[char] = $row['characterID'];
			$user[id] = $row['id'];
		}
		return $user;
	}
	
	function getLocationFromName($name)
	{
		$grabLocData = mysql_query("SELECT * FROM locations WHERE name = '$name'");
		$loc = mysql_fetch_array($grabLocData);
		return $loc;
	}
	
	function getLocationFromID($id)
	{
		$grabLocData = mysql_query("SELECT * FROM locations WHERE id = '$id'");
		$loc = mysql_fetch_array($grabLocData);
		return $loc;
	}
	
	function locationDisplayName($name)
	{
		$grabLocData = mysql_query("SELECT * FROM locations WHERE name = '$name'");
		$loc = mysql_fetch_array($grabLocData);
		return $loc[display_name];
	}
	
	function getSkills()
	{
		$grabSkills = mysql_query("SELECT * FROM skill_sets");
		$n=-1;
		while($row = mysql_fetch_array($grabSkills))
		{
			$n++;
			$skills[id][$n] = $row[id];
			$skills[name][$n] = $row[name];
			$skills[desc][$n] = $row[description];
			$skills[abbreviation][$n] = $row[abbreviation];
		}
		return $skills;
	}
	
	function getCharSkills($id)
	{
		$grabCharacterSkills = mysql_query("SELECT * FROM skills WHERE charid ='$id'");
		$n=-1;
		while($row = mysql_fetch_array($grabCharacterSkills))
		{
			$n++;
			$char_skills[points][$n] = $row[points];
			$char_skills[char][$n] = $row[charid];
			$char_skills[skill][$n] = $row[skill];
		}
		return $char_skills;
	}
	
	function getSkill($id)
	{
		$grabSkills = mysql_query("SELECT * FROM skill_sets WHERE id = '$id'");
		$skill = mysql_fetch_array($grabSkills);
		return $skill;
	}
	
	function get_javascript_array($phpArray, $jsArrayName, &$html = '') {
			$html .= $jsArrayName . " = new Array(); \r\n ";
			foreach ($phpArray as $key => $value) {
					$outKey = (is_int($key)) ? '[' . $key . ']' : "['" . $key . "']";
					if (is_array($value)) {
							get_javascript_array($value, $jsArrayName . $outKey, $html);
							continue;
					}
					$html .= $jsArrayName . $outKey . " = ";
					if (is_string($value)) {
							$html .= "'" . $value . "'; \r\n ";
					} else if ($value === false) {
							$html .= "false; \r\n";
					} else if ($value === NULL) {
							$html .= "null; \r\n";
					} else if ($value === true) {
							$html .= "true; \r\n";
					} else {
							$html .= $value . "; \r\n";
					}
			}
		   
			return $html;
	}
	
}
?>