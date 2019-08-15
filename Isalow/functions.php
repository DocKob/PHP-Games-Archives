<?php
//**************************//
// FUNCTION DE DB
//**************************//
function db_connexion() //CONNEXION A LA DB
{
	mysql_connect("localhost","user","pass");
	mysql_select_db("data");
}
//**************************//
// FUNCTION DIVERS
//**************************//
function exut($page,$raison)
{
	$raison = htmlentities($raison);
	$_SESSION['erreur'] = $raison;
	header("location:../jeu.php?include=".$page);
	exit;
}
function sms($auteur,$destinataire,$sujet,$message)
{
	$date_ecrit = date("d/m/Y");
	$heur_ecrit = date("H:i");
	$date_heur_ecrit = "".$date_ecrit." &agrave; ".$heur_ecrit."";
	$seconde = time();
	$sql = "INSERT INTO is_message (type,de,pour,sujet,message,date_ecrit,seconde) VALUES ('message','".$auteur."','".$destinataire."','".$sujet."','".$message."','".$date_heur_ecrit."',".$seconde.")";
	mysql_query($sql);
}
function filtre($chaine,$lenghtMin,$lenghtMax)
{
	$lenghtBefore = strlen($chaine);
	$caracteres = array(
	"," => "error",
	";" => "error",
	":" => "error",
	" " => "error",
	"!" => "error",
	"@" => "error",
	"|" => "error",
	"=" => "error",
	"+" => "error",
	"/" => "error",
	"*" => "error",
	"#" => "error",
	"'" => "error",
	"&" => "error",
	" " => "error",
	);
	$chaine = strtr($chaine,$caracteres);
	$chaine = trim( htmlentities($chaine) );
	$lenghtAfter = strlen($chaine);
	
	if($lenghtBefore != $lenghtAfter || $lenghtAfter < $lenghtMin || $lenghtAfter > $lenghtBefore)
	{
		return false;
	}
	else
	{
		return true;
	}
}
function filtrehttp($chaine)
{
	if( strpos($chaine,"http://") < 0  && strpos($chaine,".") < strpos($chaine,"http://") )
	{
		return false;
	}
	else
	{
		return true;
	}
}
function filtremail($chaine)
{
	if( strpos($chaine,"@") > 0 && strrpos($chaine,".") > strpos($chaine,"@") )
	{
		return true;
	}
	else
	{
		return false;
	}
}
function exploMax($t_user)
{
	$lands = $t_user['lands'];
	$clone = $t_user['clone'];
	$nourriture = $t_user['nourriture'];
	$electricite = $t_user['electricite'];
	$isalox = $t_user['isalox'];
	$ors = $t_user['ors'];
	$argent = $t_user['argent'];
	$fer = $t_user['fer'];
	
	$nombre_max = 0;
	
	while($clone > 0 && $nourriture > 0 && $electricite > 0 && $isalox > 0 && $ors > 0 && $argent > 0 && $fer > 0)
	{
		$explo = explo($lands);
		
		$clone -= $explo[5];
		$nourriture -= $explo[4];
		
		if($clone > 0 && $nourriture > 0 && $electricite > 0 && $isalox > 0 && $ors > 0 && $argent > 0 && $fer > 0) $nombre_max ++;
	}
	return $nombre_max;
}
function gen_passe()
{
	$passe = "";
	$caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_";
	$longueur = rand(8,12);
	for($i = 0 ; $i < $longueur ; $i++) {
		$passe .= substr($caracteres,rand(0,(strlen($caracteres)-1) ),1);
	}
	return $passe;
}
function show_ressource($nombre)
{
	if($nombre < 75)
	{
		echo("<font class=\"rouge\">".number_format($nombre, 0, ',', ' ')."</font>");
	}
	else
	{
		echo( number_format($nombre, 0, ',', ' ') );
	}
}
function afficherressource($batiment,$couts)
{
	$price = $couts[$batiment];
	echo('( isalox: <font class="gris">'.$price[0].'</font> or: <font class="gris">'.$price[1].'</font> argent: <font class="gris">'.$price[2].'</font> fer: <font class="gris">'.$price[3].'</font> nourriture: <font class="gris">'.$price[4].'</font> cl&ocirc;nes: <font class="gris">'.$price[5].'</font> &eacute;lectricit&eacute;: <font class="gris">'.$price[6].'</font> )');
}
function graphique($ressource,$place,$plus,$batiment)
{
	$max = ($batiment * $place) + $plus;
	if($max <= 0) $max = 1;
	$pixels_rouge = round( (100*$ressource)/$max );
	$pourcentage = round( (100*$ressource)/$max );
	if($pixels_rouge > 100)
	{
		echo("cheater");
	}
	else
	{
		$pixels_vert = 100-$pixels_rouge;
		if( $pixels_rouge != 0 ) echo('<img src="images/barre_rouge.gif" height="16" width="'.$pixels_rouge.'">');
		if( $pixels_vert != 0 ) echo('<img src="images/barre_vert.gif" height="16" width="'.$pixels_vert.'">');
	}
	echo( (100-$pourcentage)."% libres");
}
function isaCode($chaine) {
	$isaCode = array(
			//les smileys
			":)" => "<img src=\"images/smileys/content.gif\">",
			":d" => "<img src=\"images/smileys/dents.gif\">",
			"8)" => "<img src=\"images/smileys/cool.gif\">",
			"zZ" => "<img src=\"images/smileys/dormeur.gif\">",
			":o" => "<img src=\"images/smileys/etonne.gif\">",
			":s" => "<img src=\"images/smileys/gene.gif\">",
			":#" => "<img src=\"images/smileys/insulte.gif\">",
			":p" => "<img src=\"images/smileys/langue.gif\">",
			":@" => "<img src=\"images/smileys/mechant.gif\">",
			":x" => "<img src=\"images/smileys/mort.gif\">",
			":0" => "<img src=\"images/smileys/pleure.gif\">",
			":?" => "<img src=\"images/smileys/question.gif\">",
			":|" => "<img src=\"images/smileys/rien.gif\">",
			":(" => "<img src=\"images/smileys/pleure.gif\">",
			//isaCode
			"[a]" => "<a target='blank' href='",
			"[b]" => "'>",
			"[c]" => "</a>",
			"[img]" => "<img src='",
			"[/img]" => "'>",
			"[br]" => "<br>"
			);
	return strtr($chaine,$isaCode);
}
function intervalles($var)
{
	global $max;
	if($var <= $max) return true;
	else return false;
}
?>