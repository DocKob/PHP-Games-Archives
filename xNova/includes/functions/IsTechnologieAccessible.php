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

if(!defined('INSIDE')) die('Hacking attempt!');

	function IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element)
	{
		global $requeriments, $resource, $reslist;
		
		if(!isset($requeriments[$Element]))
			return true;		

		foreach($requeriments[$Element] as $ReqElement => $EleLevel)
		{
			if ((isset($CurrentPlanet[$resource[$ReqElement]]) && $CurrentPlanet[$resource[$ReqElement]] < $EleLevel) || (isset($CurrentUser[$resource[$ReqElement]]) && $CurrentUser[$resource[$ReqElement]] < $EleLevel))
				return false;
		}
		return true;
	}
?>