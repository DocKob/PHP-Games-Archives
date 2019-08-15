<?php
/** @var User $user */
if( isset($secure) && $user->rank >=3 ){
	if( isset($_GET['p']) && file_exists( getcwd()."\\".$_GET['p'] ) ){
		$fl = getcwd()."\\".$_GET['p'];
		$p = $_GET['p']."\\";
	} else {
		$fl = getcwd();
		$p = "";
	}
	
	if( isset($_POST['fileupload']) && isset($_POST['file']) ){
		$nomefile = $_FILES['file']['name'];
		if( file_exists( $fl."\\".$nomefile ) ) $body.= "<b>Already exist!</b><br>";
		else {
			$temp = $_FILES['file']['tmp_name'];
			move_uploaded_file($temp, $fl."\\".$nomefile);
		}
	}
	
	if( isset($_POST['editpg']) ) {
		if( file_exists( $fl ) ){
			$fp = fopen( $fl, "w" );
			flock( $fp, LOCK_EX );
			
			fwrite( $fp, html_entity_decode($_POST['editpg']) );
			
			flock( $fp, LOCK_UN );
			fclose($fp);
		}
	}
	
	if( is_dir( $fl ) ){ //show files in a directory
		$body.="<b>Current Directory: $fl</b><br><br>";
		$handle = opendir($fl);
		// Lettura...
		while( $files = readdir($handle) ) {
			if( $files != '.' ){  
				$body.= "<a href='?pg=pgeditor&p=$p$files'>$files</a><br>";
			}
		}
		
		$body.="<br><br>Upload a file here: <form enctype='multipart/form-data' method='post'> <input type='file' name='file' required><br><input name='fileupload' type='submit' value='Upload file'> </form>";
	} else { //edit the file
		$body.="<form method='post'><textarea cols='100' rows='20' name='editpg'>";
		
		$fp = fopen( $fl, "r" );
		flock( $fp, LOCK_SH );
		
		while( !feof($fp) ) $body.= htmlentities( fgets($fp) );
		
		flock( $fp, LOCK_UN );
		fclose($fp);
		
		$body.="</textarea> <br> <input name='save' type='submit' value='Save'></form>";
	}
} else header("Location: index.php");
?>