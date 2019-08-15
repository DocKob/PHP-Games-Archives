<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <?php echo '<link rel="stylesheet" type="text/css" href="templates/'.$_SESSION[$shortTitle.'User']['template'].'/default.css">'; ?>
  <title>
<?php
echo $title;
if (isset($ui[$_GET['action']])) echo $ui['separator'].$ui['alliance'].$ui['separator'].$ui[$_GET['action']];
else echo $ui['separator'].$ui['alliance'];
?>
  </title>
  <?php echo $tracker; ?>
 </head>
 <body class="body">
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/header.php'; ?>
<?php
if (isset($_SESSION[$shortTitle.'User']['id'], $_GET['action']))
{
 echo '<div class="container"><div class="content" style="text-align: left;">';
 if ($_SESSION[$shortTitle.'User']['alliance'])
 {
  echo '
   <div class="section">
    <a class="link" href="alliance.php?action=get">'.$alliance->data['name'].'</a> | ';
  if ($alliance->data['user']==$_SESSION[$shortTitle.'User']['id']) echo '
    <a class="link" href="alliance.php?action=set">'.$ui['set'].'</a> | 
    <a class="link" href="alliance.php?action=remove">'.$ui['remove'].'</a>';
  echo '</div>';
 }
 switch ($_GET['action'])
 {
  case 'get':
   if (isset($alliance->data['id']))
   {
    if ($alliance->members)
    {
     echo '<div class="section"> -> '.$ui['members'].'</div>';
     foreach ($alliance->members as $member)
     {
      echo '<div class="right">'.$member['name'];
      if (($alliance->data['user']==$_SESSION[$shortTitle.'User']['id'])||($member['id']==$_SESSION[$shortTitle.'User']['id']))
       echo ' | <a class="link" href="?action=removeMember&user='.$member['id'].'">x</a>';
      echo '</div>';
     }
    }
    if ($alliance->data['user']==$_SESSION[$shortTitle.'User']['id'])
     echo '<div class="section" style="margin-top: 5px;"> -> '.$ui['invitations'].' | <a class="link" href="?action=addInvitation">'.$ui['invite'].'</a></div>';
    foreach ($alliance->invitations as $invitation)
    {
     $user=new user();
     if ($user->get('id', $invitation['user'])=='done')
     {
      $accept='';
      $removeLabel='x';
      if ($user->data['id']==$_SESSION[$shortTitle.'User']['id'])
      {
       $accept='<a class="link" href="?action=acceptInvitation&alliance='.$invitation['alliance'].'&user='.$invitation['user'].'">'.$ui['accept'].'</a> | ';
       $removeLabel=$ui['decline'];
      }
      echo '<div class="right"> '.$user->data['name'].' | '.$accept.'<a class="link" href="?action=removeInvitation&alliance='.$invitation['alliance'].'&user='.$invitation['user'].'">'.$removeLabel.'</a></div>';
     }
    }
    if ($alliance->data['user']==$_SESSION[$shortTitle.'User']['id'])
     echo '<div class="section" style="margin-top: 5px;"> -> '.$ui['wars'].' | <a class="link" href="?action=addWar">'.$ui['goToWar'].'</a></div>';
    foreach ($alliance->wars as $war)
    {
     $otherAlliance=new alliance();
     if ($alliance->data['id']==$war['sender']) $otherAllianceId=$war['recipient'];
     else $otherAllianceId=$war['sender'];
     if ($otherAlliance->get('id', $otherAllianceId)=='done')
      if ($war['type']) echo '<div class="right">'.$otherAlliance->data['name'].' | <a class="link" href="?action=proposePeace&recipient='.$otherAlliance->data['id'].'">'.$ui['peace'].'</a></div>';
      else
      {
       if ($alliance->data['id']==$war['recipient']) $ad='<a class="link" href="?action=acceptPeace&sender='.$war['sender'].'&recipient='.$war['recipient'].'">'.$ui['accept'].'</a> / <a class="link" href="?action=removePeace&recipient='.$otherAlliance->data['id'].'">'.$ui['decline'].'</a>';
       else $ad='<a class="link" href="?action=removePeace&recipient='.$otherAlliance->data['id'].'">x</a>';
       echo '<div class="right">'.$otherAlliance->data['name'].' '.$ui['peace'].' | '.$ad.'</div>';
      }
    }
   }
   else
   {
    echo '<div class="section"><a class="link" href="?action=add">'.$ui['add'].'</a></div>';
    if ($invitations)
    {
     echo '<div class="section"> -> '.$ui['invitations'].'</div>';
     foreach ($invitations as $invitation)
     {
      $user=new user();
      if ($user->get('id', $invitation['user'])=='done')
      {
       $accept='';
       $removeLabel='x';
       if ($user->data['id']==$_SESSION[$shortTitle.'User']['id'])
       {
        $accept='<a class="link" href="?action=acceptInvitation&alliance='.$invitation['alliance'].'&user='.$invitation['user'].'">'.$ui['accept'].'</a> | ';
        $removeLabel=$ui['decline'];
       }
       echo '<div class="right"> '.$user->data['name'].' | '.$accept.'<a class="link" href="?action=removeInvitation&alliance='.$invitation['alliance'].'&user='.$invitation['user'].'">'.$removeLabel.'</a></div>';
      }
     }
    }
   }
  break;
  case 'set':
   if (isset($alliance->data['id']))
   {
    $costData='';
     foreach ($game['factions'][$node->data['faction']]['costs']['alliance'] as $key=>$cost)
      $costData.='<div class="cell">'.$cost['value'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$cost['resource'].'.png" title="'.$gl['resources'][$cost['resource']]['name'].'"></div>';
    echo '
     <form method="post" action="?action=set">
     <div><div class="cell">'.$ui['node'].'</div><div class="cell"><select class="dropdown" name="nodeId">'.$nodeList.'</select></div></div>
      <div><div class="cell">'.$ui['name'].'</div><div class="cell"><input class="textbox" type="text" name="name" value="'.$alliance->data['name'].'"></div></div>
      <div><div class="cell"><input class="button" type="submit" value="'.$ui['set'].'"></div></div>
     </form>
     <div>'.$ui['cost'].': '.$costData.'</div>
     <div style="border-top: 1px solid black; padding-top: 5px; margin-top: 5px;"><a class="link" href="node.php?action=get&nodeId='.$node->data['id'].'">'.$node->data['name'].'</a></div>';
   }
  break;
  case 'add':
   if (isset($nodeList))
   {
    $costData='';
    foreach ($game['factions'][$node->data['faction']]['costs']['alliance'] as $key=>$cost)
     $costData.='<div class="cell">'.$cost['value'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$cost['resource'].'.png" title="'.$gl['resources'][$cost['resource']]['name'].'"></div>';
    echo '
     <form method="post" action="?action=add">
      <div><div class="cell">'.$ui['node'].'</div><div class="cell"><select class="dropdown" name="nodeId">'.$nodeList.'</select></div></div>
      <div><div class="cell">'.$ui['name'].'</div><div class="cell"><input class="textbox" type="text" name="name" value=""></div></div>
      <div><div class="cell"><input class="button" type="submit" value="'.$ui['add'].'"></div></div>
     </form>
     <div>'.$ui['cost'].': '.$costData.'</div>
     <div style="border-top: 1px solid black; padding-top: 5px; margin-top: 5px;"><a class="link" href="node.php?action=get&nodeId='.$node->data['id'].'">'.$node->data['name'].'</a></div>';
   }
  break;
  case 'remove':
   if (!isset($_GET['go']))
    echo '<div>'.$ui['areYouSure'].'</div><div><a class="link" href="alliance.php?action=remove&go=1">'.$ui['yes'].'</a> | <a class="link" href="alliance.php?action=get">'.$ui['no'].'</a></div>';
  break;
  case 'addInvitation':
   echo '
    <div>
     <form method="post" action="?action=addInvitation">
      <label>'.$ui['username'].'</label>
      <input class="textbox" type="text" name="name" value="">
      <input class="button" type="submit" value="'.$ui['invite'].'">
     </form>
    </div>';
  break;
  case 'addWar':
   echo '
    <div>
     <form method="post" action="?action=addWar">
      <label>'.$ui['alliance'].'</label>
      <input class="textbox" type="text" name="name" value="">
      <input class="button" type="submit" value="'.$ui['goToWar'].'">
     </form>
    </div>';
  break;
 }
 echo '</div></div>';
}
?>
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/footer.php'; ?>
 </body>
</html>
