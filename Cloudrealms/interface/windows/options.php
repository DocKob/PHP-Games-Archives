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
// File: options.php                                                              /
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
<!-- options window -->
<div id="options" class="containerPlus draggable resizable {buttons:'m,c', skin:'default', width:'350', height:'200',title:'Options', closed:'true' }" style="top:10px; left:72%;color:#000;"><br>
<p><a href="#" onclick="cwindow('changepassword.php?username=<? echo $username; ?>');">Change Your Password</a></p><hr />
<p><a href="#" onclick="cwindow('update_email.php?username=<? echo $username; ?>');">Update Your Email</a></p><hr />
<p><a href="#">Upload New Avatar</a></p><hr />
<p><a href="#">Close Account</a></p><hr />
<p><a href="#">Privacy Settings</a></p><hr />
<p>Press F11 for Fullscreen</p><hr />
</div>
<!-- /options window -->