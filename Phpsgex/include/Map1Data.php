<?php

/**
 * Class MapCoordinates
 * used for map system 1 and 2
 */
class MapCoordinates {
    public $x, $y, $z;

    public function MapCoordinates($x, $y, $z = 0){
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    public function GetDistance( MapCoordinates $other ){
        return sqrt( pow( $this->x -$other->x, 2 ) + pow( $this->y -$other->y, 2 ) );
    }
};