<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="{$lang}">
<head>
<title>{$bu_request_message}</title>
{if $goto}
<meta http-equiv="refresh" content="{$gotoinsec};URL={$goto}" />
{/if}
<meta http-equiv="content-language" content="{$lang}" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta name="robots" content="index, follow" />
<link rel="stylesheet" type="text/css" href="./styles/css/jquery.css" />
<link rel="stylesheet" type="text/css" href="./styles/theme/{$Raza_skin}/formato.css" />
<link rel="icon" href="favicon.ico" />
</head>
<script type="text/javascript">

function check(){
	if(document.buddy.text.value == '') {
		alert('{$mg_empty_text}');
		return false;
	} else {
		$.post('game.php?page=buddy&mode=1&sm=3&u={$id}&ajax=1', $('#buddy').serialize(), function(data){
			alert(data);
			window.close();
		});
		return true;
	}
}
</script> 
<form name="buddy" id="buddy">
    <table style="width:95%">
    <tr><br /><br />
   
    </tr><tr>
        <td>{$bu_player}</td>
        <td>{$username}</td>
    </tr><tr>
        <td>{$bu_request_text}(<span id="cntChars">0</span> / 5000 {$bu_characters})</td>
        <td><textarea name="text" id="text" cols="40" rows="10" size="100" onkeyup="$('#cntChars').text($(this).val().length);"></textarea></td>
    </tr><tr>
        <td colspan="2"><input class="submit" type="button" onClick="return check();" name="button" value="{$bu_send}"></td>
	</tr>
</table>
</form>
{include file="overall_footer.tpl"}