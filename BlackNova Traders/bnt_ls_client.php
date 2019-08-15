<?
if (preg_match("/bnt_ls_client.php/i", $PHP_SELF)) {
	echo "You can not access this file directly!";
	die();
}

include_once("config.php");
$url = "http://www.rednova.de/bnt_ls_server2z.php";

$url .= "?url1=" . urlencode($bnt_ls_gameurl);
$url .= "&key1=" . urlencode($bnt_ls_key);

$url .= "&end1=true";

@file($url);

?>