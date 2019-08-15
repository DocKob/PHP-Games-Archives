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
				<div id="titular_texto" style="display: block;">{$st_statistics}</div>
			</div>
        </div>
	</div> 
{include file="left_menu.tpl"}
<div id="contenidoMostrado">                               
<div id="elCosoxD">
<div id="cabezza" style="background-image: url(styles/theme/{$Raza_skin}/imagenes/navegacion/head2.png);"></div>
<div id="eins_small">
 <div>	
    <form name="stats" id="stats" method="post" action="">
        <table width="95%">
            <tr>
				<td>{$st_updated}: {$stat_date}</td>
            </tr>
				<td>&nbsp;</td>
			<tr>
			</tr>
            <tr>
			<td>
				{$st_show} <select name="who" onChange="$('#stats').submit();">{html_options options=$Selectors.who selected=$who}</select> 
				{$st_per} <select name="type" onChange="$('#stats').submit();">{html_options options=$Selectors.type selected=$type}</select> 
				{$st_in_the_positions} <select name="range" onChange="$('#stats').submit();">{html_options options=$Selectors.range selected=$range}</select>
			</td>
            </tr>
        </table>
    </form>
    <table width="95%">
	{if $who == 1}
		{include file="estadisticas/stat_playertable.tpl"}
 	{elseif $who == 2}
		{include file="estadisticas/stat_alliancetable.tpl"}
	{/if}
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