{include file="overall_header.tpl"}
<body id="mercado">
<div id="tooltip" class="tip"></div>
<div class="contenido_big">
<div id="cajaBG">
    <div id="caja">
<div id="topnav" class="header_g"> 	
		{include file="overall_topnav.tpl"}	
			<div id="titular">
			<div id="estructura_titular" style="position:relative;">
				<div id="titular_texto" style="display: block;">{$fl_new_mission_title}</div>
			</div>
        </div>
	</div> 
{include file="left_menu.tpl"}
<div id="contenidoMostrado">                               
<div id="elCosoxD">
<div class="coso_izquierda_corto"></div>
<div class="coso_derecha_corto"></div>
<div id="planeta_small" style="background-image: url(styles/theme/{$Raza_skin}/adds/flotas1.jpg);"></div>
<div id="titulo_alternativo_corto">
    <ul class="tabsbelow">
        <li>
              <span><b>{$fl_fleets}:</b> {$flyingfleets} / {$maxfleets}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>{$fl_expeditions}:</b> {$currentexpeditions} / {$maxexpeditions} 			<a class="right" href="javascript:maxShips();"><b><font color="red">>></font> {$fl_select_all_ships}</b></a> </span>
        </li>                                    
    </ul>
</div>
<div id="eins">
        <div>	
	<br />
		
        {if !$slots_available}
		<table width="95%"><tr><th colspan="9" ><font color="red"><b>{$fl_no_more_slots}</b></font></th></tr></table>
		{/if}
        <table width="95%" height="100%">
		<form action="?page=fleet1" method="POST">
		<input type="hidden" name="galaxy" value="{$galaxy}" />
        <input type="hidden" name="system" value="{$system}" />
        <input type="hidden" name="planet" value="{$planet}" />
        <input type="hidden" name="planet_type" value="{$planettype}" />
        <input type="hidden" name="mission" value="{$target_mission}" />
        <input type="hidden" name="maxepedition" value="{$envoimaxexpedition}" />
        <input type="hidden" name="curepedition" value="{$expeditionencours}" />
        <input type="hidden" name="target_mission" value="{$target_mission}" />
		<div>
			<ul class="naves">
		{foreach name=Fleets item=FleetRow from=$FleetsOnPlanet}   
			{if $FleetRow.speed != 0}
			<li>
			<img class="tooltip" name="<font color='orange'><b>{$FleetRow.name}:</b></font> <td id='ship{$FleetRow.id}_value'>{$FleetRow.count}</td><br /><b>{$fl_speed_title}</b> {pretty_number($FleetRow.speed)}" src="styles/theme/{$Raza_skin}/gebaeude/{$FleetRow.id}.png" width="70" height="70" /><br />{else}&nbsp;{/if}
			{if $FleetRow.id == 212} {else}<font color="orange"><b><ul id="ship{$FleetRow.id}_value">{$FleetRow.count}</ul></b></font>{/if}
			{if $FleetRow.speed != 0}
			<input name="ship{$FleetRow.id}" id="ship{$FleetRow.id}_input" class="campo_comun" size="10" value="" /><a href="javascript:maxShip('ship{$FleetRow.id}');"><img class="max_img" src="styles/theme/{$Raza_skin}/imagenes/navegacion/none.png" /></a>
			</li>
			{else}
			&nbsp;
			{/if}
		{/foreach}
			</ul>
			</div>
	
			{if $smarty.foreach.Fleets.total == 0}
			<table>
			<th>&nbsp;{$fl_no_ships}&nbsp;</th>
			</table>
			{/if}
			<table>{if $smarty.foreach.Fleets.total > 0}<input type="submit" class="submit" value="{$fl_continue}" />{/if}</table>
        </form>
		</table>
        </div>
</div>	
<div class="new_footer"></div>	
{if isset($aks_invited_mr)}  	
<div id="titulo_alternativo_secundario">
    <ul class="tabsbelow">
        <li>
              <span><b>{$fl_sac_of_fleet}</b></span>
        </li>                                    
    </ul>
</div>
<div id="eins">
<div>
{include file="flotas/fleetACS_table.tpl"}
</div>
</div>	
<div class="new_footer"></div>		
{/if}
<div id="titulo_alternativo_secundario">
    <ul class="tabsbelow">
        <li>
              <span><b>{$fl_bonus}</b></span>
        </li>                                    
    </ul>
