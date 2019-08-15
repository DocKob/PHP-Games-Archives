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

if ( defined('INSIDE'))
{

	$resource = array(
	  1 => "metal_mine",
	  2 => "crystal_mine",
	  3 => "deuterium_sintetizer",
	  4 => "solar_plant",
	  6 => "university",
	  7 => "norio_mine",
	 12 => "fusion_plant",
	 14 => "robot_factory",
	 15 => "nano_factory",
	 21 => "hangar",
	 22 => "metal_store",
	 23 => "crystal_store",
	 24 => "deuterium_store",
	 25 => "norio_store",
	 31 => "laboratory",
	 33 => "terraformer",
	 34 => "ally_deposit",
	 41 => "mondbasis",
	 42 => "phalanx",
	 43 => "sprungtor",
	 44 => "silo",

	106 => "spy_tech",
	108 => "computer_tech",
	109 => "military_tech",
	110 => "defence_tech",
	111 => "shield_tech",
	113 => "energy_tech",
	114 => "hyperspace_tech",
	115 => "combustion_tech",
	117 => "impulse_motor_tech",
	118 => "hyperspace_motor_tech",
	120 => "laser_tech",
	121 => "ionic_tech",
	122 => "buster_tech",
	123 => "intergalactic_tech",
	124 => "expedition_tech",
	131 => "metal_proc_tech",
	132 => "crystal_proc_tech",
	133 => "deuterium_proc_tech",
	134 => "darkmatter_moon",
	135 => "norio_proc_tech",
	199 => "graviton_tech",

	202 => "small_ship_cargo",
	203 => "big_ship_cargo",
	204 => "light_hunter",
	205 => "heavy_hunter",
	206 => "crusher",
	207 => "battle_ship",
	208 => "colonizer",
	209 => "recycler",
	210 => "spy_sonde",
	211 => "bomber_ship",
	212 => "solar_satelit",
	213 => "destructor",
	214 => "dearth_star",
	215 => "battleship",
    216 => "lune_noir",
	217 => "ev_transporter",
	218 => "star_crasher",
	219 => "giga_recykler",
	220 => "dm_ship",
	
	401 => "misil_launcher",
	402 => "small_laser",
	403 => "big_laser",
	404 => "gauss_canyon",
	405 => "ionic_canyon",
	406 => "buster_canyon",
	407 => "small_protection_shield",
	408 => "big_protection_shield",
	409 => "planet_protector",
	410 => "graviton_canyon",
	411 => "orbital_station",	
	
	502 => "interceptor_misil",
	503 => "interplanetary_misil",
	
	600 => "comandante", 
	601 => "geologo",
	602 => "almirante",
	603 => "ingeniero",
	604 => "tecnocrata",
	);

	$requeriments = array(
		 6  => array(  14 =>  20, 31  =>  22, 15 => 4, 108 => 12, 123 => 3),
		 12 => array(   3 =>   5, 113 =>   3),
		 15 => array(  14 =>  10, 108 =>  10),
		 21 => array(  14 =>   2),
		 33 => array(  15 =>   1, 113 =>  12),

		 42 => array(  41 =>   1),
		 43 => array(  41 =>   1, 114 =>   7),
		 44 => array(  21 =>   1),

		106 => array(  31 =>   3),
		108 => array(  31 =>   1),
		109 => array(  31 =>   4),
		110 => array( 113 =>   3,  31 =>   6),
		111 => array(  31 =>   2),
		113 => array(  31 =>   1),
		114 => array( 113 =>   5, 110 =>   5,  31 =>   7),
		115 => array( 113 =>   1,  31 =>   1),
		117 => array( 113 =>   1,  31 =>   2),
		118 => array( 114 =>   3,  31 =>   7),
		120 => array(  31 =>   1, 113 =>   2),
		121 => array(  31 =>   4, 120 =>   5, 113 =>   4),
		122 => array(  31 =>   5, 113 =>   8, 120 =>  10, 121 =>   5),
		123 => array(  31 =>  10, 108 =>   8, 114 =>   8),
		124 => array( 106 =>   3, 117 =>   3, 31 =>   3),
		131 => array(  31 =>   8, 113 =>   5),
		132 => array(  31 =>   8, 113 =>   5),
		133 => array(  31 =>   8, 113 =>   5),
		134 => array(  31 =>  13, 113 =>   9),
		135 => array(  31 =>   8, 113 =>   5),
		199 => array(  31 =>  12),

		202 => array(  21 =>   2, 115 =>   2),
		203 => array(  21 =>   4, 115 =>   6),
		204 => array(  21 =>   1, 115 =>   1),
		205 => array(  21 =>   3, 111 =>   2, 117 =>   2),
		206 => array(  21 =>   5, 117 =>   4, 121 =>   2),
		207 => array(  21 =>   7, 118 =>   4),
		208 => array(  21 =>   4, 117 =>   3),
		209 => array(  21 =>   4, 115 =>   6),
		210 => array(  21 =>   3, 115 =>   3, 106 =>   2),
		211 => array( 117 =>   6,  21 =>   8, 122 =>   5),
		212 => array(  21 =>   1),
		213 => array(  21 =>   9, 118 =>   6, 114 =>   5),
		214 => array(  21 =>  12, 118 =>   7, 114 =>   6, 199 =>   1),
		215 => array( 114 =>   5, 120 =>  12, 118 =>   5,  21 =>   8),
        216 => array( 106 =>  12,  21 =>  15, 109 =>  14, 110 => 14, 111 => 15, 114 => 10, 120 => 20, 199 => 3),
		217 => array(  21 =>  14, 114 =>  10, 117 => 15),
        218 => array(  21 =>  18, 109 =>  20, 110 =>  20, 111 => 20, 114 => 15, 118 => 20, 120 => 25, 199 => 8),
		219 => array(  21 =>  15, 118 => 8),
		220 => array(  21 =>   9, 114 =>   5, 118 =>   6, 134 => 5),
	
		401 => array(  21 =>   1),
		402 => array( 113 =>   1,  21 =>   2, 120 =>   3),
		403 => array( 113 =>   3,  21 =>   4, 120 =>   6),
		404 => array(  21 =>   6, 113 =>   6, 109 =>   3, 110 =>   1),
		405 => array(  21 =>   4, 121 =>   4),
		406 => array(  21 =>   8, 122 =>   7),
		407 => array( 110 =>   2,  21 =>   1),
		408 => array( 110 =>   6,  21 =>   6),
		409 => array( 110 =>   8,  21 =>   8),
		410 => array( 199 =>   7,  21 =>  18, 109 => 20),
		411 => array( 199 =>  10, 110 =>  22, 122 =>  20, 108 => 15, 111 => 25, 113 => 20, 21 => 20),
				
		
		502 => array(  44 =>   2,  21 =>   1),
		503 => array(  44 =>   4,  21 =>   1, 117 =>   1),

	);

	$pricelist = array(
		  1 => array ( 'metal' =>      60, 'crystal' =>      15, 'deuterium' =>       0, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' => 3/2),
		  2 => array ( 'metal' =>      48, 'crystal' =>      24, 'deuterium' =>       0, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' => 1.6),
		  3 => array ( 'metal' =>     225, 'crystal' =>      75, 'deuterium' =>       0, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' => 3/2),
		  4 => array ( 'metal' =>      75, 'crystal' =>      30, 'deuterium' =>       0, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' => 3/2),
		  6 => array ( 'metal' =>100000000,'crystal' =>50000000, 'deuterium' =>25000000, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' => 2.2),
		 7 => array ( 'metal' =>       500,'crystal' =>     150, 'deuterium' =>       0, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' => 3/2),
		 12 => array ( 'metal' =>     900, 'crystal' =>     360, 'deuterium' =>     180, 'norio' =>       0,'energy_max' =>      0, 'darkmatter' =>  0, 'factor' => 1.8),
		 14 => array ( 'metal' =>     400, 'crystal' =>     120, 'deuterium' =>     200, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2),
		 15 => array ( 'metal' => 1000000, 'crystal' =>  500000, 'deuterium' =>  100000, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2),
		 21 => array ( 'metal' =>     400, 'crystal' =>     200, 'deuterium' =>     100, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2),
		 22 => array ( 'metal' =>    2000, 'crystal' =>       0, 'deuterium' =>       0, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2),
		 23 => array ( 'metal' =>    2000, 'crystal' =>    1000, 'deuterium' =>       0, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2),
		 24 => array ( 'metal' =>    2000, 'crystal' =>    2000, 'deuterium' =>       0, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2),
		 25 => array ( 'metal' =>    1000, 'crystal' =>    3000, 'deuterium' =>       0, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2),
		 31 => array ( 'metal' =>     200, 'crystal' =>     400, 'deuterium' =>     200, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2),
		 33 => array ( 'metal' =>       0, 'crystal' =>   50000, 'deuterium' =>  100000, 'norio' =>       0, 'energy_max' =>   0, 'darkmatter' =>  0, 'factor' =>   2),
		 34 => array ( 'metal' =>   20000, 'crystal' =>   40000, 'deuterium' =>       0, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2),
		 41 => array ( 'metal' =>   20000, 'crystal' =>   40000, 'deuterium' =>   20000, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2),
		 42 => array ( 'metal' =>   20000, 'crystal' =>   40000, 'deuterium' =>   20000, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2),
		 43 => array ( 'metal' => 2000000, 'crystal' => 4000000, 'deuterium' => 2000000, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2),
		 44 => array ( 'metal' =>   20000, 'crystal' =>   20000, 'deuterium' =>    1000, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2),

		106 => array ( 'metal' =>     200, 'crystal' =>    1000, 'deuterium' =>     200, 'norio' =>    100, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		108 => array ( 'metal' =>     100, 'crystal' =>     400, 'deuterium' =>     600, 'norio' =>    0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		109 => array ( 'metal' =>     800, 'crystal' =>     200, 'deuterium' =>       0, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		110 => array ( 'metal' =>     200, 'crystal' =>     600, 'deuterium' =>       0, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		111 => array ( 'metal' =>    1000, 'crystal' =>       0, 'deuterium' =>       0, 'norio' =>    0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		113 => array ( 'metal' =>     100, 'crystal' =>     800, 'deuterium' =>     400, 'norio' =>       50, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		114 => array ( 'metal' =>     100, 'crystal' =>    4000, 'deuterium' =>    2000, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		115 => array ( 'metal' =>     400, 'crystal' =>     100, 'deuterium' =>     600, 'norio' =>       200, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		117 => array ( 'metal' =>    2000, 'crystal' =>    4000, 'deuterium' =>    600,  'norio' =>      500,  'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		118 => array ( 'metal' =>   10000, 'crystal' =>   20000, 'deuterium' =>    6000, 'norio' =>     5000, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		120 => array ( 'metal' =>     200, 'crystal' =>     100, 'deuterium' =>       0, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		121 => array ( 'metal' =>    1000, 'crystal' =>     300, 'deuterium' =>     100, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		122 => array ( 'metal' =>    2000, 'crystal' =>    4000, 'deuterium' =>    1000, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		123 => array ( 'metal' =>  240000, 'crystal' =>  400000, 'deuterium' =>  160000, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		131 => array ( 'metal' =>     750, 'crystal' =>     500, 'deuterium' =>     250, 'norio' =>     300, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		132 => array ( 'metal' =>    1000, 'crystal' =>     750, 'deuterium' =>     500, 'norio' =>     600, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		133 => array ( 'metal' =>    1250, 'crystal' =>    1000, 'deuterium' =>     750, 'norio' =>    0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		124 => array ( 'metal' =>    4000, 'crystal' =>    8000, 'deuterium' =>    4000, 'norio' =>       0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		134 => array ( 'metal' =>    100, 'crystal' =>    50000, 'deuterium' =>    40000, 'norio' =>    	  0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 5),
		135 => array ( 'metal' =>    1000, 'crystal' =>    850, 'deuterium' =>     610, 'norio' =>     0, 'energy_max' =>      0, 'darkmatter' =>  0, 'factor' =>   2, 'max' => 255),
		199 => array ( 'metal' =>       0, 'crystal' =>       0, 'deuterium' =>       0, 'norio' =>       0, 'energy_max' => 300000, 'darkmatter' =>  0, 'factor' =>   3, 'max' => 255),

		202 => array ( 'metal' =>      4000, 'crystal' =>      4000, 'deuterium' =>        0, 'norio' =>       0, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>     10, 'consumption2' => 20  , 'speed' =>      5000, 'speed2' =>     10000, 'capacity' =>      5000, 'tech'	=> 4),
		203 => array ( 'metal' =>     8000, 'crystal' =>      8000, 'deuterium' =>        0, 'norio' =>    0, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>     50, 'consumption2' => 50  , 'speed' =>      7500, 'speed2' =>      7500, 'capacity' =>     25000, 'tech'	=> 1),
		204 => array ( 'metal' =>      5000, 'crystal' =>      2000, 'deuterium' =>        0, 'norio' =>       0, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>     20, 'consumption2' => 20  , 'speed' =>     12500, 'speed2' =>     12500, 'capacity' =>        50, 'tech'	=> 1),
		205 => array ( 'metal' =>      8000, 'crystal' =>      6000, 'deuterium' =>        0, 'norio' =>     0, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>     75, 'consumption2' => 75  , 'speed' =>     10000, 'speed2' =>     15000, 'capacity' =>       100, 'tech'	=> 2),
		206 => array ( 'metal' =>     20000, 'crystal' =>      7000, 'deuterium' =>     3000, 'norio' =>    6000, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>    300, 'consumption2' => 300 , 'speed' =>     15000, 'speed2' =>     15000, 'capacity' =>       800, 'tech'	=> 2),
		207 => array ( 'metal' =>     55000, 'crystal' =>     23000, 'deuterium' =>     5000, 'norio' =>   10000, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>    250, 'consumption2' => 250 , 'speed' =>     10000, 'speed2' =>     10000, 'capacity' =>      1500, 'tech'	=> 3),
		208 => array ( 'metal' =>     20000, 'crystal' =>     30000, 'deuterium' =>    15000, 'norio' =>       0, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>   1000, 'consumption2' => 1000, 'speed' =>      2500, 'speed2' =>      2500, 'capacity' =>      7500, 'tech'	=> 2),
		209 => array ( 'metal' =>     20000, 'crystal' =>      8000, 'deuterium' =>     3000, 'norio' =>     2000, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>    300, 'consumption2' => 300 , 'speed' =>      2000, 'speed2' =>      2000, 'capacity' =>     20000, 'tech'	=> 1),
		210 => array ( 'metal' =>      100, 'crystal' =>      2000, 'deuterium' =>        0, 'norio' =>       0, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>      1, 'consumption2' => 1   , 'speed' => 1000000, 'speed2' => 1000000, 'capacity' =>         10, 'tech'	=> 1),
		211 => array ( 'metal' =>     60000, 'crystal' =>     35000, 'deuterium' =>    25000, 'norio' =>   30000, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>   1000, 'consumption2' => 1000, 'speed' =>      4000, 'speed2' =>      5000, 'capacity' =>       500, 'tech'	=> 5),
		212 => array ( 'metal' =>        100, 'crystal' =>      3000, 'deuterium' =>      500, 'norio' =>     1000, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>      0, 'consumption2' => 0   , 'speed' =>         0, 'speed2' =>         0, 'capacity' =>         0, 'tech'	=> 0),
		213 => array ( 'metal' =>     80000, 'crystal' =>     60000, 'deuterium' =>    25000, 'norio' =>    40000, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>   1000, 'consumption2' => 1000, 'speed' =>      5000, 'speed2' =>      5000, 'capacity' =>      2000, 'tech'	=> 3),
		214 => array ( 'metal' =>   10000000, 'crystal' =>   7000000, 'deuterium' =>  2000000, 'norio' =>      9000000, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>      1, 'consumption2' => 1   , 'speed' =>       200, 'speed2' =>       200, 'capacity' =>   1000000, 'tech'	=> 3),
		215 => array ( 'metal' =>     40000, 'crystal' =>     15000, 'deuterium' =>    10000, 'norio' =>    0, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>    250, 'consumption2' => 250 , 'speed' =>     10000, 'speed2' =>     10000, 'capacity' =>       750, 'tech'	=> 3),
        216 => array ( 'metal' =>   8000000, 'crystal' =>   2000000, 'deuterium' =>  1500000, 'norio' =>   0, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>    250, 'consumption2' => 250 , 'speed' =>       900, 'speed2' =>       900, 'capacity' =>  15000000, 'tech'	=> 3),
		217 => array ( 'metal' =>     35000, 'crystal' =>     20000, 'deuterium' =>     1500, 'norio' =>     40000, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>     90, 'consumption2' =>     90, 'speed' =>    6000, 'speed2' =>      6000, 'capacity' => 400000000, 'tech'	=> 3),
        218 => array ( 'metal' => 275000000, 'crystal' => 130000000, 'deuterium' => 60000000, 'norio' =>       120000000, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>  10000, 'consumption2' =>  10000, 'speed' =>      10, 'speed2' =>        10, 'capacity' =>  50000000, 'tech'	=> 3),
        219 => array ( 'metal' =>   1000000, 'crystal' =>    600000, 'deuterium' =>   200000, 'norio' =>      300000, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' =>    300, 'consumption2' =>    300, 'speed' =>    7500, 'speed2' =>      7500, 'capacity' => 200000000, 'tech'	=> 3),
        220 => array ( 'metal' =>   100, 'crystal' =>   2500, 'deuterium' =>  800, 'norio' =>       0, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1, 'consumption' => 100000, 'consumption2' => 100000, 'speed' =>     100, 'speed2' =>       100, 'capacity' =>   6000000, 'tech'	=> 3),
      
		401 => array ( 'metal' =>       2000, 'crystal' =>          0, 'deuterium' =>         0, 'norio' =>       0, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1 ),
		402 => array ( 'metal' =>       1500, 'crystal' =>        500, 'deuterium' =>         0, 'norio' =>       0, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1 ),
		403 => array ( 'metal' =>       6000, 'crystal' =>       2000, 'deuterium' =>         0, 'norio' =>       0, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1 ),
		404 => array ( 'metal' =>      20000, 'crystal' =>      15000, 'deuterium' =>      2000, 'norio' =>     3000, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1 ),
		405 => array ( 'metal' =>       2000, 'crystal' =>       6000, 'deuterium' =>      1000, 'norio' =>      2000, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1 ),
		406 => array ( 'metal' =>      50000, 'crystal' =>      50000, 'deuterium' =>     30000, 'norio' =>    20000, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1 ),
		407 => array ( 'metal' =>      10000, 'crystal' =>      10000, 'deuterium' =>         0, 'norio' =>       0, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1 ),
		408 => array ( 'metal' =>      50000, 'crystal' =>      50000, 'deuterium' =>         0, 'norio' =>       0, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1 ),
        409 => array ( 'metal' =>   10000000, 'crystal' =>    5000000, 'deuterium' =>   2500000, 'norio' =>       0, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1 ),
		410 => array ( 'metal' =>   15000000, 'crystal' =>   15000000, 'deuterium' =>         0, 'norio' =>       0, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1 ),
		411 => array ( 'metal' => 5000000000, 'crystal' => 2000000000, 'deuterium' => 500000000, 'norio' =>       800000000, 'energy_max' => 0, 'darkmatter' =>  10000, 'factor' => 1 ),         
		
		502 => array ( 'metal' =>   8000, 'crystal' =>     100, 'deuterium' =>    2000, 'norio' =>       0, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1 ),
		503 => array ( 'metal' =>  12500, 'crystal' =>    2500, 'deuterium' =>   10000, 'norio' =>       0, 'energy_max' => 0, 'darkmatter' =>  0, 'factor' => 1 ),
		
		600 => array ( 'max' =>  20, 'week'=> array('time' => 604800, 'darkmatter' => 10000), 'months'=>array('time' => 7776000, 'darkmatter' => 100000)),
		601 => array ( 'max' =>  20, 'week'=> array('time' => 604800, 'darkmatter' => 5000),  'months'=>array('time' => 7776000, 'darkmatter' => 50000)),
		602 => array ( 'max' =>  20, 'week'=> array('time' => 604800, 'darkmatter' => 5000),  'months'=>array('time' => 7776000, 'darkmatter' => 50000)),
		603 => array ( 'max' =>  20, 'week'=> array('time' => 604800, 'darkmatter' => 12500), 'months'=>array('time' => 7776000, 'darkmatter' => 125000)),
		604 => array ( 'max' =>  20, 'week'=> array('time' => 604800, 'darkmatter' => 10000), 'months'=>array('time' => 7776000, 'darkmatter' => 100000)),
	);

	$CombatCaps = array(
		202 => array ( 'shield' =>      10, 'attack' =>        5, 'sd' => array (210 =>    5, 212 =>    5)),
		203 => array ( 'shield' =>      25, 'attack' =>        5, 'sd' => array (210 =>    5, 212 =>    5)),
		204 => array ( 'shield' =>      10, 'attack' =>       50, 'sd' => array (202 =>    2, 210 =>    5, 212 =>    5)),
		205 => array ( 'shield' =>      25, 'attack' =>      150, 'sd' => array (202 =>    4, 203 =>    1, 210 =>    5, 212 =>   5)),
		206 => array ( 'shield' =>      50, 'attack' =>      400, 'sd' => array (204 =>    6, 401 =>   10, 210 =>   5, 212 =>   5)),
		207 => array ( 'shield' =>     200, 'attack' =>     1000, 'sd' => array (205 =>    2, 210 =>    5, 212 =>    5)),
		208 => array ( 'shield' =>     100, 'attack' =>       50, 'sd' => array (210 =>    5, 212 =>    5)),
		209 => array ( 'shield' =>      10, 'attack' =>        1, 'sd' => array (210 =>    5, 212 =>    5)),
		210 => array ( 'shield' =>    .001, 'attack' =>     .001, 'sd' => array ()),
		211 => array ( 'shield' =>     500, 'attack' =>     1000, 'sd' => array (210 =>    5, 212 =>    5, 401 =>  20, 402 =>  20, 403 =>  10, 405 =>  10)),
		212 => array ( 'shield' =>    .001, 'attack' =>     .001, 'sd' => array ()),
		213 => array ( 'shield' =>     500, 'attack' =>     2000, 'sd' => array (210 =>    5, 212 =>    5, 215 =>   2, 223 => 20, 402 =>  10)),
		214 => array ( 'shield' =>   50000, 'attack' =>   200000, 'sd' => array (210 => 1250, 212 => 1250, 202 => 250, 203 => 250, 208 => 250, 209 => 250, 204 => 200, 205 => 100, 206 => 33, 207 => 30, 211 => 25, 215 => 15, 213 => 5, 223 => 20, 224 => 20, 225 => 25, 226 => 5, 227 => 30, 228 => 25, 401 => 200, 402 => 200, 403 => 100, 404 =>  50, 405 => 100)),
		215 => array ( 'shield' =>    8000, 'attack' =>      700, 'sd' => array (202 =>    3, 203 =>   3, 205 =>   4, 206 =>   4, 207 =>   10, 210 =>   5, 212 =>   5)),
        216 => array ( 'shield' =>   70000, 'attack' =>   150000, 'sd' => array (210 => 1250, 212 => 1250, 202 => 250, 203 => 250, 204 => 200, 205 => 100, 206 =>  33, 207 =>  30, 208 => 250, 209 => 250, 211 =>  25, 213 =>   5, 214 =>   1, 215 =>  15, 223 => 30, 224 => 30, 225 => 35, 226 => 10, 227 => 40, 228 => 35, 401 => 400, 402 => 200, 403 => 100, 404 =>  50, 405 => 100)),
		217 => array ( 'shield' =>     120, 'attack' =>       50, 'sd' => array (210 =>    5, 212 =>    5)),
        218 => array ( 'shield' => 2000000, 'attack' => 35000000, 'sd' => array (210 => 1250, 212 => 1250, 202 => 250, 203 => 250, 204 => 200, 205 => 100, 206 =>  33, 207 =>  30, 208 => 250, 209 => 250, 211 =>  25, 213 =>   5, 223 => 50, 224 => 50, 225 => 55, 226 => 30, 227 => 60, 228 => 55, 215 =>  15, 401 => 400, 402 => 200, 403 => 100, 404 =>  50, 405 => 100)),
        219 => array ( 'shield' =>    1000, 'attack' =>        1, 'sd' => array (210 =>    5, 212 =>    5)),
        220 => array ( 'shield' =>   25, 'attack' => 	   5, 'sd' => array (210 =>    5, 212 =>    5)),
     	
		401 => array ( 'shield' =>      20, 'attack' =>       80, 'sd' => array ()),
		402 => array ( 'shield' =>      25, 'attack' =>      100, 'sd' => array ()),
		403 => array ( 'shield' =>     100, 'attack' =>      250, 'sd' => array ()),
		404 => array ( 'shield' =>     200, 'attack' =>     1100, 'sd' => array ()),
		405 => array ( 'shield' =>     500, 'attack' =>      150, 'sd' => array ()),
		406 => array ( 'shield' =>     300, 'attack' =>     3000, 'sd' => array ()),
		407 => array ( 'shield' =>    2000, 'attack' =>        1, 'sd' => array ()),
		408 => array ( 'shield' =>   10000, 'attack' =>        1, 'sd' => array ()),
		409 => array ( 'shield' => 1000000, 'attack' =>        1, 'sd' => array ()),
		410 => array ( 'shield' =>   80000, 'attack' =>   500000, 'sd' => array ()),
		411 => array ( 'shield' =>2000000000, 'attack' => 400000000, 'sd' => array ()),
		
		502 => array ( 'shield' =>     1, 'attack' =>      1, 'sd' => array ()),
		503 => array ( 'shield' =>     1, 'attack' =>  12000,  'sd' => array ()),
	);

	$ProdGrid = array(

		 1   => array( 'metal' =>   40, 'crystal' =>   10, 'deuterium' =>    0, 'norio' =>       0, 'energy' => 0, 'factor' => 3/2,
         'formule' => array(
            'metal'     => 'return   (30 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor) * (1 + ($BuildProcMetal * 0.02));',
            'crystal'   => 'return   "0";',
            'deuterium' => 'return   "0";',
            'norio'     => 'return   "0";',
            'energy'    => 'return - (10 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);')
      ),

      2   => array( 'metal' =>   30, 'crystal' =>   15, 'deuterium' =>    0, 'norio' =>       0, 'energy' => 0, 'factor' => 1.6,
         'formule' => array(
            'metal'     => 'return   "0";',
			'crystal'   => 'return   (20 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor) * (1 + ($BuildProcCrystal * 0.02));',
            'deuterium' => 'return   "0";',
            'norio'     => 'return   "0";',
            'energy'    => 'return - (10 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);')
      ),

      3   => array( 'metal' =>  150, 'crystal' =>   50, 'deuterium' =>    0, 'norio' =>       0, 'energy' => 0, 'factor' => 3/2,
         'formule' => array(
            'metal'     => 'return   "0";',
            'crystal'   => 'return   "0";',
            'deuterium' => 'return   (10 * $BuildLevel * pow((1.1), $BuildLevel) * (-0.002 * $BuildTemp + 1.28) * (0.1 * $BuildLevelFactor)) * (1 + ($BuildProcDeuterium * 0.02));',
            'norio'     => 'return   "0";',
            'energy'    => 'return - (30 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);')
                ),

      4   => array( 'metal' =>   50, 'crystal' =>   20, 'deuterium' =>    0, 'norio' =>       0, 'energy' => 0, 'factor' => 3/2,
         'formule' => array(
            'metal'     => 'return   "0";',
            'crystal'   => 'return   "0";',
            'deuterium' => 'return   "0";',
            'norio'     => 'return   "0";',
            'energy'    => 'return   (40 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);')
      ),
      
      7   => array( 'metal' =>   400, 'crystal' =>   130, 'deuterium' =>    0, 'norio' =>       0, 'energy' => 0, 'factor' => 3/2,
         'formule' => array(
            'metal'     => 'return   "0";',
            'crystal'   => 'return   "0";',
            'deuterium' => 'return   "0";',
            'norio'     => 'return   (15 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor) * (1 + ($BuildProcNorium * 0.02));',
            'energy'    => 'return - (15 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);')
      ),
      
      12  => array( 'metal' =>  500, 'crystal' =>  200, 'deuterium' =>  100, 'norio' =>       0, 'energy' => 0, 'factor' => 1.8,
         'formule' => array(
            'metal'     => 'return   "0";',
            'crystal'   => 'return   "0";',
            'deuterium' => 'return - (10 * $BuildLevel * pow(1.1,$BuildLevel)  * (0.1 * $BuildLevelFactor));',
            'norio'     => 'return   "0";',
            'energy'    => 'return   (40 * $BuildLevel * pow((1.05 + $BuildEnergy * 0.01), $BuildLevel)) * (0.1 * $BuildLevelFactor);')
      ),

      212 => array( 'metal' =>    0, 'crystal' => 2000, 'deuterium' =>  500, 'norio' =>       0, 'energy' => 0, 'factor' => 0.5,
         'formule' => array(
            'metal'     => 'return   "0";',
            'crystal'   => 'return   "0";',
            'deuterium' => 'return   "0";',
            'norio'     => 'return   "0";',
            'energy'    => 'return  ((($BuildTemp + 200) / 6) * (0.1 * $BuildLevelFactor) * $BuildLevel);')
      )
   );
	
	$reslist['allow']    = array ( 1 => array(1,  2,  3,  4,  6,  7, 12, 14, 15, 21, 22, 23, 24, 25, 31, 33, 34, 44), 3 => array(12, 14, 21, 22, 23, 24, 25, 34, 41, 42, 43));
	$reslist['build']    = array (   1,   2,   3,   4,   6,  7,  12,  14,  15,  21,  22,  23,  24,  25,  31,  33,  34,  44,  41,  42,  43);
	$reslist['tech']     = array ( 106, 108, 109, 110, 111, 113, 114, 115, 117, 118, 120, 121, 122, 123, 124, 131, 132, 133, 134, 135, 199);
	$reslist['fleet']    = array ( 202, 203, 204, 205, 206, 207, 208, 209, 210, 211, 212, 213, 214, 215, 216, 217, 218, 219, 220);
	$reslist['defense']  = array ( 401, 402, 403, 404, 405, 406, 407, 408, 409, 410, 411, 502, 503 );
	$reslist['officier'] = array ( 600,601, 602, 603, 604);  
	$reslist['prod']     = array (   1,   2,   3,   4,   7,  12, 212 );
	$reslist['procent']  = array ( 100,  90,  80,  70,  60,  50,  40,  30,  20,  10,   0);
	$reslist['one']  	 = array ( 407, 408, 409, 411);
}
?>