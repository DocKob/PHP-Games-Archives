<?php

// Si la constante n'est pas defini on bloque l'execution du fichier
if(!defined('PHPSIMUL_PAGES') || @PHPSIMUL_PAGES != 'PHPSIMULLL') 
{
die('Erreur 404 - Le fichier n\'a pas été trouvé');
}

/* 

PHPsimul : Créez votre jeu de simulation en PHP
Copyright (©) - 2007 - CAPARROS Sébastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr



Mod Search - Permet de recherchez des Joueurs/Planetes/Alliances

Créer a la base par Perberos pour Ugamela

Adapté par Max485 pour PHPSimul

*/

includelangue(); // Inclue la fonction langue qui est en bas

$i = 0;
@$searchtext = $_POST['searchtext'] ;
@$type = $_POST['type'] ;
//creamos la query
switch(@$type){
	case "playername":
		$table = gettemplate('search_user_table');
		$row = gettemplate('search_user_row');
		$search = doquery("SELECT * FROM {{table}} WHERE nom LIKE '{$searchtext}%' ORDER BY nom LIMIT 30","users");
	break;
	case "planetname":
		$table = gettemplate('search_user_table');
		$row = gettemplate('search_user_row');
		$search = doquery("SELECT * FROM {{table}} WHERE nom LIKE '{$searchtext}%' ORDER BY  nom LIMIT 30","bases");
	break;
	case "allytag":
		$table = gettemplate('search_ally_table');
		$row = gettemplate('search_ally_row');
		$search = doquery("SELECT * FROM {{table}} WHERE tag LIKE '{$searchtext}%' ORDER BY tag LIMIT 30","alliance");
	break;
	case "allyname":
		$table = gettemplate('search_ally_table');
		$row = gettemplate('search_ally_row');
		$search = doquery("SELECT * FROM {{table}} WHERE nom LIKE '{$searchtext}%' ORDER BY nom LIMIT 30","alliance");
	break;
	default:
		$table = gettemplate('search_user_table');
		$row = gettemplate('search_user_row');
		$search = doquery("SELECT * FROM {{table}} WHERE nom LIKE '{$searchtext}%' ORDER BY nom LIMIT 30","users");
}



