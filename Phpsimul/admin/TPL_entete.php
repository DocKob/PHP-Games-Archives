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

echo '

	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>
			PHPSimul : Panneau d\'administration v1.1 (by Stevenson)
		</title>
		<link rel="stylesheet" href="admin/tpl/style.css"  />
		<script language="javascript" type="text/javascript" src="admin/tpl/logics.js"></script>
		<script language="javascript" type="text/javascript" src="admin/tpl/convers.js"></script>
		<script language="javascript" type="text/javascript" src="admin/tpl/general.js"></script>
		<script language="javascript" type="text/javascript" src="admin/tpl/heure.js"></script>
	</head>

	<body>

	<!-- 	DEBUT ENTETE -->

	<div class="pageZone">
		<div class="headerZone"></div>

		<div class="userZone">
			<span style="float:right"><strong>
				<img src="admin/tpl/icons/time.gif.png" alt="" align="absbottom" /> <span id="dateheure"></span></strong>

			</strong></span>
			<img src="admin/tpl/icons/user.gif.png" alt="" align="absbottom" /> <strong><i><span class="mdj" id="headerLogin"><img src="admin/tpl/icons/nouvmess.gif"> <a href="mailto:steveproject@free.fr">Contacter Stevenson</a></span></i></strong>
		</div>
		<table border="0" cellpadding="0" cellspacing="0" class="middleZone">
			<tr valign="top"><td width="15%"><strong>
				<div class="menuZone">
					<ul>
						<li onClick="window.location.replace(\'?mod=default\')">
							<img src="admin/tpl/icons/accueil.gif.png" alt="" align="absbottom" /> Accueil   
						</li>
					</ul>
					<div class="menuZoneTitre"><img src="admin/tpl/icons/cog.png" alt="" align="absbottom" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Configuration</div>
					<ul>
'.( ($userrow['administrateur'] == '1' || $userrow['fondateur'] == 1)?'				
						<li onClick="window.location.replace(\'?mod=configurationprincipale\')">
							<img src="admin/tpl/icons/wrench.png" alt="" align="absbottom" /> Configuration du jeu      
						</li>
						<li onClick="window.location.replace(\'?mod=batiments\')">
							<img src="admin/tpl/icons/multi_group.gif.png" alt="" align="absbottom" /> Batiments      
						</li>
						<li onClick="window.location.replace(\'?mod=recherches\')">
							<img src="admin/tpl/icons/lightning.png" alt="" align="absbottom" /> Recherches        
						</li>						
						<li onClick="window.location.replace(\'?mod=chantier\')">
							<img src="admin/tpl/icons/car.png" alt="" align="absbottom" /> Chantier        
						</li>
						<li onClick="window.location.replace(\'?mod=defenses\')">
							<img src="admin/tpl/icons/shield.png" alt="" align="absbottom" /> Défenses        
						</li>
						<li onClick="window.location.replace(\'?mod=ressources\')">
							<img src="admin/tpl/icons/money.png" alt="" align="absbottom" /> Ressources        
						</li>		
						<li onClick="window.location.replace(\'?mod=menu\')">
							<img src="admin/tpl/icons/application_form_edit.png" alt="" align="absbottom" /> Edition menu        
						</li>	
