function goto(url) {
	document.location = url;
}

function post(formulaire,hdd,val) {
	document.getElementById(hdd).value = val;
	document.getElementById(formulaire).submit();
}