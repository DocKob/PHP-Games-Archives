<?php

/*
Ce fichier permet de recuperer les informations demandé par ajax
*/

// On demarre SQL apres avoir inseré les fichier necessité
define('PHPSIMUL_PAGES', 'PHPSIMULLL');
include('systeme/config.php');
include('classes/sql.class.php');
$sql = new sql;
$sql->connect();


switch(@$_GET['a']) 
{
	case 'nouveau_login' : // Le joueur veut s'inscrire, ici on verifie si son login est déja pris ou pas
	
		$verif = $sql->select1('SELECT COUNT(id) FROM '.PREFIXE_TABLES.TABLE_USERS.' WHERE nom="'.strtolower($_GET['b']).'" ');
		
		if($verif <= 0) // Dans le cas ou le login n'existe pas
		{
			// On affiche un texte comme quoi, le joueur peut créer un compte avec se login
			echo '<font color="green">Vous pouvez utiliser ce login</font>';
		}
		else // Si le login existe
		{
			// On affiche un texte precisant au joueur qu'il doit changer de login
			echo '<font color="red">Ce login est d&#233;ja pris. Meri de le changer</font>';
		}
		
	break;
	
	##################################################################
	
	case 'verif_mail' : // On verifie si l'adresse mail saisi est valide, et si elle n'existe pas deja dans la base de donnée
	
		/*
		@$verifpass = explode('@', $_POST['mail']); // On regarde si l'email 
		@$verifpass2 = explode('.', $verifpass[1]);
		if (empty($verifpass[0]) || empty($verifpass2[0]) || empty($verifpass2[1])) 
		{
		$erreur .= '<font color="red" size="+2">L\'adresse e-mail est invalide</font></br>';
		}
		*/

		if(eregi('^(.+)@(.+)\.([a-zA-Z]+)$', $_GET['b']) ) // Dans le cas ou le format est correct
		{
			// On test si le mail n'est pas deja occupé
			$verif_mail = $sql->select1('SELECT COUNT(mail) FROM '.PREFIXE_TABLES.TABLE_USERS.' WHERE mail="'.$_GET['b'].'" ');
			
			if($verif_mail > 0) // Dans le cas ou le mail existe deja
			{
				echo '<font color="red">Cette adresse mail heberge deja un compte. Attention le multijoueur est interdit.</font>';
			}
			else // Dans le cas ou le mail existe pas
			{
				echo '<font color="green">L\'adresse mail est valide et disponible</font>';
			}
		}
		else // Dans le cas ou le format est incorrect
		{
			echo '<font color="red">Le format du mail est incorrect. Merci de renseigner une adresse correcte</font>';
		}
		
	break;
	
	##################################################################
	

	
}


?>