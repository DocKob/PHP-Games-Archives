<?php
/**
 * This file is part of Wootook
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @see http://wootook.org/
 *
 * Copyright (c) 2009-Present, Wootook Support Team <http://wootook.org>
 * All rights reserved.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *                                --> NOTICE <--
 *  This file is part of the core development branch, changing its contents will
 * make you unable to use the automatic updates manager. Please refer to the
 * documentation for further information about customizing Wootook.
 *
 */

function GetTargetDistance($OrigGalaxy, $DestGalaxy, $OrigSystem, $DestSystem, $OrigPlanet, $DestPlanet) {
    $distance = 0;

    if (($OrigGalaxy - $DestGalaxy) != 0) {
        $distance = abs($OrigGalaxy - $DestGalaxy) * 20000;
    } elseif (($OrigSystem - $DestSystem) != 0) {
        $distance = abs($OrigSystem - $DestSystem) * 5 * 19 + 2700;
    } elseif (($OrigPlanet - $DestPlanet) != 0) {
        $distance = abs($OrigPlanet - $DestPlanet) * 5 + 1000;
    } else {
        $distance = 5;
    }

    return $distance;
}

// Calcul de la durée de vol d'une flotte par rapport a sa vitesse max
function GetMissionDuration ($GameSpeed, $MaxFleetSpeed, $Distance, $SpeedFactor) {
    $Duration = round(((35000 / $GameSpeed * sqrt($Distance * 10 / $MaxFleetSpeed) + 10) / $SpeedFactor));

    return $Duration;
}

// Retourne la valeur ajustée de vitesse des flottes
function GetGameSpeedFactor () {
    return Wootook::getGameConfig('game/speed/fleet') / 2500;
}

/**
 *  Calcul de la vitesse de la flotte par rapport aux technos du joueur
 *  Avec prise en compte
 */
function GetFleetMaxSpeed($FleetArray, $Fleet, $Player) {
    global $reslist, $pricelist;

    if (!is_array($FleetArray)) {
        $FleetArray = array();
    }

    if ($Fleet != 0) {
        $FleetArray[$Fleet] =  1;
    }

    $speedalls = array();
    foreach ($FleetArray as $Ship => $Count) {
        if ($Ship == Legacies_Empire::ID_SHIP_SOLAR_SATELLITE) {
            $speedalls[$Ship] = 0;
        }
        if ($Ship == Legacies_Empire::ID_SHIP_LIGHT_TRANSPORT) {
            if ($Player['impulse_motor_tech'] >= 5) {
                $speedalls[$Ship] = $pricelist[$Ship]['speed2'] + (($pricelist[$Ship]['speed'] * $Player['impulse_motor_tech']) * 0.2);
            } else {
                $speedalls[$Ship] = $pricelist[$Ship]['speed']  + (($pricelist[$Ship]['speed'] * $Player['combustion_tech']) * 0.1);
            }
        }
        if ($Ship == Legacies_Empire::ID_SHIP_LARGE_TRANSPORT || $Ship == Legacies_Empire::ID_SHIP_LIGHT_FIGHTER ||
            $Ship == Legacies_Empire::ID_SHIP_RECYCLER || $Ship == Legacies_Empire::ID_SHIP_SPY_DRONE) {
            $speedalls[$Ship] = $pricelist[$Ship]['speed'] + (($pricelist[$Ship]['speed'] * $Player['combustion_tech']) * 0.1);
        }
        if ($Ship == Legacies_Empire::ID_SHIP_HEAVY_FIGHTER || $Ship == Legacies_Empire::ID_SHIP_CRUISER ||
            $Ship == Legacies_Empire::ID_SHIP_COLONY_SHIP) {
            $speedalls[$Ship] = $pricelist[$Ship]['speed'] + (($pricelist[$Ship]['speed'] * $Player['impulse_motor_tech']) * 0.2);
        }
        if ($Ship == Legacies_Empire::ID_SHIP_BOMBER) {
            if ($Player['hyperspace_motor_tech'] >= 8) {
                $speedalls[$Ship] = $pricelist[$Ship]['speed2'] + (($pricelist[$Ship]['speed'] * $Player['hyperspace_motor_tech']) * 0.3);
            } else {
                $speedalls[$Ship] = $pricelist[$Ship]['speed']  + (($pricelist[$Ship]['speed'] * $Player['impulse_motor_tech']) * 0.2);
            }
        }
        if ($Ship == Legacies_Empire::ID_SHIP_BATTLESHIP || $Ship == Legacies_Empire::ID_SHIP_DESTRUCTOR ||
            $Ship == Legacies_Empire::ID_SHIP_DEATH_STAR || $Ship == Legacies_Empire::ID_SHIP_BATTLECRUISER ||
            $Ship == Legacies_Empire::ID_SHIP_SUPERNOVA) {
            $speedalls[$Ship] = $pricelist[$Ship]['speed'] + (($pricelist[$Ship]['speed'] * $Player['hyperspace_motor_tech']) * 0.3);
        }
    }
    if ($Fleet != 0 && isset($speedalls[$Ship])) {
        $ShipSpeed = $speedalls[$Ship];
        $speedalls = $ShipSpeed;
    }

    return $speedalls;
}

