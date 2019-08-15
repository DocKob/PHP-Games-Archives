LocalizationStrings = new Array();
LocalizationStrings.timeunits = new Array();
LocalizationStrings.timeunits.short = new Array();
LocalizationStrings.timeunits.short.day = 't';
LocalizationStrings.timeunits.short.hour = 'h';
LocalizationStrings.timeunits.short.minute = 'm';
LocalizationStrings.timeunits.short.second = 's';
LocalizationStrings.status = new Array();

LocalizationStrings.decimalPoint = ",";
LocalizationStrings.thousandSeperator = ".";
LocalizationStrings.unitMega = 'M';
LocalizationStrings.unitKilo = 'K';
LocalizationStrings.unitMilliard = 'Mrd';

function OpenPopup(target_url, win_name, width, height) {
	var new_win = window.open(target_url+'&ajax=1', win_name, 'scrollbars=yes,statusbar=no,toolbar=no,location=no,directories=no,resizable=no,menubar=no,width='+width+',height='+height+',screenX='+((screen.width-width) / 2)+",screenY="+((screen.height-height) / 2)+",top="+((screen.height-height) / 2)+",left="+((screen.width-width) / 2));
	new_win.focus();
}

function allydiplo(action, id, level) {
	if(id != '0')
		var vid = "&id="+id;
	else
		var vid = "";
				
	if(level != '0')
		var vlevel = "&level="+level;
	else
		var vlevel = "";
		
    OpenPopup("game.php?page=alliance&mode=admin&edit=diplo&action="+action+vid+vlevel+"&ajax=1", "diplo", 720, 300);
}
 