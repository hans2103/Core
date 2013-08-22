<?php

/**
 * @category    Genmato
 * @package     Genmato_Core
 * @copyright   Copyright (c) 2013 Genmato BV (http://www.genmato.net)
 */

class Genmato_Core_Model_System_Config_Backend_Registration extends Mage_Core_Model_Config_Data {

	protected function _beforeSave() {
		if (!$this->getOldValue()) {
			$path   = explode('/', $this->getPath());
			$data   = $this->getFieldsetData();
			$module = str_replace('_Helper_Data', '', Mage::getConfig()->getHelperClassName($path[0]));

			$response = Mage::helper('genmato_core')->moduleRegistration($module, $data['order_id'], $data['email']);
			if ($response['status']) {
				$this->setValue($response['serial']);
			} else {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('genmato_core')->__($response['error']));
			}
		}

		return $this;
	}

}