// ----------------------------------------------------------------------------------------------------------------
// Calcul de la consommation de base d'un vaisseau au regard des technologies
function GetShipConsumption($shipId, $player)
{
    $pricelist = Wootook_Empire_Helper_Config_Prices::getSingleton();
    if ($shipId == Legacies_Empire::ID_SHIP_LIGHT_TRANSPORT && $player->getElement(Legacies_Empire::ID_RESEARCH_IMPULSE_DRIVE) >= 5) {
        $Consumption  = $pricelist[$shipId]['consumption2'];
    } else {
        $Consumption  = $pricelist[$shipId]['consumption'];
    }

    return $Consumption;
}

// ----------------------------------------------------------------------------------------------------------------
// Calcul de la consommation de la flotte pour cette mission
function GetFleetConsumption ($FleetArray, $SpeedFactor, $MissionDuration, $MissionDistance, $FleetMaxSpeed, $Player) {

    $consumption = 0;
    $basicConsumption = 0;

    foreach ($FleetArray as $Ship => $Count) {
        if ($Ship > 0) {
            $ShipSpeed         = GetFleetMaxSpeed ( "", $Ship, $Player );
            $ShipConsumption   = GetShipConsumption ( $Ship, $Player );
            $spd               = 35000 / ($MissionDuration * $SpeedFactor - 10) * sqrt( $MissionDistance * 10 / $ShipSpeed );
            $basicConsumption  = $ShipConsumption * $Count;
            $consumption      += $basicConsumption * $MissionDistance / 35000 * (($spd / 10) + 1) * (($spd / 10) + 1);
        }
    }

    $consumption = round($consumption) + 1;

    return $consumption;
}

// ----------------------------------------------------------------------------------------------------------------
//
// Mise en forme de chaines pour affichage
//

// Mise en forme de la durée sous forme xj xxh xxm xxs
function pretty_time ($seconds) {
    $day = floor($seconds / (24 * 3600));
    $hs = floor($seconds / 3600 % 24);
    $ms = floor($seconds / 60 % 60);
    $sr = floor($seconds / 1 % 60);

    if ($hs < 10) { $hh = "0" . $hs; } else { $hh = $hs; }
    if ($ms < 10) { $mm = "0" . $ms; } else { $mm = $ms; }
    if ($sr < 10) { $ss = "0" . $sr; } else { $ss = $sr; }

    $time = '';
    if ($day != 0) { $time .= $day . 'j '; }
    if ($hs  != 0) { $time .= $hh . 'h ';  } else { $time .= '00h '; }
    if ($ms  != 0) { $time .= $mm . 'm ';  } else { $time .= '00m '; }
    $time .= $ss . 's';

    return $time;
}

// Mise en forme de la durée sous forme xxxmin
function pretty_time_hour ($seconds) {
    $min = floor($seconds / 60 % 60);

    $time = '';
    if ($min != 0) { $time .= $min . 'min '; }

    return $time;
}

// Mise en forme du temps de construction (avec la phrase de description)
function ShowBuildTime ($time) {
    global $lang;

    return "<br>". $lang['ConstructionTime'] .": " . pretty_time($time);
}

// ----------------------------------------------------------------------------------------------------------------
//
function add_points ($resources, $userid) {
    return false;
}

function remove_points ($resources, $userid) {
    return false;
}

function get_userdata () {
    return '';
}


/**
 * Gestion de la localisation des chaînes
 *
 * @param string $filename
 * @param string $extension
 * @return void
 */
function includeLang($filename, $extension = 'mo')
{
    global $lang, $user;

    $pathPattern = ROOT_PATH . "language/%s/{$filename}.%s";
    if (isset($user['lang']) && !empty($user['lang'])) {
        if (($fp = @fopen($filename = sprintf($pathPattern, $user['lang'], $extension), 'r', false)) !== false) {
            fclose($fp);

            require_once $filename;
            return $lang;
        } else if (($fp = @fopen($filename = sprintf($pathPattern, $user['lang'], 'csv'), 'r', false)) !== false) {
            while (!feof($fp)) {
                $line = fgetcsv($fp);
                if (count($line) == 2 && !empty($line[0])) {
                    $lang[$line[0]] = $line[1];
                }
            }
            fclose($fp);
            return $lang;
        }
    }

    require_once sprintf($pathPattern, DEFAULT_LANG, 'mo');
    return $lang;
}

// ----------------------------------------------------------------------------------------------------------------
//
// Affiche une adresse de depart sous forme de lien
function GetStartAdressLink ( $FleetRow, $FleetType ) {
    $Link  = "<a href=\"galaxy.php?mode=3&galaxy=".$FleetRow['fleet_start_galaxy']."&system=".$FleetRow['fleet_start_system']."\" ". $FleetType ." >";
    $Link .= "[".$FleetRow['fleet_start_galaxy'].":".$FleetRow['fleet_start_system'].":".$FleetRow['fleet_start_planet']."]</a>";
    return $Link;
}

