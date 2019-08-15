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
// File: placeTile.php                                                            /
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

include("../includes/connect.php");
$col = $_GET[col];
$row = $_GET[row];
//$tile = $_GET[tile];
$loc = $_GET[loc];
$tile = $_GET[tile];
$do = $_GET['do'];
if($do=='update')
{
	mysql_query("UPDATE tiles SET bg = '$tile' WHERE row = '$row' AND col = '$col'");
} else {
	mysql_query("INSERT INTO tiles (bg, row, col, location) VALUES ('$tile', '$row', '$col', '$loc')") or die (mysql_error());
}
$return_arr = array();
$return_arr["col"] = $_POST['col'];
$return_arr["row"] = $_POST['row'];
echo json_encode($return_arr);
?>