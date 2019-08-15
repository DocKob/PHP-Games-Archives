<?php
/* --------------------------------------------------------------------------------------
                                      BATTLE
   Credits         : phpSGEx by Aldrigo Raffaele
   Last modified by: rafa50 18.11.2013
   Comments        : fix colonization
-------------------------------------------------------------------------------------- */

if( isset($_GET['p']) ){
	$atkcity= (int)$_GET['p'];
	
	$qrc= $DB->query("SELECT * FROM ".TB_PREFIX."city WHERE id =".$atkcity);
	if( $qrc->num_rows >0 ){
		$acinfo= $qrc->fetch_array();
		
		if( $acinfo['owner'] == $user->id ){ header("Location: index.php"); exit; }
		
		$body="<h3>You are ataking ".$acinfo['name']." city</h3> <table border='1' cellpadding='5'>
		<form method='post' action='index.php'> <input type='hidden' name='atkcity' value='$atkcity'>";
        $units= $currentCity->GetUnits();
		foreach( $units as $unit ){ /** @var Unit $unit */
			$body.= "<tr><td>{$unit->unit->name} ({$unit->quantity})</td> <td><input name='tuid{$unit->unit->id}' type='number' min='0' value='0' max='{$unit->quantity}'></td></tr>";
		}
		$body.="<tr><td colspan='2'><input type='submit' value='Atack!' ></td></tr></form></table>";
	} else header("Location: index.php");
}

if( isset($_GET['colnize']) ){ //colonization page
	$qrcolunt= $DB->query("SELECT * FROM `".TB_PREFIX."t_unt` WHERE `type` = 'column' LIMIT 1;");
	if( $qrcolunt->num_rows > 0 ){
		$aidcolunt= $qrcolunt->fetch_array();
		$idcolunt= $aidcolunt['id'];
		
		$numcu= 0;
		$qrycu= $DB->query("SELECT * FROM `".TB_PREFIX."units` WHERE `id_unt` =$idcolunt AND `owner_id` =".$user->id." AND `where` =".$currentCity->id." AND `action` =0 LIMIT 1;");
		if( $qrycu->num_rows >0 ){
			$anumcu= $qrycu->fetch_array();
			$numcu= $anumcu['uqnt']; 
		}
		
		$qr; $x; $y; $z;
		if( MAP_SYS ==1 ){
			$x = (int)$_GET['gal'];
			$y = (int)$_GET['sys'];
			$z = (int)$_GET['colnize'];
			$qr = $DB->query("SELECT * FROM `".TB_PREFIX."city` WHERE `x` =$x AND `y` =$y AND `z` =$z LIMIT 1");
		} else {
			$x = (int)$_GET['x'];
			$y = (int)$_GET['y'];
			$z = 0;
			$qr = $DB->query("SELECT * FROM ".TB_PREFIX."city WHERE x = $x AND y = $y");
		}
		
		if( $qr->num_rows > 0 ) header("Location: index.php?pg=main&err=Field%20is%20not%20empity!"); //field is not empity!
		else {
			$body.="
			<form name='fc' id='fc' method='post' action='?pg=main' >
			<input type='hidden' name='x' value='$x'>
			<input type='hidden' name='y' value='$y'>
			<input type='hidden' name='z' value='$z'>
			Colonize:<br> ".$aidcolunt['name']." (colonizator): $numcu<br>";
			
			if( $numcu >0 ) $body.="<input action='?pg=main' type='submit' name='colonize' value='Colonize!' >";
			else $body.="<span class='Stile3'>You must have at least one ".$aidcolunt['name']."</span>";
			
			$body.="</form>";
		}
	}
}
?>