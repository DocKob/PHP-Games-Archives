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

Permet de choisir manuelement sa base apres une inscription si celle si n'a pas été ajouté automatiquement lors de l'inscription

*/


    if ($controlrow["coordonnees_activees"] == 1 && empty($_POST['basechoixok']) ) {
        if ($controlrow["ordre_1_active"] == 1) {
            if (empty($_POST["ordre_1"])) {
                $ordre_1 = rand(1, $controlrow["ordre_1_max"]);
            } else {
                $ordre_1 = $_POST["ordre_1"];
            }

            if ($ordre_1 > $controlrow["ordre_1_max"]) {
                $ordre_1 = $controlrow["ordre_1_max"];
            }
        } else {
            $ordre_1 = 1;
        }

        if (empty($_POST["ordre_2"])) {
            $ordre_2 = rand(1, $controlrow["ordre_2_max"]);
        } else {
            $ordre_2 = $_POST["ordre_2"];
        }

        if ($ordre_2 > $controlrow["ordre_2_max"]) {
            $ordre_2 = $controlrow["ordre_2_max"];
        }

        $echo = "<center>Bienvenue dans ".$controlrow['nom']." 
                 <br><br>Vous n'avez pas de " . $controlrow["nom_bases"] . ". 
                 <br>Veuillez séléctionner un emplacement libre de la liste ci dessous afin de vous y installer : 
                 <br><br><form action='index.php' method='post'>Coordonnées : <table border='0'><tr>";

        if ($controlrow["ordre_1_active"] == 1) {
            $echo .= "<td><input type='text' name='ordre_1' value='" . $ordre_1 . "'></td>";
        }

        $echo .= "<td><input type='text' name='ordre_2' value='" . $ordre_2 . "'></td></tr>
                  </table><br>
                  <input type='submit' value='Valider'></form>
                  <br><br><table width='400' border='1'>
                  <tr align='center'><td align='center'>N°</td><td align='center'>Vue</td><td align='center'>Nom</td><td align='center'>Occupant</td></tr>";

        $numero_ordre_3 = 1;

        while ($numero_ordre_3 <= $controlrow["ordre_3_max"]) {
            $ordrequery = mysql_query("SELECT * FROM phpsim_bases WHERE ordre_1='" . $ordre_1 . "' AND ordre_2='" . $ordre_2 . "' AND ordre_3='" . $numero_ordre_3 . "'");
            if (mysql_num_rows($ordrequery) == 1) {
                $ordre = mysql_fetch_array($ordrequery);
                $occupantquery = mysql_query("SELECT * FROM phpsim_users WHERE id='" . $ordre["utilisateur"] . "'");
                $occupantrow = mysql_fetch_array($occupantquery);
                $echo .= "<tr align='center'><td align='center'>" . $numero_ordre_3 . "</td><td align='center'><img src='templates/" . $userrow["template"] . "/images/bases/" . $ordre["image"] . ".gif'></td><td align='center'>" . $ordre["nom"] . "</td><td align='center'>" . $occupantrow["nom"] . "</td></tr>";
            } else {
                $echo .= "<tr align='center'><td align='center'>" . $numero_ordre_3 . "</td><td align='center'><img src='templates/" . $userrow["template"] . "/images/bases/0.gif'></td><td align='center'><a href='index.php?mod=choixbasedepart2|" . $ordre_1 . "|" . $ordre_2 . "|" . $numero_ordre_3 . "'>S'installer ici</a></td><td align='center'> - </td></tr>";
            }

            $numero_ordre_3 = $numero_ordre_3 + 1;
        }
        $echo .= "</table></center>";
    } 
    
#################################################################################################

    elseif($controlrow["coordonnees_activees"] == 0 || !empty($_GET['c']) )
    {
        $idmax = $sql->select1("SELECT MAX(id) FROM phpsim_bases");

        mysql_query("UPDATE phpsim_users SET 
                                             bases='" . $idmax . "', 
                                             baseactuelle='" . $idmax . "' 
                                         WHERE id='" . $userrow["id"] . "'");

$count = 0 ;
$dir = opendir("templates/" . $userrow["template"] . "/images/bases") ;
while($file = readdir($dir) )
{
if(!is_dir($file) ) { if(!eregi('index', $file) ) { $count ++; } } // On incremente la valeur qui si ce n'est pas un fichier index 
}

$image = rand(1, $count); // Defini une image aleatoire en prenant pas plus que le nombre d'images dans le template

$map2 = explode(",", "0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0");
$map2[rand(1, 81)] = "-1";
$map2[rand(1, 81)] = "-1";
$map2[rand(1, 81)] = "-1";
$map = implode(",", $map2);

$batiments2 = $sql->select1('SELECT COUNT(id) FROM phpsim_batiments ');
$batiments1 = 1;
$batiments = '';
while($batiments1 <= $batiments2)
{
$batiments. = '0'.( ($batiments1 + 1 < $batiments2)?',':'' ) ;

$batiments1++;
}

$unites2 = $sql->select1('SELECT COUNT(id) FROM phpsim_unites ');
$unites1 = 1;
$unites = '';
while($unites1 <= $unites2)
{
$unites. = '0'.( ($unites1 + 1 < $unites2)?',':'' );

$unites1++;
}

$defenses2 = $sql->select1('SELECT COUNT(id) FROM phpsim_defenses ');
$defenses1 = 1;
$defenses = '';
while($defenses1 <= $defenses2)
{
$defenses. = '0'.( ($defenses1 + 1 < $defenses2)?',':'' );

$defenses1++;
}

if($controlrow["coordonnees_activees"] == 1) // Si les coordonnées sont actives
{
$sql->update("INSERT INTO phpsim_bases SET id='" . $idmax . "',
utilisateur='" . $userrow["id"] . "',
ordre_1='" . $ordre_1 . "',
ordre_2='" . $ordre_2 . "',
ordre_3='" . $ordre_3 . "',
ressources='" . $controlrow["ressourcesdepart"] . "',
derniere_mise_a_jour='" . time() . "',
cases='0',
cases_max = '" . $controlrow["cases_default"] . "',
productions='" . $controlrow["productiondepart"] . "',
stockage='" . $controlrow["stockagedepart"] . "',
energie_max='" . $controlrow["energie_default"] . "',
energie='0',
batiments='" . $batiments . "',
unites='" . $unites . "',
defenses='" . $defenses . "',
image='" . $image . "',
map='".$map."'");
}
else // Si les coordonnées sont inactive
{
$sql->update("INSERT INTO phpsim_bases SET 
                    id='" . $idmax . "', 
                    utilisateur='" . $userrow["id"] . "', 
                    ressources='" . $controlrow["ressourcesdepart"] . "',
                    derniere_mise_a_jour='" . time() . "',
                    cases='0', 
                    cases_max = '" . $controlrow["cases_default"] . "', 
                    productions='" . $controlrow["productiondepart"] . "', 
                    stockage='" . $controlrow["stockagedepart"] . "', 
                    energie_max='" . $controlrow["energie_default"] . "', 
                    energie='0', 
					     batiments='" . $batiments . "',
						  unites='" . $unites . "',
						  defenses='" . $defenses . "',                    image='" . $image . "',
                    map='".$map."'");
}   


die('<script>document.location="index.php"</script>');

    }

    echo $echo;


?>