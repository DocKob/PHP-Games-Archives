<?php
/* --------------------------------------------------------------------------------------
                                     MARKET
   Credits         : phpSGEx by Aldrigo Raffaele
   Last modified by: Raffa50 17.07.2013
   Comments        : Fix delete offer
-------------------------------------------------------------------------------------- */

if( isset($_POST['makeoffer']) ){
    $resreq= (int)$_POST['resreq'];
    $resreqqnt= (int)$_POST['resreqqnt'];
    $resoff= (int)$_POST['resoff'];
    $currentCity->Market_MakeOffer( (int)$_POST['resreq'], (int)$_POST['resreqqnt'],(int)$_POST['resoff'], (int)$_POST['resoffqnt'] );
}

if( isset($_GET['aceptoff']) ){
    $offid=(int)$_GET['aceptoff'];
    $currentCity->Market_AcceptOffer( $offid );
}

if( isset($_GET['deloff']) ){
    $currentCity->Market_DeleteOffer( (int)$_GET['deloff'] );
}

$rescbr="";
$resd= $DB->query("SELECT * FROM `".TB_PREFIX."resdata`");
while( $fres= $resd->fetch_array() ) {$rescbr.="<option value='".$fres['id']."'>".$fres['name']."</option>"; }

$body='';
//make offer
$body.="<form method='post' action='?pg=market'><table cellpadding='5' border='1'><tr><td>".$lang['mkt_offer_res']."</td><td>".$lang['mkt_need_res']."</td></tr> <tr><td><select name='resoff'>".$rescbr."</select> <input name='resoffqnt' type='number' min='1' value='1'></td><td><select name='resreq'>".$rescbr."</select> <input name='resreqqnt' type='number' min='1' value='1'></td><td><input type='submit' name='makeoffer' value='".$lang['mkt_make']."'></td></tr> </table></form> <br>";

$body.="<table width='512' border='1' cellspacing='0' cellpadding='5'>";
//show offers.
$arq= $DB->query("SELECT * FROM `".TB_PREFIX."market`");
if( $arq->num_rows >0 ){
	$body.="<tr><td><b>".$lang['mkt_offered']."</b></td><td><b>".$lang['mkt_wanted']."</b></td></tr>";
	while( $riga= $arq->fetch_array() ) {
		$res1nam= $DB->query("SELECT `name` FROM `".TB_PREFIX."resdata` WHERE `id` =".$riga['resoff']." LIMIT 1;")->fetch_array();
		$res2nam= $DB->query("SELECT `name` FROM `".TB_PREFIX."resdata` WHERE `id` =".$riga['resreq']." LIMIT 1;")->fetch_array();
		
		$body.="<tr><td><div align='center'>".$res1nam['name']."<br>".$riga['resoqnt']."</div></td><td><div align='center'>".$res2nam['name']."<br>".$riga['resrqnt']."</div></td><td>";
		
		if( $riga['city'] == $currentCity->id ) $body.="<a href='?pg=market&deloff=".$riga['id']."'>Delete</a>";
		else $body.="<a href='?pg=market&aceptoff=".$riga['id']."'>".$lang['mkt_accept']."</a>";
		
		$body.="</td></tr>";
	} 
}
else $body.="<tr><td colspan='2'>".$lang['mkt_no_offers']."</td></tr>";
$body.="</table>";
?>