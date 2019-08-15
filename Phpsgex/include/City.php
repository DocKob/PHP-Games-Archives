<?php
require_once("ResourceData.php");
require_once("User.php");
require_once("BuildingData.php");
require_once("ResearchData.php");
require_once("UnitData.php");
require_once("Map1Data.php");
/*switch( MAP_SYS ){
    case 1:
        require_once("Map1Data.php");
        break;
    case 2:
        require_once("Map2Data.php");
        break;
}*/
if( CITY_SYS == 2 ) require_once("Field.php");

class City {
	public $id, $user, $name, $lastUpdate, $mapPosition;
	private $resources;
	
	public function GetResources(){ return $this->resources; }

    /**
     * called when you have city id, it also loads it's owner (a User)
     * @param int $_id
     * @return City
     * @throws Exception
     */
	public static function LoadCity( $_id ){
		global $DB;
		$query= $DB->query("select * from ".TB_PREFIX."city where id = ".(int)$_id);
		if( $query->num_rows == 0 ) throw new Exception("Invalid City id $_id");
		$fetch = $query->fetch_array();
		return new City( $fetch, new User( $fetch["owner"] ) );
	}

    /**
     * called by User
     * @param array $_row
     * @param User $_user
     */
	public function City( Array $_row, User $_user ){
		$this->user = $_user;
		
		$this->id = $_row["id"];
		$this->name = $_row["name"];
        $this->lastUpdate = $_row["last_update"];

        switch( MAP_SYS ){
            case 1:
                $this->mapPosition= new MapCoordinates( $_row["x"], $_row["y"], $_row["z"] );
                break;
            case 2:
                $this->mapPosition= new MapCoordinates( $_row["x"], $_row["y"] );
                break;
        }

		$this->resources= array();
		$this->DoResourceProduction();
	}

    /**
     * Only for CITY_SYS 2
     * @return array of buildings foreach field[FieldId] that has MAX_FIELDS elements!
     */
    public function GetFieldsBuildings(){ //TODO edit for listing build in city_build_queue!
        if( CITY_SYS != 2 ) throw new Exception("this function is only for CITY_SYS 2");
        global $DB;

        $fieldBuild= array();
        for( $i= 0; $i < MAX_FIELDS; $i++ ) $fieldBuild[]= null;

        $qr= $DB->query("select * from ".TB_PREFIX."city_builds where city= ".$this->id);
        while( $row= $qr->fetch_array() ){
            $fieldBuild[ (int)$row['field'] ]= new Field( $row['build'], $row['lev'] );
        }

        return $fieldBuild;
    }

    public static function CreateCity( $_ownerId, MapCoordinates $_coords, $_name ){
        global $DB;
        if (MAP_SYS == 1) {
            $x= $_coords->x;
            $y= $_coords->y;
            $z= $_coords->z;
            $newCityQr= $DB->query("INSERT INTO `".TB_PREFIX."city` (`id`, `owner`, `name`, `last_update`, `x`, `y`, `z`) VALUES (null, $_ownerId, '$_name', ".GetTimeStamp().", $x, $y, $z);");
        } else {
            $x= $_coords->x;
            $y= $_coords->y;
            $newCityQr= $DB->query("INSERT INTO `".TB_PREFIX."city` (`id`, `owner`, `name`, `last_update`, `x`, `y`) VALUES (null, $_ownerId, '$_name', ".GetTimeStamp().", $x, $y);");
        }

        if( !$newCityQr ) throw new Exception( $DB->error );
        return $DB->insert_id;
    }

