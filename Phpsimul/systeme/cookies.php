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

function checkcookies()
{
    $row = false;

    if (isset($_COOKIE["PHPsimul"])) 
	{
        
        if(!eregi('[0-9]',$_COOKIE["PHPsimul"]) ) // Permet de verifier que le cookie n'est pas trafiqué, dans quel cas on redirige sur l'index
        { 
	        header("Location: login/index.php");
	        die();
        } 
        
        $theuser = explode(" ", $_COOKIE["PHPsimul"]);
        $query = mysql_query("SELECT * FROM phpsim_users WHERE id='" . $theuser[0] . "'");
        if (mysql_num_rows($query) != 1) 
		{
            header("Location: login/index.php");
        }
		
        $userrow = mysql_fetch_array($query);
        if ($userrow["nom"] != $theuser[1]) 
		{
            header("Location: login/index.php");
        }
		
        if ($userrow["pass"] . "--PHPsimul" != $theuser[2]) 
		{
            header("Location: login/index.php");
        }

        $newcookie = implode(" ", $theuser);
        if ($theuser[3] == 1) 
		{
            $expiretime = time() + 31536000;
        } 
		else 
		{
            $expiretime = 0;
        }
		
        setcookie ("PHPsimul", $newcookie, $expiretime, "/", "", 0);
        $onlinequery = mysql_query("UPDATE phpsim_users SET onlinetime=NOW() WHERE id='$theuser[0]' LIMIT 1");
    
    } 
    else // Si le cookies n'est pas la, alors on redirige sur la page de login
    {
        header("Location: login/index.php");
        exit();
    }

    return $userrow;
}

?>