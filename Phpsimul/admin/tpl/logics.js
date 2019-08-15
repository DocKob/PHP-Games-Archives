/**
   * Biblioth�que de fonctions logiques
   *
   * Javascript
   *
   * Fonctions utiles pour les tests
   *
   * @author: Gr�gory JUNG
   * @copyright: 2007-2008 Virtual Developpement
   * @version: 1.0
*/

// teste si la chaine est un nombre
String.prototype.isNumber = function() {
	return (!this.match(/^[0-9]+$/gi)) ? FALSE : TRUE;
}

// teste si la chaine est alphanum�rique
String.prototype.isAlphanum = function() {
	return (!this.match(/^[a-zA-Z0-9]+$/gi)) ? FALSE : TRUE;
}

// teste si la chaine est une adresse mail
String.prototype.isMail = function() {
	return (!this.match(/^([a-zA-Z0-9_\-]+\.)*[a-zA-Z0-9_\-]+\@[a-zA-Z0-9_\-]+\.\w{2,4}$/gi)) ? FALSE : TRUE;
}

// teste si une valeur � la bonne longueur
String.prototype.isGoodSize = function(mini,maxi) {
	return (this.length < mini || this.length > maxi) ? FALSE : TRUE;
}

// teste si une valeur � la bonne longueur
String.prototype.isEmpty = function() {
	return (this == "") ? TRUE : FALSE;
}

// teste si une valeur est �gale
String.prototype.isSame = function(string) {
	return (this == string) ? TRUE : FALSE;
}

// teste si le nombre est positif
Number.prototype.isPos = function() {
	return (this > 0);
}

// teste si le nombre est positif
Number.prototype.isNeg = function() {
	return (this < 0);
}

// teste si le nombre est nul
Number.prototype.isNull = function() {
	return (this == 0);
}

// teste si une valeur est dans le tableau
Array.prototype.inArray = function(value) {
	var i;
	for(i=0; i < this.length; i++) {
		if(this[i] === value) {
			return TRUE;
		}
	}
	return FALSE;
}