':'').'						
						<li onClick="window.location.replace(\'?mod=forum\')">
							<img src="admin/tpl/icons/layout.png" alt="" align="absbottom" /> Edition forum        
						</li>
						<li onClick="window.location.replace(\'?mod=screens\')">
							<img src="admin/tpl/icons/screens.gif.png" alt="" align="absbottom" /> Screens        
						</li>
						<li onClick="window.location.replace(\'?mod=news\')">
							<img src="admin/tpl/icons/new.gif.png" alt="" align="absbottom" /> News        
						</li>
						<li onClick="window.location.replace(\'?mod=musique\')">
							<img src="admin/tpl/icons/music.png" alt="" align="absbottom" /> Musique        
					</ul>
	<div class="menuZoneTitre"><img src="admin/tpl/icons/computer.png" alt="" align="absbottom" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Modération</div>
					<ul>
						<li onClick="window.location.replace(\'?mod=agenda\')">
							<img src="admin/tpl/icons/calendar.png" alt="" align="absbottom" /> Agenda        
						</li>
						<li onClick="window.location.replace(\'?mod=alliances\')">
							<img src="admin/tpl/icons/users_online.gif.png" alt="" align="absbottom" /> Alliances        
						</li>
						<li onClick="window.location.replace(\'?mod=joueurs\')">
							<img src="admin/tpl/icons/vcard.png" alt="" align="absbottom" /> Joueurs        
						</li>
						<li onClick="window.location.replace(\'?mod=contact\')">
							<img src="admin/tpl/icons/vcard.png" alt="" align="absbottom" /> Messages        
						</li>					
						<li onClick="window.location.replace(\'?mod=joueurs&action=logs_joueurs\')">
							<img src="admin/tpl/icons/log.gif.png" alt="" align="absbottom" /> Logs joueurs        
						</li>
						<li onClick="window.location.replace(\'?mod=joueurs&action=liste_ips\')">
							<img src="admin/tpl/icons/report.png" alt="" align="absbottom" /> Listing IP       
						</li>
						<li onClick="window.location.replace(\'?mod=whois\')">
							<img src="admin/tpl/icons/report_magnify.png" alt="" align="absbottom" /> Résolution d\'IP        
						</li>
						<li onClick="window.location.replace(\'?mod=multicompte\')">
							<img src="admin/tpl/icons/alerts_multi.gif.png" alt="" align="absbottom" /> Multi-comptes        
						</li>
'.( ($userrow['administrateur'] == '1' || $userrow['fondateur'] == 1)?'						
						<li onClick="window.location.replace(\'?mod=gestion_staff\')">
							<img src="admin/tpl/icons/vcard.png" alt="" align="absbottom" /> Gestion Staff        
						</li>	
	<div class="menuZoneTitre"><img src="admin/tpl/icons/computer.png" alt="" align="absbottom" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Serveur</div>						
						</li>
							<li onClick="window.location.replace(\'?mod=raz\')">
							<img src="admin/tpl/icons/wrench.png" alt="" align="absbottom" /> RAZ        
						</li>						
						<li onClick="window.location.replace(\'?mod=aide&action=maj\')">
							<img src="admin/tpl/icons/nouv.gif" alt="" align="absbottom" /> Mise à jour       
						</li>
						<li onClick="window.location.replace(\'?mod=infosphp\')">
							<img src="admin/tpl/icons/page_white_php.png" alt="" align="absbottom" /> Infos PHP        
						</li>
						<li onClick="window.location.replace(\'?mod=sql&action=liste\')">
							<img src="admin/tpl/icons/sql.gif" alt="" align="absbottom" /> Accès base SQL        
						</li>
						<li onClick="window.location.replace(\'?mod=sql&action=backup\')">
							<img src="admin/tpl/icons/sql.gif" alt="" align="absbottom" /> Backup base SQL       
						</li>
						<li onClick="window.location.replace(\'?mod=uploadftp\')">
							<img src="admin/tpl/images/dir.png" width=16 heignt=16 alt="" align="absbottom" /> Gestion FTP       
						</li>	
':'').'						
						<li>
							&nbsp;
						</li>
						<li onClick="window.location.replace(\'?mod=logout\')">
							<img src="admin/tpl/icons/close.gif.png" alt="" align="absbottom" /> Deconnexion        
						</li>
					</ul>
					</div>
				</div>
				</strong>
			</td><td width="85%">
				<div class="contenuZone">

					<strong>
					<div class="contenuZoneTitre"><img src="admin/tpl/icons/application.png" alt="" align="absbottom" /> <span id="titre">Ecran de configuration</span></div>
					<div class="contenuZonePage" id="page"><div align="center">

	<!-- FIN ENTETE -->


	<!-- DEBUT Affichage de la page -->


';