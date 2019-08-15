<?php
include 'core/config.php';
include 'core/core.php';
$db->query('start transaction');
if ((isset($_SESSION[$shortTitle.'User']['level']))&&($_SESSION[$shortTitle.'User']['level']>=3))
{
 if (isset($_GET['action'], $_POST['password']))
 {
  foreach ($_POST as $key=>$value)
   if ($key=='maxIdleTime') $_POST[$key]=misc::clean($value, 'numeric');
   else $_POST[$key]=misc::clean($value);
  switch ($_GET['action'])
  {
   case 'vars':
    if ($_SESSION[$shortTitle.'User']['password']==sha1($_POST['password'])) $message=$ui[flags::set($_POST['name'], $_POST['value'])];
    else $message=$ui['wrongPassword'];
   break;
   case 'bans':
    $user=new user();
    $status=$user->get('name', $_POST['name']);
    if ($_SESSION[$shortTitle.'User']['password']==sha1($_POST['password']))
     if ($status=='done')
     {
      if ($_POST['level']>-1)
      {
       $user->data['level']=$_POST['level'];
       $message=$ui[$user->set()];
      }
      else $message=$ui[user::remove($user->data['id'])];
     }
     else $message=$ui[$status];
    else $message=$ui['wrongPassword'];
   break;
   case 'accounts':
    if ($_SESSION[$shortTitle.'User']['password']==sha1($_POST['password']))
     if ($_POST['maxIdleTime']>0)
     {
      $output=user::removeInactive($_POST['maxIdleTime']);
      $message=$output['found'].' '.$ui['accountsFound'].', '.$output['removed'].' '.$ui['removed'];
     }
     else $message=$ui['insufficientData'];
    else $message=$ui['wrongPassword'];
   break;
   case 'username':
    if ($_SESSION[$shortTitle.'User']['password']==sha1($_POST['password']))
     if ($_POST['name']!='')
     {
      $user=new user();
      $status=$user->get('name', $_POST['name']);
      if ($status=='done')
       $message='<div>'.$user->data['name'].'</div><div><div class="cell">'.$ui['ip'].': </div><div class="cell">'.$user->data['ip'].'</div></div><div><div class="cell">'.$ui['email'].': </div><div class="cell">'.$user->data['email'].'</div></div>';
      else $message=$ui[$status];
     }
     else $message=$ui['insufficientData'];
    else $message=$ui['wrongPassword'];
   break;
   case 'blacklist':
    if (isset($_GET['blacklistAction'], $_POST['type'], $_POST['value']))
     if ($_SESSION[$shortTitle.'User']['password']==sha1($_POST['password']))
      switch ($_GET['blacklistAction'])
      {
       case 'add':
        $message=$ui[blacklist::add($_POST['type'], $_POST['value'])];
       break;
       case 'remove':
        foreach ($_POST['value'] as $value)
         $message=$ui[blacklist::remove($_POST['type'], $value)];
       break;
      }
     else $message=$ui['wrongPassword'];
    else $message=$ui['insufficientData'];
   break;
  }
 }
 $flags=flags::get('id');
 $flagNames='';
 $flagValues=array();
 foreach ($flags as $key=>$flag)
 {
  $flagNames.='<option value="'.$flag['name'].'">'.$ui[$flag['name']].'</option>';
  $flagValues[$key]='"'.$flag['value'].'"';
 }
 $blacklist=array('ip'=>blacklist::get('ip'), 'email'=>blacklist::get('email'));
 $temp='';
 foreach ($blacklist['ip'] as $item) $temp.='<option value="'.$item['value'].'">'.$item['value'].'</option>';
 $blacklist['ip']=$temp;
 $temp='';
 foreach ($blacklist['email'] as $item) $temp.='<option value="'.$item['value'].'">'.$item['value'].'</option>';
 $blacklist['email']=$temp;
}
else header('Location: logout.php');
if ((isset($status))&&($status=='error')) $db->query('rollback');
else $db->query('commit');
include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/admin.php';
?>