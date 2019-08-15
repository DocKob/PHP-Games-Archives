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
// File: index.php                                                                /
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
include('../includes/globals.php');
include('includes/manager.class.php');
session_start();
echo '<title>'.$game_name.' Game Manager</title>';
echo '<style>ul{list-style:none;}</style>';
$location = $_GET[loc];
$multi = $_GET[multi];
?>
<link rel="stylesheet" type="text/css" href="../interface/styles/colorpicker.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript" src="../interface/scripts/colorpicker.js"></script>
<script language="javascript" type="text/javascript">
<!--
function popitup(url) {
	newwindow=window.open(url,'name','height=540,width=450');
	if (window.focus) {newwindow.focus()}
	return false;
}
// -->
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
function previewPic(sel) 
{
	document.previewpic.src = "../" + sel.options[sel.selectedIndex].value;
}
</script>
<? if($multi=='true'){ ?>
<script type="text/javascript"> 
var ajax_load = "Loading...";
$('#map_editor').html(ajax_load).load('map_editor.php?loc=<? echo $location; ?>&multi=<? echo $_GET[multi]; ?>').fadeIn("slow");
var auto_refresh = setInterval(function ()
{
	$('#map_editor').load('map_editor.php?loc=<? echo $location; ?>&multi=<? echo $_GET[multi]; ?>').fadeIn("slow");
	$('#tile_in_use').load('tileInUse.php').fadeIn("slow");
}, 2000); // refresh interval
</script>
<? } else { ?>
<script type="text/javascript"> 
var ajax_load = "Loading...";
$('#map_editor').html(ajax_load).load('map_editor.php?loc=<? echo $location; ?>&multi=<? echo $_GET[multi]; ?>7fullscreen=<? echo $fullscreen; ?>').fadeIn("slow");
var auto_refresh = setInterval(function ()
{
	$('#map_editor').load('map_editor.php?loc=<? echo $location; ?>&multi=<? echo $_GET[multi]; ?>').fadeIn("slow");
}, 2000); // refresh interval
</script>
<? } ?>
<SCRIPT TYPE="text/javascript">
function dropdown(mySel)
{
var myWin, myVal;
myVal = mySel.options[mySel.selectedIndex].value;
if(myVal)
   {
   if(mySel.form.target)myWin = parent[mySel.form.target];
   else myWin = window;
   if (! myWin) return true;
   myWin.location = myVal;
   }
return false;
}
</SCRIPT>
<link href="<? echo $urldir; ?>manager/uploadify/uploadify.css" type="text/css" rel="stylesheet" />
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="<? echo $urldir; ?>manager/uploadify/swfobject.js"></script>
<script type="text/javascript" src="<? echo $urldir; ?>manager/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $('#file_upload').uploadify({
	'uploader'  : '/projects/game/manager/uploadify/uploadify.swf',
	'script'    : '/projects/game/manager/uploadify/uploadify.php',
	'cancelImg' : '/projects/game/manager/uploadify/cancel.png',
	'folder'    : '/projects/game/source/sounds',
	'auto'      : true,
	'multi'     : true
  });
});
</script>
<?

$manager = new manager();
// Manage actions
$action = $_GET[action];
if($action=="home"){
	echo $manager->console();
	$login='false';
} else if($action=="add_item"){
	echo $manager->console();
	echo $manager->add_item();
	$login='false';
} else if($action=="game_config"){
	echo $manager->console();
	echo $manager->game_config($game_name, $game_expansion, $game_description, $game_logo, $game_domain, $canvas_width, $canvas_height, $tile_width, $tile_height, $fullscreen, $mp3_theme, $ogg_theme, $avatar_height);
	$login='false';
} else if($action=="add_npc"){
	echo $manager->console();
	echo $manager->add_npc();
	$login='false';
} else if($action=="add_loc"){
	echo $manager->console();
	echo $manager->add_loc();
	$login='false';
} else if($action=="add_quest"){
	echo $manager->console();
	echo $manager->add_quest();
	$login='false';
} else if($action=="add_class"){
	echo $manager->console();
	echo $manager->add_class();
	$login='false';
} else if($action=="map_editor"){
	echo $manager->console();
	echo $manager->map_editor($canvas_width, $canvas_height, $tile_width, $tile_height, $fullscreen);
	$login='false';
} else if($action=="add_obj"){
	echo $manager->console();
	echo $manager->add_obj();
	$login='false';
} else if($action=="add_enemy"){
	echo $manager->console();
	echo $manager->add_enemy();
	$login='false';
} else if($action=="add_enemy_type"){
	echo $manager->console();
	echo $manager->add_enemy_type();
	$login='false';
} else if($action=="sounds"){
	echo $manager->console();
	echo $manager->sounds_manager();
	$login='false';
} else if($action=="add_skill"){
	echo $manager->console();
	echo $manager->add_skill();
	$login='false';
}
if($login=='false'){
	// do nothing
} else {
	if($_SESSION[admin]==1){
		echo $manager->console();
	} else {
?>
<form method="post" action="../do/login.php?manager=1">
Username: <input type="text" name="username"><br>
Password: <input type="password" name="password"><br>
<input type="submit" value="Login">
</form>
<? }} 
if($multi=='true'){
?>
<div style="position:absolute;z-index:999999;top:15%;right:1%;background:url('../interface/img/multi2.png');float:right;margin:30px;width:250px;padding:5px;">
<a href="#" onclick="hide_panel();">hide panel</a> / <a href="#" onclick="show_panel();">show panel</a>
</div>
<div id="tile_panel" style="position:absolute;z-index:99999;top:20%;right:1%;background:url('../interface/img/multi2.png');float:right;margin:30px;width:250px;height:300px;padding:5px;">
Select a tile to place:<br>
<?
if ($handle = opendir('../source/tiles')) {
	while (false !== ($file = readdir($handle))) {
		?><a href="#" onclick="setCookie('tile', 'source/tiles/<? echo $file; ?>', '1');"><img src='../source/tiles/<? echo $file; ?>' width='32' height='32' style='padding:4px;'></a><?
		$first_file=$file;
	}
	closedir($handle);
}
?>
<div id="tile_in_use" style="margin:5px;"></div>
</div>
<script language="javascript" type="text/javascript">
function setCookie(c_name,value,exdays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}
function hide_panel()
{
	document.getElementById('tile_panel').style.display='none';
}
function show_panel()
{
	document.getElementById('tile_panel').style.display='block';
}
</script>
<? } ?>