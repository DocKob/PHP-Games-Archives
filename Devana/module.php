<?php
include 'core/config.php';
include 'core/core.php';
include 'core/game.php';
include 'locales/'.$_SESSION[$shortTitle.'User']['locale'].'/gl.php';
$db->query('start transaction');
if (isset($_SESSION[$shortTitle.'User']['id'], $_GET['action'], $_GET['nodeId'], $_GET['slotId']))
{
 foreach ($_POST as $key=>$value)
  if (in_array($key, array('input', 'quantity'))) $_POST[$key]=misc::clean($value, 'numeric');
  else $_POST[$key]=misc::clean($value);
 foreach ($_GET as $key=>$value)
  if (in_array($key, array('nodeId', 'slotId'))) $_GET[$key]=misc::clean($value, 'numeric');
  else $_GET[$key]=misc::clean($value);
 $flags=flags::get('name');
 $node=new node();
 $status=$node->get('id', $_GET['nodeId']);
 if ($status=='done')
 {
  $node->checkAll(time());
  $node->getLocation();
  if ($node->data['user']==$_SESSION[$shortTitle.'User']['id'])
   if (isset($node->modules[$_GET['slotId']]))
    switch ($_GET['action'])
    {
     case 'get':
      $mid=$node->modules[$_GET['slotId']]['module'];
      $sid=$node->modules[$_GET['slotId']]['slot'];
      if ($mid>-1) $module=$game['modules'][$node->data['faction']][$mid];
      if (isset($module))
       switch ($module['type'])
       {
        case 'research':
         $node->getQueue('research', 'technology', $game['modules'][$node->data['faction']][$mid]['technologies']);
         $totalIR=0;
         foreach ($node->modules as $key=>$item)
          if ($item['module']==$mid) $totalIR+=$item['input']*$game['modules'][$node->data['faction']][$item['module']]['ratio'];
        break;
        case 'craft':
         $node->getQueue('craft', 'component', $game['modules'][$node->data['faction']][$mid]['components']);
         $totalIR=0;
         foreach ($node->modules as $key=>$item)
          if ($item['module']==$mid) $totalIR+=$item['input']*$game['modules'][$node->data['faction']][$item['module']]['ratio'];
        break;
        case 'train':
         $node->getQueue('train', 'unit', $game['modules'][$node->data['faction']][$mid]['units']);
         $totalIR=0;
         foreach ($node->modules as $key=>$item)
          if ($item['module']==$mid) $totalIR+=$item['input']*$game['modules'][$node->data['faction']][$item['module']]['ratio'];
        break;
       }
      else $message='emptySlot';
     break;
     case 'set':
      if (isset($_POST['input']))
      {
       $node->modules[$_GET['slotId']]['input']=$_POST['input'];
       $status=$node->setModule($_GET['slotId']);
       if ($status=='done') header('Location: module.php?action=get&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId']);
       else $message=$ui[$status];
      }
     break;
     case 'add':
      if ($flags['build'])
      {
       if (isset($_GET['moduleId']))
       {
        $status=$node->addModule($_GET['slotId'], $_GET['moduleId']);
        if ($status=='done') header('Location: node.php?action=get&nodeId='.$node->data['id']);
        else $message=$ui[$status];
       }
      }
      else $message=$ui['featureDisabled'];
     break;
     case 'remove':
      if ($flags['build'])
      {
       $status=$node->removeModule($_GET['slotId']);
       if ($status=='done') header('Location: node.php?action=get&nodeId='.$node->data['id']);
       else $message=$ui[$status];
      }
      else $message=$ui['featureDisabled'];
     break;
     case 'cancel':
      $status=$node->cancelModule($_GET['slotId']);
      if ($status=='done') header('Location: node.php?action=get&nodeId='.$node->data['id']);
      else $message=$ui[$status];
     break;
     case 'list':
      
     break;
     case 'addTechnology':
      if ($flags['research'])
      {
       if (isset($_GET['technologyId']))
       {
        $status=$node->addTechnology($_GET['technologyId'], $_GET['slotId']);
        if ($status=='done') header('Location: module.php?action=get&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId']);
        else $message=$ui[$status];
       }
      }
      else $message=$ui['featureDisabled'];
     break;
     case 'cancelTechnology':
      if (isset($_GET['technologyId']))
      {
       $status=$node->cancelTechnology($_GET['technologyId'], $node->modules[$_GET['slotId']]['module']);
       if ($status=='done') header('Location: module.php?action=get&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId']);
       else $message=$ui[$status];
      }
     break;
     case 'addComponent':
      if ($flags['craft'])
      {
       if (isset($_GET['componentId'], $_POST['quantity']))
        if ($_POST['quantity']>0)
        {
         $status=$node->addComponent($_GET['componentId'], $_POST['quantity'], $_GET['slotId']);
         if ($status=='done') header('Location: module.php?action=get&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId']);
         else $message=$ui[$status];
        }
        else header('Location: module.php?action=get&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId']);
      }
      else $message=$ui['featureDisabled'];
     break;
     case 'removeComponent':
      if ($flags['craft'])
      {
       if (isset($_GET['componentId'], $_POST['quantity']))
       {
        $status=$node->removeComponent($_GET['componentId'], $_POST['quantity'], $node->modules[$_GET['slotId']]['module']);
        if ($status=='done') header('Location: module.php?action=get&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId']);
        else $message=$ui[$status];
       }
      }
      else $message=$ui['featureDisabled'];
     break;
     case 'cancelComponent':
      if (isset($_GET['craftId']))
      {
       $status=$node->cancelComponent($_GET['craftId'], $node->modules[$_GET['slotId']]['module']);
       if ($status=='done') header('Location: module.php?action=get&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId']);
       else $message=$ui[$status];
      }
     break;
     case 'addUnit':
      if ($flags['train'])
      {
       if (isset($_GET['unitId'], $_POST['quantity']))
        if ($_POST['quantity']>0)
        {
         $status=$node->addUnit($_GET['unitId'], $_POST['quantity'], $_GET['slotId']);
         if ($status=='done') header('Location: module.php?action=get&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId']);
         else $message=$ui[$status];
        }
        else header('Location: module.php?action=get&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId']);
      }
      else $message=$ui['featureDisabled'];
     break;
     case 'removeUnit':
      if ($flags['train'])
      {
       if (isset($_GET['unitId'], $_POST['quantity']))
       {
        $status=$node->removeUnit($_GET['unitId'], $_POST['quantity'], $node->modules[$_GET['slotId']]['module']);
        if ($status=='done') header('Location: module.php?action=get&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId']);
        else $message=$ui[$status];
       }
      }
      else $message=$ui['featureDisabled'];
     break;
     case 'cancelUnit':
      if (isset($_GET['trainId']))
      {
       $status=$node->cancelUnit($_GET['trainId'], $node->modules[$_GET['slotId']]['module']);
       if ($status=='done') header('Location: module.php?action=get&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId']);
       else $message=$ui[$status];
      }
     break;
    }
   else $message=$ui['noSlot'];
  else $message=$ui['noSlot'];
 }
 else $message=$ui[$status];
}
else $message=$ui['accessDenied'];
if ((isset($status))&&($status=='error')) $db->query('rollback');
else $db->query('commit');
include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/module.php'; ?>