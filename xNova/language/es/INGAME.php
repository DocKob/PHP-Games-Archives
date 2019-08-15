<?php

/**
 _  \_/ |\ | /¯¯\ \  / /\    |¯¯) |_¯ \  / /¯¯\ |  |   |´¯|¯` | /¯¯\ |\ |5
 ¯  /¯\ | \| \__/  \/ /--\   |¯¯\ |__  \/  \__/ |__ \_/   |   | \__/ | \|Core Redesigned.
 * @author: Copyright (C) 2011 by Brayan Narvaez (Prinick) developer of xNova Revolution
 * @author web: http://www.bnarvaez.com
 * @link: http://www.xnovarev.com
 * @version 5.6

 * @package 2Moons
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <douglas@crockford.com> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/

 * Please do not remove the credits
*/

# Generales del servidor
$LNG['Metal']										= 'Niobio'; # Search Niobio on Wikipedia
$LNG['Crystal']								    = 'Germanio'; # Search Germanio on Wikipedia
$LNG['Deuterium']								= 'Deuterio';
$LNG['Darkmatter']								= 'Materia Oscura';
$LNG['Norio']							  			= 'Norio';
$LNG['Energy']									= 'Energía';
$LNG['Messages']								= 'Mensajes';
$LNG['write_message']						= 'Escribir mensaje';
$LNG['Raza']                                          = 'Raza';
$LNG['Raza_0']                                     = 'Gultra';
$LNG['Raza_1']                                   = 'Voltra';

$LNG['ready']										= 'Listo';
$LNG['show_planetmenu']					= 'Mostrar / Ocultar';

$LNG['type_mission'][1]  					= 'Atacar';
$LNG['type_mission'][2]  					= 'Ataque grupal';
$LNG['type_mission'][3]  					= 'Transportar';
$LNG['type_mission'][4]  					= 'Desplegar';
$LNG['type_mission'][5]  					= 'Apoyar con refuerzos';
$LNG['type_mission'][6]  					= 'Espiar';
$LNG['type_mission'][7]  					= 'Colonizar';
$LNG['type_mission'][8]  					= 'Reciclar';
$LNG['type_mission'][9]  					= 'Destruir';
$LNG['type_mission'][11]  					= 'Exploración de Materia Oscura';
$LNG['type_mission'][15] 					= 'Expedición';

$LNG['user_level'] = array (
	'0' => 'Jugador',
	'1' => 'Operador',
	'2' => 'Super Operador',
	'3' => 'Administrador',
);

$LNG['see_you_soon']						= '¡Hasta luego!';
$LNG['page_doesnt_exist']					= 'La página solicitada no existe.';
$LNG['tn_vacation_mode']					= 'Estás en modo vacaciones ';
$LNG['tn_delete_mode']						= 'Tu cuenta se encuentra en período de eliminación. La misma será borrada el %s.';

# Mercado General
$LNG['mercado_negro'] = "Mercado Negro";
$LNG['comerciante'] = "Comerciante";
$LNG['bonus_n'] = "Bonus";
$LNG['mercado_negro_desc'] = "En el mercado negro el negocio de recursos es rentable.";
$LNG['comerciante_desc'] = "Con el comerciante, puedes comercializar tus naves a cambio de recursos.";
$LNG['bonus_n_desc'] = "Puedes obtener buenos packs a cambio de Materia Oscura.";

#Partes extras de otros lugares
$LNG['bd_commander']					= 'Necesitas el comandante';

#Oficiales
$LNG['oficiales'] = "Oficiales";
$LNG['comandante'] = "Comandante";
$LNG['comandante_desc'] = "El Comandante se ha establecido por si mismo en la guerra moderna. Incrementar&aacute;s la eficiencia en las construcciones. Ser&aacute;s capaz de tener una visi&oacute;n general de tu imperio. Esto te permitir&aacute; desarrollar estructuras que te lleven un paso m&aacute;s cerca de tu enemigo. <br /><br /> <font color=skyblue>Visi&oacute;n de imperio, Cola de construcci&oacute;n en estructuras y tecnologías, Bot&oacute;n de maxima construcci&oacute;n en el hangar, -10% de tiempo en todas las construcciones.</font> ";
$LNG['geologo'] = "Ge&oacute;logo";
$LNG['geologo_desc'] = "El ge&oacute;logo es un experto en astrominerolog&iacute;a y astrocristalograf&iacute;a. Apoyado por su equipo de metal&uacute;rgicos e ingenieros en qu&iacute;mica apoya a gobiernos interplanetarios a la explotaci&oacute;n de fuentes de recursos y a la optimazaci&oacute;n del refinamiento de estos recursos.<br /><br /><font color=skyblue>Incrementa en un +10% la producci&oacute;n de las minas y disminuye en un 20% el costo de las construcciones.</font>";
$LNG['ingeniero'] = "Ingeniero";
$LNG['ingeniero_desc'] = "El Ingeniero es un especialista en gesti&oacute;n de energ&iacute;a. En tiempos de paz aumenta la energ&iacute;a de todas las colonias. En caso de ataque, garantiza el abastecimiento de energ&iacute;a a los ca&ntilde;ones, evitando una posible sobrecarga, lo que conduce a una reducci&oacute;n de defensas perdidas en batalla. <br /><br /><font color=skyblue>Disminuye en un 10% el consumo de energ&iacute;a.</font>";
$LNG['almirante'] = "Almirante";
$LNG['almirante_desc'] = "El almirante de flota es un veterano de guerra experimentado y un habilidoso estratega. En las batallas m&aacute;s duras, es capaz de hacerse una idea de la situaci&oacute;n y contactar a sus almirantes subordinados. Un emperador sabio puede confiar en su ayuda durante los combates y guiar m&aacute;s flotas al mismo tiempo.<br /><br /><font color=skyblue>Incrementa en +2 los espacios de flota disponibles y en una hora extra el limite de tiemo en expediciones.</font>";
$LNG['tecnocrata'] = "Tecn&oacute;crata";
$LNG['tecnocrata_desc'] = "El gremio de los Tecn&oacute;cratas est&aacute; compuesto de aut&eacute;nticos genios y siempre los encontrar&aacute;s en un mundo donde la l&oacute;gica humana ser&iacute;a descartada. Desde hace miles de a&ntilde;os, ning&uacute;n ser humano normal ha podido descifrar el c&oacute;digo de un tecn&oacute;crata. El tecn&oacute;crata inspira a los investigadores del imperio con tan s&oacute;lo su presencia. <br /><br /><font color=skyblue>Incrementa en un +2 al nivel de espionaje. <br /> Disminuye un -25% el tiempo de investigaciones.</font>";
$LNG['contratar'] = "Contratar";
$LNG['semana'] = "Semana";
$LNG['mes'] = "Meses";
$LNG['activo'] = "Activo";
$LNG['inactivo'] = "Inactivo";
$LNG['nivel_maximo'] = "Nivel Maximo";
$LNG['oficial_contratado'] = "<b>Oficial contratado, desde hoy trabaja para tu imperio.</b>";
$LNG['materia_oscura'] = "La Materia Oscura es una substancia que puede ser almacenada &uacute;nicamente con un gran esfuerzo y s&oacute;lo desde hace unos pocos a&ntilde;os est&aacute;ndar. Puedes obtener grandes cantidades de energ&iacute;a de ella, pero el m&eacute;todo para ganar materia oscura es complejo y esta lleno de riesgos, por eso se volvi&oacute; tan valiosa...";
$LNG['comprar'] = "Comprar";

#Materia Oscura Mercader
$LNG['dm_pack_no'] = "No tienes suficiente norio para comprar este pack.";
$LNG['dm_pack_ok'] = "Has comprado este pack.";
$LNG['de_materia'] = " de Materia Oscura";
$LNG['caja'] = "Caja #";

# Menú izquierdo y topbaar
$LNG['lm_overview']						= 'General';
$LNG['lm_galaxy']							= 'Universo';
$LNG['lm_empire']							= 'Imperio';
$LNG['lm_fleet']								= 'Flotas';
$LNG['lm_buildings']						= 'Estructuras';
$LNG['lm_research']						= 'Tecnologías';
$LNG['lm_shipshard']						= 'Naves';
$LNG['lm_defenses']						= 'Defensas';
$LNG['lm_resources']						= 'Recursos';
$LNG['lm_fleettrader']						= 'Comerciante';
$LNG['lm_trader']							= 'Mercado';
$LNG['lm_technology']					= 'Requisitos';
$LNG['lm_messages']					= 'Mensajes';
$LNG['lm_alliance']						    = 'Alianza';
$LNG['lm_buddylist']						= 'Amigos';
$LNG['lm_bonus']							= 'Bonus';
$LNG['lm_notes']							= 'Notas';
$LNG['lm_statistics']						= 'Clasificación';
$LNG['lm_search']							= 'Buscador';
$LNG['lm_options']							= 'Configuración';
$LNG['lm_banned']							= 'Baneados';
$LNG['lm_contact']							= 'Contacto';
$LNG['lm_forums']							= 'Foro';
$LNG['lm_logout']							= 'Salir';
$LNG['lm_administration']				= 'CPanel';
$LNG['lm_game_speed']				= 'Juego';
$LNG['lm_fleet_speed']					= 'Flota';
$LNG['lm_resources_speed']			= 'Recursos';
$LNG['lm_queue']							= 'Colas';
$LNG['lm_topkb']							= 'Batallas';
$LNG['lm_faq']								= 'FAQ';
$LNG['lm_records']							= 'Records';
$LNG['lm_chat']							    = 'Chat';
$LNG['lm_support']							= 'Soporte';
$LNG['lm_rules']								= 'Reglas';
$LNG['lm_battlesim']						= "Simulador";
$LNG['lm_credits']                          = "Créditos";
$LNG['lm_officiers']                      = "Oficiales";

