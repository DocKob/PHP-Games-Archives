{include file="overall_header.tpl"}
<body id="mercado">
<div id="tooltip" class="tip"></div>
<div class="contenido_big">
<div id="cajaBG">
    <div id="caja">
<div id="topnav" class="header_normal"> 	
		{include file="overall_topnav.tpl"}	
			<div id="titular">
			<div id="estructura_titular" style="position:relative;">
				<div id="titular_texto" style="display: block;">{$supp_header}</div>
			</div>
        </div>
	</div> 
{include file="left_menu.tpl"}
<div id="contenidoMostrado">                               
<div id="elCosoxD">
<div id="cabezza" style="background-image: url(styles/theme/{$Raza_skin}/imagenes/navegacion/head2.png);"></div>
<div id="eins_small">
 <div>	
 <br />
	<table width="95%">
		<tr>
			<th style="width:10%">{$ticket_id}</td>
			<th style="width:50%">{$subject}</td>
			<th style="width:15%">{$status}</td>
			<th style="width:25%">{$ticket_posted}</td>
		</tr>
		{foreach key=TicketID item=TicketInfo from=$TicketsList}	
		<tr>
		<td>{$TicketID}</td>
		<td><a href="#" onclick="ShowTicket('ticket_{$TicketID}');">{$TicketInfo.subject}</a></td>
		<td>{if $TicketInfo.status == 0}<span style="color:red">{$supp_close}</span>{elseif $TicketInfo.status == 1}<span style="color:green">{$supp_open}</span>{elseif $TicketInfo.status == 2}<span style="color:orange">{$supp_admin_answer}</span>{elseif $TicketInfo.status == 3}<span style="color:green">{$supp_player_answer}</span>{/if}</td>
		<td>{$TicketInfo.date}</td>
		</tr>
		{/foreach}
	</table>
	{foreach key=TicketID item=TicketInfo from=$TicketsList}
	<div id="ticket_{$TicketID}" style="display:none;" class="tickets">
		<form action="game.php?page=support&amp;action=send&amp;id={$TicketID}" method="POST">
			<table style="width:50%">
				<tr>
					<th>{$text}</th>
				</tr>
				<tr>
					<td>{$TicketInfo.text}</td>
				</tr>
				{if $TicketInfo.status == 0}<tr><th>{$supp_ticket_close}</th></tr>{/if}
				<tr>
					<td>
					{if $TicketInfo.status != 0}
					<textarea cols="50" rows="10" name="text"></textarea><br><input class="submit" type="submit" value="{$supp_send}">
					{/if}
					</td>
				</tr>
			</table>
		</form>
	</div>
	{/foreach}
	<div id="newbutton" style="display:block;">
		<table style="width:50%">
			<tr>
				<td><a href="#" onclick="ShowTicket(0);"><input class="submit" type="submit" value="{$ticket_new}" /></a></td>
			</tr>
		</table>
	</div>
	<div id="new" style="display:none;">
		<form action="game.php?page=support&amp;action=newticket" method="POST">
			<table style="width:50%">
				<tr>
					<th colspan="2" width="50%">{$ticket_new}</th>
				</tr>
				<tr>
					<td>{$subject}:</td>
					<td><input type="text" class="campo_comun" name="subject"></td>
				</tr>
				<tr>
					<td colspan="2">{$input_text}</td>
				</tr>
				<tr>
					<td colspan="2">
						<textarea name="text" cols="50" rows="10"></textarea>
						<input type="submit" class="submit" value="{$supp_send}">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
</div>	
<div class="new_footer_small"></div>	
<br /><br /><br />	
</div>
</div>
</div>
</div>
</div>
{include file="planet_menu.tpl"}
{include file="overall_footer.tpl"}