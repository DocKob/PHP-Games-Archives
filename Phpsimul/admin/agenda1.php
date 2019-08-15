<?php

// Etant donné sque l'on appelle cette page par acces direct par JavaScript, on ne bloque son execution que si le get function n'est pas defini
// Sachant que le Js l'appelle toujours par ?function=xxx la page ne bloquera pas l'execution direct par le JS
if(empty($_GET['function']) || $_GET['function'] == '') 
{
die('Erreur 404 - Le fichier n\'a pas été trouvé');
}

/*********************************************************\
Merci de laisser ces commentaires si vous utilisez ce code
XL_AJendAX v1.0 de Xavier Langlois
http://xl714.free.fr
xavier.langlois@gmail.com
Version 1.0 sortie le 4 Avril 2006

Ce mod n'a pas été optimisé pour PHPSimul il se peut donc qu'il surgisse des bugs
\*********************************************************/

define('PHPSIMUL_PAGES', 'PHPSIMULLL'); // On defini la constante qui va permettre d'ouvrir le fichier de configuration
include ("../systeme/config.php"); // On inclue le fichier contenant les informations des tables

function ConnectDB()
{	
	$db = mysql_connect(BDD_HOST, BDD_USER, BDD_PASS);
	mysql_select_db(BDD_NOM);
	return $db;
}
function myEncoding($str)
{
	$str = str_replace(' ','~s~',$str);//$str = strtr($str, "éèêàâîïûü", "eeeaaiiuu");
	$str = str_replace('\\n','~j~',$str);//$str = str_replace('\'','~q~',$str);
	$str = urlencode($str);
	return $str;
}
function fonction_test()
{
	die(myEncoding("On est dans la fonction test"));
}
function getNotes()
{
	$str = "";
	$db = ConnectDB();
	$result = mysql_query ("SELECT id, titre FROM ".PREFIXE_TABLES.TABLE_AGENDA." WHERE `type` = 0 ORDER BY `titre`",$db) or die(myEncoding("~X~Requête"));
	$nbRec = mysql_num_rows($result);
	if($nbRec){
		while($objet = mysql_fetch_object($result)){	
			$id = $objet->id;
			$titre = $objet->titre;
			$str .= '<option value="'.$id.'">'.$titre.'</option>';
		}
		mysql_free_result($result);
		die(myEncoding($str));	
	}else{
		mysql_free_result($result);
		die(myEncoding('<option value="rien" disabled>Aucune note enregistrée</option>'));
	}
}
function getContacts()
{
	$str = "";
	$db = ConnectDB();
	$result = mysql_query ("SELECT id, titre FROM ".PREFIXE_TABLES.TABLE_AGENDA." WHERE `type` = 1 ORDER BY `titre`",$db) or die(myEncoding("~X~Requête"));
	$nbRec = mysql_num_rows($result);
	if($nbRec){
		while($objet = mysql_fetch_object($result)){	
			$id = $objet->id;
			$titre = $objet->titre;
			$str .= '<option value="'.$id.'">'.$titre.'</option>';
		}
		mysql_free_result($result);
		die(myEncoding($str));	
	}else{
		mysql_free_result($result);
		die(myEncoding('<option value="rien" disabled>Aucun contact enregistré</option>'));
	}
}
function getTasks()
{
	if(array_key_exists("date_taches",$_GET)) {$date_taches = $_GET["date_taches"];}else{die(myEncoding("~X~Paramètre non défini"));}
	$str = "";
	$db = ConnectDB();
	$requete = "SELECT id, titre, date_tache FROM ".PREFIXE_TABLES.TABLE_AGENDA." WHERE `date_tache` LIKE '".$date_taches."%' ORDER BY `date_tache`,`titre`";
	$result = mysql_query ($requete,$db) or die(myEncoding("~X~Requête: ".$requete));
	$nbRec = mysql_num_rows($result);
	if($nbRec){
		while($objet = mysql_fetch_object($result)){	
			$id = $objet->id;
			$titre = $objet->titre;
			$date = $objet->date_tache;
			$tab = explode("-", $date);
			$str .= '<option value="'.$id.'">'.$tab[2]."/".$tab[1]." - ".$titre.'</option>';
		}
		mysql_free_result($result);
		die(myEncoding($str));	
	}else{
		mysql_free_result($result);
		die(myEncoding('<option value="rien" disabled>Rien de prévu</option>'));
	}
}
function getRecord()
{
	if(array_key_exists("id",$_GET)) {$id = $_GET["id"];}else{die(myEncoding("~X~Paramètre id non défini"));}
	$str = "";
	$db = ConnectDB();
	$requete = "SELECT * FROM ".PREFIXE_TABLES.TABLE_AGENDA." WHERE `id`=".$id;
	$result = mysql_query ($requete, $db) or die(myEncoding("~X~Requête: ".$requete));
	$nbRec = mysql_num_rows($result);
	if($nbRec){
		while($objet = mysql_fetch_object($result)){				
			$str .= "record['id'] = '".$objet->id."';";
			$str .= "record['type'] = '".$objet->type."';";
			$str .= "record['titre'] = '".urlencode($objet->titre)."';";
			$str .= "record['contenu'] = '".urlencode($objet->contenu)."';";
			$str .= "record['date_tache'] = '".$objet->date_tache."';";
		}
		mysql_free_result($result);
		die($str);
	}
}
function getMonthString()
{
	if(array_key_exists("date",$_GET)) {$date = $_GET["date"];}else{die(myEncoding("~X~Paramètre date non défini"));}
	$db = ConnectDB();
	$requete = "SELECT date_tache FROM ".PREFIXE_TABLES.TABLE_AGENDA." WHERE `date_tache` LIKE '".$date."%' GROUP BY `date_tache`";
	$result = mysql_query ($requete, $db) or die(myEncoding("~X~Requête:".$requete));
	$nbRec = mysql_num_rows($result);
	$str = "~";
	if($nbRec){
		while($objet = mysql_fetch_object($result)){$str .= $objet->date_tache."~";}
		mysql_free_result($result);
		die($str);
	}else{
		die($str);
	}
}
function insertRecord()
{
	if(array_key_exists("id",$_GET)) {$id = $_GET["id"];}else{die(myEncoding("~X~Paramètre 'id' non défini"));}
	if(array_key_exists("type",$_GET)) {$type = $_GET["type"];}else{die(myEncoding("~X~Paramètre 'type'  non défini"));}
	if(array_key_exists("titre",$_GET)) {$titre = $_GET["titre"];}else{die(myEncoding("~X~Paramètre 'titre' non défini"));}
	if(array_key_exists("contenu",$_GET)) {$contenu = $_GET["contenu"];}else{die(myEncoding("~X~Paramètre 'contenu' non défini"));}
	if(array_key_exists("date_tache",$_GET)) {$date_tache = $_GET["date_tache"];}else{die(myEncoding("~X~Paramètre 'date_tache' non défini"));}
	if($date_tache!="0000-00-00"){$type = 2;}
	$requete = 	"INSERT INTO ".PREFIXE_TABLES.TABLE_AGENDA." ( `id` , `date` , `type` , `titre` , `contenu` , `date_tache` , `user` )".
				"VALUES ('', '0000-00-00 00:00:00', '".$type."', '".$titre."', '".$contenu."', '".$date_tache."', '0');";
	$db = ConnectDB();
	if(mysql_query ($requete,$db)){die(myEncoding("Insertion effectuée"));}else{die(myEncoding("~X~Requête : ".$requete));}
}
function updateRecord()
{
	if(array_key_exists("id",$_GET)) {$id = $_GET["id"];}else{die(myEncoding("~X~Paramètre 'id' non défini"));}
	if(array_key_exists("type",$_GET)) {$type = $_GET["type"];}else{die(myEncoding("~X~Paramètre 'type'  non défini"));}
	if(array_key_exists("titre",$_GET)) {$titre = $_GET["titre"];}else{die(myEncoding("~X~Paramètre 'titre' non défini"));}
	if(array_key_exists("contenu",$_GET)) {$contenu = $_GET["contenu"];}else{die(myEncoding("~X~Paramètre 'contenu' non défini"));}
	if(array_key_exists("date_tache",$_GET)) {$date_tache = $_GET["date_tache"];}else{die(myEncoding("~X~Paramètre 'date_tache' non défini"));}
	if($date_tache!="0000-00-00"){$type = 2;}
	$requete = 	"UPDATE ".PREFIXE_TABLES.TABLE_AGENDA." SET `type` = '".$type."',`titre` = '".$titre."',`contenu` = '".$contenu."',`date_tache` = '".$date_tache."' WHERE `id` =".$id." LIMIT 1 ;";
	$db = ConnectDB();
	if(mysql_query ($requete,$db)){die(myEncoding("Modification effectuée"));}else{die(myEncoding("~X~Requête : ".$requete));}
}
function deleteRecord()
{
	if(array_key_exists("id",$_GET)) {$id = $_GET["id"];}else{die(myEncoding("Paramètre non défini"));}
	$requete = 	"DELETE FROM ".PREFIXE_TABLES.TABLE_AGENDA." WHERE `id` =".$id." LIMIT 1 ;";
	$db = ConnectDB();
	if(mysql_query ($requete,$db)){die(myEncoding("Suppression effectuée"));}else{die(myEncoding("~X~Requête : ".$requete));}
}
if(array_key_exists("function",$_GET))
{
	if (function_exists($_GET["function"]))
	{
		eval("".$_GET["function"]."();");
	}
	else
	{
		die(myEncoding("~X~Fonction introuvable"));
	}
}
else
{
	die(myEncoding("~X~Paramètre 'function' non défini"));
}
?>