# General
$LNG['rang_1']  = 'Civilización Primitiva';
$LNG['rang_2']  = 'Civilización Planetaria';
$LNG['rang_3']  = 'Civilización Espacial';
$LNG['rang_4']  = 'Civilización Colonial';
$LNG['rang_5']  = 'Civilización Avanzada';
$LNG['rang_6']  = 'Imperio Estelar';
$LNG['rang_7']  = 'Imperio Galáctico';
$LNG['rang_8']  = 'Imperio Avanzado';
$LNG['rang_9']  = 'Imperio Dominante';
$LNG['ov_fragatas'] = "Fragatas: ";
$LNG['ov_cazador'] = "Cazadores: ";
$LNG['ov_civil'] = "Naves Civiles: ";
$LNG['ov_cruceros'] = "Cruceros: ";
$LNG['ov_insignia'] = "Naves Insignia: ";
$LNG['ov_capital'] = "Naves Capitales: ";
$LNG['ov_newname_alphanum']				= 'Has introducido algún caracter ilegal. Sólo puedes introducir caracteres alfanuméricos.';
$LNG['ov_newname_no_space']				= 'El nombre de los planetas no puede contener espacios.';
$LNG['ov_subiendo']						= 'Subiendo al nivel';
$LNG['ov_cantidad']						= 'Construyendo';
$LNG['ov_estructuras_construccion']     = 'Construcciones';
$LNG['ov_planet_abandoned']				= 'Has abandonado el planeta.';
$LNG['ov_principal_planet_cant_abanone']	= 'No puedes habandonar tu planeta principal.';
$LNG['ov_abandon_planet_not_possible']		= 'No se puede abandonar esta colonia si hay flota desplegada.';
$LNG['ov_wrong_pass']						= 'Contraseña incorrecta. Intentalo de nuevo.';
$LNG['ov_have_new_message']				= 'Has recibido 1 mensaje nuevo';
$LNG['ov_have_new_messages']				= 'Has recibido %d mensajes nuevos';
$LNG['ov_planetmenu']						= 'Planeta';
$LNG['ov_free_estructuras']					= 'No se están construyendo estructuras planetarias.';
$LNG['ov_free_hangar']						= 'No se está construyendo en el hangar de este planeta.';
$LNG['ov_news']							= 'Novedades';
$LNG['ov_place']							= 'Top';
$LNG['ov_of']								= 'de';
$LNG['ov_planet']							= 'Planeta';
$LNG['ov_server_time']						= 'Hora del servidor ';
$LNG['ov_events']							= 'Eventos';
$LNG['ov_diameter']						= 'Tamaño';
$LNG['ov_distance_unit']					= 'km';
$LNG['ov_temperature']						= 'Temperatura';
$LNG['ov_aprox']							= 'Aprox.';
$LNG['ov_temp_unit']						= '&#176;C';
$LNG['ov_to']								= 'hasta';
$LNG['ov_position']						= 'Coordenadas';
$LNG['ov_points']							= 'Puntos';
$LNG['ov_security_request']				= 'Estás a punto de eliminar este planeta';
$LNG['ov_security_confirm']				= 'Confirma que lo deseas borrar introduciendo tu contraseña.';
$LNG['ov_with_pass']						= 'con contraseña.';
$LNG['ov_password']						= 'Contraseña';
$LNG['ov_delete_planet']					= 'Borrar planeta';
$LNG['ov_your_planet']						= 'Tu planeta';
$LNG['ov_coords']							= 'Coordenadas';
$LNG['ov_abandon_planet']					= 'Abandonar colonia';
$LNG['ov_planet_name']						= 'Nombre';
$LNG['ov_actions']							= 'Acciones';
$LNG['ov_planet_rename']					= 'Renombrar';
$LNG['ov_planet_rename_action']			= 'Renombrar';
$LNG['ov_fields']							= 'Campos';
$LNG['ov_developed_fields']                = 'Campos desarrollados';
$LNG['ov_max_developed_fields']			= 'max. de campos a construir';
$LNG['ov_fleet']							= 'Flota';
$LNG['ov_admins_online']					= 'Administradores Conectados:';
$LNG['ov_no_admins_online']				= 'Actualmente ninguno en línea.';
$LNG['ov_userbanner']						= 'Firma con tus estadísticas';
$LNG['ov_userrank_info']					= '%s (%s <a href="game.php?page=statistics&amp;range=%d">%d</a> %s %s)';
$LNG['ov_teamspeak_not_online']			= 'El servidor está inaccesible. Te pedimos disculpas.';
$LNG['ov_teamspeak']						= 'Teamspeak';
$LNG['ov_teamspeak_v2']					= '<a href="teamspeak://%s:%s?nickname=%s" title="Teamspeak Connect">Conectar</a> &bull; Online: %d/%d &bull; Canales: %d &bull; Trafico ges: %s MB';
$LNG['ov_teamspeak_v3']					= '<a href="ts3server://%s?port=%d&amp;nickname=%s&amp;password=%s" title="Teamspeak Connect">Conectado</a>&nbsp;&bull;&nbsp;Online: %d/%d &bull; Canales: %d &bull; Trafico ges: %s MB';
$LNG['ov_closed']						= 'El juego actualmente está desactivado.';

# Bonus
$LNG['packs_darkmatter'] = "de Materia Oscura";
$LNG['packs_en_venta'] = "Packs en venta";
$LNG['packs_comprar'] = "Comprar";
$LNG['packs_coste'] = "Precio: ";
$LNG['recursos_pack'] = "Pack de Recursos";
$LNG['recursos_pack_descr'] = "Niobio: +10.000.000 <br />Germanio: +5.000.000 <br />Deuterio: +2.500.000";
$LNG['minas_pack'] = "Pack de Mineros";
$LNG['minas_pack_descr'] = "Mina de Niobio +2 <br />Mina de Germanio +2 <br />Mina de Norio +2 <br />Planta de Energía Solar +5 <br />Fábrica de Robots +2";
$LNG['almacenes_pack'] = "Pack de Almacenes";
$LNG['almacenes_pack_descr'] = "Almacen de Niobio +1 <br />Almacen de Germanio +1 <br />Almacen de Deuterio +1 <br />Almacen de Norio +1 ";
$LNG['flotas_pack'] = "Pack de Foteros";
$LNG['flotas_pack_descr']  = "Fragatas pequeñas: +300.000 <br />Fragatas medianas: +150.000 <br />Recicladores grandes: +500 <br />Deuterio: +3.000.000 ";
$LNG['bunkers_pack'] = "Pack de Bunkeros";
$LNG['bunkers_pack_descr'] = "Cúpula pequeña de protección +1 <br />Cúpula grande de protección +1 <br />Cúpula externa de protección +1 <br />Cañones iónicos: +20.000 ";
$LNG['tecnos_pack'] = "Pack de Tecnología";
$LNG['tecnos_pack_descr'] = "Espionaje +1 <br />Computación +1 <br />Energía +1 <br />Motores de Combustión +1 <br />Motores de Impulso +1 <br />Propulsores  Hiperespaciales +1 ";
$LNG['bn_pack_ok'] = "Has comprado este pack.";
$LNG['bn_pack_no'] = "No tienes suficiente materia oscura para comprar este pack.";

#Galaxia (Universo)
$LNG['gl_no_deuterium_to_view_galaxy']		= 'No hay suficiente combustible (deuterio).';
$LNG['gl_legend']							= 'Leyenda';
$LNG['gl_strong_player']					= 'Jugador Fuerte';
$LNG['gl_week_player']						= 'Jugador Débil';
$LNG['gl_vacation']						= 'Está en Modo Vacaciones';
$LNG['gl_banned']							= 'Jugador Baneado';
$LNG['gl_inactive_seven']					= '7 Dias inactivo';
$LNG['gl_inactive_twentyeight']			= '28 Dias inactivo';
$LNG['gl_s']								= 'F';
$LNG['gl_w']								= 'D';
$LNG['gl_v']								= 'V';
$LNG['gl_b']								= 'B';
$LNG['gl_i']								= 'i';
$LNG['gl_I']								= 'I';
$LNG['gl_populed_planets']					= '%d planetas habitados';
$LNG['gl_out_space']						= 'Explora el Espacio exterior';
$LNG['gl_avaible_missiles']				= 'Misiles';
$LNG['gl_fleets']							= 'Slots de flota';
$LNG['gl_avaible_grecyclers']				= 'Mega-Recicladores disponibles';
$LNG['gl_avaible_recyclers']				= 'Recicladores disponibles';
$LNG['gl_avaible_spyprobes']				= 'Sondas disponibles';
$LNG['gl_missil_launch']					= 'Lanzamiento de Misiles';
$LNG['gl_missil_to_launch']				= 'Número de misiles (<b>%d</b>):';
$LNG['gl_all_defenses']					= 'Todo';
$LNG['gl_objective']						= 'Objectivo';
$LNG['gl_missil_launch_action']			= 'Enviar';
$LNG['gl_galaxy']							= 'Galaxia';
$LNG['gl_solar_system']					= 'Sistema Solar';
$LNG['gl_show']							= 'Mostrar';
$LNG['gl_pos']								= '#';
$LNG['gl_planet']							= 'Planeta';
$LNG['gl_name_activity']					= 'Nombre';
$LNG['gl_moon']							= 'Luna';
$LNG['gl_inavitado']					= 'Inavitado';
$LNG['gl_debris']							= 'Escombros';
$LNG['gl_player_estate']					= 'Jugador (Estado)';
$LNG['gl_alliance']						= 'Alianza';
$LNG['gl_actions']							= 'Acción';
$LNG['gl_spy']								= 'Espiar';
$LNG['gl_buddy_request']					= 'Solicitud de amistad';
$LNG['gl_missile_attack']					= 'Ataque con misiles';
$LNG['gl_with']							= ' con ';
$LNG['gl_member']							= '%d miembros';
$LNG['gl_member_add']						= '%d miembro';
$LNG['gl_alliance_page']					= 'Página de la alianza';
$LNG['gl_see_on_stats']					= 'Estadísticas';
$LNG['gl_alliance_web_page']				= 'Página principal de la alianza';
$LNG['gl_debris_field']					= 'Campo de escombros';
$LNG['gl_collect']							= 'Recolectar';
$LNG['gl_resources']						= 'Recursos';
$LNG['gl_features']						= 'Características';
$LNG['gl_diameter']						= 'Diámetro';
$LNG['gl_temperature']						= 'Temperatura';
$LNG['gl_phalanx']							= 'Phalanxear';
$LNG['gl_planet_destroyed']				= 'Destruir Planeta';
$LNG['gl_playercard']						= 'Perfil';
$LNG['gl_player']                                                       = 'Jugador';
$LNG['gl_in_the_rank']						= 'Jugador %s ranking %d';
$LNG['gl_activity']                                            = '(*)';
$LNG['gl_activity_inactive']                                   = '(%d min)';
$LNG['gl_ajax_status_ok']                    = 'OK';
$LNG['gl_ajax_status_fail']                = 'Error';
$LNG['gl_free_desc']                                    = 'Un planeta deshabitado. Este es un lugar ideal para fundar una nueva colonia.';
$LNG['gl_free']                                                 = 'Libre';
$LNG['gl_yes']                                                  = 'Si';
$LNG['gl_no']                                                   = 'No';
$LNG['gl_points']                                                       = 'Puntos';
$LNG['gl_player']                                                       = 'Jugador';
$LNG['gl_to']								= '';

 #Phalanx
