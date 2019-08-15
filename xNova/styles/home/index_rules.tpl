<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$lang}">
<head>
<title>{$servername}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="favicon.ico">
<style type="text/css">
<!--
html, body, a {
	padding:0px;
	margin:0px;
	background-color:#000000;
	color:#FFFFFF;
	font-family: tahoma;
	font-size:12px;
}

a {
	text-align:left;
}

a:hover {
	text-decoration:underline;
	color:#DCBB96;
}


h1 {
	font-size:18px;
	color:#DCBB96;
	padding:0px;
	padding-left:8px;
	margin:0px;
}

h2 {
	font-size:13px;
	margin:0px;
	margin-bottom:10px;
	color:#DCBB96;
}

h3 {
	font-size:12px;
	font-weight:bold;
	margin:0px;
	margin-bottom:10px;

}

hr {
	margin:13px 0px;
	padding:0px;
	color:#DCBB96;
	background-color:#DCBB96;
	border:0px;
	border-bottom:1px dashed #DCBB96;
	clear:both;
	width:100%;
}

* html hr {
	margin:5px 0px;
}
-->
</style>
</head>
<body>
<table width="520" align="center" cellspacing="0" cellpadding="0">
	<tr>
		<td>
		<br/><br/>	<b><u>{$rules_overview}</u></b><br/><br/>

			<table>

{foreach name=Rules key=Head item=Rule from=$rules}
<b>{$smarty.foreach.Rules.iteration}. {$Head}</b>
<br><br>
{$Rule}
<br><br><br>
{/foreach}
{$rules_info1}
<h2 align="center"><span style="font-weight: 400"><b><font size="3">{$rules_info2}</font></b>

			</table><br>
xNova Revolution 5 &copy; 2011<br />
Development and Design by Brayan Narv&aacute;ez<br />

1070 Caracas, Venezuela<br />
	</tr>

		</table>
		<br/>
		</body>
</html>