    public function DoResourceProduction(){
        global $DB;
        //get resource production rate
        $resprodrateqr= $DB->query("SELECT * FROM ".TB_PREFIX."resdata");
        $tmdif= ( GetTimeStamp() - $this->lastUpdate ) /3600;

        while( $resdata= $resprodrateqr->fetch_array() ){ //current city resources
            $i= $resdata['id'];
            $qr= $DB->query("SELECT * FROM `".TB_PREFIX."city_resources` WHERE `city_id` =".$this->id." AND `res_id`= $i");
            if( $qr->num_rows ==0 ){
                $DB->query("INSERT INTO `".TB_PREFIX."city_resources` VALUES (".$this->id.", $i, ".$resdata['start'].")");
                $this->resources[$i]= $resdata['start']; //city res ($i)
            } else {
                $aqr= $qr->fetch_array();
                $this->resources[$i]= $aqr['res_quantity']; //city res ($i)
            }
            //producion of res $i
            $qrresprodbud= $DB->query("SELECT `id` FROM `".TB_PREFIX."t_builds` WHERE `produceres`= $i");

            while( $prid= $qrresprodbud->fetch_array() ) {
                $bdlev = $this->GetBuildLevel( $prid['id'] );
                if( $bdlev > 0 ) {
                    $resh = $resdata['prod_rate'] * $bdlev;
                    $this->resources[$i] += $resh * $tmdif;
                }
            }
        }

        $this->UpdateResourcesOnDb();
    }

    protected function UpdateLastUpdateTime(){
        global $DB;
        $DB->query("UPDATE ".TB_PREFIX."city SET `last_update`= '".GetTimeStamp()."' WHERE `id`= ".$this->id." LIMIT 1;");
    }

    /**
     * Use only if magazine is activated
     */
    public function GetMaxResourcesCapacity(){
        global $DB, $config;
        if( $config['MG_max_cap'] <= 0 ) throw new Exception("Magazine is not activated! MG_max_cap must be > 0!");

        $qtmg= $DB->query("SELECT id FROM ".TB_PREFIX."t_builds WHERE func= 'mag_e' SELECT id FROM t_builds WHERE func= 'mag_e' and (arac is null or arac= ".$this->user->raceId.")");
        if( $qtmg->num_rows >0 ) {
            $tmg= $qtmg->fetch_array();
            $maglev= $this->GetBuildLevel($tmg['id']); //magazine level

            $maxres= $config['MG_max_cap'] * ($maglev + 1);
        } else {
            echo "<b>WARNING: Magazine is activated but there is no building with magazine function!</b>";
            $maxres= $config['MG_max_cap'];
        }
        return $maxres;
    }

	public function UpdateResourcesOnDb(){
        global $DB, $config;

        if( $config['MG_max_cap'] >0 ){
            $maxres= $this->GetMaxResourcesCapacity();
        }

        for( $i=1; $i <= count( $this->resources ); $i++ ){
            if( $config['MG_max_cap'] >0 ){ //magazine engine
                if( $this->resources[$i] > $maxres ) $this->resources[$i] = $maxres;
            }

            $DB->query("UPDATE `".TB_PREFIX."city_resources` SET `res_quantity`= '{$this->resources[$i]}' WHERE `city_id`= {$this->id} AND `res_id`= $i;");
        }

        $this->UpdateLastUpdateTime();
	}

    /**
     * get building level, 0 if not built
     * @param int $_buildId
     * @param bool $_queue if true, will be added 1 to the level foreach building in the queue
     * @return int build level
     */
	public function GetBuildLevel( $_buildId, $_queue = false, $_field= 0 ){
		global $DB;

        if( CITY_SYS == 1 )
		    $qrbuildedinfo= $DB->query("SELECT lev FROM ".TB_PREFIX."city_builds WHERE build= $_buildId AND city= {$this->id} LIMIT 1;");
		else {
            if( $_field == 0 )
                $qrbuildedinfo= $DB->query("SELECT lev FROM ".TB_PREFIX."city_builds WHERE build= $_buildId AND city= {$this->id} order by lev desc LIMIT 1;");
            else
                $qrbuildedinfo= $DB->query("SELECT lev FROM ".TB_PREFIX."city_builds WHERE build= $_buildId AND city= {$this->id} and field= $_field LIMIT 1;");
        }

        if( $qrbuildedinfo->num_rows >0 ) {
			$abli= $qrbuildedinfo->fetch_array();
			$lev= $abli['lev'];
		} else $lev= 0;
		
		if( !$_queue ) return $lev;
		else {
			$qr= $DB->query("SELECT id FROM `".TB_PREFIX."city_build_que` WHERE `city`= {$this->id} AND `build` = ".$_buildId);
			return $lev + $qr->num_rows;
		}
	}

