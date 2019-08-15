<?php
include("skin/header.php");

require("functions.php");
require("race/$race.php");

db_connexion();

$dureeTour = 3600;
$percent = array(0.01 , 0.005 , 0.0025);

$sql = "SELECT * FROM is_user WHERE pseudo = '".$pseudo."'";
$r_user = mysql_query($sql);
$t_user = mysql_fetch_assoc($r_user);

$tours = floor( (time() - $t_user['tour']) / $dureeTour );
$time = time() - (time() - $t_user['tour']);

$TIMEAFFICHAGE = $dureeTour - (time() - $t_user['tour']);

if( $tours > 0 )
{
	$id      = array();
	$type    = array();
	$nombre  = array();
	$seconds = array();

	$sql = "SELECT * FROM is_construction WHERE pseudo = '".$pseudo."' ORDER BY seconds ASC";
	$r_construction = mysql_query($sql);
	while( $t_construction = mysql_fetch_assoc($r_construction) )
	{
		$id[]      = $t_construction['id'];
		$type[]    = $t_construction['type'];
		$nombre[]  = $t_construction['nombre'];
		$seconds[] = $t_construction['seconds'];
	}
	
	$ressources = array(
	"clone"       => $t_user['clone'],
	"nourriture"  => $t_user['nourriture'],
	"electricite" => $t_user['electricite'],
	"isalox"      => $t_user['isalox'],
	"ors"         => $t_user['ors'],
	"argent"      => $t_user['argent'],
	"fer"         => $t_user['fer'],
	"partisans"   => $t_user['partisans']);
	
	$batiments = array(
	"a" => $t_user['habitation'],	//habitation
	"b" => $t_user['abattoir'],		//abattoir
	"c" => $t_user['port'],			//port
	"g" => $t_user['stockage'],		//stockage
	"h" => $t_user['centrale'],		//centrale
	"i" => $t_user['Misalox'],		//Misalox
	"j" => $t_user['Mor'],			//Mor
	"k" => $t_user['Margent'],		//Margent
	"l" => $t_user['Mfer'],			//Mfer
	"n" => $t_user['universite'],	//universite
	"o" => $t_user['stationradar'],	//stationradar
	"q" => $t_user['tourdefense'],	//tourdefense
	"r" => $t_user['caserne'],		//caserne
	"s" => $t_user['usine'],		//usine
	"t" => $t_user['nerv'],			//nerv
	);

	for( $i = 0 ; $i < $tours ; $i++ )
	{
		$time += $dureeTour;
		$max = $time;

		$constructions = array_filter($seconds,"intervalles");
		
		foreach( $constructions as $cle => $valeur )
		{
			$batiments[ $type[ $cle ] ] += $nombre[ $cle ];
			mysql_query("DELETE FROM is_construction WHERE id = '".$id[$cle]."'");
			unset( $type[ $cle ] , $nombre[ $cle ] , $seconds[ $cle ] );
		}
		
		$ressources['clone']       +=  $t_user['habitation'] * $t_user['thabitation'];
		$ressources['nourriture']  += ($t_user['abattoir']   * $t_user['tabattoir'])  + ($t_user['port']  * $t_user['tport']);
		$ressources['electricite'] += ($t_user['centrale']   * $t_user['tcentrale'])  + 30;
		$ressources['isalox']      +=  $t_user['Misalox']    * $t_user['tisalox'];
		$ressources['ors']         += ($t_user['Mor']        * $t_user['tor'])        + ($t_user['clone'] * $t_user['timpot']);
		$ressources['argent']      +=  $t_user['habitation'] * $t_user['thabitation'];
		$ressources['fer']         +=  $t_user['habitation'] * $t_user['thabitation'];

		$maxclone       = ($t_user['habitation'] * $race_caract['place_clone'])       + 150;
		$maxnourriture  = ($t_user['stockage']   * $race_caract['place_nourriture'] ) + 5000;
		$maxelectricite = ($t_user['centrale']   * $race_caract['place_electricite']) + 50;
		$maxisalox      = ($t_user['stockage']   * $race_caract['place_isalox']);
		$maxor          = ($t_user['stockage']   * $race_caract['place_or'])          + 500;
		$maxargent      = ($t_user['stockage']   * $race_caract['place_argent'])      + 1000;
		$maxfer         = ($t_user['stockage']   * $race_caract['place_fer'])         + 2000;
		
		if($ressources['clone']       > $maxclone      ) $ressources['clone']       = $maxclone;
		if($ressources['nourriture']  > $maxnourriture ) $ressources['nourriture']  = $maxnourriture;
		if($ressources['electricite'] > $maxelectricite) $ressources['electricite'] = $maxelectricite;
		if($ressources['isalox']      > $maxisalox     ) $ressources['isalox']      = $maxisalox;
		if($ressources['ors']         > $maxor         ) $ressources['ors']         = $maxor;
		if($ressources['argent']      > $maxargent     ) $ressources['argent']      = $maxargent;
		if($ressources['fer']         > $maxfer        ) $ressources['fer']         = $maxfer;
	
		$ressources['nourriture']  -= ( ($t_user['clone'] * $race_caract['clone_cout']) + ($t_user['soldat'] * $race_caract['soldat_cout']) + ($t_user['elite'] * $race_caract['elite_cout']) );
		$ressources['electricite'] -= ( ($t_user['stockage'] + $t_user['universite'] + $t_user['tourdefense'] + $t_user['port'] + $t_user['habitation']) + (5 * ( $t_user['stationradar'] + $t_user['caserne'] + $t_user['usine'])) + (20 * $t_user['nerv']) );
		$ressources['ors']         -= ( ($t_user['tank'] * $race_caract['tank_cout']) + ($t_user['artillerie'] * $race_caract['artillerie_cout']) + ($t_user['evangelion'] * $race_caract['evangelion_cout']) );
		
		if( $ressources['nourriture']  <= 0 )
		{
			$ressources['clone']       *= $percent[0];
			$ressources['nourriture']   = 0;
			$ressources['isalox']      *= $percent[2];
			$ressources['ors']         *= $percent[2];
			$ressources['argent']      *= $percent[1];
			$ressources['fer']         *= $percent[1];
		}
		if( $ressources['ors']         <= 0 )
		{
			$ressources['clone']       *= $percent[2];
			$ressources['nourriture']  *= $percent[2];
			$ressources['isalox']      *= $percent[0]; 
			$ressources['ors']          = 0;
			$ressources['argent']      *= $percent[1];
			$ressources['fer']         *= $percent[1];
		}
		if( $ressources['electricite']  <= 0 )
		{
			$ressources['electricite']  = 0;
			$ressources['isalox']      *= $percent[2]; 
			$ressources['ors']         *= $percent[2];
			$ressources['argent']      *= $percent[2];
		}
		if    ( $ressources['partisans'] >= 90 && $ressources['partisans'] <  99 ) $ressources['partisans'] ++;
		elseif( $ressources['partisans'] <  90 && $ressources['partisans'] >= 30 ) $ressources['partisans'] += rand(-1,2);
		elseif( $ressources['partisans'] <  30 && $ressources['partisans'] >= 10 ) $ressources['partisans'] --;
		elseif( $ressources['partisans'] <  10 && $ressources['partisans'] >= 2  ) $ressources['partisans'] -= 2;
		
		if( $ressources['partisans'] <= 5 )
		{
			$ressources['clone']        = 0;
			$ressources['nourriture']  *= $percent[0];
			$ressources['isalox']      *= $percent[0];
			$ressources['ors']         *= $percent[0];
			$ressources['argent']      *= $percent[0];
			$ressources['fer']         *= $percent[0];
		}
	}
	$ressources['clone']       = floor($ressources['clone']);
	$ressources['nourriture']  = floor($ressources['nourriture']);
	$ressources['electricite'] = floor($ressources['electricite']);
	$ressources['isalox']      = floor($ressources['isalox']);
	$ressources['ors']         = floor($ressources['ors']);
	$ressources['argent']      = floor($ressources['argent']);
	$ressources['fer']         = floor($ressources['fer']);
	
	$score  = ( ( ($ressources['electricite']/6) + ($ressources['nourriture']/3.5) + $ressources['clone'] + ($ressources['isalox'] /0.4) + ($ressources['ors'] / 0.8) + ($ressources['argent']/1.6) + ($ressources['fer']/2) )/ ($t_user['lands']+1) )*1;
	$score += ( ( ($t_user['soldat']*3) + ($t_user['elite']*5) + ($t_user['tank']*10) + ($t_user['artillerie']*4) + ($t_user['evangelion'] * 500) ) / ($t_user['lands']+1) ) * 6;
	$score += ( ( ($t_user['habitation']/10) + ($t_user['abattoir']/10) + ($t_user['port']/5) + ($t_user['centrale']*10) + ($t_user['caserne']*15) + ($t_user['stockage']*30) + ($t_user['usine']*60) + ($t_user['universite']*120) + ($t_user['nerv']*240) + ($t_user['Misalox']/0.4) + ($t_user['Mor']/0.8) + ($t_user['Margent']/1.6) + ($t_user['Mfer']/2) ) / ($t_user['lands']+1) )*3;
	$score += ( $t_user['partisans'] * 150 ) + ($t_user['lands']*750);
	$score  = ceil($score/1000)*100;
	
	$tps = floor( (time()/$dureeTour) )*$dureeTour;
	
	$sql = "UPDATE is_user
	SET `score`        = '".$score."',
		`habitation`   = '".$batiments['a']."',
		`abattoir`     = '".$batiments['b']."',
		`port`         = '".$batiments['c']."',
		`stockage`     = '".$batiments['g']."',
		`centrale`     = '".$batiments['h']."',
		`Misalox`      = '".$batiments['i']."',
		`Mor`          = '".$batiments['j']."',
		`Margent`      = '".$batiments['k']."',
		`Mfer`         = '".$batiments['l']."',
		`universite`   = '".$batiments['n']."',
		`stationradar` = '".$batiments['o']."',
		`tourdefense`  = '".$batiments['q']."',
		`caserne`      = '".$batiments['r']."',
		`usine`        = '".$batiments['s']."',
		`nerv`         = '".$batiments['t']."',
		`partisans`    = '".$ressources['partisans']."',
		`clone`        = '".$ressources['clone']."',
		`nourriture`   = '".$ressources['nourriture']."',
		`electricite`  = '".$ressources['electricite']."',
		`isalox`       = '".$ressources['isalox']."',
		`ors`          = '".$ressources['ors']."',
		`argent`       = '".$ressources['argent']."',
		`fer`          = '".$ressources['fer']."',
		`tour`         = '".$tps."',
		`seconde`      = '".time()."',
		`ip`           = '".$_SERVER['REMOTE_ADDR']."'
	WHERE pseudo='".$pseudo."'";
	mysql_query($sql);
}
else
{
	$sql = "UPDATE is_user
	SET `seconde`      = '".time()."',
		`ip`           = '".$_SERVER['REMOTE_ADDR']."'
	WHERE pseudo='".$pseudo."'";
	mysql_query($sql);
}
//
//HEADER//
//
$sql = "SELECT COUNT(id) FROM is_message WHERE pour='$pseudo' AND lu='0'";
$r_message = mysql_query($sql);
$row = mysql_fetch_row($r_message);
$messages = $row[0];
if( $messages > 0 ) $URLMESSAGE = "green";
else $URLMESSAGE = "";

include("skin/header.tpl");
//
//MIDDLE//
//
if( isset($_SESSION['erreur']) )
{
	echo('<p align="center" class="txt">&quot; '.$_SESSION['erreur'].' &quot;</p>');
	unset($_SESSION['erreur']);
}
if( isset($_GET['include']) ) include("pages/".$_GET['include'].".php");
else include("pages/accueil.php");

if( !isset($t_user) )
{
	$sql = "SELECT * FROM is_user WHERE pseudo = '".$pseudo."'";
	$resultat_user = mysql_query($sql);
	$t_user = mysql_fetch_assoc($resultat_user);
}
//
//FOOT
//
include("skin/foot.tpl");
mysql_close();
?>