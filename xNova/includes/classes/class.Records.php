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

class records
{
	public static $File	= "cache/CacheRecords_Uni%d.php";
	public $maxinfos	= array();
	
	function SetIfRecord($ID, $Count, $Data)
	{
		global $CONF;
		if(($CONF['stat'] == 1 && $Data['authlevel'] >= $CONF['stat_level']) || !empty($Data['bana']))
			return;
		
		if(!isset($this->maxinfos[$Data['universe']]))
			$this->maxinfos[$Data['universe']] = array();
			
		if(!isset($this->maxinfos[$Data['universe']][$ID]))
			$this->maxinfos[$Data['universe']][$ID] = array('maxlvl' => 0, 'username' => '');

		if($this->maxinfos[$Data['universe']][$ID]['maxlvl'] < $Count)
			$this->maxinfos[$Data['universe']][$ID] = array('maxlvl' => $Count, 'username' => $Data['username']);
	}

	function BuildRecordCache() 
	{
		$Elements	= array_merge($GLOBALS['reslist']['build'], $GLOBALS['reslist']['tech'], $GLOBALS['reslist']['fleet'], $GLOBALS['reslist']['defense']);
		foreach($this->maxinfos as $Uni	=> $Records) {
			$array		= "";
			foreach($Elements as $ElementID) {
				$array	.= $ElementID." => array('username' => '".(isset($Records[$ElementID]['username']) ? $Records[$ElementID]['username'] : '-')."', 'maxlvl' => '".(isset($Records[$ElementID]['maxlvl']) ? $Records[$ElementID]['maxlvl'] : '-')."'),\n";
			}
			$file	= "<?php \n//The File is created on ".date("d. M y H:i:s", TIMESTAMP)."\n$"."RecordsArray = array(\n".$array."\n);\n?>";
			file_put_contents(sprintf(ROOT_PATH.self::$File, $Uni), $file);
		}
	}
	
	function RenameRecordOwner($OldName, $NewName, $Uni)
	{
		$Content	= file_get_contents(sprintf(ROOT_PATH.self::$File, $Uni));	
		$Content	= str_replace("array('username' => '".$OldName."'", "array('username' => '".$NewName."'", $Content);	
		file_put_contents(sprintf(ROOT_PATH.self::$File, $Uni), $Content);	
	}
	
	function GetRecords($Uni)
	{
		if(!file_exists(sprintf(ROOT_PATH.self::$File, $Uni)))
			return array();
		
		require(sprintf(ROOT_PATH.self::$File, $Uni));
		return $RecordsArray;
	}
}

?>