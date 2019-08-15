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

// On bloque l'execution de la page pour les modo, elle est seulement autorisé pour les administrateurs et fondateurs
if($userrow['administrateur'] != '1' && $userrow['fondateur'] != '1')
{
	die('<script>document.location="?mod=aide&error=interdit_au_modo"</script>'); // On redirige sur la page gerant les erreurs afficher en alerte JS
}

$page = ''; // On initalise la variable



switch(@$_GET['action'])
{ // debut switch action

	/**************************************************\
	|**************************************************|
	\**************************************************/
	
	case 'modifier' :
	
    	$row = $sql->select("SELECT * FROM ".PREFIXE_TABLES.TABLE_RESSOURCES." WHERE id='" . $_GET["ressource"] . "' ");

    $page .=  "<form method='post' action='?mod=ressources&envoyemodif=" . $_GET["ressource"] . "'>
					<table align = 'center'>
						<tr>
							<td>
								Nom :  <input type='text' name='nom' value='" . $row["nom"] . "'>
							</td>
						</tr>
						<tr>
							<td>
								<br>
								Image (uploadez l'image dans le dossier images/ressources sous le nom x.gif 
								ou x est un nombre, indiquez ce nombre) : 
								<br>
								images/ressources: <input type='text' name='image' value='" . $row["image"] . "'>.gif
							</td>
						</tr>
					</table>
					<br>
					<input type='submit' value='Valider'>
					</form>
					<br>
					<br>
					<center>
					<img src='admin/tpl/images/retour.gif.png'> <a href='?mod=ressources'>Retour</a></center>
				  ";

	break;
	
	/**************************************************\
	|**************************************************|
	\**************************************************/
	
	default :
		
		if(!empty($_GET['envoyemodif']) ) // Dans le cas ou une modif a été envoyé
		{
			// $_GEt['envoyemodif'] contient l'id de la ressource a modifier
			
			extract($_POST); // On extrait les données du tableau
		   
    		$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_RESSOURCES." SET nom='" . $nom . "', 
    																 image='" . $image . "' 
    														   WHERE id='" . $_GET["envoyemodif"] . "'
    						 ");

   		$page .= "<img src='admin/tpl/icons/accept.png'>Enregistrement effectué avec succès.
   					 <br>
   					 <br>
   					 <br>
   					";

		
		}
		
		###########################################################################

		if(@$_GET['creer'] == 1) // Dans le cas ou on a demander a créer une nouvelle ressource
		{ 
    		$id = $sql->select1("SELECT MAX(id) FROM ".PREFIXE_TABLES.TABLE_RESSOURCES." ") + 1; // On recupere l'id le plus elevé dans la table des ressources et on l'incremente de 1 pour obtenir notre nouvelle id

    		$sql->update("INSERT INTO ".PREFIXE_TABLES.TABLE_RESSOURCES." SET id='" . $id . "', nom='Nouvelle ressource' "); // on insere le nouvelle id dans la table
    
    
    		// On rajoute l'existance de la ressource pour chaque joueur
			$query = $sql->query('SELECT id, ressources, productions, stockage FROM '.PREFIXE_TABLES.TABLE_BASES.' ');
			while ($row = mysql_fetch_array($query) )
			{
				$ressources = $row["ressources"] . ( ($row['ressources'] == '') ? '0' : ',0' );
				$productions = $row["productions"] . ( ($row['productions'] == '') ? '0' : ',0' );
				$stockage= $row["stockage"] . ( ($row['stockage'] == '') ? '100000' : ',100000' );

				$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_BASES." SET 
																							ressources='" . $ressources . "',
																							productions='".$productions."', 
																							stockage='".$stockage."'
																					 WHERE id='" . $row["id"] . "' 
								 ");
			}
			

			// On modifie la configuration de la table des configuration en ajoutant la nouvelle ressource
			$ressources_depart = $controlrow["ressourcesdepart"] . ( ($controlrow["ressourcesdepart"] == '') ? '0' : ',0');
			$production_depart = $controlrow["productiondepart"] . ( ($controlrow["productiondepart"] == '') ? '0' : ',0');
			$stockage_depart = $controlrow["stockagedepart"] . ( ($controlrow["stockagedepart"] == '') ? '100000' : ',100000');

			$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . $ressources_depart . "' WHERE config_name='ressourcesdepart' ");
			$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . $production_depart . "' WHERE config_name='productiondepart' ");
			$sql->update("UPDATE ".PREFIXE_TABLES.TABLE_CONFIG." SET config_value='" . $stockage_depart . "' WHERE config_name='stockagedepart' ");
			
			// On detruit le cache pour l'actualiser
			unlink('cache/controlrow');
			
			$page .= "La ressource a bien été créé. Vous pouvez maintenant la configurer.</center><br><br>";
			
		}
		
		###########################################################################

		if(!empty($_GET['supprimer']) ) // Dans le cas ou on a demander a supprimer la derniere ressource
		{
			// $_GET['supprimer'] contient l'id de la ressource a supprimer
			// Le script d'administration concu a la base par Stevenson ne permettait de supprimer que la derniere ressource
			// Du au faite que je ne sait pas pourquoi, peut etre a cause d'un bug ?? Je laisse comme cela a été fait
			// -- Max485
			
			$sql->update("DELETE FROM ".PREFIXE_TABLES.TABLE_RESSOURCES." WHERE id='" . $_GET["supprimer"] . "' ");
		}
		
		###########################################################################
		
		// On recupere les ressources existante dans la base de données
		$ressources = mysql_query("SELECT * FROM ".PREFIXE_TABLES.TABLE_RESSOURCES." ORDER BY id");
		
		$page .= '
					 <table>
					 	<tr>
					 		<td>
					 			<u><b>Nom</b></u>
					 		</td>
					 	</tr>
					';
		
		while ($ressource = mysql_fetch_array($ressources) ) 
		{
    		$page .= "<tr>
    						<td>
    							<img src='admin/tpl/icons/money.png'>
    							<a href='?mod=ressources&action=modifier&ressource=" . $ressource["id"] . "'>
    								" . $ressource["nom"] . "
    							</a>
    						</td>
    					</tr>
    				  ";
    				  
    		$dernier_id = $ressource["id"]; // Permet de recuperer le dernier id des ressources pour pouvoir supprimer la deniere ressource existante
		}

		$page .= "
					</table>
					<br>
					<img src='admin/tpl/icons/money_add.png'>
					<a href='?mod=ressources&creer=1'> 
						Créer une nouvelle ressources.
					</a>
					<br>
					<br>
					<img src='admin/tpl/icons/money_delete.png'>
					<a href='?mod=ressources&supprimer=" . $dernier_id . "'>
						<font color='red'> Supprimer la dernière  ressource</font>
					</a>.
					<br>
					<br>
					<img src='admin/tpl/icons/retour.gif.png'> 
					<a href='?mod=default'>Retour</a>
				 	";

	break;

	/**************************************************\
	|**************************************************|
	\**************************************************/
	
		
} // fin switch get action

?>