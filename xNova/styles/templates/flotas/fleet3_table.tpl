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
<table width="95%">
	<tr style="height:20px">
		<th colspan="2" class="success">{$fl_fleet_sended}</span></th>
	</tr>
    <tr style="height:20px">
        <td>{$fl_mission}</td>
        <td>{$mission}</td>
	</tr>
    <tr style="height:20px">
        <td>{$fl_distance}</td>
        <td>{$distance}</td>
    </tr>
    <tr style="height:20px">
        <td>{$fl_fleet_speed}</td>
        <td>{$speedallsmin}</td>
    </tr>
    <tr style="height:20px">
        <td>{$fl_fuel_consumption}</td>
        <td>{$consumption}</td>
    </tr>
    <tr style="height:20px">
        <td>{$fl_from}</td>
        <td>{$from}</td>
    </tr>
    <tr style="height:20px">
        <td>{$fl_destiny}</td>
        <td>{$destination}</td>
    </tr>
    <tr style="height:20px">
        <td>{$fl_arrival_time}</td>
        <td>{$start_time}</td>
    </tr>
    <tr style="height:20px">
        <td>{$fl_return_time}</td>
        <td>{$end_time}</td>
    </tr>
    <tr style="height:20px">
        <th colspan="2">{$fl_fleet}</th>
    </tr>
	{foreach key=Shipname item=Shipcount from=$FleetList}
	<tr>
	<td>{$Shipname}</td>
	<td>{$Shipcount}</td>
	</tr>
	{/foreach}
</table>
</div>	
</div>
<div class="new_footer"></div>
<br /><br /><br />		
</div>
</div>	
</div>	
</div>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}