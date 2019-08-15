{include file="overall_header.tpl"}
<div id="tooltip" class="tip"></div>
<br /><br /><br />
<div id="titulo_alternativo_corto">
    <ul class="tabsbelow">
        <li>
              <span><b>{$px_scan_position} [{$phl_pl_galaxy}:{$phl_pl_system}:{$phl_pl_place}] ({$phl_pl_name}) - {$px_fleet_movement}</b></a> </span>
        </li>                                    
    </ul>
</div>
<div id="eins">
<div>
<br />
<table width="95%">
    {foreach key=ID item=FleetInfoRow from=$fleets}
		<tr class="{$FleetInfoRow.fleet_status}">
			<td id="fleettime_{$ID}" style="width:92px;">-</td>
			<td>
				{$FleetInfoRow.fleet_descr}
			</td>
		</tr>
	{foreachelse}
		<tr><td colspan="2">{$px_no_fleet}</td></tr>
	{/foreach}
</table>
 </div>
</div>	
<div class="new_footer"></div>
<script type="text/javascript">
Fleets		= {$FleetData};
</script>
{include file="overall_footer.tpl"}