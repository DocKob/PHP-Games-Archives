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
				<div id="titular_texto" style="display: block;">{$tr_call_trader}</div>
			</div>
        </div>
	</div> 
{include file="left_menu.tpl"}
<div id="contenidoMostrado">                               
<div id="elCosoxD">
<div id="planeta" style="background-image: url(styles/theme/{$Raza_skin}/adds/mercader.jpg);"></div>
<div class="coso_izquierda"></div>
<div class="coso_derecha"></div>
<div id="cajon">
        <h3>{$tr_call_trader_who_buys}</h3>
        <div style="position:relative; height:80px">        	
	<div id="mercader_en_caja">			
				<div class="mercader_icon">
					<form action="game.php?page=trader" method="post">
					<input type="hidden" name="ress" value="metal" />
					<input type="image" class="tooltip" name="<h4>{$tr_elemento}{$Metal}</h4>" src="{$dpath}images/metal.jpg" />
					</form>
				</div>
				<div class="mercader_icon">
					<form action="game.php?page=trader" method="post">
					<input type="hidden" name="ress" value="crystal" />
					<input type="image" class="tooltip" name="<h4>{$tr_elemento}{$Crystal}</h4>" src="{$dpath}images/cristal.jpg" />
					</form>
				</div>
				<div class="mercader_icon">
					<form action="game.php?page=trader" method="post">
					<input type="hidden" name="ress" value="deuterium" />
					<input type="image" class="tooltip" name="<h4>{$tr_elemento}{$Deuterium}</h4>" src="{$dpath}images/deuterio.jpg" />
					</form>
				</div>
				<div class="mercader_icon">
					<form action="game.php?page=trader" method="post">
					<input type="hidden" name="ress" value="norio" />
					<input type="image" class="tooltip" name="<h4>{$tr_elemento}{$Norio}</h4>" src="{$dpath}images/norio.jpg" />
					</form>
				</div>
	
    </div>
		<div id="mercader_infos">
				<div class="mercader_info">
				<label>{$tr_cost_dm_trader}</label>
				</div>
				<div class="mercader_info">
				<label>{$tr_exchange_quota}</label>
				</div>
         </div>					
		</div>

    </div>
	
	<br /><br />
	</div>
</div>
</div>	
</div>	
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}