<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <?php echo '<link rel="stylesheet" type="text/css" href="templates/'.$_SESSION[$shortTitle.'User']['template'].'/default.css">'; ?>
  <title><?php echo $title.$ui['separator'].$ui['combat']; ?></title>
  <?php echo $tracker; ?>
 </head>
 <body class="body">
<script type="text/javascript">
 var attacker=new Array(), defender=new Array();
 function Group(groupType, groupQuantity)
 {
  this.type=groupType;
  this.quantity=groupQuantity;
 }
</script>
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/header.php'; ?>
<?php
if (isset($node->data['id']))
 switch ($_GET['action'])
 {
  case 'add':
   $units='"';
   foreach ($gl['units'][$node->data['faction']] as $ukey=>$unit)
    $units.='<option value=\''.$ukey.'\'>'.$unit['name'].'</option>';
   $units.='"';
   $factions='';
   foreach ($gl['factions'] as $key=>$faction)
    $factions.='<option value="'.$key.'">'.$faction['name'].'</option>';
   $attacker=array('output'=>'', 'outcome'=>'');
   $defender=array('output'=>'', 'outcome'=>'');
   echo '
    <div class="container">
     <div class="content" style="text-align: center;">';
   include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/resources.php';
   echo '<div style="text-align: left; border-bottom: 1px solid black;"><div>';
   $uc=0;
   foreach ($node->units as $key=>$unit)
   {
    echo '<div class="cell">'.$unit['value'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/units/'.$node->data['faction'].'/'.$key.'.png" title="'.$gl['units'][$node->data['faction']][$key]['name'].'"></div>';
    $uc++;
    if ($uc==9) echo '</div><div>';
   }
   echo '</div></div>';
   $costData='';
    foreach ($game['factions'][$node->data['faction']]['costs']['combat'] as $key=>$cost)
     $costData.='<div class="cell">'.$cost['value'].'</div><div class="cell"><img class="resource" src="templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/resources/'.$cost['resource'].'.png" title="'.$gl['resources'][$cost['resource']]['name'].'"></div>';
   echo '
      <form method="post" action="">
       <div><div class="cell">'.$ui['node'].'</div><div class="cell"><input class="textbox" type="text" name="name"></div></div>
       <div>
        '.$ui['focus'].'
        <select class="dropdown" name="attackerFocus" id="attackerFocus">
         <option value="hp">'.$ui['hp'].'</option>
         <option value="damage">'.$ui['damage'].'</option>
         <option value="armor">'.$ui['armor'].'</option>
        </select> | 
        <select class="dropdown" id="attackerUnit">'.$units.'</select>
        <input class="button" type="button" value="'.$ui['add'].'" onClick="addGroup()">
       </div>
       <div class="container" id="attacker"></div>
       <div style="text-align: left; border-top: 1px solid black; margin-top: 5px; padding-top: 5px;">
        <div class="cell" style="float: right;">'.$ui['cost'].': '.$costData.'</div>
        <input class="button" type="submit" value="'.$ui['send'].'">
       </div>
      </form>
     </div>
    </div>
   <script type="text/javascript">
    function addGroup()
    {
     var group=new Group(document.getElementById("attackerUnit").value, 0);
     attacker.push(group);
     setUnits();
    }
    function removeGroup(index)
    {
     attacker.splice(index, 1);
     setUnits();
    }
    function setUnits()
    {
     var holder="";
     if (attacker.length==0) holder="[ ... ]";
     for (var i=0; i<attacker.length; i++)
      holder+="<div class=\'cell\' style=\'text-align: center;\'><div class=\'row\'><a class=\'link\' href=\'javascript: removeGroup("+i+")\'>x</a></div><div class=\'row\'><img src=\'templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/units/'.$node->data['faction'].'/"+attacker[i].type+".png\' style=\'width: 38px;\'></div><div class=\'row\'><input type=\'hidden\' name=\'attackerGroupUnitIds[]\' value=\'"+attacker[i].type+"\'><input class=\'textbox numeric\' type=\'text\' name=\'attackerGroups[]\' value=\'"+attacker[i].quantity+"\' onChange=\'attacker["+i+"].quantity=this.value\' style=\'width: 30px;\'></div></div>";
     document.getElementById("attacker").innerHTML=holder;
    }
    setUnits();
   </script>';
  break;
 }
?>
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/footer.php'; ?>
 </body>
</html>