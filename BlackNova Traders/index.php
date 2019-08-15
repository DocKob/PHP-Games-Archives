<? 
  include("config.php");

  if(empty($lang))
    $lang = $default_lang;
  include("languages/$lang");
	$title="Login"; 
  $interface="index.php";
  $no_body=1;
	include("header.php");
//  include("config.php");
?>

<body bgcolor="#666666" text="#c0c0c0" link="#000000" vlink="#990033" alink="#FF3333" onLoad="MM_preloadImages('images/login_.gif','images/mail_.gif')">
<center>
<img src="images/BNT-header.jpg" width="517" height="189" border="0" alt="BlackNova Traders">

<table border="0" cellpadding="0" cellspacing="0" width="600">
  <tr>
    <td colspan="3"><img name="div1" src="images/div1.gif" width="600" height="21" border="0" alt=""></td>
    <td><img src="images/spacer.gif" width="1" height="21" border="0" alt=""></td>
  </tr>
  <tr>
    <td colspan="3"><img name="bnthed" src="images/bnthed.gif" width="600" height="61" border="0" alt="BlackNova Traders"></td>
    <td><img src="images/spacer.gif" width="1" height="61" border="0" alt=""></td>
  </tr>
  <tr>
    <td colspan="3"><img name="div2" src="images/div2.gif" width="600" height="21" border="0" alt=""></td>
    <td><img src="images/spacer.gif" width="1" height="21" border="0" alt=""></td>
  </tr>
  <tr>
    <td colspan=3 align=center><a href=<? echo "login.php"; ?> onMouseOut="MM_swapImgRestore()"  onMouseOver="MM_swapImage('login','','images/login_.gif',1);" ><img name="login" src="images/login.gif" width="146" height="58" border="0" alt="Login"></a></td>
    <td><img src="images/spacer.gif" width="1" height="58" border="0" alt=""></td>
  </tr>
  <tr>
    <td colspan=3 align=center><a href=<? echo "\"mailto:$admin_mail\""; ?> onMouseOut="MM_swapImgRestore()"  onMouseOver="MM_swapImage('mail','','images/mail_.gif',1);" ><img name="mail" src="images/mail.gif" width="146" height="58" border="0" alt="Mail"></a></td>
    <td><img src="images/spacer.gif" width="1" height="58" border="0" alt=""></td>
  </tr>
  <tr>
  <td colspan=3 align=center><a href="faq.html"><? echo "$l_faq"; ?></a></td>
  </tr>
  </table></center>
<?
	include("footer.php");
?>
