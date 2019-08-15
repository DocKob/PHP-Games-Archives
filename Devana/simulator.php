<?php
include 'core/config.php';
include 'core/core.php';
include 'core/game.php';
include 'locales/'.$_SESSION[$shortTitle.'User']['locale'].'/gl.php';
if (isset($_POST['attackerGroupUnitIds'], $_POST['defenderGroupUnitIds']))
{
 foreach ($_POST as $key=>$value)
  if (!in_array($key, array('attackerGroupUnitIds', 'defenderGroupUnitIds', 'attackerGroups', 'defenderGroups', 'attackerFocus', 'defenderFocus'))) $_POST[$key]=misc::clean($value, 'numeric');
  else if (!in_array($key, array('attackerFocus', 'defenderFocus')))
  {
   $nr=count($_POST[$key]);
   for ($i=0; $i<$nr; $i++) $_POST[$key][$i]=misc::clean($_POST[$key][$i], 'numeric');
  }
  else $_POST[$key]=misc::clean($value);
 $data=array();
 $data['input']['attacker']['focus']=$_POST['attackerFocus'];
 $data['input']['attacker']['faction']=$_POST['attackerFaction'];
 foreach ($_POST['attackerGroupUnitIds'] as $key=>$unitId)
  $data['input']['attacker']['groups'][$key]=array('unitId'=>$unitId, 'quantity'=>$_POST['attackerGroups'][$key]);
 $data['input']['defender']['focus']=$_POST['defenderFocus'];
 $data['input']['defender']['faction']=$_POST['defenderFaction'];
 foreach ($_POST['defenderGroupUnitIds'] as $key=>$unitId)
  $data['input']['defender']['groups'][$key]=array('unitId'=>$unitId, 'quantity'=>$_POST['defenderGroups'][$key]);
 $data=node::doCombat($data);
}
include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/simulator.php';
?>