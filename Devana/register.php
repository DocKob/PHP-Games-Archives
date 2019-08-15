<?php
include 'core/config.php';
include 'core/core.php';
include 'core/game.php';
$db->query('start transaction');
$flags=flags::get('name');
if ($flags['register'])
{
 if (isset($_POST['email'], $_POST['name'], $_POST['password'], $_POST['rePassword'], $_POST['regCode']))
 {
  foreach ($_POST as $key=>$value)
  {
   if ($key=='name') $value=preg_replace('/[^a-zA-Z0-9]/', '', $value);
   $_POST[$key]=misc::clean($value);
  }
  if ((($_POST['email']!=''))&&($_POST['name']!='')&&(($_POST['password']!='')))
  {
   $user=new user();
   if ($_POST['password']==$_POST['rePassword'])
    if ($_POST['regCode']==$_SESSION['regCode'])
     if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
     {
      $user->data['name']=$_POST['name'];
      $user->data['email']=$_POST['email'];
      $user->data['password']=sha1($_POST['password']);
      if ($flags['activation']) $user->data['level']=0;
      else $user->data['level']=1;
      $user->data['joined']=strftime('%Y-%m-%d', time());
      $user->data['lastVisit']=strftime('%Y-%m-%d %H:%M:%S', time());
      $user->data['ip']=$_SERVER['REMOTE_ADDR'];
      $user->data['template']='default';
      $user->data['locale']='en';
      $status=$user->add();
      if ($flags['activation'])
       if ($status=='done')
       {
        include 'core/email/email.php';
        $user->get('name', $user->data['name']);
        $code=rand(1000000000, 9999999999);
        $link=$location.'activate.php?user='.$user->data['name'].'&code='.$code;
        $body=$title.' '.$ui['accountActivationLink'].': <a href="'.$link.'" target="_blank">'.$link.'</a>';
        $activation=new activation();
        $activation->data['user']=$user->data['id'];
        $activation->data['code']=$code;
        $status=$activation->add();
        if ($status=='done')
         $status=email($title, $user->data['email'], $title.' '.$ui['registration'], $body);
       }
      $message=$ui[$status];
     }
     else $message=$ui['invalidEmail'];
    else $message=$ui['wrongCode'];
   else $message=$ui['rePassNotMatch'];
  }
  else $message=$ui['insufficientData'];
 }
 else $_SESSION['regCode']=rand(1, 9999);
}
else
{
 $message=$ui['registrationDisabled'];
 $_SESSION['regCode']=':(';
}
if ((isset($status))&&($status=='error')) $db->query('rollback');
else $db->query('commit');
include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/register.php'; ?>
