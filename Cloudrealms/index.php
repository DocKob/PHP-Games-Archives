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
// File: index.php                                                                /
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

$mode=$_GET[mode];
session_start();
if(!isset($_SESSION['is_logged_in'])) 
{
	Header('location: login.php');	
} else {
	include('classes/mmorpg.class.php');
	$mmorpg = new MMORPG();
	$location = $_GET[location]; // grabs current location
	include('includes/connect.php'); // connects game to database
	include('includes/load_player_data.php'); // grabs all player and character data into easy vars
	include('interface/header.php'); // loads scripts and interface
	include('chat.php'); // handles chat server
	include('includes/post_handler.php'); //handles all post to game index
	include('includes/location_handler.php'); // handles the games locations and towns, and loads towns and locations data
	// include('includes/sounds.php'); // handles game sounds
	include('interface/notifications.php'); // displays in-game notifications
	if($mode!='battle'){
		include('interface/user_box.php'); // displays players info box char data and user data
	}
	if($mode=='battle'){
		include('interface/battle.php'); // displays battle mode
	} else {
		include('interface/game_canvas.php'); // displays game canvas
	}
	include('includes/battle_handler.php'); // handles engaged battles and maybe more
	if($mode=='battle'){
		include('interface/user_box.php'); // displays players info box char data and user data
	}
	include('interface/toolbox.php'); // loads global chat and game tools icons
	include('interface/windows.php'); // handles all windows
	include('interface/events_handler.php'); // handles all windows
	include('includes/quest_handler.php'); //handles quest functions and active quest conditions
	include('includes/close_db.php'); // works to close all database connections
	include('interface/footer.php'); // end scripts
}
?>