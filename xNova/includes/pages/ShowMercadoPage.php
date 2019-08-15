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

function ShowMercadoPage()
{
	global $USER, $PLANET, $LNG, $LANG;

	$PlanetRess = new ResourceUpdate();
	$PlanetRess->CalcResource();
	$PlanetRess->SavePlanetToDB();

	$template	= new template();

	$template->assign_vars(array(	
		'mercado_negro'		=> $LNG['mercado_negro'],
		'comerciante'	=> $LNG['comerciante'],
		'bonus' => $LNG['bonus_n'],
		'mercado_negro_desc'		=> $LNG['mercado_negro_desc'],
		'comerciante_desc'	=> $LNG['comerciante_desc'],
		'bonus_desc' => $LNG['bonus_n_desc'],
	));
	
	$template->show("mercado_general.tpl");
}
?>