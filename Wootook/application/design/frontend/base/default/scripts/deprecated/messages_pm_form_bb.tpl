<script src="scripts/cntchar.js" type="text/javascript"></script>

<br />
<center>
<form action="messages.php?mode=write&id=<?php echo $this->getData('id')?>" method="post">
<table width="519">
<tr>
	<td class="c" colspan="2"><?php echo $this->getData('Send_message')?></td>
</tr><tr>
	<th><?php echo $this->getData('Recipient')?></th>
	<th><input type="text" name="to" size="40" value="<?php echo $this->getData('to')?>" /></th>
</tr><tr>
	<th><?php echo $this->getData('Subject')?></th>
	<th><input type="text" name="subject" size="40" maxlength="40" value="<?php echo $this->getData('subject')?>" /></th>
</tr><tr>
	<th><?php echo $this->getData('Message')?>(<span id="cntChars">0</span> / 5000 <?php echo $this->getData('characters')?>)</th>
	<th><textarea name="text" cols="40" rows="10" size="100" onkeyup="javascript:cntchar(5000)"><?php echo $this->getData('text')?></textarea></th>
</tr>
<tr>

</tr>
<tr>
	<th colspan="2"><input type="reset" value="Effacer" /></th>
</tr><tr>
	<th colspan="2"><input type="submit" value="Envoyer" size="20" style="font-weight:bold" onClick="this.form.submit();this.disabled=true;this.value='Patientez...'"/></th>
</tr><tr>
	<th colspan="2">&Eacute;moticones et BBCode :<br />Vous pouvez utiliser le BBCode et des &eacute;moticones pour embellir vos m&eacute;ssages...<br /><br />Pour utiliser les &eacute;moticones de base fournis par le staff :<br /><img src="emoticones/Smile.png" alt="Sourire ;)"> = Smile<br /><img src="emoticones/cool.png" alt="cool ;)"> = cool<br /><img src="emoticones/grrr.png" alt="Enerv�"> = grrr<br /><img src="emoticones/love.png" alt="Amour^^"> = love<br /><img src="emoticones/msn.png" alt="msn"> = msn<br /><img src="emoticones/Oo.png" alt="Oo"> = Oo<br /><img src="emoticones/perdu.png" alt="perdu"> = perdu<br /><img src="emoticones/wink.png" alt="wink"> = wink<br /><img src="emoticones/wow.png" alt="wow"> = wow<hr />Texte en gras = [b]Texte[/b]<br />Texte soulign� = [u]Texte[/u]<br />Texte en italliqiue = [i]Texte[/i]<br />Une image = [img]http://liendelimage.com[/img]</th>
</tr>
</table>
</form>
</center>