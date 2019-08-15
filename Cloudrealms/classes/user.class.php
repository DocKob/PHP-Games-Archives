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
// File: user.class.php                                                           /
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

class User {

    function createUser()
    {
        // start here
    }
	
	public function getCharacterID($charID) {
		$this->characterID = $charID;
	}
	
	public function forgotPassword($mail)
	{
		//Iind user data in database
		$newpassword = $this->rand_string(20);
		$encodedpassword = md5($newpassword);
		$query = ("UPDATE users SET password = '$encodedpassword' WHERE email = '$mail'; ");
		mysql_query($query) or die ("MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$query\n<br>");
		
		$to = $mail;
		$subject = "Feeder Story Account Update: New Password";
		$message = "This is a message from Feeder Story MMORPG. Here is your new password ----> $newpassword";
		$from = "no-reply@feederstory.co.cc";
		$headers = "From: $from";
		return mail($to,$subject,$message,$headers);
		echo "Mail Sent.";
		
	}
	
	public function changePassword($newpassword, $user)
	{
		// make sure user is logged in
		if(!$_SESSION[username] = ""){
			$encodednewpassword = md5($newpassword);
			$q = ("UPDATE users SET password = '$encodednewpassword' WHERE username = '$user'");
			mysql_query($q) or die ("MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$query\n<br>");
			echo '<center><img src="../interface/img/ajax-loader.gif"><br>';
			echo 'Your password has been changed!<br>';
			echo '<a href="../do/logout.php" target="_parent">click here to continue...</a>';
		} else {
			echo "You must be logged in to change your password, make sense?<br><br>";
		}
	}
	
	public function updateStatus($new_status, $user)
	{
		$q = ("INSERT INTO statuses (user, status) VALUES ('$user', '$new_status')");
		mysql_query($q) or die ("MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$query\n<br>");
	}
	
	public function updateEmail($new_email, $user)
	{
		$q = ("UPDATE users SET email = '$new_email' WHERE username = '$user'");
		mysql_query($q) or die ("MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$query\n<br>");
		echo '<center><img src="../interface/img/ajax-loader.gif"><br>';
		echo 'Your email has been updated!<br>';
	}
	
	public function rand_string( $length )
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	
		$size = strlen( $chars );
		for( $i = 0; $i < $length; $i++ )
		{
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}
		return $str;
	}
}
?>