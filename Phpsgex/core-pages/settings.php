<?php
/* --------------------------------------------------------------------------------------
                                      SETTINGS
   Credits         : phpSGEx by Aldrigo Raffaele
   Last modified by: Raffa50 09.04.2014
   Comments        : user pic
-------------------------------------------------------------------------------------- */
if( isset($_POST['editset']) ){
    $lng= CleanString($_POST['lang']);
    $DB->query("UPDATE `".TB_PREFIX."users` SET `lang` = '$lng' WHERE `id` =".$user->id);
    $_SESSION['lang']= $lng;

    if( isset($_FILES['usrpic']) && $_FILES["usrpic"]["error"] > 0 ){
        $temp = $_FILES['usrpic']['tmp_name'];
        $type = $_FILES['usrpic']['type'];

        list($width, $height) = getimagesize($_FILES['usrpic']['tmp_name']);
        if( $width > 256 || $height > 256 ) echo "Image exceeds maximum dimensions!";
        else {
            if( $type == "image/jpeg" ){
                if( !move_uploaded_file($temp, ".\\img\\userpics\\i".$user->id.".jpg") ) echo "Error during upload!";
            } else if( $type == "image/png" ){
                if( !move_uploaded_file($temp, ".\\img\\userpics\\i".$user->id.".png") ) echo "Error during upload!";
            } else echo "Invalid Image!";
        }
    }
}

$body= "<form enctype='multipart/form-data' method='post'>".$lang['reg_language'].": <select name='lang'>";

$dir = './lang';
$handle = opendir($dir);
// Lettura...
while( $files= readdir($handle) ) {
// Escludo gli elementi '.' e '..' e stampo il nome del file...
	if( $files != '.' && $files != '..' && $files != 'index.php' ){  
		$body.= '<option ';
		if( $user->language ==substr($files,0,-4) ) $body.= 'selected';
		$body.= '>'.substr($files,0,-4).'</option>';
	}
}
$body.="</select>";
if( $config['cusr_pics'] ) $body.= "<br>Upload your profile pic: <input type='file' name='usrpic'>";
$body.="<br><input type='submit' name='editset' value='Save'> </form>";
?>