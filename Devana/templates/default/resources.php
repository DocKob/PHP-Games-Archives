<?php
$thisPage=explode('/', $_SERVER["PHP_SELF"]);
$thisPage=$thisPage[count($thisPage)-1];
if ($game['factions'][$node->data['faction']]['costs']['move'][0]['resource']>-1)
 $move='<a class="link" href="node.php?action=move&nodeId='.$node->data['id'].'">'.$ui['move'].'</a> |';
else $move='';
echo '
 <div style="padding: 5px; border-bottom: 1px solid black; text-align: right;">
  <span id="label" style="color: white;"></span> | 
  <a class="link" href="node.php?action=get&nodeId='.$node->data['id'].'">'.$node->data['name'].'</a> | 
  <a class="link" href="'.$location.'combat.php?action=add&nodeId='.$node->data['id'].'">'.$ui['combat'].'</a> | 
  <a class="link" href="grid.php?x='.$node->location['x'].'&y='.$node->location['y'].'">'.$ui['grid'].'</a> | 
  <a class="link" href="node.php?action=set&nodeId='.$node->data['id'].'">'.$ui['edit'].'</a> | 
  '.$move.' 
  <a class="link" href="node.php?action=remove&nodeId='.$node->data['id'].'">'.$ui['remove'].'</a>
 </div>';
echo '<div style="text-align: left;">';
foreach ($node->resources as $key=>$resource)
{
 echo '<div class="cell"> | '.floor($resource['value']).'/'.$node->storage[$key];
 if ($node->production[$key]) echo ' (+'.$node->production[$key].$ui['perHour'].')';
 echo '</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$key.'.png" title="'.$gl['resources'][$key]['name'].'"></div>';
 if (($key==2)&&($thisPage!='node.php'))
  echo '</div><div style="border-bottom: 1px solid black; text-align: right;"><div style="display: inline-block;">';
}
echo '</div>';
if ($thisPage!='node.php') echo '</div>';
?>