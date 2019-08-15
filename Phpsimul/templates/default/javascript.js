/*

Scripts JS permettant de faire fonctionner le jeu

*/

//////////////////////////////******************************************\\\\\\\\\\\\\\\
/* Fonction pour recuperer l'heure */
function HeureCheck()
{
	krucial = new Date;
	heure = krucial.getHours();
	min = krucial.getMinutes();
	sec = krucial.getSeconds();
	jour = krucial.getDate();
	mois = krucial.getMonth()+1;
	annee = krucial.getFullYear();

	if (sec < 10)
	{
		sec0 = "0";
	}
	else
	{
		sec0 = "";
	}
	
	if (min < 10)
	{
		min0 = "0";
	}
	else
	{
		min0 = "";
	}
	
	if (heure < 10)
	{
		heure0 = "0";
	}
	else
	{
		heure0 = "";
	}
	
	if (mois < 10)
	{
		mois0 = "0";
	}
	else
	{
		mois0 = "";
	}
	
	if (jour < 10)
	{
		jour0 = "0";
	}
	else
	{
		jour0 = "";
	}
	
	if (annee < 10)
	{
		annee0 = "0";
	}
	else
	{
		annee0 = "";
	}
	
	DinaDate = "" + jour0 + jour + "/" +  mois0 + mois + "/" + annee0 + annee;
	total = DinaDate
	DinaHeure = heure0 + heure + ":" + min0 + min + ":" + sec0 + sec;
	total = DinaHeure
	total = "Nous sommes le " + DinaDate + " et il est " + DinaHeure + ".";

	document.getElementById("dateheure").innerHTML = total; // On modifie ce qui est ecrit sur la page

	tempo = setTimeout("HeureCheck()", 1000) // On parametre pour permettre pour revenir dans la fonction toute les secondes
}
window.onload = HeureCheck; // On charge la fonction




//////////////////////////////******************************************\\\\\\\\\\\\\\\
/* Fonction pour modifier le temps du compte a rebours des constructions */
function construire(krucial) 
{

	heure = Math.round((krucial / 3600) - 0.5);
	min = Math.round(((krucial - (3600 * heure)) / 60) - 0.5);
	sec = Math.round(krucial - (3600 * heure) - (60 * min));

	if(sec < 0)
	{
		sec = 0;
		min = min - 1;
	}

	if(min < 0)
	{
		min = 0;
		heure = heure - 1;
	}

	if (sec < 10)
	{
		sec0 = "0";
	}
	else
	{
		sec0 = "";
	}
	
	if (min < 10)
	{
		min0 = "0";
	}
	else
	{
		min0 = "";	
	}
	
	if (heure < 10)
	{
		heure0 = "0";
	}
	else
	{
		heure0 = "";
	}
	
	DinaHeure = heure0 + heure + " H " + min0 + min + " Min " + sec0 + sec;
	total = DinaHeure

	if(heure < 0)
	{
		total = "Terminé<br><a href='" + window.location.href + "'>Continuer</a>";
	}

	document.getElementById("construction").innerHTML = total;

	krucial = krucial - 1;

	tempo = setTimeout("construire(" + krucial + ")", 1000)
}




//////////////////////////////******************************************\\\\\\\\\\\\\\\
function GetId(id) // Recupere le document ayant l'id saisi
{
	return document.getElementById(id);
}






//////////////////////////////******************************************\\\\\\\\\\\\\\\
var i=false; // La variable i nous dit si la bulle est visible ou non

function move(e) 
{
	if(i) 
	{  // Si la bulle est visible, on calcul en temps reel sa position ideale
		if (navigator.appName!="Microsoft Internet Explorer") // Si on est pas sous IE
		{ 
			GetId("curseur").style.left=e.pageX + 5+"px";
			GetId("curseur").style.top=e.pageY + 10+"px";
		}
		else // Modif proposé par TeDeum, merci à lui
		{ 
			if(document.documentElement.clientWidth>0) 
			{
				GetId("curseur").style.left=20+event.x+document.documentElement.scrollLeft+"px";
				GetId("curseur").style.top=10+event.y+document.documentElement.scrollTop+"px";
			} 
			else 
			{
				GetId("curseur").style.left=20+event.x+document.body.scrollLeft+"px";
				GetId("curseur").style.top=10+event.y+document.body.scrollTop+"px";
			}
		}
	}
}




//////////////////////////////******************************************\\\\\\\\\\\\\\\
function montre(text) 
{
	if(i==false) 
	{
		document.getElementById("curseur").style.visibility="visible"; // Si il est cacher (la verif n'est qu'une securité) on le rend visible.
		document.getElementById("curseur").innerHTML = text; // Cette fonction est a améliorer, il parait qu'elle n'est pas valide (mais elle marche)
		i=true;
	}
}






