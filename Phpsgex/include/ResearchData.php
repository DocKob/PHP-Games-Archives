<?php 

class ResearchData {
	public $id, $raceId, $name, $description, $image, $researchTime, $timeMultiplier, $gainPoints, $maxLevel;
	
	public function ResearchData( $_id ){
	    global $DB;
        $aqr= $DB->query("select * from ".TB_PREFIX."t_research where id = $_id")->fetch_array();

        $this->id= $_id;
        $this->raceId= $aqr['arac'];
        $this->name= $aqr['name'];
        $this->description= $aqr['desc'];
        $this->image= $aqr['img'];
        $this->researchTime= $aqr['time'];
        $this->timeMultiplier= $aqr['time_mpl'];
        $this->gainPoints= $aqr['gpoints'];
        $this->maxLevel= $aqr['maxlev'];
	}
	
	//returns a indexed list (by resource id) with cost foreach resouce, this list will be long as the number of resources in resdata
	public function GetResearchCosts( $_level ) {
		if( $_level <= 0 ) throw new Exception("Level <= 0");

        global $DB;
        $costs = Array();
        $resd= $DB->query("SELECT * FROM `".TB_PREFIX."resdata`");
        while( $row= $resd->fetch_array() ){
            $qbudcost= $DB->query("SELECT * FROM ".TB_PREFIX."t_research_resourcecost WHERE research = ".$this->id." AND `resource`= ".$row['id']);
            if( $qbudcost->num_rows >0 ){
                $acst= $qbudcost->fetch_array();
                $costs[ $row['id'] ]= $_level *$acst['cost'] *$acst['moltiplier'];
            } else $costs[ $row['id'] ] = 0;
        }

        return $costs;
    }
	
	public function GetBuildingsRequirements(){
        global $DB;
        $qr= $DB->query("SELECT * FROM ".TB_PREFIX."t_research_reqbuild WHERE research = ".$this->id);

        $requisites = Array();
        if( $qr->num_rows ==0 ) return $requisites; //no requisites!

        while( $row = $qr->fetch_array() ){
            $requisites[] = new BuildingRequirement( $row['reqbuild'], $row['lev'] );
        }
        return $requisites;
	}
	
	public function GetResearchRequirements(){
        global $DB;
        $qr= $DB->query("SELECT * FROM ".TB_PREFIX."t_research_req_research WHERE research = ".$this->id);

        $requisites = Array();
        if( $qr->num_rows ==0 ) return $requisites; //no requisites!

        while( $row = $qr->fetch_array() ){
            $requisites[] = new ResearchRequirement( $row['reqresearch'], $row['lev'] );
        }
        return $requisites;
	}
	
	public function GetResearchTime( $_nextLevel ){
		if( $_nextLevel <= 0 ) throw new Exception("Level <= 0");
        global $config;

        $time = ( $this->researchTime * $this->timeMultiplier * $_nextLevel ) / $config['researchfast_molt'];
        return (int)$time;
	}
};

class Research {
    public $researchData, $level, $researchEndTime;

    public function Research( ResearchData $researchData, $level = 0, $researchEndTime = 0 ){
        $this->researchData = $researchData;
        $this->level = $level;
        $this->researchEndTime = $researchEndTime;
    }
};

?>