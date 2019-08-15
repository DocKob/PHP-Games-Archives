<?php
include 'core/config.php';
include 'core/core.php';
$db->query('start transaction');
if (isset($_SESSION[$shortTitle.'User']['id']))
{
 $locales='<option value="'.$_SESSION[$shortTitle.'User']['locale'].'">'.$_SESSION[$shortTitle.'User']['locale'].'</option>';
 if ($handle=opendir('locales'))
  while (false!=($file=readdir($handle)))
  {
   $fileName=explode('.', $file); $fileName=$fileName[0];
   if (($file!='.')&&($file!='..')&&($_SESSION[$shortTitle.'User']['locale']!=$fileName))
    $locales.='<option value="'.$fileName.'">'.$fileName.'</option>';
  }
 closedir($handle);
 $templates='<option value="'.$_SESSION[$shortTitle.'User']['template'].'">'.$_SESSION[$shortTitle.'User']['template'].'</option>';
 if ($handle=opendir('templates'))
  while (false!=($file=readdir($handle)))
   if ((strpos($file, '.')===false)&&($_SESSION[$shortTitle.'User']['template']!=$file))
    $templates.='<option value="'.$file.'">'.$file.'</option>';
 closedir($handle);
 $user=new user();
 $user->get('id', $_SESSION[$shortTitle.'User']['id']);
 if (isset($_GET['action'], $_POST['password']))
 {
  foreach ($_POST as $key=>$value) $_POST[$key]=misc::clean($value);
  switch ($_GET['action'])
  {
   case 'misc':
    if ($_SESSION[$shortTitle.'User']['password']==sha1($_POST['password']))
    {
     $user->data['email']=$_SESSION[$shortTitle.'User']['email']=$_POST['email'];
     $user->data['sitter']=$_SESSION[$shortTitle.'User']['sitter']=$_POST['sitter'];
     $user->data['locale']=$_SESSION[$shortTitle.'User']['locale']=$_POST['locale'];
     $user->data['template']=$_SESSION[$shortTitle.'User']['template']=$_POST['template'];
     $message=$ui[$user->set()];
    }
    else $message=$ui['wrongPassword'];
   break;
   case 'preferences':
    if ($_SESSION[$shortTitle.'User']['password']==sha1($_POST['password']))
     $message=$ui[$user->setPreference($_POST['name'], $_POST['value'])];
    else $message=$ui['wrongPassword'];
   break;
   case 'blocklist':
    if ($_SESSION[$shortTitle.'User']['password']==sha1($_POST['password']))
     $message=$ui[$user->setBlocklist($_POST['name'])];
    else $message=$ui['wrongPassword'];
   break;
   case 'password':
    if ($_SESSION[$shortTitle.'User']['password']==sha1($_POST['password']))
     if ($_POST['newPassword']==$_POST['rePassword'])
     {
      $user->data['password']=$_SESSION[$shortTitle.'User']['password']=sha1($_POST['newPassword']);
      $message=$ui[$user->set()];
     }
     else $message=$ui['rePassNotMatch'];
    else $message=$ui['wrongPassword'];
   break;
   case 'remove':
    if ($_SESSION[$shortTitle.'User']['password']==sha1($_POST['password']))
    {
     $status=user::remove($user->data['id']);
     if ($status=='done') header('Location: logout.php');
     else $message=$ui[$status];
    }
    else $message=$ui['wrongPassword'];
   break;
  }
 }
 $user->getPreferences('id');
 $preferenceNames='';
 $preferenceValues=array();
 foreach ($user->preferences as $key=>$preference)
 {
  $preferenceNames.='<option value="'.$preference['name'].'">'.$ui[$preference['name']].'</option>';
  $preferenceValues[$key]='"'.$preference['value'].'"';
 }
 $user->getBlocklist();
 $blocklistNames='';
 foreach ($user->blocklist as $item)
  $blocklistNames.=$item['senderName'].' ';
}
else header('Location: logout.php');
if ((isset($status))&&($status=='error')) $db->query('rollback');
else $db->query('commit');
include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/account.php';
?>