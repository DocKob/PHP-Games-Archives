<?php

// Modifié le 14 Aout 2008 18h15 => Changement des variable $bases en leur donnant un autre nom, car elle plantait la variable $bases deja existante, qui contenant les fonctions de la classe ...



// Si la constante n'est pas defini on bloque l'execution du fichier
if(!defined('PHPSIMUL_PAGES') || @PHPSIMUL_PAGES != 'PHPSIMULLL') 
{
die('Erreur 404 - Le fichier n\'a pas été trouvé');
}

/* PHPsimul : Créez votre jeu de simulation en PHP
Copyright (©) - 2007 - CAPARROS Sébastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr


Créer par NumYor pour PHPSimul

Modifié par max485, pour permettre la vue de tous ce qui conserne le joueur suivant ce qui a été autorisé a voir dans l'administration

*/

lang("profil");

$page = "
<style>.lien_alliance { text-decoration: none; } </style>
<center><a href='javascript:history.back();'>Retour</a><br><br>
<h3>Profil Général</h3>
<table border='1' width='600'>
<tr>
<th>".$lang["place"]."</th>
<th>".$lang["pseudo"]."</th>
<th>".$lang["points"]."</th>
<th>".$lang["race"]."</th>
<th>".$lang["alliance"]."</th>
<th>".$lang["deco"]."</th>
<th>".$lang["admin"]."</th>
<th>".$lang["action"]."</th>
</tr>";

$b = $sql->select("SELECT * FROM phpsim_users WHERE id='".$mod[1]."' ");

if ($b['alli'] != 0 ) {
$c = mysql_query("SELECT * From phpsim_alliance where id='".$b['alli']."'");
while ($d = mysql_fetch_array ($c)) {	$alli2=$d['tag']; }}

