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
// File: game_canvas.php                                                          /
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

if($fullscreen==1)
{
?>
<script>
var tileWidth = <? echo $tile_width; ?>;
var tileHeight = <? echo $tile_height; ?>;
var canvasWidth = <? echo $canvas_width; ?>;
var canvasHeight = <? echo $canvas_height; ?>;
// Resize the width and height of the tiles to fit the users screen
tileReSizeWidth = Math.round(screen.width / canvasWidth);
tileReSizeHeight = Math.round(screen.height / canvasHeight);
// Store javascript variable in cookie so php can retrieve user data
function setCookie(c_name,value,exdays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}
setCookie("width", tileReSizeWidth, 7);
setCookie("height", tileReSizeHeight, 7);
document.onkeydown = function(evt) {
    evt = evt || window.event;
    var keyCode = evt.keyCode;
    if (keyCode >= 37 && keyCode <= 40) {
        return false;
    }
};
</script>
<? 
// Finally set the full screen additions
$tile_width = $_COOKIE[width];
$tile_height = $_COOKIE[height];
} 
?>
<style>
#canvas
{
	<? if($fullscreen!=1){?>
		margin-left:10%;
	<? } else {?>
		margin:0px;
		position:absolute;
		top:0;
		left:0;
		overflow:hidden;
		width:110%;
	<? } ?>
}
#canvas p 
{
	clear: both;
	width: 100%;
	margin: 0;
}
#canvas span 
{
	float: left;
}
#canvas span.tile 
{
	width: <? echo $tile_width; ?>px;
	height: <? echo $tile_height; ?>px;
	background: #<? echo $loc_tile_color; ?>;
}
.overTile
{
	z-index:15;
	position:relative;
}
#arrowPad
{
	width:130px;
	float:right;
	position:absolute;
	bottom:50px;
	right:50px;
	z-index:999;
}
</style>
<div id="arrowPad">
	<!--<button onclick="playerCoordinates();">pos</button>-->
	<center><button id="up">&uarr;<br>N</button></center>
	<button id="left" style="float:left;">&larr; W</button>
	<button id="right" style="float:right;">E &rarr;</button>
	<center><button id="down">S<BR>&darr;</button></center>
