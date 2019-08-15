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

//general
$LNG['index']				= 'Indice';
$LNG['register']			= 'Registro';
$LNG['forum']				= 'Descarga';
$LNG['send']				= 'Aceptar';
$LNG['menu_index']			= 'Inicio';
$LNG['menu_news']			= 'Noticias';
$LNG['menu_rules']			= 'Reglas';
$LNG['menu_agb']			= 'T&C'; 
$LNG['menu_pranger']		= 'Baneados';
$LNG['menu_top100']		    = 'Salón de la Fama';
$LNG['menu_disclamer']		= 'Contacto';
$LNG['uni_closed']			= '(offline)';
	 
/* ------------------------------------------------------------------------------------------ */

$LNG['music_off']			= 'Música: OFF';
$LNG['music_on']			= 'Música: ON';


//index.php
//case lostpassword
$LNG['mail_not_exist'] 		    = 'La dirección de correo electrónico no existe.';
$LNG['mail_title']				= 'Nueva contraseña';
$LNG['mail_text']				= 'Su nueva contraseña es: ';
$LNG['mail_sended']			    = 'Su contraseña ha sido enviada con exito.';
$LNG['mail_sended_fail']		= 'El e-mail no se pudo enviar.';
$LNG['server_infos']			= array(
	"Un juego de estrategia espacial en tiempo real.",
	"Juega junto con cientos de jugadores.",
	"Nada de descarga, sólo se requiere un navegador estándar.",
	"Registro Gratuito",
);

//case default
$LNG['login_error_1']			= 'Usuario/Contraseña Incorrecto!';
$LNG['login_error_2']			= 'Alguien se ha logueado desde otro ordenador con esta cuenta!';
$LNG['login_error_3']			= 'La sesión ha expirado.';
$LNG['screenshots']			= 'Imagenes';
$LNG['universe']				= 'Universo';
$LNG['chose_a_uni']			= 'Elige Universo';



/* ------------------------------------------------------------------------------------------ */

//lostpassword.tpl
$LNG['lost_pass_title']		    = 'Recuperar Contraseña';
$LNG['retrieve_pass']			= 'Restaurar';
$LNG['email']					= 'Dirección de E-mail';

//index_body.tpl
$LNG['user']					= 'Usuario';
$LNG['pass']					= 'Contraseña';
$LNG['remember_pass']			= 'Auto-Login';
$LNG['lostpassword']			= 'Recordar Contraseña';
$LNG['welcome_to']				= 'Bienvenido a';
$LNG['server_description']		= '<strong>%s</strong> es un juego de estrategia en el espacio. Compite con jugadores las 24h para conquistar el universo. Todo lo que necesitas es un navegador estandard.';
$LNG['server_register']		    = 'Registrate Ahora';
$LNG['server_message']			= 'Regístrate ahora y experimenta una nueva y emocionante aventura en el mundo de';
$LNG['login']					= 'Acceso';
$LNG['disclamer']				= 'Contacto';
$LNG['login_info']				= 'Acepto las <a href="index.php?page=rules&lang=es" target="_blank">Reglas</a> y los <a href="index.php?page=agb&lang=es" target="_blank">T&C</a>';

/* ------------------------------------------------------------------------------------------ */

