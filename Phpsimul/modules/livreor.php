<?php

// Si la constante n'est pas defini on bloque l'execution du fichier
if(!defined('PHPSIMUL_PAGES') || @PHPSIMUL_PAGES != 'PHPSIMULLL') 
{
die('Erreur 404 - Le fichier n\'a pas �t� trouv�');
}

/* PHPsimul : Cr�ez votre jeu de simulation en PHP
Copyright (�) - 2007 - CAPARROS S�bastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr



Mod Livre D'Or 

Cr�er a la base par Terreur pour S-U-C & Ameliorer par Max485 pour PHPSimul

*/

lang("livreor");

// Definisser le nombre de message par pages
$nombreDeMessagesParPage = 10; 

####################################
//Dans le cas ou l'admin a demand� une suppression
if(!empty($_GET['suppr']) && $userrow['administrateur'] == 1 )
{
$sql->update('DELETE FROM phpsim_livreor WHERE id="'.$_GET['suppr'].'" ');
}
####################################

@$page.='
<center>
<form method="post" action="?mod=livreor">
<p>'.$controlrow['nom'].' '.$lang["vousplait"].'<center></p>

Message:<br>
<textarea name="message" rows="10" cols="50"></textarea>
<br><input type="submit" value="Envoyer" />
</p>
</form>
<p class="pages">
';

####################################
if (isset($_POST['message']) )
{
    $pseudo = $userrow['nom']; 
    $message = mysql_real_escape_string($_POST['message']); 

    $sql->update('INSERT INTO phpsim_livreor SET pseudo="'.$pseudo.'", message="'.$message.'", date="'.time().'" ');
}
####################################

$totalDesMessages = $sql->select1('SELECT COUNT(id) FROM phpsim_livreor');

$nombreDePages  = ceil($totalDesMessages / $nombreDeMessagesParPage);


####################################
if (isset($_GET['page']) ) // Permet de choisir la page, par default c'est la 1
{
$pagenum = $_GET['page']; 
}
else 
{
$pagenum = 1;
}
####################################


@$page.='
 
</p>
<table border="5" cellpadding="4" cellspacing="0" width="100%"><tr><td>
'.( ($nombreDePages > 1)?'<center><font size="-3">
'.( ($pagenum != 1)?'<a href="?mod=livreor&page='.($pagenum-1).'">Pr�c�dente</a>':'')
.( ($pagenum != 1 || $pagenum >= $page+1)?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;':'' ).
( ($nombreDePages >= $pagenum+1)?'<a href="?mod=livreor&page='.($pagenum+1).'">Suivante</a></font>':''):'').'
</td></tr></table>
<br>
'; 
 
###########################################################################################
 
$premierMessageAafficher = ($pagenum - 1) * $nombreDeMessagesParPage;
 
$reponse = $sql->query('SELECT * FROM phpsim_livreor ORDER BY id DESC LIMIT ' . $premierMessageAafficher . ', ' . $nombreDeMessagesParPage);
 
if(mysql_num_rows($reponse) >= 1)
{ // debut if message retourn�
while ($donnees = mysql_fetch_array($reponse))
{
@$page.='
<table border="1" cellpadding="4" cellspacing="0" width="100%">
<tr><td>
'.( ($userrow['administrateur'] == 1)?'<a href="?mod=livreor&suppr='.$donnees['id'].'"><img src="templates/'.$userrow['template'].'/images/img_suppr_message.gif"></a>':'' ).'
<strong>' . htmlspecialchars($donnees['pseudo']) . '</strong> (Le '. date('d/m/Y \� H \H i \M\i\n',$donnees['date']) .') a �crit :
<br>' . nl2br(htmlspecialchars($donnees['message'])) . '
</td></tr>
</table>
<br>
';
}
} // fin if message retourn�
else // si aucun messages
{
$page.='<font size="+1"><b>'.$lang["pasmsg"].'</b></font><br><br>';
}


@$page.='

<table border="5" cellpadding="4" cellspacing="0" width="100%"><tr><td>
<b><center><font size="-3">Cr�� � la base pour S-U-C par Tereur & Adapt� a PHPSimul par Max485</font></b>
</td></tr></table>

';