<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="es">
<head>
<link rel="stylesheet" type="text/css" href="./styles/theme/gultra/cpanel.css" />
<link rel="icon" href="./favicon.ico" />
<title>{$title}</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta http-equiv="content-style-type" content="text/css" />
<meta http-equiv="X-UA-Compatible" content="IE=100" />
<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon" />
{if $goto}
<meta http-equiv="refresh" content="{$gotoinsec};URL={$goto}" />
{/if}
<script type="text/javascript" src="./scripts/base.js"></script>
<script type="text/javascript" src="./scripts/jQuery.js"></script>
<script type="text/javascript" src="./scripts/install.js"></script>
{foreach item=scriptname from=$scripts}
<script type="text/javascript" src="./scripts/{$scriptname}"></script>
{/foreach}
</head>
<body>
<center>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<table width="700">
<tr>
	<th colspan="3">{$menu_install}</th>
</tr>
<tr>
<td colspan="3">[<a href="?mode=intro&amp;{$lang}">{$menu_intro}</a> &bull; <a href="?mode=req&amp;{$lang}">{$menu_install}</a> &bull; <a href="?mode=license&amp;{$lang}">{$menu_license}</a>]</td>
</tr>