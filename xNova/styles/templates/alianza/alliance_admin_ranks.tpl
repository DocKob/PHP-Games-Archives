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
				<div id="titular_texto" style="display: block;">{$lm_alliance}</div>
			</div>
        </div>
	</div> 
{include file="left_menu.tpl"}
<div id="contenidoMostrado">                               
<div id="elCosoxD">
<div class="coso_izquierda_corto"></div>
<div class="coso_derecha_corto"></div>
<div id="planeta_small" style="background-image: url(styles/theme/{$Raza_skin}/adds/redes.jpg);"></div>	
<div id="titulo_alternativo_corto">
    <ul class="tabsbelow">
        <li>
            <span><b>{$al_configura_ranks}</b> <a class="right" href="game.php?page=alliance&amp;mode=admin&amp;edit=ally"><b><font color="red">>></font> {$al_back}</b></a></span>
        </li>                                    
    </ul>
</div>	
<div id="eins">
<div>		
	<form action="game.php?page=alliance&amp;mode=admin&amp;edit=rights" method="POST">
	<br />
	<table style="width:95%">
	<tr>
		<th>{$al_dlte}</th>
		<th>{$al_rank_name}</th>
		<td><img class="tooltip" name="{$al_legend_disolve_alliance}" src="styles/theme/{$Raza_skin}/imagenes/otros/r1.png" alt=""></td>
		<td><img class="tooltip" name="{$al_legend_kick_users}" src="styles/theme/{$Raza_skin}/imagenes/otros/r2.png" alt=""></td>
		<td><img class="tooltip" name="{$al_legend_see_requests}" src="styles/theme/{$Raza_skin}/imagenes/otros/r3.png" alt=""></td>
		<td><img class="tooltip" name="{$al_legend_see_users_list}" src="styles/theme/{$Raza_skin}/imagenes/otros/r4.png" alt=""></td>
		<td><img class="tooltip" name="{$al_legend_check_requests}" src="styles/theme/{$Raza_skin}/imagenes/otros/r5.png" alt=""></td>
		<td><img class="tooltip" name="{$al_legend_admin_alliance}" src="styles/theme/{$Raza_skin}/imagenes/otros/r6.png" alt=""></td>
		<td><img class="tooltip" name="{$al_legend_see_connected_users}" src="styles/theme/{$Raza_skin}/imagenes/otros/r7.png" alt=""></td>
		<td><img class="tooltip" name="{$al_legend_create_circular}" src="styles/theme/{$Raza_skin}/imagenes/otros/r8.png" alt=""></td>
		<td><img class="tooltip" name="{$al_legend_right_hand}" src="styles/theme/{$Raza_skin}/imagenes/otros/r9.png" alt=""></td>
	</tr>
	{foreach item=RankInfo from=$AllyRanks}
	<tr>
		<td><input type="hidden" name="id[]" value="{$RankInfo.id}"><a href="game.php?page=alliance&amp;mode=admin&amp;edit=rights&amp;d={$RankInfo.id}"><img src="{$dpath}pic/abort.gif" alt="{$Delete_range}" border="0"></a></td>
		<td>{$RankInfo.name}</td>
		<td><input type="checkbox" name="u{$RankInfo.id}r0"{if $RankInfo.close} checked="checked"{/if}{if !$close}disabled{/if}></td>
		<td><input type="checkbox" name="u{$RankInfo.id}r1"{if $RankInfo.kick} checked="checked"{/if}{if !$kick}disabled{/if}></td>
		<td><input type="checkbox" name="u{$RankInfo.id}r2"{if $RankInfo.seeapply} checked="checked"{/if}{if !$seeapply}disabled{/if}></td>
		<td><input type="checkbox" name="u{$RankInfo.id}r3"{if $RankInfo.memberlist} checked="checked"{/if}{if !$memberlist}disabled{/if}></td>
		<td><input type="checkbox" name="u{$RankInfo.id}r4"{if $RankInfo.changeapply} checked="checked"{/if}{if !$changeapply}disabled{/if}></td>
		<td><input type="checkbox" name="u{$RankInfo.id}r5"{if $RankInfo.admin} checked="checked"{/if}{if !$admin}disabled{/if}></td>
		<td><input type="checkbox" name="u{$RankInfo.id}r6"{if $RankInfo.memberlist_on} checked="checked"{/if}{if !$memberlist_on}disabled{/if}></td>
		<td><input type="checkbox" name="u{$RankInfo.id}r7"{if $RankInfo.roundmail} checked="checked"{/if}{if !$roundmail}disabled{/if}></td>
		<td><input type="checkbox" name="u{$RankInfo.id}r8"{if $RankInfo.righthand} checked="checked"{/if}{if !$righthand}disabled{/if}></td>
	</tr>
	{foreachelse}
	<tr>
		<th colspan="11">{$al_no_ranks_defined}</th>
	</tr>
	{/foreach}
	<tr>
		<td colspan="11"><input class="submit" type="submit" value="{$al_save}"></td>
	</tr>
    </table>
	</form>
</div>			
</div>
<div class="new_footer"></div>		
<div id="titulo_alternativo_secundario">
    <ul class="tabsbelow">
        <li>
              <span><b>{$al_create_new_rank}</b></span>
        </li>                                    
    </ul>
</div>	
<div id="eins">
<div>			
     <form action="game.php?page=alliance&amp;mode=admin&amp;edit=rights" method="POST">
    <table style="width:95%">
        <tr>
		 <th colspan="2">{$al_rank_name}</th>
		</tr>
		<tr>
          <td><center><div class="bg_input_special"><input class="text" type="text" name="newrangname" size="20" maxlength="30"></div></center></td>
        </tr>
        <tr>
          <td colspan="2"><input class="submit" type="submit" value="{$al_create}"></td>
        </tr>
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