//reg.php - Registrierung
$LNG['register_closed']			    = '¡Registro Cerrado!';
$LNG['register_at']				    = 'Registrado en ';
$LNG['reg_mail_message_pass']		= 'Un paso más para activar su nombre de usuario';
$LNG['reg_mail_reg_done']			= '¡Bienvenido a %s!';
$LNG['invalid_mail_adress']		    = 'E-Mail Incorrecto.<br>';
$LNG['empty_user_field']			= 'Por favor, rellene todos los campos.<br>';
$LNG['password_lenght_error']		= 'La contraseña debe tener al menos 4 caracteres.<br>';
$LNG['user_field_no_alphanumeric']	= 'Por favor introduce en el nombre de usuario sólo caracteres alfanuméricos.<br>';
$LNG['user_field_no_space']		    = 'Por favor, no introduzca el nombre de usuario en blanco.<br>';
$LNG['planet_field_no_alphanumeric']= 'Por favor, introduce solo caracteres alphanumericos en el nombre del planeta.<br>';
$LNG['planet_field_no_space']		= 'Por favor, no deje el nombre del planeta vacio.<br>';
$LNG['terms_and_conditions']		= 'Acepta las <a href="index.php?page=rules&lang=es" target="_blank">Reglas</a> y los <a href="index.php?page=agb&lang=es" target="_blank">T&C</a> por favor.<br>';
$LNG['user_already_exists']		    = 'El nombre de usuario ya está siendo usado.<br>';
$LNG['mail_already_exists']		    = 'La dirección de correo electrónico ya está en uso.<br>';
$LNG['wrong_captcha']				= 'Codigo de Seguridad incorrecto.<br>';
$LNG['different_passwords']		    = 'Ha introducido dos contraseñas diferentes.<br>';
$LNG['different_mails']			    = 'Ha introducido dos E-Mail diferentes.<br>';
$LNG['welcome_message_from']		= 'Administración';
$LNG['welcome_message_sender']		= 'Administración';
$LNG['welcome_message_subject']	    = 'Bienvenido';
$LNG['welcome_message_content']	    = 'Bienvenido a %s!<br>En primer lugar construye una Planta de energía solar, porque la energía es necesaria para la posterior producción de materias primas. Para construirla, haz click en Estructuras del panel izquierdo. Cuando tengas la energía, puedes comenzar a construir las minas. Vuelve al menú Estructuras y construye una mina de metal, y luego otra vez una mina de cristal. El equipo te desea mucha diversión y comienza a explorar el universo.';
$LNG['newpass_smtp_email_error']	= '<br><br>Se produjo un error. Tu contraseña es: ';
$LNG['reg_completed']				= 'Gracias por tu registro. Recibirás un correo electrónico con un enlace de activación.';
$LNG['planet_already_exists']		= 'La posición del planeta ya esta ocupada.<br>';

//registry_form.tpl
$LNG['server_message_reg']			= 'Regístrate ahora y forma parte de';
$LNG['register_at_reg']			    = 'Registrado en';
$LNG['uni_reg']					    = 'Universo';
$LNG['user_reg']					= 'Usuario';
$LNG['pass_reg']					= 'Contraseña';
$LNG['pass2_reg']					= 'Confirmar Contraseña';
$LNG['email_reg']					= 'Dirección E-mail';
$LNG['email2_reg']					= 'Confirmar Direccion E-mail';
$LNG['planet_reg']					= 'Nombre del planeta principal';
$LNG['lang_reg']					= 'Idioma';
$LNG['raza_reg']                                        = 'Raza';
$LNG['raza_0']                                  = 'Gultra';
$LNG['raza_1']                                   = 'Voltra';
$LNG['register_now']				= 'Registrate';
$LNG['captcha_reg']				    = 'Clave de Seguridad';
$LNG['accept_terms_and_conditions'] = 'Acepto las <a href="index.php?page=rules&lang=es" target="_blank">Reglas</a> y los <a href="index.php?page=agb&lang=es" target="_blank">T&C</a>';
$LNG['captcha_reload']				= 'Recarga';
$LNG['captcha_help']				= 'Ayuda';
$LNG['captcha_get_image']			= 'Carga Bild-CAPTCHA';
$LNG['captcha_reload']				= 'Nuevo CAPTCHA';
$LNG['captcha_get_audio']			= 'Carga Sonido-CAPTCHA';
$LNG['user_active']                 = 'Usuario %s se ha activado.';

//registry_closed.tpl
$LNG['info']						= 'Información';
$LNG['reg_closed']					= 'Registro Cerrado';

