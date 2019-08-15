<?php

class MissingRequirementsException extends Exception {

};

class BuildingRequirement {
    public $buildId, $level;

    public function BuildingRequirement( $buildId, $level ){
        $this->buildId = $buildId;
        $this->level = $level;
    }
};

class ResearchRequirement {
    public $researchId, $level;

    public function ResearchRequirement( $reasearchId, $level ){
        $this->researchId = $reasearchId;
        $this->level = $level;
    }
}
?>