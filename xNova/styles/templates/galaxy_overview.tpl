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
				<div id="titular_texto" style="display: block;">{$lm_galaxy} - {$gl_solar_system} {$galaxy}:{$system}</div>
			</div>
        </div>
	</div> 
{include file="left_menu.tpl"}
<div id="contenidoMostrado">                               
<div id="elCosoxD">
<div id="cabezza" style="background-image: url(styles/theme/{$Raza_skin}/imagenes/navegacion/head2.png);"></div>
<div id="eins_small">
        <div>	
	
	<table id="galaxia" width="95%">

	<tr>
		<td style="white-space: nowrap;width:30px"><b>{$gl_pos}</b></td>
		<td style="white-space: nowrap;width:30px"><b>{$gl_planet}</b></td>
		<td style="white-space: nowrap;width:130px"><b>{$gl_name_activity}</b></td>
		<td style="white-space: nowrap;width:30px"><b>{$gl_moon}</b></td>
		<td style="white-space: nowrap;width:30px"><b>{$gl_debris}</b></td>
		<td style="white-space: nowrap;width:150px"><b>{$gl_player_estate}</b></td>
		<td style="white-space: nowrap;width:80px"><b>{$gl_alliance}</b></td>
		<td style="white-space: nowrap;width:125px"><b>{$gl_actions}</b></td>
	</tr> 
    {foreach key=planet item=GalaxyRow from=$GalaxyRows}
	<tr>
	<td><a href="#">{$planet}</a></td>
	
	{if is_array($GalaxyRow)}
	{if $GalaxyRow.planet}
	<td><a class="tooltip_sticky" name="<table style='width:220px'>
	<tr>
	<th colspan='2'>{$gl_planet} {$GalaxyRow.planet.name} [{$galaxy}:{$system}:{$planet}]</th>
	</tr>
	<tr>
	<td style='width:80'>
	<img src='styles/theme/{$Raza_skin}/planeten/small/s_{$GalaxyRow.planet.image}.png' height='75' width=75 />
	</td>
	<td>
	{if $GalaxyRow.planet.spionage}
	<a href='javascript:doit(6,{$galaxy},{$system},{$planet},1,{$spio_anz});'>{$GalaxyRow.planet.spionage}</a>
	<br /><br />
	{/if}
	{if $GalaxyRow.planet.phalax}
	<a href='javascript:OpenPopup(&quot;?page=phalanx&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=1&quot;, &quot;&quot;, 640, 510);'>{$GalaxyRow.planet.phalax}</a>
	<br />
	{/if}
	{if $GalaxyRow.planet.attack}
	<a href='?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=1&amp;target_mission=1'>{$GalaxyRow.planet.attack}</a>
	<br />
	{/if}
	{if $GalaxyRow.planet.stayally}
	<a href='?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=1&amp;target_mission=5'>{$GalaxyRow.planet.stayally}</a>
	<br />
	{/if}
	{if $GalaxyRow.planet.stay}<a href='?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=1&amp;target_mission=4'>{$GalaxyRow.planet.stay}</a>
	<br />
	{/if}
	{if $GalaxyRow.planet.transport}
	<a href='?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=1&amp;target_mission=3'>{$GalaxyRow.planet.transport}</a>
	<br />
	{/if}
	{if $GalaxyRow.planet.missile}<a href='?page=galaxy&amp;mode=2&amp;galaxy={$galaxy}&amp;system={$system}&amp;gl_cp={$planet}'>{$GalaxyRow.planet.missile}</a>
	<br />
	{/if}
	</td>
	</tr></table>"><img src="styles/theme/{$Raza_skin}/imagenes/planeta.png" height="30" width="40" alt="" /></a></td>
	{/if}
	
	<td style="white-space: nowrap;">{$GalaxyRow.planetname.name}</td>
	
	<td style="white-space: nowrap;">
	{if $GalaxyRow.moon}
	<a class="tooltip_sticky" name="<table style='width:240px'>
	<tr>
	<th colspan='2'>{$gl_moon} {$GalaxyRow.moon.name} [{$galaxy}:{$system}:{$planet}]</th>
	</tr>
	<tr>
	<td style='width:80'>
	<img src='styles/theme/{$Raza_skin}/planeten/small/s_mond.png' height='75' style='width:75' />
	</td>
	<td>
	<table style='width:100%'>
	<tr><th colspan='2'>{$gl_features}</th>
	</tr>
	<tr>
	<td>{$gl_diameter}</td>
	<td>{$GalaxyRow.moon.diameter}</td>
	</tr>
	<tr>
	<td>{$gl_temperature}</td>
	<td>{$GalaxyRow.moon.temp_min}</td>
	</tr>
	<tr><th colspan=2>{$gl_actions}</th>
	</tr>
	<tr>
	<td colspan='2'>
	{if $GalaxyRow.moon.attack}
	<a href='?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=3&amp;target_mission=1'>{$GalaxyRow.moon.attack}</a>
	<br />
	{/if}<a href='?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=3&amp;target_mission=3'>{$GalaxyRow.moon.transport}</a>
	{if $GalaxyRow.moon.stay}
	<br />
	<a href='?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=3&amp;target_mission=4'>{$GalaxyRow.moon.stay}</a>
	{/if}
	{if $GalaxyRow.moon.stayally}
	<br />
	<a href='?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=3&amp;target_mission=5'>{$GalaxyRow.moon.stayally}</a>
	{/if}
	{if $GalaxyRow.moon.spionage}
	<br />
	<a href='javascript:doit(6,{$galaxy},{$system},{$planet},3,{$spio_anz});'>{$GalaxyRow.moon.spionage}</a>
	{/if}
	{if $GalaxyRow.moon.destroy}
	<br /><br />
	<a href='?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$planet}&amp;planettype=3&amp;target_mission=9'>{$GalaxyRow.moon.destroy}</a>
	<br />
	{/if}
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</table>"><img src="styles/theme/{$Raza_skin}/imagenes/luna.png" height="22" width="22" alt="{$GalaxyRow.moon.name}" /></a>
	{else}
	<img src="styles/theme/{$Raza_skin}/imagenes/luna_o.png" height="22" width="22" alt="{$GalaxyRow.moon.name}" />
	{/if}
	</td>
	
	
	
	<td style="white-space: nowrap;">
	{if $GalaxyRow.derbis}
	<a class="tooltip_sticky" name="<table style='width:240px'>
	<tr>
	<th colspan='2'>{$gl_debris_field} [{$galaxy}:{$system}:{$planet}]</th>
	</tr>
	<tr>
	<td style='width:80'><img src='styles/theme/{$Raza_skin}/planeten/debris.jpg' height='75' style='width:75' />
	</td>
	<td><table style='width:100%'>
	<tr>
	<th colspan='2'>{$gl_resources}:</th>
	</tr>
	<tr>
	<td>{$Metal}: </td>
	<td>{$GalaxyRow.derbis.metal}</td>
	</tr>
	<tr>
	<td>{$Crystal}: </td>
	<td>{$GalaxyRow.derbis.crystal}</td>
	</tr>
	<tr>
	<th colspan='2'>{$gl_actions}</th>
	</tr>
	<tr>
	<td colspan='2'>
	<a href='javascript:doit(8,{$galaxy},{$system},{$planet}, 2, &quot;{$GalaxyRow.derbis.GRecSended}|{$GalaxyRow.derbis.RecSended}&quot;);'>{$gl_collect}</a>
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</table>"><img src="styles/theme/{$Raza_skin}/imagenes/escombro.png" height="22" width="22" alt="" /></a>
	{else}
	<img src="styles/theme/{$Raza_skin}/imagenes/escombro_o.png" height="22" width="22" alt="" />
	{/if}
	</td>
	
	
	<td>
	<a class="tooltip_sticky" name="<table style='width:240px'>
	<tr>
	<th colspan='2'>{$GalaxyRow.user.playerrank}</th>
	</tr>
	<tr>
	{if $GalaxyRow.user.isown}
	<tr>
	<td>
	<a href='javascript:OpenPopup(&quot;?page=buddy&amp;mode=2&amp;u={$GalaxyRow.user.id}&quot;, &quot;&quot;, 720, 300);'>{$gl_buddy_request}</a>
	</td>
	</tr>
	<td><a href='#' onclick='return Dialog.Playercard({$GalaxyRow.user.id}, &quot;{$GalaxyRow.user.username}&quot;);'>{$gl_playercard}</a>
	</td>
	</tr>
	{/if}
	<tr>
	<td><a href='?page=statistics&amp;who=1&amp;start={$GalaxyRow.user.rank}'>{$gl_see_on_stats}</a>
	</td>
	</tr>
	</table>"><b>{$GalaxyRow.user.Systemtatus}{$GalaxyRow.user.username}{if $GalaxyRow.user.Systemtatus}</b>
	{/if}
	<b>{$GalaxyRow.user.Systemtatus2}</b>
	</a>
	</td>
	
	<td style="white-space: nowrap;">
	{if $GalaxyRow.ally}
	<a class="tooltip_sticky" name="<table style='width:240px'>
	<tr>
	<th>
	{$gl_alliance} {$GalaxyRow.ally.name} {$GalaxyRow.ally.member}
	</th>
	</tr>
	<td>
	<table>
	<tr>
	<td>
	<a href='?page=alliance&amp;mode=ainfo&amp;a={$GalaxyRow.ally.id}'>{$gl_alliance_page}</a>
	</td>
	</tr>
	<tr>
	<td>
	<a href='?page=statistics&amp;start={$GalaxyRow.ally.rank}&amp;who=2'>{$gl_see_on_stats}</a>
	</td>
	</tr>
	{if $GalaxyRow.ally.web}
	<tr>
	<td>
	<a href='{$GalaxyRow.ally.web}' target='allyweb'>{$gl_alliance_web_page}
	</td>
	</tr>
	{/if}
	</table>
	</td>
	</table>">
	{if $GalaxyRow.ally.inally == 2}
	<span style="color:#44a5ff"><b>{$GalaxyRow.ally.tag}</b></span>
	{elseif $GalaxyRow.ally.inally == 1}
	<span class="allymember">{$GalaxyRow.ally.tag}</span>
	{else}
	{$GalaxyRow.ally.tag}
	{/if}
	</a>
	{else}
	-
	{/if}
	</td>
	
	
	<td style="white-space: nowrap;">
	{if $GalaxyRow.action}
	{if $GalaxyRow.action.esp}
	<a href="javascript:doit(6,{$galaxy},{$system},{$planet},1,{$spio_anz});">
	<img src="styles/theme/{$Raza_skin}/imagenes/otros/e.gif" title="{$gl_spy}" alt="" />
	</a>
	{/if}
	{if $GalaxyRow.action.message}
	&nbsp;
	<a href="#" onclick="return Dialog.PM({$GalaxyRow.user.id});">
	<img src="styles/theme/{$Raza_skin}/imagenes/otros/m.gif" title="{$write_message}" alt="" />
	</a>
	{/if}
	{if $GalaxyRow.action.buddy}
	&nbsp;
	<a href="javascript:OpenPopup('?page=buddy&amp;mode=2&amp;u={$GalaxyRow.user.id}', '', 720, 300);"> 
	<img src="styles/theme/{$Raza_skin}/imagenes/otros/b.gif" title="{$gl_buddy_request}" alt="" />
	</a>
	{/if}
	{if $GalaxyRow.action.missle}
	&nbsp;
	<a href="?page=galaxy&amp;mode=2&amp;galaxy={$galaxy}&amp;system={$system}&amp;gl_cp={$planet}">
	<img src="styles/theme/{$Raza_skin}/imagenes/otros/r.gif" title="{$gl_missile_attack}" alt="" />
	</a>{/if}
	{else}
	-
	{/if}
	</td>
	{elseif empty($GalaxyRow)}
	<td><img class="tooltip" name="{$inavitado}" src="styles/theme/{$Raza_skin}/imagenes/planeta_o.png" height="30" width="40" /></td><td style="white-space: nowrap;">-</td><td style="white-space: nowrap;"><img src="styles/theme/{$Raza_skin}/imagenes/luna_o.png" height="22" width="22" /></td><td style="white-space: nowrap;"><img src="styles/theme/{$Raza_skin}/imagenes/escombro_o.png" height="22" width="22" /></td><td>-</td><td>-</td><td style="white-space: nowrap;">-</td>
	{else}
	<td><img class="tooltip" name="{$inavitado}" src="styles/theme/{$Raza_skin}/imagenes/planeta_o.png" height="30" width="40" /></td><td style="white-space: nowrap;">-</td><td style="white-space: nowrap;"><img src="styles/theme/{$Raza_skin}/imagenes/luna_o.png" height="22" width="22" /></td><td style="white-space: nowrap;"><img src="styles/theme/{$Raza_skin}/imagenes/escombro_o.png" height="22" width="22" /></td><td>-</td><td>-</td><td style="white-space: nowrap;">-</td>
	{/if}
	</tr>
	{/foreach}
	<tr>
		<td>{$smarty.const.MAX_PLANET_IN_SYSTEM + 1}</td>
		<td colspan="6">
		<a href="?page=fleet&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$smarty.const.MAX_PLANET_IN_SYSTEM + 1}&amp;planettype=1&amp;target_mission=15">{$gl_out_space}</a>
		</td>
		<td>
		<a class="tooltip" name="<table style='width:240px'>
		<tr>
		<th colspan='2'>{$gl_legend}</td>
		</tr>
		<tr>
		<td style='width:220px'>{$gl_strong_player}</td>
		<td><span class='strong'>{$gl_s}</span></td>
		</tr>
		<tr>
		<td style='width:220px'>{$gl_week_player}</td>
		<td><span class='noob'>{$gl_w}</span></td>
		</tr>
		<tr>
		<td style='width:220px'>{$gl_vacation}</td>
		<td><span class='vacation'>{$gl_v}</span>
		</td>
		</tr>
		<tr><td style='width:220px'>{$gl_banned}</td>
		<td><span class='banned'>{$gl_b}</span></td>
		</tr>
		<tr>
		<td style='width:220px'>{$gl_inactive_seven}</td>
		<td><span class='inactive'>{$gl_i}</span></td>
		</tr>
		<tr><td style='width:220px'>{$gl_inactive_twentyeight}</td>
		<td><span class='longinactive'>{$gl_I}</span></td>
		</tr>
		</table>"><img src="styles/theme/{$Raza_skin}/imagenes/otros/s.gif" /></a> 
		</td></td>
	</tr>
	
	</table>	
	
	<script type="text/javascript">
		status_ok		= '{$gl_ajax_status_ok}';
		status_fail		= '{$gl_ajax_status_fail}';
		MaxFleetSetting = {$settings_fleetactions} - 1;
	</script>
        </div>