    /**
     * Total build time forall $_buildId level in the queue
     * @param int $_buildId
     * @return int
     */
	public function GetBuildQueueTime( $_buildId ){
		global $DB;
		$query= $DB->query("select sum(`end`) as totaltime, count(*) as upgrades from ".TB_PREFIX."city_build_que where build= $_buildId and city= ".$this->id);
		$info = $query->fetch_array();
		
		if( $info['totaltime'] == 0 ) return 0;
		$ret = $info['totaltime'] - $info['upgrades'] * GetTimeStamp();
		if( $ret < 0 ) return 0;
		else return $ret;
	}

    //you can build if count($missings) is == 0
	public function CanBuild_BuildRequirements( BuildingData $_build ){
        global $DB;
        $requirements = $_build->GetBuildingsRequirements();
        $missings = Array();

        foreach ($requirements as $req) {
            $query= $DB->query( "select id from ".TB_PREFIX."city_builds where city= {$this->id} and build= {$req->buildId} and lev >= ".$req->level );
            if( $query->num_rows == 0 ) $missings[] = $req;
        }

        return $missings;
	}

    public function CanBuild_ResearchesRequirements( BuildingData $_build ){
        global $DB;
        $requirements = $_build->GetResearchRequirements();
        $missings = Array();

        foreach($requirements as $req){
            $query = new $DB->query( "select id from ".TB_PREFIX."user_research where id_res= ".$req->researchId." and usr= {$this->user->id} and lev >= ".$req->level );
            if( $query->num_rows == 0 ) $missings[] = $req;
        }

        return $missings;
    }

    public function CanBuild_ResourcesCheck( BuildingData $_build, $_nextLevel ){
        $requestedResources = $_build->GetBuildCosts( $_nextLevel );

        for($i=1; $i <= count( $this->resources ); $i++){
            if( $this->resources[$i] < $requestedResources[$i] ) return false;
        }

        return true;
    }

    /**
     * get building time of a build
     * @param BuildingData $_build
     * @param $_nextLevel level to be built
     * @return float|int building time in seconds
     * @throws Exception
     */
    public function GetBuildTime( BuildingData $_build, $_nextLevel ){
        if( $_nextLevel <=0 ) throw new Exception( "nextLevel <= 0 !" );

        global $DB, $config;
        $buildFasterBuildQr= $DB->query("select lev from ".TB_PREFIX."t_builds join ".TB_PREFIX."city_builds on (".TB_PREFIX."t_builds.id=".TB_PREFIX."city_builds.build) where func= 'buildfaster' limit 1");
        if( $buildFasterBuildQr->num_rows == 0 ) $buildFasterLev= 0;
        else {
			$a= $buildFasterBuildQr->fetch_array();
			$buildFasterLev= $a['lev'];
		}

        if( $buildFasterLev == 0 ) return $_build->GetBuildTime( $_nextLevel ) + $this->GetBuildQueueTime( $_build->id );
        return $_build->GetBuildTime( $_nextLevel ) / ($buildFasterLev * $config['buildfast_molt']) + $this->GetBuildQueueTime( $_build->id );
    }

