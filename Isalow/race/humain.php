<?php
$sexes = array(
	"m" => "#3399CC",
	"f" => "#FF99CC",
	"z" => "#990000"
	);
	
$renomme = array(
	-5 => "Démon",
	-4 => "Démoniaque",
	-3 => "Chaotique",
	-2 => "Mauvais",
	-1 => "Neutre mauvais",
	0 => "Neutre",
	1 => "Neutre bon",
	2 => "Bon",
	3 => "Loyal",
	4 => "Bienfaiteur",
	5 => "Ange"
	);

$race_caract = array(
"place_clone" => 80,
"place_nourriture" => 10000,
"place_electricite" => 100,
"place_isalox" => 1000,
"place_or" => 5000,
"place_argent" => 7000,
"place_fer" => 8000,

"clone_cout" => 1,
"soldat_cout" => 2,
"elite_cout" => 2,
"tank_cout" => 2,
"artillerie_cout" => 2,
"evangelion_cout" => 2,

"thabitation" => 0.7,
"tabattoir" => 10,
"tport" => 15,
"tcentrale" => 50,
"timpot" => 1,
"tisalox" => 1,
"tor" => 2,
"targent" => 4,
"tfer" => 8,

"tps_batiment" => 1800
);

$couts = array( //isalow,or,argent,fer,nourriture,clone,electricite
	"a" => array(0,0,0,100,0,0,0), //habitation
	"b" => array(0,0,20,200,0,5,0), //abattoir
	"c" => array(0,0,10,200,0,10,0), //port
	"g" => array(0,0,50,500,0,5,0), //centre de stockage
	"h" => array(10,20,100,600,0,10,0), //centrale electrique
	"i" => array(0,100,200,300,0,20,0), //mine d'isalox
	"j" => array(0,0,100,300,0,17,0), //mine d'or
	"k" => array(0,0,0,300,0,10,0), //mine d'argent
	"l" => array(0,0,0,30,500,7,0), //mine de fer
	"n" => array(100,200,400,700,0,50,0), //universite
	"o" => array(500,1000,1750,2000,0,500,0), //station radar
	"q" => array(500,300,3000,3000,0,500,0), //tour de defense
	"r" => array(0,100,200,500,0,24,0), //caserne
	"s" => array(100,0,500,1500,0,50,0), //usine
	"t" => array(10000,10000,10000,10000,10000,500,0),  //nerv
	"u" => array(0,0,100,50,50,10,0),  //soldat
	"y" => array(0,0,150,100,55,15,0),  //soldats d'elite
	"t" => array(5,5,50,100,300,50,0), //chars d'assaut
	"x" => array(2,3,10,25,150,25,0), //atillerie
	"e" => array(3,10,25,50,100,20,0) //evangelion
);

$marche = array(
	0 => array(0,2,4,8,16,0.5,0.0625), //isalox
	1 => array(0.5,0,2,4,8,0.25,0.125), //or
	2 => array(0.25,0.5,0,2,4,0.2,0.25), //argent
	3 => array(0.125,0.25,0.5,0,2,0.0625,0.5), //fer
	4 => array(0.0625,0.125,0.25,0.5,0,0.05,0), //nourriture
	5 => array(2,4,5,16,20,0,0), //clone
	6 => array(0.05,0.125,0.25,0.325,0,0,0), //electricite
);

function explo($lands)
{
	$explo = array();
	$explo[6] = 0; //electricite
	$explo[5] = round(10*exp($lands/1000)); //clones
	$explo[4] = round(100*exp($lands/1000)); //nourriture
	$explo[3] = 0; //fer
	$explo[2] = 0; //argent
	$explo[1] = 0; //or
	$explo[0] = 0; //isalox
	return $explo;
}
?>