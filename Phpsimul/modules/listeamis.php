<?php

// Si la constante n'est pas defini on bloque l'execution du fichier
if(!defined('PHPSIMUL_PAGES') || @PHPSIMUL_PAGES != 'PHPSIMULLL') 
{
die('Erreur 404 - Le fichier n\'a pas été trouvé');
}

lang("listeamis");

/* PHPsimul : Créez votre jeu de simulation en PHP
Copyright (©) - 2007 - CAPARROS Sébastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr


Mod Liste Des Amis

Créer par Max485 Pour PHPSimul (Concu a l'origine pour Ugamela par Perberos)

################################################

Pour permettre d'arrivé sur cette page a partir d'une autre, inserée ce lien dans les pages:

<a href='index.php?mod=listeamis&a=2&u=".$user['id']."'>Devenir Amis<a>

Bien sur $user['id'] est l'id du joueur avec lequel devenir amis, il est donc nessccessaire d'ouvrir une requete sql avant ^^
################################################
Infos sur la table SQL (phpsim_listeamis) :

sender => L'emetteur de la demande
owner => Le destinataire de la demande
active => Si =0 alors la demande est en cours, et n'a pas encore été prise en compte
text => Le message de la demande
*/

extract($_GET); // on extrait les GET pour pouvoir les traité comme des variables
##############################################################################################
/* On traite une requete Supprimer/Accpeter/Refuser */
if(@$s == 1 && isset($bid) ) //Supprimez un amis
{ // debut if traitement requete

	$buddy1 = mysql_query("SELECT * FROM phpsim_listeamis WHERE id=".$bid);
	$buddy = mysql_fetch_array($buddy1) ;
	if($buddy["owner"] == $userrow["id"]) // Si l'emetteur est le joueur demandant la requete
	{
		if(@$buddy["active"]==0 && @$a==1) // le joueur a refusé de devenir amis
		{
			mysql_query("DELETE FROM phpsim_listeamis WHERE id=$bid");
			@$page .= "<font size='+2'><b></b></font>";
		}
		elseif($buddy["active"]==1) // la demande etait active 
		{
			mysql_query("DELETE FROM phpsim_listeamis WHERE id=".$bid); 
			@$page .= "<font size='+2'><b></b></font>";
		}
		elseif($buddy["active"]==0) // la demande n'avait pas encore été accepté, l'emetteur a voulu l'acceptez
		{
			mysql_query("UPDATE phpsim_listeamis SET active=1 WHERE id=".$bid);
			@$page .= "<font size='+2'><b></b></font>";
		}
	}
	elseif($buddy["sender"] == $userrow["id"]) // si le destinataire est a l'origine de la requete, alors il veut annulez sa demande
	{
			mysql_query("DELETE FROM phpsim_listeamis WHERE id=".$bid);
			@$page .= "<font size='+2'><b></b></font>";
	}

} // fin if traitement requete
##############################################################################################
/* Lorsqu'une demande a été envoyer on rejoint cette partie pour envoyer la demande */

elseif(@$_POST["s"] == 3 && $_POST["a"] == 1 && $_POST["e"] == 1 && isset($_POST["u"]) )
{
	$uid = $userrow["id"];
	$u = $_POST["u"];
	
	$buddy1 = mysql_query("SELECT * FROM phpsim_listeamis WHERE sender=$uid AND owner=$u  OR sender=$u AND owner=$uid ");
	$buddy = mysql_fetch_array($buddy1) ;
	
	if(!$buddy){
		
		$text = addslashes($_POST["text"]) ;
		mysql_query("INSERT INTO phpsim_listeamis SET sender=$uid, owner=$u, active=0, text='$text' ");
	    @$page .= "<font size='+2'><b>Demande envoyée au joueur</b></font>" ;
	}
	else
	{ 
       @$page .= "<font size='+2'><b>".$lang["dejademande"]."</b></font>";
	}

}
##############################################################################################

@$page .= "<center><br>";

