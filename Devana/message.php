<?php
include 'core/config.php';
include 'core/core.php';
$db->query('start transaction');
if (isset($_SESSION[$shortTitle.'User']['id'], $_GET['action']))
{
 foreach ($_POST as $key=>$value) $_POST[$key]=misc::clean($value);
 foreach ($_GET as $key=>$value)
  if (in_array($key, array('page', 'messageId'))) $_GET[$key]=misc::clean($value, 'numeric');
  else $_GET[$key]=misc::clean($value);
 switch ($_GET['action'])
 {
  case 'get':
   if (isset($_GET['messageId']))
   {
    $msg=new message();
    $status=$msg->get($_GET['messageId']);
    if ($status=='done')
     if ($msg->data['recipient']==$_SESSION[$shortTitle.'User']['id'])
     {
      if (!$msg->data['viewed'])
      {
       $msg->data['viewed']=1;
       $msg->set();
      }
      $user=new user();
      $status=$user->get('id', $msg->data['sender']);
      if ($status=='done') $msg->data['senderName']=$user->data['name'];
      else $msg->data['senderName']=$ui['game'];
      $msg->data['body']=str_replace("\r\n", "<br>", $msg->data['body']);
      $msg->data['body']=str_replace("\n", "<br>", $msg->data['body']);
     }
     else $message=$ui['accessDenied'];
    else $message=$ui[$status];
   }
   else $message=$ui['insufficientData'];
  break;
  case 'add':
   if (isset($_GET['messageId']))
   {
    $msg=new message();
    $status=$msg->get($_GET['messageId']);
    if ($status!='done') $msg=0;
    else if ($msg->data['recipient']!=$_SESSION[$shortTitle.'User']['id']) $msg=0;
   }
   if (isset($_POST['recipient'], $_POST['subject'], $_POST['body']))
    if (($_POST['recipient']!='')&&($_POST['subject']!='')&&($_POST['body']!=''))
    {
     $msg=new message();
     $msg->data['sender']=$_SESSION[$shortTitle.'User']['name'];
     $msg->data['recipient']=$_POST['recipient'];
     $msg->data['subject']=$_POST['subject'];
     $msg->data['body']=$_POST['body'];
     $msg->data['viewed']=0;
     $message=$ui[$msg->add()];
    }
    else $message=$ui['insufficientData'];
  break;
  case 'remove':
   if (isset($_GET['messageId']))
   {
    $msg=new message();
    $status=$msg->get($_GET['messageId']);
    if ($status=='done')
    {
     if ($msg->data['recipient']==$_SESSION[$shortTitle.'User']['id'])
     {
      $status=message::remove($_GET['messageId']);
      if ($status=='done') header('location: message.php?action=list');
      else $message=$ui[$status];
     }
     else $message=$ui['accessDenied'];
    }
    else $message=$ui['noMessage'];
   }
   else if (isset($_POST['messageId']))
   {
    foreach ($_POST['messageId'] as $id) message::remove($id);
    header('location: message.php?action=list');
   }
   else $message=$ui['insufficientData'];
  break;
  case 'removeAll':
   $status=message::removeAll($_SESSION[$shortTitle.'User']['id']);
   if ($status=='done') header('location: message.php?action=list');
   else $message=$ui[$status];
  break;
  case 'list':
   $limit=20;
   if (isset($_GET['page'])) $offset=$limit*$_GET['page'];
   else $offset=0;
   $messages=message::getList($_SESSION[$shortTitle.'User']['id'], $limit, $offset);
   $pageCount=ceil($messages['count']/$limit);
  break;
 }
}
else $message=$ui['accessDenied'];
if ((isset($status))&&($status=='error')) $db->query('rollback');
else $db->query('commit');
include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/message.php'; ?>