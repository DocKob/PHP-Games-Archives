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
// File: footer.php                                                               /
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
<script type="text/javascript">
// STATUS UPDATE CODE
$(function(){
	$("#updateStatus").submit(function(){		
		$.post("do/new_status.php?username=<? echo $username; ?>", $("#updateStatus").serialize(),
		function(data){
				$("#new_status").html("<p style='padding:5px;margin:2px;color:#fff;'><span><? echo $username; ?>:</span> " + data.status + "</p>"); 
		}, "json");
		return false;
	});
});
</script>
<script type="text/javascript"> 
var ajax_load = "<img src='interface/img/ajax-loader.gif' alt='loading...' />";
//  load() functions  
var auto_refresh = setInterval(function ()
{
	$('#other_status').load('includes/statuses.php').fadeIn("slow");
	$('#handler').load('includes/events_handler.php?id=<? echo $userID; ?>').fadeIn("slow");
	$('#notifications').load('includes/notifications.php?user=<? echo $userID; ?>').fadeIn("slow");
	$('#portalChecker').load('includes/portalChecker.php?char=<? echo $charID; ?>&loc=<? echo $location; ?>');
}, 1000); // refresh interval
</script>