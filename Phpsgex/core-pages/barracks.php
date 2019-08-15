<?php
/* --------------------------------------------------------------------------------------
                                       BARRACKS
   Credits         : phpSGEx by Aldrigo Raffaele
   Last modified by: raffa50 19.06.2013
   Comments        : added health
-------------------------------------------------------------------------------------- */

if( isset($_POST['itunt']) ) $currentCity->QueueUnits( new UnitData( (int)$_POST['itunt'] ), (int)$_POST['qunt'] );

$body="";
$head="<script src='templates/js/barraks.js'></script>";

// --------------------------------- SHOW CURRENT UNITS QUEUE ---------------------------
$body.="<table width='600' cellpadding='1'>";
$bqs= $DB->query("SELECT * FROM ".TB_PREFIX."unit_que WHERE `city` ='".$currentCity->id."'");
			
while( $rab= $bqs->fetch_array() ){	
	$rtimr= $rab['end']-GetTimeStamp();
	$cqbk= $DB->query("SELECT `name` FROM `".TB_PREFIX."t_unt` WHERE `id` =".$rab['id_unt'])->fetch_array();
		
	$body.= "<tr><td>".$cqbk['name']." (".$rab['uqnt'].")</td><td class='k'> <div id='blc' class='z'>".$rtimr."<br> 	<a href='?pg=barracks&amp;cancel_unit=".$rab['id_unt']."&amp;city=".$currentCity->id."'>Interrompere</a></div> <script language='JavaScript'>			pp = '".$rtimr."';";
	$body.=			"pk = '1';";
	$body.=			"pm = 'cancel';";
	$body.=		"pl = '".$currentCity->id."';";
	$body.=			"t();";
	$body.=	"</script></td></tr>";
}
$body.="</table>";

// --------------------------------------- SHOW UNITS -----------------------------------
$body.="<table width='100%' border='1' cellspacing='0' cellpadding='1'>";
$qrtunits= $DB->query("SELECT * FROM ".TB_PREFIX."t_unt WHERE race= ".$user->raceId." OR race is null");
while( $row= $qrtunits->fetch_array() ){
    $unit= new UnitData( $row['id'] );
	$body.= "<form action='' method='post'><input type='hidden' name='act' value='aunt'> <input type='hidden' name='itunt' value='".$unit->id."'>";
	
	$trainunt = true;
	$reqb="";
	$ar= $currentCity->CanTrain_BuildRequirements( $unit );
	if( count($ar) >0 ){
		$trainunt = false;
		$untreqs= $lang['bld_requirements']."<br>";
		for( $i=0; $i < count($ar); $i++ ){
			$bn= $DB->query("SELECT `name` FROM `".TB_PREFIX."t_builds` WHERE `id` =".$ar[$i]->buildId)->fetch_array();
			$untreqs.= $bn['name']." ".$lang['bld_level'].$ar[$i]->level."<br>";
		}
		$reqb= "<span class='Stile3'>".$untreqs."</span>";
	} else {
		$maxunt= $currentCity->GetMaxTrainableUnits( $unit );
		if ( $maxunt >0 ) {
			$trainb="<input name='qunt' id='qunt".$unit->id."' type='number' min='0' size='3' value='0' max='$maxunt' ><br><br>";
			$trainb.=Template::buttonsubmit($lang['amy_train']);		
			$trainb.="<br><br><span class='Stile1'>".$lang['amy_max_units'].": ".$maxunt."</span>";
		} else { 
			$trainunt = false; 
			$reqb= "<span class='Stile3'>".$lang['bld_no_resources']."</span>"; 
		}
	}
	
	$ar= $currentCity->CanTrain_ResearchRequirements( $unit );
	if( count($ar) >0 ){
		$trainunt = false;
		$untreqs= "";
		for( $i=0; $i < count($ar); $i++ ){
			$bn= $DB->query("SELECT name FROM ".TB_PREFIX."t_research WHERE id =".$ar[$i]->researchId)->fetch_array();
			$untreqs.= $bn['name']." ".$lang['bld_level'].$ar[$i]->level."<br>";
		}
		$reqb.=$untreqs;
	}

	$rescbr= "";
    $costs= $unit->GetTrainCosts();
	$resd= $DB->query("SELECT * FROM `".TB_PREFIX."resdata`");
    while( $riga= $resd->fetch_array() ){
        if ( (int)$costs[ $riga['id'] ] > 0 || $config['FLAG_SZERORES'] ) {
            if( $config['FLAG_RESICONS'] ) $rescbr .= "<img src='".IRES.$riga['ico']."'/> ";
            if( $config['FLAG_RESLABEL'] ) $rescbr .= $riga['name'] . ": ";

            $rescbr.= (int)$costs[ $riga['id'] ]." ";
        }
    }
	
	//number of units that do you have in your city
	$anul= $DB->query("SELECT * FROM ".TB_PREFIX."units WHERE id_unt='".$unit->id."' AND owner_id='".$user->id."' AND `where` = ".$currentCity->id)->fetch_array();
	$ncu= $anul['uqnt'];
	if( $ncu=="" ) $ncu=0;
	
	if( $trainunt || $config['FLAG_SUNAVALB'] ) {
		$body.="<tr><td class='l'><div align='center'> <img src='".IUNT.$unit->image."'></div></td>
		<td class='l'><div align='center'> ".$unit->name." (".$lang['amy_level'].": $ncu)<br> <span class='Stile1'>$rescbr</span><br><br>".$lang['amy_time']. ": ".SecondsToTimeString( $unit->trainTime )." Sec</div></td><td class='l'><div align='center'><i> \"".$unit->description."\"</i><br><br><img src='img/icons/health.gif'> ".$unit->health." <img src='img/icons/attack.gif'> ".$unit->attack." <img src='img/icons/defense.gif'> ".$unit->defence." <img src='img/icons/maneuver.gif'> ".$unit->speed."</div></td><td class='k'>";
		if( $trainunt ) $body.=$trainb;
		else $body .= Template::buttondisabled()."<br>" . $reqb;
	
		$body.="</td></tr></form>";
	}		

}

$body.="</table>";

?>