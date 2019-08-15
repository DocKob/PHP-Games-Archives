<?php

/**
 _  \_/ |\ | /¯¯\ \  / /\    |¯¯) |_¯ \  / /¯¯\ |  |   |´¯|¯` | /¯¯\ |\ |5
 ¯  /¯\ | \| \__/  \/ /--\   |¯¯\ |__  \/  \__/ |__ \_/   |   | \__/ | \|Core.
 * @author: Copyright (C) 2011 by Brayan Narvaez (Prinick) developer of xNova Revolution
 * @author web: http://www.bnarvaez.com
 * @link: http://www.xnovarev.com

 * @package 2Moons
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <douglas@crockford.com> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/

 * Please do not remove the credits
*/

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) exit;

function ShowMultiIPPage()
{
	global $LNG, $db;
	$Query	= $db->query("SELECT id, username, user_lastip FROM ".USERS." WHERE `universe` = '".$_SESSION['adminuni']."' AND user_lastip IN (SELECT user_lastip FROM ".USERS." WHERE `universe` = '".$_SESSION['adminuni']."' GROUP BY user_lastip HAVING COUNT(*)>1) ORDER BY user_lastip, id ASC;");
	$IPs	= array();
	while($Data = $db->fetch_array($Query)) {
		if(!isset($IPs[$Data['user_lastip']]))
			$IPs[$Data['user_lastip']]	= array();
		
		$IPs[$Data['user_lastip']][$Data['id']]	= $Data['username'];
	}
	$template	= new template();
	$template->assign_vars(array(
		'IPs'		=> $IPs,
		'mip_ip'	=> $LNG['mip_ip'],
		'mip_user'	=> $LNG['mip_user'],
	));
	$template->show('adm/MultiIPs.tpl');
}


?>