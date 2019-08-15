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
				<div id="titular_texto" style="display: block;">CHANGELOG</div>
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
    <table width="95%">
		<tr>
			<th>{$Version}</th>
			<th>{$Description}</th>
		</tr>
	{foreach key=version_number item=description from=$ChangelogList}
    <tr>
        <td class="semi_remarcado" style="width:70px" align="center">{$version_number}</th>
        <td class="semi_remarcado" style="padding-left:6px;padding-bottom:6px" align="left">&nbsp;{$description}</td>
    </tr>
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