<?php

/**
 * @category    Genmato
 * @package     Genmato_Core
 * @copyright   Copyright (c) 2013 Genmato BV (http://www.genmato.net)
 */

class Genmato_Core_Block_System_Config_Form_Field_Status extends Mage_Adminhtml_Block_System_Config_Form_Field {

	protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) {
		$this->setElement($element);

		$path = explode('_', $element->getId());
		if ($path[0] == "genmato") {
			$module = $path[0] . '_' . $path[1];
			$node   = $path[2];

			$orderId = Mage::getStoreConfig($module . '/registration/order_id');
			$email   = Mage::getStoreConfig($module . '/registration/email');
			$serial  = Mage::getStoreConfig($module . '/registration/serial');

			if (!$orderId || !$email || !$serial) {
				return '<span style=\'color:#aa0000;font-weight:bold;\'>' . Mage::helper('genmato')->__('Unregistered!') . '</span>' . $this->_getAddRowButtonHtml('Register', $module);
			} else {
				if (Mage::helper('genmato')->checkSerial($orderId, $email, $serial)) {
					return '<span style=\'color:#00aa00;font-weight:bold;\'>' . Mage::helper('genmato')->__('Registered') . '</span>';
				} else {
					return '<span style=\'color:#aa0000;font-weight:bold;\'>' . Mage::helper('genmato')->__('Invalid serial!') . '</span>' . $this->_getAddRowButtonHtml('Register', $module);
				}
			}
		} else {
			return '<span style=\'color:#aa0000;font-weight:bold;\'>' . Mage::helper('genmato')->__('Unknown') . '</span>' . $this->_getAddRowButtonHtml('Register', false);
		}

		return '';
	}

	protected function _getAddRowButtonHtml($title, $module) {

		$url = Mage::helper('adminhtml')->getUrl("adminhtml/genmato_register", array('module' => $module));

		return '<br>' . $this->getLayout()->createBlock('adminhtml/widget_button')->setType('button')->setLabel(Mage::helper('genmato')->__($title))->setOnClick("window.location.href='" . $url . "'")->toHtml();
	}

}
