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
				<div id="titular_texto" style="display: block;">{$bu_buddy_list}</div>
			</div>
        </div>
	</div> 
{include file="left_menu.tpl"}
<div id="contenidoMostrado">                               
<div id="elCosoxD">
<div id="cabezza" style="background-image: url(styles/theme/{$Raza_skin}/imagenes/navegacion/head2.png);"></div>
<div id="eins_small">
 <div>	
 <br /> 
<table style="min-width:569px;width:569px;">
<tr><th colspan="6" style="text-align:center">{$bu_requests}</th></tr>
<tr><th>{$bu_player}</th>
<th>{$bu_alliance}</th>
<th>{$bu_coords}</th>
<th>{$bu_text}</th>
<th>{$bu_action}</th>
</tr>
{foreach name=OutRequestList item=OutRequestInfo from=$OutRequestList}
<tr>
<td><a href="#" onclick="return Dialog.PM({$OutRequestInfo.playerid});">{$OutRequestInfo.name}</a></td>
<td>{if {$OutRequestInfo.allyname}}<a href="game.php?page=alliance&amp;mode=ainfo&amp;a={$OutRequestInfo.allyid}">{$OutRequestInfo.allyname}</a>{else}-{/if}</td>
<td><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$OutRequestInfo.galaxy}&amp;system={$OutRequestInfo.system}">{$OutRequestInfo.galaxy}:{$OutRequestInfo.system}:{$OutRequestInfo.planet}</a></td>
<td>{$OutRequestInfo.text}</td>
<td><a href="game.php?page=buddy&amp;mode=1&amp;sm=2&amp;bid={$OutRequestInfo.buddyid}">{$bu_accept}</a>
<br><a href="game.php?page=buddy&amp;mode=1&amp;sm=1&amp;bid={$OutRequestInfo.buddyid}">{$bu_decline}</a></td>
</tr>
{foreachelse}
<tr><td colspan="6">{$bu_no_request}</td></tr>
{/foreach}
<tr><th colspan="6" style="text-align:center">{$bu_my_requests}</th></tr>
<tr><th>{$bu_player}</th>
<th>{$bu_alliance}</th>
<th>{$bu_coords}</th>
<th>{$bu_text}</th>
<th>{$bu_action}</th>
</tr>
{foreach name=MyRequestList item=MyRequestInfo from=$MyRequestList}
<tr>
<td><a href="#" onclick="return Dialog.PM({$MyRequestInfo.playerid});">{$MyRequestInfo.name}</a></td>
<td>{if {$MyRequestInfo.allyname}}<a href="game.php?page=alliance&amp;mode=ainfo&amp;a={$MyRequestInfo.allyid}">{$MyRequestInfo.allyname}</a>{else}-{/if}</td>
<td><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$MyRequestInfo.galaxy}&amp;system={$MyRequestInfo.system}">{$MyRequestInfo.galaxy}:{$MyRequestInfo.system}:{$MyRequestInfo.planet}</a></td>
<td>{$MyRequestInfo.text}</td>
<td><a href="game.php?page=buddy&amp;mode=1&amp;sm=1&amp;bid={$MyRequestInfo.buddyid}">{$bu_cancel_request}</a></td></tr>
{foreachelse}
<tr><td colspan="6">{$bu_no_request}</td></tr>
{/foreach}
<tr><th colspan="6" style="text-align:center">{$bu_partners}</th></tr>
<tr>
<th>{$bu_player}</td>
<th>{$bu_alliance}</th>
<th>{$bu_coords}</th>
<th>{$bu_online}</th>
<th>{$bu_action}</th>
</tr>
{foreach name=MyBuddyList item=MyBuddyInfo from=$MyBuddyList}
<tr>
<td><a href="#" onclick="return Dialog.PM({$MyBuddyInfo.playerid});">{$MyBuddyInfo.name}</a></td>
<td>{if {$MyBuddyInfo.allyname}}<a href="game.php?page=alliance&amp;mode=ainfo&amp;a={$MyBuddyInfo.allyid}">{$MyBuddyInfo.allyname}</a>{else}-{/if}</td>
<td><a href="game.php?page=galaxy&amp;mode=3&amp;galaxy={$MyBuddyInfo.galaxy}&amp;system={$MyBuddyInfo.system}">{$MyBuddyInfo.galaxy}:{$MyBuddyInfo.system}:{$MyBuddyInfo.planet}</a></td>
<td>
{if $MyBuddyInfo.onlinetime < 4}
<span style="color:lime">{$bu_connected}</span>
{elseif $MyBuddyInfo.onlinetime >= 4 && $MyBuddyInfo.onlinetime <= 15}
<span style="color:yellow">{$MyBuddyInfo.onlinetime} {$bu_minutes}</span>
{else}
<span style="color:red">{$bu_disconnected}</span>
{/if}
</td>
<td><a href="game.php?page=buddy&amp;mode=1&amp;sm=1&amp;bid={$MyBuddyInfo.buddyid}">{$bu_delete}</a></td></tr>
{foreachelse}
<tr><td colspan="6">{$bu_no_buddys}</td></tr>
{/foreach}
</table>
 </div>
</div>	
<div class="new_footer_small"></div>	
<br /><br /><br />	
</div>
</div>
</div>
</div>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}