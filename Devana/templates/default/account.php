<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <script type="text/javascript" src="core/core.js"></script>
  <?php echo '<link rel="stylesheet" type="text/css" href="templates/'.$_SESSION[$shortTitle.'User']['template'].'/default.css">'; ?>
  <title><?php echo $title.$ui['separator'].$ui['account']; ?></title>
  <?php echo $tracker; ?>
 </head>
 <body class="body">
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/header.php'; ?>
 <div class="container">
  <div class="content">
<?php echo '
   <div style="display: inline-block;">
    <div>
     <div class="cell">'.$ui['edit'].'</div>
     <div class="cell">
      <select class="dropdown" id="action" onChange="selectAction()">
       <option value="misc">'.$ui['misc'].'</option>
       <option value="preferences">'.$ui['preferences'].'</option>
       <option value="blocklist">'.$ui['blocklist'].'</option>
       <option value="password">'.$ui['password'].'</option>
       <option value="remove">'.$ui['remove'].'</option>
      </select>
     </div>
    </div>
   </div>
   <div id="misc">
    <form method="post" action="?action=misc">
     <div><div class="cell">'.$ui['email'].'</div><div class="cell"><input class="textbox" type="text" name="email" maxlength="32" value="'.$_SESSION[$shortTitle.'User']['email'].'"></div></div>
     <div><div class="cell">'.$ui['sitter'].'</div><div class="cell"><input class="textbox" type="text" name="sitter" maxlength="32" value="'.$_SESSION[$shortTitle.'User']['sitter'].'"></div></div>
     <div><div class="cell">'.$ui['locale'].'</div><div class="cell"><select class="dropdown" type="text" name="locale">'.$locales.'</select></div></div>
     <div><div class="cell">'.$ui['template'].'</div><div class="cell"><select class="dropdown" type="text" name="template">'.$templates.'</select></div></div>
     <div><div class="cell">'.$ui['password'].'</div><div class="cell"><input class="textbox" type="password" name="password"></div></div>
     <div><div class="cell"><input class="button" type="submit" value="'.$ui['edit'].'"></div></div>
    </form>
   </div>
   <div id="preferences">
    <form method="post" action="?action=preferences">
     <div><div class="cell">'.$ui['name'].'</div><div class="cell"><select class="dropdown" name="name" id="preferenceName" onChange="changePreference()">'.$preferenceNames.'</select></div></div>
     <div><div class="cell">'.$ui['value'].'</div><div class="cell"><input class="textbox" type="text" name="value" id="preferenceValue" maxlength="64" value="'.$user->preferences[0]['value'].'"></div></div>
     <div><div class="cell">'.$ui['password'].'</div><div class="cell"><input class="textbox" type="password" name="password"></div></div>
     <div><div class="cell"><input class="button" type="submit" value="'.$ui['edit'].'"></div></div>
    </form>
   </div>
   <div id="blocklist">
    <div style="max-width: 230px;"><div class="cell">'.$ui['list'].': </div><div class="cell">'.$blocklistNames.'</div></div>
    <form method="post" action="?action=blocklist">
     <div><div class="cell">'.$ui['username'].'</div><div class="cell"><input class="textbox" type="text" name="name"></div></div>
     <div><div class="cell">'.$ui['password'].'</div><div class="cell"><input class="textbox" type="password" name="password"></div></div>
     <div><div class="cell"><input class="button" type="submit" value="'.$ui['go'].'"></div></div>
    </form>
   </div>
   <div id="password">
    <form method="post" action="?action=password">
     <div><div class="cell">'.$ui['oldPassword'].'</div><div class="cell"><input class="textbox" type="password" name="password"></div></div>
     <div><div class="cell">'.$ui['newPassword'].'</div><div class="cell"><input class="textbox" type="password" name="newPassword" id="newPassword" onChange=\"check("newPassword")\"></div></div>
     <div><div class="cell">'.$ui['retypePassword'].'</div><div class="cell"><input class="textbox" type="password" name="rePassword"></div></div>
     <div><div class="cell"><input class="button" type="submit" value="'.$ui['edit'].'"></div></div>
    </form>
   </div>
   <div id="remove">
    <form method="post" action="?action=remove">
     <div><div class="cell">'.$ui['password'].'</div><div class="cell"><input class="textbox" type="password" name="password"></div></div>
     <div><div class="cell"><input class="button" type="submit" value="'.$ui['edit'].'"></div></div>
    </form>
   </div>';
?>
  </div>
 </div>
<script type="text/javascript">
 <?php echo 'var preferenceValues=new Array('.implode(', ', $preferenceValues).');'; ?>
 var misc=document.getElementById("misc"), preferences=document.getElementById("preferences"), blocklist=document.getElementById("blocklist"), password=document.getElementById("password"), remove=document.getElementById("remove");
 function changePreference()
 {
  document.getElementById('preferenceValue').value=preferenceValues[document.getElementById('preferenceName').selectedIndex];
 }
 function selectAction()
 {
  var action=document.getElementById("action").value;
  switch (action)
  {
   case "misc": misc.style.display="block"; preferences.style.display="none"; blocklist.style.display="none"; password.style.display="none"; remove.style.display="none"; break;
   case "preferences": misc.style.display="none"; preferences.style.display="block"; blocklist.style.display="none"; password.style.display="none"; remove.style.display="none"; break;
   case "blocklist": misc.style.display="none"; preferences.style.display="none"; blocklist.style.display="block"; password.style.display="none"; remove.style.display="none"; break;
   case "password": misc.style.display="none"; preferences.style.display="none"; blocklist.style.display="none"; password.style.display="block"; remove.style.display="none"; break;
   case "remove": misc.style.display="none"; preferences.style.display="none"; blocklist.style.display="none"; password.style.display="none"; remove.style.display="block"; break;
   default: misc.style.display="none"; preferences.style.display="none"; blocklist.style.display="none"; blocklist.style.display="none"; password.style.display="none"; remove.style.display="none";
  }
 }
 function check(obj)
 {
  var str=document.getElementById(obj).value, regex=/^[0-9A-Za-z]+$/;
  if (!regex.test(str)) alert("<?php echo $ui['onlyAlphaNum']; ?>");
 }
<?php
 if (isset($_GET['action'])) echo 'document.getElementById("action").selectedIndex=indexOfSelectValue(document.getElementById("action"), "'.$_GET['action'].'");';
?>
 selectAction();
</script>
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/footer.php'; ?>
 </body>
</html>