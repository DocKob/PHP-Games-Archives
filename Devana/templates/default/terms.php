<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <?php echo '<link rel="stylesheet" type="text/css" href="templates/'.$_SESSION[$shortTitle.'User']['template'].'/default.css">'; ?>
  <title><?php echo $title.$ui['separator'].$ui['terms']; ?></title>
  <?php echo $tracker; ?>
 </head>
 <body class="body">
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/header.php'; ?>
 <div class="container">
  <div class="content" style="text-align: left;">
 Copyright (C) 2008-2013 Andrei Busuioc<br><br>

  This software is provided 'as-is', without any express or implied<br>
  warranty.  In no event will the authors be held liable for any damages<br>
  arising from the use of this software.<br><br>

  Permission is granted to anyone to use this software for any purpose,<br>
  including commercial applications, and to alter it and redistribute it<br>
  freely, subject to the following restrictions:<br><br>

  1. The origin of this software must not be misrepresented; you must not<br>
     claim that you wrote the original software. If you use this software<br>
     in a product an acknowledgment of the original author in the product documentation is required.<br>
  2. Altered source versions must be plainly marked as such, and must not be<br>
     misrepresented as being the original software.<br>
  3. This notice may not be removed or altered from any source distribution.<br><br>

  Andrei Busuioc<br>
  <img src="templates/default/images/terms.png"><br><br>
  
  This website does not send unsolicited emails.<br>
  All user data is private.
  </div>
 </div>
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/footer.php'; ?>
 </body>
</html>