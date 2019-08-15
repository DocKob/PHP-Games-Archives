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
				<div id="titular_texto" style="display: block;">{$tr_sell_deuterium}</div>
			</div>
        </div>
	</div> 
{include file="left_menu.tpl"}
<script type="text/javascript">
res_a = {$mod_ma_res_a};
res_b = {$mod_ma_res_b};
res_d = {$mod_ma_res_d};
</script>
<div id="contenidoMostrado">                               
<div id="elCosoxD">
<div class="coso_izquierda"></div>
<div class="coso_derecha"></div>
<div id="planeta" style="background-image: url(styles/theme/{$Raza_skin}/adds/mercader.jpg);"></div>
<div id="titulo_alternativo">
    <ul class="tabsbelow">
        <li>
              <span></span>
        </li>                                    
    </ul>
</div>
<div id="eins">
        <div>	
    <form id="trader" action="" method="post">
    <input type="hidden" name="ress" value="deuterium">
    <input type="hidden" name="action" value="trade">
     <table cellspacing="0" cellpadding="0" id="mercado_tabla" >
			<tbody><tr>
                    <td></td>
					<td>{$tr_resource}</td>
		            <td>{$tr_amount}</td>
					<td>{$tr_quota_exchange}</td>
				</tr>
				<!-- Metal -->
				<tr class="alt_2">
                    <td class="resIcon noCenter"><img src="styles/theme/{$Raza_skin}/images/metal.jpg"></td>
					<td class="noCenter">{$Metal}</td>
						<td>
							<div class="bg_input"><input name="metal" class="text" id="metal" type="text" value="0" onkeyup="calcul('{$ress}')" style="text-align: right;" size="10" class="textinput" /></div>
						</td>
						<td class="rate tipsTitle">
                            <span class="marca_color tooltip"  name="<h2>{$tr_quota_exchange}:</h4><span class='marca_color'><b>1 {$Deuterium}</b></span> = {$mod_ma_res_a} {$Metal}">{$mod_ma_res_a}</span>
						</td>
				</tr>
				<!-- Cristal -->
				<tr class="alt_2">
                    <td class="resIcon noCenter"><img src="styles/theme/{$Raza_skin}/images/cristal.jpg"></td>
					<td class="noCenter">{$Crystal}</td>
    				<td>
					<div class="bg_input"><input name="crystal" class="text" id="crystal" type="text" value="0" onkeyup="calcul('{$ress}')" style="text-align: right;" /></div>
					</td>
						<td class="rate tipsTitle">
                            <span class="marca_color tooltip" name="<h2>{$tr_quota_exchange}:</h4><span class='marca_color'><b>1 {$Deuterium}</b></span> = {$mod_ma_res_a} {$Crystal}">{$mod_ma_res_b}</span>
						</td>
    			</tr>	
				<!-- Deuterio -->
				<tr class="alt">
                    <td class="resIcon noCenter"><img src="styles/theme/{$Raza_skin}/images/deuterio.jpg"></td>
					<td class="noCenter">{$Deuterium}</td>
    				<td class="marca_color" id="deuterium">&nbsp;</td>
						<td class="rate"><span class="tooltip" name="<h2>{$tr_quota_exchange}:</h4><span class='marca_color'><b>1 {$Deuterium}</b></span> = {$mod_ma_res_a} {$Metal}, {$mod_ma_res_b} {$Crystal}, {$mod_ma_res_d} {$Norio}">1</span></td>
				
    			</tr>
				<!-- Norio -->
				<tr class="alt_2">
                    <td class="resIcon noCenter"><img src="styles/theme/{$Raza_skin}/images/norio.jpg"></td>
					<td class="noCenter">{$Norio}</td>
						<td>
							<div class="bg_input"><input name="norio" class="text" id="norio" type="text" value="0" onkeyup="calcul('{$ress}')" style="text-align: right;" size="10" class="textinput" /></div>
						</td>
						<td class="rate tipsTitle">
                            <span class="marca_color tooltip" name="<h2>{$tr_quota_exchange}:</h4><span class='marca_color'><b>1 {$Deuterium}</b></span> = {$mod_ma_res_d} {$Norio}">{$mod_ma_res_d}</span>
						</td>
				</tr>
				<!-- Otras cosas -->
				<tr>
					<td style="padding:10px" colspan="4">{$tr_descr}	
					<input type="submit" value="{$tr_exchange}" class="submit" />
					</td>
				</tr>
				<tr class="alt_2">
				<span class="tr_economia">
				<img class="tooltip" style="cursor: help" name="{$tr_cost_dm_trader}" src="styles/theme/{$Raza_skin}/imagenes/infos/economia.png" height="30" width="30"/>
				<img class="tooltip" style="cursor: help" name="{$tr_almacenes}" src="styles/theme/{$Raza_skin}/imagenes/infos/info.png" height="30" width="30"/>
				</span>
				</tr>
			</tbody>
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