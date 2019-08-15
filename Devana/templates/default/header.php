<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $ads; ?><div class="cell">
<?php
if (isset($message)) echo misc::showMessage($message);
if (isset($_SESSION[$shortTitle.'User']['id']))
{
 $umc=message::getUnreadCount($_SESSION[$shortTitle.'User']['id']);
 if ($umc) $umcl=' ('.$umc.')';
 else $umcl='';
 echo '
 <div class="topMenu">
  <a class="link" href="'.$location.'index.php">'.$ui['home'].'</a> | 
  <a class="link" href="'.$location.'grid.php">'.$ui['grid'].'</a> | 
  <a class="link" href="'.$location.'node.php?action=list">'.$ui['nodes'].'</a> | 
  <a class="link" href="'.$location.'alliance.php?action=get">'.$ui['alliance'].'</a> | 
  <a class="link" href="'.$location.'message.php?action=list">'.$ui['messages'].'</a>'.$umcl.' | 
  <a class="link" href="'.$location.'account.php">'.$ui['account'].'</a> | 
  <a class="link" href="'.$location.'logout.php">'.$ui['logout'].'</a>
 </div>';
}
else
 echo '
 <div class="topMenu">
  <a class="link" href="'.$location.'index.php">'.$ui['home'].'</a> | 
  <a class="link" href="'.$location.'grid.php">'.$ui['grid'].'</a> | 
  <a class="link" href="'.$location.'login.php">'.$ui['login'].'</a> | 
  <a class="link" href="'.$location.'register.php">'.$ui['register'].'</a>
 </div>';
?>
<div class="clear"></div>