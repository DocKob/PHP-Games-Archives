<?php

// Si la constante n'est pas defini on bloque l'execution du fichier
if(!defined('PHPSIMUL_PAGES') || @PHPSIMUL_PAGES != 'PHPSIMULLL') 
{
die('Erreur 404 - Le fichier n\'a pas été trouvé');
}

/* PHPsimul : Créez votre jeu de simulation en PHP
Copyright (©) - 2007 - CAPARROS Sébastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr


Systeme de login demandant le login du joueur pour se loguer sur le systeme administrateur/moderateur
Les données se trouve dans la table phpsim_staff

L'admin ou le modo se connectant d'ici doit posseder en plus des identifiant de connexion un code de connexion dans le cas ou il n'est pas logué sur le jeu pour securisé encore plus le truc
Le code de connexion est defini dans le fichier de configuration (systeme/config.php)

Des que l'admin / modo est connecté, alors son id s'enregistre dans une session, ce qui permet de savoir que l'admin / modo est connecté

*/




###############################################################################################################
// Si le joueur a deja envoyer le formulaire on le renvoye ici pour tester ses identifiants
if(isset($_POST['connexion']) && $_POST['connexion'] == 'connexion')
{ // debut if isset post connexion

	// On commence directement en cherchant dans le SQL si le joueur existe et si le mot de pass est correct

	$interrogation = $sql->select('SELECT COUNT(id) as count,id FROM '.PREFIXE_TABLES.TABLE_STAFF.' 
	         					  WHERE (administrateur="1" or fondateur="1" or moderateur="1") and
	         					  nom="'.$_POST['login_nom'].'" and pass="'.md5($_POST['pass']).'"
	         					  GROUP BY id
	         				   ');

	$demande = $interrogation['count'];
	$idadmin = $interrogation['id'];


	if($demande == 1) // Si une ligne est renvoyé, le joueur existe bien on le logue
	{ // DEBUT if $demande

		// On verifie si le joueur est deja connecté dans le jeu, si tel est le cas alors le code de connexion est inutile, si ce n'est pas le cas alors il faut a tous pris le code de connexion
		if(isset($_SESSION['idjoueur']) ) // Dans ce cas il a le droit de se logué
		{ // debut if session jeu ouverte
			$onpeutconnecter = 1; // Créer la variable pour activer la connexion
		} // fin if session jeu ouverte

		#####

		else // Dans le cas ou faut le code de connexion
		{ // debut else code de connexion requis

			if($_POST['codecon'] == CODE_CONNEXION_ADMIN) // Si le code est valide
			{ // debut if code valide
				$onpeutconnecter = 1; // Créer la variable pour activer la connexion
			} //fin if code valide
			// Dans le cas ou le code est invalide on reaffiche le formulaire sans rien preciser

		} // fin else code de connexion requis


		// Code de connexion
		if(isset($onpeutconnecter) && @$onpeutconnecter == 1) // Si c'est le cas alors la variable est defini et vaut 1
		{
			$_SESSION['idadmin12345678900'] = $idadmin; // on defini la session
			$sql->update('UPDATE '.PREFIXE_TABLES.TABLE_STAFF.' SET ip="'.$_SERVER['REMOTE_ADDR'].'", time="'.time().'" WHERE id="'.$idadmin.'" '); // On save les infos de connexion du joueur
			
			// On enregsitre les connexion a l'administration
			$txt = "<font color='blue'>".$sql->select1('SELECT nom FROM '.PREFIXE_TABLES.TABLE_STAFF.' WHERE id="'.$idadmin.'" ')." <font color='green'>{<a href='index.php?mod=multicompte&action=voir&ip=
				   ".$_SERVER['REMOTE_ADDR']."'>".$_SERVER['REMOTE_ADDR']."</a>} le ".date("d/m/y")." à ".date("H:i:s")."<br></font>";
			$fp = fopen("admin/acces.txt", "a"); // Ou onuvre le fichier
			fputs($fp, $txt); // On enregistre la ligne dans le fichier
			fclose($fp); // On ferme le fichier
			
			header('location: admin.php'); // On redirige sur l'index de l'administration
			die(); // On stoppe le programme
		}
	} // FIN if $demande
	#####################



	// Si aucune ligne est renvoyer, alors le joueur n'existe pas on ne fait aucune action ce qui reaffiche le formulaire
} // fin if isset post connexion



###############################################################################################################
// Si le joueur n'est pas encore connecté, on lui montre le formulaire de connexion

?>


<html>
<head>
	<title>Acces Staff</title>
</head>
<body>
<center>
<table align='center' height='100%' width='100%' valign='center'>
<tr><td align='center' height='100%' width='100%' valign='center'>

<font color='blue' size='+3'>Bienvenue au membres du Staff</font>
<br>
<br><font color='red' size='+2'>Identifiez vous pour acceder au panneau d'administration</font>
<br>
<br>
<form name='loginacces' action='' method='post'>
<input type='hidden' name='connexion' value='connexion'>
<table>
	<tr>
		<td>Nom d'utilisateur :</td><td><input type='text' name='login_nom' value=''></td>
	</tr>
	<tr>
		<td>Mot de passe :</td><td><input type='password' name='pass' value=''></td>
	</tr>
	<tr>
		<td>Code de connexion :</td><td><input type='password' name='codecon' value=''></td>
	</tr>
	<tr>
		<td colspan='2' align='center'><br><input type='submit' value='Connexion'></td>
	</tr>
</table>


</td></tr></table>
</form>
</center>
</body>
</html>