<?php

abstract class Plugin {
    public $name, $type, $active,
        $author, $author_email, $website, $version, $pluginFwVersion; //IMPORTANT: set this field to framework version

    private static $plugins = array();
    public static function GetLoadedPlugins(){
        return self::$plugins;
    }

    public static $frameworkVersion= 1;

    public static function GetAllPluginsNames(){
        $ret= array();
        $files= scandir( __DIR__ );
        foreach( $files as $dir ){
            if( !is_dir( __DIR__."\\".$dir ) || $dir == "." || $dir == ".." ) continue;

            $ret[]= $dir;
        }
        return $ret;
    }

    protected function Plugin( $_name, $_type ){
        $this->name= $_name;
        $this->type= $_type;
    }

    public static function Load(){
        $plugins= self::GetAllPluginsNames();
        foreach( $plugins as $p ){
            require_once __DIR__ ."\\". $p."\\".$p.".php";
			$ref= new ReflectionClass( $p );
            $plug= $ref->newInstance(); /** @var Plugin $plug */
            if( !$plug->IsInstalled() ) $plug->Install();
            self::$plugins[]= $plug;
        }
    }

    public function IsInstalled(){
        global $DB;
        $qr= $DB->query("select * from ".TB_PREFIX."plugins where name= '".$this->name."'");
        return $qr->num_rows != 0;
    }

    protected function Install(){
        global $DB;
        $DB->query("insert into ".TB_PREFIX."plugins values ( '".$this->name."', 1, '".$this->type."' )");
    }

    public function Uninstall(){
        global $DB;
        $DB->query("delete from ".TB_PREFIX."plugins where name= '".$this->name."'");
    }

    public abstract function Content( $params = null );

    public function SetActive( $active ){
        global $DB;
        $DB->query("update into ".TB_PREFIX."plugins set active= $active where name= '".$this->name."'");
        $this->active= $active;
    }
};