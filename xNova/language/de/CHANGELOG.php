<?php

/**
 _  \_/ |\ | /¯¯\ \  / /\    |¯¯) |_¯ \  / /¯¯\ |  |   |´¯|¯` | /¯¯\ |\ |5
 ¯  /¯\ | \| \__/  \/ /--\   |¯¯\ |__  \/  \__/ |__ \_/   |   | \__/ | \|Core Redesigned.
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

$LNG['Version']     = 'Versi&oacute;n';
$LNG['Description'] = 'Descripci&oacute;n';

$LNG['changelog']   = array(

'<font color="lime" size="1" face="arial"><b>XNOVA 5.9</b></font>' => 'xNovaRevolution v5.9

- FIX: Bug norium production with commander
- FIX: Fix of fix Research time
- FIX: Recycler errors
- FIX: Fields with buildings added by Admin or Bonus Pack
- FIX: Galaxy, System and Planet error position on register with new universe
- FIX: Send Messages To Yourself by Giogio
- FIX: Fleettrader
- MOD: : CreateOnePlanetRecord Function optimized
- MOD: ShowAccountEditorPage.php code optimized

',

'<font size="1" face="arial"><b>XNOVA 5.8</b></font>' => 'xNovaRevolution Civilizations v5.8

- FIX: Battlesim by sromantr
- FIX: Small display problem on overview
- FIX: Research time
- FIX: Playercard
- FIX: Build time text css
- FIX: Image on spy raports
- FIX: Missile Attack by Idro
- FIX: Small problem in BonusPage
- FIX: MissionCaseFoundDM
- FIX: Phalanx by Idro
- FIX: Alliance image template
- FIX: Trader with norium and germanio
- FIX: JQuery Boxs
- FIX: Conoly Mission
- FIX: Apostrophe in italian messagge by Idro
- FIX: Shield can more build more than 1 by Idro
- ADD: New officiers system by D4rk0ur and Prinick
- ADD: Image of race on overview
- ADD: Darkmatter mercader
- ADD: Gultra race with +10% of production mines and -10% of building time
- ADD: Voltra race with -10% of research times and -10% of time building of ships
- MOD: General Mercader
',

'<font  size="1" face="arial"><b>XNOVA 5.7</b></font>' => 'xNovaRevolution Civilizations v5.7

- FIX: Buildings Issue by LOGAN
- FIX: Fleet Market by linksuploader
- FIX: Now, it\'s impossibleto delete a planete while any fleet action on moons
- FIX: Fleettime, if acs mission was cancel
- FIX: Fleetspeed Bonus
- FIX: Wrong moon chance on BattleSim
- FIX: Some bugs
--- Fix: GeneralFunctions.php
--- Fix: MissionCaseExpedition.php
--- Fix: common.php
--- Fix: class.ShowBuildingsPage.php
--- Fix: class.ShowShipyardPage.php
--- Fix: class.ShowFleetPages.php
--- Fix: class.ShowGalaxyPage.php
--- Fix: galaxy_overview.tpl
--- Fix: fleettrader_overview.tpl
- ADD: getMail and getExtra functions
--- Index.php
--- class.Lang.php
- ADD: Missle can now attack moons.
- ADD: A const for excluded missions on phalanx
--- constants.php
--- ShowPhalanxPage.php
- ADD: RootID now in constants
--- GeneralFunctions.php
--- constants.php
--- DeleteSelectedUser.php
--- ShowAccountEditorPage.php
--- ShowQuickEditorPage.php
--- ShowRightsPage.php
--- ShowSearchPage.php
--- ShowUniversePage.php
- ADD: Race System
--- Add: Races in overview
--- Add: Races in statistics
--- Add: Race in playercard
--- Add: Individual skin by race
-----> Voltra skin by Brayan Narvaez (Planets helps by david)
- ADD: Officier System (Based on Jstar code), rewrite some codes for xNova (25%)
--- Add: Commander improved
--- Add: Darkmatter buy
- MOD: Improved galaxy
- MOD: Black Market (10%)
',

'<font size="1" face="arial"><b>XNOVA 5.6</b></font>' => 'xNovaRevolution Redesign v5.6

- DIV: Template kernel
- MOD: Energy on topnav
- MOD and FIX: Fleet Trader - V1.0 by linksuploader
- FIX: Computation research time
- FIX: Query() error on ShowConfigPage.php
- FIX: Calculate Steal
- FIX: Recycling
- FIX: Resource Production Bonus From Research  by Gian
- FIX: Add slots for ACS in Battlesim by Giogio
- FIX: Fixed field hack
- FIX: Install by  Asfo
- FIX: Update of messages by Giogio
- FIX: Some problems with vars.php
- FIX: Fleet dublicate bug
- FIX: Research big error
- FIX: Jump Gate by linksuploader
- FIX: Firefox 6+ problems style on inputs in hangar
- FIX: Phalanx by linksuploader
- FIX: Reduction from tech research from university by linksuploader
- SECURITY: SQL Injections in Moons and Planets
',

'<font size="1" face="arial"><b>XNOVA 5.5</b></font>' => 'xNovaRevolution Redesign v5.5

- ADD: Slovenian language by _pandorax_
- MOD: Color resources on Topnav
- FIX: Banned page, template redesign.
- FIX: Send missile when target is vacation
- FIX: Fleet1 Page on some browsers
- FIX: Position of Missile Action by kmti212
- FIX: Nano Factory by kmti212
- FIX: Excessive time on buildings, research, etc..
- FIX: TECH.php lang FR by cricriweb
- FIX: Email text lang IT by fzozzen
- FIX: TECH.php lang IT by killer99
- FIX: Ro language by Alin
- FIX: BattleEngine
- FIX: Sessions
- FIX: Query() problem on Buildings and Research list
- FIX: Lang PT by g0mes
',

'<font size="1" face="arial">XNOVA 5.4</font>' => 'xNovaRevolution Redesign v5.4

- MOD: New display current missions on fleet page
- DIV: MissionCaseDestruction Security Hole
- FIX: FlyingFleets Table add resource info by kmti212
- FIX: Show resources on builds by kmti212
- FIX: ReseachPage Bug by kmti212
- FIX: Current resources on Topnav by kmti212
- FIX: Redesign for others languages
- FIX: Destroy build level 0
- FIX: Ghost ship on fleets
- FIX: CombatRaports on hallf of fame whites by kmti212
- FIX: Global styles .css by kmti212
- FIX: All javascript problems
- FIX: Recycle problem
- FIX: MissionCaseDestruction	
- FIX: Jump Cuantic link Dialog
- FIX: Phalanx
- FIX: Defended planet mission SQL problem
- FIX: Sintax on MissionCaseAttack
- FIX: Mission Expedition Icon on fleets
- FIX: Send message and count characters of buddy

This version is stable, all bugs of version redesigned beta is solved.
',

'<font size="1" face="arial">XNOVA 5.3</font>' => 'xNovaRevolution Redesign v5.3
- ADD: New order templates
- ADD: Key Galaxy javascript by giogio
- ADD: Own images to the redesign
- ADD: Rewritten all the design with xHTML 5 and CSS3
- ADD: Buy bonus by darkmatter
- MOD: Light optimizations
- MOD: Rewritten texts
- MOD: Ships for groups
- DIV: Fixes for better indexing
- FIX: Error on ShowAccountDataPage
- FIX: Time of nanobots constructions
- FIX: Research warning by giogio
- FIX: No resource Expedition by kmti212
- FIX: Dialog Playcard Galaxy by giogio
- FIX: Crystal debris
- FIX: Battlesim
- FIX: Found ships on Expedition
- FIX: PlanetRessUpdate
- FIX: Fleet error
- FIX: Research building list by giogio
- FIX: Recycler mission by kmti212
- FIX: Division by zero and Wrong Max Energy by Norium by kmti212
- FIX: Adm fleet bug by kmti212

<b>Important:</b> The images of structures, defense, technology, ships and some property owners are Gameforge GmbH.

The design was created by <a href="http://princk.deviantart.com/" target="_blank">Brayan Narv&aacute;ez</a> on 17/09/2011.<br />
',

'<font size="1" face="arial">XNOVA 5.2</font>' => 'xNovaRevolution v5.2
- ADD: New Factor System
- ADD: New research for norio production
- ADD: Multilang to Raports
- ADD: Emergency root login
- ADD: New calculation for moonsize
- ADD: New layouts and some mods
- ADD: jQuery System
- MOD: Improved AdminAttack Protection
- MOD: Improved XNOVA Kernel
- MOD: Improved Missions
- MOD: Improved Skin Selector
- MOD: Improved Missions
- MOD: Rewrite QueueSystem
- MOD: Display fleets in enemy planets by Ropnom
- MOD: Improved style and a small function on GenerateReport by CoderFinger
- DEL: Deleted all Officiers System
- FIX: Division by Zero bug
- FIX: Names of Universe
- FIX: Alliance Create on Multi Universe
- FIX: Phalanx 
- FIX: Wrong UserCount, if a new player joins the game
- FIX: Dropped HyperSpeed for ShipBulid (Fixed BCMath Iusses)
- FIX: ResearchQueue (1st)
- FIX: MultiUniverse Glitches
- FIX: Galaxy
- FIX: Clear Users
- FIX: University time
- FIX: Times of construction
- FIX: Derbis Collect
- FIX: Build Rockets
- FIX: No build ships and defenses
- FIX: Energy used on Imperium
- FIX: FleetTrader
- FIX: ACS
- FIX: Missions
- FIX: .5 Floating Bug
- FIX: Research List in colonies (ResearchQueue (2st))
- FIX: Ressource Storage be now display correct, if Tech or Shipyard = 0 
- FIX: Fixed Del Ships, if you have same Jobs
- FIX: Moon destruction mission
- FIX: Resource Update on options
- FIX: Fleets
- FIX: Alliance settings
- FIX: Bug in MultiUniverses there maks impossible to grap a Debris from Menu
- FIX: Css styles in Opera
- FIX: Calculations of Maximum Rockets
- FIX: Instant Logout on some servers
- FIX: Missed Facotr Calculation
- FIX: Solarsats on moons give now energy
- FIX: Bug where Labor cant Build after Research Cancels
- FIX: Combat Extras
- FIX: FirePHP Log System
- FIX: Time on messages
- FIX: UTF8 names on fleet shortcuts
- FIX: Alliance mails 
- FIX: Modules in Galaxy
- FIX: Search page
- FIX: Attackbonus on Missions
- FIX: Incorrect display of reycler fleets
- FIX: Button logout in Admin Panel
- FIX: Negative time of fleets
- FIX: Battlesim
- FIX: Clear planets after spy
- FIX: SQL Error on FleetBack, if fleet is on a acs
- FIX: JS Error on Combat Raports
- FIX: Tag and Name with spaces in Alliance
- FIX: Real Energy
- FIX: Norio Storage on Resources Page
- FIX: Universe names in Admin Panel by Ropnom
- FIX: Calculate Steal with Norio by Ropnom
- FIX: Send message of missions
- FIX: Building missiles
- FIX: Ressource cheat and dublicate shields
- FIX: Fleet tables
- FIX: Mission stay
',

'<font size="1" face="arial">XNOVA 5.1</font>' => 'xNovaRevolution v5.1
- ADD: FirePHP Log System
- ADD: New pack of spanish language
- ADD: New language RO by alin
- ADD: Trader with norium
- ADD: Login of xNova Revolution Redesigned
--> Added the rules page
--> Added the T&C page
- MOD: Optimized CheckPlanetIfExist Function
- MOD: Images techtree page by Barradas
- MOD: Number format in trader
- MOD: Button max in hangar and defense
- FIX: Lostpassword page
- FIX: Norium-Energy stability
- FIX: Fleets in Overview
- FIX: Reset of Universe with Norium
- FIX: Recycle Mission
- FIX: Language refresh in buildings
- FIX: Admin page white and languages option
- FIX: Battle Engine
- FIX: Message new alliance
- FIX: Change name in options
- FIX: Raport_* files deletion
- FIX: JS Error on FleetTrader
- FIX: Ressource Cheat
- FIX: Multiply Messages
- FIX: Defender bonus on combats
- FIX: Redirect on Messages
- FIX: Unable to send recylers to vacation players
- FIX: Cencored coors on hall of frame know correctly
- FIX: Mine Informations
- FIX: Shipspeed Officier
- FIX: Alliance Mangement in Admin Panel
- FIX: Missle Cheat
- FIX: Phalanx WebCommit
- FIX: Register on lange Unis
- FIX: Alliance SaveBug
- FIX: Statbuldier
- FIX: Enable MySQL Exceptions
- FIX: Combat report template
- FIX: Data Account File
- FIX: Battlesim style
- FIX: Del Unmarked Messages
- FIX: Language RU by spaceomega
',

'<font size="1" face="arial">XNOVA 5.0</font>' => 'xNovaRevolution v5.0
- ADD: New pack of spanish language
- ADD: News templates
- ADD: New pages of Login, Register and Lostpassword
- ADD: New mine form Norio
- ADD: New store from Norio
- ADD: New resource "Norio"
--> Norio in Missions of Attack, Transport, Recycle, Spy, etc.
--> Can be constructed buildings, research, fleets and defenses with Norio
- ADD: Template Core of xNova Revolution
- ADD: Images origin of xNova Revolution
- ADD: New research "Extraction of DarkMatter"
- MOD: New skin created from gow
- MOD: Officiers in time
- DIV: Update Spanish language
- FIX: Language variable errors
- FIX: CSS Internet Explorer Compatibility

New version of 2moons created by <a href="http://princk.deviantart.com/" target="_blank">Brayan Narv&aacute;ez</a> on 19/04/2011.<br />
',
);
?>