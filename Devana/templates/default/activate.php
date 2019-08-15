<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <?php echo '<link rel="stylesheet" type="text/css" href="templates/'.$_SESSION[$shortTitle.'User']['template'].'/default.css">'; ?>
  <title><?php echo $title.$ui['separator'].$ui['activate']; ?></title>
  <?php echo $tracker; ?>
 </head>
 <body class="body">
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/header.php'; ?>
 <div class="container">
  <div class="content">
   <form method="get" action="">
    <div><div class="cell"><?php echo $ui['username']; ?></div><div class="cell"><input class="textbox" type="text" name="user"></div></div>
    <div><div class="cell"><?php echo $ui['securityCode']; ?></div><div class="cell"><input class="textbox" type="password" name="code"></div></div>
    <div><div class="cell"><input class="button" type="submit" value="<?php echo $ui['activate']; ?>"></div></div>
   </form>
  </div>
 </div>
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/footer.php'; ?>
 </body>
</html>