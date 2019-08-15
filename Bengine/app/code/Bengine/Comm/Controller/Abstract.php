<?php
/**
 * Abstract controller.
 *
 * @package Bengine
 * @copyright Copyright protected by / Urheberrechtlich geschützt durch "Sebastian Noll" <snoll@4ym.org>
 * @version $Id: Abstract.php 8 2010-10-17 20:55:04Z secretchampion $
 */

abstract class Bengine_Comm_Controller_Abstract extends Recipe_Controller_Abstract
{
	/**
	 * Called when no action method has been found.
	 *
	 * @return Bengine_Comm_Controller_Abstract
	 */
	protected function norouteAction()
	{
		$this->assign("page", Core::getLang()->get("ERROR_404"));
		return parent::norouteAction();
	}
}
?>