$LNG['px_no_deuterium']					= 'No tienes suficiente deuterio.';
$LNG['px_scan_position']					= 'Escanear posición';
$LNG['px_fleet_movement']					= 'Movimiento actual de flotas';
$LNG['px_no_fleet']						= 'No hay movimientos de flota.';
$LNG['px_out_of_range']                                         = 'Fuera de alcance';

//----------------------------------------------------------------------------//
//IMPERIUM
$LNG['iv_imperium_title']					= 'Visualización del Imperio';
$LNG['iv_planet']							= 'Planeta';
$LNG['iv_name']							= 'Nombre';
$LNG['iv_coords']							= 'Coordenadas';
$LNG['iv_fields']							= 'Campos';
$LNG['iv_resources']						= 'Recursos';
$LNG['iv_buildings']						= 'Estructuras';
$LNG['iv_technology']						= 'Tecnologías';
$LNG['iv_ships']							= 'Naves';
$LNG['iv_defenses']						= 'Defensas';

//----------------------------------------------------------------------------//
//FLEET - FLEET1 - FLEET2 - FLEET3 - FLEETACS - FLEETSHORTCUTS

$LNG['fl_titulo_misiones']					= 'MISIONES ACTUALES';
$LNG['fl_no_misiones']						= 'No hay misiones actualmente';
$LNG['fl_returning']						= 'Regresando';
$LNG['fl_onway']							= 'En camino';
$LNG['fl_r']								= '(R)';
$LNG['fl_a']								= '(A)';
$LNG['fl_send_back']						= 'Regresar';
$LNG['fl_acs']								= 'SAC';
$LNG['fl_no_more_slots']					= 'Todos los slots de flotas estan siendo utilizados';
$LNG['fl_speed_title']						= 'Velocidad: ';
$LNG['fl_continue']						    = 'Continuar';
$LNG['fl_no_ships']					      	= 'No hay naves';
$LNG['fl_remove_all_ships']			    	= 'Ninguna nave';
$LNG['fl_select_all_ships']			    	= 'Todas las naves';
$LNG['fl_fleets']							= 'Flota';
$LNG['fl_expeditions']						= 'Expediciones';
$LNG['fl_number']							= 'ID';
$LNG['fl_mission']							= 'Misión';
$LNG['fl_ammount']							= 'Naves (total)';
$LNG['fl_beginning']						= 'Desde';
$LNG['fl_departure']						= 'Llegada (destino)';
$LNG['fl_destiny']							= 'Hasta';
$LNG['fl_objective']						= 'Objectivo';
$LNG['fl_arrival']							= 'Llegada (Vuelta)';
$LNG['fl_info_detail']						= 'Detalles de flota';
$LNG['fl_order']							= 'Orden';
$LNG['fl_new_mission_title']				= 'Nueva misión: escoge las naves';
$LNG['fl_ship_type']						= 'Tipo de nave';
$LNG['fl_ship_available']					= 'Disponibles';
$LNG['fl_planet']							= 'Planeta';
$LNG['fl_debris']							= 'Escombros';
$LNG['fl_moon']						    	= 'Luna';
$LNG['fl_planet_shortcut']					= '(P)';
$LNG['fl_debris_shortcut']					= '(E)';
$LNG['fl_moon_shortcut']					= '(L)';
$LNG['fl_no_shortcuts']					= 'No hay accesos directos';
$LNG['fl_anonymous']						= 'Anónimo';
$LNG['fl_shortcut_add_title']				= 'Nombre [Galaxia/Sistema/Planeta]';
$LNG['fl_shortcut_name']					= 'Nombre';
$LNG['fl_shortcut_galaxy']					= 'Galaxia';
$LNG['fl_shortcut_solar_system']			= 'Sistema';
$LNG['fl_clean']							= 'Resetear';
$LNG['fl_register_shorcut']				= 'Registrar';
$LNG['fl_shortcuts']						= 'Accesos directos';
$LNG['fl_reset_shortcut']					= 'Reestablecer';
$LNG['fl_dlte_shortcut']					= 'Eliminar';
$LNG['fl_back']							= 'Volver';
$LNG['fl_shortcut_add']					= 'Agregar';
$LNG['fl_shortcut_edition']				= 'Edición: ';
$LNG['fl_no_colony']						= 'No hay colonias';
$LNG['fl_send_fleet']						= 'Enviar flota';
$LNG['fl_fleet_speed']						= 'Velocidad';
$LNG['fl_distance']						= 'Distancia';
$LNG['fl_flying_time']						= 'Tiempo de vuelo (solo ida)';
$LNG['fl_flying_arrival']					= 'Llagada a destino';
$LNG['fl_flying_return']					= 'Llegada a Origen';
$LNG['fl_fuel_consumption']				= 'Consumo de combustible';
$LNG['fl_max_speed']						= 'Velocidad máxima';
$LNG['fl_cargo_capacity']					= 'Capacidad de carga';
$LNG['fl_shortcut']						= 'Atajos';
$LNG['fl_shortcut_add_edit']				= '(Agregar / Editar)';
$LNG['fl_my_planets']						= 'Mis planetas';
$LNG['fl_acs_title']						= 'Ataques grupales';
$LNG['fl_hold_time']						= 'Tiempo de estacionamiento';
$LNG['fl_resources']						= 'Recursos';
$LNG['fl_cantidad']							= 'Cantidad';
$LNG['fl_accion']							= 'Acción';
$LNG['fl_max']								= 'max';
$LNG['fl_hours']							= 'Horas';
$LNG['fl_resources_left']					= 'Restante';
$LNG['fl_all_resources']					= 'MAXIMOS RECURSOS DISPONIBLES';
$LNG['fl_empty_target']					= 'No hay misiones disponibles (¿existe el planeta?)';
$LNG['fl_expedition_alert_message']		= 'ATENCIÓN: ¡Las expediciones son misiones muy arriesgadas y puedes perder tus naves!';
$LNG['fl_dm_alert_message']				= 'Ten cuidado, si en la %s, se encuentra %s, ¡tu flota será destruida!';
$LNG['fl_vacation_mode_active']			= 'Estás en modo vacaciones';
$LNG['fl_expedition_tech_required']		= 'No se pudo enviar la expedición, antes tu imperio debe poseer la tecnología de expedición almenos en el nivel uno (1).';
$LNG['fl_expedition_fleets_limit']			= 'Superado el limite de flotas de Expedicion.';
$LNG['fl_week_player']						= '&#161;¡El jugador es muy débil!';
$LNG['fl_strong_player']					= '&#161;¡El jugador es muy fuerte!';
$LNG['fl_in_vacation_player']				= 'El jugador está en modo vacaciones.';
$LNG['fl_capitals']				= 'Las naves capitales deben estar acompañadas de al menos 10 naves del tipo crucero y 5 naves insignia.';
$LNG['fl_no_slots']						= 'No hay más slots disponibles.';
$LNG['fl_empty_transport']					= 'No puedes transportar 0 recursos';
$LNG['fl_planet_populed']					= '&#161;Este planeta está ocupado.';
$LNG['fl_no_same_alliance']                 = '¡El jugador del planeta de destino debe ser un compañero de alianza o ser un amigo!';
$LNG['fl_not_ally_deposit']				= '&#161;No existe un depósito de alianza.';
$LNG['fl_deploy_only_your_planets']		= '&#161;Sólo puedes desplegar flotas en tus planetas.';
$LNG['fl_no_enought_deuterium']			= 'No tienes suficiente %s. Necesitas %s %s.';
$LNG['fl_no_enought_cargo_capacity']		= 'No tienes suficiente espacio de carga. Disponible:';
$LNG['fl_admins_cannot_be_attacked']		= 'Los administradores y operadores del juego no pueden recibir ataques.';
$LNG['fl_fleet_sended']					= 'Flota enviada';
$LNG['fl_from']							= 'De';
$LNG['fl_arrival_time']					= 'Hora de llegada';
$LNG['fl_return_time']						= 'Hora de regreso';
$LNG['fl_fleet']							= 'Flota';
$LNG['fl_player']							= 'El jugador ';
$LNG['fl_add_to_attack']					= ' fue agregado al ataque.';
$LNG['fl_dont_exist']						= ' no existe.';
$LNG['fl_acs_invitation_message']			= ' te invita a participar en un SAC.';
$LNG['fl_acs_invitation_title']			= 'Invitación a SAC';
$LNG['fl_sac_of_fleet']					= 'SAC de flota';
$LNG['fl_modify_sac_name']					= 'Modificar el nombre del SAC';
$LNG['fl_members_invited']					= 'Participantes invitados';
$LNG['fl_invite_members']					= 'Invitar a otros participantes';
$LNG['fl_simulate']						= 'Simular';
$LNG['fl_bonus']							= 'INFORMACIÓN EXTRA';
$LNG['fl_bonus_attack']					= 'Ataque';
$LNG['fl_bonus_defensive']					= 'Defensa';
$LNG['fl_bonus_shield']					= 'Escudos';
$LNG['fl_no_empty_derbis']					= '¡No existe ningún campo de escombros! ';
$LNG['fl_acs_newname_alphanum']				= 'El nombre solo puede tener caracteres alfanumericos. ';
$LNG['fl_acs_change']						= 'Cambiando';
$LNG['fl_acs_change_name']					= 'Enscribir un nuevo nombre';
$LNG['fl_error_not_avalible']				= '¡No se puede hacer nada con este planeta!';
$LNG['fl_error_empty_derbis']				= 'No hay escombros.';
$LNG['fl_error_no_moon']					= 'No hay luna.';
$LNG['fl_error_same_planet']				= 'El origen y el destino no pueden ser el mismo planeta!';

