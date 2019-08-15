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
// File: target_setter.php                                                        /
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

include('../includes/connect.php');
include('../classes/battle.class.php');
$battle = new Battle();
$char = $_GET[char];
$battleid = $_GET[battleid];
$enemy[0] = $_GET[enemy0];
$enemy[1] = $_GET[enemy1];
$enemy[2] = $_GET[enemy2];
$enemy[3] = $_GET[enemy3];
$enemy[4] = $_GET[enemy4];
$getTarget = mysql_query("SELECT * FROM characters WHERE id = '$char'");
while($row=mysql_fetch_array($getTarget))
{
	$target=$row[current_target];
}
?>
<form id="setTarget">Your Target: <select name="target"><option>>> <? echo $battle->targetName($target, $battleid); ?> << </option>
	<?
	$x=0;
	foreach($enemy as $_enemy){
		$x++;
		if($_enemy)
		{
			echo "<option value='".$target_set = "enemy".$x."'>".$battle->enemyName($_enemy)." $x</option>";
		}
	}
	?>
</select><input type="submit" value="Set!"></form>
<div id="target_set"> </div>

<script type="text/javascript">
$(function(){
	$("#setTarget").submit(function(){	
		$.post("do/set_target.php?char=<? echo $char_id; ?>", $("#setTarget").serialize(),
		function(data){
			$("#target_set").html("<p>" + data.target + " is your current target</p>");
			var target = data.target;
		}, "json");
		return false;
	});
});
</script>