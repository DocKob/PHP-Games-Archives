<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <script type="text/javascript" src="core/core.js"></script>
  <script type="text/javascript">
   var timerIds=new Array();
   function setLabel(value)
   {
    document.getElementById("label").innerHTML=value;
   }
  </script>
  <?php echo '<link rel="stylesheet" type="text/css" href="templates/'.$_SESSION[$shortTitle.'User']['template'].'/default.css">'; ?>
  <title>
<?php
echo $title;
echo $ui['separator'].$ui['messages'].$ui['separator'].$ui[$_GET['action']];
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
 switch ($_GET['action'])
 {
  case 'get':
   if (isset($msg->data['recipient']))
   {
    echo '
    <div style="border-bottom: 1px solid black; padding-bottom: 5px; margin-bottom: 5px;">
     <div><div class="cell">'.$ui['sender'].'</div><div class="cell">'.$msg->data['senderName'].'</div></div>
     <div><div class="cell">'.$ui['subject'].'</div><div class="cell">'.$msg->data['subject'].'</div></div>
    </div>
    <div style="border-bottom: 1px solid black; padding-bottom: 5px; margin-bottom: 5px;">'.$msg->data['body'].'</div>
    <div><a class="link" href="message.php?action=add&messageId='.$msg->data['id'].'">'.$ui['reply'].'</a></div>
    ';
   }
  break;
  case 'add':
   $recipient=$subject=$body='';
   if (isset($msg->data['id']))
   {
    $user=new user();
    $status=$user->get('id', $msg->data['sender']);
    if ($status=='done') $recipient=$user->data['name'];
    $subject='re: '.$msg->data['subject'];
    $body="\r\n\r\n-----\r\n".$msg->data['body'];
   }
   echo '
    <form method="post" action="?action=add">
     <div>
      <div><div class="cell"><input class="textbox" type="text" name="recipient" value="'.$recipient.'" style="width: 200px;"></div><div class="cell">'.$ui['recipient'].'</div></div>
      <div><div class="cell"><input class="textbox" type="text" name="subject" value="'.$subject.'" style="width: 200px;"></div><div class="cell">'.$ui['subject'].'</div></div>
     </div>
     <div><textarea class="textbox" name="body" style="width: 400px; height: 200px;">'.$body.'</textarea></div>
     <div><input class="button" type="submit" value="'.$ui['send'].'"></div>
    </form>';
  break;
  case 'list':
   if (count($messages['messages'])) $removeAll=' | <a class="link" href="?action=removeAll">'.$ui['removeAll'].'</a>';
   else $removeAll='';
   echo '<div><a class="link" href="?action=add">'.$ui['send'].'</a>'.$removeAll.'</div><div style="border-top: 1px solid black; border-bottom: 1px solid black; padding: 5px 0 5px 0; margin: 5px 0 5px 0;">
   <form method="post" action="?action=remove" id="messageList">';
   foreach ($messages['messages'] as $message)
   {
    if (!$message->data['viewed']) $new=' style="text-decoration: underline;"';
    else $new='';
    $hours=round((time()-strtotime($message->data['sent']))/3600, 2);
    echo '<div><div class="cell"><input type="checkbox" name="messageId[]" value="'.$message->data['id'].'"></div><div class="cell"><a class="link" href="message.php?action=get&messageId='.$message->data['id'].'"'.$new.'>'.$message->data['subject'].'</a></div><div class="cell">'.$hours.' '.$ui['hours'].'</div><div class="cell"><a class="link" href="?action=remove&messageId='.$message->data['id'].'">x</a></div></div>';
   }
   if (count($messages['messages'])) echo '<a class="link" href="javascript: document.getElementById(\'messageList\').submit()">'.$ui['remove'].'</a>';
   echo '</form></div>';
   if ($pageCount>1)
   {
    $previous='';
    $next='';
    if (isset($_GET['page']))
     if ($_GET['page']) $previous='<a class="link" href="message.php?action=list&page='.($_GET['page']-1).'">'.$ui['previous'].'</a>';
    if (!isset($_GET['page']))
    {
     if ($pageCount) $next='<a class="link" href="message.php?action=list&page=1">'.$ui['next'].'</a>';
    }
    else if ($pageCount-$_GET['page']-1) $next='<a class="link" href="message.php?action=list&page='.($_GET['page']+1).'">'.$ui['next'].'</a>';
    echo '
     '.$ui['page'].': 
     '.$previous.' <select class="dropdown" id="page" onChange="window.location.href=\'message.php?action=list&page=\'+this.value">';
    for ($i=0; $i<$pageCount; $i++)
     echo '<option value="'.$i.'">'.$i.'</option>';
    echo '</select> '.$next;
    if (isset($_GET['page']))
     echo '<script type="text/javascript">document.getElementById("page").selectedIndex='.$_GET['page'].'</script>';
   }
  break;
 }
 echo '</div></div>';
}
?>
<?php include 'templates/'.$_SESSION[$shortTitle.'User']['template'].'/footer.php'; ?>
 </body>
</html>
