<?php

// Si la constante n'est pas defini on bloque l'execution du fichier
if(!defined('PHPSIMUL_PAGES') || @PHPSIMUL_PAGES != 'PHPSIMULLL') 
{
die('Erreur 404 - Le fichier n\'a pas été trouvé');
}

/* 

PHPsimul : Créez votre jeu de simulation en PHP
Copyright (©) - 2007 - CAPARROS Sébastien (Camaris)

Codeur officiel: Camaris & Max485
http://forum.epic-arena.fr

*/



/*
	Classe Tpl : Moteur de template avec cache intégré optimisé pour PHP 5
	gère l'assignation de variables simples et de tableaux de variables
	gère les blocs avec suppression conditionnelle et les boucles
	gère la création de listes déroulantes

	Version 1.1.0.20080608

	Copyright © NiCo <neointhematrix@fr.st>

	Inspirée de nombreux systèmes de template existants
*/

//Pour récupérer le template à la fin : recuptpl()
class Tpl
{
	private $tpl;
	private $blocs;
	private $contenu_blocs;
	private $dossier_cache;
	private $temps_cache;

	// Charge le template donné
	public function fichier($fichier)
	{
		if (file_exists($fichier))
		{
			$this->dossier_cache = 'cache/';
			$this->temps_cache = '600'; // Le cache est valable 10 minutes
			$this->tpl = file_get_contents($fichier);
			$this->blocs = array();
			$this->contenu_blocs = array();
		}
		else
		{
			die('Attention! Problème lors de la récupération du fichier ' . $fichier);
		}
	}

	/* Assigne une variable simple au template ou un tableau de variables
	* Côté Template :
		<div>{TITRE}</div>
		<table>
			<tr>
				<td>{TITRE2}</td>
				<td>{TEXTE}</td>
			</tr>
		</table>
	* Côté php :
		$tpl->assign('TITRE', 'Exemple');
		$tpl->assign(array(
			'TITRE2' => 'Exemple2',
			'TEXTE' => 'Test de la fonction assign'
		));
	*/
	public function assign($variable, $valeur = '')
	{
		$rechercher = array();
		$remplacer = array();
		if (is_array($variable))
		{
			foreach ($variable AS $cle => $valeur)
			{
				$rechercher[] = '{' . $cle . '}';
				$remplacer[] = $valeur;
			}
		}
		else
		{
			$rechercher[] = '{' . $variable . '}';
			$remplacer[] = $valeur;
		}
		$this->tpl = str_replace($rechercher, $remplacer, $this->tpl);
	}

	/* Permet de placer un bloc conditionnel et ses variables
	* Côté Template :
		<!--MONBLOC-->
			<table>
				<tr>
					<td>{NOM}</td>
					<td>{DESCRIPTION}</td>
				</tr>
			</table>
		<!--/NOMBLOC-->
	* Côté PHP :
		$tpl->bloc("NOMBLOC", array("NOM" => $nom, "DESCRIPTION" => $description));
	*/
	public function bloc($nom_bloc, $tableau)
	{
		$array_recherche = array('<!--' . $nom_bloc . '-->', '<!--/' . $nom_bloc . '-->');
		$array_remplace = array('', '');
		if (!isset($this->blocs[$nom_bloc]))
		{
			$tableau_ereg = array();
			ereg('<!--' . $nom_bloc . '-->(.*)<!--/' . $nom_bloc . '-->', $this->tpl, $tableau_ereg);
			$this->blocs[$nom_bloc] = $tableau_ereg[0];
		}
		while (list($cle, $valeur) = each($tableau))
		{
			$array_recherche[] = '{' . $cle . '}';
			$array_remplace[] = $valeur;
		}
		if (!isset($this->contenu_blocs[$nom_bloc]))
		{
			$this->contenu_blocs[$nom_bloc] = str_replace($array_recherche, $array_remplace, $this->blocs[$nom_bloc]);
		}
		else
		{
			$this->contenu_blocs[$nom_bloc] .= str_replace($array_recherche, $array_remplace, $this->blocs[$nom_bloc]);
		}
	}

