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
// File: socialHub.php                                                            /
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

include("includes/connect.php");
include_once("classes/mmorpg.class.php");
include("classes/social.class.php");
$mmorpg = new MMORPG();
$social = new Social();
$x = $_GET[go];
$user = $_GET[user];
$userdata = $mmorpg->getUser($user);
echo $social->loadHeader();
echo $social->displayHubMenu($user);
if($x=="dashboard")
{
	$social->displayDashboard($user);
} else if($x=='profile'){
	$social->displayProfile($_GET[p], $user);
	$userdata = $mmorpg->getUser($_GET[p]);
}
?>
<script type="text/javascript">
// JAVASCRIPTS
$(function(){
	$("#updateStatus").submit(function(){		
		$.post("do/new_status.php?username=<? echo $userdata[name]; ?>", $("#updateStatus").serialize(),
		function(data){
				$("#new_status").html("<p style='padding:5px;margin:2px;color:#fff;'><span><? echo $userdata[name]; ?>:</span> " + data.status + "</p>"); 
		}, "json");
		return false;
	});
});
var auto_refresh = setInterval(function ()
{
	$("#player_status").load("includes/playerStatus.php?user=<? echo $userdata[name]; ?>").fadeIn("slow");
}, 1000); // refresh interval
function relationshipRequest(to, from)
{
	$.post("do/newRequest.php");
}
function partyInvite(to, from)
{
	$.post("do/partyActions.php?action=invite&to="+to+"&from="+from);
}
</script>
