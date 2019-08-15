<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <?php echo '<link rel="stylesheet" type="text/css" href="templates/'.$_SESSION[$shortTitle.'User']['template'].'/default.css">'; ?>
  <title><?php echo $title.$ui['separator'].$ui['register']; ?></title>
  <?php echo $tracker; ?>
 </head>
 <body class="body">
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/header.php'; ?>
 <div class="container">
  <div class="content">
   <form method="post" action="">
    <div><div class="cell"><?php echo $ui['email']; ?></div><div class="cell"><input class="textbox" type="text" name="email"></div></div>
    <div><div class="cell"><?php echo $ui['username']; ?></div><div class="cell"><input class="textbox" type="text" name="name" id="name" maxlength="32" onChange="check('name')"></div></div>
    <div><div class="cell"><?php echo $ui['password']; ?></div><div class="cell"><input class="textbox" type="password" name="password"></div></div>
    <div><div class="cell"><?php echo $ui['retypePassword']; ?></div><div class="cell"><input class="textbox" type="password" name="rePassword"></div></div>
    <div><div class="cell"><?php echo $ui['securityCode']; ?></div><div class="cell"><div class="cell"><img style="margin-bottom: -5px;" src="captcha.php"></div><div class="cell"><input class="textbox" type="text" size="4" name="regCode"></div></div></div>
    <div><div class="cell"><input class="button" type="submit" value="<?php echo $ui['register']; ?>"></div></div>
   </form>
  </div>
 </div>
<script type="text/javascript">
 function check(obj)
 {
  var str=document.getElementById(obj).value, regex=/^[0-9A-Za-z]+$/;
  if (!regex.test(str)) alert("<?php echo $ui['onlyAlphaNum']; ?>");
 }
</script>
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/footer.php'; ?>
 </body>
</html>