	/* Très utile pour les boucles, assigne en boucle les variables stockées dans $tag_array
	* Côté Template :
	<table> 
		{BALISE id=1}
		<tr>
			<td>{NOM}</td>
			<td>{DESCRIPTION}</td>
		</tr>
		{/BALISE}
	</table>
	* Côté PHP :
		$sql = 'SELECT nom, description FROM test';
		$reponse = mysql_query($sql);
		$nom = array();
		$description = array();
		while ($donnees = mysql_fetch_array($reponse))
		{
			$nom[] = $donnees['nom'];
			$description[] = $donnees['description'];
		}
		$global = array('NOM' => $nom, 'DESCRIPTION' => $description);
		$tpl->assigntag('BALISE', '1', $global);
	*/
	public function assigntag($tag, $id, $tableau)
	{
		if ($this->veriftableau($tableau))
		{
			reset($tableau);
			$nom_cle = count($tableau);
			$nom_valeur = count($tableau[key($tableau)]);
			$tmp = $this->trouvertag($tag, $id);
			for ($i = 0; $i < $nom_valeur; $i++)
			{
				$tab[$i] = $tmp;
				reset($tableau);
				for ($j = 0; $j < $nom_cle; $j++)
				{
					$tab[$i] = str_replace('{' . key($tableau) . '}', $tableau[key($tableau)][$i], $tab[$i]);
					next($tableau);
				}
			}
			for ($i = 1; $i < count($tab); $i++)
			{
				$tab[0] .= $tab[$i];
			}
			$remplacer = '{' . $tag . ' id=' . $id . '}' . $tmp . '{/' . $tag . '}';
			$this->tpl = str_replace($remplacer, $tab[0], $this->tpl);
		}
		else
		{
			die("Attention! Erreur dans la taille des tableaux de la balise $tag id=$id");
		}
	}

	/* Permet de supprimer dynamiquement un bloc
	* Côté Template :
		<!--BLOC1-->
			<table>
				<tr>
					<td>{ERREUR}</td>
				</tr>
			</table>
		<!--/BLOC1-->
		...
	* Côté PHP :
		if ($erreur)
		{
			$tpl->bloc("BLOC1", array ("ERREUR" => "Texte à afficher en cas d'erreur."));
		}
		else
		{
			$tpl->supprime_bloc('BLOC1');
		}
	*/
	public function supprime_bloc($nom_bloc)
	{
		$this->tpl = preg_replace('`<!--' . $nom_bloc . '-->(.+?)<!--/' . $nom_bloc . '-->`sim', '', $this->tpl);
	}

	/* Permet d'inclure une liste déroulante
	* Côté Template :
		<div>{HTMLSELECT id=test_select}</div> // OU <div>{TMLSELECT id=test_select selected=1}</div> Sachant que la sélection dans le PHP est prioritaire sur celle dans le TPL
	* Côté PHP :
		$option = array('0' => 'test0', '1' => 'test1', '2' => 'test2', '3' =>'test3');
		$tpl->htmlSelect('test_select', $option, '1', array('onclick' => '"mafonction()"', 'id' => 'ideselect', 'class' => 'classselect')); // Sélectionne test1 et gère des attributs
	*/
	public function htmlselect($nom, $tableau, $selected = "", $attributs = array())
	{
		//on test la balise avec l'option selected
        $select = $this->trouvertag("HTMLSELECT", $nom, "SELECTED");
        if (!$select)
		{
			//si on l'a pas trouvé on cherche sans l'option selected
			if ($this->trouvertag("HTMLSELECT", $nom))
			{
				$tmp = $this->creerhtmlselect($nom, $tableau, $selected, $attributs);
				$this->tpl = str_replace("{HTMLSELECT id=$nom}", $tmp, $this->tpl);
			}
			else
			{
				die("Attention! Impossible de trouver HTMLSELECT $nom");
            }
		}
		else
		{
			$tmp = $this->creerhtmlselect($nom, $tableau, $select, $attributs);
			$this->tpl = str_replace("{HTMLSELECT id=$nom selected=$select}", $tmp, $this->tpl);
		}
	}

