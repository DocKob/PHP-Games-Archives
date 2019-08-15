// Fonctions pour le BBcode

var clientPC = navigator.userAgent.toLowerCase(); // Get client info
var clientVer = parseInt(navigator.appVersion); // Get browser version
var is_ie = ((clientPC.indexOf("msie") != -1) && (clientPC.indexOf("opera") == -1));
var is_nav = ((clientPC.indexOf('mozilla')!=-1) && (clientPC.indexOf('spoofer')==-1)
                && (clientPC.indexOf('compatible') == -1) && (clientPC.indexOf('opera')==-1)
                && (clientPC.indexOf('webtv')==-1) && (clientPC.indexOf('hotjava')==-1));
var is_moz = 0;
var is_win = ((clientPC.indexOf("win")!=-1) || (clientPC.indexOf("16bit") != -1));
var is_mac = (clientPC.indexOf("mac")!=-1);
var timer=0;
var ptag=String.fromCharCode(5,6,7);
function  visualisation() {
t=document.formu.texte.value  
	t=code_to_html(t)
	if (document.getElementById) document.getElementById("previsualisation").innerHTML=t
	if (document.formu.auto.checked) timer=setTimeout(visualisation,1000)
}
function automatique() {
	if (document.formu.auto.checked) visualisation()
}
function code_to_html(t) {
	t=nl2khol(t)
    
	t=remplace_tag(/:oops:/g, '<img src="images/blog/smileys/redface.gif">',t)
	t=remplace_tag(/:\)/g, '<img src="images/blog/smileys/sourire2.gif">',t)
	t=remplace_tag(/8\)/g, '<img src="images/blog/smileys/lunettes.gif">',t)
	t=remplace_tag(/:P/g, '<img src="images/blog/smileys/razz.gif">',t)
	t=remplace_tag(/:colere:/g, '<img src="images/blog/smileys/colere.gif">',t)
	t=remplace_tag(/:bigcry:/g, '<img src="images/blog/smileys/crying.gif">',t)
	t=remplace_tag(/:roll:/g, '<img src="images/blog/smileys/rolleyes.gif">',t)
	t=remplace_tag(/:x/g, '<img src="images/blog/smileys/mad.gif">',t)
	t=remplace_tag(/:bigsmile:/g, '<img src="images/blog/smileys/green.gif">',t)
	t=remplace_tag(/:splif:/g, '<img src="images/blog/smileys/petard.gif">',t)
	t=remplace_tag(/:fire:/g, '<img src="images/blog/smileys/flame.gif">',t)
	t=remplace_tag(/:confus:/g, '<img src="images/blog/smileys/confus.gif">',t)
    t=remplace_tag(/:lol:/g, '<img src="images/blog/smileys/lol.gif">',t)
	t=remplace_tag(/:o/g, '<img src="images/blog/smileys/etonne.gif">',t)
	t=remplace_tag(/:surpris:/g, '<img src="images/blog/smileys/yeuxrond.gif">',t)
	t=remplace_tag(/:\(/g, '<img src="images/blog/smileys/triste.gif">',t)
	t=remplace_tag(/;\)/g, '<img src="images/blog/smileys/clin.gif">',t)
	t=remplace_tag(/:D/g, '<img src="images/blog/smileys/sourire.gif">',t)
	
// balise Gras
	t=deblaie(/(\[\/b\])/g,t)
	t=remplace_tag(/\[b\](.+)\[\/b\]/g,'<b>$1</b>',t)  
	t=remblaie(t)
// balise Italique
	t=deblaie(/(\[\/i\])/g,t)
	t=remplace_tag(/\[i\](.+)\[\/i\]/g,'<i>$1</i>',t)  
	t=remblaie(t)
// balise Underline
	t=deblaie(/(\[\/u\])/g,t)
	t=remplace_tag(/\[u\](.+)\[\/u\]/g,'<u>$1</u>',t)  
	t=remblaie(t)
// balise quote
	t=deblaie(/(\[\/quote\])/g,t)
	t=remplace_tag(/\[quote\](.+)\[\/quote\]/g,'<p class="quote">$1</p>',t)  
	t=remblaie(t)
// balise code	
	t=remplace_tag(/\[code\](.+)\[\/code\]/g,'<code>$1</code>',t)  
// balise Img
	t=deblaie(/(\[\/img\])/g,t)
	t=remplace_tag(/\[img\](.+)\[\/img\]/g,'<img src="$1"/>',t)
	t=remblaie(t)
// balise URL	
	t=remplace_tag(/\[url=([^\s<>]+)\](.+)\[\/url\]/g,'<a href="$1" target="_blank">$2</a>',t)
