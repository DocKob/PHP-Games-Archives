<div id="planet_menu">
	<div id="planet_menu_header"><a href="javascript:ShowPlanetMenu()" id="planet_menu_link"><font color="red">>></font> {$show_planetmenu}</a></div>
	<div id="planet_menu_content"{if $is_pmenu == 0} style="display:none;"{/if}>
		<table style="text-align:center;margin:0">
			<tr>
			{foreach key=PlanetID item=PlanetInfo from=$PlanetMenu}
				<td class="transparent" style="width:80px;">
				<a href="{$PlanetInfo.url}" title="{$PlanetInfo.name}">
					<img src="styles/theme/{$Raza_skin}/planeten/small/s_{$PlanetInfo.image}.png" height="40" width="40" alt="{$PlanetInfo.name}" />
					<br />
					{if $PlanetID == $current_pid}
					<span style="color:#FFFF00;" class="planetname"><b>{$PlanetInfo.name}</b></span>
					<br /><span style="color:#FE9A2E;"><b>[{$PlanetInfo.galaxy}:{$PlanetInfo.system}:{$PlanetInfo.planet}]</b></span>
					{else}
					{if $PlanetInfo.ptype == 3}<span style="color:#CCCCCC">{else}<span style="color:#2E9AFE">{/if}{$PlanetInfo.name}</span>
					<br /><span style="color:#58FA58;">[{$PlanetInfo.galaxy}:{$PlanetInfo.system}:{$PlanetInfo.planet}]</span>
					{/if}
					<br /><span id="planet_{$PlanetID}"></span>
				</a>
				</td>
			{/foreach}
			</tr>
		</table>
	</div>
</div>
<script type="text/javascript">
planetmenu	= {$Scripttime};
</script>
