<?php
$body.="<h2>Add reource</h2>
<table border='1'> <tr> <td>".$lang['adm_name']."</td><td>".$lang['adm_start']."</td><td>".$lang['adm_prodrate']."</td><td>".$lang['adm_icon']."</td> </tr>
<form method='post' action='?pg=resources'>
	<tr> <td><input type='text' name='name'></td>
		<td><input type='number' name='start' min='0' value='100'></td>
		<td><input type='number' name='prodrate' min='1' value='1'></td>
		<td><input type='text' name='icon' value='null.gif'></td>
		<td><input type='image' src='../img/icons/add-icon.png' onclick='document.thisform.submit()' name='addresource' value=' ' /></td>
</form>
</table>";

$body.="<br><br><table border='1'> <tr><td>".$lang['adm_name']."</td><td>".$lang['adm_start']."</td><td>".$lang['adm_prodrate']."</td><td>".$lang['adm_icon']."</td> </tr>";
$qrresources= $DB->query("SELECT * FROM ".TB_PREFIX."resdata");
while( $row= $qrresources->fetch_array() ){
	$body.="<form method='post' action='?pg=resources'><input type='hidden' name='editresource' value='".$row['id']."'>
	<tr><td><input type='text' name='name' value='".$row['name']."'></td>
	<td><input type='number' name='start' min='0' value='".$row['start']."'></td>
	<td><input type='number' name='prodrate' min='0' value='".$row['prod_rate']."'></td>
	<td><input type='text' name='ico' value='".$row['ico']."'></td>
	<td><input type='image' src='../img/icons/b_edit.png' onclick='document.thisform.submit()' />";
	
	if( $row['id']!=1 ) $body.="<a href='?pg=resources&delresource=".$row['id']."'><img src='../img/icons/x.png' /></a>";
	else $body.="&nbsp;";
	
	$body.="</td></tr></form>";
}
$body.="</table>";
?>