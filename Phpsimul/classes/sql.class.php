<?php


/* 

Atlantis DSV

GamePlay => Stenvenson
Code => Max485

© Tous droit réservé - Copie illegal - 2008/2009

*/

define('BDD_PORT', 3306);

class Sql 
{


    var $nombrerequetes = 0; // Permet de connaitre le nombres de requete effectué pour l'affichage d'une page

	###############################################################################
	/*******************************************************************************************************\
				POUR SE CONNECTER AU SERVEUR SQL
	\*******************************************************************************************************/
    function connect() // Permet dans le cas ou on arrive pas sur ce fichier par l'index du jeu de definir ou se trouve le config.php
    {
        mysql_connect(BDD_HOST.':'.BDD_PORT, BDD_USER, BDD_PASS) 
				or die('<font color="red">IMPOSSIBLE DE SE CONNECTER AU SERVEUR SQL
						<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HOST :</font> '.BDD_HOST.'
						<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="red">PORT :</font> '.BDD_PORT.'
						<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="red">UTILISATEUR :</font> '.BDD_USER.'
						<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="red">PASS :</font> ********
						<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="red">ERREUR : </font>'.mysql_error()
					  );
					   
        mysql_select_db(BDD_NOM) 
				or die('<font color="red">IL EST IMPOSSIBLE DE SELECTIONNER LA BASE DE DONNÉES
						<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BASE DEMANDÉ : </font>'.BDD_NOM.'
						<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="red">ERREUR : </font>'.mysql_error()
					  );
    }
	
	###############################################################################
	/*******************************************************************************************************\
		POUR SE DECONNECTER DU SERVEUR SQL
	\*******************************************************************************************************/
    function close()
    {
        mysql_close()
				or die('<font color="red">IL EST IMPOSSIBLE DE FERMER LA BASE DE DONNÉES');
    }
	
	###############################################################################
	/*******************************************************************************************************\
		DANS LE CAS DE DEMANDE D'UNE SEULE LIGNE, RENVOYE LE TABLEAU 
	\*******************************************************************************************************/
    function select($texte)
    {
        global $nombrerequetes;
        $query = mysql_query($texte) 
						or die('<font color="red">ERREUR SQL :
								<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REQUÊTE :</font> '.htmlentities($texte).' 
								<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="red">ERREUR :</font> '.mysql_error()  
							  );
        $row = mysql_fetch_array($query);
        $nombrerequetes++;
        return $row;
    }
	###############################################################################
	/*******************************************************************************************************\
		PERMET LORSQUE UN SEULE CHAMP DE SQL EST DEMANDER, DE L'ENVOYE DIRECTEMENT 
	\*******************************************************************************************************/
    function select1($texte)
    {
        global $nombrerequetes;
        $query = mysql_query($texte) 
						or die('<font color="red">ERREUR SQL :
								<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REQUÊTE :</font> '.htmlentities($texte).' 
								<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="red">ERREUR :</font> '.mysql_error() 
							  );
        $row2 = mysql_fetch_array($query);
        $row = $row2['0'];
        $nombrerequetes++;
        return $row;
    }
	###############################################################################
	/*******************************************************************************************************\
		POUR MODIFIER UN TEXTE, CETTE FONCTION NE RENVOYE RIEN
	\*******************************************************************************************************/
    function update($texte)
    {
        global $nombrerequetes;
        mysql_query($texte) 
				or die('<font color="red">ERREUR SQL :
						<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REQUÊTE :</font> '.htmlentities($texte).' 
						<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="red">ERREUR :</font> '.mysql_error() 
					  );
        $nombrerequetes++;
    }
	###############################################################################
	/****************************************µ**************************************************************\
	CETTE FONCTION AGIT COMME mysql_query() CEPENDANT ELLE PERMET DE CALCULER LA REQUETE
	\*******************************************************************************************************/
    function query($texte)
    {
        global $nombrerequetes;
        $query = mysql_query($texte) 
						or die('<font color="red">ERREUR SQL :<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REQUÊTE :</font> '.htmlentities($texte).' 
								<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="red">ERREUR :</font> '.mysql_error() 
							  );
        $nombrerequetes++;
        return $query;
    }
	###############################################################################
	/*******************************************************************************************************\
		COMPTE LE NOMBRE TOTAL DE REQUETES EFFECTUÉ POUR AFFICHER LA PAGE
	\*******************************************************************************************************/
    function compter()
    {

        global $nombrerequetes;
        return $nombrerequetes;

    }
	###############################################################################
	/*******************************************************************************************************\
		PERMET D'EXECUTER UN AJOUT D4UN FICHIER DANS SQL
	\*******************************************************************************************************/
	function execbackup($nom_fichier_backup,$del_fichier='0')
	{
		$requetes="";
		 
		$sql=file($nom_fichier_backup); // on charge le fichier SQL
		foreach($sql as $l) // on le lit
		{ 
			if (substr(trim($l),0,2)!="--")  // suppression des commentaires
			{
				$requetes .= $l;
			}
		}

		$reqs = split(";",$requetes);// on sépare les requêtes
		foreach($reqs as $req) // et on les éxécute
		{
			if (!mysql_query($req) && trim($req)!='')
			{
			    // Si une erreur est produite, on stoppe l'execution et on parle de l'erreur
				die("<br><center><h1>Une erreur s'est produite au niveau de la requete :</h1>
				     <h2><font color='FF0000'> ".$req."</font></h2>
				     <br><h1>Erreur retournée par le serveur MySQL :</h1>
				     <h2><font color='FF0000'> ".mysql_error()."</font></h2>
				     <br><h3><font color='0000FF'>Merci de réessayer l'installation et de prendre en compte l'erreur retournée par MySQL</font></h3>
		             <style>.lien_install { text-decoration: none ; }</style><br><br>
					 <h3><a class='lien_install' href='javascript: history.back();'><font color='191970'>Retour sur la page d'accueil</font></a>
		            "); 
			}
		}

		if($del_fichier == '1') // Si l'utilisateur a demandé la suppression du fichier
		{ 
			unlink($nom_fichier_backup); 
		} 

	}
	#######################################################################################
}


?>