//Rules
$LNG['rules_overview']				= "Reglas";
$LNG['rules']						= array(
	"Cuentas"					=> "Cada jugador es libre para controlar una sola cuenta. Cada cuenta tiene derecho a ser desempeñado por un solo jugador a la vez, la única excepción es la cuenta de sitting.
El Sitting permite a un jugador en cuestión tener su cuenta vigilada bajo las siguientes regulaciones:

- Un administrador debe ser informado antes de que el Sitting se realice mediante la apertura de un ticket.
- No se permiten movimientos de flota mientras la cuenta esta en sitting a menos que se de el caso de un ataque, en cuyo caso usted puede salvar su flota mediante el despliegue o transporte a un planeta o una luna de propiedad de la cuenta.
- Una cuenta puede ser cuidada durante un período máximo de 48 horas continuas (permiso de administración sera obtenido en los casos que sea necesaria una ampliación del plazo).
El Cuidador puede, en la cuenta que de Sitting y, mientras dura el período de sesión:

- Gastar recursos en edificios o investigaciones.
- Hacer Fleetsave de una flota en peligro inminente por una flota de ataque de entrada, sólo con la misión de despliegue o transporte a uno de los planetas propios de la cuenta.
- Colocar una cuenta en el modo de vacaciones.

El sitter no puede:

- Transportar recursos, ni entre los planetas / lunas de la cuenta que cuida, ni a cualquier otro planeta / luna.
- Gastar recursos en las estructuras de defensa o naves.
- Cuidar una cuenta si ya ha cuidado otra durante los últimos 7 días.
- Cuidar una cuenta que ya cuido en los últimos 7 días.
- Quitar una cuenta del modo de vacaciones.",


	"Pushing"					=> "No está permitido a ninguna cuenta obtener provecho injusto a cabo de una cuenta de menor puntuación en cuestión de recursos.
Esto incluye pero no esta limitado a:

- Recursos enviados desde una cuenta de menor puntuación a una de mayor puntuación sin obtener nada tangible a cambio.
- Un jugador destruya su flota en una de mayor puntuación para que la de mayor puntuación pueda mantener el campo de escombros, y así sacar provecho de ella.
- Los préstamos que no se devuelven en 48 horas.
- Operaciones en las que el jugador de mayor puntuación no devuelve los recursos dentro de las 48 horas.
- Jugadores de que responden a una extorsión de un jugador de mayor puntuación mediante el pago de los recursos.
- Intercambios que significan un beneficio injusto para el jugador de mayor puntuación por la salida fuera de la siguiente gama de relaciones:

03:02:01 Donde cada unidad de deuterio vale 2 unidades de cristal o 3 unidades de metal.

02:01:01 Donde cada unidad de deuterio es un valor de 1 unidad de cristal o 2 unidades de metal.
",

	"Bashing"					=> "No está permitido atacar a cualquier planeta o luna de propiedad de un jugador más de 6 veces en un solo período de 24 horas.

Bashing sólo está permitido cuando la Alianza está en guerra con otra Alianza. La guerra debe ser anunciado en el foro y los líderes deben estar de acuerdo con los términos.",

	
	"Bugusing"					=> "El uso de un bug con fines de lucro intencionado, o no reportar un bug intencionadamente está estrictamente prohibido.",


	"Amenazas en la vida real"	=> "Está prohibido insinuar que se va a localizar y causar daño a un jugador, a un miembro del equipo, a un empleado de Planet Moons o a cualquier persona.",

	"Spam"			=> "Cualquier intento de saturar la interfaz del jugador usando cualquier método está prohibido. Esto incluye pero no limita a:

- Mensajes personales de spam
- Pruebas de spam
- Spam en General",

  "Guerras"                    => "Después de que los líderes de las alianzas esten de acuerdo con la guerra, esta oficialmente empezada. Y continuará hasta que una de las alianzas la cancele. Para cancelar oficialmente la guerra necesitan cancelar el pacto de guerra desde dentro del juego, y anunciarlo en el hilo que empezó inicialmente.
Mientras que la guerra este en marcha, las reglas de bashing no cuentan entre los ataques de estas alianzas. Significa que los miembros pertenecientes a las alianzas en dicha guerra se pueden atacar una cantidad infinita de veces con el castigo que eso conlleve.
Si bien una de las alianza se da por vencida y cancela la guerra, la norma entrará de Bashing en vigor de nuevo, y los miembros que rompan esta regla despues de que la guerra haya terminado seran castigados con un ban de un día. Se castigara más si el grado de ataque es muy alto.

Si alguna de las alianzas cuenta con una flota en vuelo. Y la guerra se cancela antes de que lleguen. Ellos no serán castigados por ese ataque. Pero cualquier flota enviada después de la cancelación de la guerra se cuenta para el Bashing.


Por una Nueva Guerra los líderes necesitan de crear un nuevo tema en el foro de guerra/diplomacia.
Se puede establecer una normativa específica o términos que los lideres quieran para una guerra. Cualquier norma establecida, y que se acuerde con la alianza contratia debe estar en acuerdo, y no deben contravenir las normas establecidas aquí.",

);

