<?php
include 'core/config.php';
include 'core/core.php';
include 'core/game.php';
include 'locales/'.$_SESSION[$shortTitle.'User']['locale'].'/gl.php';
$db->query('start transaction');
if (isset($_SESSION[$shortTitle.'User']['id'], $_GET['action'], $_GET['nodeId']))
{
 $node=new node();
 if ($node->get('id', $_GET['nodeId'])=='done')
 {
  $flags=flags::get('name');
  $node->checkAll(time());
  switch ($_GET['action'])
  {
   case 'add':
    if ($flags['combat'])
    {
     if (isset($_POST['name'], $_POST['attackerGroupUnitIds'], $_POST['attackerGroups']))
     {
      foreach ($_POST as $key=>$value)
       if (!in_array($key, array('name', 'attackerGroupUnitIds', 'attackerGroups', 'attackerFocus'))) $_POST[$key]=misc::clean($value, 'numeric');
       else if (!in_array($key, array('name', 'attackerFocus')))
       {
        $nr=count($_POST[$key]);
        for ($i=0; $i<$nr; $i++) $_POST[$key][$i]=misc::clean($_POST[$key][$i], 'numeric');
       }
       else $_POST[$key]=misc::clean($value);
      $target=new node();
      if ($target->get('name', $_POST['name'])=='done')
      {
       $targetUser=new user();
       if ($targetUser->get('id', $target->data['user'])=='done')
       {
        $alliance=new alliance();
        $targetAlliance=new alliance();
        if (($targetAlliance->get('id', $targetUser->data['alliance'])=='done')&&($alliance->get('id', $_SESSION[$shortTitle.'User']['alliance'])=='done'))
        {
         $war=$alliance->getWar($targetAlliance->data['id']);
         if (isset($war['type']))
         {
          $gotStatic=false;
          $data=array();
          $data['input']['attacker']['focus']=$_POST['attackerFocus'];
          $data['input']['attacker']['faction']=$node->data['faction'];
          foreach ($_POST['attackerGroupUnitIds'] as $key=>$unitId)
          {
           $data['input']['attacker']['groups'][$key]=array('unitId'=>$unitId, 'quantity'=>$_POST['attackerGroups'][$key]);
           if (!$game['units'][$node->data['faction']][$unitId]['speed']) $gotStatic=true;
          }
          if (!$gotStatic) $status=$node->addCombat($target->data['id'], $data);
          else $status='cannotSendStatic';
          $message=$ui[$status];
         }
         else $message=$ui['noWar'];
        }
        else $message=$ui['noAlliance'];
       }
       else $message=$ui['noUser'];
      }
      else $message=$ui['noNode'];
     }
    }
    else $message=$ui['featureDisabled'];
   break;
   case 'cancel':
    if (isset($_GET['combatId']))
    {
     $combat=node::getCombat($_GET['combatId']);
     if (isset($combat['id']))
      if ($combat['sender']==$node->data['id'])
      {
       $status=$node->cancelCombat($combat['id']);
       if ($status=='done') header('Location: node.php?action=get&nodeId='.$node->data['id']);
       else $message=$ui[$status];
      }
      else $message=$ui['accessDenied'];
     else $message=$ui['noCombat'];
    }
   break;
  }
 }
 else $message=$ui['noNode'];
}
else $message=$ui['insufficientData'];
if ((isset($status))&&($status=='error')) $db->query('rollback');
else $db->query('commit');
include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/combat.php';
?>