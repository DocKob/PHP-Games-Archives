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
				<div id="titular_texto" style="display: block;">{$lm_defenses}</div>
			</div>
        </div>
	</div> 
{include file="left_menu.tpl"}
<div id="contenidoMostrado">                               
<div id="elCosoxD">
<div class="coso_izquierda_corto"></div>
<div class="coso_derecha_corto"></div>
<div id="planeta_small" style="background-image: url(styles/theme/{$Raza_skin}/adds/defensas.jpg);"></div>
<div id="titulo_alternativo_corto">
    <ul class="tabsbelow">
        <li>
              <span><b>{$lm_defense}</b></span>
        </li>                                    
    </ul>
</div>
<div id="eins">
 <div>	
 <br />
   <table width="95%">	
   	<form action="" method="POST"> 
		<ul class="estructuras_c">
		{foreach name=DefenseList item=DefenseListRow from=$DefenseList}
			<li>
				<a href="#" onclick="return Dialog.info({$DefenseListRow.id})">
					<img class="tooltip" name="<table>
					<tr>
					<th colspan=2>{$DefenseListRow.name}</th>
					</tr>
					<tr>
					<td><img src={$dpath}gebaeude/{$DefenseListRow.id}.png width=140 height=140 /></td>
					<td>{$DefenseListRow.descriptions}</td>
					</tr>
					</table>" src="{$dpath}gebaeude/{$DefenseListRow.id}.png" width="100" height="100" />
				</a>
				{if $DefenseListRow.Available != 0} <div class="nivel_c"> <b style="cursor:help;" id="val_{$DefenseListRow.id}" class="tooltip" name="{$DefenseListRow.Available}">{$DefenseListRow.Available}</b></div>{/if}		
				<br />
				{if $NotBuilding && $DefenseListRow.IsAvailable}<div class="cantidad_flota_h"><input type="text" class="campo_comun" name="fmenge[{$DefenseListRow.id}]" id="input_{$DefenseListRow.id}" size="12" maxlength="{$maxlength}" value="0" tabindex="{$smarty.foreach.FleetList.iteration}" /></div>
				{if $USERcommander >= 1}<div class="max_h"><input type="button" class="campo_comun" value="Max" onclick="$('#input_{$DefenseListRow.id}').val('{$DefenseListRow.GetMaxAmount}')" /></div>{/if}{/if}
				<div class="demas_c">
				<div class="recursos_c">{$DefenseListRow.price}</div>
				<div class="espacio_c"><br /></div>
				<div class="tiempo_c">
				<b>{$fgf_time}</b></font><br />{$DefenseListRow.time}
				</div>		
				</div>
			</li>
		{/foreach}
		<ul>
	</table>
		{if $NotBuilding}<table width="95%"><center><input class="submit" type="submit" value="{$bd_build_ships}"><center></table>{/if}
	</form>

</div>
</div>	
<div class="new_footer"></div>
{if !$NotBuilding}<table width="70%" id="infobox" style="border: 2px solid red; text-align:center;background:transparent"><tr><td>{$bd_building_shipyard}</td></tr></table>{/if}		  
<br /><br /><br />	
</div>
{if $BuildList != '[]'}
    <div id="menu_flotas">
			<div id="lista_misiones">  
			<div class="misiones_top"></div>
			<div class="misiones">
	<table width="50%">
		<tr>
			<td class="transparent">
				<div id="bx"></div> <!-- Nombre e imagen de construccion actual -->
				<form method="POST" action="">
				<input type="hidden" name="mode" value="fleet" />
				<input type="hidden" name="action" value="delete" />
				<table>
				 <tr>
					<td><select style="width:120px" name="auftr[]" id="auftr" size="4"  multiple="multiple"><option>&nbsp;</option></select></td>
				</tr> 
				<tr align="center">
				<td><input type="Submit" class="campo_comun" value="{$bd_cancel_send}" /></td>
				</tr>
				</table>
				</form>
				<center><b><span id="timeleft"></span></b></center> <!-- Tiempo -->
			</td>
		</tr>
    </table>
	</div> 
	<div class="misiones_footer"></div>
	<br/ ><br /><br />
	{/if} 
</div>
</div>
</div>
</div>
<script type="text/javascript">
data			= {$BuildList};
bd_operating	= '{$bd_operating}';
bd_available	= '{$bd_available}';
</script>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}