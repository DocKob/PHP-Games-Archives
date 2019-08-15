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
// File: toolbox.php                                                              /
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

?>
<div style="padding:30px;left:0;bottom:0;position:absolute;display:block;">
<? include('includes/chat_server.php'); ?>
<table><tr>
<td><center><a id="toggle-chat" href="javascript:toggle_chat();<? if($mode=='battle'){ ?>hide_stats();<? } ?>"><img src="interface/icons/bubble_48.png"></a><br>World Chat
</center></td>
<td><center><a href="index.php?location=home"><img src="interface/icons/home_48.png"></a><br>Your Home
</center></td>
<td><center>
<a href="javascript:void(0)" id="close" style="display:none;" onclick="$('#options').mb_close(); $('#actions').fadeOut(); $('#open').fadeIn(); $(this).hide();"><img src="interface/icons/gear_48.png"></a>
<a href="javascript:void(0)" id="open" onclick="$('#options').mb_open(); $('#close').fadeIn();$('#actions').fadeIn(); $(this).hide();"><img src="interface/icons/gear_48.png"></a><br>Options
</center></td>
<td><center>
<a href="javascript:void(0)" id="close2" style="display:none;" onclick="$('#inventory').mb_close(); $('#actions').fadeOut(); $('#open2').fadeIn(); $(this).hide();"><img src="interface/icons/briefcase_48.png"></a>
<a href="javascript:void(0)" id="open2" onclick="$('#inventory').mb_open(); $('#close2').fadeIn();$('#actions').fadeIn(); $(this).hide();"><img src="interface/icons/briefcase_48.png"></a><br>Inventory
</center></td>
<td><center>
<a href="javascript:void(0)" id="close4" style="display:none;" onclick="$('#online').mb_close(); $('#actions').fadeOut(); $('#open4').fadeIn(); $(this).hide();"><img src="interface/icons/user_48.png"></a>
<a href="javascript:void(0)" id="open4" onclick="$('#online').mb_open(); $('#close4').fadeIn();$('#actions').fadeIn(); $(this).hide();"><img src="interface/icons/user_48.png"></a><br>Players Online
</center></td>
<td><center>
<a id="toggle-stats" href="javascript:toggle_stats();"><img src="interface/icons/statistics_48.png"></a><br>Your Stats
</center></td>
<td><center>
<a href="javascript:void(0)" id="close5" style="display:none;" onclick="$('#npcz').mb_close(); $('#actions').fadeOut(); $('#open5').fadeIn(); $(this).hide();"><img src="interface/icons/info_48.png"></a>
<a href="javascript:void(0)" id="open5" onclick="$('#npcz').mb_open(); $('#close5').fadeIn();$('#actions').fadeIn(); $(this).hide();"><img src="interface/icons/info_48.png"></a><br>NPC
</center></td>
<td><center>
<a href="javascript:void(0)" id="close6" style="display:none;" onclick="$('#party').mb_close(); $('#actions').fadeOut(); $('#open6').fadeIn(); $(this).hide();"><img src="interface/icons/flag_48.png"></a>
<a href="javascript:void(0)" id="open6" onclick="$('#party').mb_open(); $('#close6').fadeIn();$('#actions').fadeIn(); $(this).hide();"><img src="interface/icons/flag_48.png"></a><br>Party
</center></td>
<td><center>
<a href="javascript:void(0)" id="close7" style="display:none;" onclick="$('#quest_panel').mb_close(); $('#actions').fadeOut(); $('#open7').fadeIn(); $(this).hide();"><img src="interface/icons/clipboard_48.png"></a>
<a href="javascript:void(0)" id="open7" onclick="$('#quest_panel').mb_open(); $('#close7').fadeIn();$('#actions').fadeIn(); $(this).hide();"><img src="interface/icons/clipboard_48.png"></a><br>Quest Panel
</center></td>
</tr></table>
</div>
</div>