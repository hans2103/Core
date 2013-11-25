<?php

/**
 * @category    Genmato
 * @package     Genmato_Core
 * @copyright   Copyright (c) 2013 Genmato BV (http://www.genmato.net)
 */

class Genmato_Core_Helper_Data extends Mage_Core_Helper_Abstract
{

    protected $_versiondata = false;

    public function debug($msg)
    {
        if (Mage::getStoreConfigFlag('genmato_core/debug/active')) {
            Mage::log($msg);
        }
    }

    public function getLatestExtensionData($name)
    {
        if (!$this->_versiondata) {
            try {
                $xmldata = file_get_contents(Mage::getStoreConfig('genmato_core/extension/url'));
                $this->_versiondata = simplexml_load_string($xmldata);
            } catch (Exception $ex) {
                return false;
            }
        }
        return (array)$this->_versiondata->$name;

    }

    public function sendJSON($content = array())
    {

        $action = Mage::app()->getFrontController()->getAction();

        $action->getResponse()->setHttpResponseCode(200)->setHeader('Pragma', 'public', true)->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true)->setHeader('Content-type', 'application/json', true)->setHeader('Content-Length', strlen(json_encode($content)))->setHeader('Last-Modified', date('r'));

        $action->getResponse()->setBody(json_encode($content));

        return $action;
    }

    public function sendXML($content = array())
    {

        $action = Mage::app()->getFrontController()->getAction();

        $action->getResponse()->setHttpResponseCode(200)->setHeader('Pragma', 'public', true)->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true)->setHeader('Content-type', 'application/xml', true)->setHeader('Content-Length', strlen(json_encode($content)))->setHeader('Last-Modified', date('r'));

        $action->getResponse()->setBody($content);

        return $action;
    }

}