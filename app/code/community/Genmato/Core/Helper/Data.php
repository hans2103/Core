<?php

/**
 * @category    Genmato
 * @package     Genmato_Core
 * @copyright   Copyright (c) 2013 Genmato BV (http://www.genmato.net)
 */

class Genmato_Core_Helper_Data extends Mage_Core_Helper_Abstract {

	protected $installurl = 'https://genmato.com/genmato/register/installation';
	protected $registerurl = 'https://genmato.com/genmato/register/module';

	public function storeInstallation() {
		try {
			$edition = method_exists('Mage', 'getEdition') ? Mage::getEdition() : 'unknown';

			$modules = (array)Mage::getConfig()->getNode('modules')->children();

			$mod_list = array();
			foreach ($modules as $moduleName => $moduleData) {
				if (strstr($moduleName, 'Genmato_') === false) {
					continue;
				}
				$mod_list[] = array('name' => $moduleName, "version" => (string)$moduleData->version);
			}

			$data                 = array();
			$data['mage_sysid']   = Mage::getModel('core/encryption')->encrypt('Genmato');
			$data['mage_regcode'] = Mage::getStoreConfig('genmato/registration/code');
			$data['mage_version'] = Mage::getVersion();
			$data['mage_edition'] = $edition;
			$data['mage_url']     = Mage::helper('adminhtml')->getUrl('*');
			$data['modules']      = $mod_list;

			$response = (array)json_decode($this->postData($this->installurl, array('data' => (base64_encode(serialize($data))))));

			if (isset($response['registration'])) {
				Mage::getConfig()->saveConfig('genmato/registration/code', $response['registration'])->cleanCache();
			}
		}
		catch (Exception $ex) {
			$this->debug($ex->getMessage());
		}
	}

	public function moduleRegistration($module, $orderId, $email) {

		if (Mage::getStoreConfig('genmato/registration/code') == "") {
			$this->storeInstallation();
		}

		$data                 = array();
		$data['mage_sysid']   = Mage::getModel('core/encryption')->encrypt('Genmato');
		$data['mage_regcode'] = Mage::getStoreConfig('genmato/registration/code');
		$data['module']       = $module;
		$data['orderId']      = $orderId;
		$data['email']        = $email;

		try {
			$response = (array)json_decode($this->postData($this->registerurl, array('data' => (base64_encode(serialize($data))))));

			return $response;
		}
		catch (Exception $ex) {
			$this->debug($ex->getMessage());

			return array('status' => 0, 'error' => $ex->getMessage());
		}

	}

	public function postData($url, $data = array()) {

		$client = new Zend_Http_Client();
		$client->setUri($url);
		$client->setMethod('POST');
		$client->setConfig(array('maxredirects' => 0, 'timeout' => 5));
		foreach ($data as $param => $val) {
			$client->setParameterPost($param, $val);
		}
		$response = $client->request();

		return $response->getBody();

	}

	public function checkSerial($orderId, $email, $serial) {
		$reg_code = Mage::getStoreConfig('genmato/registration/code');
		if (sha1('Genmato' . $reg_code . $orderId . $email) == $serial) {
			return true;
		}

		return false;
	}

	public function debug($msg) {
		if (Mage::getStoreConfigFlag('genmato/debug/active')) {
			Mage::log($msg);
		}
	}

	public function sendJSON($content = array()) {

		$action = Mage::app()->getFrontController()->getAction();

		$action->getResponse()->setHttpResponseCode(200)->setHeader('Pragma', 'public', true)->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true)->setHeader('Content-type', 'application/json', true)->setHeader('Content-Length', strlen(json_encode($content)))->setHeader('Last-Modified', date('r'));

		$action->getResponse()->setBody(json_encode($content));

		return $action;
	}

}