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
// File: social.class.php                                                         /
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

class Social{

	function loadHeader()
	{
		echo "<script src='http://code.jquery.com/jquery-latest.js'></script>
			<link href='interface/styles/layout.css' rel='stylesheet' type='text/css' />
			<link rel='stylesheet' type='text/css' href='interface/styles/socialHub.css' />";
	}
	
	function displayHubMenu($user)
	{
		echo "<div id='nav'>
				<ul>
					<li><a href='socialHub.php?go=dashboard&user=$user'>Dashboard</a></li>
					<li><a href='messages.php?do=inbox&user=$user'>Messages</a></li>
					<li><a href='socialHub.php?go=auction&user=$user'>Auction</a></li>
					<li><a href='socialHub.php?go=river&user=$user'>River</a></li>
					<li><a href='socialHub.php?go=profile&user=$user&p=$user'>Your Profile</a></li>
					<li><a href='socialHub.php?go=search&user=$user'>Search</a></li>
				</ul>
			</div>";
	}
	
	function displayDashboard($user)
	{
		include_once("mmorpg.class.php");
		$mmorpg = new MMORPG();
		include_once("classes/character.class.php");
		$character = new Character();
		$char = $mmorpg->getCharacter($user);
		$userdata = $mmorpg->getUser($user);
		echo "<div id='profile_left'>
				<img src='$char[avatar]' width='180' height='180' class='hoverimg' alt='$char[name]' style='margin:7px;' />
				<p><br>Name: $char[name]</p>
				<p>Level: $char[level]</p>
				<p>Class: ".$char['class']."</p>
				<p>Money: $char[money]</p>
				<p>Age: $char[age]</p>
				<p>Zodiac: $char[zodiac]</p>
				<p>Gender: $char[gender]</p>
				<p>Martial Status: $char[martial]</p>
			</div>
			<div id='profile_right'>
				<form id='updateStatus'>
					<fieldset class='status'>";
						?><input type="text" class="box" value="Update Your Status..." id="status" name="status" onclick="this.value='';" onblur="this.value='Update Your Status...';" /><?
					echo "</fieldset>
				</form>
				<div id='player_status'></div>
			</div>
			<div id='profile_left' style='height:245px;'>
			<b style='float:left;'>Friends</b><br>";
			$friends = $character->getFriends($user);
			for($i=0; $i < count($friends); $i++)
			{
				echo "<a href='socialHub.php?p=$friends[$i]&user=$user&go=profile'><img src='".$character->getPlayerAvatar($friends[$i])."' width='60' height='60' class='hoverimg' alt='".$character->getPlayerName($friends[$i])."' style='margin:7px;' /></a>";
			}
			echo "</div>";
	}
	
	function displayProfile($user, $realuser)
	{
		include_once("mmorpg.class.php");
		$mmorpg = new MMORPG();
		include_once("classes/character.class.php");
		$character = new Character();
		$char = $mmorpg->getCharacter($user);
		$userdata = $mmorpg->getUser($user);
		echo "<div id='profile_left'>
				<img src='$char[avatar]' width='180' height='180' class='hoverimg' alt='$char[name]' style='margin:7px;' />
				<p><br>Name: $char[name]</p>
				<p>Level: $char[level]</p>
				<p>Class: ".$char['class']."</p>
				<p>Money: $char[money]</p>
				<p>Age: $char[age]</p>
				<p>Zodiac: $char[zodiac]</p>
				<p>Gender: $char[gender]</p>
				<p>Martial Status: $char[martial]</p>";
				$relationship = $character->getRelationship($user);
				if($relationship[0])
				{
					echo "<a href='socialHub.php?p=$relationship[0]&user=$realuser&go=profile'>".$character->getPlayerName($relationship[0])."</a> is in a relationship with <a href='socialHub.php?p=$relationship[1]&user=$realuser&go=profile'>".$character->getPlayerName($relationship[1])."</a>";
				}
			echo "</div>
			<div id='profile_right'>
				<div id='player_status'></div>
			</div>
			<div id='profile_left' style='height:245px;'>
			<b style='float:left;'>Friends</b><br>";
			$friends = $character->getFriends($user);
			for($i=0; $i < count($friends); $i++)
			{
				echo "<a href='socialHub.php?p=$friends[$i]&user=$realuser&go=profile'><img src='".$character->getPlayerAvatar($friends[$i])."' width='60' height='60' class='hoverimg' alt='".$character->getPlayerName($friends[$i])."' style='margin:7px;' /></a>";
			}
			echo "</div>";
			if($realuser!=$user)
			{
				echo "<div id='profile_right' style='height:245px;'>
						<b style='float:left;'>Actions</b><br>";
							for($i=0; $i < count($friends); $i++)
							{
								if($realuser==$friends[$i]||$user)
								{ 
									// is a friend or is self
								} else {
									echo "<button style='width:200px;padding:12px;'>Send Friend Request</button>";
								}
							}
							if(!$relationship[0])
							{
								echo "<button style='width:200px;padding:12px;'>Send Relationship Request</button>";
							}
							?><button style='width:200px;padding:12px;' onclick="location.href='messages.php?to=<? echo $user; ?>&from=<? echo $realuser; ?>&do=compose&user=<? echo $realuser; ?>';">Send Message</button><?
							if($character->isInParty($realuser)){
								echo "<button style='width:200px;padding:12px;' onclick='partyInvite($user, $realuser);'>Invite to Join Party</button>";
							}
							?><button style="width:200px;padding:12px;" onclick="location.href='tradeWithUser.php?g=<? echo $realuser; ?>&t=<? echo $user; ?>&hub=true';">Trade With Player</button><?
					echo "</div>";
			}
	}
	
	function displayAuction($user)
	{
		echo "No Auction";
	}
	
	function displayRiver($user)
	{
		// do
	}
	
	function displaySearch($user)
	{
		echo "No Search Yet";
	}
	
	function searchSocialHub($user)
	{
		// dude this will be an action
	}
}
?>