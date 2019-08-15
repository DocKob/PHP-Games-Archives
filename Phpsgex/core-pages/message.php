<?php

/* --------------------------------------------------------------------------------------
                                     MESSAGE
   Credits         : phpSGEx by Aldrigo Raffaele
   Last modified by: Aldrigo Raffaele 08.07.2013
   Comments        : Fix redirect
-------------------------------------------------------------------------------------- */

if( isset($_POST['act']) && $_POST['act']=="messagesend" ) $user->SendMessage( (int)$_POST['ito'], CleanString($_POST['mtit']), CleanString( $_POST['freeRTE_content'] ) );
if( isset($_GET['delmsg']) ){
    $DB->query("DELETE FROM ".TB_PREFIX."user_message WHERE id =".(int)$_GET['delmsg']);
}

if( isset($_GET['act']) && $_GET['act']=="smsg" ) {
	$ito= (int)$_GET['ito'];
	$gnto= $DB->query("SELECT * FROM ".TB_PREFIX."users WHERE id=$ito")->fetch_array();
	$nto= $gnto['username'];
	// intialize text editor
	$body.= "<h2 class='news-title'><span class='news-date'></span>".$lang['msg_send']."</h2>";
	$body.= "<form method='post' action=''> <input type='hidden' name='act' value='messagesend'> <input type='hidden' name='ito' value='$ito'>";
	$body.= "<div class='news-body'><p>".$lang['msg_to'].": <input name='to' type='text' value='$nto' size='25' disabled> ".$lang['msg_title'].": <input name='mtit' type='text' size='15'></p>";
	$body.= "<script src='templates/js/nicEdit.js' type='text/javascript'></script>
<script type='text/javascript'>bkLib.onDomLoaded(nicEditors.allTextAreas);</script>";
	$body.="<textarea name='freeRTE_content' id='textarea' cols='45' rows='5'></textarea>";
	$body.= "<p><input type='submit' value='".$lang['msg_send']."'></p></form></div>";
} 

$body.="<table width='50%' border='0' cellspacing='1' cellpadding='1'><tr><td><a href='?pg=message'>".$lang['msg_all']."</a></td><td><a href='?pg=message&mtp=2'>".$lang['msg_reports']."</a></td><td><a href='?pg=message&mtp=3'>".$lang['msg_ally_inv']."</a></td></tr></table>";
$body.="<h2 class='news-title'><span class='news-date'></span>".$lang['msg_your_messages']."</h2><div class='news-body'><table width='300' border='1' cellspacing='0' cellpadding='0'>";
//show msg
$msgunreaded= $DB->query("SELECT * FROM `".TB_PREFIX."user_message` WHERE `to` =".$user->id." AND `read` =0");
$nummsg= $msgunreaded->num_rows;

if( $usermessage->num_rows ==0 ) $body.=$lang['msg_no_msgs'];
else {
	while( $riga= $usermessage->fetch_array() ) {
		$aiab="";
		if( $riga['mtype'] ==3 ) $aiab="<br><a href='?pg=ally&showally=".$riga['aiid']."&invid=".$riga['id']."'> <input type='button' value='".$lang['mkt_accept']."'></a>";
		
		if( $riga['from'] ==0 ) $fun= "System";
		else {
			$fua= $DB->query("SELECT username FROM ".TB_PREFIX."users WHERE `id` =".$riga['from']." LIMIT 1;")->fetch_array(); 	
			$fun= $fua['username'];
		}
		$body.= "<tr> <td rowspan='2'><a href='?pg=message&delmsg=".$riga['id']."'><img src='img/icons/x.png' /></a>";
		
		if( $riga['mtype']==1 ) $body.="<br><a href='?pg=message&act=smsg&ito=".$riga['from']."'><img src='img/icons/reply.png' /></a>";
		
		$body.="</td> <td><div align='center'> ".$lang['msg_from'].": $fun</div></td><td><div align='center'> ".$riga['mtit']."</td></tr> <tr><td colspan='2'><div align='center'>".$riga['text'].$aiab."</div></td></tr>";
		$DB->query("UPDATE `".TB_PREFIX."user_message` SET `read` = 1 WHERE `id` =".$riga['id']);
 	}  
}

$body.="</table></div>";
?>