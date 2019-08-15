function get_last_version(){
    var request = null;
    if(window.XMLHttpRequest){
        request = new XMLHttpRequest();
    } else if(window.ActiveXObject){
        request = new ActiveXObject("Microsoft.XMLHTTP");
    }

    if(request){
        request.open("GET","http://rpvg.altervista.org/phpsge/frchat.php?v=1");

        request.onreadystatechange = function(){
            if(request.readyState==4){
                if( request.responseText.length >1 ) document.getElementById('laver').innerHTML = request.responseText;
                else document.getElementById('laver').innerHTML = "Failed to get";
            }
        }
        request.send();
    } else alert("Ajax Eror!");
}