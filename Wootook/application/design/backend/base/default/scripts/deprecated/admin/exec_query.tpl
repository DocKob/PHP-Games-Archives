<br><br>
<h2><?php echo $this->getData('Qry_title')?></h2>
<form method="post" action="QueryExecute.php">
<table width="305" border="0" cellspacing="2" cellpadding="0" style="color:#FFFFFF">
<tr>
	<td class="c" colspan="6"><TEXTAREA name="qry_sql" rows=10 COLS=40></TEXTAREA></td>
</tr>
<tr>
	<th width="130"><input type="submit" name="ok" value="<?php echo $this->getData('md5_doit')?>"></th>
		<th width="130"><input type="checkbox" name="really_do_it" ><?php echo $this->getData('exec_check')?></th>
	
</tr>
</table>
</form>

