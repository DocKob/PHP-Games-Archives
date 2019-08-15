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



Créer par Max485, création de signature pour PSPHimul - Créer a la base pour E-UniverS par Quek

*/


header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");

header("Cache-Control: no-cache, must-revalidate");

header("Pragma: no-cache");

// On defini le nom de l'alli du joueur
$alli = $sql->select("SELECT nom FROM phpsim_alliance WHERE id='".$userrow['alli']."' ");

// Puis le classement / nombre d'inscrit
$nb_inscrit = $sql->select("SELECT COUNT(id) as total FROM phpsim_users ");
$classement = $compteurs->classement($userrow['id'])."/".$nb_inscrit['total'] ;

// Et enfin le nombres de bases du joueur
$nbbases = $compteurs->nombre_bases($userrow['id']);


#######################################################################################################

@$page.='

<head>
<link rel="stylesheet" href="modules/sign/conv_global.css" type="text/css" charset="utf-8" />
</head>
<script>
	function changeCoul(n,c){
		champ1 = n.value;
		document.getElementById(c).style.backgroundColor = "#"+champ1;	
	}
	
	function iniCouleur(){
		document.getElementById(\'coultitre\').style.backgroundColor = document.getElementById(\'idcoultitre\').value;
		document.getElementById(\'coulvaleur\').style.backgroundColor = document.getElementById(\'idcoulvaleur\').value;
		document.getElementById(\'coulexp\').style.backgroundColor = document.getElementById(\'idcoulexp\').value;
		document.getElementById(\'coulfond\').style.backgroundColor = document.getElementById(\'idcoulfond\').value;
		document.getElementById(\'coultransp\').style.backgroundColor = document.getElementById(\'idcoultransp\').value;
	}
	function affiche_choixstyle(){
    	        valeurbouton = document.getElementById(\'bontonchoixstyle\');
    	        etatvue = document.getElementById(\'choixstyle\').style;

    	        
    	        if (etatvue.visibility != \'visible\'){
    	        	etatvue.visibility = \'visible\';
			valeurbouton.value = \'Fermer les fonds\';	
		}
		else{
			etatvue.visibility = \'hidden\';
			valeurbouton.value = \'Choisir un fond\';
		}
	}
    
    	function modifStyle(n){
    	
    		styleTitre = document.getElementById(\'id_coultitre\');
    		styleValeur = document.getElementById(\'id_coulvaleur\');
    		styleExp = document.getElementById(\'id_coulexp\');
    		styleFond = document.getElementById(\'id_coulfond\');
    		styleTransp = document.getElementById(\'id_coultransp\');
    	
    		styleTitre2 = document.getElementById(\'coultitre2\').style;
    		styleValeur2 = document.getElementById(\'coulvaleur2\').style;
    		styleExp2 = document.getElementById(\'coulexp2\').style;
    		styleFond2 = document.getElementById(\'coulfond2\').style;
    		styleTransp2 = document.getElementById(\'coultransp2\').style;
    		
	    	if(n==0){
	    		styleTitre.value = \'000000\';
			styleValeur.value = \'000000\';
			styleExp.value = \'000000\';
			styleFond.value = \'FFFFFF\';
			styleTransp.value = \'\';
	
		}
	
		if(n==1){
	    		styleTitre.value = \'000000\';
			styleValeur.value = \'000000\';
			styleExp.value = \'000000\';
			styleFond.value = \'00FF00\';
			styleTransp.value = \'00FF00\';
	
	    	}
	
	    	if(n==2){
	    		styleTitre.value = \'CC00CC\';
			styleValeur.value = \'FFFF00\';
			styleExp.value = \'FF3399\';
			styleFond.value = \'000000\';
			styleTransp.value = \'\';
		}
	

	    	
	    	styleTitre2.backgroundColor = \'#\'+styleTitre.value;
		styleValeur2.backgroundColor = \'#\'+styleValeur.value;
		styleExp2.backgroundColor = \'#\'+styleExp.value;
		styleFond2.backgroundColor = \'#\'+styleFond.value;
		if (styleTransp.value==\'\') styleTransp2.backgroundColor = null;
		else styleTransp2.backgroundColor = \'#\'+styleTransp.value;
	    	
	}
	   
</script>
<body onLoad="iniCouleur();">

<br>
<center>
<div class="inputText">
<div class="logo">
	<img src="modules/sign/logo.png">
</div>


';

#######################################################################################################
if (empty($_POST['etape']) )
{


$page.='
	<form action="" method="post" ENCTYPE="multipart/form-data">
	<input type="hidden" name="etape" value="1">
		<table width=85% style="border:1px solid #FF0000;" align="center" border="0" cellpadding="5" cellspacing="0">
		<tr>
			<td bgcolor="#2F4653" align="center" style="color:#6F797F; bottom left repeat-x;"><b>DONNEES GENERALES DE L\'IMAGE</b></td>
		</tr>
		<tr>
		<td align="center">
		    <table>
		    <tr><td>Pseudo : '.$userrow["nom"].'</td>
		    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		    <td>Race : '.$controlrow['race_'.$userrow['race']].'</td>
		    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td>Alliance : '.$alli['nom'].'</td>
			</tr><tr>
			<td>Points : '.$userrow["points"].'</td>
			<td></td>
			<td>Classement : '.$classement.'</td>
			<td></td>
			<td>Nombre de base : '.$nbbases.'</td>
			
			</tr></table>
								
		</td>
		</tr>
		</table>
		<br>
		
		<table width=85% style="border:1px solid #FF0000;" align="center" border="0" cellpadding="5" cellspacing="0">
		<tr>
			<td bgcolor="#2F4653" colspan=3 align="center" style="color:#6F797F; bottom left repeat-x;"><b>OPTIONS</b></td>
		</tr>
		<tr>
			<td colspan=3 align="center">(Pour les couleurs HTML : <a href="modules/sign/couleurs.php" target="_blank"><span class="lien">Aide ici</span></a>)</td>
		</tr>
		<tr>
			<td colspan=3 align="center"><input id="bontonchoixstyle" class="valid" type="button" OnClick="affiche_choixstyle();" value="Choisir un fond"></td>
		</tr>
		<tr>
		    <td colspan=3 align="center">(Mettez 1 pour générer une couleur aléatoire)</td>
		</tr>
		<tr>
			<td align="right">Couleur pour le nom du jeu :</td>
			<td>#<input onchange="changeCoul(this,\'coultitre2\');" id="id_coultitre" type="text" name="couleur_nomjeu" value="';
			if (@$coultitre!= "") $page.=$coultitre; else $page.="CC00CC";
			$page.='" maxlength="6" size="7"> (Par defaut : CC00CC)</td>
			<td width=100><div id="coultitre2" style="border:1px solid #000000;width:30px;height:15px;background-color:#CC00CC;"></div></td>
		</tr>
		<tr>
			<td align="right">Couleur des catégories :</td>
			<td>#<input onchange="changeCoul(this,\'coulvaleur2\');" id="id_coulvaleur" type="text" name="couleur_cat" value="';
			if (@$coulvaleur!= "") $page.=$coulvaleur; else $page.="FFFF00";
			$page.='" maxlength="6" size="7"> (Par defaut : FFFF00)</td>
			<td width=100><div id="coulvaleur2"style="border:1px solid #000000;width:30px;height:15px;background-color:#FFFF00;"></div></td>
		</tr>
		<tr>
			<td align="right">Couleur des valeurs :</td>
			<td>#<input onchange="changeCoul(this,\'coulexp2\');" id="id_coulexp" type="text" name="couleur_valeurs" value="';
			if (@$coulexp!= "") $page.=$coulexp; else $page.="FF3399";
			$page.='" maxlength="6" size="7"> (Par defaut : FF3399)</td>
			<td width=100><div id="coulexp2" style="border:1px solid #000000;width:30px;height:15px;background-color:#FF3399;"></div></td>
		</tr>
		<tr>
			<td align="right">Couleur pour le fond de l\'image :</td>
			<td>#<input onchange="changeCoul(this,\'coulfond2\');" id="id_coulfond" type="text" name="couleur_fond" value="';
			if (@$coulfond!= "") $page.=$coulfond; else $page.="000000";
			$page.='" maxlength="6" size="7"> (Par defaut : 000000)</td>
			<td width=100><div id="coulfond2" style="border:1px solid #000000;width:30px;height:15px;"></div></td>
		</tr>
		<tr>
			<td align="right">Couleur de transparence :</td>
			<td> #<input onchange="changeCoul(this,\'coultransp2\');" id="id_coultransp" type="text" name="couleur_transp" value="';
			if (@$coultransp!= "") $page.=$coultransp; else $page.="";
			$page.='" maxlength="6" size="7"> (Par defaut : Vide)</td>
			<td width=100><div id="coultransp2" style="border:1px solid #000000;width:30px;height:15px;"></div></td>
		</tr>
		</table>
		<br>
		<input type="submit" class="valid" value="Continuer" name="save">



<div id="choixstyle" class="choixstyle" align="left">
	<div class="choixstyle_bouton" style="cursor:pointer;" OnClick="affiche_choixstyle()()">&nbsp;&nbsp;Fermer</div>
	<div class="choixstyle_corps" align="left">
	
		<table><tr><td><input type="radio" OnClick="modifStyle(0)" name="stylefond" value="0"></td><td>Aucun fond (fond blanc)</td></tr></table>
		<br>
		<table><tr><td><input type="radio" OnClick="modifStyle(1)" name="stylefond" value="1"></td><td>Fond transparent</td></tr></table>
		<br>
		<table>
		<tr>
			<td><input type="radio" OnClick="modifStyle(0)" name="stylefond" value="5"></td>
			<td>
				<table border=0 cellpadding=0 cellspacing=0>
				<tr>
				<td align="right" valign="middle">Utiliser mon image :</td>
				<td colspan=2>&nbsp;<input type="file" lang="fr" name="imgperso">(Format: 600x140)<br>
				<font color=#FD7E00>Conseil</font> : utilisez de préférence<br>des images au format PNG et non JPG,<br> la qualité est nettement meilleure !!!
				</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
		<br>
		
';
		
// On calcule le nombre d'image dans le dossier du template du joueur, et on affiche suivant les images qu'il y a		
		
    	  $nb = 1 ;
		  $dir = opendir("templates/" . $userrow["template"] . "/images/sign") ;
		  while($file = readdir($dir) )
		  {
		  if(!is_dir($file) and !eregi('index', $file) and !eregi('Thumbs', $file) ) 
		  { 
		  $check = ($nb == 1)?"checked":'' ;
		  $page.='		
		  <table><tr><td><input type="radio" OnClick="modifStyle(2)" name="stylefond" '.$check.' value="'.$file.'"></td>
		  <td><img src="templates/' . $userrow["template"] . '/images/sign/'.$file.'"><td></td></table>
		  <br>';
		  $nb++;
		  } 
		  }




		

$page.='
	</div>
	<div class="choixstyle_bouton2" style="cursor:pointer;" OnClick="affiche_choixstyle()()">&nbsp;&nbsp;Fermer</div>
</div>
		

	</form>
';

#######################################################################################################






}
elseif($_POST['etape'] == "1")
{

// On recupere lesinfo neccessaires dans des variables
$pseudo = $userrow["nom"] ;
$race = $controlrow['race_'.$userrow['race']] ;
$alliance = $alli['nom'];
$points = $userrow['points'] ;
$nom_jeu = $controlrow['nom'] ;
$time = date("d/m/Y \à H \: i", time() ) ;

$cnomjeu = $_POST['couleur_nomjeu'];
$ccat = $_POST['couleur_cat'];
$cvaleurs = $_POST['couleur_valeurs'];
$cfond = $_POST['couleur_fond'];
$ctransp = $_POST['couleur_transp'];
$stylefond = $_POST['stylefond'];
	
	
		$page.= " Attention, à cause du cache vous avez peut être l'impression que votre image n'a pas changé.<br>";
		$page.= "N'hésitez pas à actualiser la page pour rafraichir l'image !<br><br>";
		
		// On crée l'image
		$monImage = imagecreatetruecolor(600,140);
		
		// On regarde si l'utilisateur a envoyer une photo perso dans quel cas on la traite
		if(!empty($_FILES['imgperso']["name"]) && $stylefond == "5"){
			$verif=substr($_FILES['imgperso']["name"],-3); 
			// on vérifie l'extension avant de télécharger 
			if (eregi('jpg',$verif) ){ 
				$monImage2 = imagecreatefromjpeg($_FILES["imgperso"]["tmp_name"]);
				imagecopy($monImage, $monImage2, 0, 0, 0, 0, 600, 140);
			}
			if (eregi('png',$verif) ){ 
				$monImage2 = imagecreatefrompng($_FILES["imgperso"]["tmp_name"]);
				imagecopy($monImage, $monImage2, 0, 0, 0, 0, 600, 140);
			}	
			if (!eregi('jpg',$verif) &&  !eregi('png',$verif) ) // si le format de son image est incorrect, on met du blanc
			{
			$couleur_fond = imageColorAllocate($monImage, 255, 255, 255);
			imagefill($monImage, 0, 0, $couleur_fond);
		    }
		}
		else // Sinon on regarde si il a demandé une image dans quel cas on met l'image qu'il a demandé
		{
			if($stylefond != "0" && $stylefond != "1" && isset($stylefond) ){
				$monImage2 = imagecreatefrompng('templates/' . $userrow["template"] . '/images/sign/'.$stylefond);
				imagecopy($monImage, $monImage2, 0, 0, 0, 0, 600, 140);
			
			}
		}
		
		
		$cnomjeu2 = hex2int($cnomjeu);
		$cnomjeu = imageColorAllocate($monImage, $cnomjeu2['r'], $cnomjeu2['g'], $cnomjeu2['b']);

		$ccat2 = hex2int($ccat);
		$ccat = imageColorAllocate($monImage, $ccat2['r'], $ccat2['g'], $ccat2['b']);

		$cvaleurs2 = hex2int($cvaleurs);
		$cvaleurs = imageColorAllocate($monImage, $cvaleurs2['r'], $cvaleurs2['g'], $cvaleurs2['b']);
		
		if(empty($_FILES['imgperso']["name"]) ){
			if($cfond != ""){
				$imColor = hex2int($cfond);
				$couleur_fond = imageColorAllocate($monImage, $imColor['r'], $imColor['g'], $imColor['b']);
			}
			else // Si aucune couleur n'est defini
			{
				$col = hex2int('1');
				$couleur_fond = imageColorAllocate($monImage, $col['r'],$col['g'],$col['b']); 
			}
			imagefill($monImage, 0, 0, $couleur_fond);
		}
		
		
		if($ctransp != ""){
			
				$imColor2 = hex2int($ctransp);
				$couleur_transp = imageColorAllocate($monImage, $imColor2['r'], $imColor2['g'], $imColor2['b']);
				imagecolortransparent($monImage,$couleur_transp);
			
		}

        // on rempli l'image avec les valeurs

        imagettftext($monImage, 35, 0, 5, 40, $cnomjeu, "modules/sign/style.ttf" , $nom_jeu );

        imagettftext($monImage, 16, 0, 400, 18, $ccat, "modules/sign/style.ttf" , "Pseudo :");
        imagettftext($monImage, 14, 0, 470, 18, $cvaleurs, "modules/sign/style.ttf" , $pseudo );

        imagettftext($monImage, 16, 0, 420, 40, $ccat, "modules/sign/style.ttf" , "Race :");
        imagettftext($monImage, 14, 0, 470, 40, $cvaleurs, "modules/sign/style.ttf" , $race );

        imagettftext($monImage, 16, 0, 398, 60, $ccat, "modules/sign/style.ttf" , "Alliance :");
        imagettftext($monImage, 14, 0, 470, 60, $cvaleurs, "modules/sign/style.ttf" , $alliance );

        imagettftext($monImage, 16, 0, 10, 70, $ccat, "modules/sign/style.ttf" , "Classement :");
        imagettftext($monImage, 14, 0, 110, 70, $cvaleurs, "modules/sign/style.ttf" , $classement );

        imagettftext($monImage, 16, 0, 50, 90, $ccat, "modules/sign/style.ttf" , "Points :");
        imagettftext($monImage, 14, 0, 110, 90, $cvaleurs, "modules/sign/style.ttf" , $userrow['points'] );

        imagettftext($monImage, 16, 0, 280, 100, $ccat, "modules/sign/style.ttf" , "Nombre de ".$controlrow['nom_bases']." :");
        imagettftext($monImage, 14, 0, 500, 100, $cvaleurs, "modules/sign/style.ttf" , $nbbases );

        imagettftext($monImage, 10, 0, 5, 135, $cnomjeu, "modules/sign/style.ttf" , "Généré le: ".$time );

        imagettftext($monImage, 10, 0, 465, 135, $cnomjeu, "modules/sign/style.ttf" , "ModSign Créé Par Max485" );




        // Si l'utilisateur a envoyé une photo, on regarde son format pour savoir en quoi la créer
		if(!empty($_FILES['imgperso']["name"])){
			$verif=substr($_FILES['imgperso']["name"],-3); 
			// on vérifie l'extension avant de télécharger 
			if (eregi('jpg',$verif) ){ 
				imageJpeg($monImage,"imgsign/".str_replace( " ", "_", $pseudo)."_sign.jpg"); 
				$page.= "<img src=imgsign/".str_replace( " ", "_", $pseudo)."_sign.jpg><br>";
			}
			if (eregi('png',$verif) ){ 
				imagePng($monImage,"imgsign/".str_replace( " ", "_", $pseudo)."_sign.png"); 
				$page.="<img src=imgsign/".str_replace( " ", "_", $pseudo)."_sign.png><br>";
			}
			if (!eregi('jpg',$verif) &&  !eregi('png',$verif) ) // si le format de son image est incorrect, on met du blanc
			{
			imagePng($monImage,"imgsign/".str_replace( " ", "_", $pseudo)."_sign.png"); 
			$page.="<img src=imgsign/".str_replace( " ", "_", $pseudo)."_sign.png><br>";
		    }
		}
		else // Si il n'a pas upload de photo alors on passe ici en png obligatoire
		{

			imagePng($monImage,"imgsign/".str_replace( " ", "_", $pseudo)."_sign.png"); 
			$page.="<img src=imgsign/".str_replace( " ", "_", $pseudo)."_sign.png><br>";
			
			
		}
	
// On enregistre les données dans MySQL pour pouvoir faire les reactualisation de l'image
//$sql->query("INSERT INTO phpsim_imgsign SET  ") ;

	}


$page.="
<br><br>
<a href='http://quek2.free.fr/e-univers/stat_prod/index.php' target='_blank'><span class='lien'>Créé par Quek pour E-Univers</span></a> - 
<a href='http://forum.epic-arena.fr' target='_blank'><span class='lien'>Adapté a PHPSimul Par Max485</span></a>
</div>";































#######################################################################################################
// Les fonctions

#######################################################################################################
// Permet d'extraire ce qui se trouve entre la valeur 1 et la valeur 2 dans le texte $text
function extractPara($text,$val1,$val2){
	$text1 = explode ($val1, $text);
	$text2 = explode ($val2, $text1[1]);
	return $text2[0];
}

#######################################################################################################
// Ajoute des espace tous les 3 caracteres
function nombreEspace ($nb){
	$chaineRetour = "";
	$nb_caractere = strlen($nb);
	$nb_debut = $nb_caractere % 3 ; 
	
	$cpt = 0;
	while ($cpt < $nb_debut){

		$chaineRetour = $chaineRetour.substr($nb, $cpt, 1);	
		$cpt++;
	}

	$cpt2 = 0;
	while ($cpt < $nb_caractere){
		if ($cpt2 == 0 && $cpt != 0 ) $chaineRetour = $chaineRetour." ";
		$chaineRetour = $chaineRetour.substr($nb, $cpt, 1);	
		$cpt2++;
		if ($cpt2 == 3 ) $cpt2 = 0;
		$cpt++;
	}

	return $chaineRetour;
}

#######################################################################################################
// Permet de transformez en format 255,255,255 une couleur de format HTML dy style FF0000
function hex2int($hex) 
{
// On commence par regarder si le joueur a vouu une couleur aleatoire ou pas
if($hex == "1")
{
return array( 'r' => rand(1,255),
              'g' => rand(1,255),
              'b'=> rand(1,255)
            );
}
else // Le joueur n'a pas demandé une couleur aleatoire
{
        return array( 'r' => hexdec(substr($hex, 0, 2)), // 1ere paire de digit
                      'g' => hexdec(substr($hex, 2, 2)), // 2eme paire de digit
                      'b' => hexdec(substr($hex, 4, 2))  // 3eme paire de digit 
                    );
}
}

#######################################################################################################















?>