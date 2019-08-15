<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <script type="text/javascript" src="core/core.js"></script>
  <?php echo '<link rel="stylesheet" type="text/css" href="templates/'.$_SESSION[$shortTitle.'User']['template'].'/default.css">'; ?>
  <title><?php echo $title.$ui['separator'].$ui['adminPanel']; ?></title>
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
       <option value="vars">'.$ui['vars'].'</option>
       <option value="bans">'.$ui['bans'].'</option>
       <option value="accounts">'.$ui['accounts'].'</option>
       <option value="username">'.$ui['username'].'</option>
       <option value="blacklist">'.$ui['blacklist'].'</option>
      </select>
     </div>
    </div>
   </div>
   <div id="vars">
    <form method="post" action="?action=vars">
     <div><div class="cell">'.$ui['name'].'</div><div class="cell"><select class="dropdown" name="name" id="varName" onChange="selectFlag()">'.$flagNames.'</select></div></div>
     <div><div class="cell">'.$ui['value'].'</div><div class="cell"><input class="textbox" type="text" name="value" id="varValue" maxlength="64" value="'.$flags[0]['value'].'"></div></div>
     <div><div class="cell">'.$ui['password'].'</div><div class="cell"><input class="textbox" type="password" name="password"></div></div>
     <div><div class="cell"><input class="button" type="submit" value="'.$ui['edit'].'"></div></div>
    </form>
   </div>
   <div id="bans">
    <form method="post" action="?action=bans">
     <div><div class="cell">'.$ui['name'].'</div><div class="cell"><input type="text" class="textbox" name="name"></div></div>
     <div><div class="cell">'.$ui['level'].'</div><div class="cell"><input class="textbox numeric" type="text" name="level" maxlength="2" size="1"></div></div>
     <div><div class="cell">'.$ui['password'].'</div><div class="cell"><input class="textbox" type="password" name="password"></div></div>
     <div><div class="cell"><input class="button" type="submit" value="'.$ui['edit'].'"></div></div>
    </form>
   </div>
   <div id="accounts">
    <form method="post" action="?action=accounts">
     <div><div class="cell">'.$ui['maxIdleTime'].'</div><div class="cell"><input class="textbox numeric" type="text" name="maxIdleTime" size="1"></div></div>
     <div><div class="cell">'.$ui['password'].'</div><div class="cell"><input class="textbox" type="password" name="password"></div></div>
     <div><div class="cell"><input class="button" type="submit" value="'.$ui['remove'].'"></div></div>
    </form>
   </div>
   <div id="username">
    <form method="post" action="?action=username">
     <div><div class="cell">'.$ui['username'].'</div><div class="cell"><input class="textbox" type="text" name="name"></div></div>
     <div><div class="cell">'.$ui['password'].'</div><div class="cell"><input class="textbox" type="password" name="password"></div></div>
     <div><div class="cell"><input class="button" type="submit" value="'.$ui['get'].'"></div></div>
    </form>
   </div>
   <div id="blacklist">
    '.$ui['action'].' <select class="dropdown" id="blacklistAction" onChange="selectBlacklistAction()"><option value="add">'.$ui['add'].'</option><option value="remove">'.$ui['remove'].'</option></select>
    <form method="post" action="?action=blacklist&blacklistAction=add" id="blacklistAdd">
     <div><div class="cell">'.$ui['type'].'</div><div class="cell"><select class="dropdown" name="type" id="blacklist_add_type"><option value="ip">'.$ui['ip'].'</option><option value="email">'.$ui['email'].'</option></select></div></div>
     <div><div class="cell">'.$ui['value'].'</div><div class="cell"><input class="textbox" type="text" name="value"></div></div>
     <div><div class="cell">'.$ui['password'].'</div><div class="cell"><input class="textbox" type="password" name="password"></div></div>
     <div><div class="cell"><input class="button" type="submit" value="'.$ui['add'].'"></div></div>
    </form>
    <form method="post" action="?action=blacklist&blacklistAction=remove" id="blacklistRemove">
     <div><div class="cell">'.$ui['type'].'</div><div class="cell"><select class="dropdown" name="type" id="blacklist_remove_type" onChange="selectBlacklistRemoveType()"><option value="ip">'.$ui['ip'].'</option><option value="email">'.$ui['email'].'</option></select></div></div>
     <div><div class="cell">'.$ui['list'].'</div><div class="cell"><select class="dropdown" name="value[]" id="ipList" multiple="true" style="height: 200px;">'.$blacklist['ip'].'</select><select class="dropdown" name="value[]" id="emailList" multiple="true" style="height: 200px;">'.$blacklist['email'].'</select></div></div>
     <div><div class="cell">'.$ui['password'].'</div><div class="cell"><input class="textbox" type="password" name="password"></div></div>
     <div><div class="cell"><input class="button" type="submit" value="'.$ui['remove'].'"></div></div>
    </form>
   </div>';
