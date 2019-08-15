<?php
/* --------------------------------------------------------------------------------------
                                  LANGUAAGE CONFIGURATION - ENGLISH
   Credits         : phpSGEx by Aldrigo Raffaele
   Last modified by: raffa50 21.07.2013
   Comments        : admincp
-------------------------------------------------------------------------------------- */

$lang = array(

// -------------------------------- LABELS - REGISTER -------------------------------- //
'reg_language'			=> 'Език',
'reg_nickname'			=> 'Име на Играча',
'reg_user'				=> 'Играч',
'reg_city'				=> 'Град',
'reg_password'			=> 'Парола',
'reg_race'				=> 'Раса',
'reg_register'			=> 'Регистрирайте се',
'reg_login'				=> 'Влезте',
// -------------------------------- LABELS - INDEX ----------------------------------- //
'idx_numplayers'		=> 'Общо Регистрирани Играчи',
'idx_lastreg'			=> 'Най-нов Играч',
// -------------------------------- LABELS - MENU ------------------------------------ //
'mnu_profile' 			=> 'Профил',
'mnu_messages' 			=> 'Съобщения',
'mnu_buildings' 		=> 'Сгради',
'mnu_barracks' 			=> 'Казарма',
'mnu_map' 				=> 'Карта',
'mnu_settings' 			=> 'Настройки',
'mnu_market' 			=> 'Пазарище',
'mnu_allies' 			=> 'Съюз',
'mnu_researches'		=> 'Изследвания',
// -------------------------------- LABELS - BUILDINGS ------------------------------- //
'bld_build' 			=> 'Построй',
'bld_level' 			=> 'Ниво',
'bld_requirements'		=> 'Изисквания',
'bld_no_resources'		=> 'Недостатъчно ресурси!',
'bld_time' 				=> 'Време за конструиране',
'bld_cancel'			=> 'Спри Строежа',
'bld_upgrade'			=> 'Разшири',
'bld_time_s' 			=> 'Сек.', 						//Obsolete?
// -------------------------------- LABELS - ARMY ------------------------------------ //
'amy_train'				=> 'Тренирай',
'amy_max_units'			=> 'Най-много войници',
'amy_time'				=> 'Време за трениране',
'amy_level'				=> 'В Гарнизон',
'amy_no_resources'		=> 'Недостатъчно ресурси!',
// -------------------------------- LABELS - RESEARCH -------------------------------- //
'lab_research'			=> 'Изследвай',
'lab_level'				=> 'Ниво',
'lab_requirements'		=> 'Изисквания',
'lab_cancel'			=> 'Спри Изследването',
'lab_no_resources'		=> 'Недостатъчно ресурси!',
'lab_time'				=> 'Време за изследване',
// -------------------------------- LABELS - PROFILE --------------------------------- //
'prf_no_ally'			=> 'Не членувате в съюз',
'prf_points' 			=> 'Трофеи',
'prf_last_login' 		=> 'Последно влизане',
'prf_send_pm' 			=> 'Изпрати лично съобщение',
'prf_alliance' 			=> 'Съюз',
'prf_cityof'			=> 'Град на',
// -------------------------------- LABELS - HIGHSCORES --------------------------------- //
'scr_highscore' 		=> 'Най-голям брой точки',
'scr_position' 			=> 'Позиция',
'scr_username' 			=> 'Играч',
// -------------------------------- LABELS - MESSAGES --------------------------------- //
'msg_your_messages' 	=> 'Ваши съобщения',
'msg_reports' 			=> 'Докладвания',
'msg_ally_inv' 			=> 'Покана за членуване в съюз',
'msg_no_msgs' 			=> 'Празно',
'msg_title' 			=> 'Заглавие',
'msg_send' 				=> 'изпрати',
'msg_to' 				=> 'до',
'msg_from' 				=> 'от',
'msg_mp'				=> 'Лично съобщение',
'msg_all'				=> 'Всичко',
// -------------------------------- LABELS - ALLIANCES ------------------------------- //
'aly_ally_name' 		=> 'Име на съюза',
'aly_no_alliance' 		=> 'Без съюз',
'aly_ally_create' 		=> 'Създай съюз',
'aly_create' 			=> 'Създай',
'aly_search' 			=> 'Търси съюзи',
'aly_join' 				=> 'Влез в съюз',
// -------------------------------- LABELS - MARKET ---------------------------------- //
'mkt_no_offers' 		=> 'Празно!',
'mkt_offer_res' 		=> 'Предложи',
'mkt_need_res' 			=> 'Изисквай',
'mkt_make' 				=> 'Готово',
'mkt_accept'			=> 'Приеми',
'mkt_offered' 			=> 'Предложено',
'mkt_wanted' 			=> 'Искано',
// -------------------------------- LABELS - ADMIN ----------------------------------- //
'adm_admin_panel_of' 	=> 'Панел на',
'adm_back' 				=> 'Обратно в игра',
'adm_name' 				=> 'Име',
'adm_image' 			=> 'Картинка',
'adm_desc' 				=> 'Описание',
'adm_addrace' 			=> 'Добави раса',
'adm_addunit' 			=> 'Добави войн',
'adm_addbuild' 			=> 'Добави сграда',
'adm_add' 				=> 'Добави',
'adm_cityof' 			=> 'Град на',
'adm_requirements' 		=> 'Изисквание',
'adm_start' 			=> 'Старт',
'adm_prodrate' 			=> 'Производство',
'adm_prodres' 			=> 'Произвежда',
'adm_icon' 				=> 'Икона',
'adm_races' 			=> 'Раси',
'adm_units' 			=> 'Редакт. Войни',
'adm_info' 				=> 'Информация',
'adm_fast_commands' 	=> 'Бързи команди',
'adm_adv_sql_commands'	=> 'Advanced SQL commands',
'adm_insert_sql_query' 	=> 'SQL query',
'adm_clear_chat' 		=> 'Изтрии чата',
'adm_addresearch' 		=> 'Добави изследване',
'adm_resources' 		=> 'Ресурси',
'adm_table' 			=> 'Маса',
'adm_status' 			=> 'Статус',
'adm_broken' 			=> 'Счупен',
'adm_config'			=> 'Edit Config / Rates',
'adm_dbcheck'			=> 'Database Check',
'adm_buildings'			=> 'Сгради',
'adm_research'			=> 'Изследване',
// -------------------------------- LABELS - INSTALLER ------------------------------- //
'ins_installintro' 		=> "<p>ATTENTION!<span class='Stile3'><strong> If you are on Linux you must set CHMOD to 777 or do <a href='http://sourceforge.net/apps/mediawiki/phpstrategygame/index.php?title=Manual_installation'>Manual installation (click here)!</a></strong></span></p>	<p><b>Need help?</b> just visit: <a href='http://sourceforge.net/apps/mediawiki/phpstrategygame/index.php?title=Installation_guide'>PhpSgeX Wiki: Installation Guide</a> to get a tutorial on phpsgex installation.</p>
<p>By installing PhpSgeX you also agree with the licence rules</p>",
'ins_createdb' 			=> 'Create DataBase',
'ins_next' 				=> 'Next'

);

?>