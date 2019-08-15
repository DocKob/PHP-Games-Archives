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
 
 * @Author of original mod: Jstar
 * @Relase, Fixs and Adapted by Brayan Narvaez

 * Please do not remove the credits
*/

if(!defined('INSIDE')) die('Hacking attempt!');

class ShowOfficierPage
{
   private function IsOfficierAccessible($USER,$Officier)
   {
      global $requeriments,$resource,$pricelist,$reslist;

      if(!in_array($Officier,$reslist['officier']))
         return -3;

      if(isset($requeriments[$Officier]))
      {
         foreach($requeriments[$Officier] as $ReqOfficier => $OfficierLevel)
         {
            if(empty($USER[$resource[$ReqOfficier]]) || count($USER[$resource[$ReqOfficier]]) < $OfficierLevel)
               return -2;
         }
      }
      if(count($USER[$resource[$Officier]]) >= $pricelist[$Officier]['max'])
      {
         return -1;
      }
      return 0;
   }

   private function addOfficier($USER,$Officier,$Mode)
   {
      global $pricelist, $resource, $db, $LNG, $LANG;
	 $template    = new template();
 if ( $Officier == 600 ) { $offtime =  $USER['commander_time'];}
 if ( $Officier == 601 ) { $offtime =  $USER['geologe_time'];}
  if ( $Officier == 602 ) { $offtime =  $USER['admiral_time'];}
   if ( $Officier == 603 ) { $offtime =  $USER['engineer_time'];}
    if ( $Officier == 604 ) { $offtime =  $USER['technocratic_time'];}
    
      $offInfo = $pricelist[$Officier][$Mode];
      $darkprice = $offInfo['darkmatter'];
      $diahoy = date("d-m-o G:i:s");
      $diahoy = strtotime($diahoy);
      $offtime2 = $offtime - $diahoy;
      if ( $offtime2 < 0 ) { $offtime3 = 0;} else { $offtime3 = $offtime2;}
      $time = $offInfo['time'];
      $newEndTime = $diahoy + $time + $offtime3;
      
 if ( $Officier == 600 ) { $offname =  "commander";}
 if ( $Officier == 601 ) { $offname =  "geologe";}
  if ( $Officier == 602 ) { $offname =  "admiral";}
   if ( $Officier == 603 ) { $offname =  "engineer";}
    if ( $Officier == 604 ) { $offname =  "technocratic";}
	$db->query("UPDATE ".USERS." SET `".$offname."` = '1' WHERE `id` = '".$USER['id']."';");
	$db->query("UPDATE ".USERS." SET `".$offname."_time` = '".$newEndTime."' WHERE `id` = '".$USER['id']."';");
	$db->query("UPDATE ".USERS." SET `darkmatter`=darkmatter-".$darkprice." WHERE id=".$USER['id']."");
 if ( $Officier == 604 && $USER['technocratic'] == 0 ) { $db->query("UPDATE ".USERS." SET `spy_tech`=spy_tech+2 WHERE id=".$USER['id']."");}
 
	$template->message($LNG['oficial_contratado'],"?page=oficiales", 2);
	error_reporting(0); #Fix de message.
   }

    private function haveDarkMatterFor($USER,$Officier,$Mode)
   {
      global $pricelist;
      return $pricelist[$Officier][$Mode]['darkmatter'] <= $USER['darkmatter'];
   }
   
   private function getStrTime($seconds)
   {
      $anni = floor($seconds / (365 * 24 * 60 * 60));
      $str = "";
      if($anni != 0)
      {
         $str .= $anni . " A&ntilde;o";
         $seconds -= $anni * (365 * 24 * 60 * 60);
      }
      $mesi = floor($seconds / 2592000);
      if($mesi != 0)
      {
         $str .= $mesi . " Meses";
         $seconds -= $mesi * 2592000;
      }
      $settimane = floor($seconds / 604800);
      if($settimane != 0)
      {
         $str .= $settimane . " Semana";
      }
      return $str;
   }