</div>
<div id="portalChecker"></div>
<div id="canvas">
	<span class="canvas">
		<? 
		$i=10;
		$avatar_width=$_COOKIE[avatar_width];
		$avatar_height=$_COOKIE[avatar_height];
		$width = $canvas_width;
		$height = $canvas_height;
		for($row =0; $row < $height; $row++)
		{
			echo "<p>";
			for($column =0; $column < $width; $column++)
			{
				$grabPlayers = mysql_query("SELECT * FROM characters WHERE row = '$row' AND col = '$column' AND location = '$loc_id'");
				$_player=mysql_fetch_array($grabPlayers);
				$grabEnemy = mysql_query("SELECT * FROM enemy WHERE row = '$row' AND col = '$column' AND location = '$loc_id'");
				while($enemy_array=mysql_fetch_array($grabEnemy))
				{
					$enemy_avatar=$enemy_array[avatar];
					$enemy_id=$enemy_array[id];
					$enemy_name=$enemy_array[name];
				}
				$grabNPC = mysql_query("SELECT * FROM npc WHERE row = '$row' AND col = '$column' AND location = '$loc_id'");
				while($npc_array=mysql_fetch_array($grabNPC))
				{
					$npc_avatar=$npc_array[avatar];
					$npc_id=$npc_array[id];
					$npc_name=$npc_array[name];
				}
				$grabObject = mysql_query("SELECT * FROM objects WHERE row = '$row' AND col = '$column' AND location = '$loc_id'");
				while($obj_array=mysql_fetch_array($grabObject))
				{
					$object=$obj_array[image];
				}
				$enemy=mysql_query("SELECT * FROM enemy WHERE row = '$row' AND col = '$column' AND location = '$loc_id'");
				$obj=mysql_query("SELECT * FROM objects WHERE row = '$row' AND col = '$column' AND location = '$loc_id'");
				$npc_check=mysql_query("SELECT * FROM npc WHERE row = '$row' AND col = '$column' AND location = '$loc_id'");
				$tiles=mysql_query("SELECT * FROM tiles WHERE row = '$row' AND col = '$column' AND location = '$location'");
				if(mysql_num_rows($tiles) > 0) 
				{
					$grabTile = mysql_query("SELECT * FROM tiles WHERE row = '$row' AND col = '$column' AND location = '$location'");
					while($tile=mysql_fetch_array($grabTile))
					{
						$bg=$tile[bg];
						$portal=$tile[portal];
					}
					if($portal!=""){
		?>
						<a href="index.php?location=<? echo $portal; ?>">
							<span class="tile" style="background:url('<? echo $bg; ?>') #66CD00;">
							
								<? if(mysql_num_rows($npc_check) > 0) { ?>
									<span class="npc" id="<? echo $npc_id; ?>">
									<a href="#" onclick="cwindow('talkToNPC.php?npc=<? echo $npc_id; ?>');" class="npc" title="<? echo $npc_name; ?>">
										<img src="<? echo $npc_avatar; ?>">
									</a>
									</span>
								<? } ?>
								<? if(mysql_num_rows($enemy) > 0) { ?>
									<span class="enemy" id="<? echo $enemy_id; ?>">
									<a href="#" onclick="cwindow('engageEnemy.php?enemy=<? echo $enemy_id; ?>&loc=<? echo $location; ?>');" class="npc" title="<? echo $enemy_name; ?>">
										<img src="<? echo $enemy_avatar; ?>" class="overTile">
									</a>
									</span>
								<? } ?>
								<? if(mysql_num_rows($grabPlayers) > 0) { ?>
									<a href="#" onclick="cwindow('playerStats.php?player=<? echo $_player[name]; ?>');" title="<? echo $_player[name]; ?>">
										<span class="player-<? echo $_player[id]; ?>" id="player-<? echo $_player[id]; ?>" style="height:<? echo $avatar_height; ?>px;width:<? echo $avatar_width; ?>px;overflow:hidden;z-index:99;background:transparent url('<? echo $_player[avatar]; ?>');"></span>
									</a>
								<? } ?>
								<? if(mysql_num_rows($obj) > 0) { ?>
									<img src="<? echo $object; ?>" class="overTile">
								<? } ?>
							</span>
						</a>
		<?
					} else {
					?>
						<span class="tile" style="background:url('<? echo $bg; ?>') #66CD00;">
						
							<? if(mysql_num_rows($npc_check) > 0) { ?>
								<span class="npc" id="<? echo $npc_id; ?>">
									<a href="#" onclick="cwindow('talkToNPC.php?npc=<? echo $npc_id; ?>');" class="npc" title="<? echo $npc_name; ?>">
										<img src="<? echo $npc_avatar; ?>">
									</a>
								</span>
							<? } ?>
							<? if(mysql_num_rows($enemy) > 0) { ?>
								<span class="enemy" id="<? echo $enemy_id; ?>">
								<a href="#" onclick="cwindow('engageEnemy.php?enemy=<? echo $enemy_id; ?>&loc=<? echo $location; ?>');" class="npc" title="<? echo $enemy_name; ?>">
									<img src="<? echo $enemy_avatar; ?>" class="overTile">
								</a>
								</span>
							<? } ?>
							<? if(mysql_num_rows($grabPlayers) > 0) { ?>
								<a href="#" onclick="cwindow('playerStats.php?player=<? echo $_player[name]; ?>');" title="<? echo $_player[name]; ?>">
									<span class="player-<? echo $_player[id]; ?>" id="player-<? echo $_player[id]; ?>" style="height:<? echo $avatar_height; ?>px;width:<? echo $avatar_width; ?>px;overflow:hidden;z-index:99;background:transparent url('<? echo $_player[avatar]; ?>');"></span>
								</a>
							<? } ?>
							<? if(mysql_num_rows($obj) > 0) { ?>
								<img src="<? echo $object; ?>" class="overTile">
							<? } ?>
						</span>
					<?
						}
				} else {
		?>
				<span class="tile">
				
					<? if(mysql_num_rows($npc_check) > 0) { ?>
						<span class="npc" id="<? echo $npc_id; ?>">
							<a href="#" onclick="cwindow('talkToNPC.php?npc=<? echo $npc_id; ?>');" class="npc" title="<? echo $npc_name; ?>">
								<img src="<? echo $npc_avatar; ?>">
							</a>
						</span>
					<? } ?>
					<? if(mysql_num_rows($enemy) > 0) { ?>
						<span class="enemy" id="<? echo $enemy_id; ?>">
						<a href="#" onclick="cwindow('engageEnemy.php?enemy=<? echo $enemy_id; ?>&loc=<? echo $location; ?>');" class="npc" title="<? echo $enemy_name; ?>">
							<img src="<? echo $enemy_avatar; ?>" class="overTile">
						</a>
						</span>
					<? } ?>
					<? if(mysql_num_rows($grabPlayers) > 0) { ?>
						<a href="#" onclick="cwindow('playerStats.php?player=<? echo $_player[name]; ?>');" title="<? echo $_player[name]; ?>">
							<span class="player-<? echo $_player[id]; ?>" id="player-<? echo $_player[id]; ?>" style="height:<? echo $avatar_height; ?>px;width:<? echo $avatar_width; ?>px;overflow:hidden;z-index:99;background:transparent url('<? echo $_player[avatar]; ?>');"></span>
						</a>
					<? } ?>
					<? if(mysql_num_rows($obj) > 0) { ?>
						<img src="<? echo $object; ?>" class="overTile">
					<? } ?>
				</span>
		<?
				}
			}
			echo "</p>";
		}
		// do some math to calculate the avatar margin for animation
		$move_down = $avatar_height * 0;
		$move_left = $avatar_height * 1;
		$move_right = $avatar_height * 2;
		$move_up = $avatar_height * 3;
		?>
	</span>
