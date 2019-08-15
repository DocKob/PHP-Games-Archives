<?php //config.php
/* --------------------------------------------------------------------------------------
                                      BASIC CONFIGURATION
   Credits         : phpSGEx by Aldrigo Raffaele
   Last modified by: raffa50 11.06.2013
   Comments        : Sorted, added subsystem flags, added resource icon image directory
-------------------------------------------------------------------------------------- */

define("conf_ver", "101");
//not changable
define("MAP_SYS", "%MAP%");    // 1 ogame/drogame, 2 travian/devana/tribals, 3 grepolis/ikariam
define("CITY_SYS", "%CTS%");  // 1 ogame, 2 travian/grepolis/ikariam
define("MAX_FIELDS", "15");  //only if city sys = 2

//registration page
define("REG_PAGE", "register.php");

//changable
define("LANG", "%LANG%");

//images
define("IRACE", "./img/races/");
define("IBUD", "./img/structures/");
define("IUNT", "./img/units/");
define("IRSC", "./img/research/");
define("IRES", "./img/icons/");
define("IBTN", "./img/buttons/");

//SQL Server Defination (not changable)
define("SQL_SERVER", "%SSERVER%");
define("SQL_USER", "%SUSER%");
define("SQL_PASS", "%SPASS%");
define("SQL_DB", "%SDB%");
define("TB_PREFIX", "%PREFIX%");
?>
