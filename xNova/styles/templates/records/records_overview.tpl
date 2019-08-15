{include file="overall_header.tpl"}
<body id="imperio_body">
<div id="tooltip" class="tip"></div>
<center>
<div id="imperio">
<br />
 	<table id="imperio_tabla">
<tbody>
<tr><td colspan="3" class="c" style="text-align:center;">{$update}</td></tr>
{foreach item=Elementlist key=Section from=$Records}
<tr>
<td>&nbsp;</td>
<th class="repetido" style="width:199px">{$Section}</th>
<th class="repetido" style="width:203px">{$player}</th>
<th class="repetido" style="width:172px">{$level}</th>
</tr>
{foreach item=ElementInfo key=ElementName from=$Elementlist}
<tr>
<td><img class="tooltip" name="{$ElementName}" src="styles/theme/{$Raza_skin}/gebaeude/{$ElementInfo.id}.png" width="50" height="50" /></td>
<td class="tech_nombre" style="width:199px">{$ElementName}</td>
<td class="tech_nombre" style="width:203px">{$ElementInfo.winner}</td>
<td class="tech_nombre" style="width:172px">{$ElementInfo.count}</td>
</tr>
{/foreach}
{/foreach}
</tbody>
  </table>
</div>
</center>
{include file="overall_footer.tpl"}