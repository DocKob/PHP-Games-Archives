<?php
$page = "<head><script language='JavaScript'>

function ChangeUrl(formulaire)
	{
	if (formulaire.ListeUrl.selectedIndex != 0)
		{
		location.href = formulaire.ListeUrl.options[formulaire.ListeUrl.selectedIndex].value;
	 	}
	else 
		{
		alert('Veuillez choisir une destination.');
		}
	}
</script>
</head>
Afficher le classement des : <form><SELECT NAME='ListeUrl' SIZE=1 onChange='ChangeUrl(this.form)'>
<OPTION SELECTED VALUE=''>--- Selectionnez ---
<option value='index.php?mod=classement'>Joueurs</option>
<option value='index.php?mod=alliances/classement2'>Alliances</option>
</select></form><br>";
$page .= "<center><table border='1' width='400'><tr><th>N°</th><th>Nom de l'alliance</th><th>Tag</th><th>Points</th></tr>";
$nombre = 1 ;

$c = mysql_query("SELECT * From phpsim_alliance ");
while ($d = mysql_fetch_array ($c)) {
$e = mysql_query("SELECT SUM(points) as total From phpsim_users Where alli='".$d['id']."' ") ;
while ($f = mysql_fetch_array ($e)) {

$page .= " 
<tr><td>".$nombre."</td><td><a href='index.php?mod=alliances/voiralli|".$d['tag']."'>".$d['nom']."</a></td>
<td><a href='index.php?mod=alliances/rejoindre|".$d['tag']."'>".$d['tag']."</a></td>
<td>".$f['total']."</td>
</td></tr>
";

$nombre = $nombre + 1 ;
}
}
$page .= " </table> </center>" ;
?>