	/**
     * add a building to Queue subtracting resources, it will be built next level
	 * @throws MissingRequirementsException if you can't build
     */
	public function QueueBuild( BuildingData $_build, $_field= 0 ){
        if( CITY_SYS == 1 )
		    $nextQueueLevel= $this->GetBuildLevel( $_build->id, true ) +1;
        else
            $nextQueueLevel= $this->GetBuildLevel( $_build->id, true, $_field ) +1;

        if( !$this->CanBuild_ResourcesCheck( $_build, $nextQueueLevel ) ) throw new MissingRequirementsException();
        if( count( $this->CanBuild_BuildRequirements( $_build ) ) != 0 ) throw new MissingRequirementsException();
        if( count( $this->CanBuild_ResearchesRequirements( $_build ) ) != 0 ) throw new MissingRequirementsException();

        global $DB;
        $costs= $_build->GetBuildCosts( $nextQueueLevel );
        for( $i=1; $i <= count($costs); $i++) $this->resources[$i] -= $costs[$i];
        $this->UpdateResourcesOnDb();

        $buildEndTime= $this->GetBuildTime( $_build, $nextQueueLevel ) + GetTimeStamp();
        if( CITY_SYS == 1 )
            $DB->query("insert into ".TB_PREFIX."city_build_que values (null, {$this->id}, {$_build->id}, $buildEndTime)");
        else {
            $qr= $DB->query("select id from ".TB_PREFIX."city_build_que where city= {$this->id} and `field`= $_field and build != ".$_build->id);
            if($qr->num_rows > 0){
                echo "error, field is busy!";
                return;
            }
            $qr= $DB->query("select id from ".TB_PREFIX."city_builds where city= {$this->id} and `field`= $_field and build != ".$_build->id);
            if($qr->num_rows > 0){
                echo "error, field is busy!";
                return;
            }

            $DB->query("insert into ".TB_PREFIX."city_build_que values (null, {$this->id}, {$_build->id}, $buildEndTime, $_field)");
        }
	}

    private function FetchBuildQueue(){
        global $DB;
        //search if there in a build in the que - return the resting time
        $bqs= $DB->query("SELECT * FROM ".TB_PREFIX."city_build_que WHERE `city`= ".$this->id);
        while( $queuedBuild= $bqs->fetch_array() ) {
            $rtimr= $queuedBuild['end'] - GetTimeStamp();
            if ($rtimr <= 0) {
                $DB->query("DELETE FROM `".TB_PREFIX."city_build_que` WHERE `id`= ".$queuedBuild['id']);
                //build level control!
                $lev= $this->GetBuildLevel( $queuedBuild['build'] );
                if ($lev == 0) { // verifica sul livello 0 - se non c'è costruzisce livello 1
                    if( CITY_SYS == 1 )
                        $DB->query("INSERT INTO `".TB_PREFIX."city_builds`( `id`, `city`, `build`, `lev` ) VALUES ( NULL , ".$this->id.",  ".$queuedBuild['build'].", 1 );");
                    else
                        $DB->query("INSERT INTO `".TB_PREFIX."city_builds`( `id`, `city`, `build`, `lev`, `field` ) VALUES ( NULL , ".$this->id.",  ".$queuedBuild['build'].", 1, ".$queuedBuild['field']." );");
                } else { //increase level
                    if( CITY_SYS == 1 )
                        $DB->query("UPDATE `".TB_PREFIX."city_builds` SET `lev`= lev +1 WHERE `build`= ".$queuedBuild['build']." AND city= ".$this->id." LIMIT 1");
                    else
                        $DB->query("UPDATE `".TB_PREFIX."city_builds` SET `lev`= lev +1 WHERE `build`= ".$queuedBuild['build']." AND city= ".$this->id." and field= ".$queuedBuild['field']." LIMIT 1");

                    //pop increment engine
                    //$opobd= $DB->query("SELECT `id` FROM `t_builds` WHERE `func` = 'pop_e' LIMIT 1;")->fetch_array();
                    //if( $opobd['id'] == $rab['build'] ) $this->AddPopulation($value);

                    //add points
                    $build= new BuildingData( $queuedBuild['build'] );
                    $this->user->AddPoints( $build->gainPoints );
                }
            }
        }
    }

