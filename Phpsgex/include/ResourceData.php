<?php

class ResourceData {
	public $id, $name, $productionRate, $start, $icon;

    public static function GetResourcesData(){
        $resdata = Array();
        global $DB;

        $qr= $DB->query("select id from ".TB_PREFIX."resdata");
        $i = 1;
        while( $row = $qr->fetch_array() ){
            $resdata[$i++] = new ResearchData($row['id']);
        }

        return $resdata;
    }

	public function ResourceData( $_resourceId ){
		global $DB;
		$this->id = $_resourceId;
		
		$info = $DB->query("SELECT * FROM ".TB_PREFIX."resdata WHERE id = $_resourceId")->fetch_array();
		$this->name = $info['name'];
		$this->productionRate = $info['prod_rate'];
		$this->start = $info['start'];
		$this->icon = $info['ico'];
	}
};

?>