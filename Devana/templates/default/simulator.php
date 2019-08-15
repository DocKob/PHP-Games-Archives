<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <?php echo '<link rel="stylesheet" type="text/css" href="templates/'.$_SESSION[$shortTitle.'User']['template'].'/default.css">'; ?>
  <title><?php echo $title.$ui['separator'].$ui['combatSimulator']; ?></title>
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
echo '<script type="text/javascript">';
if (isset($_POST['attackerGroupUnitIds'], $_POST['defenderGroupUnitIds']))
{
 $attackerData=$defenderData=array();
 foreach ($_POST['attackerGroupUnitIds'] as $key=>$unitId)
  $attackerData[$key]='new Group('.$unitId.', '.$_POST['attackerGroups'][$key].')';
 $attackerData=implode(', ', $attackerData);
 echo 'attacker=new Array('.$attackerData.');';
 foreach ($_POST['defenderGroupUnitIds'] as $key=>$unitId)
  $defenderData[$key]='new Group('.$unitId.', '.$_POST['defenderGroups'][$key].')';
 $defenderData=implode(', ', $defenderData);
 echo 'defender=new Array('.$defenderData.');';
}
$units=array();
foreach ($gl['factions'] as $fkey=>$faction)
{
 $units[$fkey]='"';
 foreach ($gl['units'][$fkey] as $ukey=>$unit)
  $units[$fkey].='<option value=\''.$ukey.'\'>'.$unit['name'].'</option>';
 $units[$fkey].='"';
}
echo 'var units=new Array('.implode(', ', $units).');';
echo '</script>';
$factions='';
foreach ($gl['factions'] as $key=>$faction)
 $factions.='<option value="'.$key.'">'.$faction['name'].'</option>';
$attacker=array('output'=>'', 'outcome'=>'');
$defender=array('output'=>'', 'outcome'=>'');
if (isset($data['output']))
{
 $showOutput=' style="display: table;"';
 foreach ($data['output']['attacker']['groups'] as $group)
  $attacker['output'].='<div class="cell" style="text-align: center;"><div class="unitBlock">'.$group['quantity'].'</div></div>';
 if ($data['output']['attacker']['winner']) $attacker['outcome']=$ui['won'];
 else $attacker['outcome']=$ui['lost'];
 foreach ($data['output']['defender']['groups'] as $group)
  $defender['output'].='<div class="cell" style="text-align: center;"><div class="unitBlock">'.$group['quantity'].'</div></div>';
 if ($data['output']['defender']['winner']) $defender['outcome']=$ui['won'];
 else $defender['outcome']=$ui['lost'];
}
else $showOutput=' style="display: none;"';
echo '
 <div class="container">
  <div class="content" style="text-align: center;">
   <form method="post" action="">
    <div style="border-bottom: 1px solid black; margin-bottom: 5px; padding-bottom: 5px;">
     '.$ui['focus'].'
     <select class="dropdown" name="attackerFocus" id="attackerFocus">
      <option value="hp">'.$ui['hp'].'</option>
      <option value="damage">'.$ui['damage'].'</option>
      <option value="armor">'.$ui['armor'].'</option>
     </select> | 
     <select class="dropdown" name="attackerFaction" id="attackerFaction" onChange="setFaction(this.value, \'attacker\')">'.$factions.'</select>
     <span id="attackerUnitSpan"><select class="dropdown" id="attackerUnit"></select></span>
     <input class="button" type="button" value="'.$ui['add'].'" onClick="addGroup(\'attacker\')">
    </div>
    <div class="container" id="attacker"></div>
    <div class="container"'.$showOutput.'>'.$attacker['output'].'</div>
    <div class="container"'.$showOutput.'>'.$attacker['outcome'].'</div>
    <div style="text-align: center;"><input class="button" type="submit" value="'.$ui['versus'].'"></div>
    <div class="container"'.$showOutput.'>'.$defender['outcome'].'</div>
    <div class="container"'.$showOutput.'>'.$defender['output'].'</div>
    <div class="container" id="defender"></div>
    <div style="border-top: 1px solid black; margin-top: 5px; padding-top: 5px;">
     '.$ui['focus'].'
     <select class="dropdown" name="defenderFocus" id="defenderFocus">
      <option value="hp">'.$ui['hp'].'</option>
      <option value="damage">'.$ui['damage'].'</option>
      <option value="armor">'.$ui['armor'].'</option>
     </select> | 
     <select class="dropdown" name="defenderFaction" id="defenderFaction" onChange="setFaction(this.value, \'defender\')">'.$factions.'</select>
     <span id="defenderUnitSpan"><select class="dropdown" id="defenderUnit"></select></span>
     <input class="button" type="button" value="'.$ui['add'].'" onClick="addGroup(\'defender\')">
    </div>
   </form>
  </div>
 </div>';
