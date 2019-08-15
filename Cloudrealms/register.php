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
// File: register.php                                                             /
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
?>
<div style="margin:30px;color:#000;">
<h2>Register an account</h2><br />
<form enctype='multipart/form-data' name="register" action="do/register.php" method="post">
	<p>
		<label for="textfield"><strong>Username:</strong></label>
		<input type="text" id="textfield" class="inputbox" name="username" /> <br />
	</p>
	<p>
		<label for="textfield"><strong>Password:</strong></label>
		<input type="password" id="textfield" class="inputbox" name="password" /> <br />
	</p>
	<p>
		<label for="textfield"><strong>Confirm Password:</strong></label>
		<input type="password" id="textfield" class="inputbox" name="password2" /> <br />
	</p>
	<p>
		<label for="textfield"><strong>Email:</strong></label>
		<input type="text" id="textfield" class="inputbox" name="email" /> <br />
	</p>
	<p>
		<label for="textfield"><strong>Avatar:</strong></label>
		<input type="file" id="uploader" name="avatar" /> <br />
	</p>
	<p>
		<label for="textfield"><strong>Status:</strong></label>
		<input type="text" id="textfield" class="inputbox" name="status" /> <br />
	</p>
	<input type="submit" value="Submit" class="btn" name="register" />
</form>
</div>