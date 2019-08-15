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


Ce Mod n'a pas été optimisé pour PHPSimul, il se peut donc qu'il y ait quelques bugs

*/
   
     // 
     // Nom du script : whois.php
     // Auteur : SebF@frameIP.com.pas.de.spam
     // Date de création : 17 Novembre 2003
     // version : 1.3
     // Licence : Ce script est libre de toute utilisation.
     // La seule condition existante est de faire référence au site http://www.frameip.com afin de respecter le travail d'autrui.
     // 
    
     // 
     // Affichage de l'entete html
     // 
     echo
     '
     <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
    
     <html>
    
     <head>
    
     <LINK REL="StyleSheet" HREF="../style.css" TYPE="text/css">
    
     <title>FrameIP, Pour ceux qui aiment IP - Script Whois</title>
    
     <META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
     <META NAME="AUTHOR" CONTENT="www.frameip.com">
     <META NAME="COPYRIGHT" CONTENT="Copyright (c) 2003 by framip">
     <META NAME="KEYWORDS" CONTENT="whois, online, outil, ripe, iana, apic, arin, lacnic, adresse ip, rir, registrar, tcp 43, lir, rir, db, database, as, asnum">
     <META NAME="DESCRIPTION" CONTENT="Frameip, pour ceux qui aiment IP - Script Whois">
     <META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
     <META NAME="REVISIT-AFTER" CONTENT="1 DAYS">
     <META NAME="RATING" CONTENT="GENERAL">
     <META NAME="GENERATOR" CONTENT="powered by frameip.com - webmaster@frameip.com">
    
     </head>
    
     <body>
     ';
    echo "<form method='post' action='?mod=whois'>

Entrez une adresse IP :<br><br>

<input type='varchar' name='ipaddress' size='15' value='".@$_POST['ipaddress']."'>

<input type='submit' value='Rechercher' alt='Lancer la recherche!'>

</form>";

