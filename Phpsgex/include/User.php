<?php 
require_once("City.php");
require_once("Ally.php");

class User {
	public $id, $raceId, $name, $capitalCityId, $email, $timestampReg, $points, $rank, $allyId, $lastLogin, $tutorial, $language, $ip;

	public function User( $_id ){
		global $DB;
        $query = $DB->query("select * from ".TB_PREFIX."users where id= $_id");
        $info = $query->fetch_array();

        $this->id = $_id;
        $this->name = $info["username"];
        $this->raceId = $info["race"];
        $this->capitalCityId = $info["capcity"];
        $this->allyId = $info["ally_id"];
        $this->email = $info["email"];
        $this->timestampReg = $info["timestamp_reg"];
        $this->points = $info["points"];
        $this->rank = $info["rank"];
        $this->lastLogin = $info["last_log"];
        $this->tutorial = $info["tut"];
        $this->language = $info["lang"];
        $this->ip = $info["ip"];
	}
	
	//return a list of City
	public function GetCities(){
		global $DB;
		$cities = Array();
		
		$query = $DB->query("select * from ".TB_PREFIX."city where owner = ".$this->id);
		while( $row = $query->fetch_array() ){
			$cities = new City( $row, $this );
		}
		
		return $cities;
	}

    /**
     * @param int $_cityId
     * @return City
     * @throws Exception
     */
    public function GetCity( $_cityId ){
        global $DB;
        $query = $DB->query("select * from ".TB_PREFIX."city where owner = ".$this->id." and id = $_cityId");
        if( $query->num_rows != 1 ) throw new Exception();

        return new City( $query->fetch_array(), $this );
    }

    /**
     * @return bool
     */
    public function IsOnline(){
        $ll= $this->lastLogin;

        $ymg = explode(" ", $ll);
        $s = explode("-", $ymg[0]);
        $Y = $s[0];
        $M = $s[1];
        $G = $s[2];

        $z = explode(":", $ymg[1]);
        $h = $z[0];
        $m = $z[1];
        $s = $z[2];

        $tmll= ( GetTimeStamp() - mktime($h,$m,$s,$M,$G,$Y) ) / 60;
        return $tmll < 5;
    }

    /**
     * @param int $_researchId
     * @param bool $_queue
     * @return int
     */
    public function GetResearchLevel( $_researchId, $_queue = false ){
        global $DB;
        $qrbuildedinfo= $DB->query("SELECT lev FROM ".TB_PREFIX."user_research WHERE id_res = $_researchId AND usr = ".$this->id." LIMIT 1;");
        if( $qrbuildedinfo->num_rows >0 ) {
            $abli= $qrbuildedinfo->fetch_array();
            $lev= $abli['lev'];
        } else $lev= 0;

        if( !$_queue ) return $lev;
        else {
            $qr= $DB->query("SELECT * FROM `".TB_PREFIX."city_research_que` WHERE `city` in (select id from ".TB_PREFIX."city where owner= ".$this->id.") AND `res_id`= $_researchId");
            return $lev + $qr->num_rows;
        }
    }

    public function GetResearchQueueTime( $_researchId ){
        global $DB;
        $query= $DB->query("select sum(`end`) as totaltime, count(*) as upgrades from ".TB_PREFIX."city_research_que where res_id= $_researchId and city in (select id from ".TB_PREFIX."city where owner= ".$this->id.") ");
        $info = $query->fetch_array();

        if( $info['totaltime'] == 0 ) return 0;
        $ret = $info['totaltime'] - $info['upgrades'] * GetTimeStamp();
        if( $ret < 0 ) return 0;
        else return $ret;
    }

    public function GetResearchTime( ResearchData $_research, $_nextLevel ){
        return $_research->GetResearchTime( $_nextLevel ) +$this->GetResearchQueueTime( $_research->id );
    }

    public function FetchResearchQueue(){
        global $DB;
        //search if there in a build in the que - return the resting time
        $bqs= $DB->query("SELECT * FROM ".TB_PREFIX."city_research_que WHERE `city` in (select id from ".TB_PREFIX."city where owner= {$this->id}) ");
        while( $rab= $bqs->fetch_array() ){
            $rtimr= $rab['end']-GetTimeStamp();
            if( $rtimr <=0 ){
                //build
                $qcb= $DB->query("SELECT * FROM ".TB_PREFIX."t_research WHERE `id`= ".$rab['res_id']);
                $acb= $qcb->fetch_array();
                //level control!
                $lev= $this->GetResearchLevel($rab['res_id']);
                if( $lev ==0 ){ // verifica sul livello 0 - se non c'è costruzisce livello 1
                    //$qadf=""; $qaf="";
                    //if(CITY_SYS==2){$qadf=" ,`field`"; $qaf=", '".$rab['field']."'";}
                    $DB->query("INSERT INTO `".TB_PREFIX."user_research` (`id_res`, `usr`, `lev`) VALUES ({$rab['res_id']}, {$this->id}, 1);");
                } else { //altrimenti aumenta il livello
                    $lcb= $lev+1;
                    $DB->query("UPDATE `".TB_PREFIX."user_research` SET `lev`= $lcb WHERE `id_res`= {$rab['res_id']} AND `usr`= ".$this->id);
                }
                $DB->query("DELETE FROM ".TB_PREFIX."city_research_que WHERE id=".$rab['id']);
                //add points
                //$this->addpoints($acb['gpoints']);
            } //else return $rab; //return array
        }
    }

    public function IsBanned(){
        global $DB;
        $qrban= $DB->query("SELECT timeout FROM ".TB_PREFIX."banlist WHERE usrid = ".$this->id);
        if( $qrban->num_rows ==0 ) return false;
        $abq= $qrban->fetch_array();
        if( $abq['timeout'] == -1 ) return true; //forever banned!
        if( $abq['timeout'] > GetTimeStamp() ) return true;
        $DB->query("DELETE FROM ".TB_PREFIX."banlist WHERE usrid = ".$this->id);
        return false;
    }

    public function AddPoints( $_points ){
        if( $_points < 0 ) throw new Exception("points < 0!");
        if( $_points == 0 ) return;
        global $DB;
        $this->points += $_points;
        $DB->query("UPDATE `".TB_PREFIX."users` SET `points` = ".$this->points.",`last_log` = NOW( ) WHERE `id`= ".$this->id);
    }
};

class LoggedUser extends User {
    private $currentCity;

	public function LoggedUser( $_id ){
		User::User($_id);
        global $DB;
        $capCityQr= $DB->query("select * from ".TB_PREFIX."city where id= (select capcity from ".TB_PREFIX."users where id= $_id)");
        $this->currentCity= new City( $capCityQr->fetch_array(), $this );
	}

    public function SwitchCity( $cityId ){
        global $DB;
        $qr= $DB->query("select * from ".TB_PREFIX."city where id= $cityId and owner= ".$this->id);
        if( $qr->num_rows ==0 ) throw new Exception("Invalid cityId: $cityId");

        $this->currentCity= new City( $qr->fetch_array(), $this );
        $DB->query("update ".TB_PREFIX."users set capcity= $cityId where id= ".$this->id);
    }

	public function UpdateLastAction(){
	
	}

    /**
     * @return City
     */
	public function GetCurrentCity(){ 
	    return $this->currentCity;
	}
	
	public function SendMessage( $_to, $_tittle, $_body, $_messageType= 1, Ally $allyInvite= null ){
        SendMessage($this, $_to, $_tittle, $_body, $_messageType, $allyInvite);
    }
};

?>