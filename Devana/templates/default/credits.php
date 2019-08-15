<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <?php echo '<link rel="stylesheet" type="text/css" href="templates/'.$_SESSION[$shortTitle.'User']['template'].'/default.css">'; ?>
  <title><?php echo $title.$ui['separator'].$ui['credits']; ?></title>
  <?php echo $tracker; ?>
 </head>
 <body class="body">
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/header.php'; ?>
 <div class="container">
  <div class="content" style="text-align: left;">
Devana created by Andrei Busuioc - http://devana.eu<br><br>

This project uses images from the following sources:<br>
- resource, technology and building images courtesy of the open source game "0AD" - http://play0ad.com/<br>
- component and unit images courtesy of the open source game "The Battle for Wesnoth" - http://www.wesnoth.org/<br>
- map images courtesy of http://www.pixeltemple.com/portfolio/isometric-icons/<br><br>

This project uses the "PHPMailer" class from http://phpmailer.sourceforge.net
  </div>
 </div>
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/footer.php'; ?>
 </body>
</html>