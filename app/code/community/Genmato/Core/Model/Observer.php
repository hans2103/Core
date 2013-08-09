<?php

/**
 * @category    Genmato
 * @package     Genmato_Core
 * @copyright   Copyright (c) 2013 Genmato BV (http://www.genmato.net)
 */

class Genmato_Core_Model_Observer {


	protected $refresh_timeout = 86400;

	/**
	 * Predispath admin action controller
	 *
	 * @param Varien_Event_Observer $observer
	 */
	public function preDispatch(Varien_Event_Observer $observer) {

		if (Mage::getSingleton('admin/session')->isLoggedIn()) {
			if (Mage::app()->loadCache('genmato_core_updated_flag') == 'UPDATED') {
				if ((time() - Mage::app()->loadCache('genmato_core_updated_time')) > $this->refresh_timeout || Mage::getStoreConfig('genmato/registration/code') == "") {
					Mage::helper('genmato_core')->storeInstallation();
					Mage::app()->saveCache(time(), 'genmato_core_updated_time', array(), $this->refresh_timeout * 2);
				}
				Mage::app()->removeCache('genmato_core_updated_flag');
			}
		}
	}
}
