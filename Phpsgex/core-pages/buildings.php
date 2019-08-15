<?php
/* --------------------------------------------------------------------------------------
                                      BUILDINGS
   Credits         : phpSGEx by Aldrigo Raffaele
   Last modified by: Aldrigo Raffaele 09.07.2013
   Comments        : Fix maxlev check
-------------------------------------------------------------------------------------- */

if( CITY_SYS == 1 ) {
    if( isset( $_REQUEST['bid'] ) )
        $currentCity->QueueBuild( new BuildingData( (int)$_REQUEST['bid'] ) );
} else {
    if( !isset( $_REQUEST['field'] ) ){
        header("Location: index.php");
        exit;
    }
    $field= (int)$_REQUEST['field'];
    if( isset( $_REQUEST['bid'] ) )
        $currentCity->QueueBuild( new BuildingData( (int)$_REQUEST['bid'] ), $field );
}

if( isset( $_GET['cancel'] ) ){
    $queue_id= (int)$_GET['cancel'];
    $currentCity->Building_Cancel( $queue_id );
}

$body="";
$head="<script src='templates/js/buildings.js'></script>";

// --------------------------------- SHOW CURRENT BUILDING QUEUE ------------------------
$body.="<table width='600' cellpadding='1'>";
$bqs= $DB->query("SELECT * FROM ".TB_PREFIX."city_build_que WHERE `city`= ".$currentCity->id);
			
while( $rab= $bqs->fetch_array() ){	
	$rtimr= $rab['end']-GetTimeStamp();
	$cqbk= $DB->query("SELECT `name`, `func` FROM `".TB_PREFIX."t_builds` WHERE `id`= ".$rab['build'])->fetch_array();
		
	$lp = $currentCity->GetBuildLevel($rab['build']) +1;
	$body.= "<tr><td>{$cqbk['name']} ({$lang['bld_level']}: $lp)</td><td class='k'> <div id='blc' class='z'>$rtimr<br> <a href='?pg=buildings&cancel={$rab['id']}'>{$lang['bld_cancel']}</a></div> <script> pp = '$rtimr'; pk = '{$rab['id']}'; pm = 'cancel'; pl = '{$currentCity->id}'; t(); </script></td></tr>";
}
$body.="</table>";


$body.="<table width='100%' border='1' cellspacing='0' cellpadding='1'>";

if( CITY_SYS == 1 )
	$qrbuilds= $DB->query("SELECT * FROM ".TB_PREFIX."t_builds WHERE `arac` is null OR `arac`= ".$user->raceId);
else{
	$fields= $currentCity->GetFieldsBuildings();
	$fbud= $fields[ $field ];
	if( $fbud == null ) $qrbuilds= $DB->query("SELECT * FROM ".TB_PREFIX."t_builds WHERE `arac` is null OR `arac`= ".$user->raceId);
	else {
		$qrbuilds= $DB->query("select * from ".TB_PREFIX."t_builds where id= ".$fbud->buildId);
	}
}


while( $ftbudrow= $qrbuilds->fetch_array() ){
    $build= new BuildingData( $ftbudrow['id'] );
	if( CITY_SYS == 1 ) {
		$lev= $currentCity->GetBuildLevel( $build->id, false );
		$nextLevel= $currentCity->GetBuildLevel($build->id, true) + 1;
	} else {
		$lev= $currentCity->GetBuildLevel( $build->id, false, $field );
		$nextLevel= $currentCity->GetBuildLevel($build->id, true, $field) + 1;
	}
	//resource info
	$rescbr="";
	$costs= $build->GetBuildCosts( $nextLevel );
	$resd= $DB->query("SELECT * FROM `".TB_PREFIX."resdata`");
	while( $riga= $resd->fetch_array() ){ 		
		if ( (int)$costs[ $riga['id'] ] > 0 || $config['FLAG_SZERORES'] ) {
			if( $config['FLAG_RESICONS'] ) $rescbr .= "<img src='". IRES . $riga['ico'] . "'/> ";														
			if( $config['FLAG_RESLABEL'] ) $rescbr .= $riga['name'] . ": ";
			
			$rescbr.= (int)$costs[ $riga['id'] ]." ";
		}
	}
	//can build?
	if( $build->maxLevel ==0 || $nextLevel < $build->maxLevel ){
		if( $currentCity->CanBuild_ResourcesCheck( $build, $nextLevel ) ){
			$canbuild= true;
			
			$ar= $currentCity->CanBuild_BuildRequirements( $build );
			if( count($ar) !=0 ){
                $canbuild= false;
				$buildreqs= $lang['bld_requirements'].":<br>";
				for( $i=0; $i < count($ar); $i++ ){
					$bn= $DB->query("SELECT `name` FROM `".TB_PREFIX."t_builds` WHERE `id` =".$ar[$i]->buildId)->fetch_array();
					$buildreqs.= $bn['name']." ({$lang['bld_level']} {$ar[$i]->level})<br>";
				}
			}
	
			if ($canbuild) {
				$ctb="<div align='center'> <form method='post'>
					<input type='hidden' name='bid' value='".$build->id."'>
					<input type='submit' value='{$lang['bld_build']}'>
				</form></div>";
			} else {
				$ctb= "<div align='center'><span class='Stile3'>$buildreqs</span></div>";
			}
			
		} else {
            $canbuild= false;
			$ctb="<div align='center'><span class='Stile3'>{$lang['bld_no_resources']}</span></div>";
		}
	} else {
        $canbuild= false;
		$ctb="<div align='center'><span class='Stile3'>Max level!</span></div>";	
	}

    $tm= $currentCity->GetBuildTime( $build, $nextLevel );
	
	if( $config['FLAG_SUNAVALB'] || $canbuild ) {
		$body.="<tr><td class='l'><div align='center'> <img border='0' src='".IBUD.$build->image."'></div>
		</td><td class='k'><div align='center'> {$build->name} ({$lang['bld_level']}: $lev)</div>
		<span class='Stile1'>$rescbr</span><br>{$lang['bld_time']}: " . SecondsToTimeString($tm) . " </td>
		<td class='k'><div align='center'><i> \"{$build->description}</i>\"</div></td><td class='k'>$ctb</td></tr>";
	}

}
	
$body.="</table>";

?>