//----------------------------------------------------------------------------//
//BUILDINGS - RESEARCH - SHIPYARD - DEFENSES
$LNG['bd_dismantle']						= 'Desmontar';
$LNG['bd_interrupt']						= 'Interrumpir';
$LNG['bd_cancel']							= 'Cancelar';
$LNG['bd_working']							= 'Trabajando';
$LNG['bd_build']							= 'Construir';
$LNG['no_recursos']							= 'No hay recursos suficientes';
$LNG['bd_build_next_level']				= 'Ampliar al nivel ';
$LNG['bd_add_to_list']						= 'Añadir a la cola de producción';
$LNG['bd_no_more_fields']					= 'No hay espacio en el planeta';
$LNG['bd_remaining']						= 'Restantes';
$LNG['bd_lab_required']					= 'Para el desarrollo de nueva tecnología en tu planeta, es necesario que construyas un Laboratorio de Investigaciones, una vez construido podrás comenzar a desarrollar nuevas tecnologías para el crecimiento de tu imperio.';
$LNG['bd_building_lab']					= 'No se puede investigar cuando se está ampliando el laboratorio.';
$LNG['bd_max_lvl']							= '(Max. Nivel: %s)';
$LNG['bd_lvl']								= 'Nivel';
$LNG['bd_research']						= 'Investigar';
$LNG['bd_shipyard_required']				= 'Para el desarrollo de naves y estructuras defensivas, es necesario que construyas un Hangar, una vez construido podrás comenzar a desarrollar naves y estructuras defensivas.';
$LNG['bd_building_shipyard']				= 'No puedes fabricar durante la ampliación del hangar, fábrica de robots o nanobots.';
$LNG['bd_available']						= 'Disponible: ';
$LNG['bd_build_ships']						= 'Construir';
$LNG['bd_protection_shield_only_one']		= 'El escudo de protección sólo se puede construir una vez.';
$LNG['bd_build_defenses']					= 'Construir';
$LNG['bd_actual_production']				= 'Producción actual:';
$LNG['bd_completed']						= 'Completado';
$LNG['bd_operating']						= 'En funcionamiento';
$LNG['bd_continue']						= 'Continuar';
$LNG['bd_price_for_destroy']				= 'Coste de destrucción:';
$LNG['bd_ready']							= 'Listo';
$LNG['bd_finished']						= 'Terminado';
$LNG['bd_maxlevel']						= 'Nivel máximo alcanzado';
$LNG['bd_on']								= 'on';
$LNG['bd_max_builds']						= 'Puede max. %d enviar ordenes!';
$LNG['bd_next_level']						= 'Próximo nivel:';
$LNG['bd_need_engine']						= '<font color="#FF0000">-%s</font>';
$LNG['bd_more_engine']						= '<font color="#00FF00">+%s</font>';
$LNG['bd_jump_gate_action']				= 'Saltar a';
$LNG['bd_cancel_warning']					= 'Durante la demolición, sólo el 60% de los recursos se restaurará.';
$LNG['bd_cancel_send']						= 'Eliminar - Seleccionar';
$LNG['bd_destroy_time'] 					= 'Duración';
$LNG['sys_notenough_money'] 				= 'En el planeta %s <a href="?page=buildings&amp;cp=%d&amp;re=0">[%d:%d:%d]</a> no tienes suficientes recursos para construir %s . <br>Ahora tienes %s %s , %s %s y %s %s. <br>El coste de la construcción es %s %s , %s %s y %s %s.';
$LNG['sys_nomore_level'] 					= 'Intentas destruir un edificio que ya no tiene más ( %s ).';
$LNG['sys_buildlist'] 						= 'Colas';
$LNG['sys_techlist'] 						= 'Lista de búsqueda';
$LNG['sys_buildlist_fail'] 					= 'La Construcción no es posible.';


//----------------------------------------------------------------------------//
//RESOURCES
$LNG['rs_amount']							= 'Cantidad';
$LNG['rs_lvl']								= 'nivel';
$LNG['rs_production_on_planet']			= 'Producción de recursos en el planeta "%s"';
$LNG['rs_basic_income']					= 'Ingresos básicos';
$LNG['rs_storage_capacity']				= 'Almacenes';
$LNG['rs_calculate']						= 'Calcular';
$LNG['rs_sum']								= 'Total:';
$LNG['rs_daily']							= 'Por dia:';
$LNG['rs_weekly']							= 'Por Semana:';

//----------------------------------------------------------------------------//
//TRADER
$LNG['tr_empty_darkmatter']				= 'No tienes suficiente %s.';
$LNG['tr_cost_dm_trader']					= 'El valor de las tasas es <font color=\'orange\'><b>%s</b></font> de %s';
$LNG['tr_almacenes']					= 'La información sobre la capacidad de tus almacenes puedes verla en tu visor de recursos o en la página de gestión de recursos.';
$LNG['tr_only_positive_numbers']			= 'Sólo se pueden usar cantidades sobre cero.';
$LNG['tr_elemento'] 						= 'Comprar unidades de ';
$LNG['tr_not_enought_metal']				= 'No tienes suficiente niobio.';
$LNG['tr_not_enought_crystal']				= 'No tienes suficiente germanio.';
$LNG['tr_not_enought_deuterium']			= 'No tienes suficiente deuterio.';
$LNG['tr_not_enought_norio']				= 'No tienes suficiente norio.';
$LNG['tr_exchange_done']					= 'Intercambio realizado con éxito.';
$LNG['tr_call_trader']						= 'Mercado de Recursos Intergaláctico';
$LNG['tr_call_trader_who_buys']				= 'Llamar a un negociante que compre los siguientes recursos:';
$LNG['tr_descr']							= 'Un comerciante solo proporciona tantos recursos como capacidad de almacenamiento haya disponible.';
$LNG['tr_call_trader_submit']				= 'Negociar';
$LNG['tr_exchange_quota']					= 'El tipo de intercambio es de 2/1/0.25/0.5';
$LNG['tr_sell_metal']						= 'Vender niobio';
$LNG['tr_sell_crystal']					= 'Vender germanio';
$LNG['tr_sell_deuterium']					= 'Vender deuterio';
$LNG['tr_sell_norio']					= 'Vender norio';
$LNG['tr_resource']						= 'Recurso';
$LNG['tr_amount']							= 'Cantidad';
$LNG['tr_quota_exchange']					= 'Cuota de intercambio';
$LNG['tr_exchange']						= 'Intercambiar';

//----------------------------------------------------------------------------//
//TECHTREE
$LNG['tt_requirements']					= 'Requisitos';
$LNG['tt_lvl']								= 'Nivel ';

//----------------------------------------------------------------------------//
//INFOS
$LNG['in_jump_gate_done']                    = 'El salto cuántico fue realizado, el próximo salto podrá ser realizado en: <span id="bxxGate1">%s</span>';
$LNG['in_jump_gate_error_data']			= '&#161;Error, los datos para el salto son incorrectos!';
$LNG['in_jump_gate_not_ready_target']		= 'El salto cuántico no está listo en la Luna de destino, estará listo en: ';
$LNG['in_jump_gate_doesnt_have_one']		= '&#161;No tienes Salto cuántico en esa luna!';
$LNG['in_jump_gate_already_used']			= 'El Salto cuántico fue usado, tiempo para recargar su energía: ';
$LNG['in_jump_gate_available']				= 'disponible';
$LNG['in_rf_again']    					= 'Fuego rapido contra';
$LNG['in_rf_from']     					= 'Fuego rapido de';
$LNG['in_level']       					= 'Nivel';
$LNG['in_prod_p_hour'] 					= 'Producción/hora';
$LNG['in_difference']  					= 'Diferencia';
$LNG['in_used_energy'] 					= 'Consumo de energía';
$LNG['in_prod_energy'] 					= 'Producción de energía';
$LNG['in_used_deuter']						= 'Consumo de deuterio';
$LNG['in_range']       					= 'Rango de sensores';
$LNG['in_title_head']  					= 'Información de';
$LNG['in_name']        					= 'Nombre';
$LNG['in_struct_pt']   					= 'Puntos de Estructura';
$LNG['in_shield_pt']   					= 'Integridad del Escudo';
$LNG['in_attack_pt']   					= 'Poder de ataque';
$LNG['in_capacity']    					= 'Capacidad de carga';
$LNG['in_units']       					= 'unidades';
$LNG['in_base_speed'] 						= 'Velocidad base';
$LNG['in_consumption'] 					= 'Consumo de combustible (Deuterio)';
$LNG['in_jump_gate_start_moon']			= 'Luna de partida';
$LNG['in_jump_gate_finish_moon']			= 'Luna de destino';
$LNG['in_jump_gate_select_ships']			= 'Usar Salto Cuántico: número de naves';
$LNG['in_jump_gate_wait_time']				= 'Siguiente posible su uso';
$LNG['in_jump_gate_jump']					= 'Saltar';
$LNG['in_destroy']     					= 'Destruir:';
$LNG['in_needed']      					= 'Necesita';
$LNG['in_dest_durati'] 					= 'Duración de destrucción';

//----------------------------------------------------------------------------//
//MESSAGES
$LNG['mg_type'][0]    						= 'Informes de espionajes';
$LNG['mg_type'][1]    						= 'Mensajes de jugadores';
$LNG['mg_type'][2]    						= 'Mensajes de la alianza';
$LNG['mg_type'][3]    						= 'Informes de batallas';
$LNG['mg_type'][4]    						= 'Mensajes del Sistema';
$LNG['mg_type'][5]    						= 'Informes de tranportes';
$LNG['mg_type'][15]   						= 'Informes de expediciones';
$LNG['mg_type'][50]						    = 'Noticias del Juego';
$LNG['mg_type'][99]   						= 'Informes de construcciones';
$LNG['mg_type'][100]						= 'Ver todos los Mensajes';
$LNG['mg_type'][999]						= 'Bandeja de Salida';
$LNG['mg_id_to_id']  						= 'No puedes enviarte un mensaje a ti mismo';
$LNG['mg_no_subject']						= 'Sin asunto';
$LNG['mg_no_text']							= 'Falta el mensaje';
$LNG['mg_msg_sended']						= '¡Mensaje enviado!';
$LNG['mg_delete_marked']					= 'Borrar mensajes marcados';
$LNG['mg_delete_type_all']					= 'Borrar todos los mensajes de este tipo';
$LNG['mg_delete_unmarked']					= 'Borrar todos los mensajes sin marcar';
$LNG['mg_delete_all']						= 'Borrar todos los mensajes';
$LNG['mg_show_only_header_spy_reports']	= 'Mostrar sólo el encabezado de los informes de espionaje';
$LNG['mg_action']							= 'Acción';
$LNG['mg_date']							= 'Fecha';
$LNG['mg_from']							= 'De';
$LNG['mg_to']								= 'a';
$LNG['mg_subject']							= 'Asunto';
$LNG['mg_confirm_delete']					= 'Confirmar';
$LNG['mg_message_title']					= 'Mensajes';
$LNG['mg_message_type']					= 'Tipo del mensaje';
$LNG['mg_total']							= 'Total';
$LNG['mg_game_operators']					= 'Operadores del juego';
$LNG['mg_error']							= '¡Destinatario no encontrado!';
$LNG['mg_overview']						= 'Resumen';
$LNG['mg_send_new']						= 'Escribir un mensaje';
$LNG['mg_send_to']							= 'Destinatario';
$LNG['mg_message']							= 'Mensaje';
$LNG['mg_characters']						= 'Caracteres';
$LNG['mg_send']							= 'Enviar';
$LNG['mg_game_message']					= 'Mensajes del juego';
$LNG['mg_message_send']                 = 'Mensaje enviado!';
$LNG['mg_empty_text']                           = '¡Introduce el texto!';
$LNG['mg_answer_to']						= 'Responder a:';

