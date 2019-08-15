function ReBuildView() {
		var HTML     = '<div id="menu_flotas">';
			HTML    += '<div id="lista_misiones">';
        $.each(data.build, function(index, val) {
                if (index == 0) {
						HTML    += '<div class="misiones_top"></div>';
						HTML    += '<div class="misiones">';
						HTML    += '<center>';
						HTML    += '<img src="styles/theme/'+data.raza_skin+'/gebaeude/'+val.element+'.png" width="140" height="140" />';
						HTML    += '<b>'+val.name+'<br />'+data.nivel+' '+val.level+' '+(val.planet != '' ? ' @ '+val.planet : '')+'</b><div id="progressbar"></div>';
						HTML    += '<div id="blc"><a href="game.php?page=buildings&mode=research&amp;cmd=cancel"><div class="cancelar_c"><span>'+data.bd_cancel+'</span></div></a></div>';
						HTML    += '</center>';
						HTML    += '</div>';
						HTML    += '<div class="misiones_footer"></div>';
                } else {
						HTML    += '<div class="misiones_top"></div>';
						HTML    += '<div class="misiones"><div class="encola_ajust_c">';
						HTML    += '<img class="tooltip" name="'+val.name+'" src="styles/theme/'+data.raza_skin+'/gebaeude/'+val.element+'.png" width="40" height="40" /><span class="encola_c">'+data.nivel+' '+val.level+'</span> ';
                        HTML    += '<a href="game.php?page=buildings&mode=research&amp;cmd=remove&amp;listid='+(index+1)+'"><div class="cancelar_c_small"></div></a>';
						HTML    += '</div>';
						HTML    += '</div>';
						HTML    += '<div class="misiones_footer"></div>';
                }
        });
       	HTML    += '</div>';
		HTML    += '</div>';
        $('#buildlist').html(HTML).fadeIn("fast");
        $('#progressbar').progressbar({value: ((data.build[0].time != 0) ? 100 - ((data.build[0].endtime - (serverTime.getTime() / 1000) + ServerTimezoneOffset) / data.build[0].time) * 100 :100)});
        $('.ui-progressbar-value').addClass('ui-corner-right').animate({width: "100%" }, data.build[0].endtime * 1000 - serverTime.getTime() + ServerTimezoneOffset * 1000, "linear");
        return true;
}

function Techlist() {
        var h           = 0;
        var     m               = 0;
        var s           = (data.build[0].endtime - (serverTime.getTime() / 1000) + ServerTimezoneOffset);
        
        if ( s <= 0 ) {
                if(data.build.length == 1){
                        $('#blc').html(Ready + '<br><a href=?page=build>'+data.bd_continue+'</a>');
                        document.title  = Ready + ' - ' + Gamename;
                        window.setTimeout("window.location.href = 'game.php?page=buildings&mode=research'", 1000);
                        return true;
                } else if(data.build[0].reload === true){
                        window.location.href = 'game.php?page=buildings&mode=research';
                        return true;
                } else {
                        data.build.shift();
                        $('#buildlist').fadeOut("fast");
                        ReBuildView();
                        s       = (data.build[0].endtime - (serverTime.getTime() / 1000) + ServerTimezoneOffset);
                }
        }
        
        var time        = GetRestTimeFormat(s);
        
        $('#blc').html(time + '<br><a href="game.php?page=buildings&mode=research&amp;cmd=cancel"><div class="cancelar_c"><span>'+data.bd_cancel+'</span></div></a>');
        document.title  = time + ' - ' + data.build[0].name + ' - ' + Gamename;
        window.setTimeout('Techlist();', 1000);
}
