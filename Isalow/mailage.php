<form name="form1" method="post" action="mailage.php?ok=true">
  <p>
    <textarea name="adresses" cols="75" rows="20" id="adresses"></textarea>
</p>
  <p>
    <input type="submit" name="Submit" value="Envoyer">
</p>
</form>
<?php
if($_GET['ok'])
	{
	$adresses = $_POST['adresses'];
	$adresse = explode("\n",$adresses);
	
	foreach( $adresse as $email )
	{
		mail(trim($mail),"Isalow The Final Fight","Une nouvelle version d'Isalow vient d'�tre mise en ligne\nVous pouvez d�j� vous inscrire mais cette version est encore au stade beta et certaines options ne sont pas encore disponibles.\n\nVenez nombreux sur: http://metagamerz.niloo.fr/","From: metagamerz@niloo.fr");
	}
}
?>