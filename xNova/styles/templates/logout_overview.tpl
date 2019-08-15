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
<table align="center">
<tr>
<td><font color="#FFFFFF" size="1" face="Arial"><center>{$lo_logout}</center></font></td>
</tr>
<tr>
<td><center><font color="#FFFFFF" size="1" face="Arial">{$lo_notify}</font></center></td>
</tr>
</table>
<script type="text/javascript">
    var second = 5;
	function Countdown(){
		if(second == 0)
			return;
			
		second--;
		$('#seconds').text(second);
	}
	window.setTimeout("window.location.href='./index.php'", 5000);
	window.setInterval("Countdown()", 1000);
</script>
{include file="overall_footer.tpl"}