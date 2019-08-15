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

*/

$LANG = array (
				'DELETE_FILE_ERROR' => 'Le fichier de Dump n\'a pu être supprimé.',
				'DELETE_FILE_OK' => 'Le fichier de Dump a ete supprimé.',
				'DUMPING_COMPLETE' => 'La sauvegarde est termin&eacute;e',
				'DUMPING_GET_FILE' => 'Vous pouvez r&eacute;cuperer votre fichier de sauvegarde &agrave; l\'adresse suivante',
				'DUMPING_SAVING_DATA' => 'Sauvegarde de l\'enregistrement',
				'DUMPING_SAVING_STRUCT' => 'Sauvegarde de la Structure de la Table',
				'DUMPING_SAVING_TABLE' => 'Sauvegarde de la Table',
				'DUMPING_WAIT_RESUME' => 'ATTENTION ! La sauvegarde n\'est pas termin&eacute;e!',
				'DUMPING_WAIT_RESUME2' => 'Veuillez patienter, la sauvegarde reprendra dans 5 secondes<br />(ou cliquez sur le boutton ci-dessous si votre navigateur ne vous redirige pas automatiquement)',
				'ERROR_CONNEXION_FAILED' => 'La connexion a echou&eacute;e. Veuillez v&eacute;rifier vos param&egrave;tres de connexion',
				'ERROR_DB_NOT_EXISTS' => 'La base selectionn&eacute;e n\'existe pas. Veuillez v&eacute;rifier vos param&egrave;tres de connexion',
				'ERROR_INVALID_FILENAME' => 'Fichier de Backup Invalide',
				'ERROR_NO_SAVE_TYPE_SELECTED' => 'Veuillez s&eacute;lectionner un type de sauvegarde (Structure, Donn&eacute;es ou les deux).',
				'ERROR_NO_TABLE_SELECTED' => 'Aucune Table n\'a &eacute;t&eacute; s&eacute;lectionn&eacute;e. Veuillez au moins en s&eacute;lectionner une.',
				'ERROR_ZLIB_NOT_AVAILABLE' => 'La fonction Zlib est indisponible sur ce serveur',
				'GEST_CONFIRM_DELETE' => 'Confirmez-vous le souhait de supprimer ce fichier ?',
				'GEST_DUMP' => 'Gestion des Fichiers Dumps',
				'GEST_NO_FILES' => 'Aucun fichier',
				'GO_SCRIPT_INDEX' => 'Retourner &agrave; l\'index du script',
				'LOGON_ACTGEST' => 'G&eacute;rer les fichiers de Dump.',
				'LOGON_ACTRESTORE' => 'Restaurer une Base de Donn&eacute;es.',
				'LOGON_ACTSAVE' => 'Sauvegarder la Base de Donn&eacute;es.',
				'LOGON_CONNECT' => 'Connexion',
				'LOGON_DBBASE' => 'Nom de la Base de Donn&eacute;es',
				'LOGON_DBHOST' => 'Adresse du Serveur de la Base de Donn&eacute;es',
				'LOGON_DBPASS' => 'Mot de passe de la Base de Donn&eacute;es',
				'LOGON_DBUSER' => 'Nom d\'utilisateur de la Base de Donn&eacute;es',
				'OPTIONS_LEGEND' => 'Options de Sauvegarde',
				'PLEASE_WAIT' => 'Veuillez patienter',
				'QUERIES_EXECUTED' => 'Requetes execut&eacute;es',
				'RESTORE_ADVERT' => 'Le fichier de restauration n\'a pas ete cr&eacute;&eacute; avec XT-Dump,<br />La barre de progression n\'est donc pas disponible.',
				'RESTORE_BUTTON' => 'Demarrer la Restauration',
				'RESTORE_CHOOSE_DUMP' => 'S&eacute;lectionnez le fichier a importer',
				'RESTORE_COMPLETE' => 'La Restauration est termin&eacute;e',
				'RESTORE_WAIT_RESUME' => 'ATTENTION ! La restauration n\'est pas termin&eacute;e!',
				'RESTORE_WAIT_RESUME2' => 'Veuillez patienter, la restauration reprendra dans 5 secondes<br />(ou cliquez sur le boutton ci-dessous si votre navigateur ne vous redirige pas automatiquement)',
				'RESUME_DUMP' => 'Continuer la Sauvegarde',
				'RESUME_RESTORE' => 'Continuer la Restauration',
				'SELECT_ADD_DROPTABLE' => 'Inclure des énoncés "DROP TABLE"',
				'SELECT_ADD_IFEXISTS' => 'Ajouter "IF NOT EXISTS"',
				'SELECT_DATA' => 'Sauvegarder Donnees',
				'SELECT_FILENAME' => 'Nom du fichier de Sauvegarde (sans l\'extention)',
				'SELECT_GZIP' => 'Compresser en Gzip',
				'SELECT_MAKE_SELECTION' => 'Veuillez s&eacute;lectionner les tables &agrave; sauvegarder',
				'SELECT_STRUCT' => 'Sauvegarder Structures',
				'SELECT_SUBMIT' => 'Sauvegarder les Tables',
				'SELECT_TABLE_NAME' => 'Nom de la Table',
				'TITLE_DATABASE_CONNEXION' => 'Que desirez vous faire ??',
				'CHECK_NEW_VERSION' => 'V&eacute;rifier nouvelle version',
			  );

?>