// Affiche une adresse de cible sous forme de lien
function GetTargetAdressLink ( $FleetRow, $FleetType ) {
    $Link  = "<a href=\"galaxy.php?mode=3&galaxy=".$FleetRow['fleet_end_galaxy']."&system=".$FleetRow['fleet_end_system']."\" ". $FleetType ." >";
    $Link .= "[".$FleetRow['fleet_end_galaxy'].":".$FleetRow['fleet_end_system'].":".$FleetRow['fleet_end_planet']."]</a>";
    return $Link;
}

// Affiche une adresse de planete sous forme de lien
function BuildPlanetAdressLink ( $CurrentPlanet ) {
    $Link  = "<a href=\"galaxy.php?mode=3&galaxy=".$CurrentPlanet['galaxy']."&system=".$CurrentPlanet['system']."\">";
    $Link .= "[".$CurrentPlanet['galaxy'].":".$CurrentPlanet['system'].":".$CurrentPlanet['planet']."]</a>";
    return $Link;
}

// Création d'un lien pour le joueur hostile
function BuildHostileFleetPlayerLink ( $FleetRow ) {
    global $lang, $dpath;

    $PlayerName = doquery ("SELECT `username` FROM {{table}} WHERE `id` = '". $FleetRow['fleet_owner']."';", 'users', true);
    $Link  = $PlayerName['username']. " ";
    $Link .= "<a href=\"messages.php?mode=write&id=".$FleetRow['fleet_owner']."\">";
    $Link .= "<img src=\"".$dpath."/img/m.gif\" alt=\"". $lang['ov_message']."\" title=\"". $lang['ov_message']."\" border=\"0\"></a>";
    return $Link;
}

function GetNextJumpWaitTime ( $CurMoon ) {
    global $resource;

    $JumpGateLevel  = $CurMoon[$resource[43]];
    $LastJumpTime   = $CurMoon['last_jump_time'];
    if ($JumpGateLevel > 0) {
        $WaitBetweenJmp = (60 * 60) * (1 / $JumpGateLevel);
        $NextJumpTime   = $LastJumpTime + $WaitBetweenJmp;
        if ($NextJumpTime >= time()) {
            $RestWait   = $NextJumpTime - time();
            $RestString = " ". pretty_time($RestWait);
        } else {
            $RestWait   = 0;
            $RestString = "";
        }
    } else {
        $RestWait   = 0;
        $RestString = "";
    }
    $RetValue['string'] = $RestString;
    $RetValue['value']  = $RestWait;

    return $RetValue;
}

/**
 * Céation du lien avec popup pour la flotte
 *
 * @deprecated
 */
function CreateFleetPopupedFleetLink ( $FleetRow, $Texte, $FleetType ) {
    global $lang;

    $FleetRec     = explode(";", $FleetRow['fleet_array']);
    $FleetPopup   = "<a href='#' onmouseover=\"return overlib('";
    $FleetPopup  .= "<table width=200>";
    foreach($FleetRec as $Item => $Group) {
        if ($Group  != '') {
            $Ship    = explode(",", $Group);
            $FleetPopup .= "<tr><td width=50% align=left><font color=white>". $lang['tech'][$Ship[0]] .":<font></td><td width=50% align=right><font color=white>". pretty_number($Ship[1]) ."<font></td></tr>";
        }
    }
    $FleetPopup  .= "</table>";
    $FleetPopup  .= "');\" onmouseout=\"return nd();\" class=\"". $FleetType ."\">". $Texte ."</a>";

    return $FleetPopup;

}

// ----------------------------------------------------------------------------------------------------------------
//
// Céation du lien avec popup pour le type de mission avec ou non les ressources si disponibles
function CreateFleetPopupedMissionLink ( $FleetRow, $Texte, $FleetType ) {
    global $lang;

    $FleetTotalC  = $FleetRow['fleet_resource_metal'] + $FleetRow['fleet_resource_crystal'] + $FleetRow['fleet_resource_deuterium'];
    if ($FleetTotalC <> 0) {
        $FRessource   = "<table width=200>";
        $FRessource  .= "<tr><td width=50% align=left><font color=white>". $lang['Metal'] ."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_metal']) ."<font></td></tr>";
        $FRessource  .= "<tr><td width=50% align=left><font color=white>". $lang['Crystal'] ."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_crystal']) ."<font></td></tr>";
        $FRessource  .= "<tr><td width=50% align=left><font color=white>". $lang['Deuterium'] ."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_deuterium']) ."<font></td></tr>";
        $FRessource  .= "</table>";
    } else {
        $FRessource   = "";
    }

    if ($FRessource <> "") {
        $MissionPopup  = "<a href='#' onmouseover=\"return overlib('". $FRessource ."');";
        $MissionPopup .= "\" onmouseout=\"return nd();\" class=\"". $FleetType ."\">" . $Texte ."</a>";
    } else {
        $MissionPopup  = $Texte ."";
    }

    return $MissionPopup;
}
