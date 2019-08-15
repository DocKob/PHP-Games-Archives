<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="{$lang}" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<link rel="stylesheet" type="text/css" href="styles/css/login.css" media="screen">
<link rel="stylesheet" type="text/css" href="styles/css/login_bg.css" media="screen">
<link rel="icon" href="favicon.ico">
<title>{$servername}</title>
<meta name="keywords" content="Browsergame, Clone, XNova, Revolution">
<meta name="medium" content="mult">
<meta name="description" content='xNova Revolution Browsergame powerd by Brayan Narvaez'>
</head>	
<body id="login">
<table>
<td> 
<a onclick="ajax('?getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">{$menu_index}</a> || <a href='{$forum_url}' target='_blank'>{$forum}</a> || {foreach $langs as $lng} <a href="?lang={$lng}"><img src="./styles/images/login/{$lng}.png" alt="" width="16" height="11"></a>{/foreach}
</td>
</table>
<br>
<div id="background-content">