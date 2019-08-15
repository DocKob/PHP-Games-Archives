<?php
session_start();
$image=imagecreate(42, 20);
$backgroundColor=imagecolorallocate($image, 0, 0, 0);
$textColor=imagecolorallocate($image, 255, 255, 255);
imagettftext($image, 10, 0, 5, 15, $textColor, 'templates/default/arial.ttf', $_SESSION['regCode']);
header('Content-type: image/gif');
imagegif($image);
imagedestroy($image);
?>
