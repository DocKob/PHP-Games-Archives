<?php
require_once("Requirements.php");

//this class represents t_builds, it's not a builded building in a city
class BuildingData {
	public $id, $raceId, $name, $function, $produceResourceId, $image, $description, $buildTime, $timeMultiplier, $gainPoints, $maxLevel;
	
	public function BuildingData( $_id ){
		global $DB;
		$query = $DB->query("select * from ".TB_PREFIX."t_builds where id =".(int)$_id);
		if( $query->num_rows == 0 ) throw new Exception("Invalid build id ".$_id);
		$building = $query->fetch_array();
		
		$this->id = (int)$_id;
		$this->raceId = $building["arac"];
		$this->name = $building["name"];
		$this->function = $building["func"];
		$this->produceResourceId = $building["produceres"];
		$this->image = $building["img"];
		$this->description = $building["desc"];
		$this->buildTime = $building["time"];
        $this->timeMultiplier= $building["time_mpl"];
        $this->maxLevel = $building['maxlev'];
	}
	
	//returns a indexed list (by resource id) with cost foreach resouce, this list will be long as the number of resources in resdata
	public function GetBuildCosts( $_level ){
		if( $_level <= 0 ) throw new Exception("Level <= 0");
		
		global $DB;
		$costs = Array();
		$resd= $DB->query("SELECT * FROM `".TB_PREFIX."resdata`");
		while( $row= $resd->fetch_array() ){ 
			$qbudcost= $DB->query("SELECT * FROM `".TB_PREFIX."t_build_resourcecost` WHERE `build` = ".$this->id." AND `resource` =".$row['id']);
			if( $qbudcost->num_rows >0 ){
				$acst= $qbudcost->fetch_array();
				$costs[ $row['id'] ]= $_level *$acst['cost'] *$acst['moltiplier'];	
			} else $costs[ $row['id'] ] = 0;
		}
		
		return $costs;
	}

    /**
     * @return array
     */
	public function GetBuildingsRequirements(){
		global $DB;
		$qr= $DB->query("SELECT * FROM `".TB_PREFIX."t_build_reqbuild` WHERE `build` = ".$this->id);
		
		$requisites = Array();
		if( $qr->num_rows ==0 ) return $requisites; //no requisites!

		while( $row = $qr->fetch_array() ){
            $requisites[] = new BuildingRequirement( $row['reqbuild'], $row['lev'] );
		}
		return $requisites;
	}

	public function GetResearchRequirements(){
		global $DB;
		$qr= $DB->query("SELECT * FROM `".TB_PREFIX."t_build_req_research` WHERE `build` = ".$this->id);
		
		$requisites = Array();
		if( $qr->num_rows ==0 ) return $requisites; //no requisites!

		while( $row = $qr->fetch_array() ){
            $requisites[] = new ResearchRequirement( $row['reqresearch'], $row['lev'] );
		}
		return $requisites;
	}

    /**
     * @param int $_nextLevel
     * @return int build time for next level
     * @throws Exception
     */
	public function GetBuildTime( $_nextLevel ){
		if( $_nextLevel <= 0 ) throw new Exception("Level <= 0");
		global $config;

        $time = ( $this->buildTime * $this->timeMultiplier * $_nextLevel ) / $config['buildfast_molt'];
		return (int)$time;
	}
};

class Building {
    public $buildingData, $level, $buildEndTime;

    public function Building( BuildingData $buildingData, $level = 0, $buildEndTime = 0 ){
        $this->buildingData = $buildingData;
        $this->level = $level;
        $this->buildEndTime = $buildEndTime;
    }
};
?>