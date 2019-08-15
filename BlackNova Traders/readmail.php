<?
include("config.php");
updatecookie();

include("languages/$lang");
$title=$l_readm_title;
include("header.php");

bigtitle();

connectdb();

if(checklogin())
{
  die();
}

$res = $db->Execute("SELECT * FROM $dbtables[ships] WHERE email='$username'");
$playerinfo = $res->fields;

if ($action=="delete")
{
 $db->Execute("DELETE FROM $dbtables[messages] WHERE ID='".$ID."' AND recp_id='".$playerinfo[ship_id]."'");
}
else if ($action=="delete_all")
{
  $db->Execute("DELETE FROM $dbtables[messages] WHERE recp_id='".$playerinfo[ship_id]."'");
}

$cur_D = date("Y-m-d");
$cur_T = date("H:i:s");

$res = $db->Execute("SELECT * FROM $dbtables[messages] WHERE recp_id='".$playerinfo[ship_id]."' ORDER BY sent DESC");
?>
<div align="center">
  <table border="0" cellspacing="0" width="70%" bgcolor="silver" cellpadding="0">
    <tr>
      <td width="100%">
        <div align="center">
          <center>
          <table border="0" cellspacing="1" width="100%">
            <tr>
              <td width="100%" bgcolor="black">
                <div align="center">
                  <table border="1" cellspacing="1" width="100%" bgcolor="gray" bordercolorlight="black" bordercolordark="silver">
                    <tr>
                      <td width="75%" align="left"><font color="white" size="2"><b><? echo $l_readm_center ?></b></font></td>
                      <td width="21%" align="center" nowrap><font color="white" size="2"><?echo "$cur_D" ?>&nbsp;<?echo "$cur_T" ?></font></td>
                      <td width="4%" align="center" bordercolorlight="black" bordercolordark="gray"><A HREF="main.php"><img alt="Click here to return to the main menu" src="images/c95x.gif" width="16" height="14" border="0"></a></td>
                    </tr>
                  </table>
                </div>
              </td>
            </tr>

<?
 if ($res->EOF)
 {
//  echo "$l_readm_nomessage";
?>
            <tr>
              <td width="100%" bgcolor="black" bordercolorlight="black" bordercolordark="silver">
                <div align="center">
                  <table border="1" cellspacing="1" width="100%" bgcolor="white" bordercolorlight="black" bordercolordark="silver">
                    <tr>
                      <td width="100%" align="center" bgcolor="white"><font color="red"><? echo $l_readm_nomessage ?></font></td>
                    </tr>
                  </table>
                </div>
              </td>
            </tr>
<?
 }
 else
 {
  $line_counter = true;
  while(!$res->EOF)
  {
   $msg = $res->fields;
   $result = $db->Execute("SELECT * FROM $dbtables[ships] WHERE ship_id='".$msg[sender_id]."'");
   $sender = $result->fields;
?>
            <tr>
              <td width="100%" align="center" bgcolor="black" height="4"></td>
            </tr>
            <tr>
              <td width="100%" bgcolor="black" bordercolorlight="black" bordercolordark="silver">
                <div align="center">
                  <table border="0" cellspacing="1" width="100%" bgcolor="gray" cellpadding="0">
                    <tr>
                      <td width="20%"><font color="white" size="2"><b><? echo $l_readm_sender; ?></b></td>
                      <td width="55%"><font color="yellow" size="2"><? echo $sender[character_name]; ?></font></td>
                      <td width="21%" align="center"><font color="white" size="2"><? echo "$msg[sent]" ?></font></td>
                      <td width="4%" align="center" bordercolorlight="black" bordercolordark="gray"><A class="but" HREF="readmail.php?action=delete&ID=<? echo $msg[ID]; ?>"><img src="images/c95x.gif" width="16" height="14" border="0"></a></td>
                    </tr>
                  </table>
                </div>
              </td>
            </tr>
            <tr>
              <td width="100%" bgcolor="black" bordercolorlight="black" bordercolordark="silver">
                <div align="center">
                  <table border="0" cellspacing="1" width="100%" bgcolor="gray" cellpadding="0">
                    <tr>
                      <td width="20%"><font color="white" size="2"><b><? echo $l_readm_captn ?></b></font></td>
                      <td width="80%"><font color="yellow" size="2"><? echo $sender[ship_name] ?></font></td>
                    </tr>
                  </table>
                </div>
              </td>
            </tr>
            <tr>
              <td width="100%" bgcolor="black" bordercolorlight="black" bordercolordark="silver">
                <div align="center">
                  <table border="0" cellspacing="1" width="100%" bgcolor="gray" cellpadding="0">
                    <tr>
                      <td width="20%"><font color="white" size="2"><b>Subject</b></font></td>
                      <td width="80%"><b><font color="yellow" size="2"><? echo $msg[subject]; ?></font></b></td>
                    </tr>
                  </table>
                </div>
              </td>
            </tr>
            <tr>
              <td width="100%" bgcolor="black" bordercolorlight="black" bordercolordark="silver">
                <div align="center">
                  <table border="1" cellspacing="1" width="100%" bgcolor="white" bordercolorlight="black" bordercolordark="silver">
                    <tr>
                      <td width="100%"><font color="black" size="2"><? echo nl2br($msg[message]); ?></font></td>
                    </tr>
                  </table>
                </div>
              </td>
            </tr>
            <tr>
              <td width="100%" align="center" bgcolor="black" bordercolorlight="black" bordercolordark="silver">
                <div align="center">
                  <table border="1" cellspacing="1" width="100%" bgcolor="gray" bordercolorlight="black" bordercolordark="silver" cellpadding="0">
                    <tr>
                      <td width="100%" align="center" valign="middle"><A class="but" HREF="readmail.php?action=delete&ID=<? echo $msg[ID]; ?>"><? echo $l_readm_del ?></A> |
        <A class="but" HREF="mailto2.php?name=<? echo $sender[character_name]; ?>&subject=<? echo $msg[subject] ?>"><? echo $l_readm_repl ?></A>
                      </td>
                    </tr>
                  </table>
                </div>
              </td>
            </tr>
<?
    $res->MoveNext();
  }
}
?>
            <tr>
              <td width="100%" align="center" bgcolor="black" height="4"></td>
            </tr>
            <tr>
              <td width="100%" align="center" bgcolor="#000000" height="4">
                <div align="center">
                  <table border="1" cellspacing="1" width="100%" bgcolor="#808080" bordercolorlight="#000000" bordercolordark="#C0C0C0" height="8">
                    <tr>
                      <td width="50%"><p align="left"><font color="#FFFFFF" size="2">Mail Reader</font></td>
                      <td width="50%"><p align="right"><font color="#FFFFFF" size="2"><A class="but" HREF="readmail.php?action=delete_all">Delete All</a></font></td>
                    </tr>
                  </table>
                </div>
              </td>
            </tr>

          </table>
          </center>
        </div>
      </td>
    </tr>
  </table>
</div>
<br>
<?
 //}

TEXT_GOTOMAIN();

include("footer.php");
?>