    /**
     * check research buildings requirements
     * @param ResearchData $_research
     * @return array empty if the research matches the requirements, otherwise it contains the missing requirements
     */
	public function CanResearch_BuildRequirements( ResearchData $_research ){
        global $DB;
        $requirements= $_research->GetBuildingsRequirements();
        $missings= array();

        foreach ($requirements as $req) {
            $query = $DB->query( "select id from ".TB_PREFIX."city_builds where city = ".$this->id." and build = ".$req->buildId." and lev >= ".$req->level );
            if( $query->num_rows == 0 ) $missings[] = $req;
        }

        return $missings;
	}

    public function CanResearch_ResearchesRequirements( ResearchData $_research ){
        global $DB;
        $requirements = $_research->GetResearchRequirements();
        $missings = Array();

        foreach($requirements as $req){
            $query = new $DB->query( "select id from ".TB_PREFIX."user_research where id_res = ".$req->researchId." and usr = ".$this->user->id." and lev >= ".$req->level );
            if( $query->num_rows == 0 ) $missings[] = $req;
        }

        return $missings;
    }

    public function CanResearch_ResourcesCheck( ResearchData $_research, $_nextLevel ){
        $requestedResources = $_research->GetResearchCosts( $_nextLevel );

        for($i=1; $i <= count( $this->resources ); $i++){
            if( $this->resources[$i] < $requestedResources[$i] ) return false;
        }

        return true;
    }

    /**
     * add a research to Queue subtracting resources, it will be built next level
	 * @throws MissingRequirementsException if you can't build
     */
	public function QueueResearch( ResearchData $_research ){
        $nextQueueLevel= $this->user->GetResearchLevel( $_research->id ) +1;
        if( !$this->CanResearch_ResourcesCheck( $_research, $nextQueueLevel ) ) throw new MissingRequirementsException();
        if( count( $this->CanResearch_BuildRequirements( $_research ) ) != 0 ) throw new MissingRequirementsException();
        if( count( $this->CanResearch_ResearchesRequirements( $_research ) ) != 0 ) throw new MissingRequirementsException();

        global $DB;
        $costs = $_research->GetResearchCosts( $nextQueueLevel );
        for( $i=1; $i <= count($costs); $i++) $this->resources[$i] -= $costs[$i];
        $this->UpdateResourcesOnDb();

        $resEndTime = $_research->GetResearchTime( $nextQueueLevel ) + $this->user->GetResearchQueueTime( $_research->id ) + GetTimeStamp();
        $DB->query("insert into ".TB_PREFIX."city_research_que values (null, ".$this->id.", ".$_research->id.",  $resEndTime)");
	}

    public function CanTrain_BuildRequirements( UnitData $_unit ){
        global $DB;
        $requirements = $_unit->GetBuildingsRequirements();
        $missings = Array();

        foreach ($requirements as $req) {
            $query = $DB->query( "select id from ".TB_PREFIX."city_builds where city = ".$this->id." and build = ".$req->buildId." and lev >= ".$req->level );
            if( $query->num_rows == 0 ) $missings[] = $req;
        }

        return $missings;
    }

    public function CanTrain_ResearchRequirements( UnitData $_unit ){
        global $DB;
        $requirements=  $_unit->GetResearchRequirements();
        $missings= Array();

        foreach($requirements as $req){
            $query= $DB->query( "select * from ".TB_PREFIX."user_research where id_res = ".$req->researchId." and usr = ".$this->user->id." and lev >= ".$req->level );
            if( $query->num_rows == 0 ) $missings[] = $req;
        }

        return $missings;
    }