$LNG['rules_info1']				= "Sin embargo, se recoge en este <a href=\"%s\" target=\"_blank\"> Foro </ a> y sobre la página inicial del juego la información al respecto ...";
$LNG['rules_info2']				= "Para complementar esto, los <a onclick=\"ajax('?page=agb&getajax=1');\" style=\"cursor:pointer;\">T&C</a> tienen que ser respetados!</font>";


//AGB

$LNG['agb_overview']				= "Terminos y Condiciones";
$LNG['agb']						= array(
	"Servicio de contenidos"				=> array( 
		"El reconocimiento de las políticas son un requisito previo necesario para poder participar en el juego.
Se aplican a todas las ofertas por parte de los operadores, incluido el Foro y otros contenidos del juego. ",

                "El servicio es gratuito.
Por lo tanto no existen reclamaciones a la disponibilidad, la entrega, la funcionalidad, o daños y perjuicios.
Ademas, el jugador no debe tener pretensiones de restaurar una cuenta tratada negativamente.",
	),

	"Afiliacion"				=> array(
		"Al iniciar la sesion en el juego y / o los miembros del Foro se iniciara en el juego.",

                "Lo que comienza con la declaracion de miembros podra ser rescindido por parte del miembro, borrando su cuenta o por escrito de un administrador.
La supresión de los datos por razones técnicas no se pueden hacer de inmediato.",

                "Terminado por el operador ningun usuario tiene derecho a participar en las operaciones del operador.
El operador se reserva el derecho de borrar cuentas.
La decision de eliminar una cuenta es unica y exclusivamente del operador y del administrador.
Cualquier reclamacion legal de una calidad de miembro esta excluida.",

                "Todos los derechos permanecen con el operador.",
        ),

	"Contenidos / Responsabilidad"	=> "Para el contenido de las diversas capacidades de comunicaciones de juego, los usuarios son responsables. Pornografia, racismo, abusos o cualquier otra cosa que infrinja la ley en contra de contenidos ajenos a la responsabilidad del operador.
Violaciónes pueden derivar en la anulación o revocación inmediata.",

	"Prohibido procedimientos"			=> array(
		"El usuario no está autorizado a usar el hardware / software u otras sustancias o mecanismos asociados con el sitio web, que pueden interferir con la función y el juego.
El usuario no podrá seguir aceptando cualquier acción que pueda causar la tensión indebida o el aumento de la capacidad técnica.
El usuario no se le permite manipular el contenido generado por el operador o interferir en modo alguno con el juego",
		
		"Cualquier tipo de bot, script o funciones automatizadas están prohibidas.
El juego se puede jugar sólo en el navegador. Incluso sus funciones no se debe utilizar para obtener una ventaja en el juego.
Por lo tanto, ningún tipo de publicidad se bloqueará. La decisión de cuando un programa es beneficioso para los jugadores, es competencia exclusiva con el operador / con los administradores u operadores.",
		
	
	),

	"Restricciones de uso"		=> array(
		"Un jugador sólo puede usar uno por cada cuenta de universo, los llamados \ multinacionales \ no están permitidas y serán borrados sin previo aviso puede ser o será bloqueado.
La decisión de cuando hay un \ varios \ corresponde exclusivamente a los operadores y administradores u operadores. ",
		
		"Datos se regirá por las reglas.",
		
		"Los bloqueos pueden permanente a discreción del operador o temporalmente.
Del mismo modo, los cierres pueden extenderse a una o todas las áreas de juego.
La decisión se suspende cuando y cuánto tiempo un jugador que es sólo con el operador / con los administradores u operadores.",
	),

	"Privacidad"					=> array(
		"El operador se reserva el derecho de almacenar datos de los jugadores con el fin de vigilar el cumplimiento de las normas, condiciones de uso y la legislación aplicable.
Guardado todos los obligatorios y presentado por el jugador o su información de cuenta.
Estos (IPs se asocian con periodos de utilización y uso, la dirección de correo electrónico dada durante el registro y otros datos.
En el foro, lo que se almacene en el perfil. ",
		
		"Estos datos se dará a conocer en determinadas circunstancias para llevar a cabo las obligaciones legales de los empleados y otras personas autorizadas.
Por otra parte, los datos pueden (si es necesario emitidos) en determinadas circunstancias a terceros. ",
		
		"El usuario puede objetar el almacenamiento de datos personales en cualquier momento. Una apelación es un derecho de rescisión.",
	),

	"Derechos del titular de las cuentas"	=> array(
		"Todas las cuentas y todos los objetos virtuales siguen siendo en la posesión y propiedad de la operadora.
El jugador no obtiene la propiedad y otros derechos a cualquier cuenta o partes.
Todos los derechos permanecen con el operador.
Una transferencia de la explotación u otros derechos para el usuario se llevará a cabo en cualquier momento. ",
		
		"La venta no autorizada, usar, copiar, distribuir, reproducir o violar los derechos (por ejemplo, a cuenta) de que el operador será reportado a las autoridades y perseguidos.
Expresamente se permite la libre transferencia, permanente de la cuenta y las acciones de sus recursos propios en el universo, a menos que ya excepción de lo permitido por las reglas ",
            ),

	"Responsabilidad"	=> "El titular de cada universo no se responsabiliza de los daños y perjuicios.
Un pasivo es negarse, salvo por los daños causados por dolo o negligencia grave y todos los daños a la vida y la salud.
En este sentido, se señaló expresamente que los videojuegos pueden representar un riesgo significativo para la salud.
Los daños no son en el sentido del operador. ",

	"Cambios en los Términos"	=> "El operador se reserva el derecho de modificar estos términos en cualquier momento o extender.
Un cambio o adición se publicarán al menos una semana antes de la entrada en el Foro.",
);

//Facebook Connect

$LNG['fb_perm']                = "Acceso prohibido. %s necesitas todos los derechos para que puedas ingresar con tu cuenta de Facebook. ¡También se puede acceder sin una cuenta de Facebook! ";

//NEWS

$LNG['news_overview']			= "Noticias";
$LNG['news_from']				= "Abierto %s por %s";
$LNG['news_does_not_exist']	    = "No hay noticias!";

//Impressum

$LNG['disclamer']				= "Denuncia";
$LNG['disclamer_name']			= "Nombre";
$LNG['disclamer_adress']		= "Dirección";
$LNG['disclamer_tel']			= "Teléfono:";
$LNG['disclamer_email']		    = "Dirección E-mail";

// Traducido por ZideN // Modified by Morktadela

?>
