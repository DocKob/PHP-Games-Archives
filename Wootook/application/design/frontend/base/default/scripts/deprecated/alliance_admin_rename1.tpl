<br>
<form action="" method=POST>
<table width=519>
	<tr>
	  <td class="ramka" colspan=2><?php echo $this->getData('question')?></td>
	</tr>
	<tr>
	  <td class="ramka"><font color=green><b>Zmiana Nazwy</b></font></td>
	  <td class="ramka"><input type=text name=<?php echo $this->getData('name')?>> <input type=submit value="Zmie�"></td>
	</tr>
	<tr>
	  <td class="ramka" colspan="9"><a href="alliance.php?mode=admin&edit=ally"><?php echo $this->getData('Return_to_overview')?></a></td>
	</tr>
</table>
</form>