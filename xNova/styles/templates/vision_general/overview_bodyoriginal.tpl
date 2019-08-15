{include file="overall_header.tpl"}
<body id="vision_general">
<div id="tooltip" class="tip"></div>
<div class="contenido_big">
<div id="cajaBG">
    <div id="caja">
<div id="topnav" class="header_g"> 
		{include file="overall_topnav.tpl"}	
		
       		<div id="titular">
			<div id="estructura_titular" style="position:relative;">
				<div id="titular_texto" style="display: block;"><a href="#" onclick="$('#dialog').dialog('open');return false;" title="{$ov_planetmenu}">{$ov_planet} "<span>{$planetname}</span>"</a> ({$username})</div>
			</div>
        </div>
	</div> 
{include file="left_menu.tpl"}
<div id="contenidoMostrado">                               
<div id="elCosoxD">
<div id="top_planeta_datos"></div>
<div id="planeta_datos">	
<div>
                <table width="95%">
				 {if $messages}  
				 <tr>
                        <td>
                          <span><b><a href="?page=messages">{$messages}</a></b></span>
                        </td>
                  </tr>
				  {/if}
				   <tr>
                        <td>
                          <span><b><font color="#ffffff">{$ov_diameter}:</font> {$planet_diameter} {$ov_distance_unit} (<a title="{$ov_developed_fields}">{$planet_field_current}</a> / <a title="{$ov_max_developed_fields}">{$planet_field_max}</a> {$ov_fields})</b></span>
                        </td>
                    </tr>
					<tr>
                        <td>
                            <span><b><font color="#ffffff">{$ov_temperature}:</font> {$ov_aprox} {$planet_temp_min}{$ov_temp_unit} {$ov_to} {$planet_temp_max}{$ov_temp_unit}</b></span>
                        </td>
                    </tr>
					<tr>
                        <td>
                            <span><b><font color="#ffffff">{$ov_position}:</font> <a href="game.php?page=galaxy&amp;mode=0&amp;galaxy={$galaxy}&amp;system={$system}">[{$galaxy}:{$system}:{$planet}]</a></b></span>
                        </td>
                    </tr>	
					<tr>
                        <td>
                            <span><b><font color="#ffffff">{$ov_points}:</font> {$user_rank}</b></span>
                        </td>
                    </tr>
					
                </table>
	</div>			
</div>
<div id="footer_planeta_datos"></div>
<div id="rangos_ov"><img class="tooltip" name="<img src=styles/images/rangos/{$rango}.png /><br /><h3>{$lvl_rg} {$rango}<br />{$nivel}</h3> " src="styles/images/rangos/{$rango}.png" width="70" height="70" /></div>
<div id="luna_ov">
{if $Moon}
<a href="game.php?page=overview&amp;cp={$Moon.id}&amp;re=0" class="tooltip" name="('{$Moon.name} ({$fcm_moon})')">
<img src="styles/theme/{$Raza_skin}/imagenes/luna.png" /></a>{else}<img src="styles/theme/{$Raza_skin}/imagenes/luna_o.png" />
{/if}
</div>	
<div id="escombros_ov">{$escombros}</div>
<div id="razas_ov"><img class="tooltip" name="<img src={$ov_raza_img} width=120 height=120/><h2><font color=#83919c>{$Raza}: {$Raza_tipo}</font></b></h2>" src="{$ov_raza_img}" width="70" height="70" /></div>
<div id="planeta_overview"> <img  src="styles/theme/{$Raza_skin}/planeten/{$planetimage}.jpg" /></div>
{if $is_news}
<div id="titulo_alternativo">
    <ul class="tabsbelow">
        <li>
              <span><b>{$ov_news} </b></span>
        </li>                                    
    </ul>
</div>
<div id="eins">
        <div><br />
                    <table width="95%">
                         <tbody>
							<tr class="alt">
                           <th> <marquee scrolldelay="150">{$news}</marquee></th>
                        </tr>
					{if $Teamspeak}
					<tr>
                        <td>
                            <span><b><font color="#ffffff">{$ov_teamspeak}: </font> {$Teamspeak}</b></span>
                        </td>
                    </tr>
					{/if}					     
                        </tbody>
				 </table>
        </div>
    </div>
<div class="new_footer"></div>
{/if}	
<div id="titulo_alternativo_secundario">
    <ul class="tabsbelow">
        <li>
              <span><b>{$ov_events} </b></span>
        </li>                                    
    </ul>
</div>
<div id="eins">
        <div><br />
<table width="95%">
    <tbody>		
			<tr id="fleets" style="display:none;">
				<td colspan="4">
			</tr>
	</tbody>
</table>	
        </div>
    </div>
 <div class="new_footer"></div>
<br /><br /><br />
</div>
 <tr id="fleets" style="display:none;">
         <td colspan="4">
      </tr>		
</div>
<div id="menu_construcciones">
			<div id="estructuras_construccion">    
                
                <p><b>{$estructuras_construccion}</b></p>  
				<div class="misiones_top"></div>
			<div class="misiones"><center>                     
			 {$build}
			</center></div> 
			<div class="misiones_footer"></div>	
			<div class="misiones_top"></div>
			<div class="misiones"><center>                     
			 {$build_h}
			</center></div> 
			<div class="misiones_footer"></div>				
		</div>		
</div>	

</div>
</div>
</div>
  
<form action="" method="POST">
<div id="dialog" title="{$ov_planetmenu}" style="display:none;">
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">{$ov_planet_rename}</a></li>
			<li><a href="#tabs-2">{$ov_delete_planet}</a></li>
		</ul>
		<div id="tabs-1">
			<label for="newname"> </label><input class="left campo_comun" type="text" name="newname" id="newname" size="25" maxlength="20" autocomplete="off">
		</div>
		<div id="tabs-2"><h3 style="margin:0">{$ov_security_request}</h3>{$ov_security_confirm}<br>
			<label for="password">{$ov_password}: </label><input class="left campo_comun" type="password" name="password" id="password" size="25" maxlength="20" autocomplete="off">
		</div>
	</div>
</div>

</form>
<script type="text/javascript">
buildtime	= {$buildtime};
</script>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}
