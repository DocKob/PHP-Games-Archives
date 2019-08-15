<?php 
/* --------------------------------------------------------------------------------------
                                      PROFILE
   Credits         : phpSGEx by Aldrigo Raffaele
   Last modified by: raffa50 09.04.2014
   Comments        : custom picture
-------------------------------------------------------------------------------------- */

/** @var User $user */
if( isset($_POST['allyinvite']) && $user->allyId != null ){ //ally invite
    $ally= new Ally( $user->allyId );
    $content= $ally->inviteText;
    $user->SendMessage( (int)$_POST['usr'], $ally->name." Ally invite", $content, 3, $ally );
}

// template \\
$body="<form method='get' action=''> <input type='hidden' name='pg' value='profile'>
Search user: <input type='text' name='snusr'> <input type='submit' value='search'> </form>";

if( isset($_GET['snusr']) ){ //search user
	$suq= $DB->query("SELECT * FROM `".TB_PREFIX."users` WHERE `username` LIKE '%".CleanString($_GET['snusr'])."%'");
	
	$body.="<h2 class='news-title'><span class='news-date'></span>User founded</h2><div class='news-body'>";
	$body.="<table>";
	while( $riga= $suq->fetch_array() ){
			$body.="<tr><td><a href='?pg=profile&usr=".$riga['id']."'>".$riga['username']."</a></td>";
			if( isset($_GET['inv']) ) $body.="<td><a href='?plsinv=".$riga['id']."'><input type='button' value='invite'></a></td>";
			$body.="</tr>";
	}
	$body.="</table></div>";
}

if( isset($_GET['usr']) ){ //show user info
    if( (int)$_GET['usr'] == $user->id ) $otherUser= $user;
	else $otherUser= new User( (int)$_GET['usr'] );

    $ncp2= $DB->query("SELECT * FROM `".TB_PREFIX."city` WHERE `id` =".$otherUser->capitalCityId)->fetch_array();
    $qsur= $DB->query("SELECT `rname`, `img` FROM `".TB_PREFIX."races` WHERE `id`= ".$otherUser->raceId)->fetch_array();
	
	$online=" [Offline]";
	if( $otherUser->IsOnline() ) $online = " [Online]";
	$body.="<h2 class='news-title'><span class='news-date'></span>".$lang['reg_user']." ".$otherUser->name.$online."</h2><div class='news-body'>
	<br>";
	if( $config['cusr_pics'] ) {
		if( file_exists("img\\userpics\\i".$otherUser->id.".jpg") ) $body.="<img src='img\\userpics\\i".$otherUser->id.".jpg'>";
		else if ( file_exists("img\\userpics\\i".$otherUser->id.".png") ) $body.="<img src='img\\userpics\\i".$otherUser->id.".png'>";
	}
	$body.="<br>
	<table border='1' cellspacing='3' cellpadding='3'> <tr><th>".$lang['reg_race'].":</th> <td>".$otherUser->name."</td></tr>
	<tr><th>".$lang['prf_points'].":</th> <td>".$otherUser->points."</td></tr>
	<tr><th>".$lang['prf_last_login'].":</th> <td>".$otherUser->lastLogin."</td></tr>
	<tr><th>".$lang['prf_alliance'].":</th> <td>";
	// ally name
	if( $otherUser->allyId ==0 ) $body .= $lang['prf_no_ally'];
	else{
        $aan= $DB->query("SELECT * FROM `".TB_PREFIX."ally` WHERE `id` =".$otherUser->allyId)->fetch_array();
        $body.="<a href='?pg=ally&showally=".$otherUser->allyId."'>".$aan['name']."</a>";
	}
	
	if( $otherUser->allyId ==0 && $user->allyId !=0 ) $body.= "<div> <form action='' method='post'>
	<input type='hidden' name='usr' value='".$otherUser->id."'><input type='submit' name='allyinvite' value='Invite'></form> </div>";
	
	$body.="</td> </tr>"; //you can't send a message to yourself
	if( $otherUser->id != $user->id ) $body.="<tr> <td colspan='2'><form method='get' action=''> <div align='center'> <input type='hidden' name='pg' value='message'><input type='hidden' name='act' value='smsg'> <input type='hidden' name='ito' value='".$otherUser->id."'> <input type='submit' value='".$lang['prf_send_pm']."'> </div> </form>";
	$body.="</td></tr>";

    if( $config['FLAG_SHOWUSRMAIL'] || $user->id == $otherUser->id || $user->rank >= 1 || $otherUser->rank >= 1 )
        $body.="<tr><th>Email: </th> <td>".$otherUser->email."</td> </tr>";

	$body.="</table></div>";
	
	//show user city(s)
	$body.="<h2 class='news-title'><span class='news-date'></span>".$lang['prf_cityof']." ".$otherUser->name."</h2><div class='news-body'><table cellpadding='3' border='1'>";
	$qrsc= $DB->query("SELECT * FROM `".TB_PREFIX."city` WHERE `owner` =".$otherUser->id);
	while( $riga= $qrsc->fetch_array() ){
		if( MAP_SYS ==1 ) $pos = "<a href='?pg=map&gal=".$riga['x']."&sys=".$riga['y']."'>".$riga['x']." ".$riga['y']." ".($riga['z']-1)."</a>";
		else if( MAP_SYS ==2 ){
			$pos= "<a href='?pg=map2&x=".$riga['x']."&y=".$riga['y']."'>".$riga['x']." ".$riga['y']."</a>";
		}
		
		$body.="<tr><td>".$riga['name']."</td><td>".$pos."</td></tr>";	
	}
	$body.="</table></div>";
	
}
?>
