<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<script type="text/javascript" src="core/core.js"></script>
<script type="text/javascript"> var labels=new Array(<?php echo '"'.$ui['water'].'", "'.$ui['land'].'"'; ?>); </script>
 <head>
  <script type="text/javascript">
   var position=new Array(0, 0);
   function setSector(x, y)
   {
    var sector;
    sector=document.getElementById("sector_"+(position[0]-3)+"_"+(position[1]-3));
    if (isset(sector)) sector.style.border="";
    sector=document.getElementById("sector_"+(position[0]-3)+"_"+(position[1]+3));
    if (isset(sector)) sector.style.border="";
    sector=document.getElementById("sector_"+(position[0]+3)+"_"+(position[1]+3));
    if (isset(sector)) sector.style.border="";
    sector=document.getElementById("sector_"+(position[0]+3)+"_"+(position[1]-3));
    if (isset(sector)) sector.style.border="";
    sector=document.getElementById("sector_"+(x-3)+"_"+(y-3));
    if (isset(sector))
    {
     sector.style.borderLeft="1px solid white";
     sector.style.borderBottom="1px solid white";
    }
    sector=document.getElementById("sector_"+(x-3)+"_"+(y+3));
    if (isset(sector))
    {
     sector.style.borderLeft="1px solid white";
     sector.style.borderTop="1px solid white";
    }
    sector=document.getElementById("sector_"+(x+3)+"_"+(y+3));
    if (isset(sector))
    {
     sector.style.borderRight="1px solid white";
     sector.style.borderTop="1px solid white";
    }
    sector=document.getElementById("sector_"+(x+3)+"_"+(y-3));
    if (isset(sector))
    {
     sector.style.borderRight="1px solid white";
     sector.style.borderBottom="1px solid white";
    }
    position=new Array(x, y);
   }
  </script>
  <style>
   div.sector
   {
    display: inline-block;
    cursor: pointer;
    width: 5px;
    height: 5px;
    border: 1px solid transparent;
   }
   div.sector:hover
   {
    border: 1px solid black;
   }
  </style>
  <?php echo '<link rel="stylesheet" type="text/css" href="templates/'.$_SESSION[$shortTitle.'User']['template'].'/default.css">'; ?>
  <title><?php echo $title.$ui['separator'].$ui['grid']; ?></title>
  <?php echo $tracker; ?>
 </head>
 <body class="body">
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/header.php'; ?>
  <div class="container">
   <div class="cell" style="float: left;"><div class="content" id="content" style="width: 600px; height: 370px; text-align: left;"></div></div>
<?php
$sc=count($grid->data);
$rc=sqrt($sc);
$minimap='';
for ($i=0; $i<$sc; $i++)
{
 switch ($grid->data[$i]['type'])
 {
  case 0: $sectorColor='blue'; break;
  case 1: $sectorColor='green'; break;
  case 2: $sectorColor='brown'; break;
 }
 $minimap.='<div class="sector" style="background-color: '.$sectorColor.';" id="sector_'.$grid->data[$i]['x'].'_'.$grid->data[$i]['y'].'" onClick="fetch(\'getGrid.php\', \'x='.$grid->data[$i]['x'].'&y='.$grid->data[$i]['y'].'\')"></div>';
 if (!(($i+1)%$rc)) $minimap.='<br>';
}
echo '<div class="cell" style="float: right;"><div class="content" style="z-index: 10;">'.$minimap.'</div></div><div class="clear"></div>';
?>
  </div>
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/footer.php'; ?>
 </body>
<script type="text/javascript">fetch("getGrid.php", "<?php if (isset($vars)) echo $vars; ?>")</script>
</html>
