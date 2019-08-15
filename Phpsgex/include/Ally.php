<?php
require_once("Exception.php");

/*to be implemented next
class AllyRole {
	public $id, $playerId, $role;
	
	public function AllyRole( Array $_row ){
	
	}
};*/

class AllyPact {
	public $allyId, $otherAllyId, $type;
	
	public function AllyPact( Array $_row ){
	
	}
};

class Ally {
	public $id, $name, $description, $ownerId, $inviteText, $access;
	
	public function Ally( $_id ){
	    global $DB;
        $qr= $DB->query("select * from ".TB_PREFIX."ally where id= $_id");
        $aqr= $qr->fetch_array();

        $this->id= $_id;
        $this->name= $aqr["name"];
        $this->description= $aqr["desc"];
        $this->ownerId= $aqr["owner"];
        $this->inviteText= $aqr['invite_text'];
	}

    public static function CreateAlly( User $_owner, $_allyName ) {
        global $DB;
        $nam= CleanString($_POST['name']);

        $allyexistqr= $DB->query("select * from `".TB_PREFIX."ally` where `name`= '$nam' limit 1");
        if( $allyexistqr->num_rows > 0 ) throw new NameAlreadyInUseException("there is already an ally with name '$nam''");

        $DB->query("INSERT INTO `".TB_PREFIX."ally` (`id` ,`name` ,`desc` ,`owner` , `acess`) VALUES (null , '$nam', '', {$_owner->id}, 0);");
        $_owner->allyId= $DB->insert_id;
        $DB->query("UPDATE `".TB_PREFIX."users` SET `ally_id`= {$_owner->allyId} WHERE `id`= ".$_owner->id);
    }
	
	//returns a list of Users that are member of the ally
	public function GetMembers(){
	    global $DB;
        $qr= $DB->query("select id from ".TB_PREFIX."users where ally_id= ".$this->id);

        $users= Array();
        while( $row= $qr->fetch_array() ){
            $users[] = new User( $row["id"] );
        }
        return $users;
	}
	
	//calculate points
	public function GetPoints(){
	    global $DB;
        $qr= $DB->query("SELECT SUM(points) AS result FROM ".TB_PREFIX."users WHERE ally_id = ".$this->id);
        $row= $qr->fetch_array();
        return $row['result'];
	}
	
	//returns a list of AllyPact
	public function GetPacts(){
	
	}

    public function KickUser( $_userId ){
        global $DB;
        $DB->query("UPDATE `".TB_PREFIX."users` SET `ally_id`= NULL WHERE `id`= $_userId");
    }
};

?>