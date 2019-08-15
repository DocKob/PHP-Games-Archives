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
				<div id="titular_texto" style="display: block;">{$lm_options}</div>
			</div>
        </div>
	</div> 
{include file="left_menu.tpl"}
<div id="contenidoMostrado">                               
<div id="elCosoxD">
<div id="cabezza" style="background-image: url(styles/theme/{$Raza_skin}/imagenes/navegacion/head2.png);"></div>
<div id="eins_small">
 <div>	
 <br /> 
    <form action="game.php?page=options&amp;mode=exit" method="post">
        <table width="95%">            
            <tr>
                <td>{$op_end_vacation_mode}</td>
                <td><input type="checkbox" name="exit_modus" {if !$is_deak_vacation}disabled{/if}></td>
            </tr><tr>
				<td><a title="{$op_dlte_account_descrip}">{$op_dlte_account}</a></td>
				<td><input name="db_deaktjava" type="checkbox" {if $opt_delac_data > 0}checked="checked"{/if}></td>
			</tr>
            <tr>
                <td colspan="2"><input class="submit" type="submit" value="{$op_save_changes}"></td>
            </tr>
        </table>
    </form>
 </div>
</div>	
<div class="new_footer_small"></div>
<center><div style="border: 2px solid red; padding: 2px 1px 2px 1px; width: 90%;margin-top: 2px;">{$op_vacation_mode_active_message} {$vacation_until}</div></center>	
<br /><br /><br />
</div>
</div>
</div>
</div>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}