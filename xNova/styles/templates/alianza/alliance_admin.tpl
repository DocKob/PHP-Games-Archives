{include file="overall_header.tpl"}
<body id="mercado">
<div id="tooltip" class="tip"></div>
<div class="contenido_big">
<div id="cajaBG">
    <div id="caja">
<div id="topnav" class="header_g"> 	
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
              <span><b>{$al_texts}</b></span>
        </li>                                    
    </ul>
</div>	
<div id="eins">
<div>		
    <form action="" method="POST">
    <input type="hidden" name="t" value="{$t}">
    <table style="width:90%">
        <tr>
          <td><a href="game.php?page=alliance&amp;mode=admin&amp;edit=ally&amp;t=1"><h3>{$al_outside_text}</h3></a></td>
          <td><a href="game.php?page=alliance&amp;mode=admin&amp;edit=ally&amp;t=2"><h3>{$al_inside_text}</h3></a></td>
          <td><a href="game.php?page=alliance&amp;mode=admin&amp;edit=ally&amp;t=3"><h3>{$al_request_text}</h3></a></td>
        </tr>
        <tr>
          <th colspan="3">{$al_message} (<span id="cntChars">0</span> / 5000 {$al_characters})</th>
        </tr>
        <tr>
		<br />
		<textarea name="text" id="text" cols="70" rows="15" onkeyup="$('#cntChars').text($('#text').val().length);" class="bbcode">{$text}</textarea>
        </tr>
		<tr><td colspan="3">
		<div class="preview"></div>
		</td>
		</tr>
        <tr>
          <td colspan="3">
            <input class="submit" type="submit" value="{$al_save}" />
          </td>
        </tr>
    </table>
    </form>
</div>
</div>	
<div class="new_footer"></div>
<div id="titulo_alternativo_secundario">
    <ul class="tabsbelow">
        <li>
              <span><b>{$al_manage_options}</b></span>
        </li>                                    
    </ul>
</div>	
<div id="eins">
<div>
<br />	
    <form action="" method="POST">
    <table style="width:95%">
        <tr>
          <td>{$al_web_site}</td>
          <td><input class="campo_comun" type="text" name="web" value="{$ally_web}" size="70"></td>
        </tr>
        <tr>
          <td>{$al_manage_image}</td>
          <td><input class="campo_comun" type="text" name="image" value="{$ally_image}" size="70"></td>
        </tr>
        <tr>
          <td>{$al_manage_requests}</td>
          <td>{html_options name=request_notallow options=$RequestSelector selected=$ally_request_notallow}</td>
        </tr>
        <tr>
          <td>{$al_manage_founder_rank}</td>
          <td><input class="campo_comun" type="text" name="owner_range" value="{$ally_owner_range}" size="30"></td>
        </tr>
        <tr>
          <td>{$al_view_stats}</td>
          <td>{html_options name=stats options=$YesNoSelector selected=$ally_stats_data}</td>
        </tr>
        <tr>
          <td>{$al_view_diplo}</td>
          <td>{html_options name=diplo options=$YesNoSelector selected=$ally_diplo_data}</td>
        </tr>
        <tr>
          <td colspan="2"><input class="submit" type="submit" name="options" value="{$al_save}"></td>
        </tr>
<tr></tr><tr></tr>		
		<tr>
		<th colspan="2"><font color="red">>></font> {$al_transfer_alliance} <font color="red"><<</font></th>
		</tr>
		<tr>
          <td colspan="2"><input class="submit" type="button" onclick="javascript:location.href='game.php?page=alliance&amp;mode=admin&amp;edit=transfer';" value="{$al_continue}"></td>
        </tr>
    </table>
    </form>
</div>
</div>	
<div class="new_footer"></div>		
<br /><br /><br />
</div>	
<div id="menu_flotas">
		<div id="lista_misiones">    
             <p><b>{$al_manage_alliance}</b></p>  
			<div class="misiones_top"></div>
			<div class="misiones">
			<center>                     
			<b><a href="game.php?page=alliance&amp;mode=admin&amp;edit=rights">{$al_manage_ranks}</a></b><br />
			<b><a href="game.php?page=alliance&amp;mode=admin&amp;edit=members">{$al_manage_members}</a></b><br />
			<b><a href="game.php?page=alliance&amp;mode=admin&amp;edit=tag">{$al_manage_change_tag}</a></b><br />
			<b><a href="game.php?page=alliance&amp;mode=admin&amp;edit=name">{$al_manage_change_name}</a></b>
		{if $righthand}
			<br /><b><a href="game.php?page=alliance&amp;mode=admin&amp;edit=diplo">{$al_manage_diplo}</a></b><br />
		{/if}
		<br /><b>{$al_disolve_alliance}</b><br />
		<form action="?page=alliance&amp;mode=admin&amp;edit=exit" method="POST"><input class="submit" type="submit" value="{$al_continue}" onclick="return confirm('{$al_close_ally}');"></form>
			</center>
			</div> 
			<div class="misiones_footer"></div>			
		</div>		
</div>		
</div>	
</div>	
</div>
</div>	
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}