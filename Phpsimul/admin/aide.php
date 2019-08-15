<?php

// Si la constante n'est pas defini on bloque l'execution du fichier
if(!defined('PHPSIMUL_PAGES') || @PHPSIMUL_PAGES != 'PHPSIMULLL') 
{
die('Erreur 404 - Le fichier n\'a pas été trouvé');
}

/* PHPsimul : Créez votre jeu de simulation en PHP
Copyright (©) - 2007 - CAPARROS Sébastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr

*/

$page ='';


switch(@$_GET['action'])
{ // debut switch get action

	/*******************************************************************\
	|*******************************************************************|
	\*******************************************************************/
	
	case 'selectressources':
		
		$ressources = $sql->query("SELECT * FROM ".PREFIXE_TABLES.TABLE_RESSOURCES." ");
		
		$nombre = 0;

		$page .= "<form method='post' action='?mod=aide&action=selectressources2'>
					 <table>
					";

		while ($ressource = mysql_fetch_array($ressources) ) 
		{
    		$page .= "<tr><td>" . $ressource["nom"] . " : </td>
    						  <td><input type='text' name='" . $nombre . "'></td>
    					 </tr>
    					";

    		$nombre++;
		}

		$page .= "</table><br><input type='submit' value='Valider'></form>
					 <br><br><center><img src='design/icons/retour.gif.png'> 
					 <a href='?mod=default'>Retour</a></center>
					";
	
	break;


	/*******************************************************************\
	|*******************************************************************|
	\*******************************************************************/

	case 'selectressources2':
		
		$nombre = 0;
		$chiffre = 0;
		
		while (@$_POST[$nombre] != '') 
		{
    		if ($chiffre == 0) 
    		{
        		$ressource = $_POST[$nombre];
        		$chiffre = 1;
    		} 
    		else 
    		{
        		$ressource .= "," . $_POST[$nombre];
    		}
    		$nombre++;
		}

		$page = "Veuillez copier-coller le texte ci-dessous dans le champ que vous souhaitez compléter.<br><br>
					<input type='text' value='" . $ressource . "'><br><br>
					<center><img src='design/icons/retour.gif.png'> <a href='?mod=aide&action=selectressources'>Retour</a></center>
				  ";
	
		
	break;

	/*******************************************************************\
	|*******************************************************************|
	\*******************************************************************/

	case 'selectrecherches':

		$page .= "	
					<form method='post' action='?mod=aide&action=selectrecherches2'>
					
					Veuillez indiquer le nombre de recherches qui seront nécéssaires : 
					<input type='text' name='nombre'>
					<br>
					<br>
					<input type='submit' value='Valider'>
					</form>
					";
	
	break;

	/*******************************************************************\
	|*******************************************************************|
	\*******************************************************************/

	case 'selectrecherches2':

		$page .= "<form method='post' action='?mod=aide&action=selectrecherches3'>";	

		$chiffre = 0;

		while ($chiffre < $_POST["nombre"]) 
		{
    		$page .= "<select name='" . $chiffre . "'>";
    
    		$query = mysql_query("SELECT * FROM phpsim_recherches");
    
    		while ($row = mysql_fetch_array($query) ) 
    		{
        		$page .= "<option value='" . $row["id"] . "'>" . $row["nom"] . "</option>";
    		}
    		$page .= "</select> niveau <input type='text' name='niv" . $chiffre . "'><br>";
    		
    		$chiffre++;
		}

		$page .= "<input type='submit' value='Valider'></form>";
	
	break;

	/*******************************************************************\
	|*******************************************************************|
	\*******************************************************************/

	case 'selectrecherches3':

		$nombre = 0;
		$chiffre = 0;

		while ($_POST[$nombre] != "" && $_POST["niv" . $nombre] != "") 
		{
    		if ($chiffre == 0) 
    		{
        		$bat = $_POST[$nombre] . "-" . $_POST["niv" . $nombre];
        		$chiffre = 1;
    		} 
    		else 
    		{
        		$bat .= "," . $_POST[$nombre] . "-" . $_POST["niv" . $nombre];
    		}
    		$nombre++;
		}

		$page .="Veuillez copier-coller le texte ci-dessous dans le champ indiqué.
					<br>
					<input type='text' value='" . $bat . "'>
				  ";
	
	break;
	
	/*******************************************************************\
	|*******************************************************************|
	\*******************************************************************/

	case 'selectbatiments':

		$page .= "<form method='post' action='?mod=aide&action=selectbatiments2'>
					 Veuillez indiquer le nombre de batiments qui seront nécéssaires : 
					 <input type='text' name='nombre'>
					 <br>
					 <input type='submit' value='Valider'>
					 </form>
					";
	
	break;

	/*******************************************************************\
	|*******************************************************************|
	\*******************************************************************/

	case 'selectbatiments2':

		$page .= "<form method='post' action='?mod=aide&action=selectbatiments3'>";

		$chiffre = 0;

		while ($chiffre < $_POST["nombre"]) 
		{
    		$page .= "<select name='" . $chiffre . "'>";
    		
    		$query = mysql_query("SELECT * FROM phpsim_batiments ");
    		
    		while ($row = mysql_fetch_array($query) ) 
    		{
        		$page .= "<option value='" . $row["id"] . "'>" . $row["nom"] . "</option>";
    		}
    		$page .= "</select> niveau <input type='text' name='niv" . $chiffre . "'><br>";
    		
    		$chiffre++;
		}

		$page .= "<input type='submit' value='Valider'></form>
		          <br>
		          <br><center><img src='design/icons/retour.gif.png'> <a href='?mod=aide&action=selectbatiments'>Retour</a></center>
		         ";

	
	break;

	/*******************************************************************\
	|*******************************************************************|
	\*******************************************************************/

	case 'selectbatiments3':

		$nombre = 0;
		$chiffre = 0;

		while ($_POST[$nombre] != "" && $_POST["niv" . $nombre] != "") 
		{
    		if ($chiffre == 0) 
    		{
        		$bat = $_POST[$nombre] . "-" . $_POST["niv" . $nombre];
        		$chiffre = 1;
    		} 
    		else 
    		{
        		$bat .= "," . $_POST[$nombre] . "-" . $_POST["niv" . $nombre];
    		}
    		$nombre++;
		}

		$page .= "Veuillez copier-coller le texte ci-dessous dans le champ indiqué.
					 <br>
					 <input type='text' value='" . $bat . "'>
				 ";
	
	break;

	/*******************************************************************\
	|*******************************************************************|
	\*******************************************************************/

	case 'maj' :
			
		$page .= '
					Bienvenue dans le module de mise à jour de PHPSimul. 
					Lorsque vous voudrez installer une mise à jour, 
					vous devrez copier les fichiers extraits vers votre ftp, 
					en écrasant les existants, puis éxécuter les requetes du fichier sql.txt.
					<br>
					<br>
					<br>
					<IFRAME 
						SRC="http://f-server.myftp.org/phpsimul/Divers/maj/index.php?sql='.$controlrow["maj"].'&url='.$controlrow["url"].'"
						NAME="iframe" HEIGHT="500" WIDTH="600"> 
					</IFRAME>
				 ';
	break;
	
	/*******************************************************************\
	|*******************************************************************|
	\*******************************************************************/

	case 'maj_telecharger' :
	
		if(isset($_GET['ajout']) ) 
		{
			$new = $controlrow['maj'] . "," . $_GET['ajout'];

			$sql->update("UPDATE phpsim_config SET maj='".$new."' WHERE id='1'");
		}

		$page .= "
					 Mise a jour enregistrée.
					 <br>
					 <br>
					 <a href='?mod=aide&action=maj'>Retour</a>
				 ";
			
	break;

} // fin switch get action



// Dans le cas ou on veut envoyer une erreur
switch(@$_GET['error'])
{ // debut switch get error

	case 'interdit_au_modo': // Dans le cas ou un modo a voulu acceder a un mod interdit au modo
	
		die('
				<script>
					alert("En tant que modérateur, vous n\'avez pas accès à cette page");
					document.location="?mod='.( (@$_GET['redirection'] == '')?'default':$_GET['redirection'] ).'"
				</script>
			');

	break;
	
	/*******************************************************************\
	|*******************************************************************|
	\*******************************************************************/
	
	case 'modification_fondateur_interdite' : // Si il s'agit d'un admin qui tient a modifier un compte fondateur
		
		die('
				<script>
					alert("Pour agir sur un compte fondateur, vous devez avoir le pouvoir de fondateur");
					location="?mod='.( (@$_GET['redirection'] == '')?'default':$_GET['redirection'] ).'"
				</script>
			');		
	break;
	
	/*******************************************************************\
	|*******************************************************************|
	\*******************************************************************/

	
} // fin switch error
		
		
?>