//----------------------------------------------------------------------------//
//ALLIANCE

$LNG['al_newname_alphanum']				= 'El nombre de la Alianza y el de la Etiqueta solo pueden contener caracteres alfanumericos.';
$LNG['al_newname_no_space']				= 'El nombre de la Alianza y el de la Etiqueta no deben contener espacios.';
$LNG['al_nivel_error']								= '<center><img width="120" height="120" src="styles/images/rangos/3.png" /></center><br /><b>Es necesario ser almenos nivel 3 para poder crear una alianza.<br /> Para llegar al nivel 3 es necesario tener más de 10.000 puntos</b>.';
$LNG['al_description_message']				= 'Mensaje de descripción de la alianza.';
$LNG['al_web_text']						= 'Web de la alianza';
$LNG['al_request']							= 'Solicitud';
$LNG['al_click_to_send_request']			= 'Enviar solicitud de ingreso';
$LNG['al_tag_required']					= 'Falta la etiqueta de la alianza.';
$LNG['al_name_required']					= 'Falta el nombre de la alianza.';
$LNG['al_already_exists']					= 'El congreso del universo te informa que la Alianza %s ya existe.';
$LNG['al_created']							= 'Haz fundado la alianza %s, la alianza ha sido aceptada por el congreso del universo.';
$LNG['al_continue']						= 'continuar';
$LNG['al_alliance_closed']					= 'Esta alianza no admite nuevos miembros';
$LNG['al_request_confirmation_message']	= 'Solicitud enviada. Recibirás un mensaje cuando tu solicitud sea aceptada o rechazada por el líder o el encargado de la alianza. <br><a href="game.php?page=alliance">Volver</a>';
$LNG['al_default_request_text']			= 'Los líderes de la alianza no han creado un formulario de ingreso en la alianza, o no necesitan uno.';
$LNG['al_write_request']					= 'Escribir solicitud a la alianza %s';
$LNG['al_request_deleted']					= 'Tu solicitud ha sido eliminada. <br/>Ahora puedes escribir una nueva solicitud o crear tu propia alianza.';
$LNG['al_request_wait_message']			= 'Ya has enviado una solicitud a la alianza %s. <br/>Por favor, espera hasta que recibas una respuesta de ellos o borra la solicitud.';
$LNG['al_delete_request']					= 'Borrar solicitud';
$LNG['al_founder_cant_leave_alliance']		= 'Eres el fundador, por lo tanto no puedes abandonar la alianza.';
$LNG['al_leave_sucess']					= 'Abandonaste la alianza %s con éxito.';
$LNG['al_do_you_really_want_to_go_out']	= '¿Realmente deseas salir de la alianza %s?';
$LNG['al_go_out_yes']						= 'Sí';
$LNG['al_go_out_no'] 						= 'No';
$LNG['al_close_ally'] 						= '¿De verdad quieres renunciar a tu puesto en la alianza?';
$LNG['al_kick_player']						= '¿De verdad quieres expulsar al jugador %s de la alianza?';
$LNG['al_circular_sended']					= 'Mensaje circular enviado, Los siguientes miembros recibieron tu mensaje:';
$LNG['al_all_players']						= 'Todos los jugadores';
$LNG['al_no_ranks_defined']				= 'No se definieron rangos.';
$LNG['al_request_text']					= 'Texto de la solicitud';
$LNG['al_inside_text']						= 'Texto interno';
$LNG['al_outside_text']					= 'Texto externo';
$LNG['al_transfer_alliance']				= 'Transferir alianza';
$LNG['al_disolve_alliance']				= 'Disolver alianza';
$LNG['al_founder_rank_text']				= 'Fundador';
$LNG['al_new_member_rank_text']			= 'Nuevo miembro';
$LNG['al_acept_request']					= 'Aceptar';
$LNG['al_you_was_acceted']					= 'Fuiste aceptado en ';
$LNG['al_hi_the_alliance']					= '&#161;Saludos!<br>La alianza <b>';
$LNG['al_has_accepted']					= '</b> a aceptado tu solicitud.<br>Mensaje del fundador: <br>';
$LNG['al_decline_request']					= 'Rechazar';
$LNG['al_you_was_declined']				= 'Fuiste rechazado en ';
$LNG['al_has_declined']					= '</b> a rechazado tu solicitud.<br>Mensaje del fundador: <br>';
$LNG['al_no_requests']						= 'No hay solicitudes';
$LNG['al_request_from']					= 'Solicitud de "%s"';
$LNG['al_no_request_pending']				= 'Hay %d solicitud(es) pendiente(s)';
$LNG['al_name']							= 'nombre';
$LNG['al_new_name']						= 'Nuevo nombre (3-30 Caracteres):';
$LNG['al_tag']								= 'etiqueta';
$LNG['al_new_tag']							= 'Nueva etiqueta (3-8 Characteres)';
$LNG['al_user_list']						= 'Lista de miembros';
$LNG['al_users_list']						= 'Lista de miembros (%d)';
$LNG['al_manage_alliance']					= 'Administrar la alianza';
$LNG['al_send_circular_message']			= 'Enviar mensaje global';
$LNG['al_circular_front_text']				= 'El jugador %s ha escrito:';
$LNG['al_new_requests']					= 'd% nueva/s peticion/es';
$LNG['al_goto_chat']						= 'Ir al Chat de la Alianza';
$LNG['al_save']							= 'Guardar';
$LNG['al_dlte']							= 'Borrar';
$LNG['al_rank_name']						= 'Nombre del Rango';
$LNG['al_ok']								= 'OK';
$LNG['al_num']								= 'ID';
$LNG['al_member']							= 'Miembro';
$LNG['al_request_from_user']				= 'Suscripción de jugadores';
$LNG['al_message']							= 'Mensaje';
$LNG['al_position']						= 'Posición';
$LNG['al_points']							= 'Puntos';
$LNG['al_coords']							= 'Coordenadas';
$LNG['al_member_since']					= 'Miembro desde';
$LNG['al_estate']							= 'Estado';
$LNG['al_back']							= 'Volver';
$LNG['al_actions']							= 'Acciones';
$LNG['al_change_title']					= 'Cambiar';
$LNG['al_the_alliance']					= 'de la alianza';
$LNG['al_change_submit']					= 'Cambiar';
$LNG['al_reply_to_request']				= 'Respuesta a la solicitud';
$LNG['al_reason']							= 'Motivo';
$LNG['al_characters']						= 'caracteres';
$LNG['al_request_list']					= 'Lista de solicitudes';
$LNG['al_candidate']						= 'Candidato';
$LNG['al_request_date']					= 'Fecha de solicitud';
$LNG['al_transfer_alliance']				= 'Expulsar a todos los miembros de la Alianza';
$LNG['al_transfer_to']						= 'Transferir a';
$LNG['al_transfer_submit']					= 'Transferir';
$LNG['al_ally_information']				= 'Información de la alianza';
$LNG['al_ally_info_tag']					= 'Etiqueta';
$LNG['al_ally_info_name']					= 'Nombre';
$LNG['al_ally_info_members']				= 'Miembros';
$LNG['al_your_request_title']				= 'Tu solicitud';
$LNG['al_applyform_send']					= 'Enviar';
$LNG['al_applyform_reload']				= 'Recargar';
$LNG['al_circular_send_ciruclar']			= 'Enviar mensaje global';
$LNG['al_circular_alliance']               = 'Alianza ';
$LNG['al_receiver']						= 'Destinatario';
$LNG['al_circular_send_submit']			= 'Enviar';
$LNG['al_circular_reset']					= 'Limpiar';
$LNG['al_alliance']						= 'Alianzas';
$LNG['al_alliance_make']					= 'Fundar tu propia alianza';
$LNG['al_alliance_search']					= 'Buscar una alianza';
$LNG['al_your_ally']						= 'Tu alianza';
$LNG['al_rank']							= 'Rango';
$LNG['al_web_site']						= 'Sitio web';
$LNG['al_inside_section']					= 'Sección interna';
$LNG['al_make_alliance']					= 'Fundar una alianza';
$LNG['al_make_ally_tag_required']			= 'Etiqueta de la alianza (De 3-8 caracteres)';
$LNG['al_make_ally_name_required']			= 'Nombre de la alianza (Máx. 35 caracteres)';
$LNG['al_make_submit']						= 'fundar';
$LNG['al_find_alliances']					= 'Buscar alianzas';
$LNG['al_find_text']						= 'Buscar';
$LNG['al_find_no_alliances']				= 'Alianza no encontrada.';
$LNG['al_find_submit']						= 'Buscar';
$LNG['al_manage_ranks']					= 'Administrar rangos';
$LNG['al_manage_members']					= 'Administrar miembros';
$LNG['al_manage_change_tag']				= 'Etiqueta de la alianza';
$LNG['al_manage_change_name']				= 'Nombre de la alianza';
$LNG['logo']								= 'Escudo de la alianza';
$LNG['al_texts']							= 'Textos';
$LNG['al_manage_options']					= 'Opciones';
$LNG['al_manage_image']					= 'Imágen de la alianza';
$LNG['al_manage_requests']					= 'Solicitudes';
$LNG['al_manage_diplo']                    = 'Diplomácia de la alianza';
$LNG['al_requests_not_allowed']			= 'No permitidas(alianza cerrada)';
$LNG['al_requests_allowed']				= 'Permitidas(alianza abierta)';
$LNG['al_manage_founder_rank']				= 'Rango del fundador';
$LNG['al_configura_ranks']					= 'Configurar';
$LNG['al_create_new_rank']					= 'Crear rango';
$LNG['al_rank_name']						= 'Nombre del rango';
$LNG['al_create']							= 'Crear';
$LNG['al_legend']							= 'Leyendas';
$LNG['al_legend_disolve_alliance']			= 'Disolver la alianza';
$LNG['al_legend_kick_users']				= 'Expulsar usuario';
$LNG['al_legend_see_requests']				= 'Ver las solicitudes';
$LNG['al_legend_see_users_list']			= 'Ver la lista de miembros';
$LNG['al_legend_check_requests']			= 'Revisar las solicitudes';
$LNG['al_legend_admin_alliance']			= 'Administrar la alianza';
$LNG['al_legend_see_connected_users']		= 'Ver los miembros conectados';
$LNG['al_legend_create_circular']			= 'Escribir un correo circular';
$LNG['al_legend_right_hand']				= 'Mano Derecha (Necesario para transferir la alianza)';
$LNG['al_requests']						= 'Solicitudes';
$LNG['al_circular_message']				= 'Correo circular';
$LNG['al_leave_alliance']					= 'Abandonar la alianza';
$LNG['al_Gesamtk']     					= 'Batallas';
$LNG['al_Erfolg']       					= 'Batallas con éxito';
$LNG['al_Siege']        					= 'Ganador';
$LNG['al_Drawp']        					= 'Empate';
$LNG['al_Loosi']        					= 'Perdedor';
$LNG['al_KGesamt']      					= 'Batallas totales';
$LNG['al_Allyquote']    					= 'Records de batallas de los aliados';
$LNG['al_Quote']        					= 'Cotización de victoria';
$LNG['pactos']        						= 'Pactos';
$LNG['alianzas']        					= 'Alianzas';
$LNG['al_unitsshut']    					= 'Unidades Matadas';
$LNG['al_unitsloos']    					= 'Unidades Perdidas';
$LNG['al_tfmetall']     					= 'Total de escombros de niobio';
$LNG['al_tfkristall']   					= 'Total de escombros de germanio';
$LNG['al_view_stats']						= 'Registro público de batallas';
$LNG['al_view_diplo']                      = 'Diplomácia pública';
$LNG['al_memberlist_min']					= 'min';
$LNG['al_memberlist_on']					= 'Online';
$LNG['al_memberlist_off']					= 'Offline';
$LNG['al_diplo']                            = 'Diplomácia';
$LNG['al_diplo_level'][0]                    = 'Volar';
$LNG['al_diplo_level'][1]                    = 'Pacto de Alianza ';
$LNG['al_diplo_level'][2]                    = 'Pacto de Comercio';
$LNG['al_diplo_level'][3]                    = 'Pacto de no Agresion';
$LNG['al_diplo_level'][4]                    = 'En Guerra';
$LNG['al_diplo_no_entry']                    = '- No Existen Pactos -';
$LNG['al_diplo_no_accept']                    = '- Ninguna solicitud disponible -';
$LNG['al_diplo_accept']                    = 'Solicitudes entrantes';
$LNG['al_diplo_accept_send']                = 'Solicitudes enviadas';
$LNG['al_diplo_create']                    = 'Crear nuevo pacto.';
$LNG['al_diplo_create_done']                = 'Pacto creado satisfactoriamente.';
$LNG['al_diplo_ally']                        = 'Alianza ';
$LNG['al_diplo_level_des']                    = 'Sobre la alianza';
$LNG['al_diplo_text']                        = 'Texto de la pregunta/justificación';
$LNG['al_diplo_accept_yes']                = 'Pacto firmado.';
$LNG['al_diplo_accept_yes_mes']            = 'El pacto de %s fue firmado entre las alianzas %s y %s.';
$LNG['al_diplo_accept_yes_confirm']		= '¿Realmente quieres aceptar el pacto?';
$LNG['al_diplo_accept_no']                    = 'Pacto rechazado.';
$LNG['al_diplo_accept_no_mes']                = 'El pacto de %s entre las alianzas %s y %s fue rechazado.';
$LNG['al_diplo_accept_no_confirm']			= '¿Realmente quieres oponerte al pacto?';
$LNG['al_diplo_delete']                    = 'Abolir pacto.';
$LNG['al_diplo_delete_mes']                = 'El pacto de %s entre las alianzas %s y %s se ha roto.';
$LNG['al_diplo_confirm_delete']            = '¿De verdad quieres eliminar el pacto?';
$LNG['al_diplo_ground']                    = 'Razón:';
$LNG['al_diplo_ask']                        = 'Consulta de pacto';
$LNG['al_diplo_ask_mes']                    = 'Se hace un pacto de (%s) entre las alianzas -> %s <- y -> %s <-. <br>Razón: %s <br> Puedes aceptar o negar la diplomacia de la alianza';
$LNG['al_diplo_war']                        = 'Declaración de Guerra';
$LNG['al_diplo_war_mes']                    = 'La guerra ha sido declarada entre las alianzas  -> %s <- y -> %s <-.<br>Razón: %s <br><br>Información: Ambos dirigentes de las Alianzas estan de acuerdo con la guerra. Leer las reglas sobre las Guerra entre las alianzas para que todo sea legal...';
$LNG['al_leave_ally']					= '¿Realmente deseas salir de la alianza?';

