<?php 
if( isset($secure) ){
    /** @var LoggedUser $user */
    /** @var City currentCity */
	if( !isset($_GET['x']) ){
		$x= $currentCity->mapPosition->x;
		$y= $currentCity->mapPosition->y;
	} else{
		$x= (int)$_GET['x'];
		$y= (int)$_GET['y'];

        if( $x > $config['Map_max_x'] ) $x= $config['Map_max_x'];
        if( $y > $config['Map_max_y'] ) $y= $config['Map_max_y'];
	}
	//if there isn't a request for viewing a city
	if( isset($_GET['wci']) ){
		$scinfo= $DB->query("SELECT * FROM ".TB_PREFIX."city WHERE id =".(int)$_GET['wci'])->fetch_array();
		$ownname= $DB->query("SELECT username FROM ".TB_PREFIX."users WHERE id =".$scinfo['owner'])->fetch_array();
		$body.="<table width='50%' border='1' cellpadding='5'>
			<tr><td>City</td><td>".$scinfo['name']."</td></tr>
			<tr><td>Owner</td><td><a href='?pg=profile&usr=".$scinfo['owner']."'>".$ownname['username']."</a></td></tr>";
			
		if( $scinfo['owner'] != $user->id ) $body.="<tr><td>Actions</td><td><a href='?pg=battle&p=".(int)$_GET['wci']."'>Atack</a></td></tr>";
			
		$body.="</table>";	
	}
	else if( isset($_GET['field']) ){
		if( $DB->query("SELECT * FROM city WHERE x = $x AND y = $y")->num_rows ==0 ){
			$body="<table border='1' cellpadding='5' cellspacing='5'>
			<tr><td colspan='2'>Empity field</td></tr>
			<tr><td>X:</td><td>$x</td></tr>
			<tr><td>Y:</td><td>$y</td></tr>
			<tr><td colspan='2'> <a href='?pg=battle&colnize=-1&x=$x&y=$y'><img src='img/icons/colonize.png' title='colonize'></a> </td></tr>
			</table>";
		} else { header("Location: index.php?pg=map2"); exit; }
	}
	else {
		$body="<script>
		function vlinf(vl,pl,al){
			var p_vl = document.getElementById('vl');
			var p_pl = document.getElementById('pl'); 
			var p_al = document.getElementById('al');
			p_vl.innerHTML = vl;
			p_pl.innerHTML = pl;
			p_al.innerHTML = al;
		}
		</script>

		<p><form action='' method='get'><input type='hidden' name='pg' value='map2'>X: <input name='x' type='text' value='$x' size='3' /> y: <input name='y' type='text' value='$y' size='3' /> 
		<input name='' value='OK' type='submit' /></form></p>
	<p>
	<table border='2' cellpadding='9' cellspacing='9'>
	<tr><td>&nbsp;</td><td><div align='center'><a href='?pg=map2&x=$x&y=".($y-1)."'><img src='./templates/sgex/map2/map_n.png' /></a></div></td> <td>&nbsp;</td>
	</tr>
	<tr>
		<td valign='middle'><div align='center'><a href='?pg=map2&x=".($x-1)."&y=$y'><img src='./templates/sgex/map2/map_w.png' /></a></div></td>
		
		<td>";
		  $mplarge=10;
		  
		  for($k=0; $k< $mplarge; $k++){
				$body.= "<p style='margin: -3px'>";
				for($i=0; $i< $mplarge; $i++){
					$mqf= $DB->query('SELECT * FROM `'.TB_PREFIX.'city` WHERE `x` ='.($x+$i).' AND `y` ='.($y+$k).' LIMIT 1;');
					if( $mqf->num_rows !=0){
						$mpd= $mqf->fetch_array(); 
						$usrinfo= $DB->query('SELECT * FROM `'.TB_PREFIX.'users` WHERE `id` ='.$mpd['owner'].' LIMIT 1;')->fetch_array();
						
						$body.="<a title='".($x+$i).",".($y+$k)." | ".$mpd['name']."' href='?pg=map2&wci=".$mpd['id']."' onMouseOver='vlinf('".$mpd['name']."','".$usrinfo['username']."','".$usrinfo['ally_id']."');'><img src='templates/sgex/map2/v1.png' border='0' /></a>";
					} else {
						$body.="<a title='".($x+$i).",".($y+$k)."' href='?pg=map2&field=1&x=".($x+$i)."&y=".($y+$k)."'><img border='0' src='templates/sgex/map2/gras1.png' /></a>"; 
					}	
				}
			  
		  }
		  $body.="
		</td>
	
		<td><div align='center'><a href='?pg=map2&x=".($x+1)."&y=$y'><img src='./templates/sgex/map2/map_e.png' /></a></div></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><div align='center'><a href='?pg=map2&x=$x&y=".($y+1)."'><img src='./templates/sgex/map2/map_s.png' /></a></div></td>
		<td>&nbsp;</td>
	</tr>
	</table>
	</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>"; 
	}
}
?>