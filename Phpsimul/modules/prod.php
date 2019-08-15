<?php

/*

Recalule de la production, créer par Max485

*/

$bases = explode(',', $userrow['bases']);
$nb = 1;

while ($nb <= COUNT($bases) )
{
	calculer_prod($bases[$nb-1]);
}


function calculer_prod($base)
{
	// $base contient l'id de la base a recaluler
	
	// On recupere les infos de la base a traiter
	$SQLbase = $sql->select('SELECT batiments FROM phpsim_bases WHERE id="'.$base.'" ');
	
	$batiments = format_niv($SQLbase['batiments']); // On place les batiments dans un tableau pour mieux pouvoir les traiter
	
	// On recupere ce qui nous interresse dans la base des batiments
	$SQLbatiments = $sql->query('SELECT 
									id, 
									production, production_evo, 
									temps_diminution,
									consommation, consommation_evo,  
									production_energie, production_energie_evo,
									stockage, stockage_evo
								 FROM phpsim_batiments 
								');
	
	while($bat = mysql_fetch_array($SQLbatiments) ) // On traite chaque batiment un par un
	{
		## DEBUT Traitement production ##
		
		## FIN Traitement production ##
		
		
		## DEBUT Traitement temps_diminution ##
		
		## FIN Traitement temps_diminution ##
		
		
		## DEBUT Traitement consommation ##
		
		## FIN Traitement consommation ##
		
		
		## DEBUT Traitement production_energie ##
		
		## FIN Traitement production_energie ##
		
		
		## DEBUT Traitement stockage ##
		
		## FIN Traitement stockage ##
		
		
	}
	
	/*
	// On recupere les recherches permettant d'augmenter la productions
	$SQLrecherches = $sql->query('SELECT evolution_productions FROM phpsim_recherches WHERE evolution_productions != "" ');
	
	while($rech = mysql_fetch_array($SQLrecherches) )
	{
		
		
		
	}
	
	*/
	
	
	
	
	
}




function format_niv($emplacement)
{
	$ccc = explode(',', $emplacement);
	$c = array();
	$nb = 1;
	
	while($nb <= count($ccc) )
	{
		$c[$nb] = $nb.'-'.$ccc[$nb - 1]; // On met chaque champ de forme id-contenu
		$nb++;
	}
	
	return implode(',', $c);
}




?>