<table style="width:90%">
<tr>
<th colspan="3"><b>{$pl_overview}</b></th>
</tr>
<tr>
<td style="width:40%"><b>{$pl_name}</b></td>
<td colspan="2">{$name} {if $id != $yourid}<a href="javascript:OpenPopup('game.php?page=buddy&amp;mode=2&amp;u={$id}', '', 720, 300);" title="{$pl_buddy}"><img src="styles/theme/{$Raza_skin}/imagenes/otros/b.gif" /></a> <a href="#" onclick="return Dialog.PM({$id});" title="{$pl_message}"><img src="styles/theme/{$Raza_skin}/imagenes/otros/m.gif" /></a>{/if}</td>
</tr>
<tr>
<td><b>{$pl_homeplanet}</b></td>
<td colspan="2">{$homeplanet} <a href='javascript:window.opener.focus();' onclick='window.opener.location.href = "game.php?page=galaxy&amp;mode=3&amp;galaxy={$galaxy}&amp;system={$system}";'>[{$galaxy}:{$system}:{$planet}]</a></td>
</tr>
<tr>
<td><b>{$pl_ally}</b></td>
<td colspan="2">{if $allyname}<a href='javascript:window.opener.focus();' onclick='window.opener.location.href = "game.php?page=alliance&amp;mode=ainfo&amp;a={$allyid}";'>{$allyname}</a>{else}-{/if}</td>
</tr>
<tr>
<td><b>{$Raza}</b></td>
<td colspan="2">{$Raza_tipo}</td>
</tr>
<tr>
<th>&nbsp;</th>
<th>{$pl_points}</th>
<th>{$pl_range}</th>
</tr>
<tr>
<td><img src="styles/theme/{$Raza_skin}/gebaeude/3.png" width="20" height="20" /></td>
<td><center>{$build_points}</center></td>
<td><center>{$build_rank}</center></td>
</tr>
<tr>
<td><img src="styles/theme/{$Raza_skin}/gebaeude/113.png" width="20" height="20" /></td>
<td><center>{$tech_points}</center></td>
<td><center>{$tech_rank}</center></td>
</tr>
<tr>
<td><img src="styles/theme/{$Raza_skin}/gebaeude/208.png" width="20" height="20" /></td>
<td><center>{$fleet_points}</center></td>
<td><center>{$fleet_rank}</center></td>
</tr>
<tr>
<td><img src="styles/theme/{$Raza_skin}/gebaeude/404.png" width="20" height="20" /></td>
<td><center>{$defs_points}</center></td>
<td><center>{$defs_rank}</center></td>
</tr>
<tr>
<td><img src="styles/theme/{$Raza_skin}/gebaeude/411.png" width="20" height="20" /></td>
<td><center>{$total_points}</center></td>
<td><center>{$total_rank}</center></td>
</tr>
<tr>
<th colspan="3">{$pl_fightstats}</th>
</tr>
<tr>
<th>&nbsp;</th>
<th>{$pl_fights}</th>
<th>{$pl_fprocent}</th>
</tr>
<tr>
<td>{$pl_fightwon}</td>
<td>{$wons}</td>
<td>{$siegprozent} %</td>
</tr>
<tr>
<td>{$pl_fightdraw}</td>
<td>{$draws}</td>
<td>{$drawsprozent} %</td>
</tr>
<tr>
<td>{$pl_fightlose}</td>
<td>{$loos}</td>
<td>{$loosprozent} %</td>
</tr>
<tr>
<td>{$pl_totalfight}</td>
<td>{$totalfights}</td>
<td>100%</td>
</tr>
<tr>
<th colspan="3">{$playerdestory}:</th>
</tr>
<tr>
<td>{$pl_unitsshot}</td>
<td colspan="2">{$desunits}</td>
</tr>
<tr>
<td>{$pl_unitslose}</td>
<td colspan="2">{$lostunits}</td>
</tr>
<tr>
<td>{$pl_dermetal}</td>
<td colspan="2">{$kbmetal}</td>
</tr>
<tr>
<td>{$pl_dercrystal}</td>
<td colspan="2">{$kbcrystal}</td>
</tr>
<tr>
<td>{$pl_dernorio}</td>
<td colspan="2">{$kbnorio}</td>
</tr>
</table>