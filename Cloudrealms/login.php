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

include('includes/globals.php');
session_start();
if(isset($_SESSION['is_logged_in'])) 
{
	Header('location: index.php');
}
$message=$_GET['message'];
if($message == "error1"){
	$message = "Incorrect Login Credentials";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><? echo $game_name; ?> - <? echo $game_expansion; ?></title>
<link href="interface/styles/layout.css" rel="stylesheet" type="text/css" />
<link href="interface/styles/login.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="interface/scripts/jquery.fancybox-1.3.4.css" media="screen" />
<!-- Theme Start -->
<link href="interface/themes/blue/styles.css" rel="stylesheet" type="text/css" />
<!-- Theme End -->
<!-- Scripts -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript" src="interface/scripts/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#goregister").fancybox({
		'width'				: '73%',
		'height'			: '60%',
		'autoScale'			: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});
	$("#gogetnewpassword").fancybox({
		'width'				: '40%',
		'height'			: '30%',
		'autoScale'			: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});
});
</script>
<style>
.shadow 
{
	-moz-box-shadow: 9px 9px rgba(0,0,0,0.5);
	-webkit-box-shadow: 9px 9px rgba(0,0,0,0.5);
	box-shadow: 9px 9px rgba(0,0,0,0.5);
}
</style>
</head>
<body>
<div style="margin-top:25px;margin-bottom:-40px;background:#4EFF47;border-top:#07D100 solid 1px;border-bottom:#07D100 solid 1px;margin-left:auto;margin-right:auto;padding:15px;color:#000;width:15%;">For demo access use,<p>username: demo<br>password: demo</p></div>
	<div id="logincontainer">
	<? if($message == ""){ ?>
	<? } else { ?>
		<div class='status error' style="color:#000;"><p><img src='interface/img/icons/icon_error.png' /><span>Error!</span> <? echo $message; ?> </p></div>
	<? } ?>
    	<div id="loginbox" class="shadow">
        	<div id="loginheader">
            	<img src="<? echo $game_logo; ?>" alt="<? echo $game_name; ?> Login" />
            </div>
            <div id="innerlogin">
            	<form method="post" name="login" action="do/login.php">
                	<p>Enter your username:</p>
                	<input type="text" name="username" class="logininput" />
                    <p>Enter your password:</p>
                	<input type="password" name="password" class="logininput" />
                   	<input type="submit" class="loginbtn" name="login" value="Submit" /><br />
					<p><a href="characterCreation.php" id="goregister">Register!</a></p><br />
                    <p><a href="forgotpassword.php" id="gogetnewpassword" title="Recover Your Password">Forgotten Password?</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
<audio preload="auto" autoplay="autoplay" loop="loop">
	<source src="<? echo $ogg_theme; ?>" />
	<source src="<? echo $mp3_theme; ?>" />
</audio>
</html>