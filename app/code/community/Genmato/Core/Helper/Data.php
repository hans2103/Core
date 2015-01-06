<?php

/**
 * @category    Genmato
 * @package     Genmato_Core
 * @copyright   Copyright (c) 2013 Genmato BV (http://www.genmato.net)
 */
class Genmato_Core_Helper_Data extends Mage_Adminhtml_Helper_Data
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

        $action->getResponse()->setHttpResponseCode(200)->setHeader('Pragma', 'public', true)->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true)->setHeader('Content-type', 'application/json', true)->setHeader('Last-Modified', date('r'));

        $action->getResponse()->setBody(json_encode($content));

        return $action;
    }

    public function sendXML($content = array())
    {

        $action = Mage::app()->getFrontController()->getAction();

        $action->getResponse()->setHttpResponseCode(200)->setHeader('Pragma', 'public', true)->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true)->setHeader('Content-type', 'application/xml', true)->setHeader('Last-Modified', date('r'));

        $action->getResponse()->setBody($content);

        return $action;
    }

    public function registerExtensions(){
        try{
            $edition = method_exists('Mage','getEdition') ? Mage::getEdition():false;

            if(!$edition) {
                // No function getEdition found, this function is available since CE1.7
                if (version_compare(Mage::getVersion(),'1.7','>=')) {
                    $edition = 'enterprise';
                } else {
                    $edition = 'community';
                }
            }

            $data = array();
            $data['installation_id']	= Mage::getModel('core/encryption')->encrypt('Genmato');
            $data['version']	        = Mage::getVersion();
            $data['edition']        	= $edition;
            $data['domain']     		= $this->getUrl('/',array('_secure'=>1));
            $data['extensions']         = array();

            $modules 				= (array)Mage::getConfig()->getNode('modules')->children();
            foreach ($modules as $name=>$module) {
                if (substr($name,0,7)=='Genmato') {
                    $data['extensions'][$name] = (string)$module->version;
                }
            }
            $url = Mage::getStoreConfig('genmato_core/extension/data');
            $push = (base64_encode(serialize($data)));
            $this->postData($url,array('data'=>$push));
        }catch(Exception $ex){
            Mage::log($ex->getMessage());
        }
    }

    public function postData($url,$data=array()){
        $client = new Zend_Http_Client();
        $client->setUri($url);
        $client->setMethod('POST');
        $client->setConfig(array(
                'maxredirects' => 0,
                'timeout'      => 2)
        );
        foreach($data as $param=>$val){
            $client->setParameterPost($param, $val);
        }
        $response = $client->request();

        return $response->getBody();
    }

}