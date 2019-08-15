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

define('INSIDE'  , true);
define('IN_CRON' , true);

define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');
require(ROOT_PATH . 'includes/common.php');

if (empty($_SESSION)) exit;

// Output transparent gif
header('Cache-Control: no-cache');
header('Content-type: image/gif');
header('Content-length: 43');
header('Expires: 0');
echo("\x47\x49\x46\x38\x39\x61\x01\x00\x01\x00\x80\x00\x00\x00\x00\x00\x00\x00\x00\x21\xF9\x04\x01\x00\x00\x00\x00\x2C\x00\x00\x00\x00\x01\x00\x01\x00\x00\x02\x02\x44\x01\x00\x3B");
$cron = request_var('cron','');
switch($cron) 
{
	case "stats":
		if (TIMESTAMP >= ($CONF['stat_last_update'] + (60 * $CONF['stat_update_time'])))
		{
			update_config(array('stat_last_update' => TIMESTAMP), true);
			require_once(ROOT_PATH . 'includes/classes/class.statbuilder.php');
			$stat			= new Statbuilder();
			$result			= $stat->MakeStats();
		}
	break;
	case "daily":
		if (TIMESTAMP >= ($CONF['stat_last_db_update'] + (60 * 60 * 24)))
		{
			update_config(array('stat_last_db_update' => TIMESTAMP), true);
			$prueba = $db->query("SHOW TABLE STATUS from ".DB_NAME.";");
			$table = "";
			while($pru = $db->fetch_array($prueba)){
				$compprefix = explode("_",$pru["Name"]);  
				
				if($compprefix[0].'_' == DB_PREFIX && $compprefix[1] != 'session')
				{
					$table .= "`".$pru["Name"]."`, ";
				}
			}
			$db->query("OPTIMIZE TABLE ".substr($table, 0, -2).";");
			ClearCache();
		}
	break;
	case "teamspeak":
		if ($CONF['ts_modon'] == 1 && TIMESTAMP >= ($CONF['ts_cron_last'] + 60 * $CONF['ts_cron_interval']))
		{
			update_config(array('ts_cron_last' => TIMESTAMP), true);
			if($CONF['ts_version'] == 2)
			{
				include_once(ROOT_PATH.'includes/libs/teamspeak/class.teamspeak2.php');
				$ts = new cyts();
				if($ts->connect($CONF['ts_server'], $CONF['ts_tcpport'], $CONF['ts_udpport'], $CONF['ts_timeout'])) {
					file_put_contents(ROOT_PATH.'cache/teamspeak_cache.php', serialize(array($ts->info_serverInfo(), $ts->info_globalInfo())));
					$ts->disconnect();
				}
			} elseif($CONF['ts_version'] == 3){
				require_once(ROOT_PATH . "includes/libs/teamspeak/class.teamspeak3.php");
				$tsAdmin 	= new ts3admin($CONF['ts_server'], $CONF['ts_udpport'], $CONF['ts_timeout']);
				$Active		= $tsAdmin->connect();
				if($Active['success']) {
					$tsAdmin->selectServer($CONF['ts_tcpport'], 'port', true);
					$tsAdmin->login($CONF['ts_login'], $CONF['ts_password']);
					file_put_contents(ROOT_PATH.'cache/teamspeak_cache.php', serialize($tsAdmin->serverInfo()));
					$tsAdmin->logout();
				}
			}
		}
	break;
}
?>