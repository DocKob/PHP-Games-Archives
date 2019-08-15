<?php
if( isset($secure) ){
    if( isset($_POST['editconfig']) ){
        CleanArray( $_POST );
        $news= $_POST['news'];
        $registration_email= $_POST['registration_email'];
        $servernam= $_POST['servernam'];
        $subdesc= $_POST['subdesc'];
        $maindesc= $_POST['maindesc'];
        $templ= $_POST['templ'];

        $mapx= (int)$_POST['mapx']; if( $mapx <=0 ) $mapx=500;
        $mapy= (int)$_POST['mapy']; if( $mapy <=0 ) $mapy=500;
        $mapz= ( isset($_POST['mapz']) && (int)$_POST['mapz'] >0 ) ? (int)$_POST['mapz'] : 12;

        $FLAG_SZERORES= ( isset($_POST['FLAG_SZERORES']) ) ? 1 : 0;
        $FLAG_SUNAVALB= ( isset($_POST['FLAG_SUNAVALB']) ) ? 1 : 0;
        $FLAG_RESICONS= ( isset($_POST['FLAG_RESICONS']) ) ? 1 : 0;
        $FLAG_RESLABEL= ( isset($_POST['FLAG_RESLABEL']) ) ? 1 : 0;
        $FLAG_SHOWUSRMAIL= ( isset($_POST['FLAG_SHOWUSRMAIL']) ) ? 1 : 0;
        $cusr_pics= ( isset($_POST['cusr_pics']) ) ? 1 : 0;

        $MG_max_cap= (float)$_POST['MG_max_cap'];
        $baru_tmdl= (float)$_POST['baru_tmdl'];
        $buildfast_molt= (float)$_POST['buildfast_molt'];
        $researchfast_molt= (float)$_POST['researchfast_molt'];

        $popres= (int)$_POST['popres'];
        $popaddpl= (int)$_POST['popaddpl'];
        //save new config
        $DB->query("UPDATE `".TB_PREFIX."conf` SET `news1`= '$news', registration_email= '$registration_email', `server_name`= '$servernam', `server_desc_sub`= '$subdesc', `server_desc_main`= '$maindesc', `template` = '$templ', FLAG_SZERORES = $FLAG_SZERORES, FLAG_SUNAVALB = $FLAG_SUNAVALB, FLAG_RESICONS = $FLAG_RESICONS, FLAG_RESLABEL = $FLAG_RESLABEL, FLAG_SHOWUSRMAIL = $FLAG_SHOWUSRMAIL, cusr_pics = $cusr_pics, MG_max_cap = $MG_max_cap, baru_tmdl = $baru_tmdl, buildfast_molt = $buildfast_molt, researchfast_molt = $researchfast_molt, popres = $popres, popaddpl = $popaddpl, Map_max_x = $mapx, Map_max_y = $mapy, Map_max_z = $mapz WHERE 1 LIMIT 1;");
        if( $DB->error != null ) $body.="<h3>".$DB->error."</h3>";
        //now I have to reload config
        $config= $DB->query("SELECT * FROM ".TB_PREFIX."conf LIMIT 1")->fetch_array();
    }
	
	$head.= "<script src='../templates/js/nicEdit2.js'></script>
		<script>bkLib.onDomLoaded(nicEditors.allTextAreas);</script>";
	$body.="<form method='post' action='?pg=xconfig'>
	News: <br>
	<textarea name='news' cols='45' rows='5'>".$config['news1']."</textarea><br>

	Email registration message:<br>
	<textarea name='registration_email' cols='45' rows='5'>".$config['registration_email']."</textarea><br>

	Server name: <input name='servernam' type='text' value='".$config['server_name']."'> <br>
	Sub desc: <input name='subdesc' type='text' value='".$config['server_desc_sub']."'> <br>
	Main desc: <input name='maindesc' type='text' value='".$config['server_desc_main']."'> <br>
	Template: <select name='templ'>";
		
	$dir= '../templates';
    $handle= opendir($dir); // Lettura...
    while( $files= readdir($handle) ) { // Escludo gli elementi '.' e '..' e stampo il nome del file...
    	if( $files != '.' && $files != '..' && $files != 'js' && !strpos($files, ".") ){
			$body.= "<option ";
			if( $files == $config['template'] ) $body.="selected";
			$body.=">".$files."</option>";
		}
    }
		
	$body.="</select><br>
	Show resource cost if zero: <input type='checkbox' name='FLAG_SZERORES' ";
	if( $config['FLAG_SZERORES'] ) $body.="checked";
	$body.= "> <br>
	Show units, buildings and researches even if you cannot build: <input type='checkbox' name='FLAG_SUNAVALB' ";
	if( $config['FLAG_SUNAVALB'] ) $body.="checked";
	$body.="> <br>
	Show resource icon: <input type='checkbox' name='FLAG_RESICONS' ";
	if( $config['FLAG_RESICONS'] ) $body.="checked";
	$body.="> <br>
	Show resource label: <input type='checkbox' name='FLAG_RESLABEL' ";
	if( $config['FLAG_RESLABEL'] ) $body.="checked";
	$body.="> <br>
    Show Users emails on profile: <input type='checkbox' name='FLAG_SHOWUSRMAIL' ";
    if( $config['FLAG_SHOWUSRMAIL'] ) $body.="checked";
    $body.="><br>
	Custom profile image for users: <input type='checkbox' name='cusr_pics' ";
	if( $config['cusr_pics'] ) $body.="checked='checked'";
	$body.="> <br>

	
	<h2>MAP SIZE</h2>
	Map X: <input type='number' min='1' name='mapx' value='".$config['Map_max_x']."' min='1'><br>
	Map Y: <input type='number' min='1' name='mapy' value='".$config['Map_max_y']."' min='1'><br>";
	
	if( MAP_SYS!=2 )$body.="Map Z: <input type='number' min='1' name='mapz' value='".$config['Map_max_z']."'><br>";
	
	$body.="<br>
	
	<h2>RATES</h2>
	Magazine base capacity (set to 0 if you want to disable): <input type='number' name='MG_max_cap' value='".$config['MG_max_cap']."'> <br>
	Barrack time dividier per level: <input type='text' name='baru_tmdl' value='".$config['baru_tmdl']."'> <br>
	Build fast moltiplier: <input type='text' name='buildfast_molt' value='".$config['buildfast_molt']."'> <br>
	Research fast moltiplier: <input type='text' name='researchfast_molt' value='".$config['researchfast_molt']."'> <br>
	<br>
	
	<h2>Population engine</h2>
	Population resource:<select name='popres'>
		<option value='0'>OFF</option>";
	
		$qrr= $DB->query("SELECT * FROM ".TB_PREFIX."resdata");
		while( $row= $qrr->fetch_array() ){
			$body.="<option value='".$row['id']."'>".$row['name']."</option>";	
		}
	
	$body.="</select>
	<br>Population add per level: <input name='popaddpl' type='number' value='".$config['popaddpl']."' min='0'>
	
	<br><input type='submit' name='editconfig' value='save'></form>";	
}
?>