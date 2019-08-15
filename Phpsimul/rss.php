<?php

/* PHPsimul : créez votre jeu de simulation en PHP
Copyright (C) 2007 CAPARROS Sébastien (Camaris)

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA. */

include ("classes/sql.class.php");

$sql = new sql;

$sql->connect();

$controlrow = $sql->select("SELECT * FROM phpsim_config WHERE id='1' LIMIT 1");

function xmlcharacters($string, $trans = '')
{
    $trans = (is_array($trans))? $trans:get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);

    foreach ($trans as $k => $v)
    $trans[$k] = "&#" . ord($k) . ";";

    return strtr($string, $trans);
}

function xml_character_decode($string, $trans = '')
{
    $trans = (is_array($trans))? $trans:get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
    foreach ($trans as $k => $v)
    $trans[$k] = "&#" . ord($k) . ";";

    $trans = array_flip($trans);

    return strtr($string, $trans);
}

$query = "SELECT * FROM phpsim_news WHERE rss='1' ORDER BY id DESC";
$result = mysql_query($query) or die("La requête a échouée : " . mysql_error());

$nb_msg = mysql_num_rows($result);

header("Content-Type: application/xml");

$xml = '<' . '?xml version="1.0" encoding="UTF-8"?' . '><rss version="0.91"><channel>';
$xml .= '<title>' . $controlrow["nom"] . '</title>';
$xml .= '<link>' . $controlrow["url"] . '</link>';
$xml .= '<description>Voici les derni&#232;res news sur ' . $controlrow["nom"] . '.</description>';
$xml .= '<language>fr-ca</language>';

$Compteur = 0;
while (($msg_data = mysql_fetch_assoc($result)) && ($Compteur < $controlrow["maxnews"])) 
{
    $id = $msg_data['id'];
    $titre = xmlcharacters($msg_data['titre']);
    $news = stripslashes(trim(substr($msg_data["texte"], 0, 1000)));

    $news = str_replace("’", "'", $news);

    $news = xmlcharacters($news);

    $mois = substr($msg_data["date"], 10, 2);
    $jour = substr($msg_data["date"], 6, 2);
    $annee = substr($msg_data["date"], 0, 4);
    $date = date("r", mktime(0, 0, 0, $mois, $jour, $annee));

    $xml .= '<item>';
    $xml .= '<title>' . $titre . '</title>';
    $xml .= '<link>' . $controlrow["url"] . 'rss.php?id=' . $id . '</link>';
    $xml .= '<pubDate>' . $date . '</pubDate>';
    $xml .= '<description>';

    $xml .= $news . "...";

    $xml .= '</description></item>';
    $Compteur++;
}

mysql_close();
$xml .= '</channel></rss>';
echo $xml;

$sql->close();

?>

