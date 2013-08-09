<?php

/**
 * @category    Genmato
 * @package     Genmato_Core
 * @copyright   Copyright (c) 2013 Genmato BV (http://www.genmato.net)
 */

class Genmato_Core_Genmato_RegisterController extends Mage_Adminhtml_Controller_Action {

	public function indexAction() {
		$module = $this->getRequest()->getParam('module', false);
		if ($module) {
			$orderId = Mage::getStoreConfig($module . '/registration/order_id');
			$email   = Mage::getStoreConfig($module . '/registration/email');

			$class = str_replace('_Helper_Data', '', Mage::getConfig()->getHelperClassName($module));

			$response = Mage::helper('genmato_core')->moduleRegistration($class, $orderId, $email);

			if ($response['status']) {
				Mage::getConfig()->saveConfig($module . '/registration/serial', $response['serial'])->cleanCache();

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('genmato_core')->__('Module registration completed!'));
			} else {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('genmato_core')->__($response['error']));
			}
		}
		$this->_redirectReferer();
	}

}