</div>	
<div class="new_footer"></div>
	{if $mode == 2}
<div id="titulo_alternativo_secundario">
    <ul class="tabsbelow">
        <li>
              <span><b>{$gl_missil_launch} [{$galaxy}:{$system}:{$gl_cp}]</b></span>
        </li>                                    
    </ul>
</div>	
<div id="eins">
<div>
<br />							
    <form action="?page=missiles&amp;galaxy={$galaxy}&amp;system={$system}&amp;planet={$gl_cp}&amp;type={$type}" method="POST">
	<tr>
		<table>
			<tr>

				<td>{$missile_count} <input class="campo_comun" type="text" name="SendMI" size="2" maxlength="7"></td>
				<td>{$gl_objective}: 
                	{html_options name=Target options=$MissleSelector}
                </td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center;"><input class="submit" type="submit" name="aktion" value="{$gl_missil_launch_action}"></th>
			</tr>
		</table>
	</form>
</div>
</div>	
	<div class="new_footer"></div>
    {/if}	
<br /><br /><br />	
</div>
<div id="menu_flotas">
		<div id="lista_misiones">    
             <p><b>&nbsp;</b></p>  
			<div class="misiones_top"></div>
			<div class="misiones">
			
			<form action="?page=galaxy&amp;mode=1" method="post" id="galaxy_form">
			<input type="hidden" id="auto" value="dr" />
			<table>
	  <tr>
		<td class="transparent">
		  <table>
			<tr>
			 <td colspan="3"><center><h3>{$gl_galaxy}</h3></center></td>
			</tr>
			<tr>
			  <td><input class="campo_comun" type="button" name="galaxyLeft" value="&lt;-" onClick="galaxy_submit('galaxyLeft')"></td>
			  <td><input class="campo_comun" type="text" name="galaxy" value="{$galaxy}" size="5" maxlength="3" tabindex="1"></td>
			  <td><input class="campo_comun" type="button" name="galaxyRight" value="-&gt;" onClick="galaxy_submit('galaxyRight')"></td>
			</tr>
		   </table>
		  </td>
		 </tr><tr>
		 <td class="transparent">
		   <table>
			<tr>
			 <td colspan="3"><center><h3>{$gl_solar_system}</h3></center></td>
			</tr>
			 <tr>
			  <td><input class="campo_comun" type="button" name="systemLeft" value="&lt;-" onClick="galaxy_submit('systemLeft')"></td>
			  <td><input class="campo_comun" type="text" name="system" value="{$system}" size="5" maxlength="3" tabindex="2"></td>
			  <td><input class="campo_comun" type="button" name="systemRight" value="-&gt;" onClick="galaxy_submit('systemRight')"></td>
			 </tr>
			</table>
		   </td>
		  </tr>
		  <tr>
			<td style="background-color:transparent;border:0px;" colspan="2"> 
				<center><input class="submit" type="submit" value="{$gl_show}" /></center>
			</td>
		  </tr>
	</table>
	</form>			
			</div> 
			<div class="misiones_footer"></div>			
	
	<div class="misiones_top"></div>
	<div class="misiones">
	<table class="galaxia_mini">
		<tr>
			<td><img class="tooltip" name="{$gl_avaible_spyprobes}" src="styles/theme/{$Raza_skin}/gebaeude/210.png" width="50" height="50" /></td><td> <span id="probes">{$spyprobes}</span> </td>
		</tr><tr>
			<td><img class="tooltip" name="{$gl_avaible_recyclers}" src="styles/theme/{$Raza_skin}/gebaeude/209.png" width="50" height="50" /></td><td> <span id="recyclers">{$recyclers}</span></td> 
		</tr><tr>
			<td><img class="tooltip" name="{$gl_avaible_grecyclers}" src="styles/theme/{$Raza_skin}/gebaeude/219.png" width="50" height="50" /></td><td> <span id="grecyclers">{$grecyclers}</span></td> 
		</tr>
	</table>
	
	<table>
		<tr>
		<td colspan="6">({$planetcount})</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
	<tr>
		<td><span id="missiles">{$currentmip}</span> <b>{$gl_avaible_missiles}</b><br />
		<span id="slots">{$maxfleetcount}</span>/{$fleetmax} <b>{$gl_fleets}</b></td>
	</tr>
	</table>
	
	<table class="semi_remarcado">
	<tr style="display: none;" id="fleetstatusrow">
		<td colspan="8">
			<table id="fleetstatustable">

			</table>
		</td>
	</tr>
	</table>
	</div>
	<div class="misiones_footer"></div>	
<br/ ><br /><br />
</div>			
</div>
</div>	
</div>	
</div>	
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}
