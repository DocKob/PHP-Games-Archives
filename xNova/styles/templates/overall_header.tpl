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
<link rel="stylesheet" type="text/css" href="./styles/theme/{$Raza_skin}/{$css_style}.css" />
<link rel="icon" href="favicon.ico" />
<script type="text/javascript">
//<![CDATA[
// This checks its a number.
function es_numero(input){
return !isNaN(input)&&parseInt(input)==input;
}
// This checks its lower or equal to max.
function comprobar(campo,val_num){
     
var elvalor = document.getElementById(campo).value;  
if(es_numero(elvalor)){
     
if(elvalor > val_num){
document.getElementById(campo).value= val_num;
}
     
} else{
alert("Por favor, ingresa un numero en el campo.");
}
     
}
//]]>
</script>
</head>