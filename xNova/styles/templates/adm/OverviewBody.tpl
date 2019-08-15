{include file="adm/overall_header.tpl"}
<br>
<script type="text/javascript" src="./scripts/buildlist.js"></script>
<center>
<h1>{$ow_title}</h1>
<table width="90%" style="border:2px {if empty($Messages)}lime{else}red{/if} solid;text-align:center;font-weight:bold;">
<tr>
    <td class="transparent">{foreach item=Message from=$Messages}
	<span style="color:red">{$Message}</span><br>
	{foreachelse}{$ow_none}{/foreach}
	</td>
</tr>
</table>
 <table width="80%">
	<tr>
	<th colspan="2"><h3>Xnova Revolution Team</h3></th>
	</tr>
<tr align="center">
	  <td><a href="http://princk.deviantart.com/" target="_blank"><b>Brayan Narv&aacute;ez (Prinick)</b></a></td>
	  <td>Leader<br />Programmer<br />Designer<td>
	</tr>
	<tr align="center">
	  <td><b>Zorrogris</b></td>
	  <td>Xnova Forum Hoster<td>
	</tr>
	<tr align="center">
	  <td><b>D4rk0ur</b></td>
	  <td>Xnova Forum Hoster<td>
	</tr>
	<tr>
	<th colspan="2"><h3><a href="http://2moons.cc/" target="_blank">2Moons</a> Team</h3></th>
	</tr>
	<tr align="center">
	  <td><b>Slaver</b></td>
	  <td>2moons Leader<br />Developer<td>
	</tr>
	<tr align="center">
	  <td><b>Robbyn</b></td>
	  <td>Communityleitung<td>
	</tr>
	<tr align="center">
	  <td><b>Lyon</b></td>
	  <td>Forenadministrator<td>
	</tr>
	<tr align="center">
	  <td><b>Freak1992</b></td>
	  <td>Forenadministrator<td>
	</tr>
	<tr align="center">
	  <td><b>Buggy666</b></td>
	  <td>Forenmoderrator<td>
	</tr>
	<tr align="center">
	  <td><b>Z3roCooL</b></td>
	  <td>2moons English Translator<td>
	</tr>
	<tr align="center">
	  <td><b>Yoda</b></td>
	  <td>2moons Frensh Translator<td>
	</tr>
	<tr align="center">
	  <td><b>QwataKayean</b></td>
	  <td>2moons Portuguese Translator<td>
	</tr>
	<tr align="center">
	  <td><b>InquisitorEA</b></td>
	  <td>2moons Russian Translator<td>
	</tr>
	
	<tr>
	<th colspan="2"><h3>Special Thanks</h3></th>
	</tr>
	<tr align="center">
	  <td><b>lucky<br />Giogio<br />killer99<br />kmti212<br />sharpshooter<br />Naruto<br />Metusalem<br />Meikel<br />Phil<br />Schnippi<br />Inforcer<br />Vobi<br />Onko<br />Sycrog<br />Raito<br />Chlorel<br />e-Zobar<br />Flousedid<br />Allen Spielern im <a href="http://www.titanspace.org" target="blank">Betauni</a></b></td>
	  <td>Others contributors<td>
	</tr>
	<tr align="center">
	<td colspan="2"><br/>And all Community of 2moons and xNova Revolution</td>
	</tr>
	<tr class="remarcado">
	<td colspan="2"><center><img src="styles/theme/gultra/imagenes/otros/creditos.png" /></center></td>
	</tr>
	</table>
<script type="text/javascript">
$(document).ready(function(){
	$('.UIStory_Message').css("color","#CCCCCC");
});
</script>
{include file="adm/overall_footer.tpl"}