    public function GetMaxTrainableUnits( UnitData $_unit ){
        $maxunt=0; $f=1;

        $costs= $_unit->GetTrainCosts();
        for( $i= 1; $i<= count($this->resources); $i++ ){
            if( $costs[$i] ==0 ) continue;
            $mtv= (int)($this->resources[$i] / $costs[$i]);
            if( $f == 1 ){ $maxunt= $mtv; $f++; }
            else if( $mtv < $maxunt ) $maxunt= $mtv;
        }

        //if( POP_E=="1" && $maxunt > $aqres['pop'] ) $maxunt= $aqres['pop'];

        return (int) $maxunt;
    }

    public function QueueUnits( UnitData $_unit, $_quantity = 1 ){
        if( $_quantity < 1 ) throw new Exception("quantity < 1! given quantity= $_quantity");
        global $DB;

        $mxunt= $this->GetMaxTrainableUnits( $_unit );
        if( $_quantity > $mxunt ) $uqnt= $mxunt;
        $timeend= GetTimeStamp() + $_unit->trainTime * $_quantity;

        $costs= $_unit->GetTrainCosts( $_quantity );
        for( $i=1; $i <= count($this->resources); $i++ ) $this->resources[$i] -= $costs[$i];
        $this->UpdateResourcesOnDb();

        $DB->query("INSERT INTO `".TB_PREFIX."unit_que` (`id` ,`id_unt` ,`uqnt` ,`city` ,`end`) VALUES (NULL , ".$_unit->id.", $_quantity, ".$this->id.", $timeend);");
    }

