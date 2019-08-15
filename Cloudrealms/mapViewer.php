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
// File: mapViewer.php                                                            /
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
<!DOCTYPE html>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" src="interface/scripts/jqueryui.js" ></script>
	<!--<script type="text/javascript" src="jquery.js" ></script>-->
	<script type="text/javascript" src="interface/scripts/jquery.mousewheel.min.js" ></script>
	<script type="text/javascript" src="interface/scripts/jquery.iviewer.js" ></script>
	<script type="text/javascript">
	var $ = jQuery;
	$(document).ready(function(){
		  var iviewer = {};
		  $("#viewer").iviewer(
		  {
			  src: "source/backgrounds/map.jpg",
			  initCallback: function()
			  {
				iviewer = this;
			  }
		  });
	});
	</script>
	<link rel="stylesheet" type="text/css" href="interface/styles/jquery.iviewer.css" />
	<style>
		.viewer
		{
			width: 100%;
			height: 400px;
			position: relative;
		}
		
		.wrapper
		{
			overflow: hidden;
		}
	</style>
	<body>
		<div class="wrapper">
			<div id="viewer" class="viewer"></div>
		</div>
	</body>
</html>