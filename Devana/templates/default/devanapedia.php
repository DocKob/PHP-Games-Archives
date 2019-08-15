<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <?php echo '<link rel="stylesheet" type="text/css" href="templates/'.$_SESSION[$shortTitle.'User']['template'].'/default.css">'; ?>
  <title><?php echo $title.$ui['separator'].$ui['devanapedia']; ?></title>
  <?php echo $tracker; ?>
 </head>
 <body class="body">
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/header.php'; ?>
 <div class="container">
  <div class="content" style="text-align: left; max-width: 700px;">
   <div style="border-bottom: 1px solid black; padding-bottom: 5px;"><?php echo $ui['view'].' '.$ui[$_GET['view']].' '.$ui['for'].' '.$gl['factions'][$_GET['faction']]['name'].' '.$ui['faction']; ?></div>
   <div style="border-bottom: 1px solid black; padding-bottom: 5px; padding-top: 5px;"><?php echo $ui['view']; ?>: 
    <a class="link" href="devanapedia.php?action=list&view=technologies&faction=<?php echo $_GET['faction']; ?>"><?php echo $ui['technologies']; ?></a> | 
    <a class="link" href="devanapedia.php?action=list&view=modules&faction=<?php echo $_GET['faction']; ?>"><?php echo $ui['modules']; ?></a> | 
    <a class="link" href="devanapedia.php?action=list&view=components&faction=<?php echo $_GET['faction']; ?>"><?php echo $ui['components']; ?></a> | 
    <a class="link" href="devanapedia.php?action=list&view=units&faction=<?php echo $_GET['faction']; ?>"><?php echo $ui['units']; ?></a> | 
    <a class="link" href="devanapedia.php?action=list&view=classes&faction=<?php echo $_GET['faction']; ?>"><?php echo $ui['classes']; ?></a>
   </div>
