<?php
class facebook_like extends Plugin {
    public function __construct(){
        Plugin::Plugin( "facebook_like", "index" );
        $this->author= "Aldrigo Raffaele";
        $this->author_email= "Reloader90@gmail.com";
        $this->pluginFwVersion= 1;
        $this->version= 1;
        $this->website= "phpstrategygame.sf.net";
    }

    public function Content( $params = null ){
        echo "<iframe src='http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fapps%2Fapplication.php%3Fid%3D164324790248643&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=true&amp;action=like&amp;colorscheme=dark&amp;font&amp;height=80' scrolling='no' frameborder='0' style='border:none; overflow:hidden; width: 100%; height:80px;' allowTransparency='true'></iframe>";
    }
}