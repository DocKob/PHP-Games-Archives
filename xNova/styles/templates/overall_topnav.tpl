        <div id="bar">
			<b><ul>
				<!--<li>{if !empty($forum_url)}<a href="{$forum_url}" target="forum">{$lm_forums}</a>{/if}</li>-->
				<li>{if !CheckModule(22)}<a href="javascript:OpenPopup('?page=records','{$lm_records}', 1024, 768);">{$lm_records}</a>{/if}</li>
				{if !CheckModule(16)}<li><a href="?page=messages">{$lm_messages}{if $new_message > 0}<span id="newmes"> (<span id="newmesnum"><blink><font color="lime">{$new_message}</font></blink></span>)</span>{/if}</a></li>{/if}
				<li>{if !CheckModule(12)}<a href="?page=topkb">{$lm_topkb}</a>{/if}</li>
				<li>{if !CheckModule(26)}<a href="?page=search">{$lm_search}</a>{/if}</li>
				<li><a href="?page=options">{$lm_options}</a></li>
				{if !CheckModule(6)}<li><a href="?page=buddy">{$lm_buddylist}</a></li>{/if}
				{if !CheckModule(39)}<li><a href="?page=battlesim">{$lm_battlesim}</a></li>{/if}
				<li>{if !CheckModule(7)}<a href="?page=chat">{$lm_chat}</a>{/if} </li>
				{if !CheckModule(27)}<li><a href="?page=support">{$lm_support}</a></li>{/if}
				<li><a href="?page=logout"><font color="red">{$lm_logout}</font></a></li>
				{if $authlevel > 0}<li><a href="./admin.php" style="color:lime">{$lm_administration}</a></li>{/if}
            </ul></b>
        </div> 
		
    	<ul id="recursos">
        	<li class="metal">
               <a style="cursor:help" class="tooltip" name="<h3>{$Metal}</h3><hr />{$Metal}: {pretty_number($metal)}&nbsp;&nbsp;&nbsp; <br /> {if $settings_tnstor}{$almacenes}: {$metal_max}{else}{$almacenes}: {$alt_metal_max}{/if}"> <img src="styles/theme/{$Raza_skin}/images/metal.jpg" /></a>
                <span class="valor">
						<span id="current_metal"><b>{$metales}</b></span>
				</span>
            </li>
        	<li class="cristal">
               <a style="cursor:help" class="tooltip" name="<h3>{$Crystal}</h3><hr />{$Crystal}: {pretty_number($crystal)}&nbsp;&nbsp;&nbsp; <br /> {if $settings_tnstor}{$almacenes}: {$crystal_max}{else}{$almacenes}: {$alt_crystal_max}{/if}"> <img src="styles/theme/{$Raza_skin}/images/cristal.jpg" /></a>
					<span class="valor">
						<span id="current_crystal"><b>{$cristales}</b></span>
                </span>
            </li>
        	<li class="deuterio">
                <a style="cursor:help" class="tooltip" name="<h3>{$Deuterium}</h3><hr />{$Deuterium}: {pretty_number($deuterium)}&nbsp;&nbsp;&nbsp; <br /> {if $settings_tnstor}{$almacenes}: {$deuterium_max}{else}{$almacenes}: {$alt_deuterium_max}{/if}"><img src="styles/theme/{$Raza_skin}/images/deuterio.jpg" /></a>
                <span class="valor">
						<span id="current_deuterium"><b>{$deuterios}</b></span>
               	</span>
            </li>
			<li class="norio">
				<a style="cursor:help" class="tooltip" name="<h3>{$Energy}</h3><hr />{$energy} / {$energy_maxx}"><img src="styles/theme/{$Raza_skin}/images/energia.jpg" /></a>
					<span class="valor">
						<span><b>{$energia}</b></span>
                </span>
            </li>
        	<li class="energia">
				<a style="cursor:help" class="tooltip" name="<h3>{$Norio}</h3><hr />{$Norio}: {pretty_number($norio)}&nbsp;&nbsp;&nbsp; <br /> {if $settings_tnstor}{$almacenes}: {$norio_max}{else}{$almacenes}: {$alt_norio_max}{/if}"><img src="styles/theme/{$Raza_skin}/images/norio.jpg" /></a>
                <span class="valor">
                    	<span id="current_norio"><b>{$norios}</b></span>
                </span>
            </li>
        	<li class="materia_oscura">
			<a href="game.php?page=materiaoscura" class="tooltip" name="{$Darkmatter}: {$darkmatter}"><img src="styles/theme/{$Raza_skin}/images/materia.png" /></a>	
                <span class="valor">
                    	<span><b>{$darkmatter}</b></span>
                </span>
            </li>
		</ul>	
