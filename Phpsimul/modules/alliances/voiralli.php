<?PHP

$allitag = $mod[1] ;


$données_alli1=mysql_query("SELECT * FROM phpsim_alliance WHERE tag='".$allitag."'"); 
$données_alli= mysql_fetch_array($données_alli1) ;

if(empty($données_alli['texte']) ) { $données_alli['texte'] = "L'alliance ne possède aucun texte"; }

$page = "
<table>
<tr><td><center><a href='javascript:history.back()'>Retour</a></center></td></tr>
<tr><td><b><u>Texte de présentation de l'alliance : ".$données_alli['nom']."</u></b><br><br></td></tr>
<tr><td>".nl2br($données_alli['texte'])."</td></tr>
<tr><td><center><br>
<a href='index.php?mod=alliances/rejoindre|".$données_alli['tag']."'>Rejoindre cette alliance</a>
</center></td></tr>
</table>
";

?>