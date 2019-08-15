<?php
//$Id: config.php 62 2006-02-02 20:00:44Z themightydude $
error_reporting(0);
//ini_set('display_errors', 0);

include("db_config.php");
include("$ADOdbpath" . "/adodb.inc.php");

/* Main scheduler variables (game flow control)
-----------------------------------------------*/

/*
  Set this to how often (in minutes) you are running
  the scheduler script.
*/
$sched_ticks = 6;

/* All following vars are in minutes.
   These are TRUE minutes, no matter to what interval
   you're running the scheduler script! The scheduler
   will auto-adjust, possibly running many of the same
   events in a single call.
*/
$sched_turns = 2;    //New turns rate (also includes towing, xenobe)
$sched_ports = 2;    //How often port production occurs
$sched_planets = 2;  //How often planet production occurs
$sched_igb = 2;      //How often IGB interests are added
$sched_ranking = 30; //How often rankings will be generated
$sched_news = 15;    //How often news are generated
$sched_degrade = 6;  //How often sector fighters degrade when unsupported by a planet
$sched_apocalypse = 15;
$doomsday_value = 90000000; // number of colonists a planet needs before being affected by the apocalypse

/* Scheduler config end */

/* GUI colors (temporary until we have something nicer) */
$color_header = "#500050";
$color_line1 = "#300030";
$color_line2 = "#400040";

/* Localization (regional) settings */
$local_number_dec_point = ".";
$local_number_thousands_sep = ",";
$language = "english";

/* game variables */
$ip = getenv("REMOTE_ADDR");
$mine_hullsize = 8; //Minimum size hull has to be to hit mines
$ewd_maxhullsize = 15; //Max hull size before EWD degrades
$sector_max = 5000;
$link_max=10;
$universe_size = 200;

$game_name = "Default Game Name"; // Please set this to a unique name for your game
$release_version = "0.55";     // Please do not change this. Doing so will cause problems for the server lists, and setupinfo, and more.

$fed_max_hull = 8;
$maxlen_password = 16;
$max_rank=100;
$rating_combat_factor=.8;    //ammount of rating gained from combat
$server_closed=false;        //true = block logins but not new account creation
$account_creation_closed=false;    //true = block new account creation


/* newbie niceness variables */
$newbie_nice = "YES";
$newbie_extra_nice = "YES";
$newbie_hull = "8";
$newbie_engines = "8";
$newbie_power = "8";
$newbie_computer = "8";
$newbie_sensors = "8";
$newbie_armor = "8";
$newbie_shields = "8";
$newbie_beams = "8";
$newbie_torp_launchers = "8";
$newbie_cloak = "8";

/* specify which special features are allowed */
$allow_fullscan = true;                // full long range scan
$allow_navcomp = true;                 // navigation computer
$allow_ibank = true;                  // Intergalactic Bank (IGB)
$allow_genesis_destroy = true;         // Genesis torps can destroy planets

// iBank Config - Intergalactic Banking
// Trying to keep ibank constants unique by prefixing with $ibank_
// Please EDIT the following variables to your liking.

$ibank_interest = 0.0003;           // Interest rate for account funds NOTE: this is calculated every system update!
$ibank_paymentfee = 0.05;       // Paymentfee
$ibank_loaninterest = 0.0010;       // Loan interest (good idea to put double what you get on a planet)
$ibank_loanfactor = 0.10;           // One-time loan fee
$ibank_loanlimit = 0.25;        // Maximum loan allowed, percent of net worth

// Information displayed on the 'Manage Own Account' section
$ibank_ownaccount_info = "Interest rate is " . $ibank_interest * 100 . "%<BR>Loan rate is " .
$ibank_loaninterest * 100 . "%<P>If you have loans Make sure you have enough credits deposited each turn " .
  "to pay the interest and mortage, otherwise it will be deducted from your ships acccount at <FONT COLOR=RED>" .
  "twice the current Loan rate (" . $ibank_loaninterest * 100 * 2 .")%</FONT>.";

// end of iBank config

// default planet production percentages
$default_prod_ore      = 20.0;
$default_prod_organics = 20.0;
$default_prod_goods    = 20.0;
$default_prod_energy   = 20.0;
$default_prod_fighters = 10.0;
$default_prod_torp     = 10.0;

/* port pricing variables */
$ore_price = 11;
$ore_delta = 5;
$ore_rate = 75000;
$ore_prate = 0.25;
$ore_limit = 100000000;

