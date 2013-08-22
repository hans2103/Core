<?php

/**
 * @category    Genmato
 * @package     Genmato_Core
 * @copyright   Copyright (c) 2013 Genmato BV (http://www.genmato.net)
 */

class Genmato_Core_Block_System_Config_Form_Field_Status extends Mage_Adminhtml_Block_System_Config_Form_Field {

	protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) {
		$this->setElement($element);

		$module = str_replace('genmato_core_', '', str_replace('_serial', '', $element->getId()));

		if (substr($module, 0, 7) == 'genmato') {

			$orderId = Mage::getStoreConfig('genmato_core/' . $module . '/registration/order_id');
			$email   = Mage::getStoreConfig('genmato_core/' . $module . '/registration/email');
			$serial  = Mage::getStoreConfig('genmato_core/' . $module . '/registration/serial');

			if (!$orderId || !$email || !$serial) {
				return '<span style=\'color:#aa0000;font-weight:bold;\'>' . Mage::helper('genmato_core')->__('Unregistered!') . '</span>' . $this->_getButtonHtml('Register', $module);
			} else {
				if (Mage::helper('genmato_core')->checkSerial($orderId, $email, $serial)) {
					return '<span style=\'color:#00aa00;font-weight:bold;\'>' . Mage::helper('genmato_core')->__('Registered') . '</span>';
				} else {
					return '<span style=\'color:#aa0000;font-weight:bold;\'>' . Mage::helper('genmato_core')->__('Invalid serial!') . '</span>' . $this->_getButtonHtml('Register', $module);
				}
			}
		} else {
			return '<span style=\'color:#aa0000;font-weight:bold;\'>' . Mage::helper('genmato_core')->__('Unregistered') . '</span>';
		}

		return '';
	}

	protected function _getButtonHtml($title, $module) {

		$url = Mage::helper('adminhtml')->getUrl("adminhtml/genmato_register");

		return '<br>' . $this->getLayout()->createBlock('adminhtml/widget_button')->setType('button')->setLabel(Mage::helper('genmato_core')->__($title))->setOnClick("genmato_register('" . $url . "','" . $module . "')")->toHtml();
	}

}
