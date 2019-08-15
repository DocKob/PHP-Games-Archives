<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function repondre(pseudo){

	document.message.destinataire.value = pseudo;
	document.message.message.focus();

}

//-->
</script>
<table width="690" border="0" align="center" cellpadding="0" cellspacing="0" class="txt">
  <tr>
    <td class="table16px"><div align="center"><a name="messages"></a>[ <a href="jeu.php?include=messages&type=compo">Composer un message</a> ] [ <a href="jeu.php?include=messages">Boite de r&eacute;ception</a> ] [ <a href="jeu.php?include=messages&type=envoi">Boite d'envoi</a> ] [ <a href="jeu.php?include=messages&type=suppr">Corbeille</a> ]</div></td>
  </tr>
</table>
<p>
<?php
$sql = "SELECT * FROM is_message ";

if( isset($_GET['type']) )
{
	$type = $_GET['type'];
	if( $type == "suppr" ) $sql .= "WHERE pour='".$pseudo."' AND suppr=0 ";
	if( $type == "envoi" ) $sql .= "WHERE de='".$pseudo."' ";
}
else
{
	$sql .= "WHERE pour='".$pseudo."' AND suppr=1 ";
}
$sql .= "ORDER BY seconde DESC";

$resultat_message = mysql_query($sql);
if(mysql_num_rows($resultat_message) > 0 ) {
	
	/* ecrit le debut de tableau */
	if ( $_GET['type'] == "envoi" ) {
		echo('
		<table width="690" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" class="txt">
		<tr>
		<td width="75" class="table16px"><div align="center">Titre du message</div></td>
		<td width="150" class="table16px"><div align="center">Date/Heure d\'envoi</div></td>
		<td width="100" class="table16px"><div align="center">Envoy&eacute; &agrave;</div></td>
		</tr>
		');
	} else if ( $_GET['type'] == "suppr" ) {
		echo('
		<form name="SuppretionMessage" method="post" action="action/message_supp.php">
		<table width="690" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" class="txt">
		<tr>
		<td width="15" class="table16px">&nbsp;</td>
		<td width="75" class="table16px"><div align="center">Titre du message</div></td>
		<td width="150" class="table16px"><div align="center">Date/Heure d\'envoi</div></td>
		<td width="100" class="table16px"><div align="center">Exp&eacute;diteur</div></td>
		</tr>
		');
	} else {
		echo('
		<form name="SuppretionMessage" method="post" action="action/message_suppr.php">
		<table width="690" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" class="txt">
		<tr>
		<td width="15" class="table16px">&nbsp;</td>
		<td width="75" class="table16px"><div align="center">Titre du message</div></td>
		<td width="150" class="table16px"><div align="center">Date/Heure d\'envoi</div></td>
		<td width="100" class="table16px"><div align="center">Exp&eacute;diteur</div></td>
		</tr>
		');
	}
	$backcolor = "#333333";
	while( $t_message = mysql_fetch_array($resultat_message) ) {
		
		if($backcolor == "#333333") {
			$backcolor = "#000000";
		} else {
			$backcolor = "#333333";
		}
		
		/* ecrit la ligne du tableau en boucle */
		if( $_GET['type'] == "envoi" ) {
			echo('
			<tr bgcolor="'.$backcolor.'" onClick="MM_openBrWindow(\'pages/message_lire.php?id='.$t_message['id'].'\',\'Message\',\'scrollbars=yes,resizable=yes,width=400,height=250\')" onMouseOut="javascript:this.style.background=\''.$backcolor.'\'" onMouseOver="javascript:this.style.background=\'#2E3854\'">
			<td>'.$t_message['sujet'].'</td>
			<td><div align="center">'.$t_message['date_ecrit'].'</div></td>
			<td><div align="center">'.$t_message['pour'].'</div></td>
			</tr>
			');
		} else {
			echo('
			<tr bgcolor="'.$backcolor.'" onMouseOut="javascript:this.style.background=\''.$backcolor.'\'" onMouseOver="javascript:this.style.background=\'#2E3854\'">
			<td width="15">
			<input type="checkbox" name="'.$t_message['id'].'" value="'.$t_message['id'].'" style="width:15px;">
			<td onClick="MM_openBrWindow(\'pages/message_lire.php?id='.$t_message['id'].'\',\'Message\',\'scrollbars=yes,resizable=yes,width=400,height=250\')">'.$t_message['sujet'].'</td>
			<td><div align="center">'.$t_message['date_ecrit'].'</div></td>
			<td><div align="center"><a href="#bottom" onClick="javascript:repondre(\''.$t_message['de'].'\')">'.$t_message['de'].'</a></div></td>
			</tr>
			');
		}

		if($t_message['lu'] == 0 ) {
			$sql = "UPDATE is_message SET lu=1 WHERE id=".$t_message['id'];
			mysql_query($sql);
		}		
	}
	/* ecrit la fin du tableau */
	if( $_GET['type'] == "envoi" ) {
		echo('
		</table>
		');
	} else if ( $_GET['type'] == "compo" ) {
		echo('
<p align="center">
  <input type="submit" name="Submit" value="Envoyer" style="width:500">
</p>
</form>
		');
	} else {
		echo('
		</table>
		<p align="center">
		<input name="Submit" type="submit" value="Supprimer" style="width:690px;">
		</p>
		</form>
		');
	}

} else {
	if ( $_GET['type'] != "compo" ) {
		echo('<p align="center">Aucun Message disponible.</p>');
	}
}

if ( $_GET['type'] == "compo" ) {
			echo('
			<form action="action/message_envoi.php" method="post" name="message">          
			<p align="center">
			Destinataire :
			</p>
			<p align="center"> 
			<input name="destinataire" type="text" style="width:500">
			</p>
			<p align="center">
			Sujet :
			</p>
			<p align="center">
			<input name="sujet" type="text" value="" style="width:500">
			</p>
			<p align="center">
			Message :
			</p>
			<p align="center">
			  <textarea name="message"style="width:500; height:300">
			</textarea>
			</p>
			<p align="center">
			  <input type="submit" name="Submit" value="Envoyer" style="width:500">
			</p>
			</form>
');
}
?> 
</p>