	public function recuptpl()
	{
		$tag = '[a-zA-Z0-9_]{1,}';
		$id = '[a-zA-Z0-9_]{1,}';
		// supprime les balises de boucles et leur contenu ainsi que les listes déroulantes
		$this->tpl = preg_replace('/(\{' . $tag . ' id=)(' . $id . ')(})(.*?)(\{\/' . $tag . '})/ism', '', $this->tpl);
		$this->tpl = preg_replace('/(\{' . $tag . ' id=)(' . $id . ')(})/ism', '', $this->tpl);
		// On parse les blocs
		while (list($cle, $valeur) = each($this->contenu_blocs))
		{
			$this->tpl = str_replace($this->blocs[$cle], $valeur, $this->tpl);
		}
		// On supprime les commentaires de nom des blocs
		//$this->tpl = preg_replace('`<!--(.+?)-->|<!--/(.+?)-->`', '', $this->tpl);
		// On place le template en cache
		if (isset($GLOBALS['set_to_cache'])) // Cette variable est à définir à TRUE dans les fichiers PHP que l'on veut mettre en cache
		{
			$fichier_cache = $this->dossier_cache . md5($_SERVER['REQUEST_URI']);
			$f = fopen($fichier_cache, 'w+');
			fputs($f, $this->tpl);
			fclose($f);
		}
		return $this->tpl;
	}

	// Affiche le template et gère le cache
	public function afficher()
	{
		$debut = microtime();
		$fichier_cache = $this->dossier_cache . md5($_SERVER['REQUEST_URI']);
		$interval = time() - @filemtime($fichier_cache);
		if (file_exists($fichier_cache) && ($interval < $this->temps_cache) && (isset($GLOBALS['set_to_cache'])))
		{
			echo "<!-- LU A PARTIR DU CACHE -->";
			readfile ($fichier_cache);
			$fin = microtime();
			$total = (integer)(($fin - $debut) * 1000);
			if ($total < 0) $total = 0;
			echo "<!-- TEMPS D'EXECUTION : " . $total . " -->";
		}
		else
		{
			echo "<!-- CALCULE SANS CACHE -->";
			echo $this->recuptpl();
			$fin = microtime();
			$total = (integer)(($fin - $debut) * 1000);
			if ($total < 0) $total = 0;
			echo "<!-- TEMPS D'EXECUTION : " . $total . " -->";
		}
	}


/*******************************************************************************************************************
	Fonctions privées
*******************************************************************************************************************/


	// Fonction permettant de récupérer le texte entre deux balises
	private function trouvertag($tag, $id, $option = "")
	{
		if (empty($option))
		{
			//retourne la chaine si il la trouvé et rien sinon
			@preg_match("/(\{" . $tag . " id=)(" . $id . ")(})(.*?)(\{\/" . $tag . "})/ism", $this->tpl, $resultat);
			if (empty($resultat[4]))
			{
				preg_match("/\{" . $tag . " id=(" . $id . ")}/ism", $this->tpl, $resultat);
				return $resultat[1];
			}
			return $resultat[4];
		}
		elseif ($option == "SELECTED")
		{
			//retourne le nom selected si il la trouvé et rien sinon
			@preg_match("/\{" . $tag . " id=" . $id . " selected=(.*?)}/ism", $this->tpl, $resultat);
			return @$resultat[1];
		}
		else
		{
			return 0;
		}
	}

	// Test s'il y a le même nombre d'éléments dans les sous-tableaux array(key => array(), key => array())
	private function veriftableau($tableau)
	{
		reset($tableau);
		$retour = true;
		$numero = count($tableau[key($tableau)]);
		for ($i = 0; $i < count($tableau); $i++)
		{
			if ($numero != count($tableau[key($tableau)]))
			{
				$retour = false;
			}
			next($tableau);
		}
		return $retour;
	}

	// Crée un sélecteur
	private function creerhtmlselect($nom, $tableau, $selected, $attribut = array())
	{
		$attrs = '';
		foreach ($attribut as $cle => $valeur)
		{
			$attrs .= $cle . '="' . $valeur . '" ';
		}
		$tmp = '<Select name="' . $nom . '" ' . $attrs . ' >' . "\n";
		foreach ($tableau as $cle => $valeur)
		{
			if ($cle == $selected)
			{
				$tmp .= '<option value="' . $cle . '" SELECTED >' . $valeur . '</option>' . "\n";
			}
			else
			{
				$tmp .= '<option value="' . $cle . '">' . $valeur . '</option>' . "\n";	
			}	
		}
		$tmp .= '</select>';
		return $tmp;
	}
}
?>