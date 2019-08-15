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
 
class Theme
{
	function __construct()
	{	
		$this->skininfo = array();
		#$this->skin		= isset($_SESSION['dpath']) ? $_SESSION['dpath'] : DEFAULT_THEME;
		if($USER['raza'] == 0) {
		$this->skin = "gultra";
		} elseif ($USER['raza'] == 1) {
		$this->skin = "voltra";
		} 
		$this->template	= ROOT_PATH.'styles/templates';
	}
	
	function isHome() {
		$this->template	= ROOT_PATH.'styles/home/';
	}
	
	function setUserTheme($Theme) {
		if(!file_exists(ROOT_PATH.'styles/theme/'.$Theme.'/style.cfg'))
			return false;
			
		$this->skin		= $Theme;
		$this->parseStyleCFG();
	}
		
	function getTheme() {
		return './styles/theme/'.$this->skin.'/';
	}
	function getThemeName() {
		return $this->skin;
	}
		
	function getTemplatePath() {
		return $this->template;
	}
	
	function parseStyleCFG() {
		require(ROOT_PATH.'styles/theme/'.$this->skin.'/style.cfg');
		$this->skininfo	= $Skin;
		$this->template	= ROOT_PATH.'styles/templates';	
	}
	
	static function getAvalibleSkins() {
		$Skins	= array_diff(scandir(ROOT_PATH.'styles/theme/'), array('..', '.', '.svn', '.htaccess', 'index.htm'));
		$Themen	= array();
		foreach($Skins as $Theme) {
			require(ROOT_PATH.'styles/theme/'.$Theme.'/style.cfg');
			$Themen[$Theme]	= $Skin['name'];
		}
		
		return $Themen;
	}
}

?>