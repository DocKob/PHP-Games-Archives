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
				<div id="titular_texto" style="display: block;">{$thisgalaxy}:{$thissystem}:{$thisplanet} - {if $thisplanet_type == 3}{$fl_moon}{else}{$fl_planet}{/if}</div>
			</div>
        </div>
	</div> 
{include file="left_menu.tpl"}
<div id="contenidoMostrado">                               
<div id="elCosoxD">
<div class="coso_izquierda_corto"></div>
<div class="coso_derecha_corto"></div>
<div id="planeta_small" style="background-image: url(styles/theme/{$Raza_skin}/adds/flotas3.jpg);"></div>
<div id="titulo_alternativo_corto">
    <ul class="tabsbelow">
        <li>
              <span><b><font color="red">>></font>{$fl_fuel_consumption}:</b> {pretty_number($consumption)}</span>
        </li>                                    
    </ul>
</div>
<div id="eins">
        <div>	
<form action="game.php?page=fleet3" method="post">
<input type="hidden" name="galaxy" value="{$galaxy}">
<input type="hidden" name="system" value="{$system}">
<input type="hidden" name="planet" value="{$planet}">
<input type="hidden" name="planettype" value="{$planettype}">
<input type="hidden" name="speed" value="{$speed}">
<input type="hidden" name="fleet_group" value="{$fleet_group}">
<input type="hidden" name="usedfleet" value="{$fleetarray}">
<table cellspacing="0" cellpadding="0" id="mercado_tabla" >
			<tbody><tr>
                    <td></td>
					<td>{$fl_resources}</td>
		            <td>{$fl_cantidad}</td>
					<td>{$fl_accion}</td>
				</tr>
				<!-- Metal -->
				<tr class="alt">
                    <td class="resIcon noCenter"><img src="styles/theme/{$Raza_skin}/images/metal.jpg" /></td>
					<td class="noCenter">{$Metal}</td>
    				<td>
					<div class="bg_input"><input class="text" name="metal" size="10" onchange="calculateTransportCapacity();" type="text" style="text-align: right;" /></div>
					</td>
						<td>
                            <span class="marca_color"><a href="javascript:maxResource('metal');"><span class="max"></span></a></span>
						</td>
    			</tr>	
				<!-- Cristal -->
				<tr class="alt_2">
                    <td class="resIcon noCenter"><img src="styles/theme/{$Raza_skin}/images/cristal.jpg" /></td>
					<td class="noCenter">{$Crystal}</td>
    				<td>
					<div class="bg_input"><input class="text" name="crystal" size="10" onchange="calculateTransportCapacity();" type="text" style="text-align: right;" /></div>
					</td>
						<td>
                             <span class="marca_color"><a href="javascript:maxResource('crystal');"><span class="max"></span></a></span>
						</td>
    			</tr>
				<!-- Deuterio -->
				<tr class="alt">
                    <td class="resIcon noCenter"><img src="styles/theme/{$Raza_skin}/images/deuterio.jpg" /></td>
					<td class="noCenter">{$Deuterium}</td>
						<td>
							<div class="bg_input"><input class="text" name="deuterium" onchange="calculateTransportCapacity();" type="text" style="text-align: right;" size="10" /></div>
						</td>
						<td>
                            <span class="marca_color"><a href="javascript:maxResource('deuterium');"><span class="max"></span></a></span>
						</td>
				</tr>
				<!-- Norio -->
				<tr class="alt_2">
                    <td class="resIcon noCenter"><img src="styles/theme/{$Raza_skin}/images/norio.jpg" /></td>
					<td class="noCenter">{$Norio}</td>
						<td>
							<div class="bg_input"><input class="text" name="norio" onchange="calculateTransportCapacity();" type="text" style="text-align: right;" size="10" /></div>
						</td>
						<td>
                             <span class="marca_color"><a href="javascript:maxResource('norio');"><span class="max"></span></a></span>
						</td>
				</tr>
				<!-- Otras cosas -->
				<tr class="alt" style="height:20px;">
        			<td>{$fl_resources_left}</td>
					<td colspan="2" id="remainingresources">0</td>
					<td><b><a href="javascript:maxResources()"><font color="orange">{$fl_all_resources}</font></a></b></td>
				</tr>
				<tr>
					<td style="padding:10px" colspan="4">{$tr_descr}	
					<input type="submit" value="{$fl_continue}" class="submit" />
					</td>
				</tr>
			</tbody>
		</table>
</div>
</div>
<div class="new_footer"></div>	
<div id="titulo_alternativo_secundario">
    <ul class="tabsbelow">
        <li>
              <span><b>{$fl_mission}</b></span>
        </li>                                    
    </ul>
</div>
<div id="eins">
<div>
<br />
<table>
<tr>
<td style="width:50%;margin:0;padding:0;">
        		<table width="270px"><tr>
        			{foreach item=MissionName key=MissionID from=$MissionSelector}
					
						<td>
						 <label for="radio_{$MissionID}">
                     <img class="tooltip" name="{$MissionName}" src="styles/theme/{$Raza_skin}/imagenes/infos/{$MissionID}.png" /><br /><input id="radio_{$MissionID}" type="radio" name="mission" value="{$MissionID}" {if $mission == $MissionID}checked="checked"{/if} style="width:60px;">
                  </label>
						</td>
					{/foreach}	
						<tr>
							{if $MissionID == 15}<div style="color:red">{$fl_expedition_alert_message}</div><br />{/if}
							{if $MissionID == 11}<div style="color:red">{$fl_dm_alert_message}</div><br />{/if}
						</tr>					
					</tr>					
        		</table>
        	</td>			
</tr>
{if $StaySelector}
	<tr style="height:20px;">
		<th class="transparent" colspan="3">{$fl_hold_time}</th>
	</tr>
	<tr style="height:20px;">
		<td class="transparent" colspan="3">
			{html_options name=holdingtime options=$StaySelector} {$fl_hours}
		</td>
	</tr>
{/if} 
</table></form>
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