$organics_price = 5;
$organics_delta = 2;
$organics_rate = 5000;
$organics_prate = 0.5;
$organics_limit = 100000000;

$goods_price = 15;
$goods_delta = 7;
$goods_rate = 75000;
$goods_prate = 0.25;
$goods_limit = 100000000;

$energy_price = 3;
$energy_delta = 1;
$energy_rate = 75000;
$energy_prate = 0.5;
$energy_limit = 1000000000;

$inventory_factor = 1;
$upgrade_cost = 1000;
$upgrade_factor = 2;
$level_factor = 1.5;

$dev_genesis_price = 1000000;
$dev_beacon_price = 100;
$dev_emerwarp_price = 1000000;
$dev_warpedit_price = 100000;
$dev_minedeflector_price = 10;
$dev_escapepod_price = 100000;
$dev_fuelscoop_price = 100000;
$dev_lssd_price = 10000000;

$fighter_price = 50;
$fighter_prate = .01;

$torpedo_price = 25;
$torpedo_prate = .025;
$torp_dmg_rate = 10;

$credits_prate = 3.0;

$armor_price = 5;
$basedefense = 1;  // Additional factor added to tech levels by having a base on your planet. All your base are belong to us.

$colonist_price = 5;
$colonist_production_rate = .005;
$colonist_reproduction_rate = 0.0005;
$colonist_limit = 100000000;
$organics_consumption = 0.05;
$starvation_death_rate = 0.01;

$interest_rate = 1.0005;

$base_ore = 10000;
$base_goods = 10000;
$base_organics = 10000;
$base_credits = 10000000;
$base_modifier = 1;

$start_fighters = 10;
$start_armor = 10;
$start_credits = 1000;
$start_energy = 100;
$start_turns = 1200;

$max_turns = 2500;
$max_emerwarp = 10;

$fullscan_cost = 1;
$scan_error_factor=20;

$max_planets_sector = 5;
$max_traderoutes_player = 40;

$min_bases_to_own = 3;

$default_lang = 'english';

$avail_lang[0]['file'] = 'english';
$avail_lang[0]['name'] = 'English';
$avail_lang[1]['file'] = 'french';
$avail_lang[1]['name'] = 'Francais';
$avail_lang[2]['file'] = 'spanish';
$avail_lang[2]['name'] = 'Spanish';

$IGB_min_turns = $start_turns; //Turns a player has to play before ship transfers are allowed 0=disable
$IGB_svalue = 0.15; //Max amount of sender's value allowed for ship transfers 0=disable
$IGB_trate = 1440; //Time (in minutes) before two similar transfers are allowed for ship transfers.0=disable
$IGB_lrate = 1440; //Time (in minutes) players have to repay a loan
$IGB_tconsolidate = 10; //Cost in turns for consolidate : 1/$IGB_consolidate
$corp_planet_transfers = 0; //If transferring credits to/from corp planets is allowed. 1=enable
$min_value_capture = 0; //Percantage of planet's value a ship must be worth to be able to capture it. 0=disable
$defence_degrade_rate = 0.05;
$energy_per_fighter = 0.10;
$bounty_maxvalue = 0.15; //Max amount a player can place as bounty - good idea to make it the same as $IGB_svalue. 0=disable
$bounty_ratio = 0.75; // ratio of players networth before attacking results in a bounty. 0=disable
$bounty_minturns = 500; // Minimum number of turns a target must have had before attacking them may not get you a bounty. 0=disable
$display_password = false; // If true, will display password on signup screen.
$space_plague_kills = 0.20; // Percentage of colonists killed by space plague
$max_credits_without_base = $base_credits; // Max amount of credits allowed on a planet without a base
$sofa_on = false;
$ksm_allowed = true;

$xenobe_max = 0;           // Sets the number of xenobe in the universe - rjordan
$xen_start_credits = 1000000;         // What Xenobe start with - rjordan
$xen_unemployment = 100000;   // Amount of credits each xenobe receive on each xenobe tick - rjordan
$xen_aggression = 100;                // Percent of xenobe that are aggressive or hostile - rjordan
$xen_planets = 5;                     //Percent of created xenobe that will own planets. Recommended to keep at small percentage - rjordan
$xenstartsize = 15;                   // Max starting size of Xenobes at universe creation

include("global_funcs.php");
?>
