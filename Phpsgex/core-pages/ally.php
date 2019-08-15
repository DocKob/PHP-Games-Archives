<?php

/* --------------------------------------------------------------------------------------
                                      ALLIANCES
   Credits         : phpSGEx by Aldrigo Raffaele
   Last modified by: Raffa50 24.03.2015
   Comments        : Can kick user from ally
-------------------------------------------------------------------------------------- */
/** @var LoggedUser $user */
if( isset($_GET['allyleave']) ) { //send a message to the admin that says that the player left
    //$ainf= $DB->query("SELECT owner FROM ally WHERE id =".$user->allyId)->fetch_array();
    //$me->sendmsg( $ainf['owner'], "Player left ally", "Player ".$user->id." left the ally", 2 );
    $DB->query("UPDATE `".TB_PREFIX."users` SET `ally_id` = null WHERE `id` =".$user->id);
    $user->allyId= null;
}

if( isset($_POST['createally']) && $user->allyId ==0 ) {
	try {
		Ally::CreateAlly($user, CleanString($_POST['name']));
	} catch(NameAlreadyInUseException $ex){
		$errMsg= $ex->getMessage(); //uhm...
	}
}

if( $user->allyId == null && !isset($_GET['showally']) ){
	// if no ally
	$body.="<p>".$lang['aly_no_alliance']."</p>
	<h2 class='news-title'><span class='news-date'></span>".$lang['aly_ally_create']."</h2>
<div class='news-body'> <form method='post' action=''> <input type='hidden' name='pg' value='ally'><label>".$lang['aly_ally_name'].": <input type='text' name='name' id='aname' size='20'></label><label> <input type='submit' name='createally' value='".$lang['aly_create']."'></label></form></div>"; 
	$body.= "<h2 class='news-title'>".$lang['aly_search']."</h2><div class='news-body'><br><p>".$lang['aly_join']."<form method='get' action=''> <input type='hidden' name='pg' value='ally'> ".$lang['aly_ally_name'].": <input type='text' name='searchally' id='aname' size='20'> <input type='submit' value='".$lang['aly_search']."'></form></div>"; 	
} else { //you are in an alliance, show alliance info
	if( isset($_GET['showally']) ) $allyid= (int)$_GET['showally'];
	else $allyid= $user->allyId;
    $ally= new Ally( $allyid );

    if( isset($_GET['invid']) && $user->allyId == null ){ //enjoy ally invite
        //invite must exist!
        if( $DB->query("SELECT id FROM ".TB_PREFIX."user_message WHERE id= ".(int)$_GET['invid'])->num_rows >0 ){
            $DB->query("UPDATE `".TB_PREFIX."users` SET `ally_id`= ".$ally->id." WHERE `id`= ".$user->id);
            $user->allyId= $ally->id;
            $DB->query("DELETE FROM ".TB_PREFIX."user_message WHERE id =".(int)$_GET['invid']);
        }
    }

	if( isset( $_GET['allykick'] ) && $ally->ownerId == $user->allyId ){ //ally kick
        $ally->KickUser( (int)$_GET['allykick'] );
	}

    if( isset($_POST['saveally']) && $ally->ownerId == $user->allyId ) { //edit ally
        $desc= CleanString( $_POST['allydesc'] );
        $nam= CleanString( $_POST['name'] );
        $allyinvitemsg= CleanString( $_POST['allyinvitemsg'] );
        $DB->query("UPDATE ".TB_PREFIX."ally SET `desc`= '$desc', `name`= '$nam', invite_text= '$allyinvitemsg' WHERE `id`= ".$ally->id);
    }
	
	if( !isset($_GET['editally']) ){ //show ally
		if( $ally->ownerId == $user->id ) $body.="<a href='?pg=ally&editally=1'><input type='button' value='Edit'></a>";
		if( !isset($_GET['showally']) ) $body.= " <a href='?pg=ally&allyleave=1'><input type='button' value='Leave ally'></a>";
		$body.= "<table border='1' width='100%'><tr><td colspan='2'><h3>Alliance: ".$ally->name." (".$ally->GetPoints()." points)</h3></td></tr>
		<tr> <td width='50%'>".$ally->description."</td> <td><h4>Alliance members:</h4><br>";
			
		//show users in the ally
		$allyUsers= $ally->GetMembers();
        foreach( $allyUsers as $allyUser ){ /** @var User $allyUser */
            $body.= "<div><a href='?pg=profile&usr=".$allyUser->id."'>".$allyUser->name."</a>";
            if( $ally->ownerId == $user->id && $allyUser->id != $user->id ) $body.="<a href='?pg=ally&allykick=".$allyUser->id."'><img title='kick' src='img/icons/x.png'></a>";
            $body.="</div>";
        }
	} else { //edit ally
		$head.="<script type='text/javascript' src='templates/js/nicEdit.js'></script> <script type='text/javascript'>bkLib.onDomLoaded(nicEditors.allTextAreas);</script>";
		$body.="<form method='post' action='?pg=ally'> <input type='hidden' name='saveally' value='".$ally->id."'>
			Name: <input type='text' name='name' value='".$ally->name."'> <br><br>
			Ally description: <br>
			<textarea name='allydesc' cols='45' rows='5'>".$ally->description."</textarea><br>
			Ally Invite Message: <br>
			<textarea name='allyinvitemsg' cols='45' rows='5'>".$ally->inviteText."</textarea><br>

			<input type='submit' value='save'>
		</form>";	
	}
		
	$body.= "</td> </tr>";
	$body.="</table>";
}

if( isset($_GET['searchally']) ){
	$alnm= CleanString($_GET['searchally']);
	$qr= $DB->query("SELECT * FROM `".TB_PREFIX."ally` WHERE `name` LIKE '%$alnm%'");
	if( $qr->num_rows ==0 ) $body.="<h3>No ally found!</h3>";
	else{
		$body.="<br><table border='1'>";
		while( $row= $qr->fetch_array() ){
			$body.="<tr><td><a href='?pg=ally&showally=".$row['id']."'>".$row['name']."</a></td></tr>";	
		}
		$body.="</table>";
	}
}
?>