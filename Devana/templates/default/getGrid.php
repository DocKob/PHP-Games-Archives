 <?php echo $ui['jumpTo'] ?>:
 <input class="textbox" type="text" id="x" size="2" value="<?php echo $x; ?>">
 <input class="textbox" type="text" id="y" size="2" value="<?php echo $y; ?>">
 <input class="button" type="button" onClick="jumpToSector()" value="<?php echo $ui['go'] ?>">
 <div style="position: relative; top: 30px; left: 0px;">
<?php
for ($k = 3; $k >= -3; $k--)
{
   $st_x = ($k + 3) * 40 + 5;
   $st_y = (3 - $k) * 20;
?>
  <div style="position: absolute; left: <?php echo $st_x; ?>px; top: <?php echo $st_y; ?>px; width: 50px;"><?php echo $y+$k; ?></div>
<?php
}
for ($j = -3; $j <= 3; $j++)
{
      $st_x = ($j + 3) * 40 + 5;
      $st_y = 165 + ($j + 3) * 20 - 12;
?>
  <div style="position: absolute; left: <?php echo $st_x; ?>px; top: <?php echo $st_y; ?>px; width: 50px;"><?php echo $x+$j; ?></div>
<?php
}
?>
 </div>
 <div style="position: relative; top: 0px; left: 15px;">
<?php
$i=0;
for ($k = 3; $k >= -3; $k--)
{
   for ($j = -3; $j <= 3; $j++)
   {
      $st_x = ($k + 3) * 40 + ($j + 3) * 40;
      $st_y = (3 - $k) * 20 + ($j + 3) * 20;
?>
  <img style="position: absolute; left: <?php echo $st_x; ?>px; top: <?php echo $st_y; ?>px; width: 80px; height: 80px;" src="<?php echo $grid->getSectorImage($x+$j, $y+$k, $i, $_SESSION[$shortTitle.'User']['template']); ?>">
<?php
   }
}
?>
  <img src="<?php echo 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/images/grid/arrows.png'; ?>" border="0" usemap="#grid" style="position: absolute; left: 0px; top: 29px; width: 560px; height: 291px;">
  <map name="grid">
<?php
$i=0;
for ($k = 3; $k >= -3; $k--)
{
   for ($j = -3; $j <= 3; $j++)
   {
      $st_x = ($k + 3) * 40 + ($j + 3) * 40;
      $st_y = (3 - $k) * 20 + ($j + 3) * 20;
      $coords = ($st_x + 38) . ',' . ($st_y-2) . ',' . ($st_x + 78) . ',' . ($st_y + 18) . ',' . ($st_x + 40) . ',' . ($st_y + 40) . ',' . $st_x . ',' . ($st_y + 20);
?>
   <area shape="poly" coords="<?php echo $coords; ?>" <?php echo $grid->getSectorLink($x+$j, $y+$k, $i); ?>>
<?php
   }
}
?>
   <area shape="circle" coords="482,38,15" href="javascript: fetch('getGrid.php', '<?php echo 'x='.$x.'&y='.($y+3); ?>')" title="<?php echo $ui['North']; ?>">
   <area shape="circle" coords="77,241,15" href="javascript: fetch('getGrid.php', '<?php echo 'x='.$x.'&y='.($y-3); ?>')" title="<?php echo $ui['South']; ?>">
   <area shape="circle" coords="482,241,15" href="javascript: fetch('getGrid.php', '<?php echo 'x='.($x+3).'&y='.$y; ?>')" title="<?php echo $ui['East']; ?>">
   <area shape="circle" coords="77,38,15" href="javascript: fetch('getGrid.php', '<?php echo 'x='.($x-3).'&y='.$y; ?>')" title="<?php echo $ui['West']; ?>">
  </map>
 </div>
 <div style="display: inline-block; position: relative; top:-25px; left:350px;">
  <table style="border-collapse: collapse; border-style: none;" width="250">
   <tr>
    <td align="center" id="description" style="border-style: none;"><?php echo $ui['description'] ?>
   </tr>
   <tr>
    <td width="117" align="center" id="player" style="border-style: none;"><?php echo $ui['player'] ?></td>
   </tr>
   <tr>
    <td width="117" align="center" id="alliance" style="border-style: none;"><?php echo $ui['alliance'] ?></td>
   </tr>
  </table>
 </div>
<script type='text/javascript'>
 setSector(<?php echo $x.', '.$y; ?>);
</script>