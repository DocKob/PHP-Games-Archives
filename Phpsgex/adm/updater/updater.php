<?php	
function updateDB() {
	if( (int)DataBaseVersion() >= DBVER ) return;
	global $DB;
	
	switch( (int)DataBaseVersion() ){
        case 108:
            $DB->query("UPDATE `conf` SET `server_name` = '".SERVER_NAME."', `server_desc_sub` = '".SUB_DESC."', `server_desc_main` = '".MAIN_DESC."', `template` = '".TEMPLATE."', `css` = '".CSS."', `MG_max_cap` = ".MG_max_cap." WHERE 1 LIMIT 1;");
        break;

        case 118:
			if( CITY_SYS == 1 ){
				$DB->multi_query("create table city_new as SELECT city.*, x, y from city join `map` on ( city.id = `map`.city ); 
					DROP TABLE city;
					DROP TABLE `map`;
					RENAME TABLE `city_new` TO `city`;
					ALTER TABLE `city` ADD `type` VARCHAR( 15 ) NOT NULL DEFAULT 'null.gif';
					update city set `type` = 'v1' where 1;
				") or die("Update error: ".$DB->error);
			}
		break;	
		
		case 119:
			require_once( "adm/dbcheck.php" );
			$body="";
			foreach( $tb as $t ){
				$DB->query("ALTER TABLE `$t` ENGINE = INNODB;");	
			}
		break;
	}

    $update= "./adm/updater/".DataBaseVersion().".sql";
    if( !file_exists($update) ) die("Sql update \"$update\" doesn't exist!");
	$qr= file_get_contents($update);
	$qr= preg_replace( "'%PREFIX%'", TB_PREFIX, $qr );
	$DB->multi_query($qr) or die("Update error: ".$DB->error);
}
	
?>