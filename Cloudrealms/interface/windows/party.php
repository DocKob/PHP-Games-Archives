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
// File: party.php                                                                /
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
<!-- party window -->
<div id="party" class="containerPlus draggable resizable {buttons:'m,c', skin:'default', width:'350', height:'200',title:'Party', closed:'true' }" style="top:220px;left:72%;color:#000;"><br>
<ul>
<?
if($partyID==0){
?>
Start a party: <form method='post' action='<? echo $_SERVER[REQUEST_URI]; ?>'><input type='text' onClick="javascript:this.value='';" style="width:80%;"name='party_name' value='Enter a name for your party' /> <input type='submit' value='Go!' name='start_party' /></form>
<hr>
<a href="#" onclick="cwindow('partyFinder.php');">Find a party</a>
<hr>
<? } else { ?>
<?
$getParty = mysql_query("SELECT * FROM party WHERE id = '$partyID'");
while($row=mysql_fetch_array($getParty))
{
	$party_name=$row[party_name];
	$leader=$row[leader];
	$members[0]=$row[member1];
	$members[1]=$row[member2];
	$members[2]=$row[member3];
	$members[3]=$row[member4];
}
function getMemberName($userid)
{
	$getCharacter = mysql_query("SELECT * FROM characters WHERE id = '$userid'");
	while($row = mysql_fetch_array($getCharacter))
	{
		$member_name = $row[name];
	}
	echo $member_name;
}
?>
<strong><? echo $party_name; ?></strong> - <a href="index.php?location=<? echo $location; ?>&action=disband_party">Disband party</a>
<hr>
<b>Members in your party:</b><hr>
<a href=""><? getMemberName($leader); ?></a> (leader)<br>
<? foreach($members as $member){ 
	getMemberName($member);
	echo "<br>";
}
?>

<? } ?>
</div>
<!-- /party window -->