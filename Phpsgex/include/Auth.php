<?php
require_once("User.php");

class LoginException extends Exception {
    public function LoginException( $_message ){
        parent::__construct($_message);
    }
}

class RegistrationException extends Exception {
  public function RegisterException( $_message ){
      parent::__construct($_message);
  }
};

class Auth {
    private static function CryptPassword( $_password ){
        return md5($_password);
    }

    /**
     * @param string $_userName
     * @param string $_password
     * @return LoggedUser
     * @throws LoginException
     */
    public static function Login( $_userName, $_password ){
        global $DB;
        $_password= self::CryptPassword( $_password );
        $query= $DB->query("select id from ".TB_PREFIX."users where username= '$_userName' and password= '$_password' limit 1;");
        if( $query->num_rows == 0 ) throw new LoginException("Invalid Login!");

        $aid= $query->fetch_array();
        $DB->query("update users set ".TB_PREFIX."last_log= NOW() where id= ".(int)$aid["id"]);

        //if( $user->IsBanned() ) throw new LoginException("Banned user");
        return (int)$aid["id"];
    }

    public static function Register( $_userName, $_email, $_password, $_race, $_lang= "en", $_cityName= "" ){
        global $DB, $config;

        if( !filter_var( $_email, FILTER_VALIDATE_EMAIL ) ) throw new RegistrationException("Invalid email");
        if( strlen( $_userName ) < 3 ) throw new RegistrationException("Username too short!");
        if( strlen( $_password ) < 3 ) throw new RegistrationException("Password too short!");

        $_password= self::CryptPassword( $_password );
        if( $_cityName == null || $_cityName == "" ) $_cityName= "City of $_userName";
        $mtimet= GetTimeStamp();

        $insertUserQr= $DB->query("INSERT INTO `".TB_PREFIX."users`
        (id, `username`, `password`, `race`, `capcity`, `email`, `timestamp_reg`, `rank`, `tut`, `lang`)
        VALUES (null, '$_userName', '$_password', $_race, null, '$_email', $mtimet, 0, -1, '$_lang')");

        if( !$insertUserQr ) throw new RegistrationException("Username or Email already exist!");
        $id= $DB->insert_id;

        //set first user as admin
        if( $id == 1 ) $DB->query("update ".TB_PREFIX."users set rank= 3 where id= 1");

        switch(MAP_SYS){
            case 1: //ogame sys; generate coords for map sys 1
                do{
                    $x= mt_rand(0, $config['Map_max_x']);
                    $y= mt_rand(0, $config['Map_max_y']);
                    $z= mt_rand(1, $config['Map_max_z']);

                    $pvc= $DB->query("SELECT * FROM ".TB_PREFIX."city WHERE x= $x AND y= $y AND z= $z")->num_rows;

                } while ($pvc!=0);

                $cityId= City::CreateCity( $id, new MapCoordinates($x,$y,$z), $_cityName );
                break;
            case 2:
                //travian sys generate x,y
                do{
                    $x=mt_rand(0, $config['Map_max_x']);
                    $y=mt_rand(0, $config['Map_max_y']);

                    $pvc= $DB->query("SELECT * FROM `".TB_PREFIX."city` WHERE `x` = $x AND `y` = $y")->num_rows;
                }while($pvc!=0);

                $cityId= City::CreateCity( $id, new MapCoordinates($x,$y), $_cityName );
                break;
            /*case 3:
                //ikariam/grepolis sys
                //generate isle and isle position!
                $numisl= $DB->query("SELECT * FROM `".TB_PREFIX."isle`")->num_rows;

                $ipd[1]="a";
                $ipd[2]="b";
                $ipd[3]="c";
                $ipd[4]="d";
                do{
                    $islid=mt_rand(1,$numisl);
                    $islpos=mt_rand(1,4);
                    $vsplic= $DB->query("SELECT * FROM `".TB_PREFIX."isle` WHERE `id` =".$islid)->fetch_array();
                    $sicp=$vsplic['pos_'.$ipd[$islpos]];
                }while($sicp!=0);

                $cin="INSERT INTO ".TB_PREFIX."city (id, owner, name, last_update) VALUES (null, '$id', '$ncity', $startres '$mtimet')";
                $cityId= $DB->query($cin)->insert_id;

                $isi="UPDATE `".TB_PREFIX."isle` SET `pos_$islpos` = '$cidr' WHERE `id` =$islid LIMIT 1 ;";
                $DB->query($isi);
                break;*/
        }

        $DB->query("update ".TB_PREFIX."users set capcity= $cityId where id= $id");

        //insert resources
        $resd= $DB->query("SELECT * FROM `".TB_PREFIX."resdata`");
        while( $fres= $resd->fetch_array() ){
            $DB->query("INSERT INTO `".TB_PREFIX."city_resources` (`city_id`, `res_id`, `res_quantity`) VALUES ($cityId, ".$fres['id'].", ".$fres['start'].");");
        }

        mail( $_email, "Registration to ".$config['server_name'], ParseBBCodes( $config['registration_email'], null, new User($id) ) );
    }

    public static function RecoverPassword( $_email ){
        global $DB, $config;
        $usrQr= $DB->query("select * from ".TB_PREFIX."users where email= '$_email'");
        if( $usrQr->num_rows ==0 ) throw new Exception("Invalid email!");

        $auser= $usrQr->fetch_array();
        $hash= md5($auser['id'].$auser['email'].GetTimeStamp());
        $DB->query("insert into ".TB_PREFIX."user_passrecover values (".$auser['id'].", '$hash', ".(GetTimeStamp() + 600).")");
        mail($auser['email'], $config['server_name']." Password Recovery", "<a href='".$_SERVER['HOST']."?pg=register&uid=".$auser['id']."&resetpw=$hash'>Click Here to recover password</a>");
    }

    public static function ResetPassword( $_userId, $_newPassword, $_hash ){
        global $DB;

        $_newPassword= self::CryptPassword( $_newPassword );

        $qr= $DB->query("SELECT `until` FROM `".TB_PREFIX."user_passrecover` WHERE `usrid`= $_userId AND `hash`= '$_hash';");

        if( $qr->num_rows < 1 ) throw new Exception("Error");

        $DB->query("UPDATE `".TB_PREFIX."users` SET `password = '$_newPassword' WHERE `id`= $_userId;");
        $DB->query("DELETE FROM `".TB_PREFIX."user_passrecover` WHERE `usrid`= $_userId;");
    }
};