<?php
/**
 * Used for CITY_SYS 2
 */

/** @var City $currentCity */
if( isset($_REQUEST['bid']) ) $currentCity->QueueBuild( new BuildingData( (int)$_REQUEST['bid'] ), (int)$_REQUEST['field'] );

$body.="<table border='1' cellpadding='0' cellspacing='0'>";

$fields= $currentCity->GetFieldsBuildings();
for( $filedId= 0; $filedId < MAX_FIELDS; ){
    $body.="<tr>";

    for( $i=0; $i< 5 && $filedId < MAX_FIELDS; $i++ ){
        $body.= "<td width='256px' height='128px'> ";

        $fb= $fields[ $filedId ]; /** @var Field $fb */
        if( $fb != null ){
            $build= new BuildingData( $fb->buildId );
            if( $fb->IsBuilt() )
                $body.="<a href='?pg=buildings&field=$filedId'><img src='img/structures/{$build->image}'></a>";
            else
                $body.="Building {$build->name}<br>Time left: {$build->buildTime}";
        } else {
            $body.="<a href='?pg=buildings&field=$filedId'>BUILD</a>";
        }

        $body.= " </td>";

        $filedId++;
    }

    $body.="</tr>";
}

$body.="</table>";

