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
				<div id="titular_texto" style="display: block;">{$sh_search_in_the_universe}</div>
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
    <form action="" method="post">
     <table style="width:90%">
      <tr>
       <td>
		{html_options name=type options=$SeachTypes selected=$SeachType}
        <input type="text" class="campo_comun" name="searchtext" value="{$SeachInput}">
        <input class="campo_comun" type="submit" value="{$sh_search}">
       </td>
      </tr>
    </table>
    </form>

{if $SeachType}
{if $SeachType == "playername" || $SeachType == "planetname"}
{include file="buscador/search_user_result.tpl"}
{else}
{include file="buscador/search_ally_result.tpl"}
{/if}
{/if}
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