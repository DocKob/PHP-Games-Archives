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
				<div id="titular_texto" style="display: block;">{$tkb_top}</div>
			</div>
        </div>
	</div> 
{include file="left_menu.tpl"}
<div id="contenidoMostrado">                               
<div id="elCosoxD">
<div id="cabezza" style="background-image: url(styles/theme/{$Raza_skin}/imagenes/navegacion/head2.png);"></div>
<div id="eins_small">
 <div>	
<table width="95%">
<tbody>
<tr>
    <th colspan="4">
        {$tkb_gratz}
    </th>
</tr><tr>
    <th>{$tkb_platz}</th>
	<th>{$tkb_owners}</th>
    <th>{$tkb_datum}</th>
	<th>{$tkb_units}</th>
</tr>
{foreach item=RowInfo key=RowNR from=$TopKBList}
<tr>
    <td class="semi_remarcado">{$RowNR + 1}</td>
    <td class="semi_remarcado"><a href="game.php?page=topkb&amp;action=showkb&amp;rid={$RowInfo.rid}" onclick="OpenPopup('game.php?page=topkb&mode=showkb&rid={$RowInfo.rid}', 'raport', screen.width, screen.height);return false;">
	{if $RowInfo.result == "a"}
	<span style="color:#00FF00">{$RowInfo.attacker}</span> VS <span style="color:#FF0000">{$RowInfo.defender}</span>
	{elseif $RowInfo.result == "r"}
	<span style="color:#FF0000">{$RowInfo.attacker}</span> VS <span style="color:#00FF00">{$RowInfo.defender}</span>
	{else}
	{$RowInfo.attacker} VS {$RowInfo.defender}
	{/if}
	</a></td>
    <td class="semi_remarcado">{$RowInfo.time}</td>
	<td class="semi_remarcado">{$RowInfo.units}</td>
</tr>
{/foreach}
<tr><td>&nbsp;</td></tr>
<tr>
<td colspan="4">{$tkb_legende} <span style="color:#00FF00">{$tkb_gewinner}</span> <span style="color:#FF0000">{$tkb_verlierer}</span> <span style="color:#FAC531">{$tkb_unentschieden}</span></td></tr>
</tbody>
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