//----------------------------------------------------------------------------//
//BUDDY
$LNG['bu_request_exists']					= 'Ya existe una solicitud a ese jugador.';
$LNG['bu_cannot_request_yourself']			= 'No puedes solicitarte como compañero a ti mismo -.-';
$LNG['bu_request_message']					= 'Mensaje de solicitud';
$LNG['bu_player']							= 'Jugador';
$LNG['bu_request_text']					= 'Texto de solicitud';
$LNG['bu_characters']						= 'caracteres';
$LNG['bu_back']							= 'Volver';
$LNG['bu_send']							= 'Enviar';
$LNG['bu_cancel_request']					= 'Cancelar Solicitud';
$LNG['bu_accept']							= 'Aceptar';
$LNG['bu_decline']							= 'Rechazar';
$LNG['bu_connected']						= 'Conectado';
$LNG['bu_minutes']					= 'minutos';
$LNG['bu_disconnected']					= 'Desconectado';
$LNG['bu_online']							= 'Conectado';
$LNG['bu_buddy_list']						= 'Lista de compañeros';
$LNG['bu_requests']						= 'Solicitudes';
$LNG['bu_alliance']						= 'Alianza';
$LNG['bu_coords']							= 'Coordenadas';
$LNG['bu_text']							= 'Texto';
$LNG['bu_action']							= 'Acción';
$LNG['bu_my_requests']						= 'Mis solicitudes';
$LNG['bu_partners']						= 'Amigos';
$LNG['bu_delete']							= 'eliminar';
$LNG['bu_no_request']						= '¡Ninguna solicitud!';
$LNG['bu_no_buddys']						= '¡No tienes amigos aún!';
$LNG['bu_request_send']					= 'Solicitud enviada!';

//----------------------------------------------------------------------------//
//NOTES
$LNG['nt_important']						= 'Importante';
$LNG['nt_normal']							= 'Normal';
$LNG['nt_unimportant']						= 'Sin importancia';
$LNG['nt_create_note']						= 'Hacer una nota';
$LNG['nt_you_dont_have_notes']				= 'No tienes notas';
$LNG['nt_notes']							= 'Notas';
$LNG['nt_create_new_note']					= 'Crear nueva nota';
$LNG['nt_edit_note']						= 'Editar nota';
$LNG['nt_date_note']						= 'Fecha';
$LNG['nt_subject_note']					= 'Asunto';
$LNG['nt_size_note']						= 'Tamaño';
$LNG['nt_dlte_note']						= 'Borrar';
$LNG['nt_priority']						= 'Prioridad';
$LNG['nt_note']							= 'Nota';
$LNG['nt_characters']						= 'caracteres';
$LNG['nt_back']							= 'Volver';
$LNG['nt_reset']							= 'Reestablecer';
$LNG['nt_save']							= 'Guardar';
$LNG['nt_no_title']						= 'Sin titulo';
$LNG['nt_no_text']							= 'Sin texto';

//----------------------------------------------------------------------------//
//STATISTICS
$LNG['st_player']							= 'Jugador';
$LNG['st_alliance']						= 'Alianza';
$LNG['st_points']							= 'Puntos';
$LNG['st_fleets']							= 'Flotas';
$LNG['st_researh']							= 'Tecnología';
$LNG['st_buildings']						= 'Estructuras';
$LNG['st_defenses']						= 'Defensas';
$LNG['st_position']						= 'Posición';
$LNG['st_members']							= 'Miembros';
$LNG['st_per_member']						= 'Por Miembro';
$LNG['st_statistics']						= 'Estadísticas';
$LNG['st_updated']							= 'Actualizadas';
$LNG['st_escudo']							= 'Escudo';
$LNG['st_show']							= 'Mostrar';
$LNG['st_per']								= 'Categoría';
$LNG['st_in_the_positions']				= 'En las posiciones';
$LNG['st_write_message']					= 'Mensaje Privado';

//----------------------------------------------------------------------------//
//SEARCH
$LNG['sh_tag']								= 'Etiqueta';
$LNG['sh_name']							= 'Nombre';
$LNG['sh_members']							= 'Miembros';
$LNG['sh_points']							= 'Puntos';
$LNG['sh_search_in_the_universe']			= 'Buscar en el Universo';
$LNG['sh_player_name']						= 'Nombre del jugador';
$LNG['sh_planet_name']						= 'Nombre del planeta';
$LNG['sh_alliance_tag']					= 'Etiqueta de la alianza';
$LNG['sh_alliance_name']					= 'Nombre de la alianza';
$LNG['sh_search']							= 'Buscar';
$LNG['sh_write_message']					= 'Mensaje Privado';
$LNG['sh_buddy_request']					= 'Solicitud de amistad';
$LNG['sh_alliance']						= 'Alianza';
$LNG['sh_planet']							= 'Planeta';
$LNG['sh_coords']							= 'Coordenadas';
$LNG['sh_position']						= 'Posición';

