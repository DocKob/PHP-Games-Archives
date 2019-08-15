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

*/


/*
Pour utiliser le système de boucle (1 boucle par template) : 
------------------------------------------------------------
$tpl->getboucle("nomdutemplate"); <-- charge le template pour gérer la boucle
while/for/... {
$tpl->value("nom de l'élément", "valeur"); <-- définit les {{xxx}} à remplacer dans la boucle
$tpl->value("nom de l'élément2", "valeur2");
$tpl->boucle(); <-- fin du premier passage dans la boucle
}
$tpl->value("nom de l'élément", "valeur"); <-- valeurs à remplacer à l'éxterieur de la boucle
$tpl->value("nom de l'élément2", "valeur2");
$xxx = $tpl->finboucle(); <-- finalisation du template complet
*/



class templates 
{

    var $template;
    var $boucle;
    var $boucletotal;
    
#######################################################################################
    function value($nom, $valeur)
    {
        $this->template[$nom] = $valeur;
    }
#######################################################################################
    function parsetemplate($templatepage)
    {
        global $template;
        foreach($this->template as $a => $b) 
		{
            $templatepage = str_replace("{{{$a}}}", $b, $templatepage);
        }
        return $templatepage;
    }
#######################################################################################
    function getboucle($fichier)
    {
        global $userrow;

        $fichier = 'templates/' . $userrow['template'] . '/'. $fichier . '.html';

        $contenu = file_get_contents($fichier);

        $this->boucle = explode("[[boucle]]", $contenu);

    }
#######################################################################################
    function boucle()
    {

        $this->boucletotal .= templates::parsetemplate($this->boucle[1]);

    }
#######################################################################################
    function finboucle()
    {

        $this->boucle[1] = $this->boucletotal;

        $templatetotal = implode("<!-- boucle créée -->", $this->boucle);

        $tplfinal = templates::parsetemplate($templatetotal);

        $this->boucle = "";
        $this->boucletotal = "";

        return $tplfinal;

    }
#######################################################################################
    function construire($nom)
    {
        global $userrow;
		global $controlrow;
		
		// Dans le cas ou la constante ACTION_EN_COURS nous dit qu'on est sur le jeu, alors on affiche le template du joueurs, sinon on affiche le template par default
        if(ACTION_EN_COURS == 'jeu')
		{	
			$fichier = 'templates/' . $userrow['template'] . '/'. $nom . '.html';
		}
		else // Dans le cas ou c'est par default
		{
			$fichier = '../templates/' . $controlrow['login_template'] . '/'. $nom . '.html';
		}
		
		$templatepage = file_get_contents($fichier);

        $page = templates::parsetemplate($templatepage);

        return $page;
    }
#######################################################################################
    function error($error) // Dans le cas ou on tombe sur une erreur pendant le jeu on renvoye ici ce qui permet de mettre une mise en forme au erreur 
    {
		unset($this->template); // On vide le tableau des templates
		$this->value('afferreurs', $error); // On envoye l'erreur sur le template
		echo $this->construire('afferreurs'); // On envoye le template montrant l'erreur
		die(); // On stoppe le programme
    }
#######################################################################################
    
}

?>
