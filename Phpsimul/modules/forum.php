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


Mod Forum

Permet d'avoir un forum dans le jeu, et un forum par alliance

Codé par Camaris et modification apportés par Max485

*/
###########################################################################################################

lang("forum");


if (isset($_GET["do"])) 
{
	$do = explode(":",$_GET["do"]);
	
	if ($do[0] == "liste") { $page = liste($do[1], $do[2]); }
	elseif ($do[0] == "repond") { $page = repond($do[1], $do[2]); }
	elseif ($do[0] == "poster") { $page = poster($do[1]); }
	elseif ($do[0] == "modif") { $page = modif($do[1], $do[2]); }
	elseif ($do[0] == "suppr") { $page = suppr($do[1], $do[2]); }
	elseif ($do[0] == "list") { $page = voirforum($do[1], $do[2]); }
	elseif ($do[0] == "voirforum") { $page = voirforum($do[1]); }
	
} else { $page = normal(); }
###########################################################################################################
function normal()
{

global $sql;
global $userrow;
global $lang;

$query = $sql->query("SELECT * FROM phpsim_forums WHERE alliance='0'");
$page = "
<b><u>".$lang["accforum"]."</u></b><br><br>
<table width='80%' border=1><tr><td width='45%'>".$lang["nom"]."</td><td width='10%'>".$lang["nbsujets"]."</td><td width='10%'>".$lang["nbmsg"]."</td><td width='15%'>".$lang["derniermsg"]."</td></tr>\n";

while ($row = mysql_fetch_array($query)) { 

$nbsr=$sql->select("SELECT COUNT(*) as 'nbsujets' FROM phpsim_posts WHERE forum_id='".$row["id"]."'");
$row["nbsujets"] = $nbsr["nbsujets"];

$nbmr=$sql->select("SELECT COUNT(*) as 'nbmessages' FROM phpsim_discussions WHERE forum_id='".$row["id"]."'");
$row["nbmessages"] = $nbmr["nbmessages"];

$page .= "<tr><td><a href='index.php?mod=forum&do=voirforum:".$row["id"]."'>".$row["nom"]."</a>
          <br>".$row["description"]."</td><td>".$row["nbsujets"]."</td><td>".$row["nbmessages"]."</td>
          <td>".$row["dernier"]."</td></tr>\n"; 
}

$page .="</table>";

return $page;

}
###########################################################################################################
function voirforum($idforum) {

global $lang;

include("classes/bb.class.php");

$bb = new bb;

global $userrow;
global $do ;

$d = intval($_GET['d']); //Pour changer de pages

(empty($d))? $d=1: 0;
$dbt = $d*20 - 20;

$req_frm = mysql_query("SELECT COUNT(*) FROM phpsim_posts WHERE forum_id='".$idforum."' AND type='N' OR type='T'");
list($nb_s) = mysql_fetch_array($req_frm);
$nb_s--;

$req_list = mysql_query("SELECT phpsim_posts.*, phpsim_users.nom AS username     
FROM phpsim_posts LEFT JOIN phpsim_users ON phpsim_users.id=phpsim_posts.mb_id  WHERE phpsim_posts.forum_id='".$idforum."' ORDER BY id DESC, phpsim_posts.rep DESC LIMIT ".$dbt.", 20");


@$page .= '<span class="p"><a href="index.php?mod=forum&do=voirforum:".$do[1]."">'.$lang["index"].'</a>  /<br /><br />
      <a href="index.php?mod=forum&do=poster:'.$idforum.'"><img border="0" src="templates/'.$userrow["template"].'/images/forum/nouveau_message.jpg" alt="Nouveau"></a><br /><br /></span>';

$bb->div_page($nb_s,$d,$id,$cat,20);

      $page .= '<table class="tb1" style="width:750px;" border=1><b>
            <tr>
            <td class="tb2" style="width:400px;"><font size="2">'.$lang["ttmsgauteur"].'<span class="sml"><br />'.$lang["datesujet"].' </font></span> 
            </td>
            <td class="tb2" style="width:120px;"><font size="2">'.$lang["nbrep"].'</font>
            </td>
            <td class="tb2" style="width:220px;"><span class="sml"><font size="2">'.$lang["derep"].'<br /> '.$lang["auteur"].'</font></span>
            </td>
            </tr></table></b><br />';

$page .= '<table style="width:750px;" border=1>';

if(mysql_num_rows($req_list) <= 0) {
$page .= $lang["pasmsg"];
}

while ($list = mysql_fetch_array($req_list))
 {

$page .= '<tr><td class="tb2" style="width:400px;text-align:left;"><span class="p">';
	 
if($list['rep'] > (time()-3600*48))

if($list['type']=='T') echo $lang["epingle"].' ';

$page .= "<strong><a href='index.php?mod=forum&do=liste:".$list['id'].":".$idforum."'>
         ".htmlentities(stripcslashes($list['titre']))."</a></strong> ".$lang["par"]." <strong>";


($list['nbrep'] <= 1)? $s="" : $s="s";

if($list['mb_id'] != 0)
{
 $page .= '<b>'.htmlentities(stripcslashes($list['pseudo'])).'</b>';
}
else
{
 $page .= ' '.htmlentities(stripcslashes($list["pseudo"])).' ';
}
$page .= "</strong>";



$page .= "</span><span class='sml'>";


$page .= "<br />".$lang["postele"]." ".$list['date']."</span></td>";


$page .= '<td class="tb2" style="width:120px;text-align:center;">';
$page .= "<span class='p'><strong>".$list['nbrep']."</strong> ".$lang["reponse"].$s."</span>";
$page .= '</td>';
$page .= '<td class="tb2" style="width:220px;text-align:left;">';
if(!empty($list['lp_pseudo']))
{
	$page .= ' <a href="index.php?mod=forum&do=liste:'.$list["id"].'">
	         '.htmlentities(stripcslashes($list["lp_titre"])).'</a><br />';
	
if($list['lp_mb_id']>0)
{
    $page .= $lang["par2"].' <b>'.htmlentities(stripcslashes($list['lp_pseudo'])).'</b>';
}
else
{
    $page .= $lang["par2"].' '.htmlentities(stripcslashes($list[lp_pseudo]));
}
}
else
{
    $page .= $lang["norep"];
}
    $page .= '</td></tr>';

 }
$page .= '</table><br /><br>';

$page .= '<a href="index.php?mod=forum&do=poster:'.$idforum.'"><img alt="" style="border:0px;" src="templates/'.$userrow["template"].'/images/forum/nouveau_message.jpg" /></a><br>';

$bb->div_page($nb_s,$d,$id,$cat,20);

return $page;

}
###########################################################################################################
function liste($id, $idforum) {

global $userrow;
global $sql;
global $lang;

include("classes/bb.class.php");

$bb = new bb();

$req = mysql_query("SELECT * FROM phpsim_discussions WHERE message_id='$id' AND forum_id='".$idforum."' ORDER BY id DESC");
$nb = mysql_num_rows($req)-1;
$infos_disc = mysql_fetch_array($req);


$infos_disc['titre'] = htmlentities($infos_disc['titre']);
$infos_disc['titre'] = stripcslashes($infos_disc['titre']);

@$page .= "<span class='p'><a href='?mod=forum&do=voirforum:".$idforum."'>".$lang["acc"]."</a> /</span>";



$page .= "<br />
<br />
<a href='index.php?mod=forum&do=poster:".$idforum."'><img alt='' style='border:0px;' src='templates/".$userrow["template"]."/images/forum/nouveau_message.jpg' /></a>&nbsp<a href='index.php?mod=forum&do=repond:".$id.":".$idforum."'><img alt='' style='border:0px;' src='templates/".$userrow["template"]."/images/forum/repondre.jpg' /></a>
<br />
<br />";

$req_ms = mysql_query("SELECT * FROM phpsim_discussions WHERE message_id='$id' ORDER by id");


$page .= '<br />';

$page .= '<table style="width:750px;" border=1>';

while ($ms = mysql_fetch_array($req_ms) )
 {

$user = $sql->select("SELECT * FROM phpsim_users WHERE id='".$ms["mb_id"]."' LIMIT 1");

    $page .= '<tr>';
    $page .= '<td class="tb2" style="width:150px;text-align:left;padding-left:4px;" valign="top"><a id="id'.$ms['id'].'"></a>';

	$page .= '<b>'.htmlentities(stripcslashes($user["nom"])).'</b><br /><span class="p"></span>';
if (@$user["alli"] != 0 && @$user["alli"] != "")
{
$guilde=$sql->select("SELECT nom
FROM phpsim_alliance WHERE id='".$user["alli"]."'");
$ms["guilde"]=$guilde["nom"];
}
else
{
$ms["guilde"]=$lang["pasalli"];
}

	$page .= $lang["alli"].' '.htmlentities(stripcslashes($ms["guilde"]))."<br />";
	$page .= $lang["pts"].' '.htmlentities(stripcslashes($user["points"])).'<br />';
	
	if(@$user["avatar"] != "")
	{ 
	$page .= '<a href="?mod=avatars|'.$user["id"].'"><img width="75px" src="'.$user["avatar"].'" style="border:0px;" /></a>';
	}
	
	$page .= '</td>';
	
	$page .= '<td class="tb2" style="width:600px;" valign="top"><span class="p"><strong>'.$lang["postele"].' '.$ms['date'].'</strong></span>&nbsp;&nbsp;&nbsp;';
	
	if($userrow['nom'] == $user['nom'])
	{
	$page .= '<strong><font size="2">[</font><a href="index.php?mod=forum&do=modif:'.$ms['id'].':'.$idforum.'">'.$lang["editer"].'</a><font size="2">]</font></strong>';
	}

	
	$page .= '<hr /><span class="p" align=left>';
		
	$page .= ' '.$bb->smileys($bb->bbcode($ms["message"])).' ';
		
	$page .= '<br /><br /></span><span class="sml">'.$ms['edit'].'</span><span class="p">
        <br>________________________<br />
        '.$bb->bbcode($user["signature"]).'<br /><br /></span></td>';

    $page .= '</tr>';
  
}  
 
$page .='<tr><td></td></tr></table>';

$page .= "<br><br><a href='index.php?mod=forum&do=poster:".$idforum."'><img alt='' style='border:0px;' src='templates/".$userrow["template"]."/images/forum/nouveau_message.jpg' /></a>&nbsp<a href='index.php?mod=forum&do=repond:".$id.":".$idforum."'><img alt='' style='border:0px;' src='templates/".$userrow["template"]."/images/forum/repondre.jpg' /></a>";

$page .= '<br />';

return $page;

}
###########################################################################################################
function repond($id, $idforum) {

global $userrow;
global $lang;

$infos = mysql_query("SELECT * FROM phpsim_posts WHERE id='$id' ORDER BY id DESC");
$frm = mysql_result($infos,0,"forum_id");
$titre_def = mysql_result($infos,0,"titre");


@$page .= '<span class="p"><br /><a href="javascript:history.back(1);">&lt;-'.$lang["retour"].'</a><br /><br /></span>';

include("classes/bb.class.php");

$bb = new bb;

@$envoi = $_POST['envoi'];
@$titre = $_POST['titre'];
@$textem = $_POST['textem'];

if(!$titre)
{
 $titre = $titre_def;
}

$titre = trim($titre);

 if(strlen($titre)>27)
  {
  $titre = substr($titre, 0, 27);
  $titre = "$titre"."...";
  }


$pseudo = $userrow['nom'];

if(!empty($envoi) AND !empty($textem) AND !empty($titre))
 { 

$textem = addslashes($textem);
$titre  = addslashes($titre);
$date=date("d/m/Y à H:i:s");

mysql_query("INSERT INTO phpsim_discussions 
          (id, message, pseudo, titre, date, forum_id, message_id, edit, mb_id) 
          VALUES('', '".$textem."', '".$userrow["nom"]."', '$titre', '$date', '$idforum', '$id', '', '".$userrow['id']."')");
$lp_id = mysql_insert_id();
mysql_query("UPDATE phpsim_posts SET rep='".time()."', nbrep=nbrep+1, lp_mb_id='".$userrow['id']."', lp_pseudo='$pseudo', lp_titre='$titre' WHERE id='$id'");
   
   $page .= '<script type="text/javascript">document.location="index.php?mod=forum&do=liste:'.$id.':'.$idforum.'";</script>';

 }


$page .= '<div style="width:100%;margin:auto;">';

$page .= '<form id="add_message" name="formu" action="" method="post">
      <p style="text-align:center;"><label for="titre"><b><u>'.$lang["titre"].'</b></u> '.$titre.'</label><br />';

$page .= '<script language="javascript" type="text/javascript" src="modules/js_divers.js"></script>
<br />'.$lang["msg"].' <br /><textarea id="texte" name="textem" cols="80" rows="10" ></textarea><br />';

$page .= '<a href="javascript:emoticon(\':D\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/sourire.gif" border=0></a> <a href="javascript:emoticon(\';\)\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/clin.gif" border=0></a> <a href="javascript:emoticon(\':\(\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/triste.gif" border=0></a> <a href="javascript:emoticon(\':surpris:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/yeuxrond.gif" border=0></a> <a href="javascript:emoticon(\':o\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/etonne.gif" border=0></a> <a href="javascript:emoticon(\':confus:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/confus.gif" border=0></a> <a href="javascript:emoticon(\':lol:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/lol.gif" border=0></a> <a href="javascript:emoticon(\':fire:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/flame.gif" border=0></a> <a href="javascript:emoticon(\':splif:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/petard.gif" border=0></a> <a href="javascript:emoticon(\':bigsmile:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/green.gif" border=0></a> <a href="javascript:emoticon(\':x\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/mad.gif" border=0></a> <a href="javascript:emoticon(\':roll:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/rolleyes.gif" border=0></a> <a href="javascript:emoticon(\':bigcry:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/crying.gif" border=0></a> <a href="javascript:emoticon(\':colere:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/colere.gif" border=0></a> <a href="javascript:emoticon(\':P\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/razz.gif" border=0></a> <a href="javascript:emoticon(\'8\)\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/lunettes.gif" border=0></a> <a href="javascript:emoticon(\':\)\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/sourire2.gif" border=0></a> <a href="javascript:emoticon(\'^^oops:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/redface.gif" border=0></a>';
$page .= '<br />';
$page .= '<select class=taille2 onchange="bbfontstyle(\'[color=\' + this.form.select.options[this.form.select.selectedIndex].value + \']\', \'[/color]\');this.selectedIndex=0;" name=select><option style="color: black;" value=black>Couleur</option><option style="color: grey;" value=grey>Gris</option><option style="color: white;" value=white>Blanc</option><option style="color: yellow;" value=yellow>Jaune</option><option style="color: green;" value=green>Vert</option><option style="color: red;" value=red>Rouge</option><option style="color: blue;" value=blue>Bleu</option></select> <input onclick="TAinsert(\'([b]\',\'[/b]\',\'texte\');" type=button value=gras class=taille2> <input onclick="TAinsert(\'[i]\',\'[/i]\',\'texte\');" type=button value=italique class=taille2> <input onclick="TAinsert(\'[u]\',\'[/u]\',\'texte\');" type=button value=souligné class=taille2> <input onclick="TAinsert(\'[url]\',\'[/url]\',\'texte\');" type=button value=url class=taille2> <input onclick="TAinsert(\'[img]\',\'[/img]\',\'texte\');" type=button value=img class=taille2> <input onclick="TAinsert(\'[size=4]\',\'[/size]\',\'texte\');" type=button value="Plus gros" class=taille2> <input onclick="TAinsert(\'[quote]\',\'[/quote]\',\'texte\');" type=button value="Citation" class=taille2><input onclick="TAinsert(\'[code]\',\'[/code]\',\'texte\');" type=button value="Code" class=taille2>';

$page .= '<br /><br /><input type="submit" id="envoi" name="envoi" value="Envoyer" />';

$page .= '</p>
      </form>';

$page .= '</div>';

return $page;

}
###########################################################################################################
function poster($idforum) {

global $userrow;
global $lang;

@$page .= '<span class="p"><br /><a href="javascript:history.back(1);">&lt;-'.$lang["retour"].'</a><br /><br /></span>';


@$envoi = $_POST['envoi'];
@$titre = $_POST['titre'];
@$textem = $_POST['textem'];
@$toppost = $_POST['toppost'];
@$titre = trim($titre);

 if(strlen($titre)>27)
  {
  $titre = substr($titre, 0, 27);
  $titre = "$titre"."...";
  }
  
$pseudo = $userrow['nom'];

if(!empty($envoi) AND !empty($textem) AND !empty($titre) AND !empty($pseudo))
 { 

$textem = addslashes($textem);
$titre  = addslashes($titre);
$date=date("d/m/Y à H:i:s");

mysql_query("INSERT INTO phpsim_posts (id, pseudo, titre, date, forum_id, type, mb_id, rep, nbrep, lp_mb_id, lp_pseudo, lp_titre) VALUES('', '$pseudo', '$titre', '$date', '$idforum', '$toppost', '".$userrow['id']."', '".time()."' ,'0', '', '', '')");
$lid =  mysql_insert_id();
mysql_query("INSERT INTO phpsim_discussions (id, message, pseudo, titre, date, forum_id, message_id, edit, mb_id) VALUES('', '$textem', '$pseudo', '$titre', '$date', '$idforum', '$lid', '', '".$userrow['id']."')");

$texte="<a href='index.php?mod=forum&do=liste:".$lid.":".$idforum."'>".$titre."</a><br>".$lang["par2"]." <b>".$userrow["nom"]."</b><br>Le ".$date;

mysql_query("UPDATE phpsim_forums SET dernier='".$texte."' WHERE id='".$idforum."'");

$page .= "<center>".$lang["bienenregistre"]."<br><br><a href='index.php?mod=forum&do=liste:".$lid.":".$idforum."'>".$lang["retour"]."</a></center>";

}
else
{

$page .= '<div style="width:100%;margin:auto;">';

$page .= '<form id="add_message" name="formu" action="" method="post">
      <p style="text-align:center;"><label for="titre">'.$lang["titre"].' <br />
      <input type="text" id="titre" name="titre" value="'.$titre.'" size="100px"></label><br />';

$page .= '<script language="javascript" type="text/javascript" src="modules/js_divers.js"></script><br />'.$lang["msg"].' <br /><textarea id="texte" name="textem" cols="80" rows="10" ></textarea><br>';
$page .= '<a href="javascript:emoticon(\':D\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/sourire.gif" border=0></a> <a href="javascript:emoticon(\';\)\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/clin.gif" border=0></a> <a href="javascript:emoticon(\':\(\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/triste.gif" border=0></a> <a href="javascript:emoticon(\':surpris:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/yeuxrond.gif" border=0></a> <a href="javascript:emoticon(\':o\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/etonne.gif" border=0></a> <a href="javascript:emoticon(\':confus:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/confus.gif" border=0></a> <a href="javascript:emoticon(\':lol:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/lol.gif" border=0></a> <a href="javascript:emoticon(\':fire:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/flame.gif" border=0></a> <a href="javascript:emoticon(\':splif:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/petard.gif" border=0></a> <a href="javascript:emoticon(\':bigsmile:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/green.gif" border=0></a> <a href="javascript:emoticon(\':x\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/mad.gif" border=0></a> <a href="javascript:emoticon(\':roll:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/rolleyes.gif" border=0></a> <a href="javascript:emoticon(\':bigcry:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/crying.gif" border=0></a> <a href="javascript:emoticon(\':colere:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/colere.gif" border=0></a> <a href="javascript:emoticon(\':P\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/razz.gif" border=0></a> <a href="javascript:emoticon(\'8\)\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/lunettes.gif" border=0></a> <a href="javascript:emoticon(\':\)\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/sourire2.gif" border=0></a> <a href="javascript:emoticon(\'^^oops:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/redface.gif" border=0></a>';
$page .= '<br />';
$page .= '<select class=taille2 onchange="bbfontstyle(\'[color=\' + this.form.select.options[this.form.select.selectedIndex].value + \']\', \'[/color]\');this.selectedIndex=0;" name=select><option style="color: black;" value=black>Couleur</option><option style="color: grey;" value=grey>Gris</option><option style="color: white;" value=white>Blanc</option><option style="color: yellow;" value=yellow>Jaune</option><option style="color: green;" value=green>Vert</option><option style="color: red;" value=red>Rouge</option><option style="color: blue;" value=blue>Bleu</option></select> <input onclick="TAinsert(\'[b]\',\'[/b]\',\'texte\');" type=button value=gras class=taille2> <input onclick="TAinsert(\'[i]\',\'[/i]\',\'texte\');" type=button value=italique class=taille2> <input onclick="TAinsert(\'[u]\',\'[/u]\',\'texte\');" type=button value=souligné class=taille2> <input onclick="TAinsert(\'[url]\',\'[/url]\',\'texte\');" type=button value=url class=taille2> <input onclick="TAinsert(\'[img]\',\'[/img]\',\'texte\');" type=button value=img class=taille2> <input onclick="TAinsert(\'[size=4]\',\'[/size]\',\'texte\');" type=button value="Plus gros" class=taille2> <input onclick="TAinsert(\'[quote]\',\'[/quote]\',\'texte\');" type=button value="Citation" class=taille2><input onclick="TAinsert(\'[code]\',\'[/code]\',\'texte\');" type=button value="Code" class=taille2>';
$page .= '<br /><br /><input type="submit" id="envoi" name="envoi" value="Envoyer" />';
$page .= '</p>
      </form>';

$page .= '</div>';

}

return $page;
###########################################################################################################
}

function suppr($id, $idforum) {

global $userrow;
global $lang;

@$page .= '<div style="margin:auto;text-align:center;">
	      <span class="p"><br />'.$lang["supprimer"].'</span>
	      <form id="suppr" action="" method="post">
	      <p><input type="submit" name="choix" value="OUI" />&nbsp
	      <style>.choisir_NON {text-decoration: none; } </style>
	      <a class="choisir_NON" href="javascript:history.back(1);"><input type="button" value="NON"></a></p>
		  </form>
		  </div>';

@$choix = $_POST['choix'];

if($choix == "OUI")
{
$id2bis=mysql_query("SELECT * FROM phpsim_discussions WHERE id='$id'");
$id2row=mysql_fetch_array($id2bis);
mysql_query("DELETE FROM phpsim_discussions WHERE id='$id' AND forum_id='".$idforum."'");
mysql_query("UPDATE phpsim_posts SET nbrep=nbrep-1 WHERE id='".$id2row["message_id"]."'");
$nbrep2bis=mysql_query("SELECT * FROM phpsim_posts WHERE id='".$id2row["message_id"]."'");
$nbrep=mysql_fetch_array($nbrep2bis);
if($nbrep["nbrep"] <= -1)
{
mysql_query("DELETE FROM phpsim_posts WHERE id='".$id2row["message_id"]."' AND forum_id='".$idforum."'");
}
header("Location: index.php?mod=forum&do=voirforum:".$idforum);
}

return $page;

}
###########################################################################################################
function modif($id, $idforum) {

global $userrow;
global $lang;

$infos = mysql_query("SELECT * FROM phpsim_discussions WHERE id='$id' AND forum_id='".$idforum."' ORDER BY id DESC");
$inf = mysql_fetch_array($infos);
$frm = mysql_result($infos,0,"message");
$titre_def = mysql_result($infos,0,"titre");

if($userrow[nom] != $inf[pseudo])
{
$page .= $lang["pasdroitafficher"];
}
else
{

$titre = $_POST['titre'];
$textem = $_POST['textem'];

if(!$titre)
{
 $titre = "".$titre_def;
}
$date=date("d/m/Y à H:i:s");

if(!empty($textem) AND !empty($titre))
{
mysql_query("UPDATE phpsim_discussions SET titre='$titre', message='$textem', edit='".$lang["editpar"]." <b>".$userrow[nom]."</b> le ".$date."' WHERE id='$id' AND forum_id='".$idforum."'");
mysql_query("UPDATE phpsim_posts SET titre='$titre' WHERE id='$id' AND forum_id='".$idforum."'");
$page .= ' <script type="text/javascript">document.location="index.php?mod=forum&do=liste:'.$inf["message_id"].':'.$idforum.'";</script>;';
}

$page .= '<form id="add_message" name="formu" action="" method="post"><p style="text-align:center;"><label for="titre">Titre : <br /><input type="text" id="titre" name="titre" value="'.$titre.'" /></label><br />';  
$page .= '<script language="javascript" type="text/javascript" src="modules/js_divers.js"></script><br />Message : <br /><textarea id="texte" name="textem" cols="80" rows="10" >'.$frm.'</textarea><br />';
$page .= '<a href="javascript:emoticon(\':D\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/sourire.gif" border=0></a> <a href="javascript:emoticon(\';\)\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/clin.gif" border=0></a> <a href="javascript:emoticon(\':\(\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/triste.gif" border=0></a> <a href="javascript:emoticon(\':surpris:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/yeuxrond.gif" border=0></a> <a href="javascript:emoticon(\':o\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/etonne.gif" border=0></a> <a href="javascript:emoticon(\':confus:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/confus.gif" border=0></a> <a href="javascript:emoticon(\':lol:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/lol.gif" border=0></a> <a href="javascript:emoticon(\':fire:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/flame.gif" border=0></a> <a href="javascript:emoticon(\':splif:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/petard.gif" border=0></a> <a href="javascript:emoticon(\':bigsmile:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/green.gif" border=0></a> <a href="javascript:emoticon(\':x\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/mad.gif" border=0></a> <a href="javascript:emoticon(\':roll:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/rolleyes.gif" border=0></a> <a href="javascript:emoticon(\':bigcry:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/crying.gif" border=0></a> <a href="javascript:emoticon(\':colere:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/colere.gif" border=0></a> <a href="javascript:emoticon(\':P\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/razz.gif"; border=0></a> <a href="javascript:emoticon(\'8\)\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/lunettes.gif" border=0></a> <a href="javascript:emoticon(\':\)\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/sourire2.gif" border=0></a> <a href="javascript:emoticon(\'^^oops:\')"><img title=""  src="templates/'.$userrow["template"].'/images/forum/smileys/redface.gif" border=0></a>';
$page .= '<br />';
$page .= '<select class=taille2 onchange="bbfontstyle(\'[color=\' + this.form.select.options[this.form.select.selectedIndex].value + \']\', \'[/color]\');this.selectedIndex=0;" name=select><option style="color: black;" value=black>Couleur</option><option style="color: grey;" value=grey>Gris</option><option style="color: white;" value=white>Blanc</option><option style="color: yellow;" value=yellow>Jaune</option><option style="color: green;" value=green>Vert</option><option style="color: red;" value=red>Rouge</option><option style="color: blue;" value=blue>Bleu</option></select> <input onclick="TAinsert(\'[b]\',\'[/b]\',\'texte\');" type=button value=gras class=taille2> <input onclick="TAinsert(\'[i]\',\'[/i]\',\'texte\');" type=button value=italique class=taille2> <input onclick="TAinsert(\'[u]\',\'[/u]\',\'texte\');" type=button value=souligné class=taille2> <input onclick="TAinsert(\'[url]\',\'[/url]\',\'texte\');" type=button value=url class=taille2> <input onclick="TAinsert(\'[img]\',\'[/img]\',\'texte\');"; type=button value=img class=taille2> <input onclick="TAinsert(\'[size=4]\',\'[/size]\',\'texte\');" type=button value="Plus gros" class=taille2> <input onclick="TAinsert(\'[quote]\',\'[/quote]\',\'texte\');" type=button value="Citation" class=taille2><input onclick="TAinsert(\'[code]\',\'[/code]\',\'texte\');" type=button value="Code" class=taille2>';
$page .= '<br /><br /><input type="submit" id="envoi" name="envoi" value="Envoyer" />';
$page .= '</p></form>';
}
return $page;

}

?>