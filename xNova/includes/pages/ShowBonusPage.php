<?php

/**
 _  \_/ |\ | /¯¯\ \  / /\    |¯¯) |_¯ \  / /¯¯\ |  |   |´¯|¯` | /¯¯\ |\ |5
 ¯  /¯\ | \| \__/  \/ /--\   |¯¯\ |__  \/  \__/ |__ \_/   |   | \__/ | \|Core.
 * @author: Copyright (C) 2011 by Brayan Narvaez (Prinick) developer of xNova Revolution
 * @author web: http://www.bnarvaez.com
 * @link: http://www.xnovarev.com
 * @Basic version of mod by noonn

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

function ShowBonusPage()
{
    global $USER, $PLANET, $LNG, $LANG, $db;
    $PlanetRess = new ResourceUpdate();
    $PlanetRess->CalcResource();
    $PlanetRess->SavePlanetToDB();
	error_reporting(0);

    $template    = new template();
    $Mode = $_GET['pack'];
    $darkmatter = $USER['darkmatter'];
	$cost_res = 50000;
	$cost_mine = 100000;
	$cost_stor = 20000;
	$cost_flot = 120000;
	$cost_bunk = 80000;
	$cost_tecno = 70000;

#Recursos por materia oscura
if( $Mode == 'recursos' && $darkmatter >= $cost_res){
$aendern = $db->query("UPDATE ".USERS." SET darkmatter=darkmatter-" .$cost_res ." WHERE id= '".$USER[id]."';");
$aendern = $db->query("UPDATE ".PLANETS." SET metal=metal+10000000,
                              crystal=crystal+5000000,
							  deuterium=deuterium+2500000
                               WHERE `galaxy`='".$PLANET['galaxy']."'
                               AND `system` ='".$PLANET['system']."'
                               AND `planet` ='".$PLANET['planet']."'
                               AND `planet_type` ='".$PLANET['planet_type']."'
                               ",'planets');

$template->message($LNG['bn_pack_ok'],"?page=bonus",4);
                exit;    
} elseif($darkmatter < $cost_res && $Mode == 'recursos') {
$template->message($LNG['bn_pack_no'],"?page=bonus",4);                
exit;    
}

#Pack mineros por materia oscura
if( $Mode == 'mineros' && $darkmatter >= $cost_mine){
$aendern = $db->query("UPDATE ".USERS." SET darkmatter=darkmatter-" .$cost_mine ." WHERE id= '".$USER[id]."';");
$aendern = $db->query("UPDATE ".PLANETS." SET metal_mine=metal_mine+2,
                              crystal_mine=crystal_mine+2,                 
							  solar_plant=solar_plant+5,
							  norio_mine=norio_mine+2,
							  robot_factory=robot_factory+2,
							  field_current=field_current+13
                               WHERE `galaxy`='".$PLANET['galaxy']."'
                               AND `system` ='".$PLANET['system']."'
                               AND `planet` ='".$PLANET['planet']."'
                               AND `planet_type` ='".$PLANET['planet_type']."'
                               ",'planets');

$template->message($LNG['bn_pack_ok'],"?page=bonus",4);
                exit;    
} elseif($darkmatter < $cost_mine && $Mode == 'mineros') {
$template->message($LNG['bn_pack_no'],"?page=bonus",4);                
exit;    
}

#Pack de almacenes por materia oscura
if( $Mode == 'almacenes' && $darkmatter >= $cost_stor){
$aendern = $db->query("UPDATE ".USERS." SET darkmatter=darkmatter-" .$cost_stor ." WHERE id= '".$USER[id]."';");
$aendern = $db->query("UPDATE ".PLANETS." SET metal_store=metal_store+1,
                              crystal_store=crystal_store+1,
                              deuterium_store=deuterium_store+1,
							  norio_store=norio_store+1,
							  field_current=field_current+4
                               WHERE `galaxy`='".$PLANET['galaxy']."'
                               AND `system` ='".$PLANET['system']."'
                               AND `planet` ='".$PLANET['planet']."'
                               AND `planet_type` ='".$PLANET['planet_type']."'
                               ",'planets');

$template->message($LNG['bn_pack_ok'],"?page=bonus",4);
                exit;    
} elseif($darkmatter < $cost_stor && $Mode == 'almacenes') {
$template->message($LNG['bn_pack_no'],"?page=bonus",4);                
exit;    
}

#Pack floteros por materia oscura
if( $Mode == 'floteros' && $darkmatter >= $cost_flot){
$aendern = $db->query("UPDATE ".USERS." SET darkmatter=darkmatter-" .$cost_flot ." WHERE id= '".$USER[id]."';");
$aendern = $db->query("UPDATE ".PLANETS." SET deuterium=deuterium+3000000, 
							small_ship_cargo=small_ship_cargo+300000,
                              big_ship_cargo=big_ship_cargo+150000,
                              giga_recykler=giga_recykler+500
                               WHERE `galaxy`='".$PLANET['galaxy']."'
                               AND `system` ='".$PLANET['system']."'
                               AND `planet` ='".$PLANET['planet']."'
                               AND `planet_type` ='".$PLANET['planet_type']."'
                               ",'planets');

$template->message($LNG['bn_pack_ok'],"?page=bonus",4);
                exit;    
} elseif($darkmatter < $cost_flot && $Mode == 'floteros') {
$template->message($LNG['bn_pack_no'],"?page=bonus",4);                
exit;    
}

#Pack de bunkeros por materia oscura
if( $Mode == 'bunkeros' && $darkmatter >= $cost_bunk){
$aendern = $db->query("UPDATE ".USERS." SET darkmatter=darkmatter-" .$cost_bunk ." WHERE id= '".$USER[id]."';");
$aendern = $db->query("UPDATE ".PLANETS." SET small_protection_shield=small_protection_shield+1, 
							planet_protector=planet_protector+1,
                              big_protection_shield=big_protection_shield+1,
                              ionic_canyon=ionic_canyon+20000
                               WHERE `galaxy`='".$PLANET['galaxy']."'
                               AND `system` ='".$PLANET['system']."'
                               AND `planet` ='".$PLANET['planet']."'
                               AND `planet_type` ='".$PLANET['planet_type']."'
                               ",'planets');

$template->message($LNG['bn_pack_ok'],"?page=bonus",4);
                exit;    
} elseif($darkmatter < $cost_bunk && $Mode == 'bunkeros') {
$template->message($LNG['bn_pack_no'],"?page=bonus",4);                
exit;    
}

#Pack de tecnologías por materia oscura
if( $Mode == 'tecnologias' && $darkmatter >= $cost_tecno){
$aendern = $db->query("UPDATE ".USERS." SET darkmatter=darkmatter-" .$cost_tecno .",
							 spy_tech=spy_tech+1, 
							 computer_tech=computer_tech+1,
                              energy_tech=energy_tech+1,
                              combustion_tech=combustion_tech+1,
							  impulse_motor_tech=impulse_motor_tech+1,
							  hyperspace_motor_tech=hyperspace_motor_tech+1
                              WHERE id= '".$USER[id]."';");

$template->message($LNG['bn_pack_ok'],"?page=bonus",4);
                exit;    
} elseif($darkmatter < $cost_tecno && $Mode == 'tecnologias') {
$template->message($LNG['bn_pack_no'],"?page=bonus",4);                
exit;    
}

$template->assign_vars(array(
		'mo_lang' => $LNG['packs_darkmatter'],
		'en_venta' => $LNG['packs_en_venta'],
		'comprar' => $LNG['packs_comprar'],
		'coste' => $LNG['packs_coste'],
		'cost_res' => $cost_res,
		'recursos_pack'	=> $LNG['recursos_pack'],
		'recursos_pack_descr'	=> $LNG['recursos_pack_descr'],
		'cost_mine' => $cost_mine,
		'minas_pack'	=> $LNG['minas_pack'],
		'minas_pack_descr'	=> $LNG['minas_pack_descr'],
		'cost_stor' => $cost_stor,
		'almacenes_pack'	=> $LNG['almacenes_pack'],
		'almacenes_pack_descr'	=> $LNG['almacenes_pack_descr'],
		'cost_flot' => $cost_flot,
		'flotas_pack'	=> $LNG['flotas_pack'],
		'flotas_pack_descr'	=> $LNG['flotas_pack_descr'],
		'cost_bunk' => $cost_bunk,
		'bunkers_pack'	=> $LNG['bunkers_pack'],
		'bunkers_pack_descr'	=> $LNG['bunkers_pack_descr'],
		'cost_tecno' => $cost_tecno,
		'tecnos_pack'	=> $LNG['tecnos_pack'],
		'tecnos_pack_descr'	=> $LNG['tecnos_pack_descr'],
    ));
    $template->show("bonus_page.tpl");
}
?>