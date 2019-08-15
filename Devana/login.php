<?php
include 'core/config.php';
include 'core/core.php';
$db->query('start transaction');
$flags=flags::get('name');
if (isset($_GET['action']))
{
 foreach ($_GET as $key=>$value) $_GET[$key]=misc::clean($value);
 foreach ($_POST as $key=>$value) $_POST[$key]=misc::clean($value);
 switch ($_GET['action'])
 {
  case 'login':
   if (isset($_POST['name'], $_POST['password']))
   {
    $name=$_POST['name'];
    $pass=sha1($_POST['password']);
    if (isset($_POST['remember'])) $remember=1;
    else $remember=0;
   }
   else if (isset($_COOKIE[$shortTitle.'Name'], $_COOKIE[$shortTitle.'Password']))
   {
    $name=misc::clean($_COOKIE[$shortTitle.'Name']);
    $pass=misc::clean($_COOKIE[$shortTitle.'Password']);
    $remember=1;
   }
   if (isset($name, $pass))
   {
    $user=new user();
    $status=$user->get('name', $name);
    if ($status=='done')
     if (($flags['login'])||($user->data['level']==3))
      if ($user->data['password']==$pass)
       if ($user->data['level'])
       {
        $user->data['ip']=$_SERVER['REMOTE_ADDR'];
        $user->data['lastVisit']=strftime('%Y-%m-%d %H:%M:%S', time());
        $user->set();
        $_SESSION[$shortTitle.'User']=$user->data;
        if ($remember)
        {
         setcookie($shortTitle.'Name', $name, (60*60*24*30+time()));
         setcookie($shortTitle.'Password', $pass, (60*60*24*30+time()));
        }
        else
        {
         setcookie($shortTitle.'Name', $name, (time()-1));
         setcookie($shortTitle.'Password', $pass, (time()-1));
        }
        header('Location: index.php');
       }
       else $message=$ui['inactive'];
      else $message=$ui['wrongPassword'];
     else $message=$ui['loginDisabled'];
    else $message=$ui[$status];
   }
  break;
  case 'sit':
   if (isset($_POST['user'], $_POST['sitter'], $_POST['password']))
   {
    $user=new user();
    $status=$user->get('name', $_POST['user']);
    if ($status=='done')
    {
     $sitter=new user();
     $status=$sitter->get('name', $_POST['sitter']);
     if ($status=='done')
      if (sha1($_POST['password'])==$sitter->data['password'])
       if ($user->data['sitter']==$sitter->data['name'])
       {
        $user->data['ip']=$_SERVER['REMOTE_ADDR'];
        $user->data['lastVisit']=strftime('%Y-%m-%d %H:%M:%S', time());
        $user->set();
        $_SESSION[$shortTitle.'User']=$user->data;
        header('Location: index.php');
       }
       else $message=$ui['accessDenied'];
      else $message=$ui['wrongPassword'];
     else $message=$ui[$status];
    }
    else $message=$ui[$status];
   }
  break;
 }
}
if ((isset($status))&&($status=='error')) $db->query('rollback');
else $db->query('commit');
include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/login.php';
?>