//----------------------------------------------------------------------------//
//OPTIONS
$LNG['op_cant_activate_vacation_mode']		= 'Si estás construyendo o moviendo flotas no podrás entrar al modo vaciones.';
$LNG['op_password_changed']				= 'La contraseña ha sido cambiada.<br /><a href="index.php" target="_top">Volver</a>';
$LNG['op_username_changed']				= 'El nombre de usuario ha sido cambiado.<br /><a href="index.php" target="_top">Volver</a>';
$LNG['op_options_changed']					= 'Los cambios se han guardado.<br /><a href="game.php?page=options">Volver</a>';
$LNG['op_vacation_mode_active_message']	= 'El modo vacaciones esta activado. Tendrás que estar de vacaciones como mínimo hasta el: ';
$LNG['op_end_vacation_mode']				= 'Finalizar modo vacaciones';
$LNG['op_save_changes']					= 'Guardar cambios';
$LNG['op_admin_title_options']				= 'Opciones reservadas para la administración';
$LNG['op_admin_planets_protection']		= 'Protección de planetas';
$LNG['op_user_data']						= 'Datos de usuario';
$LNG['op_username']						= 'Nombre de usuario';
$LNG['op_old_pass']						= 'Contraseña actual';
$LNG['op_new_pass']						= 'Nueva contraseña (min. 8 Caracteres)';
$LNG['op_repeat_new_pass']					= 'Nueva contraseña (repetir)';
$LNG['op_email_adress']					= 'Dirección de correo electrónico';
$LNG['op_permanent_email_adress']			= 'Dirección pemanente de correo electrónico';
$LNG['op_general_settings']				= 'Opciones generales';
$LNG['op_sort_planets_by']					= 'Ordenar planetas por:';
$LNG['op_sort_kind']						= 'Tipo de ordenación:';
$LNG['op_lang']							= 'Idioma:';
$LNG['op_skin_example']					= 'Diseños:';
$LNG['op_show_skin']						= 'Utilizar el diseño';
$LNG['op_deactivate_ipcheck']				= '<font color="red">Desactivar comprobación de IP</font>';
$LNG['op_galaxy_settings']					= 'Opciones de visión de Galaxia';
$LNG['op_spy_probes_number']				= 'Cantidad de sondas de espionaje';
$LNG['op_toolt_data']						= 'Información sobre herramientas';
$LNG['op_seconds']							= 'segundos';
$LNG['op_max_fleets_messages']				= 'Máximo mensajes de flotas';
$LNG['op_show_planetmenu']					= 'Menú, Visión Planetas';
$LNG['op_shortcut']						= 'Acceso directo';
$LNG['op_show']							= 'Mostrar';
$LNG['op_spy']								= 'Espiar';
$LNG['op_write_message']					= 'Escribir mensaje';
$LNG['op_add_to_buddy_list']				= 'Agregar a la lista de amigos';
$LNG['op_missile_attack']					= 'Ataque con misiles';
$LNG['op_send_report']						= 'Enviar informe';
$LNG['op_vacation_delete_mode']			= 'Modo de vacaciones / Borrar cuenta';
$LNG['op_activate_vacation_mode']			= 'Activar modo vacaciones';
$LNG['op_dlte_account']					= 'Borrar cuenta';
$LNG['op_email_adress_descrip']			= 'Ésta dirección puede ser cambiada en cualquier momento. La dirección será permanente si no se realizan cambios en los próximos 7 días.';
$LNG['op_deactivate_ipcheck_descrip']		= 'La comprobación de IP significa que se realizará una desconexión de seguridad automáticamente cuando cambie la IP o cuando 2 personas entren en la misma cuenta usando diferentes IPs. ¡Desactivar la comprobación de IP puede causar un agujero de seguridad!';
$LNG['op_spy_probes_number_descrip']		= 'Cantidad de sondas de espionaje que serán enviadas en cada espionaje desde el menú de galaxia.';
$LNG['op_activate_vacation_mode_descrip']	= 'El modo vacaciones protege tu cuenta durante tu ausencia. Sólo podrá ser activada si no se está construyendo nada (flotas, edificios o defensas), nada está siendo investigado y ninguna de tus flotas está en movimiento. Una vez activada estás protegido contra ataques. Los ataques que esten en proceso finalizaran. Durante las vacaciones la producción se establece a cero y deberas devolverla al 100% cuando vuelvas a estar activo. El modo vacaciones dura como mínimo dos dias y solo se podra desactivar despues de ese tiempo.';
$LNG['op_dlte_account_descrip']			= 'Si seleccionas ésta opcion, el sistema borrará tu cuenta automáticamente pasados 7 días.';
$LNG['op_not_vaild_mail']                                       = 'No tienes una dirección válida de correo electrónico.';
$LNG['op_change_mail_exist']                            = 'La dirección de correo electrónico %s ya está en uso.';
$LNG['op_sort_normal']						= 'Orden de creación';
$LNG['op_sort_koords']						= 'Coordenadas';
$LNG['op_sort_abc']						= 'Alfabeticamente';
$LNG['op_sort_up']							= 'Ascendiente';
$LNG['op_sort_down']						= 'Descendiente';
$LNG['op_user_name_no_alphanumeric']		= 'Por favor introduce en el nombre de usuario sólo caracteres alfanuméricos.';
$LNG['op_change_name_pro_week']			= 'Puede cambiar su nombre de usuario sólo 1 vez por semana.';
$LNG['op_change_name_exist']				= 'El nombre %s ya existe.';
$LNG['op_active_build_messages']			= 'Cola de mensajes';
$LNG['op_small_storage']                    = 'Mostrar el tamaño de almacenamiento';

//----------------------------------------------------------------------------//
//BANNED
$LNG['bn_no_players_banned']				= 'No hay jugadores baneados';
$LNG['bn_exists']							= 'Existe ';
$LNG['bn_players_banned']					= ' jugador/es baneado/s';
$LNG['bn_players_banned_list']				= 'Lista de jugadores baneados';
$LNG['bn_player']							= 'Jugador';
$LNG['bn_reason']							= 'Motivo';
$LNG['bn_from']							= 'Desde el';
$LNG['bn_until']							= 'Hasta el';
$LNG['bn_by']								= 'Por';
$LNG['bn_writemail']						= 'Mail a %s';

//----------------------------------------------------------------------------//
//class.CheckSession.php

$LNG['css_account_banned_message']			= 'Tu cuenta ha sido baneada.';
$LNG['css_account_banned_expire']			= 'Por esta razón %s estás baneado.';
$LNG['css_goto_homeside']					= '<a href="./index.php">Ir a la página principal</a>';
$LNG['css_server_maintrace']				= 'Servidor en mantenimiento<br><br>El juego está cerrado.<br><br>Razón: %s';

//----------------------------------------------------------------------------//
//class.debug.php
$LNG['cdg_mysql_not_available']			= 'No hay conexión a la base de datos.<br>Por favor, intentalo más tarde.<br><br>Pedimos disculpas por el inconveniente.';
$LNG['cdg_error_message']					= 'Se produjo un error en la base de datos, por favor contacte al administrador. Error:';
$LNG['cdg_fatal_error']					= 'ERROR FATAL, por favor, espere a que la Administración se de cuenta de lo sucedido y repare el problema.<br>Atentamente, el sistema de SpaceOne.';

//----------------------------------------------------------------------------//
//class.FlyingFleetsTable.php

$LNG['cff_no_fleet_data']					= 'No hay datos de flota';
$LNG['cff_acs_fleet']						= 'flota sac';
$LNG['cff_fleet_own']						= 'Flota';
$LNG['cff_fleet_target']					= 'Flota';
$LNG['cff_mission_acs']						= 'Una  %s de %s %s %s se dirige a %s %s %s. Misión: %s';
$LNG['cff_mission_own_0']					= 'Una  %s de %s %s %s se dirige a %s %s %s. Misión: %s';
$LNG['cff_mission_own_1']					= 'Tu %s Vuelve de %s %s %s a %s %s %s. Misión: %s';
$LNG['cff_mission_own_2']					= 'Una  %s de %s %s %s esta en Orbita de %s %s %s. Misión: %s';
$LNG['cff_mission_own_mip']					= 'Ataque con Misiles (%d) desde %s %s %s hacia %s %s %s.';
$LNG['cff_mission_own_expo_0']				= 'Una %s de %s %s %s se dirige a %s. Misión: %s';
$LNG['cff_mission_own_expo_1']				= 'Una %s vuelve de %s  hacia %s %s %s. Misión: %s';
$LNG['cff_mission_own_expo_2']				= 'Una %s de %s %s %s va de expedición más alla de la posición %s. Misión: %s';
$LNG['cff_mission_own_recy_0']				= 'Una %s de %s %s %s se dirige al campo de escombros %s. Misión: %s';
$LNG['cff_mission_own_recy_1']				= 'Una %s vuelve del campo de escombros %s hacia %s %s %s. Misión: %s';
$LNG['cff_mission_target_bad']				= 'Una %s hostil del jugador %s de %s %s %s espia la posición %s %s %s. Misión: %s';
$LNG['cff_mission_target_good']				= 'Una %s hostil del jugador %s de %s %s %s espia la posición %s %s %s. Misión: %s';
$LNG['cff_mission_target_stay']				= 'Una %s pacífica del jugador %s de %s %s %s esta en orbita en %s %s %s. Misión: %s';
$LNG['cff_mission_target_mip']				= 'Ataque con Misiles (%d) del jugador %s de %s %s %s a la posición %s %s %s.';




//----------------------------------------------------------------------------//
// EXTRA LANGUAGE FUNCTIONS

$LNG['fcm_planet']							= 'Planeta';
$LNG['fcm_moon']							= 'Luna';
$LNG['fcm_info']							= 'Información';
$LNG['fcp_colony']							= 'Colonia';
$LNG['fgp_require']						= 'Requisitos: ';
$LNG['fgf_time']							= 'Tiempo de Construcción: ';
$LNG['sys_module_inactive']        	 	= 'Modulo inactivo';

//----------------------------------------------------------------------------//
// CombatReport.php
$LNG['cr_lost_contact']					= 'Se perdió el contacto con esta flota.';
$LNG['cr_first_round']						= '(La flota fue destruida en la primera ronda)';
$LNG['cr_type']							= 'Tipo';
$LNG['cr_total']							= 'Total';
$LNG['cr_weapons']							= 'Armas';
$LNG['cr_shields']							= 'Escudos';
$LNG['cr_armor']							= 'Blindaje';
$LNG['cr_destroyed']						= '&#161;Destruida!';

//----------------------------------------------------------------------------//
// FleetAjax.php
$LNG['fa_not_enough_probes']				= 'Lo sentimos, no hay sondas suficientes.';
$LNG['fa_galaxy_not_exist']				= 'Error, la galaxia no existe.';
$LNG['fa_system_not_exist']				= 'Error, el sistema no existe.';
$LNG['fa_planet_not_exist']				= 'Error, el planeta no existe.';
$LNG['fa_not_enough_fuel']					= 'Error, no tienes combustible suficiente.';
$LNG['fa_no_more_slots']					= 'Error, no tienes más slots de flotas disponibles.';
$LNG['fa_no_recyclers']					= 'Lo sentimos, no hay recicladores disponibles.';
$LNG['fa_no_fleetroom']					    = 'Error, el consumo de deuterio es mayor que la capacidad de transporte.';
$LNG['fa_mission_not_available']			= 'Error, misión no disponible.';
$LNG['fa_no_spios']						= 'Error, no se realizaron investigaciones.';
$LNG['fa_vacation_mode']					= 'El jugador se encuentra en modo vacaciones.';
$LNG['fa_week_player']						= 'el jugador es demasiado débil.';
$LNG['fa_strong_player']					= 'el jugador es demasiado fuerte.';
$LNG['fa_not_spy_yourself']				= 'Error, no puedes espiarte a ti mismo -.-';
$LNG['fa_not_attack_yourself']				= 'Error, no puedes atacarte a ti mismo -.-';
$LNG['fa_action_not_allowed']				= 'Error, acción no permitida.';
$LNG['fa_vacation_mode_current']			= 'Error, te encuentras en modo vacaciones.';
$LNG['fa_sending']							= 'Enviando.';

