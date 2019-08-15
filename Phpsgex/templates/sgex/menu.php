<?php
if( isset( $user ) ){ /** @var User $user */
	echo "<div class='art-layout-cell art-sidebar1'>
		<div class='art-box art-vmenublock'>
			<div class='art-box-body art-vmenublock-body'>
				<div class='art-bar art-vmenublockheader'>
					<h3 class='t'>Menu verticale</h3>
				</div>
				<div class='art-box art-vmenublockcontent'>
					<div class='art-box-body art-vmenublockcontent-body'>";
						
						if( $user->rank >0 ) echo "<ul class='art-vmenu'><li><a href='adm/index.php' class='active'>Admin CP</a></li></ul>";
						
						echo "<ul class='art-vmenu'>
							<li>
								<a href='#' class='active' onclick='showHide(UCP);'>User CP [+/-]</a>
								<ul class='active' id='UCP' style='display: none;'>
									<li> <a href='?pg=profile&usr=".$user->id."'>".$lang['mnu_profile']."</a> </li>
									<li> <a href='?pg=settings'>".$lang['mnu_settings']."</a> </li>
									<li> <a href='?pg=message'>".$lang['mnu_messages']."</a> </li>
									<li> <a href='?pg=chat'>Chat</a> </li>
									<li> <a href='?pg=highscores'>Highscores</a> </li>
									<li> <a href='?auth=logout' >Logout</a> </li>
								</ul>
							</li>	
						</ul>
						
						<ul class='art-vmenu'>
							<li>
								<a href='?pg=main' class='active'>Main</a>
								<ul class='active'>";

									if( CITY_SYS == 1 )
                                        echo "<li> <a href='?pg=buildings'>".$lang['mnu_buildings']."</a> </li>";
                                    if( CITY_SYS == 2 )
                                        echo "<li><a href='?pg=fields'>".$lang['mnu_buildings']."</a></li>";

									echo "<li> <a href='?pg=research'>".$lang['mnu_researches']."</a> </li>
									<li> <a href='?pg=barracks'>".$lang['mnu_barracks']."</a> </li>
									<li>";
									if( MAP_SYS==1 ) echo "<a href='?pg=map&gal=".$currentCity->mapPosition->x."&sys=".$currentCity->mapPosition->y."'>".$lang['mnu_map']."</a>";
									else if( MAP_SYS==2 ) echo "<a href='?pg=map2&x=".$currentCity->mapPosition->x."&y=".$currentCity->mapPosition->y."'>".$lang['mnu_map']."</a>";
									
									echo "</li>
									
									<li> <a href='?pg=market'>".$lang['mnu_market']."</a> </li>
									<li> <a href='?pg=ally'>".$lang['mnu_allies']."</a> </li>
								</ul>
							</li>	
						</ul>
					
						<div class='cleared'></div>
					</div>
				</div>
			<div class='cleared'></div>
			</div>
			
			<div class='art-box art-block'>
				<div class='art-box-body art-block-body'>
							<div class='art-box art-blockcontent'>
								<div class='art-box-body art-blockcontent-body'>
							<p>PhpSgeX Version: <span class='Stile3'>".SGEXVER."</span></p>                
								<div class='cleared'></div>
								<div>
				<a href='https://sourceforge.net/p/phpstrategygame/bugs/' target='_blank'>
					<img src='img/bugreport.png'>
				</a>
			</div>
								</div>
							</div>
					<div class='cleared'></div>
				</div>
			</div>

		</div>

		<div class='cleared'></div>
	</div>";
}
?>