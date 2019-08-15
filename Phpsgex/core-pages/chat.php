<?php
/* --------------------------------------------------------------------------------------
                                      CHAT
   Credits         : phpSGEx by Aldrigo Raffaele
   Last modified by: Raffa50 18.11.2013
   Comments        : Moved box style to css
-------------------------------------------------------------------------------------- */

$head.="<script type='application/javascript' src='templates/js/chat-js.js'></script>";
$head.=" <script type='text/javascript' src='templates/js/nicEdit.js'></script> <script type='text/javascript'>
//<![CDATA[
bkLib.onDomLoaded(function() {
	new nicEditor({buttonList : ['fontSize','bold','italic','underline','strikeThrough','forecolor','html']}).panelInstance('msg');
});
//]]>
</script>";

$body="<p><div class='box' style='width: 90% !important;' id='chatlog'>";
//chat
$result= $DB->query("SELECT * FROM ".TB_PREFIX."chat ORDER BY `id` DESC");
if( $result ) {
	$i=0;
	while($riga= $result->fetch_array() ) {
		$usrinf= new User( $riga['usrid'] );
		$body.= "<a href='?pg=profile&usr=".$riga['usrid']."' target='_blank'>".$usrinf->name."</a> : ".$riga['msg']."<br>";
	}
} 

$body.=" </div></p><p>&nbsp;</p>".$lang['msg_mp'].": <label><p id='msg' class=' ' contenteditable='true' style='border: 2px solid #000'></p> </label><label>&nbsp;&nbsp; <input type='button' value='".$lang['msg_send']."' onclick=\"javascript: chat_sendm();\"></label>";

$blol="onload='javascript: chat_rel();'";

?>