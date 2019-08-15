<?php
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
// File: getChat.php                                                              /
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


//Send some headers to keep the user's browser from caching the response.
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=utf-8");

require('database.php');

//Check to see if a message was sent.
if(isset($_POST['message']) && $_POST['message'] != '') {
	$sql = "INSERT INTO message(chat_id, user_id, user_name, message, post_time) VALUES (" . 
			db_input($_GET['chat']) . ", 1, '" . db_input($_POST['name']) . 
			"', '" . db_input($_POST['message']) . "', NOW())";
	db_query($sql);
}
//Check to see if a reset request was sent.
if(isset($_POST['action']) && $_POST['action'] == 'reset') {
	$sql = "DELETE FROM message WHERE chat_id = " . db_input($_GET['chat']);
	db_query($sql);
}

//Create the XML response.
$xml = '<?xml version="1.0" ?><root>';
//Check to ensure the user is in a chat room.
if(!isset($_GET['chat'])) {
	$xml .='Your are not currently in a chat session.  <a href="">Enter a chat session here</a>';
	$xml .= '<message id="0">';
	$xml .= '<user>Admin</user>';
	$xml .= '<text>Your are not currently in a chat session.  &lt;a href=""&gt;Enter a chat session here&lt;/a&gt;</text>';
	$xml .= '<time>' . date('h:i') . '</time>';
	$xml .= '</message>';
} else {
	$last = (isset($_GET['last']) && $_GET['last'] != '') ? $_GET['last'] : 0;
	$sql = "SELECT message_id, user_name, message, date_format(post_time, '%h:%i') as post_time" . 
		" FROM message WHERE chat_id = " . db_input($_GET['chat']) . " AND message_id > " . $last;
	$message_query = db_query($sql);
	//Loop through each message and create an XML message node for each.
	while($message_array = db_fetch_array($message_query)) {
		$xml .= '<message id="' . $message_array['message_id'] . '">';
		$xml .= '<user>' . htmlspecialchars($message_array['user_name']) . '</user>';
		$xml .= '<text>' . htmlspecialchars($message_array['message']) . '</text>';
		$xml .= '<time>' . $message_array['post_time'] . '</time>';
		$xml .= '</message>';
	}
}
$xml .= '</root>';
echo $xml;
?>