//////////////////////////////******************************************\\\\\\\\\\\\\\\
function cache() 
{
	if(i==true) 
	{
		GetId("curseur").style.visibility="hidden"; // Si la bulle etais visible on la cache
		i=false;
	}
}
document.onmousemove=move; // des que la souris bouge, on appelle la fonction move pour mettre a jour la position de la bulle.




//////////////////////////////******************************************\\\\\\\\\\\\\\\
/* fonction pour faire défiler les ressources en temps réel */
function ajouter_prod(id_champ, nombre_ressources_actuel, prod_par_heure, stockage_max)
{   
   nombre_ressources_actuel = parseFloat(nombre_ressources_actuel);
   prod_par_heure = parseFloat(prod_par_heure);
   stockage_max = parseFloat(stockage_max);
   
   if(nombre_ressources_actuel < stockage_max) // Dans le cas ou on peut produire
   {
      nombre_ressources_actuel += parseFloat( prod_par_heure / 720 ) ; // On rajoute au ressource, la prod pour 5 secondes (Le faite de diviser par 720 permet de trouver une prod pour 5 secondes)
      
      if(nombre_ressources_actuel >= stockage_max) // Dans le cas ou maintenant les ressources depasse la quantité max des silo
      {
         nombre_ressources_actuel = '<font color="red">'+stockage_max+'</font>'; // Dans ce cas on affiche la quantité max du silo, et on afiche les ressources en rouge
      }   

      document.getElementById(id_champ).innerHTML = format( Math.round(nombre_ressources_actuel) ); // On utilise format(), cette fonction se trouve dans ce fichier      

      // On recharge la fonction apres 5 secondes
      setTimeout('ajouter_prod("'+id_champ+'", "'+nombre_ressources_actuel+'", "'+prod_par_heure+'", "'+stockage_max+'")', 5000);
      
   }
   // Dans le cas ou le quantité des silo est depassé, ca ne sert a rien de continuer de demander la fonction, on arrete donc tous

} 





//////////////////////////////******************************************\\\\\\\\\\\\\\\
/*équivalent de la fonction php pour formater un nombre */
function format(x) 
{

	if (x==0) 
	{

		return x;

	} 
	else 
	{

		var str = x.toString(), n = str.length;

		if (n <4) 
		{

			return x;

		} 
		else 
		{

			return ((n % 3) ? str.substr(0, n % 3) + '.' : '') + str.substr(n % 3).match(new RegExp('[0-9]{3}', 'g')).join('.');

		}

	}

}