// balise Color	
	t=deblaie(/(\[\/color\])/g,t)
	t=remplace_tag(/\[color=(.+?)\](.+?)\[\/color\]/, '<font color=$1>$2</font>',t)
	t=remblaie(t)
	
	// balise size	
	t=deblaie(/(\[\/size\])/g,t)
	t=remplace_tag(/\[size=([+-]?[0-9])\](.+)\[\/size\]/g,'<font size="$1">$2</font>',t)
	t=remblaie(t)
	t=unkhol(t)
	t=nl2br(t)
	return t
}
function deblaie(reg,t) {
	texte=new String(t);
	return texte.replace(reg,'$1\n');
}
function remblaie(t) {
	texte=new String(t);
	return texte.replace(/\n/g,'');
}
function remplace_tag(reg,rep,t) {
	texte=new String(t);
	return texte.replace(reg,rep);
}
function nl2br(t) {
	texte=new String(t);
	return texte.replace(/\n/g,'<br/>');
}
function nl2khol(t) {
	texte=new String(t);
	return texte.replace(/\n/g,ptag);
}
function unkhol(t) {
	texte=new String(t);
	return texte.replace(new RegExp(ptag,'g'),'\n');
}
  function countInstances(open,closed) 
  { 
     var opening = document.hop.contenu.value.split(open); 
     var closing = document.hop.contenu.value.split(closed); 
     return opening.length + closing.length - 2; 
  } 

  function TAinsert(text1,text2,contenu) 
  { 

     var ta = document.getElementById(contenu); 

     if (document.selection) { 
	
        var str = document.selection.createRange().text; 
        ta.focus(); 
		  
        var sel = document.selection.createRange(); 
        if (text2!="") 
        { 
		 sel.text = text1 + sel.text + text2; 
        } 
        else 
        { 
           sel.text = sel.text + text1; 
        } 
        
     } 
     else if (ta.selectionStart | ta.selectionStart == 0) 
     { 
        if (ta.selectionEnd > ta.value.length) { ta.selectionEnd = ta.value.length; } 
       
        var firstPos = ta.selectionStart; 
        var secondPos = ta.selectionEnd+text1.length; 
       
        ta.value=ta.value.slice(0,firstPos)+text1+ta.value.slice(firstPos); 
        ta.value=ta.value.slice(0,secondPos)+text2+ta.value.slice(secondPos); 
         
        ta.selectionStart = firstPos+text1.length; 
        ta.selectionEnd = secondPos; 
        ta.focus(); 
     } 
     else 
     { // Opera 
        var sel = document.hop.contenu; 
       
        var instances = countInstances(text1,text2); 
        if (instances%2 != 0 && text2 != ""){ sel.value = sel.value + text2; } 
        else{ sel.value = sel.value + text1; } 
     }  
  }
  
 function bbfontstyle(bbopen, bbclose) {
	var txtarea = document.formu.texte;

	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (!theSelection) {
			txtarea.value += bbopen + bbclose;
			txtarea.focus();
			return;
		}
		document.selection.createRange().text = bbopen + theSelection + bbclose;
		txtarea.focus();
		return;
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, bbopen, bbclose);
		return;
	}
	else
	{
		txtarea.value += bbopen + bbclose;
		txtarea.focus();
	}
	storeCaret(txtarea);
} 

function emoticon(text) {
	var txtarea = document.formu.texte;
	text = ' ' + text + ' ';
	if (txtarea.createTextRange && txtarea.caretPos) {
		var caretPos = txtarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
		txtarea.focus();
	} else {
		txtarea.value  += text;
		txtarea.focus();
	}
}

function mozWrap(txtarea, open, close)
{
	var selLength = txtarea.textLength;
	var selStart = txtarea.selectionStart;
	var selEnd = txtarea.selectionEnd;
	if (selEnd == 1 || selEnd == 2)
		selEnd = selLength;

	var s1 = (txtarea.value).substring(0,selStart);
	var s2 = (txtarea.value).substring(selStart, selEnd)
	var s3 = (txtarea.value).substring(selEnd, selLength);
	txtarea.value = s1 + open + s2 + close + s3;
	return;
}

// Affichier la bannière en flash
function Flash(swf, hauteur, largeur, couleur, nom, mavariable) {
document.write("<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\" width=\""+hauteur+"\" height=\""+largeur+"\" id=\""+nom+"\" align=\"middle\">\n");
document.write("<param name=\"allowScriptAccess\" value=\"sameDomain\" />\n");
document.write("<param name=\"movie\" value=\""+swf+"\" /><param name=\"quality\" value=\"high\" /><param name=\"bgcolor\" value=\""+couleur+"\" /><param name=\"FlashVars\" value=\"session="+mavariable+"\" /><embed src=\""+swf+"\" FlashVars=\"session="+mavariable+"\" quality=\"high\" bgcolor=\""+couleur+"\" width=\""+hauteur+"\" height=\""+largeur+"\" name=\""+nom+"\" align=\"middle\" allowScriptAccess=\"sameDomain\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />\n");
document.write("</object>\n");
}

// Fonction pour le clignotement <blink>

go_visibility = new Array;
function goblink()
	{
	if(document.getElementById && document.all)
		{
		blink_tab = document.getElementsByTagName('blink');
		for(a=0;a<blink_tab.length;a++)
			{
			if(go_visibility[a] != "visible")
				go_visibility[a] = "visible";
			else
				go_visibility[a] = "hidden";
			blink_tab[a].style.visibility=go_visibility[a];
			}
		}
	setTimeout("goblink()", 500);
	}
window.onload = goblink;









// Fonction pour affiché le compte a rebours dans l'acceuil

function t(anz){
  v = new Date();
  n = new Date();
  o = new Date();
  for (cn = 1; cn <= anz; cn++) {
    volunites = document.getElementById(\'volunites\' + cn);
    ss = volunites.title;
    s = ss - Math.round((n.getTime() - v.getTime()) / 1000.);
    m = 0;
    h = 0;
    if (s < 0) {
      volunites.innerHTML = " - ";
    } else {
      if (s > 59) {
	m = Math.floor(s/60);
	s = s - m * 60;
      }
      if (m > 59) {
	h = Math.floor(m / 60);
	m = m - h * 60;
      }
      if (s < 10) {
	s = "0" + s;
      }
      if (m < 10) {
	m = "0" + m;
      }
      volunites.innerHTML = h + " H " + m + " Min " + s + "";
    }
    volunites.title = volunites.title - 1;
  }
  window.setTimeout("t();", 999);
}