//----------------------------------------------------------------------------//
// MissilesAjax.php
$LNG['ma_silo_level']						= 'Debes tener al menos el silo al nivel 4';
$LNG['ma_impulse_drive_required']			= 'Debes investigar el Motor de Impulso.';
$LNG['ma_not_send_other_galaxy']			= 'No puedes enviar misiles a otra galaxia.';
$LNG['ma_planet_doesnt_exists']			= 'El planeta objetivo no existe.';
$LNG['ma_wrong_target']					= 'Objetivo Incorrecto';
$LNG['ma_no_missiles']						= 'No hay misiles interplanetarios disponibles.';
$LNG['ma_add_missile_number']				= 'Ingresar el número de misiles que deseas enviar';
$LNG['ma_misil_launcher']					= 'Lanzamisiles';
$LNG['ma_small_laser']						= 'Láser pequeño';
$LNG['ma_big_laser']						= 'Láser grande';
$LNG['ma_gauss_canyon']					= 'Cañón Gauss';
$LNG['ma_ionic_canyon']					= 'Cañón iónico';
$LNG['ma_buster_canyon']					= 'Cañón de plasma';
$LNG['ma_small_protection_shield']			= 'Cúpula pequeña de protección';
$LNG['ma_big_protection_shield']			= 'Cúpula grande de protección';
$LNG['ma_planet_protector']			= 'Protección Planetaria';
$LNG['ma_graviton_canyon']			= 'Cañón de Gravitón';
$LNG['ma_all']								= 'Todo';
$LNG['ma_missiles_sended']					= ' misiles interplanetarios enviados. Objetivo principal: ';

//----------------------------------------------------------------------------//
// topkb.php
$LNG['tkb_top']                  			= 'Top de Batallas';
$LNG['tkb_gratz']                  		= 'Top 100 de mayores batallas';
$LNG['tkb_platz']                  		= 'Lugar';
$LNG['tkb_owners']             			= 'Participantes';
$LNG['tkb_datum']                  		= 'Fecha';
$LNG['tkb_units']             				= 'Unidades';
$LNG['tkb_legende']               		 	= '<b>Leyenda: </b>';
$LNG['tkb_gewinner']              		 	= '<b>-Ganador-</b>';
$LNG['tkb_verlierer']              		= '<b>-Perdedaor-</b>';
$LNG['tkb_unentschieden']         			= '<b>-Empatado- </b>';
$LNG['tkb_missing']              		  	= '<br>Desaparecido en Acción: La cuenta de usuario ya no existe.';

//----------------------------------------------------------------------------//
// playercard.php
$LNG['pl_overview']  						= 'Carta de Usuario';
$LNG['pl_name'] 							= 'Usuario';
$LNG['pl_homeplanet'] 						= 'Planeta principal';
$LNG['pl_ally']     						= 'Alianza';
$LNG['pl_message']    						= 'Mensaje';
$LNG['pl_buddy']        					= 'Amistad';
$LNG['pl_points']      					= 'Puntos';
$LNG['pl_range']         					= 'Rango';
$LNG['pl_builds']     						= 'Estructuras';
$LNG['pl_tech']    						= 'Tecnología';
$LNG['pl_fleet']       					= 'Flotas';
$LNG['pl_def']         					= 'Defensas';
$LNG['pl_total']       					= 'Total';
$LNG['pl_fightstats'] 						= 'Estadística de batallas';
$LNG['pl_fights']     						= 'Batallas';
$LNG['pl_fprocent']       					= 'Posibilidades de batallas';
$LNG['pl_fightwon']  						= 'Ganadas';
$LNG['pl_fightdraw']  						= 'Empatadas';
$LNG['pl_fightlose']  						= 'Perdidas';
$LNG['pl_totalfight']      				= 'Total de batallas';
$LNG['pl_destroy']    						= '%s destrucciones';
$LNG['pl_unitsshot']    					= 'Unidades Eliminadas';
$LNG['pl_unitslose']    					= 'Unidades Perdidas';
$LNG['pl_dermetal']    					= 'Total de niobio en campos de escombros';
$LNG['pl_dercrystal']   					= 'Total de germanio en campos de escombros';
$LNG['pl_dernorio']   					= 'Total de norio en campos de escombros';
$LNG['pl_etc']   							= 'Otros';

//----------------------------------------------------------------------------//
// Chat

$LNG['chat_title']                         = 'Chat';
$LNG['chat_ally_title']                    = 'Chat de la Alianza';
$LNG['chat_bbcode']                    		= 'BB-Codes';
$LNG['chat_fontcolor']                    	= 'Color de Fuente';

$LNG['chat_disc']                          = 'Chat';
$LNG['chat_message']                       = 'Mensaje';
$LNG['chat_send']                          = 'Enviar';
$LNG['chat_admin']                       	= '<font color="red">Administrador %s</font>';
$LNG['chat_color_white']					= 'Blanco';
$LNG['chat_color_blue']						= 'Azul';
$LNG['chat_color_yellow']					= 'Amarillo';
$LNG['chat_color_green']					= 'Verde';
$LNG['chat_color_pink']						= 'Rosa';
$LNG['chat_color_red']						= 'Rojo';
$LNG['chat_color_orange']					= 'Naranja';

$LNG['chat_notext']							= '¡Escribe algo!';
$LNG['chat_request_url']					= 'Por favor, danos un enlace:';
$LNG['chat_request_url_desc']				= 'Introduce una descripción del enlace (opcional):';

//----------------------------------------------------------------------------//
// Support

$LNG['supp_header'] 						= 'Sistema de Soporte';
$LNG['supp_header_g']                      = 'Sistema de tickets';
$LNG['ticket_id'] 							= '#Ticket-ID';
$LNG['subject'] 							= 'Tema';
$LNG['status'] 							= 'Estado';
$LNG['ticket_posted'] 						= 'Creado por';
$LNG['ticket_new'] 						= 'Nuevo Ticket';
$LNG['input_text'] 						= 'Descripcion del problema:';
$LNG['answer_new'] 						= 'Nueva Respuesta:';
$LNG['text'] 								= 'Detalles';
$LNG['message_a'] 							= 'Estado del mensaje:';
$LNG['sendit_a'] 							= 'Mensaje ha sido enviado.';
$LNG['message_t'] 							= 'Estado del Ticket:';
$LNG['supp_send'] 							= 'Enviar';
$LNG['sendit_t'] 							= 'El ticket ha sido registrado.';
$LNG['close_t'] 							= 'El ticket está cerrado.';
$LNG['sendit_error'] 						= 'ERROR:';
$LNG['sendit_error_msg'] 					= 'No ha rellenado todos los datos!';
$LNG['supp_admin_system'] 					= 'Sistema de Gestión de Incidentes';
$LNG['close_ticket'] 						= 'Cerrar Ticket';
$LNG['open_ticket']                        = 'Abrir Ticket';
$LNG['player'] 							= 'Jugador';
$LNG['supp_ticket_close']					= 'Ticket cerrado';
$LNG['supp_close'] 						= 'Cerrar';
$LNG['supp_open'] 							= 'Abrir';
$LNG['supp_admin_answer'] 					= 'Respuesta del Admin';
$LNG['supp_player_answer'] 				= 'Respuesta del jugador';

//----------------------------------------------------------------------------//
// Records

$LNG['rec_build']  						= 'Estructuras';
$LNG['rec_specb']							= 'Estructuras Lunares';
$LNG['rec_playe']  						= 'Jugador';
$LNG['rec_defes']  						= 'Defensas';
$LNG['rec_fleet']  						= 'Naves';
$LNG['rec_techn']  						= 'Tecnologías';
$LNG['rec_level']  						= 'Nivel';
$LNG['rec_nbre']   						= 'Nombre';
$LNG['rec_rien']   						= '-';
$LNG['rec_last_update_on']   				= 'La última actualización fue: %s';


//----------------------------------------------------------------------------//
// BattleSimulator


$LNG['bs_derbis_raport']					= "Necesitas %s %s o %s %s para el campo de escombros.";
$LNG['bs_steal_raport']					= "Necesitas robar  %s %s o %s %s o %s %s .";
$LNG['bs_names']							= "Nave";
$LNG['bs_atter']							= "Agresor";
$LNG['bs_deffer']							= "Defensor";
$LNG['bs_steal']							= "Recursos(por robar):";
$LNG['bs_techno']							= "Tecnología";
$LNG['bs_send']							= "Enviar";
$LNG['bs_cancel']							= "Restablecer";
$LNG['bs_wait']							= "Por favor, espera 10 segundos para la siguiente simulación.";

//----------------------------------------------------------------------------//
// Fleettrader
$LNG['ft_head']                                                         = 'Comerciante de Flotas';
$LNG['ft_selecciona']                                           = 'Selecciona Unidad';
$LNG['ft_uniselec']                                                     = 'Unidad Seleccionada';
$LNG['ft_max']                                                          = 'Máx';
$LNG['ft_total']                                                        = 'Total';
$LNG['ft_charge']                                                       = 'Tasa del comerciante';
$LNG['ft_absenden']                                                     = 'Enviar';
$LNG['ft_empty']                                                        = 'No tienes nada que aportar al comerciante';
$LNG['ft_cantidad']                                                     = 'Cantidad ';
$LNG['ft_unidad']                                                       = 'Por unidad';

//----------------------------------------------------------------------------//
// Logout
$LNG['lo_title']						= 'Desconexión satisfactoria.';
$LNG['lo_logout']						= 'Sessión Terminada.';
$LNG['lo_redirect']						= 'Redireccionando';
$LNG['lo_notify']                       = 'Seras redireccionado en <span id="seconds"> 5 </ span>';
$LNG['lo_continue']						= 'Pulsa aquí si no redirecciona tu navegador.';

?>
