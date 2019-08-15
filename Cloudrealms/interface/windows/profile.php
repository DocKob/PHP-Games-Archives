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
// File: profile.php                                                              /
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

include("classes/profile.class.php");
$profile = new Profile();
?>
<!-- profile window -->
<div id="profile" class="containerPlus draggable resizable {buttons:'m,c', skin:'default', width:'470', height:'380',title:'Profile', closed:'true' }" style="top:10px; left:25%;color:#000;"><br>
<img src="uploads/avatar/<? echo $useravatar; ?>" width="130" height="130" class="hoverimg" alt="Avatar" style="margin:7px;" />
<p><br>Username: <? echo $username; ?></p>
<p>Email: <? echo $email; ?></p>
<p><a href="#" onclick="cwindow('checkRequests.php?read=inbox&user=<? echo $username; ?>');">Check Your Request</a></p>
<? 
$blurb = $profile->display_blurb($userID);
echo "<br><b>Your Blurb:</b><br>";
echo $blurb; 
?>
</div>
<!-- /profile window -->