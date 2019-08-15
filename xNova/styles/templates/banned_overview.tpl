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
            <div id="titular_texto" style="display: block;">{$bn_players_banned_list}</div>
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
    <table width="95%">
   <tr>
        <td>{$bn_player}</td>
        <td>{$bn_reason}</td>
        <td>{$bn_from}</td>
        <td>{$bn_until}</td>
        <td>{$bn_by}</td>
    </tr>
   {foreach item=PlayerInfo from=$PrangerList name=Pranger}
   <tr>
      <td><center><b>{$PlayerInfo.player}</b></center></td>
      <td><center><b>{$PlayerInfo.theme}</b></center></td>
      <td><center><b>{$PlayerInfo.from}</b></center></td>
      <td><center><b>{$PlayerInfo.to}</b></center></td>
      <td><center><b><a href="mailto:{$PlayerInfo.mail}" title="{$PlayerInfo.info}">{$PlayerInfo.admin}</a></b></center></td>
   </tr>
   {/foreach}
   <tr><td colspan="5">{if {$smarty.foreach.Pranger.total} == 0}{$bn_no_players_banned}{else}{$bn_exists}{$smarty.foreach.Pranger.total}{$bn_players_banned}{/if}</td></tr>
    </table>
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