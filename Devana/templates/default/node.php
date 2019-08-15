<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <script type="text/javascript" src="core/core.js"></script>
  <script type="text/javascript">
   var timerIds=new Array();
   function setLabel(value)
   {
    document.getElementById("label").innerHTML=value;
   }
  </script>
  <?php echo '<link rel="stylesheet" type="text/css" href="templates/'.$_SESSION[$shortTitle.'User']['template'].'/default.css">'; ?>
  <title>
<?php
echo $title;
if (isset($node)) echo $ui['separator'].$node->data['name'].$ui['separator'].$ui[$_GET['action']];
else echo $ui['separator'].$ui[$_GET['action']];
?>
  </title>
  <?php echo $tracker; ?>
 </head>
 <body class="body">
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/header.php'; ?>
<?php
if (isset($_SESSION[$shortTitle.'User']['id'], $_GET['action']))
{
 echo '<div class="container"><div class="content">';
 switch ($_GET['action'])
 {
  case 'get':
   if ((isset($node->data['id']))&&($node->data['id']==$_SESSION[$shortTitle.'User']['id']))
   {
    echo '<div class="node" style="background-image: url(\'templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/modules/'.$node->data['faction'].'/nodeBackground.jpg\');">';
    include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/resources.php';
    echo '<div class="slots">';
    $i=0;
    foreach ($node->modules as $module)
    {
     if ($i==3)
     {
      $i=0;
      echo '</div>';
     }
     if (!$i) echo '<div>';
     if ($buildQueue[$module['slot']]) echo '<a class="link" href="module.php?action=cancel&nodeId='.$node->data['id'].'&slotId='.$module['slot'].'" onMouseOver="setLabel(\''.$ui['underConstruction'].'\')" onMouseOut="setLabel(\'\')"><img class="module" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/modules/'.$node->data['faction'].'/pending.png"></a>';
     else if ($module['module']>-1) echo '<a class="link" href="module.php?action=get&nodeId='.$node->data['id'].'&slotId='.$module['slot'].'" onMouseOver="setLabel(\''.$gl['modules'][$node->data['faction']][$module['module']]['name'].'\')" onMouseOut="setLabel(\'\')"><img class="module" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/modules/'.$node->data['faction'].'/'.$module['module'].'.png"></a>';
     else echo '<a class="link" href="module.php?action=list&nodeId='.$node->data['id'].'&slotId='.$module['slot'].'" onMouseOver="setLabel(\''.$ui['emptySlot'].'\')" onMouseOut="setLabel(\'\')"><img class="module" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/modules/'.$node->data['faction'].'/empty.png"></a>';
     $i++;
    }
    echo '</div></div>';
    if (count($node->queue['build']))
    {
     echo '<div class="queue rightQueue">';
     foreach ($node->queue['build'] as $item)
     {
      if ($node->modules[$item['slot']]['module']==-1) $action='add';
      else $action='remove';
      $remaining=$item['start']+$item['duration']*60-time();
      echo '<div><div class="cell">'.$ui[$action].'</div><div class="cell">'.$gl['modules'][$node->data['faction']][$item['module']]['name'].'</div><div class="cell"><span id="build_'.$item['node'].'_'.$item['slot'].'">'.implode(':', misc::sToHMS($remaining)).'</span><script type="text/javascript">timedJump("build_'.$item['node'].'_'.$item['slot'].'", "node.php?action=get&nodeId='.$node->data['id'].'");</script></div><div class="cell"> | <a class="link" href="module.php?action=cancel&nodeId='.$node->data['id'].'&slotId='.$item['slot'].'">x</a></div></div>';
     }
     echo '</div>';
    }
    if (count($node->queue['combat']))
    {
     echo '<div class="queue leftQueue">';
     foreach ($node->queue['combat'] as $item)
     {
      $cancel='';
      if (!$item['stage'])
      {
       if ($item['sender']==$node->data['id'])
       {
        $action='outgoing';
        $cancel='<div class="cell"> | <a class="link" href="combat.php?action=cancel&nodeId='.$node->data['id'].'&combatId='.$item['id'].'">x</a></div>';
       }
       else $action='incoming';
      }
      else if ($item['sender']==$node->data['id']) $action='returning';
      $remaining=$item['start']+$item['duration']*60-time();
      $otherNode=new node();
      if ($item['sender']==$node->data['id']) $status=$otherNode->get('id', $item['recipient']);
      else $status=$otherNode->get('id', $item['sender']);
      if ($status=='done')
       echo '<div><div class="cell">'.$ui[$action].' '.$ui['combat'].'</div><div class="cell">"'.$otherNode->data['name'].'"</div><div class="cell"><span id="combat_'.$item['id'].'">'.implode(':', misc::sToHMS($remaining)).'</span><script type="text/javascript">timedJump("combat_'.$item['id'].'", "node.php?action=get&nodeId='.$node->data['id'].'");</script></div>'.$cancel.'</div>';
     }
     echo '</div>';
    }
   }
  break;
  case 'set':
   if (isset($node->data['id']))
   {
    $costData='';
    foreach ($game['factions'][$node->data['faction']]['costs']['set'] as $key=>$cost)
     $costData.='<div class="cell">'.$cost['value'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$cost['resource'].'.png" title="'.$gl['resources'][$cost['resource']]['name'].'"></div>';
    $selectedFocus=array('hp'=>'', 'damage'=>'', 'armor'=>'');
    $selectedFocus[$node->data['focus']]=' selected';
    echo '
    <form method="post" action="?action=set&nodeId='.$node->data['id'].'">
     <div><div class="cell">'.$ui['name'].'</div><div class="cell"><input class="textbox" type="text" name="name" value="'.$node->data['name'].'"></div></div>
     <div>
      <div class="cell">'.$ui['focus'].'</div>
      <div class="cell">
       <select class="dropdown" name="focus">
        <option value="hp"'.$selectedFocus['hp'].'>'.$ui['hp'].'</option>
        <option value="damage"'.$selectedFocus['damage'].'>'.$ui['damage'].'</option>
        <option value="armor"'.$selectedFocus['armor'].'>'.$ui['armor'].'</option>
       </select>
      </div>
     </div>
     <div><input class="button" type="submit" value="'.$ui['set'].'"></div>
    </form>
    <div>'.$ui['cost'].': '.$costData.'</div>
    <div style="border-top: 1px solid black; padding-top: 5px; margin-top: 5px;"><a class="link" href="node.php?action=get&nodeId='.$node->data['id'].'">'.$node->data['name'].'</a></div>';
   }
  break;
  case 'add':
   echo '
    <form method="post" action="?action=add">
     <div><div class="cell">'.$ui['faction'].'</div><div class="cell"><select class="dropdown" name="faction" id="faction" onChange="changeFaction()">';
   foreach ($gl['factions'] as $key=>$faction)
    echo '<option value="'.$key.'">'.$faction['name'].'</option>';
   echo '</select></div></div>
     <div><div class="cell"></div><div class="cell" id="factionDescription">'.$gl['factions'][0]['description'].'</div></div>
     <div><div class="cell">'.$ui['name'].'</div><div class="cell"><input class="textbox" type="text" name="name"></div></div>
     <div><div class="cell">'.$ui['location'].'</div><div class="cell">'.$ui['x'].'<input class="textbox" type="text" name="x" size="2">'.$ui['y'].'<input class="textbox" type="text" name="y" size="2"></div></div>
     <div><input class="button" type="submit" value="'.$ui['add'].'"></div>
    </form>
    <script type="text/javascript">
     var factions=new Array(';
   foreach ($gl['factions'] as $key=>$faction) $descriptions[$key]='"'.$faction['description'].'"';
   echo implode(', ', $descriptions).');
     function changeFaction()
     {
      document.getElementById("factionDescription").innerHTML=factions[document.getElementById("faction").selectedIndex];
     }
    </script>';
  break;
  case 'remove':
   if (isset($node->data['id']))
    echo '<div>'.$ui['areYouSure'].'</div><div><a class="link" href="node.php?action=remove&nodeId='.$node->data['id'].'&go=1">'.$ui['yes'].'</a> | <a class="link" href="node.php?action=get&nodeId='.$node->data['id'].'">'.$ui['no'].'</a></div>';
  break;
  case 'move':
   if (isset($node->data['id']))
   {
    $costData='';
    foreach ($game['factions'][$node->data['faction']]['costs']['move'] as $key=>$cost)
     $costData.='<div class="cell">'.$cost['value'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$cost['resource'].'.png" title="'.$gl['resources'][$cost['resource']]['name'].'"></div>';
    echo '
    <form method="post" action="?action=move&nodeId='.$node->data['id'].'">
     <div><div class="cell">x</div><div class="cell"><input class="textbox numeric" type="text" name="x" value="'.$node->location['x'].'" size="3"></div></div>
     <div><div class="cell">y</div><div class="cell"><input class="textbox numeric" type="text" name="y" value="'.$node->location['y'].'" size="3"></div></div>
     <div><input class="button" type="submit" value="'.$ui['move'].'"></div>
    </form>
    <div>'.$ui['cost'].': '.$costData.'<div class="cell">'.$ui['perSector'].'</div></div>
    <div style="border-top: 1px solid black; padding-top: 5px; margin-top: 5px;"><a class="link" href="node.php?action=get&nodeId='.$node->data['id'].'">'.$node->data['name'].'</a></div>';
   }
  break;
  case 'list':
   echo '<div><a class="link" href="node.php?action=add">'.$ui['addNode'].'</a></div><div>-----------</div>';
   foreach ($nodes as $key=>$node)
    echo '<div><a class="link" href="node.php?action=get&nodeId='.$node->data['id'].'">'.$node->data['name'].'</a></div>';
  break;
 }
 echo '</div></div>';
}
?>
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/footer.php'; ?>
 </body>
</html>