?>
  </div>
 </div>
<script type="text/javascript">
 <?php echo 'var flagValues=new Array('.implode(', ', $flagValues).');'; ?>
 var vars=document.getElementById("vars"), bans=document.getElementById("bans"), accounts=document.getElementById("accounts"), username=document.getElementById("username"), blacklist=document.getElementById("blacklist");
 var blacklistAdd=document.getElementById("blacklistAdd"), blacklistRemove=document.getElementById("blacklistRemove"), ipList=document.getElementById("ipList"), emailList=document.getElementById("emailList");
 function selectFlag()
 {
  document.getElementById('varValue').value=flagValues[document.getElementById('varName').selectedIndex];
 }
 function selectAction()
 {
  var action=document.getElementById("action").value
  switch (action)
  {
   case "vars": vars.style.display="block"; bans.style.display="none"; accounts.style.display="none"; username.style.display="none"; blacklist.style.display="none"; break;
   case "bans": vars.style.display="none"; bans.style.display="block"; accounts.style.display="none"; username.style.display="none"; blacklist.style.display="none"; break;
   case "accounts": vars.style.display="none"; bans.style.display="none"; accounts.style.display="block"; username.style.display="none"; blacklist.style.display="none"; break;
   case "username": vars.style.display="none"; bans.style.display="none"; accounts.style.display="none"; username.style.display="block"; blacklist.style.display="none"; break;
   case "blacklist": vars.style.display="none"; bans.style.display="none"; accounts.style.display="none"; username.style.display="none"; blacklist.style.display="block"; break;
   default: vars.style.display="none"; bans.style.display="none"; accounts.style.display="none"; username.style.display="none"; blacklist.style.display="none";
  }
 }
 function selectBlacklistAction()
 {
  var blacklistAction=document.getElementById("blacklistAction").value;
  switch (blacklistAction)
  {
   case "add": blacklistAdd.style.display="block"; blacklistRemove.style.display="none"; break;
   case "remove": blacklistAdd.style.display="none"; blacklistRemove.style.display="block"; break;
  }
 }
 function selectBlacklistRemoveType()
 {
  var blacklistRemoveType=document.getElementById("blacklist_remove_type").value;
  switch (blacklistRemoveType)
  {
   case "ip": ipList.style.display="block"; emailList.style.display="none"; break;
   case "email": ipList.style.display="none"; emailList.style.display="block"; break;
  }
 }
<?php
 if (isset($_GET['action'])) echo 'document.getElementById("action").selectedIndex=indexOfSelectValue(document.getElementById("action"), "'.$_GET['action'].'");';
 if (isset($_GET['blacklistAction']))
 {
  echo 'document.getElementById("blacklistAction").selectedIndex=indexOfSelectValue(document.getElementById("blacklistAction"), "'.$_GET['blacklistAction'].'");';
  if (isset($_POST['type'])) echo 'document.getElementById("blacklist_'.$_GET['blacklistAction'].'_type").selectedIndex=indexOfSelectValue(document.getElementById("blacklist_'.$_GET['blacklistAction'].'_type"), "'.$_POST['type'].'");';
 }
?>
 selectAction();
 selectBlacklistAction();
 selectBlacklistRemoveType();
</script>
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/footer.php'; ?>
 </body>
</html>