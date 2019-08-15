<?php

/*

Ce programme permet de faire une installation complete du jeu

Il ne peut etre lancé que dans le cas ou il n'a jamais été lancé

*/

// On commence par regarder si ce n'est pas une tenta de hack
if(!defined('kjdazkljaklazre') || @kjdazkljaklazre != 'ofdsqkjfirqflekrù') 
{
include('../systeme/error404.php');
die();
}

// On test si un fichier de confiugration existe, si tel est le cas ou bloque l'acces
if(file_exists('systeme/config.php') )
{
header('location: index.php'); // Si un fichier existe on redirige sur l'index
}

// On demarre la session
@session_start();

// On defini le numero de la page, dans le cas ou aucune page precise n'est demandé on affiche la premiere
if (isset($_GET['page']) ) { $page = intval($_GET['page']); }
else { $page = 1; }


if ($page == 1) // Introduction
{ // debut if page 1



echo '


<!-- DEBUT AFFICHAGE PAGE 1 -->
<html>
	<head>
		<title>PHPSimul Installation</title>
	</head>
	<body bgcolor="#242424">
		<table style="border-style: none; border-color: #4B4B4B; border-width: 1px;" width="950" align="center">
			<tr>
				<td>
					<table border="0" style="border-style: none; padding-top: 5px; padding-left: 5px;" align="left">
						<tr><td><img src="install/images/Terminal.png"></td>
							<td>
								<font face="Arial" size="5" color="#0066FF">PHPSimul - Introduction</font>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table border="0" style="border-style: none; padding-top: 5px; padding-right: 5px;" align="right">
						<tr>
							<td>
								<font face="Verdana" size="3" color="#0066FF">Installation Etape '.$page.'</font>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<br />

		<table style="border-style: none; border-color: #4B4B4B; border-width: 1px;" width="80%" align="center">
			<tr>
				<td>
					<table style="border-style: dashed; border-color: #4B4B4B; border-width: 1px;" width="100" height="300">
						<tr>
							<td>
								<table border="0" style="border-style: none; border-color: #4B4B4B; border-width: 1px; padding-top: 5px; padding-right: 5px;" align="left" width="150">
									<tr>
										<td>
											<font face="Verdana" size="2" color="#DDDDDD">
													<b><font face="Arial" color="#0066FF">Introduction</font></b><br><br>
													Configuration des identifiants SQL<br><br>
													Création de la BDD<br><br>
													Créer votre compte fondateur
													<br><br>Fin
													</font>
										</td>
									</tr>
								</table>
							</td>

						</tr>
					</table>
				</td>
				<td>
					<table style="border-style: dashed; border-color: #4B4B4B; border-width: 1px;" width="80%" height="300">
						<tr>
							<td>
								<table border="0" style="padding-right: 15px; border-style: none; border-color: #4B4B4B; border-width: 1px; padding-top: 5px;" width="800"; align="left">
									<tr>
										<td>
											<font face="Verdana" size="2" color="#FFFFFF">Bienvenue dans l\'installation de PHPSimul<br>
											<br>Cet installateur vous permettra de mettre en ligne 
											<br>votre version de PHPSimul et de commencer a la configurer</font>
<br>
<br>
											<td><img src="install/images/install.ico"></td><td><a href="?page='.($page+1).'"><font color="#00FF00" face="Verdana" size="1">Passer &#224; la configuration</font></a></td>
										</td>
									</tr>
								</table>
							</td>

						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
<!-- FIN AFFICHAGE PAGE 1 -->
';


}
##########################################################################################
elseif ($page == 2) // Configuration des identifiants SQL
{ // debut elseif page=2

echo '

<!-- DEBUT AFFICHAGE PAGE 2 -->
<html>
	<head>
		<title>PHPSimul Configuration '.$page.'</title>
	</head>
	<body bgcolor="#242424">
	
	
'.( (@$_GET['error'] == 1)?'
<script>
alert("Impossible de se connecter à la base de données, recommencez !");
</script>
':'')
.'


		<table style="border-style: none; border-color: #4B4B4B; border-width: 1px;" width="950" align="center">
			<tr>
				<td>
					<table border="0" style="border-style: none; padding-top: 5px; padding-left: 5px;" align="left">
						<tr><td><img src="install/images/Terminal.png"></td>
							<td>
								<font face="Arial" size="5" color="#0066FF">PHPSimul - Configuration des identifiants SQL</font>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table border="0" style="border-style: none; padding-top: 5px; padding-right: 5px;" align="right">
						<tr>
							<td>
								<font face="Verdana" size="3" color="#0066FF">Installation Etape '.$page.'</font>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<br />

		<table style="border-style: none; border-color: #4B4B4B; border-width: 1px;" width="80%" align="center">
			<tr>
				<td>
					<table style="border-style: dashed; border-color: #4B4B4B; border-width: 1px;" width="100" height="300">
						<tr>
							<td>
								<table border="0" style="border-style: none; border-color: #4B4B4B; border-width: 1px; padding-top: 5px; padding-right: 5px;" align="left" width="150">
									<tr>
										<td>
											<font face="Verdana" size="2" color="#DDDDDD">
													Introduction<br><br>
													<b><font face="Arial" color="#0066FF">Configuration des identifiants SQL</font></b><br><br>
													Création de la BDD<br><br>
													Créer votre compte fondateur
													<br><br>Fin
													</font>
										</td>
									</tr>
								</table>
							</td>

						</tr>
					</table>
				</td>
				<td>
					<table style="border-style: dashed; border-color: #4B4B4B; border-width: 1px;" width="800" height="300">
						<tr>
							<td>
								<table border="0" style="padding-right: 15px; border-style: none; border-color: #4B4B4B; border-width: 1px; padding-top: 5px;" width="100%">
									<tr>
										<td>
											<font face="Verdana" size="2" color="#FFFFFF">Merci de remplir ces informations sur votre Base de Donn&#233;e<br>
												<form action="?page='.($page + 1).'" method="post">
													<br>
													<table>
														<tr>													<td><font face="Verdana" size="2" color="#FFFFFF">Serveur de la base de données</font></td><td>&nbsp;</td><td><input type="text" name="host" value="localhost" size="30" style=" font-size: 12px; font-family: Verdana,Helvetica; color: #CCCCCC; background-color: #444444; border-style: solid; border-top-width: 1px; border-left-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-color: #000000; padding-left: 4px; padding-right: 4px; padding-top: 2px; padding-bottom: 2px;"></td>
														</tr>
														<tr>
															<td><font face="Verdana" size="2" color="#FFFFFF">Login</font></td><td>&nbsp;</td><td><input type="text" name="login" value="root" size="30" style=" font-size: 12px; font-family: Verdana,Helvetica; color: #CCCCCC; background-color: #444444; border-style: solid; border-top-width: 1px; border-left-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-color: #000000; padding-left: 4px; padding-right: 4px; padding-top: 2px; padding-bottom: 2px;"></td>
														</tr>
														<tr>
															<td><font face="Verdana" size="2" color="#FFFFFF">Mot de passe</font></td><td>&nbsp;</td><td><input type="password" name="pass" value="" size="30" style=" font-size: 12px; font-family: Verdana,Helvetica; color: #CCCCCC; background-color: #444444; border-style: solid; border-top-width: 1px; border-left-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-color: #000000; padding-left: 4px; padding-right: 4px; padding-top: 2px; padding-bottom: 2px;"></td>
														</tr>
														<tr>
															<td><font face="Verdana" size="2" color="#FFFFFF">Nom de la base de données</font></td><td>&nbsp;</td><td><input type="text" name="database" value="" size="30" style=" font-size: 12px; font-family: Verdana,Helvetica; color: #CCCCCC; background-color: #444444; border-style: solid; border-top-width: 1px; border-left-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-color: #000000; padding-left: 4px; padding-right: 4px; padding-top: 2px; padding-bottom: 2px;"></td>
														</tr>
													</table>
													<br>
													&nbsp;<input type="submit" name="send" value="OK" style=" font-size: 12px; font-family: Verdana,Helvetica; color: #CCCCCC; background-color: #444444; border-style: solid; border-top-width: 1px; border-left-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-color: #000000; padding-left: 4px; padding-right: 4px; padding-top: 2px; padding-bottom: 2px;">
												</form>
											</font>

										</td>
									</tr>
								</table>
							</td>

						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
<!-- FIN AFFICHAGE PAGE 2 -->
';


} // fin elseif page=2
##########################################################################################
elseif ($page == 3) // Creation des bases SQL
{ // debut elseif page=3

// On recupere les données de connexion a la BDD que le joueur vient d'envoyer par formulaire
$host = $_POST['host'];
$login = $_POST['login'];
$pass = $_POST['pass'];
$database = $_POST['database'];


$connection = @mysql_connect($host, $login, $pass); // On tente une connexion

if (!$connection) // Dans le cas ou la connexion echoue
{

	header("Location: ?page=2&error=1"); // On redirige sur une erreur
	exit(); // On arrete le programme
}



$dbselect = @mysql_select_db($database); // On tente de se connecter a la BDD

if (!$dbselect) // Dans le cas ou la connexion echoue
{
	header("Location: ?page=2&error=1"); // On redirige
	exit(); // On stop le programme
}



// On ouvre le fichier class, et on installe les tables
define('PHPSIMUL_PAGES', 'PHPSIMULLL');
include('classes/sql.class.php');
$sql = new sql ;
// La connexion est effectué avant par un code mysql qui ne passe par par la classe
$sql->execbackup('install/backup_complet.sql',0); // Permet d'executer le fichier backup complet se trouvant 
																  // dans le repertoire d'installation
																  // Le 0 de la fin permet de ne pas supprimez le fichier

// On place les champ dans des sessions, pour pouvoir les reutiliser apres
$_SESSION['host'] = $_POST['host'];
$_SESSION['login'] = $_POST['login'];
$_SESSION['pass'] = $_POST['pass'];
$_SESSION['database'] = $_POST['database'];


echo '
<!-- DEBUT AFFICHAGE PAGE 3 -->
<html>
	<head>
		<title>PHPSimul Installation &#233;tape '.$page.'</title>
	</head>
	<body bgcolor="#242424">
		<table style="border-style: none; border-color: #4B4B4B; border-width: 1px;" width="950" align="center">
			<tr>
				<td>
					<table border="0" style="border-style: none; padding-top: 5px; padding-left: 5px;" align="left">
						<tr><td><img src="install/images/Terminal.png"></td>
							<td>
								<font face="Arial" size="5" color="#0066FF">PHPSimul - Création de la BDD</font>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table border="0" style="border-style: none; padding-top: 5px; padding-right: 5px;" align="right">
						<tr>
							<td>
								<font face="Verdana" size="3" color="#0066FF">Installation Etape '.$page.'</font>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<br />

		<table style="border-style: none; border-color: #4B4B4B; border-width: 1px;" width="80%" align="center">
			<tr>
				<td>
					<table style="border-style: dashed; border-color: #4B4B4B; border-width: 1px;" width="100" height="300">
						<tr>
							<td>
								<table border="0" style="border-style: none; border-color: #4B4B4B; border-width: 1px; padding-top: 5px; padding-right: 5px;" align="left" width="150">
									<tr>
										<td>
											<font face="Verdana" size="2" color="#DDDDDD">
													Introduction<br><br>
													Configuration des identifiants SQL<br><br>
													<b><font face="Arial" color="#0066FF">Création de la BDD</font></b><br><br>
													Créer votre compte fondateur
													<br><br>Fin
													</font>
										</td>
									</tr>
								</table>
							</td>

						</tr>
					</table>
				</td>
				<td>
					<table style="border-style: dashed; border-color: #4B4B4B; border-width: 1px;" width="800" height="300">
						<tr>
							<td>
								<table border="0" style="padding-right: 15px; border-style: none; border-color: #4B4B4B; border-width: 1px; padding-top: 5px;" width="100%">
									<tr>
										<td>
											<font face="Verdana" size="2" color="#FFFFFF">
												La base de donn&#233;e a bien &#233;t&#233; install&#233;e !<br><br>
												<td><img src="install/images/install.ico"></td><td><a href="?page='.($page + 1).'"><font color="#00FF00" face="Verdana" size="1">Passer &#224; l\'&#233;tape suivante</font></a></td>

											</font>

										</td>
									</tr>
								</table>
							</td>

						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>

<!-- FIN AFFICHAGE PAGE 3 -->
';

} // fin elseif page=3
##########################################################################################
elseif ($page == 4) // Créer un compte fondateur
{ // debut elseif page=4


echo '


<!-- DEBUT AFFICHAGE PAGE 4 -->

'.
( (@$_GET['error'] == 4)?'
<script>
alert("Merci de remplir toutes les informations !");
</script>
':'')
.
( (@$_GET['error'] == 5)?'
<script>
alert("Les mots de passe ne correspondent pas, recommencez !");
</script>
':'')
.'

<html>
	<head>
		<title>PHPSimul Installation &#233;tape '.$page.'</title>
	</head>
	<body bgcolor="#242424">
		<table style="border-style: none; border-color: #4B4B4B; border-width: 1px;" width="950" align="center">
			<tr>
				<td>
					<table border="0" style="border-style: none; padding-top: 5px; padding-left: 5px;" align="left">
						<tr><td><img src="install/images/Terminal.png"></td>
							<td>
								<font face="Arial" size="5" color="#0066FF">PHPSimul - Créer votre compte fondateur</font>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table border="0" style="border-style: none; padding-top: 5px; padding-right: 5px;" align="right">
						<tr>
							<td>
								<font face="Verdana" size="3" color="#0066FF">Installation Etape '.$page.'</font>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<br />

		<table style="border-style: none; border-color: #4B4B4B; border-width: 1px;" width="80%" align="center">
			<tr>
				<td>
					<table style="border-style: dashed; border-color: #4B4B4B; border-width: 1px;" width="100" height="300">
						<tr>
							<td>
								<table border="0" style="border-style: none; border-color: #4B4B4B; border-width: 1px; padding-top: 5px; padding-right: 5px;" align="left" width="150">
									<tr>
										<td>
											<font face="Verdana" size="2" color="#DDDDDD">
													Introduction<br><br>
													Configuration des identifiants SQL<br><br>
													Création de la BDD<br><br>
													<b><font face="Arial" color="#0066FF">Créer votre compte fondateur</font></b>
													<br><br>Fin
													</font>
										</td>
									</tr>
								</table>
							</td>

						</tr>
					</table>
				</td>
				<td>
					<table style="border-style: dashed; border-color: #4B4B4B; border-width: 1px;" width="800" height="300">
						<tr>
							<td>
								<table border="0" style="padding-right: 15px; border-style: none; border-color: #4B4B4B; border-width: 1px; padding-top: 5px;" width="100%">
									<tr>
										<td>
											<font face="Verdana" size="2" color="#FFFFFF">
												L\'installation de la base de données est termin&#233;e
												<br>
												<br>
												<form name="creation_admin" action="?page=5" method="post">
												Nous allons maintenant créer le compte fondateur (Permet d\'administrer entierement le jeu) 
												<br>
												<br>
												<style>.table { color: #ffffff; }</style>
												<table class="table">
												<tr><td>Votre nom d\'utilisateur :</td><td><input type="text" size="25" name="login_admin"></td></tr>
												<tr><td>Votre mailto :</td><td><input type="text" size="25" name="mailto"></td></tr>
												<tr><td>Votre mot de passe :</td><td><input type="password" size="25" name="pass1_admin"></td></tr>
												<tr><td>Confirmation :</td><td><input type="password" size="25" name="pass2_admin"></td></tr>
												<tr><td colspan="2" align="center"><input type="submit" name="creation_admin_submit"></td></tr>
												</table>
												</font>



											</font>

										</td>
									</tr>
								</table>
							</td>

						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>

<!-- FIN AFFICHAGE PAGE 4 -->
';


} // fin elseif page=4
##########################################################################################
elseif ($page == 5) // Fin creation de la session et ouverture du jeu
{ // debut elseif page=5

// On crée le compte joueur et administrateur

// Dans le cas ou le formulaire na pas été rempli en entier
if(empty($_POST['login_admin']) || empty($_POST['pass1_admin']) || empty($_POST['pass2_admin']) || empty($_POST['mailto']) )
{
	header("Location: ?page=4&error=4"); // On redirige
	exit(); // On stop le programme
}

// Dans le cas ou les deux pass ne correspondent pas
if($_POST['pass1_admin'] != $_POST['pass2_admin'] )
{
	header("Location: ?page=4&error=5"); // On redirige
	exit(); // On stop le programme
}

 
##############################################################
/* On ouvre le fichier class, et on demarre la connexion et la classe SQL */
define('PHPSIMUL_PAGES', 'PHPSIMULLL');
include('classes/sql.class.php');
$sql = new sql ;

// On se connecte a SQL grace au session qu'on avait enregistrer
mysql_connect($_SESSION['host'], $_SESSION['login'], $_SESSION['pass']);
mysql_select_db($_SESSION['database']);

// On crée le joueur
$sql->update('INSERT INTO phpsim_users SET 
														nom="'.$_POST['login_admin'].'", 
														pass="'.md5($_POST['pass1_admin']).'", 
														mail="'.$_POST['mailto'].'",
														onlinetime="0000-00-00",
														valide="1",
														recherches="0,0,0,0,0,0",
														template="default",
														race="1"
				');
														
// on crée le compte administrateur
$sql->update('INSERT INTO phpsim_staff SET 
														nom="'.$_POST['login_admin'].'", 
														pass="'.md5($_POST['pass1_admin']).'", 
														fondateur="1",
														administrateur="1",
														moderateur="1",
														idjoueur="Fondateur du jeu"
				');



##############################################################
### On créer et on rempli le fichier de configuration

$dz = fopen("systeme/config.php", "w"); // On créer le fichier config et on l'ouvre en ecriture

if (!$dz) // Dans le cas ou sa echoue, on est sur un serveur ou faut faire un chmod, alors on renvoye sur une erreur
{
	header("Location: ?page=2&error=2"); // On redirige sur le code de l'erreur
	exit(); // On arrete l'execution du programme

}

// Informations de configurations SQL:

$host = $_SESSION['host'];
$user = $_SESSION['login'];
$pass = $_SESSION['pass'];
$database = $_SESSION['database'];


$fichier_config = "

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



Configuration des constantes du jeu

*/

// DEBUT CONFIGURATION CONNEXION SQL
	define('BDD_HOST', '".$host."'); // Host du serveur MySQL
	define('BDD_USER', '".$user."'); // Nom d'utilisateur pour acceder a MySQL
	define('BDD_PASS', '".$pass."'); // Mot de passe pour MySQL
	define('BDD_NOM', '".$database."'); // Nom de la base de données
// FIN CONFIGURATION CONNEXION SQL


// DEBUT CONFIGURATION TABLES - Ne pas toucher cette partie, vous planterez le jeu
	define('PREFIXE_TABLES', 'phpsim_'); // Prefixe pour la base de données

	define('TABLE_CONFIG', 'config'); // Configuration  Generale

	define('TABLE_USERS', 'users'); //  Joueurs
	define('TABLE_STAFF', 'staff'); //  Base des membres du Staff
	define('TABLE_BASES', 'bases'); // Base des joueurs

	define('TABLE_MENU', 'menu'); // Configuration Menu
	define('TABLE_RESSOURCES', 'ressources'); // Configuration Ressources

	define('TABLE_ALLIANCES', 'alliance'); // Alliances
	define('TABLE_ALLIANCES_CANDIDATURES', 'allicand'); // Candidatures postées
	define('TABLE_RANGS', 'rangs'); // Gestion des rangs a l'interieurs des alliances

	define('TABLE_BATIMENTS', 'batiments'); // Configuration Batiments
	define('TABLE_CHANTIER', 'chantier'); // Configuration Flottes
	define('TABLE_DEFENSES', 'defenses'); // Configuration Defenses
	define('TABLE_RECHERCHES', 'recherches'); // Configuration Recherches

	define('TABLE_AGENDA', 'agenda'); // Agenda Administration

	define('TABLE_MESSAGERIE', 'messagerie'); // Les messages des membres
	define('TABLE_CHAT', 'chat'); // La table des Chat
	define('TABLE_CONTACT', 'contact_admin'); // Les messages posté dans le formulaire de conecta admin
	define('TABLE_LIVREOR', 'livror'); // Le livre d'or

	define('TABLE_FORUMS', 'forums'); // Liste Forums
	define('TABLE_DISCUSSIONS', 'discussions'); // Les discussions dans les differents forum
	define('TABLE_POSTS', 'post'); // Les posts dans les differente discussion

	define('TABLE_SCREENS', 'screens'); // Configuration Screens
	define('TABLE_NEWS', 'news'); // Configurations News
	define('TABLE_MUSIQUE', 'musique'); // Configuration Musique

	define('TABLE_AMIS', 'listeamis'); // Gestion des amis de chaque joueurs
	define('TABLE_NOTES', 'note'); // Notes ecrite par les joueurs

	define('TABLE_UNITES', 'unites'); //  Les flottes en vol
// FIN CONFIGURATION TABLES - Ne pas toucher cette partie, vous planterez le jeu


// Definition des variables utile pour le jeu
define('CODE_CONNEXION_ADMIN', 'phpsimul'); // Lorsqu'un joueur se connecte sur l'administration mais qu'il n'est pas connecté sur le jeu, ce code lui est demander
define('TEMPS_PENDANT_LEQUEL_ON_EST_ACTIF', '120'); // Defini combien de temps un joueur est defini comme actif - En secondes


// Les options pour les allopass
".'$allopass = array('."
					// Augmentation du facteur de production
					'facteur_production' => array(
								'pourcent_facteur_en_plus' => '30', // Le %age de plus au facteur
								'temps_dispo' => '604800', // Dispo 7 Jours
								'points' => '100', // Point allopass a avoir pour l'acheter
								                 ),
					// Offrande de ressources
					'offre_ressources' => array(
								'ressources_offertes' => array('5', '5'), // Les ressources offertes
								'points' => '500', // Les points pour acheter
											   ),
				 );


?>

";


// On rempli le fichier
// Attention a pas sauté d eligne entre les " sinon ca afficherai du HTMl et planterai la page
fwrite($dz, $fichier_config);

//FIN de l'ecriture du fichier

fclose($dz); // On referme le fichier

##############################################################

echo '
<!-- DEBUT AFFICHAGE PAGE 5 -->

<html>
	<head>
		<title>PHPSimul Installation &#233;tape '.$page.'</title>
	</head>
	<body bgcolor="#242424">
		<table style="border-style: none; border-color: #4B4B4B; border-width: 1px;" width="950" align="center">
			<tr>
				<td>
					<table border="0" style="border-style: none; padding-top: 5px; padding-left: 5px;" align="left">
						<tr><td><img src="install/images/Terminal.png"></td>
							<td>
								<font face="Arial" size="5" color="#0066FF">PHPSimul - Finalisation</font>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table border="0" style="border-style: none; padding-top: 5px; padding-right: 5px;" align="right">
						<tr>
							<td>
								<font face="Verdana" size="3" color="#0066FF">Installation Etape '.$page.'</font>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<br />

		<table style="border-style: none; border-color: #4B4B4B; border-width: 1px;" width="80%" align="center">
			<tr>
				<td>
					<table style="border-style: dashed; border-color: #4B4B4B; border-width: 1px;" width="100" height="300">
						<tr>
							<td>
								<table border="0" style="border-style: none; border-color: #4B4B4B; border-width: 1px; padding-top: 5px; padding-right: 5px;" align="left" width="150">
									<tr>
										<td>
											<font face="Verdana" size="2" color="#DDDDDD">
													Introduction<br><br>
													Configuration des identifiants SQL<br><br>
													Création de la BDD<br><br>
													Créer votre compte fondateur
													<br><br><b><font face="Arial" color="#0066FF">Fin</font></b>
													</font>
										</td>
									</tr>
								</table>
							</td>

						</tr>
					</table>
				</td>
				<td>
					<table style="border-style: dashed; border-color: #4B4B4B; border-width: 1px;" width="800" height="300">
						<tr>
							<td>
								<table border="0" style="padding-right: 15px; border-style: none; border-color: #4B4B4B; border-width: 1px; padding-top: 5px;" width="100%">
									<tr>
										<td>
											<font face="Verdana" size="2" color="#FFFFFF">
												<img src="install/images/fin.png">
												<br>
												<br>
												L\'installation de la base de données est termin&#233;e
												<br>
												<br>
												L\'installation du jeu est enfin terminé
												<br>
												<br>
												Pour vous rendre immediatemment sur le jeu, cliquez sur le lien suivant:
												<br>
												<br>
												<a href="?page='.$page.'">En route vers le jeu</a>
										
											</font>

										</td>
									</tr>
								</table>
							</td>

						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>

<!-- FIN AFFICHAGE PAGE 5 -->
';


} // fin elseif page=5
##########################################################################################
elseif ($page == 6) // Si le joueur a cliquez pour se rendre immediatement sur le jeu
 						  // On créer une session et on redirige
{ // debut elseif page=6

@session_start(); // On demarre la session
$_SESSION['idjoueur'] = '1'; // On créer la session
header('location : index.html'); // On redirige sur le jeu


} // fin elseif page=6
##########################################################################################
else // debut else dans le cas ou aucune page n'est defini 
{
	header('location: index.php'); // On redirige dans le cas ou aucune page n'est demandé
	exit(); // On stop l'execution du programme
}




?>