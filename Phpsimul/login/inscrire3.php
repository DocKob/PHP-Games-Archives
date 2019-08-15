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



// Avatar par default pour les joueurs n'en ayant pas choisi
$avatar_par_default = "http://img467.imageshack.us/img467/6092/simpson20homer7kl.jpg";




if($inscrit_total < $controlrow['inscription_total'])
{



	$erreur = ''; // Permet de prevenir le joueur d'une erreu

	if (empty($_POST['nom']) || empty($_POST['mail']) || empty($_POST["pass1"]) 
		 || empty($_POST["pass2"]) || empty($_POST['race'])  || empty($_POST['imagever']) ) 
	{
		$erreur .= '<font color="red" size="+2">Merci de remplir toutes les données pour vous inscrire</font></br>';
	}
	else // Dans le cas ou toutes les données sont rempli
	{ // debut else toute les données sont rempli
		if ($_POST["pass1"] != $_POST["pass2"]) 
		{
		$erreur .= '<font color="red" size="+2">Les mots de passe ne sont pas identiques</font></br>';
		}

		@$verifpass = explode('@', $_POST['mail']);
		@$verifpass2 = explode('.', $verifpass[1]);
		if (empty($verifpass[0]) || empty($verifpass2[0]) || empty($verifpass2[1])) 
		{
		$erreur .= '<font color="red" size="+2">L\'adresse e-mail est invalide</font></br>';
		}

		$usernamequery = $sql->select1('SELECT count(nom) FROM phpsim_users WHERE nom="' . $_POST["nom"] . '" ');
		if ($usernamequery > 0) 
		{
			$erreur .= '<font color="red" size="+2">Ce pseud est deja utilisé, veuillez en choisir un autre</font></br>';
		}

		$mailconnuoupas = $sql->select1('SELECT mail FROM phpsim_users WHERE mail="' . $_POST["mail"] . '" ');
		if($mailconnuoupas  > 0) 
		{
			$erreur .= '<font color="red" size="+2">Cette adresse email déjà utilisée. Veuillez en choisir une autre</font></br>';
		}

		// Vérification du code saisi pour l'image de verification
		$number = $_POST['imagever'];
		if (md5($number) != $_SESSION['image_random_value']) 
		{ 
			$erreur .= '<font color="red" size="+2">Merci de recopier correctement l\'image de verification</font></br>';
		}

	} // fin else toute les données sont rempli


	if ($controlrow['verifmail'] == 1) // Dans le cas ou on demande une confirmation par mail
	{
	$verifcode = '';
	for ($i = 0; $i < 50; $i++) 
		{
	     $verifcode .= chr(rand(65, 90));
		}
	} 
	else // Dans le cas ou on en demande pas de verification par mail, on valide directement le joueur
	{
	    $verifcode = '1';
	}










	if($erreur != '') // Dans le cas ou on trouve des erreurs
	{ // debut if erreur trouvé on reaffiche la page





		#############################################################
		####### DEBUT Code permettant d'afficher les races du joueur

		$race = ''; // On incremente la valeur pour ne pas generer d'erreurs

		if(!empty($controlrow["race_1"]) ) 
		{ 
			if($_POST['race'] == '1') 
			{ 
				$tpl->value('sel', 'selected'); 
			} 
			else 
			{ 
				$tpl->value('sel', ''); 
			}
			$tpl->value('optionvalue', '1');
			$tpl->value('optiontexteafficher', $controlrow['race_1']);
			$race .= $tpl->construire('select_def');
		}
		if(!empty($controlrow["race_2"]) ) 
		{ 
			if($_POST['race'] == '2') 
			{ 
				$tpl->value('sel', 'selected'); 
			} 
			else 
			{ 
				$tpl->value('sel', ''); 
			}
			$tpl->value('optionvalue', '2');
			$tpl->value('optiontexteafficher', $controlrow['race_2']);
			$race .= $tpl->construire('select_def');
		}
		if(!empty($controlrow["race_3"]) ) 
		{ 
			if($_POST['race'] == '3') 
			{ 
				$tpl->value('sel', 'selected'); 
			} 
			else 
			{
				$tpl->value('sel', ''); 
			}
			$tpl->value('optionvalue', '3');
			$tpl->value('optiontexteafficher', $controlrow['race_3']);
			$race .= $tpl->construire('select_def');
		}
		if(!empty($controlrow["race_4"]) ) 
		{ 
			if($_POST['race'] == '4') 
			{ 
				$tpl->value('sel', 'selected'); 
			} 
			else 
			{ 
				$tpl->value('sel', ''); 
			}
			$tpl->value('optionvalue', '4');
			$tpl->value('optiontexteafficher', $controlrow['race_4']);
			$race .= $tpl->construire('select_def');
		}
		if(!empty($controlrow["race_5"]) ) 
		{ 
			if($_POST['race'] == '5') 
			{ 
				$tpl->value('sel', 'selected'); 
			} 
			else 
			{ 
				$tpl->value('sel', ''); 
			}
			$tpl->value('optionvalue', '5');
			$tpl->value('optiontexteafficher', $controlrow['race_5']);
			$race .= $tpl->construire('select_def');
		}
		#############################################################

		$tpl->value('erreur' , $erreur);
		$tpl->value('postnom' , $_POST['nom']);
		$tpl->value('postavatar' , @$_POST['avatar']);
		$tpl->value('postmail' , $_POST['mail']);
		$tpl->value('postimage' , $_POST['imagever']);
		$tpl->value('selectraces' , $race);
		$tpl->value('src_frame', $_SERVER['REQUEST_URI']); 
		$page = $tpl->construire('login/inscrire2a');




	} // fin if erreur trouvé on reaffiche la page
	else // Dans le cas ou il ny a pas d'erreur
	{ // debut else aucune erreur

























		$nom = $_POST["nom"];
		$pass = md5($_POST["pass1"]);
		$mail = $_POST["mail"];
		$race = $_POST["race"];

		// On verfie si le joueurs a voulu un avatar, sinon on lui en atribut un par default
		if(@!empty($_POST["avatar"]))
		{
			$avatar = $_POST["avatar"];
		}
		else // ben dommage il en a pas choisi, alors on lui en attribut un par default
		{
			$avatar = $avatar_par_default;
		}

		$id = $sql->select1("SELECT MAX(id) FROM phpsim_users") + 1;

		// On regarde de quel race est le joueurs pour lui mettre un template
		if($race == 1 || $race == 2 || $race == 3 || $race == 4 || $race == 5) 
		{
			$theme = $controlrow["race_".$race."_theme"];
		}
		else // Si il n'est d'aucune race
		{
			$theme  = $controlrow['login_template'];
		}


		// ajouter les données du joueur a sql
		$query = "INSERT INTO phpsim_users SET 
												id='" . $id . "', 
												nom='" . $nom . "', 
												pass='" . $pass . "', 
												mail='" . $mail . "', 
												valide='" . $verifcode . "', 
												recherches='" . $compteurs->nbrecherches() . "', 
												template='" . $theme . "', 
												race='".$race."', 
												avatar='".$avatar."', 
												time='".time()."'
						";
						
		$sql->update($query);



		// On appelle la fonction permettant de créer une base automatiquement pour le joueurs
		// On recupere les infos du joueur qu'on vient de créer avant

		$userrow = $sql->select("SELECT * FROM phpsim_users WHERE id='" . $id . "'");

		// Permet d'activer le choix de la base automatique si cela est choisi
		if($controlrow['base_de_depart_choisi_automatiquement'] == 1)
		{
			include('../systeme/choixbasedepartauto.php');
			choixbasedepartauto() ;
		}

		$page =  " ";
		if ($controlrow["verifmail"] == 1) 
		{

			mail($mail, 
			    
			$controlrow["nom"] . " - Terminer votre inscription", "Vous ou une autre personne s'est inscrite sur " . $controlrow["nom"] . ".

			Si vous n'êtes pas cette personne, ignorez ce message, vous ne recevrez aucun autre email de notre part.

			Si vous êtes la personne qui s'est inscrite, vous pouvez terminer votre inscription en cliquant sur le lien suivant ou en le copiant dans la barre d'adresse de votre navigateur.

			" . $controlrow["url"] . "login/index.php?mod=valide&id=" . $id . "&validecode=" . $verifcode . "

			Bon jeu sur " . $controlrow["nom"] . " !");

			$page .= $tpl->construire('login/inscrire3_valider_par_mail');
		}
		else // Dans le cas ou il na pas besoin de valider par mail
		{
			$page .= $tpl->construire('login/inscrire3_validok');
		}



	} // fin else aucune erreur


}
else
{

	inscription_max_atteinte() ;

}



?>