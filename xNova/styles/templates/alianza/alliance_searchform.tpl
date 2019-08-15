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
              <span><b>{$al_find_alliances}</b></span>
        </li>                                    
    </ul>
</div>
<div id="eins">
<div>	
    <form action="" method="POST">
              <center><div class="bg_input_special"><input type="text" class="text" name="searchtext" value="{$searchtext}" style="text-align:right;" /></div></center>
			  <input class="submit" type="submit" value="{$al_find_submit}" />&nbsp;&nbsp;&nbsp;
    </form>
	{if is_array($SeachResult)}
</div>	
</div>	
<div class="new_footer"></div>
<div id="titulo_alternativo_secundario">
    <ul class="tabsbelow">
        <li>
              <span><b>&nbsp;</b></span>
        </li>                                    
    </ul>
</div>	
<div id="eins">
<div>	
	<table width="95%">
        <tr>
            <th>{$al_ally_info_tag}</th>
            <th>{$al_ally_info_name}</th>
            <th>{$al_ally_info_members}</th>
        </tr>
		{foreach item=SeachRow from=$SeachResult}
        <tr>
			<td><a href="game.php?page=alliance&amp;mode=apply&amp;allyid={$SeachRow.id}">{$SeachRow.tag}</a></td>
			<td>{$SeachRow.name}</td>
			<td>{$SeachRow.members}</td>
		</tr>
		{foreachelse}
        <tr>
			<td colspan="3">{$al_find_no_alliances}</td>
		</tr>
		{/foreach}
    </table>
	{/if}
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