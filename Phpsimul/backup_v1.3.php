<?php

/*

Permet d'effectuer les mises a jour impossible a effectuer depuis le backup.sql du au faite qu'elle sont dynamique

*/


// On recupere les identifiants sur install.php, c'est le fichier qui appelle celui la
include ('classes/sql.class.php'); // Pour les actions SQL
$sql = new sql; // Classes pour le SQL
$sql->connect(); // Se connecte au serveur SQL

if(!file_exists('backup_config') ) // Dans le cas ce script n'a pas encore effectué de backup de config, il le fait
{
	// Creation du backup
	$controlrow = $sql->select('SELECT * FROM phpsim_config WHERE id="1" LIMIT 1');

	$controlrow2 = $controlrow;
	$ser2 = serialize($controlrow2);

	$f = fopen('backup_config', 'w+');
	fputs($f, $ser2);
	fclose($f);
}

// On recupere les données dans le backup, cela permet en cas de bug de l'install de toujours avoir une save de la table config
$ser = @file_get_contents('backup_config');
$controlrow = unserialize($ser);


// On commence par virer la table
$sql->update('DROP TABLE phpsim_config');

// Puis on recréer la table 
$sql->update('
					CREATE TABLE phpsim_config (   
										config_name 		varchar(255),
										config_value		varchar(255),
										primary key(config_name)
									)
				 ');
	

// Et on inseres les données dans la nouvelle table avec l'ancienne configuration
$sql->update("INSERT INTO phpsim_config VALUES ('mail', '".stripslashes($controlrow['mail'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('ouvert', '".stripslashes($controlrow['ouvert'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('nom', '".stripslashes($controlrow['nom'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('description', '".stripslashes($controlrow['description'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('verifmail', '".stripslashes($controlrow['verifmail'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('url', '".stripslashes($controlrow['url'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('log_menu', '".stripslashes($controlrow['log_menu'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('maxnews', '".stripslashes($controlrow['maxnews'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('maxscreens', '".stripslashes($controlrow['maxscreens'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('screensparligne', '".stripslashes($controlrow['screensparligne'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('screenswidth', '".stripslashes($controlrow['screenswidth'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('screensheight', '".stripslashes($controlrow['screensheight'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('reglement', '".stripslashes($controlrow['reglement'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('agemin', '".stripslashes($controlrow['agemin'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('logo', '".stripslashes($controlrow['logo'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('logo_log', '".stripslashes($controlrow['logo_log'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('rss', '".stripslashes($controlrow['rss'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('rss_log', '".stripslashes($controlrow['rss_log'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('icone', '".stripslashes($controlrow['icone'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('menu', '".stripslashes($controlrow['menu'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('menu_width', '".stripslashes($controlrow['menu_width'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('coordonnees_activees', '".stripslashes($controlrow['coordonnees_activees'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('ordre_1_active', '".stripslashes($controlrow['ordre_1_active'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('ordre_1_max', '".stripslashes($controlrow['ordre_1_max'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('ordre_2_max', '".stripslashes($controlrow['ordre_2_max'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('ordre_3_max', '".stripslashes($controlrow['ordre_3_max'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('ressourcesdepart', '".stripslashes($controlrow['ressourcesdepart'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('nom_bases', '".stripslashes($controlrow['nom_bases'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('nom_cases', '".stripslashes($controlrow['nom_cases'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('cases_default', '".stripslashes($controlrow['cases_default'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('productiondepart', '".stripslashes($controlrow['productiondepart'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('stockagedepart', '".stripslashes($controlrow['stockagedepart'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('recherches_necessaire', '".stripslashes($controlrow['recherches_necessaire'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('energies_default', '".stripslashes($controlrow['energies_default'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('batiments_default', '".stripslashes($controlrow['batiments_default'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('recherches_default', '".stripslashes($controlrow['recherches_default'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('energie_nom', '".stripslashes($controlrow['energie_nom'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('energie_activee', '".stripslashes($controlrow['energie_activee'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('energie_default', '".stripslashes($controlrow['energie_default'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('chantier_necessaire', '".stripslashes($controlrow['chantier_necessaire'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('unites_default', '".stripslashes($controlrow['unites_default'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('unites_nom', '".stripslashes($controlrow['unites_nom'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('login_template', '".stripslashes($controlrow['login_template'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('temps_voyage', '".stripslashes($controlrow['temps_voyage'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('ressources_coloniser', '".stripslashes($controlrow['ressources_coloniser'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('bases_max', '".stripslashes($controlrow['bases_max'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('race_1', '".stripslashes($controlrow['race_1'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('race_2', '".stripslashes($controlrow['race_2'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('race_3', '".stripslashes($controlrow['race_3'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('race_4', '".stripslashes($controlrow['race_4'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('race_5', '".stripslashes($controlrow['race_5'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('race_1_theme', '".stripslashes($controlrow['race_1_theme'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('race_2_theme', '".stripslashes($controlrow['race_2_theme'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('race_3_theme', '".stripslashes($controlrow['race_3_theme'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('race_4_theme', '".stripslashes($controlrow['race_4_theme'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('race_5_theme', '".stripslashes($controlrow['race_5_theme'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('maj', '".stripslashes($controlrow['maj'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('titre_lecteur_musique', '".stripslashes($controlrow['titre_lecteur_musique'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('inscription_total', '".stripslashes($controlrow['inscription_total'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('vprofil_voirplanetes', '".stripslashes($controlrow['vprofil_voirplanetes'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('vprofil_voirbatiments', '".stripslashes($controlrow['vprofil_voirbatiments'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('vprofil_recherches', '".stripslashes($controlrow['vprofil_recherches'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('vprofil_flottes', '".stripslashes($controlrow['vprofil_flottes'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('vprofil_status', '".stripslashes($controlrow['vprofil_status'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('pointalli', '".stripslashes($controlrow['pointalli'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('race_1_infos', '".stripslashes($controlrow['race_1_infos'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('race_2_infos', '".stripslashes($controlrow['race_2_infos'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('race_3_infos', '".stripslashes($controlrow['race_3_infos'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('race_4_infos', '".stripslashes($controlrow['race_4_infos'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('race_5_infos', '".stripslashes($controlrow['race_5_infos'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('tps_ordre_1', '".stripslashes($controlrow['tps_ordre_1'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('tps_ordre_2', '".stripslashes($controlrow['tps_ordre_2'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('carburant', '".stripslashes($controlrow['carburant'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('points_mini', '".stripslashes($controlrow['points_mini'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('att_conquerir', '".stripslashes($controlrow['att_conquerir'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('cases_minimum_pour_colonisation', '".stripslashes($controlrow['cases_minimum_pour_colonisation'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('cases_maximum_pour_colonisation', '".stripslashes($controlrow['cases_maximum_pour_colonisation'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('banque', '".stripslashes($controlrow['banque'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('valeurs', '".stripslashes($controlrow['valeurs'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('tps_echanges', '".stripslashes($controlrow['tps_echanges'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('compression', '".stripslashes($controlrow['compression'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('defenses_default', '".stripslashes($controlrow['defenses_default'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('defenses_necessaire', '".stripslashes($controlrow['defenses_necessaire'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('voir_batiments_inaccessibles', '".stripslashes($controlrow['voir_batiments_inaccessibles'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('upload_avatars_actif', '".stripslashes($controlrow['upload_avatars_actif'])."') ");
$sql->update("INSERT INTO phpsim_config VALUES ('cacher_erreurs', '".stripslashes($controlrow['cacher_erreurs'])."') ");




// On ajoute les champs n'existant pas avant
$sql->update("INSERT INTO phpsim_config VALUES ('message_bienvenue_actif', '0') "); // Pour activer/desactiver le message de bienvenue a l'inscription
$sql->update("INSERT INTO phpsim_config VALUES ('message_bienvenue', 'Bienvenue') ");
$sql->update("INSERT INTO phpsim_config VALUES ('titre_message_bienvenue', 'Bienvenue') ");
$sql->update("INSERT INTO phpsim_config VALUES ('base_de_depart_choisi_automatiquement', '1') "); // Pour definir si la base de depart doit etre choisi automatiquement ou pas
$sql->update("INSERT INTO phpsim_config VALUES ('description_breve', 'Moteur de Jeux en PHP') "); // Pour la description sur l'index.html de la racine
$sql->update("INSERT INTO phpsim_config VALUES ('version', '1.3') "); // Pour la description sur l'index.html de la racine
















// On modifie la date pourri des anciennes news
$news1 = $sql->query('SELECT id, date FROM phpsim_news ORDER BY id'); // Selectionne les news

while($news = mysql_fetch_array($news1) ) // On traite chaque news
{
	eregi('([0-9]{4})-([0-9]{2})-([0-9]{2})', $news['date'], $date); // On recupere chaque champs de la date independament
	
	// mktime('heures', 'minutes', 'secondes', 'mois', 'jours', 'années'); // Les champs de la fonction
	$date = mktime(17, 00, 00, $date[2], $date[3], $date[1]); // Etant donnée qu'on a pas l'heure, et qu'en plus on s'en fou, on met 17H
	
	// La fonction retourne un champ correct, tel que ceut retourné par time()
	
	$sql->update('UPDATE phpsim_news SET date="'.$date.'" WHERE id="'.$news['id'].'" ');
	
}









unlink("backup.php");
unlink("index.html");

?>