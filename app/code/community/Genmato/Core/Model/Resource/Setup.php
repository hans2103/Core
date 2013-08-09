<?php

/**
 * @category    Genmato
 * @package     Genmato_Core
 * @copyright   Copyright (c) 2013 Genmato BV (http://www.genmato.net)
 */

class Genmato_Core_Model_Resource_Setup extends Mage_Core_Model_Resource_Setup {

	protected $_callAfterApplyAllUpdates = true;

	public function afterApplyAllUpdates() {

		Mage::app()->saveCache('UPDATED', 'genmato_core_updated_flag', array(), 7200);

		return $this;
	}
}