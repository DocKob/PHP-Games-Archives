<?
	include("config.php");
  include("languages/$lang");

	$title=$l_mail_title;
	include("header.php");

  connectdb();

	bigtitle();

	$result = $db->Execute ("select email, password from $dbtables[ships] where email='$mail'");

	if(!$result->EOF) {
	$playerinfo=$result->fields;
	$l_mail_message=str_replace("[pass]",$playerinfo[password],$l_mail_message);
	mail("$mail", "$l_mail_topic", "$l_mail_message\r\n\r\nhttp://$SERVER_NAME","From: webmaster@$SERVER_NAME\r\nReply-To: webmaster@$SERVER_NAME\r\nX-Mailer: PHP/" . phpversion());
	echo "$l_mail_sent $mail.";
        } else {
                echo "<b>$l_mail_noplayer</b><br>";
        }

	include("footer.php");
?>

