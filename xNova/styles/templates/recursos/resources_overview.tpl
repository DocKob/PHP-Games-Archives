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
				<div id="titular_texto" style="display: block;">{$lm_resources}</div>
			</div>
        </div>
	</div> 
{include file="left_menu.tpl"}
<div id="contenidoMostrado">                               
<div id="elCosoxD">
<div class="coso_izquierda"></div>
<div class="coso_derecha"></div>
<div id="planeta">
{$header}
</div>
<div id="titulo_alternativo">
    <ul class="tabsbelow">
        <li>
              <span>{$Production_of_resources_in_the_planet}</span>
        </li>                                    
    </ul>
</div>
<div id="eins">
        <div>	
    <form action="" method="post">
    <table class="recursos_tabla" width="100%">
    <tbody>
	<tr>
        <td>&nbsp;</td>
		<td><img class="tooltip" name="{$Metal}" src="styles/theme/{$Raza_skin}/images/metal.jpg" /></td>
        <td><img class="tooltip" name="{$Crystal}" src="styles/theme/{$Raza_skin}/images/cristal.jpg" /></td>
        <td><img class="tooltip" name="{$Deuterium}" src="styles/theme/{$Raza_skin}/images/deuterio.jpg" /></td>
        <td><img class="tooltip" name="{$Norio}" src="styles/theme/{$Raza_skin}/images/norio.jpg" /></td>		
        <td><img class="tooltip" name="{$Energy}" src="styles/theme/{$Raza_skin}/images/energia.jpg" /></td>
    </tr><tr style="height: 22px">
        <td><b>{$rs_basic_income}</b></td>
        <td class="semi_remarcado"><b>{$metal_basic_income}</b></td>
        <td class="semi_remarcado"><b>{$crystal_basic_income}</b></td>
        <td class="semi_remarcado"><b>{$deuterium_basic_income}</b></td>
        <td class="semi_remarcado"><b>{$norio_basic_income}</b></td>		
        <td class="semi_remarcado"><b>{$energy_basic_income}</b></td>
    </tr>
    {foreach item=CurrPlanetInfo from=$CurrPlanetList}
	<tr>
		<td><img class="tooltip" name="{$CurrPlanetInfo.type}" src="styles/theme/{$Raza_skin}/gebaeude/{$CurrPlanetInfo.id}.png" width="50" height="50" /><br /><font color="lime">({$CurrPlanetInfo.level} {$CurrPlanetInfo.level_type})</font></td>
		<td class="semi_remarcado"><h3 class="tooltip" name="{$CurrPlanetInfo.irs}">{$CurrPlanetInfo.metal_type}</h3></td>
		<td class="remarcado"><h3 class="tooltip" name="{$CurrPlanetInfo.irs}">{$CurrPlanetInfo.crystal_type}</h3></td>
		<td class="semi_remarcado"><h3 class="tooltip" name="{$CurrPlanetInfo.irs}">{$CurrPlanetInfo.deuterium_type}</h3></td>
		<td class="remarcado"><h3 class="tooltip" name="{$CurrPlanetInfo.irs}">{$CurrPlanetInfo.norio_type}</h3></td>		
		<td class="semi_remarcado"><h3>{$CurrPlanetInfo.energy_type}</h3></td>
		<td>
			{html_options name=$CurrPlanetInfo.name options=$option selected=$CurrPlanetInfo.optionsel}
		</td>
	</tr>
    {/foreach}
	<tr>
	<td>&nbsp;</td>
	</tr>
	<tr>
        <td><b>{$rs_storage_capacity}</b></td>
        <td class="remarcado">{$metalmax}</td>
        <td class="remarcado">{$crystalmax}</td>
        <td class="remarcado">{$deuteriummax}</td>
        <td class="remarcado">{$noriomax}</td>
        <td class="remarcado">-</td>
    </tr><tr>
        <td><b>{$rs_sum}</b></td>
        <td class="semi_remarcado">{$metal_total}</td>
        <td class="semi_remarcado">{$crystal_total}</td>
        <td class="semi_remarcado">{$deuterium_total}</td>
        <td class="semi_remarcado">{$norio_total}</td>		
        <td class="semi_remarcado">{$energy_total}</td>
		<td><input class="campo_comun" name="action" value="{$rs_calculate}" type="submit"></td>	
    </tr>
    <tr>
        <td><b>{$rs_daily}</b></td>
        <td class="remarcado">{$daily_metal}</td>
        <td class="remarcado">{$daily_crystal}</td>
        <td class="remarcado">{$daily_deuterium}</td>
        <td class="remarcado">{$daily_norio}</td>		
        <td class="remarcado">{$energy_total}</td>
    </tr>
    <tr>
        <td><b>{$rs_weekly}</b></td>
        <td class="semi_remarcado">{$weekly_metal}</td>
        <td class="semi_remarcado">{$weekly_crystal}</td>
        <td class="semi_remarcado">{$weekly_deuterium}</td>
        <td class="semi_remarcado">{$weekly_norio}</td>		
        <td class="semi_remarcado">{$energy_total}</td>
    </tr>
    </tbody>
    </table>
    </form>
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