</div>
<div id="eins">
<div>
<div id="info_centro">	
	<span id="info_izquierda">
		<img class="tooltip" name="<font color='orange'><b>{$fl_bonus_attack}:</b></font> +{$bonus_attack}%" src="styles/theme/{$Raza_skin}/imagenes/infos/Atacar.png" />
		<img class="tooltip" name="<font color='orange'><b>{$fl_bonus_defensive}:</b></font> +{$bonus_defensive}%" src="styles/theme/{$Raza_skin}/imagenes/infos/defensa.png" />
		<img class="tooltip" name="<font color='orange'><b>{$fl_bonus_shield}:</b></font> +{$bonus_shield}%" src="styles/theme/{$Raza_skin}/imagenes/infos/shield.png" />	
	</span>	
	<span>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	</span>
	<span id="info_derecha">
		<img class="tooltip" name="<font color='orange'><b>{$bonus_comp}:</b></font> +{$bonus_combustion}%" src="styles/theme/{$Raza_skin}/imagenes/infos/combustion.png" />
		<img class="tooltip" name="<font color='orange'><b>{$bonus_impul}:</b></font> +{$bonus_impulse}%" src="styles/theme/{$Raza_skin}/imagenes/infos/impulso.png" />
		<img class="tooltip" name="<font color='orange'><b>{$bonus_hyper}:</b></font> +{$bonus_hyperspace}%" src="styles/theme/{$Raza_skin}/imagenes/infos/hiperespacio.png" />	
	</span>
</div>	
</div>
</div>	
<div class="new_footer"></div>		
<br /><br /><br />			
</div>
<div id="menu_flotas">
			<div id="lista_misiones">    
                <p><b>{$fl_titulo_misiones}</b></p>  
			 {foreach name=FlyingFleets item=FlyingFleetRow from=$FlyingFleetList}
			<div class="misiones_top"></div>
			<div class="misiones"> 
			<table id="contenido_informativo">
			<span class="tooltip planeta_misiones" name="<table>
			<tr><td>
			<b><font color='orange'>{$fl_beginning}:</font></b> [{$FlyingFleetRow.start_galaxy}:</font>{$FlyingFleetRow.start_system}:{$FlyingFleetRow.start_planet}]
			</td></tr>
			<tr><td>
			<b><font color='orange'>{$fl_destiny}:</font></b> [{$FlyingFleetRow.end_galaxy}:{$FlyingFleetRow.end_system}:{$FlyingFleetRow.end_planet}]
			</td></tr>
			</table>"></span>
			
			<span class="tooltip naves_misiones" name="<table>
			<tr><th>
			{$fl_info_detail}
			</th></tr>
			<tr><td>
			{foreach key=name item=count from=$FlyingFleetRow.FleetList}
			<b><font color='orange'>{$name}:</font></b> {$count} <br />
			{/foreach}
			</td></tr>
			</table>"></span>
			
			<span class="tooltip info_misiones" name="<table>
			<tr><td>
			<b><font color='orange'>{$fl_mission}:</font></b> {$FlyingFleetRow.missionname}</td></tr>
			<tr><td>
			<b><font color='orange'>{$fl_departure}:</font></b><br /> {$FlyingFleetRow.start_time}
			</td></tr>
			<tr><td>
			<b><font color='orange'>{$fl_arrival}:</font></b><br /> {$FlyingFleetRow.end_time}
			</td></tr>
			</table>"></span>
			</table><center>
			<b>{$FlyingFleetRow.backin}</b><br /> 
			{if $FlyingFleetRow.way != 1} 
			<form action="?page=fleet&amp;action=sendfleetback" method="post">
			<input name="fleetid" value="{$FlyingFleetRow.id}" type="hidden" />
			<input value="&nbsp;{$fl_send_back}&nbsp;" class="campo_comun" type="submit" />
			</form> 
			{if $FlyingFleetRow.mission == 1}
			<form action="?page=fleet&amp;action=getakspage" method="post">
			<input name="fleetid" value="{$FlyingFleetRow.id}" type="hidden" />
			<input value="&nbsp;{$fl_acs}&nbsp;" class="campo_comun" type="submit" />
			</form>
			{/if}
			{else}
			<font color="lime"><b>--{$fl_returning}--</b></font>
			{/if}
			</center></div> 
			<div class="misiones_footer"></div>			
		{foreachelse}
	<div class="misiones_top"></div>
	<div class="misiones"><center>
	<b>{$fl_no_misiones}</b>
	</center></div>	
	<div class="misiones_footer"></div>	
	{/foreach} 
		</div>		
</div>	
</div>
</div>	
</div>	
</div>
{if isset($smarty.get.alert)}
<script type="text/javascript">
alert(unescape("{$smarty.get.alert}"));
</script>
{/if}
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}