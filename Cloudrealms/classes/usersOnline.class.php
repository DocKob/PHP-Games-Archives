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
// File: usersOnline.class.php                                                    /
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


class usersOnline {

	var $timeout = 600;
	var $count = 0;
	var $error;
	var $i = 0;
	
	function usersOnline () {
		$this->timestamp = time();
		$this->ip = $this->ipCheck();
		$this->new_user();
		$this->delete_user();
		$this->count_users();
	}
	
	function ipCheck() {
		if (getenv('HTTP_CLIENT_IP')) {
			$ip = getenv('HTTP_CLIENT_IP');
		}
		elseif (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_X_FORWARDED')) {
			$ip = getenv('HTTP_X_FORWARDED');
		}
		elseif (getenv('HTTP_FORWARDED_FOR')) {
			$ip = getenv('HTTP_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_FORWARDED')) {
			$ip = getenv('HTTP_FORWARDED');
		}
		else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	
	function new_user() {
		$insert = mysql_query ("INSERT INTO useronline(timestamp, ip, user) VALUES ('$this->timestamp', '$this->ip', '$_SESSION[username]')");
		if (!$insert) {
			$this->error[$this->i] = "Unable to record new visitor\r\n";			
			$this->i ++;
		}
	}
	
	function delete_user() {
		$delete = mysql_query ("DELETE FROM useronline WHERE timestamp < ($this->timestamp - $this->timeout)");
		if (!$delete) {
			$this->error[$this->i] = "Unable to delete visitors";
			$this->i ++;
		}
	}
	
	function count_users() {
		if (count($this->error) == 0) {
			$count = mysql_num_rows ( mysql_query("SELECT DISTINCT user FROM useronline"));
			return $count;
		}
	}
	
	// function players_online()
	// {
		// $x=0;
		// $getPlayers = mysql_query("SELECT DISTINCT user FROM useronline");
		// while($row = mysql_fetch_array($getPlayers))
		// {
			// $allPlayersOnline = $row[user];
		// }
		// return $allPlayersOnline;
	// }
	
	function displayPlayers($username, $partyID) {
		$players_online = mysql_query("SELECT DISTINCT user FROM useronline");
		$num2=1;
		$i=0;
		include_once("character.class.php");
		$character = new Character();
		while($row = mysql_fetch_array($players_online))
		{
			$players[$i++]=$row['user'];
			$player_online = $row['user'];
			$num2++;
			?>
			<? echo $player_online; ?>
			<? if($player_online==$username){ ?>
				- <a href="#" onclick="cwindow('playerStats.php?player=<? echo $player_online; ?>', '25', '60');">View Your Stats</a> 
			<? } else { ?>
				- <a href="#" onclick="cwindow('playerStats.php?player=<? echo $player_online; ?>', '25', '60');">View Stats</a>
				- <a href="javascript:chatWith('<? echo $player_online; ?>');">IM</a>
				- <a href="#" onclick="cwindow('tradeWithUser.php?g=<? echo $character->getIDFromName($username); ?>&t=<? echo $character->getIDFromName($player_online); ?>', '83', '55');">Trade</a>
				<? if($partyID!=0){ ?>
				- <a href="#" onclick="party_invite('<? echo $player_online; ?>', '<? echo $username; ?>');return false">Invite to Party</a>
			<? } else { } } ?>
			<hr>
			<?
		}
	}
}
?>