/* Formulaire pour envoyer les messages de demande d'amis */
if(@$a == 2 && isset($u)) // Formulaire pour faire une demande d'amis
{

	$u1 = mysql_query("SELECT * FROM phpsim_users WHERE id=$u");
	$u = mysql_fetch_array($u1) ;

	if(isset($u) && $u["id"] != $userrow["id"]) // si le joueur veut s'ajouter lui meme alors on blok ($userrow['id'] = $_POST['id'])
	{
		@$page .= "
		<center>
		<form action='index.php?mod=listeamis' method='post'>
		<input type=hidden name=a value=1>
		<input type=hidden name=s value=3>
		<input type=hidden name=e value=1>
		<input type=hidden name=u value=".$u["id"].">
		<table width=519><tr>
		<td class=c colspan=2><b><font size='+2'>".$lang["demandeamis"]."</font><br><br></b></td></tr>
		<tr><th>".$lang["joueur"]."</th><th>".$u["nom"]."<br><br></th></tr>
		<tr><th>".$lang["msg"]."</th>
		<th><textarea name=text cols=60 rows=10></textarea></th></tr>
		<tr><td class=c><a href=\"javascript:back();\">".$lang["retour"]."</a></td>
		<td class=c><input type=submit value='Envoyer'></td></tr></table>
		</form></center></body></html>";

	}
	elseif($u["id"] == $userrow["id"]) // si le joueur a voulu s'ajouter lui meme
	{
        @$page.= "<h1>".$lang["pastoimeme"]."</h1><br><br>
        <a href='javascript:history.back();'><h3>".$lang["retour"]."</h3></a>
        ";
	}

}
##############################################################################################
/* Pour affichez la page si le formulaire n'a pas été demandé */
else
{
@$page .= "<table width=519>\n<tr>\n  <td class=c colspan=6>\n";

// Si le joueur a cliqué pour voir les demande, alors a = 1 on passe dans le if qui affiche 
// les demande suivant le type de demande souhaité, ou alors qui affiche liste des amis
// si rien a été demandé
if(@$a == 1) $page .= (@$e == 1) ? "<b><font size='+2'>".$lang["mesdemandes"]."</font></b><br><br>":"<b>
                      <font size='+2'>".$lang["autresdemandes"]."</font></b><br><br>"; 
else $page .= "<b><font size='+2'>".$lang["listeamis"]."</font></b>";


$page .= "</td>\n
          </tr>\n
         ";

// Si le joueur n'a pas demandé de voir des demandes, alors on passe ici
if(!isset($a) )
{
	$page .= "<tr><th colspan=6><a href=index.php?mod=listeamis&a=1>".$lang["demandes"]."</a></th></tr>";
	$page .= "<tr><th colspan=6><a href=index.php?mod=listeamis&a=1&e=1>".$lang["mesdemandes"]."</a><br><br></th></tr>";
	$page .= "<tr><td class=c></th>";
	$page .= "<th class=c>".$lang["nom"]."</th>";
	$page .= "<th class=c>".$lang["alli"]."</th>";
	$page .= "<th class=c>".$lang["coord"]."</th>
	          <th class=c>".$lang["pos"]."</th>";
	$page .= "<th class=c></th></tr>\n";
}

##############################################################################################
// Si le joueur a demandé de voir les demandes pour devenir amis
	if(@$a == 1) 
	{  
	    // Si le joueur a demandé ses propres demandes alors e=1 on lance donc la requete pour ses propres demande
	    // sinon on lance la requete pour la demande effectué pas les autres joueurs pour lui
		$query = (@$e == 1) ? "WHERE active=0 AND sender=".$userrow["id"] : "WHERE active=0 AND owner=".$userrow["id"];
	}
	else // Si le joueur n'a pas demander de voir les demande alors on passe ici pour compsez la requete de la liste d'amis
	{
		$query = "WHERE active=1 AND sender=".$userrow["id"]." OR active=1 AND owner=".$userrow["id"] ;
	}
	if(@$user['authlevel'] && !$a && !$e) // si ce n'est point les listes des demande en cours qui est demandé on passe ici
	{                                     // le userauthlevel, permet de ne pas passez par la si aucune requete sur un joueur
	                                      // n'a été effecuté. 
	                                      // Pourquoi authlevel ? car c'etait comme ca sur ugamela, et que ca change rien qu'on le laisse
	                                      // ou qu'on mette un autre champ de la table user ...
		$buddyrow = mysql_query("SELECT (id) as owner,id as sender FROM phpsim_users ");
	}
	else // si c'est les demandes qui sont demandé alors on arrive la
	{
		$buddyrow = mysql_query("SELECT * FROM phpsim_listeamis ".$query );
	}
	while($b = mysql_fetch_array($buddyrow) )
	{
		// Pour affichez les amis
		if(!isset($i) && isset($a) )
		{	
		$page .= "	<tr>\n  
		            <th class=c></td>\n  
		            <th class=c>".$lang["joueur"]."s</th>\n  
		            <th class=c>".$lang["alli"]."s</th>\n  
		            <th class=c>".$lang["coord"]."</th>\n  
		            <th class=c>".$lang["txt"]."</th>\n  
		            <th class=c></th>\n
		            </tr>
		          ";
		}
		
		@$i++;
		$uid = ($b["owner"] == $userrow["id"]) ? $b["sender"] : $b["owner"];
		// Requete pour voir les utilisateurs
		$u1 = mysql_query("SELECT * FROM phpsim_users WHERE id=".$uid);
		$u = mysql_fetch_array($u1) ;
		
		$page .= "<tr>
		<th width=20>".$i."</th>
		<th><a href=index.php?mod=ecrire&destinataire=".$u["nom"].">".$u["nom"]."</a></th>
		<th>";
		
		if($u["alli"] != 0) // si le joueur a une alliance, on recupere son nom
		{
			$allyrow1 = mysql_query("SELECT * FROM phpsim_alliance WHERE id=".$u["alli"] );
			$allyrow = mysql_fetch_array($allyrow1) ;
			
			if($allyrow)
			{
				$page .= "<a href=index.php?mod=alliances/voiralli|".$allyrow["id"].">".$allyrow["nom"]."</a>";
			}
		}
		
		// on recupere la base principal du joueur
		$bases2 = explode(",", $u['bases']);	
		$bases1 = mysql_query("SELECT * FROM phpsim_bases WHERE id=".$bases2[0] ) ;
		$bases_sql = mysql_fetch_array($bases1) ;

		$page .= "</th><th><a href=\"index.php?mod=map|".$bases_sql["ordre_1"]."|".$bases_sql["ordre_2"]."\">";
		$page .= $bases_sql["ordre_1"].":".$bases_sql["ordre_2"].":".$bases_sql["ordre_3"]."</a></th>\n<th>"; // Coor de la planete principal

		if(isset($a) ) // si on demande a voir une demande on post le texte de la demande
		{
		    // les fonction ajouté permettent de virer les slash qui aurait pu etre ajouté, puis desactivé le html
		    // puis sauter des ligne si il y a des ligne a sauté
			$page .= nl2br(htmlentities(stripcslashes($b["text"]))) ;
		}
		else // sinon on poste off/on suivant que le joueur soit en ligne ou pas
		{
			$page .= "<font color=";
			
			if($u["time"] +60*10 >= time() )     { $page .= "lime>".$lang["on"];       }
			elseif($u["time"] +60*20 >= time() ) { $page .= "chocolate>".$lang["15min"]; }
			else     { $page .= "red> ".$lang["off"]; }
			
			$page .= "</font>";
		}
		
		$page .= "</th><th>";
		
		if(isset($a) && isset($e) ) // si a et e contiennent quelque chose alors on veut "Mes demandes" et on affiche pour annuler notre demande
		{
			$page .= "<a href=index.php?mod=listeamis&s=1&bid=".$b["id"].">".$lang["anndem"]."</a>";
		}
		elseif(isset($a) ) // si juste a est rempi alors on veut "Demandes" et on affiche le texte des demande
		{
			$page .= "<a href=index.php?mod=listeamis&s=1&bid=".$b["id"].">".$lang["accepter"]."</a><br/>";
			$page .= "<a href=index.php?mod=listeamis&a=1&s=1&bid=".$b["id"].">".$lang["refuser"]."</a></a>";
		}
		else // si rien est rempli, on veut la liste des amis et on affiche pour virer l'amis
		{ 
		$page .= "<a href=index.php?mod=listeamis&s=1&bid=".$b["id"].">".$lang["suppr"]."</a>";}
		$page .= "</th>\n</tr>\n";
	    }
	
if(!isset($i) ) // Si rien est retournée, alors on affiche que la liste est vide
{ $page .= "<th colspan=6><br>".$lang["listevide"]."</th>\n";}

// Si on a demandé a voir les demande on ajoute un bouton retour
if(@$a == 1) $page .= "<tr><td class=c><a href='index.php?mod=listeamis'><b>".$lang["retour"]."</b></a></td></tr>";

$page .= "</table>\n</center>";

}
?>