if(@isset($searchtext) && isset($type) ){

	while($r = mysql_fetch_array($search)){
		
		if($type=='playername'){
			$s=$r;
			//pour obtenir le nom de la planete
			$bases_exp = explode(",", $s['bases']);			
			$pquery = doquery("SELECT * FROM {{table}} WHERE id = {$bases_exp[0]}","bases",true);
			//puis le celui de l'alliance
			if($s['alli']!=0){
				$aquery = doquery("SELECT * FROM {{table}} WHERE id = {$s['alli']}","alliance",true);
			}
			if(empty($aquery['nom']) ) { $s['alli'] = " - "; }
			elseif(isset($aquery['nom']) ) {$s['alli'] = "<a href=\"index.php?mod=alliances/voiralli|{$aquery['tag']}\">{$aquery['tag']}</a> "; };
			$s['bases'] = $pquery['nom'];
			$s['position'] = ($s['points']==0)?'0':"{$s['points']}";
			$s['templates'] = "templates/" . $userrow["template"] . "/";
			$s['coord'] = "{$pquery['ordre_1']}:{$pquery['ordre_2']}:{$pquery['ordre_3']}";
			$s['listeamis'] = $lang['buddy_request'];
			$s['ecriremsg'] = $lang['write_a_messege'];
			$s['galaxie'] = $pquery['ordre_1'] ;
			$s['systeme'] = $pquery['ordre_2'] ;
			if($s['valide'] == 1) // Si la personne n'a pas validé son compte on ne l'affiche pas
			{
			@$result_list .= parsetemplate($row, $s);
			}
			unset($aquery) ;
		}
		elseif(@$type == 'planetname'){
			$s=$r;
			//pour obtenir le nom du joueur
			$pquery = doquery("SELECT * FROM {{table}} WHERE bases LIKE '%{$s['id']}%' ","users",true);
			//puis le celui de l'alliance
			if($pquery['alli']!=0){
				$aquery = doquery("SELECT * FROM {{table}} WHERE id = {$pquery['alli']}","alliance",true);
			}
			if(empty($aquery['nom']) ) { $s['alli'] = " - "; }
			elseif(isset($aquery['nom']) ) {$s['alli'] = "<a href=\"index.php?mod=alliances/voiralli|{$aquery['tag']}\">{$aquery['tag']}</a> "; };
			$s['bases'] = $s['nom'];
			$s['nom'] = $pquery['nom'] ;
			$s['position'] = ($pquery['points']==0)?'0':"{$pquery['points']}";
			$s['templates'] ="templates/" . $userrow["template"] . "/";
			$s['coord'] = "{$s['ordre_1']}:{$s['ordre_2']}:{$s['ordre_3']}";
			$s['listeamis'] = $lang['buddy_request'];
			$s['ecriremsg'] = $lang['write_a_messege'];
			$s['galaxie'] = $s['ordre_1'] ;
			$s['systeme'] = $s['ordre_2'] ;
			if($s['bases'] != "Système") {// si la base est different de systeme on passe par l'affichage sur le tamplate
			@$result_list .= parsetemplate($row, $s);
			}
			unset($aquery) ;
			}
		elseif(@$type=='allytag' || $type=='allyname'){
			$s=$r;
			$s['tag'] = "<a href=\"index.php?mod=alliances/voiralli|{$s['tag']}\">{$s['tag']}</a>";
			$pointalli = doquery("SELECT SUM(points) as points FROM {{table}} WHERE alli='".$s['id']."'","users",true);
			$s['points'] = $pointalli['points'] ;
			$membres = doquery("SELECT COUNT(id) As membres FROM {{table}} WHERE alli='".$s['id']."'","users",true);
			$s['membres'] = $membres['membres'] ;			
			@$result_list .= parsetemplate($row, $s);
		}
	}
	if(@$result_list != ''){
		$lang['result_list'] = $result_list;
		@$search_results .= parsetemplate($table, $lang);
	}
}

//el resto...
$lang['type_playername'] = (@$_POST["type"] == "playername") ? " SELECTED" : "";
$lang['type_planetname'] = (@$_POST["type"] == "planetname") ? " SELECTED" : "";
$lang['type_allytag'] = (@$_POST["type"] == "allytag") ? " SELECTED" : "";
$lang['type_allyname'] = (@$_POST["type"] == "allyname") ? " SELECTED" : "";
$lang['searchtext'] = @$_POST['searchtext'];
@$lang['search_results'] = $search_results ;
//esto es algo repetitivo ... w
$page1 = parsetemplate(gettemplate('search_body'), $lang);
display($page1,$lang['Search']);



#########################################################################################
#########################################################################################
#########################################################################################
function doquery($query, $table, $fetch = false)
{
  global $numqueries, $sql ;


	$sqlquery = mysql_query(str_replace("{{table}}", "phpsim_".$table, $query) ) or 

	$numqueries++;

	if($fetch)
	{ //hace el fetch y regresa $sqlrow
		@$sqlrow = mysql_fetch_array($sqlquery);
		return $sqlrow;
	}
	else
	{
		return $sqlquery;
	}
	
}
#########################################################################################
function parsetemplate($template, $array)
{
	foreach($array as $a => $b) {
		$template = str_replace("{".$a."}", $b, $template);
	}
	return $template;
}
#########################################################################################
function gettemplate($templatename)
{ 
global $userrow;

	$filename =  "templates/".$userrow['template']."/" . $templatename . ".html";
	return ReadFromFile($filename);
}
#########################################################################################
// to get the langueuage texts
function includelangue()
{

lang("search");

}
#########################################################################################
function ReadFromFile($filename){

	$f = fopen($filename,"r");
	$content = fread($f,filesize($filename));
	fclose($f);
	return $content;
}
#########################################################################################
function display($page1,$title = '',$topnav = true,$metatags=''){
	global $link,$game_config,$debug,$page;

	@$page .= "<center>".$page1."</center>";
}

?>