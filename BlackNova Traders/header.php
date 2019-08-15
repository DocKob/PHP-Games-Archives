<?php
//$Id: header.php 57 2006-01-28 03:52:07Z iamsure $
    header("Content-type: text/html; charset=utf-8");
    header("Cache-Control: public"); // Tell the client (and any caches) that this information can be stored in public caches.
    header("Connection: Keep-Alive"); // Tell the client to keep going until it gets all data, please.
    header("Keep-Alive: timeout=15, max=100");

// <!doctype html public "-//w3c//dtd html 3.2//en">

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Pragma" content="no-cache">
<title><?php echo $title; ?></title>
 <style type="text/css">
 <!--
<?php
if($interface == "")
{
  $interface = "main.php";
}

if($interface == "main.php" || $interface == "index.php")
{
  echo "  a.mnu {text-decoration:none; font-size: 8Pt; font-family: Verdana, Arial, sans-serif; color:white; font-weight:bold;}
  a.mnu:hover {text-decoration:none; font-size: 8Pt; font-family: Verdana, Arial, sans-serif; color:#3366ff; font-weight:bold;}
  div.mnu {text-decoration:none; font-size: 8Pt; font-family: Verdana, Arial, sans-serif; color:white; font-weight:bold;}
  span.mnu {text-decoration:none; font-size: 8Pt; font-family: Verdana, Arial, sans-serif; color:white; font-weight:bold;}
  a.dis {text-decoration:none; font-size: 8Pt; font-family: Verdana, Arial, sans-serif; color:silver; font-weight:bold;}
  a.dis:hover {text-decoration:none; font-size: 8Pt; font-family: Verdana, Arial, sans-serif; color:#3366ff; font-weight:bold;}
  table.dis {text-decoration:none; font-size: 8Pt; font-family: Verdana, Arial, sans-serif; color:silver; font-weight:bold;}
  table.dis:hover {text-decoration:none; font-size: 8Pt; font-family: Verdana, Arial, sans-serif; color:#3366ff; font-weight:bold;}
  .headlines:hover {text-decoration:none; color:#3366ff;}
  .headlines {text-decoration:none; font-size:8Pt; font-family: Verdana, Arial, sans-serif; font-weight:bold; color:white;}
  .portcosts1 {width:7em; border-style:none; font-family: Verdana, Arial, sans-serif; font-size:12pt; background-color:$color_line1; color:#c0c0c0;}
  .portcosts2 {width:7em; border-style:none; font-family: Verdana, Arial, sans-serif; font-size:12pt; background-color:$color_line2; color:#c0c0c0;}
  .faderlines {background-color:$color_line2;}";
}
echo "\n  body {font-family: Verdana, Arial, sans-serif; font-size: x-small;}\n";
?>
 -->
 </style>
<?php
if ($interface == "index.php")
{
?>
<SCRIPT LANGUAGE="JavaScript" type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<?php
}
echo "</head>";

if(empty($no_body))

{

  if($interface=="main.php")
  {
    echo "<body background=\"images/bgoutspace1.gif\" bgcolor=\"#000000\" text=\"#c0c0c0\" link=\"#00ff00\" vlink=\"#00ff00\" alink=\"#ff0000\">";
  }
  else
  {
    echo "<body background=\"\" bgcolor=\"#000000\" text=\"#c0c0c0\" link=\"#00ff00\" vlink=\"#808080\" alink=\"#ff0000\">";
  }

}
echo "\n";

?>
