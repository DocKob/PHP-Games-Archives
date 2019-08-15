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

* Queda pendiente para un proxio update agregar Norio al mercader
*/

function ShowTraderPage()
{
   global $USER, $PLANET, $LNG, $db;
   $ress       = request_var('ress', '');
   $action    = request_var('action', '');
   $metal      = round(request_var('metal', 0.0), 0);
   $crystal    = round(request_var('crystal', 0.0), 0);
   $deut      = round(request_var('deuterium', 0.0), 0);
   $norio      = round(request_var('norio', 0.0), 0);

   $PlanetRess = new ResourceUpdate();
   
   $template   = new template();
   $template->loadscript("trader.js");

   if ($ress != '')
   {
      switch ($ress) {
         case 'metal':
            if($action == "trade")
            {
               if ($USER['darkmatter'] < DARKMATTER_FOR_TRADER)
                  $template->message(sprintf($LNG['tr_empty_darkmatter'], $LNG['Darkmatter']), "game.php?page=trader", 1);
               elseif ($crystal < 0 || $deut < 0 || $norio < 0)
                  $template->message($LNG['tr_only_positive_numbers'], "game.php?page=trader",1);
               else
               {
                  $trade   = ($crystal * 2 + $deut * 4 + $norio * 3);
                  $PlanetRess->CalcResource();
                  if ($PLANET['metal'] > $trade)
                  {
                     $PLANET['metal']     -= $trade;
                     $PLANET['crystal']   += $crystal;
                     $PLANET['deuterium'] += $deut;
                     $PLANET['norio']     += $norio;
                     $USER['darkmatter']   -= DARKMATTER_FOR_TRADER;
                     $template->message($LNG['tr_exchange_done'],"game.php?page=trader",1);
                  }
                  else
                     $template->message($LNG['tr_not_enought_metal'], "game.php?page=trader", 1);
                     
                  $PlanetRess->SavePlanetToDB();
               }
            } else {
               $template->assign_vars(array(
                  'tr_resource'      => $LNG['tr_resource'],
                  'tr_sell_metal'      => $LNG['tr_sell_metal'],
                  'tr_amount'         => $LNG['tr_amount'],
                  'tr_exchange'      => $LNG['tr_exchange'],  
				  'tr_almacenes'      => $LNG['tr_almacenes'],   				  
                  'tr_quota_exchange'   => $LNG['tr_quota_exchange'],
				  'tr_descr'   		=> $LNG['tr_descr'],
				  'tr_cost_dm_trader'   	=> sprintf($LNG['tr_cost_dm_trader'], pretty_number(DARKMATTER_FOR_TRADER), $LNG['Darkmatter']),
                  'Metal'            => $LNG['Metal'],
                  'Crystal'         => $LNG['Crystal'],
                  'Deuterium'         => $LNG['Deuterium'],
                  'Norio'             => $LNG['Norio'],
                  'mod_ma_res_a'       => "2",
                  'mod_ma_res_b'       => "4",
                  'mod_ma_res_d'       => "3",
                  'ress'             => $ress,
               ));

               $template->show("mercader/trader_metal.tpl");   
            }
         break;
         case 'crystal':
            if($action == "trade")
            {
               if ($USER['darkmatter'] < DARKMATTER_FOR_TRADER)
                  $template->message(sprintf($LNG['tr_empty_darkmatter'], $LNG['Darkmatter']), "game.php?page=trader", 1);
               elseif ($metal < 0 || $deut < 0 || $norio < 0)
                  $template->message($LNG['tr_only_positive_numbers'], "game.php?page=trader",1);
               else
               {
                  $trade   = ($metal * 0.5 + $deut * 2 + $norio * 1.5);                  
                  $PlanetRess->CalcResource();
                  if ($PLANET['crystal'] > $trade)
                  {
                     $PLANET['metal']     += $metal;
                     $PLANET['crystal']   -= $trade;
                     $PLANET['deuterium'] += $deut;
                     $PLANET['norio']     += $norio;
                     $USER['darkmatter']   -= DARKMATTER_FOR_TRADER;
                     $template->message($LNG['tr_exchange_done'],"game.php?page=trader",1);
                  }
                  else
                     $template->message($LNG['tr_not_enought_crystal'], "game.php?page=trader", 1);
                  
                  $PlanetRess->SavePlanetToDB();
               }
            } else {
               $template->assign_vars(array(
                  'tr_resource'      => $LNG['tr_resource'],
                  'tr_sell_crystal'   => $LNG['tr_sell_crystal'],
                  'tr_amount'         => $LNG['tr_amount'],
                  'tr_exchange'      => $LNG['tr_exchange'],   
				  'tr_almacenes'      => $LNG['tr_almacenes'],
                  'tr_quota_exchange'   => $LNG['tr_quota_exchange'],
				  'tr_descr'   		=> $LNG['tr_descr'],
				  'tr_cost_dm_trader'   		=> sprintf($LNG['tr_cost_dm_trader'], pretty_number(DARKMATTER_FOR_TRADER), $LNG['Darkmatter']),
                  'Metal'            => $LNG['Metal'],
                  'Crystal'         => $LNG['Crystal'],
                  'Deuterium'         => $LNG['Deuterium'],
                  'Norio'             => $LNG['Norio'],
                  'mod_ma_res_a'       => "0.5",
                  'mod_ma_res_b'       => "2",
                  'mod_ma_res_d'       => "1.5",
                  'ress'             => $ress,
               ));

               $template->show("mercader/trader_crystal.tpl");   
            }
         break;
         case 'deuterium':
            if($action == "trade")
            {
               if ($USER['darkmatter'] < DARKMATTER_FOR_TRADER)
                  $template->message(sprintf($LNG['tr_empty_darkmatter'], $LNG['Darkmatter']), "game.php?page=trader", 1);
               elseif ($metal < 0 || $crystal < 0 || $norio < 0)
                  message($LNG['tr_only_positive_numbers'], "game.php?page=trader",1);
               else
               {
                  $trade   = ($metal * 0.25 + $crystal * 0.5 + $norio * 1.2);   #si norio se multplica por (1) da el mismo resultado               
                  $PlanetRess->CalcResource();
                  if ($PLANET['deuterium'] > $trade)
                  {
                     $PLANET['metal']     += $metal;
                     $PLANET['crystal']   += $crystal;
                     $PLANET['deuterium'] -= $trade;
                     $PLANET['norio']     += $norio;
                     $USER['darkmatter']   -= DARKMATTER_FOR_TRADER;
                     $template->message($LNG['tr_exchange_done'],"game.php?page=trader", 1);
                  }
                  else
                     $template->message($LNG['tr_not_enought_deuterium'], "game.php?page=trader", 1);
                     
                  $PlanetRess->SavePlanetToDB();
               }
            } else {
               $template->assign_vars(array(
                  'tr_resource'      => $LNG['tr_resource'],
                  'tr_sell_deuterium'   => $LNG['tr_sell_deuterium'],
                  'tr_amount'         => $LNG['tr_amount'],
                  'tr_exchange'      => $LNG['tr_exchange'],   
				  'tr_almacenes'      => $LNG['tr_almacenes'],
                  'tr_quota_exchange'   => $LNG['tr_quota_exchange'],
				  'tr_descr'   		=> $LNG['tr_descr'],
				  'tr_cost_dm_trader'   		=> sprintf($LNG['tr_cost_dm_trader'], pretty_number(DARKMATTER_FOR_TRADER), $LNG['Darkmatter']),
                  'Metal'            => $LNG['Metal'],
                  'Crystal'         => $LNG['Crystal'],
                  'Deuterium'         => $LNG['Deuterium'],
                  'Norio'             => $LNG['Norio'],
                  'mod_ma_res_a'       => "0.25",
                  'mod_ma_res_b'       => "0.5",
                  'mod_ma_res_d'       => "1.2",
                  'ress'             => $ress,
               ));

               $template->show("mercader/trader_deuterium.tpl");   
            }
         break;   
         case 'norio':
            if($action == "trade")
            {
               if ($USER['darkmatter'] < DARKMATTER_FOR_TRADER)
                  $template->message(sprintf($LNG['tr_empty_darkmatter'], $LNG['Darkmatter']), "game.php?page=trader", 1);
               elseif ($metal < 0 || $crystal < 0 || $deut < 0)
                  message($LNG['tr_only_positive_numbers'], "game.php?page=trader",1);
               else
               {
                  $trade = ($metal * 0.10 + $crystal * 2.25 + $deut * 2);         
                  $PlanetRess->CalcResource();
                  if ($PLANET['norio'] > $trade)
                  {
                     $PLANET['metal']     += $metal;
                     $PLANET['crystal']   += $crystal;
                     $PLANET['deuterium'] += $deut;
                     $PLANET['norio']     -= $trade;
                     $USER['darkmatter']   -= DARKMATTER_FOR_TRADER;
                     $template->message($LNG['tr_exchange_done'],"game.php?page=trader", 1);
                  }
                  else
                     $template->message($LNG['tr_not_enought_norio'], "game.php?page=trader", 1);
                     
                  $PlanetRess->SavePlanetToDB();
               }
            } else {
               $template->assign_vars(array(
                  'tr_resource'      => $LNG['tr_resource'],
                  'tr_sell_norio'     => $LNG['tr_sell_norio'],
                  'tr_amount'         => $LNG['tr_amount'],
                  'tr_exchange'      => $LNG['tr_exchange'],   
				  'tr_almacenes'      => $LNG['tr_almacenes'],
                  'tr_quota_exchange'   => $LNG['tr_quota_exchange'],
				  'tr_descr'   		=> $LNG['tr_descr'],
				  'tr_cost_dm_trader'   => sprintf($LNG['tr_cost_dm_trader'], pretty_number(DARKMATTER_FOR_TRADER), $LNG['Darkmatter']),
                  'Metal'            => $LNG['Metal'],
                  'Crystal'         => $LNG['Crystal'],
                  'Deuterium'         => $LNG['Deuterium'],
                  'Norio'             => $LNG['Norio'],
                  'mod_ma_res_a'       => "0.10",
                  'mod_ma_res_b'       => "2.25",
                  'mod_ma_res_c'       => "2",
                  'ress'             => $ress,
               ));

               $template->show("mercader/trader_norio.tpl");   
            }
         break;   
      }
   }
   else
   {
      $PlanetRess->CalcResource();
      $PlanetRess->SavePlanetToDB();
      $template->assign_vars(array(
         'tr_cost_dm_trader'         => sprintf($LNG['tr_cost_dm_trader'], pretty_number(DARKMATTER_FOR_TRADER), $LNG['Darkmatter']),
         'tr_call_trader_who_buys'   => $LNG['tr_call_trader_who_buys'],
         'tr_call_trader'         => $LNG['tr_call_trader'],
         'tr_exchange_quota'         => $LNG['tr_exchange_quota'],
         'tr_call_trader_submit'      => $LNG['tr_call_trader_submit'],
		 'tr_elemento'   => $LNG['tr_elemento'],
         'Metal'                  => $LNG['Metal'],
         'Crystal'               => $LNG['Crystal'],
         'Deuterium'               => $LNG['Deuterium'],
         'Norio'                   => $LNG['Norio'],
      ));

      $template->show("mercader/trader_overview.tpl");
   }
}
?>