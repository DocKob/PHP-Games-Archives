<?php
include 'core/config.php';
include 'core/core.php';
include 'core/game.php';
include 'locales/'.$_SESSION[$shortTitle.'User']['locale'].'/gl.php';
$db->query('start transaction');
if (isset($_SESSION[$shortTitle.'User']['id'], $_GET['action']))
{
 foreach ($_POST as $key=>$value)
 {
  if ($key=='name') $value=preg_replace('/[^a-zA-Z0-9]/', '', $value);
  if (in_array($key, array('x', 'y', 'faction'))) $_POST[$key]=misc::clean($value, 'numeric');
  else $_POST[$key]=misc::clean($value);
 }
 foreach ($_GET as $key=>$value)
  if ($key=='nodeId') $_GET[$key]=misc::clean($value, 'numeric');
  else $_GET[$key]=misc::clean($value);
 switch ($_GET['action'])
 {
  case 'get':
   if (isset($_GET['nodeId']))
   {
    $node=new node();
    $status=$node->get('id', $_GET['nodeId']);
    if ($status=='done')
     if ($node->data['user']==$_SESSION[$shortTitle.'User']['id'])
     {
      $node->checkAll(time());
      $node->getLocation();
      $node->getQueue('build');
      $node->getQueue('combat');
      $buildQueue=array();
      for ($i=0; $i<$game['factions'][$node->data['faction']]['modules']; $i++) $buildQueue[$i]=0;
      foreach ($node->queue['build'] as $item) $buildQueue[$item['slot']]=1;
     }
     else $message=$ui['accessDenied'];
    else $message=$ui[$status];
   }
   else $message=$ui['insufficientData'];
  break;
  case 'set':
   if (isset($_GET['nodeId']))
   {
    $node=new node();
    $status=$node->get('id', $_GET['nodeId']);
    if ($status=='done')
    {
     if ((isset($_POST['name'], $_POST['focus']))&&($_POST['name']))
      if (in_array($_POST['focus'], array('hp', 'armor', 'damage')))
       if ($node->data['user']==$_SESSION[$shortTitle.'User']['id'])
       {
        $oldName=$node->data['name'];
        $oldFocus=$node->data['focus'];
        $node->data['name']=$_POST['name'];
        $node->data['focus']=$_POST['focus'];
        $status=$node->set();
        if ($status!='done')
        {
         $node->data['name']=$oldName;
         $node->data['focus']=$oldFocus;
        }
        $message=$ui[$status];
       }
       else $message=$ui['accessDenied'];
      else $message=$ui['invalidFocus'];
    }
    else $message=$ui[$status];
   }
   else $message=$ui['accessDenied'];
  break;
  case 'add':
   if (isset($_POST['faction'], $_POST['name'], $_POST['x'], $_POST['y']))
    if (($_POST['faction']!='')&&($_POST['name']!='')&&($_POST['x']!='')&&($_POST['y']!=''))
    {
     $node=new node();
     $node->data['faction']=$_POST['faction'];
     $node->data['user']=$_SESSION[$shortTitle.'User']['id'];
     $node->data['name']=$_POST['name'];
     $node->location['x']=$_POST['x'];
     $node->location['y']=$_POST['y'];
     $message=$ui[$node->add($_SESSION[$shortTitle.'User']['id'])];
    }
    else $message=$ui['insufficientData'];
  break;
  case 'remove':
   if (isset($_GET['nodeId']))
   {
    $node=new node();
    $status=$node->get('id', $_GET['nodeId']);
    if ($status=='done')
    {
     if ((isset($_GET['go']))&&($_GET['go']))
      if ($node->data['user']==$_SESSION[$shortTitle.'User']['id'])
      {
       $status=node::remove($_GET['nodeId']);
       if ($status=='done') header('location: node.php?action=list');
       else $message=$ui[$status];
      }
      else $message=$ui['accessDenied'];
    }
    else $message=$ui[$status];
   }
   else $message=$ui['insufficientData'];
  break;
  case 'move':
   if (isset($_GET['nodeId']))
   {
    $node=new node();
    $status=$node->get('id', $_GET['nodeId']);
    if ($status=='done')
    {
     if (isset($_POST['x'], $_POST['y']))
      if ($node->data['user']==$_SESSION[$shortTitle.'User']['id'])
       if ($game['factions'][$node->data['faction']]['costs']['move'][0]['resource']>-1)
        $message=$ui[$node->move($_POST['x'], $_POST['y'])];
       else $message=$ui['nodeMoveDisabled'];
      else $message=$ui['accessDenied'];
    }
    else $message=$ui[$status];
   }
   else $message=$ui['insufficientData'];
  break;
  case 'list':
   $nodes=node::getList($_SESSION[$shortTitle.'User']['id']);
  break;
 }
}
else $message=$ui['accessDenied'];
if ((isset($status))&&($status=='error')) $db->query('rollback');
else $db->query('commit');
include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/node.php'; ?>
