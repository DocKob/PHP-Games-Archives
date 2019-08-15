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
// File: map_editor.php                                                           /
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

include("../includes/connect.php");
$multi = $_GET['multi'];
if($_GET[loc])
{
	$location=$_GET[loc];
} else {
	$location='vanlord';
}
$grabLocationData = mysql_query("SELECT * FROM locations WHERE name = '$location'") or die (mysql_error());
while($row = mysql_fetch_array($grabLocationData))
{
	$loc_id = $row[id];
	$loc_name = $row[name];
	$loc_display_name = $row[display_name];
	$loc_north = $row[north];
	$loc_south = $row[south];
	$loc_east = $row[east];
	$loc_west = $row[west];
	$loc_tile_color = $row[default_tile_color];
	$loc_bg = $row[background];
}
if($loc_tile_color!="")
{
	// do none
} else {
	$loc_tile_color='66CD00';
}
$selectedTile=$_COOKIE[selectedTile];
?>
<style>
#canvas
{}
#canvas p 
{
	clear: both;
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
	border: 1px #76C47C solid;
}
#canvas span.tile:hover
{
	background: url('http://verdisx.com/projects/game/interface/img/trans.png') #66CD00;
}
.selected
{
	background: url('http://verdisx.com/projects/game/interface/img/trans.png') #66CD00;
	width: <? echo $tile_width; ?>px;
	height: <? echo $tile_height; ?>px;
	border: 1px #76C47C solid;
}
.overTile
{
	z-index:999;
	position:absolute;
}
</style>
Now editing map for location <? echo $loc_display_name; ?> - <? if($multi=='true'){ ?><a href="index.php?action=map_editor&loc=<? echo $location; ?>&multi=false">Switch OFF multi tile editor</a> <span id="tile_placed"></span><? } else { ?><a href="index.php?action=map_editor&loc=<? echo $location; ?>&multi=true">Switch ON multi tile editor</a><? } ?>
<div id="canvas">
		<? 
		$count=0;
		$width = $canvas_width;
		$height = $canvas_height;
		for($row =0; $row < $height; $row++)
		{
			echo "<p>";
			for($column =0; $column < $width; $column++)
			{
				$count++;
				$grabEnemy = mysql_query("SELECT * FROM enemy WHERE row = '$row' AND col = '$column' AND location = '$loc_id'");
				while($enemy_array=mysql_fetch_array($grabEnemy))
				{
					$enemy_avatar=$enemy_array[avatar];
				}
				$grabNPC = mysql_query("SELECT * FROM npc WHERE row = '$row' AND col = '$column' AND location = '$loc_id'");
				while($npc_array=mysql_fetch_array($grabNPC))
				{
					$npc_avatar=$npc_array[avatar];
				}
				$grabObject = mysql_query("SELECT * FROM objects WHERE row = '$row' AND col = '$column' AND location = '$loc_id'");
				while($obj_array=mysql_fetch_array($grabObject))
				{
					$object=$obj_array[image];
					$objid=$obj_array[id];
				}
				$enemy=mysql_query("SELECT * FROM enemy WHERE row = '$row' AND col = '$column' AND location = '$loc_id'");
				$npc=mysql_query("SELECT * FROM npc WHERE row = '$row' AND col = '$column' AND location = '$loc_id'");
				$obj=mysql_query("SELECT * FROM objects WHERE row = '$row' AND col = '$column' AND location = '$loc_id'");
				$tiles=mysql_query("SELECT * FROM tiles WHERE row = '$row' AND col = '$column' AND location = '$location'");
				if(mysql_num_rows($tiles) > 0) 
				{
					$grabTile = mysql_query("SELECT * FROM tiles WHERE row = '$row' AND col = '$column' AND location = '$location'");
					while($tile=mysql_fetch_array($grabTile))
					{
						$bg=$tile[bg];
						$tileid=$tile[id];
					}
					$url="mod_tile.php?row=$row&col=$column&loc=$location&id=$tileid&locid=$loc_id";
				?>
				<? 
				if($multi!='true') { ?>
					<a href="#" onClick="popitup('<? echo $url; ?>')">
				<? } ?>
					<? if($multi=='true'){?>
						<form id="placeTile<? echo $count; ?>b" name="placeTile" onsubmit="place_tile(<? echo $column; ?>, <? echo $row; ?>, 'update');return false" style="margin:0px;padding:0px;">
					<? } ?>
						<span class="tile" style="background:url(../<? echo $bg; ?>) #66CD00;" onmouseover="this.style.background='url(../interface/img/multi.png)'" onmouseout="this.style.background='url(../<? echo $bg; ?>)'" id="<? echo $count; ?>d">
					<? if($multi=='true'){?>
						<input type="image" src="../interface/img/multi.png" onmouseover="this.src='../interface/img/multi2.png'" onmouseout="this.src='../interface/img/multi.png'" height="<? echo $tile_height; ?>" width="<? echo $tile_width; ?>" class="overTile">
					<? } ?>
					<? if(mysql_num_rows($npc) > 0) { ?>
						<img src="../<? echo $npc_avatar; ?>" class="overTile">
					<? } ?>
					<? if(mysql_num_rows($enemy) > 0) { ?>
						<img src="../<? echo $enemy_avatar; ?>" class="overTile">
					<? } ?>
					<? if(mysql_num_rows($obj) > 0) { ?>
							<img src="../<? echo $object; ?>" onclick="popitup('delObj.php?id=<? echo $objid; ?>&loc=<? echo $location; ?>');" class="overTile">
					<? } ?>
						</span>
					<? if($multi=='true'){?>
						</a>
					</form>
					<? } ?>
				<? if($multi!='true') { ?>
					</a>
				<? } ?>
				<?
				} else {
					$url="add_tile.php?row=$row&col=$column&loc=$location&id=$tileid&locid=$loc_id"; 
				?>
				<? 
				if($multi!='true') { ?>
					<a href="#" onClick="popitup('<? echo $url; ?>')">
						<span class="tile" id="<? echo $count; ?>d">
					<? if(mysql_num_rows($npc) > 0) { ?>
						<img src="../<? echo $npc_avatar; ?>" class="overTile">
					<? } ?>
					<? if(mysql_num_rows($enemy) > 0) { ?>
						<img src="../<? echo $enemy_avatar; ?>" class="overTile">
					<? } ?>
					<? if(mysql_num_rows($obj) > 0) { ?>
						<img src="../<? echo $object; ?>" onclick="popitup('delObj.php?id=<? echo $objid; ?>&loc=<? echo $location; ?>');" class="overTile">
					<? } ?>
					</span>
					</a>
				<? } else { ?>
					<form id="placeTile<? echo $count; ?>a" onsubmit="place_tile(<? echo $column; ?>, <? echo $row; ?>, 'insert');return false" name="placeTile<? echo $count; ?>a" style="margin:0px;padding:0px;">
						<span class="tile" id="<? echo $count; ?>d">
						<input type="image" src="../interface/img/multi.png" height="<? echo $tile_height; ?>" width="<? echo $tile_width; ?>" class="overTile">
					<? if(mysql_num_rows($npc) > 0) { ?>
						<input type="image" src="../<? echo $npc_avatar; ?>" class="overTile">
					<? } ?>
					<? if(mysql_num_rows($enemy) > 0) { ?>
						<input type="image" src="../<? echo $enemy_avatar; ?>" class="overTile">
					<? } ?>
					<? if(mysql_num_rows($obj) > 0) { ?>
						<input type="image" src="../<? echo $object; ?>" onclick="popitup('delObj.php?id=<? echo $objid; ?>&loc=<? echo $location; ?>');" class="overTile">
					<? } ?>
					</span>
					</form>
		<?
					}
				}
			}
			echo "</p>";
		}
		?>
</div>  <!-- eof #canvas -->
<script type="text/javascript">
function place_tile(col, row, count)
{
	$.post("../do/placeTile.php?col="+col+"&row="+row+"&tile=<? echo $_COOKIE[tile]; ?>&loc=<? echo $loc_name; ?>&do="+count);
}
</script>