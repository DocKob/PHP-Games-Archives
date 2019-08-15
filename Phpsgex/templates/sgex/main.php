<?php
$quc= $DB->query("SELECT * FROM `".TB_PREFIX."units` WHERE `owner_id`= {$user->id} AND `where`= {$currentCity->id} AND `action`= 0");
$body.="<h2>Units in town</h2>
<table border='1' cellpadding='5'>";
$units= $currentCity->GetUnits();
if( count( $units ) ==0 ) $body.="<tr><td>NO UNITS IN TOWN!</td></tr>";
else{ 
	$body.="<tr><th>Unit</th> <th>Ammount</th></tr>";
	foreach( $units as $unt ){ /** @var Unit $unt */
		$body.="<tr><td>{$unt->unit->name}</td> <td>{$unt->quantity}</td></tr>";
	}
}
$body.="</table>

<h2>Units movements</h2><table border='1' cellpadding='5'>";
$qrvm= $DB->query("SELECT * FROM `".TB_PREFIX."units` WHERE `owner_id`= {$user->id} AND (`from`= {$currentCity->id} or `to`= {$currentCity->id})");
if( $qrvm->num_rows ==0 ) $body.="<tr><td>NO MOVEMENTS!</td></tr>";
else {
	$body.="<tr><td>Unit</td> <td>Ammount</td> <td>Destination</td> <td>Time left</td></tr>";
	while( $row= $qrvm->fetch_array() ){
        $unitdata= new UnitData( $row['id_unt'] );
        $destination= City::LoadCity( $row['to'] );
		$body.="<tr><td>{$unitdata->name}</td> <td>{$row['uqnt']}</td> <td><a href='?pg=map&gal={$destination->mapPosition->x}&sys={$destination->mapPosition->y}'>{$destination->name}</a></td> <td>".SecondsToTimeString( $row['time'] -GetTimeStamp() )."</td></tr>";
	}
}
$body.="</table>";
?>