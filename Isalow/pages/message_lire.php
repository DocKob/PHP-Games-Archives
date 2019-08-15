<?php
include("../skin/header.php");

require("../functions.php");

db_connexion();

$id = $_GET['id'];

$sql = "SELECT type , de , message , date_ecrit FROM is_message WHERE id = '$id'";
$r_message = mysql_query($sql);
$t_message = mysql_fetch_assoc($r_message);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Message</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0" class="txt">
  <tr>
    <td height="16" class="table16px">Message venant de <font class="rouge"><? echo($t_message['de']); ?></font> &eacute;crit le <font class="rouge"><? echo($t_message['date_ecrit']); ?></font></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#000000"><br>
    <? echo( nl2br(stripslashes(isaCode($t_message['message']))) ); ?></td>
  </tr>
</table>
</body>
</html>
