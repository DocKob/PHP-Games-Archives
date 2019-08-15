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
// File: battle.php                                                               /
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

include('classes/battle.class.php');
$battle = new Battle();
$type = $_GET[type];
$enemy[0] = $_GET[enemy];
$enemy[1] = $_GET[enemy2];
$enemy[2] = $_GET[enemy3];
$enemy[3] = $_GET[enemy4];
$enemy[4] = $_GET[enemy5];
$count = $_GET[count];
$battleid = $_GET[battleid];
$move = $_GET[move];
if($_GET[location])
{
	$loc = $_GET[location];
} else {
	$loc = $_GET[loc];
}
// Get battle music and play it with html 5
$audio = $battle->getBattleMusic($loc);
echo '<audio preload="auto" autoplay="autoplay" loop="loop">
		<source src="'.$audio[mp3].'" />
		<source src="'.$audio[ogg].'" />
	</audio>';
// Inititate combat
if(!$battleid)
{
	$battleid = $mmorpg->battleid();
	$initial="battle not initiated";
	mysql_query("INSERT INTO battle_logs (unique_code, enemy1, enemy2, enemy3, enemy4, enemy5, enemy1_hp, enemy2_hp, enemy3_hp, enemy4_hp, enemy5_hp, end) VALUES ('$battleid', '$enemy[0]', '$enemy[1]', '$enemy[2]', '$enemy[3]', '$enemy[4]', '100', '100', '100', '100', '100', '0')") or die(mysql_error());
	mysql_query("UPDATE characters SET current_battle = '$battleid' WHERE id = '$char_id'") or die(mysql_error());
	$mmorpg->redirect($_SERVER[REQUEST_URI]."&battleid=".$battleid);
} 
// Load Party Data
if($partyID==0)
{
	$player[0] = $char_id;
	$player[1] = 0;
	$player[2] = 0;
	$player[3] = 0;
	$player[4] = 0;
} else {
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
	if(!$party_battle)
	{
		mysql_query("UPDATE party SET battleid = '$battleid' WHERE id ='$partyID'");
	}
}
// If from loaded battleid get enemy data
$loadBattle = mysql_query("SELECT * FROM battle_logs WHERE unique_code = '$battleid'");
while($row = mysql_fetch_array($loadBattle))
{
	$enemy[0] = $row[enemy1];
	$enemy[1] = $row[enemy2];
	$enemy[2] = $row[enemy3];
	$enemy[3] = $row[enemy4];
	$enemy[4] = $row[enemy5];
	$enemy1_hp = $row[enemy1_hp];
	$enemy2_hp = $row[enemy2_hp];
	$enemy3_hp = $row[enemy3_hp];
	$enemy4_hp = $row[enemy4_hp];
	$enemy5_hp = $row[enemy5_hp];
}
?>
<script type="text/javascript"> 
var ajax_load = "<img src='interface/img/ajax-loader.gif' alt='loading...' />";
//  load() functions  
var auto_refresh = setInterval(function ()
{
	$('#battlelog').load('includes/battle_log.php?battleid=<? echo $battleid; ?>').fadeIn("slow");
	$('#players').load('includes/players.php?battleid=<? echo $battleid; ?>&player0=<? echo $player[0]; ?>&player1=<? echo $player[1]; ?>&player2=<? echo $player[2]; ?>&player3=<? echo $player[3]; ?>&player4=<? echo $player[4]; ?>').fadeIn("slow");
	$('#enemies').load('includes/enemies.php?battleid=<? echo $battleid; ?>&enemy0=<? echo $enemy[0]; ?>&enemy1=<? echo $enemy[1]; ?>&enemy2=<? echo $enemy[2]; ?>&enemy3=<? echo $enemy[3]; ?>&enemy4=<? echo $enemy[4]; ?>&player0=<? echo $player[0]; ?>&player1=<? echo $player[1]; ?>&player2=<? echo $player[2]; ?>&player3=<? echo $player[3]; ?>&player4=<? echo $player[4]; ?>&loc=<? echo $loc; ?>&char=<? echo $char_id; ?>&hp=<? echo $char_id; ?>').fadeIn("slow");
}, 1000); // refresh interval
var target_setter = setInterval(function ()
{
	$('#target_setter').load('includes/target_setter.php?char=<? echo $char_id; ?>&battleid=<? echo $battleid; ?>&enemy0=<? echo $enemy[0]; ?>&enemy1=<? echo $enemy[1]; ?>&enemy2=<? echo $enemy[2]; ?>&enemy3=<? echo $enemy[3]; ?>&enemy4=<? echo $enemy[4]; ?>');
}, 6000);
</script>
<link rel="stylesheet" href="interface/styles/battle.css" type="text/css" />
<div id="battlelog"> </div>
<!-- BATTLE CANVAS -->
<div id="battlecanvas">
	<div id="players"></div>
	<div id="enemies"></div>
</div>
<!-- /BATTLE CANVAS -->

<script type="text/javascript">
$(document).ready(function() {      
    $('input[type="submit"]').click(function() {
        $(this).attr('disabled','disabled');
        setTimeout(function() {
           $('input[type="submit"]').removeAttr('disabled');
        }, 5000);
    });    
});
function playerRetreat()
{
	$.post("do/retreat.php?who=<? echo $player[0]; ?>&char=<? echo $char_id; ?>&id=<? echo $battleid; ?>&party=<? echo $partyID; ?>");
}
function castSpell(caster, target, enemy, spell, battleid)
{
	$.post("do/castSpell.php?userid="+caster+"&target="+target+"&enemy="+enemy+"&spellid="+spell+"&battleid="+battleid+"");
}
function enemyAttack()
{
	$.post("do/attack.php?who=enemy&char=<? echo $char_id; ?>&enemy=<? echo $enemy[0]; ?>&id=<? echo $battleid; ?>&hp=<? echo $enemy1_hp; ?>&w=<? echo $target; ?>");
}
setInterval('enemyAttack()',7000); // every 7 seconds
$(function(){
	$("#setTarget").submit(function(){	
		$.post("do/set_target.php?char=<? echo $char_id; ?>", $("#setTarget").serialize(),
		function(data){
			$("#target_set").html("<p>" + data.target + " is the current target</p>");
			var target = data.target;
		}, "json");
		return false;
	});
});
function toggle_spells()
{
	var ele = document.getElementById("spells");
	if(ele.style.display == "block") {
    		ele.style.display = "none";
  	}
	else {
		ele.style.display = "block";
	}
}
</script>