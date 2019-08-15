<?php session_start();
//config
$dbHost='127.0.0.1';
$dbUser='root';
$dbPass='';
$dbName='devana';
$title='devana';
$shortTitle='devana';
$location='http://127.0.0.1/devana/';
//misc vars
$benchmark=true;
$tracker='';
$ads='<div class="ad">ads</div>';
if (!isset($_SESSION[$shortTitle.'User']['id']))
{
 $_SESSION[$shortTitle.'User']['template']='default';
 $_SESSION[$shortTitle.'User']['locale']='en';
}
else if ($_SESSION[$shortTitle.'User']['level']>2) $tracker=$ads='';
include 'locales/'.$_SESSION[$shortTitle.'User']['locale'].'/ui.php';
ob_start();
?>