</div>  <!-- eof #canvas -->
<? if($hp <= 0){}{?>
<script>
var playerCol = <? echo $playerCol; ?>+1;
var playerRow = <? echo $playerRow; ?>+1;
var img = new Image();
img.onload = function() {
  avatar_height = this.height/4;
  avatar_width = this.width/4;
  move_down = avatar_height * 0;
  move_left = avatar_height * 1;
  move_right = avatar_height * 2;
  move_up = avatar_height * 3;
  setCookie("move_down", move_down, 7);
  setCookie("move_left", move_left, 7);
  setCookie("move_right", move_right, 7);
  setCookie("move_up", move_up, 7);
  setCookie("avatar_width", avatar_width, 7);
  setCookie("avatar_height", avatar_height, 7);
}
img.src = '<? echo $avatar; ?>';
$("#player-<? echo $charID; ?>").sprite({fps: 0, no_of_frames: 4});
$("#up").click(function(){
	$(".player-<? echo $charID; ?>").animate({"top": "-=<? echo $_COOKIE[height]; ?>px"}, 400, function(){$("#player-<? echo $charID; ?>").fps(0);});
	playerRow = playerRow - 1;
	document.getElementById('player-<? echo $charID; ?>').style.backgroundPosition="0px -<? echo $_COOKIE[move_up]; ?>px";
	$("#player-<? echo $charID; ?>").fps(7);
});

$("#down").click(function(){
	$(".player-<? echo $charID; ?>").animate({"top": "+=<? echo $_COOKIE[height]; ?>px"}, 400, function(){$("#player-<? echo $charID; ?>").fps(0);});
	playerRow = playerRow + 1;
	document.getElementById('player-<? echo $charID; ?>').style.backgroundPosition="0px -<? echo $_COOKIE[move_down]; ?>px"; 
	$("#player-<? echo $charID; ?>").fps(7);
});

$("#right").click(function(){
	$(".player-<? echo $charID; ?>").animate({"left": "+=<? echo $_COOKIE[width]; ?>px"}, 400, function(){$("#player-<? echo $charID; ?>").fps(0);});
	playerCol = playerCol + 1;
	document.getElementById('player-<? echo $charID; ?>').style.backgroundPosition="0px -<? echo $_COOKIE[move_right]; ?>px";
	$("#player-<? echo $charID; ?>").fps(7);
});

$("#left").click(function(){
	$(".player-<? echo $charID; ?>").animate({"left": "-=<? echo $_COOKIE[width]; ?>px"}, 400, function(){$("#player-<? echo $charID; ?>").fps(0);});
	playerCol = playerCol - 1;
	document.getElementById('player-<? echo $charID; ?>').style.backgroundPosition="0px -<? echo $_COOKIE[move_left]; ?>px";
	$("#player-<? echo $charID; ?>").fps(7);
});
$(document).keypress(function(e) {
switch(e.keyCode) { 
	// User pressed "up" arrow
	case 38:
		$(".player-<? echo $charID; ?>").animate({"top": "-=<? echo $_COOKIE[height]; ?>px"}, 400, function(){$("#player-<? echo $charID; ?>").fps(0);});
		playerRow = playerRow - 1;
		document.getElementById('player-<? echo $charID; ?>').style.backgroundPosition="0px -<? echo $_COOKIE[move_up]; ?>px";
		$("#player-<? echo $charID; ?>").fps(7);
	break;
	// User pressed "down" arrow
	case 40:
		$(".player-<? echo $charID; ?>").animate({"top": "+=<? echo $_COOKIE[height]; ?>px"}, 400, function(){$("#player-<? echo $charID; ?>").fps(0);});
		playerRow = playerRow + 1;
		document.getElementById('player-<? echo $charID; ?>').style.backgroundPosition="0px -<? echo $_COOKIE[move_down]; ?>px"; 
		$("#player-<? echo $charID; ?>").fps(7);
	break;
	// User pressed "left" arrow
	case 37:
		$(".player-<? echo $charID; ?>").animate({"left": "-=<? echo $_COOKIE[width]; ?>px"}, 400, function(){$("#player-<? echo $charID; ?>").fps(0);});
		playerCol = playerCol - 1;
		document.getElementById('player-<? echo $charID; ?>').style.backgroundPosition="0px -<? echo $_COOKIE[move_left]; ?>px";
		$("#player-<? echo $charID; ?>").fps(7);
	break;
	// User pressed "right" arrow
	case 39:
		$(".player-<? echo $charID; ?>").animate({"left": "+=<? echo $_COOKIE[width]; ?>px"}, 400, function(){$("#player-<? echo $charID; ?>").fps(0);});
		playerCol = playerCol + 1;
		document.getElementById('player-<? echo $charID; ?>').style.backgroundPosition="0px -<? echo $_COOKIE[move_right]; ?>px";
		$("#player-<? echo $charID; ?>").fps(7);
	break;
	}
});
function updatePlayerCoordinates()
{
	$.post("do/updatePlayerCoordinates.php?col="+playerCol+"&row="+playerRow+"&char=<? echo $charID; ?>&location=<? echo $location; ?>");
}
function playerCoordinates()
{
	alert("col: "+playerCol+" row: "+playerRow);
}
setInterval('updatePlayerCoordinates()',1000); // every 10 seconds update player coordinates
</script>
<? } ?>