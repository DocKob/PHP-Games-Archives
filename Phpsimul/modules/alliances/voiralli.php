<?PHP

$allitag = $mod[1] ;


$donn�es_alli1=mysql_query("SELECT * FROM phpsim_alliance WHERE tag='".$allitag."'"); 
$donn�es_alli= mysql_fetch_array($donn�es_alli1) ;

if(empty($donn�es_alli['texte']) ) { $donn�es_alli['texte'] = "L'alliance ne poss�de aucun texte"; }

$page = "
<table>
<tr><td><center><a href='javascript:history.back()'>Retour</a></center></td></tr>
<tr><td><b><u>Texte de pr�sentation de l'alliance : ".$donn�es_alli['nom']."</u></b><br><br></td></tr>
<tr><td>".nl2br($donn�es_alli['texte'])."</td></tr>
<tr><td><center><br>
<a href='index.php?mod=alliances/rejoindre|".$donn�es_alli['tag']."'>Rejoindre cette alliance</a>
</center></td></tr>
</table>
";

?>