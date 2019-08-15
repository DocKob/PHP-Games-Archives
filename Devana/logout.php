<?php
include 'core/config.php';
include 'core/core.php';
session_start();
$_SESSION=array();
session_destroy();
if (isset($_COOKIE[$shortTitle.'Name'], $_COOKIE[$shortTitle.'Password']))
{
 setcookie($shortTitle.'Name', '', (time()-1));
 setcookie($shortTitle.'Password', '', (time()-1));
}
header('Location: index.php');
?>
