<?PHP

define('PHPSIMUL_PAGES', 'PHPSIMULLL');
include('systeme/config.php'); // Configurations SQL et autres
include ("classes/sql.class.php");
$sql = new sql;
$sql->connect();

include('classes/cache.class.php'); // Pour permettre de faire des caches
$cache = new cache(); // Demarre la classes des caches

// On recupere ce que contient la table des config
$controlrow = $cache->cache_config('cache/controlrow');

$page = "
			<head>
				<title>
					".@$controlrow['titre_lecteur_musique']."
				</title>
			</head>
			<center>
			<table border='1' width=360 height=200 >
		";

switch(@$_GET['action'])
{ // debut switch get action

	case 'ecouter' :
		
		// On recupere les infos de la chanson a ecouter
		$chanson = $sql->select('SELECT * FROM '.PREFIXE_TABLES.TABLE_MUSIQUE.' WHERE id='.$_GET['musique'].' ');
		
		$page .= "
					<center>
					<br>
					<br>
					<table border='1' width=360 height=200>
						<tr>
							<td>
								<center>Lecture en cours :<br><br>
								Nom : <b>".$chanson['titre']."</b><br>
								Artiste : <b>".$chanson['artiste']."</b><br>
								<br>
								<object type='application/x-shockwave-flash' data='dewplayer.swf?mp3=musique/".$chanson['nom'].".".$chanson['extension']."&amp;showtime=1' width='200' height='20'>
									<param name='wmode' value='transparent'>
									<param name='movie' value='dewplayer.swf?mp3=".$chanson['titre'].".".$chanson['extension']."&amp;showtime=1' />
								</object>
							</td>
						</tr>
					</table>
					<br>
					<a href='musique.php'>Retour a la liste des chansons</a>
				 ";
	
	break;
	
	################################################################
	
	default :
	
		// On recuperes les chansons existante dans la table
		$chansons = mysql_query("SELECT * FROM ".PREFIXE_TABLES.TABLE_MUSIQUE." ORDER BY titre") ;
		
		if(mysql_num_rows($chansons) <= 0) // Dans le cas ou il n'y a pas de chansons dans la base de données
		{
			$page .= '
						Il n\' y aucune chansons a écouté pour le moment
					 ';
		}
		elseif(mysql_num_rows($chansons) > 0) // Dans le cas ou il y a des chansons dans la base de donnée
		{
			$page .= "
						<b>Choisir votre chanson :</b><br> 
						<table width='350' border='1'><tr><th>N°</th><th>Titre</th><th>Artiste</th><th>&nbsp;</th></tr>";
			
			$nombre = 1 ;
			while ($chanson = mysql_fetch_array ($chansons) ) 
			{
				$page .= " 
							<tr>
								<td align='center'>".$nombre."</td>
								<td align='center'>".$chanson['titre']."</td>
								<td align='center'>".$chanson['artiste']."</td>
								<td align='center'>
									<a href='?action=ecouter&musique=".$chanson['id']."'>
										<img border='0'  height='30' src='templates/".$controlrow['login_template']."/images/sono.jpg'>
									</a>
								</td>
							</tr>
						 ";
				$nombre++;
			}
		}
			
} // fin switch get action

echo $page; // On affiche la page

?>