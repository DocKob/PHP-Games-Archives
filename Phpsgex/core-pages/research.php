<?php
/* --------------------------------------------------------------------------------------
                                      RESEARCH
   Credits         : phpSGEx by Aldrigo Raffaele
   Last modified by: Aldrigo Raffaele 09.07.2013
   Comments        : Fix maxlev check
-------------------------------------------------------------------------------------- */

if( isset($_REQUEST['research']) ) $currentCity->QueueResearch( new ResearchData( (int)$_REQUEST['research'] ) );

/** @var User $user */
$body="";
$head="<script src='templates/js/research.js'></script>";

// --------------------------------- SHOW CURRENT RESEARCH QUEUE ------------------------
$body.="<table width='600' cellpadding='1'>";
$rqs= $DB->query("SELECT * FROM ".TB_PREFIX."city_research_que WHERE `city`= ".$currentCity->id);
			
while( $rab= $rqs->fetch_array() ){	
	$rtimr= $rab['end']-GetTimeStamp();
	$cqbk= $DB->query("SELECT `name` FROM `".TB_PREFIX."t_research` WHERE `id` =".$rab['res_id'])->fetch_array();	
	$lp= $user->GetResearchLevel($rab['res_id']) +1;
	$body.= "<tr><td>".$cqbk['name']." (".$lang['lab_level'].": ".$lp.")</td><td class='k'> <div id='blc' class='z'>".$rtimr."<br> <a href='?pg=research&amp;listid=1&amp;cmd=cancel&amp;city=1'>" . $lang['lab_cancel'] . "</a></div> <script language='JavaScript'> pp = '".$rtimr."'; pk = '1'; pm = 'cancel'; pl = '".$currentCity->id."'; t(); </script></td></tr>";
}
$body.="</table>";
	
// -------------------------------------- SHOW RESEARCHES -------------------------------
	$body.="<table width='100%' border='1' cellspacing='0' cellpadding='1'>";
	
	$qrresearch= $DB->query("SELECT * FROM ".TB_PREFIX."t_research WHERE `arac` is null OR `arac` =".$user->raceId);
	while( $researchrow= $qrresearch->fetch_array() ){
        $research= new ResearchData( (int)$researchrow['id'] );
		$lev= $user->GetResearchLevel( $research->id );
        $nextLev= $user->GetResearchLevel( $research->id, true ) +1;
		$timend= $user->GetResearchTime( $research, $nextLev );
		//resource info
		$rescbr="";
        $costs= $research->GetResearchCosts( $nextLev );
        $resd= $DB->query("SELECT * FROM `".TB_PREFIX."resdata`");
        while( $riga= $resd->fetch_array() ){
            if ( (int)$costs[ $riga['id'] ] > 0 || $config['FLAG_SZERORES'] ) {
                if( $config['FLAG_RESICONS'] ) $rescbr .= "<img src='". IRES . $riga['ico'] . "'/> ";
                if( $config['FLAG_RESLABEL'] ) $rescbr .= $riga['name'] . ": ";

                $rescbr.= (int)$costs[ $riga['id'] ]." ";
            }
        }
		
		if( $research->maxLevel ==0 || $lev < $research->maxLevel ){
			if( $currentCity->CanResearch_ResourcesCheck( $research, $nextLev ) ){
				$canResearch= true;
				$ar= $currentCity->CanResearch_BuildRequirements( $research );
				if( count($ar) !=0 ){
					$canResearch= false;
					$buildreqs= $lang['lab_requirements'].":<br>";
					for( $i=0; $i < count($ar); $i++ ){
						$bn= $DB->query("SELECT `name` FROM `".TB_PREFIX."t_builds` WHERE `id` =".$ar[$i]->buildId)->fetch_array();
						$buildreqs.= $bn['name']." ".$lang['lab_level'].$ar[$i]->level."<br>";
					}
				}
				
				if ($canResearch) {
					$contb= "<form method='post'>
						<input type='hidden' name='research' value='".$research->id."'>
						<input type='submit' value='".$lang['lab_research']."'>
					</form>";
				} else {
					$contb= "<span class='Stile3'>".$buildreqs."</span>";
				}
			
			} else {
				$canResearch= false;
				$contb= $lang['bld_no_resources'];
			}
		} else {
			$canResearch= false;
			$contb="<div align='center'><span class='Stile3'>Max level!</span></div>";	
		}
		
		if( $config['FLAG_SUNAVALB'] || $canResearch ) {
			$body.="<tr><td><img src='img/research/".$research->image."'></td><td>".$research->name." (". $lang['lab_level'] . ": $lev)<br><span class='Stile1'>$rescbr </span><br>Time: ".SecondsToTimeString($timend)."</td> <td>$contb</td></tr>";
		}

	}
	
	$body.="</table>";
?>