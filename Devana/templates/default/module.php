<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <script type="text/javascript" src="core/core.js"></script>
  <script type="text/javascript">
   var timerIds=new Array();
  </script>
  <?php echo '<link rel="stylesheet" type="text/css" href="templates/'.$_SESSION[$shortTitle.'User']['template'].'/default.css">'; ?>
  <title>
<?php
echo $title;
if (isset($mid)) echo $ui['separator'].$node->data['name'].$ui['separator'].$gl['modules'][$node->data['faction']][$mid]['name'];
?>
  </title>
  <?php echo $tracker; ?>
 </head>
 <body class="body">
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/header.php'; ?>
<?php
if (isset($_SESSION[$shortTitle.'User']['id'], $_GET['action'], $_GET['nodeId'], $_GET['slotId']))
 switch ($_GET['action'])
 {
  case 'get':
   if (isset($node->modules[$_GET['slotId']]))
   {
    if (isset($module))
    {
     echo '<div class="container"><div class="content" style="text-align: left;">';
     include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/resources.php';
     switch ($module['type'])
     {
      case 'storage':
       echo '
         <div>
          <div class="cell"><div class="module" style="background-image: url(\'templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/modules/'.$node->data['faction'].'/moduleBackground.jpg\');"><img style="width: 300px;" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/modules/'.$node->data['faction'].'/'.$mid.'.png" /></div></div>
          <div class="cell">
           <div><div class="cell" style="font-weight: bold;">'.$gl['modules'][$node->data['faction']][$mid]['name'].'</div></div>
           <div><div class="cell">'.$gl['modules'][$node->data['faction']][$mid]['description'].'</div></div>
           <div>
            <div class="inline">
             <div class="cell">'.$ui['maxInput'].': </div>
             <div class="cell">'.$module['maxInput'].'</div>
            </div>
           </div>
           <div>
            <div class="inline">
             <div class="cell">'.$ui['ratio'].': </div>
             <div class="cell">'.$module['ratio'].'</div>
            </div>
           </div>
           <div>
            <form method="post" action="?action=set&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId'].'">
             '.$gl['resources'][$module['inputResource']]['name'].' <input class="textbox numeric" type="text" name="input" style="width: 40px;" autocomplete="off" value="'.$node->modules[$sid]['input'].'">
             <input class="button" type="submit" value="'.$ui['set'].'">
            </form>
           </div>
           <div>
            <div class="inline">
             <div class="cell">'.$ui['storage'].': </div>
             <div class="cell">'.$module['ratio']*$node->modules[$sid]['input'].'</div>
            </div>
           </div>
           <div>
            <div style="text-align: right; border-top: 1px solid black; margin-top: 5px; padding-top: 5px;"><a class="link" href="module.php?action=remove&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId'].'">'.$ui['removeModule'].'</a></div>
           </div>
          </div>
         </div>
        ';
      break;
      case 'harvest':
       echo '
         <div>
          <div class="cell"><div class="module" style="background-image: url(\'templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/modules/'.$node->data['faction'].'/moduleBackground.jpg\');"><img style="width: 300px;" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/modules/'.$node->data['faction'].'/'.$mid.'.png" /></div></div>
          <div class="cell">
           <div><div class="cell" style="font-weight: bold;">'.$gl['modules'][$node->data['faction']][$mid]['name'].'</div></div>
           <div><div class="cell">'.$gl['modules'][$node->data['faction']][$mid]['description'].'</div></div>
           <div>
            <div class="inline">
             <div class="cell">'.$ui['maxInput'].': </div>
             <div class="cell">'.$module['maxInput'].'</div>
            </div>
           </div>
           <div>
            <div class="inline">
             <div class="cell">'.$ui['ratio'].': </div>
             <div class="cell">'.$module['ratio'].'</div>
            </div>
           </div>
           <div>
            <form method="post" action="?action=set&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId'].'">
             '.$gl['resources'][$module['inputResource']]['name'].' <input class="textbox numeric" type="text" name="input" style="width: 40px;" autocomplete="off" value="'.$node->modules[$sid]['input'].'">
             <input class="button" type="submit" value="'.$ui['set'].'">
            </form>
           </div>
           <div>
            <div class="inline">
             <div class="cell">'.$ui['production'].': </div>
             <div class="cell">'.$module['ratio']*$node->modules[$sid]['input'].$ui['perHour'].'</div>
            </div>
           </div>
           <div>
            <div style="text-align: right; border-top: 1px solid black; margin-top: 5px; padding-top: 5px;"><a class="link" href="module.php?action=remove&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId'].'">'.$ui['removeModule'].'</a></div>
           </div>
          </div>
         </div>
        ';
      break;
      case 'research':
       echo '
         <div>
          <div class="cell"><div class="module" style="background-image: url(\'templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/modules/'.$node->data['faction'].'/moduleBackground.jpg\');"><img style="width: 300px;" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/modules/'.$node->data['faction'].'/'.$mid.'.png" /></div></div>
          <div class="cell">
           <div><div class="cell" style="font-weight: bold;">'.$gl['modules'][$node->data['faction']][$mid]['name'].'</div></div>
           <div><div class="cell">'.$gl['modules'][$node->data['faction']][$mid]['description'].'</div></div>
           <div>
            <div class="inline">
             <div class="cell">'.$ui['maxInput'].': </div>
             <div class="cell">'.$module['maxInput'].'</div>
            </div>
           </div>
           <div>
            <div class="inline">
             <div class="cell">'.$ui['ratio'].': </div>
             <div class="cell">'.$module['ratio'].'</div>
            </div>
           </div>
           <div>
            <form method="post" action="?action=set&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId'].'">
             '.$gl['resources'][$module['inputResource']]['name'].' <input class="textbox numeric" type="text" name="input" style="width: 40px;" autocomplete="off" value="'.$node->modules[$sid]['input'].'">
             <input class="button" type="submit" value="'.$ui['set'].'">
            </form>
           </div>
           <div>
            <div class="inline">
             <div class="cell">'.$ui['research'].' '.$ui['speed'].' '.$ui['bonus'].': </div>
             <div class="cell">'.$totalIR.'</div>
            </div>
           </div>
           <div>
            <div style="text-align: right; border-top: 1px solid black; margin-top: 5px; padding-top: 5px;"><a class="link" href="module.php?action=remove&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId'].'">'.$ui['removeModule'].'</a></div>
           </div>
          </div>
         </div>';
       if (count($node->queue['research']))
       {
        echo '<div class="container" style="text-align: right; padding: 5px 0; margin: 5px 0; border-top: 1px solid black;">';
        foreach ($node->queue['research'] as $item)
        {
         $remaining=$item['start']+$item['duration']*60-time();
         echo '<div>'.$gl['technologies'][$node->data['faction']][$item['technology']]['name'].' <span id="research_'.$item['node'].'_'.$item['technology'].'">'.implode(':', misc::sToHMS($remaining)).'</span><script type="text/javascript">timedJump("research_'.$item['node'].'_'.$item['technology'].'", "module.php?action=get&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId'].'");</script> | <a class="link" href="module.php?action=cancelTechnology&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId'].'&technologyId='.$item['technology'].'">x</a></div>';
        }
        echo '</div>';
       }
       echo '<div style="border-bottom: 1px solid black;"><div>';
       $tc=0;
       foreach ($node->technologies as $key=>$technology)
       {
        echo '<div class="cell">'.$technology['value'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/technologies/'.$node->data['faction'].'/'.$key.'.png" title="'.$gl['technologies'][$node->data['faction']][$key]['name'].'"></div>';
        $tc++;
        if ($tc==9) echo '</div><div>';
       }
       echo '</div></div>';
       echo '<div style="text-align: center;">';
       foreach ($game['technologies'][$node->data['faction']] as $tid=>$technology)
        if (in_array($tid, $game['modules'][$node->data['faction']][$mid]['technologies']))
        {
         $costData='';
         foreach ($technology['cost'] as $key=>$cost)
          $costData.='<div class="cell">'.($cost['value']*$game['users']['cost']['train']).'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$cost['resource'].'.png" title="'.$gl['resources'][$cost['resource']]['name'].'"></div>';
         if (!count($technology['requirements'])) $requirementsData=$ui['none'];
         else
         {
          $requirementsData='';
          foreach ($technology['requirements'] as $key=>$requirement)
           $requirementsData.='<div class="cell">'.$requirement['value'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/'.$requirement['type'].'/'.$node->data['faction'].'/'.$requirement['id'].'.png" title="'.$ui[$requirement['type']].' - '.$gl[$requirement['type']][$node->data['faction']][$requirement['id']]['name'].'"></div>';
         }
         echo '
          <div style="padding: 5px; border-bottom: 1px solid black; text-align: left;">
           <div>
            <div class="cell"><img class="item" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/technologies/'.$node->data['faction'].'/'.$tid.'.png" /></div>
            <div class="cell" style="max-width: 400px;">
             <div><div class="cell" style="font-weight: bold;">'.$gl['technologies'][$node->data['faction']][$tid]['name'].'</div></div>
             <div><div class="cell">'.$gl['technologies'][$node->data['faction']][$tid]['description'].'</div></div>
             <div><div class="inline"><div class="cell">'.$ui['maxTier'].': </div><div class="cell">'.$technology['maxTier'].'</div></div></div>
             <div><div class="inline"><div class="cell">'.$ui['duration'].': </div><div class="cell">'.(($technology['duration']-$technology['duration']*$totalIR)*$game['users']['speed']['research']).' '.$ui['minutes'].'</div></div></div>
             <div><div class="inline"><div class="cell">'.$ui['cost'].': </div><div class="cell">'.$costData.'</div></div></div>
             <div><div class="inline"><div class="cell">'.$ui['requirements'].': </div><div class="cell">'.$requirementsData.'</div></div></div>
            </div>
            <div><a class="link" href="module.php?action=addTechnology&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId'].'&technologyId='.$tid.'">'.$ui['research'].'</a></div>
           </div>
          </div>
         ';
        }
       echo '</div>';
      break;
      case 'craft':
       echo '
         <div>
          <div class="cell"><div class="module" style="background-image: url(\'templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/modules/'.$node->data['faction'].'/moduleBackground.jpg\');"><img style="width: 300px;" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/modules/'.$node->data['faction'].'/'.$mid.'.png" /></div></div>
          <div class="cell">
           <div><div class="cell" style="font-weight: bold;">'.$gl['modules'][$node->data['faction']][$mid]['name'].'</div></div>
           <div><div class="cell">'.$gl['modules'][$node->data['faction']][$mid]['description'].'</div></div>
           <div>
            <div class="inline">
             <div class="cell">'.$ui['maxInput'].': </div>
             <div class="cell">'.$module['maxInput'].'</div>
            </div>
           </div>
           <div>
            <div class="inline">
             <div class="cell">'.$ui['ratio'].': </div>
             <div class="cell">'.$module['ratio'].'</div>
            </div>
           </div>
           <div>
            <form method="post" action="?action=set&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId'].'">
             '.$gl['resources'][$module['inputResource']]['name'].' <input class="textbox numeric" type="text" name="input" style="width: 40px;" autocomplete="off" value="'.$node->modules[$sid]['input'].'">
             <input class="button" type="submit" value="'.$ui['set'].'">
            </form>
           </div>
           <div>
            <div class="inline">
             <div class="cell">'.$ui['craft'].' '.$ui['speed'].' '.$ui['bonus'].': </div>
             <div class="cell">'.$totalIR.'</div>
            </div>
           </div>
           <div>
            <div style="text-align: right; border-top: 1px solid black; margin-top: 5px; padding-top: 5px;"><a class="link" href="module.php?action=remove&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId'].'">'.$ui['removeModule'].'</a></div>
           </div>
          </div>
         </div>';
       if (count($node->queue['craft']))
       {
        echo '<div class="container" style="text-align: right; padding: 5px 0; margin: 5px 0; border-top: 1px solid black;">';
        foreach ($node->queue['craft'] as $item)
        {
         if (!$item['stage']) $stage=$ui['add'];
         else $stage=$ui['remove'];
         $remaining=$item['start']+$item['duration']*60-time();
         echo '<div>'.$stage.' '.$item['quantity'].' '.$gl['components'][$node->data['faction']][$item['component']]['name'].' <span id="craft_'.$item['id'].'">'.implode(':', misc::sToHMS($remaining)).'</span><script type="text/javascript">timedJump("craft_'.$item['id'].'", "module.php?action=get&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId'].'");</script> | <a class="link" href="module.php?action=cancelComponent&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId'].'&craftId='.$item['id'].'">x</a></div>';
        }
        echo '</div>';
       }
       echo '<div style="border-bottom: 1px solid black;"><div>';
       $cc=0;
       foreach ($node->components as $key=>$component)
       {
        echo '<div class="cell">'.$component['value'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/components/'.$node->data['faction'].'/'.$key.'.png" title="'.$gl['components'][$node->data['faction']][$key]['name'].'"></div>';
        $cc++;
        if ($cc==9) echo '</div><div>';
       }
       echo '</div></div>';
       echo '<div style="text-align: center;">';
       foreach ($game['components'][$node->data['faction']] as $cid=>$component)
        if (in_array($cid, $game['modules'][$node->data['faction']][$mid]['components']))
        {
         $costData='';
         foreach ($component['cost'] as $key=>$cost)
          $costData.='<div class="cell">'.($cost['value']*$game['users']['cost']['train']).'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$cost['resource'].'.png" title="'.$gl['resources'][$cost['resource']]['name'].'"></div>';
         if (!count($component['requirements'])) $requirementsData=$ui['none'];
         else
         {
          $requirementsData='';
          foreach ($component['requirements'] as $key=>$requirement)
           $requirementsData.='<div class="cell">'.$requirement['value'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/'.$requirement['type'].'/'.$node->data['faction'].'/'.$requirement['id'].'.png" title="'.$ui[$requirement['type']].' - '.$gl[$requirement['type']][$node->data['faction']][$requirement['id']]['name'].'"></div>';
         }
         echo '
          <div style="padding: 5px; border-bottom: 1px solid black; text-align: left;">
           <div>
            <div class="cell"><img class="item" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/components/'.$node->data['faction'].'/'.$cid.'.png" /></div>
            <div class="cell" style="max-width: 400px;">
             <div><div class="cell" style="font-weight: bold;">'.$gl['components'][$node->data['faction']][$cid]['name'].'</div></div>
             <div><div class="cell">'.$gl['components'][$node->data['faction']][$cid]['description'].'</div></div>
             <div><div class="inline"><div class="cell">'.$ui['duration'].': </div><div class="cell">'.(($component['duration']-$component['duration']*$totalIR)*$game['users']['speed']['craft']).' '.$ui['minutes'].'</div></div></div>
             <div><div class="inline"><div class="cell">'.$ui['storage'].': </div><div class="cell">'.$component['storage'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$component['storageResource'].'.png" title="'.$gl['resources'][$component['storageResource']]['name'].'"></div></div></div>
             <div><div class="inline"><div class="cell">'.$ui['cost'].': </div><div class="cell">'.$costData.'</div></div></div>
             <div><div class="inline"><div class="cell">'.$ui['requirements'].': </div><div class="cell">'.$requirementsData.'</div></div></div>
            </div>
            <form method="post" action="?action=addComponent&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId'].'&componentId='.$cid.'" id="componentForm_'.$cid.'" style="margin: 0px;">
             <select class="dropdown" onChange="document.getElementById(\'componentForm_'.$cid.'\').action=this.value"><option value="?action=addComponent&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId'].'&componentId='.$cid.'">'.$ui['craft'].'</option><option value="?action=removeComponent&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId'].'&componentId='.$cid.'">'.$ui['remove'].'</option></select>
             <input class="textbox numeric" type="text" name="quantity" value="0" style="width: 40px;">
             <input class="button" type="submit" value="'.$ui['go'].'">
            </form>
           </div>
          </div>
         ';
        }
       echo '</div>';
      break;
      case 'train':
       echo '
         <div>
          <div class="cell"><div class="module" style="background-image: url(\'templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/modules/'.$node->data['faction'].'/moduleBackground.jpg\');"><img style="width: 300px;" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/modules/'.$node->data['faction'].'/'.$mid.'.png" /></div></div>
          <div class="cell">
           <div><div class="cell" style="font-weight: bold;">'.$gl['modules'][$node->data['faction']][$mid]['name'].'</div></div>
           <div><div class="cell">'.$gl['modules'][$node->data['faction']][$mid]['description'].'</div></div>
           <div>
            <div class="inline">
             <div class="cell">'.$ui['maxInput'].': </div>
             <div class="cell">'.$module['maxInput'].'</div>
            </div>
           </div>
           <div>
            <div class="inline">
             <div class="cell">'.$ui['ratio'].': </div>
             <div class="cell">'.$module['ratio'].'</div>
            </div>
           </div>
           <div>
            <form method="post" action="?action=set&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId'].'">
             '.$gl['resources'][$module['inputResource']]['name'].' <input class="textbox numeric" type="text" name="input" style="width: 40px;" autocomplete="off" value="'.$node->modules[$sid]['input'].'">
             <input class="button" type="submit" value="'.$ui['set'].'">
            </form>
           </div>
           <div>
            <div class="inline">
             <div class="cell">'.$ui['craft'].' '.$ui['speed'].' '.$ui['bonus'].': </div>
             <div class="cell">'.$totalIR.'</div>
            </div>
           </div>
           <div>
            <div style="text-align: right; border-top: 1px solid black; margin-top: 5px; padding-top: 5px;"><a class="link" href="module.php?action=remove&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId'].'">'.$ui['removeModule'].'</a></div>
           </div>
          </div>
         </div>';
       if (count($node->queue['train']))
       {
        echo '<div class="container" style="text-align: right; padding: 5px 0; margin: 5px 0; border-top: 1px solid black;">';
        foreach ($node->queue['train'] as $item)
        {
         if (!$item['stage']) $stage=$ui['add'];
         else $stage=$ui['remove'];
         $remaining=$item['start']+$item['duration']*60-time();
         echo '<div>'.$stage.' '.$item['quantity'].' '.$gl['units'][$node->data['faction']][$item['unit']]['name'].' <span id="train_'.$item['id'].'">'.implode(':', misc::sToHMS($remaining)).'</span><script type="text/javascript">timedJump("train_'.$item['id'].'", "module.php?action=get&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId'].'");</script> | <a class="link" href="module.php?action=cancelUnit&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId'].'&trainId='.$item['id'].'">x</a></div>';
        }
        echo '</div>';
       }
       echo '<div style="border-bottom: 1px solid black;"><div>';
       $uc=0;
       foreach ($node->units as $key=>$unit)
       {
        echo '<div class="cell">'.$unit['value'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/units/'.$node->data['faction'].'/'.$key.'.png" title="'.$gl['units'][$node->data['faction']][$key]['name'].'"></div>';
        $uc++;
        if ($uc==9) echo '</div><div>';
       }
       echo '</div></div>';
       echo '<div style="text-align: center;">';
       foreach ($game['units'][$node->data['faction']] as $uid=>$unit)
        if (in_array($uid, $game['modules'][$node->data['faction']][$mid]['units']))
        {
         $costData='';
         foreach ($unit['cost'] as $key=>$cost)
          $costData.='<div class="cell">'.($cost['value']*$game['users']['cost']['train']).'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$cost['resource'].'.png" title="'.$gl['resources'][$cost['resource']]['name'].'"></div>';
         if (!count($unit['requirements'])) $requirementsData=$ui['none'];
         else
         {
          $requirementsData='';
          foreach ($unit['requirements'] as $key=>$requirement)
           $requirementsData.='<div class="cell">'.$requirement['value'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/'.$requirement['type'].'/'.$node->data['faction'].'/'.$requirement['id'].'.png" title="'.$ui[$requirement['type']].' - '.$gl[$requirement['type']][$node->data['faction']][$requirement['id']]['name'].'"></div>';
         }
         echo '
          <div style="padding: 5px; border-bottom: 1px solid black; text-align: left;">
           <div>
            <div class="cell"><img class="item" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/units/'.$node->data['faction'].'/'.$uid.'.png" /></div>
            <div class="cell" style="max-width: 400px;">
             <div><div class="cell" style="font-weight: bold;">'.$gl['units'][$node->data['faction']][$uid]['name'].'</div></div>
             <div><div class="cell">'.$gl['units'][$node->data['faction']][$uid]['description'].'</div></div>
             <div><div class="cell">'.$ui['class'].': '.$gl['classes'][$unit['class']].'</div></div>
             <div><div class="inline"><div class="cell">'.$ui['hp'].': '.$unit['hp'].', '.$ui['damage'].': '.$unit['damage'].', '.$ui['armor'].': '.$unit['armor'].'</div></div></div>
             <div><div class="inline"><div class="cell">'.$ui['speed'].': '.$unit['speed'].'</div></div></div>
             <div><div class="inline"><div class="cell">'.$ui['duration'].': </div><div class="cell">'.(($unit['duration']-$unit['duration']*$totalIR)*$game['users']['speed']['train']).' '.$ui['minutes'].'</div></div></div>
             <div><div class="inline"><div class="cell">'.$ui['upkeep'].': </div><div class="cell">'.$unit['upkeep'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$unit['upkeepResource'].'.png" title="'.$gl['resources'][$unit['upkeepResource']]['name'].'"></div></div></div>
             <div><div class="inline"><div class="cell">'.$ui['cost'].': </div><div class="cell">'.$costData.'</div></div></div>
             <div><div class="inline"><div class="cell">'.$ui['requirements'].': </div><div class="cell">'.$requirementsData.'</div></div></div>
            </div>
            <form method="post" action="?action=addUnit&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId'].'&unitId='.$uid.'" id="unitForm_'.$uid.'" style="margin: 0px;">
             <select class="dropdown" onChange="document.getElementById(\'unitForm_'.$uid.'\').action=this.value"><option value="?action=addUnit&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId'].'&unitId='.$uid.'">'.$ui['train'].'</option><option value="?action=removeUnit&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId'].'&unitId='.$uid.'">'.$ui['remove'].'</option></select>
             <input class="textbox numeric" type="text" name="quantity" value="0" style="width: 40px;">
             <input class="button" type="submit" value="'.$ui['go'].'">
            </form>
           </div>
          </div>
         ';
        }
       echo '</div>';
      break;
     }
     echo '</div></div>';
    }
   }
  break;
  case "list":
   if (isset($node->modules[$_GET['slotId']]))
   {
    echo '<div class="container"><div class="content" style="text-align: left;">';
    include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/resources.php';
    foreach ($game['modules'][$node->data['faction']] as $mid=>$module)
    {
     $costData='';
     foreach ($module['cost'] as $key=>$cost)
      $costData.='<div class="cell">'.($cost['value']*$game['users']['cost']['train']).'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$cost['resource'].'.png" title="'.$gl['resources'][$cost['resource']]['name'].'"></div>';
     if (!count($module['requirements'])) $requirementsData=$ui['none'];
     else
     {
      $requirementsData='';
      foreach ($module['requirements'] as $key=>$requirement)
       $requirementsData.='<div class="cell">'.$requirement['value'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/'.$requirement['type'].'/'.$node->data['faction'].'/'.$requirement['id'].'.png" title="'.$ui[$requirement['type']].' - '.$gl[$requirement['type']][$node->data['faction']][$requirement['id']]['name'].'"></div>';
     }
     $outputData='';
     switch ($module['type'])
     {
      case 'harvest':
       $outputData='<img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$module['outputResource'].'.png" title="'.$gl['resources'][$module['outputResource']]['name'].'">';
      break;
      case 'research':
       foreach ($module['technologies'] as $technology)
        $outputData.='<img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/technologies/'.$node->data['faction'].'/'.$technology.'.png" title="'.$gl['technologies'][$node->data['faction']][$technology]['name'].'">';
      break;
      case 'craft':
       foreach ($module['components'] as $component)
        $outputData.='<img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/components/'.$node->data['faction'].'/'.$component.'.png" title="'.$gl['components'][$node->data['faction']][$component]['name'].'">';
      break;
      case 'train':
       foreach ($module['units'] as $unit)
        $outputData.='<img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/units/'.$node->data['faction'].'/'.$unit.'.png" title="'.$gl['units'][$node->data['faction']][$unit]['name'].'">';
      break;
      default:
       $outputData=$ui['none'];
      break;
     }
     echo '
      <div style="padding: 5px; border-bottom: 1px solid black;">
       <div class="cell"><div class="module" style="background-image: url(\'templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/modules/'.$node->data['faction'].'/moduleBackground.jpg\');"><img style="width: 300px;" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/modules/'.$node->data['faction'].'/'.$mid.'.png" /></div></div>
       <div class="cell">
        <div><div class="cell" style="font-weight: bold;">'.$gl['modules'][$node->data['faction']][$mid]['name'].'</div></div>
        <div><div class="cell">'.$gl['modules'][$node->data['faction']][$mid]['description'].'</div></div>
        <div>
         <div class="inline">
          <div class="cell">'.$ui['input'].': </div>
          <div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$module['inputResource'].'.png" title="'.$gl['resources'][$module['inputResource']]['name'].'"></div>
         </div>
        </div>
        <div>
         <div class="inline">
          <div class="cell">'.$ui['ratio'].': </div>
          <div class="cell">'.$module['ratio'].'</div>
         </div>
        </div>
        <div>
         <div class="inline">
          <div class="cell">'.$ui['maxInput'].': </div>
          <div class="cell">'.$module['maxInput'].'</div>
         </div>
        </div>
        <div>
         <div class="inline">
          <div class="cell">'.$ui['maxInstances'].': </div>
          <div class="cell">'.$module['maxInstances'].'</div>
         </div>
        </div>
        <div>
         <div class="inline">
          <div class="cell">'.$ui['duration'].': </div>
          <div class="cell">'.($module['duration']*$game['users']['speed']['build']).' '.$ui['minutes'].'</div>
         </div>
        </div>
        <div>
         <div class="inline">
          <div class="cell">'.$ui['salvage'].': </div>
          <div class="cell">'.$module['salvage'].'</div>
         </div>
        </div>
        <div>
         <div class="inline">
          <div class="cell">'.$ui['removeDuration'].': </div>
          <div class="cell">'.($module['removeDuration']*$game['users']['speed']['build']).' '.$ui['minutes'].'</div>
         </div>
        </div>
        <div>
         <div class="inline">
          <div class="cell">'.$ui['cost'].': </div>
          <div class="cell">'.$costData.'</div>
         </div>
        </div>
        <div><div>'.$ui['requirements'].$requirementsData.'</div></div>
        <div>
         <div>'.$ui['output'].': </div>
         <div>'.$outputData.'</div>
        </div>
       </div>
       <div style="text-align: right;"><a class="link" href="module.php?action=add&nodeId='.$node->data['id'].'&slotId='.$_GET['slotId'].'&moduleId='.$mid.'">'.$ui['addModule'].'</a></div>
      </div>
     ';
    }
    echo '</div></div>';
   }
  break;
 }
?>
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/footer.php'; ?>
 </body>
</html>