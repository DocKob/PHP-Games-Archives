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
// File: upgradeSkills.php                                                        /
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

include("includes/connect.php");
include("classes/mmorpg.class.php");
$mmorpg = new MMORPG();
$cname = $_GET[name];
$cid = $_GET[char];
$char = $mmorpg->getCharacterByName($cname);
$skills = $mmorpg->getSkills();
$char_skills = $mmorpg->getCharSkills($cid);
?>
<script>
function addPoint(skill)
{
	charSkills = parseInt(document.getElementById('char_skills').value);
	if(charSkills <= 0){
		alert("You have no more skill points!");
	} else {
		// add skill point
		skillValue = parseInt(document.getElementById(skill).value);
		newSkillValue = 1 + skillValue;
		document.getElementById(skill).value = '';
		document.getElementById(skill).value = newSkillValue;
		// next subtract skill point from characters total skill points
		newCharSkills = charSkills - 1;
		document.getElementById('char_skills').value = newCharSkills;
	}
}
function subtractPoint(skill)
{
	charSkills = parseInt(document.getElementById('char_skills').value);
	skillValue = parseInt(document.getElementById(skill).value);
	if(skillValue <= 0){
		alert("No points!");
	} else {
		// add skill point
		newSkillValue = skillValue - 1;
		document.getElementById(skill).value = '';
		document.getElementById(skill).value = newSkillValue;
		// next subtract skill point from characters total skill points
		newCharSkills = charSkills + 1;
		document.getElementById('char_skills').value = newCharSkills;
	}
}
</script>
<?
echo "<h2>Upgrade your skills</h2>";
echo "<p>Here you will be able to upgrade your skills, and learn new ones</p>";
echo "<form method='post' action='upgradeSkills.php?char=".$cid."&name=".$cname."'>";
echo "<p><b>Skill Points Available: </b><input type='textbox' name='char_skills' id='char_skills' value='".$char[skill_points]."' size='3'></p>";
for($i=0; $i < count($skills[name]); $i++)
{
	echo $skills[name][$i].": <input name='".$skills[abbreviation][$i]."' id='".$skills[abbreviation][$i]."' size='3' value='";
	if($skills[id][$i]==$char_skills[skill][$i]){
		echo $char_skills[points][$i];
	} else {
		echo '0';
	}
	echo "'>"; ?> <button onclick='addPoint("<? echo $skills[abbreviation][$i]; ?>");return false'>+</button> / <button onclick='subtractPoint("<? echo $skills[abbreviation][$i]; ?>");return false'>-</button><br><?
}
echo "<br><input type='submit' name='update_skills' value='Update Skills'></form>";
if($_POST[update_skills]){
	mysql_query("UPDATE characters SET skill_points = '$_POST[char_skills]' WHERE id = '".$cid."'") or die(mysql_error());
	$x=-1;
	for($i=0; $i < count($skills[name]); $i++)
	{
		$skilla = strval($skills[abbreviation][$i]);
		if($char_skills[skill][$i]==0)
		{
			mysql_query("INSERT INTO skills (points, charid, skill) VALUES ('".$_POST[$skilla]."', '".$cid."', '".$skills[id][$i]."')") or die(mysql_error());
			echo "<p>".$skills[name][$i]." Learned</p>";
		} else {
			mysql_query("UPDATE skills SET points = '".$_POST[$skilla]."' WHERE charid = '".$cid."' AND skill = '".$skills[id][$i]."'") or die(mysql_error());
		}
	}
	echo "<p>Skills updated</p>";
	$mmorpg->redirect("upgradeSkills.php?char=".$cid."&name=".$cname."");
}
?>

