<?php

/*

Creation de l'image de verification

*/

@session_start();

$alphanum = "abcdefghijklmnopqrstuvwxyz123456789";

$rand = substr(str_shuffle($alphanum), 0, 5);

$_SESSION['image_random_value'] = md5($rand);

$bgnum = rand(1, 3);

if ($bgnum == 1) { $bg = 'images/bg1.png'; }
if ($bgnum == 2) { $bg = 'images/bg2.png'; }
if ($bgnum == 3) { $bg = 'images/bg3.png'; }
$image = imagecreatefrompng("$bg");
$textColor = imagecolorallocate ($image, 0, 0, 0);
imagestring ($image, 5, 5, 8, $rand, $textColor); 

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-type: image/png');

imagejpeg($image);

imagedestroy($image);
?>