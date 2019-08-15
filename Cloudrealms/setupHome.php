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
// File: setupHome.php                                                            /
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

echo '<font color="#000">';
include('interface/header.php');
include('includes/connect.php');
include('includes/load_player_data.php');
?>
<script>
jQuery(document).ready(function(){
	$('#colorpickerField1').ColorPicker({
		onSubmit: function(hsb, hex, rgb, el) {
			$(el).val(hex);
			$(el).ColorPickerHide();
		},
		onBeforeShow: function () {
			$(this).ColorPickerSetColor(this.value);
		}
	})
	.bind('keyup', function(){
		$(this).ColorPickerSetColor(this.value);
	});
});
</script>
<font color="#000">
<img src='source/icons/home.png' style="float:left;margin-right:20px;"><br>
<? if($_POST[setup_finish])
{ 
?>
<div id="ticker" style="float:left;margin:20px;">
	<div>
		<p>Your home is now setup!</p>
		<a href="index.php?location=home&bgcolor=<? echo $_POST[bgcolor]; ?>&action=setup_home" target="_parent">click here to be teleported to your new home</a>
	</div>
</div>
<? } else if($_GET[action]=='0') { ?>
<div id="ticker" style="float:left;margin:20px;width:300px;">
	<div>
		<p>Your home is not yet setup, click the button below to set up your home</p>
		<button onClick="location.href='setupHome.php'">Continue</button>
	</div>
</div>
<? } else if($_GET[action]=='pick_color') { ?>
<form method="post" action="<? echo $_SERVER[PHP_SELF]; ?>" />
	<input type="text" maxlength="6" size="6" id="colorpickerField1" name="bgcolor" value="00ff00" /><br><br>
	<b>Pick a color using the color picker above, once you have found a color, click the color icon in the bottom right corner of the picker</b><br><br>
	<input type="submit" name="setup_finish" value="Click here to finish setting up your new home!" />
</form>
<? } else { ?>
<div id="ticker" style="float:left;margin:20px;width:300px;">
	<div>
		<p>Welcome to the home wizard, this in-game wizard will help you setup your new home!</p><br>
		<button class="next">Continue</button>
	</div>
	<div>
		<p>There are only a few options to setup, so let's begin!</p><br>
		<button class="next">Continue</button>
	</div>
	<div>
		<p>Your home will need a default paint color, use the color picker to choose a color for your home.</p><br>	
		<button onClick="location.href='setupHome.php?action=pick_color'">Continue</button>
	</div>
</div>
<? } ?>