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
// File: add_tile.php                                                             /
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
$rowx=$_GET[row];
$column=$_GET[col];
$loc=$_GET[loc];
$loc_id=$_GET[locid];
?>
<script>
function previewPic(sel) 
{
	document.previewpic.src = "../" + sel.options[sel.selectedIndex].value;
}
</script>
<b>Add a new tile for row <? echo $rowx; ?> and column <? echo $column; ?></b>
<form method='post' action='<? echo $_SERVER[REQUEST_URI]; ?>' enctype='multipart/form-data'>
Upload a tile: <input type='file' name='uploaded_tile'>
<input type='submit' name='upload' value='Upload tile'>
</form>
<hr>
Select tile from gallery:<br>
<form method='post' action='<? echo $_SERVER[REQUEST_URI]; ?>'>
<table><td><td>
<?
if ($handle = opendir('../source/tiles')) {
    echo "<select name='from_tiles' onChange='previewPic(this)'>";
    while (false !== ($file = readdir($handle))) {
        echo "<option value='source/tiles/$file'>$file</option>";
		$first_file=$file;
    }
	echo "</select>";
    closedir($handle);
}
?>
</td><td>
<img name="previewpic" src="../source/tiles/<? echo $first_file; ?>" width="32" height="32" border=1>
</tr></tr></table>
<input type='submit' name='select' value='Use tile'>
</form>
<hr>
Place an NPC:
<form method='post' action='<? echo $_SERVER[REQUEST_URI]; ?>'>
<?
echo "Select the NPC to place: <select name='npc'>";
echo "<option>Select</option>";
$getNPC = mysql_query("SELECT * FROM npc");
while($row = mysql_fetch_array($getNPC))
{
	echo "<option value='$row[id]'>$row[name]</option>";
}
echo "</select>";
?>
<input type="submit" name="place_npc" value="Go!" >
</form>
<hr>
Place an Enemy:
<form method='post' action='<? echo $_SERVER[REQUEST_URI]; ?>'>
<?
echo "Select the Enemy to place: <select name='enemy'>";
echo "<option>Select</option>";
$getEnemy = mysql_query("SELECT * FROM enemy");
while($row = mysql_fetch_array($getEnemy))
{
	echo "<option value='$row[id]'>$row[name]</option>";
}
echo "</select>";
?>
<input type="submit" name="place_enemy" value="Go!" >
</form>
<hr>
Place an Object:
<form method='post' action='<? echo $_SERVER[REQUEST_URI]; ?>'>
<?
echo "Select the Object to place: <select name='object'>";
echo "<option>Select</option>";
$getObjects = mysql_query("SELECT * FROM objects");
while($row = mysql_fetch_array($getObjects))
{
	echo "<option value='$row[id]'>$row[name]</option>";
}
echo "</select>";
?>
<input type="submit" name="place_obj" value="Go!" >
</form>
<?
if($_POST[upload])
{
	$target = "../source/tiles/"; 
	$target = $target . basename( $_FILES['uploaded_tile']['name']);
	$new_tile = "source/tiles/".$_FILES[uploaded_tile][name];
	if(move_uploaded_file($_FILES['uploaded_tile']['tmp_name'], $target)) 
	{ 
		// success
	} else { 
		// failed
	}
	mysql_query("INSERT INTO tiles (bg, row, col, location) VALUES ('$new_tile', '$rowx', '$column', '$loc')") or die (mysql_error());
	echo "Tile added successfully!";
	echo "<script>setTimeout('self.close();',1000)</script>";
} else if($_POST[select]){
	mysql_query("INSERT INTO tiles (bg, row, col, location) VALUES ('$_POST[from_tiles]', '$rowx', '$column', '$loc')") or die (mysql_error());
	echo "Tile added successfully!";
	echo "<script>setTimeout('self.close();',1000)</script>";
} else if($_POST[place_npc]){
	mysql_query("UPDATE npc SET col = '$column', row = '$rowx', location = '$loc_id' WHERE id = '$_POST[npc]'");
	echo "NPC placed successfully!";
	echo "<script>setTimeout('self.close();',1000)</script>";
} else if($_POST[place_obj]){
	mysql_query("UPDATE objects SET col = '$column', row = '$rowx', location = '$loc_id' WHERE id = '$_POST[object]'");
	echo "Object placed successfully!";
	echo "<script>setTimeout('self.close();',1000)</script>";
} else if($_POST[place_enemy]){
	mysql_query("UPDATE enemy SET col = '$column', row = '$rowx', location = '$loc_id' WHERE id = '$_POST[enemy]'");
	echo "Enemy placed successfully!";
	echo "<script>setTimeout('self.close();',1000)</script>";
}
?>