<?

include("config.php");
updatecookie();

include("languages/$lang");

$title="$l_mt_title";
include("header.php");

connectdb();

if(checklogin())
{
  die();
}

$res = $db->Execute("SELECT * FROM $dbtables[ships] WHERE email='$username'");
$playerinfo = $res->fields;

bigtitle();

if(empty($content))
{
  $res = $db->Execute("SELECT * FROM $dbtables[ships] WHERE ship_destroyed = 'N' ORDER BY character_name ASC");
  echo "<FORM ACTION=mailto2.php METHOD=POST>";
  echo "<TABLE>";
  echo "<TR><TD>To:</TD><TD><SELECT NAME=to>";
  while(!$res->EOF)
  {
    $row=$res->fields;
    if($row[ship_id] == $to)
    {
       echo "\n<OPTION SELECTED>$row[character_name]</OPTION>";
    }   
    else 
    {
       echo "\n<OPTION>$row[character_name]</OPTION>";
    }   
    $res->MoveNext();
  }
  echo "</SELECT></TD></TR>";
  echo "<TR><TD>$l_mt_from</TD><TD><INPUT DISABLED TYPE=TEXT NAME=dummy SIZE=40 MAXLENGTH=40 VALUE=\"$playerinfo[character_name]\"></TD></TR>";
  echo "<TR><TD>$l_mt_subject</TD><TD><INPUT TYPE=TEXT NAME=subject SIZE=40 MAXLENGTH=40></TD></TR>";
  echo "<TR><TD>$l_mt_message:</TD><TD><TEXTAREA NAME=content ROWS=5 COLS=40></TEXTAREA></TD></TR>";
  echo "<TR><TD></TD><TD><INPUT TYPE=SUBMIT VALUE=$l_mt_send><INPUT TYPE=RESET VALUE=Clear></TD>";
  echo "</TABLE>";
  echo "</FORM>";
}
else
{
  echo "$l_mt_sent<BR><BR>";
  $content = htmlspecialchars($content);
  $subject = htmlspecialchars($subject);

  $res = $db->Execute("SELECT * FROM $dbtables[ships] WHERE character_name='$to'");
  $target_info = $res->fields;
  $db->Execute("INSERT INTO messages (sender_id, recp_id, subject, message) VALUES ('".$playerinfo[ship_id]."', '".$target_info[ship_id]."', '".$subject."', '".$content."')");
  #using this three lines to get recipients ship_id and sending the message -- blindcoder

}

TEXT_GOTOMAIN();

include("footer.php");

?> 

