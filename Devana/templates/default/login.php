<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <?php echo '<link rel="stylesheet" type="text/css" href="templates/'.$_SESSION[$shortTitle.'User']['template'].'/default.css">'; ?>
  <title><?php echo $title.$ui['separator'].$ui['login']; ?></title>
  <?php echo $tracker; ?>
 </head>
 <body class="body">
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/header.php'; ?>
 <div class="container">
  <div class="content">
   <select class="dropdown" onChange="changeAction(this.value)">
    <option value="login"><?php echo $ui['login']; ?></option>
    <option value="sit"><?php echo $ui['sit']; ?></option>
   </select>
   <form method="post" action="?action=login" id="login">
    <div><div class="cell"><?php echo $ui['username']; ?></div><div class="cell"><input class="textbox" type="text" name="name"></div></div>
    <div><div class="cell"><?php echo $ui['password']; ?></div><div class="cell"><input class="textbox" type="password" name="password"></div></div>
    <div><div class="cell"><?php echo $ui['rememberMe']; ?></div><div class="cell"><input type="checkbox" name="remember" value="1"></div></div>
    <div><a class="link" href="reset.php"><?php echo $ui['resetPassword']; ?></a><div class="cell"><input class="button" type="submit" value="<?php echo $ui['login']; ?>"></div></div>
   </form>
   <form method="post" action="?action=sit" id="sit" style="display: none;">
    <div><div class="cell"><?php echo $ui['username']; ?></div><div class="cell"><input class="textbox" type="text" name="user"></div></div>
    <div><div class="cell"><?php echo $ui['sitter']; ?></div><div class="cell"><input class="textbox" type="text" name="sitter"></div></div>
    <div><div class="cell"><?php echo $ui['password']; ?></div><div class="cell"><input class="textbox" type="password" name="password"></div></div>
    <div><div class="cell"><input class="button" type="submit" value="<?php echo $ui['login']; ?>"></div></div>
   </form>
  </div>
 </div>
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/footer.php'; ?>
<script type="text/javascript">
 function changeAction(type)
 {
  var login=document.getElementById("login"), sit=document.getElementById("sit");
  switch (type)
  {
   case "login":
    login.style.display="block";
    sit.style.display="none";
   break;
   case "sit":
    login.style.display="none";
    sit.style.display="block";
   break;
  }
 }
</script>
 </body>
</html>