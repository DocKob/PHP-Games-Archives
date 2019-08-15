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
<script type="text/javascript">
function infodiv(i){
$('.request:visible').slideUp(500);
$('#'+i).slideDown(500);
}
</script>
<div id="contenidoMostrado">                               
<div id="elCosoxD">
<div class="coso_izquierda_corto"></div>
<div class="coso_derecha_corto"></div>
<div id="planeta_small" style="background-image: url(styles/theme/{$Raza_skin}/adds/redes.jpg);"></div>	
<div id="titulo_alternativo_corto">
    <ul class="tabsbelow">
        <li>
              <span><b>{$al_request_list}</b> <a class="right" href="game.php?page=alliance"><b><font color="red">>></font> {$al_back}</b></a></span>
        </li>                                    
    </ul>
</div>	
<div id="eins">
<div>	
     <table width="95%">
		<tr>
          <td colspan="2">{$requestcount}</td>
        </tr>
        <tr>
          <th><a href="?page=alliance&amp;mode=admin&amp;edit=requests&amp;show=0&amp;sort=1">{$al_candidate}</a></th>
          <th><a href="?page=alliance&amp;mode=admin&amp;edit=requests&amp;show=0&amp;sort=0">{$al_request_date}</a></th>
        </tr>
        {foreach item=RequestRow from=$RequestList}
		<tr><td><a href="javascript:infodiv('request_{$RequestRow.id}');">{$RequestRow.username}</a></td><td><a href="javascript:infodiv('request_{$RequestRow.id}');">{$RequestRow.time}</a></td></tr>
		{foreachelse}
		<tr><td colspan="2">{$al_no_requests}</td></tr>
		{/foreach}
    </table>
</div>			
</div>
<div class="new_footer"></div>	
{foreach item=RequestRow from=$RequestList}
<div id="titulo_alternativo_secundario">
    <ul class="tabsbelow">
        <li>
              <span><b>{$al_request_from_user} <font color="orange">{$RequestRow.username}<font></b></span>
        </li>                                    
    </ul>
</div>	
<div id="eins">
<div>	
	<div class="request" id="request_{$RequestRow.id}" style="display:none;">
	<form action="?page=alliance&amp;mode=admin&amp;edit=requests&amp;action=send&amp;id={$RequestRow.id}" method="POST">
     <table width="95%">	
	<br /><tr>
		<td colspan="2">{$RequestRow.text}</td>
	</tr>
	<tr>
		<th colspan="2">{$al_reply_to_request}</th>
	</tr>
	<tr>
		<td><span id="cntChars">0</span> / 500 {$al_characters}&nbsp;</td>
		<td><br /><textarea name="text" cols="40" rows="10" onkeyup="$('#cntChars').text($(this).val().length);"></textarea></td>
	</tr>
	<tr>
		<td colspan="2"><input class="submit" type="submit" name="action" value="{$al_acept_request}"> <input class="submit" type="submit" name="action" value="{$al_decline_request}"></td>
	</tr>
	</table>
	</form>
	</div>
</div>			
</div>
<div class="new_footer"></div>	
{/foreach}	
<br /><br /><br />
</div>	
</div>
</div>	
</div>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}