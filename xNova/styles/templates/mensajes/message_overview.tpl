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
				<div id="titular_texto" style="display: block;">{$lm_messages}</div>
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
              <span><b>{$mg_overview}</b></span>
        </li>                                    
    </ul>
</div>
<div id="eins">
<div id="content">
<table width="94%">
{foreach name=MessageList key=MessID item=MessInfo from=$MessageList}
<tr class="semi_remarcado">
<td><b><a href="#" onclick="Message.getMessages({$MessID});return false;" style="color:{$MessInfo.color};">{$MessInfo.lang}</a></b></td>
<td id="messcount" style="color:{$MessInfo.color};"><span id="unread_{$MessID}">{$MessInfo.unread}</span>/<span id="total_{$MessID}">{$MessInfo.total}</span></td>
</tr>
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