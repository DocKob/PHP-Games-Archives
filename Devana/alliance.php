<?php
include 'core/config.php';
include 'core/core.php';
include 'core/game.php';
include 'locales/'.$_SESSION[$shortTitle.'User']['locale'].'/gl.php';
$db->query('start transaction');
if (isset($_SESSION[$shortTitle.'User']['id'], $_GET['action']))
{
 foreach ($_POST as $key=>$value) $_POST[$key]=misc::clean($value);
 foreach ($_GET as $key=>$value) $_GET[$key]=misc::clean($value);
 $alliance=new alliance();
 $status=$alliance->get('id', $_SESSION[$shortTitle.'User']['alliance']);
 switch ($_GET['action'])
 {
  case 'get':
   if ($_SESSION[$shortTitle.'User']['alliance'])
   {
    if ($status=='done') $alliance->getAll();
    else $message=$ui[$status];
   }
   else $invitations=alliance::getInvitations('user', $_SESSION[$shortTitle.'User']['id']);
  break;
  case 'set':
   $nodes=node::getList($_SESSION[$shortTitle.'User']['id']);
   $nodeList='';
   foreach ($nodes as $node)
    $nodeList.='<option value="'.$node->data['id'].'">'.$node->data['name'].'</option>';
   if (($status=='done')&&(isset($_POST['nodeId'], $_POST['name'])))
    if ($_POST['name']!='')
     if ($alliance->data['user']==$_SESSION[$shortTitle.'User']['id'])
     {
      $node=new node();
      $status=$node->get('id', $_POST['nodeId']);
      if ($status=='done')
       if ($node->data['user']==$_SESSION[$shortTitle.'User']['id'])
       {
        $alliance->data['name']=$_POST['name'];
        $status=$alliance->set($node->data['id']);
        $message=$ui[$status];
       }
       else $message=$ui['accessDenied'];
      else $message=$ui[$status];
     }
     else $message=$ui['accessDenied'];
    else $message=$ui['insufficientData'];
  break;
  case 'add':
   if ($status=='noAlliance')
   {
    $nodes=node::getList($_SESSION[$shortTitle.'User']['id']);
    if ($nodes)
    {
     $nodeList='';
     foreach ($nodes as $node)
      $nodeList.='<option value="'.$node->data['id'].'">'.$node->data['name'].'</option>';
     if (isset($_POST['nodeId'], $_POST['name']))
      if ($_POST['name']!='')
      {
       $alliance=new alliance();
       $node=new node();
       $status=$node->get('id', $_POST['nodeId']);
       if ($status=='done')
        if ($node->data['user']==$_SESSION[$shortTitle.'User']['id'])
        {
         $alliance->data['name']=$_POST['name'];
         $alliance->data['user']=$_SESSION[$shortTitle.'User']['id'];
         $status=$alliance->add($node->data['id']);
         if ($status=='done')
         {
          $status=$alliance->get('name', $_POST['name']);
          if ($status=='done') $_SESSION[$shortTitle.'User']['alliance']=$alliance->data['id'];
         }
         $message=$ui[$status];
        }
        else $message=$ui['accessDenied'];
       else $message=$ui[$status];
      }
      else $message=$ui['insufficientData'];
    }
    else $message=$ui['noNode'];
   }
   else $message=$ui['allianceSet'];
  break;
  case 'remove':
   if ((isset($_GET['go']))&&($_GET['go']))
    if ($_SESSION[$shortTitle.'User']['alliance'])
    {
     if ($status=='done')
      if ($alliance->data['user']==$_SESSION[$shortTitle.'User']['id'])
      {
       $status=alliance::remove($_SESSION[$shortTitle.'User']['alliance']);
       if ($status=='done')
       {
        $_SESSION[$shortTitle.'User']['alliance']=0;
        header('location: alliance.php?action=get');
       }
       else $message=$ui[$status];
      }
      else $message=$ui['accessDenied'];
     else $message=$ui[$status];
    }
    else $message=$ui['insufficientData'];
  break;
  case 'addInvitation':
   if (isset($_POST['name']))
    if ($_POST['name']!='')
     if ($status=='done')
      if ($alliance->data['user']==$_SESSION[$shortTitle.'User']['id'])
      {
       $user=new user();
       if ($user->get('name', $_POST['name'])=='done')
       {
        $status=$alliance->addInvitation($user->data['id']);
        if ($status=='done')
        {
         $user->getPreferences('name');
         if ($user->preferences['allianceReports'])
         {
          $msg=new message();
          $msg->data['sender']=$_SESSION[$shortTitle.'User']['name'];
          $msg->data['recipient']=$user->data['name'];
          $msg->data['subject']=$ui['allianceInvitation'];
          $msg->data['body']='<a class=\"link\" href=\"alliance.php?action=acceptInvitation&alliance='.$alliance->data['id'].'&user='.$user->data['id'].'\">'.$ui['accept'].'</a> '.$alliance->data['name'].' '.$ui['alliance'];
          $msg->data['viewed']=0;
          $status=$msg->add();
         }
        }
        $message=$ui[$status];
       }
       else $message=$ui['noUser'];
      }
      else $message=$ui['accessDenied'];
     else $message=$ui['noAlliance'];
    else $message=$ui['insufficientData'];
  break;
  case 'removeInvitation':
   if (isset($_GET['alliance'], $_GET['user']))
   {
    $senderAlliance=new alliance();
    if ($senderAlliance->get('id', $_GET['alliance'])=='done')
     if (in_array($_SESSION[$shortTitle.'User']['id'], array($_GET['user'], $senderAlliance->data['user'])))
     {
      $status=alliance::removeInvitation($_GET['alliance'], $_GET['user']);
      if ($status=='done') header('Location: alliance.php?action=get');
      else $message=$ui[$status];
     }
     else $message=$ui['accessDenied'];
    else $message=$ui['noAlliance'];
   }
   else $message=$ui['insufficientData'];
  break;
  case 'acceptInvitation':
   if (isset($_GET['alliance'], $_GET['user']))
    if ($_SESSION[$shortTitle.'User']['id']==$_GET['user'])
    {
     $status=alliance::acceptInvitation($_GET['alliance'], $_GET['user']);
     if ($status=='done') $_SESSION[$shortTitle.'User']['alliance']=$_GET['alliance'];
     $message=$ui[$status];
    }
    else $message=$ui['accessDenied'];
   else $message=$ui['insufficientData'];
  break;
  case 'removeMember':
   if ($status=='done')
    if (isset($_GET['user']))
     if ((($alliance->data['user']==$_SESSION[$shortTitle.'User']['id'])&&($_GET['user']!=$_SESSION[$shortTitle.'User']['id']))||(($alliance->data['user']!=$_SESSION[$shortTitle.'User']['id'])&&($_GET['user']==$_SESSION[$shortTitle.'User']['id'])))
     {
      $status=$alliance->removeMember($_GET['user']);
      if ($status=='done')
      {
       if ($_GET['user']==$_SESSION[$shortTitle.'User']['id']) $_SESSION[$shortTitle.'User']['alliance']=0;
       header('Location: alliance.php?action=get');
      }
      $message=$ui[$status];
     }
     else $message=$ui['accessDenied'];
    else $message=$ui['insufficientData'];
   else $message=$ui['noAlliance'];
  break;
  case 'addWar':
   if (isset($_POST['name']))
    if ($_POST['name']!='')
     if ($status=='done')
      if ($alliance->data['user']==$_SESSION[$shortTitle.'User']['id'])
      {
       $recipientAlliance=new alliance();
       if ($recipientAlliance->get('name', $_POST['name'])=='done')
        if ($alliance->data['id']!=$recipientAlliance->data['id'])
        {
         $status=$alliance->addWar($recipientAlliance->data['id']);
         if ($status=='done')
         {
          $user=new user();
          if ($user->get('id', $recipientAlliance->data['user'])=='done')
          {
           $user->getPreferences('name');
           if ($user->preferences['allianceReports'])
           {
            $msg=new message();
            $msg->data['sender']=$_SESSION[$shortTitle.'User']['name'];
            $msg->data['recipient']=$user->data['name'];
            $msg->data['subject']=$ui['warDeclaration'];
            $msg->data['body']=$ui['sender'].': '.$alliance->data['name'].' '.$ui['alliance'];
            $msg->data['viewed']=0;
            $status=$msg->add();
            if ($status=='done') header('Location: alliance.php?action=get');
           }
          }
          else $message=$ui['noUser'];
         }
         $message=$ui[$status];
        }
        else $message=$ui['accessDenied'];
       else $message=$ui['noAlliance'];
      }
      else $message=$ui['accessDenied'];
     else $message=$ui['noAlliance'];
    else $message=$ui['insufficientData'];
  break;
  case 'proposePeace':
   if (isset($_GET['recipient']))
    if ($status=='done')
     if ($alliance->data['user']==$_SESSION[$shortTitle.'User']['id'])
     {
      $recipientAlliance=new alliance();
      if ($recipientAlliance->get('id', $_GET['recipient'])=='done')
      {
       $status=$alliance->proposePeace($recipientAlliance->data['id']);
       if ($status=='done') header('Location: alliance.php?action=get');
       $message=$ui[$status];
      }
      else $message=$ui['noAlliance'];
     }
     else $message=$ui['accessDenied'];
    else $message=$ui['noAlliance'];
   else $message=$ui['insufficientData'];
  break;
  case 'removePeace':
   if (isset($_GET['recipient']))
    if ($status=='done')
     if ($alliance->data['user']==$_SESSION[$shortTitle.'User']['id'])
     {
      $recipientAlliance=new alliance();
      if ($recipientAlliance->get('id', $_GET['recipient'])=='done')
      {
       $status=$alliance->removePeace($recipientAlliance->data['id']);
       if ($status=='done') header('Location: alliance.php?action=get');
       else $message=$ui[$status];
      }
      else $message=$ui['noAlliance'];
     }
     else $message=$ui['accessDenied'];
    else $message=$ui['noAlliance'];
   else $message=$ui['insufficientData'];
  break;
  case 'acceptPeace':
   if (isset($_GET['sender'], $_GET['recipient']))
    if ($status=='done')
     if (($alliance->data['user']==$_SESSION[$shortTitle.'User']['id'])&&($alliance->data['id']==$_GET['recipient']))
     {
      $senderAlliance=new alliance();
      if ($senderAlliance->get('id', $_GET['sender'])=='done')
      {
       $status=$alliance->acceptPeace($senderAlliance->data['id']);
       if ($status=='done')
       {
        $user=new user();
        if ($user->get('id', $senderAlliance->data['user'])=='done')
        {
         $user->getPreferences('name');
         if ($user->preferences['allianceReports'])
         {
          $msg=new message();
          $msg->data['sender']=$_SESSION[$shortTitle.'User']['name'];
          $msg->data['recipient']=$user->data['name'];
          $msg->data['subject']=$ui['peaceAccepted'];
          $msg->data['body']=$ui['sender'].': '.$alliance->data['name'].' '.$ui['alliance'];
          $msg->data['viewed']=0;
          $status=$msg->add();
          if ($status=='done') header('Location: alliance.php?action=get');
         }
        }
        else $message=$ui['noUser'];
       }
       $message=$ui[$status];
      }
      else $message=$ui['noAlliance'];
     }
     else $message=$ui['accessDenied'];
    else $message=$ui['noAlliance'];
   else $message=$ui['insufficientData'];
  break;
 }
}
else $message=$ui['accessDenied'];
if ((isset($status))&&($status=='error')) $db->query('rollback');
else $db->query('commit');
include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/alliance.php'; ?>