?>
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/footer.php'; ?>
<script type="text/javascript">
 function addGroup(prefix)
 {
  var group=new Group(document.getElementById(prefix+"Unit").value, 0);
  if (prefix=="attacker") attacker.push(group);
  else defender.push(group);
  setUnits(prefix);
 }
 function removeGroup(prefix, index)
 {
  if (prefix=="attacker") attacker.splice(index, 1);
  else defender.splice(index, 1);
  setUnits(prefix);
 }
 function setFaction(faction, prefix)
 {
  document.getElementById(prefix+"UnitSpan").innerHTML="<select class='dropdown' id='"+prefix+"Unit'>"+units[faction]+"</select>";
 }
 function setUnits(prefix)
 {
  var holder="", faction=document.getElementById(prefix+"Faction");
  if (prefix=="attacker")
  {
   for (var i=0; i<attacker.length; i++)
    holder+="<div class='cell' style='text-align: center;'><div class='row'><a class='link' href='javascript: removeGroup(\"attacker\", "+i+")'>x</a></div><div class='row'><img src='templates/<?php echo $_SESSION[$shortTitle.'User']['template']; ?>/images/units/"+faction.value+"/"+attacker[i].type+".png' class='unitBlock'></div><div class='row'><input type='hidden' name='"+prefix+"GroupUnitIds[]' value='"+attacker[i].type+"'><input class='textbox numeric' type='text' name='"+prefix+"Groups[]' value='"+attacker[i].quantity+"' onChange='attacker["+i+"].quantity=this.value' style='width: 30px;'></div></div>";
  }
  else
  {
   for (var i=0; i<defender.length; i++)
    holder+="<div class='cell' style='text-align: center;'><div class='row'><input type='hidden' name='"+prefix+"GroupUnitIds[]' value='"+defender[i].type+"'><input class='textbox numeric' type='text' name='"+prefix+"Groups[]' value='"+defender[i].quantity+"' onChange='defender["+i+"].quantity=this.value' style='width: 30px;'></div><div class='row'><img src='templates/<?php echo $_SESSION[$shortTitle.'User']['template']; ?>/images/units/"+faction.value+"/"+defender[i].type+".png' class='unitBlock'></div><div class='row'><a class='link' href='javascript: removeGroup(\"defender\", "+i+")'>x</a></div></div>";
  }
  document.getElementById(prefix).innerHTML=holder;
 }
 setFaction(0, "attacker");
 setFaction(0, "defender");
 setUnits("attacker");
 setUnits("defender");
<?php
if (isset($_POST['attackerFaction'], $_POST['defenderFaction'], $_POST['attackerFocus'], $_POST['defenderFocus']))
 echo '
  var focusTypes=new Array("hp", "damage", "armor");
  document.getElementById("attackerFocus").selectedIndex=focusTypes.indexOf("'.$_POST['attackerFocus'].'");
  document.getElementById("defenderFocus").selectedIndex=focusTypes.indexOf("'.$_POST['defenderFocus'].'");
  document.getElementById("attackerFaction").selectedIndex='.$_POST['attackerFaction'].';
  document.getElementById("defenderFaction").selectedIndex='.$_POST['defenderFaction'].';
 ';
?>
</script>
 </body>
</html>