   public function __construct(&$USER) 
   {      
    global $USER, $LNG, $LANG, $dpath, $CONF, $resource, $reslist,  $pricelist, $db;

	$template    = new template();
 	
      if($_GET['mode'] == 2)
      {
         $Officier = intval($_GET['offi']);
         $Mode = $_GET['offi_mode'];
         if($this->IsOfficierAccessible($USER,$Officier) === 0)
            $this->addOfficier($USER,$Officier,$Mode);
      }
       
	
	#Comandante
	if ($USER['commander'] > 0) {
		$actividad600 = "<font color=\"#3ab100\">" . $LNG['activo'] ."</font>";
	} else {
		$actividad600 = "<font color=\"red\"><b>" . $LNG['inactivo'] ."</b></font>";
	}
	if ($USER['darkmatter'] >= $pricelist[600]['week']['darkmatter']) {
		$link600_week = "<a href=\"game.php?page=oficiales&mode=2&offi=600&offi_mode=week\"><font color=\"#00ff00\">" . $LNG['contratar'] . "</font></a>";
	} else {
		$link600_week = "<font color=\"red\">" . $LNG['contratar'] . "</font>";
	}
	if ($USER['darkmatter'] >= $pricelist[600]['months']['darkmatter']) {
		$link600_mes = "<a href=\"game.php?page=oficiales&mode=2&offi=600&offi_mode=months\"><font color=\"#00ff00\">" . $LNG['contratar'] . "</font></a>";
	} else {
		$link600_mes = "<font color=\"red\">" . $LNG['contratar'] . "</font>";
	}
	
	#Ingeniero
	if ($USER['engineer'] > 0) {
		$actividad603 = "<font color=\"#3ab100\"><b>" . $LNG['activo'] ."</b></font>";
	} else {
		$actividad603 = "<font color=\"red\"><b>" . $LNG['inactivo'] ."<b></font>";
	}
	if ($USER['darkmatter'] >= $pricelist[603]['week']['darkmatter']) {
		$link603_week = "<a href=\"game.php?page=oficiales&mode=2&offi=603&offi_mode=week\"><font color=\"#00ff00\">" . $LNG['contratar'] . "</font></a>";
	} else {
		$link603_week = "<font color=\"red\">" . $LNG['contratar'] . "</font>";
	}
	if ($USER['darkmatter'] >= $pricelist[603]['months']['darkmatter']) {
		$link603_mes = "<a href=\"game.php?page=oficiales&mode=2&offi=603&offi_mode=months\"><font color=\"#00ff00\">" . $LNG['contratar'] . "</font></a>";
	} else {
		$link603_mes = "<font color=\"red\">" . $LNG['contratar'] . "</font>";
	}
	
	#Geologo
	if ($USER['geologe'] > 0) {
		$actividad601 = "<font color=\"#3ab100\"><b>" . $LNG['activo'] ."</b></font>";
	} else {
		$actividad601 = "<font color=\"red\"><b>" . $LNG['inactivo'] ."<b></font>";
	}
	if ($USER['darkmatter'] >= $pricelist[601]['week']['darkmatter']) {
		$link601_week = "<a href=\"game.php?page=oficiales&mode=2&offi=601&offi_mode=week\"><font color=\"#00ff00\">" . $LNG['contratar'] . "</font></a>";
	} else {
		$link601_week = "<font color=\"red\">" . $LNG['contratar'] . "</font>";
	}
	if ($USER['darkmatter'] >= $pricelist[601]['months']['darkmatter']) {
		$link601_mes = "<a href=\"game.php?page=oficiales&mode=2&offi=601&offi_mode=months\"><font color=\"#00ff00\">" . $LNG['contratar'] . "</font></a>";
	} else {
		$link601_mes = "<font color=\"red\">" . $LNG['contratar'] . "</font>";
	}
	
	#Tecnocrata
	if ($USER['technocratic'] > 0) {
		$actividad604 = "<font color=\"#3ab100\"><b>" . $LNG['activo'] ."</b></font>";
	} else {
		$actividad604 = "<font color=\"red\"><b>" . $LNG['inactivo'] ."<b></font>";
	}
	if ($USER['darkmatter'] >= $pricelist[604]['week']['darkmatter']) {
		$link604_week = "<a href=\"game.php?page=oficiales&mode=2&offi=604&offi_mode=week\"><font color=\"#00ff00\">" . $LNG['contratar'] . "</font></a>";
	} else {
		$link604_week = "<font color=\"red\">" . $LNG['contratar'] . "</font>";
	}
	if ($USER['darkmatter'] >= $pricelist[604]['months']['darkmatter']) {
		$link604_mes = "<a href=\"game.php?page=oficiales&mode=2&offi=604&offi_mode=months\"><font color=\"#00ff00\">" . $LNG['contratar'] . "</font></a>";
	} else {
		$link604_mes = "<font color=\"red\">" . $LNG['contratar'] . "</font>";
	}
	
	#Almirante
	if ($USER['admiral'] > 0) {
		$actividad602 = "<font color=\"#3ab100\"><b>" . $LNG['activo'] ."</b></font>";
	} else {
		$actividad602 = "<font color=\"red\"><b>" . $LNG['inactivo'] ."<b></font>";
	}
	if ($USER['darkmatter'] >= $pricelist[602]['week']['darkmatter']) {
		$link602_week = "<a href=\"game.php?page=oficiales&mode=2&offi=602&offi_mode=week\"><font color=\"#00ff00\">" . $LNG['contratar'] . "</font></a>";
	} else {
		$link602_week = "<font color=\"red\">" . $LNG['contratar'] . "</font>";
	}
	if ($USER['darkmatter'] >= $pricelist[602]['months']['darkmatter']) {
		$link602_mes = "<a href=\"game.php?page=oficiales&mode=2&offi=602&offi_mode=months\"><font color=\"#00ff00\">" . $LNG['contratar'] . "</font></a>";
	} else {
		$link602_mes = "<font color=\"red\">" . $LNG['contratar'] . "</font>";
	}
	
	$template->assign_vars(array(
		'comandante' => $LNG['comandante'],
		'comandante_desc' => $LNG['comandante_desc'],
		'actividad600' => $actividad600,
		'link600_week' => $link600_week,
		'link600_mes' => $link600_mes,
		'precio1_600' => pretty_number($pricelist[600]['week']['darkmatter']),
		'precio2_600' => pretty_number($pricelist[600]['months']['darkmatter']),
		'geologo' => $LNG['geologo'],
		'geologo_desc' => $LNG['geologo_desc'],
		'actividad601' => $actividad601,
		'link601_week' => $link601_week,
		'link601_mes' => $link601_mes,
		'precio1_601' => pretty_number($pricelist[601]['week']['darkmatter']),
		'precio2_601' => pretty_number($pricelist[601]['months']['darkmatter']),		
		'ingeniero' => $LNG['ingeniero'],
		'ingeniero_desc' => $LNG['ingeniero_desc'],
		'actividad603' => $actividad603,
		'link603_mes' => $link603_mes,
		'link603_week' => $link603_week,
		'precio1_603' => pretty_number($pricelist[603]['week']['darkmatter']),
		'precio2_603' => pretty_number($pricelist[603]['months']['darkmatter']),
		'almirante' => $LNG['almirante'],
		'almirante_desc' => $LNG['almirante_desc'],
		'actividad602' => $actividad602,
		'link602_week' => $link602_week,
		'link602_mes' => $link602_mes,
		'precio1_602' => pretty_number($pricelist[602]['week']['darkmatter']),
		'precio2_602' => pretty_number($pricelist[602]['months']['darkmatter']),
		'tecnocrata' => $LNG['tecnocrata'],
		'tecnocrata_desc' => $LNG['tecnocrata_desc'],
		'actividad604' => $actividad604,
		'link604_week' => $link604_week,
		'link604_mes' => $link604_mes,
		'precio1_604' => pretty_number($pricelist[604]['week']['darkmatter']),
		'precio2_604' => pretty_number($pricelist[604]['months']['darkmatter']),
		'contratar' => $LNG['contratar'],
		'semana' => $LNG['semana'],
		'mes' => $LNG['mes'],
		'materia_oscura_descr' => $LNG['materia_oscura'],
		'comprar' => $LNG['comprar'],
		'oficiales' => $LNG['oficiales'],
    ));
    $template->show("oficiales/officier_table.tpl");  
   } 
}
?> 