if(empty($_POST['ipaddress']) ) { exit(); }

     // 
     // Initiation des variables
     // 
     $whois_ip_demande=$_POST['ipaddress'];
    
     // 
     // Récupération de la date et heure
     // 
     $annee=date("Y");
     $mois=date("m");
     $jour=date("d");
     $heure=date("H");
     $minute=date("i");
     $seconde=date("s");
    
     // 
     // Récupération de l'IP cliente
     // 
     $ip_client=getenv("REMOTE_ADDR");
    
     // 
     // Récupération du Ptr de l'IP cliente
     // 
     $ptr=gethostbyaddr("$ip_client");
     if ($ptr==$ip_client)
     $ptr="Pas de ptr";
    
     // 
     // Récupération du port TCP source
     // 
     $port_source=getenv("REMOTE_PORT");
    
     // 
     // Récupération de l'IP du browser
     // 
     $ip_browser=getenv("HTTP_X_FORWARDED_FOR");
    
     // 
     // Vérification des champs vide
     // 
     if (empty($whois_ip_demande))
     whois_erreur(1);
    
     // 
     // Résolution du nom et conformité de l'IP selectionné
     // 
     if (ip2long($whois_ip_demande)==-1) // Si ce n'est pas une IP
     {
     $nom_correspondant=gethostbyname($whois_ip_demande); // Alors résolution du nom
     if ($nom_correspondant!=$whois_ip_demande) // Si il a résolut le nom
     $whois_ip_demande=$nom_correspondant; // Récupération de l'ip résolut
     else
     whois_erreur(2);
     }
    
     // 
     // Transforme les saisies tel que 10.10..4 en 10.10.0.4
     // 
     $inetaddr=ip2long($whois_ip_demande);
     $whois_ip_demande=long2ip($inetaddr);
    
     // 
     // Présentation des résultats
     // 
     echo "
	 <p align='center'>
     <font size='4' color='#008000'>
     <b>
     Whois
     </b>
     </font>
     </p>
     <p>
     Voici les résultats du whois pour l\'adresse IP '.$whois_ip_demande.'
     <br>
     &nbsp;
     </p>
     ";
    
     // 
     // Appel de la fonction connexion
     // 
     $buffer=connexion("whois.ripe.net",$whois_ip_demande);
     $serveur_ayant_repondu="whois.ripe.net";
    
     // 
     // Vérifie si on est sur le bon serveur
     // 
     if (eregi("www.iana.org", $buffer))
     {
     $buffer=connexion("whois.arin.net",$whois_ip_demande);
     $serveur_ayant_repondu = "whois.arin.net";
     }
     elseif (eregi("whois.apnic.net", $buffer))
     {
     $buffer=connexion("whois.apnic.net",$whois_ip_demande);
     $serveur_ayant_repondu = "whois.apnic.net";
     }
     elseif (eregi("whois.registro.br", $buffer))
     {
     $buffer=connexion("whois.registro.br",$whois_ip_demande);
     $serveur_ayant_repondu = "whois.registro.br";
     }
     elseif (eregi("nic.ad.jp", $buffer))
     {
     $buffer=connexion("whois.nic.ad.jp",$whois_ip_demande);
    
    
    
     ////////////////////////////////////////////////////////////////////// A VOIR
     #/e suppresses Japanese character output from JPNIC
     $extra = "/e";
    
     $serveur_ayant_repondu = "whois.nic.ad.jp";
     }
    
     // 
     // Affichage du nom du serveur qui à rendu l'information
     // 
     echo '<BR><b>';
     echo 'C\'est le serveur '.$serveur_ayant_repondu.' qui possède l\'information suivante :';
     echo '</b><BR><BR>';
    
     // 
     // Intégre les retours charriot
     // 
     $buffer2 = nl2br($buffer);
    
     // 
     // Affiche le resultat
     // 
     echo "<table align = 'center' border = '1' widht = '500'><td>$buffer2</td></table>";
    
     // 
     // Fin du script général
     // 
     fin_du_script();
    
     // 
     // Fonction de connexion whois
     // 
     function connexion($serveur,$ip_recherche)
     {
     // 
     // Ouverture de la session TCP
     // 
     $socket=fsockopen($serveur, 43);
    
     if ($socket!=0)
     {
     // 
     // Envoi de l'IP demandé
     // 
     fwrite($socket, "$ip_recherche\n");
    
     // 
     // Receptionne dans buffer la réponse
     // 
     while (feof($socket)==0)
     $tampon = $tampon . fgets($socket, 1000); // Le . signifie concatenation
    
     // 
     // Ferme la session TCP
     // 
     fclose($socket);
     }
     else
     // 
     // Sortie du script
     // 
     whois_erreur(3);
    
     return ($tampon);
     }
    
     // 
     // Fonction d'affichage de l'erreur de saisie
     // 
     function whois_erreur($erreur) // $erreur représente le numéro d'erreur.
     {
     // 
     // Affichage de titre
     // 
     echo
     '
     <p align="center">
     <b>
     <font size="5" color="#008000">
     Erreur
     </font>
     </b>
     </p>
     ';
    
     // 
     // Affichage de l'erreur
     // 
     echo
     '
     <p>
     ';
    
     // 
     // Message personnalisé
     // 
     if ($erreur==1)
     echo'Le Whois ne peux pas avoir lieu car le champ IP est vide.';
     elseif ($erreur==2)
     echo'Le Whois ne peux pas avoir lieu car le champ IP ne contient pas d\'adresse valide ou le nom n\'a pas pu être résolut.';
     elseif ($erreur==3)
     echo'Impossible de se connecter sur le serveur '.$server.' via le port 43.';
    
     // 
     // Fin du script général
     // 
     fin_du_script();
     }
    
     function fin_du_script()
     {
     // 
     // Affiche de l'Url
     // 
     echo
     '
     </p>
     <p align="right">
     <a target="_blank" href="http://www.frameip.com">
     www.FrameIP.com
     </a>
     </p>
     ';
    
     // 
     // Fin de la page Html
     // 
     echo
     '
     </body>
    
     </html>
     ';
    
     // 
     // Fin du script général
     // 
     exit(0);
     }

?>

