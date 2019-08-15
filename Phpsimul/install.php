<?php

/*

Créer pour PHPSimul par Max485

Fichier permettant l'installation des mise a jour ou d'une version complete, il est appellé par index.php 
lorsque un fichier backup.sql existe que aucun fichier de configuration n'a été trouvé

Dans le cas d'une mise a jour:
Ce fichier lit le contenu du fichier backup.sql pour ajouté ces données dans la Base de Données SQL

Dans le cas d'une install complete:
Ce fichier renvoye sur install/install.install.php qui lui gere la creation complete du jeu

*/

#########################################################################################################################
#########################################################################################################################
#########################################################################################################################
#########################################################################################################################
#########################################################################################################################


// Si le fichier de configuration n'existe pas on inclue le fichier d'install complete
if (!file_exists('systeme/config.php') ) 
{
	define('kjdazkljaklazre', 'ofdsqkjfirqflekrù'); // on defini une variable permettant de bloquer l'acces direct au fichier
	include('install/install.php'); // On inclue le fichier
	exit(); // On stop le programme
}




if(isset($_GET["a"]) ) // On regarde si get mod contient quelque chose, 
{
    $a = explode("|", $_GET["a"]); // on extrait les mod si il n'est pas vide
} 
else // il contient rien alors $mod contient rien
{
    $a[0] = "";
}
// On teste si le fichier backup est bien present, sinon on change la valeur de $a[0] pour ne pas allé plus loin
if (!file_exists("backup.sql") && !file_exists("backup.php") ) // si le fichier n'existe pas
{
	$a[0] = "not_exists"; // on defini $a[0] a not_exists pour affichez le if en cas de non existance du fichier
}
#########################################################################################################################
if($a[0] == "not_exists" ) // Si le fichier n'existe pas on vient ici est on bloque toutes action possible
{
	echo "
			<center><br>
			<h1><u><font color='8B008B'>Bienvenue dans l'installation des Mise A Jour de PHPSimul</font></u></h1>
			<br>
			<h2>Aucun fichiers <font color='FF1493'>backup.sql</font> & <font color='FF1493'>backup.php</font> n'a été trouvé. Il n'y a donc aucune MAJs a réaliser
			<br>
			<style>.lien_install { text-decoration: none ; }</style>
			<br><a class='lien_install' href='index.php'><font color='191970'>Se rendre dans le jeu</font></a>
			</h3>
			</center>
		 ";
}
#########################################################################################################################
elseif($a[0] == "" )
{
	echo "
			<center><br>
			<h1><u><font color='8B008B'>Bienvenue dans l'installation des Mise A Jour de PHPSimul</font></u></h1>
			<br>
			<h2>Un fichier <font color='FF1493'>backup.sql</font> a été trouvé, il contient les tables SQL permettant de faire fonctionner les MAJs 
			<br>(Si un fichier backup.php existe egalement, il sera executé en même temps)
			<br>
			Veuillez executé le fichier pour pouvoir continuer</h2>
			<h3><a class='lien_install' href='install.php?a=installation'><font color='191970'>Executer le fichier (Ce qui installera les MAJs)</font></a>
			<br>
			<style>.lien_install { text-decoration: none ; }</style>
			<br><a class='lien_install' href='install.php?a=contenufichier'><font color='191970'>Voir le contenu du fichier backup.sql</font></a>
			<br><br><br><br><br><style>.lien_install1 { text-decoration: overline underline ; }</style>
			<a class='lien_install1' href='?a=aidedev'><font size='-1' color='191970'>Aide au devloppeurs pour la conception du fichier backup.sql</font></a></h3>
			</center>
		 ";

}
#########################################################################################################################
elseif($a[0] == "installation") // si le perso a demandé une installation ont arrive ici
{
	define('PHPSIMUL_PAGES', 'PHPSIMULLL');
	include('systeme/config.php') ;
	mysql_connect(BDD_HOST, BDD_USER, BDD_PASS);
	mysql_select_db(BDD_NOM);	
	
	if (file_exists('backup.php') ) // Dans le cas ou un fichier de backup format php a été trouvé, on l'execute
	{
		include('backup.php'); // On ouvre le fichier
		unlink("backup.php"); // On supprime le fichier apres son execution
	}

	$requetes="";
	 
	$fichier_sql = file("backup.sql"); // on charge le fichier SQL
	foreach($fichier_sql as $l) // on le lit
	{ 
		if (substr(trim($l),0,2)!="--") // suppression des commentaires
		{ 
			$requetes .= $l;
		}
	}

	$reqs = split(";",$requetes);// on sépare les requêtes
	foreach($reqs as $req) // et on les éxécute
	{	
		if (!mysql_query($req) && trim($req)!="")
		{
		    // Si une erreur est produite, on stoppe l'execution et on parle de l'erreur
			die("
					<br><center><h1>Une erreur s'est produite au niveau de la requete :</h1>
					<h2><font color='FF0000'> ".$req."</font></h2>
					<br><h1>Erreur retournée par le serveur MySQL :</h1>
					<h2><font color='FF0000'> ".mysql_error()."</font></h2>
					<br><h3><font color='0000FF'>Merci de réessayer l'installation et de prendre en compte l'erreur retournée par MySQL</font></h3>
					<style>.lien_install { text-decoration: none ; }</style><br><br>
					<h3><a class='lien_install' href='install.php'><font color='191970'>Retour sur la page d'accueil</font></a>
	            "); 
		}
	}

	unlink("backup.sql") ;

	echo "
			<center><br>
			<h1><u><font color='8B008B'>Installation des MAJs</font></u></h1>
			<br>
			<h2>L'installation a été effectué avec succès
			<br>
			Si le fichier backup.sql n'est pas supprimé automatiquement, veuillez le supprimez vous même
			<br>
			<style>.lien_install { text-decoration: none ; }</style><br><br>
			<a class='lien_install' href='index.php'><font color='191970'>En direction du jeu ...</font></a>

			</h2>
		 ";
}
#########################################################################################################################
elseif($a[0] == "contenufichier") // si la personne a demandé a voir le contenu ont arrive ici
{
	echo "
			<center><br>
			<h1><u><font color='8B008B'>Apercu du contenu du fichier backup.sql</font></u></h1>
			<br>
			<h2>Le fichier ne contient que des tables SQL, elle permettent l'installation des MAJs
			<br>
			L'installation des tables est nécessaire pour le bon fonctionnement du jeu
			</h2>
			<table border='1'>
		 ";

	$sql=file("backup.sql"); // On charge le fichier backup.sql
	foreach($sql as $l) // On le lit en nommant chaque ligne $l
	{
		if (substr(trim($l),0,2)!="--") // On recupere la ligne que si il ne s'agit pas de commentaire ou de ligne vide
		{
			@$requetes .= $l; // On met toute les requetes a la suite
		}
	}

	$reqs = explode(";",$requetes); // J'ai mis explode alors que c'etait split avant, les deux fonctions doivent faire la meme chose (??)
	                                // Permet d'extraire chaque requete une a une
	foreach($reqs as $req) // Execute l'affichage pour chaque requetes
	{
		echo "
				<tr><td align='center'><font size='+1' color='006400'>
				".$req."
				</font></td></tr>
			 ";
	}

	echo "
			</table>
			<style>.lien_install { text-decoration: none ; }</style><br><br>
			<h3><a class='lien_install' href='install.php?a=installation'><font color='191970'>Executer le fichier (Ce qui installera les MAJs)</font></a>
			<br>
			<br><a class='lien_install' href='install.php'><font color='191970'>Retour a la page d'accueil</font></a>
			<br><br><br><br><br><style>.lien_install1 { text-decoration: overline underline ; }</style>
			<a class='lien_install1' href='?a=aidedev'><font size='-1' color='191970'>Aide au devloppeurs pour la conception du fichier backup.sql</font></a></h3>
			</center>
		 ";
}
#########################################################################################################################
elseif($a[0] == "aidedev") // Le perso a demandé l'aide pour créer le fichier backup.sql
{
echo "
		<center><br>
		<h1><u><font color='8B008B'>Bienvenue dans l'aide pour les devloppeurs</font></u></h1>
		<br>
		<h3>
		Les fichier backup doivent se presenter sous cette forme:
		<br><br>
		Votre requete, suivit d'un point virgule => ;
		<br><br><table width='650'>

		<tr><td valign='top' width='80'><u><b>Attention1 :</b></u></td><td>Les fichier SQL venant de PHPMyAdmin ne sont pas compatible du au faite qu'a la fin de chaque requete, il y a un truc contenant des ; pour pouvoir les rendre compatible, il suffit de supprimer, ce qui se trouve apres la ) de la fin.

		           <table><tr><td align='right' valign='top' width='80'><u><b>Exemple :</u></b></td><td>
		        		  <table><tr><td  align='right' valign='top' width='45'><u>Avant :</td><td>CREATE TABLE IF NOT EXISTS phpsim_screens (
		                              						<br>id int(255) NOT NULL auto_increment,
		 													<br>numero int(255) NOT NULL default '0',
		  													<br>PRIMARY KEY  (id)
															<br>) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;
						  </td></tr>
		        		  <table><tr><td  align='right' valign='top' width='45'><u>Avant :</td><td>CREATE TABLE IF NOT EXISTS phpsim_screens (
		                              						<br>id int(255) NOT NULL auto_increment,
		 													<br>numero int(255) NOT NULL default '0',
		  													<br>PRIMARY KEY  (id)
															<br>) ;
						 </td></tr></table></table>
		Il est conseillé de se servir du Mod de backup des tables inclus dans l'Administration qui lui ne pose pas les même probleme que PHPMyAdmin<br><br>
		</td></tr>
		<tr><td valign='top'><u><b>Attention2 :</td><td>Si vous ajoutez du contenu avec la commande INSERT, verifiez qu'il n'existe pas de ; (Points-Virgules) au milieu du contenu (Si c'est une table forum par Exemple) car sinon ca vacouper la requete au milieu et provoquez un Bug
		</td></tr>
		</table>
		<style>.lien_install { text-decoration: none ; }</style><br><br>
		<a class='lien_install' href='install.php'><font color='191970'>Retour a la page d'accueil</font></a>
		</h3>
		</center>
	 ";

}





?>