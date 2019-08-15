function $id( id ) {
	return document.getElementById(id);	
}

function showHide(id) {
	if (id.style.display != 'block') id.style.display = 'block';
	else id.style.display = 'none';
}

function AddMultiField( multi, clone ){
	var newnode= $id( clone ).firstChild.cloneNode(true);
	$id( multi ).appendChild( newnode );
}

function RefreshResources(){
    var request = null;
    if(window.XMLHttpRequest){
        request = new XMLHttpRequest();
    } else if(window.ActiveXObject){
        request = new ActiveXObject("Microsoft.XMLHTTP");
    }

    request.open("GET", "index.php?ajax=getresources");

    request.onreadystatechange = function(){
        if(request.readyState==4){
            $id( "resources").innerHTML= request.responseText;
            setTimeout("RefreshResources();",60000);
        }
    }

    request.send();
}