{include file="overall_header.tpl"}
<body id="mercado">
<div id="tooltip" class="tip"></div>
<div class="contenido_big">
<div id="cajaBG">
    <div id="caja">
<div id="topnav" class="header_normal"> 	
		{include file="overall_topnav.tpl"}	
			<div id="titular">
			<div id="estructura_titular" style="position:relative;">
				<div id="titular_texto" style="display: block;">{$fl_send_fleet}</div>
			</div>
        </div>
	</div> 
{include file="left_menu.tpl"}
<div id="contenidoMostrado">                               
<div id="elCosoxD">
<div class="coso_izquierda_corto"></div>
<div class="coso_derecha_corto"></div>
<div id="planeta_small" style="background-image: url(styles/theme/{$Raza_skin}/adds/flotas2.jpg);"></div>
<div id="titulo_alternativo_corto">
    <ul class="tabsbelow">
        <li>
              <span>&nbsp;</span>
        </li>                                    
    </ul>
</div>
<div id="eins">
        <div>	<br />
<form action="game.php?page=fleet2" method="post" onsubmit="return CheckTarget()" id="form">
	<input type="hidden" name="fleet_group" value="0" />
	<input type="hidden" name="mission" value="{$mission}" />
	<input type="hidden" name="usedfleet" value="{$fleetarray}" />
		<table class="datos_vuelo" >
		   <tr>
            	<td>
				
                    <input class="campo_comun" name="galaxy" size="3" maxlength="2" onChange="updateVars()" onKeyUp="updateVars()" value="{$galaxy_post}">
                    <input class="campo_comun" name="system" size="3" maxlength="3" onChange="updateVars()" onKeyUp="updateVars()" value="{$system_post}">
                    <input class="campo_comun" name="planet" size="3" maxlength="2" onChange="updateVars()" onKeyUp="updateVars()" value="{$planet_post}">
                    <select name="planettype" onChange="updateVars()" onKeyUp="updateVars()">
                    {html_options options=$options_selector selected=$options}
                    </select>
					<select name="speed" onChange="updateVars()" onKeyUp="updateVars()">
                    {html_options options=$AvailableSpeeds}
					</select><font color="#f2d999"><b>%</b></font>
                    </select>
            	</td>
            </tr>

            <tr class="distancia">
            	<td style="height:50px;"><font color="#2b0000"><h4 class="tooltip" style="cursor:help;" name="{$fl_distance}" id="distance">0</h4></font></td>
            </tr>
			<tr>
            	<td><input class="submit" type="submit" value="{$fl_continue}"></td>
            </tr>	

			</table>

			<table class="info_vuelo" align="right" width="300px">
            <tr class="semi_remarcado">
            	<td><b>{$fl_flying_time}:</b></td>
            	<td id="duration">0</td>
            </tr>
            <tr class="remarcado">
                <td><b>{$fl_fuel_consumption}:</b></td>
                <td id="consumption">0</td>
            </tr>
            <tr class="semi_remarcado">
                <td><b>{$fl_max_speed}:</b></td>
                <td id="maxspeed">0</td>
            </tr>
            <tr class="remarcado">
                <td><b>{$fl_cargo_capacity}:</b></td>
                <td id="storage">0</td>
            </tr>
			</table>

</form>
 </div>
</div>
<div class="new_footer"></div>	
<div id="titulo_alternativo_secundario">
    <ul class="tabsbelow">
        <li>
              <span><b>{$fl_my_planets}</b></span>
        </li>                                    
    </ul>
</div>
<div id="eins">
<div>
<br />
<table width="270px"><tr>
			{foreach name=ColonyList item=ColonyRow from=$Colonylist}
			{if $smarty.foreach.ColonyList.iteration is odd}{/if}
			<td><a href="javascript:setTarget({$ColonyRow.galaxy},{$ColonyRow.system},{$ColonyRow.planet},{$ColonyRow.planet_type});updateVars();"><img width="50" height="50" border="0" src="{$dpath}planeten/small/s_{$ColonyRow.image}.jpg" alt="{$ColonyRow.name}" /><br /><b>{$ColonyRow.name}</b> <br />{if $ColonyRow.planet_type == 3}{$fl_moon_shortcut}{/if}[{$ColonyRow.galaxy}:{$ColonyRow.system}:{$ColonyRow.planet}]</a></td>
			{if $smarty.foreach.ColonyList.iteration is even}{/if}
			{foreachelse}
			{$fl_no_colony}<br />
			{/foreach}
			{if $AKSList}
			{$fl_acs_title}<br />
            {foreach item=AKSRow from=$AKSList}
			<a href="javascript:setACSTarget({$AKSRow.galaxy},{$AKSRow.system},{$AKSRow.planet},{$AKSRow.planet_type}, {$AKSRow.id});updateVars();">{$AKSRow.name} - [{$AKSRow.galaxy}:{$AKSRow.system}:{$AKSRow.planet}]</a><br />
			{/foreach}
			{/if}			
</tr></table>
</div>
</div>	
<div class="new_footer"></div>
<br /><br /><br />			
</div>
</div>
</div>	
</div>	
</div>
<script type="text/javascript">
data	= {$fleetdata};
</script>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}