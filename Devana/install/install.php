<?php
chdir("../");
include 'core/config.php';
include 'core/core.php';
include 'core/game.php';
if (isset($_POST['email'], $_POST['name'], $_POST['password'], $_POST['rePassword'], $_POST['regCode']))
{
 foreach ($_POST as $key=>$value)
 {
  if ($_POST['name']==$_POST[$key]) $value=preg_replace('/[^a-zA-Z0-9]/', '', $value);
  $_POST[$key]=misc::clean($value);
 }
 if ((($_POST['email']!=''))&&($_POST['name']!='')&&(($_POST['password']!='')))
 {
  $user=new user(); $user->get('name', $_POST['name']);
  if ($_POST['password']==$_POST['rePassword'])
   if ($_POST['regCode']==$_SESSION['regCode'])
    if (!$user->data['id'])
    {
     $user->data['name']=$_POST['name'];
     $user->data['email']=$_POST['email'];
     $user->data['password']=sha1($_POST['password']);
     $user->data['level']=3;
     $user->data['joined']=strftime('%Y-%m-%d', time());
     $user->data['lastVisit']=strftime('%Y-%m-%d %H:%M:%S', time());
     $user->data['ip']=$_SERVER['REMOTE_ADDR'];
     $user->data['template']='default';
     $user->data['locale']='en';
     $imageStats=getimagesize('install/grid.png');
     $image=imagecreatefrompng('install/grid.png');
     $query=array();
     for ($i=0; $i<$imageStats[0]; $i++)
      for ($j=0; $j<$imageStats[1]; $j++)
      {
       $pixelRGB=imagecolorat($image, $i, $j);
       $pixelG=($pixelRGB>>8)&0xFF;
       $pixelB=$pixelRGB&0xFF;
       if ($pixelB)
       {
        $sectorType=0;
        $sectorId=rand(1, 4);
       }
       else if ($pixelG)
       {
        $sectorType=1;
        $sectorId=rand(1, 10);
       }
       array_push($query, '('.$i.', '.$j.', '.$sectorType.', '.$sectorId.')');
      }
     $db->query('insert into grid (x, y, type, id) values '.implode(', ', $query));
     $user->add();
     $message=$ui['installed'];
    }
    else $message=$ui['nameTaken'];
   else $message=$ui['wrongCode'];
  else $message=$ui['rePassNotMatch'];
 }
 else $message=$ui['insufficientData'];
}
else $_SESSION['regCode']=rand(1, 9999);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<?php echo '<link rel="stylesheet" type="text/css" href="../templates/'.$_SESSION[$shortTitle.'User']['template'].'/default.css">'; ?>
 <head>
  <title><?php echo $title.$ui['separator'].$ui['install']; ?></title>
 </head>
 <body class="body">
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/header.php'; ?>
  <div class="content">
   <form method="post" action="install.php">
    <div><div class="cell"><?php echo $ui['email']; ?></div><div class="cell"><input class="textbox" type="text" name="email"></div></div>
    <div><div class="cell"><?php echo $ui['username']; ?></div><div class="cell"><input class="textbox" type="text" name="name" id="name" maxlength="32" onChange="check('name')"></div></div>
    <div><div class="cell"><?php echo $ui['password']; ?></div><div class="cell"><input class="textbox" type="password" name="password"></div></div>
    <div><div class="cell"><?php echo $ui['retypePassword']; ?></div><div class="cell"><input class="textbox" type="password" name="rePassword"></div></div>
    <div><div class="cell"><?php echo $ui['securityCode']; ?></div><div class="cell"><div class="cell"><img style="vertical-align: bottom;" src="../captcha.php"></div><div class="cell"><input class="textbox" type="text" size="4" name="regCode"></div></div></div>
    <div><div class="cell"><input class="button" type="submit" value="<?php echo $ui['install']; ?>"></div></div>
   </form>
  </div>
<script type="text/javascript">
 function check(obj)
 {
  var str=document.getElementById(obj).value, regex=/^[0-9A-Za-z]+$/;
  if (!regex.test(str)) alert("<?php echo $ui['onlyAlphaNum']; ?>");
 }
</script>
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/footer.php'; ?>
 </body>
</html>