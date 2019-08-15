{if !$Fatal}
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
				<div id="titular_texto" style="display: block;">{$fcm_info}</div>
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
            <td>{$mes}</td>
        </tr>
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
{/if} 

{if $Fatal}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="{$lang}">
<head>
<title>{$title} - {$uni_name}</title>
{if $goto}
<meta http-equiv="refresh" content="{$gotoinsec};URL={$goto}" />
{/if}
<meta http-equiv="content-language" content="{$lang}" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta name="robots" content="index, follow" />
<link rel="stylesheet" type="text/css" href="./styles/css/jquery.css" />
<link rel="icon" href="favicon.ico" />
</head>
<body style="background:#000000;">
<div id="tooltip" class="tip"></div>
<table>
<tr>
<td><h2><font color="#FFFFFF" face="Arial">{$fcm_info}</font></h2></td>
</tr>
<tr style="margin-left:6px;">
<td><font color="#FFFFFF" size="1" face="Arial">{$mes}</font></td>
</tr>
</table>
{/if}
{include file="overall_footer.tpl"}