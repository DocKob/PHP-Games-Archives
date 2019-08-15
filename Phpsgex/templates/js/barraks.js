function t() {
	v           = new Date();
	var blc     = document.getElementById('blc');
	var timeout = 1;
	n           = new Date();
	ss          = pp;
	aa          = Math.round( (n.getTime() - v.getTime() ) / 1000. );
	s           = ss - aa;
	m           = 0;
	h           = 0;

	if ( (ss + 3) < aa ) {
		blc.innerHTML = "Finished!<br>" + "<a href=?pg=barraks&city=" + pl + ">Continue</a>";
		if ((ss + 6) >= aa) {
			window.setTimeout('document.location.href="?pg=barraks&city=' + pl + '";', 3500);
		}
	} else {
		if ( s < 0 ) {
			if (1) {
				blc.innerHTML = "Finished!<br>" + "<a href=?pg=barraks&city=" + pl + ">Continue</a>";
				window.setTimeout('document.location.href="?pg=barraks&city=' + pl + '";', 2000);
			} else {
				timeout = 0;
				blc.innerHTML = "Finished!<br>" + "<a href=?pg=barraks&city=" + pl + ">Continue</a>";
			}
		} else {
			if ( s > 59) {
				m = Math.floor( s / 60);
				s = s - m * 60;
			}
			if ( m > 59) {
				h = Math.floor( m / 60);
				m = m - h * 60;
			}
			if ( s < 10 ) {
				s = "0" + s;
			}
			if ( m < 10 ) {
				m = "0" + m;
			}
			if (1) {
				blc.innerHTML = h + ":" + m + ":" + s + "<br><a href=?pg=barraks&listid=" + pk + "&cmd=" + pm + "&city=" + pl + ">Cancel</a>";
			} else {
				blc.innerHTML = h + ":" + m + ":" + s + "<br><a href=?pg=barraks&listid=" + pk + "&cmd=" + pm + "&city=" + pl + ">Cancel</a>";
			}
		}
		pp = pp - 1;
		if (timeout == 1) {
			window.setTimeout("t();", 999);
		}
	}
}

// unt control funcions
function maxuq(fd,mxu){
	if( document.getElementById(fd).value > mxu ){ document.getElementById(fd).value=mxu; }
}
