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
				<div id="titular_texto" style="display: block;">{$lm_battlesim}</div>
			</div>
        </div>
	</div> 
{include file="left_menu.tpl"}
<div id="contenidoMostrado">                               
<div id="elCosoxD">
<div id="cabezza" style="background-image: url(styles/theme/{$Raza_skin}/imagenes/navegacion/head2.png);"></div>
<div id="eins_small">
 <div>	
 
<form id="battlesim" name="battlesim">
<input type="hidden" name="slots" id="slots" value="{$Slots + 1}" />
<table style="width:95%">
<br />
<tr>
<td>
<center><img src="styles/theme/{$Raza_skin}/images/metal.jpg" class="tooltip" name="{$Metal}" /> <br /><input class="campo_comun" type="text" size="10" value="{if $battleinput.0.1.1}{$battleinput.0.1.1}{else}0{/if}" name="battleinput[0][1][1]"></center>
</td>

<td>
 <center><img src="styles/theme/{$Raza_skin}/images/cristal.jpg" class="tooltip" name="{$Crystal}" /> <br /> <input class="campo_comun" type="text" size="10" value="{if $battleinput.0.1.2}{$battleinput.0.1.2}{else}0{/if}" name="battleinput[0][1][2]"></center>
 </td>
 
 <td>
 <center><img src="styles/theme/{$Raza_skin}/images/deuterio.jpg" class="tooltip" name="{$Deuterium}" /> <br />  <input class="campo_comun" type="text" size="10" value="{if $battleinput.0.1.3}{$battleinput.0.1.3}{else}0{/if}" name="battleinput[0][1][3]"></center>
 </td>
 
 <td>
 <center><img src="styles/theme/{$Raza_skin}/images/norio.jpg" class="tooltip" name="{$Norio}" /> <br />  <input class="campo_comun" type="text" size="10" value="{if $battleinput.0.1.4}{$battleinput.0.1.4}{else}0{/if}" name="battleinput[0][1][4]"></center>
</td>
</tr>
 	<tr><td colspan="4"><br /></td></tr>
<tr>
</tr>
 	<tr><td  colspan="4"><input class="campo_comun" type="button" onClick="return add();" value="Add AKS-Slot"></td></tr>
<tr  colspan="4">
<td  colspan="4" style="padding:0;">
<div id="tabs">
<ul>
{section name=tab start=0 loop=$Slots}<li><a href="#tabs-{$smarty.section.tab.index}">AKS-Slot {$smarty.section.tab.index + 1}</a></li>{/section}
</ul>
{section name=content start=0 loop=$Slots}
<div id="tabs-{$smarty.section.content.index}">
<table>
<tr><th>{$bs_techno}</td><th>{$bs_atter}</th><th>{$bs_deffer}</th></tr>
<tr>
<td>{$attack_tech}:</td><td><input  class="campo_comun" type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.0.109}{$battleinput.{$smarty.section.content.index}.0.109}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][109]"></td><td><input class="campo_comun" type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.1.109}{$battleinput.{$smarty.section.content.index}.1.109}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][109]"></td>
</tr>
<tr>
<td>{$shield_tech}:</td><td><input class="campo_comun" type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.0.110}{$battleinput.{$smarty.section.content.index}.0.110}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][110]"></td><td><input class="campo_comun" type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.1.110}{$battleinput.{$smarty.section.content.index}.1.110}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][110]"></td>
</tr>
<tr>
<td>{$tank_tech}:</td><td><input class="campo_comun" type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.0.111}{$battleinput.{$smarty.section.content.index}.0.111}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][111]"></td><td><input class="campo_comun" type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.1.111}{$battleinput.{$smarty.section.content.index}.1.111}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][111]"></td>
</tr>
</table>
<br>
<table>
<tr><td class="transparent">
<table>
<tbody>
<tr><th>{$bs_names}</th><th>{$bs_atter}</th><th>{$bs_deffer}</th></tr>
{foreach item=name key=id from=$GetFleet}
<tr>
<td>{$name}:</td><td><input class="campo_comun" type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.0.$id}{$battleinput.{$smarty.section.content.index}.0.$id}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][0][{$id}]"></td><td><input class="campo_comun" type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.1.$id}{$battleinput.{$smarty.section.content.index}.1.$id}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][{$id}]"></td>
</tr>
{/foreach}
</table>
</td>{if $smarty.section.content.index == 0}<td style="width:50%" class="transparent">
<table>
<tr><th>{$bs_names}</td><th>{$bs_atter}</th><th>{$bs_deffer}</th></tr>
{foreach item=name key=id from=$GetDef}
<tr>
<td>{$name}:</td><td>-</td><td><input class="campo_comun" type="text" size="10" value="{if $battleinput.{$smarty.section.content.index}.1.$id}{$battleinput.{$smarty.section.content.index}.1.$id}{else}0{/if}" name="battleinput[{$smarty.section.content.index}][1][{$id}]"></td>
</tr>
{/foreach}
</tbody>
</table>
</td>{/if}</tr></table>
</div>
{/section}
</div>
</td>
</tr>
<tr id="submit">
<td colspan="4"><input class="submit" type="button" onClick="return check();" value="{$bs_send}">&nbsp;<input class="submit" type="reset" value="{$bs_cancel}"></td>
</tr>
<tr id="wait" style="display:none;">
<td style="height:20px">{$bs_wait}</td>
</tr>
</table>
</form>
 </div>
</div>	
<div class="new_footer_small"></div>	
<br /><br /><br />	


</div>
</div>
</div>
</div>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}