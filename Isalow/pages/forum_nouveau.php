<SCRIPT LANGUAGE="JavaScript1.1">
function smiley(smiley){
	document.forum.message.value += smiley+" ";
	document.forum.message.focus();
}

function lien() {
	var texte  = prompt("Rentrez le texte qui apparaîtera comme lien.","lien");
	var url  = prompt("Rentrez l'url qui servira au lien","http://");
	
	var smiley = "[a]"+url+"[b]"+texte+"[c]";	
	document.comment.messageF.value += smiley+" ";
	document.comment.messageF.focus();
}
</script>

<form name="forum" method="post" action="action/forum_nouveau.php">
<table width="690" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>  
	<td width="80%" align="center" class="txt">
    <br />
	Nom d'utilisateur :
    <br /><br />
	</td>
	<td width="20%" class="txt">
	<input type="text" style="width:570;" maxlength="35" disabled="disabled" value="<?= $pseudo ?>">
	</td>
  </tr>
<?php
if( !isset($_GET['sujet']) )
{
	echo('
  <tr>  
	<td width="80%" class="txt">
    <br />
	Titre du message :
    <br /><br />
	</td>
	<td width="20%">
	<input name="titre" type="text" id="titre" style="width:570;" maxlength="35">
	</td>
  </tr>
	');
}
?>   
  <tr>
    <td width="80%" align="center" class="txt">
    <br />
	Votre message :
	<br /><br />
	<table width="100" border="0" align="center" cellpadding="0" cellspacing="0" class="tablebords">
	<tr>
		<td class="txt" colspan="4">Smileys</td>
	</tr>
	<tr>
 	   <td width="20%">
	          <div align="center"><a href="javascript:smiley(':)')"><img src="images/smileys/content.gif" width="15" height="15" border="0"  title="Content"></a></div></td>
        <td width="20%">
          <div align="center"><a href="javascript:smiley('8)')"><img src="images/smileys/cool.gif" width="15" height="15" border="0" title="Happy"></a></div></td>
        <td width="20%">
          <div align="center"><a href="javascript:smiley(':d')"><img src="images/smileys/dents.gif" width="15" height="15" border="0" title="Cool"></a></div></td>
        <td width="20%">
          <div align="center"><a href="javascript:smiley(':o')"><img src="images/smileys/etonne.gif" width="15" height="15" border="0" title="Etonn&eacute;"></a></div></td>
        </tr>
      <tr>
        <td width="20%">
          <div align="center"><a href="javascript:smiley(':s')"><img src="images/smileys/gene.gif" width="15" height="15" border="0" title="Gene"></a></div></td>
        <td width="20%">
          <div align="center"><a href="javascript:smiley(':0')"><img src="images/smileys/pleure.gif" width="15" height="15" border="0"></a></div></td>
        <td width="20%">
          <div align="center"><a href="javascript:smiley(':p')"><img src="images/smileys/langue.gif" width="15" height="15" border="0" title="Langue"></a></div></td>
        <td width="20%">
          <div align="center"><a href="javascript:smiley(':@')"><img src="images/smileys/mechant.gif" width="15" height="15" border="0" title="Mechant"></a></div></td>
        </tr>
      <tr>
        <td width="20%">
          <div align="center"><a href="javascript:smiley(':|')"><img src="images/smileys/rien.gif" width="15" height="15" border="0" title="Rien"></a></div></td>
        <td width="20%">
          <div align="center"><a href="javascript:smiley(':(')"><img src="images/smileys/triste.gif" width="15" height="15" border="0" title="Triste"></a></div></td>
        <td width="20%">
          <div align="center"><a href="javascript:smiley(':x')"><img src="images/smileys/mort.gif" width="15" height="15" border="0" title="Mort"></a></div></td>
        <td width="20%">
          <div align="center"></div></td>
        </tr>
      <tr>
        <td width="20%">
          <div align="center"><a href="javascript:smiley(':#')"><img src="images/smileys/insulte.gif" width="15" height="22" border="0" title="Insulte"></a></div></td>
        <td width="20%">
          <div align="center"><a href="javascript:smiley(':?')"><img src="images/smileys/question.gif" width="15" height="22" border="0" title="Question"></a></div></td>
        <td width="20%">
          <div align="center"><a href="javascript:smiley('zZ')"><img src="images/smileys/dormeur.gif" width="15" height="24" border="0" title="Dormeur"></a></div></td>
        <td width="20%">
          <div align="center"></div></td>
        </tr>
    </table>
    <br />
    </td>
    <td width="80%">
	<textarea name="message" id="textarea" style="width:570; height:400;"></textarea>
    </td>
  </tr>
  <tr>
    <td width="100%" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="80%" colspan="2" align="center"><input type="submit" name="Submit" value="Envoyer" style="width:690;">
<?php
if( isset($_GET['sujet']) )
{
	echo('<input name="sujet" type="hidden" id="sujet" value="'.$_GET['sujet'].'">');
}
?>
      <input name="forum" type="hidden" id="forum" value="<? echo($_GET['forum']); ?>"></td>
  </tr>
</table>
</form>