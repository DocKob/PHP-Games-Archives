<?php
function race_select($race=0){
	global $DB;
	$qr= $DB->query("SELECT * FROM `".TB_PREFIX."races`");
	$racesel="<select name='race'><option value='0' ".(($race==0)?"selected":"").">All</option>";
	while( $row= $qr->fetch_array() ){
		$racesel.= "<option value='".$row['id']."' ".(($race==$row['id'])?"selected":"").">".$row['rname']."</option>";
	}
	return $racesel;
}

function budfun_select($fun="none"){
	$budfun="<select name='budfunc'>";
	foreach( bud_func() as $bf ){
		$budfun.="<option value='$bf' ".(($bf==$fun)?"selected":"").">$bf</option>";
	}
	$budfun.="</select>";
	return $budfun;
}

function produce_select($prodres=0){
	global $DB;
	$qr= $DB->query("select * from ".TB_PREFIX."resdata");
	$produce="<select name='prod'><option value='0' ".(($prodres==0)?"selected":"").">None</option>";
	while( $row= $qr->fetch_array() ){
		$produce.="<option value='".$row['id']."' ".(($prodres==$row['id'])?"selected":"").">".$row['name']."</option>";
	}
	$produce.="</select>";
	return $produce;
}

?>