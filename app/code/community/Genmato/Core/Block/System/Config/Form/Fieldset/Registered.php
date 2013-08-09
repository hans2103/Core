<?php

/**
 * @category    Genmato
 * @package     Genmato_Core
 * @copyright   Copyright (c) 2013 Genmato BV (http://www.genmato.net)
 */

class Genmato_Core_Block_System_Config_Form_Fieldset_Registered extends Mage_Adminhtml_Block_System_Config_Form_Fieldset {

	/**
	 * Render fieldset html
	 *
	 * @param Varien_Data_Form_Element_Abstract $element
	 *
	 * @return string
	 */
	public function render(Varien_Data_Form_Element_Abstract $element) {

		$path = explode('_', $element->getId());

		if ($path[0] != "genmato") {
			$module = 'genmato_' . $path[0];
		} else {
			$module = $path[0] . '_' . $path[1];
		}

		$orderId = Mage::getStoreConfig($module . '/registration/order_id');
		$email   = Mage::getStoreConfig($module . '/registration/email');
		$serial  = Mage::getStoreConfig($module . '/registration/serial');

		if (Mage::helper('genmato')->checkSerial($orderId, $email, $serial)) {
			return parent::render($element);
		}
	}

}
