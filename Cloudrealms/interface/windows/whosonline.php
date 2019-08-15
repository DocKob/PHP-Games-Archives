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
// File: whosonline.php                                                           /
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
<!-- whosonline window -->
<div id="online" class="containerPlus draggable resizable {buttons:'m,c', skin:'default', width:'350', height:'200',title:'Players Online', closed:'true' }" style="top:430px; left:72%;color:#000;"><br>
<?php
include_once('classes/usersOnline.class.php');
$players_online = new usersOnline();
echo "<div id='success_invite'></div>";
if (count($players_online->error) == 0) {

    if ($players_online->count_users() == 1) {
        echo "There is " . $players_online->count_users() . " player online";
    }
    else {
        echo "There are " . $players_online->count_users() . " players online";
    }
}
else {
    echo "<b>Users online class errors:</b><br /><ul>\r\n";
    for ($i = 0; $i < count($players_online->error); $i ++ ) {
        echo "<li>" . $players_online->error[$i] . "</li>\r\n";
    }
    echo "</ul>\r\n";

}
echo "<br><br>";
echo $players_online->displayPlayers($username, $partyID);
?>
</div>
<script type="text/javascript">
// PARTY INVITE
function party_invite(to, from)
{
	$.post("do/partyActions.php?action=invite&to="+to+"&from="+from, $("#partyInvite").serialize(),
	function(data){
			$("#success_invite").html(data.success); 
	}, "json");
	return false;
}
var auto_refresh = setInterval(function ()
{
	$('#show_inventory').load('includes/show_inventory.php?char=<? echo $char_id; ?>&loc=<? echo $location; ?>&inv=<? echo $inventoryID; ?>').fadeIn("slow");
}, 2000); // refresh interval
</script>
<!-- /whosonline window -->