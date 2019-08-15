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

*/

lang("messagerie");


#######################################################################################################################
#######################################################################################################################
if(@$_POST["Supprimer"] == 1) // supprimmez les messages selectioner
{

$query = $sql->query("SELECT * FROM phpsim_messagerie WHERE destinataire='" . $userrow["id"] . "' ORDER BY id");

while($row = mysql_fetch_array($query)) 
{

if(@$_POST[$row["id"]] == 1) 
{

$sql->update("DELETE FROM phpsim_messagerie WHERE id='".$row["id"]."'");

}
}
}
#######################################################################################################################
#######################################################################################################################
if(@$_POST["Supprimer"] == "all") // supprimmez tous les messages lu
{
$données_messages1 = $sql->query("SELECT * FROM phpsim_messagerie WHERE destinataire='" . $userrow["id"] . "' ");
while($données_messages = mysql_fetch_array($données_messages1) ) 
{
if($données_messages['statut'] == 0) // permet d'executez la suppression que poue les messages lu
{
$sql->update("DELETE FROM phpsim_messagerie WHERE id='".$données_messages["id"]."'");
}
}
}
#######################################################################################################################
#######################################################################################################################
if (!empty($_GET["message"]))  // si message n'est pas vide alors l'utilisateur veut voir le message
{
    $query12 = mysql_query("SELECT * FROM phpsim_messagerie WHERE id='" . $_GET["message"] . "'");
    $msg = mysql_fetch_array($query12);
    if ($msg["destinataire"] != $userrow["id"]) {
        die($lang["appartientpas"]);
    }
    $emetteurquery = mysql_query("SELECT nom FROM phpsim_users WHERE id='" . $msg["emetteur"] . "'");
    $emetteurrow = mysql_fetch_array($emetteurquery);
    if ($msg["systeme"] == 0) {
        $message = bbcode_msg($msg["message"]); // analyse le bbcode du message
    } else {
        $message = $msg["message"];
        $emetteurrow["nom"] = $lang["sys"];
    }

    $date = date("j/m/Y à G:i", $msg["date"]);
    $page = "<a href='index.php?mod=messagerie'>Retour à la messagerie</a><br><br><table><tr><td>
             <b>" . htmlentities(stripcslashes($msg["titre"])) . "</b> (Par : " . $emetteurrow["nom"] . " le " . $date . ") - 
             <a href='index.php?mod=messagerie&messageasupprimer=" . $msg["id"] . "'>".$lang["supprimer"]."</a> - 
             <a href='index.php?mod=ecrire&destinataire=" . $emetteurrow["nom"] . "'>".$lang["repondre"]."</a>
             <br>__________________</td></tr><tr><td>" . $message . "</td></tr></table>";
             
    if ($msg["statut"] == 1) {
        mysql_query("UPDATE phpsim_messagerie SET statut='0' WHERE id='" . $msg["id"] . "'");
    }
}
#######################################################################################################################
#######################################################################################################################
elseif (!empty($_GET["messageasupprimer"])) // l'utilisateur a demandé la suppression du message
{
    $query = mysql_query("SELECT destinataire FROM phpsim_messagerie WHERE id='" . $_GET["messageasupprimer"] . "'");
    $msg = mysql_fetch_array($query);
    if ($msg["destinataire"] != $userrow["id"]) {
        die($lang["appartientpas"]);
    }
    mysql_query("DELETE FROM phpsim_messagerie WHERE id=" . $_GET["messageasupprimer"]);
    echo "<script>window.location.replace('index.php?mod=messagerie'); </script>";
} 
#######################################################################################################################
#######################################################################################################################
elseif($userrow['messagerie_type'] == "1") // par default on affiche les message - si la messagerie du joueur est 
                                             // celle par default alors on passe ici, sinon le if d'apres
{
    $query_msg = mysql_query("SELECT * FROM phpsim_messagerie WHERE destinataire='" . $userrow["id"] . "' ORDER BY date DESC");
    $num = mysql_num_rows($query_msg);    // on verifie si des lignes sont retournées  
    
    if($num == 0) // si aucune ligne a été renvoyé
    {
    $page = "<a href='index.php?mod=ecrire'>".$lang["redigermsg"]."</a><br><h1>".$lang["nomsg"]."</h1>";    
    }
    else
    {   
    $page = "<form name='suppr_messages_all' method='post' action='index.php?mod=messagerie'>
             <input type='hidden' name='Supprimer' value='all'></form>
             <form name='suppr_messages_select' method='post' action='index.php?mod=messagerie'>
             <input type='hidden' name='Supprimer' value='1'>
             <a href='index.php?mod=ecrire'>".$lang["redigermsg"]." - </a><a href='javascript:document.suppr_messages_select.submit();'>".$lang["delselection"]."</a><a href='javascript:document.suppr_messages_all.submit();'> - ".$lang["dellus"]."</a>
             <br>____________________________________________________<br>
             <table><tr><td></td><td></td><td></td><td>&nbsp;&nbsp;</td>
             <td>".$lang["titre"]."</td><td>&nbsp;&nbsp;&nbsp;</td><td>".$lang["emetteur"]."</td><td>&nbsp;&nbsp;&nbsp;</td><td>Date</td></tr>";
    while ($row = mysql_fetch_array($query_msg)) {
        // On recupere le nom du joueur
        $emetteurquery = mysql_query("SELECT * FROM phpsim_users WHERE id='" . $row["emetteur"] . "'");
        $emetteurrow = mysql_fetch_array($emetteurquery);
        
        // Si le message vient du systeme, on laisse activé le html
        if ($row["systeme"] == 1) 
        {
            $emetteurrow["nom"] = $lang["sys"];
        }
        $date = date("j/m/Y à G:i", $row["date"]);
        $page .= "<tr><td><INPUT type='checkbox' name='".$row["id"]."' value='1'></td><td></td>
                  <td><img src='templates/" . $userrow["template"] . "/images/messagerie/msg_" . $row["statut"] . ".gif' border='0'>
                  </td><td></td>
                  <td><a href='index.php?mod=messagerie&message=" . $row["id"] . "'>" . htmlentities(stripcslashes($row["titre"])) . "
                  </a></td><td></td><td>" . $emetteurrow["nom"] . "</td><td></td>
                  <td>" . $date . "</td>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <a href='index.php?mod=messagerie&messageasupprimer=" . $row["id"] . "'>
                  <img widgth='20px' src='templates/" . $userrow["template"] . "/images/img_suppr_message.gif'></a></td></tr>";
    }
    $page .= "</table></form>";
    }
}
#######################################################################################################################
#######################################################################################################################
// Si le joueur a choisi la messagerie ou l'on voit tous les message sur la meme page alors on afffiche ici
else
{
	$query_msg = mysql_query("SELECT * FROM phpsim_messagerie WHERE destinataire='" . $userrow["id"] . "' ORDER BY date DESC");
	$num = mysql_num_rows($query_msg);    // on verifie si des lignes sont retournées  
    
    if($num == 0) // si aucune ligne a été renvoyé
    {
    $page = "<a href='index.php?mod=ecrire'>".$lang["redigermsg"]."</a><br><h1>".$lang["nomsg"]."</h1>";    
    }
    else
    {   
    $page = "<a href='index.php?mod=ecrire'>Rédiger un message - </a>
             <a href='javascript:document.suppr_messages_select.submit();'>".$lang["delselection"]."</a>
             <a href='javascript:document.suppr_messages_all.submit();'> - ".$lang["dellus"]."</a><br><hr>
             <form name='suppr_messages_all' method='post' action='index.php?mod=messagerie'>
             <input type='hidden' name='Supprimer' value='all'></form>
             <form name='suppr_messages_select' method='post' action='index.php?mod=messagerie'>
             <input type='hidden' name='Supprimer' value='1'>
            ";
            
    while ($row = mysql_fetch_array($query_msg)) {
        $emetteurquery = mysql_query("SELECT nom FROM phpsim_users WHERE id='" . $row["emetteur"] . "'");
        $emetteurrow = mysql_fetch_array($emetteurquery);

        $date = date("j/m/Y à G:i", $row["date"]);
        
        // on affiche le message et on le met en bbcode
           $query = mysql_query("SELECT * FROM phpsim_messagerie WHERE id='" . $row["id"] . "'");
           $msg = mysql_fetch_array($query);
        if($row["systeme"] != 1) // si c'est le systeme qui envoye alors on execute pas le bbcode car si il y a du html dedans
                                            // ca le fait planter, puisque la fonction bbcode vire le html ..
        {
           $message = bbcode_msg($msg['message']); // analyse le bbcode du message
        }
        else // si le systeme est egal a 1, alors on l'attribut comme emmetteur et on lui laisse le html
        {  
         $message = $msg['message'] ; 
         $emetteurrow["nom"] = $lang["sys"];  
        } 

       
        $page .= "<table>
                  <tr>
                  <td><INPUT type='checkbox' name='".$row["id"]."' value='1'></td>
                  <td></td>
                  <td><img src='templates/" . $userrow["template"] . "/images/messagerie/msg_" . $row["statut"] . ".gif' border='0'></td>
                  <td><a href='index.php?mod=messagerie&message=" . $row["id"] . "'>" . htmlentities(stripcslashes($row["titre"])) . "</a></td>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td><a href='index.php?mod=ecrire&destinataire=" . $emetteurrow["nom"] . "'>" . $emetteurrow["nom"] . "</a></td>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td>" . $date . "</td>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <a href='index.php?mod=messagerie&messageasupprimer=" . $row["id"] . "'>
                  <img widgth='20px' src='templates/" . $userrow["template"] . "/images/img_suppr_message.gif'></a></td>
                  </tr>
                  <table><tr><td>&nbsp;&nbsp;&nbsp;</td><td><br>".$message."</td></tr></table><hr>
                                    

                  ";
    
    if ($msg["statut"] == 1) // si le message n'a jamais été lu alors on le passe en tant que lu
    {
        mysql_query("UPDATE phpsim_messagerie SET statut='0' WHERE id='" . $msg["id"] . "'");
    }
    
    }
    $page .= "</form>";
    }

}


?>