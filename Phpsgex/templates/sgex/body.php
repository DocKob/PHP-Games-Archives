<?php
if( isset($secure) ){
	echo "<!DOCTYPE html>
	<html>
	<head>
		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
		<meta about='PhpSgeX' />
		<title>".$config['server_name']."</title>
	
		<link rel='shortcut icon' href='favicon.ico' >
		<link rel='stylesheet' href='templates/sgex/style.css' type='text/css' media='screen' />
		<!--[if IE 6]><link rel='stylesheet' href='style.ie6.css' type='text/css' media='screen' /><![endif]-->
		<!--[if IE 7]><link rel='stylesheet' href='style.ie7.css' type='text/css' media='screen' /><![endif]-->
	
		<script src='templates/sgex/jquery.js'></script>
		<script src='templates/sgex/script.js'></script>
		<script src='templates/js/common.js'></script>
		$head
	   <style type='text/css'>
	.art-post .layout-item-0 { padding-right: 10px;padding-left: 10px; }
	   .ie7 .art-post .art-layout-cell {border:none !important; padding:0 !important; }
	   .ie6 .art-post .art-layout-cell {border:none !important; padding:0 !important; }
	   </style>
	
	</head>
	<body onload='RefreshResources();$blol''>
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
									 <td align='right'><img src='img/sgex.png' width=350 height=100 /></td>
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
						<div class='art-content-layout-row'>";
						 require_once('menu.php');
						echo "<div class='art-layout-cell art-content'>
	<div class='art-box art-post'>
		<div class='art-box-body art-post-body'>
	<div class='art-post-inner art-article'>
									<div class='art-postmetadataheader'>
											";
													if( isset($user) ){ /** @var LoggedUser $user */
														echo $user->name."
														<form method='get'><select name='changecity' onchange='this.form.submit();'>";
															
														$ycqr= $DB->query("SELECT id, `name` FROM `".TB_PREFIX."city` WHERE `owner`= ".$user->id);
														while( $row= $ycqr->fetch_array() ) 
															echo "<option value='".$row['id']."'
															".( ($row['id'] == $currentCity->id)? "selected":"" ).">".$row['name']
                                                                ."</option>";
															
														echo "</select></form>
														 <a href='?pg=message'>Messages($nummsg)</a><br><hr>";
                                                        echo "<span id='resources'>";
														Template::print_resources( $currentCity );
                                                        echo "</span>";
															
													}
												
											echo "
																				</div>
									<div class='art-postcontent'>
	<div class='art-content-layout'>
		<div class='art-content-layout-row'>
		<div class='art-layout-cell layout-item-0' style='width: 100%;'>
			  <p>".$body."</p>
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
				require('templates/sgex/footer.php'); 
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