$e = mysql_query("SELECT race_".$b['race']." as race From phpsim_config ");
while ($f = mysql_fetch_array ($e)) {

if ( $b["administrateur"]== 1 ){
$admin = "OUI";	}
else
$admin = "NON";

if ( $b['alli'] == 0 ){
$alli = $lang["aucune"];	}

elseif ( $b['alli'] != 0 ){
$alli = "<a class='lien_alliance' href='index.php?mod=alliances/voiralli|".$alli2."'>
         <span class='lien_dans_vprofils'>".$alli2."</font></a>"; }

// On calcule la place du joueur dans le classement
$classement2 = $sql->query("SELECT * FROM phpsim_users ORDER BY points DESC") ;
$place = "0";
while($classement1 = mysql_fetch_array($classement2) ) 
{ 
if($classement1['nom'] != $b['nom']) { $place++; }
else { $classement = $place + 1 ;  break; }
}

$onlinetime = explode('-',$b['onlinetime']); // on remet la date dans un format jj/mm/aaaa

$page .= " 
<tr>
<td>".$classement."</td>
<td><center><a class='lien_alliance' href='index.php?mod=ecrire&destinataire=".$b['nom']."'><span class='lien_dans_vprofils'>".$b['nom']."</font></a></td>
<td><center>".$b['points']."</td>
<td><center>".$f["race"]."</td>
<td><center>".$alli."</td>
<td><center>".$onlinetime[2]."/".$onlinetime[1]."/".$onlinetime[0]."</td>
<td><center>".$admin."</td>
<td><center><a href='index.php?mod=listeamis&a=2&u=".$b['id']."'>
<img title='Proposer de devenir amis' alt='Proposer de devenir amis' src='templates/" . $userrow["template"] . "/images/listeamis.gif.png'></a>
</td></tr>
";
}


$page.="</table><br><h3>".$lang["avatar"]."</h3><a href='?mod=avatars|".$b['id']."'>
        <img width='15%' src='".$b['avatar']."'></a><br>";
#############################################################################################################
if($controlrow['vprofil_voirplanetes'] == 1)
{ // debut if controlrow vue des bases
$page.= "<br>
<h3>".$lang["emplacementpl"]."</h3>
<table border='1'><tr><th>".$lang["nompl"]."</th><th>".$lang["coord"]."</th></tr>
";

$bases1 = explode(",",$b['bases']) ;

foreach($bases1 as $bases_all)
{ // debut foreach traitement bases

$base_une = $sql->select("SELECT * FROM phpsim_bases WHERE id='".$bases_all."' "); // On recupere mes infos de la base

$page.="
<tr><td><center>".$base_une['nom']."</td>
<td><center><a class='lien_alliance' href='index.php?mod=map|".$base_une['ordre_1']."|".$base_une['ordre_2']."'>
<span class='lien_dans_vprofils'>".$base_une['ordre_1'].":".$base_une['ordre_2'].":".$base_une['ordre_3']."
</font></a></td></tr>
";
} // fin foreach traitement bases
} // fin if controlrow vue des bases

$page .="</table>";
#############################################################################################################
if($controlrow['vprofil_voirbatiments'] == 1)
{
$bases1 = explode(",",$b['bases']) ;

foreach($bases1 as $bases_all)
{ // debut foreach traitement bases

$bases2 = $sql->select("SELECT * FROM phpsim_bases WHERE id=".$bases_all ) ;

$page .= "<br><h3>".$lang["batpl"]." ".$bases2['nom']."</h3><table border='1' width='400'><tr><th>".$lang["nom"]."</th><th>".$lang["niv"]."</th></tr>";
$bases2["batiments"] = "0," . $bases2["batiments"];
$niv = explode(",", $bases2["batiments"]);
$batquery = sql::query("SELECT * FROM phpsim_batiments WHERE race_".$b['race']."='1' ORDER BY ordre");
while ($batrow = mysql_fetch_array($batquery)) {
    if ($niv[$batrow["id"]] == "" || $niv[$batrow["id"]] == 0) {
        $niveau = "<center> 0 ";
    } else {
        $niveau = "<center>" . $niv[$batrow["id"]] ;
    }

$page.="<tr><td>".$batrow['nom']."</td><td>".$niveau."</td></tr> ";

}

$page.= "</table>";

} // fin foreach traitement bases

}
#############################################################################################################
if($controlrow['vprofil_recherches'] == 1)
{

$page .= "<br><h3>".$lang["rechj"]."</h3><table border='1' width='400'><tr><th>".$lang["nom"]."</th><th>".$lang["niveau"]."</th></tr>";
$b["recherches"] = "0," . $b["recherches"];
$niv = explode(",", $b["recherches"]);
$batquery = sql::query("SELECT * FROM phpsim_recherches WHERE race_".$b['race']."='1' ORDER BY ordre");
while ($batrow = mysql_fetch_array($batquery)) {
    if (@$niv[$batrow["id"]] == "" || $niv[$batrow["id"]] == 0) {
        $niveau = "<center> 0 ";
    } else {
        $niveau = "<center>" . $niv[$batrow["id"]] ;
    }

$page.="<tr><td>".$batrow['nom']."</td><td>".$niveau."</td></tr> ";

}

$page.= "</table>";


}

#############################################################################################################
if($controlrow['vprofil_flottes'] == 1)
{

$bases1 = explode(",",$b['bases']) ;

foreach($bases1 as $bases_all)
{ // debut foreach traitement chantier

$bases2 = $sql->select("SELECT * FROM phpsim_bases WHERE id=".$bases_all ) ;

$page .= "<br><h3>".$lang["fljpl"]." ".$bases2['nom']."</h3><table border='1' width='400'><tr><th>".$lang["nom"]."</th><th>".$lang["qte"]."</th></tr>";

$baseunites = "0," . $bases2["unites"];
$niv = explode(",", $baseunites);
$batquery = sql::query("SELECT * FROM phpsim_chantier WHERE race_".$b["race"]."='1' ORDER BY ordre");
    while ($batrow = mysql_fetch_array($batquery)) {
        if (!isset($niv[$batrow["id"]]) || $niv[$batrow["id"]] == 0) {
            $niveau = "<center> 0 ";
        } else {
            $niveau = "( " . $niv[$batrow["id"]] . " disponibles )";
        }

        $page.="<tr><td>".$batrow['nom']."</td><td><center>".$niveau."</td></tr>";
    }

$page.="</table>";

} // fin foreach traitement chantier
}

#############################################################################################################
if($controlrow['vprofil_status'] == 1)
{
$page .= "<br><h3>".$lang["statusj"]."</h3>
<b>Etat : <font color=";
			
if($b["time"] + 120 >= time() )     { $page .= "lime>On";       }
elseif($b["time"] + 900 >= time() ) { $page .= "yellow>15 Min"; }
elseif($b["time"] + 1800 >= time() ) { $page .= "yellow>30 Min"; }
elseif($b["time"] + 2400 >= time() ) { $page .= "yellow>40 Min"; }
elseif($b["time"] + 3000 >= time() ) { $page .= "yellow>50 Min"; }
elseif($b["time"] + 3600 >= time() ) { $page .= "yellow>1 Heure"; }
else     { $page .= "red> Off"; }

$page.="</b></font><br><br><b>".$lang["derco"]."</b> ".date('d/m/Y à H \H i',$b["time"]) ;


}

  
/*

Créer par NumYor

Amelioré par Max485

Pour PHPSimul

*/

?>