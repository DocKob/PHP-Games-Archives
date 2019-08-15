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
// File: playerStats.php                                                          /
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
include('includes/connect.php');
$player = $_GET['player'];

$grabTheirUserID = mysql_query("SELECT * FROM users WHERE username = '$player'");
while($row = mysql_fetch_array($grabTheirUserID))
{
	$_userid = $row['id'];
}
$grabTheirCharacterData = mysql_query("SELECT * FROM characters WHERE userID = '$_userid'");
while($row = mysql_fetch_array($grabTheirCharacterData))
{
	include('classes/character.class.php');
	$character = new Character();
	$name = $row['name'];
	$level = $row['level'];
	$money = $row['money'];
	$exp = $row['exp'];
	$age = $character->calculateCharacterAge($row['age']);
	$knowledge = $row['knowledge'];
	$strength = $row['strength'];
	$charm = $row['charm'];
	$zodiac = $row['zodiac'];
	$avatar = $row['avatar'];
	$martial = $row['martial'];
	$class = $row['class'];
	$gender = $row['gender'];
}
?>
<!-- character box -->
<div style="padding:10px;margin:5px;width:250px;background:#fff;color:#000;"> 
	<h1><? echo $name; ?></h1>
	<a href="<? echo $avatar; ?>" id="imgx"><img src="<? echo $avatar; ?>" width="80" height="80" class="hoverimg" style="margin:8px;" alt="Avatar" /></a>
	<p>Name: <? echo $name; ?></p>
	<p>Level: <? echo $level; ?></p>
	<p>Money: <? echo $money; ?></p>
	<p>Age: <? echo $age; ?></p>
	<p>Zodiac: <? echo $zodiac; ?></p>
	<p>Gender: <? echo $gender; ?></p>
	<p>Martial Status: <? echo $martial; ?></p>
	<hr />
	<h3>Stats</h3>
	<p>Class: <? echo $class; ?></p>
	<p>Strength: <? echo $strength; ?></p>
	<p>Charm: <? echo $charm; ?></p>
	<p>Knowledge: <? echo $knowledge; ?></p>
	<div class="usagebox"><div class="midbar" style="width: <? echo $exp; ?>%;padding:2px;">EXP:<? echo $exp; ?>%</div></div>
</div>
<!-- /character box -->