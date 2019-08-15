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
// File: create_character.php                                                     /
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

include('interface/header.php');
$user = $_GET[user];
?> 
<div style="margin:30px;color:#000;">
<h2>Create your character (part 1)</h2><br />
<form name="create_character" action="create_character2.php?user=<? echo $user; ?>" method="post">
	<p>
		<label for="textfield"><strong>Character Name:</strong></label>
		<input type="text" id="textfield" class="inputbox" name="name" /> <br />
	</p>
	<table><tr><td valign="top">
	<p>
		<label for="textfield"><strong>Age: (YYYY-MM-DD)</strong></label>
		<input type="text" id="character-age" class="inputbox smallbox" id="age" name="age" /> <br />
	</p><br>
	<p>Your stats are randomly generated, <a href="javascript:location.reload(true)">click here</a> to re-roll your stats</p>
	<table><tr>
	<td>
	<p>
		<label for="textfield"><strong>Knowledge:</strong></label>
		<input type="text" id="smallbox" class="inputbox smallbox" id= "knowledge" name="knowledge" value="<? echo rand(1,10); ?>" style="width:20px;" readonly /> <br />
	</p>
	</td><td>
	<p>
		<label for="textfield"><strong>Strength:</strong></label>
		<input type="text" id="smallbox" class="inputbox smallbox" id="strength" name="strength" value="<? echo rand(1,10); ?>" style="width:20px;" readonly /> <br />
	</p>
	</td></tr><tr>
	<td>
	<p>
		<label for="textfield"><strong>Charm:</strong></label>
		<input type="text" id="smallbox" class="inputbox smallbox" name="charm" value="<? echo rand(1,10); ?>" style="width:20px;" readonly /> <br />
	</p>
	</td><td>
	<p>
		<label for="textfield"><strong>Magic:</strong></label>
		<input type="text" id="smallbox" class="inputbox smallbox" name="magic" value="<? echo rand(1,10); ?>" style="width:20px;" readonly /> <br />
	</p>
	</td></tr></table>
	<br>
	<input type="submit" value="Continue..." class="btn" name="create_character" />
	</td><td valign="top">
	<p><br>
		<label for="textfield"><strong>Zodiac:</strong></label>
		<select name="zodiac">
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
		</select>
		<br />
	</p>
	<p><br>
		<label for="textfield"><strong>Gender:</strong></label>
		<select name="gender">
			<option>Male</option>
			<option>Female</option>
		</select>
		<br />
	</p>
	<p><br>
		<label for="textfield"><strong>Class:</strong></label>
		<select name="class">
		<?
		$q = mysql_query("SELECT * FROM classes");
		while($row = mysql_fetch_array($q))
			{
		?>
			<option value="<? echo $row[id]; ?>"><? echo $row[name]; ?></option>
		<?
			}
		?>
		</select>
		<br />
	</p>
	</td></tr></table>
</form>
</div>