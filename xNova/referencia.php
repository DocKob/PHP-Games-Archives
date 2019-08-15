<?php

# Primero se define la constante de root
define('ROOT_PATH', str_replace('\\', '/',dirname(__FILE__)).'/');
# Llamamos el archivo madre
include(ROOT_PATH . 'includes/common.php'); 

# Saqueamos la variable $CONF para ver sus contenidos
# Generada en common.php: $CONF = $db->uniquequery("SELECT HIGH_PRIORITY * FROM `".CONFIG."` WHERE `uni` = '".$UNI."';");
echo "Tenga en cuenta que el contenido se mostrara de acuerdo al usuario actual en sesi&oacute;n, pero es valido.<br /><hr />";
echo "<h3>Array \$CONF[]. </h3>";
foreach($CONF as $key => $conf) {
	echo "<b>Name:</b>	" .$key ." <b>Value:</b> " .$conf ."<br />";
}
echo "<hr />";

# Saqueamos la variable $USER para ver sus contenidos
# Generada en common.php: $USER	= $db->uniquequery("SELECT u.*, s.`total_points`, s.`total_rank` FROM ".USERS." as u LEFT JOIN ".STATPOINTS." as s ON s.`id_owner` = u.`id` AND s.`stat_type` = '1' WHERE u.`id` = '".$_SESSION['id']."';");
echo "<h3>Array \$USER[]. </h3>";
foreach($USER as $key => $conf) {
	echo "<b>Name:</b>	" .$key ." <b>Value:</b> " .$conf ."<br />";
}
echo "<hr />";

# Saqueamos la variable $PLANET para ver sus contenidos
# Es generada en common.php lo siguiente: $PLANET = $db->uniquequery("SELECT * FROM `".PLANETS."` WHERE `id` = '".$_SESSION['planet']."';");
echo "<h3>Array \$PLANET[]. </h3>";
foreach($PLANET as $key => $conf) {
	echo "<b>Name:</b>	" .$key ." <b>Value:</b> " .$conf ."<br />";
}
echo "<hr />";

# El elemento $db es un objeto y su valor proviene de includes/classes/class.MySQLi.php en donde se define la clase, se declara en common.php de la siguiente manera: $db 	= new DB_MySQLi();
?>