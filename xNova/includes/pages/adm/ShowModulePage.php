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

function ShowModulePage()
{
	global $CONF, $LNG;
	if($_GET['mode']) {
		$CONF['moduls'][request_var('id', 0)]	= ($_GET['mode'] == 'aktiv') ? 1 : 0;
		update_config(array('moduls' => implode(";", $CONF['moduls']), false, $_SESSION['adminuni']));
		$CONF['moduls']		= explode(";", $CONF['moduls']);
	}
	$IDs	= range(0, 40);
	foreach($IDs as $ID => $Name) {
		$Modules[$ID]	= array(
			'name'	=> $LNG['modul'][$ID], 
			'state'	=> isset($CONF['moduls'][$ID]) ? $CONF['moduls'][$ID] : 1,
		);
	}
	
	asort($Modules);
	$template	= new template();
	$template->assign_vars(array(
		'Modules'				=> $Modules,
		'mod_module'			=> $LNG['mod_module'],
		'mod_info'				=> $LNG['mod_info'],
		'mod_active'			=> $LNG['mod_active'],
		'mod_deactive'			=> $LNG['mod_deactive'],
		'mod_change_active'		=> $LNG['mod_change_active'],
		'mod_change_deactive'	=> $LNG['mod_change_deactive'],
	));
	
	$template->show('adm/ModulePage.tpl');
}
?>