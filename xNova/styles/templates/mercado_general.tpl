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
				<div id="titular_texto" style="display: block;">{$lm_trader}</div>
			</div>
        </div>
	</div> 
{include file="left_menu.tpl"}
<div id="contenidoMostrado">                               
<div id="elCosoxD">
<div class="coso_izquierda"></div>
<div class="coso_derecha"></div>
<div id="planeta" style="background-image: url(styles/theme/{$Raza_skin}/adds/mercado.jpg);"></div>

<div id="titulo_alternativo">
    <ul class="tabsbelow">
        <li>
              <span><b>{$oficiales}</b></span>
        </li>                                    
    </ul>
</div>
<div id="eins">
 <div>	
 <br />
   <table width="95%">		
	<ul class="estructuras_c">
		 {if !CheckModule(13)}<li>
					<a href="game.php?page=trader"><img class="tooltip" name="<table>
					<tr>
					<th colspan=2>{$mercado_negro}</th>
					</tr>
					<tr>
					<td>{$mercado_negro_desc}</td>
					</tr>
					</table>" src="styles/theme/{$Raza_skin}/adds/mercaderr.jpg" /></a>
				<div class="nivel_c"><b>{$mercado_negro}</b></div>
		</li>{/if}
		
		<li>
					<a href="game.php?page=bonus"><img class="tooltip" name="<table>
					<tr>
					<th colspan=2>{$bonus}</th>
					</tr>
					<tr>
					<td>{$bonus_desc}</td>
					</tr>
					</table>" src="styles/theme/{$Raza_skin}/adds/bonuss.jpg" /></a>
				<div class="nivel_c"><b>{$bonus}</b></div>
		</li>

		 {if !CheckModule(38)}<li>
					<a href="game.php?page=fleettrader"><img class="tooltip" name="<table>
					<tr>
					<th colspan=2>{$comerciante}</th>
					</tr>
					<tr>
					<td>{$comerciante_desc}</td>
					</tr>
					</table>" src="styles/theme/{$Raza_skin}/adds/comerciante.jpg" /></a>
				<div class="nivel_c"><b>{$comerciante}</b></div>
		</li>{/if}
	<ul>
    </table>
</div>
</div>	
<div class="new_footer"></div>
	  
<br /><br /><br />	
</div>
<div id="buildlist" style="display:none;"></div>  
<br/ ><br /><br />
</div>
</div>
</div>
</div>
{if $data}
<script type="text/javascript">
data	= {$data};
</script>
{/if}
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}