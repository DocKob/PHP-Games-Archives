{include file="overall_header.tpl"}
<body id="imperio_body">
<div id="tooltip" class="tip"></div>
<center>
<div id="imperio">
<br />
 	<table id="imperio_tabla" style="text-align: center;">        
			<tr>
                <td></td>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
				<td><a href="javascript:opener.location.replace('game.php?page=overview&amp;cp={$PlanetsInfoRow.InfoList.id}&amp;re=0'); self.close();"><img class="redondeada" width="80" height="80" border="0" src="{$dpath}planeten/small/s_{$PlanetsInfoRow.InfoList.image}.jpg" alt="{$PlanetsInfoRow.InfoList.name}" /></a></td>
				
				{/foreach}
            </tr>
            <tr>
				<td></td>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
					<td class="tech_nombre"><font color="#e0d164"><h2><b>{$PlanetsInfoRow.InfoList.name}</b></h2></font></td>
				{/foreach}
            </tr>
            <tr>
				<td></td>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
					<td class="tech_nombre"><a class="tooltip" name="{$iv_coords}" href="javascript:opener.location.replace('game.php?page=galaxy&amp;mode=3&amp;galaxy={$PlanetsInfoRow.InfoList.galaxy}&amp;system={$PlanetsInfoRow.InfoList.system}'); self.close();">[{$PlanetsInfoRow.InfoList.galaxy}:{$PlanetsInfoRow.InfoList.system}:{$PlanetsInfoRow.InfoList.planet}]</a></td>
				{/foreach}
            </tr>
            <tr>
				<td></td>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
					<td class="tech_nombre tooltip" name="{$iv_fields}"><font color="#41914c">{$PlanetsInfoRow.InfoList.field_current}/{$PlanetsInfoRow.InfoList.field_max}</font></td>
				{/foreach}
			</tr>
		
			<tr>
				<th class="repetido" colspan="{$colspan}">{$iv_resources}</th>
            </tr>
			<tr>
				<td><img class="tooltip" name="<font color='#a0b3cd'><b><h3>{$Metal}</h3></b></font>" src="styles/theme/{$Raza_skin}/images/metal.jpg" /></td>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
					<td class="tech_nombre"><font color="#a0b3cd"><b><h3>{$PlanetsInfoRow.InfoList.metal}</h3></b></font></td>
				{/foreach}
			</tr>
            <tr>
				<td><img class="tooltip" name="<font color='#6eb6ff'><b><h3>{$Crystal}</h3></b></font>" src="styles/theme/{$Raza_skin}/images/cristal.jpg" /></td>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
					<td class="tech_nombre"><font color="#6eb6ff"><b><h3>{$PlanetsInfoRow.InfoList.crystal}</h3></b></font></td>
				{/foreach}
			</tr>
			<tr>
				<td><img class="tooltip" name="<font color='#dbfff8'><b><h3>{$Norio}</h3></b></font>" src="styles/theme/{$Raza_skin}/images/norio.jpg" /></td>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
					<td class="tech_nombre"><font color="#dbfff8"><b><h3>{$PlanetsInfoRow.InfoList.norio}</h3></b></font></td>
				{/foreach}
			</tr>
            <tr>
				<td><img class="tooltip" name="<font color='#1a8494'><b><h3>{$Deuterium}</h3></b></font>" src="styles/theme/{$Raza_skin}/images/deuterio.jpg" /></td>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
					<td class="tech_nombre"><font color="#1a8494"><b><h3>{$PlanetsInfoRow.InfoList.deuterium}</h3></b></font></td>
				{/foreach}
			</tr>
            <tr>
				<td><img class="tooltip" name="<font color='#e36b6a'><b><h3>{$Energy}</h3></b></font>" src="styles/theme/{$Raza_skin}/images/energia.jpg" /></td>
				{foreach item=PlanetsInfoRow from=$PlanetsList}
					<td class="tech_nombre"><font color="#e36b6a"><b><h3>{$PlanetsInfoRow.InfoList.energy_used}/{$PlanetsInfoRow.InfoList.energy_max}</h3></b></font></td>
				{/foreach}
            </tr>
			
			<tr>
              <th class="repetido" colspan="{$colspan}">{$iv_buildings}</th>
            </tr>
				{foreach item=Builds from=$build}
					<tr>
					<td><img class="tooltip" name="<b><h3>{$tech.$Builds}</h3></b>" src="styles/theme/{$Raza_skin}/gebaeude/{$Builds}.png" width="50" height="50" /></td>
					{foreach item=PlanetsInfoRow from=$PlanetsList}
						<td class="tech_nombre"><b><h3>{$PlanetsInfoRow.BuildsList.$Builds}</h3></b></td>
					{/foreach}
					</tr>
				{/foreach}
			<tr>
                <th class="repetido" colspan="{$colspan}">{$iv_technology}</th>
			</tr>
				{foreach item=Researchs from=$research}
					<tr>
					<td><img class="tooltip" name="<b><h3>{$tech.$Researchs}</h3></b>" src="styles/theme/{$Raza_skin}/gebaeude/{$Researchs}.png" width="50" height="50" /></td>
					{foreach item=PlanetsInfoRow from=$PlanetsList}
						<td class="tech_nombre"><b><h3>{$ResearchList.$Researchs}</h3></b></td>
					{/foreach}
					</tr>
				{/foreach}
            <tr>
               <th class="repetido" colspan="{$colspan}">{$iv_ships}</th>
            </tr>
				{foreach item=Fleets from=$fleet}
					<tr>
					<td><img class="tooltip" name="<b><h3>{$tech.$Fleets}</h3></b>" src="styles/theme/{$Raza_skin}/gebaeude/{$Fleets}.png" width="50" height="50" /></td>
					{foreach item=PlanetsInfoRow from=$PlanetsList}
						<td class="tech_nombre"><b><h3>{$PlanetsInfoRow.FleetsList.$Fleets}</h3></b></td>
					{/foreach}
					</tr>
				{/foreach}
            <tr>
                <th class="repetido" colspan="{$colspan}">{$iv_defenses}</th>
            </tr>
				{foreach item=Defenses from=$defense}
					<tr>
					<td><img class="tooltip" name="<b><h3>{$tech.$Defenses}</h3></b>" src="styles/theme/{$Raza_skin}/gebaeude/{$Defenses}.png" width="50" height="50" /></td>
					{foreach item=PlanetsInfoRow from=$PlanetsList}
						<td class="tech_nombre"><b><h3>{$PlanetsInfoRow.DefensesList.$Defenses}</h3></b></td>
					{/foreach}
					</tr>
				{/foreach}  
    </table>
</div>
</center>
{include file="overall_footer.tpl"}