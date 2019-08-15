{include file="overall_header.tpl"}
<script type="text/javascript">

function check(){
	if(document.message.text.value == '') {
		alert('{$mg_empty_text}');
		return false;
	} else {
		$.post('game.php?page=alliance&mode=circular&action=send&ajax=1', $('#message').serialize(), function(data){
			alert(data);
			window.close();
		});
		return true;
	}
}
</script>
    <form name="message" id="message">
      <table style="width:95%">
        <tr>
          <td colspan="2"><b><center>&nbsp;</b></center></td>
        </tr>
        <tr>
          <td><br />
            {html_options name=r options=$RangeList}
          </td>
        </tr><tr>
        <td><input class="campo_comun" type="text" name="subject" id="subject" size="40" maxlength="40" value="{$mg_no_subject}"></td>
		</tr>
        <tr>
		<td>
            <textarea name="text" cols="60" rows="10" onkeyup="$('#cntChars').text($(this).val().length);"></textarea>
		<td><b>{$al_message} (<span id="cntChars">0</span> / 5000 {$al_characters})</b></td>
          </td>
        </tr>
        <tr>
          <td colspan="2" style="text-align:center;">
            <input class="submit" type="reset" value="{$al_circular_reset}">
            <input class="submit" type="button" onClick="return check();" name="button" value="{$al_circular_send_submit}">
          </td>
        </tr>
      </table>
    </form>
{include file="overall_footer.tpl"}