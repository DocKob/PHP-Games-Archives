<?php
if( isset($secure) ){
	echo "<!DOCTYPE html>
<html>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <title>".$config['server_name']."</title>

	<link rel='shortcut icon' href='../favicon.ico' >
    <link rel='stylesheet' href='../templates/sgex/style.css' type='text/css' media='screen' />
    <!--[if IE 6]><link rel='stylesheet' href='style.ie6.css' type='text/css' media='screen' /><![endif]-->
    <!--[if IE 7]><link rel='stylesheet' href='style.ie7.css' type='text/css' media='screen' /><![endif]-->

    <script src='../templates/sgex/jquery.js'></script>
    <script src='../templates/sgex/script.js'></script>
	<script src='../templates/js/common.js'></script>
	".$head."
   <style type='text/css'>
.art-post .layout-item-0 { padding-right: 10px;padding-left: 10px; }
   .ie7 .art-post .art-layout-cell {border:none !important; padding:0 !important; }
   .ie6 .art-post .art-layout-cell {border:none !important; padding:0 !important; }
   </style>

</head>
<body $bol>
<div id='art-page-background-middle-texture'>
<div id='art-main'>
    <div class='cleared reset-box'></div>
    <div class='art-header'>
        <div class='art-header-position'>
            <div class='art-header-wrapper'>
                <div class='cleared reset-box'></div>
                <div class='art-header-inner'>
                <div class='art-logo'>
                                 <h1 class='art-logo-name'>
                                 <table border='0' width='100%'><tr>
                               	 <td><a href='#'>".$config['server_name']."</a><br><h2 class='art-logo-text'>".$config['server_desc_sub']."</h2></td>
                                 <td align='right'><img src='../img/sgex.png' width='350' height='100' /></td>
                                 </tr></table>
                                 </h1>
                                </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class='cleared reset-box'></div>
    <div class='art-box art-sheet'>
        <div class='art-box-body art-sheet-body'>
            <div class='art-layout-wrapper'>
                <div class='art-content-layout'>
                    <div class='art-content-layout-row'>
                        <div class='art-layout-cell art-sidebar1'>
<div class='art-box art-vmenublock'>
    <div class='art-box-body art-vmenublock-body'>
                <div class='art-bar art-vmenublockheader'>
                    <h3 class='t'>Menu verticale</h3>
                </div>
                <div class='art-box art-vmenublockcontent'>
                    <div class='art-box-body art-vmenublockcontent-body'>
                    
                    <ul class='art-vmenu'>
                    	<li><a href='../index.php' class='active'>".$lang['adm_back']."</a></li>
                    </ul>
                    
                <ul class='art-vmenu'>
	<li>
		<a href='#' class='active'>Moderator</a>
		<ul class='active'>
			<li><a href='?pg=users'>Users</a></li>
		</ul>
	</li>			
	
	<li>
		<a href='?pg=main' class='active'>Main</a>
		<ul class='active'>
			<li><a href='?pg=races'>".$lang['adm_races']."</a></li>
			<li><a href='?pg=resources'>".$lang['adm_resources']."</a></li>
			<li><a href='?pg=buildings'>".$lang['adm_buildings']."</a></li>
			<li><a href='?pg=research'>".$lang['adm_research']."</a></li>
			<li><a href='?pg=units'>".$lang['adm_units']."</a></li>
			<li> <a href='?pg=xconfig'>".$lang['adm_config']."</a> </li>
			<li> <a href='?pg=plugins'>Plugins</a> </li>
			<li> <a href='?pg=dbcheck'>".$lang['adm_dbcheck']."</a> </li>
			<li> <a href='?pg=pgeditor'>Page Editor</a> </li>
		</ul>
	</li>	
</ul>
                
                                		<div class='cleared'></div>
                    </div>
                </div>
		<div class='cleared'></div>
    </div>
</div>

<div class='art-box art-block'>
    <div class='art-box-body art-block-body'>
                <div class='art-box art-blockcontent'>
                    <div class='art-box-body art-blockcontent-body'>
                <p>PhpSgeX Version: <span class='Stile3'>".SGEXVER."</span></p>                
                    <div class='cleared'></div>
                    </div>
                </div>
		<div class='cleared'></div>
    </div>
</div>
                          <div class='cleared'></div>
                        </div>
                        <div class='art-layout-cell art-content'>
<div class='art-box art-post'>
    <div class='art-box-body art-post-body'>
<div class='art-post-inner art-article'>
                                <div class='art-postmetadataheader'>
                                        <h2 class='art-postheader'>".$pg."</h2>
                                </div>
                                <div class='art-postcontent'>
<div class='art-content-layout'>
    <div class='art-content-layout-row'>
    <div class='art-layout-cell layout-item-0' style='width: 100%;'>
        ".$body."
    </div>
    </div>
</div>
                      </div>
                <div class='cleared'></div>
                </div>

		<div class='cleared'></div>
    </div>
</div>
                          <div class='cleared'></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='cleared'></div>";
				$path= '../';
				require('../templates/sgex/footer.php'); 
    		echo "<div class='cleared'></div>
        </div>
    </div>
    <div class='cleared'></div>
    <div class='cleared'></div>
</div>
</div>

</body>
</html>";
}
?>