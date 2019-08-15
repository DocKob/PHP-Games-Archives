<?php 

class RaceData {
	public $id, $name, $description, $image;
	
	public function RaceData( $_id ){
		global $DB;
		$query = $DB->query("select * from ".TB_PREFIX."races where id = $_id");
		if( $query->num_rows == 0 ) throw new Exception("Race $_id doesn't exist!");
		$race = $query->fetch_array();
		
		$this->id = $_id;
		$this->name = $race["rname"];
		$this->description = $race["rdesc"];
		$this->image = $race["image"];
	}
};

?>