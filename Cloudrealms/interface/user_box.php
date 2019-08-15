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
// File: user_box.php                                                             /
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

if(preg_match('/^enemy/', $target)){
	$enemyx = 1;
} else {
	$enemyx = 0;
}
?>
<style>
.player-<? echo $charID; ?> {
  position:absolute;
}
</style>
<div style="margin:17px;width:265px;">
<!-- user box -->
<div class="user" style="z-index:222;position:relative;padding:10px;margin:5px;background:url('interface/img/trans.png');width:260px;">
	<img src="uploads/avatar/<? echo $useravatar; ?>" width="44" height="44" class="hoverimg" alt="Avatar" />
	<p>Playing as:</p>
	<p class="username"><? echo $username; ?></p>
	<p class="userbtn"><a id="close3" style="display:none;" onclick="$('#profile').mb_close(); $('#actions').fadeOut(); $('#open3').fadeIn(); $(this).hide();">Profile</a><a id="open3" onclick="$('#profile').mb_open(); $('#close3').fadeIn();$('#actions').fadeIn(); $(this).hide();">Profile</a></p>
	<p class="userbtn"><a href="do/logout.php" title="">Log out</a></p>
	<p class="userbtn"><a id="toggle-status" href="javascript:toggle_statuses();">Status</a></p>
</div>
<!-- /user box -->
<? if($mode=='battle'){ ?>
<!-- battle box -->
<div class="user" style="z-index:222;position:relative;padding:10px;margin:5px;background:url('interface/img/trans.png');width:250px;overflow:hidden;">
	<form id="playerAttack" onsubmit="playerAttack();return false"><input type="submit" value="Attack" style="float:left;" /></form>
	<form id="playerDefend"><input type="submit" value="Defend" style="float:left;" /></form>
	<form id="playerItems"><input type="submit" value="Items" style="float:left;" /></form>
	<br><br>
	<form id="playerSpecials"><input type="submit" value="Specials" style="float:left;" /></form>
	<input type="submit" value="Spells" style="float:left;" onclick="toggle_spells();" />
	<form id="playerRetreat" onsubmit="playerRetreat();return false"><input type="submit" value="Retreat" style="float:left;" /></form>
	<br><br>
	<form id="setTarget">Your Target: <select name="target" style="border:0px;padding:2px;margin:0px;"><option>>> <? if($enemyx==1){ echo $battle->targetName($target, $battleid); } else { echo $target; } ?> << </option>
		<?
		$x=0;
		foreach($enemy as $_enemy){
			$x++;
			if($_enemy)
			{
				echo "<option value='".$target_set = "enemy".$x."'>".$battle->enemyName($_enemy)." $x</option>";
			}
		}
		foreach($player as $_player){
			if($_player)
			{
				echo "<option value='".$battle->playerName($_player)."'>".$battle->playerName($_player)."</option>";
			}
		}
		?>
	</select><input type="submit" value="Set!"></form>
	<div id="target_set"> </div>
</div>
<div id="spells" class="user" style="top:107px;left:300px;z-index:222;position:absolute;padding:10px;background:url('interface/img/trans.png');width:250px;height:123px;overflow-y:scroll;display:none;">
<?
$spells = $battle->getPlayerSpells($userID); 
for($i=0;$i < count($spells);$i++)
{
	$scroll = $battle->loadScroll($spells[$i]);
	?><li><span style="margin-right:10%;"><? echo $scroll[name]; ?></span> <input type="submit" onclick="castSpell('<? echo $userID; ?>', '<? echo $target; ?>', '<? echo $enemyx; ?>', '<? echo $scroll[id]; ?>', '<? echo $battleid; ?>');return false" value="Cast Spell!"></li><hr><?
}
?>
</div>
<!-- /battle box -->
<? } ?>
<!-- status update -->
<div id="statusx" class="statusx" style="z-index:222;position:absolute;padding:10px;margin:5px;background:url('interface/img/trans.png');width:250px;overflow:hidden;display:none;">
<form id="updateStatus">
	<input onclick="this.value='';" value="Update Your Status..." type="text" name="status" style="width:190px;" />   	
	<input type="submit" name="update_status" value="Go!" /> <br />
</form>
<div id="other_status"></div>
</div>
<!-- /status box -->
<!-- character box -->
<div id="char" class="user" style="z-index:222;position:absolute;padding:10px;margin:5px;background:url('interface/img/trans.png');width:250px;color:#fff;<? if($mode!='battle'){ ?>display:none;<? } ?>">
	<a href="<? echo $avatar; ?>" id="imgx"><img src="<? echo $combat_avatar; ?>" width="80" height="80" class="hoverimg" alt="Avatar" /></a>
	<p>Name: <? echo $name; ?></p>
	<p>Level: <? echo $level; ?></p>
	<p>Money: <? echo $money; ?></p>
	<p>Age: <? echo $age; ?></p>
	<p>Zodiac: <? echo $zodiac; ?></p>
	<p>Gender: <? echo $gender; ?></p>
	<p>Martial Status: <? echo $martial; ?></p>
	<hr />
	<h3>Stats</h3>
	<p>Class: <? echo $class; ?></p>
	<p>Attack: <? echo $attack; ?></p>
	<p>Defense: <? echo $defense; ?></p>
	<?
		if($exp >= 100)
		{
			$maxp = $maxexp-$exp;
			$realEXP = 100-$maxp;
		} else {
			$realEXP = $exp;
		}
	?>
	<div class="usagebox" style="height:15px;overflow:hidden;"><div class="midbar" style="width:<? echo $realEXP; ?>%;height:15px;">EXP:<? echo $exp; ?>% / <? echo $maxexp; ?>%</div></div>
	<div class="usagebox" style="height:15px;overflow:hidden;"><div class="midbar" style="<? if($hp > 0){ ?>width: <? echo $hp; ?>%;height:15px;background:#00FF08;<? } else { ?>width: 100%;height:15px;background:#ff0000;<? } ?>"><? if($hp > 0){ ?>HP:<? echo $hp; ?>%<? } else { ?>HP:<? echo $hp; ?>% / <? echo $maxhp; ?>%<? } ?></div></div>
	<div class="usagebox" style="height:15px;overflow:hidden;"><div class="midbar" style="width: <? echo $mp; ?>%;height:15px;background:#00C8FF;">MP:<? echo $mp; ?>% / <? echo $maxmp; ?>%</div></div>
	<div class="usagebox" style="height:15px;overflow:hidden;"><div class="midbar" style="width: <? echo $tp; ?>%;height:15px;background:#F200FF;">TP:<? echo $tp; ?>%</div></div>
	<? if($mode!='battle'){ ?>
	<hr />
	<h3>Skills <button onclick="cwindow('upgradeSkills.php?char=<? echo $charID; ?>&name=<? echo $name; ?>');" style="float:right;">manage skills</button></h3>
	<?
	$skills = $mmorpg->getSkills($name);
	$char_skills = $mmorpg->getCharSkills($charID); 
	for($i=0; $i < count($skills[name]); $i++)
	{
		echo $skills[name][$i].": ";
		if($skills[id][$i]==$char_skills[skill][$i]){
			echo $char_skills[points][$i];
		} else {
			echo '0';
		}
		echo "<br>";
	}}
	?>
</div>
<!-- /character box -->