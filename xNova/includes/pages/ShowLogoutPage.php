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

function ShowLogoutPage()
{
	global $LNG, $SESSION;
		
	$SESSION = new Session();
	$SESSION->DestroySession();
	
	$template	= new template();
	$template->cache	= true;
	$template->isPopup(true);	
	$template->assign_vars(array(
		'lo_title'		=> $LNG['lo_title'],
		'lo_logout'		=> $LNG['lo_logout'],
		'lo_redirect'	=> $LNG['lo_redirect'],
		'lo_notify'		=> $LNG['lo_notify'],
		'lo_continue'	=> $LNG['lo_continue'],
	));
	$template->show("logout_overview.tpl");
}
?>