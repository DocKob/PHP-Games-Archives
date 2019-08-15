<div id="menu_izquierdo">
        <ul id="menu_botones">
  		<li class="arriba_menu">
		<span class="menu_icon">
		<img width="38" height="29" src="./styles/theme/{$Raza_skin}/imagenes/navegacion/menu_icon.png">
        </span>
		<a class="menu_boton_2 " href="?page=overview"><span>{$lm_overview}</span></a>
		</li>
		{if !CheckModule(15)}{$imperio}{/if}
		{if !CheckModule(3)}<li>
	    <span class="menu_icon">
		<img width="38" height="29" src="./styles/theme/{$Raza_skin}/imagenes/navegacion/menu_icon.png">
        </span>
		<a class="menu_boton " href="?page=buildings&amp;mode=research"><span>{$lm_research}</span></a>
		</li>{/if}
		{if !CheckModule(2)}<li>
		<span class="menu_icon">
		<img width="38" height="29" src="./styles/theme/{$Raza_skin}/imagenes/navegacion/menu_icon.png">
        </span>
		<a class="menu_boton " href="?page=buildings"><span>{$lm_buildings}</span></a>
		</li>{/if}
		{if !CheckModule(4)}<li>
		<span class="menu_icon">
		<img width="38" height="29" src="./styles/theme/{$Raza_skin}/imagenes/navegacion/menu_icon.png">
        </span>
		<a class="menu_boton " href="?page=buildings&amp;mode=fleet"><span>{$lm_shipshard}</span></a>
		</li>{/if}
		{if !CheckModule(5)}<li>
		<span class="menu_icon">
		<img width="38" height="29" src="./styles/theme/{$Raza_skin}/imagenes/navegacion/menu_icon.png">
        </span>
		<a class="menu_boton " href="?page=buildings&amp;mode=defense"><span>{$lm_defenses}</span></a>
		</li>{/if}
		<li>
		<span class="menu_icon">
		<img width="38" height="29" src="./styles/theme/{$Raza_skin}/imagenes/navegacion/menu_icon.png">
        </span><a class="menu_boton " href="?page=mercado"><span class="mercader_menu">{$lm_trader}</span></a>
		</li>
		{if !CheckModule(9)}<li>
		<span class="menu_icon">
		<img width="38" height="29" src="./styles/theme/{$Raza_skin}/imagenes/navegacion/menu_icon.png">
        </span>
		<a class="menu_boton " href="?page=fleet"><span>{$lm_fleet}</span></a>
		</li>{/if}
		{if !CheckModule(28)}<li>
		<span class="menu_icon">
		<img width="38" height="29" src="./styles/theme/{$Raza_skin}/imagenes/navegacion/menu_icon.png">
        </span><a class="menu_boton " href="?page=techtree"><span>{$lm_technology}</span></a>
		</li>{/if}
		{if !CheckModule(23)}<li>
		<span class="menu_icon">
		<img width="38" height="29" src="./styles/theme/{$Raza_skin}/imagenes/navegacion/menu_icon.png">
        </span><a class="menu_boton " href="?page=resources"><span>{$lm_resources}</span></a>
		</li>{/if}
		{if !CheckModule(11)}<li><span class="menu_icon">
		<img width="38" height="29" src="./styles/theme/{$Raza_skin}/imagenes/navegacion/menu_icon.png">
        </span>
		<a class="menu_boton " href="?page=galaxy"><span>{$lm_galaxy}</span></a>
		</li>{/if}
		{if !CheckModule(0)}<li>
		<span class="menu_icon">
		<img width="38" height="29" src="./styles/theme/{$Raza_skin}/imagenes/navegacion/menu_icon.png">
        </span>
		<a class="menu_boton " href="?page=alliance"><span>{$lm_alliance}</span></a>
		</li>{/if}
		<li>
		<span class="menu_icon">
		<img width="38" height="29" src="./styles/theme/{$Raza_skin}/imagenes/navegacion/menu_icon.png">
        </span>
		<a class="menu_boton " href="?page=oficiales"><span class="mercader_menu">{$lm_officiers}</span></a>
		</li>
		{if !CheckModule(25)}<li class="abajo_menu">
		<span class="menu_icon">
		<img width="38" height="29" src="./styles/theme/{$Raza_skin}/imagenes/navegacion/menu_icon.png">
        </span>
		<a class="menu_boton_3 " href="?page=statistics"><span>{$lm_statistics}</span></a>
		</li>{/if}		
    </ul>
	<div id="oficiales_menu">
	<a href="game.php?page=oficiales"><img src="styles/theme/{$Raza_skin}/imagenes/navegacion/oficiales/{$Comandante}" class="tooltip" name="{$comandante}"></a>
	<a href="game.php?page=oficiales"><img src="styles/theme/{$Raza_skin}/imagenes/navegacion/oficiales/{$Geologo}" class="tooltip" name="{$geologo}"></a>
	<a href="game.php?page=oficiales"><img src="styles/theme/{$Raza_skin}/imagenes/navegacion/oficiales/{$Almirante}" class="tooltip" name="{$almirante}"></a>
	<a href="game.php?page=oficiales"><img src="styles/theme/{$Raza_skin}/imagenes/navegacion/oficiales/{$Ingeniero}" class="tooltip" name="{$ingeniero}"></a>
	<a href="game.php?page=oficiales"><img src="styles/theme/{$Raza_skin}/imagenes/navegacion/oficiales/{$Tecnocrata}" class="tooltip" name="{$tecnocrata}"></a>
	</div>
	{if $closed}
	<table width="70%" id="infobox" style="border: 3px solid red; text-align:center; margin-left: 6px; margin-top: 3px;"><tr><td>{$closed}</td></tr></table>
	{elseif $delete}
	<table width="70%" id="infobox" style="border: 3px solid red; text-align:center; margin-left: 6px; margin-top: 3px;"><tr><td>{$tn_delete_mode} {$delete}</td></tr></table>
	{elseif $vacation}
	<table width="70%" id="infobox" style="border: 3px solid red; text-align:center; margin-left: 6px; margin-top: 3px;"><tr><td>{$tn_vacation_mode} {$vacation}</td></tr></table>
	{/if}
</div>