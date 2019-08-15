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
// File: changepassword.php                                                       /
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

include('interface/header.php');
$username = $_GET[username];
?>
<div style="margin:30px;color:#000;">
<? if($message == ""){ ?>
<? } else { ?>
	<div class='status error'><p><img src='interface/img/icons/icon_error.png' /><span>Error!</span> <? echo $message; ?> </p></div>
<? } ?>
<form method="post" action="do/changepassword.php?username=<? echo $username; ?>">
	<p>
		<label for="textfield"><strong>Enter a new password:</strong></label>
		<input type="password" id="textfield" class="inputbox" name="newpassword" /> <br />
		<input type="submit" name="changepassword" class="btn" class="submit" value="Change your password!" /><br />
	</p>
</form>