<?php
if ($_GET['view']!='classes')
{
 echo '<div style="border-bottom: 1px solid black; padding-bottom: 5px; padding-top: 5px;">'.$ui['faction'].': ';
 $nr=count($gl['factions']);
 foreach ($gl['factions'] as $key=>$faction)
 {
  if (isset($_GET['id'])) $showId='&id='.$_GET['id'];
  else $showId='';
  echo '<a class="link" href="devanapedia.php?action='.$_GET['action'].'&view='.$_GET['view'].'&faction='.$key.$showId.'">'.$faction['name'].'</a>';
  if ($key<$nr-1) echo ' | ';
 }
 echo '</div>';
}
if (isset($_GET['action'], $_GET['view'], $_GET['faction']))
{
 echo '<div style="border-bottom: 1px solid black; padding-bottom: 5px; padding-top: 5px;"><div class="cell">'.$ui['storage'].':</div>';
 foreach ($game['factions'][$_GET['faction']]['storage'] as $key=>$storage)
  echo '<div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$key.'.png" title="'.$gl['resources'][$key]['name'].'"></div><div class="cell">'.$storage.'</div>';
 echo '</div>';
 if ($_GET['action']=='list')
  switch ($_GET['view'])
  {
   case 'technologies':
    foreach ($game['technologies'][$_GET['faction']] as $tid=>$technology)
    {
     $costData='';
     foreach ($technology['cost'] as $key=>$cost)
      $costData.='<div class="cell">'.($cost['value']*$game['users']['cost']['train']).'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$cost['resource'].'.png" title="'.$gl['resources'][$cost['resource']]['name'].'"></div>';
     if (!count($technology['requirements'])) $requirementsData=$ui['none'];
     else
     {
      $requirementsData='';
      foreach ($technology['requirements'] as $key=>$requirement)
       $requirementsData.='<div class="cell">'.$requirement['value'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/'.$requirement['type'].'/'.$_GET['faction'].'/'.$requirement['id'].'.png" title="'.$ui[$requirement['type']].' - '.$gl[$requirement['type']][$_GET['faction']][$requirement['id']]['name'].'"></div>';
     }
     echo '
      <div style="padding: 5px; border-bottom: 1px solid black; text-align: left;">
       <div class="cell"><img style="width: 60px;" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/technologies/'.$_GET['faction'].'/'.$tid.'.png" /></div>
       <div class="cell">
        <div><div class="cell" style="font-weight: bold;"><a class="link" href="devanapedia.php?action=get&view=technologies&faction='.$_GET['faction'].'&id='.$tid.'">'.$gl['technologies'][$_GET['faction']][$tid]['name'].'</a></div></div>
        <div><div class="cell">'.$gl['technologies'][$_GET['faction']][$tid]['description'].'</div></div>
        <div><div class="inline"><div class="cell">'.$ui['maxTier'].': </div><div class="cell">'.$technology['maxTier'].'</div></div></div>
        <div><div class="inline"><div class="cell">'.$ui['duration'].': </div><div class="cell">'.($technology['duration']*$game['users']['speed']['research']).' '.$ui['minutes'].'</div></div></div>
        <div><div class="inline"><div class="cell">'.$ui['cost'].': </div><div class="cell">'.$costData.'</div></div></div>
        <div><div class="inline"><div class="cell">'.$ui['requirements'].': </div><div class="cell">'.$requirementsData.'</div></div></div>
       </div>
      </div>
     ';
    }
   break;
   case 'modules':
    foreach ($game['modules'][$_GET['faction']] as $mid=>$module)
    {
     $costData='';
     foreach ($module['cost'] as $key=>$cost)
      $costData.='<div class="cell">'.($cost['value']*$game['users']['cost']['train']).'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$cost['resource'].'.png" title="'.$gl['resources'][$cost['resource']]['name'].'"></div>';
     if (!count($module['requirements'])) $requirementsData=$ui['none'];
     else
     {
      $requirementsData='';
      foreach ($module['requirements'] as $key=>$requirement)
       $requirementsData.='<div class="cell">'.$requirement['value'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/'.$requirement['type'].'/'.$_GET['faction'].'/'.$requirement['id'].'.png" title="'.$ui[$requirement['type']].' - '.$gl[$requirement['type']][$_GET['faction']][$requirement['id']]['name'].'"></div>';
     }
     $outputData='';
     switch ($module['type'])
     {
      case 'harvest':
       $outputData='<img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$module['outputResource'].'.png" title="'.$gl['resources'][$module['outputResource']]['name'].'">';
      break;
      case 'research':
       foreach ($module['technologies'] as $technology)
        $outputData.='<img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/technologies/'.$_GET['faction'].'/'.$technology.'.png" title="'.$gl['technologies'][$_GET['faction']][$technology]['name'].'">';
      break;
      case 'craft':
       foreach ($module['components'] as $component)
        $outputData.='<img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/components/'.$_GET['faction'].'/'.$component.'.png" title="'.$gl['components'][$_GET['faction']][$component]['name'].'">';
      break;
      case 'train':
       foreach ($module['units'] as $unit)
        $outputData.='<img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/units/'.$_GET['faction'].'/'.$unit.'.png" title="'.$gl['units'][$_GET['faction']][$unit]['name'].'">';
      break;
      default:
       $outputData=$ui['none'];
      break;
     }
     echo '
      <div style="padding: 5px; border-bottom: 1px solid black; text-align: left;">
       <div class="cell"><div class="module" style="background-image: url(\'templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/modules/'.$_GET['faction'].'/moduleBackground.jpg\');"><img style="width: 300px;" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/modules/'.$_GET['faction'].'/'.$mid.'.png" /></div></div>
       <div class="cell">
        <div><div class="cell" style="font-weight: bold;"><a class="link" href="devanapedia.php?action=get&view=modules&faction='.$_GET['faction'].'&id='.$mid.'">'.$gl['modules'][$_GET['faction']][$mid]['name'].'</a></div></div>
        <div><div class="cell">'.$gl['modules'][$_GET['faction']][$mid]['description'].'</div></div>
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
      </div>
     ';
    }
   break;
   case 'components':
    foreach ($game['components'][$_GET['faction']] as $cid=>$component)
    {
     $costData='';
     foreach ($component['cost'] as $key=>$cost)
      $costData.='<div class="cell">'.($cost['value']*$game['users']['cost']['train']).'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$cost['resource'].'.png" title="'.$gl['resources'][$cost['resource']]['name'].'"></div>';
     if (!count($component['requirements'])) $requirementsData=$ui['none'];
     else
     {
      $requirementsData='';
      foreach ($component['requirements'] as $key=>$requirement)
       $requirementsData.='<div class="cell">'.$requirement['value'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/'.$requirement['type'].'/'.$_GET['faction'].'/'.$requirement['id'].'.png" title="'.$ui[$requirement['type']].' - '.$gl[$requirement['type']][$_GET['faction']][$requirement['id']]['name'].'"></div>';
     }
     echo '
      <div style="padding: 5px; border-bottom: 1px solid black; text-align: left;">
       <div class="cell"><img style="width: 60px;" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/components/'.$_GET['faction'].'/'.$cid.'.png" /></div>
       <div class="cell">
        <div><div class="cell" style="font-weight: bold;"><a class="link" href="devanapedia.php?action=get&view=components&faction='.$_GET['faction'].'&id='.$cid.'">'.$gl['components'][$_GET['faction']][$cid]['name'].'</a></div></div>
        <div><div class="cell">'.$gl['components'][$_GET['faction']][$cid]['description'].'</div></div>
        <div><div class="inline"><div class="cell">'.$ui['duration'].': </div><div class="cell">'.($component['duration']*$game['users']['speed']['craft']).' '.$ui['minutes'].'</div></div></div>
        <div><div class="inline"><div class="cell">'.$ui['storage'].': </div><div class="cell">'.$component['storage'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$component['storageResource'].'.png" title="'.$gl['resources'][$component['storageResource']]['name'].'"></div></div></div>
        <div><div class="inline"><div class="cell">'.$ui['cost'].': </div><div class="cell">'.$costData.'</div></div></div>
        <div><div class="inline"><div class="cell">'.$ui['requirements'].': </div><div class="cell">'.$requirementsData.'</div></div></div>
       </div>
      </div>
     ';
    }
   break;
   case 'units':
    foreach ($game['units'][$_GET['faction']] as $uid=>$unit)
    {
     $costData='';
     foreach ($unit['cost'] as $key=>$cost)
      $costData.='<div class="cell">'.($cost['value']*$game['users']['cost']['train']).'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$cost['resource'].'.png" title="'.$gl['resources'][$cost['resource']]['name'].'"></div>';
     if (!count($unit['requirements'])) $requirementsData=$ui['none'];
     else
     {
      $requirementsData='';
      foreach ($unit['requirements'] as $key=>$requirement)
       $requirementsData.='<div class="cell">'.$requirement['value'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/'.$requirement['type'].'/'.$_GET['faction'].'/'.$requirement['id'].'.png" title="'.$ui[$requirement['type']].' - '.$gl[$requirement['type']][$_GET['faction']][$requirement['id']]['name'].'"></div>';
     }
     echo '
      <div style="padding: 5px; border-bottom: 1px solid black; text-align: left;">
       <div class="cell"><img src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/units/'.$_GET['faction'].'/'.$uid.'.png" /></div>
       <div class="cell">
        <div><div class="cell" style="font-weight: bold;"><a class="link" href="devanapedia.php?action=get&view=units&faction='.$_GET['faction'].'&id='.$uid.'">'.$gl['units'][$_GET['faction']][$uid]['name'].'</a></div></div>
        <div><div class="cell">'.$gl['units'][$_GET['faction']][$uid]['description'].'</div></div>
        <div><div class="cell">'.$ui['class'].': '.$gl['classes'][$unit['class']].'</div></div>
        <div><div class="inline"><div class="cell">'.$ui['hp'].': '.$unit['hp'].', '.$ui['damage'].': '.$unit['damage'].', '.$ui['armor'].': '.$unit['armor'].'</div></div></div>
        <div><div class="inline"><div class="cell">'.$ui['speed'].': '.$unit['speed'].'</div></div></div>
        <div><div class="inline"><div class="cell">'.$ui['duration'].': </div><div class="cell">'.($unit['duration']*$game['users']['speed']['train']).' '.$ui['minutes'].'</div></div></div>
        <div><div class="inline"><div class="cell">'.$ui['upkeep'].': </div><div class="cell">'.$unit['upkeep'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$unit['upkeepResource'].'.png" title="'.$gl['resources'][$unit['upkeepResource']]['name'].'"></div></div></div>
        <div><div class="inline"><div class="cell">'.$ui['cost'].': </div><div class="cell">'.$costData.'</div></div></div>
        <div><div class="inline"><div class="cell">'.$ui['requirements'].': </div><div class="cell">'.$requirementsData.'</div></div></div>
       </div>
      </div>
     ';
    }
   break;
   case 'classes':
    foreach ($game['classes'] as $cid=>$class)
    {
     echo '
      <div style="padding: 5px; border-bottom: 1px solid black; text-align: left;">
      <div><div class="cell" style="font-weight: bold;"><a class="link" href="devanapedia.php?action=get&view=classes&faction='.$_GET['faction'].'&id='.$cid.'">'.$gl['classes'][$cid].'</a></div></div>';
     foreach ($class as $mid=>$mod)
      echo '<div><div class="cell">'.$gl['classes'][$mid].': '.$mod.'</div></div>';
     echo '</div>';
    }
   break;
  }
 else if (($_GET['action']=='get')&&(isset($_GET['id'])))
 {
  switch ($_GET['view'])
  {
   case 'technologies':
    $technology=$game['technologies'][$_GET['faction']][$_GET['id']];
    $tid=$_GET['id'];
    $costData='';
    foreach ($technology['cost'] as $key=>$cost)
     $costData.='<div class="cell">'.($cost['value']*$game['users']['cost']['train']).'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$cost['resource'].'.png" title="'.$gl['resources'][$cost['resource']]['name'].'"></div>';
    if (!count($technology['requirements'])) $requirementsData=$ui['none'];
    else
    {
     $requirementsData='';
     foreach ($technology['requirements'] as $key=>$requirement)
      $requirementsData.='<div class="cell">'.$requirement['value'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/'.$requirement['type'].'/'.$_GET['faction'].'/'.$requirement['id'].'.png" title="'.$ui[$requirement['type']].' - '.$gl[$requirement['type']][$_GET['faction']][$requirement['id']]['name'].'"></div>';
    }
    echo '
     <div style="padding: 5px; border-bottom: 1px solid black; text-align: left;">
      <div class="cell"><img style="width: 60px;" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/technologies/'.$_GET['faction'].'/'.$tid.'.png" /></div>
      <div class="cell">
       <div><div class="cell" style="font-weight: bold;">'.$gl['technologies'][$_GET['faction']][$tid]['name'].'</div></div>
       <div><div class="cell">'.$gl['technologies'][$_GET['faction']][$tid]['description'].'</div></div>
       <div><div class="inline"><div class="cell">'.$ui['maxTier'].': </div><div class="cell">'.$technology['maxTier'].'</div></div></div>
       <div><div class="inline"><div class="cell">'.$ui['duration'].': </div><div class="cell">'.($technology['duration']*$game['users']['speed']['research']).' '.$ui['minutes'].'</div></div></div>
       <div><div class="inline"><div class="cell">'.$ui['cost'].': </div><div class="cell">'.$costData.'</div></div></div>
       <div><div class="inline"><div class="cell">'.$ui['requirements'].': </div><div class="cell">'.$requirementsData.'</div></div></div>
      </div>
     </div>
    ';
   break;
   case 'modules':
    $module=$game['modules'][$_GET['faction']][$_GET['id']];
    $mid=$_GET['id'];
    $costData='';
    foreach ($module['cost'] as $key=>$cost)
     $costData.='<div class="cell">'.($cost['value']*$game['users']['cost']['train']).'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$cost['resource'].'.png" title="'.$gl['resources'][$cost['resource']]['name'].'"></div>';
    if (!count($module['requirements'])) $requirementsData=$ui['none'];
    else
    {
     $requirementsData='';
     foreach ($module['requirements'] as $key=>$requirement)
      $requirementsData.='<div class="cell">'.$requirement['value'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/'.$requirement['type'].'/'.$_GET['faction'].'/'.$requirement['id'].'.png" title="'.$ui[$requirement['type']].' - '.$gl[$requirement['type']][$_GET['faction']][$requirement['id']]['name'].'"></div>';
    }
    echo '
     <div style="padding: 5px; border-bottom: 1px solid black; text-align: left;">
      <div class="cell"><div class="module" style="background-image: url(\'templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/modules/'.$_GET['faction'].'/moduleBackground.jpg\');"><img style="width: 300px;" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/modules/'.$_GET['faction'].'/'.$mid.'.png" /></div></div>
      <div class="cell">
       <div><div class="cell" style="font-weight: bold;">'.$gl['modules'][$_GET['faction']][$mid]['name'].'</div></div>
       <div><div class="cell">'.$gl['modules'][$_GET['faction']][$mid]['description'].'</div></div>
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
      </div>
     </div>
    ';
   break;
   case 'components':
    $component=$game['components'][$_GET['faction']][$_GET['id']];
    $cid=$_GET['id'];
    $costData='';
    foreach ($component['cost'] as $key=>$cost)
     $costData.='<div class="cell">'.($cost['value']*$game['users']['cost']['train']).'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$cost['resource'].'.png" title="'.$gl['resources'][$cost['resource']]['name'].'"></div>';
    if (!count($component['requirements'])) $requirementsData=$ui['none'];
    else
    {
     $requirementsData='';
     foreach ($component['requirements'] as $key=>$requirement)
      $requirementsData.='<div class="cell">'.$requirement['value'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/'.$requirement['type'].'/'.$_GET['faction'].'/'.$requirement['id'].'.png" title="'.$ui[$requirement['type']].' - '.$gl[$requirement['type']][$_GET['faction']][$requirement['id']]['name'].'"></div>';
    }
    echo '
     <div style="padding: 5px; border-bottom: 1px solid black; text-align: left;">
      <div class="cell"><img style="width: 60px;" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/components/'.$_GET['faction'].'/'.$cid.'.png" /></div>
      <div class="cell">
       <div><div class="cell" style="font-weight: bold;">'.$gl['components'][$_GET['faction']][$cid]['name'].'</div></div>
       <div><div class="cell">'.$gl['components'][$_GET['faction']][$cid]['description'].'</div></div>
       <div><div class="inline"><div class="cell">'.$ui['duration'].': </div><div class="cell">'.($component['duration']*$game['users']['speed']['craft']).' '.$ui['minutes'].'</div></div></div>
       <div><div class="inline"><div class="cell">'.$ui['storage'].': </div><div class="cell">'.$component['storage'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$component['storageResource'].'.png" title="'.$gl['resources'][$component['storageResource']]['name'].'"></div></div></div>
       <div><div class="inline"><div class="cell">'.$ui['cost'].': </div><div class="cell">'.$costData.'</div></div></div>
       <div><div class="inline"><div class="cell">'.$ui['requirements'].': </div><div class="cell">'.$requirementsData.'</div></div></div>
      </div>
     </div>
    ';
   break;
   case 'units':
    $unit=$game['units'][$_GET['faction']][$_GET['id']];
    $uid=$_GET['id'];
    $costData='';
    foreach ($unit['cost'] as $key=>$cost)
     $costData.='<div class="cell">'.($cost['value']*$game['users']['cost']['train']).'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$cost['resource'].'.png" title="'.$gl['resources'][$cost['resource']]['name'].'"></div>';
    if (!count($unit['requirements'])) $requirementsData=$ui['none'];
    else
    {
     $requirementsData='';
     foreach ($unit['requirements'] as $key=>$requirement)
      $requirementsData.='<div class="cell">'.$requirement['value'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/'.$requirement['type'].'/'.$_GET['faction'].'/'.$requirement['id'].'.png" title="'.$ui[$requirement['type']].' - '.$gl[$requirement['type']][$_GET['faction']][$requirement['id']]['name'].'"></div>';
    }
    echo '
     <div style="padding: 5px; border-bottom: 1px solid black; text-align: left;">
      <div class="cell"><img style="width: 60px;" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/units/'.$_GET['faction'].'/'.$uid.'.png" /></div>
      <div class="cell">
       <div><div class="cell" style="font-weight: bold;"><a class="link" href="devanapedia.php?action=get&view=units&faction='.$_GET['faction'].'&id='.$uid.'">'.$gl['units'][$_GET['faction']][$uid]['name'].'</a></div></div>
       <div><div class="cell">'.$gl['units'][$_GET['faction']][$uid]['description'].'</div></div>
       <div><div class="inline"><div class="cell">'.$ui['hp'].': '.$unit['hp'].', '.$ui['damage'].': '.$unit['damage'].', '.$ui['armor'].': '.$unit['armor'].'</div></div></div>
       <div><div class="inline"><div class="cell">'.$ui['duration'].': </div><div class="cell">'.($unit['duration']*$game['users']['speed']['train']).' '.$ui['minutes'].'</div></div></div>
       <div><div class="inline"><div class="cell">'.$ui['upkeep'].': </div><div class="cell">'.$unit['upkeep'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$unit['upkeepResource'].'.png" title="'.$gl['resources'][$unit['upkeepResource']]['name'].'"></div></div></div>
       <div><div class="inline"><div class="cell">'.$ui['cost'].': </div><div class="cell">'.$costData.'</div></div></div>
       <div><div class="inline"><div class="cell">'.$ui['requirements'].': </div><div class="cell">'.$requirementsData.'</div></div></div>
      </div>
     </div>
    ';
   break;
   case 'classes':
    echo '
     <div style="padding: 5px; border-bottom: 1px solid black; text-align: left;">
     <div><div class="cell" style="font-weight: bold;"><a class="link" href="devanapedia.php?action=get&view=classes&faction='.$_GET['faction'].'&id='.$_GET['id'].'">'.$gl['classes'][$_GET['id']].'</a></div></div>';
    foreach ($game['classes'][$_GET['id']] as $mid=>$mod)
     echo '<div><div class="cell">'.$gl['classes'][$mid].': '.$mod.'</div></div>';
    echo '</div>';
   break;
  }
 }
}
?>
  </div>
 </div>
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/footer.php'; ?>
 </body>
</html>