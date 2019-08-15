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

include('../classes/user.class.php');
include('../includes/connect.php');
include('../interface/header.php');

echo '<link href="../interface/themes/blue/styles.css" rel="stylesheet" type="text/css" />';
echo '<link href="../interface/styles/layout.css" rel="stylesheet" type="text/css" />';
echo '<div style="margin:30px;color:#000;">';
// Avatar upload process
$target = "../uploads/avatar/"; 
$target = $target . basename( $_FILES['avatar']['name']);
if(move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) 
{ 
	// SUCCESSFUL AVATAR UPLOAD!
} else { 
	//echo "<div class='status error'><p><img src='".$basedir."interface/img/icons/icon_error.png' /><span>Error!</span> No avatar uploaded</p></div>";
}

// This makes sure they did not leave any fields blank
 if (!$_POST['username'] | !$_POST['password'] | !$_POST['password2'] | !$_POST['email'] | !$_POST['status']) {
	die("<div class='status error'><p><img src='".$basedir."interface/img/icons/icon_error.png' /><span>Error!</span> You did not complete all of the required fields</p></div><a href='../register.php'>try again</a>");
}

// Checks if the username is in use
if (!get_magic_quotes_gpc()) {
	$_POST['username'] = addslashes($_POST['username']);
}
 $usercheck = $_POST['username'];
 $check = mysql_query("SELECT username FROM users WHERE username = '$usercheck'") 
or die(mysql_error());
 $check2 = mysql_num_rows($check);
 
// If the name exists it gives an error
 if ($check2 != 0) {
	die("<div class='status error'><p><img src='".$basedir."interface/img/icons/icon_error.png' /><span>Error!</span> Sorry, the username ".$_POST['username']." is already in use</p></div><a href='../register.php'>try again</a>");
}

// Checks if the email is in use
if (!get_magic_quotes_gpc()) {
	$_POST['email'] = addslashes($_POST['email']);
}
 $emailcheck = $_POST['email'];
 $check_email = mysql_query("SELECT email FROM users WHERE email = '$emailcheck'") 
or die(mysql_error());
 $check2_email = mysql_num_rows($check_email);
 
// If the name exists it gives an error
 if ($check2_email != 0) {
	die("<div class='status error'><p><img src='".$basedir."interface/img/icons/icon_error.png' /><span>Error!</span> Sorry, the email ".$_POST['email']." is already in use</p></div><a href='../register.php'>try again</a>");
}
// This makes sure both passwords entered match
if ($_POST['password'] != $_POST['password2']) {
	die("<div class='status error'><p><img src='".$basedir."interface/img/icons/icon_error.png' /><span>Error!</span> Your passwords did not match</p></div><a href='../register.php'>try again</a>");
}
// Encodes password
$_POST['password']=md5($_POST['password']);
if (!get_magic_quotes_gpc()) {
	$_POST['password'] = addslashes($_POST['password']);
	$_POST['username'] = addslashes($_POST['username']);
}
$user = $_POST['username'];
// Finally creates the user
$user = new User();
$user->process($_POST['username'],$_POST['password'],$_POST['email'],$_FILES['avatar']['name'],$_POST['status']);
$connect->CloseDB;
echo '</div>';
// finally for ID retrieval purposes only
?>