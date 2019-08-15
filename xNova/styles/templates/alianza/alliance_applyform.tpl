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
              <span><b>{$al_write_request}</b></span>
        </li>                                    
    </ul>
</div>	
<div id="eins">
<div>	
    <form action="game.php?page=alliance&amp;mode=apply&amp;allyid={$allyid}&amp;action=send" method="POST">
    <table width="95%">
        <tr>
          <td><textarea name="text" cols="70" rows="10">{$applytext}</textarea></td>
        </tr>
        <tr>
          <td colspan="2"><input type="submit" class="submit" name="enviar" value="{$al_applyform_send}"> <input type="submit" class="submit" name="enviar" value="{$al_applyform_reload}"></td>
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