    public function FetchTrainUnitsQueue(){
        global $DB;

        $qr= $DB->query("select * from ".TB_PREFIX."unit_que where city= ".$this->id);
        while( $row= $qr->fetch_array() ){
            if( $row['end'] - GetTimeStamp() <= 0 ){
                $DB->query("delete from ".TB_PREFIX."unit_que where id= ".$row['id']);
                $CityUnitQr= $DB->query("select * from ".TB_PREFIX."units where owner_id= ".$this->user->id." and id_unt= ".$row['id_unt']." and `where`= ".$this->id);
                if( $CityUnitQr->num_rows ==0 ) {
                    $DB->query("insert into ".TB_PREFIX."units
                    values ( null, ".$row['id_unt'].", ".$row['uqnt'].", ".$this->user->id.", null, null, ".$this->id.", 0, 0 )");
                } else {
                    $ainf= $CityUnitQr->fetch_array();
                    $DB->query("update ".TB_PREFIX."units set uqnt= uqnt +".$row['uqnt']." where id= ".$ainf['id']);
                }
            }
        }
    }

    public function FetchUnitMovements(){
        global $DB;
        //atacks
        $qr= $DB->query("SELECT * FROM `".TB_PREFIX."units` WHERE `owner_id`= ".$this->user->id." AND `from` =".$this->id." AND `action`= 1");
        while( $row= $qr->fetch_array() ){
            if( $row['time'] <= GetTimeStamp() ){
                $cityowner = $DB->query("SELECT `owner` FROM `".TB_PREFIX."city` WHERE `id` = ".$row['to'])->fetch_array();
                City::LoadCity( $row['to'] )->FetchAllQueue();
            }
        }
        //return units
        $qr= $DB->query("SELECT * FROM `".TB_PREFIX."units` WHERE `owner_id`= ".$this->user->id." AND `to`= ".$this->id." AND `action`= 0");
        while( $row= $qr->fetch_array() ){
            if( $row['time'] <= GetTimeStamp() ){
                $qrcuruntct= $DB->query("SELECT * FROM `".TB_PREFIX."units` WHERE `owner_id`= ".$this->user->id." AND `where`= ".$this->id." AND `action`= 0 AND `id_unt`= ".$row['id_unt']);
                if( $qrcuruntct->num_rows ==0 ) $DB->query("INSERT INTO `".TB_PREFIX."units` (`id`, `id_unt`, `uqnt`, `owner_id`, `from`, `to`, `where`, `time`, `action`) VALUES (NULL, ".$row['id_unt'].", ".$row['uqnt'].", ".$this->user->id.", NULL, NULL, ".$this->id.", 0, 0);");
                else {
                    $ayu= $qrcuruntct->fetch_array();
                    $totunt= $ayu['uqnt'] +$row['uqnt'];
                    $DB->query("UPDATE `".TB_PREFIX."units` SET `uqnt`= $totunt WHERE `id`= ".$ayu['id']);
                }
                $DB->query("DELETE FROM `".TB_PREFIX."units` WHERE `id`= ".$row['id']);
            }
        }
    }

    /**
     * get units in city
     * @return Unit array
     */
    public function GetUnits(){
        global $DB;
        $units= array();

        $quyrunt= $DB->query("SELECT ".TB_PREFIX."units.*, ".TB_PREFIX."t_unt.vel FROM ".TB_PREFIX."units JOIN ".TB_PREFIX."t_unt ON (".TB_PREFIX."units.id_unt = ".TB_PREFIX."t_unt.id) WHERE `where`= {$this->id} ORDER BY `".TB_PREFIX."t_unt`.`vel` DESC");
        if( $quyrunt->num_rows > 0 ) {
            while ($yourunits= $quyrunt->fetch_array()) {
                $units[]= new Unit( (int)$yourunits['id'], (int)$yourunits['uqnt'], (int)$yourunits['id_unt'] );
            }
        }

        return $units;
    }

    public function SufferAttacks(){
        global $DB, $config;
        //search ataking units
        //$qratkunt= $DB->query("SELECT * FROM units WHERE `to` =$id_city AND `time` <=".GetTimeStamp()." AND `action` =1");
        $qratkunt= $DB->query("SELECT ".TB_PREFIX."units.*, ".TB_PREFIX."t_unt.vel FROM ".TB_PREFIX."units JOIN ".TB_PREFIX."t_unt ON (".TB_PREFIX."units.id_unt = ".TB_PREFIX."t_unt.id) WHERE `to` = ".$this->id." AND `time` <=".GetTimeStamp()." AND `action` =1 ORDER BY `".TB_PREFIX."t_unt`.`vel` DESC");
        if( $qratkunt->num_rows ==0 ) return; //if there isn't an atack end

        //your units (or supports)
        $ayu= $this->GetUnits();
        if( count( $ayu ) > 0 ){ //battle begin, create an array of your units
            //atacking units
            $aat= array();
            $atakerowner=0;
            $atk_from = 0;
            while( $aatu= $qratkunt->fetch_array() ){
                $atakerowner= $aatu['owner_id'];
                $atk_from = $aatu['from'];
                $aat[]= new Unit( $aatu['id'], $aatu['uqnt'], $aatu['id_unt'] );
            }

            // duel
            $yi=0;
            $ai=0;
            $maxcicles = 1000;
            $cicle = 0;
            while( $yi < count($ayu) && $ai < count($aat) && $cicle < $maxcicles ){
                $savayu= clone $ayu[$yi];
                $ayu[$yi]->GetAttackedBy( $aat[$ai] );
                if( $ayu[$yi]->quantity <= 0 ) $yi++;

                $aat[$ai]->GetAttackedBy( $savayu );
                if( $aat[$ai]->quantity <= 0 ) $ai++;
                $cicle++;
            }

            // update units
            //your untis
            for($i=0; $i < count($ayu); $i++){
                $DB->query("UPDATE `".TB_PREFIX."units` SET `uqnt`= {$ayu[$i]->quantity} WHERE `id`= {$ayu[$i]->id} LIMIT 1 ;");
            }

            $attackerCity= City::LoadCity( (int)$atk_from );
            $travelTime= $this->mapPosition->GetDistance( $attackerCity->mapPosition );

            for($i=0; $i < count($aat); $i++){
                $DB->query("UPDATE `".TB_PREFIX."units` SET `uqnt`= {$aat[$i]->quantity},`from`= {$this->id} ,`to`= $atk_from ,`where`= NULL,`time` = ".( GetTimeStamp() +(int)$travelTime )." ,`action` = '0' WHERE `id`= {$aat[$i]->id} LIMIT 1 ;");
            }
            // clear units where uqnt=0
            $DB->query("delete from units where uqnt <= 0");
        } else { //there are no units so enemy win
            while( $riga= $qratkunt->fetch_array() ){
                $atakerowner= $riga['owner_id'];
                if( $riga['time']<= GetTimeStamp() ) $DB->query("UPDATE `".TB_PREFIX."units` SET `from`= {$riga['to']} ,`to`= {$riga['from']} ,`where`= NULL ,`time`= 0 ,`action`= '0' WHERE `id`= {$riga['id']} LIMIT 1;");
            }
        }

        //send battle report
        $userAttacker= new User( (int)$atakerowner );
        SendMessage( null, $this->user->id, "Battle report", "You were atacked form <a href='?pg=profile&usr={$userAttacker->id}'>{$userAttacker->name}</a> !", 2 );

        SendMessage( null, $userAttacker->id, "Battle report", "Atack to <a href='?pg=profile&usr={$this->user->id}'>{$this->user->name}</a> complete!", 2 );
    }

    public function FetchAllQueue(){
        $this->FetchBuildQueue();
        $this->FetchTrainUnitsQueue();
        $this->user->FetchResearchQueue();
        $this->SufferAttacks();
        $this->FetchUnitMovements();
    }

    public function Market_MakeOffer( $requestedResId, $requestedResAmount, $offeredResId, $offeredResAmount ){
        $resoffqnt= (int)min( $offeredResAmount, $this->resources[$offeredResId] );
        if( $resoffqnt > 0 ) {
            global $DB;
            $this->resources[$offeredResId] -= $resoffqnt;
            $DB->query("INSERT INTO `".TB_PREFIX."market` (`id`, `city`, `resoff`, `resoqnt`, `resreq`, `resrqnt`)
                        values (NULL, ".$this->id.", $offeredResId, $resoffqnt, $requestedResId, $requestedResAmount);");
            $this->UpdateResourcesOnDb();
        }
    }

    public function Market_AcceptOffer( $offerId ){
        global $DB;
        $offinf= $DB->query("SELECT * FROM ".TB_PREFIX."market WHERE id=".$offerId)->fetch_array();
        if( $this->resources[ $offinf['resreq'] ] >= $offinf['resrqnt'] ){ //you must have the requided resoure!
            $DB->query("DELETE FROM ".TB_PREFIX."market WHERE id=".$offerId);
            if( $DB->affected_rows == 0 ) return; //offer already accepted!

            $this->resources[ $offinf['resreq'] ] -= $offinf['resrqnt'];
            $this->resources[ $offinf['resoff'] ] += $offinf['resoqnt'];
            $this->UpdateResourcesOnDb();

            $op= City::LoadCity( $offinf['city'] ); //update the offer owner resource!
            $op->resources[ $offinf['resreq'] ] += $offinf['resrqnt'];
            $op->UpdateResourcesOnDb();
        }
    }

    public function Market_DeleteOffer( $offerId ){
        global $DB;
        $offdata= $DB->query("SELECT * FROM ".TB_PREFIX."market WHERE id = ".$offerId)->fetch_array();
        $DB->query("DELETE FROM ".TB_PREFIX."market WHERE id = ".$offerId);
        if( $DB->affected_rows == 0 ) return; //offer already accepted!

        $this->resources[ $offdata['resoff'] ] += $offdata['resoqnt'];
        $this->UpdateResourcesOnDb();
    }

    public function Building_Cancel( $queue_id ){
        global $DB;
        $DB->query("delete from ".TB_PREFIX."city_build_que where id= $queue_id");
    }
};
?>