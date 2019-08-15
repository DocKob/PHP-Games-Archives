<?php
$body.="<h2>".$lang['adm_addrace']."</h2>
<table border='1' > <tr> <td>".$lang['adm_name']."</td> <td>".$lang['adm_desc']."</td> <td>".$lang['adm_image']."</td> </tr>
	<form method='post' action='?pg=races'>
		<tr>
			<td><input type='text' name='rname'></td>
			<td><textarea name='rdesc'></textarea></td>
			<td><input type='text' name='img' value='null.gif'></td>
			<td><input type='image' src='../img/icons/add-icon.png' onclick='document.thisform.submit()' name='addrace' value=' ' /></td>
		</tr>
	</form>
</table>";


$body.= "<br><br><table border='1' > <tr><td>id</td> <td>".$lang['adm_name']."</td> <td>".$lang['adm_desc']."</td> <td>".$lang['adm_image']."</td></tr>";

$qrrac= $DB->query("SELECT * FROM `".TB_PREFIX."races`");
while( $row= $qrrac->fetch_array() ){
	$body.="<tr><td>".$row['id']."</td><td>
			<form method='post' action=''><input type='hidden' name='editrac' value='".$row['id']."'>
			<input type='text' name='rname' value='".$row['rname']."'></td>
			<td><textarea name='rdesc'>".$row['rdesc']."</textarea></td>
			<td><input type='text' name='img' value='".$row['img']."'></td>
			<td><input type='image' src='../img/icons/b_edit.png' onclick='document.thisform.submit()' />
			</form>";
			
			if( $row['id']!=1 ) $body.="<a href='?pg=races&delrac=".$row['id']."'><img src='../img/icons/x.png' /></a>";
			else $body.="&nbsp;";
			
			$body.="</td></tr>";
}

$body.="</table>";
?>