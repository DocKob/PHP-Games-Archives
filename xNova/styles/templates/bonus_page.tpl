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
				<div id="titular_texto" style="display: block;">{$lm_bonus} - {$en_venta}</div>
			</div>
        </div>
	</div> 
{include file="left_menu.tpl"}
<div id="contenidoMostrado">                               
<div id="elCosoxD">
<div class="coso_izquierda"></div>
<div class="coso_derecha"></div>
<div id="planeta" style="background-image: url(styles/theme/{$Raza_skin}/adds/bonus.jpg);"></div>
<div id="titulo_alternativo">
    <ul class="tabsbelow">
        <li>
              <span><b>{$recursos_pack}</b></span>
        </li>                                    
    </ul>
</div>
<div id="eins">
 <div>	
 <br />
<table width="95%">
<tr>
<td width="130">
<img border="0" src="styles/theme/{$Raza_skin}/imagenes/otros/recursos.png" align="top" width="130" height="130">
</td>
<td>
<font color=yellowgreen size="2"><b>{$recursos_pack_descr}</b></font>
<br /><br />
<center><b>{$coste}<font color=lime>{pretty_number($cost_res)}</font> {$mo_lang}</b></center>
</td>
<td align="right"><a href="?page=bonus&pack=recursos"><div class="cancelar_c"><span class="comprar_c">{$comprar}&nbsp;</span></div></a></td>
</tr>
</table>
</div>
</div>	
<div class="new_footer"></div>	

<div id="titulo_alternativo_secundario">
    <ul class="tabsbelow">
        <li>
              <span><b>{$minas_pack}</b></span>
        </li>                                    
    </ul>
</div>
<div id="eins">
 <div>	
 <br />
<table width="95%">
<tr>
<td width="130">
<img border="0" src="styles/theme/{$Raza_skin}/imagenes/otros/minas.png" align="top" width="130" height="130">
</td>
<td>
<font color=yellowgreen size="2"><b>{$minas_pack_descr}</b></font>
<br /><br />
<center><b>{$coste}<font color=lime>{pretty_number($cost_mine)}</font> {$mo_lang}</b></center>
</td>
<td align="right"><a href="?page=bonus&pack=mineros"><div class="cancelar_c"><span class="comprar_c">{$comprar}&nbsp;</span></div></a></td>
</tr>
</table>
</div>
</div>	
<div class="new_footer"></div>

<div id="titulo_alternativo_secundario">
    <ul class="tabsbelow">
        <li>
              <span><b>{$almacenes_pack}</b></span>
        </li>                                    
    </ul>
</div>
<div id="eins">
 <div>	
 <br />
<table width="95%">
<tr>
<td width="130">
<img border="0" src="styles/theme/{$Raza_skin}/imagenes/otros/almacenes.png" align="top" width="130" height="130">
</td>
<td>
<font color=yellowgreen size="2"><b>{$almacenes_pack_descr}</b></font>
<br /><br />
<center><b>{$coste}<font color=lime>{pretty_number($cost_stor)}</font> {$mo_lang}</b></center>
</td>
<td align="right"><a href="?page=bonus&pack=almacenes"><div class="cancelar_c"><span class="comprar_c">{$comprar}&nbsp;</span></div></a></td>
</tr>
</table>
</div>
</div>	
<div class="new_footer"></div>

<div id="titulo_alternativo_secundario">
    <ul class="tabsbelow">
        <li>
              <span><b>{$flotas_pack}</b></span>
        </li>                                    
    </ul>
</div>
<div id="eins">
 <div>	
 <br />
<table width="95%">
<tr>
<td width="130">
<img border="0" src="styles/theme/{$Raza_skin}/imagenes/otros/floteros.png" align="top" width="130" height="130">
</td>
<td>
<font color=yellowgreen size="2"><b>{$flotas_pack_descr}</b></font>
<br /><br />
<center><b>{$coste}<font color=lime>{pretty_number($cost_flot)}</font> {$mo_lang}</b></center>
</td>
<td align="right"><a href="?page=bonus&pack=floteros"><div class="cancelar_c"><span class="comprar_c">{$comprar}&nbsp;</span></div></a></td>
</tr>
</table>
</div>
</div>	
<div class="new_footer"></div>

<div id="titulo_alternativo_secundario">
    <ul class="tabsbelow">
        <li>
              <span><b>{$bunkers_pack}</b></span>
        </li>                                    
    </ul>
</div>
<div id="eins">
 <div>	
 <br />
<table width="95%">
<tr>
<td width="130">
<img border="0" src="styles/theme/{$Raza_skin}/imagenes/otros/defensas.png" align="top" width="130" height="130">
</td>
<td>
<font color=yellowgreen size="2"><b>{$bunkers_pack_descr}</b></font>
<br /><br />
<center><b>{$coste}<font color=lime>{pretty_number($cost_bunk)}</font> {$mo_lang}</b></center>
</td>
<td align="right"><a href="?page=bonus&pack=bunkeros"><div class="cancelar_c"><span class="comprar_c">{$comprar}&nbsp;</span></div></a></td>
</tr>
</table>
</div>
</div>	
<div class="new_footer"></div>

<div id="titulo_alternativo_secundario">
    <ul class="tabsbelow">
        <li>
              <span><b>{$tecnos_pack}</b></span>
        </li>                                    
    </ul>
</div>
<div id="eins">
 <div>	
 <br />
<table width="95%">
<tr>
<td width="130">
<img border="0" src="styles/theme/{$Raza_skin}/imagenes/otros/tecnologia.png" align="top" width="130" height="130">
</td>
<td>
<font color=yellowgreen size="2"><b>{$tecnos_pack_descr}</b></font>
<br /><br />
<center><b>{$coste}<font color=lime>{pretty_number($cost_tecno)}</font> {$mo_lang}</b></center>
</td>
<td align="right"><a href="?page=bonus&pack=tecnologias"><div class="cancelar_c"><span class="comprar_c">{$comprar}&nbsp;</span></div></a></td>
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