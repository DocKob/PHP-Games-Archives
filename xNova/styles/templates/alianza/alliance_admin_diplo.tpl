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
              <span><b><a href="javascript:allydiplo('new',0,0);">{$al_diplo_create}</a></b> <a class="right" href="game.php?page=alliance&amp;mode=admin&amp;edit=ally"><b><font color="red">>></font> {$al_back}</b></a></span>
        </li>                                    
    </ul>
</div>	
<div id="eins">
<div>	
       <table width="95%">
        <tr>
          <th colspan="3">{$al_diplo_level.1}</th>
        </tr>
		{foreach key=id item=name from=$DiploInfo.1}
		<tr><td style="width:90%" colspan="2">{$name.0}</td><td><a href="?page=alliance&amp;mode=admin&amp;edit=diplo&amp;action=delete&amp;id={$id}&amp;level=1" onclick="javascript:return confirm('{$al_diplo_confirm_delete}');"><img src="{$dpath}pic/abort.gif" border="0" alt=""></a></td></tr>
		{foreachelse}
		<tr><td>{$al_diplo_no_entry}</td></tr>
		{/foreach}
        <tr>
          <th colspan="3">{$al_diplo_level.2}</th>
        </tr>
		{foreach key=id item=name from=$DiploInfo.2}
		<tr><td style="width:90%" colspan="2">{$name.0}</td><td><a href="?page=alliance&amp;mode=admin&amp;edit=diplo&amp;action=delete&amp;id={$id}&amp;level=2" onclick="javascript:return confirm('{$al_diplo_confirm_delete}');"><img src="{$dpath}pic/abort.gif" border="0" alt=""></a></td></tr>
		{foreachelse}
		<tr><td>{$al_diplo_no_entry}</td></tr>
		{/foreach}
        <tr>
          <th colspan="3">{$al_diplo_level.3}</th>
        </tr>
		{foreach key=id item=name from=$DiploInfo.3}
		<tr><td style="width:90%" colspan="2">{$name.0}</td><td><a href="?page=alliance&amp;mode=admin&amp;edit=diplo&amp;action=delete&amp;id={$id}&amp;level=3" onclick="javascript:return confirm('{$al_diplo_confirm_delete}');"><img src="{$dpath}pic/abort.gif" border="0" alt=""></a></td></tr>
		{foreachelse}
		<tr><td>{$al_diplo_no_entry}</td></tr>
		{/foreach}
        <tr>
          <th colspan="3">{$al_diplo_level.4}</th>
        </tr>
		{foreach key=id item=name from=$DiploInfo.4}
		<tr><td style="width:90%" colspan="2">{$name.0}</td><td>{if $ally_id == $name.2}<a href="?page=alliance&amp;mode=admin&amp;edit=diplo&amp;action=delete&amp;id={$id}&amp;level=4" onclick="javascript:return confirm('{$al_diplo_confirm_delete}');"><img src="{$dpath}pic/abort.gif" border="0" alt=""></a>{else}-{/if}</td></tr>
		{foreachelse}
		<tr><td>{$al_diplo_no_entry}</td></tr>
		{/foreach}
        <tr>
          <th colspan="3">{$al_diplo_accept}</th>
        </tr>
		{foreach key=id item=name from=$DiploInfo.5}
		<tr><td style="width:60%" class="tooltip" name="{$al_diplo_ground} {$name.3}">{$name.0}</td><td>{$al_diplo_level.{$name.2}}</td><td><a href="?page=alliance&amp;mode=admin&amp;edit=diplo&amp;action=accept&amp;id={$id}&amp;level={$name.2}" onclick="javascript:return confirm('{$al_diplo_accept_yes_confirm}');"><img src="{$dpath}pic/key.gif" border="0" alt=""></a><a href="?page=alliance&amp;mode=admin&amp;edit=diplo&amp;action=decline&amp;id={$id}&amp;level={$name.2}" onclick="javascript:return confirm('{$al_diplo_accept_no_confirm}');"><img src="{$dpath}pic/abort.gif" border="0" alt=""></a></td></tr>
		{foreachelse}
		<tr><td colspan="3">{$al_diplo_no_accept}</td></tr>
		{/foreach}
        <tr>
          <th colspan="3">{$al_diplo_accept_send}</th>
        </tr>
		{foreach key=id item=name from=$DiploInfo.6}
		<tr><td style="width:60%">{$name.0}</td><td>{$al_diplo_level.{$name.2}}</td><td><a href="?page=alliance&amp;mode=admin&amp;edit=diplo&amp;action=delete&amp;id={$id}&amp;level={$name.2}" onclick="javascript:return confirm('{$al_diplo_confirm_delete}');"><img src="{$dpath}pic/abort.gif" border="0" alt=""></a></td></tr>
		{foreachelse}
		<tr><td>{$al_diplo_no_accept}</td></tr>
		{/foreach}
    </table>
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