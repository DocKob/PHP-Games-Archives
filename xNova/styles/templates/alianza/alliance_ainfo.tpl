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
				<div id="titular_texto" style="display: block;">{$al_ally_information}</div>
			</div>
        </div>
	</div> 
{include file="left_menu.tpl"}
<div id="contenidoMostrado">                               
<div id="elCosoxD">
<div id="cabezza" style="background-image: url(styles/theme/{$Raza_skin}/imagenes/navegacion/head2.png);"></div>
<div id="eins_small">
<div>
<table>
	<tr>
		<td colspan="2" style="height:100px">{if $ally_description}{$ally_description}{else}{$al_description_message}{/if}</td>
	</tr>
</table>	
</div>
</div>	
<div class="new_footer"></div>	
	{if $DiploInfo}	
<div id="titulo_alternativo_secundario">
    <ul class="tabsbelow">
        <li>
              <span><b>{$al_diplo}</b></span>
        </li>                                    
    </ul>
</div>	
<div id="eins">
<div>
 <table width="95%">		
		<tr>
		<th>{$pactos}</th>
		<th>{$alianzas}</th>
		</tr>		
			{if !empty($DiploInfo.1)}
			<tr class="alt">
			<td width="30"><img class="tooltip" name="{$al_diplo_level.1}" src="styles/theme/{$Raza_skin}/imagenes/otros/pacto_alianza.png" width="60" height="58" /></td>
			<td width="100%">{foreach item=PaktInfo from=$DiploInfo.1}<b><a href="?page=alliance&mode=ainfo&a={$PaktInfo.1}">{$PaktInfo.0}</a></b><br />{/foreach}</td>
			</tr>
			{/if}
			
			{if !empty($DiploInfo.2)}
			<tr class="alt_2">
			<td width="30"><img class="tooltip" name="{$al_diplo_level.2}" src="styles/theme/{$Raza_skin}/imagenes/otros/pacto_comercio.png" width="60" height="58" /></td>
			<td width="100%">{foreach item=PaktInfo from=$DiploInfo.2}<b><a href="?page=alliance&mode=ainfo&a={$PaktInfo.1}">{$PaktInfo.0}</a></b><br />{/foreach}</td>
			</tr>
			{/if}
			
			{if !empty($DiploInfo.3)}
			<tr class="alt">
			<td width="30"><img class="tooltip" name="{$al_diplo_level.3}" src="styles/theme/{$Raza_skin}/imagenes/otros/no_agrecion.png" width="60" height="58" /></td>
			<td width="100%">{foreach item=PaktInfo from=$DiploInfo.3}<b><a href="?page=alliance&mode=ainfo&a={$PaktInfo.1}">{$PaktInfo.0}</a></b><br />{/foreach}</td>
			</tr>
			{/if}
			
			{if !empty($DiploInfo.4)}
			<tr class="alt_2">
			<td width="30"><img class="tooltip" name="{$al_diplo_level.4}" src="styles/theme/{$Raza_skin}/imagenes/otros/en_guerra.png" width="60" height="58" /></td>
			<td width="100%">{foreach item=PaktInfo from=$DiploInfo.4}<b><a href="?page=alliance&mode=ainfo&a={$PaktInfo.1}">{$PaktInfo.0}</a></b><br />{/foreach}</td>
			</tr>
			{/if}
</table>
</div>
</div>	
<div class="new_footer"></div>			
{/if}
{if $ally_stats}
<div id="titulo_alternativo_secundario">
    <ul class="tabsbelow">
        <li>
              <span><b>{$al_Allyquote}</b></span>
        </li>                                    
    </ul>
</div>	
<div id="eins">
<div>
 <table width="70%">	
		<tr>
			<td align="left">{$pl_totalfight}</td><td>{pretty_number($totalfight)}</td>
		</tr>
		<tr>
			<td align="left">{$pl_fightwon}</td><td>{pretty_number($fightwon)} {if $totalfight}({round($fightwon / $totalfight * 100, 2)}%){/if}</td>
		</tr>
		<tr>	
			<td align="left">{$pl_fightlose}</td><td>{pretty_number($fightlose)} {if $totalfight}({round($fightlose / $totalfight * 100, 2)}%){/if}</td>
		</tr>
		<tr>	
			<td align="left">{$pl_fightdraw}</td><td>{pretty_number($fightdraw)} {if $totalfight}({round($fightdraw / $totalfight * 100, 2)}%){/if}</td>
		</tr>
		<tr>
			<td align="left">{$pl_unitsshot}</td><td>{$unitsshot}</td>
		</tr>
		<tr>
			<td align="left">{$pl_unitslose}</td><td>{$unitslose}</td>
		</tr>
		<tr>
			<td align="left">{$pl_dermetal}</td><td>{$dermetal}</td>
		</tr>
		<tr>
			<td align="left">{$pl_dercrystal}</td><td>{$dercrystal}</td>
		</tr>
    </table>
</div>	
</div>
<div class="new_footer"></div>	
{/if}	
<br /><br /><br />
</div>
<div id="menu_flotas">
		<div id="lista_misiones">    
             <p><b>{$lm_alliance}</b></p>  
			<div class="misiones_top"></div>
			<div class="misiones">
			{if $ally_image}
			<img class="tooltip" name="<font color=orange><b>{$al_ally_info_tag}:</b></font> {$ally_tag}<br /><font color=orange><b>{$al_ally_info_name}: </b></font>{$ally_name}<br /><font color=orange><b>{$al_ally_info_members}:</b></font> {$ally_member_scount}" src="{$ally_image}" width="151" height="151" /><br />{/if}
			{if $ally_web}
			<center><a href="{$ally_web}" target="_blank"><b>{$al_web_text}</b></a></center>
			{/if}
			{if $ally_request}
			<center><a href="game.php?page=alliance&amp;mode=apply&amp;allyid={$ally_id}"><div class="tooltip send_solicitud" name="{$al_click_to_send_request}"></div></a></center>
			{/if}
			</div> 
			<div class="misiones_footer"></div>							
</div>			
</div>	
</div>			
</div>		
</div>	
</div>	
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}