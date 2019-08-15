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
// File: header.php                                                               /
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
$dir = dirname(__FILE__);
$dir = substr($dir, 0, -9);
include($dir.'/includes/globals.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? echo $game_name; ?> - <? echo $game_expansion; ?></title>
<link href="interface/styles/layout.css" rel="stylesheet" type="text/css" />
<link href="interface/styles/wysiwyg.css" rel="stylesheet" type="text/css" />
<link href="interface/styles/mbContainer.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" media="all" href="interface/styles/chat.css" />
<link rel="stylesheet" type="text/css" href="interface/scripts/jquery.fancybox-1.3.4.css" media="screen" />
<link type="text/css" rel="stylesheet" media="all" href="interface/styles/screen.css" />
<link rel="stylesheet" type="text/css" href="interface/styles/scroller.css" />
<link rel="stylesheet" type="text/css" href="interface/styles/tipTip.css" />
<link rel="stylesheet" type="text/css" href="interface/styles/colorpicker.css" />
<link rel="stylesheet" type="text/css" href="interface/styles/loading.css" />
<!--[if lte IE 7]>
<link type="text/css" rel="stylesheet" media="all" href="interface/styles/screen_ie.css" />
<![endif]-->
<!-- Theme Start -->
<link href="interface/themes/blue/styles.css" rel="stylesheet" type="text/css" />
<!-- Theme End -->
<!-- Scripts -->
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="interface/scripts/jquery.fancybox-1.3.4.pack.js"></script>
<script src="interface/scripts/jquery.maskedinput-1.3.min.js" type="text/javascript"></script>
<script type="text/javascript" src="http://dwpe.googlecode.com/svn/trunk/_shared/EnhanceJS/enhance.js"></script>	
<script type="text/javascript" src="http://dwpe.googlecode.com/svn/trunk/charting/js/excanvas.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js"></script>
<script type="text/javascript" src="interface/scripts/jquery.wysiwyg.js"></script>
<script type="text/javascript" src="interface/scripts/visualize.jQuery.js"></script>
<script type="text/javascript" src="interface/scripts/functions.js"></script>
<script type="text/javascript" src="interface/scripts/jquery.contextmenu.r2.packed.js"></script>
<script type="text/javascript" src="interface/scripts/jquery.metadata.js"></script>
<script type="text/javascript" src="interface/scripts/mbContainer.js"></script>
<script type="text/javascript" src="interface/scripts/chat.js"></script>
<script type="text/javascript" src="interface/scripts/colorpicker.js"></script>
<script type="text/javascript" src="interface/scripts/jquery.tipTip.minified.js"></script>
<script type="text/javascript" src="interface/scripts/jquery.jcarousel.min.js"></script>
<script type="text/javascript" src="interface/scripts/jquery.jticker.js"></script>
<script type="text/javascript" src="interface/scripts/jquery.easydrag.js"></script>
<script type="text/javascript" src="interface/scripts/jquery.spritely-0.5.js" ></script>
<script type="text/javascript">
$(function(){
	// add drag and drop functionality to fancybox
	$("#fancy_outer").easydrag();
});
<!--
jQuery(document).ready(function(){
// Instantiate jTicker 
jQuery("#ticker").ticker({
	cursorList:  " ",
	rate:        10,
	delay:       4000
}).trigger("play").trigger("stop");

// Trigger events 
jQuery(".stop").click(function(){
	jQuery("#ticker").trigger("stop");
	return false;
});

jQuery(".play").click(function(){
	jQuery("#ticker").trigger("play");
	return false;
});

jQuery(".speedup").click(function(){
	jQuery("#ticker")
	.trigger({
		type: "control",
		item: 0,
		rate: 10,
		delay: 4000
	})
	return false;
});

jQuery(".slowdown").click(function(){
	jQuery("#ticker")
	.trigger({
		type: "control",
		item: 0,
		rate: 90,
		delay: 8000
	})
	return false;
});

jQuery(".next").live("click", function(){
	jQuery("#ticker")
	.trigger({type: "play"})
	.trigger({type: "stop"});
	return false;
});

jQuery(".style").click(function(){
	jQuery("#ticker")
	.trigger({
		type: "control",
		cursor: jQuery("#ticker").data("ticker").cursor.css({width: "4em", background: "#efefef", position: "relative", top: "1em", left: "-1em"})
	})
	return false;
});
});
//-->
</script>
<script>
jQuery(document).ready(function() {
    jQuery('#game-canvas').jcarousel();
});
jQuery(function($){
   $("#character-age").mask("9999-99-99",{placeholder:" "});
});
function toggle_chat() {
	var ele = document.getElementById("chat");
	var text = document.getElementById("toggle-chat");
	if(ele.style.display == "block") {
    		ele.style.display = "none";
		text.innerHTML = "<img src='interface/icons/bubble_48.png'>";
  	}
	else {
		ele.style.display = "block";
		text.innerHTML = "<img src='interface/icons/bubble_48.png'>";
	}
} 
function toggle_stats() {
	var ele = document.getElementById("char");
	var text = document.getElementById("toggle-stats");
	if(ele.style.display == "block") {
    		ele.style.display = "none";
		text.innerHTML = "<img src='interface/icons/statistics_48.png'>";
  	}
	else {
		ele.style.display = "block";
		text.innerHTML = "<img src='interface/icons/statistics_48.png'>";
	}
} 
function hide_stats()
{
	document.getElementById('char').style.display='none';
}
function toggle_statuses() {
	var ele = document.getElementById("statusx");
	var text = document.getElementById("toggle-status");
	if(ele.style.display == "block") {
    		ele.style.display = "none";
		text.innerHTML = "Status";
  	}
	else {
		ele.style.display = "block";
		text.innerHTML = "Status";
	}
} 
$(function(){
  $(".containerPlus").buildContainers({
	containment:"document",
	elementsPath:"interface/elements/",
	onClose:function(o){},
	onIconize:function(o){},
	effectDuration:200
  });

  if ($("#demoContainer").mb_getState("closed")){
	$('#close').fadeIn();$('#actions').fadeIn(); $("#open").hide(); $('#open_change').hide();
  }
  if ($("#demoContainer").mb_getState("closed")){
	$('#close2').fadeIn();$('#actions2').fadeIn(); $("#open2").hide(); $('#open_change').hide();
  }
  if ($("#demoContainer").mb_getState("closed")){
	$('#close3').fadeIn();$('#actions3').fadeIn(); $("#open3").hide(); $('#open_change').hide();
  }
  if ($("#demoContainer").mb_getState("closed")){
	$('#close4').fadeIn();$('#actions4').fadeIn(); $("#open4").hide(); $('#open_change').hide();
  }
  if ($("#demoContainer").mb_getState("closed")){
	$('#close5').fadeIn();$('#actions5').fadeIn(); $("#open5").hide(); $('#open_change').hide();
  }
  if ($("#demoContainer").mb_getState("closed")){
	$('#close6').fadeIn();$('#actions6').fadeIn(); $("#open6").hide(); $('#open_change').hide();
  }
  if ($("#demoContainer").mb_getState("closed")){
	$('#close7').fadeIn();$('#actions7').fadeIn(); $("#open7").hide(); $('#open_change').hide();
  }
});
$(function(){
	$(".gameItem").tipTip();
	$(".npc").tipTip();
});
$(document).ready(function() {
	$("a#imgx").fancybox({
		'overlayShow'	: false,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic'
	});
	$("#player-stats").fancybox({
		'width'				: '25%',
		'height'			: '65%',
		'autoScale'			: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});
});	
function cwindow(href, width, height)
{
	if (width == null){
	   width = 60;
	}
	if (height == null){
	   height = 45;
	}
	$.fancybox({
		'width': width+'%',
		'height': height+'%',
		'autoScale': true,
		'transitionIn': 'fade',
		'transitionOut': 'fade',
		'type': 'iframe',
		'hideOnContentClick': false,
		'href': href
	});
}
function setIntervalX(callback, delay, repetitions) {
    var x = 0;
    var intervalID = window.setInterval(function () {

       callback();

       if (++x === repetitions) {
           window.clearInterval(intervalID);
       }
    }, delay);
}
$(document).ready(function() {
	$('span.npc').contextMenu('npcMenu', {
		bindings: {
			'talk': function(t) {
				cwindow('talkToNPC.php?npc='+t.id+'');
			},
			'quest': function(t) {
				cwindow('questFromNPC.php?npc='+t.id+'');
			},
			'trade': function(t) {
				cwindow('tradeWithNPC.php?npc='+t.id+'');
			}
		}
	});
	$('span.enemy').contextMenu('enemyMenu', {
		bindings: {
			'engage': function(t) {
				cwindow('engageEnemy.php?enemy='+t.id+'&loc=<? echo $location; ?>');
			},
			'stats': function(t) {
				cwindow('viewEnemyStats.php?enemy='+t.id+'');
			}
		}
	});
	$('span.canvas').contextMenu('canvasMenu', {
		bindings: {
			'bazaar': function(t) {
				cwindow('#');
			},
			'map': function(t) {
				cwindow('mapViewer.php',50,70);
			},
			'social': function(t) {
				cwindow('socialHub.php?go=dashboard&user=<? echo $userID; ?>', 100, 100);
			}
		}
	});
	$('span.inventory').contextMenu('itemMenu', {
		bindings: {
			'sell': function(t) {
				cwindow('#');
			},
			'drop': function(t) {
				cwindow('#');
			},
			'inspect': function(t) {
				cwindow('#');
			}
		}
	});
});
</script>
<div class="contextMenu" id="enemyMenu" style="display:none;">
  <ul>
	<li id="engage">Engage Enemy</li>
	<li id="stats">View Stats</li>
  </ul>
</div>
<div class="contextMenu" id="npcMenu" style="display:none;">
  <ul>
	<li id="talk">Talk</li>
	<li id="quest">Quest</li>
	<li id="trade">Trade</li>
  </ul>
</div>
<div class="contextMenu" id="canvasMenu" style="display:none;">
  <ul>
	<li id="bazaar">Your Bazaar</li>
	<li id="social">Socialize</li>
	<li id="map">View Map</li>
  </ul>
</div>
<div class="contextMenu" id="itemMenu" style="display:none;">
  <ul>
	<li id="sell">Sell</li>
	<li id="drop">Drop</li>
	<li id="inspect">Inspect</li>
  </ul>
</div>
<style type="text/css" media="screen, projection">
#ticker
{height: 12em; padding: 0.6em 0; margin: 0 0 1.8em 0; position: relative;}
#ticker .cursor
{display: inline-block; background: #565c61; width: 0.6em; height: 1em; text-align: center;}
#ticker p
{margin-bottom: 0.8em;}
#ticker code
{margin: 0.4em 0.4em; display: block;}
#ticker .next 
{position: absolute; bottom: 1em;}
</style>
</head>
<body onload="javascript:startChat();init();">
<? 
$loadFile = $basedir."index.php";
if($_SERVER[SCRIPT_FILENAME]==$loadFile){ 
	if($mode!='battle'){
?>
<div id="loading" class="loading-invisible">
	<p>[cloudRealms Game Engine 1.0] <br>Game Loading...</p>
</div>
<script type="text/javascript">
  document.getElementById("loading").className = "loading-visible";
  var hideDiv = function(){document.getElementById("loading").className = "loading-invisible";};
  var oldLoad = window.onload;
  var newLoad = oldLoad ? function(){hideDiv.call(this);oldLoad.call(this);} : hideDiv;
  window.onload = newLoad;
</script>
<? }} ?>