<?php
/**
 * Construction model.
 *
 * @package Bengine
 * @copyright Copyright protected by / Urheberrechtlich geschützt durch "Sebastian Noll" <snoll@4ym.org>
 * @version $Id: Construction.php 8 2010-10-17 20:55:04Z secretchampion $
 */

class Bengine_Game_Model_Construction extends Recipe_Model_Abstract
{
	/**
	 * Initializes the model.
	 *
	 * @return Bengine_Game_Model_Construction
	 */
	protected function init()
	{
		$this->setTableName("construction");
		$this->setModelName("game/construction");
		$this->setPrimaryKey("buildingid");
		return parent::init();
	}

	/**
	 * Returns the construction name as a language phrase.
	 *
	 * @return string
	 */
	public function getName()
	{
		return Core::getLang()->get($this->get("name"));
	}

	/**
	 * Returns the construction description as language phrase.
	 *
	 * @return string
	 */
	public function getDescription()
	{
		return Core::getLang()->get($this->get("name")."_DESC");
	}

	/**
	 * Returns the linked name.
	 *
	 * @return string
	 */
	public function getLinkName()
	{
		return Link::get("game/".SID."/Constructions/Info/".$this->get("buildingid"), $this->getName());
	}

	/**
	 * Returns the Image.
	 *
	 * @return string
	 */
	public function getImage()
	{
		return Link::get("game/".SID."/Constructions/Info/".$this->get("buildingid"), Image::getImage("buildings/".$this->get("name").".gif", $this->getName()));
	}

	/**
	 * Returns the edit Link.
	 *
	 * @return string
	 */
	public function getEditLink()
	{
		return Link::get("game/".SID."/Construction_Edit/Index/".$this->get("buildingid"), "[".Core::getLanguage()->getItem("EDIT")."]");
	}

	/**
	 * Checks if the current planet has enough resources to build this.
	 *
	 * @return bool
	 */
	public function hasResources()
	{
		$required = $this->calculateRequiredResources();
		if($required["required_metal"] > Game::getPlanet()->getData("metal"))
		{
			return false;
		}
		if($required["required_silicon"] > Game::getPlanet()->getData("silicon"))
		{
			return false;
		}
		if($required["required_hydrogen"] > Game::getPlanet()->getData("hydrogen"))
		{
			return false;
		}
		$energy = (Game::getPlanet()->getEnergy() < 0) ? 0 : Game::getPlanet()->getEnergy();
		if($required["required_energy"] > $energy)
		{
			return false;
		}
		return true;
	}

	/**
	 * Returns the required resources.
	 *
	 * @return array
	 */
	public function calculateRequiredResources()
	{
		if(!$this->get("resources_calculated"))
		{
			$nextLevel = $this->get("level");
			if(!$nextLevel)
			{
				$nextLevel = 1;
			}
			else
			{
				$nextLevel++;
			}
			$requiredMetal = (int) $this->get("basic_metal");
			$requiredSilicon = (int) $this->get("basic_silicon");
			$requiredHydrogen = (int) $this->get("basic_hydrogen");
			$requiredEnergy = (int) $this->get("basic_energy");

			if($nextLevel > 1)
			{
				if($requiredMetal)
				{
					$requiredMetal = parseFormula($this->get("charge_metal"), $requiredMetal, $nextLevel);
				}
				if($requiredSilicon)
				{
					$requiredSilicon = parseFormula($this->get("charge_silicon"), $requiredSilicon, $nextLevel);
				}
				if($requiredHydrogen)
				{
					$requiredHydrogen = parseFormula($this->get("charge_hydrogen"), $requiredHydrogen, $nextLevel);
				}
				if($requiredEnergy)
				{
					$requiredEnergy = parseFormula($this->get("charge_energy"), $requiredEnergy, $nextLevel);
				}
			}
			$ret = array(
				"required_metal" => (int) $requiredMetal,
				"required_silicon" => (int) $requiredSilicon,
				"required_hydrogen" => (int) $requiredHydrogen,
				"required_energy" => (int) $requiredEnergy,
				"resources_calculated" => true
			);
			$this->set($ret);
		}
		else
		{
			$ret = array(
				"required_metal" => $this->get("required_metal"),
				"required_silicon" => $this->get("required_silicon"),
				"required_hydrogen" => $this->get("required_hydrogen"),
				"required_energy" => $this->get("required_energy"),
			);
		}
		return $ret;
	}

	/**
	 * Returns production time.
	 *
	 * @param bool $formatted
	 * @return int|string
	 */
	public function getProductionTime($formatted = false)
	{
		if(!$this->exists("production_time"))
		{
			$required = $this->calculateRequiredResources();
			$time = getBuildTime($required["required_metal"], $required["required_silicon"], $this->get("mode"));
			$this->set("production_time", $time);
		}

		$time = $this->get("production_time");
		return ($formatted) ? getTimeTerm($time) : $time;
	}
}
?>