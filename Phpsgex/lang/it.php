<?php
/* --------------------------------------------------------------------------------------
                                  LANGUAAGE CONFIGURATION - ENGLISH
   Credits         : phpSGEx by Aldrigo Raffaele
   Last modified by: raffa50 21.07.2013
   Comments        : admincp
-------------------------------------------------------------------------------------- */

$lang = array(

'version' => 3,
'language' => 'Italiano',
// -------------------------------- LABELS - REGISTER -------------------------------- //
'reg_language'			=> 'Lingua',
'reg_nickname'			=> 'Nick',
'reg_user'				=> 'Utente',
'reg_city'				=> 'Città',
'reg_password'			=> 'Password',
'reg_race'				=> 'Razza',
'reg_register'			=> 'Registrati',
'reg_login'				=> 'Login',
// -------------------------------- LABELS - INDEX ----------------------------------- //
'idx_numplayers'		=> 'Giocatori Totali',
'idx_lastreg'			=> 'Nuovo Giocatore',
// -------------------------------- LABELS - MENU ------------------------------------ //
'mnu_profile' 			=> 'Profilo',
'mnu_messages' 			=> 'Messaggi',
'mnu_buildings' 		=> 'Costruzioni',
'mnu_barracks' 			=> 'Caserma',
'mnu_map' 				=> 'Mappa',
'mnu_settings' 			=> 'Impostazioni',
'mnu_market' 			=> 'Mercato',
'mnu_allies' 			=> 'Alleanza',
'mnu_researches'		=> 'Ricerche',
// -------------------------------- LABELS - BUILDINGS ------------------------------- //
'bld_build' 			=> 'Costruisci',
'bld_level' 			=> 'Livello',
'bld_requirements'		=> 'Requisiti',
'bld_no_resources'		=> 'Risorse insufficienti!',
'bld_time' 				=> 'Tempo di costruzione',
'bld_cancel'			=> 'Cancella costruzione',
'bld_upgrade'			=> 'Aggiorna',
'bld_time_s' 			=> 'Sec', 						//Obsolete?
// -------------------------------- LABELS - ARMY ------------------------------------ //
'amy_train'				=> 'Addestra',
'amy_max_units'			=> 'Unità Max',
'amy_time'				=> 'Tempo di addestramento',
'amy_level'				=> 'Presenti',
'amy_no_resources'		=> 'Risorse insufficienti!',
// -------------------------------- LABELS - RESEARCH -------------------------------- //
'lab_research'			=> 'Ricerca',
'lab_level'				=> 'Livello',
'lab_requirements'		=> 'Requisitis',
'lab_cancel'			=> 'Cancella Ricerca',
'lab_no_resources'		=> 'Risorse Insifficienti!',
'lab_time'				=> 'Tempo di ricerca',
// -------------------------------- LABELS - PROFILE --------------------------------- //
'prf_no_ally'			=> 'Non sei in una alleanza!',
'prf_points' 			=> 'Trofei',
'prf_last_login' 		=> 'Ultimo login',
'prf_send_pm' 			=> 'Manda un MP',
'prf_alliance' 			=> 'Alleanza',
'prf_cityof'			=> 'Città di',
// -------------------------------- LABELS - HIGHSCORES --------------------------------- //
'scr_highscore' 		=> 'Classifica',
'scr_position' 			=> 'Posizione',
'scr_username' 			=> 'Giocatore',
// -------------------------------- LABELS - MESSAGES --------------------------------- //
'msg_your_messages' 	=> 'I tuoi messaggi',
'msg_reports' 			=> 'Rapporti',
'msg_ally_inv' 			=> 'Inviti Alleanza',
'msg_no_msgs' 			=> 'Nessun Messaggio',
'msg_title' 			=> 'Titolo',
'msg_send' 				=> 'invia',
'msg_to' 				=> 'a',
'msg_from' 				=> 'da',
'msg_mp'				=> 'Messaggi Privati',
'msg_all'				=> 'All',
// -------------------------------- LABELS - ALLIANCES ------------------------------- //
'aly_ally_name' 		=> 'Nome Alleanza',
'aly_no_alliance' 		=> 'Senza Alleanza',
'aly_ally_create' 		=> 'Crea Alleanza',
'aly_create' 			=> 'Crea',
'aly_search' 			=> 'cerca alleanza',
'aly_join' 				=> 'unisciti',
// -------------------------------- LABELS - MARKET ---------------------------------- //
'mkt_no_offers' 		=> 'Nessuna offerta!',
'mkt_offer_res' 		=> 'Offerta',
'mkt_need_res' 			=> 'Richiesta',
'mkt_make' 				=> 'Fai',
'mkt_accept'			=> 'Accetta',
'mkt_offered' 			=> 'Offerto',
'mkt_wanted' 			=> 'Richiesto',
// -------------------------------- LABELS - ADMIN ----------------------------------- //
'adm_admin_panel_of' 	=> 'Pannello Admin di',
'adm_back' 				=> 'Torna al gioco',
'adm_name' 				=> 'Nome',
'adm_image' 			=> 'Immagine',
'adm_desc' 				=> 'Descrizione',
'adm_addrace' 			=> 'Aggiungi Razza',
'adm_addunit' 			=> 'Aggiungi Unità',
'adm_addbuild' 			=> 'Aggiungi costruzione',
'adm_add' 				=> 'Aggiungi',
'adm_cityof' 			=> 'Città di',
'adm_requirements' 		=> 'Requisiti',
'adm_start' 			=> 'Start',
'adm_prodrate' 			=> 'Produzione',
'adm_prodres' 			=> 'Produce',
'adm_icon' 				=> 'Icona',
'adm_races' 			=> 'Razze',
'adm_units' 			=> 'Unità',
'adm_info' 				=> 'Informazioni',
'adm_fast_commands' 	=> 'Comandi veloci',
'adm_adv_sql_commands'	=> 'Comandi SQL avanzati',
'adm_insert_sql_query' 	=> 'SQL query',
'adm_clear_chat' 		=> 'Pulisci Chat',
'adm_addresearch' 		=> 'Aggiungi ricerca',
'adm_resources' 		=> 'Risorse',
'adm_table' 			=> 'Tabella',
'adm_status' 			=> 'Stato',
'adm_broken' 			=> 'Rotta',
'adm_config'			=> 'Modifica Configurazione / Rate',
'adm_dbcheck'			=> 'Controllo Database',
'adm_buildings'			=> 'Costruzioni',
'adm_research'			=> 'Ricerche',
// -------------------------------- LABELS - INSTALLER ------------------------------- //
'ins_installintro' 		=> "<p>ATTENZIONE!<span class='Stile3'><strong> Se sei su Linux imposta CHMOD a 777 o fai l' <a href='https://sourceforge.net/p/phpstrategygame/wiki/Home/'>Instalazione manuale (clik qua)!</a></strong></span></p>	<p><b>Necessiti aiuto?</b> Visita: <a href='https://sourceforge.net/p/phpstrategygame/wiki/Home/'>PhpSgeX wiki: Guida d'installazione</a> per una guida!</p><p>Installando PhpSgeX accetti di sottostare alle regole di licenza</p>",
'ins_createdb' 			=> 'Crea DataBase',
'ins_next' 				=> 'avanti'

);

?>