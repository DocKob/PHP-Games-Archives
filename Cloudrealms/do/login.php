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
// File: login.php                                                                /
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

include('../includes/connect.php');
session_start();
if(!isset($_SESSION['is_logged_in'])) {
	// not logged in
} else { 
    Header('Location: ../index.php');
}
// Login message
$message="";
////// Login Section.
function clean_data($string) {
	if (get_magic_quotes_gpc()) {
		$string = stripslashes($string);
	}
		$string = strip_tags($string);
	return mysql_real_escape_string($string);
}
$manager = $_GET[manager];
$username=clean_data($_POST['username']);
$password=md5($_POST['password']);
// Check matching of username and password.
$result=mysql_query("SELECT * FROM users WHERE username = '$username' AND password = '$password'");
if(mysql_num_rows($result) > 0) {
    $_SESSION['is_logged_in'] = 1;
	$_SESSION['username'] = $username;
	$row = mysql_fetch_assoc($result);
	$_SESSION['userid'] = $row['id'];
	$_SESSION['admin'] = $row['admin'];
	if(!$manager=="1"){
		redirect("../index.php"); // Re-direct to index.php
	} else {
		redirect("../manager/index.php?action=home"); // redirect to manager 
	}
	exit;
} else { // If not match.
	$message='error1';
	header("location: ../login.php?message=".$message."");
}
// End Login authorize check.
// redirect function
function redirect($page)
{
	if($_SERVER['HTTP_REFERER'] != '')
	{
		header('Location: '.$_SERVER['HTTP_REFERER']);
	}
	else
	{
		header ("Location: $page");
	}
}
?>
