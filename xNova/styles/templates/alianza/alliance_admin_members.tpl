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
              <span><b>{$al_users_list}</b> <a class="right" href="game.php?page=alliance&amp;mode=admin&amp;edit=ally"><b><font color="red">>></font> {$al_back}</b></a></span>
        </li>                                    
    </ul>
</div>	
<div id="eins">
<div>	
    <table style="width:95%">
        <tr>
            <th>{$al_num}</th>
            <th><a href="game.php?page=alliance&amp;mode=admin&amp;edit=members&amp;sort1=1&amp;sort2={$sort}">{$al_member}</a></th>
            <th>{$al_message}</th>
            <th><a href="game.php?page=alliance&amp;mode=admin&amp;edit=members&amp;sort1=2&amp;sort2={$sort}">{$al_position}</a></th>
            <th><a href="game.php?page=alliance&amp;mode=admin&amp;edit=members&amp;sort1=3&amp;sort2={$sort}">{$al_points}</a></th>
            <th><a href="game.php?page=alliance&amp;mode=admin&amp;edit=members&amp;sort1=0&amp;sort2={$sort}">{$al_coords}</a></th>
            <th><a href="game.php?page=alliance&amp;mode=admin&amp;edit=members&amp;sort1=4&amp;sort2={$sort}">{$al_member_since}</a></th>
            <th><a href="game.php?page=alliance&amp;mode=admin&amp;edit=members&amp;sort1=5&amp;sort2={$sort}">{$al_estate}</a></th>
            <th>{$al_actions}</th>
        </tr>
        {foreach name=Memberlist item=MemberInfo from=$Memberlist}
		<tr>
			<th>{$smarty.foreach.Memberlist.iteration}</th>
			<td>{$MemberInfo.username}</td>
			<td class="semi_remarcado"><a href="#" onclick="return Dialog.PM({$MemberInfo.id});"><img src="{$dpath}imagenes/otros/m.gif" border="0" title="{$rite_message}" alt="{$rite_message}"></a></td>
			<td><b>{$MemberInfo.range}</b></td>
			<td class="semi_remarcado">{$MemberInfo.points}</td>
			<td><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$MemberInfo.galaxy}&amp;system={$MemberInfo.system}"><b>[</b>{$MemberInfo.galaxy}:{$MemberInfo.system}:{$MemberInfo.planet}<b>]</b></a></td>
			<td class="semi_remarcado">{$MemberInfo.register_time}</td>
			<td>{$MemberInfo.onlinetime}</td>
			<td class="remarcado">{if $MemberInfo.action > 0}<a href="game.php?page=alliance&amp;mode=admin&amp;edit=members&amp;action=edit&amp;id={$MemberInfo.id}"><img src="{$dpath}pic/key.gif" border="0" alt=""></a>
			{if $MemberInfo.action == 2}<a href="game.php?page=alliance&amp;mode=admin&amp;edit=members&amp;action=kick&amp;id={$MemberInfo.id}" onclick="javascript:return confirm('{$MemberInfo.kick}');"><img src="{$dpath}pic/abort.gif" border="0" alt=""></a>{/if}{else}-{/if}
			</td>
		</tr>
		{if $MemberInfo.id == $id}
		<tr>
			<td colspan="9">
			<form action="game.php?page=alliance&amp;mode=admin&amp;edit=members&amp;action=edit&amp;id={$MemberInfo.id}" name="editar_usu_rango" method="POST">
				{html_options name=newrang options=$Selector selected=$MemberInfo.rank_id}
				<input type="submit" class="campo_comun" value="{$al_ok}" /> 
			</form>
			</td>
		</tr>
		{/if}
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