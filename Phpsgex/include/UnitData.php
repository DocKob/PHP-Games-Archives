<?php

class UnitData {
	public $id, $speed, $attack, $defence, $health, $name, $description, $image, $trainTime;
	
	public function UnitData( $_id ){
		global $DB;
		$this->id = $_id;	
		$aquinfo= $DB->query("SELECT * FROM ".TB_PREFIX."t_unt WHERE id= $_id" )->fetch_array();
		$this->speed= $aquinfo['vel'];
		$this->attack= $aquinfo['atk'];
		$this->defence= $aquinfo['dif'];
		$this->health= $aquinfo['health'];
        $this->trainTime= $aquinfo['etime'];
        $this->name= $aquinfo['name'];
        $this->description= $aquinfo['desc'];
        $this->image= $aquinfo['img'];
	}

    public function GetTrainCosts( $_quantity = 1 ){
        if( $_quantity < 1 ) throw new Exception("quantity < 1");

        global $DB;
        $costs = Array();
        $resd= $DB->query("SELECT * FROM `".TB_PREFIX."resdata`");
        while( $row= $resd->fetch_array() ){
            $qbudcost= $DB->query("SELECT * FROM `".TB_PREFIX."t_unt_resourcecost` WHERE `unit` = ".$this->id." AND `resource` =".$row['id']);
            if( $qbudcost->num_rows >0 ){
                $acst= $qbudcost->fetch_array();
                $costs[ $row['id'] ]= $_quantity *$acst['cost'];
            } else $costs[ $row['id'] ] = 0;
        }

        return $costs;
    }

    public function GetBuildingsRequirements(){
        global $DB;
        $qr= $DB->query("SELECT * FROM `".TB_PREFIX."t_unt_reqbuild` WHERE `unit` = ".$this->id);

        $requisites = Array();
        if( $qr->num_rows ==0 ) return $requisites; //no requisites!

        while( $row = $qr->fetch_array() ){
            $requisites[] = new BuildingRequirement( $row['reqbuild'], $row['lev'] );
        }
        return $requisites;
    }

    public function GetResearchRequirements(){
        global $DB;
        $qr= $DB->query("SELECT * FROM `".TB_PREFIX."t_unt_req_research` WHERE `unit`= ".$this->id);

        $requisites= Array();
        if( $qr->num_rows ==0 ) return $requisites; //no requisites!

        while( $row= $qr->fetch_array() ){
            $requisites[] = new ResearchRequirement( $row['reqresearch'], $row['lev'] );
        }
        return $requisites;
    }
};

class Unit { //unit data (used only for battle)
	public $id, $quantity, $unit;	
	
	public function Unit( $_id, $_quantity, $_id_unit ){
		$this->id= $_id;
		$this->quantity= $_quantity;
		$this->unit= new UnitData( $_id_unit );
	}
	
	public function GetAttackedBy( Unit $unitData ){
		$damage= $unitData->unit->attack * $unitData->quantity - $this->unit->defence * $this->quantity;
		if( $damage <= 0 || $this->quantity <= 0 ) return;
		
		$grouphealth= $this->quantity * $this->unit->health - $damage;
		$newqty= $grouphealth / $this->quantity;
		if( (int)$newqty > $this->quantity ) return;
		
		$this->quantity= (int)$newqty;
		if( $this->quantity < 0 ) $this->quantity = 0;
	}
};

?>