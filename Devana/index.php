<?php
include 'core/config.php';
include 'core/core.php';
if (!isset($_SESSION[$shortTitle.'User']['id']))
 if (isset($_COOKIE[$shortTitle.'Name'], $_COOKIE[$shortTitle.'Password']))
  header('Location: login.php?action=login');
include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/index.php';
?>