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
// File: test.php                                                                 /
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

include("interface/header.php"); ?>
<div id="player" style="height:120px;width:70px;overflow:hidden;z-index:99;background:transparent url('source/avatars/full_walk.png');"></div>
<button onclick="up();" style="float:left;">u</button>
<button onclick="down();" style="float:left;">d</button>
<button onclick="right();" style="float:left;">r</button>
<button onclick="left();" style="float:left;">l</button>
<script>
$("#player").sprite({fps: 7, no_of_frames: 4});
function right()
{
	document.getElementById("player").style.backgroundPosition="0px -240px";
}
function up()
{
	document.getElementById("player").style.backgroundPosition="0px -360px";
}
function down()
{
	document.getElementById("player").style.backgroundPosition="0px -0px";
}
function left()
{
	document.getElementById("player").style.backgroundPosition="0px -120px";
}
</script>
