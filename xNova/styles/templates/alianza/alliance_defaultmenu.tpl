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
              <span><b>{$al_alliance}</b></span>
        </li>                                    
    </ul>
</div>
<div id="eins">
<div>	
    <table>
        <br />
		<tr>
			<td><a href="game.php?page=alliance&amp;mode=make"><img src="styles/theme/{$Raza_skin}/imagenes/infos/con_alianza.png" /><br /><h4>{$al_alliance_make}</h4></a></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><a href="game.php?page=alliance&amp;mode=search"><img src="styles/theme/{$Raza_skin}/imagenes/infos/sin_alianza.png" /><br /><h4>{$al_alliance_search}</h4></a></td>
        </tr>
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