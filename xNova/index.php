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
 
if (isset($_GET['action']) && $_GET['action'] == 'keepalive')
{
	header('Content-Type: image/gif');
	exit("\x47\x49\x46\x38\x39\x61\x01\x00\x01\x00\x80\x00\x00\x00\x00\x00\x00\x00\x00\x21\xF9\x04\x01\x00\x00\x00\x00\x2C\x00\x00\x00\x00\x01\x00\x01\x00\x00\x02\x02\x44\x01\x00\x3B");
}

define('INSIDE', true );
define('LOGIN', true );

define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');

if(!file_exists(ROOT_PATH.'includes/config.php')) {
	header('Location: install.php?lang=es');
	exit;
}

require(ROOT_PATH . 'includes/common.php');
	
$template	= new template();
$template->cache = true;
$THEME->isHome();
$page = request_var('page', '');
$mode = request_var('mode', '');

switch ($page) {
	case 'lostpassword': 
		if ($mode == "send") {
			$USERmail = request_var('email', '');
			$Universe = request_var('universe', 0);
			$ExistMail = $db->uniquequery("SELECT `username` FROM ".USERS." WHERE `email` = '".$db->sql_escape($USERmail)."' AND `universe` = '".$Universe."';");
			if (empty($ExistMail['username'])) {
				$template->message($LNG['mail_not_exist'], "index.php?page=lostpassword&lang=".$LANG->getUser(), 3, true);
			} else {
				$Caracters = "aazertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN1234567890";
				$Count = strlen($Caracters);
				$Taille = 8;
				$NewPass = "";
				for($i = 0; $i < $Taille; $i ++) {
					$CaracterBoucle = rand ( 0, $Count - 1 );
					$NewPass .= substr ( $Caracters, $CaracterBoucle, 1 );
				}

				$MailRAW		= file_get_contents("./language/".$CONF['lang']."/email/email_lost_password.txt");
				$MailContent	= sprintf($MailRAW, $ExistMail['username'], $CONF['game_name'], $NewPass, "http://".$_SERVER['SERVER_NAME'].$_SERVER["PHP_SELF"]);			
			
				$Mail			= MailSend($USERmail, $ExistMail['username'], $LNG['mail_title'], $MailContent);
				
				if(true === true)
				{
					$db->query("UPDATE ".USERS." SET `password` ='" . md5($NewPass) . "' WHERE `username` = '".$ExistMail['username']."' AND `universe` = '".$Universe."';");
					$template->message($LNG['mail_sended'], "./?lang=".$LANG->getUser(), 5, false);
				} else {
					$template->message($LNG['mail_sended_fail'], "./?lang=".$LANG->getUser(), 5, true);
				}
			
			}
		} else {
			$AvailableUnis[$CONF['uni']]	= $CONF['uni_name'].($CONF['game_disable'] == 0 ? $LNG['uni_closed'] : '');
			$Query	= $db->query("SELECT `uni`, `game_disable`, `uni_name` FROM ".CONFIG." WHERE `uni` != '".$UNI."' ORDER BY `uni` ASC;");
			while($Unis	= $db->fetch_array($Query)) {
				$AvailableUnis[$Unis['uni']]	= $Unis['uni_name'].($Unis['game_disable'] == 0 ? $LNG['uni_closed'] : '');
			}
			ksort($AvailableUnis);
			$year = date(Y);
			$asd = "xNova Revolution";
			$template->assign_vars(array(
				'email'				=> $LNG['email'],
				'uni_reg'			=> $LNG['uni_reg'],
				'send'				=> $LNG['send'],
				'AvailableUnis'		=> $AvailableUnis,
				'chose_a_uni'		=> $LNG['chose_a_uni'],
				'lost_pass_title'	=> $LNG['lost_pass_title'],
				'year'		=> $year,
				'asd'	=> $asd,				
			));
			$template->show('lostpassword.tpl');
		}
		break;
	case 'reg' :
		if ($CONF['reg_closed'] == 1){
			$year = date(Y);
			$asd = "xNova Revolution";
			$template->assign_vars(array(
				'closed'	=> $LNG['reg_closed'],
				'info'		=> $LNG['info'],
				'year' => $year,
				'asd' => $asd,
			));
			$template->show('registry_closed.tpl');
			exit;
		}
		switch ($mode) {
			case 'send' :
				$UserPass 	= request_var('password', '');
				$UserPass2 	= request_var('password2', '');
				$UserName 	= request_var('character', '', UTF8_SUPPORT);
				$UserPlanet	= request_var('planet', '', UTF8_SUPPORT);
				$UserEmail 	= request_var('email', '');
				$UserEmail2	= request_var('email2', '');
				$agbrules 	= request_var('rgt', '');
				$UserLang 	= request_var('lang', '');
				$Raza   = request_var('raza', '');
				$Universe 	= request_var('universe', 0);
					
				$Exist['userv'] = $db->uniquequery("SELECT username, email FROM ".USERS." WHERE `universe` = '".$Universe."' AND (username = '".$db->sql_escape($UserName)."' OR email = '".$db->sql_escape($UserEmail)."');");
				$Exist['valid'] = $db->uniquequery("SELECT username, email FROM ".USERS_VALID." WHERE `universe` = '".$Universe."' AND (username = '".$db->sql_escape($UserName)."' OR email = '".$db->sql_escape($UserEmail)."');");
				
				$errors 	= '';
				$errors	   .= !ValidateAddress($UserEmail) ? $LNG['invalid_mail_adress'] : '';
				$errors	   .= empty($UserName) ? $LNG['empty_user_field'] : '';
				$errors	   .= empty($UserPlanet) ? 	$LNG['empty_planet_field'] : '';			
				$errors	   .= !isset($UserPass{5}) ? $LNG['password_lenght_error'] : '';					
				$errors	   .= $UserPass != $UserPass2 ? $LNG['different_passwords'] : '';				
				$errors	   .= $UserEmail != $UserEmail2 ? $LNG['different_mails'] : '';		
				$errors	   .= $agbrules != 'on' ? sprintf($LNG['terms_and_conditions'], $LANG->getUser()) : '';
				$errors    .= (isset($Exist['userv']['username']) || isset($Exist['valid']['username']) && ($UserName == $Exist['userv']['username'] || $UserName == $Exist['valid']['username'])) ? $LNG['user_already_exists'] : '';
				$errors    .= (isset($Exist['userv']['email']) || isset($Exist['valid']['email'])) && ($UserEmail == $Exist['userv']['email'] || $UserEmail == $Exist['valid']['email']) ? $LNG['mail_already_exists'] : '';
				
				if (!CheckName($UserName))
					$errors .= (UTF8_SUPPORT) ? $LNG['user_field_no_space'] : $LNG['user_field_no_alphanumeric'];				
				
				if (!CheckName($UserPlanet))
					$errors .= (UTF8_SUPPORT) ? $LNG['planet_field_no_space'] : $LNG['planet_field_no_alphanumeric'];			
								
				if (!empty($errors)) {
					$template->message($errors, '?page=reg&lang='.$LANG->getUser(), 3, true);
					exit;
				}
				
				$md5newpass = md5($UserPass);
					
				$clef	= uniqid('2m');

				$SQL = "INSERT INTO ".USERS_VALID." SET ";
				$SQL .= "`username` = '".$db->sql_escape($UserName)."', ";
				$SQL .= "`email` = '".$db->sql_escape($UserEmail)."', ";
				$SQL .= "`lang` = '".$db->sql_escape($UserLang)."', ";
				$SQL .= "`raza` = '".$db->sql_escape($Raza)."', ";
				$SQL .= "`planet` = '".$db->sql_escape($UserPlanet)."', ";
				$SQL .= "`date` = '".TIMESTAMP."', ";
				$SQL .= "`cle` = '".$clef."', ";
				$SQL .= "`universe` = '".$Universe."', ";
				$SQL .= "`password` = '".$md5newpass."', ";
				$SQL .= "`ip` = '".$_SERVER['REMOTE_ADDR']."'; ";
				$db->query($SQL);
				
				if($CONF['user_valid'] == 0 || $CONF['mail_active'] == 0) {
					redirectTo("index.php?page=reg&mode=valid&lang=".$UserLang."&clef=".$clef);
				} else {
					$MailSubject 	= $LNG['reg_mail_message_pass'];
					#$MailRAW		= file_get_contents("./language/".$UserLang."/email/email_vaild_reg.txt");
					$MailRAW		= $LANG->getMail('email_vaild_reg');
					$MailContent	= sprintf($MailRAW, $UserName, $CONF['game_name'].' - '.$CONF['uni_name'], "http://".$_SERVER['SERVER_NAME'].$_SERVER["PHP_SELF"], $clef, $UserPass, $CONF['smtp_sendmail'], $UserLang);
			
					MailSend($UserEmail, $UserName, $MailSubject, $MailContent);
					$template->message($LNG['reg_completed'], '?lang='.$UserLang, 10, true);
				}								
			break;
			case 'valid' :		
				$pseudo 	= request_var('id', '');
				$clef 		= request_var('clef', '');
				$admin 	 	= request_var('admin', 0);
				$Valider       = $db->uniquequery("SELECT `username`, `password`, `email`, `ip`, `planet`, `lang`, `raza`, `universe` FROM ".USERS_VALID." WHERE `cle` = '".$db->sql_escape($clef)."';");
				if(!isset($Valider)) 
					redirectTo('index.php?page=reg');
				
				$UserName 	= $Valider['username'];
				$UserPass 	= $Valider['password'];
				$UserMail 	= $Valider['email'];
				$UserIP 	= $Valider['ip'];
				$UserPlanet	= $Valider['planet'];
				$UserLang 	= $Valider['lang'];
				$Raza   = $Valider['raza'];
				$UserUni 	= $Valider['universe'];
				$CONF		= $db->uniquequery("SELECT `users_amount`, `initial_fields`, `LastSettedGalaxyPos`, `LastSettedSystemPos`, `LastSettedPlanetPos`, `mail_active`, `mail_use`, `smail_path`, `smtp_host`, `smtp_port`, `smtp_user`, `smtp_pass`, `smtp_ssl`, `smtp_sendmail`, `game_name`, `users_amount`, `metal_basic_income`, `crystal_basic_income`, `deuterium_basic_income` FROM ".CONFIG." WHERE `uni` = ".$UserUni.";");
				
				$SQL = "INSERT INTO " . USERS . " SET ";
				$SQL .= "`username` = '".$UserName . "', ";
				$SQL .= "`universe` = '".$UserUni . "', ";
				$SQL .= "`email` = '".$UserMail."', ";
				$SQL .= "`email_2` = '".$UserMail."', ";
				$SQL .= "`lang` = '".$UserLang."', ";
				$SQL .= "`raza` = '".$Raza."', ";
				$SQL .= "`ip_at_reg` = '".$UserIP."', ";
				$SQL .= "`id_planet` = '0', ";
				$SQL .= "`onlinetime` = '".TIMESTAMP."', ";
				$SQL .= "`register_time` = '".TIMESTAMP. "', ";
				$SQL .= "`password` = '".$UserPass."', ";
				$SQL .= "`dpath` = '".DEFAULT_THEME."', ";
				$SQL .= "`darkmatter` = '".$CONF['darkmatter_start']."', ";
				$SQL .= "`uctime`= '0';";
				$db->query($SQL);
				$NewUser = $db->GetInsertID();
				if($CONF['mail_active'] == 1) {
					$MailSubject	= sprintf($LNG['reg_mail_reg_done'], $CONF['game_name']);	
					#$MailRAW		= file_get_contents("./language/".$UserLang."/email/email_reg_done.txt");
					$MailRAW		= $LANG->getMail('email_reg_done');
					$MailContent	= sprintf($MailRAW, $UserName, $CONF['game_name'].' - '.$CONF['uni_name']);
					MailSend($UserMail, $UserName, $MailSubject, $MailContent);
				}
				$LastSettedGalaxyPos = $CONF['LastSettedGalaxyPos'];
				$LastSettedSystemPos = $CONF['LastSettedSystemPos'];
				$LastSettedPlanetPos = $CONF['LastSettedPlanetPos'];
				require_once(ROOT_PATH.'includes/functions/CreateOnePlanetRecord.php');	
				$PlanetID = false;
				
				while ($PlanetID === false) {
					$Planet = mt_rand(4, 12);
									
					if ($LastSettedPlanetPos < 3) {
						$LastSettedPlanetPos += 1;
					} else {
						if ($LastSettedSystemPos > $CONF['max_system']) {
							$LastSettedGalaxyPos += 1;
							$LastSettedSystemPos = 1;
							$LastSettedPlanetPos = 1;
						} else {
							$LastSettedSystemPos += 1;
							$LastSettedPlanetPos = 1;
						}
						
						if($LastSettedGalaxyPos  > $CONF['max_system'])
							$LastSettedGalaxyPos	= 1;
					}
					
					$PlanetID = CreateOnePlanetRecord($LastSettedGalaxyPos, $LastSettedSystemPos, $Planet, $UserUni, $NewUser, $UserPlanet, true);
				}
			
				$SQL = "DELETE FROM ".USERS_VALID." WHERE `cle` = '".$db->sql_escape($clef)."';";
				$SQL .= "UPDATE ".USERS." SET ";
				$SQL .= "`id_planet` = '".$PlanetID."', ";
				$SQL .= "`galaxy` = '".$LastSettedGalaxyPos."', ";
				$SQL .= "`system` = '".$LastSettedSystemPos."', ";
				$SQL .= "`planet` = '".$Planet."' ";
				$SQL .= "WHERE ";
				$SQL .= "`id` = '".$NewUser."' ";
				$SQL .= "LIMIT 1;";
				$SQL .= "INSERT INTO ".STATPOINTS." (`id_owner`, `id_ally`, `stat_type`, `universe`, `tech_rank`, `tech_old_rank`, `tech_points`, `tech_count`, `build_rank`, `build_old_rank`, `build_points`, `build_count`, `defs_rank`, `defs_old_rank`, `defs_points`, `defs_count`, `fleet_rank`, `fleet_old_rank`, `fleet_points`, `fleet_count`, `total_rank`, `total_old_rank`, `total_points`, `total_count`) VALUES (".$NewUser.", 0, 1, ".$UserUni.", '".($CONF ['users_amount'] + 1)."', '".($CONF ['users_amount'] + 1)."', 0, 0, '".($CONF ['users_amount'] + 1)."', '".($CONF ['users_amount'] + 1)."', 0, 0, '".($CONF ['users_amount'] + 1)."', '".($CONF ['users_amount'] + 1)."', 0, 0, '".($CONF ['users_amount'] + 1)."', '".($CONF ['users_amount'] + 1)."', 0, 0, '".($CONF ['users_amount'] + 1)."', '".($CONF ['users_amount'] + 1)."', 0, 0);";
				$db->multi_query($SQL);
				
				$from 		= $LNG['welcome_message_from'];
				$Subject 	= $LNG['welcome_message_subject'];
				$message 	= sprintf($LNG['welcome_message_content'], $CONF['game_name']);
				SendSimpleMessage($NewUser, 1, $Time, 1, $from, $Subject, $message);
				
				update_config(array('users_amount' => $CONF['users_amount'] + 1, 'LastSettedGalaxyPos' => $LastSettedGalaxyPos, 'LastSettedSystemPos' => $LastSettedSystemPos, 'LastSettedPlanetPos' => $LastSettedPlanetPos), false, $UserUni);
				if ($admin == 1) {
					echo sprintf($LNG['user_active'], $UserName);
				} else {
					session_start();
					$SESSION       	= new Session();
					$SESSION->CreateSession($NewUser, $UserName, $PlanetID, $UserUni);

					redirectTo("game.php?page=overview");
				}
			break;
			default:
				$AvailableUnis[$CONF['uni']]	= $CONF['uni_name'].($CONF['game_disable'] == 0 ? $LNG['uni_closed'] : '');
				$Query	= $db->query("SELECT `uni`, `game_disable`, `uni_name` FROM ".CONFIG." WHERE `uni` != '".$UNI."' ORDER BY `uni` ASC;");
				while($Unis	= $db->fetch_array($Query)) {
					$AvailableUnis[$Unis['uni']]	= $Unis['uni_name'].($Unis['game_disable'] == 0 ? $LNG['uni_closed'] : '');
				}
				ksort($AvailableUnis);
				$year = date(Y);
			    $asd = "xNova Revolution";
				$template->assign_vars(array(
					'server_message_reg'			=> $LNG['server_message_reg'],
					'register_at_reg'				=> $LNG['register_at_reg'],
					'user_reg'						=> $LNG['user_reg'],
					'pass_reg'						=> $LNG['pass_reg'],
					'pass2_reg'						=> $LNG['pass2_reg'],
					'email_reg'						=> $LNG['email_reg'],
					'email2_reg'					=> $LNG['email2_reg'],
					'planet_reg'					=> $LNG['planet_reg'],
					'lang_reg'						=> $LNG['lang_reg'],
					'raza_reg'                         => $LNG['raza_reg'],
					'raza_0'                             => $LNG['raza_0'],
					'raza_1'                             => $LNG['raza_1'],
					'register_now'					=> $LNG['register_now'],
					'accept_terms_and_conditions'	=> sprintf($LNG['accept_terms_and_conditions'], $LANG->getUser()),
					'AvailableUnis'					=> $AvailableUnis,
					'AvailableLangs'				=> $LANG->getAllowedLangs(false),
					'uni_reg'						=> $LNG['uni_reg'],
					'chose_a_uni'					=> $LNG['chose_a_uni'],
					'register'						=> $LNG['register'],
					'send'							=> $LNG['send'],
					'uni_closed'					=> $LNG['uni_closed'],
					'year'							=> $year,
					'asd'					=> $asd,
				));
				$template->show('registry_form.tpl');
			break;
		}
		break;
	case 'agb' :
		$template->assign_vars(array(
			'agb'				=> $LNG['agb'],
			'agb_overview'		=> $LNG['agb_overview'],
		));
		$template->show('index_agb.tpl');
		break;
	case 'rules' :
		$template->assign_vars(array(
			'rules'				=> $LNG['rules'],
			'rules_overview'	=> $LNG['rules_overview'],
			'rules_info1'		=> sprintf($LNG['rules_info1'], $CONF['forum_url']),
			'rules_info2'		=> $LNG['rules_info2'],
		));
		$template->show('index_rules.tpl');
		break;
	default :
		if ($_POST) {
			$luser = request_var('username', '', UTF8_SUPPORT);
			$lpass = request_var('password', '', UTF8_SUPPORT);
			$luniv = request_var('universe', 1);
			$login = $db->uniquequery("SELECT `id`, `username`, `dpath`, `authlevel`, `id_planet` FROM ".USERS." WHERE `username` = '".$db->sql_escape($luser)."' AND `universe` = '".$luniv."' AND `password` = '".md5($lpass)."';");
			
			if (isset($login)) {
				session_start();
				$SESSION       	= new Session();
				$SESSION->CreateSession($login['id'], $login['username'], $login['id_planet'], $luniv, $login['authlevel'], $login['dpath']);

				redirectTo("game.php?page=overview");
			} else {
				redirectTo('index.php?code=1');
			}
		} else {
			$AvailableUnis[$CONF['uni']]	= $CONF['uni_name'].($CONF['game_disable'] == 0 ? $LNG['uni_closed'] : '');
			$Query	= $db->query("SELECT `uni`, `game_disable`, `uni_name` FROM ".CONFIG." WHERE `uni` != '".$UNI."' ORDER BY `uni` ASC;");
			while($Unis	= $db->fetch_array($Query)) {
				$AvailableUnis[$Unis['uni']]	= $Unis['uni_name'].($Unis['game_disable'] == 0 ? $LNG['uni_closed'] : '');
			}
			ksort($AvailableUnis);
			$Code	= request_var('code', 0);
			if(!empty($Code)) {
				$template->assign_vars(array(
					'code'					=> $LNG['login_error_'.$Code],
				));
			}
			$year = date(Y);
			$asd = "xNova Revolution";
			$template->assign_vars(array(
				'AvailableUnis'			=> $AvailableUnis,
				'welcome_to'			=> $LNG['welcome_to'],
				'server_description'	=> sprintf($LNG['server_description'], $CONF['game_name']),
				'server_infos'			=> $LNG['server_infos'],
				'login'					=> $LNG['login'],
				'login_info'			=> sprintf($LNG['login_info'], $LANG->getUser()),
				'user'					=> $LNG['user'],
				'pass'					=> $LNG['pass'],
				'lostpassword'			=> $LNG['lostpassword'],
				'register_now'			=> $LNG['register_now'],
				'screenshots'			=> $LNG['screenshots'],
				'chose_a_uni'			=> $LNG['chose_a_uni'],
				'universe'			 	=> $LNG['universe'],
				'year'				    => $year,
				'asd'                   => $asd,
			));
			$template->show('index_body.tpl');
		}
	break;
}
?>