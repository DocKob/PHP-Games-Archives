<?php
if( !isset($secure) ){
	header("Location: ../index.php");
	exit;	
}

require_once("../include/User.php");

if( isset($_GET['editusr']) ){ //edit user
	$uid= (int)$_GET['editusr'];
	$qr= $DB->query("SELECT * FROM `".TB_PREFIX."users` WHERE `id` =".$uid);
	if( $qr->num_rows == 0 ) return; //TODO error reporting
	$usrinf= $qr->fetch_array();
	
	$body="<h3>User Info: ".$usrinf['username']."</h3>
	<form method='post' action='?pg=users'><input type='hidden' name='editusr' value='".$usrinf['id']."'>
	Email: <input type='email' name='email' value='".$usrinf['email']."' required><br>
	Rank: <input type='number' name='rank' min='0' max='3' value='".$usrinf['rank']."'><br>
	Points: <input type='number' name='points' min='0' value='".$usrinf['points']."'><br>
	<input type='submit' value='Save'>
	</form>";
	
	$body.="<h3>City of ".$usrinf['username']."</h3><table border='0' width='21%'>";
	
	$qrct= $DB->query("SELECT * FROM `".TB_PREFIX."city` WHERE `owner` =".$uid);
	while( $row= $qrct->fetch_array() ){
		$body.=	"<tr> <td>".$row['name']."<td> <td><a href='?pg=users&editcity=".$row['id']."'><img src='../img/icons/b_edit.png'></a></td> </tr>";
	}
	$body.="</table>";
} else if( isset($_GET['editcity']) ){ //edit city
	$cid= (int)$_GET['editcity'];
	$cinf= $DB->query("SELECT * FROM ".TB_PREFIX."city WHERE id=".$cid)->fetch_array();
	$body="<h3>Edit city</h3><form method='post' action='?pg=users&editcity=$cid'> <input type='hidden' name='editct' value='$cid'>";
	$body.="City name: <input type='text' name='name' value='".$cinf['name']."'><br>";
	
	$body.="<table border='1'><tr>";
	$resnam= GetResourcesNames();
	for( $i=1; $i<=count($resnam); $i++) $body.="<td>".$resnam[$i]."</td>";
	$body.="</tr><tr>";
	//show city res
	$resd= $DB->query("SELECT * FROM ".TB_PREFIX."resdata");
	while( $ftr= $resd->fetch_array() ){
		$crs= $DB->query("SELECT * FROM `".TB_PREFIX."city_resources` WHERE `city_id`= $cid AND `res_id`= ".$ftr['id'])->fetch_array();
		$body.="<td> <input type='text' name='res".$ftr['id']."' value='".$crs['res_quantity']."'> </td>";
	}
	$body.="</tr></table> <br><input type='submit' value='Save'></form>";
} else { //show all users
	$body="
	<form method='post' action='?pg=users'>Search user: <input type='text' name='searchusr' size='9'> <input type='submit' value='Search'></form>
	 <a href='?pg=users&showbanned=1'><input type='button' value='Show banned users'></a>
	<br><br><table border='1' width='50%'> <tr> <th>Name</th> <th>Points</th> <th>Edit</th> <th>Ban days<br>(-1 = forever)</th> </tr>";
	
	if( isset($_GET['showbanned']) ) $qr= $DB->query("SELECT * FROM ".TB_PREFIX."users join ".TB_PREFIX."banlist on (".TB_PREFIX."users.id = ".TB_PREFIX."banlist.usrid)");
	else if( !isset($_POST['searchusr']) ) $qr= $DB->query("SELECT * FROM `".TB_PREFIX."users`");
	else $qr= $DB->query("SELECT id FROM `".TB_PREFIX."users` WHERE `username` LIKE '".$_POST['searchusr']."'");
	
	if( $qr->num_rows ==0 ) $body.="<tr><td colspan='4'>BANLIST IS EMPTY!</td></tr>";
	else while( $row= $qr->fetch_array() ){
        $user= new User( $row['id'] );
		$body.="<tr> <td>".$user->name;
		if( $user->rank >0 ) $body.=" [<font color='#00FF00'>A</font>]";
		$body.="</td> <td>".$user->points."</td> <td><a href='?pg=users&editusr=".$user->id."'><img src='../img/icons/b_edit.png' alt='Edit user'></a></td>
			<td>";
			
			if( $user->rank <1 ){
				if( $user->IsBanned() ) $body.="<a href='?pg=users&pardon=".$user->id."'><img src='../img/icons/pardon.png' alt='Unban user'></a>";
				else $body.="<form method='post' action='?pg=users&ban=".$user->id."'><input type='number' name='bantime' min='-1' value='0'><a href='#' onclick='this.form.sumbit()'><img src='../img/icons/ban.png' alt='Ban user'></a></form>";
			}
			$body.=" </td> </tr>";	
	}
	$body.="</table>";
}
?>