//////////////////////////////******************************************\\\\\\\\\\\\\\\
/* Grace a cette fonction, on peut tester certaines choses sans devoir recharger la page */
function test_champ(type, id_champ_a_tester, id_champ_de_reponse)
{

	/*
	// Le nom du fichier contenant les infos Ajax est defini lorsqu'un script veut appellé la fonction
	var fichier_ajax = '../ajax.php'; // Le fichier contenant les infos Ajax
	*/
	
	var ajax = null;

	if(window.XMLHttpRequest) // Firefox
	{
		ajax = new XMLHttpRequest();
	}
	else if(window.ActiveXObject) // Internet Explorer
	{
		ajax = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else // XMLHttpRequest non supporté par le navigateur
	{ 
		alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
		return;
	}

	var champ_test = document.getElementById(id_champ_a_tester).value; // On recupere le texte ecrit

	if(champ_test != '') // Dans le cas ou le joueur a ecrit un texte
	{
		ajax.open('GET', fichier_ajax+'?a='+type+'&b='+champ_test, true); // On ouvre le fichier permettant la recherche

		ajax.onreadystatechange = function() 
		{
			if(ajax.readyState == 4) 
			{
				var tmp = ajax.responseText; // On recupere la reponse du fichier
				document.getElementById(id_champ_de_reponse).innerHTML = tmp; // On affiche la reponse du fichier, la ou il le faut
			}
		}

		ajax.send(null);

	}
}





//////////////////////////////******************************************\\\\\\\\\\\\\\\
/* Cette fonction permet d'actualiser une image de verification*/
function actualiser_image_verif(id_image, src_image) 
{
	/*
		id_image	=> 	Contient l'id de l'image a actualiser
		src_image	=>	 Contient la nouvelle image qui va se trouver a la place
	*/
	
	// on atribue un GET au hasard a la fin de l'image a afficher, car sinon dans le cas ou l'on demande la meme image, ca ne marche pas
	var src = src_image+'?'+rand(0, 1000);
	
	document.getElementById(id_image).src = '';
	document.getElementById(id_image).src = src;
}	




//////////////////////////////******************************************\\\\\\\\\\\\\\\
/* Renvoye une valeur aleatoire comprise entre un chiffre min et un chiffre max*/
function rand( min, max ) 
{
    // http://kevin.vanzonneveld.net
    // +   original by: Leslie Hoare
    // *     example 1: rand(1, 1);
    // *     returns 1: 1

 
    if( max ) 
	{
        return Math.floor(Math.random() * (max - min + 1)) + min;
    } 
	else 
	{
        return Math.floor(Math.random() * (min + 1));
    }
}








//////////////////////////////******************************************\\\\\\\\\\\\\\\
/* Grace a cette fonction, on peut envoyer et actualiser les messages du chat */
function chat(etat)
{

	var ajax = null;

	if(window.XMLHttpRequest) // Firefox
	{
		ajax = new XMLHttpRequest();
	}
	else if(window.ActiveXObject) // Internet Explorer
	{
		ajax = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else // XMLHttpRequest non supporté par le navigateur
	{ 
		alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
		return;
	}

	if(etat = 1) // Dans ce cas le joueur a posté un message, on le traite
	{
		var type_message = document.getElementById('type').value; // On recupere le type du message (Global / Alliance)

		var message = document.getElementById('message').value; // On recupere le message
	
		ajax.open('GET', 'modules/chat.php?action=envoye_message&type='+type_message+'&message='+message, true); // On ouvre le fichier permettant la recherche

		ajax.onreadystatechange = function() 
		{
			if(ajax.readyState == 4) 
			{
				var tmp = ajax.responseText; // On recupere la reponse du fichier
				document.getElementById('messages').innerHTML = tmp; // On affiche la reponse du fichier, la ou il le faut
			}
		}
		
		document.getElementById('message').value = ''; // On efface le message puiqu'il a été envoyé
	}
	else // Dans le cas u on veut juste voir les messages
	{
			ajax.open('GET', 'modules/chat.php?action=afficher_messages', true); // On ouvre le fichier permettant la recherche

		ajax.onreadystatechange = function() 
		{
			if(ajax.readyState == 4) 
			{
				var tmp = ajax.responseText; // On recupere la reponse du fichier
				document.getElementById('messages').innerHTML = tmp; // On affiche la reponse du fichier, la ou il le faut
			}
		}
	
	}
	
	ajax.send(null);

}









//////////////////////////////******************************************\\\\\\\\\\\\\\\
/* Fonction permettant d'effectuer des calcule, grace au mod calculette */
function calc()
{ // debut fonction calc()

	var number1 = document.getElementById('number1').value; // On recupere le premier chiffre de l'operation
	var signe = document.getElementById('signe').options[document.getElementById('signe').selectedIndex].value; // On recupere le signe que le joueur a voulu utiliser
	var number2 = document.getElementById('number2').value; // On recupere le deuxieme chiffre de l'operation
	
	if(number1 == '' || number2 == '') // Dans le cas ou tous les champs n'ont pas été rempli
	{
		// On affiche un message d'erreur
		document.getElementById('rep').innerHTML = 'Merci de remplir tous les champs';
	}
	else // Dans le cas ou tous les champs sont rempli
	{ // debut else  else tous les champ sont rempli
	
		// On effectue l'operation suivant le signe
		
		if(signe == '+') // Faire une adition
		{
			var result = parseFloat(number1) + parseFloat(number2); 
		}

		else if(signe == '-') // Faire une soustraction
		{
			var result = parseFloat(number1) - parseFloat(number2) ;  
		}

		else if(signe == 'x') // Faire une multiplication
		{
			var result = parseFloat(number1) * parseFloat(number2) ;  
		}

		else if(signe == '/') // Faire une division
		{
			var result = parseFloat(number1) / parseFloat(number2); 
		}

		// On efface les champs du form
		document.getElementById('number1').value = ''; // On efface le premier nombre
		document.getElementById('signe').options[0].selected = true; // On selectionne l'option par default
		document.getElementById('number2').value = ''; // On efface le deuxieme nombre

		// On affiche le resultat du calcul
		document.getElementById('rep').innerHTML = '<br>Votre calcul etait: '+number1+' '+signe+' '+number2+'<br><br>Le resultat est: '+result+'<br><br>';
	} // fin else tous les champ sont rempli

} // fin fonction calc()












//////////////////////////////******************************************\\\\\\\\\\\\\\\
