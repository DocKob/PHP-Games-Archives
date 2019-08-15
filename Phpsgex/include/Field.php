<?php
class Field {
    public $buildId, $level, $build_time;

    public function Field( $_buildId, $_level, $_build_time= 0 ){
        $this->buildId= $_buildId;
        $this->level= $_level;
        $this->build_time= $_build_time;
    }

    public function IsBuilt(){
        return $this->build_time <= 0;
    }
};