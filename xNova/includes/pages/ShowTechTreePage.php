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

function ShowTechTreePage()
{
	global $resource, $requeriments, $LNG, $reslist, $USER, $PLANET;
	
	$PlanetRess = new ResourceUpdate();
	$PlanetRess->CalcResource();
	$PlanetRess->SavePlanetToDB();
	
	$template	= new template();
	$RequeriList = array();
	foreach($LNG['tech'] as $Element => $ElementName)
	{
		if(!isset($resource[$Element]))
			$TechTreeList[]	= $ElementName;
		else
		{
			$RequeriList	= array();
			if(isset($requeriments[$Element]))
			{
				foreach($requeriments[$Element] as $RegID => $RedCount)
				{
					$RequeriList[$Element][]	= array('id' => $RegID, 'count' => $RedCount, 'own' => (isset($PLANET[$resource[$RegID]])) ? $PLANET[$resource[$RegID]] : $USER[$resource[$RegID]]);
				}
			}
	
			$TechTreeList[]	= array(
				'id' 	  => $Element,
				'name'	  => $ElementName,
				'need'	  => $RequeriList,		
			);
		}
	}
	
	$template->assign_vars(array(
		'TechTreeList'		=> $TechTreeList,
		'tt_requirements'	=> $LNG['tt_requirements'],
		'LNG'				=> $LNG['tech'],
		'tt_lvl'			=> $LNG['tt_lvl'],
	));

	$template->show("techtree_overview.tpl");
}
?>