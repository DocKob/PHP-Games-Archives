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
<link rel="stylesheet" type="text/css" href="styles/theme/{$Raza_skin}/reportes.css" />
<link rel="icon" href="favicon.ico" />
</head>
<body>
<div id="tooltip" class="tip"></div>
{$raport}
{include file="overall_footer.tpl"}